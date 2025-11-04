<?php

namespace App\Filament\Admin\Resources\Graves\Pages;

use App\Filament\Admin\Resources\Graves\GraveResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGrave extends EditRecord
{
    protected static string $resource = GraveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
