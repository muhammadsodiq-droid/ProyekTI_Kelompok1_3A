<?php

namespace App\Filament\Resources\MahasiswaProfileResource\Pages;

use App\Filament\Resources\MahasiswaProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswaProfiles extends ListRecords
{
    protected static string $resource = MahasiswaProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
