<?php

namespace App\Application\GrammarWriting;

use App\Services\MultiProviderAiClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateGrammarVariationService
{
    /**
     * Generate dynamic AI variations for any meeting and track
     */
    public function generateGenericVariation(string $track, int $meetingNumber): array
    {
        $providers = ['groq', 'sambanova', 'siliconflow', 'cerebras', 'deepinfra', 'gemini', 'openrouter', 'openai'];

        // Retrieve existing questions from database
        $questions = DB::table('grammar_questions')
            ->where('meeting_number', $meetingNumber)
            ->get();

        if ($questions->isEmpty()) {
            // Fallback: try meeting 4 structure if available
            return [
                'sentences' => [],
                'matrixIntro' => [],
                'matrix' => [],
                'is_ai_generated' => false,
            ];
        }

        $itemsSummary = [];
        foreach ($questions as $q) {
            $itemsSummary[] = [
                'id' => $q->id,
                'section' => $q->section ?? 'sentences',
                'question_number' => $q->question_number,
                'tense' => $q->tense ?? 'Grammar Practice',
                'structure' => $q->structure ?? 'Verbal',
                'id_text' => $q->question_text,
                'en_answer' => $q->correct_answer,
            ];
        }

        $systemPrompt = "You are an expert English grammar teacher and curriculum designer for Indonesian learners.\n"
            . "Generate FRESH, contextual variations of translation sentences based on the provided curriculum items.\n"
            . "CRITICAL RULES:\n"
            . "1. TENSE, ASPECT, AND GRAMMAR STRUCTURE MUST MATCH 100% (e.g. if original is Simple Present Passive, the new one must also be Simple Present Passive).\n"
            . "2. Sentence polarity (affirmative, negative, interrogative) must match the original sentence exactly.\n"
            . "3. CHANGE vocabulary, subject, verbs, and context to engaging, academic, modern life, or scientific topics.\n"
            . "4. Output ONLY valid JSON matching the requested schema without surrounding markdown.";

        $userPrompt = "Generate variations for meeting {$meetingNumber} ({$track}):\n\n"
            . json_encode($itemsSummary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            . "\n\nRespond with JSON array of objects:\n"
            . "[\n"
            . '  {"id": <original_id>, "question_text": "Kalimat Indonesia baru...", "correct_answer": "New English translation...", "vocab": {"Word": {"id": "Arti", "pos": "(v)"}}}\n'
            . "]";

        try {
            $response = MultiProviderAiClient::chat($providers, $systemPrompt, $userPrompt, [
                'json_mode' => true,
                'max_tokens' => 4096,
                'temperature' => 0.7,
            ]);

            if ($response && !empty($response['content'])) {
                $raw = trim($response['content']);
                if (str_starts_with($raw, '```')) {
                    $raw = preg_replace('/^```(?:json)?\s*/i', '', $raw);
                    $raw = preg_replace('/\s*```$/', '', $raw);
                }

                $data = json_decode($raw, true);
                if (is_array($data)) {
                    $keyed = [];
                    foreach ($data as $item) {
                        if (isset($item['id'])) {
                            $keyed[$item['id']] = $item;
                        }
                    }

                    return [
                        'questions' => $keyed,
                        'is_ai_generated' => true,
                        'generated_at' => now()->toIso8601String(),
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::error('GenerateGrammarVariationService generic error: ' . $e->getMessage());
        }

        return [
            'questions' => [],
            'is_ai_generated' => false,
        ];
    }
}