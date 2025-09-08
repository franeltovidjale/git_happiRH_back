<?php

use App\Http\Controllers\Api\Employer\{
    AbsenceController,
    DepartmentController,
    DocumentController,
    EmployeeController,
    ExperienceController,
    PlanningController,
    PresenceController,
    ProfileController,
    ProjectController,
    TaskController,
    TransactionController
};

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

        // Absence routes
        Route::post('absences', [AbsenceController::class, 'store']);

        // Planning routes
        Route::post('plannings', [PlanningController::class, 'store']);

        // Presence routes
        Route::post('presences', [PresenceController::class, 'store']);

        // Transaction routes
        Route::get('transactions', [TransactionController::class, 'index']);
    });
});
