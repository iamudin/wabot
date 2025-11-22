<?php

namespace App\Filament\Resources\Permohonans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermohonansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('layanan.id')
                    ->searchable(),
                TextColumn::make('sesi_dimulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('sesi_berakir')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status_permohonan')
                    ->searchable(),
                TextColumn::make('penduduk.id')
                    ->searchable(),
                TextColumn::make('pemohon.id')
                    ->searchable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
