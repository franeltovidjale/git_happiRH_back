<?php

namespace App\Http\Controllers\Api\Employer;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\Employer\Departements\StoreDepartmentRequest;
use App\Http\Requests\Api\Employer\Departements\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();
            $departments = $enterprise->departments()
                ->withCount('members')
                ->orderBy('name')
                ->get();


            return $this->ok('Liste des départements récupérée avec succès', DepartmentResource::collection($departments));
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->serverError('Erreur lors de la récupération des départements');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->getActiveEnterprise();

            $slug = Str::slug($request->name);

            $department = Department::create([
                'enterprise_id' => $enterprise->id,
                'name' => $request->name,
                'active' => $request->boolean('active', true),
                'slug' => $slug,
                'late_penalty' => $request->boolean('late_penalty', false),
                'work_model' => $request->work_model,
                'meeting_participation_score' => $request->boolean('meeting_participation_score', false),
                'attendance_score' => $request->boolean('attendance_score', false),
                'overtime_recording_score' => $request->overtime_recording_score,
                'overtime_clocking_score' => $request->overtime_clocking_score,
                'supervisor_id' => $request->supervisor_id,
            ]);

            DB::commit();

            return $this->created('Département créé avec succès', new DepartmentResource($department));
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
            return $this->serverError('Erreur lors de la création du département');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            $department = Department::with(['enterprise', 'members.user', 'supervisor.user'])
                ->where('enterprise_id', $enterprise->id)
                ->where('id', $id)
                ->firstOrFail();
            return $this->ok('Département récupéré avec succès', new DepartmentResource($department));
        } catch (\Exception $e) {
            Log::error($e);
            if ($e instanceof ModelNotFoundException) {
                return $this->notFound('Département introuvable');
            }
            return $this->serverError('Erreur lors de la récupération du département');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $enterprise = $this->getActiveEnterprise();

            $department = Department::where('enterprise_id', $enterprise->id)
                ->where('id', $id)
                ->firstOrFail();

            $department->update([
                'name' => $request->name ?? $department->name,
                'active' => $request->boolean('active', $department->active),
                'late_penalty' => $request->boolean('late_penalty', $department->late_penalty),
                'work_model' => $request->work_model ?? $department->work_model,
                'meeting_participation_score' => $request->boolean('meeting_participation_score', $department->meeting_participation_score),
                'attendance_score' => $request->boolean('attendance_score', $department->attendance_score),
                'overtime_recording_score' => $request->overtime_recording_score ?? $department->overtime_recording_score,
                'overtime_clocking_score' => $request->overtime_clocking_score ?? $department->overtime_clocking_score,
                'supervisor_id' => $request->supervisor_id ?? $department->supervisor_id,
            ]);

            DB::commit();

            return $this->ok('Département mis à jour avec succès', new DepartmentResource($department));
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
            return $this->serverError('Erreur lors de la mise à jour du département');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {

            $enterprise = $this->getActiveEnterprise();

            $department = Department::where('enterprise_id', $enterprise->id)
                ->where('id', $id)
                ->firstOrFail();

            // Check if department has members
            if ($department->members()->count() > 0) {
                return $this->badRequest('Impossible de supprimer un département qui contient des employés');
            }

            $department->delete();

            DB::commit();


            return $this->ok('Département supprimé avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            if ($e instanceof ModelNotFoundException) {
                return $this->notFound('Département introuvable');
            }
            logger()->error($e);
            return $this->serverError('Erreur lors de la suppression du département');
        }
    }
}
