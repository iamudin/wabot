<?php

namespace App\Filament\Resources\Penduduks\Schemas;

use App\Models\Rt;
use App\Models\Rw;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DateTimePicker;

class PendudukForm
{
    public static function form(): array
    {
        return [
            TextInput::make('nik')
                ->required(),
               
            TextInput::make('nama')
                ->required(),
                 TextInput::make('tempat_tanggal_lahir')
                ->required(),
            Select::make('jenis_kelamin')
                ->options(['L' => 'Laki laki', 'P' => 'Perempuan'])
                ->required(),
            TextInput::make('alamat'),
                TextInput::make('rt')
                ->required(),
                 TextInput::make('rw')
                ->required(),
            // Select::make('rw_filter')
            //     ->label('RW')
            //     ->options(
            //         RW::query()->pluck('nomor', 'id')->mapWithKeys(fn($v, $k) => [(int) $k => $v]) // ✅ pastikan key integer
            //     )
            //     ->afterStateHydrated(function (callable $set, $record) {   // ✅ ini yang memastikan tampil
            //         if ($record && $record->rt) {
            //             $set('rw_filter', $record->rt->rw_id);
            //         }
            //     })
            //     ->getOptionLabelUsing(fn($value) => RW::find($value)?->nomor)
            //     ->preload()
            //     ->reactive()
            //     ->afterStateUpdated(fn(callable $set) => $set('rt_id', null))
            //     ->dehydrated(false),



            // Select::make('rt_id')
            //     ->label('RT')
            //     ->relationship(
            //         name: 'rt',
            //         titleAttribute: 'nomor', // tampilkan nomor, bukan id
            //         modifyQueryUsing: function ($query, callable $get, $record) {
            //             $rwId = $get('rw_filter');

            //             // saat edit, jika belum memilih RW, pakai RW dari RT existing
            //             if (!$rwId && $record) {
            //                 $rwId = $record->rt?->rw_id;
            //             }

            //             if ($rwId) {
            //                 $query->where('rw_id', $rwId);
            //             }
            //         }
            //     )
            //     ->required()
            //     ->reactive()
            //     ->preload(), // agar label RT tampil langsung saat edit

            Select::make('agama')->options([
                'Islam' => 'Islam',
                'Katolik' => 'Katolik',
                'Kristen' => 'Kristen',
                'Budha' => 'Budha'
            ]),
            Select::make('status_kawin')->options([
                'Kawin' => 'Kawin',
                'Belum Kawin' => 'Belum Kawin'
            ]),
                 TextInput::make('kewarganegaraan')
                    ->required(),
                       TextInput::make('pekerjaan')
                    ->required(),
            TextInput::make('nomor_whatsapp')
                ->required()
        ];
    }
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('nik')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                           TextInput::make('tempat_tanggal_lahir')
                ->required(),
               Select::make('jenis_kelamin')
                ->options(['L' => 'Laki laki', 'P' => 'Perempuan'])
                ->required(),
                TextInput::make('alamat'),
                    TextInput::make('rt')
                ->required(),
                 TextInput::make('rw')
                ->required(),
// Select::make('rw_filter')
//     ->label('RW')
//     ->options(
//         RW::query()->pluck('nomor', 'id')->mapWithKeys(fn ($v, $k) => [(int) $k => $v]) // ✅ pastikan key integer
//     )
//     ->afterStateHydrated(function (callable $set, $record) {   // ✅ ini yang memastikan tampil
//         if ($record && $record->rt) {
//             $set('rw_filter', $record->rt->rw_id);
//         }
//     })
//     ->getOptionLabelUsing(fn ($value) => RW::find($value)?->nomor)
//     ->preload()
//     ->reactive()
//     ->afterStateUpdated(fn (callable $set) => $set('rt_id', null))
//     ->dehydrated(false),



// Select::make('rt_id')
//     ->label('RT')
//     ->relationship(
//         name: 'rt',
//         titleAttribute: 'nomor', // tampilkan nomor, bukan id
//         modifyQueryUsing: function ($query, callable $get, $record) {
//             $rwId = $get('rw_filter');

//             // saat edit, jika belum memilih RW, pakai RW dari RT existing
//             if (!$rwId && $record) {
//                 $rwId = $record->rt?->rw_id;
//             }

//             if ($rwId) {
//                 $query->where('rw_id', $rwId);
//             }
//         }
//     )
//     ->required()
//     ->reactive()
//     ->preload(), // agar label RT tampil langsung saat edit

                Select::make('agama')->options([
                   'Islam' => 'Islam',
                   'Katolik' =>'Katolik',
                   'Kristen' =>'Kristen',
                    'Budha'=>'Budha'
                ]),
                Select::make('status_kawin')->options([
                   'Kawin' =>'Kawin',
                   'Belum Kawin'=>'Belum Kawin'
                ]),
                TextInput::make('kewarganegaraan')
                    ->required(),
                       TextInput::make('pekerjaan')
                    ->required(),
                TextInput::make('nomor_whatsapp')
                    ->required(),
Toggle::make('verifikasi_toggle')
    ->label('Verifikasi Data Penduduk')
    ->dehydrated(false)
    ->hidden(fn ($record) => filled($record?->terverifikasi_pada)),

DateTimePicker::make('terverifikasi_pada')
    ->label('Terverifikasi Pada')
    ->readOnly()
    ->visible(fn ($record) => filled($record?->terverifikasi_pada)),    
                Placeholder::make('ktp_preview')
                ->visible(fn($record)=> filled($record?->file_ktp))
                    ->label('Preview KTP')
                    ->content(fn($record) => new \Illuminate\Support\HtmlString(
                        $record
                        ? '<img 
                src="' . route('penduduk.ktp.stream', $record) . '" 
                class="max-w-full rounded shadow"
              >'
                        : 'File KTP tidak tersedia'
                    )),

            ]);
    }
}
