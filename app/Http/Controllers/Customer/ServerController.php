<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServerRequest;
use App\Services\OpenStack\OpenStackInstanceService;
use App\Jobs\ProvisionOpenStackInstance;
use App\Models\OpenStackInstance;
use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSecurityGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServerController extends Controller
{
    protected OpenStackInstanceService $instanceService;

    public function __construct(OpenStackInstanceService $instanceService)
    {
        $this->instanceService = $instanceService;
    }

    /**
     * Display the VPS purchase wizard
     */
    public function create(Request $request)
    {
        $region = config('openstack.region');
        
        // Get available resources for the form
        $flavors = OpenStackFlavor::where('region', $region)
            ->where('is_disabled', false)
            ->where('is_public', true)
            ->orderBy('vcpus')
            ->orderBy('ram')
            ->get();
        
        $images = OpenStackImage::where('region', $region)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('visibility', 'public')
                      ->orWhere('visibility', 'shared');
            })
            ->orderBy('name')
            ->get();
        
        $networks = OpenStackNetwork::where('region', $region)
            ->where('status', 'ACTIVE')
            ->get();
        
        $securityGroups = OpenStackSecurityGroup::where('region', $region)
            ->orderBy('name')
            ->get();
        
        $customer = $request->user('customer');
        $keyPairs = \App\Models\OpenStackKeyPair::where('customer_id', $customer->id)
            ->where('region', $region)
            ->orderBy('name')
            ->get();

        return view('customer.servers.create', compact('flavors', 'images', 'networks', 'securityGroups', 'keyPairs'));
    }

    /**
     * Store the new VPS instance
     */
    public function store(StoreServerRequest $request)
    {
        try {
            $customer = $request->user('customer');
            
            // Create instance locally first
            $instance = $this->instanceService->create($customer, $request->validated());
            
            // Dispatch job to provision in OpenStack
            // Note: If QUEUE_CONNECTION=sync in .env, this will run immediately
            // Otherwise, you need to run a queue worker: php artisan queue:work --queue=openstack-provisioning
            // Or run: php artisan queue:listen --queue=openstack-provisioning
            ProvisionOpenStackInstance::dispatch($instance);
            
            Log::info('Instance creation initiated', [
                'instance_id' => $instance->id,
                'customer_id' => $customer->id,
                'name' => $instance->name,
            ]);
            
            return redirect()->route('customer.servers.show', $instance->id)
                ->with('success', 'سرور شما در حال راه‌اندازی است. لطفاً چند لحظه صبر کنید.');
        } catch (\Exception $e) {
            Log::error('Failed to create instance', [
                'customer_id' => $request->user('customer')->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'خطا در ایجاد سرور: ' . $e->getMessage()]);
        }
    }

    /**
     * Display list of customer servers
     */
    public function index(Request $request)
    {
        $customer = $request->user('customer');
        
        $instances = OpenStackInstance::where('customer_id', $customer->id)
            ->where('status', '!=', 'deleted')
            ->with(['flavor', 'image', 'networks'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('customer.servers.index', compact('instances'));
    }

    /**
     * Display VPS management page
     */
    public function show(Request $request, $id)
    {
        $customer = $request->user('customer');
        
        $instance = OpenStackInstance::where('id', $id)
            ->where('customer_id', $customer->id)
            ->where('status', '!=', 'deleted')
            ->with(['flavor', 'image', 'keyPair', 'networks', 'securityGroups', 'events' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(50);
            }])
            ->firstOrFail();

        // Format instance data for the view
        $publicIps = $instance->public_ips ?? [];
        $privateIps = $instance->private_ips ?? [];
        
        $server = [
            'id' => $instance->id,
            'name' => $instance->name ?? 'Unnamed Server',
            'status' => $instance->status ?? 'unknown',
            'os' => $instance->image->name ?? ($instance->image->description ?? 'Unknown'),
            'vcpu' => $instance->flavor->vcpus ?? 0,
            'ram' => $instance->flavor ? round($instance->flavor->ram / 1024, 1) : 0,
            'storage' => $instance->flavor->disk ?? 0,
            'type' => $instance->flavor->name ?? 'Unknown',
            'region' => $instance->region ?? config('openstack.region', 'Unknown'),
            'public_ip' => !empty($publicIps) ? $publicIps[0] : 'در حال اختصاص...',
            'private_ip' => !empty($privateIps) ? $privateIps[0] : 'در حال اختصاص...',
            'created_at' => $instance->created_at ? $instance->created_at->format('Y/m/d H:i') : 'Unknown',
            // Resource usage (placeholder - should be fetched from OpenStack metrics)
            'cpu_usage' => 0,
            'ram_used' => 0,
            'storage_used' => 0,
            // Additional data
            'floating_ips' => [],
            'security_groups' => $instance->securityGroups ? $instance->securityGroups->map(function ($sg) {
                // Format rules for display
                $rulesText = 'هیچ قانونی تعریف نشده';
                if (!empty($sg->rules) && is_array($sg->rules)) {
                    $rulesCount = count($sg->rules);
                    $rulesText = $rulesCount . ' قانون تعریف شده';
                } elseif (!empty($sg->rules)) {
                    $rulesText = 'قوانین تعریف شده';
                }
                
                return [
                    'id' => $sg->id,
                    'name' => $sg->name,
                    'description' => $sg->description ?? '',
                    'rules' => $rulesText,
                ];
            })->toArray() : [],
            'bandwidth' => [
                'used' => 0,
                'limit' => 1000,
                'inbound' => 0,
                'outbound' => 0,
            ],
            'volumes' => [],
            'snapshots' => [],
        ];

        return view('customer.servers.show', compact('server', 'instance'));
    }

    /**
     * API: Get available flavors
     */
    public function getFlavors(Request $request)
    {
        $region = $request->input('region', config('openstack.region'));
        
        $flavors = OpenStackFlavor::where('region', $region)
            ->where('is_disabled', false)
            ->where('is_public', true)
            ->orderBy('vcpus')
            ->orderBy('ram')
            ->get()
            ->map(function ($flavor) {
                return [
                    'id' => $flavor->id,
                    'name' => $flavor->name,
                    'description' => $flavor->description,
                    'vcpus' => $flavor->vcpus,
                    'ram' => $flavor->ram,
                    'ram_gb' => $flavor->ram_in_gb,
                    'disk' => $flavor->disk,
                    'pricing_hourly' => $flavor->pricing_hourly,
                    'pricing_monthly' => $flavor->pricing_monthly,
                    'is_available' => $flavor->isAvailable(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $flavors,
        ]);
    }

    /**
     * API: Get available images
     */
    public function getImages(Request $request)
    {
        $region = $request->input('region', config('openstack.region'));
        $os = $request->input('os'); // Optional filter by OS type
        
        $query = OpenStackImage::where('region', $region)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('visibility', 'public')
                      ->orWhere('visibility', 'shared');
            });

        // Filter by OS type if provided
        if ($os && $os !== 'custom') {
            $query->where(function ($q) use ($os) {
                $osMap = [
                    'ubuntu' => ['Ubuntu', 'ubuntu'],
                    'debian' => ['Debian', 'debian'],
                    'centos' => ['CentOS', 'centos'],
                    'almalinux' => ['AlmaLinux', 'almalinux'],
                    'windows' => ['Windows', 'windows'],
                ];
                
                if (isset($osMap[$os])) {
                    foreach ($osMap[$os] as $osName) {
                        $q->orWhere('name', 'like', "%{$osName}%");
                    }
                }
            });
        }

        $images = $query->orderBy('name')
            ->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'name' => $image->name,
                    'description' => $image->description,
                    'status' => $image->status,
                    'visibility' => $image->visibility,
                    'size_gb' => $image->size_in_gb,
                    'min_disk' => $image->min_disk,
                    'min_ram' => $image->min_ram,
                    'disk_format' => $image->disk_format,
                    'is_available' => $image->isAvailable(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $images,
        ]);
    }

    /**
     * API: Get available networks
     */
    public function getNetworks(Request $request)
    {
        $region = $request->input('region', config('openstack.region'));
        
        $networks = OpenStackNetwork::where('region', $region)
            ->where('status', 'ACTIVE')
            ->with('subnets')
            ->orderBy('name')
            ->get()
            ->map(function ($network) {
                return [
                    'id' => $network->id,
                    'name' => $network->name,
                    'description' => $network->description,
                    'status' => $network->status,
                    'shared' => $network->shared,
                    'external' => $network->external,
                    'is_active' => $network->isActive(),
                    'subnets' => $network->relationLoaded('subnets') && $network->subnets instanceof \Illuminate\Database\Eloquent\Collection
                        ? $network->subnets->map(function ($subnet) {
                            return [
                                'id' => $subnet->id,
                                'name' => $subnet->name,
                                'cidr' => $subnet->cidr,
                                'ip_version' => $subnet->ip_version,
                            ];
                        })->toArray()
                        : (is_array($network->subnets) ? $network->subnets : []),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $networks,
        ]);
    }

    /**
     * API: Get available security groups
     */
    public function getSecurityGroups(Request $request)
    {
        $region = $request->input('region', config('openstack.region'));
        
        $securityGroups = OpenStackSecurityGroup::where('region', $region)
            ->orderBy('name')
            ->get()
            ->map(function ($sg) {
                return [
                    'id' => $sg->id,
                    'name' => $sg->name,
                    'description' => $sg->description,
                    'rules_count' => is_array($sg->rules) ? count($sg->rules) : 0,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $securityGroups,
        ]);
    }

    /**
     * API: Get customer's SSH key pairs
     */
    public function getKeyPairs(Request $request)
    {
        $customer = $request->user('customer');
        $region = $request->input('region', config('openstack.region'));
        
        $keyPairs = \App\Models\OpenStackKeyPair::where('customer_id', $customer->id)
            ->where('region', $region)
            ->orderBy('name')
            ->get()
            ->map(function ($keyPair) {
                return [
                    'id' => $keyPair->id,
                    'name' => $keyPair->name,
                    'fingerprint' => $keyPair->fingerprint,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $keyPairs,
        ]);
    }

    /**
     * Perform server action (start, stop, reboot, etc.)
     */
    public function action(Request $request, $id, $action)
    {
        try {
            $customer = $request->user('customer');
            
            $instance = OpenStackInstance::where('id', $id)
                ->where('customer_id', $customer->id)
                ->where('status', '!=', 'deleted')
                ->firstOrFail();

            // Validate action
            $allowedActions = ['start', 'stop', 'restart', 'soft-reboot', 'hard-reboot', 'delete', 'rescue-mode'];
            if (!in_array($action, $allowedActions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'عملیات نامعتبر است.',
                ], 400);
            }

            // Map action names to service methods
            switch ($action) {
                case 'start':
                    $this->instanceService->start($instance);
                    $message = 'دستور شروع سرور ارسال شد.';
                    break;
                
                case 'stop':
                    $this->instanceService->stop($instance);
                    $message = 'دستور توقف سرور ارسال شد.';
                    break;
                
                case 'restart':
                case 'soft-reboot':
                    $this->instanceService->reboot($instance, 'SOFT');
                    $message = 'دستور راه‌اندازی مجدد نرم ارسال شد.';
                    break;
                
                case 'hard-reboot':
                    $this->instanceService->reboot($instance, 'HARD');
                    $message = 'دستور راه‌اندازی مجدد سخت ارسال شد.';
                    break;
                
                case 'rescue-mode':
                    $this->instanceService->rescue($instance);
                    $message = 'دستور فعال‌سازی حالت نجات ارسال شد.';
                    break;
                
                case 'delete':
                    $this->instanceService->delete($instance);
                    $message = 'دستور حذف سرور ارسال شد.';
                    break;
                
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'عملیات پشتیبانی نمی‌شود.',
                    ], 400);
            }

            Log::info('Server action executed', [
                'instance_id' => $instance->id,
                'customer_id' => $customer->id,
                'action' => $action,
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to execute server action', [
                'instance_id' => $id,
                'action' => $action,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطا در اجرای عملیات: ' . $e->getMessage(),
            ], 500);
        }
    }
}

