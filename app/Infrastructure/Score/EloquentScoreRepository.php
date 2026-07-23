<?php

namespace App\Infrastructure\Score;

use App\Domain\Score\Repositories\ScoreRepository;
use App\Models\MeetingScore;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EloquentScoreRepository implements ScoreRepository
{
    public function listScores(array $filters, int $perPage): mixed
    {
        $query = MeetingScore::with(['user', 'program'])
            ->where('is_reported', true)
            ->orderByDesc('submitted_at');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        if (!empty($filters['meeting_number'])) {
            $query->where('meeting_number', $filters['meeting_number']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getProgramOptions(): array
    {
        return Program::where('is_active', true)
            ->withoutMockTests()
            ->orderBy('name')
            ->get()
            ->all();
    }

    public function getScoreMetrics(): array
    {
        $base = MeetingScore::where('is_reported', true);

        return [
            'total' => (clone $base)->count(),
            'completed' => (clone $base)->whereNotNull('score')->count(),
            'unique_students' => (clone $base)->distinct('user_id')->count('user_id'),
            'average' => (clone $base)->whereNotNull('score')->avg('score') ?? 0,
        ];
    }

    public function listProgramsWithAssignments(array $filters = []): array
    {
        $query = Program::withoutMockTests()
            ->whereHas('meetingScores', fn ($q) => $q->where('is_reported', true))
            ->with([
                'meetingScores' => fn ($q) => $q->where('is_reported', true),
                'enrollments',
            ])
            ->withCount([
                'meetingScores as meeting_scores_count' => fn ($q) => $q->where('is_reported', true),
                'meetingScores as completed_assignments' => fn ($q) => $q->whereNotNull('score')->where('is_reported', true),
                'enrollments',
            ])
            ->orderByDesc('meeting_scores_count');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        if (!empty($filters['program_id'])) {
            $query->where('id', $filters['program_id']);
        }

        return $query->get()->all();
    }

    public function getOverallAssignmentStats(array $filters = []): array
    {
        $base = MeetingScore::where('is_reported', true)->whereHas('program', fn ($q) => $q->withoutMockTests());

        if (!empty($filters['program_id'])) {
            $base->where('program_id', $filters['program_id']);
        }

        $totalAssignments = (clone $base)->count();
        $completedAssignments = (clone $base)->whereNotNull('score')->count();
        $usersWithSubmissions = (clone $base)->distinct('user_id')->count('user_id');

        $totalUsers = \App\Models\User::whereIn('role', ['student', 'guest'])->count();

        return compact('totalAssignments', 'completedAssignments', 'totalUsers', 'usersWithSubmissions');
    }

    public function getTopPrograms(): array
    {
        $programs = Program::withoutMockTests()
            ->whereHas('meetingScores', fn ($q) => $q->where('is_reported', true))
            ->with(['meetingScores' => fn ($q) => $q->where('is_reported', true)])
            ->get();

        return $programs->map(function ($program) {
            $scores = $program->meetingScores->whereNotNull('score');
            $program->avg_score = $scores->avg('score') ?? 0;
            $program->students_submitted = $scores->unique('user_id')->count();
            return $program;
        })
        ->sortByDesc('avg_score')
        ->take(10)
        ->values()
        ->all();
    }

    public function getProgramAssignmentDetails(mixed $program): array
    {
        $program->load([
            'meetingScores' => fn ($query) => $query->where('is_reported', true)->orderByDesc('submitted_at'),
            'meetingScores.user',
        ]);

        $base = $program->meetingScores()->where('is_reported', true);

        $totalSubmissions = $base->count();
        $completedSubmissions = (clone $base)->whereNotNull('score')->count();
        $averageScore = (clone $base)->whereNotNull('score')->avg('score');
        $uniqueStudents = (clone $base)->distinct('user_id')->count();

        $submissionsByMeeting = $program->meetingScores()
            ->where('is_reported', true)
            ->select('meeting_number', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN score IS NOT NULL THEN 1 ELSE 0 END) as completed'))
            ->groupBy('meeting_number')
            ->orderBy('meeting_number')
            ->get();

        return compact('program', 'totalSubmissions', 'completedSubmissions', 'averageScore', 'uniqueStudents', 'submissionsByMeeting');
    }

    public function getSubmissionDetails(mixed $program, mixed $submission): mixed
    {
        if ($submission->program_id !== $program->id) {
            return null;
        }

        return $submission->load('user');
    }
}
