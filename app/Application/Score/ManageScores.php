<?php

namespace App\Application\Score;

use App\Domain\Score\Repositories\ScoreRepository;

class ManageScores
{
    public function __construct(private readonly ScoreRepository $repository)
    {
    }

    public function listScores(array $filters, int $perPage = 20): mixed
    {
        return $this->repository->listScores($filters, $perPage);
    }

    public function getProgramOptions(): array
    {
        return $this->repository->getProgramOptions();
    }

    public function getScoreMetrics(): array
    {
        return $this->repository->getScoreMetrics();
    }

    public function listProgramsWithAssignments(array $filters = []): array
    {
        return $this->repository->listProgramsWithAssignments($filters);
    }

    public function getOverallAssignmentStats(array $filters = []): array
    {
        return $this->repository->getOverallAssignmentStats($filters);
    }

    public function getTopPrograms(): array
    {
        return $this->repository->getTopPrograms();
    }

    public function getProgramAssignmentDetails(mixed $program): array
    {
        return $this->repository->getProgramAssignmentDetails($program);
    }

    public function getInProgressSubmissions(mixed $program): mixed
    {
        return $this->repository->getInProgressSubmissions($program);
    }

    public function getSubmissionDetails(mixed $program, mixed $submission): mixed
    {
        return $this->repository->getSubmissionDetails($program, $submission);
    }

    public function saveSubmissionReview(mixed $submission, array $review, int $reviewerId): mixed
    {
        return $this->repository->saveSubmissionReview($submission, $review, $reviewerId);
    }
}
