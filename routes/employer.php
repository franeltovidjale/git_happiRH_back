<?php

use App\Http\Controllers\Employer\EmployeeController;
use App\Http\Controllers\Employer\EnterpriseController;
use App\Http\Controllers\Employer\DepartmentController;
use App\Http\Controllers\Employer\LocationController;
use App\Http\Controllers\Employer\WorkingDayController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'employer'])->group(function () {
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('enterprises', EnterpriseController::class);
    Route::post('enterprises/{enterprise}/detach-employee', [EnterpriseController::class, 'detachEmployee'])->name('enterprises.detach-employee');

    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('working-days', WorkingDayController::class);
});