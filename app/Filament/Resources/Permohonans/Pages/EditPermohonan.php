<?php

namespace App\Filament\Resources\Permohonans\Pages;

use Filament\Actions\Action;
use Filament\Actions\SaveAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Permohonans\PermohonanResource;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['penduduk_id'] = $this->record->pemohon_id;

        return $data;
    }

    // Saat update, tetap samakan pemohon_id dengan penduduk_id
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['pemohon_id'] = $data['penduduk_id'] ?? $this->record->pemohon_id;

        // kalau tidak ada kolom penduduk_id di DB:
        // unset($data['penduduk_id']);

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [

            Action::make('cetak')
                ->label('Cetak')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn() => url('/'))
                ->openUrlInNewTab(),

            Action::make('kembali')
                ->label('Kembali')
                ->color('danger')
                ->url(fn() => url('permohonans')),
            // default actions
        ];
    }
   


}
