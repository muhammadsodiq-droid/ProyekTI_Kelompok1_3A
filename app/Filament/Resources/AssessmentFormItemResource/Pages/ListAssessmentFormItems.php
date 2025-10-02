<?php

namespace App\Filament\Resources\AssessmentFormItemResource\Pages;

use App\Filament\Resources\AssessmentFormItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssessmentFormItems extends ListRecords
{
    protected static string $resource = AssessmentFormItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
