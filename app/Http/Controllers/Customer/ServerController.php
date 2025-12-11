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
    public function create()
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

        return view('customer.servers.create', compact('flavors', 'images', 'networks', 'securityGroups'));
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
            ->with(['flavor', 'image', 'keyPair', 'networks', 'securityGroups', 'events' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(50);
            }])
            ->firstOrFail();

        return view('customer.servers.show', compact('instance'));
    }
}

