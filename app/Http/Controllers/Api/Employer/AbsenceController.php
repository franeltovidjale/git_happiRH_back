<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Absences\StoreAbsenceRequest;
use App\Services\Absences\AbsenceService;
use Illuminate\Http\JsonResponse;

class AbsenceController extends Controller
{
    public function __construct(
        private AbsenceService $absenceService
    ) {}

    /**
     * Store a newly created absence
     */
    public function store(StoreAbsenceRequest $request): JsonResponse
    {
        try {
            $absence = $this->absenceService->store($request->validated());

            return $this->created('Absence créée avec succès', [
                'absence' => $absence,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de l\'absence', null, $e->getMessage());
        }
    }
}