<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreEmployeeRequest;
use App\Http\Requests\Employer\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Mail\EmployeeRegisteredMail;
use App\Models\Member;
use App\Models\MemberAddress;
use App\Models\MemberBanking;
use App\Models\MemberEmployment;
use App\Models\MemberSalary;
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
        $members = $enterprise->members()
            ->where('type', Member::TYPE_EMPLOYEE)
            ->with(['user', 'address', 'banking', 'salary', 'employment'])
            ->get();

        return $this->ok('Liste des employés récupérée avec succès', EmployeeResource::collection($members));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $password = Str::random(12);
            $employer = auth()->user();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($password),
                'type' => User::TYPE_USER,
                'is_deletable' => true,
            ]);

            $member = Member::create([
                'user_id' => $user->id,
                'enterprise_id' => $employer->active_enterprise_id,
                'type' => Member::TYPE_EMPLOYEE,
                'status' => Member::STATUS_ACTIVE,
                'location_id' => $request->location_id,
                'birth_date' => $request->birth_date,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'username' => $request->username,
                'designation' => $request->designation,
                'joining_date' => $request->joining_date,
                'status_by' => auth()->id(),
                'status_date' => now(),
            ]);

            // Create address information
            if ($request->filled(['address', 'city', 'state', 'zip_code'])) {
                MemberAddress::create([
                    'member_id' => $member->id,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                ]);
            }

            // Create banking information
            if ($request->filled(['bank_account_number', 'bank_name', 'pan_number', 'ifsc_code'])) {
                MemberBanking::create([
                    'member_id' => $member->id,
                    'bank_account_number' => $request->bank_account_number,
                    'bank_name' => $request->bank_name,
                    'pan_number' => $request->pan_number,
                    'ifsc_code' => $request->ifsc_code,
                ]);
            }

            // Create salary information
            if ($request->filled(['salary_basis', 'effective_date', 'monthly_salary_amount', 'type_of_payment', 'billing_rate'])) {
                MemberSalary::create([
                    'member_id' => $member->id,
                    'salary_basis' => $request->salary_basis,
                    'effective_date' => $request->effective_date,
                    'monthly_salary_amount' => $request->monthly_salary_amount,
                    'type_of_payment' => $request->type_of_payment,
                    'billing_rate' => $request->billing_rate,
                ]);
            }

            // Create employment information
            if ($request->filled(['job_type', 'contract_type'])) {
                MemberEmployment::create([
                    'member_id' => $member->id,
                    'job_type' => $request->job_type,
                    'contract_type' => $request->contract_type,
                ]);
            }

            Mail::to($user->email)->send(new EmployeeRegisteredMail(
                $user->first_name,
                $user->last_name,
                $user->email,
                $password,
                $employer->full_name
            ));

            DB::commit();

            $member->load(['user', 'enterprise', 'location', 'address', 'banking', 'salary', 'employment']);

            return $this->created('Employé créé avec succès', new EmployeeResource($member));
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Erreur lors de la création de l\'employé: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->validated(),
            ]);

            return $this->serverError('Erreur lors de la création de l\'employé: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            $member = Member::with(['user', 'enterprise', 'address', 'banking', 'salary', 'employment'])
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

            $member = Member::with(['user', 'enterprise', 'address', 'banking', 'salary', 'employment'])
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
                'username' => $request->username,
                'designation' => $request->designation,
                'joining_date' => $request->joining_date,
                'location_id' => $request->location_id,
            ]);

            // Update or create address information
            if ($request->filled(['address', 'city', 'state', 'zip_code'])) {
                $member->address()->updateOrCreate(
                    ['member_id' => $member->id],
                    [
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                    ]
                );
            }

            // Update or create banking information
            if ($request->filled(['bank_account_number', 'bank_name', 'pan_number', 'ifsc_code'])) {
                $member->banking()->updateOrCreate(
                    ['member_id' => $member->id],
                    [
                        'bank_account_number' => $request->bank_account_number,
                        'bank_name' => $request->bank_name,
                        'pan_number' => $request->pan_number,
                        'ifsc_code' => $request->ifsc_code,
                    ]
                );
            }

            // Update or create salary information
            if ($request->filled(['salary_basis', 'effective_date', 'monthly_salary_amount', 'type_of_payment', 'billing_rate'])) {
                $member->salary()->updateOrCreate(
                    ['member_id' => $member->id],
                    [
                        'salary_basis' => $request->salary_basis,
                        'effective_date' => $request->effective_date,
                        'monthly_salary_amount' => $request->monthly_salary_amount,
                        'type_of_payment' => $request->type_of_payment,
                        'billing_rate' => $request->billing_rate,
                    ]
                );
            }

            // Update or create employment information
            if ($request->filled(['job_type', 'contract_type'])) {
                $member->employment()->updateOrCreate(
                    ['member_id' => $member->id],
                    [
                        'job_type' => $request->job_type,
                        'contract_type' => $request->contract_type,
                    ]
                );
            }

            DB::commit();

            $member->load(['user', 'enterprise', 'location', 'address', 'banking', 'salary', 'employment']);

            return $this->ok('Employé mis à jour avec succès', new EmployeeResource($member));
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Erreur lors de la mise à jour de l\'employé: ' . $e->getMessage(), [
                'exception' => $e,
                'member_id' => $id,
                'request_data' => $request->validated(),
            ]);

            return $this->serverError('Erreur lors de la mise à jour de l\'employé: ' . $e->getMessage());
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