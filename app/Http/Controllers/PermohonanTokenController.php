<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Models\DataPermohonan;
use App\Models\PermohonanToken;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class PermohonanTokenController extends Controller
{
    public function show(Request $request) {
        $token = PermohonanToken::with('layanan.syaratLayanans')->where('token', $request->token)->first();

        if (!$token || !$token->isValid()) {
            abort(403, 'Link tidak valid atau sudah kedaluwarsa');
        }

        return view('permohonan.form', [
            'token' => $token->token,
            'data' => $token->layanan
        ]);
    }

    public function cetakPermohonan($permohonan_id) {
        $data = Permohonan::with([
            'dataPermohonans'
        ])->findOrFail($permohonan_id);
        $template = new TemplateProcessor(Storage::path($data->layanan->template_surat));
        $data_syarat = $data->dataPermohonans->pluck('keterangan', 'key')->toArray();
        $penduduk = $data->penduduk->toArray();
        $datafix = array_merge($data_syarat, $penduduk);
        unset($datafix['file_ktp']);
        //array_merge($data_syarat, $penduduk)
        $template->setValues(['tgl_cetak'=>now()->format('d F Y')]);
        $template->setValues(['nomor_surat'=>$data->nomor_surat]);
        $template->setValues($datafix);
        $path = Storage::makeDirectory('permohonan/hasil-surat');
        $docname = '/permohonan/hasil-surat/' . uniqid() . '.docx';
        $docpath = Storage::path($docname);
        $template->saveAs($docpath);
        $data->update(['hasil_docx' => $docname]);
        return $docname;
    }
    public function streamHasilSurat($filename){
        $path = 'permohonan/hasil-surat/' . $filename;
        abort_unless(Storage::disk('public')->exists($path), 404);

    return response()->stream(function () use ($path) {
        echo Storage::get($path);
    }, 200, [
        'Content-Type' => Storage::mimeType($path),
        'Content-Disposition' => 'inline; filename="'.basename($path).'"',
    ]);
    }
    public function generateTicket() {
        $last = Permohonan::orderBy('id', 'desc')->first();

        $number = $last ? $last->id + 1 : 1;

        return date('Ymd') . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function submit(Request $request) {
        $token = PermohonanToken::where('token', $request->token)->firstOrFail();

        if (!$token->isValid()) {
            abort(403, 'Token sudah digunakan');
        }

        // SIMPAN DATA PERMOHONAN
        $permohonan = Permohonan::create([
            'layanan_id' => $token->layanan->id,
            'penduduk_id' => Penduduk::where('nomor_whatsapp', $token->phone)->first()?->id,
            'kode_tiket' => $this->generateTicket(),
            'diajukan_pada' => now(),
        ]);
        $data[] = null;
        $syarat = $token->layanan->syaratLayanans;
        foreach ($syarat as $row) {
            $request_key = 'syarat_' . $row->id;
            if ($req = $request->$request_key) {
                DataPermohonan::updateOrCreate([
                    'permohonan_id' => $permohonan->id,
                    'syarat_layanan_id' => $row->id,
                ], [
                    'keterangan' => $req,
                    'key' => $row->kata_kunci,
                    'status' => 'menunggu',
                    'is_valid' => '0'
                ]);
            }
        }

        $token->update(['used' => true]);
         defer(fn() => Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => config('wabot.wa_session'),
            'to' => $permohonan->penduduk->nomor_whatsapp,
            'text' => 'Permohonan '.$permohonan->layanan->nama_layanan.' anda telah kami terima dengan kode tiket #'.$permohonan->kode_tiket.'.\r Akan kami proses 1x24 jam. mohon tunggu informasi selanjutnya. \r Terima kasih telah menggunakan layanan kami.',
            'is_group' => false,
        ]));
        return view('permohonan.sukses');
    }

    function validasi($kode_tiket){
        $data = Permohonan::where('kode_tiket', $kode_tiket)->first();
        abort_if(!$data, 404);
        return view('permohonan.validasi', compact('data'));
    }
}
