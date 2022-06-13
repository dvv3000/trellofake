<?php

namespace Database\Seeders;
use Faker\Factory as Faker;

use App\Models\Board;
use App\Models\Task;

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $boards = Board::query()->inRandomOrder()->pluck('id')->toArray();

        foreach(range(1, 20) as $_){
            Task::create([
                'title' => $faker->word,
                'board_id' => $boards[array_rand($boards)],
            ]);
        }
    }
}
