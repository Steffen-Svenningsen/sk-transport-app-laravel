<?php

namespace App\Filament\Admin\Resources\Tasks;

use App\Filament\Admin\Resources\Tasks\Pages\CreateTask;
use App\Filament\Admin\Resources\Tasks\Pages\EditTask;
use App\Filament\Admin\Resources\Tasks\Pages\ListTasks;
use App\Filament\Admin\Resources\Tasks\Pages\ViewTask;
use App\Filament\Admin\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Admin\Resources\Tasks\Schemas\TaskInfolist;
use App\Filament\Admin\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::count();

        if ($count === 0) {
            return null;
        }

        if ($count > 999) {
            return '999+';
        }

        return (string) $count;
    }

    public static function getNavigationLabel(): string
    {
        return __('Tasks');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Operations');
    }

    public static function getBreadcrumb(): string
    {
        return __('Tasks');
    }

    public static function getModelLabel(): string
    {
        return __('Worktask');
    }

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'view' => ViewTask::route('/{record}'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
