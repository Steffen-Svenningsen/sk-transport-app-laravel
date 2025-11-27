<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Steffen Svenningsen',
                'username' => 'stsv0001',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
