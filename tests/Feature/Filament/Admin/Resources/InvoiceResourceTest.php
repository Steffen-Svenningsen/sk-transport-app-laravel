<?php

use App\Filament\Admin\Resources\Invoices\InvoiceResource;
use App\Filament\Admin\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Admin\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Admin\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Admin\Resources\Invoices\Pages\ViewInvoice;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'),
    );

    /** @var \App\Models\User $user */
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    actingAs($user);
});

it('can load the list page', function () {
    $invoice = Invoice::factory()->count(5)->create();

    livewire(ListInvoices::class)
        ->assertOk()
        ->assertCanSeeTableRecords($invoice);
});

it('can load the create page', function () {
    livewire(ListInvoices::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $invoice = Invoice::factory()->create();

    get(InvoiceResource::getUrl('edit', [
        'record' => $invoice->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditInvoice::class, [
        'record' => $invoice->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $invoice = Invoice::factory()->create();

    get(InvoiceResource::getUrl('view', [
        'record' => $invoice->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewInvoice::class, [
        'record' => $invoice->getRouteKey(),
    ])->assertSuccessful();
});

it('can create an Invoice', function () {
    $customer = Customer::factory()->create();
    $service = Service::factory()->create();

    Repeater::fake();

    livewire(CreateInvoice::class)
        ->fillForm([
            'customer_id' => $customer->id,
            'issue_date' => now()->toDateString(),
            'product_lines' => [
                [
                    'service_id' => $service->id,
                    'custom_service' => null,
                    'quantity' => 1,
                    'unit_price' => 100,
                    'total' => 100,
                ],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Invoice::class, [
        'customer_id' => $customer->id,
        'product_lines' => json_encode([
            [
                'service_id' => $service->id,
                'custom_service' => null,
                'quantity' => 1,
                'unit_price' => 100,
                'total' => 100,
            ],
        ]),
    ]);

    expect(Invoice::whereDate('issue_date', now()->toDateString())->exists())->toBeTrue();
});

it('can update a Invoice', function () {
    $invoice = Invoice::factory()->create();

    Repeater::fake();

    livewire(EditInvoice::class, [
        'record' => $invoice->getRouteKey(),
    ])
        ->fillForm([
            'product_lines' => [
                [
                    'custom_service' => 'Custom Service Name',
                    'quantity' => 2,
                    'unit_price' => 100,
                    'total' => 200,
                ],
            ],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $invoice->refresh();

    expect($invoice->product_lines[0])->toMatchArray([
        'custom_service' => 'Custom Service Name',
        'quantity' => 2,
        'unit_price' => 100,
        'total' => 200,
    ]);
});

it('can delete a Invoice', function () {
    $invoice = Invoice::factory()->create();

    livewire(EditInvoice::class, [
        'record' => $invoice->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $invoice->refresh();

    expect($invoice->trashed())->toBeTrue();
});

it('can download invoice', function () {
    $invoice = Invoice::factory()->create();

    livewire(ViewInvoice::class, [
        'record' => $invoice->getRouteKey(),
    ])
        ->callAction('download')
        ->assertSuccessful();
});
