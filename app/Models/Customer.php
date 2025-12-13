<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'company_name',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'status',
        'phone_verified_at',
        'last_login_at',
        'preferences',
        'notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'preferences' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Customer status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';

    /**
     * Get all available statuses.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending Verification',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_SUSPENDED => 'Suspended',
        ];
    }

    /**
     * Get the customer's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the formatted phone number.
     *
     * @return string
     */
    public function getFormattedPhoneAttribute(): string
    {
        // Format phone number (assuming international format)
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        
        if (strlen($phone) === 11 && substr($phone, 0, 1) === '1') {
            return '+1 (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7);
        }
        
        return $this->phone_number;
    }

    /**
     * Check if the customer is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the customer's phone is verified.
     *
     * @return bool
     */
    public function isPhoneVerified(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Mark the customer's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
            'status' => self::STATUS_ACTIVE,
        ])->save();
    }

    /**
     * Update the customer's last login timestamp.
     *
     * @return bool
     */
    public function updateLastLogin(): bool
    {
        return $this->forceFill([
            'last_login_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Scope a query to only include active customers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include verified customers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('phone_verified_at');
    }

    /**
     * Scope a query to search customers by name, phone, or email.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('phone_number', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%");
        });
    }

    /**
     * Get the OpenStack instances associated with the customer.
     */
    public function openStackInstances()
    {
        return $this->hasMany(OpenStackInstance::class, 'customer_id')
                    ->where('status', '!=', 'deleted');
    }

    /**
     * Get the key pairs associated with the customer.
     */
    public function openStackKeyPairs()
    {
        return $this->hasMany(OpenStackKeyPair::class, 'customer_id');
    }

    /**
     * Get the wallet associated with the customer.
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'customer_id');
    }

    /**
     * Get or create wallet for this customer.
     */
    public function getOrCreateWallet(): Wallet
    {
        return Wallet::getOrCreateForCustomer($this->id);
    }

    /**
     * Get the machines associated with the customer.
     * This is a placeholder for the machine relationship.
     * @deprecated Use openStackInstances() instead
     */
    public function machines()
    {
        // Legacy method for backward compatibility
        return $this->openStackInstances();
    }

    /**
     * Get customer statistics for dashboard.
     *
     * @return array
     */
    public function getStats(): array
    {
        $instances = $this->openStackInstances();
        
        // Get all instances for counting
        $allInstances = $instances->get();
        
        // Calculate total monthly cost from active instances
        $activeInstances = $allInstances->where('status', 'active');
        $totalMonthlyCost = $activeInstances->sum(function ($instance) {
            // If billing cycle is monthly, use monthly_cost, otherwise calculate from hourly
            if ($instance->billing_cycle === 'monthly') {
                return (float) ($instance->monthly_cost ?? 0);
            } else {
                // Convert hourly to monthly (approximate: hourly * 730)
                return (float) (($instance->hourly_cost ?? 0) * 730);
            }
        });
        
        // Count instances by status
        $statusCounts = $allInstances->groupBy('status')->map(function ($group) {
            return $group->count();
        });
        
        return [
            'total_machines' => $allInstances->count(),
            'active_machines' => $statusCounts['active'] ?? 0,
            'pending_machines' => $statusCounts['pending'] ?? 0,
            'building_machines' => $statusCounts['building'] ?? 0,
            'stopped_machines' => $statusCounts['stopped'] ?? 0,
            'error_machines' => $statusCounts['error'] ?? 0,
            'total_monthly_cost' => round($totalMonthlyCost, 2),
            'total_hourly_cost' => round($activeInstances->sum('hourly_cost'), 4),
            // CPU and memory usage would come from monitoring data (not available yet)
            'avg_cpu_usage' => 0, // Placeholder - would come from monitoring
            'avg_memory_usage' => 0, // Placeholder - would come from monitoring
            'bandwidth_used' => '0 GB', // Placeholder - would come from monitoring
        ];
    }
}
