<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NetworkManagementController extends Controller
{
    /**
     * Show the network management page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.networks.index');
    }

    /**
     * Show the network detail page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        return view('admin.networks.show', compact('id'));
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



