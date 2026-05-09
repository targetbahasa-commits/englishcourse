<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupResultRepository;

class ListMockupResults
{
    public function __construct(
        private readonly MockupResultRepository $repository
    ) {}

    public function execute(int $perPage = 15): mixed
    {
        return $this->repository->listAll($perPage);
    }
}
