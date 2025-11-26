<?php

namespace App\Filament\Admin\Resources\Customers\Tables;

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

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label(__('Email address'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('address')
                    ->label(__('Address'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label(__('City'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferColumnManager(false)
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-secondary']),
                DeleteAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-primary']),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label(__('Export to Excel'))
                    ->extraAttributes(['class' => 'fi-button-secondary'])
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->askForFilename(__('customers').'-'.now()->format('Y-m-d')),
                    ]),
                CreateAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.customers.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label(__('Export to Excel'))
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->askForFilename(__('customers').'-'.now()->format('Y-m-d')),
                        ]),
                ]),
            ]);
    }
}
