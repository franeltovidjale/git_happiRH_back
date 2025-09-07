<?php

use App\Http\Controllers\Public\DownloadController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LoginController;
use App\Http\Controllers\Public\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');


Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/tarifs', [HomeController::class, 'tarifs'])->name('tarifs');
Route::get('/demo', [HomeController::class, 'demo'])->name('demo');
Route::get('/resources', [HomeController::class, 'resources'])->name('resources');
Route::get('/company', [HomeController::class, 'company'])->name('company');

Route::get('/register-success', [RegistrationController::class, 'registerSuccess'])->name('public.register-success');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('public.login');

Route::get('/download-payslip', [DownloadController::class, 'download'])->name('download-payslip');

Route::get(
    '/get-started',
    [HomeController::class, 'getStarted']
)->name('public.register');

require __DIR__ . '/admin.php';
