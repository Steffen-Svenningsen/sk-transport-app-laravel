<?php

use App\Models\User;
use Filament\Facades\Filament;
use Joaopaulolndev\FilamentEditProfile\Livewire\EditProfileForm;
use Livewire\Livewire;

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
        'password' => bcrypt('password'),
    ]);

    actingAs($user);

    $this->user = $user;
});

it('can load the page', function () {
    get(route('filament.admin.pages.my-profile'))
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
