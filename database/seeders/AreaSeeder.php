<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::insert([
            ['name' => 'Mors', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fur', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
