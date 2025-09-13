<?php

namespace App\Services\Presences;

use App\Enums\PresenceStatus;
use App\Models\Presence;
use App\Models\WorkingHour;
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
        $currentWeekday = strtolower($now->format('l')); // monday, tuesday, etc.

        // Vérifier si l'utilisateur a des heures de travail définies pour aujourd'hui
        $workingHours = $this->getTodayWorkingHours($currentWeekday);

        if ($workingHours->isEmpty()) {
            throw new \Exception('Aucune heure de travail définie pour ' . $currentWeekday . '. Vous ne pouvez pas pointer aujourd\'hui.');
        }

        // Vérifier si l'heure actuelle correspond à une période de travail
        $isWithinWorkingHours = $this->isWithinWorkingHours($currentTime, $workingHours);

        if (!$isWithinWorkingHours) {
            throw new \Exception('Vous ne pouvez pointer que pendant vos heures de travail définies.');
        }

        // Vérifier s'il existe déjà une présence pour aujourd'hui
        $existingPresence = Presence::where('member_id', member()->id)
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

        // Déterminer le statut basé sur l'heure d'arrivée et les heures de travail
        $status = $this->determinePresenceStatus($currentTime, $workingHours);

        return Presence::create(array_merge($data, [
            'member_id' => member()->id,
            'enterprise_id' => activeEnterprise()->id,
            'presence_date' => $currentDate,
            'check_in_time' => $currentTime,
            'status' => $status,
        ]));
    }

    /**
     * Get working hours for today's weekday
     */
    private function getTodayWorkingHours(string $weekday): \Illuminate\Database\Eloquent\Collection
    {
        return WorkingHour::where('member_id', member()->id)
            ->where('enterprise_id', activeEnterprise()->id)
            ->where('weekday', $weekday)
            ->where('active', true)
            ->orderBy('start_hour')
            ->get();
    }

    /**
     * Check if current time is within any working hour period
     */
    private function isWithinWorkingHours(string $currentTime, \Illuminate\Database\Eloquent\Collection $workingHours): bool
    {
        foreach ($workingHours as $workingHour) {
            $startTime = $workingHour->start_hour->format('H:i:s');
            $endTime = $workingHour->end_hour->format('H:i:s');

            if ($currentTime >= $startTime && $currentTime <= $endTime) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine presence status based on check-in time and working hours
     */
    private function determinePresenceStatus(string $checkInTime, \Illuminate\Database\Eloquent\Collection $workingHours): PresenceStatus
    {
        // Trouver la première période de travail de la journée (généralement le matin)
        $firstWorkingPeriod = $workingHours->first();

        if (!$firstWorkingPeriod) {
            return PresenceStatus::Present;
        }

        $expectedStartTime = $firstWorkingPeriod->start_hour->format('H:i:s');

        // Tolérance de 15 minutes de retard
        $lateThreshold = Carbon::createFromFormat('H:i:s', $expectedStartTime)
            ->addMinutes(15)
            ->format('H:i:s');

        // Si l'heure d'arrivée est après le seuil de tolérance, marquer comme retard
        if ($checkInTime > $lateThreshold) {
            return PresenceStatus::Late;
        }

        return PresenceStatus::Present;
    }
}
