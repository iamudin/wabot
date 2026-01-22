<?php

namespace App\Filament\Pages;
use BackedEnum;
use Filament\Forms;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Filament\Resources\Users\Widgets\LaporanStats;


class Laporan extends Page implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;
    protected string $view = 'permohonan-surat';


    protected static string|BackedEnum|null $navigationIcon= 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Permohonan';


   

    public function table(Table $table): Table
    {

        return $table->records()->columns([
          
            TextColumn::make('nama_skpd'),
            TextColumn::make('nilai_konversi')->label('IKM'),
            TextColumn::make('predikat_mutu_layanan')->label('Predikat'),
            TextColumn::make('sample_diambil')->label('Responden'),
            ViewColumn::make('statistik_responden')
                ->label('Statistik')
                ->view('filament.components.statistik-card')
        ])->deferLoading()->striped()
         ->recordActions([
                Action::make('cetak')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->modalHeading('Pilih Jenis Cetak')
                    ->form([
                      Select::make('tipe')
                            ->label('Jenis Cetak')
                            ->options([
                                'olahan' => 'Cetak Olahan Data',
                                'rekap' => 'Cetak Rekapitulasi',
                            ])
                            ->required(),
                    ])
               
                ]);
      
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                //TextInput::make('email')->placeholder('email@email.com'),
            ]);
    }
}
