<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Members\RegistrationFormRequest;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;

class MemberRegistrationController extends Controller
{
    public function __construct(
        private readonly EmployeeService $employeeService
    ) {}

    /**
     * Register a new member (employee).
     */
    public function register(RegistrationFormRequest $request): JsonResponse
    {
        try {
            $member = $this->employeeService->store($request->validated());

            event(new \Illuminate\Auth\Events\Registered($member->user));

            return $this->created(
                'Inscription réussie. Votre demande est en attente d\'approbation.',
                [
                    'member' => $member,
                    'user' => $member->user,
                    'enterprise' => $member->enterprise,
                ]
            );
        } catch (\Exception $e) {
            return $this->serverError(
                'Une erreur s\'est produite lors de l\'inscription.',
                null,
                $e->getMessage()
            );
        }
    }
}
