<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for dropdown (AJAX)
     */
    public function getNotifications()
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return response()->json([
                'notifications' => [],
                'unread_count' => 0
            ]);
        }

        $notifications = Notification::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'description' => $notification->description,
                    'type' => $notification->type,
                    'type_icon' => $notification->type_icon,
                    'time' => $notification->time_ago,
                    'read' => $notification->read,
                    'action_url' => $notification->action_url,
                ];
            });

        $unreadCount = Notification::where('customer_id', $customer->id)
            ->where('read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Display all notifications
     */
    public function index(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $filter = $request->get('filter', 'all');

        $query = Notification::where('customer_id', $customer->id);

        // Apply filters
        switch ($filter) {
            case 'unread':
                $query->where('read', false);
                break;
            case 'billing':
                $query->where('type', Notification::TYPE_BILLING);
                break;
            case 'technical':
                $query->where('type', Notification::TYPE_TECHNICAL);
                break;
            case 'security':
                $query->where('type', Notification::TYPE_SECURITY);
                break;
            case 'wallet':
                $query->where('type', Notification::TYPE_WALLET);
                break;
        }

        $notifications = $query->orderBy('created_at', 'desc')->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'description' => $notification->description,
                    'type' => $notification->type,
                    'type_label' => $notification->type_label,
                    'type_icon' => $notification->type_icon,
                    'time' => $notification->time_ago,
                    'timestamp' => $notification->created_at->format('Y/m/d - H:i'),
                    'read' => $notification->read,
                    'action_url' => $notification->action_url,
                ];
            });

        $unreadCount = Notification::where('customer_id', $customer->id)
            ->where('read', false)
            ->count();

        return view('customer.notifications.index', compact('notifications', 'filter', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $customer = Auth::guard('customer')->user();
        
        $notification = Notification::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        $customer = Auth::guard('customer')->user();
        
        Notification::where('customer_id', $customer->id)
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now(),
            ]);

        return redirect()->route('customer.notifications.index')
            ->with('success', 'همه اعلان‌ها به عنوان خوانده شده علامت‌گذاری شدند');
    }
}
