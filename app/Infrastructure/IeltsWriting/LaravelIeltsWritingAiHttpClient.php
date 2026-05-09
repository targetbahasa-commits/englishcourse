<?php

namespace App\Infrastructure\IeltsWriting;

use App\Domain\IeltsWriting\Contracts\IeltsWritingAiHttpClient;
use Illuminate\Support\Facades\Http;

class LaravelIeltsWritingAiHttpClient implements IeltsWritingAiHttpClient
{
    public function postJson(string $url, array $payload, int $timeout): ?array
    {
        $response = Http::timeout($timeout)->post($url, $payload);

        if (! $response->successful()) {
            return null;
        }

        return $response->json();
    }
}
