<?php

use App\Filament\Admin\Resources\Graves\GraveResource;
use App\Filament\Admin\Resources\Graves\Pages\CreateGrave;
use App\Filament\Admin\Resources\Graves\Pages\EditGrave;
use App\Filament\Admin\Resources\Graves\Pages\ListGraves;
use App\Filament\Admin\Resources\Graves\Pages\ViewGrave;
use App\Models\Area;
use App\Models\Grave;
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
    $graves = Grave::factory()->count(5)->create();

    livewire(ListGraves::class)
        ->assertOk()
        ->assertCanSeeTableRecords($graves);
});

it('can load the create page', function () {
    livewire(ListGraves::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $grave = Grave::factory()->create();

    get(GraveResource::getUrl('edit', [
        'record' => $grave->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditGrave::class, [
        'record' => $grave->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $grave = Grave::factory()->create();

    get(GraveResource::getUrl('view', [
        'record' => $grave->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewGrave::class, [
        'record' => $grave->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a grave', function () {
    $area = Area::factory()->create();

    livewire(CreateGrave::class)
        ->fillForm([
            'name' => 'New Grave',
            'area_id' => $area->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Grave::class, [
        'name' => 'New Grave',
        'area_id' => $area->id,
    ]);
});

it('can update a grave', function () {
    $grave = Grave::factory()->create();

    livewire(EditGrave::class, [
        'record' => $grave->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated Grave',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Grave::class, [
        'id' => $grave->id,
        'name' => 'Updated Grave',
    ]);
});

it('can delete a grave', function () {
    $grave = Grave::factory()->create();

    livewire(EditGrave::class, [
        'record' => $grave->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $grave->refresh();

    expect($grave->trashed())->toBeTrue();
});

it('can export a grave', function () {
    livewire(ListGraves::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListGraves::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListGraves::class)
        ->assertActionExists(TestAction::make('export')->table());
});
