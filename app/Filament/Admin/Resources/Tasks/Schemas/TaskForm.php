<?php

namespace App\Filament\Admin\Resources\Tasks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('task_type_id')
                    ->label(__('Task Type'))
                    ->relationship('taskType', 'name')
                    ->required()
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])),

                Select::make('area_id')
                    ->label(__('Area'))
                    ->relationship('area', 'name')
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])),

                Select::make('grave_id')
                    ->label(__('Grave'))
                    ->relationship('grave', 'name')
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
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
                    ])),

                Select::make('service_id')
                    ->label(__('Service'))
                    ->relationship('service', 'name')
                    ->required()
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])),

                Select::make('customer_id')
                    ->label(__('Customer'))
                    ->relationship('customer', 'name')
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('Phone')),
                        TextInput::make('email')
                            ->label(__('Email')),
                    ])),

                Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->required(),

                Select::make('work_type_id')
                    ->label(__('Work Type'))
                    ->relationship('workType', 'name')
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                    ])),

                TextInput::make('hours')
                    ->label(__('Hours'))
                    ->required()
                    ->numeric()
                    ->maxValue(24.0),

                TextInput::make('break_hours')
                    ->label(__('Break Hours'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->maxValue(4.0)
                    ->rule(function ($get) {
                        $hours = $get('hours');

                        return function (string $attribute, $value, $fail) use ($hours) {
                            if ($value >= $hours) {
                                $fail(__('Break hours must be less than total hours worked'));
                            }
                        };
                    }),

                Textarea::make('comment')
                    ->label(__('Comment'))
                    ->columnSpanFull(),
            ]);
    }
}
