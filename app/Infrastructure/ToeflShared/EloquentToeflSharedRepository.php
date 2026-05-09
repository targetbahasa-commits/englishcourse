<?php

namespace App\Infrastructure\ToeflShared;

use App\Domain\ToeflShared\Repositories\ToeflSharedRepository;
use App\Models\Program;

class EloquentToeflSharedRepository implements ToeflSharedRepository
{
    public function findProgramByIdWithClassPeriods(int $programId): mixed
    {
        return Program::with('classPeriods')->find($programId);
    }

    public function findToeflProgramWithClassPeriods(): mixed
    {
        return Program::with('classPeriods')->where('slug', 'toefl-itp')->first();
    }
}
