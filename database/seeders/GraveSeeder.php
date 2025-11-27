<?php

namespace Database\Seeders;

use App\Models\Grave;
use Illuminate\Database\Seeder;

class GraveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grave::insert([
            ['name' => 'Harhøj', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vangsgaard', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Østergård', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fabrikken', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'EN Knud VA', 'area_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'EN Anders D', 'area_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Skarrehage', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Elvergården', 'area_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Elke', 'area_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'F106 Conny', 'area_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
