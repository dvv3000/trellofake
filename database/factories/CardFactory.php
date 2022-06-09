<?php

namespace Database\Factories;

use App\Enums\CardStatusEnum;
use App\Enums\CardLabelEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
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
            // 'status' => $this->faker->randomElement(CardStatusEnum::getValues()),
            // 'label' => $this->faker->randomElement(CardLabelEnum::getValues()),
            // 'due_time' => $this->faker->dateTimeThisMonth('now', 'Asia/Ho_Chi_Minh'),
            // 'task_id' => Task::query()->inRandomOrder()->first()->id,
            // 'member_id' => User::query()->inRandomOrder()->first()->id,
        ];
    }
}
