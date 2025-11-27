<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AreaSeeder::class,
            CustomerSeeder::class,
            GraveSeeder::class,
            ServiceSeeder::class,
            TaskTypeSeeder::class,
            WorkTypeSeeder::class,
        ]);
    }
}
