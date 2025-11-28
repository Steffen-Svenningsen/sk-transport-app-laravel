<?php

use App\Filament\Admin\Resources\Services\Pages\CreateService;
use App\Filament\Admin\Resources\Services\Pages\EditService;
use App\Filament\Admin\Resources\Services\Pages\ListServices;
use App\Filament\Admin\Resources\Services\Pages\ViewService;
use App\Filament\Admin\Resources\Services\ServiceResource;
use App\Models\Service;
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
    $service = Service::factory()->count(5)->create();

    livewire(ListServices::class)
        ->assertOk()
        ->assertCanSeeTableRecords($service);
});

it('can load the create page', function () {
    livewire(ListServices::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $service = Service::factory()->create();

    get(ServiceResource::getUrl('edit', [
        'record' => $service->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditService::class, [
        'record' => $service->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $service = Service::factory()->create();

    get(ServiceResource::getUrl('view', [
        'record' => $service->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewService::class, [
        'record' => $service->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a service', function () {
    livewire(CreateService::class)
        ->fillForm([
            'name' => 'New Service',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Service::class, [
        'name' => 'New Service',
    ]);
});

it('can update a service', function () {
    $service = Service::factory()->create();

    livewire(EditService::class, [
        'record' => $service->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated Service',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Service::class, [
        'id' => $service->id,
        'name' => 'Updated Service',
    ]);
});

it('can delete a service', function () {
    $service = Service::factory()->create();

    livewire(EditService::class, [
        'record' => $service->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $service->refresh();

    expect($service->trashed())->toBeTrue();
});

it('can export a service', function () {
    livewire(ListServices::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListServices::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListServices::class)
        ->assertActionExists(TestAction::make('export')->table());
});
