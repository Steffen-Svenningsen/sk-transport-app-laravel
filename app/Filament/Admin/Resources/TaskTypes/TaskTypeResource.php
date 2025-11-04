<?php

namespace App\Filament\Admin\Resources\TaskTypes;

use App\Filament\Admin\Resources\TaskTypes\Pages\CreateTaskType;
use App\Filament\Admin\Resources\TaskTypes\Pages\EditTaskType;
use App\Filament\Admin\Resources\TaskTypes\Pages\ListTaskTypes;
use App\Filament\Admin\Resources\TaskTypes\Pages\ViewTaskType;
use App\Filament\Admin\Resources\TaskTypes\Schemas\TaskTypeForm;
use App\Filament\Admin\Resources\TaskTypes\Schemas\TaskTypeInfolist;
use App\Filament\Admin\Resources\TaskTypes\Tables\TaskTypesTable;
use App\Models\TaskType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskTypeResource extends Resource
{
    protected static ?string $model = TaskType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TaskTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskTypesTable::configure($table);
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
            'index' => ListTaskTypes::route('/'),
            'create' => CreateTaskType::route('/create'),
            'view' => ViewTaskType::route('/{record}'),
            'edit' => EditTaskType::route('/{record}/edit'),
        ];
    }
}
