<?php

namespace App\Livewire;

use App\Mail\EnterpriseRegisteredMail;
use App\Models\Country;
use App\Models\Enterprise;
use App\Models\EnterprisePayment;
use App\Models\Member;
use App\Models\PaymentReminder;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class GetStarted extends Component
{
    public $currentStep = 1;

    public $selectedPlanId;

    public $selectedPlan;

    // Step 2 form fields
    public $email;

    public $phone;

    public $countryCode;

    public $enterpriseName;

    public $employeesCount = 0;

    public $billingCycle = 'monthly';

    public $isProcessing = false;

    public function mount($plan = null)
    {
        if ($plan) {
            $this->selectedPlan = $plan;
            $this->selectedPlanId = $plan->id;
        } else {
            $this->selectedPlan = Plan::active()->with('features')->first();
            $this->selectedPlanId = $this->selectedPlan->id;
        }

        $this->employeesCount = intval(request('employeesCount', 0));
        $this->billingCycle = request('billingCycle', 'monthly');
    }

    public function nextStep()
    {
        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    public function register()
    {

        $this->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'countryCode' => ['required', 'exists:countries,code'],
            'enterpriseName' => ['required', 'string', 'max:255'],
        ]);
        $this->isProcessing = true;
        DB::beginTransaction();
        try {

            // Generate a secure 12-character password
            $generatedPassword = Str::random(12);

            // Create user
            $user = User::create([
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($generatedPassword),
                'type' => User::TYPE_GERANT,
                'is_deletable' => false,
            ]);

            // Create enterprise
            $enterprise = Enterprise::create([
                'name' => $this->enterpriseName,
                'email' => $this->email,
                'phone' => $this->phone,
                'country_code' => $this->countryCode,
                'plan_id' => $this->selectedPlanId,
                'status' => Enterprise::STATUS_REQUESTED,
                'status_by' => $user->id,
                'status_date' => now(),
            ]);

            // Set user's active enterprise
            $user->update(['active_enterprise_id' => $enterprise->id]);

            // Create member relationship
            Member::create([
                'enterprise_id' => $enterprise->id,
                'user_id' => $user->id,
                'type' => User::TYPE_GERANT,
                'status' => Member::STATUS_ACTIVE,
                'status_by' => $user->id,
            ]);

            // Calculate next payment date based on billing cycle
            $nextPaymentDate = $this->billingCycle === 'yearly' ? now()->addYear() : now()->addMonth();

            // Create EnterprisePayment record
            EnterprisePayment::create([
                'enterprise_id' => $enterprise->id,
                'payment_date' => now(),
                'next_payment_date' => $nextPaymentDate,
                'amount' => $this->calculateTotalPrice(),
                'transaction_id' => 'INIT-' . uniqid(),
                'status' => EnterprisePayment::STATUS_PAID,
            ]);

            // Create PaymentReminder records based on billing cycle
            if ($this->billingCycle === 'yearly') {
                // For yearly billing: 2 months, 1 month, 10 days, 5 days, 1 day before
                $reminderDates = [
                    $nextPaymentDate->copy()->subMonths(2),
                    $nextPaymentDate->copy()->subMonth(),
                    $nextPaymentDate->copy()->subDays(10),
                    $nextPaymentDate->copy()->subDays(5),
                    $nextPaymentDate->copy()->subDay(),
                ];
            } else {
                // For monthly billing: 10 days, 5 days, 1 day before
                $reminderDates = [
                    $nextPaymentDate->copy()->subDays(10),
                    $nextPaymentDate->copy()->subDays(5),
                    $nextPaymentDate->copy()->subDay(),
                ];
            }

            foreach ($reminderDates as $reminderDate) {
                PaymentReminder::create([
                    'enterprise_id' => $enterprise->id,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'alert_date' => $reminderDate,
                ]);
            }

            DB::commit();

            // Send welcome email with credentials
            Mail::to($this->email)->send(new EnterpriseRegisteredMail(
                $this->enterpriseName,
                $this->email,
                $generatedPassword,
                $enterprise->status
            ));

            session()->put('enterprise_id', $enterprise->id);

            return redirect()->route('public.register-success');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            $this->isProcessing = false;
            session()->flash('error', 'Une erreur est survenue lors de la création du compte.');
        }
    }

    public function getCountriesProperty()
    {
        return Country::active()->get();
    }

    public function calculateTotalPrice()
    {
        if ($this->selectedPlan->is_custom_quote) {
            return null;
        }

        $basePrice = $this->selectedPlan->price;
        $pricePerEmployee = $this->selectedPlan->price_per_employee;

        if ($pricePerEmployee > 0) {
            $totalPrice = $basePrice + ($pricePerEmployee * $this->employeesCount);
        } else {
            $totalPrice = $basePrice;
        }

        return $totalPrice;
    }

    public function formatTotalPrice()
    {
        $totalPrice = $this->calculateTotalPrice();

        if ($totalPrice === null) {
            return 'Sur devis';
        }

        if ($this->billingCycle === 'yearly') {
            $yearlyPlanRate = \App\Models\Setting::getSetting('yearlyPlanRate', 0.05);
            $yearlyPrice = $totalPrice * 12;
            $discount = $yearlyPrice * $yearlyPlanRate;
            $finalPrice = $yearlyPrice - $discount;

            return number_format($finalPrice, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /an';
        }

        return number_format($totalPrice, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /mois';
    }

    public function getMonthlyPriceFromYearly()
    {
        if ($this->billingCycle !== 'yearly') {
            return null;
        }

        $totalPrice = $this->calculateTotalPrice();
        if ($totalPrice === null) {
            return null;
        }

        $yearlyPlanRate = \App\Models\Setting::getSetting('yearlyPlanRate', 0.05);
        $yearlyPrice = $totalPrice * 12;
        $discount = $yearlyPrice * $yearlyPlanRate;
        $finalPrice = $yearlyPrice - $discount;

        return number_format($finalPrice / 12, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /mois';
    }

    public function formatBasePrice()
    {
        if ($this->billingCycle === 'yearly') {
            $yearlyPlanRate = \App\Models\Setting::getSetting('yearlyPlanRate', 0.05);
            $yearlyPrice = $this->selectedPlan->price * 12;
            $discount = $yearlyPrice * $yearlyPlanRate;
            $finalPrice = $yearlyPrice - $discount;

            return number_format($finalPrice, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /an';
        }

        return number_format($this->selectedPlan->price, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /mois';
    }

    public function formatPricePerEmployee()
    {
        if ($this->selectedPlan->price_per_employee <= 0) {
            return null;
        }

        if ($this->billingCycle === 'yearly') {
            $yearlyPlanRate = \App\Models\Setting::getSetting('yearlyPlanRate', 0.05);
            $yearlyPrice = $this->selectedPlan->price_per_employee * 12;
            $discount = $yearlyPrice * $yearlyPlanRate;
            $finalPrice = $yearlyPrice - $discount;

            return number_format($finalPrice, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /an';
        }

        return number_format($this->selectedPlan->price_per_employee, 0, ',', ' ') . ' ' . $this->selectedPlan->currency . ' /mois';
    }

    public function render()
    {
        return view('livewire.get-started');
    }
}
