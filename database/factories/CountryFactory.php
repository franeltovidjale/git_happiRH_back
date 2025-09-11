<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        return [
            'name' => $this->faker->country() . ' ' . $counter,
            'flag' => 'flags/' . strtolower($this->faker->countryCode()) . '.png',
            'code' => $this->faker->unique()->countryCode() . $counter,
            'active' => true,
            'lang' => $this->faker->randomElement(['fr', 'en', 'es']),
        ];
    }
}
