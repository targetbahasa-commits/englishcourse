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
        if ($testType === 'toefl_itp') {
            $sectionScores = $this->buildToeflItpSectionScores();
            $score = $this->scaleToeflItpScore($sectionScores);

            $evaluationData = array_merge($evaluationData, [
                'listening_score' => $sectionScores['listening'],
                'structure_score' => $sectionScores['structure'],
                'reading_score' => $sectionScores['reading'],
                'toefl_score' => $score,
            ]);
        } elseif (str_starts_with($testType, 'ielts_') || $testType === 'pte_academic') {
            $score = mt_rand(40, 90) / 10; // Mock for IELTS (4.0 - 9.0)
        } else {
            $score = mt_rand(350, 677); // Default mock for TOEFL ITP if type changes
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

    private function buildToeflItpSectionScores(): array
    {
        return [
            'listening' => mt_rand(30, 50),
            'structure' => mt_rand(25, 40),
            'reading'   => mt_rand(30, 50),
        ];
    }

    private function scaleToeflItpScore(array $sectionScores): int
    {
        $rawTotal = $sectionScores['listening'] + $sectionScores['structure'] + $sectionScores['reading'];
        $minRaw = 30 + 25 + 30; // minimum generated raw total
        $maxRaw = 50 + 40 + 50; // maximum raw total
        $minScale = 310;
        $maxScale = 677;

        $scaled = $minScale + (($rawTotal - $minRaw) / ($maxRaw - $minRaw)) * ($maxScale - $minScale);

        return (int) round($scaled);
    }
}
