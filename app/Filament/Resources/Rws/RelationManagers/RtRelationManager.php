<?php

namespace App\Filament\Resources\Rws\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class RtRelationManager extends RelationManager
{
    protected static string $relationship = 'rts';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row_number')->label('#')->rowIndex(),
                TextColumn::make('nomor')->label('Nomor'),
                
            ])
            ->headerActions([
                CreateAction::make(),
            ])->recordActions([
                    EditAction::make(),
                    DeleteAction::make()->disabled(fn($record)=>$record->penduduks()->exists())
                ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nomor')->required()->columnSpanFull(),

            ]);
    }
}
