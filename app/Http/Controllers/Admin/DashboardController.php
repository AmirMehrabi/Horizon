<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Customer;
use App\Models\OpenStackInstance;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackFlavor;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Instance Statistics
        $instanceStats = [
            'total' => OpenStackInstance::where('status', '!=', 'deleted')->count(),
            'active' => OpenStackInstance::where('status', 'active')->count(),
            'stopped' => OpenStackInstance::where('status', 'stopped')->count(),
            'building' => OpenStackInstance::where('status', 'building')->count(),
            'pending' => OpenStackInstance::where('status', 'pending')->count(),
            'error' => OpenStackInstance::where('status', 'error')->count(),
        ];

        // Network Statistics
        $networkStats = [
            'total' => OpenStackNetwork::count(),
            'active' => OpenStackNetwork::where('status', 'ACTIVE')->count(),
            'private' => OpenStackNetwork::where('external', false)->where('status', 'ACTIVE')->count(),
            'public' => OpenStackNetwork::where('external', true)->where('status', 'ACTIVE')->count(),
        ];

        // Resource Capacity (calculated from active instances)
        $activeInstances = OpenStackInstance::where('status', 'active')
            ->with('flavor')
            ->get();

        $totalVcpus = 0;
        $totalRam = 0; // in MB
        $totalDisk = 0; // in GB

        foreach ($activeInstances as $instance) {
            if ($instance->flavor) {
                $totalVcpus += $instance->flavor->vcpus;
                $totalRam += $instance->flavor->ram;
                $totalDisk += $instance->flavor->disk;
            }
        }

        // Get max capacity from all flavors (assuming we have capacity limits)
        // For now, we'll use a multiplier of active resources as max capacity
        $maxVcpus = max($totalVcpus * 1.5, 1000); // At least 1000 or 1.5x current
        $maxRam = max($totalRam * 1.5, 1000000); // At least 1TB or 1.5x current (in MB)
        $maxDisk = max($totalDisk * 1.5, 10000); // At least 10TB or 1.5x current (in GB)

        $resourceCapacity = [
            'vcpus' => [
                'used' => $totalVcpus,
                'total' => $maxVcpus,
                'percentage' => $maxVcpus > 0 ? round(($totalVcpus / $maxVcpus) * 100, 2) : 0,
            ],
            'ram' => [
                'used' => $totalRam,
                'total' => $maxRam,
                'percentage' => $maxRam > 0 ? round(($totalRam / $maxRam) * 100, 2) : 0,
                'used_tb' => round($totalRam / 1024 / 1024, 2), // Convert MB to TB
                'total_tb' => round($maxRam / 1024 / 1024, 2),
            ],
            'disk' => [
                'used' => $totalDisk,
                'total' => $maxDisk,
                'percentage' => $maxDisk > 0 ? round(($totalDisk / $maxDisk) * 100, 2) : 0,
                'used_pb' => round($totalDisk / 1024 / 1024, 2), // Convert GB to PB (simplified)
                'total_pb' => round($maxDisk / 1024 / 1024, 2),
            ],
        ];

        // Revenue Metrics (from wallet transactions)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $previousPeriodStart = Carbon::now()->subDays(60);
        $previousPeriodEnd = $thirtyDaysAgo;

        $revenueTransactions = WalletTransaction::where('type', 'debit')
            ->where('status', 'completed')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->get();

        $previousRevenueTransactions = WalletTransaction::where('type', 'debit')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->get();

        $totalRevenue = $revenueTransactions->sum('amount');
        $previousRevenue = $previousRevenueTransactions->sum('amount');
        $revenueGrowth = $previousRevenue > 0 
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : 0;

        // Revenue breakdown by reference type
        $monthlyRevenue = $revenueTransactions
            ->where('reference_type', OpenStackInstance::class)
            ->filter(function ($transaction) {
                $metadata = $transaction->metadata ?? [];
                return ($metadata['billing_cycle'] ?? 'hourly') === 'monthly';
            })
            ->sum('amount');

        $hourlyRevenue = $revenueTransactions
            ->where('reference_type', OpenStackInstance::class)
            ->filter(function ($transaction) {
                $metadata = $transaction->metadata ?? [];
                return ($metadata['billing_cycle'] ?? 'hourly') === 'hourly';
            })
            ->sum('amount');

        $otherRevenue = $totalRevenue - $monthlyRevenue - $hourlyRevenue;

        // Customer Statistics
        $customerStats = [
            'total' => Customer::count(),
            'active' => Customer::active()->count(),
            'verified' => Customer::verified()->count(),
            'today_signups' => Customer::whereDate('created_at', Carbon::today())->count(),
            'week_signups' => Customer::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'month_signups' => Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'recent' => Customer::latest()->take(5)->with('openStackInstances')->get(),
        ];

        // Get unique regions from instances for hypervisor display
        $regions = OpenStackInstance::select('region', 'availability_zone')
            ->whereNotNull('region')
            ->distinct()
            ->get()
            ->groupBy('region')
            ->map(function ($group) {
                return $group->pluck('availability_zone')->unique()->values();
            });

        $stats = [
            'instances' => $instanceStats,
            'networks' => $networkStats,
            'resources' => $resourceCapacity,
            'revenue' => [
                'total' => $totalRevenue,
                'previous' => $previousRevenue,
                'growth' => $revenueGrowth,
                'monthly' => $monthlyRevenue,
                'hourly' => $hourlyRevenue,
                'other' => $otherRevenue,
            ],
            'customers' => $customerStats,
            'regions' => $regions,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
