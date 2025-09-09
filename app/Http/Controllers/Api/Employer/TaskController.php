<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\Tasks\StoreTaskRequest;
use App\Http\Requests\Api\Employer\Tasks\UpdateTaskRequest;
use App\Services\Tasks\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    /**
     * Store a newly created task
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $this->taskService->store($request->validated());

            return $this->created('Tâche créée avec succès', [
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de la tâche', null, $e->getMessage());
        }
    }

    /**
     * Update the specified task
     */
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->update($id, $request->validated());

            return $this->ok('Tâche mise à jour avec succès', [
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de la tâche', null, $e->getMessage());
        }
    }

    /**
     * Remove the specified task
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->taskService->destroy($id);

            return $this->ok('Tâche supprimée avec succès');
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la suppression de la tâche', null, $e->getMessage());
        }
    }
}
