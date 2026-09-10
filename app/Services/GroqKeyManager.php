<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * GroqKeyManager
 *
 * Manages multiple Groq API keys per feature with sequential fallback.
 *
 * Strategy:
 * 1. Load keys for the requested feature from DB settings (cached).
 * 2. If no dedicated keys found, fall back to 'general' keys.
 * 3. Try keys sequentially (key[0] first, then key[1], etc.).
 * 4. On HTTP 429 (rate limit), move to the next key automatically.
 * 5. On all keys exhausted, throw an exception.
 */
class GroqKeyManager
{
    /**
     * Valid feature identifiers mapped to DB setting keys.
     */
    public const FEATURES = [
        'general'   => 'groq_keys_general',
        'writing'   => 'groq_keys_writing',
        'speaking'  => 'groq_keys_speaking',
        'listening' => 'groq_keys_listening',
    ];

    /**
     * Cache TTL in seconds (5 minutes).
     */
    private const CACHE_TTL = 300;

    /**
     * Get an ordered array of API keys for a given feature.
     * Falls back to general keys if dedicated keys are not configured.
     */
    public static function getKeysForFeature(string $feature): array
    {
        $settingKey = self::FEATURES[$feature] ?? self::FEATURES['general'];
        $cacheKey   = 'groq_keys_' . $feature;

        $keys = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($settingKey) {
            $value = DB::table('settings')->where('key', $settingKey)->value('value');
            return self::parseKeys($value);
        });

        // If no dedicated keys, fall back to general
        if (empty($keys) && $feature !== 'general') {
            $keys = Cache::remember('groq_keys_general', self::CACHE_TTL, function () {
                $value = DB::table('settings')->where('key', self::FEATURES['general'])->value('value');
                return self::parseKeys($value);
            });
        }

        // Also merge in the generic 'groq_keys' pool (AiProviderKeyManager's
        // provider-level pool, used by non-feature-scoped callers). Feature
        // pools were introduced later and several Groq accounts had only ever
        // been added to the generic pool, so without this merge those keys
        // were invisible to feature-scoped callers (e.g. PTE's Whisper
        // transcription), silently running on a single key.
        $genericKeys = Cache::remember('groq_keys_provider_generic', self::CACHE_TTL, function () {
            $value = DB::table('settings')->where('key', 'groq_keys')->value('value');
            return self::parseKeys($value);
        });
        $keys = array_values(array_unique(array_merge($keys, $genericKeys)));

        // Last resort: use .env GROQ_API_KEY
        if (empty($keys)) {
            $envKey = env('GROQ_API_KEY');
            if ($envKey) {
                $keys = [$envKey];
            }
        }

        // Randomize order per call so concurrent requests spread across the
        // whole pool instead of all piling onto key #0 first (see the same
        // note in AiProviderKeyManager::getKeys()).
        if (count($keys) > 1) {
            shuffle($keys);
        }

        return $keys;
    }

    /**
     * Execute a Groq API call with sequential fallback across all keys for a feature.
     *
     * @param  string   $feature   One of: 'general', 'writing', 'speaking', 'listening'
     * @param  array    $payload   The full JSON payload (model, messages, etc.)
     * @param  int      $timeout   HTTP timeout in seconds
     * @return array   ['body' => array, 'key_index' => int, 'key_used' => string]
     * @throws \RuntimeException   If all keys fail
     */
    public static function callWithFallback(string $feature, array $payload, int $timeout = 60): array
    {
        $keys = self::getKeysForFeature($feature);

        if (empty($keys)) {
            throw new \RuntimeException("No Groq API keys configured for feature [{$feature}] or general pool.");
        }

        // Auto-replace decommissioned models
        $requestedModel = $payload['model'] ?? 'openai/gpt-oss-120b';
        if ($requestedModel === 'llama-3.3-70b-versatile' || $requestedModel === 'mixtral-8x7b-32768') {
            $requestedModel = 'openai/gpt-oss-120b';
        }

        $modelsToTry = array_unique([$requestedModel, 'openai/gpt-oss-120b', 'qwen/qwen3.6-27b', 'llama-3.1-8b-instant']);

        $lastError = null;

        foreach ($keys as $index => $key) {
            foreach ($modelsToTry as $targetModel) {
                try {
                    $currPayload = $payload;
                    $currPayload['model'] = $targetModel;

                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $key,
                        'Content-Type'  => 'application/json',
                    ])->timeout($timeout)->post('https://api.groq.com/openai/v1/chat/completions', $currPayload);

                    $statusCode = $response->status();

                    // On rate limit, log and try next key
                    if ($statusCode === 429) {
                        Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] hit rate limit (429). Trying next key.");
                        $lastError = "Key #{$index} rate limited (429)";
                        break; // break model loop to try next key
                    }

                    // On model error (400 / 404), try next model on this key
                    if ($statusCode === 400 || $statusCode === 404) {
                        Log::warning("GroqKeyManager: Model {$targetModel} returned HTTP {$statusCode}. Trying fallback model.");
                        $lastError = "Model {$targetModel} returned HTTP {$statusCode}";
                        continue;
                    }

                    // On other non-success, log and try next key
                    if (!$response->successful()) {
                        Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] returned HTTP {$statusCode}. Trying next key.");
                        $lastError = "Key #{$index} returned HTTP {$statusCode}";
                        break;
                    }

                    $body = $response->json();
                    if (!isset($body['choices'][0]['message']['content'])) {
                        Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] returned invalid structure. Trying next model/key.");
                        $lastError = "Key #{$index} returned invalid response structure";
                        continue;
                    }

                    // Success
                    Log::info("GroqKeyManager: [{$feature}] succeeded with key #{$index} using model [{$targetModel}].");
                    return [
                        'body'      => $body,
                        'key_index' => $index,
                        'key_used'  => self::maskKey($key),
                        'model'     => $targetModel,
                    ];

                } catch (\Exception $e) {
                    Log::warning("GroqKeyManager: Key #{$index} with model {$targetModel} for [{$feature}] threw exception: " . $e->getMessage());
                    $lastError = $e->getMessage();
                    continue;
                }
            }
        }

        $keyCount = count($keys);
        throw new \RuntimeException(
            "GroqKeyManager: All {$keyCount} key(s) for [{$feature}] failed. Last error: {$lastError}",
            503
        );
    }

    /**
     * Execute a Groq Whisper API call (Audio Transcription) with fallback.
     */
    public static function callWhisperWithFallback(string $feature, string $audioPath, int $timeout = 60, array $extraOptions = []): array
    {
        $keys = self::getKeysForFeature($feature);

        if (empty($keys)) {
            throw new \RuntimeException("No Groq API keys configured for feature [{$feature}] or general pool.");
        }

        $lastError = null;

        $postData = array_merge([
            'model' => 'whisper-large-v3-turbo',
            'response_format' => 'json'
        ], $extraOptions);

        foreach ($keys as $index => $key) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $key,
                ])->timeout($timeout)
                ->attach('file', fopen($audioPath, 'r'), basename($audioPath))
                ->post('https://api.groq.com/openai/v1/audio/transcriptions', $postData);

                $statusCode = $response->status();

                if ($statusCode === 429) {
                    Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] hit rate limit (429). Trying next key.");
                    $lastError = "Key #{$index} rate limited (429)";
                    continue;
                }

                if (!$response->successful()) {
                    Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] returned HTTP {$statusCode}. Trying next key.");
                    $lastError = "Key #{$index} returned HTTP {$statusCode}";
                    continue;
                }

                $body = $response->json();
                if (!isset($body['text'])) {
                    Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] returned invalid structure. Trying next key.");
                    $lastError = "Key #{$index} returned invalid response structure";
                    continue;
                }

                Log::info("GroqKeyManager: [{$feature}] Whisper succeeded with key #{$index}.");
                return [
                    'body'      => $body,
                    'key_index' => $index,
                    'key_used'  => self::maskKey($key),
                ];

            } catch (\Exception $e) {
                Log::warning("GroqKeyManager: Key #{$index} for [{$feature}] threw exception: " . $e->getMessage());
                $lastError = $e->getMessage();
                continue;
            }
        }

        $keyCount = count($keys);
        throw new \RuntimeException(
            "GroqKeyManager (Whisper): All {$keyCount} key(s) for [{$feature}] failed. Last error: {$lastError}",
            503
        );
    }

    /**
     * Flush all cached key pools (call this after saving new keys in admin).
     */
    public static function flushCache(): void
    {
        foreach (array_keys(self::FEATURES) as $feature) {
            Cache::forget('groq_keys_' . $feature);
        }
    }

    /**
     * Parse a comma-separated keys string into a clean array.
     */
    private static function parseKeys(?string $value): array
    {
        if (!$value) return [];
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * Mask an API key for safe display in logs.
     */
    public static function maskKey(string $key): string
    {
        if (strlen($key) <= 12) return str_repeat('•', strlen($key));
        return substr($key, 0, 8) . str_repeat('•', 10) . substr($key, -4);
    }
}
