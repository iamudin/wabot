<?php

namespace App\Filament\Resources\Permohonan\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class PermohonanRelationManager extends RelationManager
{
    protected static string $relationship = 'permohonans';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row_number')->label('#')->rowIndex(),
                TextColumn::make('kode_tiket')->prefix('#')->label('Kode Tiket'),
                TextColumn::make('layanan.nama_layanan')->label('Layanan'),
                TextColumn::make('pemohon.nama')->label('Pemohon')->description(fn($record)=>$record->pemohon->nama_lengkap),
                TextColumn::make('status')->label('Status Permohonan')
                    ->description(
                        function ($record) {
                            return match ($record->status) {
                            'baru'=> $record->diajukan_pada->format('d F Y H:i T'),
                            'ditolak' => $record->ditolak_pada->format('d F Y H:i T'),
                            'selesai' => $record->diselesaikan_pada->format('d F Y H:i T'),
                            };
                }
            
            ),
            ])
            ->headerActions([
            ])->recordActions([
                    EditAction::make(),
                    DeleteAction::make()
                ]);
    }
}
