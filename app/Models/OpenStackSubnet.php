<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpenStackSubnet extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'openstack_subnets';

    protected $fillable = [
        'openstack_id',
        'network_id',
        'name',
        'description',
        'cidr',
        'ip_version',
        'gateway_ip',
        'enable_dhcp',
        'dns_nameservers',
        'allocation_pools',
        'host_routes',
        'region',
        'synced_at',
    ];

    protected $casts = [
        'ip_version' => 'integer',
        'enable_dhcp' => 'boolean',
        'dns_nameservers' => 'array',
        'allocation_pools' => 'array',
        'host_routes' => 'array',
        'synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the network this subnet belongs to.
     */
    public function network(): BelongsTo
    {
        return $this->belongsTo(OpenStackNetwork::class, 'network_id');
    }

    /**
     * Scope to filter by region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope to filter by IP version.
     */
    public function scopeIpVersion($query, int $version)
    {
        return $query->where('ip_version', $version);
    }
}
