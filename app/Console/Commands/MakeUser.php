<?php

namespace App\Console\Commands;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    protected $signature = 'make:user {--name= : Name} {--username= : Username} {--password= : Password} {--admin : Is Admin}';

    protected $description = 'Create a new user for the application';

    public function handle()
    {
        $name = $this->option('name') ?? 'Default Name';
        $username = $this->option('username') ?? 'username';
        $password = $this->option('password') ?? bin2hex(random_bytes(4));
        $is_admin = $this->option('admin') ?? false;

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
