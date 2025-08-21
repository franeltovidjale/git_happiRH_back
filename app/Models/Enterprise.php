<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Enterprise Model
 *
 * @property int $id
 * @property string|null $ifu
 * @property string $name
 * @property bool $active
 * @property string $code
 * @property int $owner_id
 * @property int $sector_id
 * @property string $country_code
 * @property string|null $address
 * @property string|null $logo
 * @property string|null $zip_code
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property string $status
 * @property string|null $status_note
 * @property \Carbon\Carbon|null $status_date
 * @property int $status_by
 * @property array|null $status_stories
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read User $owner
 * @property-read Sector $sector
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employees
 * @property-read \Illuminate\Database\Eloquent\Collection|Department[] $departments
 * @property-read \Illuminate\Database\Eloquent\Collection|Location[] $locations
 */
class Enterprise extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_STORIES = [
        self::STATUS_PENDING => self::STATUS_PENDING,
        self::STATUS_ACTIVE => self::STATUS_ACTIVE,
        self::STATUS_INACTIVE => self::STATUS_INACTIVE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ifu',
        'name',
        'active',
        'code',
        'owner_id',
        'sector_id',
        'country_code',
        'address',
        'logo',
        'zip_code',
        'email',
        'phone',
        'website',
        'status',
        'status_note',
        'status_date',
        'status_by',
        'status_stories',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'country_code' => 'string',
        'status' => 'string',
        'status_date' => 'datetime',
        'status_by' => 'integer',
        'status_stories' => 'array',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($enterprise) {
            if (empty($enterprise->code)) {
                $enterprise->code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique alphanumeric code for the enterprise.
     *
     * @return string
     */
    protected static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    /**
     * Get the owner of the enterprise.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the employees of the enterprise.
     *
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get the departments of the enterprise.
     *
     * @return HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the locations of the enterprise.
     *
     * @return HasMany
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the sector of the enterprise.
     *
     * @return BelongsTo
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /**
     * Get the logo URL attribute.
     *
     * @return string
     */
    public function getLogoAttribute($value): string
    {
        if (!empty($value)) {
            return asset('storage/' . $value);
        }

        return asset('empty-image.png');
    }
}