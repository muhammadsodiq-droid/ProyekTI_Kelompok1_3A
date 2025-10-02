<?php

namespace App\Filament\Resources\MahasiswaProfileResource\Pages;

use App\Filament\Resources\MahasiswaProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMahasiswaProfile extends EditRecord
{
    protected static string $resource = MahasiswaProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
