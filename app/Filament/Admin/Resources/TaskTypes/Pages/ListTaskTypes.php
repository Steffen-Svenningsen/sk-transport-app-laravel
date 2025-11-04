<?php

namespace App\Filament\Admin\Resources\TaskTypes\Pages;

use App\Filament\Admin\Resources\TaskTypes\TaskTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskTypes extends ListRecords
{
    protected static string $resource = TaskTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
