<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Absences\ChangeStatusDemandeAbsenceRequest;
use App\Http\Requests\Api\Employer\Absences\StoreDemandeAbsenceRequest;
use App\Http\Resources\Api\Employer\DemandeAbsenceResource;
use App\Services\Absences\DemandeAbsenceService;
use Illuminate\Http\JsonResponse;

class DemandeAbsenceController extends Controller
{
    public function __construct(
        private DemandeAbsenceService $demandeAbsenceService
    ) {}

    /**
     * Display a paginated listing of demandes absences
     */
    public function index(): JsonResponse
    {
        try {
            $demandesAbsences = $this->demandeAbsenceService->paginate();

            $formattedData = [
                'items' => DemandeAbsenceResource::collection($demandesAbsences),
                'current_page' => $demandesAbsences->currentPage(),
                'per_page' => $demandesAbsences->perPage(),
                'total' => $demandesAbsences->total(),
                'last_page' => $demandesAbsences->lastPage(),
                'from' => $demandesAbsences->firstItem(),
                'to' => $demandesAbsences->lastItem(),
            ];

            return $this->ok('Liste des demandes d\'absence récupérée avec succès',  $formattedData);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la récupération des demandes d\'absence', null, $e->getMessage());
        }
    }

    /**
     * Store a newly created demande absence
     */
    public function store(StoreDemandeAbsenceRequest $request): JsonResponse
    {
        try {
            $demandeAbsence = $this->demandeAbsenceService->store($request->validated());

            return $this->created('Demande d\'absence créée avec succès', [
                'demande_absence' => new DemandeAbsenceResource($demandeAbsence),
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de la demande d\'absence', null, $e->getMessage());
        }
    }

    /**
     * Change the status of a demande absence
     */
    public function changeStatus(int $id, ChangeStatusDemandeAbsenceRequest $request): JsonResponse
    {
        try {
            $demandeAbsence = $this->demandeAbsenceService->changeStatus($id, $request->validated());

            return $this->ok('Statut de la demande d\'absence modifié avec succès', [
                'demande_absence' => new DemandeAbsenceResource($demandeAbsence),
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la modification du statut', null, $e->getMessage());
        }
    }
}
