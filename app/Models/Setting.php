<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Setting Model
 *
 * @property int $id
 * @property string $key Machine-readable identifier for the setting
 * @property string|null $value Stored value of the setting
 * @property bool $editable Determines if the setting can be changed through the UI or API
 * @property string $type Type of setting: "input", "textarea", "number", "boolean", "array", etc.
 * @property string|null $label Human-readable label for display purposes
 * @property string|null $description Detailed explanation or usage notes for the setting
 * @property array|null $options Available options for the setting (for select, array types)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * Allowed setting keys
     *
     * @var array<string>
     */
    public const ALLOW_KEYS = [
        'logoPath',
        'appName',
        'authPasswordRequired',
        'authEnabledOtp',
        'signingCodeRequired',
        'autoLogoutDelay',
        'notifOnProjetUpdated',
        'notifOnAnnoncement',
        'notifOnCalendarEvent',
        'overtimeRequests',
        'leaveRequests',
        'securityAlerts',
        'specialOffers',
        'feedbackRequests',
        'defaultLang',
        'defaultTheme',
        'appDescription',
        'appSlogan',
        'workDays',
        'standardWorkingHours',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'editable',
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
        'editable' => 'boolean',
        'options' => 'array',
    ];

    /**
     * Retrieve a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getSetting(string $key, $default = null)
    {
        if (!static::isValidKey($key)) {
            return $default;
        }

        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return static::parseValue($setting->value, $setting->type);
    }

    /**
     * Save or update a setting by key
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function setSetting(string $key, $value): bool
    {
        if (!static::isValidKey($key)) {
            return false;
        }

        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return false;
        }

        $setting->value = static::formatValue($value, $setting->type);
        return $setting->save();
    }

    /**
     * Create or update a setting by key
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string|null $label
     * @param string|null $description
     * @param bool $editable
     * @return bool
     */
    public static function createOrUpdateSetting(
        string $key,
        $value,
        string $type = 'input',
        ?string $label = null,
        ?string $description = null,
        bool $editable = true
    ): bool {
        if (!static::isValidKey($key)) {
            return false;
        }

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => static::formatValue($value, $type),
                'type' => $type,
                'label' => $label,
                'description' => $description,
                'editable' => $editable,
            ]
        )->exists;
    }

    /**
     * Check if a key is valid
     *
     * @param string $key
     * @return bool
     */
    public static function isValidKey(string $key): bool
    {
        return in_array($key, static::ALLOW_KEYS);
    }

    /**
     * Get all valid keys
     *
     * @return array<string>
     */
    public static function getValidKeys(): array
    {
        return static::ALLOW_KEYS;
    }

    /**
     * Parse value based on setting type
     *
     * @param string|null $value
     * @param string $type
     * @return mixed
     */
    private static function parseValue($value, string $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (strpos($value, '.') !== false ? (float) $value : (int) $value) : $value;
            case 'array':
                return json_decode($value, true) ?? [];
            case 'input':
            case 'textarea':
            case 'string':
            default:
                return (string) $value;
        }
    }

    /**
     * Format value for storage based on setting type
     *
     * @param mixed $value
     * @param string $type
     * @return string
     */
    private static function formatValue($value, string $type): string
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'number':
                return (string) $value;
            case 'array':
                return json_encode($value);
            case 'input':
            case 'textarea':
            case 'string':
            default:
                return (string) $value;
        }
    }
}