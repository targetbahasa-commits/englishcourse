<?php

namespace App\Application\Dictionary;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Shared by ToeflDictionaryController (live student lookups) and the
 * dictionary:prewarm command (bulk background caching) so both go through
 * the exact same provider order/timeouts - a speed fix made here benefits
 * both call sites automatically instead of drifting apart.
 */
class ResolveWordTranslation
{
    /**
     * MyMemory first (best quality - real translation-memory matches, not
     * machine translation), Google Translate's unofficial endpoint as
     * fallback. LibreTranslate and Argos were dropped from this chain -
     * LibreTranslate's public instance now rejects unauthenticated
     * requests (requires a paid API key) and Argos's public instance is
     * unreachable; both were failing on every single call, doing nothing
     * but adding a wasted request per word.
     */
    public function handle(string $word): ?string
    {
        return $this->tryMyMemory($word)
            ?? $this->tryGoogleTranslate($word);
    }

    public function fetchSynonyms(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 5])
                ->get('https://api.datamuse.com/words', [
                    'rel_syn' => $word,
                    'max' => 5,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    return implode(', ', array_column($data, 'word'));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Datamuse API failed: ' . $e->getMessage());
        }

        return null;
    }

    private function tryMyMemory(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 4])
                ->get('https://api.mymemory.translated.net/get', [
                    'q' => $word,
                    'langpair' => 'en|id',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['responseData']['translatedText'])) {
                    // MyMemory sometimes returns the input if no translation found, or specific error messages.
                    // But usually it's okay for single words.
                    return $data['responseData']['translatedText'];
                }
            }
        } catch (\Exception $e) {
            Log::warning('MyMemory API failed: ' . $e->getMessage());
        }

        return null;
    }

    private function tryGoogleTranslate(string $word): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 4])
                ->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl' => 'en',
                    'tl' => 'id',
                    'dt' => 't',
                    'q' => $word,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0][0][0]) && !empty($data[0][0][0])) {
                    return $data[0][0][0];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Google Translate failed: ' . $e->getMessage());
        }

        return null;
    }

}
