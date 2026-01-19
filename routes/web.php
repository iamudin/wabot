<?php 

use App\Jobs\WaBot;
use App\Http\Controllers\ApiWebhook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
use Filament\Http\Middleware\Authenticate;
use App\Http\Controllers\BotWebHookController;
use App\Http\Controllers\PermohonanTokenController;
use App\Http\Controllers\PendaftaranTokenController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
Route::get('coba', function () {
    // WaBot::dispatch(['to' => '6282315192789', 'text' => 'hallllobos']);
    defer(function () {
       $respon = Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => 'sadhfan',
            'to' => '6282315192789',
            'text' => 'hallobro',
            'is_group' => false,
        ]);
        return $respon;
    });
});

Route::get('kolom-pesan', function () {
    return view('kolom-pesan');
});
Route::get('preview-file/{path}', function ($path) {

    $path = base64_decode($path);
    abort_if(!$path || !Storage::disk('local')->exists($path), 404);

    return response()->file(
        Storage::disk('local')->path($path)
    );
})->name('file.preview');
Route::post('upload', [App\Http\Controllers\UploadController::class, 'upload']);
Route::get('/download/{file}', [UploadController::class, 'download']);
Route::get('/stream/{file}', [UploadController::class, 'stream']);
Route::get('/form-permohonan', [PermohonanTokenController::class, 'show']);
Route::get('/pendaftaran', [PendaftaranTokenController::class, 'show']);
Route::post('/pendaftaran-submit', [PendaftaranTokenController::class, 'submit']);
Route::prefix('api')->controller(BotWebHookController::class)->group(function () {
    Route::match(['get','post'],'webhook/{type}', 'webhook')->withoutMiddleware([VerifyCsrfToken::class]);;
});

Route::middleware([Authenticate::class])
    ->get('/secure/penduduk/{penduduk}/ktp', [FileController::class, 'streamKTP'])
    ->name('penduduk.ktp.stream');
