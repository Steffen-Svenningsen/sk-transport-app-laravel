<?php

use App\Models\User;
use Filament\Facades\Filament;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'),
    );
});

it('does not allow guests to access the admin panel', function () {
    get('/admin')
        ->assertRedirect(route('filament.admin.auth.login'));
});

it('does not allow users with role employee to access the admin panel', function () {
    actingAs(User::factory()->create(['is_admin' => false]))
        ->get('/admin')
        ->assertForbidden();
});

it('allows logged in users with role admin to access the panel', function () {
    actingAs(User::factory()->create(['is_admin' => true]))
        ->get('/admin')
        ->assertSuccessful();
});
