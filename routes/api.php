<?php

use App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [Auth\LoginController::class, 'login']);
Route::post('/login/verify-otp', [Auth\LoginController::class, 'verifyByOtp']);
Route::post('/login/resend-otp', [Auth\LoginController::class, 'resendLoginOtp']);
Route::post('/logout', [Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');

// Forgot Password Routes
Route::post('/forgot-password/check-email', [Auth\ForgotPasswordController::class, 'checkEmail']);
Route::post('/forgot-password/resend-otp', [Auth\ForgotPasswordController::class, 'resendOtp']);
Route::post('/forgot-password/change-password', [Auth\ForgotPasswordController::class, 'changePassword']);

require_once __DIR__.'/employer.php';
require_once __DIR__.'/member.php';
