<?php

namespace App\Application\IeltsReading;

use App\Application\IeltsShared\IeltsBatchResolver;
use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;

class BuildIeltsReadingIndexData
{
    public function __construct(
        private readonly IeltsBatchResolver $ieltsBatchResolver,
        private readonly ToeflBatchResolver $batchResolver,
        private readonly IeltsReadingRepository $repository,
    ) {
    }

    public function handle($user): array
    {
        $program = $this->repository->findProgramBySlugWithMeetings('ielts-academic-reading');
        $batchProgram = $this->ieltsBatchResolver->resolveBatchProgramForIelts($user);
        $selectedClassPeriod = $this->batchResolver->resolveSelectedClassPeriodForProgram($batchProgram, $user);
        $meetings = $program ? collect($program->meetings)->sortBy('meeting_number') : collect();

        return [
            'meetings' => $meetings,
            'program' => $program,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}