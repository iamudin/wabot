<?php

namespace App\Filament\Resources\Kategoris\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class KategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kategori')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
