<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Update user profile photo.
     */
    public function updatePhoto(User $user, UploadedFile $photo): User
    {
        // Delete old photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $path = $photo->store('profiles', 'public');

        // Update user record
        $user->update(['photo' => $path]);

        return $user;
    }
}
