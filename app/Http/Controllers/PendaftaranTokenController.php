<?php
namespace App\Http\Controllers;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\PendaftaranToken;
use App\Services\FileCryptoService;
use Illuminate\Support\Facades\Http;

class PendaftaranTokenController extends Controller
{
    public function show(Request $request)
    {
        $token = PendaftaranToken::where('token', $request->token)->firstOrFail();

        if (!$token->isValid()) {
            abort(403, 'Link tidak valid atau sudah kedaluwarsa');
        }

        return view('pendaftaran.form', [
            'token' => $token->token
        ]);
    }

    public function submit(
        Request $request,
        FileCryptoService $crypto
    ) {
        $token = PendaftaranToken::where('token', $request->token)->firstOrFail();

        if (!$token->isValid()) {
            abort(403, 'Token tidak valid atau kedaluwarsa');
        }

        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🔐 AMBIL FILE & ENKRIPSI
        $fileContent = file_get_contents($request->file('ktp')->getRealPath());

        $encryptedPayload = $crypto->encrypt($fileContent);

        // SIMPAN DATA PENDUDUK
        Penduduk::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nomor_whatsapp' => $token->phone, // dari token
            'file_ktp' => $encryptedPayload, // 🔥 ENKRIPSI
        ]);

        // TOKEN SEKALI PAKAI
        defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => config('wabot.wa_session'),
            'to' => $token->phone,
            'text' => str_replace('\n', "\r", 'Terima kasih pendaftaran sudah berhasil dilakukan dan sedang kami proses untuk validasi dalam waktu 1x24 jam.'),
            'is_group' => false,
        ]));
        $token->update(['used' => true]);
      
        return view('pendaftaran.sukses');
    }
}
