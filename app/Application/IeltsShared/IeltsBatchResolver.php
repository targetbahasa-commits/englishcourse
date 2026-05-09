<?php

namespace App\Application\IeltsShared;

use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;

class IeltsBatchResolver
{
    public function __construct(
        private readonly IeltsSharedRepository $repository,
    ) {}

    public function resolveBatchProgramForIelts(mixed $user): mixed
    {
        $program = null;

        if ($user && $user->program_id) {
            $candidate = $this->repository->findProgramByIdWithClassPeriods((int) $user->program_id);
            if ($candidate && str_starts_with((string) $candidate->slug, 'ielts-academic')) {
                $program = $candidate;
            }
        }

        if (!$program) {
            $program = $this->repository->findFirstIeltsProgramWithClassPeriods();
        }

        return $program;
    }
}