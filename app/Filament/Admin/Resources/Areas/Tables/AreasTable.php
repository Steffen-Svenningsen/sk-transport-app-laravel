<?php

namespace App\Filament\Admin\Resources\Areas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class AreasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferColumnManager(false)
            ->filters([
                //
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
                            ->askForFilename(__('areas').'-'.now()->format('Y-m-d')),
                    ]),
                CreateAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.areas.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label(__('Export to Excel'))
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->askForFilename(__('areas').'-'.now()->format('Y-m-d')),
                        ]),
                ]),
            ]);
    }
}
