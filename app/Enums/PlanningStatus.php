<?php

namespace App\Enums;

enum PlanningStatus: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case EXPIRED = 'expired';
    case SCHEDULED = 'scheduled';
    case UPDATE_COMING = 'update_coming';

    /**
     * Get all status values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get status label
     */
    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Approuvé',
            self::REJECTED => 'Rejeté',
            self::EXPIRED => 'Expiré',
            self::SCHEDULED => 'Planifié',
            self::UPDATE_COMING => 'Mise à jour à venir',
        };
    }
}
