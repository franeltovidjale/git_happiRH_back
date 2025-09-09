<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendLoginOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

/**
 * LoginController
 *
 * Handles user authentication and login operations
 */
class LoginController extends Controller
{
    /**
     * Handle user login
     */
    public function login(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            if (! Auth::attempt($credentials)) {
                DB::rollback();

                return $this->unauthorized('Identifiants invalides');
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $authEnabledOtp = Setting::getSetting('authEnabledOtp', false);

            if ($authEnabledOtp) {
                // Invalidate any existing OTPs for this email and type
                Otp::where('identifier', $user->email)
                    ->where('type', 'login_verification')
                    ->update(['is_valid' => false]);

                // Create new OTP
                $otp = Otp::create([
                    'identifier' => $user->email,
                    'code' => Otp::generateCode(),
                    'type' => 'login_verification',
                    'expires_at' => Carbon::now()->addMinutes(10),
                    'is_valid' => true,
                ]);

                // Send OTP email
                Mail::to($user->email)->send(new OtpMail(
                    $otp->code,
                    $user->first_name,
                    'Code de connexion',
                    'connexion'
                ));

                DB::commit();

                return $this->ok('Code OTP envoyé à votre adresse email', [
                    'authEnabledOtp' => true,
                    'message' => 'Vérifiez votre email pour le code OTP',
                    'user' => null,
                    'token' => null,
                ]);
            }

            // OTP not enabled, proceed with normal login
            $this->setActiveEnterprise($user);
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return $this->ok('Connexion réussie', [
                'user' => $user->only('id', 'first_name', 'last_name', 'email'),
                'token' => $token,
                'authEnabledOtp' => false,
            ]);
        } catch (ValidationException $e) {
            DB::rollback();

            return $this->badRequest('Données invalides', null, $e->errors());
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);

            return $this->serverError('Erreur lors de la connexion', null, $e->getMessage());
        }
    }

    /**
     * Verify OTP and complete login
     */
    public function verifyByOtp(VerifyOtpRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $email = $data['email'];
            $otpCode = $data['otp'];

            $user = User::where('email', $email)->first();
            if (! $user) {
                DB::rollback();

                return $this->notFound('Utilisateur non trouvé');
            }

            // Verify OTP
            if (! Otp::verify($email, $otpCode, 'login_verification')) {
                DB::rollback();

                return $this->badRequest('Code OTP invalide ou expiré');
            }

            // Set active enterprise and create auth token
            $this->setActiveEnterprise($user);
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return $this->ok('Connexion réussie', [
                'user' => $user->only('id', 'first_name', 'last_name', 'email'),
                'token' => $token,
                'authEnabledOtp' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);

            return $this->serverError('Erreur lors de la vérification OTP', null, $e->getMessage());
        }
    }

    /**
     * Resend login OTP with progressive delays
     */
    public function resendLoginOtp(ResendLoginOtpRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $email = $request->validated()['email'];

            $user = User::where('email', $email)->first();
            if (! $user) {
                DB::rollback();

                return $this->notFound('Utilisateur non trouvé');
            }

            // Count OTP attempts in the last hour
            $otpCount = Otp::where('identifier', $email)
                ->where('type', 'login_verification')
                ->where('created_at', '>', Carbon::now()->subHour())
                ->count();

            // Get last OTP to check delays
            $lastOtp = Otp::where('identifier', $email)
                ->where('type', 'login_verification')
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
                ->where('type', 'login_verification')
                ->update(['is_valid' => false]);

            // Create new OTP
            $otp = Otp::create([
                'identifier' => $email,
                'code' => Otp::generateCode(),
                'type' => 'login_verification',
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_valid' => true,
            ]);

            // Send OTP email
            Mail::to($email)->send(new OtpMail(
                $otp->code,
                $user->first_name,
                'Code de connexion',
                'connexion'
            ));

            DB::commit();

            return $this->ok('Nouveau code OTP envoyé');
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);

            return $this->serverError('Erreur lors du renvoi du code OTP', null, $e->getMessage());
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            /** @var \App\Models\User $user */
            $user = $request->user();
            if ($user) {
                $user->tokens()->delete();
            }

            DB::commit();

            return $this->ok('Déconnexion réussie');
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error($e);

            return $this->serverError('Erreur lors de la déconnexion', null, $e->getMessage());
        }
    }

    /**
     * Set the active enterprise for the user based on their type
     */
    private function setActiveEnterprise(User $user): void
    {
        if (! $user->activeEnterprise) {
            $latestEnterprise = $user->enterprises()->latest()->first();
            if ($latestEnterprise) {
                $user->update(['active_enterprise_id' => $latestEnterprise->id]);
            }
        }
    }

    /**
     * Calculate resend delay based on attempt count
     *
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
