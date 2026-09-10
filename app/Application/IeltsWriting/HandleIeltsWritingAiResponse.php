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
        ?int $meetingId = null,
    ): JsonResponse {
        try {
            $json = $this->ieltsWritingAiSupport->runJsonPrompt($prompt, $timeout, $maxTokens, $sanitize, $useRobustDecoder, $taskType, $category, $meetingId);

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
        ?int $meetingId = null,
    ): array {
        $result = $this->ieltsWritingAiSupport->request($prompt, true, $timeout, $maxTokens, $taskType, $category, $meetingId);
        $content = $result['content'] ?? '';

        return [
            $this->ieltsWritingAiSupport->decodeJson($content, $sanitize, $useRobustDecoder),
            $content,
        ];
    }

    public function respondWithFeedbackPrompt(string $prompt, int $timeout, int $maxTokens, ?int $taskType = null, ?string $category = null, ?int $meetingId = null): JsonResponse
    {
        try {
            [$json, $content] = $this->requestDecodedJsonPrompt($prompt, $timeout, $maxTokens, true, true, $taskType, $category, $meetingId);

            if ($json && isset($json['feedback'])) {
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
            $this->logger->error('IELTS Feedback Exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage(), 'status' => 'failed'], 500);
        }
    }

    public function respondWithGradingPrompt(string $prompt, string $essay, string $taskType, int $timeout, int $maxTokens, ?string $category = null, ?int $meetingId = null): JsonResponse
    {
        try {
            [$json] = $this->requestDecodedJsonPrompt($prompt, $timeout, $maxTokens, true, true, (int) $taskType, $category, $meetingId);

            if ($json && isset($json['scores'])) {
                $json['scores'] = $this->enforceWordCountPenalty($json['scores'] ?? [], $essay, $taskType);
                $json['status'] = 'success';

                return response()->json($json);
            }

            return response()->json(['error' => 'AI Response Error', 'status' => 'failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 'failed'], 500);
        }
    }

    /**
     * Official IELTS policy: an under-length response cannot score above Band 5 for
     * Task Achievement/Response, regardless of writing quality — the AI is instructed
     * to apply this in the prompt, but this is a deterministic backstop in case it doesn't.
     */
    public function enforceWordCountPenalty(array $scores, string $essay, string $taskType): array
    {
        $wordCount = str_word_count(strip_tags($essay));
        $minWords = $taskType === '1' ? 150 : 250;

        if ($wordCount >= $minWords || !isset($scores['task_achievement'])) {
            return $scores;
        }

        $scores['task_achievement'] = min((float) $scores['task_achievement'], 5.0);

        $subScores = [
            $scores['task_achievement'] ?? null,
            $scores['coherence_cohesion'] ?? null,
            $scores['lexical_resource'] ?? null,
            $scores['grammatical_range'] ?? null,
        ];

        if (!in_array(null, $subScores, true)) {
            $scores['overall_band'] = $this->roundIeltsBand(array_sum($subScores) / 4);
        }

        return $scores;
    }

    /**
     * Official IELTS rounding: average ending in .25 rounds up to the next half band;
     * .75 rounds up to the next whole band. Equivalent to rounding to the nearest 0.5,
     * with exact .25/.75 midpoints rounding up.
     */
    private function roundIeltsBand(float $average): float
    {
        return round($average * 2) / 2;
    }

    public function respondWithCorrectionPrompt(string $prompt, string $essay, int $timeout, int $maxTokens, ?int $taskType = null, ?string $category = null, ?int $meetingId = null): JsonResponse
    {
        try {
            [$json] = $this->requestDecodedJsonPrompt($prompt, $timeout, $maxTokens, true, true, $taskType, $category, $meetingId);

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