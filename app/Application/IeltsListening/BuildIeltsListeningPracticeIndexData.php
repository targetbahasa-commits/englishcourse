<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class BuildIeltsListeningPracticeIndexData
{
    public function __construct(
        private readonly IeltsListeningRepository $repository,
    ) {}

    public function handle(): array
    {
        $program = $this->repository->findOrCreateProgram('ielts-academic-listening', [
            'name' => 'IELTS Academic Listening', 'period' => 'All Time', 'is_active' => true, 'price' => 0
        ]);

        return [
            'program' => $program,
            'meetings' => collect($program->meetings)->sortBy('meeting_number'),
        ];
    }
}