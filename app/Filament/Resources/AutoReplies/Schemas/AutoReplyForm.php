<?php

namespace App\Filament\Resources\AutoReplies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AutoReplyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key'),
                Select::make('parent_id')->relationship('parent','value'),
                Textarea::make('value')
                    ->columnSpanFull(),

                Select::make('action')
                    ->options(['reply_value' => 'Reply value', 'aksi' => 'Aksi'])
                    ->required(),
            ]);
    }
}
