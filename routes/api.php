<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/verify-otp', [LoginController::class, 'verifyByOtp']);
Route::post('/login/resend-otp', [LoginController::class, 'resendLoginOtp']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Forgot Password Routes
Route::post('/forgot-password/check-email', [ForgotPasswordController::class, 'checkEmail']);
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp']);
Route::post('/forgot-password/change-password', [ForgotPasswordController::class, 'changePassword']);