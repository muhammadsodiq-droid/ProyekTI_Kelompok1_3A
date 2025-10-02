<?php

namespace App\Filament\Resources\KhsResource\Pages;

use App\Filament\Resources\KhsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKhs extends EditRecord
{
    protected static string $resource = KhsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
