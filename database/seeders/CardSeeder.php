<?php

namespace Database\Seeders;

use App\Enums\CardStatusEnum;
use App\Enums\CardLabelEnum;
use App\Models\Task;
use App\Models\User;
use App\Models\Card;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::query()->inRandomOrder()->pluck('id')->toArray();
        $tasks = Task::query()->inRandomOrder()->pluck('id')->toArray();

        foreach(range(1, 100) as $index)
        {
            Card::create([
                'title' => $faker->word,
                'description' => $faker->sentence,
                'status' => $faker->randomElement(CardStatusEnum::getValues()),
                'label' => $faker->randomElement(CardLabelEnum::getValues()),
                'due_time' => $faker->dateTimeThisMonth('now', 'Asia/Ho_Chi_Minh'),
                'task_id' => $tasks[array_rand($tasks)],
                'member_id' => $users[array_rand($users)],
            ]);
        }
    }
}
