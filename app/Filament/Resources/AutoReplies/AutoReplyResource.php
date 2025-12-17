<?php

namespace App\Filament\Resources\AutoReplies;

use BackedEnum;
use App\Models\AutoReply;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\AutoReplies\Pages\EditAutoReply;
use App\Filament\Resources\AutoReplies\Pages\CreateAutoReply;
use App\Filament\Resources\AutoReplies\Pages\ListAutoReplies;
use App\Filament\Resources\AutoReplies\Schemas\AutoReplyForm;
use App\Filament\Resources\AutoReplies\Tables\AutoRepliesTable;
use App\Filament\Resources\Permohonan\RelationManagers\AutoReplyRelation;

class AutoReplyResource extends Resource
{
    protected static ?string $model = AutoReply::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'AutoReply';

    public static function form(Schema $schema): Schema
    {
        return AutoReplyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AutoRepliesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'childs'=>AutoReplyRelation::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAutoReplies::route('/'),
            'edit' => EditAutoReply::route('/{record}/edit'),
        ];
    }
}
