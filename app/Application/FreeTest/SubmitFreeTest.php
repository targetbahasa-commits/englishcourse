<?php

namespace App\Application\FreeTest;

use App\Domain\FreeTest\Contracts\FreeTestFollowUpDispatcher;
use App\Domain\FreeTest\Repositories\FreeTestRepository;

class SubmitFreeTest
{
    public function __construct(
        private readonly FreeTestRepository $repository,
        private readonly FreeTestFollowUpDispatcher $followUpDispatcher,
    ) {
    }

    public function execute(int $userId, string $testType, array $evaluationData): mixed
    {
        $score = mt_rand(350, 677); // Default mock for TOEFL ITP
        
        if (str_starts_with($testType, 'ielts_') || $testType === 'pte_academic') {
            $score = mt_rand(40, 90) / 10; // Mock for IELTS (4.0 - 9.0)
        }

        $result = $this->repository->createResult([
            'user_id'         => $userId,
            'test_type'       => $testType,
            'score'           => $score,
            'evaluation_data' => $evaluationData,
        ]);

        $this->followUpDispatcher->dispatchForResult($result);

        return $result;
    }
}
