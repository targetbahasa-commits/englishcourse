<?php

namespace App\Application\ToeflStructure;

use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;

class ManageStructureQuestions
{
    public function __construct(
        private readonly ToeflStructureRepository $repository,
    ) {
    }

    public function create(int $number, array $attributes): void
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        $attributes['section_id'] = $meeting->id;
        $attributes['meeting_number'] = $number;

        $this->repository->createQuestion($attributes);
    }

    public function update(int $id, array $attributes): void
    {
        $this->repository->updateQuestion($id, $attributes);
    }

    public function updateAnswer(int $id, string $correctAnswer): void
    {
        $this->repository->updateQuestion($id, ['correct_answer' => $correctAnswer]);
    }

    public function destroy(int $id): void
    {
        $this->repository->deleteQuestion($id);
    }
}