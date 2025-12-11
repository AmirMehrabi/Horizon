<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpenStackImage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'openstack_id',
        'name',
        'description',
        'status',
        'visibility',
        'disk_format',
        'container_format',
        'min_disk',
        'min_ram',
        'size',
        'checksum',
        'owner_id',
        'metadata',
        'region',
        'synced_at',
    ];

    protected $casts = [
        'min_disk' => 'integer',
        'min_ram' => 'integer',
        'size' => 'integer',
        'metadata' => 'array',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all instances using this image.
     */
    public function instances(): HasMany
    {
        return $this->hasMany(OpenStackInstance::class, 'image_id');
    }

    /**
     * Check if image is active and available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get formatted size in GB.
     */
    public function getSizeInGbAttribute(): ?float
    {
        return $this->size ? round($this->size / (1024 ** 3), 2) : null;
    }

    /**
     * Scope to get only active images.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter by visibility.
     */
    public function scopeVisible($query, string $visibility = 'public')
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}
