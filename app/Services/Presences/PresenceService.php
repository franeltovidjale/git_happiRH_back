<?php

namespace App\Services\Presences;

use App\Models\Presence;
use Illuminate\Database\Eloquent\Collection;

class PresenceService
{
    /**
     * Store a new presence record
     */
    public function store(array $data): Presence
    {
        return Presence::create(array_merge($data, [
            'enterprise_id' => auth()->user()->currentEnterprise->id,
        ]));
    }

    /**
     * Update an existing presence record
     */
    public function update(int $id, array $data): Presence
    {
        $presence = Presence::forEnterprise(auth()->user()->currentEnterprise->id)
            ->findOrFail($id);

        $presence->update($data);

        return $presence->fresh();
    }

    /**
     * Get presence records for a specific date range
     */
    public function getPresencesForDateRange(string $startDate, string $endDate): Collection
    {
        return Presence::forEnterprise(auth()->user()->currentEnterprise->id)
            ->dateRange($startDate, $endDate)
            ->with(['user:id,name,email'])
            ->orderBy('presence_date', 'desc')
            ->orderBy('user_id')
            ->get();
    }

    /**
     * Get presence records for a specific user
     */
    public function getUserPresences(int $userId, ?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = Presence::forEnterprise(auth()->user()->currentEnterprise->id)
            ->where('user_id', $userId)
            ->with(['user:id,name,email']);

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        return $query->orderBy('presence_date', 'desc')->get();
    }

    /**
     * Delete a presence record
     */
    public function delete(int $id): bool
    {
        $presence = Presence::forEnterprise(auth()->user()->currentEnterprise->id)
            ->findOrFail($id);

        return $presence->delete();
    }

}