<?php

namespace App\Filament\Resources\Permohonans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermohonanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('layanan_id')
                    ->relationship('layanan', 'id')
                    ->required(),
                DateTimePicker::make('sesi_dimulai'),
                DateTimePicker::make('sesi_berakir'),
                TextInput::make('status_permohonan')
                    ->required()
                    ->default('baru'),
                Select::make('penduduk_id')
                    ->relationship('penduduk', 'id')
                    ->required(),
                Select::make('pemohon_id')
                    ->relationship('pemohon', 'id')
                    ->required(),
            ]);
    }
}
