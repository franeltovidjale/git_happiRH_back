<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model
 *
 * Represents a user in the HappyHR system
 *
 * @property int $id
 * @property string|null $photo
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string $email unique
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $type User type: admin|normal|employer|employee
 * @property bool $is_deletable
 * @property int|null $active_enterprise_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read Enterprise|null $activeEnterprise
 * @property-read \Illuminate\Database\Eloquent\Collection|Enterprise[] $enterprises
 * @property-read \Illuminate\Database\Eloquent\Collection|Member[] $members
 * @property-read \Illuminate\Database\Eloquent\Collection|Enterprise[] $memberEnterprises
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const TYPE_USER = 'user';

    public const TYPE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'photo',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'email_verified_at',
        'is_deletable',
        'active_enterprise_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_deletable' => 'boolean',
    ];

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the active enterprise for this user.
     */
    public function activeEnterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'active_enterprise_id');
    }

    /**
     * Get all memberships for this user.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all enterprises where this user is a member (employee or owner).
     */
    public function enterprises(): BelongsToMany
    {
        return $this->belongsToMany(Enterprise::class, 'members')
            ->withTimestamps();
    }

    /**
     * Get enterprises owned by this user.
     */
    public function myEnterprises(): HasMany
    {
        return $this->hasMany(Enterprise::class, 'owner_id');
    }
}
