<?php

namespace App\Filament\Resources\AssessmentResponseItemResource\Pages;

use App\Filament\Resources\AssessmentResponseItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentResponseItem extends EditRecord
{
    protected static string $resource = AssessmentResponseItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
