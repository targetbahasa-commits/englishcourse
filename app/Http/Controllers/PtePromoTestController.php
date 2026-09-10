<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ScoresTextAccuracy;
use App\Http\Controllers\Concerns\VerifiesTurnstile;
use App\Models\FreeTestSubmission;
use App\Services\PteScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Public, unauthenticated PTE Academic promo/free-test flow.
 *
 * Deliberately separate from the authenticated assignments.pte-academic.* system:
 * question content comes from config('pte_promo_tests'), and submissions are stored
 * in free_test_submissions (leads), never touching real student assignment tables.
 */
class PtePromoTestController extends Controller
{
    use VerifiesTurnstile;
    use ScoresTextAccuracy;

    private const CATEGORIES = ['speaking_writing', 'reading', 'listening'];

    public function showSpeakingWriting($id)
    {
        return $this->showTest('speaking_writing', $id, 'promo.pte-speaking-writing');
    }

    public function showReading($id)
    {
        return $this->showTest('reading', $id, 'promo.pte-reading');
    }

    public function showListening($id)
    {
        return $this->showTest('listening', $id, 'promo.pte-listening');
    }

    private function showTest(string $category, $id, string $view)
    {
        $test = $this->findPteTest($category, $id);

        if (!$test) {
            abort(404);
        }

        if ($this->isPteTestGated($test)) {
            return view('promo.expired');
        }

        return view($view, ['test' => $test]);
    }

    public function submitSpeakingWriting(Request $request, $id)
    {
        $test = $this->findPteTest('speaking_writing', $id);
        if (!$test || $this->isPteTestGated($test)) {
            return response()->json(['success' => false, 'message' => 'Test tidak tersedia.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'cf-turnstile-response' => 'required|string',
            'read_aloud_audio' => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
            'repeat_sentence_audio' => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
            'describe_image_audio' => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
            'retell_lecture_audio' => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
            'summarize_written_text_answer' => 'required|string',
            'write_essay_answer' => 'required|string',
        ]);

        if (!$this->verifyTurnstile($request)) {
            return response()->json(['success' => false, 'message' => 'Verifikasi captcha gagal. Silakan coba lagi.'], 422);
        }

        $questions = $test['questions'];
        $scoringService = app(PteScoringService::class);
        $tasks = [];
        $scores = [];

        try {
            $speakingTasks = [
                'read_aloud' => $questions['read_aloud']['text'] ?? '',
                'repeat_sentence' => $questions['repeat_sentence']['text'] ?? '',
                'describe_image' => $questions['describe_image']['title'] ?? '',
                'retell_lecture' => $questions['retell_lecture']['transcript'] ?? '',
            ];

            foreach ($speakingTasks as $task => $originalText) {
                $audio = $request->file($task . '_audio');
                $result = $scoringService->scoreSpeaking($audio, $originalText, $task);

                if (!$result['success']) {
                    $tasks[$task] = ['error' => $result['message']];
                    continue;
                }

                $path = $audio->store('promo_recordings/pte', 'public');
                $tasks[$task] = [
                    'audio_url' => asset('storage/' . $path),
                    'transcription' => $result['transcription'],
                    'scores' => $result['scores'],
                ];
                $scores[] = $result['scores']['overall_score'] ?? 0;
            }

            $writingTasks = [
                'summarize_written_text' => [
                    'prompt' => $questions['summarize_written_text']['passage'] ?? '',
                    'answer' => $validated['summarize_written_text_answer'],
                ],
                'write_essay' => [
                    'prompt' => $questions['write_essay']['topic'] ?? '',
                    'answer' => $validated['write_essay_answer'],
                ],
            ];

            foreach ($writingTasks as $task => $data) {
                $result = $scoringService->scoreWriting($task, $data['prompt'], $data['answer']);
                $tasks[$task] = [
                    'answer' => $data['answer'],
                    'scores' => $result,
                ];
                $scores[] = $result['overall_score'] ?? 0;
            }

            $overallScore = count($scores) ? round(array_sum($scores) / count($scores), 1) : null;

            $submission = FreeTestSubmission::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'test_type' => 'pte_speaking_writing_' . $id,
                'estimated_band_score' => $overallScore,
                'ai_raw_json_feedback' => ['overall_score' => $overallScore, 'tasks' => $tasks],
            ]);

            return response()->json([
                'success' => true,
                'submission_id' => $submission->id,
                'overall_score' => $overallScore,
            ]);
        } catch (\Throwable $e) {
            Log::error('PTE Promo Speaking & Writing submission error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menilai jawaban Anda.'], 500);
        }
    }

    public function submitReading(Request $request, $id)
    {
        $test = $this->findPteTest('reading', $id);
        if (!$test || $this->isPteTestGated($test)) {
            return response()->json(['success' => false, 'message' => 'Test tidak tersedia.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'cf-turnstile-response' => 'required|string',
            'rw_fib_answers' => 'array',
            'rw_fib_answers.*' => 'nullable|string',
            'reorder_answer' => 'array',
            'reorder_answer.*' => 'integer',
            'reading_fib_answers' => 'array',
            'reading_fib_answers.*' => 'nullable|string',
        ]);

        if (!$this->verifyTurnstile($request)) {
            return response()->json(['success' => false, 'message' => 'Verifikasi captcha gagal. Silakan coba lagi.'], 422);
        }

        $questions = $test['questions'];
        $tasks = [];
        $correct = 0;
        $total = 0;

        if (isset($questions['rw_fib'])) {
            $correctAnswers = $this->extractBracketedAnswers($questions['rw_fib']['passage'] ?? '');
            $submitted = $validated['rw_fib_answers'] ?? [];
            $taskCorrect = 0;
            foreach ($correctAnswers as $i => $answer) {
                $total++;
                if (($submitted[$i] ?? null) === $answer) {
                    $correct++;
                    $taskCorrect++;
                }
            }
            $tasks['rw_fib'] = ['submitted' => $submitted, 'correct_count' => $taskCorrect, 'total' => count($correctAnswers)];
        }

        if (isset($questions['reorder'])) {
            $correctOrder = $questions['reorder']['correct_order'] ?? [];
            $submitted = $validated['reorder_answer'] ?? [];
            $total++;
            $isCorrect = $submitted === $correctOrder;
            if ($isCorrect) $correct++;
            $tasks['reorder'] = ['submitted' => $submitted, 'is_correct' => $isCorrect];
        }

        if (isset($questions['reading_fib'])) {
            $correctAnswers = $this->extractBracketedAnswers($questions['reading_fib']['passage'] ?? '');
            $submitted = $validated['reading_fib_answers'] ?? [];
            $taskCorrect = 0;
            foreach ($correctAnswers as $i => $answer) {
                $total++;
                if (($submitted[$i] ?? null) === $answer) {
                    $correct++;
                    $taskCorrect++;
                }
            }
            $tasks['reading_fib'] = ['submitted' => $submitted, 'correct_count' => $taskCorrect, 'total' => count($correctAnswers)];
        }

        $overallScore = $total ? $this->scaleToPteScore($correct / $total) : null;

        $submission = FreeTestSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'test_type' => 'pte_reading_' . $id,
            'estimated_band_score' => $overallScore,
            'ai_raw_json_feedback' => ['overall_score' => $overallScore, 'correct' => $correct, 'total' => $total, 'tasks' => $tasks],
        ]);

        return response()->json([
            'success' => true,
            'submission_id' => $submission->id,
            'overall_score' => $overallScore,
        ]);
    }

    public function submitListening(Request $request, $id)
    {
        $test = $this->findPteTest('listening', $id);
        if (!$test || $this->isPteTestGated($test)) {
            return response()->json(['success' => false, 'message' => 'Test tidak tersedia.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'cf-turnstile-response' => 'required|string',
            'sst_answer' => 'nullable|string',
            'wfd_answers' => 'array',
            'wfd_answers.*' => 'nullable|string',
        ]);

        if (!$this->verifyTurnstile($request)) {
            return response()->json(['success' => false, 'message' => 'Verifikasi captcha gagal. Silakan coba lagi.'], 422);
        }

        $questions = $test['questions'];
        $tasks = [];
        $scores = [];

        try {
            if (isset($questions['sst']) && !empty($validated['sst_answer'])) {
                $result = app(PteScoringService::class)->scoreWriting(
                    'summarize-spoken-text',
                    $questions['sst']['transcript'] ?? '',
                    $validated['sst_answer']
                );
                $tasks['sst'] = ['answer' => $validated['sst_answer'], 'scores' => $result];
                $scores[] = $result['overall_score'] ?? 0;
            }

            if (isset($questions['wfd'])) {
                $sentences = $questions['wfd']['sentences'] ?? [];
                $submitted = $validated['wfd_answers'] ?? [];
                $ratios = [];
                foreach ($sentences as $i => $sentence) {
                    $ratio = $this->wordAccuracy($sentence, $submitted[$i] ?? '');
                    $ratios[] = $ratio;
                }
                $avgRatio = count($ratios) ? array_sum($ratios) / count($ratios) : 0;
                $wfdScore = $this->scaleToPteScore($avgRatio);
                $tasks['wfd'] = ['submitted' => $submitted, 'accuracy' => round($avgRatio, 2)];
                $scores[] = $wfdScore;
            }

            $overallScore = count($scores) ? round(array_sum($scores) / count($scores), 1) : null;

            $submission = FreeTestSubmission::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'test_type' => 'pte_listening_' . $id,
                'estimated_band_score' => $overallScore,
                'ai_raw_json_feedback' => ['overall_score' => $overallScore, 'tasks' => $tasks],
            ]);

            return response()->json([
                'success' => true,
                'submission_id' => $submission->id,
                'overall_score' => $overallScore,
            ]);
        } catch (\Throwable $e) {
            Log::error('PTE Promo Listening submission error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menilai jawaban Anda.'], 500);
        }
    }

    public function thankYou($submissionId)
    {
        $submission = FreeTestSubmission::where('id', $submissionId)
            ->where('test_type', 'like', 'pte_%')
            ->firstOrFail();

        return view('promo.pte-thankyou', ['submission' => $submission]);
    }

    private function findPteTest(string $category, $id): ?array
    {
        if (!in_array($category, self::CATEGORIES, true)) {
            return null;
        }

        $tests = config('pte_promo_tests.' . $category, []);
        foreach ($tests as $test) {
            if ((string) ($test['id'] ?? null) === (string) $id) {
                return $test;
            }
        }

        return null;
    }

    private function isPteTestGated(array $test): bool
    {
        if (empty($test['is_free_tier'])) {
            return true;
        }
        if (!empty($test['promo_start']) && \Carbon\Carbon::parse($test['promo_start'])->isFuture()) {
            return true;
        }
        if (!empty($test['promo_deadline']) && \Carbon\Carbon::parse($test['promo_deadline'])->isPast()) {
            return true;
        }
        return false;
    }

    /**
     * Extract ground-truth answers from a fill-in-the-blank passage marked with [brackets].
     */
    private function extractBracketedAnswers(string $passage): array
    {
        preg_match_all('/\[(.*?)\]/', $passage, $matches);
        return $matches[1] ?? [];
    }

}
