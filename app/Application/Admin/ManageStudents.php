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
        $latestFinalTest     = $this->repository->getLatestFinalTest($student->id);
        $allAssignmentScores = $this->repository->getAllAssignmentScores($student->id);

        return array_merge(
            compact('student', 'recentActivity', 'latestTest', 'latestFinalTest', 'allAssignmentScores'),
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
            'is_online' => (bool) ($data['isOnline'] ?? false),
            'snapshot' => $data['snapshot'],
        ];
    }

    private function generateCurrentAssignmentData(mixed $student): array
    {
        if (is_object($student) && method_exists($student, 'loadMissing')) {
            $student->loadMissing(['program', 'enrollments.program', 'classPeriod.program']);
        }

        $sessionRow  = $this->repository->getLatestSessionForStudent($student->id);
        $sessionData = $this->decodeSessionPayload($sessionRow->payload ?? null);
        $activityUrl = $this->resolveActivityUrl($sessionData, (int) $student->id);
        $programName = $this->mapUrlToProgramName($activityUrl);

        // Online/last-activity is derived from users.last_seen_at (stamped by
        // App\Http\Middleware\UpdateLastSeen on every authenticated request,
        // throttled to 1 write/60s) rather than the `sessions` table. The
        // shared host intermittently fails to connect for `sessions` reads
        // (SQLSTATE[HY000] [2002] "Operation not permitted"), which used to
        // empty $sessionRow even for a student who is genuinely mid-session,
        // falling all the way through to resolveFallbackLastActivity()'s
        // MeetingScore/AssignmentDraft lookup - "6 days ago" and Live Preview
        // flipped to OFF for an actively-working student. $student is already
        // a loaded model here, so reading last_seen_at costs no extra query
        // and can't fail on a DB hiccup the way the sessions query can.
        $lastActivityAt = $student->last_seen_at;
        $isOnline = $lastActivityAt && $lastActivityAt->gte(now()->subSeconds(180));

        // If programName is Unknown Program, resolve it from student profile/enrollments/scores
        if ($programName === 'Unknown Program') {
            $programName = $this->resolveStudentProgramName($student);
        }

        // If activityUrl is null, resolve fallback activity URL from student's drafts / scores / enrolled program
        if (!$activityUrl) {
            $activityUrl = $this->resolveFallbackActivityUrl($student, $sessionData);
        }

        // If lastActivityAt is null, resolve fallback last activity timestamp
        if (!$lastActivityAt) {
            $lastActivityAt = $this->resolveFallbackLastActivity($student);
        }

        return [
            'activityUrl'   => $activityUrl,
            'programName'   => $programName,
            'lastActivityAt'=> $lastActivityAt,
            'isOnline'      => $isOnline,
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
        //   any /*-pdf or /*/pdf download route (a student clicking "Download
        //   Materi PDF"/"Download Evaluation PDF" makes THAT the last real
        //   page nav in their session; surfaced into the Live Preview iframe,
        //   a PDF response just triggers the browser's native Save dialog and
        //   leaves the iframe blank instead of showing their actual work)
        $ignoredPrefixes = [
            '/api/',
            '/broadcasting/',
        ];
        $ignoredContains = [
            '/current-assignment-json',
            '/download-material-pdf',
            '/download-pdf',
            '/materi/pdf',
            '/hasil/pdf',
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

    private function resolveStudentProgramName(mixed $student): string
    {
        if (!empty($student->program?->name)) {
            return $student->program->name;
        }

        if (isset($student->enrollments) && $student->enrollments->isNotEmpty()) {
            foreach ($student->enrollments as $enrollment) {
                if (!empty($enrollment->program?->name)) {
                    return $enrollment->program->name;
                }
            }
        }

        if (!empty($student->classPeriod?->program?->name)) {
            return $student->classPeriod->program->name;
        }

        if (!empty($student->classPeriod?->name)) {
            return $student->classPeriod->name;
        }

        $latestScore = \App\Models\MeetingScore::where('user_id', $student->id)
            ->with('program')
            ->whereNotNull('program_id')
            ->latest('updated_at')
            ->first();

        if ($latestScore?->program?->name) {
            return $latestScore->program->name;
        }

        $latestDraft = \App\Models\AssignmentDraft::where('user_id', $student->id)
            ->with('program')
            ->whereNotNull('program_id')
            ->latest('updated_at')
            ->first();

        if ($latestDraft?->program?->name) {
            return $latestDraft->program->name;
        }

        return 'Unknown Program';
    }

    private function resolveFallbackActivityUrl(mixed $student, array $sessionData): ?string
    {
        // 1. Check cache for last valid URL
        $cached = Cache::get('student_last_valid_activity_url_' . $student->id);
        if ($cached) {
            return $cached;
        }

        // 2. Check latest draft
        $latestDraft = \App\Models\AssignmentDraft::where('user_id', $student->id)
            ->latest('updated_at')
            ->first();

        if ($latestDraft && $latestDraft->meeting_number) {
            $track = $latestDraft->track ?? 'fast-track';
            $meeting = $latestDraft->meeting_number;

            // Same root cause as resolveGrammarMeetingSnapshot()'s meeting-2
            // fallback (see its docblock): fast-track meeting 1's stale
            // data-meeting="2" bug filed real meeting-1 answers under
            // meeting_number=2. That's fixed at the source now, but any
            // AssignmentDraft rows already saved while the bug was live
            // still say meeting_number=2 - so the "current page" shown here
            // would otherwise point admins at the wrong meeting entirely,
            // not just show blank answers. Detect it the same way: content
            // shaped like meeting 1's matrix (trans_matrix/tenses keys)
            // saved under meeting_number=2 can only be meeting 1's answers,
            // since the real meeting 2 ("Latihan penerapan tenses") uses a
            // completely different answers shape.
            if ($track === 'fast-track' && $meeting === 2 && is_array($latestDraft->answers)
                && (isset($latestDraft->answers['trans_matrix']) || isset($latestDraft->answers['tenses']))) {
                $meeting = 1;
            }

            $url = match ($track) {
                'introductory' => "/assignments/grammar-writing/introductory/meeting/{$meeting}",
                'complexity' => "/assignments/grammar-writing/complexity/meeting/{$meeting}",
                'proficiency' => "/assignments/grammar-writing/proficiency/meeting/{$meeting}",
                default => "/assignments/grammar-writing/fast-track/meeting{$meeting}",
            };
            return $this->normalizeActivityUrlToCurrentHost($url);
        }

        // 3. Check latest submitted score
        $latestScore = \App\Models\MeetingScore::where('user_id', $student->id)
            ->latest('updated_at')
            ->first();

        $programSlug = $student->program?->slug
            ?? $student->enrollments?->first()?->program?->slug
            ?? ($latestScore ? \App\Models\Program::where('id', $latestScore->program_id)->value('slug') : null);

        if ($latestScore && $latestScore->meeting_number) {
            $nextMeeting = $latestScore->meeting_number < 20 ? ($latestScore->meeting_number + 1) : $latestScore->meeting_number;
            
            if ($programSlug === 'fast-track-grammar-for-writing' || str_contains((string) $programSlug, 'fast-track') || str_contains((string) $programSlug, 'grammar')) {
                $url = "/assignments/grammar-writing/fast-track/meeting{$nextMeeting}";
                return $this->normalizeActivityUrlToCurrentHost($url);
            }
        }

        // 4. Default to first meeting / entry page of enrolled program
        if ($programSlug) {
            $url = match ($programSlug) {
                'fast-track-grammar-for-writing' => '/assignments/grammar-writing/fast-track/meeting1',
                'grammar-for-writing-introductory' => '/assignments/grammar-writing/introductory/meeting/1',
                'grammar-for-writing-complexity' => '/assignments/grammar-writing/complexity/meeting/1',
                'grammar-for-writing-proficiency' => '/assignments/grammar-writing/proficiency/meeting/1',
                'toefl-itp' => '/assignments/toefl-itp',
                'pte-academic' => '/assignments/pte-academic',
                'ielts-general' => '/assignments/ielts-general',
                'ielts-academic' => '/assignments/ielts-academic',
                'speaking' => '/assignments/speaking',
                default => null,
            };

            if ($url) {
                return $this->normalizeActivityUrlToCurrentHost($url);
            }
        }

        return null;
    }

    private function resolveFallbackLastActivity(mixed $student): ?\Carbon\Carbon
    {
        $latestScore = \App\Models\MeetingScore::where('user_id', $student->id)->latest('updated_at')->first();
        if ($latestScore?->updated_at) {
            return $latestScore->updated_at;
        }

        $latestDraft = \App\Models\AssignmentDraft::where('user_id', $student->id)->latest('updated_at')->first();
        if ($latestDraft?->updated_at) {
            return $latestDraft->updated_at;
        }

        if (!empty($student->last_seen_at)) {
            return \Carbon\Carbon::parse($student->last_seen_at);
        }

        return null;
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

        $ieltsWritingSnapshot = $this->resolveIeltsWritingMeetingSnapshot($userId, $path, $sessionData);
        if ($ieltsWritingSnapshot !== null) {
            return array_merge($snapshot, $ieltsWritingSnapshot);
        }

        $ieltsWritingSessionSnapshot = $this->resolveIeltsWritingMeetingSnapshotFromSession($sessionData);
        if ($ieltsWritingSessionSnapshot !== null) {
            return array_merge($snapshot, $ieltsWritingSessionSnapshot);
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
        // "meeting/?(\d+)" (not just "meeting(\d+)") because introductory
        // track's URL is /assignments/grammar-writing/introductory/meeting/{N}
        // - a literal slash between "meeting" and the number - unlike every
        // other track's /meeting{N} (no slash). Missing this meant this
        // method silently never matched ANY introductory meeting's URL at
        // all, no matter how correct everything else here was - it always
        // fell straight through to the less-precise, whole-session-scanning
        // resolveGrammarMeetingSnapshotFromSession() fallback instead.
        if (!preg_match('#/assignments/grammar-writing/(?:([^/]+)/)?meeting/?(\d+)#', $path, $matches)) {
            return null;
        }

        $track = $matches[1] ?? null;
        $meetingNumber = (int) ($matches[2] ?? 0);
        if ($meetingNumber <= 0) {
            return null;
        }

        // Two incompatible session-key conventions exist for the same
        // "current draft answers" concept, depending which controller owns
        // this meeting: the newer "Complexity-style" pages (see
        // grammar-writing-complexity-meeting.blade.php's syncGrammarDraft(),
        // saved by GrammarWritingAdminController::grammarWritingMeetingDraft())
        // key by "{track}_meeting{N}_draft_answers" - e.g.
        // "fast-track_meeting2_draft_answers" - since a track-qualified key
        // is required there (the same meeting number can exist under
        // multiple tracks). Older/legacy grammar-writing pages key by the
        // bare "meeting{N}_user_answers" instead, with no track prefix.
        // Try the modern key(s) first (most current pages use them), only
        // falling back to the legacy one if nothing's there - this is what
        // was missing before, silently showing every Complexity-style
        // meeting's live-typed answers as blank in the admin preview no
        // matter how fresh the student's session data actually was.
        $modernAnswerKeys = [];
        $legacyAnswerKeys = ["meeting{$meetingNumber}_user_answers"];
        $candidateParagraphKeys = [];
        if ($track) {
            $modernAnswerKeys[] = "{$track}_meeting{$meetingNumber}_draft_answers";
            $modernAnswerKeys[] = "{$track}_meeting{$meetingNumber}_user_answers";
            $candidateParagraphKeys[] = "{$track}_meeting{$meetingNumber}_draft_paragraph_answer";
            $candidateParagraphKeys[] = "{$track}_meeting{$meetingNumber}_user_paragraph";
        }
        $candidateParagraphKeys[] = "meeting{$meetingNumber}_user_paragraph_answer";

        // Meeting 1 is the one exception where the "modern track-qualified
        // key -> wrap under 'answers'" rule above doesn't hold, but ONLY
        // for fast-track's own meeting 1 and Complexity's (which reuses it -
        // see BuildGrammarWritingMeeting2ViewData): meeting2.blade.php's
        // fields are "tenses[...]"/"trans_sent[...]"/"trans_matrix[...]",
        // not "answers[N]" - Complexity's meeting 1 draft happens to be
        // saved through the same modern grammarWritingMeetingDraft()
        // endpoint as every OTHER Complexity meeting (see
        // meeting2.blade.php's syncDraftToServer()), but with that
        // different top-level shape, so it must never get the 'answers'
        // wrap the modern key would otherwise imply. Introductory's and
        // Proficiency's OWN meeting 1 pages are unrelated - they use the
        // ordinary "answers[N]" fields just like their other meetings - so
        // this must stay scoped to fast-track/complexity only, not every
        // track's meeting 1.
        $isSharedTensesMatrixMeeting = $meetingNumber === 1 && in_array($track, [null, 'fast-track', 'complexity'], true);

        $rawAnswers = [];
        $answersWrapperKey = null;
        foreach ([...$modernAnswerKeys, ...$legacyAnswerKeys] as $answersKey) {
            $cached = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_' . $answersKey);
            if (is_array($cached) && $cached !== []) {
                $rawAnswers = $cached;
                $answersWrapperKey = ($isSharedTensesMatrixMeeting || !in_array($answersKey, $modernAnswerKeys, true))
                    ? $this->resolveLegacyAnswersWrapperKey($track, $meetingNumber)
                    : 'answers';
                break;
            }
            if (isset($sessionData[$answersKey]) && is_array($sessionData[$answersKey]) && $sessionData[$answersKey] !== []) {
                $rawAnswers = $sessionData[$answersKey];
                $answersWrapperKey = ($isSharedTensesMatrixMeeting || !in_array($answersKey, $modernAnswerKeys, true))
                    ? $this->resolveLegacyAnswersWrapperKey($track, $meetingNumber)
                    : 'answers';
                break;
            }
        }

        if (empty($rawAnswers)) {
            $dbDraft = \App\Models\AssignmentDraft::where('user_id', $userId)
                ->where('meeting_number', $meetingNumber)
                ->latest('updated_at')
                ->first();
            if ($dbDraft && !empty($dbDraft->answers)) {
                $rawAnswers = is_array($dbDraft->answers) ? $dbDraft->answers : (json_decode((string) $dbDraft->answers, true) ?? []);
                if (is_array($rawAnswers) && $rawAnswers !== []) {
                    $answersWrapperKey = ($isSharedTensesMatrixMeeting || !in_array("{$track}_meeting{$meetingNumber}_draft_answers", $modernAnswerKeys, true))
                        ? $this->resolveLegacyAnswersWrapperKey($track, $meetingNumber)
                        : 'answers';
                }
            }
        }

        // Fast-track meeting 1's form (meeting2.blade.php - see its docblock)
        // used to carry a stale data-meeting="2" attribute that made every
        // draft-save silently POST to .../meeting2/draft instead of
        // .../meeting1/draft, filing the student's real meeting-1 answers
        // under meeting_number=2 in both the cache and AssignmentDraft.
        // That's now fixed at the source, but any browser tab that loaded
        // the page before the fix deploys will keep doing this until it's
        // reloaded - so meeting 1 specifically also checks meeting_number=2
        // as a fallback, only accepting it when its shape is unmistakably
        // this matrix page's own (trans_matrix/tenses keys), never a
        // genuine unrelated meeting 2 draft.
        //
        // Trigger on "no REAL content yet", not just "empty array": some
        // students have an old, essentially-blank meeting1_user_answers
        // cache/session entry from a much earlier, mostly-untouched visit
        // to this page (predating the misfile bug) - a non-empty PHP array
        // whose every leaf is null/blank. empty() alone treats that as
        // "found", masking the richer real answers sitting under
        // meeting_number=2 instead of falling through to find them.
        $hasFilledTensesContent = static function ($answers): bool {
            if (!is_array($answers)) {
                return false;
            }
            foreach (['trans_matrix', 'tenses'] as $group) {
                if (isset($answers[$group]) && is_array($answers[$group])
                    && collect($answers[$group])->contains(fn ($v) => $v !== null && trim((string) $v) !== '')) {
                    return true;
                }
            }
            return false;
        };

        if ($track === 'fast-track' && $meetingNumber === 1 && !$hasFilledTensesContent($rawAnswers)) {
            $misfiledCached = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting2_user_answers');
            if ($hasFilledTensesContent($misfiledCached)) {
                $rawAnswers = $misfiledCached;
                $answersWrapperKey = null;
            } else {
                $misfiledDraft = \App\Models\AssignmentDraft::where('user_id', $userId)
                    ->where('meeting_number', 2)
                    ->latest('updated_at')
                    ->first();
                if ($misfiledDraft && $hasFilledTensesContent($misfiledDraft->answers)) {
                    $rawAnswers = $misfiledDraft->answers;
                    $answersWrapperKey = null;
                }
            }
        }

        // Additional fallback: if student has submitted, retrieve answers from MeetingScore
        if (empty($rawAnswers)) {
            $scoreRecord = \App\Models\MeetingScore::where('user_id', $userId)
                ->where('meeting_number', $meetingNumber)
                ->latest('submitted_at')
                ->first();
            if ($scoreRecord && !empty($scoreRecord->answers)) {
                $scoreAnswers = is_array($scoreRecord->answers) ? $scoreRecord->answers : (json_decode((string) $scoreRecord->answers, true) ?? []);
                if (is_array($scoreAnswers) && !empty($scoreAnswers)) {
                    $rawAnswers = $scoreAnswers['user_answers'] ?? ($scoreAnswers['answers'] ?? $scoreAnswers);
                    $answersWrapperKey = 'answers';
                }
            }
        }

        $paragraphAnswer = '';
        foreach ($candidateParagraphKeys as $paragraphKey) {
            $cached = \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_' . $paragraphKey);
            if (is_string($cached) && trim($cached) !== '') {
                $paragraphAnswer = trim($cached);
                break;
            }
            if (isset($sessionData[$paragraphKey]) && trim((string) $sessionData[$paragraphKey]) !== '') {
                $paragraphAnswer = trim((string) $sessionData[$paragraphKey]);
                break;
            }
        }

        if ($paragraphAnswer === '' && !empty($scoreRecord ?? null) && !empty($scoreRecord->answers)) {
            $scoreAnswers = is_array($scoreRecord->answers) ? $scoreRecord->answers : (json_decode((string) $scoreRecord->answers, true) ?? []);
            if (isset($scoreAnswers['paragraph_answer'])) {
                $paragraphAnswer = (string) $scoreAnswers['paragraph_answer'];
            } elseif (isset($scoreAnswers['user_paragraph_answer'])) {
                $paragraphAnswer = (string) $scoreAnswers['user_paragraph_answer'];
            }
        }

        // Introductory meeting 11 ("Irregular Verb") is its own special
        // case, even among the already-inconsistent grammar-writing
        // conventions: its two per-question fields are named
        // "meeting11_answers[N][v2]" / "[v3]" in the DOM, but
        // syncGrammarDraft() (grammar-writing-introductory-meeting.blade.php)
        // reuses the SAME generic per-input draftKey-keyed flat-map
        // collector every other "answers[N]"-style meeting uses - it just
        // sets each input's own data-draft-key to a composite "N_v2"/"N_v3"
        // string instead of a plain N, since a single flat answers[N]
        // slot can't hold two values. That composite key needs
        // reconstructing into real nesting before it means anything to
        // either this method's own per-question extraction below or the
        // live-preview iframe's field-matching JS.
        if ($track === 'introductory' && $meetingNumber === 11 && $rawAnswers !== []) {
            $rawAnswers = $this->reshapeMeeting11Answers($rawAnswers);
            $answersWrapperKey = 'meeting11_answers';
        }

        return $this->buildGrammarMeetingSnapshot($meetingNumber, $rawAnswers, $paragraphAnswer, $answersWrapperKey);
    }

    /**
     * Turns introductory meeting 11's saved {"3_v2": "...", "3_v3": "..."}
     * flat composite-key draft map into the real {"3": {"v2": "...", "v3":
     * "..."}} nesting - see resolveGrammarMeetingSnapshot()'s docblock on
     * why the saved shape doesn't already look like this.
     */
    private function reshapeMeeting11Answers(array $rawAnswers): array
    {
        $reshaped = [];

        foreach ($rawAnswers as $key => $value) {
            if (!preg_match('/^(\d+)_(v2|v3)$/', (string) $key, $matches)) {
                continue;
            }

            $questionNumber = $matches[1];
            $field = $matches[2];

            if (!isset($reshaped[$questionNumber])) {
                $reshaped[$questionNumber] = [];
            }

            $reshaped[$questionNumber][$field] = $value;
        }

        return $reshaped;
    }

    /**
     * The legacy draft endpoint (LegacyGrammarWritingController::meetingDraft(),
     * session key "meeting{N}_user_answers") is shared by every fast-track
     * meeting from 1-10 and 18-20, but each one's own JS builds a
     * differently-shaped JSON payload depending on its actual form field
     * names - and that shape is what ends up saved to the session, since
     * the handler just stores $request->input('userAnswers', []) (or, if
     * that key is absent, everything else via $request->except(...)) as-is.
     *
     * Most meetings' fields are named "userAnswers[...]" (a plain index,
     * e.g. meeting6/7/8/9/10/18/19, or a nested group, e.g. meeting3's
     * "userAnswers[N][tense|trans]" and meeting5's
     * "userAnswers[section][N]") - Laravel's input('userAnswers') strips
     * that outer "userAnswers[...]" segment before it ever reaches this
     * class, so the live-preview iframe's field-matching JS (which
     * flattens raw_answers with NO assumed prefix) needs it added back, or
     * every one of those fields' names come out wrong by exactly that one
     * missing segment.
     *
     * Meeting 1 (fast-track) and meeting 4 are the two exceptions: their
     * fields are named directly as "tenses[...]"/"trans_sent[...]"/
     * "trans_matrix[...]" (no "userAnswers[" wrapper at all), so
     * $request->input('userAnswers') is empty and the handler falls
     * through to $request->except(...) instead - which preserves those
     * top-level group names exactly as they appear in the real DOM
     * already, needing no rewrapping.
     *
     * Only covers the fast-track track, since that's the one this was
     * actually verified against field-by-field - other tracks' meeting
     * numbers may map to entirely different pages/conventions, so they
     * intentionally fall through to "no wrap" (this class's prior,
     * unverified-but-unchanged behavior) rather than guessing.
     */
    private function resolveLegacyAnswersWrapperKey(?string $track, int $meetingNumber): ?string
    {
        if ($track !== 'fast-track') {
            return null;
        }

        $noWrapMeetings = [1, 4, 20];

        return in_array($meetingNumber, $noWrapMeetings, true) ? null : 'userAnswers';
    }

    private function resolveGrammarMeetingSnapshotFromSession(array $sessionData): ?array
    {
        $candidateMeetings = [];

        // Matches both session-key conventions (see resolveGrammarMeetingSnapshot()'s
        // docblock): bare "meeting{N}_user_answers" (legacy pages) and
        // "{track}_meeting{N}_draft_answers" / "{track}_meeting{N}_user_answers"
        // (Complexity-style pages, track-qualified since the same meeting
        // number exists under multiple tracks).
        foreach ($sessionData as $key => $value) {
            if (!is_string($key) || !is_array($value)) {
                continue;
            }

            if (!preg_match('/^(?:([a-z-]+)_)?meeting(\d+)_(?:draft_answers|user_answers)$/', $key, $matches)) {
                continue;
            }

            // preg_match sets an unmatched-but-non-trailing optional group
            // to "" rather than omitting it, so a bare "meeting5_user_answers"
            // key (no track prefix) yields $matches[1] === "" here, NOT
            // null - "?? null" alone never catches that, which silently
            // broke every "$track === null" / "$track !== null" check
            // below for genuinely bare legacy keys.
            $track = ($matches[1] ?? '') !== '' ? $matches[1] : null;
            $meetingNumber = (int) ($matches[2] ?? 0);
            if ($meetingNumber <= 0) {
                continue;
            }

            $paragraphKeys = $track
                ? ["{$track}_meeting{$meetingNumber}_draft_paragraph_answer", "{$track}_meeting{$meetingNumber}_user_paragraph"]
                : ["meeting{$meetingNumber}_user_paragraph_answer"];
            $paragraphAnswer = '';
            foreach ($paragraphKeys as $paragraphKey) {
                if (isset($sessionData[$paragraphKey]) && trim((string) $sessionData[$paragraphKey]) !== '') {
                    $paragraphAnswer = trim((string) $sessionData[$paragraphKey]);
                    break;
                }
            }

            $normalized = $this->normalizeGrammarAnswerMap($value);

            // A track-qualified key overwrites a same-numbered legacy
            // candidate seen earlier (or vice versa) - keep whichever one
            // actually has content, since only one convention is ever
            // populated for a given meeting in practice.
            $existing = $candidateMeetings[$meetingNumber] ?? null;
            if ($existing !== null && $existing['has_answers'] && $normalized === []) {
                continue;
            }

            // The bare "meeting{N}_user_answers" key (no track prefix) never
            // encodes which track it belongs to - resolveGrammarMeetingSnapshot()
            // (the primary path, using the student's actual current URL)
            // knows this for certain, but this is the fallback used when
            // that lookup fails entirely. fast-track is assumed since
            // that's the only track resolveLegacyAnswersWrapperKey() has
            // been verified against field-by-field; a wrong guess here
            // just means an untested track's raw_answers goes back
            // unwrapped, same as this whole class's behavior before this
            // fix existed.
            $rawAnswersForCandidate = $value;
            // Mirrors resolveGrammarMeetingSnapshot()'s $isSharedTensesMatrixMeeting -
            // only fast-track's own meeting 1 (bare key, $track === null here)
            // and Complexity's (which reuses it) skip the 'answers' wrap.
            // Introductory's and Proficiency's own meeting 1 use ordinary
            // "answers[N]" fields like their other meetings and must NOT
            // be swept into this exception just because meetingNumber === 1.
            $isSharedTensesMatrixMeeting = $meetingNumber === 1 && in_array($track, [null, 'fast-track', 'complexity'], true);
            $wrapperKey = ($isSharedTensesMatrixMeeting || $track === null)
                ? $this->resolveLegacyAnswersWrapperKey($track ?? 'fast-track', $meetingNumber)
                : 'answers';

            // See resolveGrammarMeetingSnapshot()'s docblock on this one.
            if ($track === 'introductory' && $meetingNumber === 11 && $rawAnswersForCandidate !== []) {
                $rawAnswersForCandidate = $this->reshapeMeeting11Answers($rawAnswersForCandidate);
                $wrapperKey = 'meeting11_answers';
            }

            $candidateMeetings[$meetingNumber] = [
                'meeting_number' => $meetingNumber,
                'raw_answers' => $rawAnswersForCandidate,
                'has_answers' => $normalized !== [],
                'paragraph_answer' => $paragraphAnswer,
                'answers_wrapper_key' => $wrapperKey,
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
                    $candidate['answers_wrapper_key'] ?? null
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
            $first['answers_wrapper_key'] ?? null
        );
    }

    /**
     * Primary path: uses the student's actual current URL
     * ("/assignments/ielts-academic|general/writing/{task}/meeting/{id}")
     * to know exactly which meeting's draft to read - IeltsWritingController::
     * saveMeetingDraft() persists it under both a Cache key
     * ("ielts_writing_draft_{userId}_{meetingId}") and a session key
     * ("ielts_writing_meeting{meetingId}_user_answers"), the same pair
     * showMeeting() itself reads from to restore the page on load.
     */
    private function resolveIeltsWritingMeetingSnapshot(int $userId, string $path, array $sessionData): ?array
    {
        if (!preg_match('#/assignments/ielts-(?:academic|general)/writing/(\d+)/meeting/(\d+)#', $path, $matches)) {
            return null;
        }

        $meetingId = (int) ($matches[2] ?? 0);
        if ($meetingId <= 0) {
            return null;
        }

        $rawAnswers = Cache::get('ielts_writing_draft_' . $userId . '_' . $meetingId);
        if (!is_array($rawAnswers) || $rawAnswers === []) {
            $sessionValue = $sessionData['ielts_writing_meeting' . $meetingId . '_user_answers'] ?? null;
            $rawAnswers = is_array($sessionValue) ? $sessionValue : [];
        }

        if ($rawAnswers === []) {
            return null;
        }

        return $this->buildIeltsWritingMeetingSnapshot($meetingId, $rawAnswers);
    }

    /**
     * Fallback used when the URL-based lookup above fails (e.g. the
     * session's cached "last known good" activity URL is stale) - scans
     * every "ielts_writing_meeting{N}_user_answers" session key directly,
     * mirroring resolveGrammarMeetingSnapshotFromSession()'s fallback role
     * for the grammar-writing tracks.
     */
    private function resolveIeltsWritingMeetingSnapshotFromSession(array $sessionData): ?array
    {
        foreach ($sessionData as $key => $value) {
            if (!is_string($key) || !is_array($value) || $value === []) {
                continue;
            }

            if (!preg_match('/^ielts_writing_meeting(\d+)_user_answers$/', $key, $matches)) {
                continue;
            }

            $meetingId = (int) ($matches[1] ?? 0);
            if ($meetingId <= 0) {
                continue;
            }

            return $this->buildIeltsWritingMeetingSnapshot($meetingId, $value);
        }

        return null;
    }

    private function buildIeltsWritingMeetingSnapshot(int $meetingId, array $rawAnswers): ?array
    {
        $viewType = \App\Models\IeltsWritingMeeting::find($meetingId)?->view_type;
        $rawAnswers = $this->reshapeIeltsWritingAnswers($viewType, $rawAnswers);

        $pair = $this->firstNonEmptyAnswerPair($rawAnswers);
        if ($pair === null) {
            return null;
        }

        return [
            'source' => 'Live IELTS Writing draft (meeting ' . $meetingId . ')',
            'question' => 'Field ' . $pair['key'],
            'answer' => $pair['value'],
            'submitted_at' => null,
            'meeting_number' => $meetingId,
            'raw_answers' => $rawAnswers,
        ];
    }

    /**
     * Most of the 9 IELTS Writing sub-lesson pages already store their
     * userAnswers object with keys that match their real DOM field `name`
     * attributes exactly (e.g. reducing_clauses' "q1"/"q2", introduction's
     * "attempt1"/"intro_bar", parts_of_paragraph's "q{id}_topic") - the
     * live-preview iframe's flatten()-and-match-by-name JS already handles
     * those correctly with no changes needed here. Two pages don't:
     *
     * - graphical_sentences.blade.php stores {itemId: {verb, noun}} (a
     *   nested object, matching its Alpine `userAnswers[id].verb` state)
     *   but the real fields are flat "answer_{itemId}_verb"/
     *   "answer_{itemId}_noun" (see its `:name="'answer_' + item.id +
     *   '_verb'"` bindings) - flatten() alone would produce bracket-nested
     *   "itemId[verb]" names that never match anything in the DOM.
     * - connecting_trend.blade.php stores {itemId: "text"} (bare id key,
     *   matching `x-model="answers[item.id]"`) but the real field is
     *   "answer_{itemId}" (see its `:name="'answer_' + item.id"` binding).
     */
    private function reshapeIeltsWritingAnswers(?string $viewType, array $rawAnswers): array
    {
        if ($viewType === 'graphical_sentences') {
            $reshaped = [];
            foreach ($rawAnswers as $itemId => $pair) {
                if (!is_array($pair)) {
                    continue;
                }
                if (array_key_exists('verb', $pair)) {
                    $reshaped["answer_{$itemId}_verb"] = $pair['verb'];
                }
                if (array_key_exists('noun', $pair)) {
                    $reshaped["answer_{$itemId}_noun"] = $pair['noun'];
                }
            }

            return $reshaped;
        }

        if ($viewType === 'connecting_trend') {
            $reshaped = [];
            foreach ($rawAnswers as $itemId => $value) {
                $reshaped["answer_{$itemId}"] = $value;
            }

            return $reshaped;
        }

        return $rawAnswers;
    }

    private function buildGrammarMeetingSnapshot(int $meetingNumber, array $rawAnswers, string $paragraphAnswer, ?string $answersWrapperKey = null): array
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
            // Form-field-shaped payload the live-preview iframe's JS
            // flattens into bracket-notation field names and matches by
            // exact `name` attribute (see current-assignment.blade.php).
            // $rawAnswers itself is always keyed by question number (or a
            // section name) with NO wrapper - Laravel's
            // $request->input('userAnswers')/('answers') already strips
            // that outer bracket segment before it's saved. Re-nesting it
            // one level under $answersWrapperKey here (when the real field
            // names need one - see resolveLegacyAnswersWrapperKey()) is
            // what makes flatten() produce "userAnswers[3]"/"answers[1]"
            // etc. instead of the bare "3"/"1" that never matched anything.
            // A small number of meetings' fields aren't wrapped at all
            // (e.g. meeting 4's "trans_sent[N]"/"trans_matrix[N]") - for
            // those $answersWrapperKey is null and $rawAnswers already
            // matches the real field names as-is.
            'raw_answers' => $answersWrapperKey !== null ? [$answersWrapperKey => $rawAnswers] : $rawAnswers,
            'raw_paragraph_answer' => $paragraphAnswer !== '' ? $paragraphAnswer : null,
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
