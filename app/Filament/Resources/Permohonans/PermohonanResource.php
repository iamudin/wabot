<?php

namespace App\Filament\Resources\Permohonans;

use BackedEnum;
use App\Models\Permohonan;
use Filament\Actions\CreateAction;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Permohonans\Pages\EditPermohonan;
use App\Filament\Resources\Permohonans\Pages\ListPermohonans;
use App\Filament\Resources\Permohonans\Pages\CreatePermohonan;
use App\Filament\Resources\Permohonans\Schemas\PermohonanForm;
use App\Filament\Resources\Permohonans\Tables\PermohonansTable;
use App\Filament\Resources\Permohonans\RelationManagers\DataPermohonanRelationManager;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

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
            'dataPermohonans'=> DataPermohonanRelationManager::class
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
