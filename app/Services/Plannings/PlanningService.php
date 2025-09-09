<?php

namespace App\Services\Plannings;

use App\Models\Planning;
use Illuminate\Support\Facades\DB;

class PlanningService
{
    /**
     * Store a new planning
     */
    public function store(array $data): Planning
    {
        try {
            DB::beginTransaction();

            // Use provided status or default to 'scheduled'
            $status = $data['status'] ?? 'scheduled';

            $planning = Planning::create([
                'creator_id' => auth()->id(),
                'assignee_id' => $data['assignee_id'],
                'date_and_time' => $data['date_and_time'],
                'address' => $data['address'],
                'task_id' => $data['task_id'] ?? null,
                'status' => $status,
                'description' => $data['description'] ?? null,
            ]);

            DB::commit();

            return $planning->load(['creator', 'assignee', 'task']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
