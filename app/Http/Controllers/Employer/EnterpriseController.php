<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreEnterpriseRequest;
use App\Http\Requests\Employer\UpdateEnterpriseRequest;
use App\Models\Enterprise;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Enterprise Controller for Employer operations
 */
class EnterpriseController extends Controller
{
    /**
     * Display a listing of enterprises owned by the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $enterprises = Enterprise::where('owner_id', auth()->id())
                ->with(['owner', 'employees'])
                ->get();

            return $this->successResponse($enterprises, 'Enterprises retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving enterprises: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve enterprises', 500);
        }
    }


    /**
     * Store a newly created enterprise.
     *
     * @param StoreEnterpriseRequest $request
     * @return JsonResponse
     */
    public function store(StoreEnterpriseRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $enterprise = Enterprise::create([
                'ifu' => $request->ifu,
                'name' => $request->name,
                'active' => $request->active ?? true,
                'owner_id' => auth()->id(),
            ]);

            DB::commit();

            return $this->successResponse($enterprise->load('owner'), 'Enterprise created successfully', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating enterprise: ' . $e->getMessage());
            return $this->errorResponse('Failed to create enterprise', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified enterprise.
     *
     * @param UpdateEnterpriseRequest $request
     * @param Enterprise $enterprise
     * @return JsonResponse
     */
    public function update(UpdateEnterpriseRequest $request, Enterprise $enterprise): JsonResponse
    {
        try {
            if ($enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $enterprise->update([
                'ifu' => $request->ifu,
                'name' => $request->name,
                'active' => $request->active,
            ]);

            DB::commit();

            return $this->successResponse($enterprise->load('owner'), 'Enterprise updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating enterprise: ' . $e->getMessage());
            return $this->errorResponse('Failed to update enterprise', 500);
        }
    }

    /**
     * Remove the specified enterprise.
     *
     * @param Enterprise $enterprise
     * @return JsonResponse
     */
    public function destroy(Enterprise $enterprise): JsonResponse
    {
        try {
            if ($enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $enterprise->delete();

            DB::commit();

            return $this->successResponse(null, 'Enterprise deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting enterprise: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete enterprise', 500);
        }
    }

    /**
     * Detach an employee from the enterprise.
     *
     * @param Request $request
     * @param Enterprise $enterprise
     * @return JsonResponse
     */
    public function detachEmployee(Request $request, Enterprise $enterprise): JsonResponse
    {
        try {
            if ($enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $request->validate([
                'employee_id' => 'required|exists:employees,id'
            ]);

            DB::beginTransaction();

            $employee = Employee::where('id', $request->employee_id)
                ->where('enterprise_id', $enterprise->id)
                ->first();

            if (!$employee) {
                return $this->errorResponse('Employee not found in this enterprise', 404);
            }

            $employee->update(['enterprise_id' => null]);

            DB::commit();

            return $this->successResponse(null, 'Employee detached successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error detaching employee: ' . $e->getMessage());
            return $this->errorResponse('Failed to detach employee', 500);
        }
    }
}
