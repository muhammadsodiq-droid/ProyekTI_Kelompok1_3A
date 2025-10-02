<?php

namespace App\Filament\Resources\AssessmentResultResource\Pages;

use App\Filament\Resources\AssessmentResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentResult extends EditRecord
{
    protected static string $resource = AssessmentResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
