<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display list of support tickets
     */
    public function index(Request $request)
    {
        // Dummy data for tickets
        $tickets = [
            [
                'id' => 1001,
                'title' => 'مشکل در اتصال به سرور',
                'status' => 'open',
                'status_label' => 'باز',
                'status_color' => 'green',
                'category' => 'فنی',
                'priority' => 'high',
                'priority_label' => 'بالا',
                'last_update' => '۱۴۰۳/۱۰/۲۲ - ۱۴:۳۰',
                'created_at' => '۱۴۰۳/۱۰/۲۲ - ۱۰:۱۵',
                'unread_messages' => 2
            ],
            [
                'id' => 1002,
                'title' => 'سوال درباره صورتحساب',
                'status' => 'answered',
                'status_label' => 'پاسخ داده شده',
                'status_color' => 'blue',
                'category' => 'مالی',
                'priority' => 'medium',
                'priority_label' => 'متوسط',
                'last_update' => '۱۴۰۳/۱۰/۲۱ - ۱۶:۴۵',
                'created_at' => '۱۴۰۳/۱۰/۲۰ - ۱۴:۲۰',
                'unread_messages' => 0
            ],
            [
                'id' => 1003,
                'title' => 'درخواست افزایش منابع',
                'status' => 'in_progress',
                'status_label' => 'در حال بررسی',
                'status_color' => 'yellow',
                'category' => 'سرویس‌ها',
                'priority' => 'high',
                'priority_label' => 'بالا',
                'last_update' => '۱۴۰۳/۱۰/۲۲ - ۰۹:۱۰',
                'created_at' => '۱۴۰۳/۱۰/۲۱ - ۱۱:۳۰',
                'unread_messages' => 1
            ],
            [
                'id' => 1004,
                'title' => 'مشکل در پشتیبان‌گیری',
                'status' => 'closed',
                'status_label' => 'بسته شده',
                'status_color' => 'gray',
                'category' => 'فنی',
                'priority' => 'low',
                'priority_label' => 'پایین',
                'last_update' => '۱۴۰۳/۱۰/۲۰ - ۱۵:۰۰',
                'created_at' => '۱۴۰۳/۱۰/۱۸ - ۱۰:۰۰',
                'unread_messages' => 0
            ],
            [
                'id' => 1005,
                'title' => 'سوال درباره امنیت',
                'status' => 'open',
                'status_label' => 'باز',
                'status_color' => 'green',
                'category' => 'امنیت',
                'priority' => 'medium',
                'priority_label' => 'متوسط',
                'last_update' => '۱۴۰۳/۱۰/۲۲ - ۱۲:۲۰',
                'created_at' => '۱۴۰۳/۱۰/۲۲ - ۱۲:۲۰',
                'unread_messages' => 0
            ]
        ];

        $categories = ['فنی', 'مالی', 'شبکه', 'سرویس‌ها', 'امنیت', 'سایر'];
        $statuses = ['open' => 'باز', 'in_progress' => 'در حال بررسی', 'answered' => 'پاسخ داده شده', 'closed' => 'بسته شده'];

        return view('customer.support.index', compact('tickets', 'categories', 'statuses'));
    }

    /**
     * Show create ticket form
     */
    public function create()
    {
        $categories = [
            ['value' => 'technical', 'label' => 'فنی'],
            ['value' => 'billing', 'label' => 'مالی'],
            ['value' => 'network', 'label' => 'شبکه'],
            ['value' => 'services', 'label' => 'سرویس‌ها'],
            ['value' => 'security', 'label' => 'امنیت'],
            ['value' => 'other', 'label' => 'سایر']
        ];

        $priorities = [
            ['value' => 'low', 'label' => 'پایین'],
            ['value' => 'medium', 'label' => 'متوسط'],
            ['value' => 'high', 'label' => 'بالا'],
            ['value' => 'urgent', 'label' => 'فوری']
        ];

        // Dummy servers list
        $servers = [
            ['id' => 1, 'name' => 'وب سرور اصلی'],
            ['id' => 2, 'name' => 'سرور پایگاه داده'],
            ['id' => 3, 'name' => 'سرور تست']
        ];

        return view('customer.support.create', compact('categories', 'priorities', 'servers'));
    }

    /**
     * Store new ticket
     */
    public function store(Request $request)
    {
        // TODO: Implement ticket creation logic
        return redirect()->route('customer.support.index')
            ->with('success', 'تیکت شما با موفقیت ایجاد شد');
    }

    /**
     * Show ticket details
     */
    public function show($id)
    {
        // Dummy ticket data
        $ticket = [
            'id' => $id,
            'title' => 'مشکل در اتصال به سرور',
            'status' => 'open',
            'status_label' => 'باز',
            'status_color' => 'green',
            'category' => 'فنی',
            'priority' => 'high',
            'priority_label' => 'بالا',
            'created_at' => '۱۴۰۳/۱۰/۲۲ - ۱۰:۱۵',
            'updated_at' => '۱۴۰۳/۱۰/۲۲ - ۱۴:۳۰',
            'server' => 'وب سرور اصلی'
        ];

        // Dummy messages
        $messages = [
            [
                'id' => 1,
                'sender' => 'user',
                'sender_name' => 'شما',
                'content' => 'سلام، من نمی‌توانم به سرور خود متصل شوم. لطفاً راهنمایی کنید.',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۰:۱۵',
                'attachments' => []
            ],
            [
                'id' => 2,
                'sender' => 'support',
                'sender_name' => 'پشتیبانی',
                'content' => 'سلام، لطفاً اطلاعات زیر را برای ما ارسال کنید:\n1. آدرس IP سرور\n2. پیام خطا (اگر وجود دارد)\n3. زمان دقیق مشکل',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۱:۳۰',
                'attachments' => []
            ],
            [
                'id' => 3,
                'sender' => 'user',
                'sender_name' => 'شما',
                'content' => 'اطلاعات درخواستی:\nIP: 185.123.45.67\nخطا: Connection timeout\nزمان: ۱۴۰۳/۱۰/۲۲ - ۱۰:۰۰',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۲:۰۰',
                'attachments' => [
                    ['name' => 'error-log.txt', 'size' => '2.5 KB']
                ]
            ],
            [
                'id' => 4,
                'sender' => 'support',
                'sender_name' => 'پشتیبانی',
                'content' => 'ممنون از اطلاعات. مشکل را بررسی کردیم و به نظر می‌رسد مشکل از فایروال باشد. لطفاً تنظیمات فایروال را بررسی کنید.',
                'timestamp' => '۱۴۰۳/۱۰/۲۲ - ۱۴:۳۰',
                'attachments' => []
            ]
        ];

        return view('customer.support.show', compact('ticket', 'messages'));
    }

    /**
     * Store reply to ticket
     */
    public function reply(Request $request, $id)
    {
        // TODO: Implement reply logic
        return redirect()->route('customer.support.show', $id)
            ->with('success', 'پاسخ شما ارسال شد');
    }

    /**
     * Close ticket
     */
    public function close($id)
    {
        // TODO: Implement close ticket logic
        return redirect()->route('customer.support.show', $id)
            ->with('success', 'تیکت بسته شد');
    }
}


