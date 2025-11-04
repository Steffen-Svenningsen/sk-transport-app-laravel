<?php

namespace App\Filament\Admin\Resources\WorkTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
