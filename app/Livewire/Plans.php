<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Setting;
use Livewire\Component;

class Plans extends Component
{
    public $billingCycle = 'monthly';
    public $businessType = 'tpe_pme'; // 'tpe_pme' or 'custom'
    public $employeeCount = 0;

    public $yearlyPlanRate;

    public function mount()
    {
        $this->yearlyPlanRate = Setting::getSetting('yearlyPlanRate', 0.05);
    }

    public function toggleBillingCycle()
    {
        $this->billingCycle = $this->billingCycle === 'monthly' ? 'yearly' : 'monthly';
    }

    public function setBusinessType($type)
    {
        $this->businessType = $type;
    }

    public function incrementEmployeeCount()
    {
        $this->employeeCount++;
    }

    public function decrementEmployeeCount()
    {
        if ($this->employeeCount > 0) {
            $this->employeeCount--;
        }
    }

    public function getPlansProperty()
    {
        $query = Plan::active()->with('features');

        if ($this->businessType === 'custom') {
            $query->where('is_custom_quote', true);
        } else {
            $query->where('is_custom_quote', false);
        }

        return $query->get();
    }

    public function getYearlyPrice($monthlyPrice)
    {
        $yearlyPrice = $monthlyPrice * 12;
        $discount = $yearlyPrice * $this->yearlyPlanRate;

        return $yearlyPrice - $discount;
    }

    public function getMonthlyPriceFromYearly($yearlyPrice)
    {
        return $yearlyPrice / 12;
    }

    public function formatPrice($plan)
    {
        if ($plan->is_custom_quote) {
            return 'Sur devis';
        }

        $price = $plan->price;
        $pricePerEmployee = $plan->price_per_employee;

        $formattedPrice = number_format($price, 0, ',', ' ') . ' ' . $plan->currency;

        if ($pricePerEmployee > 0) {
            $formattedPrice .= ' + ' . number_format($pricePerEmployee, 0, ',', ' ') . ' ' . $plan->currency . '/employé';
        }

        return $formattedPrice;
    }

    public function calculateTotalPrice($plan)
    {
        if ($plan->is_custom_quote) {
            return null;
        }

        $basePrice = $plan->price;
        $pricePerEmployee = $plan->price_per_employee;

        if ($pricePerEmployee > 0) {
            $totalPrice = $basePrice + ($pricePerEmployee * $this->employeeCount);
        } else {
            $totalPrice = $basePrice;
        }

        return $totalPrice;
    }

    public function formatTotalPrice($plan)
    {
        $totalPrice = $this->calculateTotalPrice($plan);

        if ($totalPrice === null) {
            return 'Sur devis';
        }

        return number_format($totalPrice, 0, ',', ' ') . ' ' . $plan->currency;
    }

    public function getTrialInfo($plan)
    {
        if ($plan->trial_period_months > 0) {
            return $plan->trial_period_months . ' mois d\'essai gratuit';
        }
        return null;
    }

    public function render()
    {
        return view('livewire.plans');
    }
}
