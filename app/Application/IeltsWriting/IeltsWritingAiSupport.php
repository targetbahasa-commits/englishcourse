<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Contracts\IeltsWritingAiHttpClient;
use App\Services\GroqKeyManager;
use App\Services\LlmServerManager;
use Illuminate\Support\Facades\Http;

class IeltsWritingAiSupport
{
    public function __construct(
        private readonly IeltsWritingAiHttpClient $httpClient,
    ) {
    }

    public function request(string $prompt, bool $jsonMode = true, int $timeout = 300, int $maxTokens = 4096, ?int $taskType = null, ?string $category = null): array
    {
        $messages = [
            ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $payload = [
            'messages' => $messages,
            'temperature' => 0.3,
            'max_tokens' => $maxTokens,
            'stream' => false,
        ];
        if ($jsonMode) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        // Fallback Chain: SambaNova -> Gemini -> OpenRouter
        $providers = ['sambanova', 'gemini', 'openrouter'];

        foreach ($providers as $provider) {
            $keys = \App\Services\AiProviderKeyManager::getKeys($provider);
            if (empty($keys)) {
                continue;
            }

            foreach ($keys as $index => $key) {
                try {
                    $response = null;
                    if ($provider === 'sambanova') {
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                        ])->timeout($timeout)->post("https://api.sambanova.ai/v1/chat/completions", $payload);
                    } elseif ($provider === 'gemini') {
                        $geminiPayload = $payload;
                        $geminiPayload['model'] = 'gemini-2.5-flash';
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                        ])->timeout($timeout)->post("https://generativelanguage.googleapis.com/v1beta/openai/chat/completions", $geminiPayload);
                    } elseif ($provider === 'openrouter') {
                        $orPayload = $payload;
                        $orPayload['model'] = 'meta-llama/llama-3.3-70b-instruct:free';
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                            'HTTP-Referer' => 'https://targetbahasa.com',
                            'X-Title' => 'Target Bahasa Course'
                        ])->timeout($timeout)->post("https://openrouter.ai/api/v1/chat/completions", $orPayload);
                    }

                    if ($response && $response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                        return [
                            'content' => $response->json()['choices'][0]['message']['content'],
                            'source' => ucfirst($provider) . ' [key ' . \App\Services\GroqKeyManager::maskKey($key) . ']'
                        ];
                    }
                    \Log::warning("Writing AI: {$provider} key #{$index} failed.", ['status' => $response ? $response->status() : 'No response']);
                } catch (\Exception $e) {
                    \Log::warning("Writing AI: {$provider} key #{$index} exception.", ['error' => $e->getMessage()]);
                }
            }
        }

        throw new \Exception('All AI services failed (SambaNova, Gemini, and OpenRouter)');
    }

    public function runJsonPrompt(
        string $prompt,
        int $timeout = 600,
        int $maxTokens = 4096,
        bool $sanitize = false,
        bool $useRobustDecoder = true,
        ?int $taskType = null,
        ?string $category = null,
    ): ?array {
        $result = $this->request($prompt, true, $timeout, $maxTokens, $taskType, $category);

        return $this->decodeJson($result['content'] ?? '', $sanitize, $useRobustDecoder);
    }

    public function decodeJson(string $content, bool $sanitize = false, bool $useRobustDecoder = true): ?array
    {
        $cleanJson = $this->extractJson($content);
        $json = $useRobustDecoder
            ? $this->robustJsonDecode($cleanJson)
            : json_decode($cleanJson, true, 512, JSON_INVALID_UTF8_IGNORE);

        if (!$json && $cleanJson) {
            $cleanJson = $this->cleanJsonString($cleanJson);
            $json = $useRobustDecoder
                ? $this->robustJsonDecode($cleanJson)
                : json_decode($cleanJson, true, 512, JSON_INVALID_UTF8_IGNORE);
        }

        if (!$json) {
            return null;
        }

        return $sanitize ? $this->sanitizeData($json) : $json;
    }

    public function sanitizeData($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeData($value);
            }

            return $data;
        }

        if (is_string($data)) {
            if (trim($data) === 'undefined') {
                return '';
            }

            if (stripos($data, 'undefined') !== false) {
                return str_ireplace('undefined', '', $data);
            }
        }

        return $data;
    }

    public function extractJson(string $content): string
    {
        if (preg_match('/```json\s*(.*?)\s*```/s', $content, $matches)) {
            return $this->cleanJsonString($matches[1]);
        }

        if (preg_match('/```\s*(.*?)\s*```/s', $content, $matches)) {
            return $this->cleanJsonString($matches[1]);
        }

        $start = strpos($content, '{');
        $end = strrpos($content, '}');

        if ($start !== false && $end !== false && $end > $start) {
            $jsonStr = substr($content, $start, $end - $start + 1);
            return $this->cleanJsonString($jsonStr);
        }

        return $this->cleanJsonString($content);
    }

    public function cleanJsonString(string $json): string
    {
        $json = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $json) ?? $json;

        $json = preg_replace_callback(
            '/"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"/s',
            static function ($matches) {
                return str_replace(["\r\n", "\n", "\r", "\t"], ['\\n', '\\n', '\\r', '\\t'], $matches[0]);
            },
            $json,
        ) ?? $json;

        return preg_replace('/,\s*([\}\]])/', '$1', $json) ?? $json;
    }

    public function robustJsonDecode(string $jsonStr): ?array
    {
        $json = json_decode($jsonStr, true, 512, JSON_INVALID_UTF8_IGNORE);

        return is_array($json) ? $json : null;
    }
}