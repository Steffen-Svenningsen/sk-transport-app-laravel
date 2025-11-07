<?php

namespace App\Filament\Admin\Resources\Services\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Service Information'))
                    ->description(__('Detailed information about the service'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Name')),
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
