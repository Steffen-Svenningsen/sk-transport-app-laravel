<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LatestTasks extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Task::query()
                ->where('user_id', Auth::id())
                ->latest()
                ->limit(10)
            )
            ->paginated(false)
            ->heading(__('My Latest Tasks'))
            ->columns([
                TextColumn::make('taskTypeWithTrashed.name')
                    ->label(__('Task Type'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('actual_time')
                    ->label(__('Task Duration (Hours)'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->sortable()
                    ->searchable(),
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
                return route('filament.app.resources.tasks.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
