<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'title' => $this->faker->word,
            // 'description' => $this->faker->sentence,
            // 'user_id' => User::query()->inRandomOrder()->first()->id,
        ];
    }
}
