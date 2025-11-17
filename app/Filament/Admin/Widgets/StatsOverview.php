<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('user_with_most_tasks_this_week', fn () => User::getUserWithMostTasksThisWeek())
                ->label(__('User with Most Tasks This Week')),

        ];
    }
}
