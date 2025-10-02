<?php

namespace App\Filament\Resources\AssessmentResponseItemResource\Pages;

use App\Filament\Resources\AssessmentResponseItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentResponseItems extends ListRecords
{
    protected static string $resource = AssessmentResponseItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
