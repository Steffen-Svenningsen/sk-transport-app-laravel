<?php

namespace App\Filament\Admin\Resources\Tasks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Task Details'))
                    ->description(__('Detailed information about the task'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('taskType.name')
                                    ->label(__('Task Type')),
                                TextEntry::make('area.name')
                                    ->label(__('Area'))
                                    ->placeholder('-'),
                                TextEntry::make('grave.name')
                                    ->label(__('Grave'))
                                    ->placeholder('-'),
                                TextEntry::make('service.name')
                                    ->label(__('Service')),
                                TextEntry::make('customer.name')
                                    ->label(__('Customer'))
                                    ->placeholder('-'),
                                TextEntry::make('user.name')
                                    ->label(__('User')),
                                TextEntry::make('workType.name')
                                    ->label(__('Work Type'))
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpan(2)
                    ->columnSpanFull(),
                Section::make(__('Date and Time'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),
                                TextEntry::make('actual_time')
                                    ->label(__('Task Duration (Hours)'))
                                    ->numeric(),
                                TextEntry::make('hours')
                                    ->label(__('Hours'))
                                    ->numeric(),
                                TextEntry::make('break_hours')
                                    ->label(__('Break Hours'))
                                    ->numeric(),
                            ]),
                    ]),
                Section::make(__('Comment'))
                    ->schema([
                        TextEntry::make('comment')
                            ->hiddenLabel()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
