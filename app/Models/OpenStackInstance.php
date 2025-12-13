<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpenStackInstance extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'openstack_instances';

    protected $fillable = [
        'customer_id',
        'name',
        'description',
        'openstack_server_id',
        'openstack_project_id',
        'status',
        'flavor_id',
        'image_id',
        'key_pair_id',
        'root_password_hash', // Encrypted password (not hashed)
        'user_data',
        'config_drive',
        'region',
        'availability_zone',
        'metadata',
        'auto_billing',
        'billing_cycle',
        'hourly_cost',
        'monthly_cost',
        'billing_started_at',
        'last_billed_at',
        'ip_addresses',
        'synced_at',
        'last_openstack_status',
    ];

    protected $casts = [
        'config_drive' => 'boolean',
        'auto_billing' => 'boolean',
        'metadata' => 'array',
        'ip_addresses' => 'array',
        'hourly_cost' => 'decimal:4',
        'monthly_cost' => 'decimal:2',
        'billing_started_at' => 'datetime',
        'last_billed_at' => 'datetime',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this instance.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the flavor for this instance.
     */
    public function flavor(): BelongsTo
    {
        return $this->belongsTo(OpenStackFlavor::class, 'flavor_id');
    }

    /**
     * Get the image for this instance.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(OpenStackImage::class, 'image_id');
    }

    /**
     * Get the key pair for this instance.
     */
    public function keyPair(): BelongsTo
    {
        return $this->belongsTo(OpenStackKeyPair::class, 'key_pair_id');
    }

    /**
     * Get all networks attached to this instance.
     */
    public function networks(): BelongsToMany
    {
        return $this->belongsToMany(OpenStackNetwork::class, 'openstack_instance_networks', 'instance_id', 'network_id')
                    ->withPivot(['fixed_ip', 'floating_ip', 'is_primary', 'subnet_id'])
                    ->withTimestamps();
    }

    /**
     * Get all security groups attached to this instance.
     */
    public function securityGroups(): BelongsToMany
    {
        return $this->belongsToMany(OpenStackSecurityGroup::class, 'openstack_instance_security_groups', 'instance_id', 'security_group_id')
                    ->withTimestamps();
    }

    /**
     * Get all events for this instance.
     */
    public function events(): HasMany
    {
        return $this->hasMany(OpenStackInstanceEvent::class, 'instance_id')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Check if instance is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if instance is building.
     */
    public function isBuilding(): bool
    {
        return $this->status === 'building';
    }

    /**
     * Check if instance is in error state.
     */
    public function isError(): bool
    {
        return $this->status === 'error';
    }

    /**
     * Get primary network.
     */
    public function getPrimaryNetworkAttribute()
    {
        return $this->networks()->wherePivot('is_primary', true)->first();
    }

    /**
     * Get public IP addresses.
     */
    public function getPublicIpsAttribute(): array
    {
        return $this->ip_addresses['public'] ?? [];
    }

    /**
     * Get private IP addresses.
     */
    public function getPrivateIpsAttribute(): array
    {
        return $this->ip_addresses['private'] ?? [];
    }

    /**
     * Scope to filter by customer.
     */
    public function scopeForCustomer($query, string $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope to get active instances.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to exclude deleted instances.
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
