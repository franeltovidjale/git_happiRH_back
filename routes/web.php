<?php

use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/tarifs', [HomeController::class, 'tarifs'])->name('tarifs');
Route::get('/demo', [HomeController::class, 'demo'])->name('demo');
Route::get('/resources', [HomeController::class, 'resources'])->name('resources');
Route::get('/company', [HomeController::class, 'company'])->name('company');

Route::get(
    '/get-started',
    [HomeController::class, 'getStarted']
)->name('public.register');

require __DIR__ . '/admin.php';