<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileCryptoService;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    public function stream(string $filename, FileCryptoService $crypto)
    {
        $payload = json_decode(
            Storage::get("secure/{$filename}"),
            true
        );

        return response()->stream(function () use ($crypto, $payload) {
            $crypto->decryptStream($payload, function ($chunk) {
                echo $chunk;
                flush();
            });
        }, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="file-decrypt.jpg"',
            'Cache-Control' => 'no-store',
        ]);
    }
        public function download(string $filename, FileCryptoService $crypto)
    {
        $payload = json_decode(
            Storage::get("secure/{$filename}"),
            true
        );

        $decrypted = $crypto->decrypt(
            $payload['data'],
            $payload['key'],
            $payload['iv']
        );

        return response($decrypted)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'inline; filename="file-asli.jpg"');
    }

    public function upload(Request $request, FileCryptoService $crypto)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $fileContent = file_get_contents($request->file('file')->getRealPath());

        $encrypted = $crypto->encrypt($fileContent);

        $filename = uniqid() . '.enc';

        Storage::put("secure/{$filename}", json_encode($encrypted));

        return response()->json([
            'status' => 'success',
            'file' => $filename
        ]);
    }
}