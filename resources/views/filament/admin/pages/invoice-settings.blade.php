<x-filament-panels::page>
    {{ $this->form }}

    <x-filament::button wire:click="save" class="mr-auto w-full md:w-fit">
        {{ __('Save Settings') }}
    </x-filament::button>
</x-filament-panels::page>
