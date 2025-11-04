<?php

namespace App\Filament\Admin\Resources\WorkTypes\Pages;

use App\Filament\Admin\Resources\WorkTypes\WorkTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkTypes extends ListRecords
{
    protected static string $resource = WorkTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
