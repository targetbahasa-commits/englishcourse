<?php

namespace App\Infrastructure\Dashboard;

use App\Domain\Dashboard\Repositories\DashboardRepository;
use App\Models\Enrollment;
use App\Models\FreeTestResult;
use App\Models\Meeting;
use App\Models\MeetingScore;
use App\Models\OutreachMessage;
use App\Models\Program;
use App\Models\ClassPeriod;

class EloquentDashboardRepository implements DashboardRepository
{
    public function countMeetings(): int
    {
        return Meeting::count();
    }

    public function countMeetingScoresByUser(int $userId): int
    {
        return MeetingScore::where('is_reported', true)->where('user_id', $userId)->count();
    }

    public function averageMeetingScore(int $userId): float
    {
        return (float) (MeetingScore::where('is_reported', true)->where('user_id', $userId)->avg('score') ?? 0);
    }

    public function highestMeetingScore(int $userId): int
    {
        return (int) (MeetingScore::where('is_reported', true)->where('user_id', $userId)->max('score') ?? 0);
    }

    public function totalMeetingPoints(int $userId): int
    {
        return (int) MeetingScore::where('is_reported', true)->where('user_id', $userId)->sum('score');
    }

    public function recentMeetingActivity(int $userId, int $limit = 5): array
    {
        return MeetingScore::where('is_reported', true)->where('user_id', $userId)
            ->with('program')
            ->orderByDesc('submitted_at')
            ->limit($limit)
            ->get()->all();
    }

    public function latestFreeTest(int $userId): mixed
    {
        return FreeTestResult::where('user_id', $userId)->latest()->first();
    }

    public function findOutreachMessage(string $testType, string $targetRole, float $score): mixed
    {
        return OutreachMessage::query()->with('program')
            ->where('test_type', $testType)
            ->where('target_role', $targetRole)
            ->where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->first();
    }

    public function upcomingClasses(int $classPeriodId, int $limit = 3): array
    {
        $period = ClassPeriod::find($classPeriodId);

        if (! $period) {
            return [];
        }

        return $period->classMeetings()
            ->where('meeting_date', '>=', now()->toDateString())
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->limit($limit)
            ->get()->all();
    }

    public function allMeetingScoresByUser(int $userId): array
    {
        return MeetingScore::where('is_reported', true)->where('user_id', $userId)->get()->all();
    }

    public function enrollmentsWithProgram(int $userId): array
    {
        return Enrollment::where('user_id', $userId)
            ->whereIn('status', ['active', 'completed'])
            ->with('program')
            ->get()->all();
    }

    public function scoresBelow(int $userId, int $threshold, int $limit = 2): array
    {
        return MeetingScore::where('is_reported', true)->where('user_id', $userId)
            ->where('score', '<', $threshold)
            ->orderBy('score', 'asc')
            ->orderBy('submitted_at', 'desc')
            ->limit($limit)
            ->get()->all();
    }

    public function pluckScores(int $userId): array
    {
        return MeetingScore::where('is_reported', true)->where('user_id', $userId)->pluck('score')->all();
    }

    public function findProgramBySlug(string $slug): mixed
    {
        return Program::where('slug', $slug)->first();
    }

    public function getPteScores(int $userId): array
    {
        $results = \App\Models\PtePracticeResult::where('user_id', $userId)->get();

        $readingModules = ['mcsa', 'mcma', 'reorder', 'rfib', 'rwfib'];
        $listeningModules = ['summarize-spoken-text', 'listening-multiple-choice-multiple-answer', 'listening-fill-blanks', 'listening-highlight-correct-summary', 'listening-multiple-choice-single-answer', 'listening-select-missing-word', 'listening-highlight-incorrect-words', 'listening-write-from-dictation'];
        $speakingWritingModules = ['read-aloud', 'repeat-sentence', 'describe-image', 'retell-lecture', 'answer-short-question', 'summarize-written-text', 'write-essay'];

        $readingScores = [];
        $listeningScores = [];
        $speakingWritingScores = [];

        foreach ($results as $result) {
            $score = 0;
            if ($result->max_score == 90) {
                // Already scaled
                $score = $result->score;
            } else {
                // Compute raw percentage and scale
                $ratio = max(0, min(1, $result->score / max(1, $result->max_score)));
                $score = round(10 + $ratio * 80);
            }

            if (in_array($result->module, $readingModules)) {
                $readingScores[] = $score;
            } elseif (in_array($result->module, $listeningModules)) {
                $listeningScores[] = $score;
            } elseif (in_array($result->module, $speakingWritingModules)) {
                $speakingWritingScores[] = $score;
            }
        }

        $avgReading = count($readingScores) ? round(array_sum($readingScores) / count($readingScores)) : null;
        $avgListening = count($listeningScores) ? round(array_sum($listeningScores) / count($listeningScores)) : null;
        $avgSpeakingWriting = count($speakingWritingScores) ? round(array_sum($speakingWritingScores) / count($speakingWritingScores)) : null;

        return [
            'reading' => $avgReading,
            'listening' => $avgListening,
            'speaking_writing' => $avgSpeakingWriting,
        ];
    }

    public function weeklyStreak(int $userId): array
    {
        $start = now()->startOfWeek(\Carbon\CarbonInterface::MONDAY)->startOfDay();
        $end = now()->endOfWeek(\Carbon\CarbonInterface::SUNDAY)->endOfDay();

        $activeDates = collect()
            ->merge(
                MeetingScore::where('user_id', $userId)
                    ->whereBetween('submitted_at', [$start, $end])
                    ->pluck('submitted_at')
            )
            ->merge(
                FreeTestResult::where('user_id', $userId)
                    ->whereBetween('created_at', [$start, $end])
                    ->pluck('created_at')
            )
            ->merge(
                \App\Models\PtePracticeResult::where('user_id', $userId)
                    ->whereBetween('created_at', [$start, $end])
                    ->pluck('created_at')
            )
            ->filter()
            ->map(fn ($date) => \Carbon\Carbon::parse($date)->toDateString())
            ->unique();

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);
            $days[] = [
                'date' => $date->toDateString(),
                'label' => $date->format('D'),
                'day' => $date->format('d M'),
                'studied' => $activeDates->contains($date->toDateString()),
                'is_today' => $date->isToday(),
                'is_future' => $date->isFuture() && ! $date->isToday(),
            ];
        }

        return $days;
    }

    public function monthlyLeaderboard(int $userId, ?int $programId, int $limit = 5): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $query = MeetingScore::query()
            ->selectRaw('user_id, SUM(score) as total_points')
            ->where('is_reported', true)
            ->whereBetween('submitted_at', [$start, $end])
            ->groupBy('user_id');

        if ($programId) {
            $query->where('program_id', $programId);
        }

        $ranked = $query->orderByDesc('total_points')->get()->values();

        $names = \App\Models\User::whereIn('id', $ranked->pluck('user_id'))->pluck('name', 'id');

        $entries = $ranked->take($limit)->map(function ($row, $idx) use ($names) {
            return [
                'rank' => $idx + 1,
                'user_id' => (int) $row->user_id,
                'name' => $names[$row->user_id] ?? 'Student',
                'points' => (int) $row->total_points,
            ];
        })->all();

        $currentUserRank = null;
        $currentUserPoints = 0;
        foreach ($ranked as $idx => $row) {
            if ((int) $row->user_id === $userId) {
                $currentUserRank = $idx + 1;
                $currentUserPoints = (int) $row->total_points;
                break;
            }
        }

        return [
            'entries' => $entries,
            'total_participants' => $ranked->count(),
            'current_user_rank' => $currentUserRank,
            'current_user_points' => $currentUserPoints,
        ];
    }
}
