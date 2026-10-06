<?php

namespace App\Http\Controllers;

use App\Models\FreeTestSubmission;
use App\Models\ToeflPromoQuestion;
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

        // 40 questions full test is standard 25 minutes
        if ($test->questions->count() == 40 || empty($test->duration_minutes)) {
            $test->duration_minutes = 25;
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:25',
            'answers' => 'nullable|array',
        ]);

        $leadName = !empty($validated['name']) ? $validated['name'] : 'Peserta TOEFL (Waktu Habis)';
        $leadEmail = !empty($validated['email']) ? $validated['email'] : 'peserta@targetbahasa.com';
        $leadWhatsapp = !empty($validated['whatsapp_number']) ? $validated['whatsapp_number'] : '081234567890';

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

            if ($q->part === 'part_a' || $q->question_number <= 15) {
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
                'correct_answer' => $q->correct_answer,
                'user_answer' => $userAns,
                'is_correct' => $isCorrect,
                'explanation' => $q->explanation,
            ];
        }

        // Calculate TOEFL ITP Section 2 scaled score (31 - 68, ETS official)
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
            'name' => $leadName,
            'email' => $leadEmail,
            'whatsapp_number' => $leadWhatsapp,
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
     * Map raw correct answers to standard TOEFL ITP Structure scaled score (310 - 680).
     * Official ETS Section 2 converted range: 31 - 68 -> multiplied by 10 to represent 310 - 680.
     */
    private function calculateToeflStructureScaledScore(int $correct, int $total): int
    {
        if ($total <= 0) return 310;

        // Normalize to 40-item scale then apply official lookup table
        $normalizedCorrect = ($correct / $total) * 40;

        // Official ETS conversion table (Structure & Written Expression, 40 items)
        $conversionTable = [
             0 => 31,  1 => 31,  2 => 31,  3 => 32,  4 => 33,
             5 => 34,  6 => 35,  7 => 36,  8 => 37,  9 => 38,
            10 => 39, 11 => 40, 12 => 41, 13 => 42, 14 => 43,
            15 => 44, 16 => 45, 17 => 46, 18 => 47, 19 => 48,
            20 => 49, 21 => 50, 22 => 51, 23 => 52, 24 => 53,
            25 => 54, 26 => 55, 27 => 56, 28 => 57, 29 => 58,
            30 => 59, 31 => 60, 32 => 61, 33 => 62, 34 => 63,
            35 => 64, 36 => 65, 37 => 66, 38 => 67, 39 => 67,
            40 => 68,
        ];

        $rounded = (int) round($normalizedCorrect);
        $rounded = max(0, min(40, $rounded));

        return $conversionTable[$rounded] * 10;
    }

    /**
     * Estimate CEFR level from TOEFL ITP Structure scaled score (310–680).
     */
    private function calculateCefrLevel(int $scaledScore): string
    {
        if ($scaledScore >= 640) return 'C1 (Advanced)';
        if ($scaledScore >= 530) return 'B2 (Upper Intermediate)';
        if ($scaledScore >= 430) return 'B1 (Intermediate)';
        if ($scaledScore >= 370) return 'A2 (Elementary)';
        return 'A1 (Beginner)';
    }

    /**
     * Update correct answer for a question (Admin only).
     */
    public function updateAnswer(Request $request, $questionId)
    {
        $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin', 'teacher']);

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Fitur ini hanya untuk Admin / Pengajar.',
            ], 403);
        }

        $validated = $request->validate([
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $question = ToeflPromoQuestion::findOrFail($questionId);
        $question->correct_answer = $validated['correct_answer'];
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Kunci jawaban berhasil diperbarui.',
            'question_id' => $question->id,
            'correct_answer' => $question->correct_answer,
        ]);
    }
}
