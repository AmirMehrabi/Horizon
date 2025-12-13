<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BackupSettings extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_id',
        'enabled',
        'schedule',
        'time',
        'retention_days',
        'last_backup_at',
        'last_backup_status',
        'next_backup_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'retention_days' => 'integer',
        'last_backup_at' => 'datetime',
        'next_backup_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns these settings.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Calculate and set the next backup time based on schedule and time.
     */
    public function calculateNextBackupTime(): void
    {
        if (!$this->enabled) {
            $this->next_backup_at = null;
            return;
        }

        $time = $this->time ? Carbon::parse($this->time)->format('H:i') : '02:00';
        $now = Carbon::now();

        switch ($this->schedule) {
            case 'hourly':
                $next = $now->copy()->startOfHour()->addHour();
                break;
            case 'daily':
                $next = $now->copy()->setTimeFromTimeString($time);
                if ($next->lte($now)) {
                    $next->addDay();
                }
                break;
            case 'weekly':
                $next = $now->copy()->setTimeFromTimeString($time);
                if ($next->lte($now)) {
                    $next->addWeek();
                }
                break;
            case 'monthly':
                $next = $now->copy()->setTimeFromTimeString($time)->day(1);
                if ($next->lte($now)) {
                    $next->addMonth();
                }
                break;
            default:
                $next = $now->copy()->addDay();
        }

        $this->next_backup_at = $next;
    }

    /**
     * Get or create backup settings for a customer.
     */
    public static function getOrCreateForCustomer(string $customerId): self
    {
        return static::firstOrCreate(
            ['customer_id' => $customerId],
            [
                'enabled' => false,
                'schedule' => 'daily',
                'time' => '02:00',
                'retention_days' => 30,
            ]
        );
    }
}
