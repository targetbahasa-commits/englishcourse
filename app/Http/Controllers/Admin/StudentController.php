<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\ManageStudents;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentAssignTeacherRequest;
use App\Http\Requests\Admin\StudentQuickUpdateRequest;
use Illuminate\Http\Request;
use App\Models\ToeflListeningQuestion;
use App\Models\ToeflListeningScore;
use App\Models\ToeflMockupResult;
use App\Models\GrammarQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function __construct(
        private readonly ManageStudents $manageStudents
    ) {}

    /**
     * Display a listing of all students.
     */
    public function index(Request $request)
    {
        ['students' => $students, 'teachers' => $teachers, 'programs' => $programs, 'metrics' => $metrics] = $this->manageStudents->listAll(
            $request->only(['search', 'status', 'missing', 'program_id', 'class_period_id', 'month_year']),
            15
        );

        return view('admin.students.index', compact('students', 'teachers', 'programs', 'metrics'));
    }

    /**
     * Display the specified student's profile.
     */
    public function show(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')->with('error', 'User is not a student.');
        }

        [
            'student' => $student,
            'recentActivity' => $recentActivity,
            'progressPercentage' => $progressPercentage,
            'completedAssignments' => $completedAssignments,
            'totalAssignments' => $totalAssignments,
            'averageScore' => $averageScore,
            'latestTest' => $latestTest,
        ] = $this->manageStudents->show($student);

        return view('admin.students.show', compact('student', 'recentActivity', 'progressPercentage', 'completedAssignments', 'totalAssignments', 'averageScore', 'latestTest'));
    }

    /**
     * Reassign a student to a different teacher.
     */
    public function assignTeacher(StudentAssignTeacherRequest $request, User $student)
    {
        if ($request->teacher_id) {
            $teacher = User::findOrFail($request->teacher_id);
            if ($teacher->role !== 'teacher') {
                return back()->with('error', 'The selected user is not a teacher.');
            }
        }

        $message = $this->manageStudents->assignTeacher($student, $request->teacher_id ? (int) $request->teacher_id : null);

        return back()->with('success', $message);
    }

    /**
     * Quick inline update of phone_number and/or referral_code.
     */
    public function quickUpdate(StudentQuickUpdateRequest $request, User $student)
    {
        $this->manageStudents->quickUpdate($student, [
            'phone_number' => $request->phone_number,
            'referral_code' => $request->referral_code,
        ]);

        return back()->with('success', "Updated {$student->name}'s contact info successfully.");
    }

    /**
     * Bulk auto-generate referral codes for students who don't have one.
     */
    public function bulkGenerateReferralCodes()
    {
        $updated = $this->manageStudents->bulkGenerateReferralCodes();

        return back()->with('success', "Generated referral codes for {$updated} student(s).");
    }

    /**
     * Open a quick view of the student's currently active assignment path
     * with the latest detected question/answer snapshot.
     */
    public function currentAssignment(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')->with('error', 'User is not a student.');
        }

        $sessionRow = DB::table('sessions')
            ->where('user_id', $student->id)
            ->orderByDesc('last_activity')
            ->first();

        $sessionData = $this->decodeSessionPayload($sessionRow->payload ?? null);
        $activityUrl = $this->resolveActivityUrl($sessionData);
        $programName = $this->mapUrlToProgramName($activityUrl);
        $lastActivityAt = isset($sessionRow->last_activity) ? now()->setTimestamp((int) $sessionRow->last_activity) : null;

        $snapshot = $this->resolveCurrentWorkSnapshot($student->id, $activityUrl, $sessionData);

        return view('admin.students.current-assignment', compact(
            'student',
            'activityUrl',
            'programName',
            'lastActivityAt',
            'snapshot'
        ));
    }

    /**
     * JSON endpoint for auto-refresh polling of student's current assignment snapshot.
     * Called every 5 seconds by the frontend to update the display with fresh data.
     */
    public function currentAssignmentJson(User $student)
    {
        if ($student->role !== 'student') {
            return response()->json(['error' => 'User is not a student.'], 403);
        }

        $sessionRow = DB::table('sessions')
            ->where('user_id', $student->id)
            ->orderByDesc('last_activity')
            ->first();

        if (!$sessionRow) {
            \Log::debug('[Admin Dashboard] No session found for student', ['student_id' => $student->id]);
            return response()->json([
                'student_id' => $student->id,
                'program_name' => 'N/A',
                'activity_url' => null,
                'last_activity_at' => null,
                'snapshot' => ['source' => 'No session', 'question' => '', 'answer' => '']
            ]);
        }

        $sessionData = $this->decodeSessionPayload($sessionRow->payload ?? null);
        
        // Debug logging
        \Log::debug('[Admin Dashboard] Session data keys', [
            'student_id' => $student->id,
            'session_keys' => array_keys($sessionData),
            'has_meeting3_answers' => isset($sessionData['meeting3_user_answers']),
        ]);
        
        $activityUrl = $this->resolveActivityUrl($sessionData);
        $programName = $this->mapUrlToProgramName($activityUrl);
        $lastActivityAt = isset($sessionRow->last_activity) ? now()->setTimestamp((int) $sessionRow->last_activity) : null;

        $snapshot = $this->resolveCurrentWorkSnapshot($student->id, $activityUrl, $sessionData);

        return response()->json([
            'student_id' => $student->id,
            'program_name' => $programName,
            'activity_url' => $activityUrl,
            'last_activity_at' => $lastActivityAt ? $lastActivityAt->toIso8601String() : null,
            'last_activity_human' => $lastActivityAt ? $lastActivityAt->diffForHumans() : 'N/A',
            'snapshot' => $snapshot
        ]);
    }

    private function decodeSessionPayload(?string $payload): array
    {
        if (!$payload) {
            return [];
        }

        $decoded = base64_decode($payload, true);
        if ($decoded === false || $decoded === '') {
            return [];
        }

        $data = @unserialize($decoded, ['allowed_classes' => false]);

        return is_array($data) ? $data : [];
    }

    private function resolveActivityUrl(array $sessionData): ?string
    {
        $url = null;

        if (isset($sessionData['_previous']) && is_array($sessionData['_previous'])) {
            $url = $sessionData['_previous']['url'] ?? null;
        }

        if (!$url && isset($sessionData['url.intended']) && is_string($sessionData['url.intended'])) {
            $url = $sessionData['url.intended'];
        }

        if (!is_string($url) || trim($url) === '') {
            return null;
        }

        return $this->normalizeActivityUrlToCurrentHost($url);
    }

    private function normalizeActivityUrlToCurrentHost(string $url): ?string
    {
        $trimmed = trim($url);
        if ($trimmed === '') {
            return null;
        }

        $base = request()->getSchemeAndHttpHost();

        // Session may store relative paths; convert them to an absolute URL on current host.
        if (str_starts_with($trimmed, '/')) {
            return $base . $trimmed;
        }

        $path = parse_url($trimmed, PHP_URL_PATH);
        if (!is_string($path) || $path === '' || !str_starts_with($path, '/')) {
            return $trimmed;
        }

        $query = parse_url($trimmed, PHP_URL_QUERY);
        $fragment = parse_url($trimmed, PHP_URL_FRAGMENT);

        $normalized = $base . $path;
        if (is_string($query) && $query !== '') {
            $normalized .= '?' . $query;
        }

        if (is_string($fragment) && $fragment !== '') {
            $normalized .= '#' . $fragment;
        }

        return $normalized;
    }

    private function mapUrlToProgramName(?string $url): string
    {
        if (!$url) {
            return 'Unknown Program';
        }

        $path = strtolower((string) parse_url($url, PHP_URL_PATH));

        return match (true) {
            str_starts_with($path, '/assignments/grammar-writing') => 'Grammar for Writing',
            str_starts_with($path, '/assignments/toefl-itp') => 'TOEFL ITP',
            str_starts_with($path, '/assignments/pte-academic') => 'PTE Academic',
            str_starts_with($path, '/assignments/ielts-general') => 'IELTS General',
            str_starts_with($path, '/assignments/ielts-academic'),
            str_starts_with($path, '/assignments/ielts/') => 'IELTS Academic',
            str_starts_with($path, '/assignments/speaking') => 'Speaking',
            str_starts_with($path, '/assignments') => 'Assignments',
            default => 'Unknown Program',
        };
    }

    private function resolveCurrentWorkSnapshot(int $userId, ?string $activityUrl, array $sessionData): array
    {
        $snapshot = [
            'source' => 'No answer snapshot found yet.',
            'question' => null,
            'answer' => null,
            'submitted_at' => null,
            'meeting_number' => null,
            'live_items' => [],
            'paragraph_answer' => null,
        ];

        $path = strtolower((string) parse_url((string) $activityUrl, PHP_URL_PATH));

        $grammarSnapshot = $this->resolveGrammarMeetingSnapshot($path, $sessionData);
        if ($grammarSnapshot !== null) {
            return array_merge($snapshot, $grammarSnapshot);
        }

        $grammarSessionSnapshot = $this->resolveGrammarMeetingSnapshotFromSession($sessionData);
        if ($grammarSessionSnapshot !== null) {
            return array_merge($snapshot, $grammarSessionSnapshot);
        }

        $sessionSnapshot = $this->extractAnswerFromSessionData($sessionData);
        if ($sessionSnapshot !== null) {
            return $sessionSnapshot;
        }

        if (str_contains($path, '/assignments/toefl-itp/listening')) {
            $listening = ToeflListeningScore::query()
                ->where('user_id', $userId)
                ->orderByDesc('submitted_at')
                ->first();

            if ($listening) {
                $pair = $this->firstNonEmptyAnswerPair((array) ($listening->answers ?? []));
                $questionText = null;
                $answerText = $pair['value'] ?? null;

                if ($pair !== null && is_numeric($pair['key'])) {
                    $question = ToeflListeningQuestion::query()->find((int) $pair['key']);
                    if ($question) {
                        $questionText = $question->question_text;
                    }
                }

                return [
                    'source' => 'Latest TOEFL Listening submission',
                    'question' => $questionText ?: ($pair ? ('Question ID ' . $pair['key']) : null),
                    'answer' => $answerText,
                    'submitted_at' => $listening->submitted_at,
                ];
            }
        }

        if (str_contains($path, '/mockup')) {
            $mockup = ToeflMockupResult::query()
                ->where('user_id', $userId)
                ->orderByDesc('completed_at')
                ->orderByDesc('created_at')
                ->first();

            if ($mockup) {
                $pair = $this->firstNonEmptyAnswerPair((array) ($mockup->answers_data ?? []));

                return [
                    'source' => 'Latest Mockup result',
                    'question' => $pair ? ('Question ' . $pair['key']) : null,
                    'answer' => $pair['value'] ?? null,
                    'submitted_at' => $mockup->completed_at ?: $mockup->created_at,
                ];
            }
        }

        return $snapshot;
    }

    private function resolveGrammarMeetingSnapshot(string $path, array $sessionData): ?array
    {
        if (!preg_match('#/assignments/grammar-writing/meeting(\d+)#', $path, $matches)) {
            return null;
        }

        $meetingNumber = (int) ($matches[1] ?? 0);
        if ($meetingNumber <= 0) {
            return null;
        }

        $answersKey = 'meeting' . $meetingNumber . '_user_answers';
        $paragraphKey = 'meeting' . $meetingNumber . '_user_paragraph_answer';

        $rawAnswers = isset($sessionData[$answersKey]) && is_array($sessionData[$answersKey])
            ? $sessionData[$answersKey]
            : [];
        $paragraphAnswer = isset($sessionData[$paragraphKey])
            ? trim((string) $sessionData[$paragraphKey])
            : '';

        return $this->buildGrammarMeetingSnapshot($meetingNumber, $rawAnswers, $paragraphAnswer);
    }

    private function resolveGrammarMeetingSnapshotFromSession(array $sessionData): ?array
    {
        $candidateMeetings = [];

        foreach ($sessionData as $key => $value) {
            if (!is_string($key) || !is_array($value)) {
                continue;
            }

            if (!preg_match('/^meeting(\d+)_user_answers$/', $key, $matches)) {
                continue;
            }

            $meetingNumber = (int) ($matches[1] ?? 0);
            if ($meetingNumber <= 0) {
                continue;
            }

            $normalized = $this->normalizeGrammarAnswerMap($value);
            $paragraphKey = 'meeting' . $meetingNumber . '_user_paragraph_answer';
            $paragraphAnswer = isset($sessionData[$paragraphKey]) ? trim((string) $sessionData[$paragraphKey]) : '';

            $candidateMeetings[$meetingNumber] = [
                'meeting_number' => $meetingNumber,
                'raw_answers' => $value,
                'has_answers' => $normalized !== [],
                'paragraph_answer' => $paragraphAnswer,
            ];
        }

        if ($candidateMeetings === []) {
            return null;
        }

        krsort($candidateMeetings);

        foreach ($candidateMeetings as $candidate) {
            if ($candidate['has_answers'] || $candidate['paragraph_answer'] !== '') {
                return $this->buildGrammarMeetingSnapshot(
                    (int) $candidate['meeting_number'],
                    (array) $candidate['raw_answers'],
                    (string) $candidate['paragraph_answer'],
                );
            }
        }

        $first = reset($candidateMeetings);
        if (!is_array($first)) {
            return null;
        }

        return $this->buildGrammarMeetingSnapshot(
            (int) ($first['meeting_number'] ?? 0),
            (array) ($first['raw_answers'] ?? []),
            (string) ($first['paragraph_answer'] ?? ''),
        );
    }

    private function buildGrammarMeetingSnapshot(int $meetingNumber, array $rawAnswers, string $paragraphAnswer): array
    {
        $answersKey = 'meeting' . $meetingNumber . '_user_answers';
        $normalizedAnswers = $this->normalizeGrammarAnswerMap($rawAnswers);

        $questionsQuery = GrammarQuestion::query()
            ->where('meeting_number', $meetingNumber)
            ->orderBy('question_number');

        if ($this->grammarQuestionsHasSectionColumn()) {
            $questionsQuery->where('section', 'sentences');
        } else {
            $questionsQuery->where('question_number', '!=', 999);
        }

        $questions = $questionsQuery
            ->get(['question_number', 'question_text'])
            ->unique(static fn ($question) => (int) $question->question_number)
            ->values();

        $liveItems = [];
        foreach ($questions as $question) {
            $questionNumber = (string) $question->question_number;
            $answerData = $normalizedAnswers[$questionNumber] ?? null;

            $tenseAnswer = null;
            $translationAnswer = null;
            $rawAnswer = null;

            if (is_array($answerData)) {
                $tenseAnswer = isset($answerData['tense']) ? trim((string) $answerData['tense']) : null;
                $translationAnswer = isset($answerData['trans']) ? trim((string) $answerData['trans']) : null;
                $rawAnswer = isset($answerData['answer']) ? trim((string) $answerData['answer']) : null;
            } elseif ($answerData !== null && $answerData !== '') {
                $rawAnswer = trim((string) $answerData);
            }

            $tenseAnswer = $tenseAnswer === '' ? null : $tenseAnswer;
            $translationAnswer = $translationAnswer === '' ? null : $translationAnswer;
            $rawAnswer = $rawAnswer === '' ? null : $rawAnswer;

            $liveItems[] = [
                'question_number' => (int) $question->question_number,
                'question_text' => (string) $question->question_text,
                'tense_answer' => $tenseAnswer,
                'translation_answer' => $translationAnswer,
                'answer' => $rawAnswer,
            ];
        }

        if ($liveItems === [] && $normalizedAnswers !== []) {
            foreach ($normalizedAnswers as $key => $value) {
                $tenseAnswer = isset($value['tense']) ? trim((string) $value['tense']) : null;
                $translationAnswer = isset($value['trans']) ? trim((string) $value['trans']) : null;
                $rawAnswer = isset($value['answer']) ? trim((string) $value['answer']) : null;

                $liveItems[] = [
                    'question_number' => is_numeric($key) ? (int) $key : 0,
                    'question_text' => 'Question ' . $key,
                    'tense_answer' => $tenseAnswer !== '' ? $tenseAnswer : null,
                    'translation_answer' => $translationAnswer !== '' ? $translationAnswer : null,
                    'answer' => $rawAnswer !== '' ? $rawAnswer : null,
                ];
            }
        }

        $primaryQuestion = $liveItems[0]['question_text'] ?? ('Meeting ' . $meetingNumber);
        $primaryAnswer = null;
        foreach ($liveItems as $item) {
            $candidate = $item['translation_answer']
                ?? $item['tense_answer']
                ?? $item['answer']
                ?? null;

            if (is_string($candidate) && trim($candidate) !== '') {
                $primaryAnswer = $candidate;
                break;
            }
        }

        return [
            'source' => 'Live grammar draft (' . $answersKey . ')',
            'question' => $primaryQuestion,
            'answer' => $primaryAnswer,
            'submitted_at' => null,
            'meeting_number' => $meetingNumber,
            'live_items' => $liveItems,
            'paragraph_answer' => $paragraphAnswer !== '' ? $paragraphAnswer : null,
        ];
    }

    private function grammarQuestionsHasSectionColumn(): bool
    {
        static $hasSectionColumn = null;

        if ($hasSectionColumn === null) {
            $hasSectionColumn = \Illuminate\Support\Facades\Schema::hasColumn('grammar_questions', 'section');
        }

        return $hasSectionColumn;
    }

    private function normalizeGrammarAnswerMap(array $rawAnswers): array
    {
        $normalized = [];

        foreach ($rawAnswers as $key => $value) {
            if (is_array($value)) {
                $qKey = (string) $key;
                if (!isset($normalized[$qKey])) {
                    $normalized[$qKey] = ['tense' => null, 'trans' => null, 'answer' => null];
                }

                if (isset($value['tense'])) {
                    $normalized[$qKey]['tense'] = (string) $value['tense'];
                }
                if (isset($value['trans'])) {
                    $normalized[$qKey]['trans'] = (string) $value['trans'];
                }
                if (isset($value['answer'])) {
                    $normalized[$qKey]['answer'] = (string) $value['answer'];
                }

                continue;
            }

            if (!is_scalar($value)) {
                continue;
            }

            $rawKey = (string) $key;
            if (preg_match('/^(\d+)[._](tense|trans|answer)$/i', $rawKey, $matches)) {
                $qKey = (string) $matches[1];
                $field = strtolower((string) $matches[2]);

                if (!isset($normalized[$qKey])) {
                    $normalized[$qKey] = ['tense' => null, 'trans' => null, 'answer' => null];
                }

                $normalized[$qKey][$field] = (string) $value;
                continue;
            }

            if (preg_match('/^\d+$/', $rawKey)) {
                if (!isset($normalized[$rawKey])) {
                    $normalized[$rawKey] = ['tense' => null, 'trans' => null, 'answer' => null];
                }

                $normalized[$rawKey]['answer'] = (string) $value;
            }
        }

        if ($normalized === []) {
            return [];
        }

        uksort($normalized, static function ($a, $b): int {
            return ((int) $a) <=> ((int) $b);
        });

        return $normalized;
    }

    private function extractAnswerFromSessionData(array $sessionData): ?array
    {
        foreach ($sessionData as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            if (!Str::endsWith($key, '_user_answers') || !is_array($value)) {
                continue;
            }

            $pair = $this->firstNonEmptyAnswerPair($value);
            if ($pair === null) {
                continue;
            }

            return [
                'source' => 'Live session draft (' . $key . ')',
                'question' => 'Question ' . $pair['key'],
                'answer' => $pair['value'],
                'submitted_at' => null,
            ];
        }

        return null;
    }

    private function firstNonEmptyAnswerPair(array $answers): ?array
    {
        foreach ($answers as $key => $value) {
            if (is_array($value)) {
                $nested = $this->firstNonEmptyAnswerPair($value);
                if ($nested !== null) {
                    return [
                        'key' => $key . '.' . $nested['key'],
                        'value' => $nested['value'],
                    ];
                }

                continue;
            }

            if (is_string($value) && trim($value) === '') {
                continue;
            }

            if ($value === null) {
                continue;
            }

            return [
                'key' => (string) $key,
                'value' => (string) $value,
            ];
        }

        return null;
    }
}
