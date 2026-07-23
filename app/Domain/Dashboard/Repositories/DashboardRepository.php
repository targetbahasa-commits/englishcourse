<?php

namespace App\Domain\Dashboard\Repositories;

interface DashboardRepository
{
    public function countMeetings(): int;

    public function countMeetingScoresByUser(int $userId): int;

    public function averageMeetingScore(int $userId): float;

    public function highestMeetingScore(int $userId): int;

    public function totalMeetingPoints(int $userId): int;

    public function recentMeetingActivity(int $userId, int $limit = 5): array;

    public function latestFreeTest(int $userId): mixed;

    public function findOutreachMessage(string $testType, string $targetRole, float $score): mixed;

    public function upcomingClasses(int $classPeriodId, int $limit = 3): array;

    public function allMeetingScoresByUser(int $userId): array;

    public function enrollmentsWithProgram(int $userId): array;

    public function scoresBelow(int $userId, int $threshold, int $limit = 2): array;

    public function pluckScores(int $userId): array;

    public function findProgramBySlug(string $slug): mixed;

    public function getPteScores(int $userId): array;
}
