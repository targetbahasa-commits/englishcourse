<?php

namespace App\Domain\Score\Repositories;

interface ScoreRepository
{
    public function listScores(array $filters, int $perPage): mixed;

    public function getProgramOptions(): array;

    public function getScoreMetrics(): array;

    public function listProgramsWithAssignments(array $filters = []): array;

    public function getOverallAssignmentStats(array $filters = []): array;

    public function getTopPrograms(): array;

    public function getProgramAssignmentDetails(mixed $program): array;

    public function getSubmissionDetails(mixed $program, mixed $submission): mixed;
}
