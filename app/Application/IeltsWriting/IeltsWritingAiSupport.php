<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Contracts\IeltsWritingAiHttpClient;

class IeltsWritingAiSupport
{
    public function __construct(
        private readonly IeltsWritingAiHttpClient $httpClient,
    ) {
    }

    public function request(string $prompt, bool $jsonMode = true, int $timeout = 300, int $maxTokens = 4096): array
    {
        $ports = [1234, 11434];

        foreach ($ports as $port) {
            try {
                $url = "http://127.0.0.1:{$port}/v1/chat/completions";
                $modelName = $port === 1234 ? 'local-model' : 'llama3';

                $payload = [
                    'model' => $modelName,
                    'messages' => [
                        ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.3,
                    'stream' => false,
                ];

                $data = $this->httpClient->postJson($url, $payload, $timeout);

                if (!is_array($data)) {
                    continue;
                }

                if (!isset($data['choices'][0]['message']['content'])) {
                    continue;
                }

                return [
                    'content' => $data['choices'][0]['message']['content'],
                    'source' => $port === 1234 ? 'LM Studio' : 'Ollama',
                ];
            } catch (\Exception) {
                continue;
            }
        }

        throw new \Exception('No Local AI reachable on ports 1234 or 11434');
    }

    public function runJsonPrompt(
        string $prompt,
        int $timeout = 600,
        int $maxTokens = 4096,
        bool $sanitize = false,
        bool $useRobustDecoder = true,
    ): ?array {
        $result = $this->request($prompt, true, $timeout, $maxTokens);

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
            '/"(?:[^"\\]|\\.)*"/s',
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