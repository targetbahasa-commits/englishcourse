<?php

namespace App\Application\WHV;

use App\Domain\WHV\Repositories\WHVRepository;

class GetFeaturedWHVApplication
{
    public function __construct(
        private readonly WHVRepository $repository
    ) {
    }

    public function handle(): mixed
    {
        return $this->repository->findFeaturedApplication();
    }
}
