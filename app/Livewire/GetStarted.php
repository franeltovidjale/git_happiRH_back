<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Enterprise;
use App\Models\Member;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class GetStarted extends Component
{
    public $currentStep = 1;

    public $selectedPlanId;

    public $availablePlans;

    // Step 2 form fields
    public $email;

    public $phone;

    public $password;

    public $countryCode;

    public $employeeCount;

    public $showPassword = false;

    public function mount($plan = null)
    {
        $this->availablePlans = Plan::active()->with('features')->get();

        if ($plan) {
            $this->selectedPlanId = $plan->id;
        } else {
            $this->selectedPlanId = $this->availablePlans->first()->id;
        }
    }

    public function selectPlan($planId)
    {
        $this->selectedPlanId = $planId;
    }

    public function nextStep()
    {
        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    public function togglePassword()
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function register()
    {
        $this->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', Password::defaults()],
            'countryCode' => ['required', 'exists:countries,code'],
            'employeeCount' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'type' => User::TYPE_GERANT,
                'is_deletable' => false,
            ]);

            // Create enterprise
            $enterprise = Enterprise::create([
                'name' => 'Entreprise de '.$user->email,
                'email' => $this->email,
                'phone' => $this->phone,
                'country_code' => $this->countryCode,
                'plan_id' => $this->selectedPlanId,
                'owner_id' => $user->id,
                'status' => Enterprise::STATUS_ACTIVE,
                'status_by' => $user->id,
                'status_date' => now(),
            ]);

            // Set user's active enterprise
            $user->update(['active_enterprise_id' => $enterprise->id]);

            // Create member relationship
            Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'type' => Member::TYPE_OWNER,
                'status' => Member::STATUS_ACTIVE,
                'status_by' => $user->id,
            ]);

            DB::commit();

            // Log in the user
            auth()->login($user);

            // Redirect to dashboard
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue lors de la création du compte.');
        }
    }

    public function getSelectedPlanProperty()
    {
        return $this->availablePlans->find($this->selectedPlanId);
    }

    public function getCountriesProperty()
    {
        return Country::active()->get();
    }

    public function render()
    {
        return view('livewire.get-started');
    }
}
