<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenStackSyncJob extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'openstack_sync_jobs';

    protected $fillable = [
        'resource_type',
        'status',
        'started_at',
        'completed_at',
        'records_synced',
        'records_created',
        'records_updated',
        'records_deleted',
        'errors_count',
        'errors',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'records_synced' => 'integer',
        'records_created' => 'integer',
        'records_updated' => 'integer',
        'records_deleted' => 'integer',
        'errors_count' => 'integer',
        'errors' => 'array',
        'metadata' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if job is running.
     */
    public function isRunning(): bool
    {
        return $this->status === 'running';
    }

    /**
     * Check if job is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if job failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Scope to filter by resource type.
     */
    public function scopeForResourceType($query, string $resourceType)
    {
        return $query->where('resource_type', $resourceType);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
