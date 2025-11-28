<?php

use App\Filament\Pages\TimeOverview;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    actingAs($user);

    $this->user = $user;
});

it('can load the page', function () {
    livewire(TimeOverview::class)
        ->assertSuccessful();
});
