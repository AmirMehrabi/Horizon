<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OpenStackNetwork extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'openstack_networks';

    protected $fillable = [
        'openstack_id',
        'name',
        'description',
        'status',
        'admin_state_up',
        'shared',
        'external',
        'provider_network_type',
        'provider_segmentation_id',
        'provider_physical_network',
        'router_external',
        'availability_zones',
        'subnets',
        'region',
        'synced_at',
    ];

    protected $casts = [
        'admin_state_up' => 'boolean',
        'shared' => 'boolean',
        'external' => 'boolean',
        'router_external' => 'boolean',
        'provider_segmentation_id' => 'integer',
        'availability_zones' => 'array',
        'subnets' => 'array',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all subnets for this network.
     */
    public function subnets(): HasMany
    {
        return $this->hasMany(OpenStackSubnet::class, 'network_id');
    }

    /**
     * Get all instances connected to this network.
     */
    public function instances(): BelongsToMany
    {
        return $this->belongsToMany(OpenStackInstance::class, 'openstack_instance_networks')
                    ->withPivot(['fixed_ip', 'floating_ip', 'is_primary', 'subnet_id'])
                    ->withTimestamps();
    }

    /**
     * Check if network is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'ACTIVE' && $this->admin_state_up;
    }

    /**
     * Scope to get only active networks.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE')
                     ->where('admin_state_up', true);
    }

    /**
     * Scope to get external/public networks.
     */
    public function scopeExternal($query)
    {
        return $query->where('external', true);
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}
