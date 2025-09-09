<?php

namespace App\Enums;

enum DemandeAbsenceType: string
{
    case LEAVE = 'leave';
    case ABSENCE = 'absence';
    case HOLIDAY = 'holiday';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::LEAVE => 'Congé',
            self::ABSENCE => 'Absence',
            self::HOLIDAY => 'Jour férié',
        };
    }
}
