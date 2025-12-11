<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OpenStackSecurityGroup extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'openstack_id',
        'name',
        'description',
        'rules',
        'region',
        'synced_at',
    ];

    protected $casts = [
        'rules' => 'array',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all instances using this security group.
     */
    public function instances(): BelongsToMany
    {
        return $this->belongsToMany(OpenStackInstance::class, 'openstack_instance_security_groups')
                    ->withTimestamps();
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}
