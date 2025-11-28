<?php

use App\Models\User;
use Joaopaulolndev\FilamentEditProfile\Livewire\EditProfileForm;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    actingAs($user);

    $this->user = $user;
});

it('can load the page', function () {
    get(route('filament.app.pages.my-profile'))
        ->assertSuccessful();
});

it('can update profile information', function () {
    Livewire::component('edit_profile_form', EditProfileForm::class);

    livewire(EditProfileForm::class)
        ->set('data.name', 'New Name')
        ->set('data.email', 'newemail@example.com')
        ->call('updateProfile')
        ->assertHasNoErrors();

    assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'New Name',
        'email' => 'newemail@example.com',
    ]);
});
