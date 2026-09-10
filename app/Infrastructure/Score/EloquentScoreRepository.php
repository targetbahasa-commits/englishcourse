<?php

namespace App\Infrastructure\Score;

use App\Domain\Score\Repositories\ScoreRepository;
use App\Models\AssignmentDraft;
use App\Models\MeetingScore;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
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

        $inProgressQuery = AssignmentDraft::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('meeting_scores')
                ->whereColumn('meeting_scores.user_id', 'assignment_drafts.user_id')
                ->whereColumn('meeting_scores.meeting_number', 'assignment_drafts.meeting_number')
                ->whereColumn('meeting_scores.program_id', 'assignment_drafts.program_id')
                ->where('meeting_scores.is_reported', true);
        });
        if (!empty($filters['program_id'])) {
            $inProgressQuery->where('program_id', $filters['program_id']);
        }
        $inProgressCount = $inProgressQuery->count();

        return compact('totalAssignments', 'completedAssignments', 'totalUsers', 'usersWithSubmissions', 'inProgressCount');
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
            // Batch/teacher come from the student's Enrollment for THIS
            // program specifically (a student can be enrolled in several
            // programs under different batches) - User::classPeriod() is
            // the older single-assignment fallback for students who were
            // never given a proper Enrollment row, kept only as a fallback
            // (see show.blade.php).
            'meetingScores.user.enrollments' => fn ($query) => $query->where('program_id', $program->id),
            'meetingScores.user.enrollments.classPeriod.teacher',
            'meetingScores.user.classPeriod.teacher',
            'meetingScores.reviewer',
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

        $inProgressSubmissions = $this->getInProgressSubmissions($program);

        return compact('program', 'totalSubmissions', 'completedSubmissions', 'averageScore', 'uniqueStudents', 'submissionsByMeeting', 'inProgressSubmissions');
    }

    /**
     * Students who have a saved-but-not-submitted draft for this program
     * (see AssignmentDraft) and don't already have a submitted MeetingScore
     * for that same meeting - i.e. "currently working on it, hasn't hit
     * Submit yet."
     */
    public function getInProgressSubmissions(mixed $program): mixed
    {
        return AssignmentDraft::where('program_id', $program->id)
            ->whereNotExists(function ($query) use ($program) {
                $query->select(DB::raw(1))
                    ->from('meeting_scores')
                    ->whereColumn('meeting_scores.user_id', 'assignment_drafts.user_id')
                    ->whereColumn('meeting_scores.meeting_number', 'assignment_drafts.meeting_number')
                    ->where('meeting_scores.program_id', $program->id)
                    ->where('meeting_scores.is_reported', true);
            })
            ->with([
                'user.enrollments' => fn ($query) => $query->where('program_id', $program->id),
                'user.enrollments.classPeriod.teacher',
                'user.classPeriod.teacher',
            ])
            ->orderByDesc('last_saved_at')
            ->get();
    }

    public function getSubmissionDetails(mixed $program, mixed $submission): mixed
    {
        // Route param arrives as a raw ID string, not a bound model (the
        // controller type-hints this mixed, so Laravel never does implicit
        // binding here) - resolve it explicitly before touching properties.
        $submission = $submission instanceof MeetingScore ? $submission : MeetingScore::find($submission);

        if (!$submission || $submission->program_id !== $program->id) {
            return null;
        }

        return $submission->load('user', 'reviewer');
    }

    public function saveSubmissionReview(mixed $submission, array $review, int $reviewerId): mixed
    {
        $submission->update([
            'teacher_score' => $review['teacher_score'] ?? null,
            'teacher_feedback' => $review['teacher_feedback'] ?? null,
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
        ]);

        Cache::forget("review_draft_{$submission->id}");
        Cache::forget("review_draft_time_{$submission->id}");

        return $submission;
    }
}
