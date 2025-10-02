<?php

namespace App\Filament\Resources\AssessmentFormItemResource\Pages;

use App\Filament\Resources\AssessmentFormItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentFormItem extends EditRecord
{
    protected static string $resource = AssessmentFormItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
