<?php

namespace App\Jobs;

use App\Models\OpenStackInstance;
use App\Services\OpenStack\OpenStackConnectionService;
use App\Services\OpenStack\OpenStackInstanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProvisionOpenStackInstance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30; // seconds between retries

    /**
     * Create a new job instance.
     */
    public function __construct(
        public OpenStackInstance $instance
    ) {
        // Set queue name for better organization
        $this->onQueue('openstack-provisioning');
    }

    /**
     * Execute the job.
     */
    public function handle(
        OpenStackConnectionService $connectionService,
        OpenStackInstanceService $instanceService
    ): void {
        try {
            // Refresh instance to get latest data
            $this->instance->refresh();

            // Check if already provisioned
            if ($this->instance->openstack_server_id) {
                Log::info('Instance already provisioned', [
                    'instance_id' => $this->instance->id,
                    'openstack_server_id' => $this->instance->openstack_server_id,
                ]);
                return;
            }

            // Update status to building
            $instanceService->updateStatus($this->instance, 'building');

            // Get compute service
            $compute = $connectionService->getComputeService();

            // Prepare server creation parameters
            $serverParams = $this->prepareServerParams();

            // Log parameters for debugging (excluding sensitive data)
            Log::info('Preparing to create server in OpenStack', [
                'instance_id' => $this->instance->id,
                'name' => $serverParams['name'] ?? null,
                'flavorId' => $serverParams['flavorId'] ?? null,
                'imageId' => $serverParams['imageId'] ?? null,
                'networks_count' => isset($serverParams['networks']) ? count($serverParams['networks']) : 0,
                'security_groups_count' => isset($serverParams['securityGroups']) ? count($serverParams['securityGroups']) : 0,
                'has_keyName' => isset($serverParams['keyName']),
                'has_userData' => isset($serverParams['userData']),
            ]);

            // Create server in OpenStack
            $server = $compute->createServer($serverParams);

            // Update instance with OpenStack server ID
            $instanceService->updateWithOpenStackId(
                $this->instance,
                $server->id,
                config('openstack.project_id')
            );

            Log::info('Instance provisioned successfully in OpenStack', [
                'instance_id' => $this->instance->id,
                'openstack_server_id' => $server->id,
                'name' => $this->instance->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to provision instance in OpenStack', [
                'instance_id' => $this->instance->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Update instance status to error
            $instanceService->updateStatus($this->instance, 'error', 'ERROR');

            // Log error event
            $this->instance->events()->create([
                'event_type' => 'error',
                'message' => 'Failed to provision instance in OpenStack: ' . $e->getMessage(),
                'source' => 'openstack',
                'metadata' => ['error' => $e->getMessage()],
                'created_at' => now(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Prepare server creation parameters for OpenStack.
     */
    protected function prepareServerParams(): array
    {
        $this->instance->load(['flavor', 'image', 'keyPair', 'networks', 'securityGroups']);

        // Validate required OpenStack IDs
        if (empty($this->instance->flavor->openstack_id)) {
            throw new \Exception('Flavor missing OpenStack ID. Please sync flavors first.');
        }
        if (empty($this->instance->image->openstack_id)) {
            throw new \Exception('Image missing OpenStack ID. Please sync images first.');
        }

        $params = [
            'name' => $this->instance->name,
            'flavorId' => $this->instance->flavor->openstack_id,
            'imageId' => $this->instance->image->openstack_id,
        ];

        // Add networks - filter out networks without openstack_id
        // OpenStack SDK expects networks as array of objects with 'uuid' key
        if ($this->instance->networks->isNotEmpty()) {
            $networks = [];
            foreach ($this->instance->networks as $network) {
                // Validate openstack_id is not empty and is a valid UUID format
                $openstackId = trim($network->openstack_id ?? '');
                if (!empty($openstackId) && strlen($openstackId) > 0) {
                    $networks[] = ['uuid' => $openstackId];
                } else {
                    Log::warning('Network missing or invalid openstack_id, skipping', [
                        'network_id' => $network->id,
                        'network_name' => $network->name,
                        'openstack_id' => $network->openstack_id,
                        'instance_id' => $this->instance->id,
                    ]);
                }
            }
            if (!empty($networks)) {
                $params['networks'] = $networks;
            } else {
                Log::warning('No valid networks found for instance', [
                    'instance_id' => $this->instance->id,
                    'networks_count' => $this->instance->networks->count(),
                ]);
            }
        }

        // Add security groups - filter out security groups without openstack_id
        // OpenStack SDK expects security groups as array of name strings
        if ($this->instance->securityGroups->isNotEmpty()) {
            $securityGroups = [];
            foreach ($this->instance->securityGroups as $sg) {
                if (!empty($sg->name)) {
                    // OpenStack SDK expects security groups as array of name strings
                    $securityGroups[] = $sg->name;
                } else {
                    Log::warning('Security group missing name, skipping', [
                        'security_group_id' => $sg->id,
                        'instance_id' => $this->instance->id,
                    ]);
                }
            }
            if (!empty($securityGroups)) {
                $params['securityGroups'] = $securityGroups;
            }
        }

        // Add key pair if available
        if ($this->instance->keyPair && $this->instance->keyPair->openstack_id) {
            $params['keyName'] = $this->instance->keyPair->name;
        } elseif ($this->instance->keyPair && $this->instance->keyPair->public_key) {
            // If key pair exists locally but not in OpenStack, we need to create it
            // For now, we'll use the public key directly if the API supports it
            $params['personality'] = [
                [
                    'path' => '/root/.ssh/authorized_keys',
                    'contents' => base64_encode($this->instance->keyPair->public_key),
                ],
            ];
        }

        // Add user data (cloud-init)
        if ($this->instance->user_data) {
            $params['userData'] = base64_encode($this->instance->user_data);
        }

        // Add metadata
        if ($this->instance->metadata) {
            $params['metadata'] = $this->instance->metadata;
        }

        // Add availability zone
        if ($this->instance->availability_zone) {
            $params['availabilityZone'] = $this->instance->availability_zone;
        }

        // Add config drive
        if ($this->instance->config_drive) {
            $params['configDrive'] = true;
        }

        // Handle root password if password authentication is used
        if ($this->instance->root_password_hash && !$this->instance->keyPair) {
            try {
                // Decrypt the password (it was encrypted, not hashed)
                $password = decrypt($this->instance->root_password_hash);
                
                // Generate cloud-init script to set root password
                $passwordScript = $this->generatePasswordScript($password);
                
                // Append to existing user_data or create new
                $existingUserData = $this->instance->user_data ?? '';
                $params['userData'] = base64_encode($existingUserData . "\n" . $passwordScript);
            } catch (\Exception $e) {
                Log::warning('Failed to decrypt password for instance', [
                    'instance_id' => $this->instance->id,
                    'error' => $e->getMessage(),
                ]);
                // Continue without password - user will need to reset it
            }
        }

        return $params;
    }

    /**
     * Generate cloud-init script to set root password.
     */
    protected function generatePasswordScript(string $password): string
    {
        // Escape password for shell safety
        $escapedPassword = escapeshellarg($password);
        
        // Generate cloud-init script to set root password
        // This works for most Linux distributions
        return <<<SCRIPT
#!/bin/bash
# Set root password via cloud-init
echo "root:{$escapedPassword}" | chpasswd

# For Ubuntu/Debian, also ensure password authentication is enabled
if [ -f /etc/ssh/sshd_config ]; then
    sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config
    sed -i 's/PasswordAuthentication no/PasswordAuthentication yes/' /etc/ssh/sshd_config
    systemctl restart sshd 2>/dev/null || service ssh restart 2>/dev/null || true
fi
SCRIPT;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('ProvisionOpenStackInstance job failed permanently', [
            'instance_id' => $this->instance->id,
            'error' => $exception->getMessage(),
        ]);

        // Update instance status
        $this->instance->update(['status' => 'error']);

        // Log error event
        $this->instance->events()->create([
            'event_type' => 'error',
            'message' => 'Instance provisioning failed permanently: ' . $exception->getMessage(),
            'source' => 'system',
            'metadata' => [
                'error' => $exception->getMessage(),
                'attempts' => $this->attempts(),
            ],
            'created_at' => now(),
        ]);
    }
}
