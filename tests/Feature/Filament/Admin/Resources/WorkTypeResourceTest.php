<?php

use App\Filament\Admin\Resources\WorkTypes\Pages\CreateWorkType;
use App\Filament\Admin\Resources\WorkTypes\Pages\EditWorkType;
use App\Filament\Admin\Resources\WorkTypes\Pages\ListWorkTypes;
use App\Filament\Admin\Resources\WorkTypes\Pages\ViewWorkType;
use App\Filament\Admin\Resources\WorkTypes\WorkTypeResource;
use App\Models\User;
use App\Models\WorkType;
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
    $workType = WorkType::factory()->count(5)->create();

    livewire(ListWorkTypes::class)
        ->assertOk()
        ->assertCanSeeTableRecords($workType);
});

it('can load the create page', function () {
    livewire(ListWorkTypes::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $workType = WorkType::factory()->create();

    get(WorkTypeResource::getUrl('edit', [
        'record' => $workType->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditWorkType::class, [
        'record' => $workType->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $workType = WorkType::factory()->create();

    get(WorkTypeResource::getUrl('view', [
        'record' => $workType->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewWorkType::class, [
        'record' => $workType->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a WorkType', function () {
    livewire(CreateWorkType::class)
        ->fillForm([
            'name' => 'New WorkType',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(WorkType::class, [
        'name' => 'New WorkType',
    ]);
});

it('can update a WorkType', function () {
    $workType = WorkType::factory()->create();

    livewire(EditWorkType::class, [
        'record' => $workType->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated WorkType',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(WorkType::class, [
        'id' => $workType->id,
        'name' => 'Updated WorkType',
    ]);
});

it('can delete a WorkType', function () {
    $workType = WorkType::factory()->create();

    livewire(EditWorkType::class, [
        'record' => $workType->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $workType->refresh();

    expect($workType->trashed())->toBeTrue();
});

it('can export a WorkType', function () {
    livewire(ListWorkTypes::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListWorkTypes::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListWorkTypes::class)
        ->assertActionExists(TestAction::make('export')->table());
});
