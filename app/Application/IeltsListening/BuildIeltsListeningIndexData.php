<?php

namespace App\Application\IeltsListening;

use App\Application\IeltsShared\IeltsBatchResolver;
use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class BuildIeltsListeningIndexData
{
    public function __construct(
        private readonly IeltsBatchResolver $ieltsBatchResolver,
        private readonly ToeflBatchResolver $batchResolver,
        private readonly IeltsListeningRepository $repository,
    ) {
    }

    public function handle($user): array
    {
        $program = $this->repository->findOrCreateProgram('ielts-academic-listening', [
            'name' => 'IELTS Academic Listening', 'period' => 'All Time', 'is_active' => true, 'price' => 0
        ]);
        $batchProgram = $this->ieltsBatchResolver->resolveBatchProgramForIelts($user);
        $selectedClassPeriod = $this->batchResolver->resolveSelectedClassPeriodForProgram($batchProgram);

        $meetings = collect($program->meetings)->sortBy('meeting_number');

        return [
            'meetings' => $meetings,
            'program' => $program,
            'batchProgram' => $batchProgram,
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }
}