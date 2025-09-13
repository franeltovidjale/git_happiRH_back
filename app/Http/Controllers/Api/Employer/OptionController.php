<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employer\UpdateOptionRequest;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use App\Services\OptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptionController extends Controller
{
    public function __construct(private OptionService $optionService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->ok(
                'Liste des options récupérée avec succès',
                OptionResource::collection($this->optionService->fetchList())
            );
        } catch (\Exception $e) {
            Log::error($e);

            return $this->serverError('Erreur lors de la récupération des options');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $key = $request->input('key');
        try {
            $option = $this->optionService->update($key, $request->input('value'));
            DB::commit();

            return $this->ok(
                'Option mise à jour avec succès',
                new OptionResource($option)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $this->notFound('Option non trouvée');
            }
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de l\'option');
        }
    }
}
