<?php

namespace App\Application\ToeflListeningPractice;

use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;

class BuildListeningPracticeIndexData
{
    public function __construct(
        private readonly ListeningPracticeRepository $listeningPracticeRepository,
    ) {
    }

    public function handle(): array
    {
        $parts = collect([
            [
                'key' => 'A',
                'title' => 'Part A',
                'subtitle' => 'Short Dialogues',
                'status' => 'available',
                'description' => 'Latihan soal Listening Part A.',
            ],
            [
                'key' => 'B',
                'title' => 'Part B',
                'subtitle' => 'Longer Conversations',
                'status' => 'coming_soon',
                'description' => 'Latihan Part B akan segera tersedia.',
            ],
            [
                'key' => 'C',
                'title' => 'Part C',
                'subtitle' => 'Talks and Lectures',
                'status' => 'coming_soon',
                'description' => 'Latihan Part C akan segera tersedia.',
            ],
        ]);

        $listeningPackages = collect(range(1, 5))->map(function (int $number) {
            if ($number === 1) {
                $partA = $this->listeningPracticeRepository->countQuestionsByPart('A');
                $partB = $this->listeningPracticeRepository->countQuestionsByPart('B');
                $partC = $this->listeningPracticeRepository->countQuestionsByPart('C');

                return [
                    'package_number' => $number,
                    'title' => 'Paket ' . $number,
                    'subtitle' => 'Diagnostic Pre-Test Listening',
                    'status' => 'available',
                    'description' => 'Part A, Part B, Part C (' . ($partA + $partB + $partC) . ' soal).',
                ];
            }

            return [
                'package_number' => $number,
                'title' => 'Paket ' . $number,
                'subtitle' => 'Listening Package',
                'status' => 'coming_soon',
                'description' => 'Paket soal listening akan segera tersedia.',
            ];
        });

        return [
            'parts' => $parts,
            'listeningPackages' => $listeningPackages,
        ];
    }
}