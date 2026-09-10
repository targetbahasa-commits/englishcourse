<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait VerifiesTurnstile
{
    protected function verifyTurnstile(Request $request): bool
    {
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        return $response->successful() && $response->json('success');
    }
}
