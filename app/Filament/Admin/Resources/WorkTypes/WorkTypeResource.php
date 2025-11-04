<?php

namespace App\Filament\Admin\Resources\WorkTypes;

use App\Filament\Admin\Resources\WorkTypes\Pages\CreateWorkType;
use App\Filament\Admin\Resources\WorkTypes\Pages\EditWorkType;
use App\Filament\Admin\Resources\WorkTypes\Pages\ListWorkTypes;
use App\Filament\Admin\Resources\WorkTypes\Pages\ViewWorkType;
use App\Filament\Admin\Resources\WorkTypes\Schemas\WorkTypeForm;
use App\Filament\Admin\Resources\WorkTypes\Schemas\WorkTypeInfolist;
use App\Filament\Admin\Resources\WorkTypes\Tables\WorkTypesTable;
use App\Models\WorkType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkTypeResource extends Resource
{
    protected static ?string $model = WorkType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return WorkTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkTypesTable::configure($table);
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
            'index' => ListWorkTypes::route('/'),
            'create' => CreateWorkType::route('/create'),
            'view' => ViewWorkType::route('/{record}'),
            'edit' => EditWorkType::route('/{record}/edit'),
        ];
    }
}
