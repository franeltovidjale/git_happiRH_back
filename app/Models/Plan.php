<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Plan Model
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property float $price
 * @property string $currency
 * @property string $billing_cycle
 * @property bool $is_active
 * @property bool $is_recommended
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Feature[] $features
 * @property-read \Illuminate\Database\Eloquent\Collection|Enterprise[] $enterprises
 */
class Plan extends Model
{
    use HasFactory;

    public const BILLING_CYCLE_MONTHLY = 'monthly';

    public const BILLING_CYCLE_YEARLY = 'yearly';


    public const BILLING_CYCLES = [
        self::BILLING_CYCLE_MONTHLY => self::BILLING_CYCLE_MONTHLY,
        self::BILLING_CYCLE_YEARLY => self::BILLING_CYCLE_YEARLY,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'is_active',
        'is_recommended',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'currency' => 'string',
        'billing_cycle' => 'string',
        'is_active' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    /**
     * Get the features associated with this plan.
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'feature_plan')
            ->withPivot(['is_enabled'])
            ->withTimestamps();
    }

    /**
     * Get the enterprises using this plan.
     */
    public function enterprises(): HasMany
    {
        return $this->hasMany(Enterprise::class);
    }


    /**
     * Scope to get only active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}