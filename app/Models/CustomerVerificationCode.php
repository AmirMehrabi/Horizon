<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CustomerVerificationCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'code',
        'type',
        'verified',
        'verified_at',
        'expires_at',
        'attempts',
        'max_attempts',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'expires_at' => 'datetime',
        'attempts' => 'integer',
        'max_attempts' => 'integer',
    ];

    /**
     * Code type constants.
     */
    const TYPE_REGISTRATION = 'registration';
    const TYPE_LOGIN = 'login';
    const TYPE_PASSWORD_RESET = 'password_reset';

    /**
     * Generate a new verification code for a phone number.
     *
     * @param string $phoneNumber
     * @param string $type
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return self
     */
    public static function generateCode(
        string $phoneNumber,
        string $type = self::TYPE_REGISTRATION,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): self {
        // Invalidate any existing unverified codes for this phone/type
        self::where('phone_number', $phoneNumber)
            ->where('type', $type)
            ->where('verified', false)
            ->update(['verified' => true, 'verified_at' => now()]);

        // Generate a 6-digit code
        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Create new verification code
        $verificationCode = self::create([
            'phone_number' => $phoneNumber,
            'code' => $code,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(15), // 15 minutes expiry
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        // Log the code for development (remove in production)
        Log::info("SMS Verification Code Generated", [
            'phone' => $phoneNumber,
            'code' => $code,
            'type' => $type,
            'expires_at' => $verificationCode->expires_at,
        ]);

        return $verificationCode;
    }

    /**
     * Verify a code for a phone number.
     *
     * @param string $phoneNumber
     * @param string $code
     * @param string $type
     * @return array
     */
    public static function verifyCode(
        string $phoneNumber,
        string $code,
        string $type = self::TYPE_REGISTRATION
    ): array {
        $verificationCode = self::where('phone_number', $phoneNumber)
            ->where('type', $type)
            ->where('verified', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$verificationCode) {
            return [
                'success' => false,
                'message' => 'No verification code found for this phone number.',
                'code' => null,
            ];
        }

        // Check if code has expired
        if ($verificationCode->isExpired()) {
            return [
                'success' => false,
                'message' => 'Verification code has expired. Please request a new one.',
                'code' => $verificationCode,
            ];
        }

        // Check if max attempts exceeded
        if ($verificationCode->hasExceededMaxAttempts()) {
            return [
                'success' => false,
                'message' => 'Maximum verification attempts exceeded. Please request a new code.',
                'code' => $verificationCode,
            ];
        }

        // Increment attempts
        $verificationCode->increment('attempts');

        // Check if code matches
        if ($verificationCode->code !== $code) {
            $remainingAttempts = $verificationCode->max_attempts - $verificationCode->attempts;
            
            return [
                'success' => false,
                'message' => "Invalid verification code. {$remainingAttempts} attempts remaining.",
                'code' => $verificationCode,
            ];
        }

        // Delete any existing verified codes for this phone/type to avoid unique constraint violation
        self::where('phone_number', $phoneNumber)
            ->where('type', $type)
            ->where('verified', true)
            ->where('id', '!=', $verificationCode->id)
            ->delete();

        // Mark as verified
        $verificationCode->update([
            'verified' => true,
            'verified_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Phone number verified successfully.',
            'code' => $verificationCode,
        ];
    }

    /**
     * Check if the code has expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if max attempts have been exceeded.
     *
     * @return bool
     */
    public function hasExceededMaxAttempts(): bool
    {
        return $this->attempts >= $this->max_attempts;
    }

    /**
     * Get remaining attempts.
     *
     * @return int
     */
    public function getRemainingAttempts(): int
    {
        return max(0, $this->max_attempts - $this->attempts);
    }

    /**
     * Scope to get active (unverified and not expired) codes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('verified', false)
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope to get expired codes for cleanup.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Clean up expired verification codes.
     * This should be run periodically via a scheduled job.
     *
     * @return int Number of deleted records
     */
    public static function cleanupExpired(): int
    {
        return self::expired()->delete();
    }
}
