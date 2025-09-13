<?php

namespace App\Enums;

enum EnterpriseOptionKey: string
{
    case StartWorkTime = 'startWorkTime';
    case EndWorkTime = 'endWorkTime';
    case WorkDays = 'workDays';
    case RestMinute = 'restMinute';

    /**
     * Get all enum values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get enum label
     */
    public function label(): string
    {
        return match ($this) {
            self::StartWorkTime => 'Heure de début de travail',
            self::EndWorkTime => 'Heure de fin de travail',
            self::WorkDays => 'Jours de travail',
            self::RestMinute => 'Minutes de pause',
        };
    }

    /**
     * Get enum description
     */
    public function description(): string
    {
        return match ($this) {
            self::StartWorkTime => 'Heure de début standard',
            self::EndWorkTime => 'Heure de fin standard',
            self::WorkDays => 'Vos jours de travail',
            self::RestMinute => 'Durée de la pause en minutes',
        };
    }

    /**
     * Get enum type
     */
    public function type(): string
    {
        return match ($this) {
            self::StartWorkTime, self::EndWorkTime => 'time',
            self::WorkDays => 'array',
            self::RestMinute => 'number',
        };
    }

    /**
     * Get validation rules for the option key
     */
    public static function rules(): array
    {
        return [
            self::StartWorkTime->value => ['required', 'date_format:H:i'],
            self::EndWorkTime->value => ['required', 'date_format:H:i'],
            self::WorkDays->value => ['required', 'array'],
            self::RestMinute->value => ['required', 'integer', 'min:30'],
        ];
    }
}
