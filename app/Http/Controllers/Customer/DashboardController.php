<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the customer dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $customer = Auth::guard('customer')->user();
        $machines = $customer->machines();
        $stats = $customer->getStats();

        return view('customer.dashboard', compact('customer', 'machines', 'stats'));
    }
}
