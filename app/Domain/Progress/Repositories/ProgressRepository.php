<?php

namespace App\Domain\Progress\Repositories;

interface ProgressRepository
{
    public function getFreeTestResults(int $userId): array;

    public function getMeetingScores(int $userId, int $programId): array;
}
