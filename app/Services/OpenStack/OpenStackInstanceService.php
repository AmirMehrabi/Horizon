<?php

namespace App\Services\OpenStack;

use App\Models\Customer;
use App\Models\OpenStackInstance;
use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSecurityGroup;
use App\Models\OpenStackKeyPair;
use App\Models\OpenStackInstanceEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OpenStackInstanceService
{
    protected OpenStackConnectionService $connection;

    public function __construct(OpenStackConnectionService $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a new instance locally first (local-first approach).
     *
     * @param Customer $customer
     * @param array $data
     * @return OpenStackInstance
     * @throws \Exception
     */
    public function create(Customer $customer, array $data): OpenStackInstance
    {
        DB::beginTransaction();

        try {
            // Validate and resolve flavor
            $flavor = $this->resolveFlavor($data);
            
            // Validate and resolve image
            $image = $this->resolveImage($data);
            
            // Resolve key pair if SSH key method is used
            $keyPair = $this->resolveKeyPair($customer, $data);
            
            // Calculate costs
            $costs = $this->calculateCosts($flavor, $data['billing_cycle'] ?? 'hourly');
            
            // Prepare instance data
            $instanceData = [
                'customer_id' => $customer->id,
                'name' => $data['name'] ?? $this->generateInstanceName($customer),
                'description' => $data['description'] ?? null,
                'status' => 'pending',
                'flavor_id' => $flavor->id,
                'image_id' => $image->id,
                'key_pair_id' => $keyPair?->id,
                'root_password_hash' => $this->handlePassword($data),
                'user_data' => $data['user_data'] ?? null,
                'config_drive' => $data['config_drive'] ?? false,
                'region' => $data['region'] ?? config('openstack.region'),
                'availability_zone' => $data['availability_zone'] ?? null,
                'metadata' => $this->prepareMetadata($data),
                'auto_billing' => $data['auto_billing'] ?? true,
                'billing_cycle' => $data['billing_cycle'] ?? 'hourly',
                'hourly_cost' => $costs['hourly'],
                'monthly_cost' => $costs['monthly'],
                'billing_started_at' => null, // Will be set when instance becomes active
            ];

            // Create instance in database
            $instance = OpenStackInstance::create($instanceData);

            // Attach networks
            $this->attachNetworks($instance, $data);

            // Attach security groups
            $this->attachSecurityGroups($instance, $data);

            // Log creation event
            $this->logEvent($instance, 'created', 'Instance created locally', 'local');

            DB::commit();

            Log::info('Instance created locally', [
                'instance_id' => $instance->id,
                'customer_id' => $customer->id,
                'name' => $instance->name,
            ]);

            return $instance;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create instance locally', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Resolve flavor from form data.
     */
    protected function resolveFlavor(array $data): OpenStackFlavor
    {
        $region = $data['region'] ?? config('openstack.region');

        // If flavor_id is provided, use it
        if (isset($data['flavor_id'])) {
            $flavor = OpenStackFlavor::where('id', $data['flavor_id'])
                ->where('region', $region)
                ->where('is_disabled', false)
                ->firstOrFail();
            return $flavor;
        }

        // If prebuilt plan is selected, find matching flavor
        if (isset($data['plan']) && $data['plan_type'] === 'prebuilt') {
            $flavor = $this->findFlavorByPlan($data['plan'], $region);
            if ($flavor) {
                return $flavor;
            }
        }

        // If custom plan, find or create matching flavor
        if (isset($data['plan_type']) && $data['plan_type'] === 'custom') {
            $flavor = $this->findOrCreateCustomFlavor($data, $region);
            return $flavor;
        }

        throw new \Exception('Unable to resolve flavor. Please select a plan or flavor.');
    }

    /**
     * Find flavor by prebuilt plan name.
     */
    protected function findFlavorByPlan(string $plan, string $region): ?OpenStackFlavor
    {
        $planSpecs = [
            'starter' => ['vcpus' => 1, 'ram' => 2048, 'disk' => 20],
            'standard' => ['vcpus' => 2, 'ram' => 4096, 'disk' => 40],
            'pro' => ['vcpus' => 4, 'ram' => 8192, 'disk' => 80],
        ];

        if (!isset($planSpecs[$plan])) {
            return null;
        }

        $specs = $planSpecs[$plan];

        return OpenStackFlavor::where('region', $region)
            ->where('vcpus', $specs['vcpus'])
            ->where('ram', $specs['ram'])
            ->where('disk', $specs['disk'])
            ->where('is_disabled', false)
            ->where('is_public', true)
            ->first();
    }

    /**
     * Find or create custom flavor based on specifications.
     */
    protected function findOrCreateCustomFlavor(array $data, string $region): OpenStackFlavor
    {
        $vcpus = (int) ($data['custom_vcpu'] ?? 1);
        $ram = (int) (($data['custom_ram'] ?? 2) * 1024); // Convert GB to MB
        $disk = (int) ($data['custom_storage'] ?? 20);

        // Try to find existing flavor with matching specs
        $flavor = OpenStackFlavor::where('region', $region)
            ->where('vcpus', $vcpus)
            ->where('ram', $ram)
            ->where('disk', $disk)
            ->where('is_disabled', false)
            ->first();

        if ($flavor) {
            return $flavor;
        }

        // If not found, we need to find the closest match from OpenStack
        // For now, throw an exception - in production, you might want to
        // sync flavors first or create a custom flavor in OpenStack
        throw new \Exception('Custom flavor not found. Please sync flavors first or select a prebuilt plan.');
    }

    /**
     * Resolve image from form data.
     */
    protected function resolveImage(array $data): OpenStackImage
    {
        $region = $data['region'] ?? config('openstack.region');

        // If image_id is provided, use it
        if (isset($data['image_id'])) {
            $image = OpenStackImage::where('id', $data['image_id'])
                ->where('region', $region)
                ->where('status', 'active')
                ->firstOrFail();
            return $image;
        }

        // Map OS selection to image
        $osMapping = [
            'ubuntu' => ['name' => 'Ubuntu', 'version' => '22.04'],
            'debian' => ['name' => 'Debian', 'version' => '12'],
            'centos' => ['name' => 'CentOS', 'version' => 'Stream 9'],
            'almalinux' => ['name' => 'AlmaLinux', 'version' => '9'],
            'windows' => ['name' => 'Windows', 'version' => 'Server 2022'],
        ];

        if (!isset($data['os']) || !isset($osMapping[$data['os']])) {
            throw new \Exception('Invalid OS selection or image ID required.');
        }

        $osInfo = $osMapping[$data['os']];

        // Find image by name pattern
        $image = OpenStackImage::where('region', $region)
            ->where('status', 'active')
            ->where(function ($query) use ($osInfo) {
                $query->where('name', 'like', "%{$osInfo['name']}%")
                      ->where('name', 'like', "%{$osInfo['version']}%");
            })
            ->where(function ($query) {
                $query->where('visibility', 'public')
                      ->orWhere('visibility', 'shared');
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$image) {
            throw new \Exception("No image found for {$osInfo['name']} {$osInfo['version']}. Please sync images first or select a specific image.");
        }

        return $image;
    }

    /**
     * Resolve or create key pair.
     */
    protected function resolveKeyPair(Customer $customer, array $data): ?OpenStackKeyPair
    {
        $region = $data['region'] ?? config('openstack.region');

        // If password method is used, no key pair needed
        if (($data['access_method'] ?? 'ssh_key') === 'password') {
            return null;
        }

        // If key_pair_id is provided, use it
        if (isset($data['ssh_key_id']) && $data['ssh_key_id'] !== 'new' && !empty($data['ssh_key_id'])) {
            return OpenStackKeyPair::where('id', $data['ssh_key_id'])
                ->where('customer_id', $customer->id)
                ->where('region', $region)
                ->firstOrFail();
        }

        // If new key pair or public key provided, create it
        if (isset($data['ssh_public_key']) && !empty($data['ssh_public_key'])) {
            $keyName = 'instance-' . Str::random(8) . '-' . now()->format('YmdHis');
            
            return OpenStackKeyPair::create([
                'customer_id' => $customer->id,
                'name' => $keyName,
                'public_key' => $data['ssh_public_key'],
                'region' => $region,
            ]);
        }

        // If no key provided but SSH method selected, throw error
        if (($data['access_method'] ?? 'ssh_key') === 'ssh_key') {
            throw new \Exception('SSH key is required when using SSH key authentication method.');
        }

        return null;
    }

    /**
     * Handle password encryption if password method is used.
     * 
     * Note: We encrypt (not hash) the password so it can be decrypted for OpenStack provisioning.
     * The password is used during instance creation and should be cleared after use.
     */
    protected function handlePassword(array $data): ?string
    {
        if (($data['access_method'] ?? 'ssh_key') === 'password') {
            if (empty($data['root_password'])) {
                throw new \Exception('Root password is required when using password authentication.');
            }

            if ($data['root_password'] !== ($data['root_password_confirmation'] ?? '')) {
                throw new \Exception('Password confirmation does not match.');
            }

            if (strlen($data['root_password']) < 8) {
                throw new \Exception('Password must be at least 8 characters long.');
            }

            // Encrypt password (not hash) so it can be decrypted for OpenStack provisioning
            // In production, consider using Laravel's encrypted attributes or a more secure method
            return encrypt($data['root_password']);
        }

        return null;
    }

    /**
     * Calculate instance costs based on flavor and billing cycle.
     */
    protected function calculateCosts(OpenStackFlavor $flavor, string $billingCycle): array
    {
        $hourly = $flavor->pricing_hourly ?? 0.01; // Default minimum
        $monthly = $flavor->pricing_monthly ?? ($hourly * 730); // Approximate monthly

        // If billing cycle is monthly, use monthly pricing
        if ($billingCycle === 'monthly') {
            $hourly = $monthly / 730; // Convert monthly to hourly for calculations
        }

        return [
            'hourly' => $hourly,
            'monthly' => $monthly,
        ];
    }

    /**
     * Prepare metadata for instance.
     */
    protected function prepareMetadata(array $data): array
    {
        $metadata = [
            'created_by' => 'customer_portal',
            'created_at' => now()->toIso8601String(),
        ];

        if (isset($data['os'])) {
            $metadata['os_type'] = $data['os'];
        }

        if (isset($data['plan'])) {
            $metadata['plan'] = $data['plan'];
        }

        if (isset($data['plan_type'])) {
            $metadata['plan_type'] = $data['plan_type'];
        }

        return $metadata;
    }

    /**
     * Attach networks to instance.
     */
    protected function attachNetworks(OpenStackInstance $instance, array $data): void
    {
        $region = $instance->region;
        $networks = [];

        // If network_ids are explicitly provided, use them
        if (!empty($data['network_ids']) && is_array($data['network_ids'])) {
            foreach ($data['network_ids'] as $index => $networkId) {
                $network = OpenStackNetwork::where('id', $networkId)
                    ->where('region', $region)
                    ->where('status', 'ACTIVE')
                    ->first();

                if ($network) {
                    $networks[] = [
                        'network_id' => $network->id,
                        'is_primary' => $index === 0, // First network is primary
                    ];
                } else {
                    Log::warning('Network not found or not active', [
                        'network_id' => $networkId,
                        'region' => $region,
                        'instance_id' => $instance->id,
                    ]);
                }
            }
        } else {
            // Auto-select networks based on configuration flags
            // If assign_public_ip is true, find external network
            if ($data['assign_public_ip'] ?? true) {
                $externalNetwork = OpenStackNetwork::where('region', $region)
                    ->where('external', true)
                    ->where('status', 'ACTIVE')
                    ->first();

                if ($externalNetwork) {
                    $networks[] = [
                        'network_id' => $externalNetwork->id,
                        'is_primary' => true,
                    ];
                } else {
                    Log::warning('External network not found for public IP assignment', [
                        'region' => $region,
                        'instance_id' => $instance->id,
                    ]);
                }
            }

            // If create_private_network is true, find private network
            // Note: In production, you might want to create a private network per customer/project
            if ($data['create_private_network'] ?? true) {
                $privateNetwork = OpenStackNetwork::where('region', $region)
                    ->where('external', false)
                    ->where('status', 'ACTIVE')
                    ->orderBy('shared', 'desc') // Prefer shared networks
                    ->first();

                if ($privateNetwork) {
                    $networks[] = [
                        'network_id' => $privateNetwork->id,
                        'is_primary' => empty($networks), // Primary if no external network
                    ];
                } else {
                    Log::warning('Private network not found', [
                        'region' => $region,
                        'instance_id' => $instance->id,
                    ]);
                }
            }
        }

        // Ensure at least one network is attached
        if (empty($networks)) {
            // Fallback: try to find any available network
            $fallbackNetwork = OpenStackNetwork::where('region', $region)
                ->where('status', 'ACTIVE')
                ->first();

            if ($fallbackNetwork) {
                $networks[] = [
                    'network_id' => $fallbackNetwork->id,
                    'is_primary' => true,
                ];
                Log::info('Using fallback network for instance', [
                    'instance_id' => $instance->id,
                    'network_id' => $fallbackNetwork->id,
                ]);
            } else {
                throw new \Exception('No networks available in region. Please sync networks first.');
            }
        }

        // Attach networks
        foreach ($networks as $networkData) {
            // Generate UUID for pivot table id
            $pivotId = Str::uuid();
            
            // Use DB::table() to insert with UUID primary key
            // Laravel's attach() doesn't support setting pivot table primary keys
            DB::table('openstack_instance_networks')->insert([
                'id' => $pivotId,
                'instance_id' => $instance->id,
                'network_id' => $networkData['network_id'],
                'is_primary' => $networkData['is_primary'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Attach security groups to instance.
     */
    protected function attachSecurityGroups(OpenStackInstance $instance, array $data): void
    {
        $region = $instance->region;
        $securityGroupIds = $data['security_groups'] ?? [];

        // If no security groups provided, use default
        if (empty($securityGroupIds)) {
            $defaultSecurityGroup = OpenStackSecurityGroup::where('region', $region)
                ->where('name', 'default')
                ->first();

            if ($defaultSecurityGroup) {
                // Generate UUID for pivot table id
                $pivotId = Str::uuid();
                
                DB::table('openstack_instance_security_groups')->insert([
                    'id' => $pivotId,
                    'instance_id' => $instance->id,
                    'security_group_id' => $defaultSecurityGroup->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return;
            }
        }

        foreach ($securityGroupIds as $sgId) {
            // Find security group by ID (UUID)
            $securityGroup = OpenStackSecurityGroup::where('id', $sgId)
                ->where('region', $region)
                ->first();

            if ($securityGroup) {
                // Generate UUID for pivot table id
                $pivotId = Str::uuid();
                
                DB::table('openstack_instance_security_groups')->insert([
                    'id' => $pivotId,
                    'instance_id' => $instance->id,
                    'security_group_id' => $securityGroup->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                Log::warning('Security group not found', [
                    'security_group_id' => $sgId,
                    'region' => $region,
                    'instance_id' => $instance->id,
                ]);
            }
        }
    }

    /**
     * Generate a default instance name.
     */
    protected function generateInstanceName(Customer $customer): string
    {
        $timestamp = now()->format('YmdHis');
        $random = Str::random(4);
        return "server-{$timestamp}-{$random}";
    }

    /**
     * Log an event for the instance.
     */
    protected function logEvent(OpenStackInstance $instance, string $eventType, string $message, string $source = 'local'): void
    {
        OpenStackInstanceEvent::create([
            'instance_id' => $instance->id,
            'event_type' => $eventType,
            'message' => $message,
            'source' => $source,
            'created_at' => now(),
        ]);
    }

    /**
     * Update instance status.
     */
    public function updateStatus(OpenStackInstance $instance, string $status, ?string $openstackStatus = null): void
    {
        $instance->update([
            'status' => $status,
            'last_openstack_status' => $openstackStatus,
            'synced_at' => now(),
        ]);

        $this->logEvent($instance, $status, "Instance status changed to {$status}", 'openstack');
    }

    /**
     * Update instance with OpenStack server ID after provisioning.
     */
    public function updateWithOpenStackId(OpenStackInstance $instance, string $openstackServerId, ?string $projectId = null): void
    {
        $instance->update([
            'openstack_server_id' => $openstackServerId,
            'openstack_project_id' => $projectId,
            'status' => 'building',
            'synced_at' => now(),
        ]);

        $this->logEvent($instance, 'building', "Instance provisioning started in OpenStack (ID: {$openstackServerId})", 'openstack');
    }

    /**
     * Start a server instance.
     */
    public function start(OpenStackInstance $instance): void
    {
        if (empty($instance->openstack_server_id)) {
            throw new \Exception('Instance has not been provisioned in OpenStack yet.');
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            $server->start();

            $this->updateStatus($instance, 'building', 'starting');
            $this->logEvent($instance, 'start_requested', 'Server start requested', 'user');
        } catch (\Exception $e) {
            Log::error('Failed to start server', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to start server: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Stop a server instance.
     */
    public function stop(OpenStackInstance $instance): void
    {
        if (empty($instance->openstack_server_id)) {
            throw new \Exception('Instance has not been provisioned in OpenStack yet.');
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            $server->stop();

            $this->updateStatus($instance, 'building', 'stopping');
            $this->logEvent($instance, 'stop_requested', 'Server stop requested', 'user');
        } catch (\Exception $e) {
            Log::error('Failed to stop server', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to stop server: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Reboot a server instance (soft or hard).
     */
    public function reboot(OpenStackInstance $instance, string $type = 'SOFT'): void
    {
        if (empty($instance->openstack_server_id)) {
            throw new \Exception('Instance has not been provisioned in OpenStack yet.');
        }

        if (!in_array($type, ['SOFT', 'HARD'])) {
            throw new \Exception('Invalid reboot type. Must be SOFT or HARD.');
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            $server->reboot(['type' => $type]);

            $this->updateStatus($instance, 'building', 'rebooting');
            $this->logEvent($instance, 'reboot_requested', "Server reboot requested (type: {$type})", 'user');
        } catch (\Exception $e) {
            Log::error('Failed to reboot server', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to reboot server: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete a server instance.
     */
    public function delete(OpenStackInstance $instance): void
    {
        if (empty($instance->openstack_server_id)) {
            // If not provisioned in OpenStack, just delete locally
            $this->logEvent($instance, 'deleted', 'Instance deleted (not provisioned in OpenStack)', 'user');
            $instance->delete();
            return;
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            $server->delete();

            $this->updateStatus($instance, 'deleting', 'deleting');
            $this->logEvent($instance, 'delete_requested', 'Server deletion requested', 'user');
        } catch (\Exception $e) {
            Log::error('Failed to delete server', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to delete server: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Enable rescue mode for a server instance.
     * 
     * @param OpenStackInstance $instance
     * @param string|null $rescueImageId Optional image ID to use for rescue mode
     */
    public function rescue(OpenStackInstance $instance, ?string $rescueImageId = null): void
    {
        if (empty($instance->openstack_server_id)) {
            throw new \Exception('Instance has not been provisioned in OpenStack yet.');
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            
            $rescueParams = [];
            if ($rescueImageId) {
                $rescueParams['rescueImageRef'] = $rescueImageId;
            }
            
            $server->rescue($rescueParams);

            $this->updateStatus($instance, 'building', 'rescuing');
            $this->logEvent($instance, 'rescue_requested', 'Server rescue mode requested', 'user');
        } catch (\Exception $e) {
            Log::error('Failed to enable rescue mode', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to enable rescue mode: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Disable rescue mode for a server instance.
     */
    public function unrescue(OpenStackInstance $instance): void
    {
        if (empty($instance->openstack_server_id)) {
            throw new \Exception('Instance has not been provisioned in OpenStack yet.');
        }

        try {
            $compute = $this->connection->getComputeService();
            $server = $compute->getServer(['id' => $instance->openstack_server_id]);
            $server->unrescue();

            $this->updateStatus($instance, 'building', 'unrescuing');
            $this->logEvent($instance, 'unrescue_requested', 'Server unrescue requested', 'user');
        } catch (\Exception $e) {
            Log::error('Failed to disable rescue mode', [
                'instance_id' => $instance->id,
                'openstack_server_id' => $instance->openstack_server_id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to disable rescue mode: ' . $e->getMessage(), 0, $e);
        }
    }
}

