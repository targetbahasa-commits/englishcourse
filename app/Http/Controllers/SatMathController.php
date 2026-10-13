<?php

namespace App\Http\Controllers;

use App\Models\SatMathMeeting;
use App\Models\SatMathQuestion;
use App\Models\SatMathScore;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatMathController extends Controller
{
    use HandlesAssignmentAccess;

    private const CONTEXT = 'assignments';

    public function __construct()
    {
        $this->registerAssignmentAccessMiddleware();
    }

    /**
     * Show a specific SAT Math meeting with interactive exercises and grading.
     */
    public function showMeeting(Request $request, int $number)
    {
        $user = Auth::user();

        if ($request->has('retry')) {
            $type = $request->input('type', $request->has('review') ? 'review' : 'practice');
            SatMathScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where('type', $type)
                ->where('context', self::CONTEXT)
                ->delete();

            $redirectParams = ['number' => $number];
            if ($type === 'review') {
                $redirectParams['review'] = 1;
            } else {
                $redirectParams['exercise'] = 1;
            }

            return redirect()->route('assignments.sat.math.meeting', $redirectParams)
                ->with('info', 'Latihan telah direset. Silakan kerjakan kembali.');
        }

        $meeting = SatMathMeeting::where('meeting_number', $number)->where('context', self::CONTEXT)->firstOrFail();

        if ($meeting->is_locked && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.sat.math')
                ->with('error', 'Meeting ini saat ini terkunci.');
        }

        $practiceScore = SatMathScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->where('type', 'practice')
            ->where('context', self::CONTEXT)
            ->first();

        $reviewScore = SatMathScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->where('type', 'review')
            ->where('context', self::CONTEXT)
            ->first();

        $hasReview = SatMathQuestion::where('meeting_id', $meeting->id)
            ->where('type', 'review')
            ->exists();

        // 1. Material Page
        if ($request->has('material')) {
            $practiceQuestions = SatMathQuestion::where('meeting_id', $meeting->id)
                ->where('type', 'practice')
                ->orderBy('question_number')
                ->get();

            return view('assignments.sat.math-material', [
                'meeting' => $meeting,
                'questions' => $practiceQuestions,
                'existingScore' => $practiceScore,
            ]);
        }

        // 2. Review Materi Page
        if ($request->has('review')) {
            $reviewQuestions = SatMathQuestion::where('meeting_id', $meeting->id)
                ->where('type', 'review')
                ->orderBy('question_number')
                ->get();

            return view('assignments.sat.math-meeting', [
                'meeting' => $meeting,
                'questions' => $reviewQuestions,
                'existingScore' => $reviewScore,
                'type' => 'review',
                'pageTitle' => $meeting->title . ': Review Materi',
                'pageSubtitle' => '20 Soal Review Pemahaman Materi Sebelumnya',
                'badgeText' => 'Review Materi',
            ]);
        }

        // 3. Practice Exercise Page
        if ($request->has('exercise')) {
            $practiceQuestions = SatMathQuestion::where('meeting_id', $meeting->id)
                ->where('type', 'practice')
                ->orderBy('question_number')
                ->get();

            return view('assignments.sat.math-meeting', [
                'meeting' => $meeting,
                'questions' => $practiceQuestions,
                'existingScore' => $practiceScore,
                'type' => 'practice',
                'pageTitle' => $meeting->title . ': Math Practice',
                'pageSubtitle' => $meeting->subtitle . ' - 20 Soal Latihan & Pembahasan',
                'badgeText' => 'Practice Exercise',
            ]);
        }

        // 4. Selection Page (Default)
        $practiceCount = SatMathQuestion::where('meeting_id', $meeting->id)
            ->where('type', 'practice')
            ->count();
        $reviewCount = SatMathQuestion::where('meeting_id', $meeting->id)
            ->where('type', 'review')
            ->count();

        return view('assignments.sat.math-selection', [
            'meeting' => $meeting,
            'practiceQuestionsCount' => $practiceCount,
            'reviewQuestionsCount' => $reviewCount,
            'practiceScore' => $practiceScore,
            'reviewScore' => $reviewScore,
            'hasReview' => $hasReview,
        ]);
    }

    /**
     * Finds the sibling meeting for a given test_number + module_number, or
     * null if this test doesn't have that module.
     */
    private function findModuleMeeting(?int $testNumber, int $moduleNumber): ?SatMathMeeting
    {
        if ($testNumber === null) {
            return null;
        }

        return SatMathMeeting::where('context', self::CONTEXT)
            ->where('test_number', $testNumber)
            ->where('module_number', $moduleNumber)
            ->first();
    }

    /**
     * Display the full Digital SAT Math Mockup Test (CBT Exam Interface - 22 Questions, 35 Minutes).
     */
    public function practiceTest(Request $request, int $number)
    {
        $user = Auth::user();
        $isStaff = $user->isAdmin() || $user->isTeacher();

        $meeting = SatMathMeeting::where('meeting_number', $number)->where('context', self::CONTEXT)->firstOrFail();
        $stageSessionKey = 'sat_math_stage_test_' . ($meeting->test_number ?? $number);

        if ($request->has('retry')) {
            SatMathScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where('type', 'practice')
                ->where('context', self::CONTEXT)
                ->delete();

            return redirect()->route('assignments.sat.math.practice-test', $number)
                ->with('info', 'Practice Test Math telah direset. Silakan mulai simulasi dari awal.');
        }

        // Allow Admin or Teacher to override stage via query parameter (e.g. ?stage=Easy or ?stage=Hard)
        if ($isStaff && $request->filled('stage')) {
            $newStage = in_array(ucfirst(strtolower($request->query('stage'))), ['Hard', 'Easy']) ? ucfirst(strtolower($request->query('stageRaw', $request->query('stage')))) : 'Hard';
            session([$stageSessionKey => $newStage]);
        }

        $currentStage = session($stageSessionKey, 'Hard');

        if ($meeting->is_locked && !$isStaff) {
            return redirect()->route('assignments.sat.math')
                ->with('error', 'Practice Test Math ini saat ini terkunci.');
        }

        // Module 2 may only be entered after Module 1 of the same test is done.
        if ($meeting->module_number === 2 && !$isStaff) {
            $module1 = $this->findModuleMeeting($meeting->test_number, 1);
            $module1Done = $module1 && SatMathScore::where('user_id', $user->id)
                ->where('meeting_number', $module1->meeting_number)
                ->where('type', 'practice')
                ->where('context', self::CONTEXT)
                ->exists();

            if (!$module1Done) {
                return redirect()->route('assignments.sat.math.practice-test', $module1->meeting_number ?? $number)
                    ->with('error', 'Selesaikan Module 1 Math terlebih dahulu — Module 2 ditentukan berdasarkan hasil Module 1.');
            }
        }

        $questionsQuery = SatMathQuestion::where('meeting_id', $meeting->id)
            ->where('type', 'practice');

        // For Module 2, load questions matching the active adaptive stage (Hard vs Easy)
        if ($meeting->module_number === 2) {
            $stageCount = (clone $questionsQuery)->where('stage', $currentStage)->count();
            if ($stageCount > 0) {
                $questionsQuery->where('stage', $currentStage);
            }
        }

        $questions = $questionsQuery->orderBy('question_number')->get();

        $existingScore = SatMathScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->where('type', 'practice')
            ->where('context', self::CONTEXT)
            ->first();

        return view('assignments.sat.mockup', [
            'meeting' => $meeting,
            'questions' => $questions,
            'existingScore' => $existingScore,
            'practiceNumber' => $number,
            'sectionType' => 'math',
            'sectionTitle' => 'Section 2: Math',
            'sectionSubtitle' => 'Practice Test ' . $number . ': ' . $meeting->title . ' • ' . $questions->count() . ' Questions',
            'durationMinutes' => 35,
            'activeStage' => $currentStage,
            'testNumber' => $meeting->test_number,
            'isFullTest' => $meeting->test_number !== null,
        ]);
    }

    /**
     * Submit answers for an SAT Math meeting.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'meeting_number' => 'required|integer',
        ]);

        $user = Auth::user();
        $meetingNumber = $request->integer('meeting_number');
        $type = $request->input('type', 'practice');
        if (!in_array($type, ['practice', 'review'])) {
            $type = 'practice';
        }

        $meeting = SatMathMeeting::where('meeting_number', $meetingNumber)->where('context', self::CONTEXT)->firstOrFail();
        $stageSessionKey = 'sat_math_stage_test_' . ($meeting->test_number ?? $meetingNumber);
        $currentStage = session($stageSessionKey, 'Hard');

        $isMockupFlow = $request->input('source') === 'mockup' || $request->boolean('from_mockup');
        $isPartOfFullTest = $meeting->test_number !== null;

        $questionsQuery = SatMathQuestion::where('meeting_id', $meeting->id)
            ->where('type', $type);

        if ($meeting->module_number === 2 && $isMockupFlow) {
            $stageCount = (clone $questionsQuery)->where('stage', $currentStage)->count();
            if ($stageCount > 0) {
                $questionsQuery->where('stage', $currentStage);
            }
        }

        $questions = $questionsQuery->orderBy('question_number')->get();

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $questions->count();

        foreach ($questions as $question) {
            $userAnswer = strtoupper(trim((string) ($answers[$question->id] ?? '')));
            $correctAnswer = strtoupper(trim((string) $question->correct_answer));

            if ($userAnswer !== '' && $userAnswer === $correctAnswer) {
                $correctCount++;
            }
        }

        $scorePercentage = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        SatMathScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'meeting_number' => $meetingNumber,
                'type' => $type,
                'context' => self::CONTEXT,
            ],
            [
                'stage' => ($meeting->module_number === 2 && $isMockupFlow) ? $currentStage : null,
                'score' => round($scorePercentage, 2),
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'answers' => $answers,
            ]
        );

        if ($isMockupFlow && $isPartOfFullTest) {
            // Multistage Adaptive Flow for Digital SAT Math — generalized to any test_number
            if ($meeting->module_number === 1) {
                // If score >= 60%, user goes to Hard module, else Easy module
                $stage = ($correctCount >= ceil($totalQuestions * 0.6)) ? 'Hard' : 'Easy';
                session([$stageSessionKey => $stage]);

                $module2 = $this->findModuleMeeting($meeting->test_number, 2);

                return redirect()->route('assignments.sat.math.practice-test', $module2->meeting_number ?? ($meetingNumber + 1))
                    ->with('info', "Math Modul 1 selesai ({$correctCount}/{$totalQuestions} benar). Berdasarkan performa, Anda dialihkan ke Modul 2 (Jalur {$stage}).");
            }

            if ($meeting->module_number === 2) {
                // SAT Complete! Redirect to final cumulative SAT score report for this test
                return redirect()->route('assignments.sat.score-report', $meeting->test_number)
                    ->with('success', "Selamat! Anda telah menyelesaikan seluruh bagian simulasi Digital SAT (Reading & Writing dan Math).");
            }
        }

        if ($isMockupFlow && !$isPartOfFullTest) {
            return redirect()->route('assignments.sat.math.practice-test', $meetingNumber)
                ->with('success', "Latihan Math selesai! Skor Anda: " . round($scorePercentage) . "% ({$correctCount}/{$totalQuestions} Benar). Latihan ini bersifat drill topikal dan tidak masuk ke Score Report 400-1600.");
        }

        $redirectParams = [
            'number' => $meetingNumber,
            ($type === 'review' ? 'review' : 'exercise') => 1,
        ];

        $label = $type === 'review' ? 'Review materi' : 'Latihan practice';
        return redirect()->route('assignments.sat.math.meeting', $redirectParams)
            ->with('success', "{$label} selesai! Skor Anda: " . round($scorePercentage) . "% ({$correctCount}/{$totalQuestions} Benar)");
    }

    /**
     * Check whether the user has finished both modules of the given test
     * (Reading & Writing Module 1-2, Math Module 1-2). The score report
     * combines all four into one number, so showing it before every module
     * is done would silently treat unattempted modules as a score of 0/200,
     * misrepresenting an in-progress attempt as a final result. Only
     * test_numbers with a real module1+module2 pair can ever satisfy this —
     * drills (test_number=null) never do. Callers should let admins/teachers
     * bypass this check so staff can preview the report while testing.
     */
    private function hasCompletedFullSatMockup(int $userId, int $testNumber): bool
    {
        $rwModules = \App\Models\SatReadingWritingMeeting::where('context', self::CONTEXT)
            ->where('test_number', $testNumber)
            ->get();
        $mathModules = SatMathMeeting::where('context', self::CONTEXT)
            ->where('test_number', $testNumber)
            ->get();

        if ($rwModules->count() < 2 || $mathModules->count() < 2) {
            return false;
        }

        foreach ($rwModules as $rwModule) {
            if (!\App\Models\SatReadingWritingScore::where('user_id', $userId)
                ->where('meeting_number', $rwModule->meeting_number)
                ->where('context', self::CONTEXT)
                ->exists()) {
                return false;
            }
        }

        foreach ($mathModules as $mathModule) {
            if (!SatMathScore::where('user_id', $userId)
                ->where('meeting_number', $mathModule->meeting_number)
                ->where('type', 'practice')
                ->where('context', self::CONTEXT)
                ->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Combines the test's four modules (RW 1-2, Math 1-2) into the Digital
     * SAT's 400-1600 scaled score. Shared by the on-screen report and the
     * PDF export so the two can never silently drift apart.
     */
    private function computeSatScoreReportData(int $userId, int $testNumber): array
    {
        $rwModule1Meeting = \App\Models\SatReadingWritingMeeting::where('context', self::CONTEXT)->where('test_number', $testNumber)->where('module_number', 1)->first();
        $rwModule2Meeting = \App\Models\SatReadingWritingMeeting::where('context', self::CONTEXT)->where('test_number', $testNumber)->where('module_number', 2)->first();
        $mathModule1Meeting = SatMathMeeting::where('context', self::CONTEXT)->where('test_number', $testNumber)->where('module_number', 1)->first();
        $mathModule2Meeting = SatMathMeeting::where('context', self::CONTEXT)->where('test_number', $testNumber)->where('module_number', 2)->first();

        // Reading & Writing Scores
        $rwScore1 = $rwModule1Meeting ? \App\Models\SatReadingWritingScore::where('user_id', $userId)->where('meeting_number', $rwModule1Meeting->meeting_number)->where('context', self::CONTEXT)->first() : null;
        $rwScore2 = $rwModule2Meeting ? \App\Models\SatReadingWritingScore::where('user_id', $userId)->where('meeting_number', $rwModule2Meeting->meeting_number)->where('context', self::CONTEXT)->first() : null;

        $rwM1Correct = $rwScore1 ? $rwScore1->correct_count : 0;
        $rwM1Total = $rwScore1 ? $rwScore1->total_questions : 27;
        $rwM2Correct = $rwScore2 ? $rwScore2->correct_count : 0;
        $rwM2Total = $rwScore2 ? $rwScore2->total_questions : 27;

        $rwTotalCorrect = $rwM1Correct + $rwM2Correct;
        $rwTotalQuestions = $rwM1Total + $rwM2Total;

        // Adaptive stage RW — recomputed from Module 1 performance (the single
        // source of truth), not trusted from session.
        $rwStage = $rwM1Correct >= ceil($rwM1Total * 0.6) ? 'Hard' : 'Easy';

        // Digital SAT RW scaled score (200 - 800) based on stage and correct answers
        if ($rwTotalQuestions > 0) {
            $rwRatio = $rwTotalCorrect / $rwTotalQuestions;
            if ($rwStage === 'Hard') {
                $rwScaledScore = round(480 + ($rwRatio * 320));
            } else {
                $rwScaledScore = round(200 + ($rwRatio * 400));
            }
        } else {
            $rwScaledScore = 200;
        }
        $rwScaledScore = min(800, max(200, (int) $rwScaledScore));

        // Math Scores
        $mathScore1 = $mathModule1Meeting ? SatMathScore::where('user_id', $userId)->where('meeting_number', $mathModule1Meeting->meeting_number)->where('type', 'practice')->where('context', self::CONTEXT)->first() : null;
        $mathScore2 = $mathModule2Meeting ? SatMathScore::where('user_id', $userId)->where('meeting_number', $mathModule2Meeting->meeting_number)->where('type', 'practice')->where('context', self::CONTEXT)->first() : null;

        $mathM1Correct = $mathScore1 ? $mathScore1->correct_count : 0;
        $mathM1Total = $mathScore1 ? $mathScore1->total_questions : 22;
        $mathM2Correct = $mathScore2 ? $mathScore2->correct_count : 0;
        $mathM2Total = $mathScore2 ? $mathScore2->total_questions : 22;

        $mathTotalCorrect = $mathM1Correct + $mathM2Correct;
        $mathTotalQuestions = $mathM1Total + $mathM2Total;

        // Adaptive stage Math (>= 60% of Module 1 questions is the cut-off)
        $mathStage = $mathM1Correct >= ceil($mathM1Total * 0.6) ? 'Hard' : 'Easy';

        // Digital SAT Math scaled score (200 - 800) based on stage and correct answers
        if ($mathTotalQuestions > 0) {
            $mathRatio = $mathTotalCorrect / $mathTotalQuestions;
            if ($mathStage === 'Hard') {
                $mathScaledScore = round(480 + ($mathRatio * 320));
            } else {
                $mathScaledScore = round(200 + ($mathRatio * 400));
            }
        } else {
            $mathScaledScore = 200;
        }
        $mathScaledScore = min(800, max(200, (int) $mathScaledScore));

        $totalSatScore = $rwScaledScore + $mathScaledScore;

        $rwModule1MeetingNumber = $rwModule1Meeting->meeting_number ?? 1;
        $rwModule2MeetingNumber = $rwModule2Meeting->meeting_number ?? 2;
        $mathModule1MeetingNumber = $mathModule1Meeting->meeting_number ?? 1;
        $mathModule2MeetingNumber = $mathModule2Meeting->meeting_number ?? 2;

        return compact(
            'testNumber',
            'rwModule1MeetingNumber',
            'rwModule2MeetingNumber',
            'mathModule1MeetingNumber',
            'mathModule2MeetingNumber',
            'rwScaledScore',
            'mathScaledScore',
            'totalSatScore',
            'rwM1Correct',
            'rwM1Total',
            'rwM2Correct',
            'rwM2Total',
            'rwTotalCorrect',
            'rwTotalQuestions',
            'rwStage',
            'mathM1Correct',
            'mathM1Total',
            'mathM2Correct',
            'mathM2Total',
            'mathTotalCorrect',
            'mathTotalQuestions',
            'mathStage'
        );
    }

    /**
     * Display the cumulative Digital SAT Score Report (400 - 1600) for one test.
     */
    public function scoreReport(int $testNumber)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isTeacher() && !$this->hasCompletedFullSatMockup($user->id, $testNumber)) {
            return redirect()->route('assignments.sat')
                ->with('error', 'Selesaikan keempat modul (Reading & Writing Modul 1-2, Math Modul 1-2) terlebih dahulu sebelum melihat Score Report.');
        }

        return view('assignments.sat.score-report', $this->computeSatScoreReportData($user->id, $testNumber));
    }

    /**
     * Download the Digital SAT practice score estimate as a PDF for one test.
     */
    public function downloadScoreReportPdf(Request $request, int $testNumber)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isTeacher() && !$this->hasCompletedFullSatMockup($user->id, $testNumber)) {
            return redirect()->route('assignments.sat')
                ->with('error', 'Selesaikan keempat modul (Reading & Writing Modul 1-2, Math Modul 1-2) terlebih dahulu sebelum mengunduh Score Report.');
        }

        $reportData = $this->computeSatScoreReportData($user->id, $testNumber);
        extract($reportData);

        // Fetch official settings from Certificates & Score Reports feature
        $certificate = \App\Models\FreeTestCertificate::where('test_type', 'sat_digital')->first();

        $signatureBase64 = null;
        if (!empty($certificate?->template_config['signature_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($certificate->template_config['signature_image'])) {
            $sigPath = \Illuminate\Support\Facades\Storage::disk('public')->path($certificate->template_config['signature_image']);
            $sigData = @file_get_contents($sigPath);
            if ($sigData) {
                $sigMime = @mime_content_type($sigPath) ?: 'image/png';
                $signatureBase64 = 'data:' . $sigMime . ';base64,' . base64_encode($sigData);
            }
        }

        $logoBase64 = null;
        $logoPath = public_path('images/brand/target-bahasa-logo1.png');
        if (file_exists($logoPath)) {
            $logoData = @file_get_contents($logoPath);
            if ($logoData) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $registrationId = 'TB-SAT-' . date('Y') . '-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-T' . $testNumber;
        $testDate = now()->translatedFormat('d F Y, H:i');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('assignments.sat.score-report-pdf', compact(
            'user',
            'certificate',
            'registrationId',
            'testDate',
            'totalSatScore',
            'rwScaledScore',
            'mathScaledScore',
            'rwM1Correct',
            'rwM1Total',
            'rwM2Correct',
            'rwM2Total',
            'rwTotalCorrect',
            'rwTotalQuestions',
            'mathM1Correct',
            'mathM1Total',
            'mathM2Correct',
            'mathM2Total',
            'mathTotalCorrect',
            'mathTotalQuestions',
            'signatureBase64',
            'logoBase64'
        ))->setPaper('a4', 'portrait');

        $safeName = \Illuminate\Support\Str::slug($user->name ?: 'Student', '_');
        return $pdf->download("SAT_Estimasi_Skor_Latihan_{$safeName}_Test{$testNumber}.pdf");
    }

    /**
     * Toggle lock status for admin/teacher.
     */
    public function toggleLock(SatMathMeeting $meeting)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }

        $meeting->update(['is_locked' => !$meeting->is_locked]);

        return back()->with('success', 'Status kunci berhasil diubah.');
    }

    /**
     * Generate an in-depth AI tutor explanation for an SAT question (Reading/Writing or Math).
     */
    public function getAiExplanation(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer',
            'section_type' => 'required|string|in:math,reading_writing,rw',
            'user_answer' => 'nullable|string',
            'question_number' => 'nullable|integer',
        ]);

        $questionId = $request->integer('question_id');
        $sectionType = strtolower($request->input('section_type'));
        $userAnswer = strtoupper(trim((string)$request->input('user_answer', '')));
        $questionNumber = $request->input('question_number', 1);

        $cacheKey = "sat_ai_explanation_{$sectionType}_{$questionId}_ans_{$userAnswer}";
        $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);
        if ($cached) {
            return response()->json($cached);
        }

        if (in_array($sectionType, ['reading_writing', 'rw'])) {
            $question = \App\Models\SatReadingWritingQuestion::find($questionId);
            $sectionLabel = 'Digital SAT Reading and Writing';
        } else {
            $question = SatMathQuestion::find($questionId);
            $sectionLabel = 'Digital SAT Mathematics';
        }

        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan.',
            ], 404);
        }

        $passage = !empty($question->passage) ? $question->passage : '';
        $promptText = !empty($question->question_prompt) ? $question->question_prompt : ($question->prompt ?? '');
        $options = [
            'A' => $question->option_a ?? '',
            'B' => $question->option_b ?? '',
            'C' => $question->option_c ?? '',
            'D' => $question->option_d ?? '',
        ];
        $correctAnswer = strtoupper(trim((string)$question->correct_answer));
        $officialExplanation = $question->explanation ?? '';

        $systemPrompt = "Anda adalah Tutor Ahli Digital SAT (Official Digital SAT Expert Tutor) dari Target Bahasa.
Tugas Anda adalah memberikan penjelasan edukatif, ramah, dan sangat mendalam kepada siswa dalam Bahasa Indonesia untuk soal {$sectionLabel}.
PANDUAN STRUKTUR RESPON:
1. 💡 **Konsep Inti & Ringkasan Soal**: Jelaskan secara singkat apa yang sebenarnya diuji oleh soal ini.
2. 🎯 **Mengapa Opsi {$correctAnswer} Benar**: Berikan analisis logis langkah demi langkah mengapa jawaban ini 100% tepat.
3. ⚠️ **Analisis Opsi & Jebakan**:" . ($userAnswer && $userAnswer !== $correctAnswer ? " Khususnya bedah mengapa Opsi {$userAnswer} (yang dipilih siswa) salah/merupakan jebakan (distractor)." : " Jelaskan secara singkat mengapa pilihan lain salah.") . "
4. 🚀 **SAT Tip & Strategi Cepat**: Berikan trik cepat (shortcut/eliminasi/kata kunci) yang bisa langsung diingat siswa untuk menghadapi soal serupa di ujian resmi.

FORMAT:
- Gunakan bahasa Indonesia yang mudah dipahami, lugas, dan menyemangati.
- Jika ada rumus matematika atau simbol matematika, selalu gunakan format LaTeX dengan kurung \( ... \) untuk inline dan \[ ... \] untuk rumus blok.
- Gunakan format Markdown rapi dengan poin-poin dan tebal (bold) untuk penekanan.";

        $userPrompt = "Soal SAT:
" . ($passage ? "Bacaan/Passage:\n\"{$passage}\"\n\n" : "") .
"Pertanyaan:\n{$promptText}\n\n" .
"Pilihan Jawaban:\n" .
"A. {$options['A']}\n" .
"B. {$options['B']}\n" .
"C. {$options['C']}\n" .
"D. {$options['D']}\n\n" .
"Kunci Jawaban Resmi: {$correctAnswer}\n" .
"Jawaban Siswa: " . ($userAnswer ? $userAnswer : "(Tidak dijawab / Kosong)") . "\n" .
($officialExplanation ? "\nPembahasan Resmi Kurikulum:\n{$officialExplanation}\n" : "") .
"\nMohon berikan penjelasan tutor AI yang mendalam dan mudah dipahami sesuai instruksi.";

        $providers = ['gemini', 'groq', 'sambanova', 'cerebras', 'openai'];

        try {
            $result = \App\Services\MultiProviderAiClient::chat($providers, $systemPrompt, $userPrompt, [
                'json_mode' => false,
                'max_tokens' => 2048,
                'temperature' => 0.4,
            ]);

            if (!$result || empty($result['content'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan AI sedang sibuk. Silakan coba beberapa saat lagi.',
                ], 500);
            }

            $responsePayload = [
                'success' => true,
                'explanation' => $result['content'],
                'source' => $result['source'] ?? 'SAT AI Tutor',
                'question_id' => $questionId,
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
            ];

            // Cache for 7 days
            \Illuminate\Support\Facades\Cache::put($cacheKey, $responsePayload, now()->addDays(7));

            return response()->json($responsePayload);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('SAT AI Explanation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses penjelasan AI: ' . $e->getMessage(),
            ], 500);
        }
    }
}
