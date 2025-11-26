<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label(__('Username'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('is_admin')
                    ->label(__('Role'))
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? __('Administrator') : __('Employee'))
                    ->toggleable(),
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-secondary']),
                DeleteAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-primary']),
                RestoreAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-secondary']),
                ForceDeleteAction::make()
                    ->extraAttributes(['class' => 'fi-ta-button-primary']),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label(__('Export to Excel'))
                    ->extraAttributes(['class' => 'fi-button-secondary'])
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->askForFilename(__('users').'-'.now()->format('Y-m-d')),
                    ]),
                CreateAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.users.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label(__('Export to Excel'))
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->askForFilename(__('users').'-'.now()->format('Y-m-d'), __('Filename')),
                        ]),
                ]),
            ]);
    }
}
