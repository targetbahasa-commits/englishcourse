<?php

namespace App\Application\PlacementTest;

use App\Application\IeltsWriting\IeltsWritingAiSupport;
use App\Services\GroqKeyManager;
use Illuminate\Support\Facades\Storage;

class ScorePlacementSpeaking
{
    public function __construct(
        private readonly IeltsWritingAiSupport $aiSupport,
        private readonly BuildPlacementSpeakingAiPrompt $promptBuilder,
    ) {
    }

    /**
     * Transcribes the recording (Whisper) and grades the transcript text against
     * a CEFR speaking rubric via LLM. No acoustic/pronunciation analysis - this is
     * a deliberate v1 simplification (approved), textual inference only.
     *
     * @return array{transcript: string, scores: ?array, cefr_estimate: string, feedback: string}
     */
    public function score(string $audioPath, string $promptText): array
    {
        $fullPath = Storage::disk('public')->path($audioPath);

        $whisperResult = GroqKeyManager::callWhisperWithFallback('speaking', $fullPath, 60);
        $transcript = trim($whisperResult['body']['text'] ?? '');

        if ($transcript === '') {
            return [
                'transcript' => '',
                'scores' => null,
                'cefr_estimate' => 'A1',
                'feedback' => 'Tidak ada suara yang terdeteksi dalam rekaman.',
            ];
        }

        $prompt = $this->promptBuilder->build($promptText, $transcript);
        $aiResult = $this->aiSupport->runJsonPrompt($prompt);

        return [
            'transcript' => $transcript,
            'scores' => $aiResult['scores'] ?? null,
            'cefr_estimate' => $aiResult['cefr_estimate'] ?? 'A1',
            'feedback' => $aiResult['feedback'] ?? '',
        ];
    }
}
