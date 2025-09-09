<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OTP Model
 *
 * Represents a one-time password in the HappyHR system
 *
 * @property int $id
 * @property string $identifier Email or phone number
 * @property string $code 6-digit OTP code
 * @property string $type Type of OTP (verification, reset_password)
 * @property \Illuminate\Support\Carbon $expires_at Expiration timestamp
 * @property bool $is_valid Whether the OTP is valid

 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Otp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'code',
        'type',
        'expires_at',
        'is_valid',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    /**
     * Generate a random 6-digit OTP code
     */
    public static function generateCode(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP for the given identifier
     *
     * @param  string  $identifier  Email or phone
     * @param  string  $type  OTP type
     * @param  int  $expiryMinutes  Minutes until expiry (default: 10)
     */
    public static function createForIdentifier(string $identifier, string $type = 'verification', int $expiryMinutes = 10): static
    {
        // Delete any existing OTPs for this identifier and type
        static::where('identifier', $identifier)
            ->where('type', $type)
            ->delete();

        return static::create([
            'identifier' => $identifier,
            'code' => static::generateCode(),
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes($expiryMinutes),
            'is_valid' => true,
        ]);
    }

    /**
     * Verify the OTP code for the given identifier
     *
     * @param  string  $identifier  Email or phone
     * @param  string  $code  OTP code
     * @param  string  $type  OTP type
     */
    public static function verify(string $identifier, string $code, string $type = 'verification'): bool
    {
        $otp = static::where('identifier', $identifier)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_valid', true)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otp) {
            $otp->delete();

            return true;
        }

        return false;
    }

    /**
     * Check if the OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Check if the OTP is valid (not expired and marked as valid)
     */
    public function isValid(): bool
    {
        return $this->is_valid && ! $this->isExpired();
    }
}
