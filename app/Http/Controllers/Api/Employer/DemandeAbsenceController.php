<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Absences\StoreDemandeAbsenceRequest;
use App\Services\Absences\DemandeAbsenceService;
use Illuminate\Http\JsonResponse;

class DemandeAbsenceController extends Controller
{
    public function __construct(
        private DemandeAbsenceService $demandeAbsenceService
    ) {}

    /**
     * Store a newly created demande absence
     */
    public function store(StoreDemandeAbsenceRequest $request): JsonResponse
    {
        try {
            $demandeAbsence = $this->demandeAbsenceService->store($request->validated());

            return $this->created('Demande d\'absence créée avec succès', [
                'demande_absence' => $demandeAbsence,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de la demande d\'absence', null, $e->getMessage());
        }
    }
}
