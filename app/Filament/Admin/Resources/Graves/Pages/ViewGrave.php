<?php

namespace App\Filament\Admin\Resources\Graves\Pages;

use App\Filament\Admin\Resources\Graves\GraveResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGrave extends ViewRecord
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
