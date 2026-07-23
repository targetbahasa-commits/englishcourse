<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * AiProviderKeyManager
 *
 * Manages multiple API keys for various AI providers (SambaNova, Gemini, OpenRouter, etc.)
 */
class AiProviderKeyManager
{
    private const CACHE_TTL = 300; // 5 minutes

    /**
     * Get an ordered array of API keys for a given provider.
     * Example provider: 'sambanova', 'gemini', 'openrouter'
     */
    public static function getKeys(string $provider): array
    {
        $provider   = strtolower($provider);
        $settingKey = $provider . '_keys';
        $cacheKey   = 'ai_keys_' . $provider;

        $keys = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($settingKey) {
            $value = DB::table('settings')->where('key', $settingKey)->value('value');
            if (!$value) {
                return [];
            }
            return array_values(array_filter(array_map('trim', explode(',', $value))));
        });

        // Last resort: use .env if no keys are found in the DB pool
        if (empty($keys)) {
            $envKey = env(strtoupper($provider) . '_API_KEY');
            if ($envKey) {
                $keys = [$envKey];
            }
        }

        return $keys;
    }

    /**
     * Flush the cached keys for a given provider.
     */
    public static function flushCache(string $provider): void
    {
        Cache::forget('ai_keys_' . strtolower($provider));
    }
}
