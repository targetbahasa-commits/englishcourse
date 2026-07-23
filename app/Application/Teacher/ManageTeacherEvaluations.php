<?php

namespace App\Application\Teacher;

use App\Domain\Teacher\Repositories\TeacherRepository;

class ManageTeacherEvaluations
{
    public function __construct(
        private readonly TeacherRepository $repository
    ) {
    }

    public function getTeacherForEvaluation(int $teacherId): mixed
    {
        return $this->repository->getTeacherForEvaluation($teacherId);
    }

    public function listTeacherEvaluations(int $teacherId, int $perPage = 15): mixed
    {
        return $this->repository->listEvaluations(['teacher_id' => $teacherId], $perPage);
    }

    public function getTeacherAverageRating(int $teacherId): float
    {
        return $this->repository->getTeacherAverageRating($teacherId);
    }

    public function submitEvaluation(int $studentId, int $teacherId, int $rating, ?string $comment = null): void
    {
        $this->repository->saveTeacherEvaluation($studentId, $teacherId, $rating, $comment);
    }
}
