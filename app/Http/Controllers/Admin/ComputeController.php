<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpenStackInstance;
use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSecurityGroup;
use App\Models\Customer;
use App\Services\OpenStack\OpenStackInstanceService;
use App\Jobs\ProvisionOpenStackInstance;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ComputeController extends Controller
{
    protected OpenStackInstanceService $instanceService;

    public function __construct(OpenStackInstanceService $instanceService)
    {
        $this->instanceService = $instanceService;
    }

    /**
     * Show the compute instances list page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = OpenStackInstance::with(['customer', 'flavor', 'image'])
            ->where('status', '!=', 'deleted');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('openstack_server_id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('company_name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Customer filter
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->get('customer_id'));
        }

        // Region filter
        if ($request->filled('region')) {
            $query->where('region', $request->get('region'));
        }

        // Order by
        $query->orderBy('created_at', 'desc');

        // Paginate
        $instances = $query->paginate(25)->withQueryString();

        // Statistics
        $stats = [
            'total' => OpenStackInstance::where('status', '!=', 'deleted')->count(),
            'active' => OpenStackInstance::where('status', 'active')->count(),
            'stopped' => OpenStackInstance::where('status', 'stopped')->count(),
            'error' => OpenStackInstance::where('status', 'error')->count(),
            'building' => OpenStackInstance::where('status', 'building')->count(),
        ];

        // Get customers for filter
        $customers = Customer::orderBy('company_name')
            ->orderBy('first_name')
            ->get();

        // Get regions
        $regions = OpenStackInstance::select('region')
            ->distinct()
            ->whereNotNull('region')
            ->orderBy('region')
            ->pluck('region');

        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'customer_id' => $request->get('customer_id'),
            'region' => $request->get('region'),
        ];

        return view('admin.compute.index', compact('instances', 'stats', 'customers', 'regions', 'filters'));
    }

    /**
     * Show the create instance page.
     *
     * @return View
     */
    public function create(): View
    {
        $region = config('openstack.region', 'RegionOne');

        $flavors = OpenStackFlavor::where('region', $region)
            ->where('is_disabled', false)
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
            ->orderBy('name')
            ->get();

        $securityGroups = OpenStackSecurityGroup::where('region', $region)
            ->orderBy('name')
            ->get();

        $customers = Customer::active()
            ->orderBy('company_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.compute.create', compact('flavors', 'images', 'networks', 'securityGroups', 'customers'));
    }

    /**
     * Store a newly created instance.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'flavor_id' => 'required|exists:openstack_flavors,id',
            'image_id' => 'required|exists:openstack_images,id',
            'network_ids' => 'required|array|min:1',
            'network_ids.*' => 'exists:openstack_networks,id',
            'security_groups' => 'nullable|array',
            'security_groups.*' => 'exists:openstack_security_groups,id',
            'key_pair_id' => 'nullable|exists:openstack_key_pairs,id',
            'root_password' => 'nullable|string|min:8',
            'root_password_confirmation' => 'nullable|string|same:root_password',
            'access_method' => 'required|in:ssh_key,password',
            'user_data' => 'nullable|string',
            'config_drive' => 'nullable|boolean',
            'region' => 'nullable|string',
            'availability_zone' => 'nullable|string',
            'billing_cycle' => 'required|in:hourly,monthly',
            'auto_billing' => 'nullable|boolean',
        ]);

        try {
            $customer = Customer::findOrFail($validated['customer_id']);

            // Prepare data for service
            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'flavor_id' => $validated['flavor_id'],
                'image_id' => $validated['image_id'],
                'network_ids' => $validated['network_ids'],
                'security_groups' => $validated['security_groups'] ?? [],
                'key_pair_id' => $validated['key_pair_id'] ?? null,
                'root_password' => $validated['root_password'] ?? null,
                'root_password_confirmation' => $validated['root_password_confirmation'] ?? null,
                'access_method' => $validated['access_method'],
                'user_data' => $validated['user_data'] ?? null,
                'config_drive' => $validated['config_drive'] ?? false,
                'region' => $validated['region'] ?? config('openstack.region'),
                'availability_zone' => $validated['availability_zone'] ?? null,
                'billing_cycle' => $validated['billing_cycle'],
                'auto_billing' => $validated['auto_billing'] ?? true,
            ];

            // Create instance
            $instance = $this->instanceService->create($customer, $data);

            // Dispatch provisioning job
            ProvisionOpenStackInstance::dispatch($instance);

            Log::info('Admin created instance', [
                'instance_id' => $instance->id,
                'customer_id' => $customer->id,
                'name' => $instance->name,
            ]);

            return redirect()
                ->route('admin.compute.show', $instance->id)
                ->with('success', 'Instance created successfully and is being provisioned.');
        } catch (\Exception $e) {
            Log::error('Failed to create instance', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.compute.create')
                ->with('error', 'Failed to create instance: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the instance detail page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $instance = OpenStackInstance::with([
            'customer',
            'flavor',
            'image',
            'keyPair',
            'networks',
            'securityGroups',
            'events' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(50);
            }
        ])->findOrFail($id);

        return view('admin.compute.show', compact('instance'));
    }

    /**
     * Start an instance.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function start(string $id): RedirectResponse
    {
        try {
            $instance = OpenStackInstance::findOrFail($id);
            $this->instanceService->start($instance);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('success', 'Instance start requested.');
        } catch (\Exception $e) {
            Log::error('Failed to start instance', [
                'instance_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('error', 'Failed to start instance: ' . $e->getMessage());
        }
    }

    /**
     * Stop an instance.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function stop(string $id): RedirectResponse
    {
        try {
            $instance = OpenStackInstance::findOrFail($id);
            $this->instanceService->stop($instance);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('success', 'Instance stop requested.');
        } catch (\Exception $e) {
            Log::error('Failed to stop instance', [
                'instance_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('error', 'Failed to stop instance: ' . $e->getMessage());
        }
    }

    /**
     * Reboot an instance.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function reboot(Request $request, string $id): RedirectResponse
    {
        try {
            $instance = OpenStackInstance::findOrFail($id);
            $type = $request->get('type', 'SOFT');
            $this->instanceService->reboot($instance, $type);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('success', 'Instance reboot requested.');
        } catch (\Exception $e) {
            Log::error('Failed to reboot instance', [
                'instance_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('error', 'Failed to reboot instance: ' . $e->getMessage());
        }
    }

    /**
     * Delete an instance.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $instance = OpenStackInstance::findOrFail($id);
            $this->instanceService->delete($instance);

            return redirect()
                ->route('admin.compute.index')
                ->with('success', 'Instance deletion requested.');
        } catch (\Exception $e) {
            Log::error('Failed to delete instance', [
                'instance_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.compute.show', $id)
                ->with('error', 'Failed to delete instance: ' . $e->getMessage());
        }
    }
}



