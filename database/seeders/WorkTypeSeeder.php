<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkType::insert([
            ['name' => 'Afrømning/sten', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Re-etablering', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lerkørsel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Opskubning ler i stak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Klargørring i graven', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mødding', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vejmateriale', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Støv silo 11', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rød støv Skamol', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tømme støvsuger container', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tømme container', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anden opgave - Skriv opgaven i kommentarfeltet', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
