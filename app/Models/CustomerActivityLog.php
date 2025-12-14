<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerActivityLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_id',
        'action',
        'ip_address',
        'user_agent',
        'location',
        'device',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this activity log.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Create a new activity log entry.
     */
    public static function log(
        string $customerId,
        string $action,
        string $status = 'success',
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?array $metadata = null
    ): self {
        $location = self::getLocationFromIp($ipAddress);
        $device = self::getDeviceFromUserAgent($userAgent);

        return self::create([
            'customer_id' => $customerId,
            'action' => $action,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'location' => $location,
            'device' => $device,
            'status' => $status,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get location from IP address (simplified - would use a service in production).
     */
    private static function getLocationFromIp(?string $ip): ?string
    {
        if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
            return 'محلی';
        }
        
        // In production, you would use a geolocation service
        // For now, return a generic location
        return 'نامشخص';
    }

    /**
     * Get device information from user agent.
     */
    private static function getDeviceFromUserAgent(?string $userAgent): ?string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        // Simple device detection
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            if (preg_match('/iPhone/i', $userAgent)) {
                return 'Safari on iOS';
            } elseif (preg_match('/Android/i', $userAgent)) {
                return 'Chrome on Android';
            }
            return 'Mobile Device';
        } elseif (preg_match('/Windows/i', $userAgent)) {
            return 'Chrome on Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            return 'Safari on macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            return 'Chrome on Linux';
        }

        return 'Unknown';
    }
}
