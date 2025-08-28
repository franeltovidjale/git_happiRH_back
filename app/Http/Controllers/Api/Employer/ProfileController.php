<?php

namespace App\Http\Controllers\Api\Employer;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function show(): JsonResponse
    {
        $activeEnterprise = $this->getActiveEnterprise();

        $user = auth()->user();

        return $this->ok('Profile fetched successfully', [
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'photo' => $user->photo,
            ],
            'active_enterprise' => [
                'id' => $activeEnterprise?->id,
                'name' => $activeEnterprise?->name,
                'logo' => $activeEnterprise?->logo,
            ],
            'enterprises' => EnterpriseResource::collection($user->enterprises),
        ]);
    }

    /**
     * Update user profile photo.
     */
    public function updateProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $user = auth()->user();
            $photo = $request->file('photo');

            $this->userService->updatePhoto($user, $photo);

            $updatedUser = User::find($user->id);

            return $this->ok('Photo de profil mise à jour avec succès', [
                'photo' => $updatedUser->photo,
            ]);
        } catch (\Exception $e) {
            logger()->error($e);

            return $this->serverError('Erreur lors de la mise à jour de la photo de profil');
        }
    }
}