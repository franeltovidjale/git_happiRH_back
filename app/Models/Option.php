<?php

namespace App\Models;

use App\Enums\EnterpriseOptionKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Option Model
 *
 * @property int $id
 * @property int $enterprise_id
 * @property string $key Machine-readable identifier for the option
 * @property string|null $value Stored value of the option
 * @property bool $editable Determines if the option can be changed
 * @property string $type Type of option: "input", "textarea", "number", "boolean", "array", etc.
 * @property string|null $label Human-readable label for display purposes
 * @property string|null $description Detailed explanation or usage notes for the option
 * @property array|null $options Available options for the option (for select, array types)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Enterprise $enterprise
 */
class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enterprise_id',
        'key',
        'value',
        'type',
        'label',
        'description',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'key' => EnterpriseOptionKey::class,
    ];

    /**
     * Get the enterprise that owns the option.
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * Retrieve an option value by key for a specific enterprise
     *
     * @param  mixed  $default
     * @return mixed
     */
    public static function getOption(int $enterpriseId, EnterpriseOptionKey $key, $default = null)
    {
        $option = static::where('enterprise_id', $enterpriseId)
            ->where('key', $key->value)
            ->first();

        if (! $option) {
            return $default;
        }

        return static::parseValue($option->value, $option->type);
    }



    /**
     * Parse a value based on its type
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected static function parseValue($value, string $type)
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float', 'double' => (float) $value,
            'array' => is_array($value) ? $value : json_decode($value, true),
            default => $value,
        };
    }

    public function getValueAttribute($value)
    {
        return self::parseValue($value, $this->type);
    }

    /**
     * Scope to filter by enterprise
     */
    public function scopeForEnterprise($query, int $enterpriseId)
    {
        return $query->where('enterprise_id', $enterpriseId);
    }
}
