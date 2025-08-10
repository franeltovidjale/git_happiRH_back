<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreDepartmentRequest;
use App\Http\Requests\Employer\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Enterprise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Department Controller for Employer operations
 */
class DepartmentController extends Controller
{
    /**
     * Display a listing of departments for the authenticated user's enterprises.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            $departments = Department::whereIn('enterprise_id', $enterpriseIds)
                ->with(['enterprise', 'employees'])
                ->get();

            return $this->successResponse($departments, 'Departments retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving departments: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve departments', 500);
        }
    }



    /**
     * Store a newly created department.
     *
     * @param StoreDepartmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $department = Department::create([
                'enterprise_id' => $request->enterprise_id,
                'name' => $request->name,
                'active' => $request->active ?? true,
            ]);

            DB::commit();

            return $this->successResponse($department->load('enterprise'), 'Department created successfully', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating department: ' . $e->getMessage());
            return $this->errorResponse('Failed to create department', 500);
        }
    }

    /**
     * Display the specified department.
     *
     * @param Department $department
     * @return JsonResponse
     */
    public function show(Department $department): JsonResponse
    {
        try {
            if ($department->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $department->load(['enterprise', 'employees']);

            return $this->successResponse($department, 'Department retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving department: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve department', 500);
        }
    }


    /**
     * Update the specified department.
     *
     * @param UpdateDepartmentRequest $request
     * @param Department $department
     * @return JsonResponse
     */
    public function update(UpdateDepartmentRequest $request, Department $department): JsonResponse
    {
        try {
            if ($department->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $department->update([
                'name' => $request->name,
                'active' => $request->active,
            ]);

            DB::commit();

            return $this->successResponse($department->load('enterprise'), 'Department updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating department: ' . $e->getMessage());
            return $this->errorResponse('Failed to update department', 500);
        }
    }

    /**
     * Remove the specified department.
     *
     * @param Department $department
     * @return JsonResponse
     */
    public function destroy(Department $department): JsonResponse
    {
        try {
            if ($department->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $department->delete();

            DB::commit();

            return $this->successResponse(null, 'Department deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting department: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete department', 500);
        }
    }
}