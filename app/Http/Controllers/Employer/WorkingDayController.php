<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreWorkingDayRequest;
use App\Http\Requests\Employer\UpdateWorkingDayRequest;
use App\Models\WorkingDay;
use App\Models\Employee;
use App\Models\Enterprise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * WorkingDay Controller for Employer operations
 */
class WorkingDayController extends Controller
{
    /**
     * Display a listing of working days for the authenticated user's employees.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');
            $employeeIds = Employee::whereIn('enterprise_id', $enterpriseIds)->pluck('id');

            $workingDays = WorkingDay::whereIn('employee_id', $employeeIds)
                ->with(['employee.user', 'employee.enterprise'])
                ->get();

            return $this->successResponse($workingDays, 'Working days retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving working days: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve working days', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created working day.
     *
     * @param StoreWorkingDayRequest $request
     * @return JsonResponse
     */
    public function store(StoreWorkingDayRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $workingDay = WorkingDay::create([
                'employee_id' => $request->employee_id,
                'weekday' => $request->weekday,
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
                'active' => $request->active ?? true,
            ]);

            DB::commit();

            return $this->successResponse($workingDay->load(['employee.user', 'employee.enterprise']), 'Working day created successfully', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating working day: ' . $e->getMessage());
            return $this->errorResponse('Failed to create working day', 500);
        }
    }

    /**
     * Display the specified working day.
     *
     * @param WorkingDay $workingDay
     * @return JsonResponse
     */
    public function show(WorkingDay $workingDay): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            if (!$enterpriseIds->contains($workingDay->employee->enterprise_id)) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $workingDay->load(['employee.user', 'employee.enterprise']);

            return $this->successResponse($workingDay, 'Working day retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving working day: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve working day', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified working day.
     *
     * @param UpdateWorkingDayRequest $request
     * @param WorkingDay $workingDay
     * @return JsonResponse
     */
    public function update(UpdateWorkingDayRequest $request, WorkingDay $workingDay): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            if (!$enterpriseIds->contains($workingDay->employee->enterprise_id)) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $workingDay->update([
                'weekday' => $request->weekday,
                'start_hour' => $request->start_hour,
                'end_hour' => $request->end_hour,
                'active' => $request->active,
            ]);

            DB::commit();

            return $this->successResponse($workingDay->load(['employee.user', 'employee.enterprise']), 'Working day updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating working day: ' . $e->getMessage());
            return $this->errorResponse('Failed to update working day', 500);
        }
    }

    /**
     * Remove the specified working day.
     *
     * @param WorkingDay $workingDay
     * @return JsonResponse
     */
    public function destroy(WorkingDay $workingDay): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            if (!$enterpriseIds->contains($workingDay->employee->enterprise_id)) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $workingDay->delete();

            DB::commit();

            return $this->successResponse(null, 'Working day deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting working day: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete working day', 500);
        }
    }
}
