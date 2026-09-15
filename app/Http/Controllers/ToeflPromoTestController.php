<?php

namespace App\Http\Controllers;

use App\Models\FreeTestSubmission;
use App\Models\ToeflPromoTest;
use Illuminate\Http\Request;

class ToeflPromoTestController extends Controller
{
    /**
     * Display the dedicated public promo test page.
     */
    public function show(Request $request, $id)
    {
        $test = ToeflPromoTest::with('questions')->findOrFail($id);

        if (!$test->isPromoActive()) {
            return view('promo.expired');
        }

        $brochureType = $request->query('b', 'online');
        $brochureUrl = $brochureType === 'offline' ? url('/brochure/offline') : url('/brochure/online');

        $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin', 'teacher']);

        $questions = $test->questions->map(function ($q) use ($isAdmin) {
            $item = [
                'id' => $q->id,
                'question_number' => $q->question_number,
                'part' => $q->part,
                'question_text' => $q->question_text,
                'option_a' => $q->option_a,
                'option_b' => $q->option_b,
                'option_c' => $q->option_c,
                'option_d' => $q->option_d,
            ];
            if ($isAdmin) {
                $item['correct_answer'] = $q->correct_answer;
                $item['explanation'] = $q->explanation;
            }
            return $item;
        });

        return view('promo.toefl-structure-show', compact('test', 'questions', 'brochureType', 'brochureUrl', 'isAdmin'));
    }

    /**
     * Process test submission, calculate score, record lead, and return detailed review.
     */
    public function submit(Request $request, $id)
    {
        $test = ToeflPromoTest::with('questions')->findOrFail($id);

        if (!$test->isPromoActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Tes promo ini sudah berakhir atau belum aktif.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:25',
            'answers' => 'nullable|array',
        ]);

        $questions = $test->questions;
        $userAnswers = $validated['answers'] ?? [];

        $correctCount = 0;
        $totalQuestions = count($questions);
        $reviewItems = [];

        $partACorrect = 0;
        $partATotal = 0;
        $partBCorrect = 0;
        $partBTotal = 0;

        foreach ($questions as $q) {
            $userAns = strtoupper(trim($userAnswers[$q->id] ?? ''));
            $correctAns = strtoupper(trim($q->correct_answer));
            $isCorrect = ($userAns !== '' && $userAns === $correctAns);

            if ($isCorrect) {
                $correctCount++;
            }

            $isPartA = ($q->part === 'part_a' || $q->question_number <= 15);
            if ($isPartA) {
                $partATotal++;
                if ($isCorrect) $partACorrect++;
            } else {
                $partBTotal++;
                if ($isCorrect) $partBCorrect++;
            }

            $reviewItems[] = [
                'id' => $q->id,
                'question_number' => $q->question_number,
                'part' => $q->part,
                'question_text' => $q->question_text,
                'option_a' => $q->option_a,
                'option_b' => $q->option_b,
                'option_c' => $q->option_c,
                'option_d' => $q->option_d,
                'user_answer' => $userAns ?: '-',
                'correct_answer' => $correctAns,
                'is_correct' => $isCorrect,
                'explanation' => $q->explanation,
            ];
        }

        // Calculate TOEFL ITP Section 2 scaled score (20 - 68)
        $percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $scaledScore = $this->calculateToeflStructureScaledScore($correctCount, $totalQuestions);
        $cefrLevel = $this->calculateCefrLevel($scaledScore);

        $feedbackData = [
            'total_questions' => $totalQuestions,
            'correct_count' => $correctCount,
            'incorrect_count' => $totalQuestions - $correctCount,
            'part_a_correct' => $partACorrect,
            'part_a_total' => $partATotal,
            'part_b_correct' => $partBCorrect,
            'part_b_total' => $partBTotal,
            'percentage' => $percentage,
            'scaled_score' => $scaledScore,
            'cefr_level' => $cefrLevel,
            'review_items' => $reviewItems,
        ];

        // Persist lead submission
        $submission = FreeTestSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'test_type' => 'toefl_itp_structure_' . $test->id,
            'estimated_band_score' => $scaledScore,
            'ai_raw_json_feedback' => $feedbackData,
        ]);

        return response()->json([
            'success' => true,
            'submission_id' => $submission->id,
            'results' => $feedbackData,
            'message' => 'Tes berhasil diselesaikan!',
        ]);
    }

    /**
     * Map raw correct answers to standard TOEFL ITP Structure scaled score (20 - 68).
     */
    private function calculateToeflStructureScaledScore(int $correct, int $total): int
    {
        if ($total <= 0) return 20;

        // Normalized to 40 items scale
        $ratio = $correct / $total;
        $scaled = 20 + ($ratio * 48); // range from 20 to 68

        return (int) round(max(20, min(68, $scaled)));
    }

    /**
     * Estimate CEFR level from TOEFL Structure scaled score.
     */
    private function calculateCefrLevel(int $scaledScore): string
    {
        if ($scaledScore >= 64) return 'C1 (Advanced)';
        if ($scaledScore >= 53) return 'B2 (Upper Intermediate)';
        if ($scaledScore >= 43) return 'B1 (Intermediate)';
        return 'A2 (Elementary)';
    }
}
