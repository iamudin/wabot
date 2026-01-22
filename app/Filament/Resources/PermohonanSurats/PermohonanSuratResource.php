<?php

namespace App\Filament\Resources\PermohonanSurats;

use BackedEnum;
use App\Models\Permohonan;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\Penandatangan;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PermohonanSurats\Pages\LihatPermohonan;
use App\Filament\Resources\PermohonanSurats\Pages\EditPermohonanSurat;
use App\Filament\Resources\PermohonanSurats\Pages\ListPermohonanSurats;
use App\Filament\Resources\PermohonanSurats\Pages\CreatePermohonanSurat;
use App\Filament\Resources\PermohonanSurats\Schemas\PermohonanSuratForm;
use App\Filament\Resources\PermohonanSurats\Tables\PermohonanSuratsTable;

class PermohonanSuratResource extends Resource
{
    protected static ?string $model = Permohonan::class;
protected static ?string $navigationLabel = 'Permohonan Surat';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Permohonan Surat';
public static function canViewAny(): bool
{
        return auth()->user()->isPenandatangan();
}
    public static function form(Schema $schema): Schema
    {
        return PermohonanSuratForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermohonanSuratsTable::configure($table);
    }
public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();    

        if(auth()->user()->isPenandatangan() && auth()->user()->penandatangan->kepala_desa==1){
        $query->whereIn('penandatangan_id',array_merge([auth()->user()->penandatangan->id],Penandatangan::pluck('id')->toArray()));

        }else{
            $query->where('penandatangan_id', auth()->user()->penandatangan?->id);
        }

    return $query;
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
            'index' => ListPermohonanSurats::route('/'),
            'edit' => EditPermohonanSurat::route('/{record}/edit'),
            'lihat' => LihatPermohonan::route('/{record}/lihat')
        ];
    }
}
