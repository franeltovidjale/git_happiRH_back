<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
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
}
