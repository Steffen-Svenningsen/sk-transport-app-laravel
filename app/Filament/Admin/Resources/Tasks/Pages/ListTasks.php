<?php

namespace App\Filament\Admin\Resources\Tasks\Pages;

use App\Filament\Admin\Resources\Tasks\TaskResource;
use App\Models\TaskType;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    public function getHeading(): string
    {
        return __('Tasks');
    }

    public function getTabs(): array
    {
        $tabs = [];

        // "Alle" tab
        $tabs['all'] = Tab::make(__('All Tasks'))
            ->modifyQueryUsing(fn ($query) => $query);

        // Dynamiske tabs ud fra task types
        foreach (TaskType::query()->orderBy('name')->get() as $type) {
            $tabs[$type->id] = Tab::make($type->name)
                ->label(__($type->name))
                ->modifyQueryUsing(fn ($query) => $query->where('task_type_id', $type->id));
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
