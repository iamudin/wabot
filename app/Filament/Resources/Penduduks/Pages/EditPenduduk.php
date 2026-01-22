<?php

namespace App\Filament\Resources\Penduduks\Pages;

use App\Filament\Resources\Penduduks\PendudukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenduduk extends EditRecord
{
    protected static string $resource = PendudukResource::class;
protected function mutateFormDataBeforeSave(array $data): array
{
    // jika sudah diverifikasi, jangan ubah
    if ($this->record->terverifikasi_pada) {
        return $data;
    }

    // toggle dicentang → set timestamp
    if ($this->data['verifikasi_toggle'] ?? false) {
        $data['terverifikasi_pada'] = now();
    }

    return $data;
}

protected function afterSave(): void
{
    $this->record->refresh();

    $this->form->fill(
        $this->record->attributesToArray()
    );
}
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
