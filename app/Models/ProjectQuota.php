<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectQuota extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_quotas';

    protected $fillable = [
        'project_id',
        'instances',
        'cores',
        'ram',
        'volumes',
        'gigabytes',
        'snapshots',
        'floating_ips',
        'networks',
        'subnets',
        'routers',
        'security_groups',
        'security_group_rules',
        'load_balancers',
        'listeners',
        'pools',
        'synced_at',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the project that owns this quota.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
