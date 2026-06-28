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

        // Routing Logic: SambaNova FIRST for everything
        $sambaModel = 'Meta-Llama-3.3-70B-Instruct';
        if ($taskType === 1 && $category === 'task_achievement') {
            $sambaModel = 'DeepSeek-V3.1'; // Using latest available
        }
        $payload['model'] = $sambaModel;
        
        $sambaKeys = \App\Services\AiProviderKeyManager::getKeys('sambanova');
        $sambaSuccess = false;
        
        foreach ($sambaKeys as $sambaIndex => $sambaKey) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $sambaKey,
                ])->timeout($timeout)->post("https://api.sambanova.ai/v1/chat/completions", $payload);

                if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                    return [
                        'content' => $response->json()['choices'][0]['message']['content'],
                        'source' => 'SambaNova (' . $sambaModel . ') [key ' . \App\Services\GroqKeyManager::maskKey($sambaKey) . ']'
                    ];
                }
                \Log::warning("SambaNova key #{$sambaIndex} failed, attempting next...", ['status' => $response->status()]);
            } catch (\Exception $e) {
                \Log::warning("SambaNova key #{$sambaIndex} exception, attempting next...", ['error' => $e->getMessage()]);
            }
        }
        \Log::warning("All SambaNova keys failed, attempting fallback...");

        try {
            // TRY GROQ SECOND (with sequential fallback across all writing keys)
            $payload['model'] = 'llama-3.3-70b-versatile';
            $result = GroqKeyManager::callWithFallback('writing', $payload, $timeout);
            return [
                'content' => $result['body']['choices'][0]['message']['content'],
                'source'  => 'Groq (Llama 3.3) [key ' . $result['key_used'] . ']',
            ];
        } catch (\Exception $e) {
            \Log::warning("Groq (all writing keys) failed, attempting Gemini API...", ['error' => $e->getMessage()]);
        }

        // FALLBACK TO GEMINI
        $payload['model'] = 'gemini-2.5-flash';
        $geminiKeys = \App\Services\AiProviderKeyManager::getKeys('gemini');
        
        foreach ($geminiKeys as $geminiIndex => $geminiKey) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $geminiKey,
                ])->timeout($timeout)->post("https://generativelanguage.googleapis.com/v1beta/openai/chat/completions", $payload);

                if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                    return [
                        'content' => $response->json()['choices'][0]['message']['content'],
                        'source' => 'Gemini API [key ' . \App\Services\GroqKeyManager::maskKey($geminiKey) . ']'
                    ];
                }
                \Log::error("Gemini fallback key #{$geminiIndex} failed", ['status' => $response->status()]);
            } catch (\Exception $e) {
                \Log::error("Gemini exception during fallback key #{$geminiIndex}: " . $e->getMessage());
            }
        }

        throw new \Exception('All AI services failed (Groq and Gemini)');
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