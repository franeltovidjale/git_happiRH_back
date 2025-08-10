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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employees
 */
class Enterprise extends Model
{
    use HasFactory;

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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
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
}