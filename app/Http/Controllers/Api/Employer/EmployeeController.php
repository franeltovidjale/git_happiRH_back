<?php

namespace App\Http\Controllers\Api\Employer;

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Str;

use App\Models\MemberSalary;
use App\Models\MemberAddress;
use App\Models\MemberBanking;
use App\Services\UserService;
use App\Models\MemberEmployment;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\MemberContactPerson;
use App\Http\Controllers\Controller;
use App\Mail\EmployeeRegisteredMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeStatusChangedMail;
use App\Http\Resources\EmployeeResource;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\Employer\StoreEmployeeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\Employer\UpdateEmployeeRequest;
use App\Http\Requests\Api\Employer\ChangeEmployeeStatusRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService,
        private UserService $userService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $allowedSnippets = ['address', 'banking', 'salary', 'employment', 'departments', 'experiences'];

        $snippets = [];

        if ($request->has('snippets')) {
            $snippets = array_map(
                'trim',
                explode(',', $request->input('snippets'))
            );

            $invalidSnippets = array_diff($snippets, $allowedSnippets);
            if (! empty($invalidSnippets)) {
                return $this->badRequest('Snippets invalides: ' . implode(', ', $invalidSnippets));
            }
        }


        $enterprise = $this->getActiveEnterprise();

        $request->merge(['enterprise_id' => $enterprise->id]);

        $members = $this->employeeService->fetchList($request->all(), $snippets);

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
                'role' => $request->role,
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

            // Create contact person information
            if ($request->filled(['contact_person_full_name', 'contact_person_phone'])) {
                MemberContactPerson::create([
                    'member_id' => $member->id,
                    'full_name' => $request->contact_person_full_name,
                    'phone' => $request->contact_person_phone,
                ]);
            }

            // Associate department if provided
            if ($request->filled('department_id')) {
                $member->departments()->attach($request->department_id);
            }

            Mail::to($user->email)->send(new EmployeeRegisteredMail(
                $user->first_name,
                $user->last_name,
                $user->email,
                $password,
                $employer->full_name
            ));

            DB::commit();

            $member->load(['user', 'enterprise', 'location', 'address', 'banking', 'salary', 'employment', 'contactPerson']);

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
    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $allowedSnippets = ['address', 'banking', 'salary', 'employment', 'contactPerson', 'departments', 'workDays', 'experiences'];

            $snippets = [];

            if ($request->has('snippets')) {
                $snippets = array_map(
                    'trim',
                    explode(',', $request->input('snippets'))
                );

                $invalidSnippets = array_diff($snippets, $allowedSnippets);
                if (! empty($invalidSnippets)) {
                    return $this->badRequest('Snippets invalides: ' . implode(', ', $invalidSnippets));
                }
            }

            $enterprise = $this->getActiveEnterprise();

            $member = $this->employeeService->fetchOne(
                (int) $id,
                ['enterprise_id' => $enterprise->id],
                $snippets
            );

            if (! $member) {
                return $this->notFound('Employé introuvable');
            }

            return $this->ok('Employé récupéré avec succès', new EmployeeResource($member));
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la récupération de l\'employé');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            /**
             * @var Member
             */
            $member = Member::with(['user', 'enterprise', 'address', 'banking', 'salary', 'employment', 'contactPerson'])
                ->where('enterprise_id', $enterprise->id)
                ->findOrFail($id);

            DB::beginTransaction();

            // Get only the validated data that was actually provided
            $validatedData = $request->validatedData();

            // Update user-related fields only if provided
            $userData = array_intersect_key($validatedData, array_flip(['first_name', 'last_name', 'phone']));
            if (! empty($userData)) {
                $member->user->update($userData);
            }

            // Update member-specific fields only if provided
            $memberData = array_intersect_key($validatedData, array_flip([
                'birth_date',
                'marital_status',
                'nationality',
                'username',
                'role',
                'joining_date',
                'location_id',
            ]));
            if (! empty($memberData)) {
                $member->update($memberData);
            }

            // Update or create address information only if provided
            $addressData = array_intersect_key($validatedData, array_flip(['address', 'city', 'state', 'zip_code']));
            if (! empty($addressData)) {
                $member->address()->updateOrCreate(
                    ['member_id' => $member->id],
                    $addressData
                );
            }

            // Update or create banking information only if provided
            $bankingData = array_filter($request->only(['bank_account_number', 'bank_name', 'pan_number', 'ifsc_code']));

            if (! empty($bankingData)) {
                if (! $member->banking) {
                    $request->validate([
                        'bank_account_number' => 'required',
                        'bank_name' => 'required',
                    ]);
                }
                $member->banking()->updateOrCreate(
                    ['member_id' => $member->id],
                    $bankingData
                );
            }

            // Update or create salary information only if provided
            $salaryData = array_intersect_key($validatedData, array_flip(['salary_basis', 'effective_date', 'monthly_salary_amount', 'type_of_payment', 'billing_rate']));
            if (! empty($salaryData)) {
                $member->salary()->updateOrCreate(
                    ['member_id' => $member->id],
                    $salaryData
                );
            }

            // Update or create employment information only if provided
            $employmentData = array_intersect_key($validatedData, array_flip(['job_type', 'contract_type']));
            if (! empty($employmentData)) {
                $member->employment()->updateOrCreate(
                    ['member_id' => $member->id],
                    $employmentData
                );
            }

            // Update or create contact person information only if provided
            $contactData = array_filter($request->only(['contact_person_full_name', 'contact_person_phone']));
            if (! empty($contactData)) {
                // Map the request field names to the database field names
                $mappedContactData = [
                    'full_name' => $contactData['contact_person_full_name'] ?? null,
                    'phone' => $contactData['contact_person_phone'] ?? null,
                ];

                $member->contactPerson()->updateOrCreate(
                    ['member_id' => $member->id],
                    array_filter($mappedContactData) // Remove null values
                );
            }

            // Update department association if provided
            if ($request->filled('department_id')) {
                $member->departments()->sync([$request->department_id]);
            }

            DB::commit();

            $member->load(['user', 'enterprise', 'location', 'address', 'banking', 'salary', 'employment', 'contactPerson']);

            return $this->ok('Employé mis à jour avec succès', new EmployeeResource($member));
        } catch (\Exception $e) {
            DB::rollback();

            if ($e instanceof ValidationException) {
                return $this->badRequest($e->getMessage(), errors: $e->errors());
            }
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de l\'employé: ' . $e->getMessage());
        }
    }

    /**
     * Change the status of the specified employee.
     */
    public function changeStatus(ChangeEmployeeStatusRequest $request, string $id): JsonResponse
    {
        try {
            $enterprise = $this->getActiveEnterprise();

            /**
             * @var Member
             */
            $member = Member::with(['user', 'enterprise'])
                ->where('enterprise_id', $enterprise->id)
                ->findOrFail($id);

            DB::beginTransaction();

            // Get current status for logging
            $oldStatus = $member->status;
            $newStatus = $request->status;
            if ($newStatus === $oldStatus) {
                return $this->ok('Le statut de l\'employé est déjà ' . $newStatus);
            }

            // Update member status
            $member->update([
                'status' => $newStatus,
                'status_note' => $request->status_note,
                'status_by' => auth()->id(),
                'status_date' => now(),
            ]);

            // Add to status stories
            $statusStories = $member->status_stories ?? [];
            $statusStories[] = [
                'status' => $newStatus,
                'note' => $request->status_note,
                'changed_by' => auth()->id(),
                'changed_at' => now()->toISOString(),
                'previous_status' => $oldStatus,
            ];

            $member->update(['status_stories' => $statusStories]);

            DB::commit();

            $member->load(['user', 'enterprise']);

            Mail::to($member->user->email)->send(new EmployeeStatusChangedMail(
                $oldStatus,
                $newStatus,
                $request->status_note
            ));

            return $this->ok(
                "Statut de l'employé changé de {$oldStatus} vers {$newStatus} avec succès",
                new EmployeeResource($member)
            );
        } catch (\Exception $e) {
            DB::rollback();
            if ($e instanceof ModelNotFoundException) {
                return $this->notFound('Employé introuvable');
            }
            logger()->error($e);

            return $this->serverError('Erreur lors du changement de statut de l\'employé: ' . $e->getMessage());
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

            if ($e instanceof ModelNotFoundException) {
                return $this->notFound('Employé introuvable');
            }

            return $this->serverError('Impossible de supprimer l\'employé actuellement');
        }
    }

    /**
     * Update employee profile photo.
     */
    public function updateEmployeePhoto(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $enterprise = $this->getActiveEnterprise();

            $member = Member::where('enterprise_id', $enterprise->id)
                ->where('id', $id)
                ->first();

            if (! $member) {
                return $this->notFound('Employé introuvable');
            }

            $photo = $request->file('photo');

            $this->userService->updatePhoto($member->user, $photo);

            $updatedUser = User::find($member->user->id);

            return $this->ok('Photo de profil de l\'employé mise à jour avec succès', $updatedUser->only(['photo', 'id']));
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de la photo de profil de l\'employé');
        }
    }
}
