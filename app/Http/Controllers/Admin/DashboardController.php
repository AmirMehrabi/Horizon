<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Customer;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Laravel 12 uses different middleware registration
    }

    /**
     * Show the admin dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => Customer::count(),
            'active_customers' => Customer::active()->count(),
            'verified_customers' => Customer::verified()->count(),
            'recent_customers' => Customer::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
