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

        $rememberLatestActivity(
            DB::table('sessions')
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
                ->get(),
            fn (object $row): ?int => is_numeric($row->activity_at ?? null) ? (int) $row->activity_at : null,
            fn (object $row): string => $this->inferProgramFromSessionPayload(
                $row->session_payload ?? null,
                $row->assigned_program_name ?: 'Student Dashboard'
            )
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

        return collect($students)
            ->sortByDesc('last_activity')
            ->values()
            ->all();
    }

            public function getProgramPerformance(int $threshold): array
    {
        return Program::withCount([
            'users as students_count' => function ($q) {
                $q->where('role', 'student');
            },
            'users as active_students_count' => function ($q) use ($threshold) {
                $q->where('role', 'student')
                    ->join('sessions', 'users.id', '=', 'sessions.user_id')
                    ->where('sessions.last_activity', '>=', $threshold)
                    ->distinct('users.id');
            },
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
