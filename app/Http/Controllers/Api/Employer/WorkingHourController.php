<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Members\StoreWorkingHourRequest;
use App\Http\Requests\Api\Employer\Members\UpdateWorkingHourRequest;
use App\Http\Resources\WorkingHourResource;
use App\Services\WorkingHourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    public function __construct(
        private WorkingHourService $workingHourService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'member_id' => 'required|integer|exists:members,id',
        ]);
        try {
            $this->workingHourService->createDefaults($request->input('member_id'));
            $workingHours = $this->workingHourService->fetchList($request->all());

            return $this->ok('Liste des heures de travail récupérée avec succès', WorkingHourResource::collection($workingHours));
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la récupération des heures de travail');
        }
    }

    /**
     * Store a newly created working hour
     */
    public function store(StoreWorkingHourRequest $request): JsonResponse
    {
        try {
            $workingHour = $this->workingHourService->store($request->validated());

            return $this->created('Heure de travail créée avec succès', [
                'working_hour' => new WorkingHourResource($workingHour->load('member:id,code')),
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de l\'heure de travail', null, $e->getMessage());
        }
    }

    /**
     * Update the specified working hour
     */
    public function update(UpdateWorkingHourRequest $request, int $id): JsonResponse
    {
        try {
            $workingHour = $this->workingHourService->update($id, $request->validated());

            return $this->ok('Heure de travail mise à jour avec succès', [
                'working_hour' => new WorkingHourResource($workingHour->load('member:id,code')),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFound('Heure de travail non trouvée');
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de l\'heure de travail', null, $e->getMessage());
        }
    }
}
