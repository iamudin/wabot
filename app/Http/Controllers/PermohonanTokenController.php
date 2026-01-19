<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanToken;

class PermohonanTokenController extends Controller
{
    public function show(Request $request)
    {
        $token = PermohonanToken::where('token', $request->token)->first();

        if (!$token || !$token->isValid()) {
            abort(403, 'Link tidak valid atau sudah kedaluwarsa');
        }

        return view('permohonan.form', [
            'token' => $token->token
        ]);
    }

    public function submit(Request $request)
    {
        $token = PermohonanToken::where('token', $request->token)->firstOrFail();

        if (!$token->isValid()) {
            abort(403, 'Token sudah digunakan');
        }

        // SIMPAN DATA PERMOHONAN
        // Permohonan::create([...]);

        $token->update(['used' => true]);

        return view('permohonan.sukses');
    }
}
