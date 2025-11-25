<?php

namespace App\Filament\Admin\Resources\Invoices\Pages;

use App\Filament\Admin\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
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
            EditAction::make()
                ->extraAttributes(['class' => 'fi-button-secondary page-header-action']),
            DeleteAction::make(),
        ];
    }
}
