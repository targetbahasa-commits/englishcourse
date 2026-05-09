<?php

namespace App\Application\ToeflListeningPractice;

class ListeningPracticePackageSubmissionResult
{
    public function __construct(
        public readonly bool $success,
        public readonly int $score,
        public readonly int $correct,
        public readonly int $total,
        public readonly string $message,
        public readonly array $reviewRows,
    ) {
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'score' => $this->score,
            'correct' => $this->correct,
            'total' => $this->total,
            'message' => $this->message,
        ];
    }

    public function reviewPayload(): array
    {
        return [
            'score' => $this->score,
            'correct' => $this->correct,
            'total' => $this->total,
            'rows' => $this->reviewRows,
        ];
    }
}