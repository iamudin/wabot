<?php

namespace App\Filament\Resources\Penandatangans\Pages;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Penandatangans\PenandatanganResource;

class CreatePenandatangan extends CreateRecord
{
// HAPUS METHOD INI
protected function mutateFormDataBeforeCreate(array $data): array
{
    return $data;
}
protected function afterCreate(): void
{
    if ($this->record->user) {
        $this->record->user->update([
            'name' => $this->record->nama,
            'role' => 'penandatangan'
        ]);
    }
}
    protected static string $resource = PenandatanganResource::class;
}
