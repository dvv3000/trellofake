<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Board::factory(20)->create();
        // Task::factory(40)->create();
        // User::factory(5)->create();
        // Card::factory(100)->create();
        $this->call([
            UserSeeder::class,
            BoardSeeder::class,
            TaskSeeder::class,
            LabelSeeder::class,
            CardSeeder::class,
            
        ]);
    }
}
