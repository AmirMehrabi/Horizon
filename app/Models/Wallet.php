<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this wallet.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get all transactions for this wallet.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get formatted balance.
     */
    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 0) . ' ' . $this->currency;
    }

    /**
     * Add amount to wallet (credit).
     */
    public function credit(float $amount, string $description = null, string $paymentMethod = null, string $referenceType = null, string $referenceId = null, array $metadata = []): WalletTransaction
    {
        return \DB::transaction(function () use ($amount, $description, $paymentMethod, $referenceType, $referenceId, $metadata) {
            $balanceBefore = $this->balance;
            $this->increment('balance', $amount);
            $balanceAfter = $this->balance;

            return WalletTransaction::create([
                'wallet_id' => $this->id,
                'customer_id' => $this->customer_id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description ?? 'Wallet topup',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'payment_method' => $paymentMethod,
                'status' => 'completed',
                'metadata' => $metadata,
            ]);
        });
    }

    /**
     * Deduct amount from wallet (debit).
     */
    public function debit(float $amount, string $description = null, string $referenceType = null, string $referenceId = null, array $metadata = []): WalletTransaction
    {
        return \DB::transaction(function () use ($amount, $description, $referenceType, $referenceId, $metadata) {
            if ($this->balance < $amount) {
                throw new \Exception('Insufficient wallet balance.');
            }

            $balanceBefore = $this->balance;
            $this->decrement('balance', $amount);
            $balanceAfter = $this->balance;

            $transaction = WalletTransaction::create([
                'wallet_id' => $this->id,
                'customer_id' => $this->customer_id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description ?? 'Wallet deduction',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'status' => 'completed',
                'metadata' => $metadata,
            ]);

            // Check and notify for low balance after debit
            $this->checkAndNotifyLowBalance();

            return $transaction;
        });
    }

    /**
     * Check balance and create notification if low.
     */
    public function checkAndNotifyLowBalance(): void
    {
        $lowBalanceThreshold = 50000; // 50,000 Rials
        $veryLowBalanceThreshold = 0;

        // Refresh to get latest balance
        $this->refresh();
        $balance = $this->balance;

        // Check if we should notify (only if balance is low and we haven't notified recently)
        if ($balance <= $veryLowBalanceThreshold) {
            // Check if we already notified about zero balance in the last 24 hours
            $recentNotification = \App\Models\Notification::where('customer_id', $this->customer_id)
                ->where('type', \App\Models\Notification::TYPE_WALLET)
                ->where('title', 'موجودی کیف پول تمام شده است')
                ->where('created_at', '>', now()->subHours(24))
                ->exists();

            if (!$recentNotification) {
                \App\Models\Notification::createForCustomer(
                    $this->customer_id,
                    \App\Models\Notification::TYPE_WALLET,
                    'موجودی کیف پول تمام شده است',
                    'موجودی کیف پول شما تمام شده است. لطفاً برای ادامه استفاده از سرویس‌ها، کیف پول خود را شارژ کنید.',
                    'dollar',
                    '/wallet/topup',
                    ['balance' => $balance]
                );
            }
        } elseif ($balance < $lowBalanceThreshold && $balance > 0) {
            // Check if we already notified about low balance in the last 24 hours
            $recentNotification = \App\Models\Notification::where('customer_id', $this->customer_id)
                ->where('type', \App\Models\Notification::TYPE_WALLET)
                ->where('title', 'هشدار موجودی کم')
                ->where('created_at', '>', now()->subHours(24))
                ->exists();

            if (!$recentNotification) {
                \App\Models\Notification::createForCustomer(
                    $this->customer_id,
                    \App\Models\Notification::TYPE_WALLET,
                    'هشدار موجودی کم',
                    "موجودی کیف پول شما در حال اتمام است (" . number_format($balance, 0) . " ریال). برای ادامه استفاده از سرویس‌ها، کیف پول خود را شارژ کنید.",
                    'dollar',
                    '/wallet/topup',
                    ['balance' => $balance]
                );
            }
        }
    }

    /**
     * Get or create wallet for customer.
     */
    public static function getOrCreateForCustomer(string $customerId): self
    {
        return static::firstOrCreate(
            ['customer_id' => $customerId],
            ['balance' => 0, 'currency' => 'IRR']
        );
    }
}
