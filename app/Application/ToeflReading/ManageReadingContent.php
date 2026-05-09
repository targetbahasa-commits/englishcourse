<?php

namespace App\Application\ToeflReading;

use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;

class ManageReadingContent
{
    public function __construct(
        private readonly ToeflReadingRepository $repository,
    ) {}

    public function createPassage(array $data): void
    {
        $this->repository->createPassage($data);
    }

    public function updatePassage(int $id, array $data): void
    {
        $this->repository->updatePassage($id, $data);
    }

    public function deletePassage(int $id): void
    {
        $this->repository->deletePassage($id);
    }

    public function createQuestion(array $data): void
    {
        $this->repository->createQuestion($data);
    }

    public function updateQuestion(int $id, array $data): void
    {
        $this->repository->updateQuestion($id, $data);
    }

    public function deleteQuestion(int $id): void
    {
        $this->repository->deleteQuestion($id);
    }
}