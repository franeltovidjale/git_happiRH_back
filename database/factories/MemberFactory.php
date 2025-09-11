<?php

namespace Database\Factories;

use App\Models\Enterprise;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enterprise_id' => Enterprise::factory(),
            'user_id' => User::factory(),
            'type' => Member::TYPE_EMPLOYEE,
            'status' => Member::STATUS_ACTIVE,
            'username' => $this->faker->unique()->userName(),
            'birth_date' => $this->faker->optional()->date(),
            'marital_status' => $this->faker->optional()->randomElement(['single', 'married', 'divorced']),
            'nationality' => $this->faker->optional()->country(),
            'role' => $this->faker->optional()->jobTitle(),
            'joining_date' => $this->faker->optional()->date(),
            'status_by' => User::factory(),
            'status_date' => now(),
        ];
    }

    public function employee(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => Member::TYPE_EMPLOYEE,
        ]);
    }

    public function owner(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => Member::TYPE_OWNER,
        ]);
    }

    public function humanResource(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => Member::TYPE_HUMAN_RESOURCE,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => Member::STATUS_SUSPENDED,
        ]);
    }
}
