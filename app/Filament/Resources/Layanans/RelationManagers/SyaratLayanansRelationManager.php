<?php

namespace App\Filament\Resources\Layanans\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;

class SyaratLayanansRelationManager extends RelationManager
{
    protected static string $relationship = 'syaratLayanans';


    public function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('kata_kunci')->label('kata_kunci')
    ->required()
    ->rule(function ($attribute, $value, $fail) {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $value)) {
            $fail('Username hanya boleh berisi huruf, angka, dan underscore (_), tanpa spasi.');
        }
    })
    ->helperText('Hanya huruf, angka, dan underscore — tanpa spasi.')
                ->columnSpanFull(),
            TextInput::make('nama')->label('Nama Syarat')->required()
               ->columnSpanFull(),
            Textarea::make('keterangan')->label('Keterangan')->required()
               ->columnSpanFull(),


            Select::make('sumber_data')->label('Sumber Data')
                ->options(
                    [
                        'user' => 'User',
                        'database' => 'Database'
                    ]
                ),
            Select::make('jenis_syarat')->label('Jenis Data')
                ->options(
                    [
                        'file' => 'File',
                        'text' => 'Text',
                        'array' => 'Array',
                    ]
                ),
            TextInput::make('urutan')->numeric(),
            Toggle::make('status')->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->reorderable('urutan')
            ->defaultSort('urutan')
            ->columns([
                TextColumn::make('row_number')->label('#')->rowIndex(),
                TextColumn::make('nama')->label('Nama Syarat'),
                TextColumn::make('sumber_data')->label('Sumber Data'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])->recordActions([
                    EditAction::make(),
                    DeleteAction::make()
                ]);
    }
}
