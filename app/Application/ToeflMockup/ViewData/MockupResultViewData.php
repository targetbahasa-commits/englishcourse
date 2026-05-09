<?php

namespace App\Application\ToeflMockup\ViewData;

class MockupResultViewData
{
    public function __construct(
        public readonly int $id,
        public readonly int $user_id,
        public readonly string $name,
        public readonly ?string $email,
        public readonly string $exam_label,
        public readonly string $source_label,
        public readonly ?string $submitted_by_role,
        public readonly int $package_number,
        public readonly int $listening_correct,
        public readonly int $structure_correct,
        public readonly int $reading_correct,
        public readonly int $listening_score,
        public readonly int $structure_score,
        public readonly int $reading_score,
        public readonly int $total_score,
        public readonly array $raw_scores,
        public readonly array $scaled_scores,
        public readonly array $result_payload,
        public readonly array $answers_data,
        public readonly mixed $completed_at,
        public readonly mixed $created_at,
    ) {
    }

    public static function fromModel(object $result): self
    {
        $rawScores = $result->raw_scores ?? [
            'listening' => $result->listening_correct,
            'structure' => $result->structure_correct,
            'reading' => $result->reading_correct,
        ];

        $scaledScores = $result->scaled_scores ?? [
            'listening' => $result->listening_score,
            'structure' => $result->structure_score,
            'reading' => $result->reading_score,
        ];

        return new self(
            id: (int) $result->id,
            user_id: (int) $result->user_id,
            name: (string) $result->name,
            email: $result->email,
            exam_label: (string) $result->exam_label,
            source_label: (string) $result->source_label,
            submitted_by_role: $result->submitted_by_role,
            package_number: (int) $result->package_number,
            listening_correct: (int) $result->listening_correct,
            structure_correct: (int) $result->structure_correct,
            reading_correct: (int) $result->reading_correct,
            listening_score: (int) $result->listening_score,
            structure_score: (int) $result->structure_score,
            reading_score: (int) $result->reading_score,
            total_score: (int) $result->total_score,
            raw_scores: $rawScores,
            scaled_scores: $scaledScores,
            result_payload: $result->result_payload ?? [],
            answers_data: $result->answers_data ?? [],
            completed_at: $result->completed_at,
            created_at: $result->created_at,
        );
    }
}