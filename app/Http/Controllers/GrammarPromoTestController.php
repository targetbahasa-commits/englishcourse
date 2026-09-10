<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScoresTextAccuracy;
use App\Http\Controllers\Concerns\VerifiesTurnstile;
use App\Models\FreeTestSubmission;
use App\Models\GrammarTopic;
use Illuminate\Http\Request;

/**
 * Public, unauthenticated Grammar Practice promo/free-test flow.
 *
 * Sources content from the existing GrammarTopic/GrammarTopicQuestion pool, which is
 * fully decoupled from the real class Meeting/curriculum system. Submissions are
 * lead-capture with deterministic scoring, stored in free_test_submissions.
 */
class GrammarPromoTestController extends Controller
{
    use VerifiesTurnstile;
    use ScoresTextAccuracy;

    private const QUESTIONS_PER_PROMO = 10;

    public function show($topicId)
    {
        $topic = GrammarTopic::find($topicId);

        if (!$topic) {
            abort(404);
        }

        if ($this->isTopicGated($topic)) {
            return view('promo.expired');
        }

        $questions = $topic->questions()->orderBy('order')->get();

        return view('promo.grammar-practice-show', ['topic' => $topic, 'questions' => $questions]);
    }

    public function submit(Request $request, $topicId)
    {
        $topic = GrammarTopic::find($topicId);

        if (!$topic || $this->isTopicGated($topic)) {
            return response()->json(['success' => false, 'message' => 'Test tidak tersedia.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'cf-turnstile-response' => 'required|string',
            'answers' => 'array',
            'answers.*' => 'nullable|string',
        ]);

        if (!$this->verifyTurnstile($request)) {
            return response()->json(['success' => false, 'message' => 'Verifikasi captcha gagal. Silakan coba lagi.'], 422);
        }

        $questions = $topic->questions()->orderBy('order')->get();
        $submittedAnswers = $validated['answers'] ?? [];

        $aiResults = $this->gradeWithAi($questions, $submittedAnswers);

        $results = [];
        $ratios = [];
        foreach ($questions as $question) {
            $submitted = $submittedAnswers[$question->id] ?? '';

            $aiResult = null;
            if ($aiResults) {
                foreach ($aiResults as $r) {
                    if ((int) ($r['question_id'] ?? 0) === $question->id) {
                        $aiResult = $r;
                        break;
                    }
                }
            }

            if ($aiResult && isset($aiResult['accuracy_score'])) {
                $ratio = max(0, min(100, (float) $aiResult['accuracy_score'])) / 100;
                $feedback = $aiResult['feedback'] ?? null;
                $gradedBy = 'ai';
            } else {
                // AI grading unavailable (all providers failed) or this specific
                // item was missing from the AI response - fall back to the
                // original deterministic word-match scoring rather than losing
                // the submission or scoring it as zero.
                $ratio = $this->wordAccuracy($question->answer_en, $submitted);
                $feedback = null;
                $gradedBy = 'deterministic';
            }

            $results[] = [
                'question_id' => $question->id,
                'prompt' => $question->question_id,
                'submitted' => $submitted,
                'correct_answer' => $question->answer_en,
                'accuracy' => round($ratio, 2),
                'feedback' => $feedback,
                'graded_by' => $gradedBy,
            ];
            $ratios[] = $ratio;
        }

        $avgRatio = count($ratios) ? array_sum($ratios) / count($ratios) : 0;
        $score = $this->scaleToPteScore($avgRatio);
        $totalQuestions = count($results);
        $answeredQuestions = count(array_filter($results, function($r) {
            return !empty(trim($r['submitted'] ?? ''));
        }));
        $completionPct = $totalQuestions > 0 ? (int) round(($answeredQuestions / $totalQuestions) * 100) : 100;
        $durationSeconds = (int) $request->input('duration_seconds', 0);

        $submission = FreeTestSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'test_type' => 'grammar_practice_' . $topic->id,
            'estimated_band_score' => $score,
            'ai_raw_json_feedback' => [
                'topic' => $topic->title,
                'score' => $score,
                'results' => $results,
                'answered_count' => $answeredQuestions,
                'total_questions' => $totalQuestions,
                'completion_percentage' => $completionPct,
                'duration_seconds' => $durationSeconds > 0 ? $durationSeconds : null,
            ],
        ]);

        return response()->json([
            'success' => true,
            'submission_id' => $submission->id,
            'score' => $score,
        ]);
    }

    public function thankYou($submissionId)
    {
        $submission = FreeTestSubmission::where('id', $submissionId)
            ->where('test_type', 'like', 'grammar_practice_%')
            ->firstOrFail();

        return view('promo.grammar-practice-thankyou', ['submission' => $submission]);
    }

    /**
     * Live AI evaluation & explanation for an individual question in public promo grammar practice.
     */
    public function explainAnswer(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'prompt' => 'required|string|max:500',
            'correct_answer' => 'required|string|max:500',
            'submitted_answer' => 'required|string|max:500',
        ]);

        $systemPrompt = 'Anda adalah guru tata bahasa Inggris (Grammar) yang ramah, jelas, dan edukatif. Tuliskan penjelasan dalam bentuk paragraf teks biasa bahasa Indonesia (DILARANG MENGGUNAKAN FORMAT JSON, DILARANG MENGGUNAKAN TANDA KURUNG KURAWAL ATAU KODE PROGRAMMING).';
        $userPrompt = "Berikan evaluasi dan penjelasan ringkas dalam 2-3 kalimat bahasa Indonesia untuk jawaban latihan grammar murid berikut:

Topik Grammar: {$validated['topic']}
Soal (Bahasa Indonesia): {$validated['prompt']}
Kunci Jawaban Benar (Bahasa Inggris): {$validated['correct_answer']}
Jawaban Murid: {$validated['submitted_answer']}

Panduan Menjawab:
1. Berikan umpan balik ramah (apakah jawaban murid sudah tepat, hampir tepat, atau bagian kosa kata/grammar mana yang perlu diperbaiki).
2. Jelaskan aturan grammar terkait topik ini secara ringkas.
3. Berikan saran atau kalimat perbaikan jika ada kekeliruan.
TULIS LANGSUNG SEBAGAI PARAGRAF TEKS BIASA, JANGAN PERNAH MENGGUNAKAN FORMAT JSON ATAU CODE BLOCK.";

        $providers = ['sambanova', 'groq', 'cerebras', 'siliconflow', 'gemini', 'openai'];
        $result = \App\Services\MultiProviderAiClient::chat(
            $providers,
            $systemPrompt,
            $userPrompt,
            [
                'groq_feature' => 'writing',
                'max_tokens' => 512,
                'temperature' => 0.3,
                'json_mode' => false,
            ]
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'AI sedang memproses permintaan lain.',
            ], 503);
        }

        $rawContent = $result['content'] ?? '';
        $cleanExplanation = self::cleanAiExplanationText($rawContent);

        return response()->json([
            'success' => true,
            'explanation' => $cleanExplanation,
        ]);
    }

    /**
     * Clean raw AI output to human-readable text if the model returned JSON.
     */
    public static function cleanAiExplanationText(string $text): string
    {
        $trimmed = trim($text);
        if (preg_match('/^```(?:json)?\s*([\s\S]*?)\s*```$/i', $trimmed, $m)) {
            $trimmed = trim($m[1]);
        }
        if ((str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}')) || (str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']'))) {
            $decoded = json_decode($trimmed, true);
            if (is_array($decoded)) {
                $parts = [];
                if (!empty($decoded['feedback'])) $parts[] = $decoded['feedback'];
                if (!empty($decoded['explanation'])) $parts[] = $decoded['explanation'];
                if (!empty($decoded['suggestion'])) $parts[] = " Saran perbaikan: " . $decoded['suggestion'];
                if (!empty($decoded['correction'])) $parts[] = " Koreksi: " . $decoded['correction'];
                
                if (!empty($parts)) {
                    return implode("\n\n", $parts);
                }
                $values = array_filter(array_values($decoded), 'is_string');
                if (!empty($values)) {
                    return implode("\n\n", $values);
                }
            }
        }
        return $trimmed;
    }

    /**
     * "Lesson Explanation" toolbar content for a grammar topic - public/no-auth
     * counterpart of GrammarWritingAdminController::explainLessonTopic(). The
     * prompt (with markdown-formatting instructions) is built server-side here
     * rather than accepting a client-supplied prompt, and via the safe
     * multi-provider fallback chain, instead of the toolbar's previous direct
     * browser->Groq call with a hardcoded API key baked into page source (a
     * real credential-exposure bug, and also why formatting was unreliable -
     * that shared key was frequently rate-limited, so the model's markdown
     * instructions weren't being honored consistently).
     */
    public function explainLesson(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $systemPrompt = 'Anda adalah instruktur tata bahasa Inggris (Grammar) ahli. Tugas Anda menyajikan ringkasan materi grammar dalam format Markdown yang sangat rapi, terstruktur, mudah dipelajari, dan visual.';
        $userPrompt = "Tolong berikan penjelasan materi lengkap dan ringkas untuk topik grammar: **{$validated['topic']}**.

FORMAT MATERI YANG HARUS DIIKUTI:

##  Ringkasan Konsep Dasar
Jelaskan secara singkat apa itu topik ini, fungsi utamanya, dan kapan digunakan dalam bahasa Indonesia yang ramah & mudah dimengerti.

---

##  Pembagian & Rumus Lengkap
Bagi materi ke dalam sub-topik yang jelas (misalnya: Verbal, Nominal, Passive, atau aturan khusus). Untuk setiap sub-topik gunakan format:

### 🔹 [Nama Sub-Topik / Bentuk]
- **Fungsi / Penggunaan:** Jelaskan kapan bentuk ini digunakan.
- ** Rumus:**
  - `(+) [Rumus Positif]`
  - `(-) [Rumus Negatif]`
  - `(?) [Rumus Tanya]`
- ** Contoh Kalimat:**
  - 🇬🇧 *English sentence here with **key verb** in bold*
    🇮🇩 *(Artinya dalam bahasa Indonesia)*
  - 🇬🇧 *Another English example*
    🇮🇩 *(Artinya dalam bahasa Indonesia)*

---

##  Tips Penting & Kesalahan Umum (Common Mistakes)
- Berikan 2-3 poin tips praktis atau kesalahan yang sering dilakukan siswa beserta perbaikannya ( Salah vs  Benar).";

        $providers = ['sambanova', 'groq', 'cerebras', 'siliconflow', 'gemini', 'openai'];
        $result = \App\Services\MultiProviderAiClient::chat($providers, $systemPrompt, $userPrompt, [
            'groq_feature' => 'writing',
            'max_tokens' => 2048,
            'temperature' => 0.5,
            // We want raw Markdown prose back, not a JSON object - chat()'s
            // json_mode defaults to true, which forces response_format:
            // json_object and made several providers reject the request
            // outright (400) since the prompt/response isn't JSON-shaped.
            'json_mode' => false,
        ]);

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'AI sedang memproses permintaan lain. Silakan coba lagi.'], 503);
        }

        return response()->json(['success' => true, 'content' => $result['content']]);
    }

    /**
     * AI-based grading: judges whether the submitted answer is grammatically
     * correct and conveys the same meaning as the reference answer, rather
     * than the deterministic wordAccuracy()'s exact-word-overlap heuristic
     * (which unfairly penalizes valid paraphrases/equivalent phrasing).
     * Returns null if every AI provider fails, so the caller can fall back
     * to deterministic scoring per-question.
     *
     * @return array<int, array{question_id: int, accuracy_score: int, feedback: string}>|null
     */
    private function gradeWithAi($questions, array $submittedAnswers): ?array
    {
        $items = [];
        foreach ($questions as $q) {
            $items[] = [
                'question_id' => $q->id,
                'prompt' => $q->question_id,
                'correct_answer' => $q->answer_en,
                'submitted_answer' => $submittedAnswers[$q->id] ?? '',
            ];
        }

        if (empty($items)) {
            return null;
        }

        $itemsJson = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $systemPrompt = 'You are a strict English grammar examiner API that strictly outputs JSON.';
        $userPrompt = "Grade each of the following English grammar practice answers. For each item, judge whether "
            . "the candidate's submitted_answer is grammatically correct AND conveys the same meaning as "
            . "correct_answer - valid paraphrases or equivalent correct phrasing should score well, not just exact "
            . "word matches, but genuinely wrong or ungrammatical answers must score low. An empty submitted_answer "
            . "must score 0.\n\nItems:\n{$itemsJson}\n\n"
            . "Return ONLY a valid JSON object, no markdown: {\"results\": [{\"question_id\": 1, "
            . "\"accuracy_score\": 85, \"feedback\": \"one short sentence in Bahasa Indonesia explaining the "
            . "score\"}, ...]}. accuracy_score is an integer 0-100. Include exactly one entry per item, matching "
            . "each item's question_id.";

        $providers = ['sambanova', 'groq', 'siliconflow', 'gemini', 'openai'];
        $decoded = \App\Services\MultiProviderAiClient::chatJson($providers, $systemPrompt, $userPrompt, [
            'groq_feature' => 'writing',
            'temperature' => 0.2,
        ]);

        if (!$decoded || !isset($decoded['results']) || !is_array($decoded['results'])) {
            return null;
        }

        return $decoded['results'];
    }

    private function isTopicGated(GrammarTopic $topic): bool
    {
        if (!$topic->is_free_tier) {
            return true;
        }
        if ($topic->promo_start && \Carbon\Carbon::parse($topic->promo_start)->isFuture()) {
            return true;
        }
        if ($topic->promo_deadline && \Carbon\Carbon::parse($topic->promo_deadline)->isPast()) {
            return true;
        }
        return false;
    }
}
