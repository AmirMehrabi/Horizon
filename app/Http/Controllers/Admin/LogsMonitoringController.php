<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogsMonitoringController extends Controller
{
    /**
     * Show the logs and monitoring index page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.logs-monitoring.index');
    }

    /**
     * Show the system logs page.
     *
     * @return View
     */
    public function systemLogs(): View
    {
        return view('admin.logs-monitoring.system-logs');
    }

    /**
     * Show the failed provisioning logs page.
     *
     * @return View
     */
    public function failedProvisioning(): View
    {
        return view('admin.logs-monitoring.failed-provisioning');
    }

    /**
     * Show the OpenStack event logs page.
     *
     * @return View
     */
    public function openstackLogs(): View
    {
        return view('admin.logs-monitoring.openstack-logs');
    }

    /**
     * Show the API health page.
     *
     * @return View
     */
    public function apiHealth(): View
    {
        return view('admin.logs-monitoring.api-health');
    }
}

