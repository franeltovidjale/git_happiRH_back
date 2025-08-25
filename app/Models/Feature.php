<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Feature Model
 *
 * @property int $id
 * @property string $name
 * @property string $criteria
 * @property string $criteria_type
 * @property string|null $criteria_value
 * @property string|null $description
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Plan[] $plans
 */
class Feature extends Model
{
    use HasFactory;

    public const TYPE_LIMIT = 'limit';

    public const TYPE_BOOLEAN = 'boolean';

    public const TYPE_FEATURE = 'feature';

    public const TYPE_TEXT = 'text';

    public const CRITERIA_TYPES = [
        self::TYPE_LIMIT => self::TYPE_LIMIT,
        self::TYPE_BOOLEAN => self::TYPE_BOOLEAN,
        self::TYPE_FEATURE => self::TYPE_FEATURE,
        self::TYPE_TEXT => self::TYPE_TEXT,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'criteria',
        'criteria_type',
        'criteria_value',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the plans that have this feature.
     */
    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'feature_plan')
            ->withPivot(['is_enabled'])
            ->withTimestamps();
    }
}
