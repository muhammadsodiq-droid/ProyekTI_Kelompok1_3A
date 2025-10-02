<?php

namespace App\Filament\Resources\AssessmentResultResource\Pages;

use App\Filament\Resources\AssessmentResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentResults extends ListRecords
{
    protected static string $resource = AssessmentResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
