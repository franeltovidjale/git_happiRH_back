<?php

use App\Http\Controllers\Employer\EmployeeController;
use App\Http\Controllers\Employer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix("employer")->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('set-active-enterprise', [ProfileController::class, 'setActiveEnterprise'])->name('set-active-enterprise');
    });

    Route::middleware(['auth:sanctum', 'active.enterprise', 'employer'])->group(function () {
        Route::apiResource('employees', EmployeeController::class);
    });
});
