<?php

namespace App\Services;

use App\Models\Permohonan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Geometry\Rectangle;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TtePdfService
{
    /**
     * Proses tanda tangan elektronik PDF
     */

public function generate($permohonan)
{

    $jabatan = $permohonan->penandatangan->jabatan;
    $nama    = $permohonan->penandatangan->nama;

    // =======================
    // BUAT QR
    // =======================
    $qrPath = public_path($permohonan->kode_tiket.'.png');

    QrCode::format('png')
        ->size(220)
        ->margin(1)
        ->generate(
            url('surat/' . $permohonan->kode_tiket),
            $qrPath
        );

    $manager = ImageManager::gd();

    // =======================
    // DIMENSI
    // =======================
    $width  = 800;
    $height = 240;
    $border = 5;

    // =======================
    // CANVAS BORDER (HITAM)
    // =======================
    $canvas = $manager->create(
        $width + ($border * 2),
        $height + ($border * 2)
    )->fill('#000000');

    // =======================
    // KONTEN DALAM (PUTIH)
    // =======================
    $content = $manager->create($width, $height)->fill('#ffffff');

    // =======================
    // QR
    // =======================
    $qrImg = $manager->read($qrPath);
    $content->place($qrImg, 'left', 10, 10);

    // =======================
    // TEXT
    // =======================
    $content->text(
        'Ditandatangani secara elektronik oleh:',
        260,
        40,
        function ($font) {
            $font->file(public_path('Arial.ttf'));
            $font->size(20);
            $font->color('#000000');
        }
    );

    $content->text(
        strtoupper($jabatan),
        260,
        80,
        function ($font) {
            $font->file(public_path('Arial_Bold.ttf'));
            $font->size(22);
            $font->color('#000000');
        }
    );

    $content->text(
        strtoupper($nama),
        260,
        130,
        function ($font) {
            $font->file(public_path('Arial_Bold.ttf'));
            $font->size(22);
            $font->color('#000000');
        }
    );

    // =======================
    // TEMPEL KE CANVAS (BORDER)
    // =======================
    $canvas->place($content, 'top-left', $border, $border);

    // =======================
    // OUTPUT BASE64
    // =======================
    return base64_encode($canvas->toPng());
}

    public function sign($permohonan, string $passphrase): array {
        $pdfPath = Storage::disk('public')->path($permohonan->file_surat);

        if (!is_file($pdfPath)) {
            return $this->fail('File PDF tidak ditemukan.');
        }

        $pdfBase64 = base64_encode(file_get_contents($pdfPath));
        $payload = [
            "nik" => $permohonan->penandatangan->nik,
            "passphrase" => $passphrase,

            "signatureProperties" => [
                [
                    "tampilan" => "VISIBLE",
                    "imageBase64" => "" . $this->generate($permohonan) . "",
                    "page" => config('wabot.page'),
                    "originX" => config('wabot.originX'),
                    "originY" => config('wabot.originY'),
                    "width" => config('wabot.width'),
                    "height" => config('wabot.height'),
                    "reason" => "Tanda tangan elektronik untuk surat milik {$permohonan->penduduk->nik} untuk {$permohonan->layanan->nama_layanan}",
                ]
            ],
            "file" => [$pdfBase64],
        ];

        $response = Http::withBasicAuth(
            config('tte.username_api'),
            config('tte.password_api')
        )
            ->acceptJson()
            ->post(config('tte.endpoint_api') . '/api/v2/sign/pdf', $payload);

        if (!$response->successful()) {
            return $this->fail('Gagal menandatangani surat', $response->body());
        }

        $pathTte = $this->simpanPdfDariBase64(
            $response->json()['file'][0],
            $permohonan->file_surat
        );

        return [
            'success' => true,
            'path' => $pathTte,
        ];
    }

    /**
     * Batalkan tanda tangan elektronik
     */
    public function cancel($permohonan): void {
        if ($permohonan->ditandatangani_pada && Storage::disk('local')->exists($permohonan->surat_tte)) {
            File::delete(Storage::disk('local')->path($permohonan->surat_tte));
        }

        $permohonan->update([
            'surat_tte' => null,
            'ditandatangani_pada' => null,
        ]);
    }

    /**
     * Simpan PDF dari base64
     */
    protected function simpanPdfDariBase64(string $base64String, $filename): string {
        if (str_starts_with($base64String, 'data:application/pdf;base64,')) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
        }

        $base64String = str_replace(' ', '+', $base64String);
        $pdfContent = base64_decode($base64String);

        if ($pdfContent === false) {
            throw new \RuntimeException('Base64 PDF tidak valid.');
        }

        $namaFile = 'signed_' . basename($filename);
        $path = '/permohonan/file-surat/' . $namaFile;

        Storage::disk('local')->put(
            $path,
            $pdfContent
        );

        return 'permohonan/file-surat/' . $namaFile;
    }

    protected function fail(string $message, mixed $detail = null): array {
        return [
            'success' => false,
            'message' => $message,
            'detail' => $detail,
        ];
    }
}
