<?php

use App\Http\Controllers\Api\Auth\MemberRegistrationController;
use App\Http\Controllers\Api\Employee\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
|
| Here is where you can register member-related routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Member registration route (public)
Route::post('/register', [MemberRegistrationController::class, 'register']);

Route::prefix('employee')->group(function () {
    // Routes that require authentication
    Route::middleware('auth:sanctum')->group(function () {
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/profile/photo', [ProfileController::class, 'updateProfilePhoto']);
    });
});
