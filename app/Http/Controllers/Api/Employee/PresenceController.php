<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Services\Presences\PresenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function __construct(
        private PresenceService $presenceService
    ) {}

    /**
     * Store a newly created presence
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $presence = $this->presenceService->store($request->all());

            return $this->created('Présence créée avec succès', [
                'presence' => $presence->load(['user:id,name,email']),
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la création de la présence', null, $e->getMessage());
        }
    }
}
