<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\AutoReply;
use Illuminate\Http\Request;
use App\Models\ChatbotSession;

class BotWebHookController extends Controller
{
    public function webhook(Request $request)
    {
        $phone = $request->input('from');
        $message = trim($request->input('message'));

        $session = ChatbotSession::firstOrCreate(
            ['phone' => $phone],
            ['state' => 'main_menu']
        );

        switch ($session->state) {

            case 'main_menu':
                return $this->handleMainMenu($session, $message);
        case 'info_desa':
            return $this->handleInfoDesa($session, $message);
            case 'layanan_list':
                return $this->handlePilihLayanan($session, $message);

            case 'layanan_confirm':
                // return $this->handleKonfirmasiLayanan($session, $message);
        }

    }


    private function handlePilihLayanan($session, $message)
    {
        $layanan = Layanan::where('status', 1)->get();

        $index = (int) $message - 1;

        if (!isset($layanan[$index])) {
            return $this->sendMessage($session->phone, "❌ Pilihan tidak valid.");
        }

        $selected = $layanan[$index];

        $session->update([
            'state' => 'layanan_confirm',
            'payload' => json_encode([
                'layanan_id' => $selected->id
            ])
        ]);

        return $this->sendMessage(
            $session->phone,
            "📌 *" . $selected->nama_layanan . "*\n\nApakah Anda ingin mengajukan permohonan?\n\n1. Ya\n2. Tidak"
        );
    }

    private function sendDaftarLayanan($phone)
    {
        $layanan = Layanan::where('status', 1)->get();

        $text = "📄 Layanan Surat:\n";
        foreach ($layanan as $i => $l) {
            $text .= ($i + 1) . ". " . $l->nama_layanan . "\n";
        }

        return $this->sendMessage($phone, $text);
    }

    private function handleMainMenu($session, $message)
    {
        if ($message == '1') {
            $session->update(['state' => 'info_desa','current_parent_id'=>null]);
            return $this->sendMessage(
                $session->phone,
                "📌 Informasi Desa:\n1. Profil Desa\n2. Visi Misi\n3. Struktur Pemerintahan"
            );
        }

        if ($message == '2') {
            $session->update(['state' => 'layanan_surat']);
            return $this->sendDaftarLayanan($session->phone);
        }

        if ($message == '3') {
            $session->update(['state' => 'pendaftaran_confirm']);
            return $this->sendMessage(
                $session->phone,
                "Apakah Anda ingin mendaftar?\n1. Ya\n2. Tidak"
            );
        }

        return $this->sendMessage(
            $session->phone,
            "Selamat datang di WhatsApp Desa 🌾\n\n1. Informasi Desa\n2. Layanan Surat\n3. Pendaftaran"
        );
    }
    private function buildInfoMenu($parentId)
    {
        $items = AutoReply::where('parent_id', $parentId)->get();

        $text = "📌 *Informasi Desa*\n\n";

        foreach ($items as $item) {
            $text .= $item->key . ". " . $item->title . "\n";
        }

        return $text;
    }

    private function handleInfoDesa($session, $message)
    {
        $parentId = $session->current_parent_id;

        $item = AutoReply::where('parent_id', $parentId)
            ->where('key', $message)
            ->first();

        if (!$item) {
            return $this->sendMessage($session->phone, "❌ Pilihan tidak tersedia.");
        }

        // Ambil child
        $children = AutoReply::where('parent_id', $item->id)->get();

        $text = "";

        // Jika punya value, tetap balas
        if ($item->value) {
            $text .= $item->value . "\n\n";
        }

        // Jika punya child → tampilkan submenu
        if ($children->count()) {
            $text .= "📌 *" . $item->title . "*\n\n";

            foreach ($children as $child) {
                $text .= $child->key . ". " . $child->title . "\n";
            }

            $session->update([
                'state' => 'info_tree',
                'current_parent_id' => $item->id
            ]);

            return $this->sendMessage($session->phone, $text);
        }

        // Jika leaf → kembali ke root info
        $rootMenu = $this->buildInfoMenu(null);

        $session->update([
            'state' => 'info_root',
            'current_parent_id' => null
        ]);

        return $this->sendMessage($session->phone, $text . "\n" . $rootMenu);
    }

    function sendMessage($phone, $message)
    {
        $msg = json_decode(json_encode(['admin' => str_replace('\n', "<br>", $message), 'user' => request('message')]));
        return view('kolom-pesan', compact('msg'));
        $apiUrl = config('services.whatsapp.api_url');
        $apiToken = config('services.whatsapp.api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '/send-message', [
            'to' => $phone,
            'message' => $message,
        ]);

        return $response->json();
    }
}
