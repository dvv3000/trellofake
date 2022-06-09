<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardSeeder extends Seeder
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

        foreach(range(1, 20) as $index)
        {
            Board::create([
                'title' => $faker->word,
                'description' => $faker->sentence,
            ]);
        }


        // $boards = Board::query()->inRandomOrder()->pluck('id')->toArray();

        // foreach(range(1, 40) as $index)
        // {
        //     DB::table('user_board')->insert([
        //         'user_id' => $users[array_rand($users)],
        //         'board_id' => $boards[array_rand($boards)],
        //     ]);
        // }
    }
}
