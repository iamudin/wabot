<?php

namespace App\Filament\Resources\Penduduks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
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
                    ->description(fn($record)=>$record->nama)
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->state(fn($record)=>$record->jenis_kelamin=='L' ? 'Laki-laki' : 'Perempuan'),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('rt')
                ->label('RT'),
                TextColumn::make('rw')
                ->label('RW'),
              
                TextColumn::make('agama')
                    ->searchable(),
                TextColumn::make('status_kawin')
                    ->searchable(),
                TextColumn::make('nomor_whatsapp')
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
                DeleteAction::make()->disabled(fn($record)=>$record->permohonans->count())
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
