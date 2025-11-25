<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTasks extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Task::query()
                ->latest()
                ->limit(10)
            )
            ->paginated(false)
            ->heading(__('Latest Tasks'))
            ->columns([
                TextColumn::make('taskTypeWithTrashed.name')
                    ->label(__('Task Type'))
                    ->sortable(),
                TextColumn::make('userWithTrashed.name')
                    ->label(__('Employee'))
                    ->sortable(),
                TextColumn::make('actual_time')
                    ->label(__('Task Duration (Hours)'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.tasks.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
