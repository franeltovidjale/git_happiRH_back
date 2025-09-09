<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnterpriseTransaction>
 */
class EnterpriseTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 10000, 500000);
        $statuses = ['pending', 'completed', 'failed', 'cancelled'];

        return [
            'amount' => $amount,
            'status' => $this->faker->randomElement($statuses),
            'currency' => $this->faker->randomElement(['XOF', 'EUR', 'USD']),
            'salaire_net' => $this->faker->optional(0.8)->randomFloat(2, $amount * 0.7, $amount * 0.9),
            'employer_id' => \App\Models\User::factory(),
            'enterprise_id' => \App\Models\Enterprise::factory(),
        ];
    }

    /**
     * Transaction completed state
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Transaction pending state
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Transaction failed state
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'salaire_net' => null,
        ]);
    }
}
