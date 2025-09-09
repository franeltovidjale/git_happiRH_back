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
            'enterprise_id' => activeEnterprise()->id,
        ]));
    }
}
