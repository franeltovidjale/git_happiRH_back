<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Enterprise;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * RegisterController
 *
 * Handles user registration operations
 */
class RegisterController extends Controller
{
    /**
     * Handle user registration
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $userData['password'] = Hash::make($userData['password']);

            $user = User::create($userData);

            if ($userData['type'] === 'employer') {
                $this->createEmployer($user, $userData);
            } else {
                $this->createEmployee($user, $userData['enterprise_code']);
            }

            event(new Registered($user));
            DB::commit();

            return $this->created('Utilisateur créé avec succès', [
                'user' => $user->only('id', 'first_name', 'last_name', 'email', 'phone'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors de la création du compte', null, $e->getMessage());
        }
    }

    /**
     * Create an employee record
     *
     * @param User $user
     * @param string $enterpriseCode
     * @return void
     */
    private function createEmployee(User $user, string $enterpriseCode): void
    {
        $enterprise = Enterprise::where('code', $enterpriseCode)->first();

        if (!$enterprise) {
            throw new \Exception('Entreprise non trouvée');
        }

        Employee::create([
            'user_id' => $user->id,
            'employer_id' => $enterprise->owner_id,
            'enterprise_id' => $enterprise->id,
            'role' => 'employee',
        ]);
    }

    /**
     * Create an employer record and enterprise
     *
     * @param User $user
     * @param array $userData
     * @return void
     */
    private function createEmployer(User $user, array $userData): void
    {
        $enterprise = $this->createEnterprise($user, $userData);
    }

    /**
     * Create an enterprise
     *
     * @param User $user
     * @param array $userData
     * @return Enterprise
     */
    private function createEnterprise(User $user, array $userData): Enterprise
    {
        $statusStory = encodeModelStatusStory(
            Enterprise::STATUS_PENDING,
            'Entreprise créée et en attente de validation',
            $user->id
        );

        return Enterprise::create([
            'name' => $userData['enterprise_name'],
            'sector_id' => $userData['sector_id'],
            'owner_id' => $user->id,
            'country_code' => $userData['country_code'],
            'status' => Enterprise::STATUS_PENDING,
            'status_by' => $user->id,
            'status_date' => now(),
            'status_stories' => [$statusStory],
        ]);
    }
}
