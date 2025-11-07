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
                                    ->label(__('Task Type'))
                                    ->url(fn ($record) => $record->taskType ? route('filament.admin.resources.task-types.view', $record->taskType) : null),
                                TextEntry::make('area.name')
                                    ->label(__('Area'))
                                    ->placeholder('-')
                                    ->url(fn ($record) => $record->area ? route('filament.admin.resources.areas.view', $record->area) : null),
                                TextEntry::make('grave.name')
                                    ->label(__('Grave'))
                                    ->placeholder('-')
                                    ->url(fn ($record) => $record->grave ? route('filament.admin.resources.graves.view', $record->grave) : null),
                                TextEntry::make('service.name')
                                    ->label(__('Service'))
                                    ->url(fn ($record) => $record->service ? route('filament.admin.resources.services.view', $record->service) : null),
                                TextEntry::make('customer.name')
                                    ->label(__('Customer'))
                                    ->placeholder('-')
                                    ->url(fn ($record) => $record->customer ? route('filament.admin.resources.customers.view', $record->customer) : null),
                                TextEntry::make('user.name')
                                    ->label(__('User'))
                                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user) : null),
                                TextEntry::make('workType.name')
                                    ->label(__('Work Type'))
                                    ->placeholder('-')
                                    ->url(fn ($record) => $record->workType ? route('filament.admin.resources.work-types.view', $record->workType) : null),
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
