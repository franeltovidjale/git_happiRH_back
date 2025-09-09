<?php

namespace App\Services\Absences;

use App\Enums\AbsenceStatus;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsenceService
{
    /**
     * Store a new absence
     */
    public function store(array $data): Absence
    {
        DB::beginTransaction();
        try {

            // Use provided status or default to 'pending'
            $status = $data['status'] ?? AbsenceStatus::APPROVED;

            $absence = Absence::create([
                'absence_date' => $data['absence_date'],
                'member_id' => $data['member_id'],
                'enterprise_id' => activeEnterprise()->id,
                'status' => $status,
                'reason' => $data['reason'] ?? null,
                'creator_member_id' => member()->getId(),
            ]);

            DB::commit();

            return $absence->load(['member', 'enterprise', 'creator']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
