<?php

namespace App\Filament\Resources\Penandatangans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenandatanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip'),
                TextInput::make('nik'),
                TextInput::make('nama'),
                TextInput::make('jabatan'),
                TextInput::make('passphrase'),
            ]);
    }
}
