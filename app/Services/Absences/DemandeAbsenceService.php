<?php

namespace App\Services\Absences;

use App\Enums\AbsenceStatus;
use App\Models\DemandeAbsence;
use Illuminate\Support\Facades\DB;

class DemandeAbsenceService
{
    /**
     * Store a new demande absence
     */
    public function store(array $data): DemandeAbsence
    {
        DB::beginTransaction();
        try {

            // Use provided status or default to 'pending'
            $status = $data['status'] ?? AbsenceStatus::APPROVED;

            $demandeAbsence = DemandeAbsence::create([
                'absence_date' => $data['absence_date'],
                'member_id' => $data['member_id'],
                'enterprise_id' => activeEnterprise()->id,
                'status' => $status,
                'reason' => $data['reason'] ?? null,
                'creator_member_id' => member()->getId(),
            ]);

            DB::commit();

            return $demandeAbsence->load(['member', 'enterprise', 'creator']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
