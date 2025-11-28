<?php

use App\Filament\Admin\Pages\InvoiceSettings;
use App\Models\User;
use Filament\Facades\Filament;
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
    ]);

    actingAs($user);

    $this->user = $user;
});

it('can load the page', function () {
    get(route('filament.admin.pages.invoice-settings'))
        ->assertSuccessful();
});

it('can update invoice settings', function () {
    Livewire::component('edit_profile_form', InvoiceSettings::class);

    livewire(InvoiceSettings::class)
        ->set('data.company_name', 'New Name')
        ->set('data.email', 'newemail@example.com')
        ->set('data.address', 'New Address')
        ->set('data.zip', '1234')
        ->set('data.city', 'New City')
        ->set('data.cvr_number', '87654321')
        ->set('data.phone', '12345678')
        ->set('data.bank_name', 'New Bank')
        ->set('data.reg_number', '4321')
        ->set('data.account_number', '0123456789')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('invoice_settings', [
        'id' => $this->user->id,
        'company_name' => 'New Name',
        'email' => 'newemail@example.com',
        'address' => 'New Address',
        'zip' => '1234',
        'city' => 'New City',
        'cvr_number' => '87654321',
        'phone' => '12345678',
        'bank_name' => 'New Bank',
        'reg_number' => '4321',
        'account_number' => '0123456789',
    ]);
});
