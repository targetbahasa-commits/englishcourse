<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminRepository;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class EloquentAdminRepository implements AdminRepository
{
    public function countStudents(): int
    {
        return User::where('role', 'student')->count();
    }

    public function countTeachers(): int
    {
        return User::where('role', 'teacher')->count();
    }

    public function countPrograms(): int
    {
        return Program::count();
    }

    public function countMeetings(): int
    {
        return Meeting::count();
    }

    public function getActiveStudents(int $threshold): array
    {
        $thresholdAt = now()->setTimestamp($threshold);
        $students = [];

        // Populated only by the `sessions` branch below (it's the only
        // source with a raw session payload to read a page URL out of),
        // kept independent of $rememberLatestActivity's "most-recent
        // source wins" merge - a session row can lose that comparison to
        // a fresher users.last_seen_at row and still be the only place a
        // real activity_url is available for that student.
        $activityUrls = [];

        $rememberLatestActivity = function (iterable $rows, callable $timestampResolver, callable $programResolver) use (&$students): void {
            foreach ($rows as $row) {
                $timestamp = $timestampResolver($row);

                if (!$timestamp) {
                    continue;
                }

                $current = $students[$row->id] ?? null;

                if (!$current || $timestamp > $current->last_activity) {
                    $students[$row->id] = (object) [
                        'id'            => $row->id,
                        'name'          => $row->name,
                        'role'          => $row->role,
                        'program_name'  => $programResolver($row),
                        'last_activity' => $timestamp,
                    ];
                }
            }
        };

        $sessionRows = DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->whereNotNull('sessions.user_id')
            ->where('sessions.last_activity', '>=', $threshold)
            ->where('users.role', 'student')
            ->select(
                'users.id',
                'users.name',
                'users.role',
                'programs.name as assigned_program_name',
                'sessions.payload as session_payload',
                'sessions.last_activity as activity_at'
            )
            ->get();

        foreach ($sessionRows as $row) {
            $url = $this->extractActivityUrlFromPayload($row->session_payload ?? null);
            if ($url) {
                $activityUrls[$row->id] = $url;
            }
        }

        $rememberLatestActivity(
            $sessionRows,
            fn (object $row): ?int => is_numeric($row->activity_at ?? null) ? (int) $row->activity_at : null,
            fn (object $row): string => $this->inferProgramFromSessionPayload(
                $row->session_payload ?? null,
                $row->assigned_program_name ?: 'Student Dashboard'
            )
        );

        // General-purpose presence signal, stamped by UpdateLastSeen
        // middleware on every authenticated request - unlike the sessions
        // source above, it isn't lost to garbage collection after
        // SESSION_LIFETIME (2h) of inactivity, so this is what actually
        // makes a 24h/48h window meaningful for casual browsing that never
        // triggers one of the action-specific sources below.
        $rememberLatestActivity(
            DB::table('users')
                ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
                ->where('users.role', 'student')
                ->whereNotNull('users.last_seen_at')
                ->where('users.last_seen_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'programs.name as program_name',
                    'users.last_seen_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (object $row): string => $row->program_name ?: 'Student Dashboard'
        );

        $rememberLatestActivity(
            DB::table('program_access_logs')
                ->join('users', 'program_access_logs.user_id', '=', 'users.id')
                ->join('programs', 'program_access_logs.program_id', '=', 'programs.id')
                ->where('users.role', 'student')
                ->where('program_access_logs.status', 'success')
                ->where('program_access_logs.created_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'programs.name as program_name',
                    'program_access_logs.created_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (object $row): string => $row->program_name ?: 'Program Access'
        );

        $rememberLatestActivity(
            DB::table('meeting_scores')
                ->join('users', 'meeting_scores.user_id', '=', 'users.id')
                ->leftJoin('programs', 'meeting_scores.program_id', '=', 'programs.id')
                ->where('users.role', 'student')
                ->where('meeting_scores.submitted_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'programs.name as program_name',
                    'meeting_scores.submitted_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (object $row): string => $row->program_name ?: 'Grammar for Writing'
        );

        $rememberLatestActivity(
            DB::table('toefl_listening_scores')
                ->join('users', 'toefl_listening_scores.user_id', '=', 'users.id')
                ->where('users.role', 'student')
                ->where('toefl_listening_scores.submitted_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'toefl_listening_scores.submitted_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (): string => 'TOEFL ITP Listening'
        );

        $rememberLatestActivity(
            DB::table('toefl_reading_scores')
                ->join('users', 'toefl_reading_scores.user_id', '=', 'users.id')
                ->where('users.role', 'student')
                ->where('toefl_reading_scores.created_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'toefl_reading_scores.created_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (): string => 'TOEFL ITP Reading'
        );

        $rememberLatestActivity(
            DB::table('free_lesson_progress')
                ->join('users', 'free_lesson_progress.user_id', '=', 'users.id')
                ->where('users.role', 'student')
                ->where('free_lesson_progress.completed_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'free_lesson_progress.completed_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (): string => 'Free Lesson'
        );

        $rememberLatestActivity(
            DB::table('free_test_results')
                ->join('users', 'free_test_results.user_id', '=', 'users.id')
                ->where('users.role', 'student')
                ->where('free_test_results.created_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'free_test_results.test_type',
                    'free_test_results.created_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (object $row): string => $this->formatFreeTestType((string) ($row->test_type ?? 'free_test'))
        );

        $rememberLatestActivity(
            DB::table('toefl_mockup_results')
                ->join('users', 'toefl_mockup_results.user_id', '=', 'users.id')
                ->where('users.role', 'student')
                ->where('toefl_mockup_results.created_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'toefl_mockup_results.created_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (): string => 'TOEFL ITP Mockup'
        );

        foreach ($students as $id => $student) {
            $student->activity_url = $activityUrls[$id] ?? null;
        }

        return collect($students)
            ->sortByDesc('last_activity')
            ->values()
            ->all();
    }

    public function getActiveTeachers(int $threshold): array
    {
        $thresholdAt = now()->setTimestamp($threshold);
        $teachers = [];

        $rememberLatestActivity = function (iterable $rows, callable $timestampResolver, callable $programResolver) use (&$teachers): void {
            foreach ($rows as $row) {
                $timestamp = $timestampResolver($row);
                if (!$timestamp) continue;
                
                $current = $teachers[$row->id] ?? null;
                if (!$current || $timestamp > $current->last_activity) {
                    $teachers[$row->id] = (object) [
                        'id'            => $row->id,
                        'name'          => $row->name,
                        'role'          => $row->role,
                        'program_name'  => $programResolver($row),
                        'last_activity' => $timestamp,
                    ];
                }
            }
        };

        $rememberLatestActivity(
            DB::table('sessions')
                ->join('users', 'sessions.user_id', '=', 'users.id')
                ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
                ->whereNotNull('sessions.user_id')
                ->where('sessions.last_activity', '>=', $threshold)
                ->where('users.role', 'teacher')
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'programs.name as assigned_program_name',
                    'sessions.payload as session_payload',
                    'sessions.last_activity as activity_at'
                )
                ->get(),
            fn (object $row): ?int => is_numeric($row->activity_at ?? null) ? (int) $row->activity_at : null,
            fn (object $row): string => $this->inferProgramFromSessionPayload(
                $row->session_payload ?? null,
                $row->assigned_program_name ?: 'Teacher Dashboard'
            )
        );

        // Same general-purpose presence signal as getActiveStudents() -
        // see that method's comment. Teachers previously had NO fallback
        // beyond the sessions table at all, so this matters even more here.
        $rememberLatestActivity(
            DB::table('users')
                ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
                ->where('users.role', 'teacher')
                ->whereNotNull('users.last_seen_at')
                ->where('users.last_seen_at', '>=', $thresholdAt)
                ->select(
                    'users.id',
                    'users.name',
                    'users.role',
                    'programs.name as program_name',
                    'users.last_seen_at as activity_at'
                )
                ->get(),
            fn (object $row): ?int => $this->normalizeTimestamp($row->activity_at ?? null),
            fn (object $row): string => $row->program_name ?: 'Teacher Dashboard'
        );

        return collect($teachers)
            ->sortByDesc('last_activity')
            ->values()
            ->all();
    }

    public function getProgramPerformance(int $threshold): array
    {
        // Note: withCount() always emits COUNT(*), silently ignoring any ->distinct()
        // call inside the closure - it does NOT become COUNT(DISTINCT ...). Since a
        // student can have multiple concurrent session rows (multiple devices/browsers),
        // counting via a plain relation-count after joining sessions would double-count
        // them. Using addSelect() with an explicit COUNT(DISTINCT users.id) subquery
        // avoids that.
        return Program::withCount([
            'users as students_count' => function ($q) {
                $q->where('role', 'student');
            },
        ])
            ->addSelect(['active_students_count' => User::selectRaw('count(distinct users.id)')
                ->whereColumn('users.program_id', 'programs.id')
                ->where('role', 'student')
                ->join('sessions', 'users.id', '=', 'sessions.user_id')
                ->where('sessions.last_activity', '>=', $threshold),
            ])
            ->orderByDesc('students_count')
            ->limit(5)
            ->get()->all();
    }

    public function getTeacherActivitySummary(): array
    {
        return User::where('role', 'teacher')
            ->selectRaw('users.id, users.name, COUNT(DISTINCT programs.id) as program_count')
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->leftJoin('sessions', 'users.id', '=', 'sessions.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('MAX(sessions.last_activity) DESC')
            ->limit(5)
            ->get()->all();
    }

    private function normalizeTimestamp(mixed $value): ?int
    {
        if ($value instanceof CarbonInterface) {
            return $value->timestamp;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        if (is_string($value) && trim($value) !== '') {
            $timestamp = strtotime($value);

            return $timestamp !== false ? $timestamp : null;
        }

        return null;
    }

    private function formatFreeTestType(string $testType): string
    {
        return match ($testType) {
            'ielts_academic' => 'Free Test IELTS Academic',
            'ielts_general' => 'Free Test IELTS General',
            'toefl_itp' => 'Free Test TOEFL ITP',
            'pte_academic' => 'Free Test PTE Academic',
            default => 'Free Test ' . str_replace('_', ' ', strtoupper($testType)),
        };
    }

    /**
     * Extracts a real page URL from a decoded session payload, for the
     * Live Preview grid view's iframe tiles. Mirrors the same decode
     * step as inferProgramFromSessionPayload() (same payload, read for a
     * different purpose) and the same ignore-list ManageStudents::
     * resolveActivityUrl() uses to skip internal API/polling URLs that
     * would otherwise surface as a student's "current page".
     */
    private function extractActivityUrlFromPayload(?string $payload): ?string
    {
        if (!$payload) {
            return null;
        }

        $decoded = base64_decode($payload, true);
        if ($decoded === false || $decoded === '') {
            return null;
        }

        $data = @unserialize($decoded, ['allowed_classes' => false]);
        if (!is_array($data)) {
            return null;
        }

        $url = null;
        if (isset($data['_previous']) && is_array($data['_previous'])) {
            $url = $data['_previous']['url'] ?? null;
        }
        if (!$url && isset($data['url.intended']) && is_string($data['url.intended'])) {
            $url = $data['url.intended'];
        }

        if (!is_string($url) || trim($url) === '') {
            return null;
        }

        $path = (string) parse_url($url, PHP_URL_PATH);

        foreach (['/api/', '/broadcasting/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return null;
            }
        }

        if (str_contains($path, '/current-assignment-json')) {
            return null;
        }

        return $url;
    }

    private function inferProgramFromSessionPayload(?string $payload, string $fallback): string
    {
        if (!$payload) {
            return $fallback;
        }

        $decoded = base64_decode($payload, true);
        if ($decoded === false || $decoded === '') {
            return $fallback;
        }

        $data = @unserialize($decoded, ['allowed_classes' => false]);
        if (!is_array($data)) {
            return $fallback;
        }

        $url = null;

        if (isset($data['_previous']) && is_array($data['_previous'])) {
            $url = $data['_previous']['url'] ?? null;
        }

        if (!$url && isset($data['url.intended']) && is_string($data['url.intended'])) {
            $url = $data['url.intended'];
        }

        if (!is_string($url) || trim($url) === '') {
            return $fallback;
        }

        return $this->mapUrlToProgramName($url, $fallback);
    }

    private function mapUrlToProgramName(string $url, string $fallback): string
    {
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));

        if ($path === '') {
            return $fallback;
        }

        return match (true) {
            str_starts_with($path, '/assignments/grammar-writing') => 'Grammar for Writing',
            str_starts_with($path, '/assignments/toefl-itp') => 'TOEFL ITP',
            str_starts_with($path, '/assignments/pte-academic') => 'PTE Academic',
            str_starts_with($path, '/assignments/ielts-general') => 'IELTS General',
            str_starts_with($path, '/assignments/ielts-academic'),
            str_starts_with($path, '/assignments/ielts/') => 'IELTS Academic',
            str_starts_with($path, '/assignments/speaking') => 'Speaking',
            str_starts_with($path, '/assignments') => $fallback === 'Student Dashboard' ? 'Assignments' : $fallback,
            str_starts_with($path, '/guest/free-tests') => 'Free Test',
            str_starts_with($path, '/student') => 'Student Dashboard',
            default => $fallback,
        };
    }
}
