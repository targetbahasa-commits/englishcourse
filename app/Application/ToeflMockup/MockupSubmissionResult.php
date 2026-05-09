<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\ToeflScore;

class MockupSubmissionResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ToeflScore $rawScores,
        public readonly ToeflScore $scaledScores,
        public readonly int $totalScore,
        public readonly array $correctMap,
        public readonly ?int $resultId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'rawScores' => $this->rawScores->toArray(),
            'scaledScores' => $this->scaledScores->toArray(),
            'totalScore' => $this->totalScore,
            'correctMap' => $this->correctMap,
            'resultId' => $this->resultId,
        ];
    }
}