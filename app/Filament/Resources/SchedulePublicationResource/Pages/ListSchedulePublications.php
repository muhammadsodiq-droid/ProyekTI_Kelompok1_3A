<?php

namespace App\Filament\Resources\SchedulePublicationResource\Pages;

use App\Filament\Resources\SchedulePublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchedulePublications extends ListRecords
{
    protected static string $resource = SchedulePublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
