<?php

namespace App\Application\Program;

use App\Domain\Program\Repositories\ProgramRepository;
use App\Domain\FreeTest\Repositories\FreeTestRepository;

class CreateProgram
{
    public function __construct(
        private readonly ProgramRepository $repository,
        private readonly FreeTestRepository $freeTestRepository,
    ) {
    }

    public function handle(array $data): void
    {
        $program = $this->repository->create($data);

        // Auto-create a certificate for the new program
    }
}
