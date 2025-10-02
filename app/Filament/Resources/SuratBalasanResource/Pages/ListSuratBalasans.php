<?php

namespace App\Filament\Resources\SuratBalasanResource\Pages;

use App\Filament\Resources\SuratBalasanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratBalasans extends ListRecords
{
    protected static string $resource = SuratBalasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
