<?php

namespace App\Filament\Admin\Resources\Graves\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GraveInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Grave Information'))
                    ->description(__('Detailed information about the grave'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Name')),
                                TextEntry::make('area.name')
                                    ->label(__('Area'))
                                    ->url(fn ($record) => $record->area ? route('filament.admin.resources.areas.view', $record->area) : null),
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
