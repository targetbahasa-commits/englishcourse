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
}
