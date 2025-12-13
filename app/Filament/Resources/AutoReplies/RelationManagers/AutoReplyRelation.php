<?php

namespace App\Filament\Resources\Permohonan\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\Action;
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

class AutoReplyRelation extends RelationManager
{
    protected static string $relationship = 'childs';
    public  function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key'),
                Select::make('parent_id')->relationship('parent', 'value'),
                Textarea::make('value')
                    ->columnSpanFull(),

                Select::make('action')
                    ->options(['reply_value' => 'Reply value', 'aksi' => 'Aksi'])
                    ->required(),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table->reorderable('key')
            ->defaultSort('key')
            ->columns([
                TextColumn::make('key'),
                TextColumn::make('value'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])->recordActions([
                    Action::make('edit')->label('Edit')->url(fn($record)=>'/auto-replies/'.$record->id.'/edit'),
                    DeleteAction::make()
                ]);
    }
}
