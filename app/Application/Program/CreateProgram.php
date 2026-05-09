<?php

namespace App\Application\Program;

use App\Domain\Program\Repositories\ProgramRepository;

class CreateProgram
{
    public function __construct(
        private readonly ProgramRepository $repository
    ) {
    }

    public function handle(array $data): void
    {
        $this->repository->create($data);
    }
}
