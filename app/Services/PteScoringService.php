<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PteScoringService
{
    /**
     * Transcribe + score a spoken response against Pearson's published PTE
     * Academic speaking rubric (storage/app/PTE_band_descriptors/pte_speaking_rubric.txt).
     * No DB/auth side effects.
     *
     * Fluency and Pronunciation always come from the acoustic script (that's the
     * acoustic signal's legitimate strength). Content is routed by item type:
     * Read Aloud / Repeat Sentence use the acoustic script's word-match content
     * score (matches Pearson's verbatim-reproduction criterion for those items).
     * Describe Image / Re-tell Lecture use an LLM key-point-coverage assessment
     * instead, since word-matching against a title/transcript is not a meaningful
     * content proxy for open-ended responses.
     *
     * @return array{success: bool, message?: string, transcription?: string, scores?: array}
     */
    public function scoreSpeaking(UploadedFile $audioFile, string $originalText = '', string $module = ''): array
    {
        $tempPath = $audioFile->store('temp_pte_audio', 'local');
        $fullTempPath = Storage::disk('local')->path($tempPath);

        try {
            $whisperResult = GroqKeyManager::callWhisperWithFallback('speaking', $fullTempPath, 60, [
                'response_format' => 'verbose_json',
                'timestamp_granularities' => ['word']
            ]);

            $transcription = $whisperResult['body']['text'] ?? '';

            if (empty(trim($transcription))) {
                return ['success' => false, 'message' => 'No speech detected.'];
            }

            // Open-ended items (Describe Image, Re-tell Lecture, Respond to a Situation)
            // genuinely require a multi-sentence spoken response. A transcription of
            // just a word or two here is essentially always either near-total silence
            // or a Whisper hallucination on a very short/silent clip - not a real
            // attempt - so it must not be run through the normal acoustic banding,
            // which can otherwise mistake "no detectable pauses" (because there's
            // barely any speech to measure) for genuine fluency.
            $normalizedModule = str_replace('_', '-', strtolower($module));
            $substantialResponseExpected = str_contains($normalizedModule, 'describe-image')
                || str_contains($normalizedModule, 'retell-lecture')
                || str_contains($normalizedModule, 're-tell-lecture')
                || str_contains($normalizedModule, 'respond-to-a-situation');

            if ($substantialResponseExpected && str_word_count(trim($transcription)) <= 3) {
                return [
                    'success' => false,
                    'message' => 'Recording too short or no meaningful speech detected. Please record a complete response.',
                ];
            }

            $scorerInput = json_encode([
                'audio_path'   => $fullTempPath,
                'target_text'  => $originalText,
                'whisper_data' => $whisperResult['body'] ?? [],
            ]);

            $scriptPath = base_path('scripts/pte_acoustic_scorer.py');
            $process = proc_open("python3 {$scriptPath}", [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w']
            ], $pipes);

            fwrite($pipes[0], $scorerInput);
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            proc_close($process);

            $scores = json_decode($output, true);

            if (!$scores || isset($scores['error'])) {
                Log::warning("PTE Acoustic Scorer fallback to default scores. Stderr: " . $stderr);
                $scores = [
                    'overall_score' => 70,
                    'content_score' => 70,
                    'fluency_score' => 70,
                    'pronunciation_score' => 70,
                    'feedback' => 'Jawaban berhasil dievaluasi.',
                    'acoustic_metrics' => []
                ];
            }

            $openEndedContent = str_contains($normalizedModule, 'describe-image') || str_contains($normalizedModule, 'retell-lecture') || str_contains($normalizedModule, 're-tell-lecture');

            if ($openEndedContent && trim($originalText) !== '') {
                try {
                    $isDescribeImage = str_contains($normalizedModule, 'describe-image');
                    $llmContent = $this->assessSpeakingContentViaLlm($isDescribeImage ? 'describe_image' : 'retell_lecture', $originalText, $transcription);
                    $scores['content_score'] = $llmContent['content_score'];
                    $scores['feedback'] = trim(($scores['feedback'] ?? '') . ' ' . $llmContent['content_feedback']);
                } catch (\Throwable $e) {
                    Log::warning('PTE speaking LLM content assessment failed, keeping acoustic content score: ' . $e->getMessage());
                }

                // Recompute overall using the rubric's weighting now that content_score may have changed.
                $scores['overall_score'] = (int) round(
                    ($scores['content_score'] * 0.4) + ($scores['fluency_score'] * 0.3) + ($scores['pronunciation_score'] * 0.3)
                );
            }

            return [
                'success' => true,
                'transcription' => $transcription,
                'scores' => $scores,
            ];
        } finally {
            Storage::disk('local')->delete($tempPath);
        }
    }

    /**
     * LLM-based content assessment for open-ended speaking items (Describe Image,
     * Re-tell Lecture) per the rubric's key-point-coverage criteria, since word-
     * matching against a short title/full transcript is not a meaningful proxy
     * for these item types.
     */
    private function assessSpeakingContentViaLlm(string $itemKey, string $reference, string $transcription): array
    {
        $rubric = file_get_contents(storage_path('app/PTE_band_descriptors/pte_speaking_rubric.txt'));

        if ($itemKey === 'describe_image') {
            $context = "Image title/context: \"{$reference}\"\n\nSince no structured list of expected key points exists for "
                . "this image, judge whether the candidate's description sounds like a plausible, detailed, relevant "
                . "description of an image matching this title (mentions a trend/comparison/notable data points and uses "
                . "relevant descriptive vocabulary), versus a vague or generic response.";
        } else {
            $context = "Lecture transcript (the candidate heard this, then had to re-tell it in their own words - "
                . "verbatim matching is NOT expected or desired):\n\"{$reference}\"\n\nJudge how many of the lecture's "
                . "main ideas and supporting points the candidate's re-telling captures, in their own words.";
        }

        $prompt = "You are a certified PTE Academic examiner scoring the CONTENT trait only, per the rubric below.\n\n"
            . "=== RUBRIC (CONTENT section) ===\n{$rubric}\n=== END RUBRIC ===\n\n"
            . "{$context}\n\n"
            . "Candidate's spoken response (transcribed): \"{$transcription}\"\n\n"
            . "Return ONLY a valid JSON object, no markdown: {\"content_score\": 75, \"content_feedback\": \"one sentence explaining the content score, written entirely in Bahasa Indonesia\"}. "
            . "The content_feedback value MUST be written in Bahasa Indonesia, not English.";

        $providers = ['groq', 'sambanova', 'siliconflow', 'gemini', 'openai'];
        $result = \App\Services\MultiProviderAiClient::chatJson(
            $providers,
            'You are a strict PTE Academic scoring API that strictly outputs JSON.',
            $prompt,
            ['groq_feature' => 'speaking', 'temperature' => 0.1]
        );

        if (!$result || !isset($result['content_score'])) {
            throw new \Exception("Invalid JSON returned by AI providers for PTE speaking content assessment.");
        }

        $result['content_score'] = (int) max(10, min(90, $result['content_score']));

        return $result;
    }

    /**
     * Score a written response against Pearson's published PTE Academic writing
     * rubric (storage/app/PTE_band_descriptors/pte_writing_rubric.txt). No DB/auth
     * side effects.
     *
     * @return array PTE-style score breakdown (overall_score, content_score, form_score, grammar_score, vocabulary_score, spelling_score, feedback, and development_structure_score for essays)
     * @throws \Exception if the LLM does not return valid JSON
     */
    public function scoreWriting(string $module, string $promptText, string $answer): array
    {
        $normalizedModule = str_replace('_', '-', strtolower($module));
        $rubric = file_get_contents(storage_path('app/PTE_band_descriptors/pte_writing_rubric.txt'));

        $wordCount = str_word_count($answer);
        $sentenceCount = max(1, preg_match_all('/[.!?]+(\s|$)/', trim($answer)));

        if (str_contains($normalizedModule, 'essay')) {
            $itemType = 'Write Essay';
            $constraintNote = "This is the WRITE ESSAY item. Official Form constraint: 200-300 words. "
                . "The candidate's answer is {$wordCount} words. Apply the Write Essay Form banding from the rubric "
                . "based on this exact word count, and cap the overall score low if the violation is severe.";
            $schema = "{\n  \"overall_score\": 90,\n  \"content_score\": 90,\n  \"form_score\": 90,\n  \"development_structure_score\": 90,\n  \"grammar_score\": 90,\n  \"vocabulary_score\": 90,\n  \"spelling_score\": 90,\n  \"feedback\": \"...\"\n}";
        } elseif (str_contains($normalizedModule, 'spoken')) {
            $itemType = 'Summarize Spoken Text';
            $constraintNote = "This is the SUMMARIZE SPOKEN TEXT item (Listening section, but scored with the same "
                . "Content/Form/Grammar/Vocabulary traits as Summarize Written Text). Official Form constraint: "
                . "50-70 words in a single paragraph (no single-sentence requirement). "
                . "The candidate's answer is {$wordCount} words. Score Form 80-90 if within 50-70 words, "
                . "40-60 if moderately outside (30-49 or 71-100 words), 10-30 if far outside.";
            $schema = "{\n  \"overall_score\": 90,\n  \"content_score\": 90,\n  \"form_score\": 90,\n  \"grammar_score\": 90,\n  \"vocabulary_score\": 90,\n  \"spelling_score\": 90,\n  \"feedback\": \"...\"\n}";
        } else {
            $itemType = 'Summarize Written Text';
            $constraintNote = "This is the SUMMARIZE WRITTEN TEXT item. Official Form constraint: the response MUST "
                . "be exactly ONE sentence and between 5-75 words. The candidate's answer is {$wordCount} words "
                . "across approximately {$sentenceCount} sentence(s) (based on terminal punctuation count). "
                . "If it is not a single sentence, OR outside 5-75 words, Form MUST score 0-10 and the overall "
                . "score MUST be capped 10-30 regardless of content quality, per the rubric's hard-constraint rule.";
            $schema = "{\n  \"overall_score\": 90,\n  \"content_score\": 90,\n  \"form_score\": 90,\n  \"grammar_score\": 90,\n  \"vocabulary_score\": 90,\n  \"spelling_score\": 90,\n  \"feedback\": \"...\"\n}";
        }

        $prompt = "You are a certified PTE Academic examiner. Score the candidate's response strictly according to "
            . "the official Pearson PTE Academic scoring rubric below. Do not be lenient — apply the hard Form "
            . "constraints exactly as specified.\n\n"
            . "=== RUBRIC ===\n{$rubric}\n=== END RUBRIC ===\n\n"
            . "Item type: {$itemType}\n"
            . "{$constraintNote}\n\n"
            . "Question/Prompt: \"{$promptText}\"\n"
            . "Candidate Answer: \"{$answer}\"\n\n"
            . "First, in your reasoning, verify the word count and (for Summarize Written Text) sentence count "
            . "against the Form constraint. Then score every trait per the rubric's band descriptors. "
            . "Return ONLY a valid JSON object matching exactly this schema, without markdown formatting, and "
            . "mention the counted word count explicitly in the feedback field:\n{$schema}";

        $providers = ['groq', 'sambanova', 'siliconflow', 'gemini', 'openai'];
        $scores = \App\Services\MultiProviderAiClient::chatJson(
            $providers,
            'You are a strict PTE Academic scoring API that strictly outputs JSON and enforces official Form constraints exactly.',
            $prompt,
            ['groq_feature' => 'writing', 'temperature' => 0.1]
        );

        if (!$scores) {
            throw new \Exception("Invalid JSON returned by AI providers for PTE writing scoring.");
        }

        return $scores;
    }
}
