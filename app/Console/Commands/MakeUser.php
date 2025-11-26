<?php

namespace App\Console\Commands;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    protected $signature = 'make:user';

    protected $description = 'Create a new user for the application';

    public function handle()
    {
        $name = $this->ask('Name');
        $username = $this->ask('Username');
        $password = $this->secret('Password');
        $is_admin = $this->confirm('Should the user be an Admin?');

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'is_admin' => $is_admin,
        ]);

        Filament::auth()->login($user);

        $this->info('User created!');

        return static::SUCCESS;
    }
}
