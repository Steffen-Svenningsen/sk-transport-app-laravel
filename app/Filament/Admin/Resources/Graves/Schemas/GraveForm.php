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
                    ->label(__('Name'))
                    ->required(),
                Select::make('area_id')
                    ->label(__('Area'))
                    ->relationship('area', 'name')
                    ->required()
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])),
            ]);
    }
}
