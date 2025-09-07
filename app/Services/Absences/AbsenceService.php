<?php

namespace App\Services\Absences;

use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsenceService
{
    /**
     * Store a new absence
     */
    public function store(array $data): Absence
    {
        try {
            DB::beginTransaction();

            // Use provided status or default to 'pending'
            $status = $data['status'] ?? 'pending';

            $absence = Absence::create([
                'absence_date' => $data['absence_date'],
                'member_id' => $data['member_id'],
                'enterprise_id' => $data['enterprise_id'],
                'status' => $status,
                'reason' => $data['reason'] ?? null,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return $absence->load(['member', 'enterprise', 'creator']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}