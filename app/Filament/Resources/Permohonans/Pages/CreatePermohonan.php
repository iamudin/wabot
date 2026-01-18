<?php

namespace App\Filament\Resources\Permohonans\Pages;

use App\Filament\Resources\Permohonans\PermohonanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermohonan extends CreateRecord
{
    protected static string $resource = PermohonanResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // salin nilai penduduk_id ke pemohon_id
        // $data['pemohon_id'] = $data['penduduk_id'] ?? null;

        // kalau tabel kamu TIDAK punya kolom penduduk_id, tambahkan:
        // unset($data['penduduk_id']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $permohonan = $this->record;

        $syarats = \App\Models\SyaratLayanan::where('layanan_id', $permohonan->layanan_id)
            ->where('sumber_data', 'user')
            ->where('status', true)
            ->orderBy('urutan')
            ->get();

        foreach ($syarats as $syarat) {
            \App\Models\DataPermohonan::create([
                'permohonan_id' => $permohonan->id,
                'syarat_layanan_id' => $syarat->id,
                'keterangan' => null,
                'koreksidata' => null,
                'status' => 'menunggu',
            ]);
        }
    }
}
