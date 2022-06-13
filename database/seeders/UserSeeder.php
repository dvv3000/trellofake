<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;


use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(0, 3) as $_){
            User::create([
                'email' => $faker->unique()->email,
                'password' => md5('abc'),
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'avatar' => $faker->boolean ? $faker->imageUrl() : null,
            ]);
        }
    }
}
