<?php

namespace App\Filament\Resources\Rws;

use BackedEnum;
use App\Models\Rw;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Rws\Pages\EditRw;
use App\Filament\Resources\Rws\Pages\ListRws;
use App\Filament\Resources\Rws\Pages\CreateRw;
use App\Filament\Resources\Rws\Schemas\RwForm;
use App\Filament\Resources\Rws\Tables\RwsTable;
use App\Filament\Resources\Rws\RelationManagers\RtRelationManager;

class RwResource extends Resource
{
    protected static ?string $model = Rw::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'RW';

    public static function form(Schema $schema): Schema
    {
        return RwForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RwsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'rts'=>RtRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRws::route('/'),
            'create' => CreateRw::route('/create'),
            'edit' => EditRw::route('/{record}/edit'),
        ];
    }
}
