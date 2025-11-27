<?php

use App\Models\User;

it('does not allow guests to access the app panel', function () {
    $this->get('/')
        ->assertRedirect(route('filament.app.auth.login'));
});

it('allows logged in users to access the panel', function () {
    $this->actingAs(User::factory()->create())
        ->get('/')
        ->assertSuccessful();
});
