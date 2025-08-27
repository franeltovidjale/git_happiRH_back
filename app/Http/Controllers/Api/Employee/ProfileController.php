<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

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