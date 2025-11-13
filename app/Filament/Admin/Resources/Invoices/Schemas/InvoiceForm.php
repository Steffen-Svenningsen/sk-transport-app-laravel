<?php

namespace App\Filament\Admin\Resources\Invoices\Schemas;

use App\Models\Invoice;
use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->label(__('Invoice number'))
                    ->default(fn () => Invoice::getNextInvoiceNumber())
                    ->disabled()
                    ->required()
                    ->dehydrated(true),

                Select::make('customer_id')
                    ->label(__('Customer'))
                    ->relationship('customer', 'name')
                    ->required()
                    ->createOptionForm(fn (Schema $schema) => $schema->components([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                        TextInput::make('phone')
                            ->label(__('Phone')),
                        TextInput::make('email')
                            ->label(__('Email')),
                        TextInput::make('address')
                            ->label(__('Address')),
                        TextInput::make('city')
                            ->label(__('City')),
                    ])),

                DatePicker::make('issue_date')
                    ->label(__('Date'))
                    ->native(false)
                    ->default(now())
                    ->required(),

                TextInput::make('invoice_title')
                    ->label(__('Invoice Title')),

                Repeater::make('product_lines')
                    ->label(__('Products or Services'))
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $lines = collect($get('product_lines') ?? [])
                            ->map(function ($line) {
                                $quantity = floatval($line['quantity'] ?? 0);
                                $unitPrice = floatval($line['unit_price'] ?? 0);
                                $line['total'] = $quantity * $unitPrice;

                                return $line;
                            })
                            ->toArray();

                        $set('product_lines', $lines);

                        $subtotal = collect($lines)->sum(fn ($line) => floatval($line['total'] ?? 0));
                        $tax = round($subtotal * 0.25, 2);
                        $total = $subtotal + $tax;

                        $set('subtotal', $subtotal);
                        $set('tax', $tax);
                        $set('total', $total);
                    })
                    ->schema([
                        Select::make('service_id')
                            ->label(__('Service'))
                            ->options(Service::pluck('name', 'id'))
                            ->searchable()
                            ->placeholder(__('Select a service'))
                            ->required(fn (Get $get) => empty($get('custom_service')))
                            ->disabled(fn (Get $get) => ! empty($get('custom_service'))),

                        TextInput::make('custom_service')
                            ->label(__('Custom Service'))
                            ->helperText(__('Adding a custom service will override the selected service.'))
                            ->placeholder(__('e.g. Transport, Broken bricks etc.')),

                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->validationMessages([
                                'required' => __('Quantity is required.'),
                            ])
                            ->label(__('Quantity'))
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $quantity = floatval($state);
                                $price = floatval($get('unit_price'));
                                $set('total', $quantity * $price);
                            }),

                        TextInput::make('unit_price')
                            ->numeric()
                            ->label(__('Price'))
                            ->required()
                            ->validationMessages([
                                'required' => __('Price is required.'),
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $quantity = floatval($get('quantity'));
                                $price = floatval($state);
                                $set('total', $quantity * $price);
                            }),

                        TextInput::make('total')
                            ->numeric()
                            ->label(__('Total Price'))
                            ->disabled()
                            ->dehydrated(true),
                    ])
                    ->addActionLabel(__('Add more'))
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed(false),

                TextInput::make('subtotal')
                    ->numeric()
                    ->label(__('Subtotal'))
                    ->disabled()
                    ->reactive(),

                TextInput::make('tax')
                    ->numeric()
                    ->label(__('Tax (25%)'))
                    ->disabled()
                    ->reactive(),

                TextInput::make('total')
                    ->numeric()
                    ->label(__('Total'))
                    ->disabled()
                    ->reactive(),
            ]);
    }
}
