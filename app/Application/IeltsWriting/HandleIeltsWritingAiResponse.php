<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Contracts\IeltsWritingLogger;
use Illuminate\Http\JsonResponse;

class HandleIeltsWritingAiResponse
{
    public function __construct(
        private readonly IeltsWritingAiSupport $ieltsWritingAiSupport,
        private readonly IeltsWritingLogger $logger,
    ) {
    }

    public function respondWithJsonPrompt(
        string $prompt,
        int $timeout,
        int $maxTokens,
        bool $sanitize = false,
        bool $useRobustDecoder = true,
        ?string $context = null,
        string $parseFailureMessage = 'AI Response Error',
        ?int $taskType = null,
        ?string $category = null,
    ): JsonResponse {
        try {
            $json = $this->ieltsWritingAiSupport->runJsonPrompt($prompt, $timeout, $maxTokens, $sanitize, $useRobustDecoder, $taskType, $category);

            if ($json) {
                $json['status'] = 'success';
                return response()->json($json);
            }

            if ($context) {
                $this->logger->error($context . ' JSON Failure');
            }

            return response()->json(['error' => $parseFailureMessage, 'status' => 'failed'], 500);
        } catch (\Exception $e) {
            if ($context) {
                $this->logger->error($context . ' Exception', ['message' => $e->getMessage()]);
            }

            return response()->json(['error' => $e->getMessage(), 'status' => 'failed'], 500);
        }
    }

    public function requestDecodedJsonPrompt(
        string $prompt,
        int $timeout,
        int $maxTokens,
        bool $sanitize = false,
        bool $useRobustDecoder = true,
        ?int $taskType = null,
        ?string $category = null,
    ): array {
        $result = $this->ieltsWritingAiSupport->request($prompt, true, $timeout, $maxTokens, $taskType, $category);
        $content = $result['content'] ?? '';

        return [
            $this->ieltsWritingAiSupport->decodeJson($content, $sanitize, $useRobustDecoder),
            $content,
        ];
    }

    public function respondWithFeedbackPrompt(string $prompt, int $timeout, int $maxTokens, ?int $taskType = null, ?string $category = null): JsonResponse
    {
        try {
            [$json, $content] = $this->requestDecodedJsonPrompt($prompt, $timeout, $maxTokens, true, true, $taskType, $category);

            if ($json) {
                $json['status'] = 'success';
                $this->logger->info('IELTS Feedback Success', [
                    'raw' => substr($content, 0, 100),
                    'keys' => array_keys($json['feedback'] ?? []),
                ]);

                return response()->json($json);
            }

            $this->logger->error('IELTS Feedback JSON Null', ['raw' => $content]);

            return response()->json(['error' => 'AI Response Error', 'status' => 'failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 'failed'], 500);
        }
    }

    public function respondWithCorrectionPrompt(string $prompt, string $essay, int $timeout, int $maxTokens, ?int $taskType = null, ?string $category = null): JsonResponse
    {
        try {
            [$json] = $this->requestDecodedJsonPrompt($prompt, $timeout, $maxTokens, true, true, $taskType, $category);

            if ($json) {
                $json['correction_html'] = $this->normalizeCorrectionHtml($json['correction_html'] ?? '', $essay);
                $json['status'] = 'success';

                return response()->json($json);
            }

            return response()->json(['error' => 'AI Response Error', 'status' => 'failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 'failed'], 500);
        }
    }

    public function normalizeCorrectionHtml(string $html, string $essay): string
    {
        if (!$html || strlen($html) < 20 || stripos($html, 'undefined') !== false) {
            $this->logger->warning('IELTS Correction fallback triggered', ['content' => $html]);
            return '<p>' . nl2br(e($essay)) . '</p>';
        }

        $replacements = [
            '{RED}' => "<span class='grammar-error bg-red-100 text-red-600 rounded px-1 mx-0.5 cursor-pointer' title='Error'>",
            '{/RED}' => '</span>',
            '{GREEN}' => "<span class='grammar-correction text-green-600 font-bold mx-1'>",
            '{/GREEN}' => '</span>',
            '{YELLOW}' => "<span class='grammar-improvement bg-yellow-200 text-gray-800 rounded px-1 mx-0.5' title='Suggestion'>",
            '{/YELLOW}' => '</span>',
            '{/GREEN>}' => '</span>', '/GREEN>' => '</span>', '</GREEN>' => '</span>',
            '{/RED>}' => '</span>', '/RED>' => '</span>', '</RED>' => '</span>',
            '{/YELLOW>}' => '</span>', '/YELLOW>' => '</span>', '</YELLOW>' => '</span>',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $html);
    }
}