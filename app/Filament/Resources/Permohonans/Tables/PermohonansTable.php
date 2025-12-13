<?php

namespace App\Filament\Resources\Permohonans\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class PermohonansTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_tiket')
                    ->prefix('#')
                    ->searchable(),
                TextColumn::make('layanan.nama_layanan')
                    ->searchable(),

                TextColumn::make('penduduk.nama')
                    ->label('Pemohon')
                    ->description(fn($record) => $record->penduduk->nik)
                    ->searchable(),

                TextColumn::make('pemohon.nama')
                    ->label('Pembuat')
                    ->description(fn($record) => $record->pemohon->nik)
                    ->searchable(),
                TextColumn::make('status_permohonan')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->searchable()
                    ->description(
                        function ($record) {
                            return match ($record->status_permohonan) {
                                'draft'=> '-',
                                'baru' => $record->created_at->diffForHumans(),
                                'diproses'=> $record->diproses_pada->diffForHumans(),
                                'ditolak'=>$record->ditolak_pada->diffForHumans(),
                                'selesai' => $record->diselesaikan_pada->diffForHumans(),
                                default=>null
                            };
                        
                    }
                        )
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->disabled(fn($record)=>$record->status_permohonan != 'baru')
                ->tooltip(fn($record)=>$record->status_permohonan!='baru' ? 'Tidak dapat dihapus' : 'Hapus data permohonan')->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
