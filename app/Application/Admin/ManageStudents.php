<?php

namespace App\Application\Admin;

use App\Domain\Admin\Repositories\AdminStudentRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ManageStudents
{
    public function __construct(
        private readonly AdminStudentRepository $repository
    ) {}

    public function listAll(array $filters, int $perPage = 15): array
    {
        $students = $this->repository->listStudents($filters, $perPage);
        $teachers = $this->repository->getTeacherOptions();
        $programs = $this->repository->getProgramOptions();
        $metrics  = $this->repository->getStudentMetrics();

        return compact('students', 'teachers', 'programs', 'metrics');
    }

    public function show(mixed $student): array
    {
        $student->load(['program', 'teacher', 'classPeriod.classMeetings', 'classes', 'enrollments.program']);

        $recentActivity      = $this->repository->getRecentActivity($student->id);
        $progressStats       = $this->repository->getProgressStats($student->id);
        $latestTest          = $this->repository->getLatestTest($student->id);
        $allAssignmentScores = $this->repository->getAllAssignmentScores($student->id);

        return array_merge(
            compact('student', 'recentActivity', 'latestTest', 'allAssignmentScores'),
            $progressStats
        );
    }

    public function getCurrentAssignmentViewData(mixed $student): array
    {
        return array_merge(['student' => $student], $this->generateCurrentAssignmentData($student));
    }

    public function getCurrentAssignmentJsonData(mixed $student): array
    {
        $data = $this->generateCurrentAssignmentData($student);

        // The frontend JS expects snake_case keys
        return [
            'activity_url' => $data['activityUrl'],
            'program_name' => $data['programName'],
            'last_activity_human' => $data['lastActivityAt']
                ? $data['lastActivityAt']->diffForHumans()
                : null,
            'snapshot' => $data['snapshot'],
        ];
    }

    private function generateCurrentAssignmentData(mixed $student): array
    {
        $sessionRow  = $this->repository->getLatestSessionForStudent($student->id);
        $sessionData = $this->decodeSessionPayload($sessionRow->payload ?? null);
        $activityUrl = $this->resolveActivityUrl($sessionData, (int) $student->id);
        $programName = $this->mapUrlToProgramName($activityUrl);
        $lastActivityAt = isset($sessionRow->last_activity)
            ? now()->setTimestamp((int) $sessionRow->last_activity)
            : null;

        return [
            'activityUrl'   => $activityUrl,
            'programName'   => $programName,
            'lastActivityAt'=> $lastActivityAt,
            'snapshot'      => $this->resolveCurrentWorkSnapshot($student->id, $activityUrl, $sessionData),
        ];
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

    /**
     * Cache key for persisting the last known-good activity URL per student.
     * TTL: 2 hours — long enough to survive an entire class session.
     */
    private const LAST_VALID_URL_CACHE_TTL = 7200;

    /**
     * Resolve the student's current activity URL from their session data.
     *
     * Problem: background polling requests (e.g. /api/live-drawing/fetch)
     * constantly overwrite `_previous.url` in the student's Laravel session,
     * so the raw API endpoint URL would appear as their "current page" in the
     * admin live preview — showing raw JSON in the iframe instead of the page.
     *
     * Solution (two-layer):
     *  1. Filter: skip any URL whose path starts with an internal API prefix.
     *  2. Cache fallback: whenever a VALID URL is found, persist it in the
     *     Laravel Cache. When the session only contains API/polling URLs,
     *     return the last cached valid URL instead of null.
     *
     * This means the admin preview keeps showing the correct assignment page
     * even while the student's browser is actively polling in the background.
     *
     * @param  array $sessionData  Decoded session payload for the student.
     * @param  int   $studentId    Used as part of the cache key.
     */
    private function resolveActivityUrl(array $sessionData, int $studentId): ?string
    {
        // ── Step 1: Extract raw URL from session ──────────────────────────
        $url = null;

        if (isset($sessionData['_previous']) && is_array($sessionData['_previous'])) {
            $url = $sessionData['_previous']['url'] ?? null;
        }

        if (!$url && isset($sessionData['url.intended']) && is_string($sessionData['url.intended'])) {
            $url = $sessionData['url.intended'];
        }

        // ── Step 2: Filter out internal API / background-poll URLs ────────
        // These are XHR requests that Laravel still saves in _previous.url.
        // They must never surface as the student's "current page".
        //
        // Patterns to reject:
        //   /api/live-drawing/fetch/{id}?last_time=...
        //   /api/live-draft/...
        //   /broadcasting/auth
        //   /api/*  (all internal JSON endpoints)
        //   /admin/students/*/current-assignment-json  (admin polling endpoint)
        $ignoredPrefixes = [
            '/api/',
            '/broadcasting/',
        ];
        $ignoredContains = [
            '/current-assignment-json',
        ];

        if (is_string($url) && trim($url) !== '') {
            $path = (string) parse_url($url, PHP_URL_PATH);
            $isIgnored = false;

            foreach ($ignoredPrefixes as $prefix) {
                if (str_starts_with($path, $prefix)) {
                    $isIgnored = true;
                    break;
                }
            }

            if (!$isIgnored) {
                foreach ($ignoredContains as $needle) {
                    if (str_contains($path, $needle)) {
                        $isIgnored = true;
                        break;
                    }
                }
            }

            if (!$isIgnored) {
                // ── Step 3a: Valid URL found — normalize and cache it ─────
                $normalized = $this->normalizeActivityUrlToCurrentHost($url);

                if ($normalized !== null) {
                    Cache::put(
                        'student_last_valid_activity_url_' . $studentId,
                        $normalized,
                        self::LAST_VALID_URL_CACHE_TTL
                    );
                    return $normalized;
                }
            }
        }

        // ── Step 3b: No valid URL in session — fall back to cached URL ────
        // This happens when background polling has overwritten _previous.url.
        // The cached URL was saved the last time the student visited a real page.
        return Cache::get('student_last_valid_activity_url_' . $studentId);
    }

    private function normalizeActivityUrlToCurrentHost(string $url): ?string
    {
        $trimmed = trim($url);
        if ($trimmed === '') {
            return null;
        }

        $base = request()->getSchemeAndHttpHost();

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
            str_contains($path, '/assignments/grammar-writing/fast-track') => 'Grammar for Writing Fast Track',
            str_contains($path, '/assignments/grammar-writing/introductory') => 'Grammar for Writing Introductory',
            str_contains($path, '/assignments/grammar-writing/complexity') => 'Grammar for Writing Complexity',
            str_contains($path, '/assignments/grammar-writing/proficiency') => 'Grammar for Writing Proficiency',
            str_starts_with($path, '/assignments/grammar-writing/meeting') => 'Grammar for Writing',
            str_contains($path, '/assignments/grammar-writing/') && str_contains($path, '/meeting') => 'Grammar for Writing',
            str_starts_with($path, '/assignments/toefl-itp') => 'TOEFL ITP',
            str_starts_with($path, '/assignments/pte-academic') => 'PTE Academic',
            str_starts_with($path, '/assignments/ielts-general') => 'IELTS General',
            str_starts_with($path, '/assignments/ielts-academic') => 'IELTS Academic',
            str_starts_with($path, '/assignments/ielts/') => 'IELTS Academic',
            str_starts_with($path, '/assignments/speaking') => 'Speaking',
            str_starts_with($path, '/assignments/assignments') => 'Assignments',
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

        $grammarSnapshot = $this->resolveGrammarMeetingSnapshot($userId, $path, $sessionData);
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
            $listening = $this->repository->getLatestReportedListeningScore($userId);

            if ($listening) {
                $pair = $this->firstNonEmptyAnswerPair((array) ($listening->answers ?? []));
                $questionText = null;
                $answerText = $pair['value'] ?? null;

                if ($pair !== null && is_numeric($pair['key'])) {
                    $question = $this->repository->findToeflListeningQuestion((int) $pair['key']);
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
            $mockup = $this->repository->getLatestReportedMockupResult($userId);

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

    private function resolveGrammarMeetingSnapshot(int $userId, string $path, array $sessionData): ?array
    {
        if (!preg_match('#/assignments/grammar-writing/(?:[^/]+/)?meeting(\d+)#', $path, $matches)) {
            return null;
        }

        $meetingNumber = (int) ($matches[1] ?? 0);
        if ($meetingNumber <= 0) {
            return null;
        }

        $answersKey = 'meeting' . $meetingNumber . '_user_answers';
        $paragraphKey = 'meeting' . $meetingNumber . '_user_paragraph_answer';

        $rawAnswers = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_' . $answersKey);
        if ($rawAnswers === null) {
            $rawAnswers = isset($sessionData[$answersKey]) && is_array($sessionData[$answersKey])
                ? $sessionData[$answersKey]
                : [];
        }

        $paragraphAnswer = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_' . $paragraphKey);
        if ($paragraphAnswer === null) {
            $paragraphAnswer = isset($sessionData[$paragraphKey])
                ? trim((string) $sessionData[$paragraphKey])
                : '';
        }

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
                    (string) $candidate['paragraph_answer']
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
            (string) ($first['paragraph_answer'] ?? '')
        );
    }

    private function buildGrammarMeetingSnapshot(int $meetingNumber, array $rawAnswers, string $paragraphAnswer): array
    {
        $answersKey = 'meeting' . $meetingNumber . '_user_answers';
        $normalizedAnswers = $this->normalizeGrammarAnswerMap($rawAnswers);

        $questions = $this->repository->getGrammarQuestionsForMeeting($meetingNumber, $this->grammarQuestionsHasSectionColumn());

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
            $hasSectionColumn = Schema::hasColumn('grammar_questions', 'section');
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

    public function assignTeacher(mixed $student, ?int $teacherId): string
    {
        return $this->repository->assignTeacher($student, $teacherId);
    }

    public function getTeacherOrFail(int $teacherId): mixed
    {
        return $this->repository->getTeacherOrFail($teacherId);
    }

    public function quickUpdate(mixed $student, array $data): void
    {
        $this->repository->quickUpdate($student, $data);
    }

    public function bulkGenerateReferralCodes(): int
    {
        return $this->repository->bulkGenerateReferralCodes();
    }
}
