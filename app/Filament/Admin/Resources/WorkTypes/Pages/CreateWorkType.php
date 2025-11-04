<?php

namespace App\Filament\Admin\Resources\WorkTypes\Pages;

use App\Filament\Admin\Resources\WorkTypes\WorkTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkType extends CreateRecord
{
    protected static string $resource = WorkTypeResource::class;
}
