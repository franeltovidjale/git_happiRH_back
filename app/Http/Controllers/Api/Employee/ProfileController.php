<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employee\UpdateProfileRequest;
use App\Models\Member;
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
     * Get current employee profile.
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $activeEnterprise = $this->getActiveEnterprise($request);

            if (! $activeEnterprise) {
                return $this->badRequest('Aucune entreprise active trouvée');
            }

            $member = Member::where('user_id', $user->id)
                ->where('enterprise_id', $activeEnterprise->id)
                ->with(['user', 'enterprise', 'location', 'department'])
                ->first();

            if (! $member) {
                return $this->notFound('Profil employé introuvable');
            }

            return $this->ok('Profil récupéré avec succès', [
                'member' => $member,
                'user' => $member->user,
                'enterprise' => $member->enterprise,
                'location' => $member->location,
                'department' => $member->department,
            ]);
        } catch (\Exception $e) {
            return $this->serverError('Erreur lors de la récupération du profil');
        }
    }

    /**
     * Update employee profile.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $activeEnterprise = $this->getActiveEnterprise($request);

            if (! $activeEnterprise) {
                return $this->badRequest('Aucune entreprise active trouvée');
            }

            $member = Member::where('user_id', $user->id)
                ->where('enterprise_id', $activeEnterprise->id)
                ->first();

            if (! $member) {
                return $this->notFound('Profil employé introuvable');
            }

            $validated = $request->validated();

            // Update user information
            $user->update([
                'first_name' => $validated['first_name'] ?? $user->first_name,
                'last_name' => $validated['last_name'] ?? $user->last_name,
                'phone' => $validated['phone'] ?? $user->phone,
            ]);

            // Update member information
            $member->update([
                'birth_date' => $validated['birth_date'] ?? $member->birth_date,
                'marital_status' => $validated['marital_status'] ?? $member->marital_status,
                'nationality' => $validated['nationality'] ?? $member->nationality,
            ]);

            $member->load(['user', 'enterprise', 'location', 'department']);

            return $this->ok('Profil mis à jour avec succès', [
                'member' => $member,
                'user' => $member->user,
            ]);
        } catch (\Exception $e) {
            return $this->serverError('Erreur lors de la mise à jour du profil');
        }
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
