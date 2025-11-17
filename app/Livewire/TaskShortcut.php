<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class TaskShortcut extends Widget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    protected string $view = 'livewire.task-shortcut';
}
