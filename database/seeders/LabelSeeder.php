<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\Card;
use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();


        foreach(range(1, 5) as $_){
            Label::create([
                'name' => $faker->word,
                // 'card_id' => $cards[array_rand($cards)],
            ]);
        }
    }
}
