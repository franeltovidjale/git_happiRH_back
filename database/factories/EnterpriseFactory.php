<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Enterprise;
use App\Models\Plan;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enterprise>
 */
class EnterpriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'ifu' => $this->faker->optional()->numerify('##########'),
            'address' => $this->faker->address(),
            'website' => $this->faker->optional()->url(),
            'active' => true,
            'status' => Enterprise::STATUS_ACTIVE,
            'status_by' => User::factory(),
            'status_date' => now(),
            'country_code' => function () {
                return Country::factory()->create()->code;
            },
            'plan_id' => function () {
                return Plan::factory()->create()->id;
            },
            'sector_id' => function () {
                return Sector::factory()->create()->id;
            },
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
            'status' => Enterprise::STATUS_INACTIVE,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => Enterprise::STATUS_PENDING,
        ]);
    }
}
