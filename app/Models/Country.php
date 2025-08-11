<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Country Model
 *
 * Represents a country in the HappyHR system
 *
 * @property int $id
 * @property string $name Country name (unique, max 32)
 * @property string $flag Flag image path (flags/[lower-case-country-code].png)
 * @property string $code Country code (unique)
 * @property bool $active Whether the country is active
 * @property string $lang Default language for the country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Langue[] $languages
 */
class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'flag',
        'code',
        'active',
        'lang',
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
     * Get the languages associated with this country.
     *
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Langue::class, 'country_code', 'code');
    }
}