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
            $server = $compute->getServer(['id' => $serverId]);

            // Create image snapshot from server
            $imageData = [
                'name' => $name,
            ];

            if ($description) {
                $imageData['metadata'] = [
                    'description' => $description,
                    'snapshot_type' => 'instance',
                    'source_server_id' => $serverId,
                ];
            }

            $image = $server->createImage($imageData);

            Log::info('Instance snapshot created', [
                'server_id' => $serverId,
                'image_id' => $image->id,
                'name' => $name,
            ]);

            return [
                'id' => $image->id,
                'name' => $image->name,
                'status' => $image->status ?? 'queued',
                'size' => $image->size ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create instance snapshot', [
                'server_id' => $serverId,
                'name' => $name,
                'error' => $e->getMessage(),
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

