<?php

namespace App\Filament\Admin\Resources\TaskTypes\Pages;

use App\Filament\Admin\Resources\TaskTypes\TaskTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskType extends EditRecord
{
    protected static string $resource = TaskTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
