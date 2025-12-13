<?php

namespace App\Services\OpenStack;

use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSubnet;
use App\Models\OpenStackSecurityGroup;
use App\Models\OpenStackSyncJob;
use App\Models\OpenStackInstance;
use App\Services\OpenStack\OpenStackInstanceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class OpenStackSyncService
{
    protected OpenStackConnectionService $connection;
    protected int $batchSize = 100; // Process in batches for memory efficiency
    protected int $maxRetries = 3;
    protected int $retryDelay = 5; // seconds

    public function __construct(OpenStackConnectionService $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sync all resources from OpenStack.
     *
     * @param array $resourceTypes Optional array of resource types to sync. If empty, syncs all.
     * @return array
     */
    public function syncAll(array $resourceTypes = []): array
    {
        $results = [];
        $types = $resourceTypes ?: ['flavors', 'images', 'networks', 'security_groups'];

        foreach ($types as $type) {
            try {
                $results[$type] = match ($type) {
                    'flavors' => $this->syncFlavors(),
                    'images' => $this->syncImages(),
                    'networks' => $this->syncNetworks(),
                    'security_groups' => $this->syncSecurityGroups(),
                    'instances' => $this->syncInstances(),
                    default => ['success' => false, 'error' => "Unknown resource type: {$type}"],
                };
            } catch (\Exception $e) {
                Log::error("Failed to sync {$type}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $results[$type] = ['success' => false, 'error' => $e->getMessage()];
            }
        }

        return $results;
    }

    /**
     * Sync flavors from OpenStack to local database.
     *
     * @return array
     */
    public function syncFlavors(): array
    {
        $syncJob = $this->createSyncJob('flavors');

        try {
            $syncJob->update(['status' => 'running', 'started_at' => now()]);

            $compute = $this->connection->getComputeService();
            $region = config('openstack.region');

            // Fetch all flavors from OpenStack
            $openstackFlavors = iterator_to_array($compute->listFlavors(['isPublic' => null]));

            $stats = [
                'created' => 0,
                'updated' => 0,
                'deleted' => 0,
                'errors' => [],
            ];

            DB::beginTransaction();

            try {
                // Process in batches for memory efficiency
                foreach (array_chunk($openstackFlavors, $this->batchSize) as $batch) {
                    foreach ($batch as $flavor) {
                        try {
                            $this->syncFlavor($flavor, $region, $stats);
                        } catch (\Exception $e) {
                            $flavorId = is_object($flavor) ? ($flavor->id ?? 'unknown') : ($flavor['id'] ?? 'unknown');
                            $stats['errors'][] = [
                                'flavor_id' => $flavorId,
                                'error' => $e->getMessage(),
                            ];
                            Log::warning('Failed to sync flavor', [
                                'flavor_id' => $flavorId,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }

                // Mark flavors as deleted if they no longer exist in OpenStack
                $openstackIds = collect($openstackFlavors)->pluck('id')->toArray();
                $deleted = OpenStackFlavor::where('region', $region)
                    ->whereNotIn('openstack_id', $openstackIds)
                    ->whereNotNull('openstack_id')
                    ->update(['is_disabled' => true]);

                $stats['deleted'] = $deleted;

                DB::commit();

                $syncJob->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'records_synced' => count($openstackFlavors),
                    'records_created' => $stats['created'],
                    'records_updated' => $stats['updated'],
                    'records_deleted' => $stats['deleted'],
                    'errors_count' => count($stats['errors']),
                    'errors' => $stats['errors'],
                ]);

                return [
                    'success' => true,
                    'stats' => $stats,
                    'job_id' => $syncJob->id,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            $syncJob->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
                'errors' => [['error' => $e->getMessage()]],
            ]);

            Log::error('Flavor sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'job_id' => $syncJob->id,
            ];
        }
    }

    /**
     * Sync a single flavor.
     */
    protected function syncFlavor($flavor, string $region, array &$stats): void
    {
        // Handle both object and array access patterns
        $flavorId = is_object($flavor) ? ($flavor->id ?? null) : ($flavor['id'] ?? null);
        $flavorName = is_object($flavor) ? ($flavor->name ?? null) : ($flavor['name'] ?? null);
        
        $data = [
            'openstack_id' => $flavorId,
            'name' => $flavorName ?? 'Unnamed',
            'description' => is_object($flavor) ? ($flavor->description ?? null) : ($flavor['description'] ?? null),
            'vcpus' => is_object($flavor) ? ($flavor->vcpus ?? 1) : ($flavor['vcpus'] ?? 1),
            'ram' => is_object($flavor) ? ($flavor->ram ?? 512) : ($flavor['ram'] ?? 512),
            'disk' => is_object($flavor) ? ($flavor->disk ?? 1) : ($flavor['disk'] ?? 1),
            'ephemeral_disk' => is_object($flavor) 
                ? ($flavor->{'OS-FLV-EXT-DATA:ephemeral'} ?? $flavor->ephemeral ?? 0)
                : ($flavor['OS-FLV-EXT-DATA:ephemeral'] ?? $flavor['ephemeral'] ?? 0),
            'swap' => is_object($flavor) ? ($flavor->swap ?? 0) : ($flavor['swap'] ?? 0),
            'is_public' => is_object($flavor)
                ? ($flavor->{'os-flavor-access:is_public'} ?? $flavor->isPublic ?? true)
                : ($flavor['os-flavor-access:is_public'] ?? $flavor['is_public'] ?? true),
            'is_disabled' => is_object($flavor) ? ($flavor->disabled ?? false) : ($flavor['disabled'] ?? false),
            'extra_specs' => is_object($flavor)
                ? ($flavor->{'OS-FLV-WITH-EXT-SPECS:extra_specs'} ?? $flavor->extraSpecs ?? null)
                : ($flavor['OS-FLV-WITH-EXT-SPECS:extra_specs'] ?? $flavor['extra_specs'] ?? null),
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackFlavor::where('openstack_id', $flavorId)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            $stats['updated']++;
        } else {
            OpenStackFlavor::create($data);
            $stats['created']++;
        }
    }

    /**
     * Sync images from OpenStack to local database.
     *
     * @return array
     */
    public function syncImages(): array
    {
        $syncJob = $this->createSyncJob('images');

        try {
            $syncJob->update(['status' => 'running', 'started_at' => now()]);

            $imageService = $this->connection->getImageService();
            $region = config('openstack.region');

            // Fetch all images from OpenStack
            $openstackImages = iterator_to_array($imageService->listImages());

            $stats = [
                'created' => 0,
                'updated' => 0,
                'deleted' => 0,
                'errors' => [],
            ];

            DB::beginTransaction();

            try {
                foreach (array_chunk($openstackImages, $this->batchSize) as $batch) {
                    foreach ($batch as $image) {
                        try {
                            $this->syncImage($image, $region, $stats);
                        } catch (\Exception $e) {
                            $stats['errors'][] = [
                                'image_id' => $image->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ];
                            Log::warning('Failed to sync image', [
                                'image_id' => $image->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }

                // Mark images as deleted if they no longer exist in OpenStack
                $openstackIds = collect($openstackImages)->pluck('id')->toArray();
                $deleted = OpenStackImage::where('region', $region)
                    ->whereNotIn('openstack_id', $openstackIds)
                    ->whereNotNull('openstack_id')
                    ->update(['status' => 'deleted']);

                $stats['deleted'] = $deleted;

                DB::commit();

                $syncJob->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'records_synced' => count($openstackImages),
                    'records_created' => $stats['created'],
                    'records_updated' => $stats['updated'],
                    'records_deleted' => $stats['deleted'],
                    'errors_count' => count($stats['errors']),
                    'errors' => $stats['errors'],
                ]);

                return [
                    'success' => true,
                    'stats' => $stats,
                    'job_id' => $syncJob->id,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            $syncJob->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
                'errors' => [['error' => $e->getMessage()]],
            ]);

            Log::error('Image sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'job_id' => $syncJob->id,
            ];
        }
    }

    /**
     * Sync a single image.
     */
    protected function syncImage($image, string $region, array &$stats): void
    {
        $data = [
            'openstack_id' => $image->id,
            'name' => $image->name ?? 'Unnamed',
            'description' => $image->description ?? null,
            'status' => $image->status ?? 'unknown',
            'visibility' => $image->visibility ?? 'private',
            'disk_format' => $image->diskFormat ?? null,
            'container_format' => $image->containerFormat ?? null,
            'min_disk' => $image->minDisk ?? null,
            'min_ram' => $image->minRam ?? null,
            'size' => $image->size ?? null,
            'checksum' => $image->checksum ?? null,
            'owner_id' => $image->owner ?? null,
            'metadata' => $image->metadata ?? null,
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackImage::where('openstack_id', $image->id)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            $stats['updated']++;
        } else {
            OpenStackImage::create($data);
            $stats['created']++;
        }
    }

    /**
     * Sync networks and subnets from OpenStack to local database.
     *
     * @return array
     */
    public function syncNetworks(): array
    {
        $syncJob = $this->createSyncJob('networks');

        try {
            $syncJob->update(['status' => 'running', 'started_at' => now()]);

            $networking = $this->connection->getNetworkingService();
            $region = config('openstack.region');

            // Fetch all networks from OpenStack
            $openstackNetworks = iterator_to_array($networking->listNetworks());

            $stats = [
                'created' => 0,
                'updated' => 0,
                'deleted' => 0,
                'subnets_created' => 0,
                'subnets_updated' => 0,
                'errors' => [],
            ];

            DB::beginTransaction();

            try {
                foreach (array_chunk($openstackNetworks, $this->batchSize) as $batch) {
                    foreach ($batch as $network) {
                        try {
                            $this->syncNetwork($network, $region, $stats, $networking);
                        } catch (\Exception $e) {
                            $stats['errors'][] = [
                                'network_id' => $network->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ];
                            Log::warning('Failed to sync network', [
                                'network_id' => $network->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }

                // Mark networks as deleted if they no longer exist in OpenStack
                $openstackIds = collect($openstackNetworks)->pluck('id')->toArray();
                $deleted = OpenStackNetwork::where('region', $region)
                    ->whereNotIn('openstack_id', $openstackIds)
                    ->whereNotNull('openstack_id')
                    ->update(['status' => 'DELETED']);

                $stats['deleted'] = $deleted;

                DB::commit();

                $syncJob->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'records_synced' => count($openstackNetworks),
                    'records_created' => $stats['created'],
                    'records_updated' => $stats['updated'],
                    'records_deleted' => $stats['deleted'],
                    'errors_count' => count($stats['errors']),
                    'errors' => $stats['errors'],
                    'metadata' => [
                        'subnets_created' => $stats['subnets_created'],
                        'subnets_updated' => $stats['subnets_updated'],
                    ],
                ]);

                return [
                    'success' => true,
                    'stats' => $stats,
                    'job_id' => $syncJob->id,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            $syncJob->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
                'errors' => [['error' => $e->getMessage()]],
            ]);

            Log::error('Network sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'job_id' => $syncJob->id,
            ];
        }
    }

    /**
     * Sync a single network and its subnets.
     */
    protected function syncNetwork($network, string $region, array &$stats, $networkingService): void
    {
        $data = [
            'openstack_id' => $network->id,
            'name' => $network->name ?? 'Unnamed',
            'description' => $network->description ?? null,
            'status' => $network->status ?? 'UNKNOWN',
            'admin_state_up' => $network->adminStateUp ?? true,
            'shared' => $network->shared ?? false,
            'external' => $network->{'router:external'} ?? false,
            'provider_network_type' => $network->providerNetworkType ?? null,
            'provider_segmentation_id' => $network->providerSegmentationId ?? null,
            'provider_physical_network' => $network->providerPhysicalNetwork ?? null,
            'router_external' => $network->{'router:external'} ?? false,
            'availability_zones' => $network->availabilityZones ?? null,
            'subnets' => $network->subnets ?? [],
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackNetwork::where('openstack_id', $network->id)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            $stats['updated']++;
            $networkModel = $existing;
        } else {
            $networkModel = OpenStackNetwork::create($data);
            $stats['created']++;
        }

        // Sync subnets for this network
        if (!empty($network->subnets)) {
            foreach ($network->subnets as $subnetId) {
                try {
                    $subnet = $networkingService->getSubnet($subnetId);
                    $this->syncSubnet($subnet, $networkModel->id, $region, $stats);
                } catch (\Exception $e) {
                    $stats['errors'][] = [
                        'subnet_id' => $subnetId,
                        'error' => $e->getMessage(),
                    ];
                    Log::warning('Failed to sync subnet', [
                        'subnet_id' => $subnetId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    /**
     * Sync a single subnet.
     */
    protected function syncSubnet($subnet, string $networkId, string $region, array &$stats): void
    {
        // Handle CIDR - some subnets (like IPv6 or special types) may not have CIDR
        $cidr = $subnet->cidr ?? null;
        // For IPv6 subnets without CIDR, we might have subnetpool_id instead
        // If no CIDR and no subnetpool, we'll store null (now allowed)
        
        $data = [
            'openstack_id' => $subnet->id,
            'network_id' => $networkId,
            'name' => $subnet->name ?? 'Unnamed',
            'description' => $subnet->description ?? null,
            'cidr' => $cidr,
            'ip_version' => $subnet->ipVersion ?? 4,
            'gateway_ip' => $subnet->gatewayIp ?? null,
            'enable_dhcp' => $subnet->enableDhcp ?? true,
            'dns_nameservers' => $subnet->dnsNameservers ?? null,
            'allocation_pools' => $subnet->allocationPools ?? null,
            'host_routes' => $subnet->hostRoutes ?? null,
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackSubnet::where('openstack_id', $subnet->id)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            $stats['subnets_updated']++;
        } else {
            OpenStackSubnet::create($data);
            $stats['subnets_created']++;
        }
    }

    /**
     * Sync security groups from OpenStack to local database.
     *
     * @return array
     */
    public function syncSecurityGroups(): array
    {
        $syncJob = $this->createSyncJob('security_groups');

        try {
            $syncJob->update(['status' => 'running', 'started_at' => now()]);

            $networking = $this->connection->getNetworkingService();
            $region = config('openstack.region');

            // Fetch all security groups from OpenStack
            $openstackSecurityGroups = iterator_to_array($networking->listSecurityGroups());

            $stats = [
                'created' => 0,
                'updated' => 0,
                'deleted' => 0,
                'errors' => [],
            ];

            DB::beginTransaction();

            try {
                foreach (array_chunk($openstackSecurityGroups, $this->batchSize) as $batch) {
                    foreach ($batch as $sg) {
                        try {
                            $this->syncSecurityGroup($sg, $region, $stats);
                        } catch (\Exception $e) {
                            $stats['errors'][] = [
                                'security_group_id' => $sg->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ];
                            Log::warning('Failed to sync security group', [
                                'security_group_id' => $sg->id ?? 'unknown',
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }

                // Mark security groups as deleted if they no longer exist in OpenStack
                // Use status update instead of delete to avoid foreign key constraint violations
                $openstackIds = collect($openstackSecurityGroups)->pluck('id')->toArray();
                $deleted = OpenStackSecurityGroup::where('region', $region)
                    ->whereNotIn('openstack_id', $openstackIds)
                    ->whereNotNull('openstack_id')
                    ->where('status', '!=', 'DELETED')
                    ->update(['status' => 'DELETED']);

                $stats['deleted'] = $deleted;

                DB::commit();

                $syncJob->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'records_synced' => count($openstackSecurityGroups),
                    'records_created' => $stats['created'],
                    'records_updated' => $stats['updated'],
                    'records_deleted' => $stats['deleted'],
                    'errors_count' => count($stats['errors']),
                    'errors' => $stats['errors'],
                ]);

                return [
                    'success' => true,
                    'stats' => $stats,
                    'job_id' => $syncJob->id,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            $syncJob->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
                'errors' => [['error' => $e->getMessage()]],
            ]);

            Log::error('Security group sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'job_id' => $syncJob->id,
            ];
        }
    }

    /**
     * Sync a single security group.
     */
    protected function syncSecurityGroup($sg, string $region, array &$stats): void
    {
        $rules = [];
        if (isset($sg->securityGroupRules) && is_array($sg->securityGroupRules)) {
            foreach ($sg->securityGroupRules as $rule) {
                $rules[] = [
                    'id' => $rule->id ?? null,
                    'direction' => $rule->direction ?? null,
                    'protocol' => $rule->protocol ?? null,
                    'port_range_min' => $rule->portRangeMin ?? null,
                    'port_range_max' => $rule->portRangeMax ?? null,
                    'remote_ip_prefix' => $rule->remoteIpPrefix ?? null,
                    'remote_group_id' => $rule->remoteGroupId ?? null,
                    'ethertype' => $rule->ethertype ?? null,
                ];
            }
        }

        $data = [
            'openstack_id' => $sg->id,
            'name' => $sg->name ?? 'Unnamed',
            'description' => $sg->description ?? null,
            'rules' => $rules,
            'status' => 'ACTIVE', // Mark as active when synced from OpenStack
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackSecurityGroup::where('openstack_id', $sg->id)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            $stats['updated']++;
        } else {
            OpenStackSecurityGroup::create($data);
            $stats['created']++;
        }
    }

    /**
     * Sync instance statuses from OpenStack to local database.
     *
     * @return array
     */
    public function syncInstances(): array
    {
        $syncJob = $this->createSyncJob('instances');

        try {
            $syncJob->update(['status' => 'running', 'started_at' => now()]);

            $compute = $this->connection->getComputeService();
            $instanceService = app(OpenStackInstanceService::class);

            // Get all instances that have been provisioned in OpenStack
            $instances = OpenStackInstance::whereNotNull('openstack_server_id')
                ->whereIn('status', ['pending', 'building'])
                ->get();

            $stats = [
                'checked' => 0,
                'updated' => 0,
                'errors' => [],
            ];

            foreach ($instances as $instance) {
                try {
                    $stats['checked']++;
                    
                    // Get server from OpenStack
                    $server = $compute->getServer(['id' => $instance->openstack_server_id]);
                    
                    // Retrieve server details to ensure we have the latest status
                    $server->retrieve();
                    
                    // Get status - try multiple ways to access it
                    $openstackStatus = null;
                    if (isset($server->status)) {
                        $openstackStatus = $server->status;
                    } elseif (method_exists($server, 'getStatus')) {
                        $openstackStatus = $server->getStatus();
                    } elseif (isset($server->{'status'})) {
                        $openstackStatus = $server->{'status'};
                    }
                    
                    if (empty($openstackStatus)) {
                        Log::warning('Could not retrieve server status from OpenStack', [
                            'instance_id' => $instance->id,
                            'openstack_server_id' => $instance->openstack_server_id,
                            'server_class' => get_class($server),
                            'server_properties' => array_keys(get_object_vars($server)),
                        ]);
                        continue;
                    }
                    
                    // Map OpenStack status to our status
                    $openstackStatus = strtolower(trim($openstackStatus));
                    $mappedStatus = $this->mapOpenStackStatus($openstackStatus);
                    
                    Log::info('Syncing instance status', [
                        'instance_id' => $instance->id,
                        'current_status' => $instance->status,
                        'openstack_status' => $openstackStatus,
                        'mapped_status' => $mappedStatus,
                    ]);
                    
                    // Update if status changed
                    if ($instance->status !== $mappedStatus) {
                        $instanceService->updateStatus($instance, $mappedStatus, $openstackStatus);
                        $stats['updated']++;
                        
                        Log::info('Instance status updated from sync', [
                            'instance_id' => $instance->id,
                            'old_status' => $instance->status,
                            'new_status' => $mappedStatus,
                            'openstack_status' => $openstackStatus,
                        ]);
                    } else {
                        // Just update the last_openstack_status and synced_at
                        $instance->update([
                            'last_openstack_status' => $openstackStatus,
                            'synced_at' => now(),
                        ]);
                    }
                } catch (\Exception $e) {
                    $stats['errors'][] = [
                        'instance_id' => $instance->id,
                        'openstack_server_id' => $instance->openstack_server_id,
                        'error' => $e->getMessage(),
                    ];
                    Log::warning('Failed to sync instance status', [
                        'instance_id' => $instance->id,
                        'openstack_server_id' => $instance->openstack_server_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            $syncJob->update([
                'status' => 'completed',
                'completed_at' => now(),
                'records_synced' => $stats['checked'],
                'records_updated' => $stats['updated'],
                'errors_count' => count($stats['errors']),
                'errors' => $stats['errors'],
            ]);

            return [
                'success' => true,
                'stats' => $stats,
                'job_id' => $syncJob->id,
            ];
        } catch (\Exception $e) {
            $syncJob->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
                'errors' => [['error' => $e->getMessage()]],
            ]);

            Log::error('Instance status sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'job_id' => $syncJob->id,
            ];
        }
    }

    /**
     * Map OpenStack server status to our internal status.
     *
     * @param string $openstackStatus
     * @return string
     */
    protected function mapOpenStackStatus(string $openstackStatus): string
    {
        return match (strtolower($openstackStatus)) {
            'active' => 'active',
            'build', 'building' => 'building',
            'deleted', 'soft_deleted' => 'deleted',
            'error', 'error_deleting' => 'error',
            'stopped', 'shutoff' => 'stopped',
            'suspended' => 'stopped',
            'paused' => 'stopped',
            'rescue' => 'building',
            'resize', 'verify_resize', 'confirm_resize' => 'building',
            'revert_resize' => 'building',
            'reboot', 'hard_reboot' => 'building',
            'migrating' => 'building',
            default => 'building', // Default to building for unknown statuses
        };
    }

    /**
     * Create a sync job record.
     */
    protected function createSyncJob(string $resourceType): OpenStackSyncJob
    {
        return OpenStackSyncJob::create([
            'resource_type' => $resourceType,
            'status' => 'pending',
        ]);
    }
}

