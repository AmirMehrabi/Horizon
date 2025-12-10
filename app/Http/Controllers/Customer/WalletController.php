<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display wallet dashboard
     */
    public function index()
    {
        // Dummy data for demonstration
        $wallet = [
            'balance' => 1245000, // in Rials
            'currency' => 'ریال',
            'formatted_balance' => '1,245,000 ریال',
        ];

        $paymentMethods = [
            [
                'id' => 1,
                'type' => 'card',
                'masked' => '•••• •••• •••• 1234',
                'status' => 'default',
                'label' => 'کارت بانکی •••• 1234'
            ],
            [
                'id' => 2,
                'type' => 'mobile_money',
                'masked' => '•••• 5678',
                'status' => 'available',
                'label' => 'موبایل •••• 5678'
            ]
        ];

        $transactions = [
            [
                'id' => 1,
                'date' => '۱۴۰۳/۱۰/۲۲ - ۱۴:۲۲',
                'description' => 'شارژ کیف پول با کارت',
                'amount' => 1000000,
                'amount_formatted' => '+1,000,000 ریال',
                'status' => 'موفق',
                'status_color' => 'green'
            ],
            [
                'id' => 2,
                'date' => '۱۴۰۳/۱۰/۲۱ - ۱۰:۰۳',
                'description' => 'پرداخت تمدید ماشین مجازی',
                'amount' => -230000,
                'amount_formatted' => '-230,000 ریال',
                'status' => 'تکمیل شده',
                'status_color' => 'blue'
            ],
            [
                'id' => 3,
                'date' => '۱۴۰۳/۱۰/۲۰ - ۱۶:۴۵',
                'description' => 'شارژ کیف پول با کارت',
                'amount' => 500000,
                'amount_formatted' => '+500,000 ریال',
                'status' => 'موفق',
                'status_color' => 'green'
            ],
            [
                'id' => 4,
                'date' => '۱۴۰۳/۱۰/۱۹ - ۰۹:۱۵',
                'description' => 'پرداخت خرید سرور جدید',
                'amount' => -450000,
                'amount_formatted' => '-450,000 ریال',
                'status' => 'تکمیل شده',
                'status_color' => 'blue'
            ],
            [
                'id' => 5,
                'date' => '۱۴۰۳/۱۰/۱۸ - ۱۴:۳۰',
                'description' => 'شارژ کیف پول با کارت',
                'amount' => 2000000,
                'amount_formatted' => '+2,000,000 ریال',
                'status' => 'موفق',
                'status_color' => 'green'
            ]
        ];

        return view('customer.wallet.index', compact('wallet', 'paymentMethods', 'transactions'));
    }

    /**
     * Display wallet topup page
     */
    public function topup()
    {
        // Dummy data
        $currentBalance = 1245000;
        $paymentMethods = [
            'کارت بانکی •••• 1234',
            'کارت بانکی •••• 9981',
            'درگاه پرداخت زرین‌پال',
            'درگاه پرداخت نکست‌پی'
        ];

        return view('customer.wallet.topup', compact('currentBalance', 'paymentMethods'));
    }

    /**
     * Get wallet balance for AJAX requests (for navbar indicator)
     */
    public function getBalance()
    {
        // Dummy data
        return response()->json([
            'balance' => 1245000,
            'formatted_balance' => '1,245,000 ریال',
            'currency' => 'ریال'
        ]);
    }
}

