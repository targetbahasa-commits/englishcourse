<?php

namespace App\Http\Controllers\MockTest;

use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Controller;
use App\Models\SatReadingWritingMeeting;
use App\Models\SatReadingWritingQuestion;
use App\Models\SatReadingWritingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Public Mock Test counterpart to App\Http\Controllers\SatReadingWritingController
 * (which now serves the Assignments flow). Reuses the exact same Blade views
 * (made route-prefix-aware rather than duplicated) and the same Eloquent
 * models, but reads/writes rows scoped to context='mock-test' — fully
 * independent meetings, questions, and scores from the Assignments side,
 * even for the same meeting_number.
 *
 * A "full Digital SAT test" is defined by data (meetings.test_number +
 * module_number), not by hardcoding meeting_number 1/2. A meeting with
 * test_number=null is a standalone topical drill: it scores and shows a
 * result, but never enters the Module 1 -> adaptive Module 2 -> break ->
 * Math -> score report chain, and is never counted toward a 400-1600 score.
 */
class SatReadingWritingController extends Controller
{
    use HandlesAssignmentAccess;

    private const CONTEXT = 'mock-test';

    public function __construct()
    {
        $this->registerAssignmentAccessMiddleware();
    }

    /**
     * Mock Test SAT hub page — lists both Reading & Writing and Math access
     * points. Equivalent of AssignmentController::sat() for this context.
     */
    public function hub()
    {
        $user = Auth::user();

        $allMeetings = SatReadingWritingMeeting::withCount('questions')
            ->where('context', self::CONTEXT)
            ->orderBy('meeting_number')
            ->get();

        $scoresByMeeting = $user
            ? SatReadingWritingScore::where('user_id', $user->id)
                ->where('context', self::CONTEXT)
                ->get()
                ->keyBy('meeting_number')
            : collect();

        $allMeetings->each(function ($meeting) use ($scoresByMeeting) {
            $userScore = $scoresByMeeting->get($meeting->meeting_number);
            $meeting->completed = ($userScore !== null);
            $meeting->user_score = $userScore ? $userScore->score : null;
        });

        $mathModuleMeetingNumbers = $user
            ? \App\Models\SatMathMeeting::where('context', self::CONTEXT)->whereNotNull('test_number')->get(['test_number', 'module_number', 'meeting_number'])
            : collect();

        $mathCompletedMeetingNumbers = $user
            ? \App\Models\SatMathScore::where('user_id', $user->id)
                ->where('context', self::CONTEXT)
                ->where('type', 'practice')
                ->pluck('meeting_number')
                ->all()
            : [];

        $fullTests = $allMeetings->whereNotNull('test_number')
            ->groupBy('test_number')
            ->map(function ($modules, $testNumber) use ($mathModuleMeetingNumbers, $mathCompletedMeetingNumbers) {
                $module1 = $modules->firstWhere('module_number', 1);
                $module2 = $modules->firstWhere('module_number', 2);

                $mathModules = $mathModuleMeetingNumbers->where('test_number', (int) $testNumber);
                $mathDone = $mathModules->isNotEmpty() && $mathModules->every(
                    fn ($m) => in_array($m->meeting_number, $mathCompletedMeetingNumbers, true)
                );

                return (object) [
                    'test_number' => $testNumber,
                    'module1' => $module1,
                    'module2' => $module2,
                    'title' => $module1->title ?? "Digital SAT Practice Test {$testNumber}",
                    'description' => $module1->description ?? null,
                    'is_locked' => (bool) ($module1->is_locked ?? false),
                    'rw_completed' => (bool) ($module2->completed ?? false),
                    'score_report_available' => (bool) ($module2->completed ?? false) && $mathDone,
                ];
            })
            ->sortKeys()
            ->values();

        $drills = $allMeetings->whereNull('test_number')->values();

        return view('mock-test.sat.index', [
            'fullTests' => $fullTests,
            'drills' => $drills,
        ]);
    }

    /**
     * Display the list of SAT Reading & Writing meetings/lessons.
     */
    public function index()
    {
        $user = Auth::user();

        $meetings = SatReadingWritingMeeting::withCount('questions')
            ->where('context', self::CONTEXT)
            ->orderBy('meeting_number')
            ->get();

        $scoresByMeeting = $user
            ? SatReadingWritingScore::where('user_id', $user->id)
                ->where('context', self::CONTEXT)
                ->get()
                ->keyBy('meeting_number')
            : collect();

        $meetings->each(function ($meeting) use ($scoresByMeeting) {
            $userScore = $scoresByMeeting->get($meeting->meeting_number);
            $meeting->completed = ($userScore !== null);
            $meeting->user_score = $userScore ? $userScore->score : null;
        });

        return view('assignments.sat.reading-writing', [
            'meetings' => $meetings,
        ]);
    }

    /**
     * Show a specific SAT Reading & Writing meeting with selection cards or category practice.
     */
    public function showMeeting(Request $request, int $number)
    {
        $user = Auth::user();

        if ($request->has('retry')) {
            SatReadingWritingScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where('context', self::CONTEXT)
                ->delete();

            $redirectParams = ['number' => $number];
            if ($request->filled('category')) {
                $redirectParams['category'] = $request->input('category');
            }

            return redirect()->route('mock-test.sat.reading-writing.meeting', $redirectParams)
                ->with('info', 'Latihan telah direset. Silakan kerjakan kembali.');
        }

        $meeting = SatReadingWritingMeeting::with(['questions' => function ($query) {
            $query->orderBy('question_number');
        }])->where('meeting_number', $number)->where('context', self::CONTEXT)->firstOrFail();

        if ($meeting->is_locked && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('mock-test.sat.reading-writing')
                ->with('error', 'Meeting ini saat ini terkunci.');
        }

        $existingScore = SatReadingWritingScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->where('context', self::CONTEXT)
            ->first();

        // Mapping slug to category names
        $categoryMap = [
            'words-in-context' => 'Words in Context',
            'text-structure-and-purpose' => 'Text Structure and Purpose',
            'cross-text-connections' => 'Cross-Text Connections',
        ];

        $categorySlug = $request->query('category');

        // IF a category is requested (e.g. ?category=words-in-context or ?category=all), show the question practice page
        if ($categorySlug) {
            $currentCategoryName = null;
            if ($categorySlug !== 'all' && isset($categoryMap[$categorySlug])) {
                $currentCategoryName = $categoryMap[$categorySlug];
                $questions = $meeting->questions->filter(function ($q) use ($currentCategoryName) {
                    return trim($q->category) === $currentCategoryName;
                })->values();
            } else {
                $questions = $meeting->questions;
            }

            return view('assignments.sat.reading-writing-meeting', [
                'meeting' => $meeting,
                'questions' => $questions,
                'existingScore' => $existingScore,
                'categorySlug' => $categorySlug,
                'currentCategoryName' => $currentCategoryName,
            ]);
        }

        // DEFAULT: Show Selection Page with 3 Cards
        $subCategories = [
            [
                'slug' => 'words-in-context',
                'title' => 'Words in Context',
                'sublabel' => 'Sub-Skill 1',
                'desc' => 'Menentukan arti kata atau frasa berdasarkan konteks kalimat atau paragraf sastra dan sains.',
                'count' => $meeting->questions->where('category', 'Words in Context')->count(),
                'range' => '1 - 10',
                'gradient' => 'bg-gradient-to-br from-blue-600 to-indigo-700',
            ],
            [
                'slug' => 'text-structure-and-purpose',
                'title' => 'Text Structure & Purpose',
                'sublabel' => 'Sub-Skill 2',
                'desc' => 'Menganalisis tujuan utama penulis, sudut pandang, serta struktur argumen dalam kutipan teks.',
                'count' => $meeting->questions->where('category', 'Text Structure and Purpose')->count(),
                'range' => '11 - 20',
                'gradient' => 'bg-gradient-to-br from-indigo-600 to-violet-700',
            ],
            [
                'slug' => 'cross-text-connections',
                'title' => 'Cross-Text Connections',
                'sublabel' => 'Sub-Skill 3',
                'desc' => 'Membandingkan dan menghubungkan dua teks pendek (Text 1 & Text 2) dengan sudut pandang berbeda.',
                'count' => $meeting->questions->where('category', 'Cross-Text Connections')->count(),
                'range' => '21 - 27',
                'gradient' => 'bg-gradient-to-br from-violet-600 to-purple-700',
            ],
        ];

        return view('assignments.sat.reading-writing-selection', [
            'meeting' => $meeting,
            'subCategories' => $subCategories,
            'totalQuestionsCount' => $meeting->questions->count(),
            'overallScore' => $existingScore,
        ]);
    }

    /**
     * Finds the sibling meeting for a given test_number + module_number, or
     * null if this test doesn't have that module (e.g. a drill has neither).
     */
    private function findModuleMeeting(?int $testNumber, int $moduleNumber): ?SatReadingWritingMeeting
    {
        if ($testNumber === null) {
            return null;
        }

        return SatReadingWritingMeeting::where('context', self::CONTEXT)
            ->where('test_number', $testNumber)
            ->where('module_number', $moduleNumber)
            ->first();
    }

    /**
     * Display the full Digital SAT Mockup Test (CBT Exam Interface).
     */
    public function practiceTest(Request $request, int $number)
    {
        $user = Auth::user();
        $isStaff = $user->isAdmin() || $user->isTeacher();

        $meeting = SatReadingWritingMeeting::where('meeting_number', $number)->where('context', self::CONTEXT)->firstOrFail();
        $stageSessionKey = 'mock_test_sat_rw_stage_test_' . ($meeting->test_number ?? $number);

        // Allow Admin or Teacher to override stage via query parameter (e.g. ?stage=Easy or ?stage=Hard)
        if ($isStaff && $request->filled('stage')) {
            $requestedStage = ucfirst(strtolower((string) $request->query('stage')));
            $newStage = in_array($requestedStage, ['Hard', 'Easy'], true) ? $requestedStage : 'Hard';
            session([$stageSessionKey => $newStage]);
        }

        $currentStage = session($stageSessionKey, 'Hard');

        if ($request->has('retry')) {
            SatReadingWritingScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->where('context', self::CONTEXT)
                ->delete();

            if ($meeting->test_number !== null) {
                $siblingMath = \App\Models\SatMathMeeting::where('context', self::CONTEXT)
                    ->where('test_number', $meeting->test_number)
                    ->get();
                \App\Models\SatMathScore::where('user_id', $user->id)
                    ->whereIn('meeting_number', $siblingMath->pluck('meeting_number'))
                    ->where('context', self::CONTEXT)
                    ->delete();
            }

            return redirect()->route('mock-test.sat.practice-test', $number)
                ->with('info', 'Practice Test telah direset. Silakan mulai simulasi dari awal.');
        }

        if ($meeting->is_locked && !$isStaff) {
            return redirect()->route('mock-test.sat')
                ->with('error', 'Practice Test ini saat ini terkunci.');
        }

        // Module 2 may only be entered after Module 1 of the same test is done —
        // otherwise the adaptive stage has no real basis and defaults blindly.
        if ($meeting->module_number === 2 && !$isStaff) {
            $module1 = $this->findModuleMeeting($meeting->test_number, 1);
            $module1Done = $module1 && SatReadingWritingScore::where('user_id', $user->id)
                ->where('meeting_number', $module1->meeting_number)
                ->where('context', self::CONTEXT)
                ->exists();

            if (!$module1Done) {
                return redirect()->route('mock-test.sat.practice-test', $module1->meeting_number ?? $number)
                    ->with('error', 'Selesaikan Module 1 terlebih dahulu — Module 2 ditentukan berdasarkan hasil Module 1.');
            }
        }

        // For Module 2, load questions matching the active adaptive stage (Hard vs Easy)
        $questionsQuery = $meeting->questions();
        if ($meeting->module_number === 2) {
            // Check if questions with the specific stage exist
            $stageCount = (clone $questionsQuery)->where('stage', $currentStage)->count();
            if ($stageCount > 0) {
                $questionsQuery->where('stage', $currentStage);
            }
        }
        $questions = $questionsQuery->orderBy('question_number')->get();

        $existingScore = SatReadingWritingScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->where('context', self::CONTEXT)
            ->first();

        return view('assignments.sat.mockup', [
            'meeting' => $meeting,
            'questions' => $questions,
            'existingScore' => $existingScore,
            'practiceNumber' => $number,
            'activeStage' => $currentStage,
            'testNumber' => $meeting->test_number,
            'isFullTest' => $meeting->test_number !== null,
        ]);
    }

    /**
     * Display the 10-Minute Break Screen between Section 1 (RW) and Section 2 (Math).
     */
    public function breakScreen(int $testNumber)
    {
        $mathModule1 = \App\Models\SatMathMeeting::where('context', self::CONTEXT)
            ->where('test_number', $testNumber)
            ->where('module_number', 1)
            ->first();

        return view('assignments.sat.break', [
            'testNumber' => $testNumber,
            'mathModule1MeetingNumber' => $mathModule1->meeting_number ?? 1,
        ]);
    }

    /**
     * Submit answers for a meeting and calculate score.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'meeting_number' => 'required|integer',
        ]);

        $user = Auth::user();
        $meetingNumber = $request->integer('meeting_number');

        $meeting = SatReadingWritingMeeting::where('meeting_number', $meetingNumber)
            ->where('context', self::CONTEXT)
            ->firstOrFail();

        $stageSessionKey = 'mock_test_sat_rw_stage_test_' . ($meeting->test_number ?? $meetingNumber);
        $currentStage = session($stageSessionKey, 'Hard');

        // For Module 2, score against questions belonging to the active stage
        $questionsQuery = $meeting->questions();
        if ($meeting->module_number === 2) {
            $stageCount = (clone $questionsQuery)->where('stage', $currentStage)->count();
            if ($stageCount > 0) {
                $questionsQuery->where('stage', $currentStage);
            }
        }
        $meetingQuestions = $questionsQuery->get();

        $totalQuestions = $meetingQuestions->count();
        if ($totalQuestions === 0) {
            return back()->with('error', 'Tidak ada soal dalam meeting ini.');
        }

        $correctCount = 0;
        $submittedAnswers = [];

        foreach ($meetingQuestions as $question) {
            $submitted = $request->input('question_' . $question->id);
            if ($submitted !== null && $submitted !== '') {
                $submitted = strtoupper(trim((string) $submitted));
                $submittedAnswers[$question->id] = $submitted;

                if ($submitted === strtoupper(trim((string) $question->correct_answer))) {
                    $correctCount++;
                }
            } else {
                $submittedAnswers[$question->id] = null;
            }
        }

        // Fetch existing answers to merge if taking category by category
        $existingRecord = SatReadingWritingScore::where('user_id', $user->id)
            ->where('meeting_number', $meetingNumber)
            ->where('context', self::CONTEXT)
            ->first();

        $mergedAnswers = $existingRecord ? ($existingRecord->answers ?? []) : [];
        foreach ($submittedAnswers as $qid => $ans) {
            if ($ans !== null) {
                $mergedAnswers[$qid] = $ans;
            }
        }

        // Recalculate total correct count across all answered questions for this meeting/stage
        $overallCorrectCount = 0;
        foreach ($meetingQuestions as $q) {
            $ans = $mergedAnswers[$q->id] ?? null;
            if ($ans && strtoupper(trim((string) $ans)) === strtoupper(trim((string) $q->correct_answer))) {
                $overallCorrectCount++;
            }
        }
        $overallScore = round(($overallCorrectCount / $totalQuestions) * 100, 2);

        SatReadingWritingScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'meeting_number' => $meetingNumber,
                'context' => self::CONTEXT,
            ],
            [
                'stage' => $meeting->module_number === 2 ? $currentStage : null,
                'score' => $overallScore,
                'correct_count' => $overallCorrectCount,
                'total_questions' => $totalQuestions,
                'answers' => $mergedAnswers,
            ]
        );

        $isMockupFlow = $request->input('source') === 'mockup' || $request->boolean('from_mockup');
        $isPartOfFullTest = $meeting->test_number !== null;

        if ($isMockupFlow && $isPartOfFullTest) {
            // Multistage Adaptive Flow for Digital SAT — generalized to any test_number
            if ($meeting->module_number === 1) {
                // Determine stage based on performance: >= 60% is Hard stage, < 60% is Easy stage
                $stage = ($overallCorrectCount >= ceil($totalQuestions * 0.6)) ? 'Hard' : 'Easy';
                session([$stageSessionKey => $stage]);

                $module2 = $this->findModuleMeeting($meeting->test_number, 2);

                return redirect()->route('mock-test.sat.practice-test', $module2->meeting_number ?? ($meetingNumber + 1))
                    ->with('info', "Reading & Writing Modul 1 selesai ({$overallCorrectCount}/{$totalQuestions} benar). Berdasarkan performa, Anda dialihkan ke Modul 2 (Jalur {$stage}).");
            }

            if ($meeting->module_number === 2) {
                // Section 1 complete! Transition to 10-minute break screen before Section 2: Math
                return redirect()->route('mock-test.sat.break', $meeting->test_number)
                    ->with('success', "Section 1 (Reading and Writing) telah selesai! Silakan ambil istirahat 10 menit sebelum memulai Section 2: Math.");
            }
        }

        if ($isMockupFlow && !$isPartOfFullTest) {
            // Standalone topical drill — not part of a full adaptive test, so it
            // never chains into Module 2 / break / Math / the 400-1600 report.
            return redirect()->route('mock-test.sat.practice-test', $meetingNumber)
                ->with('success', "Latihan selesai! Skor Anda: {$overallScore}% ({$overallCorrectCount}/{$totalQuestions} benar). Latihan ini bersifat drill topikal dan tidak masuk ke Score Report 400-1600.");
        }

        $redirectParams = ['number' => $meetingNumber];
        if ($request->filled('category')) {
            $redirectParams['category'] = $request->input('category');
        }

        return redirect()->route('mock-test.sat.reading-writing.meeting', $redirectParams)
            ->with('success', "Jawaban berhasil dikirim! Skor Anda: {$overallScore}% ({$overallCorrectCount}/{$totalQuestions} benar).");
    }

    /**
     * Admin: Store new meeting.
     */
    public function storeMeeting(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'meeting_number' => [
                'required',
                'integer',
                \Illuminate\Validation\Rule::unique('sat_reading_writing_meetings', 'meeting_number')->where('context', self::CONTEXT),
            ],
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_locked' => 'nullable|boolean',
        ]);

        $validated['is_locked'] = $request->boolean('is_locked');
        $validated['context'] = self::CONTEXT;

        SatReadingWritingMeeting::create($validated);

        return back()->with('success', 'Practice test SAT berhasil ditambahkan.');
    }

    /**
     * Admin: Toggle lock status of meeting.
     */
    public function toggleLock(SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $meeting->update([
            'is_locked' => !$meeting->is_locked,
        ]);

        return back()->with('success', 'Status kunci practice test berhasil diperbarui.');
    }

    /**
     * Admin: Update meeting info.
     */
    public function updateMeeting(Request $request, SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $meeting->update($validated);

        return back()->with('success', 'Data practice test berhasil diperbarui.');
    }

    /**
     * Admin: Delete meeting.
     */
    public function destroyMeeting(SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $meeting->delete();

        return back()->with('success', 'Practice test berhasil dihapus.');
    }

    /**
     * Admin: Store Question.
     */
    public function storeQuestion(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'meeting_id' => 'required|exists:sat_reading_writing_meetings,id',
            'question_number' => 'required|integer',
            'category' => 'nullable|string|max:100',
            'passage' => 'nullable|string',
            'question_prompt' => 'nullable|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|string|max:10',
            'explanation' => 'nullable|string',
        ]);

        $validated['correct_answer'] = strtoupper(trim($validated['correct_answer']));

        SatReadingWritingQuestion::create($validated);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Admin: Update Question.
     */
    public function updateQuestion(Request $request, SatReadingWritingQuestion $question)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'question_number' => 'required|integer',
            'category' => 'nullable|string|max:100',
            'passage' => 'nullable|string',
            'question_prompt' => 'nullable|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|string|max:10',
            'explanation' => 'nullable|string',
        ]);

        $validated['correct_answer'] = strtoupper(trim($validated['correct_answer']));

        $question->update($validated);

        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Admin: Delete Question.
     */
    public function destroyQuestion(SatReadingWritingQuestion $question)
    {
        $this->ensureAdmin();

        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Akses terbatas untuk administrator.');
        }
    }
}
