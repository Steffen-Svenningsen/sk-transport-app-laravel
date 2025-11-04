<?php

namespace App\Filament\Admin\Resources\Graves;

use App\Filament\Admin\Resources\Graves\Pages\CreateGrave;
use App\Filament\Admin\Resources\Graves\Pages\EditGrave;
use App\Filament\Admin\Resources\Graves\Pages\ListGraves;
use App\Filament\Admin\Resources\Graves\Pages\ViewGrave;
use App\Filament\Admin\Resources\Graves\Schemas\GraveForm;
use App\Filament\Admin\Resources\Graves\Schemas\GraveInfolist;
use App\Filament\Admin\Resources\Graves\Tables\GravesTable;
use App\Models\Grave;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GraveResource extends Resource
{
    protected static ?string $model = Grave::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GraveForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GraveInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GravesTable::configure($table);
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
            'index' => ListGraves::route('/'),
            'create' => CreateGrave::route('/create'),
            'view' => ViewGrave::route('/{record}'),
            'edit' => EditGrave::route('/{record}/edit'),
        ];
    }
}
