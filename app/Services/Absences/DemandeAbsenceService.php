<?php

namespace App\Services\Absences;

use App\Enums\AbsenceStatus;
use App\Models\DemandeAbsence;
use Illuminate\Support\Facades\DB;

class DemandeAbsenceService
{
    /**
     * Get paginated list of demandes absences for the current enterprise
     */
    public function paginate(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DemandeAbsence::query()
            ->where('enterprise_id', activeEnterprise()->id)
            ->with(['member.user', 'creator.user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Change the status of a demande absence
     */
    public function changeStatus(int $demandeAbsenceId, array $data): DemandeAbsence
    {
        DB::beginTransaction();
        try {
            $demandeAbsence = DemandeAbsence::where('id', $demandeAbsenceId)
                ->where('enterprise_id', activeEnterprise()->id)
                ->firstOrFail();

            $demandeAbsence->update([
                'status' => $data['status'],
                'reason' => $data['reason'] ?? $demandeAbsence->reason,
            ]);

            DB::commit();

            return $demandeAbsence->load(['member.user', 'enterprise', 'creator.user']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Store a new demande absence
     */
    public function store(array $data): DemandeAbsence
    {
        DB::beginTransaction();
        try {
            // Verify that the member belongs to the current enterprise
            if (!isMemberPartOfEnterprise($data['member_id'])) {
                throw new \InvalidArgumentException('Le membre spécifié ne fait pas partie de l\'entreprise courante.');
            }

            // Use provided status or default to 'pending'
            $status = $data['status'] ?? AbsenceStatus::APPROVED;

            $demandeAbsence = DemandeAbsence::create([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'type' => $data['type'],
                'member_id' => $data['member_id'],
                'enterprise_id' => activeEnterprise()->id,
                'status' => $status,
                'reason' => $data['reason'] ?? null,
                'description' => $data['description'] ?? null,
                'creator_member_id' => member()->getId(),
            ]);

            DB::commit();

            return $demandeAbsence->load(['member.user', 'enterprise', 'creator.user']);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
