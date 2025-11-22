<?php

namespace App\Filament\Resources\Rws\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RwForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor')
                    ->required(),
            ]);
    }
}
