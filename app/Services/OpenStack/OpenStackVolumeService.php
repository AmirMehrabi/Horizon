<?php

namespace App\Services\OpenStack;

use Illuminate\Support\Facades\Log;
use OpenStack\Compute\v2\Service as ComputeService;

class OpenStackVolumeService
{
    protected OpenStackConnectionService $connection;

    public function __construct(OpenStackConnectionService $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a snapshot of an instance (using Nova image snapshot).
     *
     * @param string $serverId OpenStack server ID
     * @param string $name Snapshot name
     * @param string|null $description Snapshot description
     * @return array Snapshot information
     * @throws \Exception
     */
    public function createInstanceSnapshot(string $serverId, string $name, ?string $description = null): array
    {
        try {
            $compute = $this->connection->getComputeService();
            
            // Get server and verify it exists
            try {
                $server = $compute->getServer(['id' => $serverId]);
            } catch (\Exception $e) {
                throw new \Exception("Server not found: {$serverId} - " . $e->getMessage());
            }
            
            if (!$server || !isset($server->id)) {
                throw new \Exception("Server not found or invalid: {$serverId}");
            }

            // Verify server status (should be ACTIVE or STOPPED for snapshots)
            $serverStatus = $server->status ?? null;
            if (!in_array(strtoupper($serverStatus ?? ''), ['ACTIVE', 'STOPPED', 'SHUTOFF'])) {
                Log::warning('Server may not be in optimal state for snapshot', [
                    'server_id' => $serverId,
                    'status' => $serverStatus,
                ]);
            }

            // Prepare image data - OpenStack Nova API expects specific format
            $imageData = [
                'name' => $name,
            ];

            // Add metadata if description provided
            if ($description) {
                $imageData['metadata'] = [
                    'description' => $description,
                    'snapshot_type' => 'instance',
                    'source_server_id' => $serverId,
                ];
            }

            Log::info('Creating snapshot', [
                'server_id' => $serverId,
                'name' => $name,
                'server_status' => $serverStatus,
            ]);

            // Create image snapshot from server
            // Note: createImage may return null, a string ID, or an Image object depending on OpenStack version
            try {
                $imageResult = $server->createImage($imageData);
            } catch (\Exception $e) {
                Log::warning('createImage threw exception, may still have succeeded', [
                    'error' => $e->getMessage(),
                ]);
                $imageResult = null;
            }

            $imageId = null;
            $imageName = $name;
            $imageStatus = 'queued';
            $imageSize = null;

            // Handle different return types from createImage
            if ($imageResult === null) {
                // Some OpenStack versions return null but the image ID is in response headers
                // We need to wait a bit and then search for the image by name
                Log::info('createImage returned null, searching for image by name', [
                    'name' => $name,
                ]);
                
                // Wait a moment for the image to be created (retry up to 5 times)
                $imageService = $this->connection->getImageService();
                $found = false;
                $maxRetries = 5;
                $retryCount = 0;
                
                while (!$found && $retryCount < $maxRetries) {
                    sleep(2);
                    $retryCount++;
                    
                    try {
                        // Try to find the image by name (most recent first)
                        $images = iterator_to_array($imageService->listImages(['name' => $name]));
                        
                        if (count($images) > 0) {
                            // Get the most recent one (should be the one we just created)
                            usort($images, function($a, $b) {
                                $timeA = $a->createdAt ?? 0;
                                $timeB = $b->createdAt ?? 0;
                                return $timeB <=> $timeA; // Descending order
                            });
                            
                            $image = $images[0];
                            $imageId = $image->id;
                            $imageName = $image->name ?? $name;
                            $imageStatus = $image->status ?? 'queued';
                            $imageSize = $image->size ?? null;
                            $found = true;
                            
                            Log::info('Found image after retry', [
                                'image_id' => $imageId,
                                'retry_count' => $retryCount,
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::debug('Error searching for image', [
                            'retry_count' => $retryCount,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
                
                if (!$found) {
                    throw new \Exception("Image creation initiated but image not found after {$maxRetries} retries. The snapshot may still be processing in the background.");
                }
            } elseif (is_string($imageResult)) {
                // If createImage returns just the ID string
                $imageId = $imageResult;
                
                // Try to fetch the image details
                try {
                    $imageService = $this->connection->getImageService();
                    $image = $imageService->getImage(['id' => $imageId]);
                    $imageName = $image->name ?? $name;
                    $imageStatus = $image->status ?? 'queued';
                    $imageSize = $image->size ?? null;
                } catch (\Exception $e) {
                    // Image might not be immediately available
                    Log::info('Image not immediately available, using ID only', [
                        'image_id' => $imageId,
                        'error' => $e->getMessage(),
                    ]);
                }
            } elseif (is_object($imageResult)) {
                // If createImage returns an Image object
                if (isset($imageResult->id)) {
                    $imageId = $imageResult->id;
                    $imageName = $imageResult->name ?? $name;
                    $imageStatus = $imageResult->status ?? 'queued';
                    $imageSize = $imageResult->size ?? null;
                } else {
                    throw new \Exception("Image object returned but missing ID property");
                }
            } else {
                throw new \Exception("Unexpected return type from createImage: " . gettype($imageResult));
            }

            if (!$imageId) {
                throw new \Exception("Failed to determine image ID from createImage response");
            }

            Log::info('Instance snapshot created', [
                'server_id' => $serverId,
                'image_id' => $imageId,
                'name' => $imageName,
                'status' => $imageStatus,
            ]);

            return [
                'id' => $imageId,
                'name' => $imageName,
                'status' => $imageStatus,
                'size' => $imageSize,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create instance snapshot', [
                'server_id' => $serverId,
                'name' => $name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Failed to create snapshot: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get snapshot/image details.
     *
     * @param string $imageId OpenStack image/snapshot ID
     * @return array
     * @throws \Exception
     */
    public function getSnapshot(string $imageId): array
    {
        try {
            $imageService = $this->connection->getImageService();
            $image = $imageService->getImage(['id' => $imageId]);

            return [
                'id' => $image->id,
                'name' => $image->name,
                'status' => $image->status ?? 'unknown',
                'size' => $image->size ?? null,
                'created_at' => $image->createdAt ?? null,
                'updated_at' => $image->updatedAt ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get snapshot', [
                'image_id' => $imageId,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to get snapshot: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete a snapshot/image.
     *
     * @param string $imageId OpenStack image/snapshot ID
     * @return bool
     * @throws \Exception
     */
    public function deleteSnapshot(string $imageId): bool
    {
        try {
            $imageService = $this->connection->getImageService();
            $image = $imageService->getImage(['id' => $imageId]);
            $image->delete();

            Log::info('Snapshot deleted', [
                'image_id' => $imageId,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete snapshot', [
                'image_id' => $imageId,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to delete snapshot: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * List snapshots for a server.
     *
     * @param string|null $serverId Optional server ID to filter by
     * @return array
     * @throws \Exception
     */
    public function listSnapshots(?string $serverId = null): array
    {
        try {
            $imageService = $this->connection->getImageService();
            $options = [
                'visibility' => 'private',
            ];

            if ($serverId) {
                $options['owner'] = config('openstack.project_id');
            }

            $images = iterator_to_array($imageService->listImages($options));
            
            $snapshots = [];
            foreach ($images as $image) {
                // Filter for snapshots (images with metadata indicating they're snapshots)
                $metadata = $image->metadata ?? [];
                if (isset($metadata['snapshot_type']) || str_contains($image->name ?? '', 'snapshot')) {
                    $snapshots[] = [
                        'id' => $image->id,
                        'name' => $image->name,
                        'status' => $image->status ?? 'unknown',
                        'size' => $image->size ?? null,
                        'created_at' => $image->createdAt ?? null,
                        'source_server_id' => $metadata['source_server_id'] ?? null,
                    ];
                }
            }

            return $snapshots;
        } catch (\Exception $e) {
            Log::error('Failed to list snapshots', [
                'server_id' => $serverId,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to list snapshots: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Restore instance from snapshot (create new instance from image).
     *
     * @param string $imageId Snapshot image ID
     * @param string $newServerName Name for the new server
     * @param array $serverConfig Server configuration (flavor, networks, etc.)
     * @return array New server information
     * @throws \Exception
     */
    public function restoreFromSnapshot(string $imageId, string $newServerName, array $serverConfig): array
    {
        try {
            $compute = $this->connection->getComputeService();
            
            $serverParams = [
                'name' => $newServerName,
                'imageId' => $imageId,
                'flavorId' => $serverConfig['flavor_id'],
            ];

            if (isset($serverConfig['networks'])) {
                $serverParams['networks'] = $serverConfig['networks'];
            }

            if (isset($serverConfig['keyName'])) {
                $serverParams['keyName'] = $serverConfig['keyName'];
            }

            $server = $compute->createServer($serverParams);

            Log::info('Instance restored from snapshot', [
                'image_id' => $imageId,
                'new_server_id' => $server->id,
                'name' => $newServerName,
            ]);

            return [
                'id' => $server->id,
                'name' => $server->name,
                'status' => $server->status ?? 'building',
            ];
        } catch (\Exception $e) {
            Log::error('Failed to restore from snapshot', [
                'image_id' => $imageId,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to restore from snapshot: ' . $e->getMessage(), 0, $e);
        }
    }
}

