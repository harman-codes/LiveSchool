<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'mobile' => rand(1111111111, 9999999999),
            'email' => fake()->unique()->safeEmail(),
            'van' => 'PB02AB'.rand(1111,9999),
            'address' => fake()->address(),
            'password' => 1234,
        ];
    }
}
