<?php

namespace App\Services\OpenStack;

use App\Models\OpenStackImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OpenStack\Images\v2\Models\Image;

class OpenStackImageService
{
    protected OpenStackConnectionService $connection;

    public function __construct(OpenStackConnectionService $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Upload an image from a file.
     *
     * @param array $data
     * @param UploadedFile|null $file
     * @return OpenStackImage
     * @throws \Exception
     */
    public function uploadFromFile(array $data, ?UploadedFile $file): OpenStackImage
    {
        DB::beginTransaction();

        try {
            $imageService = $this->connection->getImageService();
            $region = config('openstack.region', 'RegionOne');

            // Create image in OpenStack
            $imageData = [
                'name' => $data['name'],
                'diskFormat' => $data['disk_format'],
                'containerFormat' => $data['container_format'] ?? 'bare',
                'visibility' => $data['visibility'] ?? 'private',
            ];

            if (!empty($data['description'])) {
                $imageData['description'] = $data['description'];
            }

            if (!empty($data['min_disk'])) {
                $imageData['minDisk'] = (int) $data['min_disk'];
            }

            if (!empty($data['min_ram'])) {
                $imageData['minRam'] = (int) $data['min_ram'] * 1024; // Convert GB to MB
            }

            // Add metadata if provided
            if (!empty($data['metadata'])) {
                $imageData['metadata'] = $data['metadata'];
            }

            $openstackImage = $imageService->createImage($imageData);

            // Upload the file data
            if ($file) {
                $fileStream = fopen($file->getRealPath(), 'r');
                $openstackImage->uploadData($fileStream);
                fclose($fileStream);
            }

            // Wait for image to become active (with timeout)
            $maxWaitTime = 300; // 5 minutes
            $waitInterval = 5; // 5 seconds
            $elapsed = 0;

            while ($elapsed < $maxWaitTime) {
                $openstackImage->retrieve();
                
                if ($openstackImage->status === 'active') {
                    break;
                } elseif (in_array($openstackImage->status, ['killed', 'deleted'])) {
                    throw new \Exception('Image upload failed: ' . $openstackImage->status);
                }

                sleep($waitInterval);
                $elapsed += $waitInterval;
            }

            if ($openstackImage->status !== 'active') {
                throw new \Exception('Image upload timed out. Status: ' . $openstackImage->status);
            }

            // Sync to local database
            $localImage = $this->syncImageToDatabase($openstackImage, $region);

            DB::commit();

            return $localImage;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to upload image from file', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Upload an image from a URL.
     *
     * @param array $data
     * @param string $url
     * @return OpenStackImage
     * @throws \Exception
     */
    public function uploadFromUrl(array $data, string $url): OpenStackImage
    {
        DB::beginTransaction();

        try {
            $imageService = $this->connection->getImageService();
            $region = config('openstack.region', 'RegionOne');

            // Validate and download the file from URL
            $tempFile = $this->downloadImageFromUrl($url);

            try {
                // Create image in OpenStack
                $imageData = [
                    'name' => $data['name'],
                    'diskFormat' => $data['disk_format'],
                    'containerFormat' => $data['container_format'] ?? 'bare',
                    'visibility' => $data['visibility'] ?? 'private',
                ];

                if (!empty($data['description'])) {
                    $imageData['description'] = $data['description'];
                }

                if (!empty($data['min_disk'])) {
                    $imageData['minDisk'] = (int) $data['min_disk'];
                }

                if (!empty($data['min_ram'])) {
                    $imageData['minRam'] = (int) $data['min_ram'] * 1024; // Convert GB to MB
                }

                if (!empty($data['metadata'])) {
                    $imageData['metadata'] = $data['metadata'];
                }

                $openstackImage = $imageService->createImage($imageData);

                // Upload the file data
                $fileStream = fopen($tempFile, 'r');
                $openstackImage->uploadData($fileStream);
                fclose($fileStream);

                // Wait for image to become active
                $maxWaitTime = 600; // 10 minutes for URL uploads
                $waitInterval = 10; // 10 seconds
                $elapsed = 0;

                while ($elapsed < $maxWaitTime) {
                    $openstackImage->retrieve();
                    
                    if ($openstackImage->status === 'active') {
                        break;
                    } elseif (in_array($openstackImage->status, ['killed', 'deleted'])) {
                        throw new \Exception('Image upload failed: ' . $openstackImage->status);
                    }

                    sleep($waitInterval);
                    $elapsed += $waitInterval;
                }

                if ($openstackImage->status !== 'active') {
                    throw new \Exception('Image upload timed out. Status: ' . $openstackImage->status);
                }

                // Sync to local database
                $localImage = $this->syncImageToDatabase($openstackImage, $region);

                DB::commit();

                return $localImage;
            } finally {
                // Clean up temp file
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to upload image from URL', [
                'error' => $e->getMessage(),
                'url' => $url,
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Download image from URL with validation.
     *
     * @param string $url
     * @return string Path to temporary file
     * @throws \Exception
     */
    protected function downloadImageFromUrl(string $url): string
    {
        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid URL provided');
        }

        // Check for allowed protocols
        $allowedSchemes = ['http', 'https'];
        $parsedUrl = parse_url($url);
        
        if (!in_array($parsedUrl['scheme'] ?? '', $allowedSchemes)) {
            throw new \Exception('Only HTTP and HTTPS URLs are allowed');
        }

        // Check for private/local IPs (security)
        $host = $parsedUrl['host'] ?? '';
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ip = $host;
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                throw new \Exception('Private or reserved IP addresses are not allowed');
            }
        }

        $client = new Client([
            'timeout' => 300, // 5 minutes
            'connect_timeout' => 30,
            'verify' => true, // SSL verification
            'allow_redirects' => [
                'max' => 5,
                'strict' => true,
                'referer' => true,
            ],
        ]);

        try {
            // Get file size first (HEAD request)
            $headResponse = $client->head($url);
            $contentLength = $headResponse->getHeaderLine('Content-Length');
            
            if ($contentLength) {
                $maxSize = 10 * 1024 * 1024 * 1024; // 10 GB
                if ((int) $contentLength > $maxSize) {
                    throw new \Exception('File size exceeds maximum allowed size of 10 GB');
                }
            }

            // Download the file
            $response = $client->get($url, [
                'sink' => $tempFile = tempnam(sys_get_temp_dir(), 'image_upload_'),
            ]);

            // Validate content type
            $contentType = $response->getHeaderLine('Content-Type');
            $allowedMimeTypes = [
                'application/octet-stream',
                'application/x-qemu-disk',
                'application/x-raw-disk-image',
                'application/x-iso9660-image',
                'application/vnd.virtualbox.vdi',
            ];

            // Get file extension from URL
            $path = parse_url($url, PHP_URL_PATH);
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $allowedExtensions = ['qcow2', 'raw', 'iso', 'vhd', 'vmdk', 'vdi'];

            if (!in_array($extension, $allowedExtensions)) {
                @unlink($tempFile);
                throw new \Exception('Invalid file type. Allowed: ' . implode(', ', $allowedExtensions));
            }

            // Validate file size
            $fileSize = filesize($tempFile);
            $maxSize = 10 * 1024 * 1024 * 1024; // 10 GB
            if ($fileSize > $maxSize) {
                @unlink($tempFile);
                throw new \Exception('File size exceeds maximum allowed size of 10 GB');
            }

            if ($fileSize < 1024) { // Less than 1 KB
                @unlink($tempFile);
                throw new \Exception('File is too small or invalid');
            }

            return $tempFile;
        } catch (RequestException $e) {
            throw new \Exception('Failed to download image from URL: ' . $e->getMessage());
        }
    }

    /**
     * Update an image.
     *
     * @param OpenStackImage $image
     * @param array $data
     * @return OpenStackImage
     * @throws \Exception
     */
    public function update(OpenStackImage $image, array $data): OpenStackImage
    {
        try {
            $imageService = $this->connection->getImageService();
            $openstackImage = $imageService->getImage(['id' => $image->openstack_id]);

            // Update properties
            if (isset($data['name'])) {
                $openstackImage->name = $data['name'];
            }

            if (isset($data['description'])) {
                $openstackImage->description = $data['description'];
            }

            if (isset($data['visibility'])) {
                $openstackImage->visibility = $data['visibility'];
            }

            if (isset($data['min_disk'])) {
                $openstackImage->minDisk = (int) $data['min_disk'];
            }

            if (isset($data['min_ram'])) {
                $openstackImage->minRam = (int) $data['min_ram'] * 1024; // Convert GB to MB
            }

            if (isset($data['metadata'])) {
                $openstackImage->metadata = array_merge($openstackImage->metadata ?? [], $data['metadata']);
            }

            $openstackImage->update();

            // Sync to local database
            $region = config('openstack.region', 'RegionOne');
            $image = $this->syncImageToDatabase($openstackImage, $region);

            return $image;
        } catch (\Exception $e) {
            Log::error('Failed to update image', [
                'error' => $e->getMessage(),
                'image_id' => $image->id,
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Delete an image.
     *
     * @param OpenStackImage $image
     * @return void
     * @throws \Exception
     */
    public function delete(OpenStackImage $image): void
    {
        try {
            // Check if image is in use
            if ($image->instances()->count() > 0) {
                throw new \Exception('Cannot delete image that is in use by instances');
            }

            $imageService = $this->connection->getImageService();
            $openstackImage = $imageService->getImage(['id' => $image->openstack_id]);
            $openstackImage->delete();

            // Delete from local database
            $image->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete image', [
                'error' => $e->getMessage(),
                'image_id' => $image->id,
            ]);
            throw $e;
        }
    }

    /**
     * Toggle image status (activate/deactivate).
     *
     * @param OpenStackImage $image
     * @return OpenStackImage
     * @throws \Exception
     */
    public function toggleStatus(OpenStackImage $image): OpenStackImage
    {
        try {
            $imageService = $this->connection->getImageService();
            $openstackImage = $imageService->getImage(['id' => $image->openstack_id]);

            // In OpenStack, we deactivate by changing visibility or status
            // For simplicity, we'll use the 'deactivated' status
            if ($image->status === 'active') {
                // Deactivate - change visibility to private or use deactivated status
                $openstackImage->visibility = 'private';
                $openstackImage->update();
                
                $image->status = 'deactivated';
            } else {
                // Activate
                $openstackImage->visibility = $image->visibility === 'public' ? 'public' : 'private';
                $openstackImage->update();
                
                $image->status = 'active';
            }

            $image->save();

            return $image;
        } catch (\Exception $e) {
            Log::error('Failed to toggle image status', [
                'error' => $e->getMessage(),
                'image_id' => $image->id,
            ]);
            throw $e;
        }
    }

    /**
     * Sync OpenStack image to local database.
     *
     * @param Image $openstackImage
     * @param string $region
     * @return OpenStackImage
     */
    protected function syncImageToDatabase(Image $openstackImage, string $region): OpenStackImage
    {
        $data = [
            'openstack_id' => $openstackImage->id,
            'name' => $openstackImage->name ?? 'Unnamed',
            'description' => $openstackImage->description ?? null,
            'status' => $openstackImage->status ?? 'unknown',
            'visibility' => $openstackImage->visibility ?? 'private',
            'disk_format' => $openstackImage->diskFormat ?? null,
            'container_format' => $openstackImage->containerFormat ?? null,
            'min_disk' => $openstackImage->minDisk ?? null,
            'min_ram' => $openstackImage->minRam ? (int) ($openstackImage->minRam / 1024) : null, // Convert MB to GB
            'size' => $openstackImage->size ?? null,
            'checksum' => $openstackImage->checksum ?? null,
            'owner_id' => $openstackImage->owner ?? null,
            'metadata' => $openstackImage->metadata ?? null,
            'region' => $region,
            'synced_at' => now(),
        ];

        $existing = OpenStackImage::where('openstack_id', $openstackImage->id)
            ->where('region', $region)
            ->first();

        if ($existing) {
            $existing->update($data);
            return $existing;
        }

        return OpenStackImage::create($data);
    }
}

