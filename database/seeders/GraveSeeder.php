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
        Grave::factory()->count(5)->create();
    }
}
