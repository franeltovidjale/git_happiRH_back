<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->group(function () {
    Route::get('/', [SettingController::class, 'index']);
    Route::put('/{key}', [SettingController::class, 'update']);
});