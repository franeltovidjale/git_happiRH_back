<?php

namespace App\Enums;

enum EnterpriseOptionKey: string
{
    case StartWorkTime = 'startWorkTime';
    case EndWorkTime = 'endWorkTime';
    case WorkDays = 'workDays';
    case RestStartTime = 'restStartTime';
    case RestEndTime = 'restEndTime';

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
            self::RestStartTime => 'Début de la pause (heure)',
            self::RestEndTime => 'Fin de la pause (heure)',
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
            self::RestStartTime => 'Début de la pause (heure)',
            self::RestEndTime => 'Fin de la pause (heure)',
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
            self::RestStartTime => 'time',
            self::RestEndTime => 'time',
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
            self::RestStartTime->value => ['required', 'date_format:H:i'],
            self::RestEndTime->value => ['required', 'date_format:H:i'],
        ];
    }
}
