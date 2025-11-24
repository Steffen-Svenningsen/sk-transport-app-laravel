<?php

namespace App\Filament\Admin\Resources\Tasks\Pages;

use App\Filament\Admin\Resources\Tasks\TaskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTask extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    public function getHeading(): string
    {
        return __('Task').' #'.$this->record->id;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->extraAttributes(['class' => 'fi-button-secondary page-header-action']),
            DeleteAction::make(),
        ];
    }
}
