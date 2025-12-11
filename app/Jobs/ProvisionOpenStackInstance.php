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

        $params = [
            'name' => $this->instance->name,
            'flavorId' => $this->instance->flavor->openstack_id,
            'imageId' => $this->instance->image->openstack_id,
        ];

        // Add networks
        if ($this->instance->networks->isNotEmpty()) {
            $networks = [];
            foreach ($this->instance->networks as $network) {
                $networks[] = ['uuid' => $network->openstack_id];
            }
            $params['networks'] = $networks;
        }

        // Add security groups
        if ($this->instance->securityGroups->isNotEmpty()) {
            $securityGroups = $this->instance->securityGroups
                ->pluck('openstack_id')
                ->filter()
                ->toArray();
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
