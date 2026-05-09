<?php

namespace App\Domain\ToeflShared\Repositories;

interface ToeflSharedRepository
{
    public function findProgramByIdWithClassPeriods(int $programId): mixed;

    public function findToeflProgramWithClassPeriods(): mixed;
}
