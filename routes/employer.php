<?php

use App\Http\Controllers\Api\Employer\DemandeAbsenceController;
use App\Http\Controllers\Api\Employer\DepartmentController;
use App\Http\Controllers\Api\Employer\DocumentController;
use App\Http\Controllers\Api\Employer\EmployeeController;
use App\Http\Controllers\Api\Employer\ExperienceController;
use App\Http\Controllers\Api\Employer\OptionController;
use App\Http\Controllers\Api\Employer\PlanningController;
use App\Http\Controllers\Api\Employer\ProfileController;
use App\Http\Controllers\Api\Employer\ProjectController;
use App\Http\Controllers\Api\Employer\TaskController;
use App\Http\Controllers\Api\Employer\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('profile/photo', [ProfileController::class, 'updateProfilePhoto']);
        Route::post('set-active-enterprise', [ProfileController::class, 'setActiveEnterprise'])->name('set-active-enterprise');
    });

    Route::middleware(['auth:sanctum', 'active.enterprise', 'employer'])->group(function () {
        Route::apiResource('employees', EmployeeController::class);
        Route::put('employees/{employee}/status', [EmployeeController::class, 'changeStatus']);
        Route::post('employees/{employee}/photo', [EmployeeController::class, 'updateEmployeePhoto']);
        Route::apiResource('departments', DepartmentController::class);

        // Document routes
        Route::post('documents/{document}', [DocumentController::class, 'update']);
        Route::apiResource('documents', DocumentController::class)->only(['index', 'store', 'destroy']);

        Route::prefix('members')->group(function () {
            Route::apiResource('experiences', ExperienceController::class)
                ->only(['store', 'update', 'destroy']);
        });

        // Project routes
        Route::post('projects', [ProjectController::class, 'store']);
        Route::put('projects/{id}', [ProjectController::class, 'update']);
        Route::delete('projects/{id}', [ProjectController::class, 'destroy']);

        // Task routes
        Route::post('tasks', [TaskController::class, 'store']);
        Route::put('tasks/{id}', [TaskController::class, 'update']);
        Route::delete('tasks/{id}', [TaskController::class, 'destroy']);

        // Demande Absence routes
        Route::get('demande-absences', [DemandeAbsenceController::class, 'index']);
        Route::post('demande-absences', [DemandeAbsenceController::class, 'store']);
        Route::put('demande-absences/{id}/status', [DemandeAbsenceController::class, 'changeStatus']);

        // Planning routes
        Route::post('plannings', [PlanningController::class, 'store']);

        // Transaction routes
        Route::get('transactions', [TransactionController::class, 'index']);

        // Option routes
        Route::get('options', [OptionController::class, 'index']);
        Route::put('options', [OptionController::class, 'update']);
    });
});
