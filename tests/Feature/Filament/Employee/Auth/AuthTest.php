<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('does not allow guests to access the app panel', function () {
    get('/')
        ->assertRedirect(route('filament.app.auth.login'));
});

it('allows logged in users to access the panel', function () {

    actingAs(User::factory()->create())
        ->get('/')
        ->assertSuccessful();
});
