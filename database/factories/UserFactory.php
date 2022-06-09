<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'email' => $this->faker->email,
            // 'password' => 'abc',
            // 'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            // 'avatar' => $this->faker->boolean ? $this->faker->imageUrl() : null,
        ];
    }
}
