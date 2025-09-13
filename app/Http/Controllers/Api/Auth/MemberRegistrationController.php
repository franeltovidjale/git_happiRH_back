<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\WorkingHourService;
use App\Http\Requests\Api\Members\RegistrationFormRequest;

class MemberRegistrationController extends Controller
{
    public function __construct(
        private readonly EmployeeService $employeeService,
        private readonly WorkingHourService $workingHourService
    ) {}

    /**
     * Register a new member (employee).
     */
    public function register(RegistrationFormRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $member = $this->employeeService->store($request->validated());

            // Create default working hours for the new member
            $this->workingHourService->createDefaults($member->id);

            event(new \Illuminate\Auth\Events\Registered($member->user));

            DB::commit();
            return $this->created(
                'Inscription réussie. Votre demande est en attente d\'approbation.',
                [
                    'member' => $member,
                    'user' => $member->user,
                    'enterprise' => $member->enterprise,
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->serverError(
                'Une erreur s\'est produite lors de l\'inscription.',
                null,
                $e->getMessage()
            );
        }
    }
}
