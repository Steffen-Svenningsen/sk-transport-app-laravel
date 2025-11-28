<?php

use App\Filament\Admin\Resources\Areas\AreaResource;
use App\Filament\Admin\Resources\Areas\Pages\CreateArea;
use App\Filament\Admin\Resources\Areas\Pages\EditArea;
use App\Filament\Admin\Resources\Areas\Pages\ListAreas;
use App\Filament\Admin\Resources\Areas\Pages\ViewArea;
use App\Models\Area;
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
    $areas = Area::factory()->count(5)->create();

    livewire(ListAreas::class)
        ->assertOk()
        ->assertCanSeeTableRecords($areas);
});

it('can load the create page', function () {
    livewire(ListAreas::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $area = Area::factory()->create();

    get(AreaResource::getUrl('edit', [
        'record' => $area->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditArea::class, [
        'record' => $area->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $area = Area::factory()->create();

    get(AreaResource::getUrl('view', [
        'record' => $area->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewArea::class, [
        'record' => $area->getRouteKey(),
    ])->assertSuccessful();
});

it('can create an area', function () {
    livewire(CreateArea::class)
        ->fillForm([
            'name' => 'New Area',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Area::class, [
        'name' => 'New Area',
    ]);
});

it('can update an area', function () {
    $area = Area::factory()->create();

    livewire(EditArea::class, [
        'record' => $area->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated Area',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Area::class, [
        'id' => $area->id,
        'name' => 'Updated Area',
    ]);
});

it('can delete an area', function () {
    $area = Area::factory()->create();

    livewire(EditArea::class, [
        'record' => $area->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $area->refresh();

    expect($area->trashed())->toBeTrue();
});

it('can export area', function () {
    livewire(ListAreas::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListAreas::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListAreas::class)
        ->assertActionExists(TestAction::make('export')->table());
});
