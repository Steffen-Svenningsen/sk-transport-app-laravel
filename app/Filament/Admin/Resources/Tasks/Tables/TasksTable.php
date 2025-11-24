<?php

namespace App\Filament\Admin\Resources\Tasks\Tables;

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
use Malzariey\FilamentDaterangepickerFilter\Enums\DropDirection;
use Malzariey\FilamentDaterangepickerFilter\Enums\OpenDirection;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('taskTypeWithTrashed.name')
                    ->label(__('Task Type'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('areaWithTrashed.name')
                    ->label(__('Area'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('graveWithTrashed.name')
                    ->label(__('Grave'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('serviceWithTrashed.name')
                    ->label(__('Service'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('customerWithTrashed.name')
                    ->label(__('Customer'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('userWithTrashed.name')
                    ->label(__('Employee'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('workTypeWithTrashed.name')
                    ->label(__('Work Type'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('actual_time')
                    ->label(__('Task Duration (Hours)'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('hours')
                    ->label(__('Hours'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('break_hours')
                    ->label(__('Break Hours'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('user_id')
                    ->label(__('Employee'))
                    ->relationship('user', 'name')
                    ->multiple(),
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
                    ->label(__('Date'))
                    ->drops(DropDirection::UP)
                    ->opens(OpenDirection::CENTER)
                    ->showWeekNumbers(),

            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(Width::FourExtraLarge)
            ->filtersFormSchema(fn (array $filters): array => [
                Section::make('')
                    ->schema([
                        $filters['user_id'],
                        $filters['task_type_id'],
                        $filters['area_id'],
                        $filters['grave_id'],
                        $filters['customer_id'],
                        $filters['created_at'],
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label(__('Export to Excel'))
                    ->extraAttributes(['class' => 'fi-button-secondary'])
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->askForFilename(__('tasks').'-'.now()->format('Y-m-d'))
                            ->withColumns([
                                Column::make('actual_time')
                                    ->heading(__('Task Duration (Hours)'))
                                    ->formatStateUsing(fn ($record) => $record->actual_time),
                            ]),
                    ]),
                CreateAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.tasks.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label(__('Export to Excel'))
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->askForFilename(__('tasks').'-'.now()->format('Y-m-d'), __('Filename'))
                                ->withColumns([
                                    Column::make('actual_time')
                                        ->heading(__('Task Duration (Hours)'))
                                        ->formatStateUsing(fn ($record) => $record->actual_time),
                                ]),
                        ]),
                ]),
            ]);
    }
}
