<?php

namespace App\Filament\Admin\Resources\Invoices\Tables;

use App\Models\Invoice;
use App\Models\InvoiceSetting;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Enums\DropDirection;
use Malzariey\FilamentDaterangepickerFilter\Enums\OpenDirection;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('Invoice number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customerWithTrashed.name')
                    ->label(__('Customer'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('issue_date')
                    ->label(__('Date'))
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('payment_due_date')
                    ->label(__('Payment Due Date'))
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('subtotal')
                    ->money('dkk')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total')
                    ->money('dkk')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferColumnManager(false)
            ->filters([
                SelectFilter::make('customer_id')
                    ->label(__('Customer'))
                    ->relationship('customer', 'name')
                    ->multiple(),
                DateRangeFilter::make('created_at')
                    ->label(__('Date'))
                    ->drops(DropDirection::AUTO)
                    ->opens(OpenDirection::CENTER)
                    ->showWeekNumbers(),
            ], layout: FiltersLayout::Modal)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                Action::make('download')
                    ->label(__('Download PDF'))
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(function (Invoice $record) {
                        $settings = InvoiceSetting::first();

                        if (! $settings) {
                            Notification::make()
                                ->title(__('Missing Invoice Settings'))
                                ->body(__('You must configure your invoice settings in order to download invoice PDFs'))
                                ->danger()
                                ->send();

                            return;
                        }

                        return redirect()->route('invoices.download', $record);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.invoices.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // TODO: Implement download bulk action
                    // Action::make('download')
                    //     ->label(__('Download PDFs'))
                    //     ->icon(Heroicon::OutlinedArrowDownTray),
                ]),
            ]);
    }
}
