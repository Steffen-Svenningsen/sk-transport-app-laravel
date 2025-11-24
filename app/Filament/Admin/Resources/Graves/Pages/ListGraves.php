<?php

namespace App\Filament\Admin\Resources\Graves\Pages;

use App\Filament\Admin\Resources\Graves\GraveResource;
use Filament\Resources\Pages\ListRecords;

class ListGraves extends ListRecords
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
