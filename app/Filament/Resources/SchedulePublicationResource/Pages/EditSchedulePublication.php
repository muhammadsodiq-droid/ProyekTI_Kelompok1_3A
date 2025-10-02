<?php

namespace App\Filament\Resources\SchedulePublicationResource\Pages;

use App\Filament\Resources\SchedulePublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchedulePublication extends EditRecord
{
    protected static string $resource = SchedulePublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
