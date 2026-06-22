<?php

namespace App\Filament\Resources\PermohonanSurats\Pages;

use Filament\Actions\Action;
use App\Services\TtePdfService;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Resources\PermohonanSurats\PermohonanSuratResource;

class LihatPermohonan extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PermohonanSuratResource::class;

    protected string $view = 'filament.resources.permohonan-surats.pages.lihat-permohonan';
protected function getActions(): array
{
    return [
       // $this->prosesTTE(),
    ];
}
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    static function canAccess(array $parameters = []): bool
    {
        $user = Auth::user();

        return $user->isPenandatangan();
    }
    public function getPenandatangan(): ?\App\Models\Penandatangan
{
    return $this->record->penandatangan; // sesuaikan relasi
}
public function prosesTTE(): Action
{
    return Action::make('prosesTTE')
        ->label('Tandatangani Dokumen')
        ->icon('heroicon-o-pencil-square')
        ->color('success')

        // 🧾 FORM MODAL
        ->form([
            TextInput::make('passphrase')
                ->label('Passphrase TTE')
                ->password()
                ->required(),
        ])

        // 🧠 AKSI SAAT SUBMIT
        ->action(function (array $data) {
            $result = (new TtePdfService)->sign(
                $this->record,
                $data['passphrase']
            );

            if ($result['success'] ?? false) {
                $this->record->update([
                    'surat_tte'            => $result['path'],
                    'ditandatangani_pada'  => now(),
                ]);
    defer(fn()=>
                    Http::post(config('wabot.wa_host').'/message/send-document', [
            'session' => config('wabot.wa_session'),
            'to' => $this->record->penduduk->nomor_whatsapp,
            'text' => 'Surat permohonan anda dengna kode tiket #'.$this->record->kode_tiket.' sudah selesai diproses, silahkan unduh file dokumen berikut :',
            'document_url' => route('file.preview',base64_encode($this->record->surat_tte)),
            'document_name' => $this->record->kode_tiket.'.pdf',
            'is_group'=>false,
        ]));
                Notification::make()
                    ->title('Berhasil TTE')
                    ->body('Dokumen berhasil ditandatangani secara elektronik.')
                    ->success()
                    ->send();
                
            } else {
                Notification::make()
                    ->title('Gagal TTE')
                    ->body('Proses penandatanganan gagal.')
                    ->danger()
                    ->send();
            }
        });
}
public function isSiapTTE(): bool
{
    return filled($this->getPenandatangan()?->passphrase)
        && filled($this->record->file_surat); // contoh
}
}
