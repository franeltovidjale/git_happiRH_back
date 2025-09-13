<?php

namespace App\Services\Presences;

use App\Enums\PresenceStatus;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresenceService
{
    /**
     * Store a new presence record based on current time and date
     */
    public function store(array $data = []): Presence
    {
        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i:s');

        // Vérifier s'il existe déjà une présence pour aujourd'hui
        $existingPresence = Presence::where('user_id', Auth::id())
            ->where('enterprise_id', activeEnterprise()->id)
            ->where('presence_date', $currentDate)
            ->first();

        if ($existingPresence) {
            // Si une présence existe déjà, mettre à jour l'heure de sortie
            if (! $existingPresence->check_out_time) {
                $existingPresence->update([
                    'check_out_time' => $currentTime,
                ]);
            }

            return $existingPresence;
        }

        // Déterminer le statut basé sur l'heure d'arrivée
        $status = $this->determinePresenceStatus($currentTime);

        return Presence::create(array_merge($data, [
            'member_id' => member()->id,
            'enterprise_id' => activeEnterprise()->id,
            'presence_date' => $currentDate,
            'check_in_time' => $currentTime,
            'status' => $status,
        ]));
    }

    /**
     * Determine presence status based on check-in time
     */
    private function determinePresenceStatus(string $checkInTime): PresenceStatus
    {
        // Heure de début standard (8h00)
        $standardStartTime = '08:00:00';

        // Si l'heure d'arrivée est après 8h00, marquer comme retard
        if ($checkInTime > $standardStartTime) {
            return PresenceStatus::Late;
        }

        return PresenceStatus::Present;
    }
}
