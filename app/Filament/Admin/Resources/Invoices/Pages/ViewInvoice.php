<?php

namespace App\Filament\Admin\Resources\Invoices\Pages;

use App\Filament\Admin\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    public function getHeading(): string
    {
        return $this->record->invoice_number;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label(__('Download PDF'))
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->url(fn (Invoice $record) => route('invoices.download', $record), true),
            EditAction::make()
                ->extraAttributes(['class' => 'fi-button-secondary page-header-action']),
            DeleteAction::make(),
        ];
    }
}
