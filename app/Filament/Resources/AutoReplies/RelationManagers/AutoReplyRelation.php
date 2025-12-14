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
use Filament\Forms\Components\RichEditor;
use Filament\Resources\RelationManagers\RelationManager;

class AutoReplyRelation extends RelationManager
{
    protected static string $relationship = 'childs';

    public  function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')->required(),
                  RichEditor::make('value')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'undo',
                        'redo',
                    ])
                    ->disableToolbarButtons([
                        'orderedList',
                        'bulletList',
                    ])
                    ->columnSpanFull()
                    ->placeholder('Tulis konten di sini...')
    ->helperText('Gunakan bahasa yang mudah dipahami.')
    ->formatStateUsing(function ($state) {
        if (!$state) return $state;

        $text = e($state);
        $text = preg_replace('/ \*(.*?)\* /', '<strong>$1</strong>', $text);
        $text = preg_replace('/ _(.*?)_ /', '<em>$1</em>', $text);
        $text = preg_replace('/ ~(.*?)~ /', '<s>$1</s>', $text);

        return '<p>' . implode('</p><p>', explode('\n', $text)) . '</p>';
    })
    ->dehydrateStateUsing(function ($state) {
        if (!$state) return $state;

        return str_replace(
            ['<br>', '<br/>', '<p>', '</p>', '<strong>', '</strong>', '<em>', '</em>', '<s>', '</s>'],
            ['\n', '\n', '', '\n', ' *', '* ', ' _', '_ ', ' ~', '~ '],
            $state
        );
    }),

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
