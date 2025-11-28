<?php

use App\Filament\Admin\Resources\Tasks\Pages\CreateTask;
use App\Filament\Admin\Resources\Tasks\Pages\EditTask;
use App\Filament\Admin\Resources\Tasks\Pages\ListTasks;
use App\Filament\Admin\Resources\Tasks\Pages\ViewTask;
use App\Filament\Admin\Resources\Tasks\TaskResource;
use App\Models\Area;
use App\Models\Grave;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskType;
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

    $this->user = $user;
});

it('can load the list page', function () {
    $tasks = Task::factory()->count(5)->create();

    livewire(ListTasks::class)
        ->assertOk()
        ->assertCanSeeTableRecords($tasks);
});

it('can load the create page', function () {
    livewire(CreateTask::class)
        ->assertOk();
});

it('can load the edit page', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    get(TaskResource::getUrl('edit', [
        'record' => $task->getRouteKey(),
    ]))->assertSuccessful();

    livewire(EditTask::class, [
        'record' => $task->getRouteKey(),
    ])->assertSuccessful();
});

it('can load the view page', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    get(TaskResource::getUrl('view', [
        'record' => $task->getRouteKey(),
    ]))->assertSuccessful();

    livewire(ViewTask::class, [
        'record' => $task->getRouteKey(),
    ])->assertSuccessful();
});

it('can create a task', function () {
    $taskType = TaskType::factory()->create();
    $area = Area::factory()->create();
    $grave = Grave::factory()->create();
    $service = Service::factory()->create();
    $workType = WorkType::factory()->create();

    $response = livewire(CreateTask::class)
        ->fillForm([
            'task_type_id' => $taskType->id,
            'area_id' => $area->id,
            'grave_id' => $grave->id,
            'service_id' => $service->id,
            'work_type_id' => $workType->id,
            'hours' => 5.0,
            'break_hours' => 0.5,
            'user_id' => $this->user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified();

    $task = Task::latest()->first();

    $response->assertRedirect(route('filament.admin.resources.tasks.view', $task));

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'task_type_id' => $taskType->id,
        'area_id' => $area->id,
        'grave_id' => $grave->id,
        'service_id' => $service->id,
        'work_type_id' => $workType->id,
        'hours' => 5.0,
        'break_hours' => 0.5,
        'user_id' => $this->user->id,
    ]);
});

it('can update a task', function () {
    $task = Task::factory()->create();

    livewire(EditTask::class, [
        'record' => $task->id,
    ])
        ->fillForm([
            'hours' => 7.0,
            'break_hours' => 0.5,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Task::class, [
        'id' => $task->id,
        'hours' => 7.0,
        'break_hours' => 0.5,
    ]);
});

it('can delete a task', function () {
    $task = Task::factory()->create();

    livewire(EditTask::class, [
        'record' => $task->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $task->refresh();

    expect($task->trashed())->toBeTrue();
});

it('can export task', function () {
    livewire(ListTasks::class)
        ->callAction(TestAction::make('export')->table());

    livewire(ListTasks::class)
        ->assertActionVisible(TestAction::make('export')->table());

    livewire(ListTasks::class)
        ->assertActionExists(TestAction::make('export')->table());
});
