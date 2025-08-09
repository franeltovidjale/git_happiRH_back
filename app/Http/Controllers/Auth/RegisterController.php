<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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
}
