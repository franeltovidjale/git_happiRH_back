<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sector>
 */
class SectorFactory extends Factory
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

        $name = $this->faker->words(2, true) . ' ' . $counter;

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'parent_id' => null,
        ];
    }
}
