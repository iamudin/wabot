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


    public function form(Schema $form):Schema{
        return $form->schema([
            TextInput::make('nama')->label('Nama Syarat')->required(),
            Textarea::make('keterangan')->label('Keterangan')->required(),
            TextInput::make('urutan')->numeric(),
            Toggle::make('status')->required(),
            Select::make('sumber_data')->label('Jenis Inputan')
                ->options(
                    [
                        'user' => 'User',
                        'database' => 'Database'
                    ]
                ),
            Select::make('jenis_syarat')->label('Jenis Inputan')
            ->options([
            'file'=>'File','text'=>'Text'
            ]
            ),
            Textarea::make('perintah')->label('Pesan perintah :')
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
