<?php

namespace App\Filament\Resources\Penduduks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PendudukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nik')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->required(),
                TextInput::make('alamat'),
                Select::make('rt_id')
                    ->relationship('rt', 'id'),
                TextInput::make('agama'),
                TextInput::make('status_kawin'),
                TextInput::make('nomor_whatsapp')
                    ->required(),
                DateTimePicker::make('terdaftar_pada'),
                DateTimePicker::make('terverifikasi_pada'),
            ]);
    }
}
