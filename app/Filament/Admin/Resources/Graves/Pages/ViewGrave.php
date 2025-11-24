<?php

namespace App\Filament\Admin\Resources\Graves\Pages;

use App\Filament\Admin\Resources\Graves\GraveResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGrave extends ViewRecord
{
    protected static string $resource = GraveResource::class;

    public function getHeading(): string
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
