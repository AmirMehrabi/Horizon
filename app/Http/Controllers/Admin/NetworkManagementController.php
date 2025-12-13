<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpenStack\OpenStackNetworkService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class NetworkManagementController extends Controller
{
    protected OpenStackNetworkService $networkService;

    public function __construct(OpenStackNetworkService $networkService)
    {
        $this->networkService = $networkService;
    }

    /**
     * Show the network management page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $filters = [
                'search' => $request->get('search'),
                'type' => $request->get('type'),
                'project_id' => $request->get('project_id'),
            ];

            $networks = $this->networkService->getAllNetworks($filters);
            $statistics = $this->networkService->getStatistics();

            return view('admin.networks.index', compact('networks', 'statistics', 'filters'));
        } catch (\Exception $e) {
            Log::error('Failed to load networks', [
                'error' => $e->getMessage(),
            ]);
            
            return view('admin.networks.index', [
                'networks' => collect([]),
                'statistics' => ['total' => 0, 'public' => 0, 'private' => 0, 'floating_ips' => 0],
                'filters' => [],
                'error' => 'Failed to load networks: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the network detail page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        try {
            $network = $this->networkService->getNetwork($id);
            
            if (!$network) {
                abort(404, 'Network not found');
            }

            return view('admin.networks.show', compact('network'));
        } catch (\Exception $e) {
            Log::error('Failed to load network', [
                'network_id' => $id,
                'error' => $e->getMessage(),
            ]);
            
            abort(404, 'Network not found');
        }
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
            'type' => 'required|in:public,private',
            'cidr' => 'nullable|string',
            'gateway_ip' => 'nullable|ip',
            'enable_dhcp' => 'nullable|boolean',
            'enable_dns' => 'nullable|boolean',
        ]);

        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'external' => $request->input('type') === 'public',
                'shared' => false,
                'admin_state_up' => true,
                'cidr' => $request->input('cidr'),
                'gateway_ip' => $request->input('gateway_ip'),
                'enable_dhcp' => $request->input('enable_dhcp', true),
            ];

            $network = $this->networkService->createNetwork($data);

            return redirect()
                ->route('admin.networks.show', $network->openstack_id)
                ->with('success', 'Network created successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create network', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.networks.index')
                ->with('error', 'Failed to create network: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified network.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private',
            'gateway_ip' => 'nullable|ip',
            'enable_dhcp' => 'nullable|boolean',
        ]);

        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'external' => $request->input('type') === 'public',
                'gateway_ip' => $request->input('gateway_ip'),
                'enable_dhcp' => $request->input('enable_dhcp', true),
            ];

            $network = $this->networkService->updateNetwork($id, $data);

            return redirect()
                ->route('admin.networks.show', $network->openstack_id)
                ->with('success', 'Network updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update network', [
                'network_id' => $id,
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.networks.show', $id)
                ->with('error', 'Failed to update network: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified network.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->networkService->deleteNetwork($id);

            return redirect()
                ->route('admin.networks.index')
                ->with('success', 'Network deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete network', [
                'network_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.networks.show', $id)
                ->with('error', 'Failed to delete network: ' . $e->getMessage());
        }
    }

    /**
     * Show the router management page.
     *
     * @return View
     */
    public function routers(): View
    {
        return view('admin.networks.routers');
    }

    /**
     * Show the router detail page.
     *
     * @param string $id
     * @return View
     */
    public function routerShow(string $id): View
    {
        return view('admin.networks.router-show', compact('id'));
    }

    /**
     * Show the floating IP pools page.
     *
     * @return View
     */
    public function floatingIps(): View
    {
        return view('admin.networks.floating-ips');
    }

    /**
     * Show the security groups page.
     *
     * @return View
     */
    public function securityGroups(): View
    {
        return view('admin.networks.security-groups');
    }

    /**
     * Show the security group detail page.
     *
     * @param string $id
     * @return View
     */
    public function securityGroupShow(string $id): View
    {
        return view('admin.networks.security-group-show', compact('id'));
    }

    /**
     * Show the load balancers page.
     *
     * @return View
     */
    public function loadBalancers(): View
    {
        return view('admin.networks.load-balancers');
    }

    /**
     * Show the load balancer detail page.
     *
     * @param string $id
     * @return View
     */
    public function loadBalancerShow(string $id): View
    {
        return view('admin.networks.load-balancer-show', compact('id'));
    }
}



