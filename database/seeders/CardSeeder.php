<?php

namespace Database\Seeders;

use App\Enums\CardStatusEnum;
use App\Enums\CardLabelEnum;
use App\Models\Task;
use App\Models\User;
use App\Models\Card;
use App\Models\Label;
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
        $labels = Label::query()->inRandomOrder()->pluck('id')->toArray();
        $tasks = Task::query()->inRandomOrder()->pluck('id')->toArray();

        foreach(range(1, 50) as $index)
        {
            Card::create([
                'title' => $faker->word,
                'description' => $faker->sentence,
                'status' => $faker->randomElement(CardStatusEnum::getValues()),
                'due_time' => $faker->dateTimeThisMonth('now', 'Asia/Ho_Chi_Minh'),
                'task_id' => $tasks[array_rand($tasks)],
                'label_id' => $labels[array_rand($labels)],
            ]);
        }
    }
}
