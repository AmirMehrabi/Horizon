<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    /**
     * Show the billing dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.billing.index');
    }

    /**
     * Show the billing settings page.
     *
     * @return View
     */
    public function settings(): View
    {
        return view('admin.billing.settings');
    }

    /**
     * Show the pricing plans page.
     *
     * @return View
     */
    public function plans(): View
    {
        return view('admin.billing.plans');
    }

    /**
     * Show the create plan page.
     *
     * @return View
     */
    public function createPlan(): View
    {
        return view('admin.billing.create-plan');
    }

    /**
     * Show the usage metrics configuration page.
     *
     * @return View
     */
    public function usageMetrics(): View
    {
        return view('admin.billing.usage-metrics');
    }

    /**
     * Show the quota pricing page.
     *
     * @return View
     */
    public function quotas(): View
    {
        return view('admin.billing.quotas');
    }

    /**
     * Show the coupons page.
     *
     * @return View
     */
    public function coupons(): View
    {
        return view('admin.billing.coupons');
    }

    /**
     * Show the wallets page.
     *
     * @return View
     */
    public function wallets(): View
    {
        return view('admin.billing.wallets');
    }

    /**
     * Show the invoices page.
     *
     * @return View
     */
    public function invoices(): View
    {
        return view('admin.billing.invoices');
    }

    /**
     * Show the invoice detail page.
     *
     * @param string $id
     * @return View
     */
    public function showInvoice(string $id): View
    {
        return view('admin.billing.invoice-show', compact('id'));
    }

    /**
     * Show the transactions page.
     *
     * @return View
     */
    public function transactions(): View
    {
        return view('admin.billing.transactions');
    }

    /**
     * Show the payment gateways page.
     *
     * @return View
     */
    public function paymentGateways(): View
    {
        return view('admin.billing.payment-gateways');
    }

    /**
     * Show the automations page.
     *
     * @return View
     */
    public function automations(): View
    {
        return view('admin.billing.automations');
    }

    /**
     * Show the credit system page.
     *
     * @return View
     */
    public function creditSystem(): View
    {
        return view('admin.billing.credit-system');
    }

    /**
     * Show the usage reports page.
     *
     * @return View
     */
    public function usageReports(): View
    {
        return view('admin.billing.usage-reports');
    }
}
