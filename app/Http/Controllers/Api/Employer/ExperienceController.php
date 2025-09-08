<?php

namespace App\Http\Controllers\Api\Employer;

use Illuminate\Http\JsonResponse;
use App\Services\ExperienceService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\Employer\Members\StoreExperienceRequest;
use App\Http\Requests\Api\Employer\Members\UpdateExperienceRequest;

class ExperienceController extends Controller
{
    public function __construct(
        private ExperienceService $experienceService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();
            $experience = $this->experienceService->store($request->validated(), $enterprise);

            return $this->created('Expérience créée avec succès', new ExperienceResource($experience));
        } catch (ModelNotFoundException $e) {
            return $this->notFound('Membre introuvable');
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de l\'expérience');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, int $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();
            $experience = $this->experienceService->update($request->validated(), $id, $enterprise);

            return $this->ok('Expérience mise à jour avec succès', new ExperienceResource($experience));
        } catch (ModelNotFoundException $e) {
            return $this->notFound('Expérience ou membre introuvable');
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de l\'expérience');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();
            $this->experienceService->delete($id, $enterprise);

            return $this->ok('Expérience supprimée avec succès');
        } catch (ModelNotFoundException $e) {
            return $this->notFound('Expérience introuvable');
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la suppression de l\'expérience');
        }
    }
}
