<?php

namespace App\Application\Scholarship;

use App\Domain\Scholarship\Repositories\ScholarshipRepository;

class ListActiveScholarships
{
    public function __construct(
        private readonly ScholarshipRepository $repository
    ) {
    }

    public function handle(int $perPage = 12): mixed
    {
        return $this->repository->listActive($perPage);
    }
}
