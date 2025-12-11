<?php

namespace App\Services\OpenStack;

use OpenStack\OpenStack;
use OpenStack\Compute\v2\Service as ComputeService;
use OpenStack\Networking\v2\Service as NetworkingService;
use OpenStack\Images\v2\Service as ImageService;
use OpenStack\Identity\v3\Service as IdentityService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OpenStackConnectionService
{
    private ?OpenStack $client = null;
    private ?ComputeService $computeService = null;
    private ?NetworkingService $networkingService = null;
    private ?ImageService $imageService = null;
    private ?IdentityService $identityService = null;

    /**
     * Get the OpenStack client instance.
     *
     * @return OpenStack
     * @throws \Exception
     */
    public function getClient(): OpenStack
    {
        if ($this->client === null) {
            try {
                $this->client = new OpenStack($this->getAuthConfig());
            } catch (\Exception $e) {
                Log::error('Failed to create OpenStack client', [
                    'error' => $e->getMessage(),
                    'auth_url' => config('openstack.auth_url'),
                ]);
                throw new \Exception('Failed to connect to OpenStack: ' . $e->getMessage(), 0, $e);
            }
        }

        return $this->client;
    }

    /**
     * Get the authentication configuration array.
     *
     * @return array
     */
    protected function getAuthConfig(): array
    {
        $config = [
            'authUrl' => config('openstack.auth_url'),
            'region' => config('openstack.region'),
            'httpOptions' => [
                'timeout' => config('openstack.timeout', 30),
                'connect_timeout' => config('openstack.connect_timeout', 10),
            ],
        ];

        // Build user configuration
        $userConfig = [];
        
        if (config('openstack.user_id')) {
            $userConfig['id'] = config('openstack.user_id');
        } else {
            $userConfig['name'] = config('openstack.username');
        }
        
        $userConfig['password'] = config('openstack.password');
        
        // Add domain if specified
        if (config('openstack.domain_id') || config('openstack.domain_name')) {
            $userConfig['domain'] = [];
            if (config('openstack.domain_id')) {
                $userConfig['domain']['id'] = config('openstack.domain_id');
            } else {
                $userConfig['domain']['name'] = config('openstack.domain_name');
            }
        }
        
        $config['user'] = $userConfig;

        // Build scope (project) configuration
        $scopeConfig = [];
        
        if (config('openstack.project_id')) {
            $scopeConfig['project']['id'] = config('openstack.project_id');
        } elseif (config('openstack.project_name')) {
            $scopeConfig['project']['name'] = config('openstack.project_name');
        }
        
        // Add domain to project if specified
        if (isset($scopeConfig['project']) && (config('openstack.domain_id') || config('openstack.domain_name'))) {
            if (config('openstack.domain_id')) {
                $scopeConfig['project']['domain']['id'] = config('openstack.domain_id');
            } else {
                $scopeConfig['project']['domain']['name'] = config('openstack.domain_name');
            }
        }
        
        if (!empty($scopeConfig)) {
            $config['scope'] = $scopeConfig;
        }

        return $config;
    }

    /**
     * Get the Nova (Compute) service.
     *
     * @return ComputeService
     * @throws \Exception
     */
    public function getComputeService(): ComputeService
    {
        if ($this->computeService === null) {
            try {
                $this->computeService = $this->getClient()->computeV2();
            } catch (\Exception $e) {
                Log::error('Failed to get Compute service', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Failed to get Compute service: ' . $e->getMessage(), 0, $e);
            }
        }

        return $this->computeService;
    }

    /**
     * Get the Neutron (Networking) service.
     *
     * @return NetworkingService
     * @throws \Exception
     */
    public function getNetworkingService(): NetworkingService
    {
        if ($this->networkingService === null) {
            try {
                $this->networkingService = $this->getClient()->networkingV2();
            } catch (\Exception $e) {
                Log::error('Failed to get Networking service', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Failed to get Networking service: ' . $e->getMessage(), 0, $e);
            }
        }

        return $this->networkingService;
    }

    /**
     * Get the Glance (Image) service.
     *
     * @return ImageService
     * @throws \Exception
     */
    public function getImageService(): ImageService
    {
        if ($this->imageService === null) {
            try {
                $this->imageService = $this->getClient()->imagesV2();
            } catch (\Exception $e) {
                Log::error('Failed to get Image service', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Failed to get Image service: ' . $e->getMessage(), 0, $e);
            }
        }

        return $this->imageService;
    }

    /**
     * Get the Keystone (Identity) service.
     *
     * @return IdentityService
     * @throws \Exception
     */
    public function getIdentityService(): IdentityService
    {
        if ($this->identityService === null) {
            try {
                $this->identityService = $this->getClient()->identityV3();
            } catch (\Exception $e) {
                Log::error('Failed to get Identity service', [
                    'error' => $e->getMessage(),
                ]);
                throw new \Exception('Failed to get Identity service: ' . $e->getMessage(), 0, $e);
            }
        }

        return $this->identityService;
    }

    /**
     * Test the connection to OpenStack.
     *
     * @return array
     * @throws \Exception
     */
    public function testConnection(): array
    {
        $results = [
            'success' => false,
            'services' => [],
            'errors' => [],
        ];

        try {
            // Test basic connection
            $client = $this->getClient();
            $results['client'] = 'Connected';

            // Test Compute service
            try {
                $compute = $this->getComputeService();
                $flavors = iterator_to_array($compute->listFlavors(['limit' => 1]));
                $results['services']['compute'] = [
                    'status' => 'connected',
                    'flavors_count' => count($flavors),
                ];
            } catch (\Exception $e) {
                $results['services']['compute'] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
                $results['errors'][] = 'Compute: ' . $e->getMessage();
            }

            // Test Networking service
            try {
                $networking = $this->getNetworkingService();
                $networks = iterator_to_array($networking->listNetworks(['limit' => 1]));
                $results['services']['networking'] = [
                    'status' => 'connected',
                    'networks_count' => count($networks),
                ];
            } catch (\Exception $e) {
                $results['services']['networking'] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
                $results['errors'][] = 'Networking: ' . $e->getMessage();
            }

            // Test Image service
            try {
                $image = $this->getImageService();
                $images = iterator_to_array($image->listImages(['limit' => 1]));
                $results['services']['image'] = [
                    'status' => 'connected',
                    'images_count' => count($images),
                ];
            } catch (\Exception $e) {
                $results['services']['image'] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
                $results['errors'][] = 'Image: ' . $e->getMessage();
            }

            // Test Identity service
            try {
                $identity = $this->getIdentityService();
                $results['services']['identity'] = [
                    'status' => 'connected',
                ];
            } catch (\Exception $e) {
                $results['services']['identity'] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
                $results['errors'][] = 'Identity: ' . $e->getMessage();
            }

            // Determine overall success
            $successCount = count(array_filter($results['services'], fn($s) => $s['status'] === 'connected'));
            $results['success'] = $successCount > 0;
            $results['services_connected'] = $successCount;
            $results['total_services'] = count($results['services']);

        } catch (\Exception $e) {
            $results['errors'][] = 'Connection failed: ' . $e->getMessage();
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * Clear cached services (useful for testing or after config changes).
     */
    public function clearCache(): void
    {
        $this->client = null;
        $this->computeService = null;
        $this->networkingService = null;
        $this->imageService = null;
        $this->identityService = null;
    }
}

