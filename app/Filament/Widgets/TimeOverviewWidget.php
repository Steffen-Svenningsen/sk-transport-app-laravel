<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;

class TimeOverviewWidget extends Widget
{
    protected string $view = 'filament.widgets.time-overview-widget';

    protected int|string|array $columnSpan = 'full';

    public ?int $userId = null;

    public ?string $fromDate = null;

    public ?string $toDate = null;

    public function mount(?int $userId = null): void
    {
        $this->userId = $userId;
        $this->fromDate = now()->startOfMonth()->toDateString();
        $this->toDate = now()->endOfMonth()->toDateString();
    }

    public function getTotalHoursProperty(): float
    {
        return Task::query()
            ->when($this->userId, fn ($q) => $q->where('user_id', $this->userId))
            ->when($this->fromDate, fn ($q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn ($q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->sum('hours');
    }

    public function getBreakHoursProperty(): float
    {
        return Task::query()
            ->when($this->userId, fn ($q) => $q->where('user_id', $this->userId))
            ->when($this->fromDate, fn ($q) => $q->whereDate('created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn ($q) => $q->whereDate('created_at', '<=', $this->toDate))
            ->sum('break_hours');
    }

    public function getActualHoursProperty(): float
    {
        return $this->totalHours - $this->breakHours;
    }
}
