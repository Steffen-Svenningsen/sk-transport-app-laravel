<?php

use App\Filament\Admin\Resources\Customers\CustomerResource;
use App\Filament\Admin\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Admin\Resources\Customers\Pages\EditCustomer;
use App\Filament\Admin\Resources\Customers\Pages\ListCustomers;
use App\Filament\Admin\Resources\Customers\Pages\ViewCustomer;
use App\Models\Customer;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;

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
    $customers = Customer::factory()->count(5)->create();

    livewire(ListCustomers::class)
        ->assertOk()
        ->assertCanSeeTableRecords($customers);
});

it('can load the create page', function () {
    livewire(ListCustomers::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $customer = Customer::factory()->create();

    get(CustomerResource::getUrl('edit', [
        'record' => $customer->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditCustomer::class, [
        'record' => $customer->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $customer = Customer::factory()->create();

    get(CustomerResource::getUrl('view', [
        'record' => $customer->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewCustomer::class, [
        'record' => $customer->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a customer', function () {
    livewire(CreateCustomer::class)
        ->fillForm([
            'name' => 'New Customer',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Customer::class, [
        'name' => 'New Customer',
    ]);
});

it('can update a customer', function () {
    $customer = Customer::factory()->create();

    livewire(EditCustomer::class, [
        'record' => $customer->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated Customer',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Customer::class, [
        'id' => $customer->id,
        'name' => 'Updated Customer',
    ]);
});

it('can delete a customer', function () {
    $customer = Customer::factory()->create();

    livewire(EditCustomer::class, [
        'record' => $customer->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $customer->refresh();

    expect($customer->trashed())->toBeTrue();
});

it('can export a customer', function () {
    livewire(ListCustomers::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListCustomers::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListCustomers::class)
        ->assertActionExists(TestAction::make('export')->table());
});
