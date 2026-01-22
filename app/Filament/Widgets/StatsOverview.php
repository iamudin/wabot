<?php

namespace App\Filament\Widgets;

use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\Permohonan;
use App\Models\Penandatangan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array {

        return $this->dashboard();

    }

    protected function dashboard() {
        if (auth()->user()->isPenandatangan() && auth()->user()->penandatangan->kepala_desa) {
            return $this->dashboardKades();
        } elseif (auth()->user()->isPenandatangan() && !auth()->user()->penandatangan->kepala_desa) {
            return $this->dashboardPejabat();
        } else {
            return $this->dashboardAdmin();

        }
    }
    protected function dashboardKades() {
        return [
            Stat::make('Total Permohonan', Permohonan::where('status_permohonan', 'selesai')->count())
                ->icon('heroicon-o-envelope')
                 ->url('permohonan-surats')->extraAttributes([
    'wire:navigate' => true,
])
                ->color('success'),


            Stat::make('Sudah Tandatangan', Permohonan::where('status_permohonan', 'selesai')->whereNotNull('ditandatangani_pada')->count())

                ->icon('heroicon-o-check-badge')
                ->color('warning'),

            Stat::make('Belum Tandatangan', Permohonan::where('status_permohonan', 'selesai')->whereNull('ditandatangani_pada')->count())

                ->icon('heroicon-o-clock')
                ->color('info'),
        ];
    }
    protected function dashboardPejabat() {
        $pejabat_id = auth()->user()->penandatangan->id;
        return [
            Stat::make('Total Permohonan', Permohonan::where('status_permohonan', 'selesai')->where('penandatangan_id', $pejabat_id)->count())
                ->icon('heroicon-o-envelope')
                 ->url('permohonan-surats')
                ->color('success')->extraAttributes([
    'wire:navigate' => true,
]),

            Stat::make('Sudah Tandatangan', Permohonan::where('status_permohonan', 'selesai')->where('penandatangan_id', $pejabat_id)->whereNotNull('ditandatangani_pada')->count())

                ->icon('heroicon-o-check-badge')
                ->color('warning'),

            Stat::make('Belum Tandatangan', Permohonan::where('status_permohonan', 'selesai')->where('penandatangan_id', $pejabat_id)->whereNull('ditandatangani_pada')->count())

                ->icon('heroicon-o-clock')
                ->color('info'),
        ];
    }
    protected function dashboardAdmin() {
        return [
            Stat::make('Total Permohonan', Permohonan::where('status_permohonan', 'selesai')->count())
                ->icon('heroicon-o-envelope')
                ->url('permohonans')->extraAttributes([
    'wire:navigate' => true,
])
                ->color('success'),
            Stat::make('Sudah Tandatangan', Permohonan::where('status_permohonan', 'selesai')->whereNotNull('ditandatangani_pada')->count())
                ->icon('heroicon-o-check-badge')
                ->color('warning'),
            Stat::make('Belum Tandatangan', Permohonan::where('status_permohonan', 'selesai')->whereNull('ditandatangani_pada')->count())
                ->icon('heroicon-o-clock')
                ->color('info'),
            Stat::make('Layanan', Layanan::count())
                ->icon('heroicon-o-computer-desktop')
                ->color('info'),
            Stat::make('Penandatangan', Penandatangan::count())
                ->icon('heroicon-o-users')
                ->color('info'),
                Stat::make( 'Penduduk Terdaftar', Penduduk::count())
                ->icon('heroicon-o-users')
                ->color('info'),
        ];
    }
}
