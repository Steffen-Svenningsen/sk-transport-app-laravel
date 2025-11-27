<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskType::insert([
            ['name' => 'Imerys', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kundeopgave', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intern', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
