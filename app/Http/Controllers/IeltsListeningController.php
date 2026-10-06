<?php

namespace App\Http\Controllers;

use App\Application\IeltsListening\BuildIeltsListeningIndexData;
use App\Application\IeltsListening\BuildIeltsListeningMaterialData;
use App\Application\IeltsListening\BuildIeltsListeningPracticeIndexData;
use App\Application\IeltsListening\BuildIeltsListeningWarmUpData;
use App\Application\IeltsListening\PrepareIeltsListeningPracticeData;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\ResolvesAuthenticatedUser;
use App\Http\Controllers\Concerns\EvaluatesClassPeriodEnd;
use App\Models\IeltsListeningPracticeResult;
use App\Models\IeltsListeningPracticeDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IeltsListeningController extends Controller
{
    use HandlesAssignmentAccess;
    use ResolvesAuthenticatedUser;
    use EvaluatesClassPeriodEnd;

    public function __construct(
        private readonly BuildIeltsListeningIndexData $buildIeltsListeningIndexData,
        private readonly BuildIeltsListeningMaterialData $buildIeltsListeningMaterialData,
        private readonly BuildIeltsListeningPracticeIndexData $buildIeltsListeningPracticeIndexData,
        private readonly BuildIeltsListeningWarmUpData $buildIeltsListeningWarmUpData,
        private readonly PrepareIeltsListeningPracticeData $prepareIeltsListeningPracticeData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        $data = $this->buildIeltsListeningIndexData->handle(Auth::user());
        $data['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');

        return view('assignments.ielts.listening.index', $data);
    }

    public function practiceIndex()
    {
        $data = $this->buildIeltsListeningPracticeIndexData->handle();

        $userPartStats = [];
        if (Auth::check()) {
            $results = \App\Models\IeltsListeningPracticeResult::where('user_id', Auth::id())
                ->get()
                ->groupBy('part');

            for ($p = 1; $p <= 4; $p++) {
                $partGroup = $results->get($p, collect());
                $userPartStats[$p] = [
                    'completed_count' => $partGroup->count(),
                    'total_tests' => 50,
                    'avg_band' => $partGroup->isNotEmpty() ? round((float) $partGroup->avg('band_score'), 1) : null,
                ];
            }
        }
        $data['userPartStats'] = $userPartStats;

        return view('assignments.ielts.listening.practice-index', $data);
    }

    public function material(Request $request, int $id)
    {
        $data = $this->buildIeltsListeningMaterialData->material($id, (int) $request->get('practice', 1));
        if (is_array($data)) {
            $data['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');
        }

        return view('assignments.ielts.listening.material', $data);
    }

    public function warmUp(Request $request, string $type)
    {
        return view(
            'assignments.ielts.listening.warmup.' . $type,
            $this->buildIeltsListeningWarmUpData->handle($type, (int) $request->get('practice', 1))
        );
    }

    public function practiceIndexPart(int $set)
    {
        $validParts = [1, 2, 3, 4];

        if (!in_array($set, $validParts, true)) {
            abort(404);
        }

        $studentResults = Auth::check()
            ? IeltsListeningPracticeResult::where('user_id', Auth::id())->where('part', $set)->get()->keyBy('test_id')
            : collect();

        return view('assignments.ielts.listening.part1-practice', [
            'set' => $set,
            'studentResults' => $studentResults,
        ]);
    }

    public function practiceIndexTest(int $set, int $test)
    {
        if (request()->query('retry') == '1' && Auth::check()) {
            IeltsListeningPracticeResult::where('user_id', Auth::id())
                ->where('part', $set)
                ->where('test_id', $test)
                ->delete();
            IeltsListeningPracticeDraft::where('user_id', Auth::id())
                ->where('part', $set)
                ->where('test_id', $test)
                ->delete();
            return redirect()->route('assignments.ielts-academic.listening.practice-index.test', ['set' => $set, 'test' => $test]);
        }

        $existingResult = Auth::check()
            ? IeltsListeningPracticeResult::where('user_id', Auth::id())->where('part', $set)->where('test_id', $test)->first()
            : null;
        $draft = (Auth::check() && !$existingResult)
            ? IeltsListeningPracticeDraft::where('user_id', Auth::id())->where('part', $set)->where('test_id', $test)->first()
            : null;

        $data = $this->prepareIeltsListeningPracticeData->createPracticeIndexTestMeeting($set);
        $data['testId'] = $test;
        $data['existingResult'] = $existingResult;
        $data['draftAnswers'] = $draft?->answers_data ?? [];
        $data['answerKeys'] = $this->extractAnswerKeys($set, $test, $data['section'] ?? null);

        return view('assignments.ielts.listening.test-practice', $data);
    }

    public function showPractice(int $meetingId, int $set, ?int $partNumber = null)
    {
        $user = $this->authenticatedUser();
        $data = $this->prepareIeltsListeningPracticeData->ensurePracticeMeetingIsAccessible(
            $meetingId,
            $set,
            $partNumber,
            $user,
        );

        if ($user && $data['isLocked'] && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.ielts-academic.listening.index')->with('error', 'This practice test is currently locked.');
        }

        unset($data['isLocked']);

        $studentResults = Auth::check()
            ? IeltsListeningPracticeResult::where('user_id', Auth::id())->where('part', $set)->get()->keyBy('test_id')
            : collect();
        $data['studentResults'] = $studentResults;

        return view('assignments.ielts.listening.part1-practice', $data);
    }

    public function showPracticeTest(int $meetingId, int $set, int $testId, ?int $partNumber = null)
    {
        if (request()->query('retry') == '1' && Auth::check()) {
            IeltsListeningPracticeResult::where('user_id', Auth::id())
                ->where('part', $set)
                ->where('test_id', $testId)
                ->delete();
            IeltsListeningPracticeDraft::where('user_id', Auth::id())
                ->where('part', $set)
                ->where('test_id', $testId)
                ->delete();
            return redirect()->route('assignments.ielts-academic.listening.part1.practice.test', [
                'meeting' => $meetingId,
                'set' => $set,
                'testId' => $testId,
            ]);
        }

        $user = $this->authenticatedUser();
        $data = $this->prepareIeltsListeningPracticeData->ensurePracticeTestIsAccessible(
            $meetingId,
            $set,
            $testId,
            $partNumber,
            $user,
        );

        if ($user && $data['isLocked'] && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.ielts-academic.listening.index')->with('error', 'This practice test is currently locked.');
        }

        unset($data['isLocked']);

        $existingResult = Auth::check()
            ? IeltsListeningPracticeResult::where('user_id', Auth::id())->where('part', $set)->where('test_id', $testId)->first()
            : null;
        $draft = (Auth::check() && !$existingResult)
            ? IeltsListeningPracticeDraft::where('user_id', Auth::id())->where('part', $set)->where('test_id', $testId)->first()
            : null;

        $data['existingResult'] = $existingResult;
        $data['draftAnswers'] = $draft?->answers_data ?? [];
        $data['answerKeys'] = $this->extractAnswerKeys($set, $testId, $data['section'] ?? null);

        return view('assignments.ielts.listening.test-practice', $data);
    }

    private function extractAnswerKeys(int $set, int $testId, $section = null): array
    {
        $keys = [];

        $viewName = "assignments.ielts.listening.answers.part{$set}.test{$testId}";
        if (view()->exists($viewName)) {
            $rendered = view($viewName)->render();
            preg_match_all('/Soal\s+(\d+)<\/span>\s*<span[^>]*>(.*?)<\/span>/i', $rendered, $matches, PREG_SET_ORDER);
            foreach ($matches as $m) {
                $qNum = (int)$m[1];
                $ansText = trim(strip_tags($m[2]));
                $keys[$qNum] = $ansText;
            }
        }

        if (empty($keys) && $section && filled($section->answer_key)) {
            $lines = explode("\n", str_replace("\r\n", "\n", trim($section->answer_key)));
            foreach ($lines as $line) {
                $line = trim($line);
                if (preg_match('/^(\d+)[\.\)]\s*(.*)$/', $line, $m)) {
                    $keys[(int)$m[1]] = trim($m[2]);
                }
            }
        }

        return $keys;
    }

    private function checkAnswerMatch(?string $studentAns, ?string $correctAns): bool
    {
        if (empty($studentAns) && empty($correctAns)) return false;
        if (empty($studentAns)) return false;

        $s = strtolower(trim($studentAns));
        $c = strtolower(trim($correctAns));

        if ($s === $c) return true;

        $cNoParen = trim(preg_replace('/\s*\([^)]*\)\s*/', ' ', $c));
        $cNoParen = preg_replace('/\s+/', ' ', $cNoParen);
        if ($s === $cNoParen) return true;

        $cWithParenContent = trim(str_replace(['(', ')'], '', $c));
        $cWithParenContent = preg_replace('/\s+/', ' ', $cWithParenContent);
        if ($s === $cWithParenContent) return true;

        if (str_contains($c, '(') && str_contains($c, ')')) {
            $alt1 = preg_replace('/\((.*?)\)/', '$1', $c);
            $alt2 = preg_replace('/\((.*?)\)/', '', $c);
            if ($s === strtolower(trim($alt1)) || $s === strtolower(trim($alt2))) return true;
        }

        if (str_contains($c, '/')) {
            $parts = explode('/', $c);
            foreach ($parts as $p) {
                $pClean = strtolower(trim($p));
                if ($s === $pClean) return true;
                $pNoParen = trim(preg_replace('/\s*\([^)]*\)\s*/', ' ', $pClean));
                if ($s === $pNoParen) return true;
            }
        }

        return false;
    }

    private function calculateIeltsListeningBand(int $correctCount, int $totalQuestions): string
    {
        if ($totalQuestions <= 0) return '2.5';
        $scaled = (int) round(($correctCount / $totalQuestions) * 40);

        if ($scaled >= 39) return '9.0';
        if ($scaled >= 37) return '8.5';
        if ($scaled >= 35) return '8.0';
        if ($scaled >= 32) return '7.5';
        if ($scaled >= 30) return '7.0';
        if ($scaled >= 26) return '6.5';
        if ($scaled >= 23) return '6.0';
        if ($scaled >= 18) return '5.5';
        if ($scaled >= 16) return '5.0';
        if ($scaled >= 13) return '4.5';
        if ($scaled >= 10) return '4.0';
        if ($scaled >= 6)  return '3.5';
        if ($scaled >= 4)  return '3.0';
        return '2.5';
    }

    public function submitPractice(Request $request)
    {
        $set = (int) ($request->input('set') ?? request()->route('set') ?? 1);
        $testId = (int) ($request->input('test') ?? request()->route('test') ?? 1);
        $meetingId = (int) ($request->input('meeting') ?? request()->route('meeting') ?? 0);

        $studentAnswers = $request->input('answers', []);
        $multiAnswers = $request->input('answers_multi', []);

        if (is_array($multiAnswers)) {
            foreach ($multiAnswers as $rangeKey => $valArray) {
                if (is_array($valArray)) {
                    $rangeParts = explode('_', $rangeKey);
                    if (count($rangeParts) === 2) {
                        $startQ = (int)$rangeParts[0];
                        foreach ($valArray as $idx => $ansVal) {
                            $studentAnswers[$startQ + $idx] = $ansVal;
                        }
                    }
                }
            }
        }

        $section = null;
        if ($meetingId > 0) {
            $meeting = \App\Models\Meeting::find($meetingId);
            if ($meeting && isset($meeting->ieltsSections)) {
                $section = $meeting->ieltsSections->where('section_number', $set)->first();
            }
        }

        $keys = $this->extractAnswerKeys($set, $testId, $section);

        $results = [];
        $correctCount = 0;
        $totalQuestions = count($keys);

        foreach ($keys as $qNum => $correctAns) {
            $userAns = trim($studentAnswers[$qNum] ?? $studentAnswers[(string)$qNum] ?? '');
            $isCorrect = $this->checkAnswerMatch($userAns, $correctAns);
            if ($isCorrect) {
                $correctCount++;
            }

            $results[$qNum] = [
                'question_number' => $qNum,
                'user_answer' => $userAns,
                'correct_answer' => $correctAns,
                'is_correct' => $isCorrect,
            ];
        }

        $scorePercentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $bandScore = $this->calculateIeltsListeningBand($correctCount, $totalQuestions);

        if (Auth::check()) {
            IeltsListeningPracticeResult::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'part' => $set,
                    'test_id' => $testId,
                ],
                [
                    'meeting_id' => $meetingId > 0 ? $meetingId : 0,
                    'correct_count' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'band_score' => (float)$bandScore,
                    'score_percentage' => $scorePercentage,
                    'answers_data' => $studentAnswers,
                    'results_data' => $results,
                ]
            );

            IeltsListeningPracticeDraft::where('user_id', Auth::id())
                ->where('part', $set)
                ->where('test_id', $testId)
                ->delete();
        }

        $evaluationData = [
            'set' => $set,
            'testId' => $testId,
            'meetingId' => $meetingId,
            'score_percentage' => $scorePercentage,
            'band_score' => $bandScore,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'results' => $results,
            'submitted_at' => now()->format('d M Y, H:i'),
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'evaluation_results' => $evaluationData,
                'message' => "Jawaban IELTS Listening berhasil dikirim! Nilai: {$scorePercentage}% (Band {$bandScore}).",
            ]);
        }

        return redirect()->back()
            ->with('success', "Jawaban IELTS Listening berhasil dikirim! Nilai: {$scorePercentage}% (Band {$bandScore}).")
            ->with('evaluation_results', $evaluationData);
    }

    public function saveDraft(Request $request)
    {
        $request->validate([
            'set' => 'required|integer',
            'test' => 'required|integer',
            'answers' => 'required|array',
        ]);

        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        IeltsListeningPracticeDraft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'part' => (int) $request->input('set'),
                'test_id' => (int) $request->input('test'),
            ],
            [
                'answers_data' => $request->input('answers'),
            ]
        );

        return response()->json(['status' => 'saved']);
    }
}
