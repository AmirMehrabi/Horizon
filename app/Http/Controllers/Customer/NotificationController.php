<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notifications for dropdown (AJAX)
     */
    public function getNotifications()
    {
        // Dummy notifications
        $notifications = [
            [
                'id' => 1,
                'title' => 'صورتحساب جدید',
                'description' => 'صورتحساب ماهانه شما آماده است',
                'type' => 'billing',
                'type_icon' => 'dollar',
                'time' => '۵ دقیقه پیش',
                'read' => false
            ],
            [
                'id' => 2,
                'title' => 'پشتیبان‌گیری تکمیل شد',
                'description' => 'Snapshot سرور شما با موفقیت ایجاد شد',
                'type' => 'technical',
                'type_icon' => 'check',
                'time' => '۱ ساعت پیش',
                'read' => false
            ],
            [
                'id' => 3,
                'title' => 'پاسخ به تیکت شما',
                'description' => 'پشتیبانی به تیکت #1001 پاسخ داد',
                'type' => 'support',
                'type_icon' => 'message',
                'time' => '۲ ساعت پیش',
                'read' => false
            ],
            [
                'id' => 4,
                'title' => 'هشدار امنیتی',
                'description' => 'ورود از IP جدید شناسایی شد',
                'type' => 'security',
                'type_icon' => 'shield',
                'time' => '۳ ساعت پیش',
                'read' => true
            ],
            [
                'id' => 5,
                'title' => 'شارژ کیف پول',
                'description' => 'موجودی کیف پول شما به‌روزرسانی شد',
                'type' => 'billing',
                'type_icon' => 'dollar',
                'time' => '۱ روز پیش',
                'read' => true
            ]
        ];

        $unreadCount = count(array_filter($notifications, fn($n) => !$n['read']));

        return response()->json([
            'notifications' => array_slice($notifications, 0, 5),
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Display all notifications
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        // Dummy notifications
        $allNotifications = [
            [
                'id' => 1,
                'title' => 'صورتحساب جدید',
                'description' => 'صورتحساب ماهانه شما آماده است. لطفاً برای مشاهده و پرداخت به بخش صورتحساب مراجعه کنید.',
                'type' => 'billing',
                'type_label' => 'صورتحساب',
                'type_icon' => 'dollar',
                'time' => '۵ دقیقه پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۴:۲۵',
                'read' => false
            ],
            [
                'id' => 2,
                'title' => 'پشتیبان‌گیری تکمیل شد',
                'description' => 'Snapshot سرور "وب سرور اصلی" شما با موفقیت ایجاد شد.',
                'type' => 'technical',
                'type_label' => 'فنی',
                'type_icon' => 'check',
                'time' => '۱ ساعت پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۳:۳۰',
                'read' => false
            ],
            [
                'id' => 3,
                'title' => 'پاسخ به تیکت شما',
                'description' => 'پشتیبانی به تیکت #1001 شما پاسخ داد. لطفاً برای مشاهده پاسخ به بخش تیکت‌ها مراجعه کنید.',
                'type' => 'support',
                'type_label' => 'پشتیبانی',
                'type_icon' => 'message',
                'time' => '۲ ساعت پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۲:۳۰',
                'read' => false
            ],
            [
                'id' => 4,
                'title' => 'هشدار امنیتی',
                'description' => 'ورود به حساب شما از IP جدید (185.123.45.67) شناسایی شد. در صورت عدم اطلاع، لطفاً رمز عبور خود را تغییر دهید.',
                'type' => 'security',
                'type_label' => 'امنیت',
                'type_icon' => 'shield',
                'time' => '۳ ساعت پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۱:۳۰',
                'read' => true
            ],
            [
                'id' => 5,
                'title' => 'شارژ کیف پول',
                'description' => 'موجودی کیف پول شما به مبلغ 1,000,000 ریال شارژ شد.',
                'type' => 'billing',
                'type_label' => 'صورتحساب',
                'type_icon' => 'dollar',
                'time' => '۱ روز پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۱ - ۱۴:۰۰',
                'read' => true
            ],
            [
                'id' => 6,
                'title' => 'به‌روزرسانی سیستم',
                'description' => 'به‌روزرسانی‌های جدید برای سرور شما در دسترس است.',
                'type' => 'technical',
                'type_label' => 'فنی',
                'type_icon' => 'info',
                'time' => '۲ روز پیش',
                'timestamp' => '۱۴۰۳/۱۰/۲۰ - ۱۰:۰۰',
                'read' => true
            ]
        ];

        // Filter notifications
        $notifications = match($filter) {
            'unread' => array_filter($allNotifications, fn($n) => !$n['read']),
            'billing' => array_filter($allNotifications, fn($n) => $n['type'] === 'billing'),
            'technical' => array_filter($allNotifications, fn($n) => $n['type'] === 'technical'),
            'security' => array_filter($allNotifications, fn($n) => $n['type'] === 'security'),
            default => $allNotifications
        };

        $unreadCount = count(array_filter($allNotifications, fn($n) => !$n['read']));

        return view('customer.notifications.index', compact('notifications', 'filter', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        // TODO: Implement mark as read logic
        return response()->json(['success' => true]);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        // TODO: Implement mark all as read logic
        return redirect()->route('customer.notifications.index')
            ->with('success', 'همه اعلان‌ها به عنوان خوانده شده علامت‌گذاری شدند');
    }
}


