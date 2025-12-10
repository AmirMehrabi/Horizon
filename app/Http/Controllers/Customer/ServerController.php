<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display the VPS purchase wizard
     */
    public function create()
    {
        return view('customer.servers.create');
    }

    /**
     * Store the new VPS instance
     */
    public function store(Request $request)
    {
        // TODO: Implement VPS creation logic
        // This will handle the form submission from the wizard
        
        return redirect()->route('customer.servers.index')
            ->with('success', 'سرور شما در حال راه‌اندازی است');
    }

    /**
     * Display list of customer servers
     */
    public function index()
    {
        return view('customer.servers.index');
    }

    /**
     * Display VPS management page
     */
    public function show($id)
    {
        // Dummy data for demonstration
        $server = [
            'id' => $id,
            'name' => 'وب سرور اصلی',
            'os' => 'Ubuntu 22.04 LTS',
            'type' => 'VPS',
            'status' => 'active', // active, stopped, building
            'region' => 'تهران',
            'public_ip' => '185.123.45.67',
            'private_ip' => '10.0.0.5',
            'created_at' => '۱۴۰۳/۰۹/۱۵',
            'vcpu' => 4,
            'ram' => 8,
            'ram_used' => 4.2,
            'storage' => 80,
            'storage_used' => 35,
            'cpu_usage' => 23,
            'floating_ips' => [
                ['ip' => '185.123.45.67', 'attached' => true]
            ],
            'security_groups' => [
                ['name' => 'پیش‌فرض', 'rules' => 'SSH (22), HTTP (80), HTTPS (443)']
            ],
            'volumes' => [
                ['id' => 'main', 'name' => 'حجم اصلی', 'size' => 80, 'type' => 'SSD', 'attached' => true]
            ],
            'snapshots' => [
                ['id' => 'snapshot-1', 'name' => 'Snapshot قبل از به‌روزرسانی', 'date' => '۱۴۰۳/۰۹/۲۰', 'size' => 80]
            ],
            'bandwidth' => [
                'used' => 285,
                'limit' => 2048, // 2TB
                'inbound' => 120,
                'outbound' => 165
            ]
        ];

        return view('customer.servers.show', compact('server'));
    }
}

