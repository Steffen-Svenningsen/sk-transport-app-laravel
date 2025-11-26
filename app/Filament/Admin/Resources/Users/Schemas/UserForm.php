<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('username')
                    ->label(__('Username'))
                    ->required()
                    ->unique(ignorable: fn ($record) => $record),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->unique(),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->required(fn ($context) => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null),
                Select::make('is_admin')
                    ->label(__('Role'))
                    ->options([
                        1 => __('Administrator'),
                        0 => __('Employee'),
                    ])
                    ->required()
                    ->default(0),
            ]);
    }
}
