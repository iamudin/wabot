<?php
namespace App\Filament\Resources\Permohonans\RelationManagers;

use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\RelationManagers\RelationManager;

class DataPermohonanRelationManager extends RelationManager
{
    protected static string $relationship = 'dataPermohonans';
    protected static ?string $title = 'Data Persyaratan';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([

                Placeholder::make('nama_syarat')
                    ->label('Nama Syarat')
                    ->content(fn($record) => $record->syaratLayanan->nama)
                    ->columnSpanFull(),

                /**
                 * ============================
                 *           TEXT MODE
                 * ============================
                 */
                TextInput::make('keterangan_text')
                    ->label('Keterangan')
                    ->visible(fn($record) => $record->syaratLayanan->jenis_syarat === 'text')

                    // tampilkan nilai lama
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->keterangan);
                    })

                    ->afterStateUpdated(function ($state, $record) {
                        $record->update([
                            'keterangan' => $state,   // simpan ke kolom aslinya
                            'status' => $state ? 'dijawab' : 'menunggu',
                        ]);
                    })

                    ->dehydrated(false)
                    ->columnSpanFull(),

                /**
                 * ============================
                 *          FILE MODE
                 * ============================
                 */

                FileUpload::make('keterangan_file')
                    ->label('Upload Berkas')
                    ->directory('permohonan/syarat')
                    ->preserveFilenames()
                    ->visible(fn($record) => $record->syaratLayanan->jenis_syarat === 'file')
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        return (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
                    })
                    // TAMPILKAN FILE LAMA
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record?->keterangan) {
                            $component->state([$record->keterangan]);
                        }
                    })

                    // SAAT FILE DIUPLOAD
                    ->afterStateUpdated(function ($state, $record, $livewire) {

                        // Jika file baru diupload
                        if ($state) {
                            $record->update([
                                'keterangan' => $state,
                                'status' => 'dijawab',
                            ]);
                            return;
                        }

                        /** 
                         * ======================
                         * SAAT TOMBOL X DIKLIK
                         * ======================
                         */

                        // Kalau ada file lama → hapus
                        if ($record?->keterangan && Storage::exists($record->keterangan)){
                            Storage::delete($record->keterangan);
                        }

                        // Kosongkan dari DB
                        $record->update([
                            'keterangan' => null,
                            'status' => 'menunggu',
                        ]);
                    })

                    ->dehydrated(false)
                    ->columnSpanFull(),


                Toggle::make('is_valid')
                    ->label('Data Ini Valid')
            ]);
    }


    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                $this->getRelationship()->getQuery()->with('syaratLayanan')
            )
            ->columns([
                TextColumn::make('syaratLayanan.nama')
                    ->label('Syarat')
                    ->sortable(),
                TextColumn::make('keterangan'),
                
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'menunggu',
                        'success' => 'dijawab',
                    ]),

IconColumn::make('is_valid')->label('Data Valid')
    ->boolean()            // otomatis tampil ✔ atau ✖
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
   ,
   TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d M Y H:i'),
            ])
            ->headerActions([])
            ->actions([
                EditAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }
}
