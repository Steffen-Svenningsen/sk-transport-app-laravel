<?php

namespace App\Filament\Admin\Resources\Tasks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('taskType.name')
                    ->label('Task type'),
                TextEntry::make('area.name')
                    ->label('Area')
                    ->placeholder('-'),
                TextEntry::make('grave.name')
                    ->label('Grave')
                    ->placeholder('-'),
                TextEntry::make('service.name')
                    ->label('Service'),
                TextEntry::make('customer.name')
                    ->label('Customer')
                    ->placeholder('-'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('workType.name')
                    ->label('Work type')
                    ->placeholder('-'),
                TextEntry::make('work_date')
                    ->dateTime(),
                TextEntry::make('hours')
                    ->numeric(),
                TextEntry::make('break_hours')
                    ->numeric(),
                TextEntry::make('comment')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
