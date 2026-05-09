<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

class ManageGrammarWritingContent
{
    public function __construct(
        private readonly GrammarWritingRepository $repository
    ) {}

    public function createQuestion(array $data): void
    {
        $this->repository->createQuestion($data);
    }

    public function updateQuestion(int $id, array $data): void
    {
        if (isset($data['vocab']) && is_string($data['vocab'])) {
            $decoded = json_decode($data['vocab'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['vocab'] = $decoded;
            }
        }

        $this->repository->updateQuestion($id, $data);
    }

    public function deleteQuestion(int $id): void
    {
        $this->repository->deleteQuestion($id);
    }

    public function createVocabulary(array $data): void
    {
        $this->repository->createVocabulary($data);
    }

    public function updateVocabulary(int $id, array $data): void
    {
        $this->repository->updateVocabulary($id, $data);
    }

    public function deleteVocabulary(int $id): void
    {
        $this->repository->deleteVocabulary($id);
    }
}