<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AutoReply;

class AutoReplySeeder extends Seeder
{
    public function run(): void
    {
        // ROOT MENU - INFO DESA
        $infoDesa = AutoReply::create([
            'parent_id' => null,
            'key' => '1',
            'title' => 'Informasi Desa',
            'value' => 'Silakan pilih informasi desa berikut:'
        ]);

        // === PROFIL DESA ===
        $profil = AutoReply::create([
            'parent_id' => $infoDesa->id,
            'key' => '1',
            'title' => 'Profil Desa',
            'value' => 'Profil singkat Desa kami.'
        ]);

        AutoReply::create([
            'parent_id' => $profil->id,
            'key' => '1',
            'title' => 'Sejarah Desa',
            'value' => 'Desa ini berdiri sejak tahun 1950 dan berkembang hingga sekarang.'
        ]);

        AutoReply::create([
            'parent_id' => $profil->id,
            'key' => '2',
            'title' => 'Visi & Misi',
            'value' => "Visi:\nMewujudkan desa mandiri.\n\nMisi:\n1. Pelayanan publik\n2. Pemberdayaan masyarakat"
        ]);

        // === PEMERINTAHAN ===
        $pemerintahan = AutoReply::create([
            'parent_id' => $infoDesa->id,
            'key' => '2',
            'title' => 'Pemerintahan Desa',
            'value' => 'Struktur pemerintahan desa.'
        ]);

        AutoReply::create([
            'parent_id' => $pemerintahan->id,
            'key' => '1',
            'title' => 'Kepala Desa',
            'value' => 'Nama Kepala Desa: Bapak Ahmad'
        ]);

        AutoReply::create([
            'parent_id' => $pemerintahan->id,
            'key' => '2',
            'title' => 'Perangkat Desa',
            'value' => "Sekretaris Desa\nKaur Keuangan\nKaur Umum"
        ]);

        // === KONTAK ===
        AutoReply::create([
            'parent_id' => $infoDesa->id,
            'key' => '3',
            'title' => 'Kontak Desa',
            'value' => "📞 Telp: 0812xxxxxxx\n📧 Email: desa@email.com"
        ]);
    }
}
