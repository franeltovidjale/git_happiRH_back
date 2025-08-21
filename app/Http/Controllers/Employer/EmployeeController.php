<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreEmployeeRequest;
use App\Http\Requests\Employer\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Mail\EmployeeRegisteredMail;
use App\Models\Enterprise;
use App\Models\Member;
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
        $enterprise = $this->getActiveEnterprise();
        $members = $enterprise->members()->where('type', Member::TYPE_EMPLOYEE)->with('user')->get();

        return $this->ok('Liste des employés récupérée avec succès', EmployeeResource::collection($members));
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

            $member = Member::create([
                'user_id' => $user->id,
                'enterprise_id' => $request->enterprise_id,
                'type' => Member::TYPE_EMPLOYEE,
                'status' => Member::STATUS_ACTIVE,
                'location_id' => $request->location_id,
                'birth_date' => $request->birth_date,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'bank_account_number' => $request->bank_account_number,
                'bank_name' => $request->bank_name,
                'pan_number' => $request->pan_number,
                'ifsc_code' => $request->ifsc_code,
                'salary_basis' => $request->salary_basis,
                'effective_date' => $request->effective_date,
                'monthly_salary_amount' => $request->monthly_salary_amount,
                'type_of_payment' => $request->type_of_payment,
                'billing_rate' => $request->billing_rate,
                'job_type' => $request->job_type,
                'username' => $request->username,
                'designation' => $request->designation,
                'joining_date' => $request->joining_date,
                'status_by' => auth()->id(),
                'status_date' => now(),
            ]);

            Mail::to($user->email)->send(new EmployeeRegisteredMail(
                $user->first_name,
                $user->last_name,
                $user->email,
                $password,
                $employer->full_name
            ));

            DB::commit();

            $member->load(['user', 'enterprise', 'location']);

            return $this->created('Employé créé avec succès', new EmployeeResource($member));
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
            $enterprise = $this->getActiveEnterprise();

            $member = Member::with(['user', 'enterprise'])
                ->where('enterprise_id', $enterprise->id)
                ->findOrFail($id);

            return $this->ok('Employé récupéré avec succès', new EmployeeResource($member));
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
            $enterprise = $this->getActiveEnterprise();

            $member = Member::with(['user', 'enterprise'])
                ->where('enterprise_id', $enterprise->id)
                ->findOrFail($id);

            DB::beginTransaction();

            // Update user-related fields
            $member->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            // Update member-specific fields
            $member->update([
                'birth_date' => $request->birth_date,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'bank_account_number' => $request->bank_account_number,
                'bank_name' => $request->bank_name,
                'pan_number' => $request->pan_number,
                'ifsc_code' => $request->ifsc_code,
                'salary_basis' => $request->salary_basis,
                'effective_date' => $request->effective_date,
                'monthly_salary_amount' => $request->monthly_salary_amount,
                'type_of_payment' => $request->type_of_payment,
                'billing_rate' => $request->billing_rate,
                'job_type' => $request->job_type,
                'username' => $request->username,
                'designation' => $request->designation,
                'joining_date' => $request->joining_date,
                'location_id' => $request->location_id,
            ]);

            DB::commit();

            $member->load(['user', 'enterprise', 'location']);

            return $this->ok('Employé mis à jour avec succès', new EmployeeResource($member));
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

            $enterprise = $this->getActiveEnterprise();

            $member = Member::where('enterprise_id', $enterprise->id)
                ->findOrFail($id);

            $user = $member->user;
            $member->delete();
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