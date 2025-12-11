<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpenStackKeyPair extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_id',
        'openstack_id',
        'name',
        'public_key',
        'private_key',
        'fingerprint',
        'region',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'private_key', // Hide private key by default
    ];

    /**
     * Get the customer that owns this key pair.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get all instances using this key pair.
     */
    public function instances(): HasMany
    {
        return $this->hasMany(OpenStackInstance::class, 'key_pair_id');
    }

    /**
     * Scope to filter by customer.
     */
    public function scopeForCustomer($query, string $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}
