<?php

namespace App\Application\FreeTest;

use App\Domain\FreeTest\Repositories\FreeTestRepository;
use App\Models\Program;

class GetTestResult
{
    public function __construct(
        private readonly FreeTestRepository $repository
    ) {
    }

    public function execute(int $resultId, int $userId, string $userRole): array
    {
        $result = $this->repository->findResultOrFail($resultId, $userId);

        $outreachMessage = $this->repository->getOutreachMessage(
            $result->test_type,
            $userRole,
            (int) $result->score,
            (int) $result->score
        );

        $recommendedProgram = null;
        if ($outreachMessage && $outreachMessage->program_id ?? false) {
            $recommendedProgram = Program::find($outreachMessage->program_id);
        }
        // Fallback: recommend first active program if none found
        if (!$recommendedProgram) {
            $recommendedProgram = Program::where('is_active', true)->first();
        }

        return compact('result', 'outreachMessage', 'recommendedProgram');
    }
}
