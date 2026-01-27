<?php

namespace App\Filament\Resources\Permohonans\Schemas;

use App\Models\Permohonan;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\Penduduks\Schemas\PendudukForm;

class PermohonanForm
{
    public static function generateTicket()
    {
        $last = Permohonan::orderBy('id', 'desc')->first();

        $number = $last ? $last->id + 1 : 1;

        return date('Ymd') . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_tiket')
                    ->prefix('#')
                    ->label('Kode Tiket')
                    ->required()
                    ->default(fn() => self::generateTicket())   // untuk create
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if (!$record) {
                            $set('invoice_number', self::generateTicket());
                        }
                    })
                    ->disabled() // jika tidak mau di-edit user
                    ->dehydrated(true)->columnSpanFull(), // tetap 

                Select::make('penduduk_id')
                    ->label('Pemohon')
                    ->relationship('penduduk', 'nama')
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        "<div>{$record->nik}<br>{$record->nama}<br>{$record->alamat}<br>RT {$record->rt?->nomor} / RW {$record->rt?->rw?->nomor}</div>"
                    )
                       ->searchable()
    ->createOptionForm(fn () => PendudukForm::form())   // ✅ panggil schema form
    ->createOptionAction(function ($action) {
        return $action
            ->modalHeading('Tambah Penduduk Baru')
            ->modalSubmitActionLabel('Simpan')
            ->modalCancelActionLabel('Batal');
    })
                    ->allowHtml()
                    ->required(),

                Select::make('layanan_id')
                    ->relationship('layanan', 'nama_layanan')
                    ->required(),

                Select::make('status_permohonan')
                    ->options([
                        'draft' => 'Draft',
                        'baru' => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai'
                    ])
                    ->visibleOn('edit')
                    ->live()   // ⬅️ wajib agar field lain bisa muncul dinamis
                    ->afterStateUpdated(function ($state, $record) {
                        switch ($state) {
                            case 'ditolak':
                                $record->update(['ditolak_pada' => now()]);
                                break;

                            case 'selesai':
                                $record->update(['diselesaikan_pada' => now()]);
                                break;

                            case 'diproses':
                                $record->update(['diproses_pada' => now()]);
                                break;

                            case 'baru':
                                $record->update(['created_at' => now()]);
                                break;
                        }
                    }),
                             Textinput::make('nomor_surat')->placeholder('Contoh : SKTM/XX/2026'),
                    Textarea::make('alasan_penolakan')
    ->label('Alasan Penolakan')
    ->visible(fn (callable $get) => $get('status_permohonan') === 'ditolak')
    ->required(fn (callable $get) => $get('status_permohonan') === 'ditolak') // wajib isi jika ditolak
    ->columnSpanFull(),

       Select::make('penandatangan_id')
    ->relationship('penandatangan','nama')
    ->label('Pejabat Penanda Tangan')
    ->visible(fn (callable $get) => $get('status_permohonan') === 'selesai')
    ->required(fn (callable $get) => $get('status_permohonan') === 'selesai') // wajib isi jika ditolak
    ->columnSpanFull(),

                FileUpload::make('file_surat')
                    ->label('Upload Surat (PDF)')
                    ->disk('public')
                    ->directory('permohonan/file-surat')
                    ->preserveFilenames(false)
                    ->acceptedFileTypes(['application/pdf'])    // hanya izinkan PDF
                    ->getUploadedFileNameForStorageUsing(
                        fn($file) =>
                        (string) Str::uuid() . '.' . $file->getClientOriginalExtension()
                    )            
                    ->columnSpanFull()
    ->visible(fn(callable $get) => $get('status_permohonan') === 'selesai')
                    ->required(fn(callable $get) => $get('status_permohonan') === 'selesai'),
                Action::make('previewPdf')
                    ->label('Lihat Surat')
                    ->icon('heroicon-o-eye')
                    ->visible(fn($record) => $record?->status_permohonan=='selesai')
                    ->modalHeading('Preview Surat (PDF)')
                    ->modalContent(function ($record) {
                        $url = route('file.preview',base64_encode($record->file_surat)); // atau Storage::url()
            
                        return new HtmlString(<<<HTML
            <div class="space-y-4">
                <iframe src="{$url}" class="w-100 h-[600px] rounded-lg border" style="width:100%;height:800px"></iframe>
            </div>
        HTML);
                    })->modalSubmitAction(false)

            ]);

          
    }
}
