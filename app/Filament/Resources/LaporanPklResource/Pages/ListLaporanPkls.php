<?php

namespace App\Filament\Resources\LaporanPklResource\Pages;

use App\Filament\Resources\LaporanPklResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporanPkls extends ListRecords
{
    protected static string $resource = LaporanPklResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
