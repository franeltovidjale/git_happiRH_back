<?php

namespace App\Livewire;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class LoginWithOtp extends Component
{
    public $email = '';

    public $password = '';

    public $otp = '';

    public $currentStep = 1; // 1: email/password, 2: OTP

    public $isProcessing = false;

    public $errorMessage = '';

    public $user = null;

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ];
    }

    public function login()
    {
        $this->validate();
        $this->isProcessing = true;
        $this->errorMessage = '';

        try {
            $user = User::where('email', $this->email)->first();

            if (! $user || ! Hash::check($this->password, $user->password)) {
                $this->errorMessage = 'Invalid email or password.';
                $this->isProcessing = false;

                return;
            }

            $this->user = $user;

            // Generate and send OTP
            $otp = Otp::createForIdentifier($user->email, 'login', 10);

            // Send OTP email
            Mail::to($user->email)->send(new \App\Mail\OtpMail($otp->code));

            $this->currentStep = 2;
            $this->isProcessing = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'An error occurred. Please try again.';
            $this->isProcessing = false;
        }
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (strlen($this->otp) !== 6) {
            $this->errorMessage = 'Please enter a valid 6-digit OTP.';

            return;
        }

        $this->isProcessing = true;
        $this->errorMessage = '';

        try {
            $isValid = Otp::verify($this->user->email, $this->otp, 'login');

            if (! $isValid) {
                $this->errorMessage = 'Invalid or expired OTP.';
                $this->isProcessing = false;

                return;
            }

            // Login the user
            Auth::login($this->user);

            // Redirect based on user type
            if ($this->user->type === User::TYPE_ADMIN) {
                return redirect()->route('admin.dashboard');
            } elseif ($this->user->type === User::TYPE_GERANT) {
                return redirect()->route('employer.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'An error occurred. Please try again.';
            $this->isProcessing = false;
        }
    }

    public function resendOtp()
    {
        if (! $this->user) {
            return;
        }

        $this->isProcessing = true;
        $this->errorMessage = '';

        try {
            $otp = Otp::createForIdentifier($this->user->email, 'login', 10);

            // Send OTP email
            Mail::to($this->user->email)->send(new \App\Mail\OtpMail($otp->code));

            $this->isProcessing = false;
            $this->errorMessage = '';
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to resend OTP. Please try again.';
            $this->isProcessing = false;
        }
    }

    public function goBack()
    {
        $this->currentStep = 1;
        $this->otp = '';
        $this->errorMessage = '';
        $this->user = null;
    }

    public function render()
    {
        return view('livewire.login-with-otp');
    }
}
