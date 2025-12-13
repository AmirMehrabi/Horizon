<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackupSnapshot extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'instance_id',
        'name',
        'description',
        'openstack_snapshot_id',
        'openstack_server_id',
        'type',
        'status',
        'size',
        'size_unit',
        'completed_at',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'size' => 'integer',
        'metadata' => 'array',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this snapshot.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the instance this snapshot belongs to.
     */
    public function instance(): BelongsTo
    {
        return $this->belongsTo(OpenStackInstance::class, 'instance_id');
    }

    /**
     * Check if snapshot is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if snapshot is creating.
     */
    public function isCreating(): bool
    {
        return $this->status === 'creating';
    }

    /**
     * Check if snapshot has error.
     */
    public function hasError(): bool
    {
        return $this->status === 'error';
    }

    /**
     * Get formatted size.
     */
    public function getFormattedSizeAttribute(): string
    {
        if (!$this->size) {
            return 'N/A';
        }

        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Get status label in Persian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'creating' => 'در حال ایجاد',
            'available' => 'در دسترس',
            'error' => 'خطا',
            'deleting' => 'در حال حذف',
            'deleted' => 'حذف شده',
            default => 'نامشخص',
        };
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
     * Scope to get available snapshots.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
