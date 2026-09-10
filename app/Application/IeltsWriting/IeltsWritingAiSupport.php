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

    public function request(string $prompt, bool $jsonMode = true, int $timeout = 300, int $maxTokens = 4096, ?int $taskType = null, ?string $category = null, ?int $meetingId = null): array
    {
        $messages = [
            ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        // Resolve image attached to meeting for Task 1 vision models if available
        $imageDataUri = null;
        if ($meetingId) {
            $meeting = \App\Models\IeltsWritingMeeting::find($meetingId);
            if ($meeting && !empty($meeting->image)) {
                $possiblePaths = [
                    public_path($meeting->image),
                    public_path('storage/' . $meeting->image),
                    storage_path('app/public/' . $meeting->image),
                    storage_path('app/' . $meeting->image),
                ];
                foreach ($possiblePaths as $path) {
                    if (file_exists($path) && is_file($path)) {
                        $mime = mime_content_type($path) ?: 'image/png';
                        $base64 = base64_encode(file_get_contents($path));
                        $imageDataUri = "data:{$mime};base64,{$base64}";
                        break;
                    }
                }
            }

            // Task 1 flowchart/map items don't have a meetings.image value — their
            // diagram is a static file resolved by meeting_number via
            // IeltsTask1ChartResolver. Attach that image directly so the AI can
            // actually see the process/map being described instead of grading blind.
            if (!$imageDataUri && $meeting && class_exists(\App\Support\IeltsTask1ChartResolver::class)) {
                $chart = \App\Support\IeltsTask1ChartResolver::resolve($meeting);
                $path = $chart['localPath'] ?? null;
                // Skip SVGs: vision APIs (Groq/Gemini) expect raster images and
                // generally reject or mis-handle SVG/XML — the text description in
                // formatChartContext() already covers these cases as a fallback.
                if ($path && file_exists($path) && is_file($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'svg') {
                    $mime = mime_content_type($path) ?: 'image/png';
                    $base64 = base64_encode(file_get_contents($path));
                    $imageDataUri = "data:{$mime};base64,{$base64}";
                }
            }
        }

        $payload = [
            'messages' => $messages,
            'temperature' => 0.3,
            'max_tokens' => $maxTokens,
            'stream' => false,
        ];
        if ($jsonMode) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        // Fallback Chain: SambaNova -> Groq -> Cerebras -> DeepInfra -> Gemini.
        // Gemini (gemini-2.5-flash) is the only provider in this chain with a
        // genuinely vision-capable model — Groq's account here only has text-only
        // models (no llama-vision/scout/maverick), and SambaNova/Cerebras/DeepInfra
        // are text-only too. When an image is attached, try Gemini FIRST so Task 1
        // chart/diagram grading actually gets to use vision before falling back to
        // the text-only providers (which still benefit from the text chart context).
        $providers = $imageDataUri
            ? ['gemini', 'groq', 'sambanova', 'cerebras', 'deepinfra', 'siliconflow', 'openrouter', 'openai']
            : ['groq', 'sambanova', 'cerebras', 'deepinfra', 'siliconflow', 'openrouter', 'gemini', 'openai'];

        // Retry the whole chain if every provider fails — with only 1-2 keys per provider
        // and many more AI calls now firing per session (evaluate/feedback/correct/improve
        // plus on-demand grammar/vocabulary/task-response upgrades), transient rate-limit
        // and provider hiccups are common. Retry up to 2 extra times with backoff so a
        // failure on one pass doesn't surface as a hard error to the user.
        $maxAttempts = 3;
        $backoffSeconds = [1, 3];

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $sawFailure = false;

            foreach ($providers as $provider) {
                if ($provider === 'groq') {
                    $featureKeys = \App\Services\GroqKeyManager::getKeysForFeature('writing');
                    $providerKeys = \App\Services\AiProviderKeyManager::getKeys($provider);
                    $keys = array_values(array_unique(array_filter(array_merge($featureKeys, $providerKeys))));
                } else {
                    $keys = \App\Services\AiProviderKeyManager::getKeys($provider);
                }

                if (empty($keys)) {
                    continue;
                }

                foreach ($keys as $index => $key) {
                    $modelsToTry = match ($provider) {
                        'groq' => ['openai/gpt-oss-120b', 'qwen/qwen3.6-27b', 'llama-3.1-8b-instant'],
                        'gemini' => ['gemini-2.0-flash', 'gemini-1.5-flash'],
                        'sambanova' => ['Meta-Llama-3.3-70B-Instruct'],
                        'cerebras' => ['llama3.3-70b', 'gpt-oss-120b'],
                        'deepinfra' => ['meta-llama/Llama-3.3-70B-Instruct'],
                        'siliconflow' => ['deepseek-ai/DeepSeek-V3'],
                        'openrouter' => ['meta-llama/llama-3.3-70b-instruct:free'],
                        'openai' => ['gpt-4o-mini'],
                        default => ['default']
                    };

                    foreach ($modelsToTry as $targetModel) {
                        try {
                            $response = null;
                            $providerMessages = [
                                ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
                                ['role' => 'user', 'content' => $prompt]
                            ];
                            $providerPayload = [
                                'messages' => $providerMessages,
                                'temperature' => 0.3,
                                'max_tokens' => $maxTokens,
                                'stream' => false,
                            ];
                            if ($jsonMode) {
                                $providerPayload['response_format'] = ['type' => 'json_object'];
                            }

                            if ($provider === 'sambanova') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.sambanova.ai/v1/chat/completions", $providerPayload);
                            } elseif ($provider === 'groq') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.groq.com/openai/v1/chat/completions", $providerPayload);
                            } elseif ($provider === 'cerebras') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.cerebras.ai/v1/chat/completions", $providerPayload);
                            } elseif ($provider === 'deepinfra') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.deepinfra.com/v1/openai/chat/completions", $providerPayload);
                            } elseif ($provider === 'gemini') {
                                $providerPayload['model'] = $targetModel;
                                if ($imageDataUri) {
                                    $providerPayload['messages'][1]['content'] = [
                                        ['type' => 'text', 'text' => $prompt],
                                        ['type' => 'image_url', 'image_url' => ['url' => $imageDataUri]]
                                    ];
                                }
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://generativelanguage.googleapis.com/v1beta/openai/chat/completions", $providerPayload);
                            } elseif ($provider === 'siliconflow') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.siliconflow.com/v1/chat/completions", $providerPayload);
                            } elseif ($provider === 'openrouter') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                    'HTTP-Referer' => 'https://www.targetbahasa.com',
                                    'X-Title' => 'TargetBahasa',
                                ])->timeout($timeout)->post("https://openrouter.ai/api/v1/chat/completions", $providerPayload);
                            } elseif ($provider === 'openai') {
                                $providerPayload['model'] = $targetModel;
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $key,
                                ])->timeout($timeout)->post("https://api.openai.com/v1/chat/completions", $providerPayload);
                            }

                            if ($response && $response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                                return [
                                    'content' => $response->json()['choices'][0]['message']['content'],
                                    'source' => ucfirst($provider) . " ({$targetModel}) [key " . \App\Services\GroqKeyManager::maskKey($key) . ']'
                                ];
                            }

                            $sawFailure = true;
                            \Log::warning("Writing AI: {$provider} ({$targetModel}) key #{$index} failed.", ['status' => $response ? $response->status() : 'No response', 'attempt' => $attempt]);
                        } catch (\Exception $e) {
                            $sawFailure = true;
                            \Log::warning("Writing AI: {$provider} ({$targetModel}) key #{$index} exception.", ['error' => $e->getMessage(), 'attempt' => $attempt]);
                        }
                    }
                }
            }

            if ($attempt < $maxAttempts && $sawFailure) {
                sleep($backoffSeconds[$attempt - 1] ?? 5);
                continue;
            }

            break;
        }

        throw new \Exception('All AI services failed (SambaNova, Groq, Cerebras, DeepInfra, SiliconFlow, Gemini, and OpenAI)');
    }

    public function runJsonPrompt(
        string $prompt,
        int $timeout = 600,
        int $maxTokens = 4096,
        bool $sanitize = false,
        bool $useRobustDecoder = true,
        ?int $taskType = null,
        ?string $category = null,
        ?int $meetingId = null,
    ): ?array {
        $result = $this->request($prompt, true, $timeout, $maxTokens, $taskType, $category, $meetingId);

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