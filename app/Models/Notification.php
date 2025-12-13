<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notification extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'type',
        'title',
        'description',
        'type_icon',
        'read',
        'metadata',
        'action_url',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'read' => 'boolean',
        'metadata' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Notification type constants.
     */
    const TYPE_BILLING = 'billing';
    const TYPE_TECHNICAL = 'technical';
    const TYPE_SECURITY = 'security';
    const TYPE_SUPPORT = 'support';
    const TYPE_WALLET = 'wallet';

    /**
     * Get the customer that owns the notification.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get formatted time ago.
     */
    public function getTimeAgoAttribute(): string
    {
        $diff = $this->created_at->diffForHumans();
        
        // Convert to Persian if needed (simplified)
        $persian = [
            'seconds ago' => 'چند ثانیه پیش',
            'second ago' => 'یک ثانیه پیش',
            'minutes ago' => 'دقیقه پیش',
            'minute ago' => 'یک دقیقه پیش',
            'hours ago' => 'ساعت پیش',
            'hour ago' => 'یک ساعت پیش',
            'days ago' => 'روز پیش',
            'day ago' => 'یک روز پیش',
            'weeks ago' => 'هفته پیش',
            'week ago' => 'یک هفته پیش',
            'months ago' => 'ماه پیش',
            'month ago' => 'یک ماه پیش',
            'years ago' => 'سال پیش',
            'year ago' => 'یک سال پیش',
        ];
        
        foreach ($persian as $en => $fa) {
            if (str_contains($diff, $en)) {
                return str_replace($en, $fa, $diff);
            }
        }
        
        return $diff;
    }

    /**
     * Get type label in Persian.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_BILLING => 'صورتحساب',
            self::TYPE_TECHNICAL => 'فنی',
            self::TYPE_SECURITY => 'امنیت',
            self::TYPE_SUPPORT => 'پشتیبانی',
            self::TYPE_WALLET => 'کیف پول',
            default => 'عمومی',
        };
    }

    /**
     * Create a notification for a customer.
     */
    public static function createForCustomer(
        string $customerId,
        string $type,
        string $title,
        ?string $description = null,
        ?string $typeIcon = null,
        ?string $actionUrl = null,
        ?array $metadata = null
    ): self {
        return self::create([
            'customer_id' => $customerId,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'type_icon' => $typeIcon ?? self::getDefaultIconForType($type),
            'action_url' => $actionUrl,
            'metadata' => $metadata,
            'read' => false,
        ]);
    }

    /**
     * Get default icon for notification type.
     */
    public static function getDefaultIconForType(string $type): string
    {
        return match($type) {
            self::TYPE_BILLING, self::TYPE_WALLET => 'dollar',
            self::TYPE_SECURITY => 'shield',
            self::TYPE_SUPPORT => 'message',
            self::TYPE_TECHNICAL => 'check',
            default => 'info',
        };
    }

    /**
     * Scope to get unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope to get read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
