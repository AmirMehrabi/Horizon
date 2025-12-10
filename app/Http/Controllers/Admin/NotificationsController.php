<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /**
     * Show the notifications index page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.notifications.index');
    }

    /**
     * Show the email templates page.
     *
     * @return View
     */
    public function emailTemplates(): View
    {
        return view('admin.notifications.email-templates');
    }

    /**
     * Show the SMS/Telegram notifications page.
     *
     * @return View
     */
    public function smsTelegram(): View
    {
        return view('admin.notifications.sms-telegram');
    }

    /**
     * Show the account alerts page.
     *
     * @return View
     */
    public function accountAlerts(): View
    {
        return view('admin.notifications.account-alerts');
    }

    /**
     * Show the admin alerts page.
     *
     * @return View
     */
    public function adminAlerts(): View
    {
        return view('admin.notifications.admin-alerts');
    }
}

