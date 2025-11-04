<?php

namespace App\Filament\Admin\Resources\TaskTypes\Pages;

use App\Filament\Admin\Resources\TaskTypes\TaskTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskType extends ViewRecord
{
    protected static string $resource = TaskTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
