<?php

namespace App\Services\OpenStack;

use App\Models\OpenStackNetwork;
use App\Models\OpenStackSubnet;
use App\Services\OpenStack\OpenStackSyncService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OpenStackNetworkService
{
    protected OpenStackConnectionService $connection;
    protected OpenStackSyncService $syncService;

    public function __construct(
        OpenStackConnectionService $connection,
        OpenStackSyncService $syncService
    ) {
        $this->connection = $connection;
        $this->syncService = $syncService;
    }

    /**
     * Get all networks with local-first approach.
     * Syncs from OpenStack if data is stale or missing.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function getAllNetworks(array $filters = []): \Illuminate\Support\Collection
    {
        $region = config('openstack.region');
        
        // Check if we need to sync (data older than 5 minutes or empty)
        $needsSync = OpenStackNetwork::where('region', $region)
            ->where(function ($query) {
                $query->whereNull('synced_at')
                    ->orWhere('synced_at', '<', now()->subMinutes(5));
            })
            ->exists();

        if ($needsSync || OpenStackNetwork::where('region', $region)->count() === 0) {
            try {
                $this->syncService->syncNetworks();
            } catch (\Exception $e) {
                Log::warning('Failed to sync networks, using cached data', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $query = OpenStackNetwork::where('region', $region)
            ->where('status', '!=', 'DELETED')
            ->with('subnets');

        // Apply filters
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('openstack_id', 'like', "%{$search}%");
            });
        }

        if (isset($filters['type']) && $filters['type']) {
            if ($filters['type'] === 'public') {
                $query->where('external', true);
            } elseif ($filters['type'] === 'private') {
                $query->where('external', false);
            }
        }

        if (isset($filters['project_id']) && $filters['project_id']) {
            // Note: OpenStack networks have tenant_id, but we're storing it differently
            // This would need to be added to the model if needed
        }

        return $query->with('subnets')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get a single network by ID.
     *
     * @param string $id
     * @return OpenStackNetwork|null
     */
    public function getNetwork(string $id): ?OpenStackNetwork
    {
        $region = config('openstack.region');
        
        $network = OpenStackNetwork::where('openstack_id', $id)
            ->orWhere('id', $id)
            ->where('region', $region)
            ->with(['subnets', 'instances'])
            ->first();

        // If not found locally, try to fetch from OpenStack
        if (!$network) {
            try {
                $this->syncService->syncNetworks();
                $network = OpenStackNetwork::where('openstack_id', $id)
                    ->orWhere('id', $id)
                    ->where('region', $region)
                    ->with(['subnets', 'instances'])
                    ->first();
            } catch (\Exception $e) {
                Log::error('Failed to fetch network from OpenStack', [
                    'network_id' => $id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $network;
    }

    /**
     * Create a new network in OpenStack.
     *
     * @param array $data
     * @return OpenStackNetwork
     * @throws \Exception
     */
    public function createNetwork(array $data): OpenStackNetwork
    {
        $networking = $this->connection->getNetworkingService();
        $region = config('openstack.region');

        try {
            // Prepare network data for OpenStack
            $networkData = [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'adminStateUp' => $data['admin_state_up'] ?? true,
                'shared' => $data['shared'] ?? false,
                'router:external' => $data['external'] ?? false,
            ];

            // Create network in OpenStack
            $openstackNetwork = $networking->createNetwork($networkData);

            // Create subnet if CIDR is provided
            $subnet = null;
            if (isset($data['cidr']) && $data['cidr']) {
                $subnetData = [
                    'name' => ($data['name'] ?? 'subnet') . '-subnet',
                    'networkId' => $openstackNetwork->id,
                    'ipVersion' => 4,
                    'cidr' => $data['cidr'],
                    'gatewayIp' => $data['gateway_ip'] ?? null,
                    'enableDhcp' => $data['enable_dhcp'] ?? true,
                ];

                if (isset($data['dns_nameservers']) && is_array($data['dns_nameservers'])) {
                    $subnetData['dnsNameservers'] = $data['dns_nameservers'];
                }

                $subnet = $networking->createSubnet($subnetData);
            }

            // Sync to local database
            $this->syncService->syncNetworks();

            // Fetch the newly created network from local DB
            $network = OpenStackNetwork::where('openstack_id', $openstackNetwork->id)
                ->where('region', $region)
                ->first();

            if (!$network) {
                throw new \Exception('Network created in OpenStack but failed to sync to local database');
            }

            return $network;
        } catch (\Exception $e) {
            Log::error('Failed to create network in OpenStack', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to create network: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Update a network in OpenStack.
     *
     * @param string $id
     * @param array $data
     * @return OpenStackNetwork
     * @throws \Exception
     */
    public function updateNetwork(string $id, array $data): OpenStackNetwork
    {
        $networking = $this->connection->getNetworkingService();
        $region = config('openstack.region');

        // Get the network from local DB first
        $network = $this->getNetwork($id);
        if (!$network) {
            throw new \Exception('Network not found');
        }

        $openstackId = $network->openstack_id;

        try {
            // Get the network from OpenStack
            $openstackNetwork = $networking->getNetwork(['id' => $openstackId]);

            // Prepare update data
            $updateData = [];
            if (isset($data['name'])) {
                $updateData['name'] = $data['name'];
            }
            if (isset($data['description'])) {
                $updateData['description'] = $data['description'];
            }
            if (isset($data['admin_state_up'])) {
                $updateData['adminStateUp'] = $data['admin_state_up'];
            }
            if (isset($data['shared'])) {
                $updateData['shared'] = $data['shared'];
            }
            if (isset($data['external'])) {
                $updateData['router:external'] = $data['external'];
            }

            // Update network in OpenStack
            if (!empty($updateData)) {
                $openstackNetwork->update($updateData);
            }

            // Update subnet if provided
            if (isset($data['cidr']) || isset($data['gateway_ip'])) {
                $subnets = $network->subnets;
                if ($subnets->isNotEmpty()) {
                    $subnet = $subnets->first();
                    $subnetObj = $networking->getSubnet(['id' => $subnet->openstack_id]);
                    
                    $subnetUpdateData = [];
                    if (isset($data['cidr'])) {
                        // Note: CIDR cannot be changed after creation, but we'll handle gateway
                    }
                    if (isset($data['gateway_ip'])) {
                        $subnetUpdateData['gatewayIp'] = $data['gateway_ip'];
                    }
                    if (isset($data['enable_dhcp'])) {
                        $subnetUpdateData['enableDhcp'] = $data['enable_dhcp'];
                    }

                    if (!empty($subnetUpdateData)) {
                        $subnetObj->update($subnetUpdateData);
                    }
                }
            }

            // Sync to local database
            $this->syncService->syncNetworks();

            // Return updated network
            return $this->getNetwork($id);
        } catch (\Exception $e) {
            Log::error('Failed to update network in OpenStack', [
                'network_id' => $id,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to update network: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete a network from OpenStack.
     *
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function deleteNetwork(string $id): bool
    {
        $networking = $this->connection->getNetworkingService();
        $region = config('openstack.region');

        // Get the network from local DB first
        $network = $this->getNetwork($id);
        if (!$network) {
            throw new \Exception('Network not found');
        }

        $openstackId = $network->openstack_id;

        try {
            // Get the network from OpenStack
            $openstackNetwork = $networking->getNetwork(['id' => $openstackId]);

            // Delete all subnets first
            $subnets = $network->subnets;
            foreach ($subnets as $subnet) {
                try {
                    $subnetObj = $networking->getSubnet(['id' => $subnet->openstack_id]);
                    $subnetObj->delete();
                } catch (\Exception $e) {
                    Log::warning('Failed to delete subnet, continuing', [
                        'subnet_id' => $subnet->openstack_id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // Delete network in OpenStack
            $openstackNetwork->delete();

            // Sync to local database to mark as deleted
            $this->syncService->syncNetworks();

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete network in OpenStack', [
                'network_id' => $id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to delete network: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get network statistics.
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $region = config('openstack.region');
        
        $total = OpenStackNetwork::where('region', $region)
            ->where('status', '!=', 'DELETED')
            ->count();

        $public = OpenStackNetwork::where('region', $region)
            ->where('status', '!=', 'DELETED')
            ->where('external', true)
            ->count();

        $private = OpenStackNetwork::where('region', $region)
            ->where('status', '!=', 'DELETED')
            ->where('external', false)
            ->count();

        // Count floating IPs (this would need a separate model/service)
        $floatingIps = 0; // TODO: Implement when floating IPs are added

        return [
            'total' => $total,
            'public' => $public,
            'private' => $private,
            'floating_ips' => $floatingIps,
        ];
    }
}

