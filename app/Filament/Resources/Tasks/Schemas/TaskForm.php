<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('task_type_id')
                    ->relationship('taskType', 'name')
                    ->required(),
                Select::make('area_id')
                    ->relationship('area', 'name'),
                Select::make('grave_id')
                    ->relationship('grave', 'name'),
                Select::make('service_id')
                    ->relationship('service', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('work_type_id')
                    ->relationship('workType', 'name'),
                DateTimePicker::make('work_date')
                    ->required(),
                TextInput::make('hours')
                    ->required()
                    ->numeric(),
                TextInput::make('break_hours')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }
}
