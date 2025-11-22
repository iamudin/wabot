<?php

namespace App\Filament\Resources\Permohonans;

use App\Filament\Resources\Permohonans\Pages\CreatePermohonan;
use App\Filament\Resources\Permohonans\Pages\EditPermohonan;
use App\Filament\Resources\Permohonans\Pages\ListPermohonans;
use App\Filament\Resources\Permohonans\Schemas\PermohonanForm;
use App\Filament\Resources\Permohonans\Tables\PermohonansTable;
use App\Models\Permohonan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'permohonan';

    public static function form(Schema $schema): Schema
    {
        return PermohonanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermohonansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermohonans::route('/'),
            'create' => CreatePermohonan::route('/create'),
            'edit' => EditPermohonan::route('/{record}/edit'),
        ];
    }
}
