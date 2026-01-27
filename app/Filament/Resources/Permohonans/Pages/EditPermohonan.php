<?php

namespace App\Filament\Resources\Permohonans\Pages;

use Filament\Actions\Action;
use Filament\Actions\SaveAction;
use Filament\Actions\DeleteAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Filament\Resources\Pages\EditRecord;
use App\Http\Controllers\PermohonanTokenController;
use App\Filament\Resources\Permohonans\PermohonanResource;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $data['penduduk_id'] = $this->record->pemohon_id;

        return $data;
    }

    // Saat update, tetap samakan pemohon_id dengan penduduk_id
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // $data['pemohon_id'] = $data['penduduk_id'] ?? $this->record->pemohon_id;

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

    // 1️⃣ EKSEKUSI CETAK + SIMPAN HASIL
    ->mountUsing(function ($record, Action $action) {

        $path = app(PermohonanTokenController::class)
            ->cetakPermohonan($record->id);
        // contoh return:
        // permohonan/hasil-surat/abc123.docx

        // ✅ SIMPAN KE ARGUMENTS (BUKAN STATE)
        $action->arguments([
            'file' => basename($path),
        ]);
    })

    ->modalHeading('Preview Cetak Permohonan')
    ->modalWidth('7xl')
    ->modalSubmitAction(false)
    ->modalCancelActionLabel('Tutup')

    // 2️⃣ AMBIL DARI ARGUMENTS
    ->modalContent(fn (Action $action): View => view(
        'filament.modals.iframe-cetak',
        [
            'url' => !config('app.debug') ? "https://view.officeapps.live.com/op/embed.aspx?src=".route(
                'showfiledocx',
                $action->getArguments()['file']
            ) : route(
                'showfiledocx',
                $action->getArguments()['file']
            ),
        ]
    )),

            Action::make('kembali')
                ->label('Kembali')
                ->color('danger')
                ->url(fn() => url('permohonans')),
            // default actions
        ];
    }
   


}
