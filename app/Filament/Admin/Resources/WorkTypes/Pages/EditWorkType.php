<?php

namespace App\Filament\Admin\Resources\WorkTypes\Pages;

use App\Filament\Admin\Resources\WorkTypes\WorkTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkType extends EditRecord
{
    protected static string $resource = WorkTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
