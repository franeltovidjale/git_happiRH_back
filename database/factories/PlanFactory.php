<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'name' => ucwords($name),
            'slug' => strtolower(str_replace(' ', '-', $name)),
            'description' => $this->faker->sentence(),
            'target_audience' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 5000, 50000),
            'price_per_employee' => $this->faker->randomFloat(2, 100, 1000),
            'trial_period_months' => $this->faker->numberBetween(0, 6),
            'is_custom_quote' => false,
            'currency' => $this->faker->randomElement(['XOF', 'FCFA', 'EUR']),
            'billing_cycle' => Plan::BILLING_CYCLE_MONTHLY,
            'is_active' => true,
            'is_recommended' => false,
        ];
    }
}
