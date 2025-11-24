<?php

namespace App\Filament\Admin\Resources\WorkTypes\Pages;

use App\Filament\Admin\Resources\WorkTypes\WorkTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkType extends ViewRecord
{
    protected static string $resource = WorkTypeResource::class;

    public function getTitle(): string
    {
        return $this->record->name;
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
