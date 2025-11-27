<?php

use App\Models\User;
use Filament\Facades\Filament;

beforeEach(function () {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'),
    );
});

it('does not allow guests to access the admin panel', function () {
    $this->get('/admin')
        ->assertRedirect(route('filament.admin.auth.login'));
});

it('does not allow users with role employee to access the admin panel', function () {
    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->get('/admin')
        ->assertForbidden();
});

it('allows logged in users with role admin to access the panel', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->get('/admin')
        ->assertSuccessful();
});
