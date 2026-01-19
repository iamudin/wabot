<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Services\FileCryptoService;

class FileController extends Controller
{
    public function streamKTP(
        Penduduk $penduduk,
        FileCryptoService $crypto,
        Request $request
    ){

        // 🔒 AUTHORIZATION (WAJIB)

        if (! $penduduk->file_ktp) {
            abort(404);
        }

        $payload = is_array($penduduk->file_ktp)
            ? $penduduk->file_ktp
            : json_decode($penduduk->file_ktp, true);

        return response()->stream(function () use ($crypto, $payload) {

            $crypto->decryptStream($payload, function ($chunk) {
                echo $chunk;
            });

        }, 200, [
            'Content-Type'        => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="ktp.jpg"',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
            'Pragma'              => 'no-cache',
        ]);
    }
}
