<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Projects\StoreProjectRequest;
use App\Http\Requests\Api\Employer\Projects\UpdateProjectRequest;
use App\Services\Projects\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {}

    /**
     * Store a newly created project
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->store($request->validated());

            return $this->created('Projet créé avec succès', [
                'project' => $project,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création du projet', null, $e->getMessage());
        }
    }

    /**
     * Update the specified project
     */
    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        try {
            $project = $this->projectService->update($id, $request->validated());

            return $this->ok('Projet mis à jour avec succès', [
                'project' => $project,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour du projet', null, $e->getMessage());
        }
    }
}
