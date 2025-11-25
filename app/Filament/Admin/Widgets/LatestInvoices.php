<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Invoice;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestInvoices extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Invoice::query()
                ->latest()
                ->limit(10)
            )
            ->paginated(false)
            ->heading(__('Latest Invoices'))
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('Invoice number'))
                    ->sortable(),
                TextColumn::make('customerWithTrashed.name')
                    ->label(__('Customer'))
                    ->sortable(),
                TextColumn::make('issue_date')
                    ->label(__('Date'))
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('payment_due_date')
                    ->label(__('Payment Due Date'))
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('total')
                    ->money('dkk')
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
                return route('filament.admin.resources.invoices.view', $record);
            })
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
