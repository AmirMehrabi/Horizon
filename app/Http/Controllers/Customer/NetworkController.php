<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\OpenStack\OpenStackNetworkService;
use App\Services\OpenStack\OpenStackSyncService;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSecurityGroup;
use App\Models\OpenStackInstance;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NetworkController extends Controller
{
    protected OpenStackNetworkService $networkService;
    protected OpenStackSyncService $syncService;

    public function __construct(
        OpenStackNetworkService $networkService,
        OpenStackSyncService $syncService
    ) {
        $this->networkService = $networkService;
        $this->syncService = $syncService;
    }

    /**
     * Show the customer networks page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $customer = Auth::guard('customer')->user();
            
            // Get customer's networks (private networks only)
            $filters = [
                'type' => 'private',
                'customer_id' => $customer->id,
            ];

            $networks = $this->networkService->getAllNetworks($filters);
            
            // Filter to only networks associated with customer's instances
            $customerInstanceIds = OpenStackInstance::where('customer_id', $customer->id)
                ->pluck('id')
                ->toArray();
            
            $customerNetworks = $networks->filter(function ($network) use ($customerInstanceIds) {
                return $network->instances()->whereIn('openstack_instances.id', $customerInstanceIds)->exists();
            });

            // Get security groups
            $securityGroups = OpenStackSecurityGroup::where('region', config('openstack.region'))
                ->get()
                ->filter(function ($sg) use ($customerInstanceIds) {
                    return $sg->instances()->whereIn('openstack_instances.id', $customerInstanceIds)->exists();
                });

            // Get customer's instances for statistics
            $instances = OpenStackInstance::where('customer_id', $customer->id)->get();
            
            // Calculate statistics
            $statistics = [
                'private_networks' => $customerNetworks->count(),
                'security_groups' => $securityGroups->count(),
                'floating_ips' => $instances->sum(function ($instance) {
                    return $instance->networks()->whereNotNull('floating_ip')->count();
                }),
                'bandwidth_usage' => 0, // TODO: Implement bandwidth tracking
            ];

            return view('customer.networks.index', compact('customerNetworks', 'securityGroups', 'instances', 'statistics'));
        } catch (\Exception $e) {
            Log::error('Failed to load customer networks', [
                'customer_id' => Auth::guard('customer')->id(),
                'error' => $e->getMessage(),
            ]);
            
            return view('customer.networks.index', [
                'customerNetworks' => collect([]),
                'securityGroups' => collect([]),
                'instances' => collect([]),
                'statistics' => [
                    'private_networks' => 0,
                    'security_groups' => 0,
                    'floating_ips' => 0,
                    'bandwidth_usage' => 0,
                ],
                'error' => 'Failed to load networks: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the create network page.
     *
     * @return View
     */
    public function create(): View
    {
        return view('customer.networks.create');
    }

    /**
     * Store a newly created network.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cidr' => 'nullable|string',
            'gateway_ip' => 'nullable|ip',
            'enable_dhcp' => 'nullable|boolean',
        ]);

        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'external' => false, // Customer can only create private networks
                'shared' => false,
                'admin_state_up' => true,
                'cidr' => $request->input('cidr'),
                'gateway_ip' => $request->input('gateway_ip'),
                'enable_dhcp' => $request->input('enable_dhcp', true),
            ];

            $network = $this->networkService->createNetwork($data);

            return redirect()
                ->route('customer.networks.index')
                ->with('success', 'Network created successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create network', [
                'customer_id' => Auth::guard('customer')->id(),
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('customer.networks.create')
                ->with('error', 'Failed to create network: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show network details.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        try {
            $customer = Auth::guard('customer')->user();
            $network = $this->networkService->getNetwork($id);
            
            if (!$network) {
                abort(404, 'Network not found');
            }

            // Verify network belongs to customer
            $customerInstanceIds = OpenStackInstance::where('customer_id', $customer->id)
                ->pluck('id')
                ->toArray();
            
            $hasAccess = $network->instances()->whereIn('openstack_instances.id', $customerInstanceIds)->exists();
            
            if (!$hasAccess) {
                abort(403, 'You do not have access to this network');
            }

            // Ensure relationships are loaded
            if (!$network->relationLoaded('subnets')) {
                $network->load('subnets');
            }
            if (!$network->relationLoaded('instances')) {
                $network->load('instances');
            }

            // Filter instances to only customer's instances
            $network->setRelation('instances', $network->instances()->whereIn('openstack_instances.id', $customerInstanceIds)->get());

            return view('customer.networks.show', compact('network'));
        } catch (\Exception $e) {
            Log::error('Failed to load network', [
                'network_id' => $id,
                'customer_id' => Auth::guard('customer')->id(),
                'error' => $e->getMessage(),
            ]);
            
            abort(404, 'Network not found');
        }
    }

    /**
     * Show security groups page.
     *
     * @return View
     */
    public function securityGroups(): View
    {
        try {
            $customer = Auth::guard('customer')->user();
            $customerInstanceIds = OpenStackInstance::where('customer_id', $customer->id)
                ->pluck('id')
                ->toArray();
            
            $securityGroups = OpenStackSecurityGroup::where('region', config('openstack.region'))
                ->get()
                ->filter(function ($sg) use ($customerInstanceIds) {
                    return $sg->instances()->whereIn('openstack_instances.id', $customerInstanceIds)->exists();
                });

            return view('customer.networks.security-groups', compact('securityGroups'));
        } catch (\Exception $e) {
            Log::error('Failed to load security groups', [
                'customer_id' => Auth::guard('customer')->id(),
                'error' => $e->getMessage(),
            ]);
            
            return view('customer.networks.security-groups', [
                'securityGroups' => collect([]),
                'error' => 'Failed to load security groups: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show floating IPs page.
     *
     * @return View
     */
    public function floatingIps(): View
    {
        try {
            $customer = Auth::guard('customer')->user();
            $instances = OpenStackInstance::where('customer_id', $customer->id)
                ->with(['networks' => function ($query) {
                    $query->whereNotNull('floating_ip');
                }])
                ->get();

            $floatingIps = collect();
            foreach ($instances as $instance) {
                foreach ($instance->networks as $network) {
                    if ($network->pivot->floating_ip) {
                        $floatingIps->push([
                            'ip' => $network->pivot->floating_ip,
                            'instance' => $instance,
                            'fixed_ip' => $network->pivot->fixed_ip,
                            'network' => $network,
                        ]);
                    }
                }
            }

            return view('customer.networks.floating-ips', compact('floatingIps', 'instances'));
        } catch (\Exception $e) {
            Log::error('Failed to load floating IPs', [
                'customer_id' => Auth::guard('customer')->id(),
                'error' => $e->getMessage(),
            ]);
            
            return view('customer.networks.floating-ips', [
                'floatingIps' => collect([]),
                'instances' => collect([]),
                'error' => 'Failed to load floating IPs: ' . $e->getMessage(),
            ]);
        }
    }
}

