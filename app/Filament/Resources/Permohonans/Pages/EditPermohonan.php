<?php

namespace App\Filament\Resources\Permohonans\Pages;

use App\Filament\Resources\Permohonans\PermohonanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
