<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpenStackFlavor extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'openstack_flavors';

    protected $fillable = [
        'openstack_id',
        'name',
        'description',
        'vcpus',
        'ram',
        'disk',
        'ephemeral_disk',
        'swap',
        'is_public',
        'is_disabled',
        'extra_specs',
        'pricing_hourly',
        'pricing_monthly',
        'region',
        'synced_at',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_disabled' => 'boolean',
        'vcpus' => 'integer',
        'ram' => 'integer',
        'disk' => 'integer',
        'ephemeral_disk' => 'integer',
        'swap' => 'integer',
        'extra_specs' => 'array',
        'pricing_hourly' => 'decimal:4',
        'pricing_monthly' => 'decimal:2',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all instances using this flavor.
     */
    public function instances(): HasMany
    {
        return $this->hasMany(OpenStackInstance::class, 'flavor_id');
    }

    /**
     * Check if flavor is available.
     */
    public function isAvailable(): bool
    {
        return $this->is_public && !$this->is_disabled;
    }

    /**
     * Get formatted RAM in GB.
     */
    public function getRamInGbAttribute(): float
    {
        return round($this->ram / 1024, 2);
    }

    /**
     * Scope to get only available flavors.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_public', true)
                     ->where('is_disabled', false);
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}
