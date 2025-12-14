<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomerApiKey extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_id',
        'name',
        'key',
        'permissions',
        'last_used_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'last_used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'key',
    ];

    /**
     * Get the customer that owns this API key.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Generate a new API key.
     */
    public static function generateKey(): string
    {
        return 'api_' . Str::random(40);
    }

    /**
     * Create a new API key for a customer.
     */
    public static function createForCustomer(string $customerId, string $name, array $permissions = ['read']): self
    {
        return self::create([
            'customer_id' => $customerId,
            'name' => $name,
            'key' => self::generateKey(),
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update last used timestamp.
     */
    public function markAsUsed(): bool
    {
        return $this->update(['last_used_at' => now()]);
    }

    /**
     * Check if key has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
