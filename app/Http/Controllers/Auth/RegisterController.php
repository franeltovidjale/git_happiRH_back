<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Enterprise;
use App\Models\Member;
use App\Models\User;
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
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $userData['password'] = Hash::make($userData['password']);

            $requestType = $userData['type'] == 'employer' ? Member::TYPE_OWNER : Member::TYPE_EMPLOYEE;
            $userData['type'] = 'user';
            $user = User::create($userData);

            $this->createMember($user, $userData, $requestType);

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
     */
    private function createMember(User $user, array $userData, ?string $type = null): void
    {
        $enterprise = Enterprise::where('code', $userData['enterprise_code'] ?? 0)->first();

        if ($type === Member::TYPE_EMPLOYEE && ! $enterprise) {
            throw new \Exception('Entreprise non trouvée');
        }

        $enterprise ??= $this->createEnterprise($user, $userData);

        Member::create([
            'user_id' => $user->id,
            'enterprise_id' => $enterprise->id,
            'type' => $type,
            'status' => Member::STATUS_REQUESTED,
            'status_by' => $user->id,
            'status_date' => now(),
            'status_stories' => encodeModelStatusStory(
                Member::STATUS_REQUESTED,
                'Membre créé et en attente de validation',
                $user->id
            ),
        ]);
    }

    /**
     * Create an enterprise
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
            'plan_id' => $userData['plan_id'],
            'owner_id' => $user->id,
            'country_code' => $userData['country_code'],
            'status' => Enterprise::STATUS_PENDING,
            'status_by' => $user->id,
            'status_date' => now(),
            'status_stories' => [$statusStory],
        ]);
    }
}
