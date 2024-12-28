<?php

namespace Database\Factories;

use App\Helpers\SessionYears;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{

    protected $sections = array('A','B','C','D','E','F');
    protected $gender = array('m','f');


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->email();
        return [
            'name' => fake()->name(),
            'gender' => $this->gender[rand(0,1)],
            'dob' => fake()->date('d-m-Y'),
            'mobile' => rand(1111111111,9999999999),
            'email' => $email,
            'fathername' => fake()->name(),
            'mothername' => fake()->name(),
            'address' => fake()->address(),
            'username' => $email,
            'password' => 1234,
            'selectedsessionyear' => SessionYears::currentSessionYear()
        ];
    }
}
