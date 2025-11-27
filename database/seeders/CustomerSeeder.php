<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([
            ['name' => 'Nordmors Murer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
