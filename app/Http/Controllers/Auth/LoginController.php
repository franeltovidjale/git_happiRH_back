<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

/**
 * LoginController
 *
 * Handles user authentication and login operations
 */
class LoginController extends Controller
{
    /**
     * Handle user login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if (!Auth::attempt($credentials)) {
                DB::rollback();
                return $this->unauthorized('Identifiants invalides');
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return $this->ok('Connexion réussie', [
                'user' => $user,
                'token' => $token
            ]);
        } catch (ValidationException $e) {
            DB::rollback();
            return $this->badRequest('Données invalides', null, $e->errors());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors de la connexion', null, $e->getMessage());
        }
    }

    /**
     * Handle user logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /** @var \App\Models\User $user */
            $user = $request->user();
            if ($user) {
                $user->tokens()->delete();
            }

            DB::commit();

            return $this->ok('Déconnexion réussie');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors de la déconnexion', null, $e->getMessage());
        }
    }

    /**
     * Get authenticated user information
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->unauthorized('Utilisateur non authentifié');
            }

            return $this->ok('Informations utilisateur récupérées', $user);
        } catch (\Exception $e) {
            return $this->serverError('Erreur lors de la récupération des informations', null, $e->getMessage());
        }
    }
}