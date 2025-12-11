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
        return $this->hasMany(OpenStackInstance::class, 'customer_id');
    }

    /**
     * Get the key pairs associated with the customer.
     */
    public function openStackKeyPairs()
    {
        return $this->hasMany(OpenStackKeyPair::class, 'customer_id');
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
        $machines = $this->machines();
        
        return [
            'total_machines' => $machines->count(),
            'active_machines' => $machines->where('status', 'active')->count(),
            'avg_cpu_usage' => round($machines->avg('cpu_usage'), 1),
            'avg_memory_usage' => round($machines->avg('memory_usage'), 1),
            'total_monthly_cost' => 156.75, // Dummy data
            'bandwidth_used' => '2.3 TB', // Dummy data
        ];
    }
}
