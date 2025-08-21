<?php

use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EnterpriseController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WorkingDayController;
use Illuminate\Support\Facades\Route;

Route::prefix("employer")->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('set-active-enterprise', [ProfileController::class, 'setActiveEnterprise'])->name('set-active-enterprise');
    });

    Route::middleware(['auth:sanctum', 'active.enterprise', 'employer'])->group(function () {});
});
