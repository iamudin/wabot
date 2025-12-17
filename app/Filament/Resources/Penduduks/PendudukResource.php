<?php

namespace App\Filament\Resources\Penduduks;

use BackedEnum;
use App\Models\Penduduk;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Penduduks\Pages\EditPenduduk;
use App\Filament\Resources\Penduduks\Pages\ListPenduduks;
use App\Filament\Resources\Penduduks\Pages\CreatePenduduk;
use App\Filament\Resources\Penduduks\Schemas\PendudukForm;
use App\Filament\Resources\Penduduks\Tables\PenduduksTable;
use App\Filament\Resources\Permohonan\RelationManagers\PermohonanRelationManager;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class; 

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'penduduk';

    public static function form(Schema $schema): Schema
    {
        return PendudukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenduduksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'permohonans'=>PermohonanRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenduduks::route('/'),
            'create' => CreatePenduduk::route('/create'),
            'edit' => EditPenduduk::route('/{record}/edit'),
        ];
    }
}
