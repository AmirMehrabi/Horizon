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
            // Log the full structure to identify the issue
            $logParams = $serverParams;
            if (isset($logParams['userData'])) {
                $logParams['userData'] = '[REDACTED - base64 encoded]';
            }
            Log::info('Preparing to create server in OpenStack', [
                'instance_id' => $this->instance->id,
                'params_structure' => $logParams,
                'params_keys' => array_keys($serverParams),
                'networks_structure' => $serverParams['networks'] ?? 'not set',
                'security_groups_structure' => $serverParams['securityGroups'] ?? 'not set',
            ]);

            // DEBUG: Log the exact structure being sent
            Log::error('DEBUG - Exact server params being sent', [
                'params' => $serverParams,
                'params_json' => json_encode($serverParams, JSON_PRETTY_PRINT),
                'networks_check' => isset($serverParams['networks']) ? [
                    'is_array' => is_array($serverParams['networks']),
                    'count' => count($serverParams['networks']),
                    'first_item' => $serverParams['networks'][0] ?? null,
                    'first_item_keys' => isset($serverParams['networks'][0]) ? array_keys($serverParams['networks'][0]) : null,
                ] : 'not set',
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

        // Validate relationships exist
        if (!$this->instance->flavor) {
            throw new \Exception('Instance flavor not found. Please ensure flavor is properly associated.');
        }
        if (!$this->instance->image) {
            throw new \Exception('Instance image not found. Please ensure image is properly associated.');
        }

        // Validate required OpenStack IDs
        if (empty($this->instance->flavor->openstack_id)) {
            throw new \Exception('Flavor missing OpenStack ID. Please sync flavors first. Flavor: ' . $this->instance->flavor->name);
        }
        if (empty($this->instance->image->openstack_id)) {
            throw new \Exception('Image missing OpenStack ID. Please sync images first. Image: ' . $this->instance->image->name);
        }

        $params = [
            'name' => $this->instance->name,
            'flavorId' => $this->instance->flavor->openstack_id,
            'imageId' => $this->instance->image->openstack_id,
        ];

        // Add networks - filter out networks without openstack_id
        // OpenStack SDK expects networks as array of objects with 'uuid' key
        $networks = [];
        if ($this->instance->networks->isNotEmpty()) {
            Log::info('Processing networks for instance', [
                'instance_id' => $this->instance->id,
                'networks_count' => $this->instance->networks->count(),
            ]);
            
            foreach ($this->instance->networks as $index => $network) {
                Log::info('Processing network', [
                    'index' => $index,
                    'network_id' => $network->id,
                    'network_name' => $network->name,
                    'openstack_id' => $network->openstack_id,
                    'openstack_id_type' => gettype($network->openstack_id),
                ]);
                
                // Validate openstack_id is not empty and is a valid UUID format
                $openstackId = $network->openstack_id ?? null;
                if (!empty($openstackId) && is_string($openstackId)) {
                    $openstackId = trim($openstackId);
                    // Ensure it looks like a UUID (basic validation)
                    if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $openstackId)) {
                        // Create a fresh array to avoid any key issues
                        $networkEntry = [];
                        $networkEntry['uuid'] = (string)$openstackId;
                        $networks[] = $networkEntry;
                        
                        Log::info('Added network to params', [
                            'network_entry' => $networkEntry,
                            'networks_array_so_far' => $networks,
                        ]);
                    } else {
                        Log::warning('Network openstack_id is not a valid UUID format', [
                            'network_id' => $network->id,
                            'network_name' => $network->name,
                            'openstack_id' => $openstackId,
                            'instance_id' => $this->instance->id,
                        ]);
                    }
                } else {
                    Log::warning('Network missing or invalid openstack_id, skipping', [
                        'network_id' => $network->id,
                        'network_name' => $network->name,
                        'openstack_id' => $network->openstack_id,
                        'openstack_id_type' => gettype($network->openstack_id),
                        'instance_id' => $this->instance->id,
                    ]);
                }
            }
        }
        
        // Only add networks parameter if we have valid networks
        // If no networks, OpenStack will use default network
        if (!empty($networks)) {
            // Re-index array to ensure clean numeric keys
            $params['networks'] = array_values($networks);
            Log::info('Final networks array for params', [
                'networks' => $params['networks'],
                'networks_json' => json_encode($params['networks']),
            ]);
        } else {
            Log::info('No valid networks specified, OpenStack will use default network', [
                'instance_id' => $this->instance->id,
            ]);
        }

        // Add security groups - filter out security groups without name
        // OpenStack SDK expects security groups as array of objects with 'name' property
        $securityGroups = [];
        if ($this->instance->securityGroups->isNotEmpty()) {
            foreach ($this->instance->securityGroups as $sg) {
                $sgName = $sg->name ?? null;
                if (!empty($sgName) && is_string($sgName)) {
                    $sgName = trim($sgName);
                    if ($sgName !== '') {
                        // Create a fresh array to avoid any key issues
                        $sgEntry = [];
                        $sgEntry['name'] = (string)$sgName;
                        $securityGroups[] = $sgEntry;
                    }
                } else {
                    Log::warning('Security group missing name, skipping', [
                        'security_group_id' => $sg->id,
                        'security_group_name' => $sg->name,
                        'instance_id' => $this->instance->id,
                    ]);
                }
            }
        }
        
        // Only add security groups parameter if we have valid security groups
        if (!empty($securityGroups)) {
            // Re-index array to ensure clean numeric keys
            $params['securityGroups'] = array_values($securityGroups);
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

        // Add metadata - ensure it's a proper array without empty keys
        if ($this->instance->metadata && is_array($this->instance->metadata)) {
            $cleanMetadata = [];
            foreach ($this->instance->metadata as $key => $value) {
                if (!empty($key) && trim($key) !== '' && $value !== null) {
                    $cleanMetadata[trim($key)] = $value;
                }
            }
            if (!empty($cleanMetadata)) {
                $params['metadata'] = $cleanMetadata;
            }
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

        // Clean up params: remove any null or empty values that might cause issues
        // Only include parameters that the OpenStack SDK expects
        $allowedParams = [
            'name', 'flavorId', 'imageId', 'networks', 'securityGroups', 
            'keyName', 'userData', 'metadata', 'availabilityZone', 
            'configDrive', 'personality'
        ];
        
        // First, check for any empty keys in the params array itself
        $hasEmptyKeys = false;
        foreach ($params as $key => $value) {
            if ($key === '' || (is_string($key) && trim($key) === '')) {
                $hasEmptyKeys = true;
                Log::error('Found empty key in params array!', [
                    'key' => var_export($key, true),
                    'value' => $value,
                    'all_keys' => array_keys($params),
                    'instance_id' => $this->instance->id,
                ]);
            }
        }
        
        if ($hasEmptyKeys) {
            // Rebuild params array without empty keys
            $params = array_filter($params, function($key) {
                return $key !== '' && (is_string($key) ? trim($key) !== '' : true);
            }, ARRAY_FILTER_USE_KEY);
        }
        
        $cleanParams = [];
        foreach ($params as $key => $value) {
            // Skip empty keys or keys not in allowed list
            if (empty($key) || (is_string($key) && trim($key) === '') || !in_array($key, $allowedParams)) {
                if (!in_array($key, $allowedParams) && $key !== '') {
                    Log::warning('Skipping unrecognized parameter', [
                        'key' => $key,
                        'value' => is_array($value) ? 'array' : $value,
                        'instance_id' => $this->instance->id,
                    ]);
                }
                continue;
            }
            
            // Skip null values and empty strings (except for userData which can be empty)
            if ($value === null || ($value === '' && $key !== 'userData')) {
                continue;
            }
            
            // For arrays, ensure they're not empty and properly structured
            if (is_array($value)) {
                if (empty($value)) {
                    continue;
                }
                
                // Validate array structure for networks and security groups
                if ($key === 'networks') {
                    $validNetworks = [];
                    foreach ($value as $network) {
                        if (is_array($network) && isset($network['uuid']) && !empty($network['uuid'])) {
                            $validNetworks[] = $network;
                        } else {
                            Log::warning('Invalid network structure in params', [
                                'network' => $network,
                                'instance_id' => $this->instance->id,
                            ]);
                        }
                    }
                    if (!empty($validNetworks)) {
                        $cleanParams[$key] = $validNetworks;
                    }
                    continue;
                }
                
                if ($key === 'securityGroups') {
                    $validSecurityGroups = [];
                    foreach ($value as $sg) {
                        if (is_array($sg) && isset($sg['name']) && !empty($sg['name'])) {
                            $validSecurityGroups[] = $sg;
                        } else {
                            Log::warning('Invalid security group structure in params', [
                                'security_group' => $sg,
                                'instance_id' => $this->instance->id,
                            ]);
                        }
                    }
                    if (!empty($validSecurityGroups)) {
                        $cleanParams[$key] = $validSecurityGroups;
                    }
                    continue;
                }
            }
            
            // Final validation: ensure key is not empty and value is valid
            if (!empty($key) && trim($key) !== '' && $value !== null) {
                $cleanParams[trim($key)] = $value;
            }
        }
        
        // Final check: ensure no empty keys exist
        $finalParams = [];
        foreach ($cleanParams as $key => $value) {
            if (!empty($key) && trim($key) !== '') {
                $finalParams[trim($key)] = $value;
            }
        }
        
        return $finalParams;
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
