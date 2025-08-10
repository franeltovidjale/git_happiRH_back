<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreEmployeeRequest;
use App\Http\Requests\Employer\UpdateEmployeeRequest;
use App\Mail\EmployeeRegisteredMail;
use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

        $employees = Employee::with(['user', 'enterprise'])
            ->whereIn('enterprise_id', $enterpriseIds)
            ->get();

        return $this->ok('Liste des employés récupérée avec succès', $employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $password = Str::random(12);
            $employer = auth()->user();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($password),
                'type' => 'employee',
                'is_deletable' => true,
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'enterprise_id' => $request->enterprise_id,
                'active' => $request->active ?? true,
                'birth_date' => $request->birth_date,
                'marital_status' => $request->marital_status,
                'gender' => $request->gender,
                'nationality' => $request->nationality,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
            ]);

            Mail::to($user->email)->send(new EmployeeRegisteredMail(
                $user->first_name,
                $user->last_name,
                $user->email,
                $password,
                $employer->full_name
            ));

            DB::commit();

            $employee->load(['user', 'enterprise']);

            return $this->created('Employé créé avec succès', $employee);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
            return $this->serverError('Erreur lors de la création de l\'employé');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            $employee = Employee::with(['user', 'enterprise'])
                ->whereIn('enterprise_id', $enterpriseIds)
                ->findOrFail($id);

            return $this->ok('Employé récupéré avec succès', $employee);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->notFound('Employé introuvable');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id): JsonResponse
    {
        try {
            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            $employee = Employee::with(['user', 'enterprise'])
                ->whereIn('enterprise_id', $enterpriseIds)
                ->findOrFail($id);

            DB::beginTransaction();

            // Update user-related fields
            $employee->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            // Update employee-specific fields
            $employee->update([
                'birth_date' => $request->birth_date,
                'marital_status' => $request->marital_status,
                'gender' => $request->gender,
                'nationality' => $request->nationality,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'active' => $request->active,
            ]);

            DB::commit();

            $employee->load(['user', 'enterprise']);

            return $this->ok('Employé mis à jour avec succès', $employee);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
            return $this->serverError('Erreur lors de la mise à jour de l\'employé');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $enterpriseIds = Enterprise::where('owner_id', auth()->id())->pluck('id');

            $employee = Employee::whereIn('enterprise_id', $enterpriseIds)
                ->findOrFail($id);

            $user = $employee->user;
            $employee->delete();
            $user->delete();

            DB::commit();

            return $this->ok('Employé supprimé avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);
            return $this->serverError('Erreur lors de la suppression de l\'employé');
        }
    }
}