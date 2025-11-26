<x-filament-widgets::widget class="time-overview-widget">

    <style>
        .time-overview-widget .fi-section-content:first-of-type {
            padding: 0;
        }

        .time-overview-widget .outer-wrapper h2 {
            border-bottom: 1px solid oklch(0.92 0.004 286.32);
            padding: 16px 24px;
            font-size: 1rem;
            font-weight: 600;
        }

        .inner-wrapper {
            display: flex;
            gap: 16px;
            padding: 24px;
        }

        .inner-wrapper section,
        .inner-wrapper div {
            flex: 1;
        }

        .input-card h3 {
            font-size: 1rem;
            font-weight: 600;
            border-bottom: 1px solid oklch(0.92 0.004 286.32);
            padding: 1rem;
        }

        .input-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 1rem;
        }

        .time-overview-card {
            height: fit-content;
        }

        .time-overview-card .fi-section-content {
            padding: 1rem !important;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .time-overview-card .fi-section-content div {
            border-radius: 8px;
            padding: 1rem;
        }

        .time-overview-card .fi-section-content div:first-of-type {
            background: oklch(98% 0.016 73.684);
        }

        .time-overview-card .fi-section-content div:nth-of-type(2) {
            background: oklch(96.9% 0.015 12.422);
        }

        .time-overview-card .fi-section-content div:nth-of-type(3) {
            background: oklch(98.6% 0.031 120.757);
            grid-column: span 2;
        }

        .time-overview-card .fi-section-content div:not(:last-of-type) {
        }

        .time-overview-card .fi-section-content div p {
            font-size: 0.875rem;
            color: oklch(0.552 0.016 285.938);
        }

        .time-overview-card .fi-section-content div strong {
            font-size: 1rem;
            font-weight: 600;
        }

        @media (max-width: 748px) {
            .inner-wrapper {
                flex-direction: column;
            }
        }

        @media (max-width: 420px) {
            .time-overview-card .fi-section-content {
                display: flex;
                flex-direction: column;
            }
        }
    </style>

    <x-filament::section class="outer-wrapper">
        <h2>{{ __('Time Overview') }}</h2>

        <div class="inner-wrapper">
            <x-filament::card class="time-overview-card">
                <div>
                    <p>{{ __('Total Time') }}</p>
                    <strong>{{ $this->totalHours }} {{ __('hours') }}</strong>
                </div>
                <div>
                    <p>{{ __('Total Breaktime') }}</p>
                    <strong>{{ $this->breakHours }} {{ __('hours') }}</strong>
                </div>
                <div>
                    <p>{{ __('Total Worktime (Time - Breaktime)') }}</p>
                    <strong>{{ $this->actualHours }} {{ __('hours') }}</strong>
                </div>
            </x-filament::card>
            <x-filament::card class="input-card">
                <h3>{{ __('Filter by date') }}</h3>
                <div class="input-wrapper">
                    <div>
                        <label for="fromDate">{{ __('From Date') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="date"
                                wire:model.live="fromDate"
                            />
                        </x-filament::input.wrapper>
                    </div>

                    <div>
                        <label for="toDate">{{ __('To Date') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="date"
                                wire:model.live="toDate"
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </x-filament::section>

</x-filament-widgets::widget>
