<?php

namespace App\Filament\Resources\Penduduks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenduduksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->badge(),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('rt.id')
                    ->searchable(),
                TextColumn::make('agama')
                    ->searchable(),
                TextColumn::make('status_kawin')
                    ->searchable(),
                TextColumn::make('nomor_whatsapp')
                    ->searchable(),
                TextColumn::make('terdaftar_pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('terverifikasi_pada')
                    ->dateTime()
                    ->sortable(),
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
