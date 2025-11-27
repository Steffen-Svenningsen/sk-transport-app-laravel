<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            ['name' => 'Lastbil', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gummiged', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '30 tons Gravemaskine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '40 tons Gravemaskine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minigraver', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Varebil m. trailer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mandetimer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
