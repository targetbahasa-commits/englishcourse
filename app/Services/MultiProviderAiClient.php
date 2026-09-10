<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * MultiProviderAiClient
 *
 * Shared text-LLM caller used across every AI grading feature (IELTS Writing,
 * IELTS Speaking, PTE, Grammar Practice). Tries an ordered list of providers,
 * each with all its pooled keys (already randomized per-call by
 * AiProviderKeyManager/GroqKeyManager so concurrent requests spread across
 * the pool instead of piling onto one key), and returns the first successful
 * response. All providers here are called via an OpenAI-compatible
 * chat-completions shape, so adding a new provider is just adding one entry
 * to PROVIDER_ENDPOINTS/PROVIDER_MODELS below.
 */
class MultiProviderAiClient
{
    /**
     * Every provider here exposes an OpenAI-compatible /chat/completions endpoint.
     */
    private const PROVIDER_ENDPOINTS = [
        'groq'        => 'https://api.groq.com/openai/v1/chat/completions',
        'sambanova'   => 'https://api.sambanova.ai/v1/chat/completions',
        'cerebras'    => 'https://api.cerebras.ai/v1/chat/completions',
        'deepinfra'   => 'https://api.deepinfra.com/v1/openai/chat/completions',
        'gemini'      => 'https://generativelanguage.googleapis.com/v1beta/openai/chat/completions',
        'openrouter'  => 'https://openrouter.ai/api/v1/chat/completions',
        'siliconflow' => 'https://api.siliconflow.com/v1/chat/completions',
        'openai'      => 'https://api.openai.com/v1/chat/completions',
    ];

    /**
     * Models to try in order for each provider (first that returns a valid
     * response wins). Kept as a list per provider since some (Cerebras) have
     * had specific models disappear/rename on this account before.
     *
     * groq/gemini/openrouter/cerebras updated 2026-08 after the old model
     * names started 404ing (model_not_found) on all of them - each
     * replacement below was confirmed live via a direct provider API call.
     * sambanova/openai model names are still valid as-is (those two are
     * blocked by account-level rate-limit/quota, not a bad model name).
     * deepinfra/siliconflow are blocked by account balance (402) before the
     * model name is even checked, so their staleness is unverifiable from
     * here - left unchanged.
     */
    private const PROVIDER_MODELS = [
        'groq'        => ['openai/gpt-oss-120b'],
        'sambanova'   => ['Meta-Llama-3.3-70B-Instruct'],
        'cerebras'    => ['gpt-oss-120b'],
        'deepinfra'   => ['meta-llama/Llama-3.3-70B-Instruct'],
        'gemini'      => ['gemini-3.6-flash'],
        'openrouter'  => ['google/gemini-3.6-flash'],
        'siliconflow' => ['deepseek-ai/DeepSeek-V3'],
        'openai'      => ['gpt-4o-mini'],
    ];

    /**
     * Try each provider in order (with all its keys and model variants) and
     * return the first successful decoded-JSON response, or null if every
     * provider/key/model combination failed.
     *
     * @param  string[]  $providers      Ordered provider names, e.g. ['sambanova', 'groq', 'gemini']
     * @param  string    $systemPrompt   System message content
     * @param  string    $userContent    User message content
     * @param  array     $options        'groq_feature' (default 'general'), 'max_tokens' (default 4096),
     *                                   'timeout' (default 60), 'temperature' (default 0.3)
     * @return array{content: string, source: string}|null
     */
    public static function chat(array $providers, string $systemPrompt, string $userContent, array $options = []): ?array
    {
        $groqFeature = $options['groq_feature'] ?? 'general';
        $maxTokens   = $options['max_tokens'] ?? 4096;
        $timeout     = $options['timeout'] ?? 60;
        $temperature = $options['temperature'] ?? 0.3;
        $jsonMode    = $options['json_mode'] ?? true;

        foreach ($providers as $provider) {
            $endpoint = self::PROVIDER_ENDPOINTS[$provider] ?? null;
            $models   = self::PROVIDER_MODELS[$provider] ?? null;
            if (!$endpoint || !$models) {
                Log::warning("MultiProviderAiClient: unknown provider [{$provider}] skipped.");
                continue;
            }

            $keys = $provider === 'groq'
                ? self::mergedGroqKeys($groqFeature)
                : AiProviderKeyManager::getKeys($provider);

            if (empty($keys)) {
                continue;
            }

            foreach ($keys as $keyIndex => $key) {
                foreach ($models as $model) {
                    try {
                        $payload = [
                            'model' => $model,
                            'messages' => [
                                ['role' => 'system', 'content' => $systemPrompt],
                                ['role' => 'user', 'content' => $userContent],
                            ],
                            'temperature' => $temperature,
                            'max_tokens' => $maxTokens,
                        ];
                        if ($jsonMode) {
                            $payload['response_format'] = ['type' => 'json_object'];
                        }

                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                            'Content-Type' => 'application/json',
                        ])->timeout($timeout)->post($endpoint, $payload);

                        $content = $response->json('choices.0.message.content');
                        if ($response->successful() && $content) {
                            Log::info("MultiProviderAiClient: succeeded via {$provider} ({$model}).");
                            return [
                                'content' => $content,
                                'source' => ucfirst($provider) . " ({$model}) [key " . GroqKeyManager::maskKey($key) . ']',
                            ];
                        }

                        Log::warning("MultiProviderAiClient: {$provider} ({$model}) key #{$keyIndex} failed.", [
                            'status' => $response->status(),
                        ]);
                    } catch (\Throwable $e) {
                        Log::warning("MultiProviderAiClient: {$provider} ({$model}) key #{$keyIndex} threw exception: " . $e->getMessage());
                    }
                }
            }
        }

        return null;
    }

    /**
     * Convenience wrapper: same as chat(), but decodes the response content
     * as JSON and returns the decoded array (or null on total failure /
     * invalid JSON).
     */
    public static function chatJson(array $providers, string $systemPrompt, string $userContent, array $options = []): ?array
    {
        $result = self::chat($providers, $systemPrompt, $userContent, $options + ['json_mode' => true]);
        if (!$result) {
            return null;
        }

        $decoded = json_decode($result['content'], true);
        if (!is_array($decoded) || empty($decoded)) {
            // Some providers occasionally wrap JSON in markdown fences despite
            // response_format being set - strip and retry once before giving up.
            $stripped = preg_replace('/^```(?:json)?\s*|\s*```$/s', '', trim($result['content']));
            $decoded = json_decode($stripped, true);
        }

        return is_array($decoded) && !empty($decoded) ? $decoded : null;
    }

    /**
     * Groq keys merge the feature-scoped pool (e.g. 'writing', 'speaking')
     * with the generic provider pool, deduplicated - mirroring the pattern
     * already established in IeltsWritingAiSupport.
     */
    private static function mergedGroqKeys(string $feature): array
    {
        $featureKeys  = GroqKeyManager::getKeysForFeature($feature);
        $providerKeys = AiProviderKeyManager::getKeys('groq');
        return array_values(array_unique(array_filter(array_merge($featureKeys, $providerKeys))));
    }
}
