<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AutoReply;
use Illuminate\Http\Request;
use App\Models\ChatbotSession;
use Illuminate\Support\Facades\Http;

class ApiWebhook extends Controller
{
    function __construct(){
     
    }

    public function webhook(Request $request)
    {
        
      
        // ============================
        // Ambil nomor WA
        // ============================

        $data = $request->all();
        $phone = $data['from'] ?? null;
            
        if (!$phone)
            return;
        
        $input = strtolower(trim($data['message'] ?? ''));

        // Ambil menu utama
        $mainMenu = AutoReply::where('key', 'menu')->first();

        if (!$mainMenu) {
            $this->send($phone, "Menu utama tidak ditemukan.");
            return;
        }

        // ======================================================
        // AMBIL SESSION TANPA MENGUBAH last_activity
        // ======================================================
        $session = ChatbotSession::where('phone', $phone)->first();

        // ======================================================
        // 1) BELUM ADA SESSION → BUAT BARU + KIRIM WELCOME
        // ======================================================
        if (!$session) {

            $session = ChatbotSession::create([
                'phone' => $phone,
                'session_state' => $mainMenu->id,
                'last_activity' => now()
            ]);

            $this->send($phone, $mainMenu->value);
            return;
        }

        // ======================================================
        // SIMPAN LAST ACTIVITY SEBELUM UPDATE
        // ======================================================

        // ======================================================
        // 2) TIMEOUT 60 DETIK
        // ======================================================
        $lastActivity = $session->last_activity instanceof Carbon
            ? $session->last_activity
            : Carbon::parse($session->last_activity);

        // Cara yang jelas: apakah last_activity lebih lama dari 60 detik yang lalu?
        if ($lastActivity->lt(now()->subSeconds(60))) {
            // timeout: reset session dan kirim welcome
            $session->update([
                'session_state' => $mainMenu->id,
                'last_activity' => now()
            ]);
            $this->send($phone, $mainMenu->value);
            return;
        }


        // ======================================================
        // JIKA TIDAK TIMEOUT → BARU UPDATE last_activity
        // ======================================================
        $session->update(['last_activity' => now()]);


        // ============================
        // Jika user ketik 'menu'
        // ============================
        if ($input === 'menu') {

            $session->update(['session_state' => $mainMenu->id]);

            $this->send($phone, $mainMenu->value);
            return;
        }

        if ($input === 'daftar') {


            $this->send($phone, 'anda akan melakukan pendaftaran');
            return;
        }
        // ============================
        // Ambil menu aktif sekarang
        // ============================
        $current = AutoReply::find($session->session_state);

        if (!$current) {
            $session->update(['session_state' => $mainMenu->id]);
            $this->send($phone, $mainMenu->value);
            return;
        }

        // ============================
        // Ambil submenu dari current
        // ============================
        $children = AutoReply::where('parent_id', $current->id)->get();

        // ================================================================
        // 3) JIKA CURRENT PUNYA SUBMENU
        // ================================================================
        if ($children->count() > 0) {

            // Harus angka
            if (!ctype_digit($input)) {
                $this->send($phone, "Silakan pilih *angka* sesuai menu.");
                return;
            }

            $index = intval($input) - 1;

            // Validasi pilihan
            if (!isset($children[$index])) {
                $this->send($phone, "Pilihan tidak valid.\nKetik *menu* untuk kembali.");
                return;
            }

            $selected = $children[$index];

            // Kirim isi submenu
            $this->send($phone, $selected->value);

            // Ubah state ke submenu yang dipilih
            $session->update(['session_state' => $selected->id]);

            return;
        }

        // ================================================================
        // 4) JIKA CURRENT TIDAK ADA SUBMENU (LEVEL DETAIL)
        // ================================================================
        if ($current->parent_id) {

            // Tombol kembali
            if ($input === '0') {
                $session->update(['session_state' => $current->parent_id]);

                $parent = AutoReply::find($current->parent_id);
                $this->send($phone, $parent->value);
                return;
            }

            // Selain 0 → tolak
            $this->send($phone, "Ketik *0* untuk kembali ke menu sebelumnya.");
            return;
        }

        // ================================================================
        // 5) Jika tak dikenali
        // ================================================================
        $this->send($phone, "Perintah tidak dikenali.\nKetik *menu* untuk kembali.");
    }


    private function send($phone, $text)
    {
        defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => config('wabot.wa_session'),
            'to' => $phone,
            'text' => str_replace('\n', "\r", $text),
            'is_group' => false,
        ]));

        return true;
    }
    function webhoodk($type=null){

    //   AutoReply::create([
    //         'key' => '1',
    //         'value' => json_encode(request()->all()),
    //         'action' => 'reply_value'
    //     ]);
    //     return true;
        
    if($type=='message'){
            $number = collect(request('from'))
                ->filter(fn($jid) => str_starts_with($jid, '62'))
                ->map(fn($jid) => str($jid)->before('@')->value())
                ->first();

            $reply = AutoReply::where('key',request()->message)->first();
            if($reply){
                defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
                    'session' => 'sadhan',
                    'to' => $number,
                    'text' => $reply->value,
                    'is_group' => false,
                ]));
            }else{
                defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
                    'session' => 'sadhan',
                    'to' => $number,
                    'text' => 'Maaf keyword tidak ditemukan',
                    'is_group' => false,
                ]));  
            }
          
    }
    }
}
