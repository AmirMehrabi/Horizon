<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\OpenStackInstance;
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
     * Show the customer dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $customer = Auth::guard('customer')->user();
        
        // Get customer statistics
        $stats = $customer->getStats();
        
        // Get wallet balance
        $wallet = $customer->getOrCreateWallet();
        
        // Get instances with relationships
        $instances = $customer->openStackInstances()
            ->with(['flavor', 'image'])
            ->where('status', '!=', 'deleted')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get active instances (for quick stats)
        $activeInstances = $instances->where('status', 'active')->take(5);
        
        // Get pending/building instances
        $pendingInstances = $instances->whereIn('status', ['pending', 'building'])->take(5);
        
        // Calculate bandwidth usage (placeholder - would come from monitoring)
        // For now, we'll use a placeholder or calculate from instance network usage if available
        $bandwidthLimit = 500; // GB - would come from customer plan
        $bandwidthUsed = 0; // GB - would come from monitoring
        $bandwidthUsage = [
            'used' => $bandwidthUsed,
            'limit' => $bandwidthLimit,
            'percentage' => $bandwidthLimit > 0 ? round(($bandwidthUsed / $bandwidthLimit) * 100, 1) : 0,
            'incoming' => 0, // GB - would come from monitoring
            'outgoing' => 0, // GB - would come from monitoring
        ];
        
        // Get recent invoices (placeholder - would come from invoice system)
        $recentInvoices = collect([]); // TODO: Implement invoice system
        
        // Get recent notifications (placeholder - would come from notification system)
        $recentNotifications = collect([
            // These would come from a notifications table
            // For now, we'll show empty or generate from instance events
        ]);
        
        // Generate notifications from instance status changes
        $instanceEvents = \App\Models\OpenStackInstanceEvent::whereIn('instance_id', $instances->pluck('id'))
            ->with('instance')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $notifications = $instanceEvents->map(function ($event) {
            $instance = $event->instance;
            $instanceName = $instance ? $instance->name : 'سرور';
            $type = match($event->event_type) {
                'active' => ['type' => 'technical', 'icon' => 'check', 'color' => 'green'],
                'error' => ['type' => 'technical', 'icon' => 'alert', 'color' => 'red'],
                'stopped' => ['type' => 'technical', 'icon' => 'pause', 'color' => 'yellow'],
                default => ['type' => 'technical', 'icon' => 'info', 'color' => 'blue'],
            };
            
            return [
                'id' => $event->id,
                'title' => $this->getEventTitle($event->event_type, $instanceName),
                'description' => $event->message ?? $this->getEventDescription($event->event_type, $instanceName),
                'type' => $type['type'],
                'icon' => $type['icon'],
                'color' => $type['color'],
                'time' => $event->created_at ? $event->created_at->diffForHumans() : 'نامشخص',
                'read' => false,
            ];
        });
        
        return view('customer.dashboard', compact(
            'customer',
            'stats',
            'wallet',
            'activeInstances',
            'pendingInstances',
            'bandwidthUsage',
            'recentInvoices',
            'notifications'
        ));
    }
    
    /**
     * Get event title for notification.
     */
    private function getEventTitle(string $eventType, string $instanceName): string
    {
        return match($eventType) {
            'active' => "سرور {$instanceName} آماده است",
            'error' => "خطا در سرور {$instanceName}",
            'stopped' => "سرور {$instanceName} متوقف شد",
            'building' => "در حال راه‌اندازی {$instanceName}",
            default => "به‌روزرسانی سرور {$instanceName}",
        };
    }
    
    /**
     * Get event description for notification.
     */
    private function getEventDescription(string $eventType, string $instanceName): string
    {
        return match($eventType) {
            'active' => "سرور {$instanceName} با موفقیت راه‌اندازی شد و آماده استفاده است",
            'error' => "خطایی در راه‌اندازی یا عملکرد سرور {$instanceName} رخ داده است",
            'stopped' => "سرور {$instanceName} متوقف شده است",
            'building' => "سرور {$instanceName} در حال راه‌اندازی است",
            default => "وضعیت سرور {$instanceName} تغییر کرد",
        };
    }
}
