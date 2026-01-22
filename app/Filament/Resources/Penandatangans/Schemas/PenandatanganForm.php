<?php

namespace App\Filament\Resources\Penandatangans\Schemas;
use App\Models\User;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
class PenandatanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Penandatangan')
                ->schema([
                    TextInput::make('nip')->required(),
                    TextInput::make('nik')->required(),
                    TextInput::make('nama')->required(),
                    TextInput::make('jabatan')->required(),
                    TextInput::make('passphrase')->password(),
                    Toggle::make('kepala_desa')->label('Pejabat ini adalah kepala desa')->nullable(),
                ]),

    Section::make('Akun User')
    ->relationship('user')
    ->schema([
        
        TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->unique(
                table: User::class,
                column: 'email',
                ignorable: fn ($record) => $record
            ),

        TextInput::make('password')
            ->label('Password')
            ->password()
            ->dehydrateStateUsing(
                fn ($state) => filled($state) ? bcrypt($state) : null
            )
            ->dehydrated(fn ($state) => filled($state))
            ->helperText('Kosongkan jika tidak ingin mengganti password'),
    ]),

        ]);
    }
}
