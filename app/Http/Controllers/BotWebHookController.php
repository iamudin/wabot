<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\AutoReply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChatbotSession;
use App\Models\PermohonanToken;
use App\Models\PendaftaranToken;
use Illuminate\Support\Facades\Http;

class BotWebHookController extends Controller
{
    public function webhook(Request $request, $type=null)
    {
        if($type && $type!='message'){
            return;
        }
        $phone = $request->input('from');
        $message = trim($request->input('message'));
      
        $session = ChatbotSession::firstOrCreate(
            ['phone' => $phone],
            [
                'state' => 'main_menu',
                'last_activity' => now()
            ]
        );

        // ⏱️ Timeout 1 menit
        if (
            $session->last_activity &&
            Carbon::parse($session->last_activity)->diffInSeconds(now()) > 60
        ) {
            $session->update([
                'state' => 'main_menu',
                'current_parent_id' => null,
                'payload' => null
            ]);
        }

        $session->update(['last_activity' => now()]);

        return match ($session->state) {
            'main_menu' => $this->handleMainMenu($session, $message),
            'konfirmasi_daftar' => $this->handleKonfirmasiDaftar($session, $message),
            'layanan_list' => $this->handlePilihLayanan($session, $message),
            'layanan_confirm' => $this->handleKonfirmasiLayanan($session, $message),
            'info_desa' => $this->handleInfoDesa($session, $message),
            default => $this->resetToMainMenu($session)
        };
    }

    private function handleKonfirmasiDaftar($session, $message)
    {
        // User setuju daftar
        if ($message == '1') {

            $token = $this->generatePendaftaranToken();

            PendaftaranToken::create([
                'phone' => $session->phone,
                'token' => $token,
                'expired_at' => Carbon::now()->addMinutes(30),
            ]);

            $link = url('/pendaftaran?token=' . $token);

            return $this->sendMessage(
                $session->phone,
                "📝 *Pendaftaran Penduduk Desa*\n\n" .
                "Silakan isi formulir melalui link berikut:\n" .
                "$link\n\n" .
                "⏳ Berlaku 30 menit\n" 
                
            );
        }

        // User batal
        $session->update(['state' => 'main_menu']);

        return $this->sendMessage(
            $session->phone,
            "❌ Pendaftaran dibatalkan.\n\nSilakan pilih menu lainnya."
        );
    }

    /* =======================
     * MAIN MENU
     * ======================= */
    private function handleMainMenu($session, $message)
    {
        if ($message == '1') {
            $root = AutoReply::where('key', 'info_desa')->first();

            $session->update([
                'state' => 'info_desa',
                'current_parent_id' => $root?->id
            ]);

            return $this->sendMessage(
                $session->phone,
                $this->buildInfoMenu($root?->id)
            );
        }

        if ($message == '2') {
            $session->update(['state' => 'layanan_list']);
            return $this->sendDaftarLayanan($session->phone);
        }
     
        return $this->sendMessage(
            $session->phone,
            "🌾 *WhatsApp Desa*\n\n" .
            "1. Informasi Desa\n" .
            "2. Layanan Surat"
        );
    }

    /* =======================
     * INFO DESA (TREE)
     * ======================= */
    private function handleInfoDesa($session, $message)
    {
        $parentId = $session->current_parent_id;

        // ⬅️ Kembali
        // ⬅️ Kembali
        if ($message === '0') {

            // Node saat ini
            $current = AutoReply::find($parentId);

            // Jika tidak ada parent → kembali ke main menu
            if (!$current || $current->parent_id === null) {
                $session->update([
                    'state' => 'main_menu',
                    'current_parent_id' => null
                ]);

                return $this->sendMessage(
                    $session->phone,
                    "🌾 *WhatsApp Desa*\n\n" .
                    "1. Informasi Desa\n" .
                    "2. Layanan Surat"
                );
            }

            // Mundur ke parent sebelumnya
            $session->update([
                'state' => 'info_desa',
                'current_parent_id' => $current->parent_id
            ]);

            return $this->sendMessage(
                $session->phone,
                $this->buildInfoMenu($current->parent_id)
            );
        }


        $item = AutoReply::where('parent_id', $parentId)
            ->where('key', $message)
            ->first();

        if (!$item) {
            return $this->sendMessage(
                $session->phone,
                "❌ Pilihan tidak tersedia\n\n" .
                $this->buildInfoMenu($parentId)
            );
        }

        $children = AutoReply::where('parent_id', $item->id)->get();
        $text = $item->value ? $item->value . "\n\n" : '';

        if ($children->count()) {
            foreach ($children as $child) {
                $text .= $child->key . ". " . $child->title . "\n";
            }

            $text .= "\n0. Kembali";

            $session->update([
                'current_parent_id' => $item->id
            ]);

            return $this->sendMessage($session->phone, $text);
        }

        return $this->sendMessage(
            $session->phone,
            $text . "\n" . $this->buildInfoMenu($parentId)
        );
    }

    private function buildInfoMenu($parentId)
    {
        $items = AutoReply::where('parent_id', $parentId)->get();

        if (!$items->count()) {
            return "❌ Data tidak tersedia";
        }

        $text = "📌 *Informasi Desa*\n\n";

        foreach ($items as $item) {
            $text .= $item->key . ". " . $item->title . "\n";
        }

        $parent = AutoReply::find($parentId);

        $text .= $parent && $parent->parent_id === null
            ? "\n0. Menu Utama"
            : "\n0. Kembali";

        return $text;
    }

    /* =======================
     * LAYANAN
     * ======================= */
    private function sendDaftarLayanan($phone)
    {
        $layanan = Layanan::where('status', 1)->get();

        $text = "📄 *Layanan Surat*\n\n";
        foreach ($layanan as $i => $l) {
            $text .= ($i + 1) . ". " . $l->nama_layanan . "\n";
        }

        return $this->sendMessage($phone, $text);
    }

    private function handlePilihLayanan($session, $message)
    {
        $layanan = Layanan::where('status', 1)->get();
        $index = (int) $message - 1;

        if (!isset($layanan[$index])) {
            return $this->sendMessage($session->phone, "❌ Pilihan tidak valid");
        }

        $session->update([
            'state' => 'layanan_confirm',
            'payload' => json_encode(['layanan_id' => $layanan[$index]->id])
        ]);

        return $this->sendMessage(
            $session->phone,
            "📌 *{$layanan[$index]->nama_layanan}*\n\n" .
            $layanan[$index]->keterangan.
            "\n\nApakah Anda ingin mengajukan?\n" .
            "1. Ya\n2. Tidak"
        );
    }
    private function generatePendaftaranToken()
    {
        return hash('sha256', Str::random(60) . now());
    }
    private function generateOneAccessToken(): string
    {
        return hash('sha256', Str::random(60) . now());
    }
    private function handleKonfirmasiLayanan($session, $message)
    {
        if ($message == '1') {

            // 🔍 Cek penduduk berdasarkan no HP
            $penduduk = Penduduk::where('nomor_whatsapp', $session->phone)->first();

            // ❌ JIKA BELUM TERDAFTAR
            if (!$penduduk) {

                $session->update([
                    'state' => 'konfirmasi_daftar'
                ]);

                return $this->sendMessage(
                    $session->phone,
                    "⚠️ *Data Anda belum terdaftar sebagai penduduk desa*\n\n" .
                    "Untuk mengajukan layanan, silakan melakukan pendaftaran terlebih dahulu.\n\n" .
                    "Ketik:\n" .
                    "1️⃣ Ya, daftar sekarang\n" .
                    "2️⃣ Tidak, batal"
                );
            }

            // ✅ JIKA SUDAH TERDAFTAR → LANJUT BUAT TOKEN
            $token = $this->generateOneAccessToken();

            PermohonanToken::create([
                'phone' => $session->phone,
                'layanan_id' => json_decode($session->payload)->layanan_id ?? null,
                'token' => $token,
                'expired_at' => Carbon::now()->addMinutes(30),
            ]);

            $link = url('/form-permohonan/'. $token);

            return $this->sendMessage(
                $session->phone,
                "✅ *Permohonan diproses*\n\n" .
                "Silakan isi formulir melalui link berikut (berlaku 30 menit):\n" .
                "$link\n\n" .
                "_Link hanya dapat digunakan satu kali_"
            );
        }

        $session->update(['state' => 'main_menu']);
        return $this->handleMainMenu($session, '');
    }
    /* =======================
     * UTIL
     * ======================= */
    private function resetToMainMenu($session)
    {
        $session->update(['state' => 'main_menu']);
        return $this->handleMainMenu($session, '');
    }

    private function sendMessage($phone, $message)
    {
        // // ⚠️ Untuk testing UI
        // $msg = (object) [
        //     'admin' => nl2br($message),
        //     'user' => request('message')
        // ];
        // return view('kolom-pesan', compact('msg'));

        // 🔴 Aktifkan jika sudah ke API WhatsApp

        defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => config('wabot.wa_session'),
            'to' => $phone,
            'text' => str_replace('\n', "\r", $message),
            'is_group' => false,
        ]));

        return true;
        }
        
}
