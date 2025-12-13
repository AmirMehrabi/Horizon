<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * Display wallet dashboard
     */
    public function index(Request $request)
    {
        $customer = $request->user('customer');
        $wallet = $customer->getOrCreateWallet();
        
        // Get recent transactions
        $transactions = WalletTransaction::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'date' => $transaction->created_at->format('Y/m/d - H:i'),
                    'description' => $transaction->description,
                    'amount' => $transaction->type === 'credit' ? $transaction->amount : -$transaction->amount,
                    'amount_formatted' => $transaction->formatted_amount,
                    'status' => $transaction->status === 'completed' ? 'موفق' : ($transaction->status === 'pending' ? 'در انتظار' : 'ناموفق'),
                    'status_color' => $transaction->status_color,
                ];
            });

        // Payment methods (empty for now as per user request)
        $paymentMethods = [];

        return view('customer.wallet.index', compact('wallet', 'paymentMethods', 'transactions'));
    }

    /**
     * Display wallet topup page
     */
    public function topup(Request $request)
    {
        $customer = $request->user('customer');
        $wallet = $customer->getOrCreateWallet();
        
        $currentBalance = $wallet->balance;
        
        // Only Test Payment method for now
        $paymentMethods = ['test_payment' => 'پرداخت تستی'];

        return view('customer.wallet.topup', compact('currentBalance', 'paymentMethods'));
    }

    /**
     * Process wallet topup
     */
    public function processTopup(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10000'],
            'payment_method' => ['required', 'string', 'in:test_payment'],
        ]);

        try {
            $customer = $request->user('customer');
            $wallet = $customer->getOrCreateWallet();
            
            $amount = (float) $request->input('amount');
            
            // Process test payment (immediate credit)
            if ($request->input('payment_method') === 'test_payment') {
                DB::beginTransaction();
                
                try {
                    $transaction = $wallet->credit(
                        $amount,
                        'شارژ کیف پول - پرداخت تستی',
                        'test_payment'
                    );
                    
                    DB::commit();
                    
                    // Create notification for wallet topup
                    Notification::createForCustomer(
                        $customer->id,
                        Notification::TYPE_WALLET,
                        'شارژ کیف پول',
                        "موجودی کیف پول شما به مبلغ " . number_format($amount, 0) . " ریال شارژ شد.",
                        'dollar',
                        route('customer.wallet.index'),
                        [
                            'transaction_id' => $transaction->id,
                            'amount' => $amount,
                            'balance_after' => $wallet->fresh()->balance,
                        ]
                    );
                    
                    Log::info('Wallet topup completed', [
                        'customer_id' => $customer->id,
                        'amount' => $amount,
                        'transaction_id' => $transaction->id,
                    ]);
                    
                    return redirect()->route('customer.wallet.index')
                        ->with('success', 'کیف پول شما با موفقیت شارژ شد.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
            
            return redirect()->back()
                ->withErrors(['error' => 'روش پرداخت نامعتبر است.']);
                
        } catch (\Exception $e) {
            Log::error('Wallet topup failed', [
                'customer_id' => $request->user('customer')->id ?? null,
                'error' => $e->getMessage(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'خطا در شارژ کیف پول: ' . $e->getMessage()]);
        }
    }

    /**
     * Get wallet balance for AJAX requests (for navbar indicator)
     */
    public function getBalance(Request $request)
    {
        $customer = $request->user('customer');
        $wallet = $customer->getOrCreateWallet();
        
        return response()->json([
            'balance' => $wallet->balance,
            'formatted_balance' => $wallet->formatted_balance,
            'currency' => $wallet->currency
        ]);
    }
}

