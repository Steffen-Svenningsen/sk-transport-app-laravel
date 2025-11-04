<?php

namespace App\Filament\Admin\Resources\Graves\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GraveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('area_id')
                    ->relationship('area', 'name')
                    ->required(),
            ]);
    }
}
