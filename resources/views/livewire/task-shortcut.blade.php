<x-filament-widgets::widget class="task-shortcut">

    <style>
        .task-shortcut-section {
            min-height: 92px;
        }

        .task-shortcut-section .fi-section-content {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .task-shortcut-section:hover {
            background-color: oklch(0.985 0 0);
        }

        .task-shortcut-section h1 {
            line-height: 24px;
        }

        .task-shortcut-section p {
            color: oklch(0.552 0.016 285.938);
        }

        .task-shortcut-section .heroicon {
            width: 40px;
            height: 40px;
            color: oklch(0.705 0.015 286.067);
            display: grid;
            place-items: center;
        }
    </style>

    <a href="{{ route('filament.app.resources.tasks.create') }}">
        <x-filament::section class="task-shortcut-section">
            <div class="heroicon">
                <x-heroicon-o-clipboard-document-list />
            </div>
            <div>
                <h1 style="font-weight: bold; font-size: 16px;">{{ __('Create a task') }}</h1>
                <p>{{ __('Click here to go directly to creating a task') }}</p>
            </div>
        </x-filament::section>
    </a>

</x-filament-widgets::widget>
