<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('taskType.name')
                    ->label(__('Task Type'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('areaWithTrashed.name')
                    ->label(__('Area'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('grave.name')
                    ->label(__('Grave'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('service.name')
                    ->label(__('Service'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('customer.name')
                    ->label(__('Customer'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('workType.name')
                    ->label(__('Work Type'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('hours')
                    ->label(__('Hours'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('break_hours')
                    ->label(__('Break Hours'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferColumnManager(false)
            ->filters([
                SelectFilter::make('task_type_id')
                    ->label(__('Task Type'))
                    ->relationship('taskType', 'name')
                    ->multiple(),
                SelectFilter::make('area_id')
                    ->label(__('Area'))
                    ->relationship('area', 'name')
                    ->multiple(),
                SelectFilter::make('grave_id')
                    ->label(__('Grave'))
                    ->relationship('grave', 'name')
                    ->multiple(),
                SelectFilter::make('customer_id')
                    ->label(__('Customer'))
                    ->relationship('customer', 'name')
                    ->multiple(),
                DateRangeFilter::make('created_at')
                    ->label(__('Date')),

            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(Width::FourExtraLarge)
            ->filtersFormSchema(fn (array $filters): array => [
                Section::make('')
                    ->schema([
                        $filters['task_type_id'],
                        $filters['area_id'],
                        $filters['grave_id'],
                        $filters['customer_id'],
                        $filters['created_at'],
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.app.resources.tasks.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
