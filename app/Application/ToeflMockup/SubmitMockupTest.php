<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\ToeflScoreConverter;
use App\Domain\ToeflMockup\ToeflScore;
use App\Domain\ToeflMockup\Repositories\MockupPackageRepository;
use App\Domain\ToeflMockup\Repositories\MockupResultRepository;

class SubmitMockupTest
{
    public function __construct(
        private readonly ToeflScoreConverter $scoreConverter,
        private readonly MockupPackageRepository $mockupPackageRepository,
        private readonly MockupResultRepository $mockupResultRepository,
    ) {
    }

    public function handle(int $package, array $answers, mixed $user = null): \App\Application\ToeflMockup\MockupSubmissionResult
    {
        $questions = $this->mockupPackageRepository->getPackageQuestionsIndexedById($package);

        $rawListening = 0;
        $rawStructure = 0;
        $rawReading = 0;
        $correctMap = [];

        foreach ($questions as $id => $question) {
            $correctMap[$id] = $question->correct_answer;

            if (isset($answers[$id]) && strtoupper(trim((string) $answers[$id])) === strtoupper($question->correct_answer)) {
                match ($question->section) {
                    'listening' => $rawListening++,
                    'structure' => $rawStructure++,
                    'reading'   => $rawReading++,
                    default     => null,
                };
            }
        }

        $raw = new ToeflScore($rawListening, $rawStructure, $rawReading);
        $scaled = new ToeflScore(
            $this->scoreConverter->convert('listening', $raw->listening),
            $this->scoreConverter->convert('structure', $raw->structure),
            $this->scoreConverter->convert('reading', $raw->reading),
        );
        $totalScore = $scaled->total();

        $result = null;
        if ($user) {
            $result = $this->mockupResultRepository->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'exam_type' => 'toefl_itp',
                'test_family' => 'mock_test',
                'source_context' => 'assignment_mock_test',
                'submitted_by_role' => $user->role,
                'package_number' => $package,
                'listening_correct' => $raw->listening,
                'structure_correct' => $raw->structure,
                'reading_correct' => $raw->reading,
                'listening_score' => $scaled->listening,
                'structure_score' => $scaled->structure,
                'reading_score' => $scaled->reading,
                'total_score' => $totalScore,
                'raw_scores' => $raw->toArray(),
                'scaled_scores' => $scaled->toArray(),
                'result_payload' => [
                    'package_number' => $package,
                    'question_count' => $questions->count(),
                    'correct_count' => $raw->listening + $raw->structure + $raw->reading,
                    'answered_count' => count(array_filter($answers, fn ($value) => filled($value))),
                    'sections' => [
                        'listening' => ['raw' => $raw->listening, 'scaled' => $scaled->listening],
                        'structure' => ['raw' => $raw->structure, 'scaled' => $scaled->structure],
                        'reading'   => ['raw' => $raw->reading,   'scaled' => $scaled->reading],
                    ],
                ],
                'answers_data' => $answers,
                'completed_at' => now(),
            ]);
        }

        return new \App\Application\ToeflMockup\MockupSubmissionResult(
            success: true,
            rawScores: $raw,
            scaledScores: $scaled,
            totalScore: $totalScore,
            correctMap: $correctMap,
            resultId: $result?->id,
        );
    }
}