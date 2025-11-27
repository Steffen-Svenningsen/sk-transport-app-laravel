<?php

use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Pages\ViewTask;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Grave;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskType;
use App\Models\User;
use App\Models\WorkType;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    actingAs($user);

    $this->user = $user;
});

it('can load the list page', function () {
    $tasks = Task::factory()->count(3)->create();

    livewire(ListTasks::class)
        ->assertOk();
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

it('can create an Imerys task via the wizard', function () {
    $imerysTaskType = TaskType::factory()->create(['name' => 'Imerys']);

    $area = Area::factory()->create();
    $grave = Grave::factory()->create();
    $service = Service::factory()->create();
    $workType = WorkType::factory()->create();

    livewire(CreateTask::class)
        ->fillForm([
            'task_type_id' => $imerysTaskType->id,
            'area_id' => $area->id,
            'grave_id' => $grave->id,
            'service_id' => $service->id,
            'work_type_id' => $workType->id,
            'hours' => 8.5,
            'break_hours' => 0.5,
            'comment' => 'This is a test task',
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Task::class, [
        'task_type_id' => $imerysTaskType->id,
        'area_id' => $area->id,
        'grave_id' => $grave->id,
        'hours' => 8.5,
        'break_hours' => 0.5,
        'comment' => 'This is a test task',
    ]);
});

it('can create a Kundeopgave task via the wizard', function () {
    $nonImerysTaskType = TaskType::factory()->create(['name' => 'Kundeopgave']);
    $service = Service::factory()->create();
    $customer = Customer::factory()->create();
    $workType = WorkType::factory()->create();

    livewire(CreateTask::class)
        ->fillForm([
            'task_type_id' => $nonImerysTaskType->id,
            'service_id' => $service->id,
            'work_type_id' => $workType->id,
            'customer_id' => $customer->id,
            'hours' => 4.0,
            'break_hours' => 0.0,
            'comment' => 'This is another test task',
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Task::class, [
        'task_type_id' => $nonImerysTaskType->id,
        'customer_id' => $customer->id,
        'hours' => 4.0,
        'break_hours' => 0.0,
        'comment' => 'This is another test task',
    ]);
});

it('can create any random task via the wizard', function () {
    $taskType = TaskType::factory()->create();
    $area = Area::factory()->create();
    $grave = Grave::factory()->create();
    $service = Service::factory()->create();
    $customer = Customer::factory()->create();
    $workType = WorkType::factory()->create();

    livewire(CreateTask::class)
        ->fillForm([
            'task_type_id' => $taskType->id,
            'service_id' => $service->id,
            'work_type_id' => $workType->id,
            'hours' => 6.0,
            'break_hours' => 1.0,
            'comment' => 'This is a random test task',
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Task::class, [
        'task_type_id' => $taskType->id,
        'service_id' => $service->id,
        'hours' => 6.0,
        'break_hours' => 1.0,
        'comment' => 'This is a random test task',
    ]);
});

it('can update a task', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $newTaskData = Task::factory()->make();

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
