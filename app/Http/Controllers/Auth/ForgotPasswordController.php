<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckEmailRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use App\Mail\PasswordChangedMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

/**
 * ForgotPasswordController
 *
 * Handles forgot password operations with OTP verification
 */
class ForgotPasswordController extends Controller
{
    /**
     * Check email and send OTP for password reset
     *
     * @param CheckEmailRequest $request
     * @return JsonResponse
     */
    public function checkEmail(CheckEmailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $email = $request->validated()['email'];

            $user = User::where('email', $email)->first();
            if (!$user) {
                DB::rollback();
                return $this->notFound('Utilisateur non trouvé');
            }

            // Invalidate any existing OTPs for this email and type (don't delete for counting)
            Otp::where('identifier', $email)
                ->where('type', 'reset_password')
                ->update(['is_valid' => false]);

            // Create new OTP
            $otp = Otp::create([
                'identifier' => $email,
                'code' => Otp::generateCode(),
                'type' => 'reset_password',
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_valid' => true,
            ]);

            // Send OTP email
            Mail::to($email)->send(new OtpMail(
                $otp->code,
                $user->first_name,
                'Code de réinitialisation',
                'réinitialisation de mot de passe'
            ));

            DB::commit();

            return $this->ok('Code OTP envoyé à votre adresse email');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors de l\'envoi du code OTP', null, $e->getMessage());
        }
    }

    /**
     * Resend OTP with progressive delays
     *
     * @param ResendOtpRequest $request
     * @return JsonResponse
     */
    public function resendOtp(ResendOtpRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $email = $request->validated()['email'];

            $user = User::where('email', $email)->first();
            if (!$user) {
                DB::rollback();
                return $this->notFound('Utilisateur non trouvé');
            }

            // Count OTP attempts in the last hour
            $otpCount = Otp::where('identifier', $email)
                ->where('type', 'reset_password')
                ->where('created_at', '>', Carbon::now()->subHour())
                ->count();


            // Get last OTP to check delays
            $lastOtp = Otp::where('identifier', $email)
                ->where('type', 'reset_password')
                ->latest()
                ->first();

            if ($lastOtp) {
                // Check if user has exceeded maximum attempts (4 times) - 60 minutes lockout
                if ($otpCount >= 4) {
                    if ($lastOtp->created_at->addHour() > Carbon::now()) {
                        DB::rollback();
                        $remainingSeconds = $lastOtp->created_at->addHour()->diffInSeconds(Carbon::now());
                        $waitTime = ceil($remainingSeconds / 60);
                        return $this->badRequest("Trop de tentatives. Veuillez attendre {$waitTime} minutes");
                    }
                } else {
                    // Progressive delays for attempts 1-4
                    $delay = $this->calculateResendDelay($otpCount);

                    if ($delay > 0 && $lastOtp->created_at->addMinutes($delay) > Carbon::now()) {
                        DB::rollback();
                        $remainingSeconds = $lastOtp->created_at->addMinutes($delay)->diffInSeconds(Carbon::now());

                        if ($remainingSeconds >= 60) {
                            $waitTime = ceil($remainingSeconds / 60);
                            return $this->badRequest("Veuillez attendre {$waitTime} minutes avant de renvoyer le code");
                        } else {
                            return $this->badRequest("Veuillez attendre {$remainingSeconds} secondes avant de renvoyer le code");
                        }
                    }
                }
            }

            // Invalidate all existing OTPs for this email (don't delete for counting)
            Otp::where('identifier', $email)
                ->where('type', 'reset_password')
                ->update(['is_valid' => false]);

            // Create new OTP
            $otp = Otp::create([
                'identifier' => $email,
                'code' => Otp::generateCode(),
                'type' => 'reset_password',
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_valid' => true,
            ]);

            // Send OTP email
            Mail::to($email)->send(new OtpMail(
                $otp->code,
                $user->first_name,
                'Code de réinitialisation',
                'réinitialisation de mot de passe'
            ));

            DB::commit();

            return $this->ok('Nouveau code OTP envoyé');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors du renvoi du code OTP', null, $e->getMessage());
        }
    }

    /**
     * Change password with OTP verification
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $email = $data['email'];
            $password = $data['password'];
            $otpCode = $data['otp'];

            $user = User::where('email', $email)->first();
            if (!$user) {
                DB::rollback();
                return $this->notFound('Utilisateur non trouvé');
            }

            // Verify OTP
            if (!Otp::verify($email, $otpCode, 'reset_password')) {
                DB::rollback();
                return $this->badRequest('Code OTP invalide ou expiré');
            }

            // Update user password
            $user->update([
                'password' => Hash::make($password)
            ]);

            // Delete all reset password OTPs for this user
            Otp::where('identifier', $email)
                ->where('type', 'reset_password')
                ->delete();

            // Send password changed confirmation email
            Mail::to($email)->send(new PasswordChangedMail($user->first_name));

            DB::commit();

            return $this->ok('Mot de passe modifié avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->serverError('Erreur lors du changement de mot de passe', null, $e->getMessage());
        }
    }

    /**
     * Calculate resend delay based on attempt count
     *
     * @param int $attemptCount
     * @return int Minutes to wait
     */
    private function calculateResendDelay(int $attemptCount): int
    {
        return match ($attemptCount) {
            0 => 0,      // First attempt - no delay
            1 => 1,      // Between 1st and 2nd attempt - wait 1 minute
            2 => 3,      // Between 2nd and 3rd attempt - wait 3 minutes
            3 => 5,      // Between 3rd and 4th attempt - wait 5 minutes
            default => 0 // This case is handled separately (60 min lockout)
        };
    }
}