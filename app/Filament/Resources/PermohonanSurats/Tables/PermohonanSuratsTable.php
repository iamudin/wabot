<?php

namespace App\Filament\Resources\PermohonanSurats\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\PermohonanSurats\Pages\LihatPermohonan;

class PermohonanSuratsTable
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
                TextColumn::make('status_permohonan')
                    ->label('Status')
                    ->formatStateUsing(fn ($record) => $record->ditandatangani_pada ? 'Sudah ditandatangani' : ' Menunggu Tanda Tangan')
                    ->searchable()
                    ->description(
                        function ($record) {
                          if($record->ditandatangani_pada){
                                return $record->ditandatangani_pada->format('d F Y H:i T');
                          }else{
                            return 'dari '.$record->diproses_pada->format('d F Y H:i T');

                          }
                        
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
            ->recordUrl(
            fn ($record) => route('filament.admin.resources.permohonan-surats.lihat', $record)
        )
            ->recordActions([
               Action::make('lihat')
    ->label('Lihat selengkapnya')
    ->icon('heroicon-o-eye')
    ->url(fn ($record) => route('filament.admin.resources.permohonan-surats.lihat', $record))
  
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
