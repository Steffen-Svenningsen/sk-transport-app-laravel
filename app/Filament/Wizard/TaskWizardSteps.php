<?php

namespace App\Filament\Wizard;

use App\Models\TaskType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class TaskWizardSteps
{
    public static function getWizardSteps(): array
    {
        return [
            Step::make(__('Task Type'))
                ->schema([
                    Select::make('task_type_id')
                        ->label(__('Task Type'))
                        ->relationship('taskType', 'name')
                        ->required()
                        ->reactive()
                        ->validationMessages([
                            'required' => __('The task type field is required'),
                        ])
                        ->createOptionForm(fn (Schema $schema) => $schema->components([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                        ]))
                        ->createOptionAction(fn ($action) => $action->visible(fn () => Auth::user()->is_admin)),
                ]),

            Step::make(__('Task Details'))
                ->schema([
                    Select::make('area_id')
                        ->label(__('Area'))
                        ->relationship('area', 'name')
                        ->required()
                        ->visible(fn (Get $get): bool => optional(TaskType::find($get('task_type_id')))->name == 'Imerys')
                        ->validationMessages([
                            'required' => __('The area field is required'),
                        ])
                        ->createOptionForm(fn (Schema $schema) => $schema->components([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                        ]))
                        ->createOptionAction(fn ($action) => $action->visible(fn () => Auth::user()->is_admin)),

                    Select::make('grave_id')
                        ->label(__('Grave'))
                        ->relationship('grave', 'name')
                        ->required()
                        ->visible(fn (Get $get): bool => optional(TaskType::find($get('task_type_id')))->name == 'Imerys')
                        ->validationMessages([
                            'required' => __('The grave field is required'),
                        ])
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
                        ]))
                        ->createOptionAction(fn ($action) => $action->visible(fn () => Auth::user()->is_admin)),

                    Select::make('service_id')
                        ->label(__('Service'))
                        ->relationship('service', 'name')
                        ->required()
                        ->validationMessages([
                            'required' => __('The service field is required'),
                        ])
                        ->createOptionForm(fn (Schema $schema) => $schema->components([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                        ]))
                        ->createOptionAction(fn ($action) => $action->visible(fn () => Auth::user()->is_admin)),

                    Select::make('customer_id')
                        ->label(__('Customer'))
                        ->relationship('customer', 'name')
                        ->required()
                        ->visible(fn (Get $get): bool => optional(TaskType::find($get('task_type_id')))->name == 'Kundeopgave')
                        ->validationMessages([
                            'required' => __('The customer field is required'),
                        ]),

                    Select::make('work_type_id')
                        ->label(__('Work Type'))
                        ->relationship('workType', 'name')
                        ->hidden(fn (Get $get): bool => optional(TaskType::find($get('task_type_id')))->name == 'SK Transport')
                        ->createOptionForm(fn (Schema $schema) => $schema->components([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required(),
                        ]))
                        ->createOptionAction(fn ($action) => $action->visible(fn () => Auth::user()->is_admin)),
                ]),

            Step::make(__('Time'))
                ->schema([
                    TextInput::make('hours')
                        ->label(__('Hours'))
                        ->required()
                        ->validationMessages([
                            'required' => __('The hours field is required'),
                        ])
                        ->numeric()
                        ->maxValue(24.0),

                    TextInput::make('break_hours')
                        ->label(__('Break Hours'))
                        ->required()
                        ->validationMessages([
                            'required' => __('The break hours field is required'),
                        ])
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
                ]),

            Step::make(__('Comment'))
                ->schema([
                    Textarea::make('comment')
                        ->label(__('Comment'))
                        ->columnSpanFull(),
                ]),
        ];
    }
}
