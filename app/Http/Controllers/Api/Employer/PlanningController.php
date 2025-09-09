<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Plannings\StorePlanningRequest;
use App\Services\Plannings\PlanningService;
use Illuminate\Http\JsonResponse;

class PlanningController extends Controller
{
    public function __construct(
        private PlanningService $planningService
    ) {}

    /**
     * Store a newly created planning
     */
    public function store(StorePlanningRequest $request): JsonResponse
    {
        try {
            $planning = $this->planningService->store($request->validated());

            return $this->created('Planning créé avec succès', [
                'planning' => $planning,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création du planning', null, $e->getMessage());
        }
    }
}
