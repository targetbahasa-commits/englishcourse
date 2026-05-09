<?php

namespace App\Application\Teacher;

use App\Domain\Teacher\Repositories\TeacherRepository;
use Illuminate\Support\Collection;

class GetTeacherEvaluations
{
    public function __construct(
        private readonly TeacherRepository $repository
    ) {}

    public function execute(array $filters = [], int $perPage = 20): array
    {
        $evaluations = $this->repository->listEvaluations($filters, $perPage);
        $teachersWithEvaluations = $this->collect($this->repository->getTeachersWithEvaluations());
        $averageRating = $this->repository->getAverageRating();
        $totalEvaluations = $this->repository->countEvaluations();
        $topTeachers = $this->collect($this->repository->getTopTeachers(5));

        return compact('evaluations', 'teachersWithEvaluations', 'averageRating', 'totalEvaluations', 'topTeachers');
    }

    private function collect(array $items): Collection
    {
        return collect($items);
    }
}
