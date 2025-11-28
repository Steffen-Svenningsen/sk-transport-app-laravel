<?php

use App\Filament\Admin\Resources\TaskTypes\Pages\CreateTaskType;
use App\Filament\Admin\Resources\TaskTypes\Pages\EditTaskType;
use App\Filament\Admin\Resources\TaskTypes\Pages\ListTaskTypes;
use App\Filament\Admin\Resources\TaskTypes\Pages\ViewTaskType;
use App\Filament\Admin\Resources\TaskTypes\TaskTypeResource;
use App\Models\TaskType;
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
    $taskType = TaskType::factory()->count(5)->create();

    livewire(ListTaskTypes::class)
        ->assertOk()
        ->assertCanSeeTableRecords($taskType);
});

it('can load the create page', function () {
    livewire(ListTaskTypes::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $taskType = TaskType::factory()->create();

    get(TaskTypeResource::getUrl('edit', [
        'record' => $taskType->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditTaskType::class, [
        'record' => $taskType->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $taskType = TaskType::factory()->create();

    get(TaskTypeResource::getUrl('view', [
        'record' => $taskType->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewTaskType::class, [
        'record' => $taskType->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a TaskType', function () {
    livewire(CreateTaskType::class)
        ->fillForm([
            'name' => 'New TaskType',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(TaskType::class, [
        'name' => 'New TaskType',
    ]);
});

it('can update a TaskType', function () {
    $taskType = TaskType::factory()->create();

    livewire(EditTaskType::class, [
        'record' => $taskType->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Updated TaskType',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(TaskType::class, [
        'id' => $taskType->id,
        'name' => 'Updated TaskType',
    ]);
});

it('can delete a TaskType', function () {
    $taskType = TaskType::factory()->create();

    livewire(EditTaskType::class, [
        'record' => $taskType->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $taskType->refresh();

    expect($taskType->trashed())->toBeTrue();
});

it('can export a TaskType', function () {
    livewire(ListTaskTypes::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListTaskTypes::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListTaskTypes::class)
        ->assertActionExists(TestAction::make('export')->table());
});
