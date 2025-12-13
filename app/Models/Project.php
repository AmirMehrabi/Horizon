<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $fillable = [
        'customer_id',
        'name',
        'description',
        'openstack_project_id',
        'openstack_domain_id',
        'status',
        'sync_status',
        'sync_error',
        'synced_at',
        'region',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Project status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_DELETED = 'deleted';

    /**
     * Sync status constants.
     */
    const SYNC_STATUS_PENDING = 'pending';
    const SYNC_STATUS_SYNCING = 'syncing';
    const SYNC_STATUS_SYNCED = 'synced';
    const SYNC_STATUS_ERROR = 'error';

    /**
     * Get the customer that owns this project.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the quota for this project.
     */
    public function quota(): HasOne
    {
        return $this->hasOne(ProjectQuota::class, 'project_id');
    }

    /**
     * Get the users assigned to this project.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
                    ->withPivot('role', 'openstack_role_id')
                    ->withTimestamps();
    }

    /**
     * Get the OpenStack instances in this project.
     */
    public function instances(): HasMany
    {
        return $this->hasMany(OpenStackInstance::class, 'openstack_project_id', 'openstack_project_id')
                    ->whereNotNull('openstack_project_id');
    }

    /**
     * Get all available statuses.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_SUSPENDED => 'Suspended',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

    /**
     * Get all available sync statuses.
     *
     * @return array
     */
    public static function getSyncStatuses(): array
    {
        return [
            self::SYNC_STATUS_PENDING => 'Pending',
            self::SYNC_STATUS_SYNCING => 'Syncing',
            self::SYNC_STATUS_SYNCED => 'Synced',
            self::SYNC_STATUS_ERROR => 'Error',
        ];
    }

    /**
     * Check if the project is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the project is synced.
     *
     * @return bool
     */
    public function isSynced(): bool
    {
        return $this->sync_status === self::SYNC_STATUS_SYNCED;
    }

    /**
     * Get resource usage statistics.
     *
     * @return array
     */
    public function getResourceUsage(): array
    {
        $quota = $this->quota;
        if (!$quota) {
            return [
                'instances' => ['used' => 0, 'total' => 0, 'percentage' => 0],
                'cores' => ['used' => 0, 'total' => 0, 'percentage' => 0],
                'ram' => ['used' => 0, 'total' => 0, 'percentage' => 0],
                'gigabytes' => ['used' => 0, 'total' => 0, 'percentage' => 0],
                'floating_ips' => ['used' => 0, 'total' => 0, 'percentage' => 0],
                'networks' => ['used' => 0, 'total' => 0, 'percentage' => 0],
            ];
        }

        // Get actual usage from instances
        $instances = $this->instances()->get();
        $usedCores = 0;
        $usedRam = 0;
        $usedGigabytes = 0;

        foreach ($instances as $instance) {
            if ($instance->flavor) {
                $usedCores += $instance->flavor->vcpus;
                $usedRam += $instance->flavor->ram;
                $usedGigabytes += $instance->flavor->disk;
            }
        }

        return [
            'instances' => [
                'used' => $instances->count(),
                'total' => $quota->instances,
                'percentage' => $quota->instances > 0 ? round(($instances->count() / $quota->instances) * 100, 2) : 0,
            ],
            'cores' => [
                'used' => $usedCores,
                'total' => $quota->cores,
                'percentage' => $quota->cores > 0 ? round(($usedCores / $quota->cores) * 100, 2) : 0,
            ],
            'ram' => [
                'used' => $usedRam,
                'total' => $quota->ram,
                'percentage' => $quota->ram > 0 ? round(($usedRam / $quota->ram) * 100, 2) : 0,
                'used_gb' => round($usedRam / 1024, 2),
                'total_gb' => round($quota->ram / 1024, 2),
            ],
            'gigabytes' => [
                'used' => $usedGigabytes,
                'total' => $quota->gigabytes,
                'percentage' => $quota->gigabytes > 0 ? round(($usedGigabytes / $quota->gigabytes) * 100, 2) : 0,
            ],
            'floating_ips' => [
                'used' => 0, // TODO: Calculate from networks
                'total' => $quota->floating_ips,
                'percentage' => 0,
            ],
            'networks' => [
                'used' => 0, // TODO: Calculate from networks
                'total' => $quota->networks,
                'percentage' => 0,
            ],
        ];
    }

    /**
     * Scope a query to only include active projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include synced projects.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSynced($query)
    {
        return $query->where('sync_status', self::SYNC_STATUS_SYNCED);
    }

    /**
     * Scope a query to search projects by name or customer.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('customer', function ($customerQuery) use ($search) {
                  $customerQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('company_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }
}
