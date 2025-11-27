<?php

use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('can render the page', function () {
    get(TaskResource::getUrl('create'))
        ->assertSuccessful();
});

it('can create a Imerys task', function () {
    livewire(CreateTask::class)
        ->fillForm([
            'name' => 'Test Task',
            'description' => 'This is a test task description.',
            'due_date' => now()->addWeek()->toDateString(),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas('tasks', [

    ])
})
