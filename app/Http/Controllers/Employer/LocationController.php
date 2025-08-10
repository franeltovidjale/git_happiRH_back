<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreLocationRequest;
use App\Http\Requests\Employer\UpdateLocationRequest;
use App\Models\Location;
use App\Models\Enterprise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Location Controller for Employer operations
 */
class LocationController extends Controller
{
    /**
     * Display a listing of locations for the authenticated user's enterprises.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            $locations = Location::whereIn('enterprise_id', $enterpriseIds)
                ->with(['enterprise', 'employees'])
                ->get();

            return $this->successResponse($locations, 'Locations retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving locations: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve locations', 500);
        }
    }

    /**
     * Store a newly created location.
     *
     * @param StoreLocationRequest $request
     * @return JsonResponse
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $location = Location::create([
                'enterprise_id' => $request->enterprise_id,
                'name' => $request->name,
                'active' => $request->active ?? true,
            ]);

            DB::commit();

            return $this->successResponse($location->load('enterprise'), 'Location created successfully', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating location: ' . $e->getMessage());
            return $this->errorResponse('Failed to create location', 500);
        }
    }

    /**
     * Display the specified location.
     *
     * @param Location $location
     * @return JsonResponse
     */
    public function show(Location $location): JsonResponse
    {
        try {
            if ($location->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $location->load(['enterprise', 'employees']);

            return $this->successResponse($location, 'Location retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving location: ' . $e->getMessage());
            return $this->errorResponse('Failed to retrieve location', 500);
        }
    }

    /**
     * Update the specified location.
     *
     * @param UpdateLocationRequest $request
     * @param Location $location
     * @return JsonResponse
     */
    public function update(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        try {
            if ($location->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $location->update([
                'name' => $request->name,
                'active' => $request->active,
            ]);

            DB::commit();

            return $this->successResponse($location->load('enterprise'), 'Location updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating location: ' . $e->getMessage());
            return $this->errorResponse('Failed to update location', 500);
        }
    }

    /**
     * Remove the specified location.
     *
     * @param Location $location
     * @return JsonResponse
     */
    public function destroy(Location $location): JsonResponse
    {
        try {
            if ($location->enterprise->owner_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            DB::beginTransaction();

            $location->delete();

            DB::commit();

            return $this->successResponse(null, 'Location deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting location: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete location', 500);
        }
    }
}
