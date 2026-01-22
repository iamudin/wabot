<?php

namespace App\Filament\Resources\Penandatangans\Pages;

use App\Filament\Resources\Penandatangans\PenandatanganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenandatangan extends EditRecord
{
    protected static string $resource = PenandatanganResource::class;
protected function mutateFormDataBeforeSave(array $data): array
{

    return $data;
}
protected function afterSave(): void
{
    if ($this->record->user) {
        $this->record->user->update([
            'name' => $this->record->nama,
        ]);
    }
}
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
