<?php

namespace App\Application\IeltsReading;

use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;

class ManageIeltsReadingContent
{
    public function __construct(
        private readonly IeltsReadingRepository $repository,
    ) {}

    public function createPassage(array $attributes): void
    {
        $this->repository->createPassage([
            'material_id' => $attributes['material_id'],
            'title' => $attributes['title'],
            'content' => $attributes['content'],
            'order' => $attributes['order'] ?? 0,
        ]);
    }

    public function updatePassage(int $id, array $attributes): void
    {
        $this->repository->updatePassage($id, [
            'title' => $attributes['title'],
            'content' => $attributes['content'],
            'order' => $attributes['order'] ?? 0,
        ]);
    }

    public function deletePassage(int $id): void
    {
        $this->repository->deletePassage($id);
    }

    public function createQuestion(array $attributes): void
    {
        $this->repository->createQuestion([
            'passage_id' => $attributes['passage_id'],
            'question_number' => $attributes['question_number'],
            'question_text' => $attributes['question_text'] ?? null,
            'type' => $attributes['type'],
            'options' => $attributes['options'] ?? null,
            'correct_answer' => $attributes['correct_answer'] ?? null,
            'explanation' => $attributes['explanation'] ?? null,
            'order' => $attributes['order'] ?? 0,
            'data' => $attributes['data'] ?? null,
        ]);
    }

    public function updateQuestion(int $id, array $attributes): void
    {
        $data = $attributes['data'] ?? [];
        if (isset($data['sub_questions']) && is_array($data['sub_questions'])) {
            $data['sub_questions'] = array_values($data['sub_questions']);
        }

        $this->repository->updateQuestion($id, [
            'question_number' => $attributes['question_number'],
            'question_text' => $attributes['question_text'] ?? null,
            'type' => $attributes['type'],
            'options' => $attributes['options'] ?? null,
            'correct_answer' => $attributes['correct_answer'] ?? null,
            'explanation' => $attributes['explanation'] ?? null,
            'order' => $attributes['order'] ?? 0,
            'data' => $data,
        ]);
    }

    public function deleteQuestion(int $id): void
    {
        $this->repository->deleteQuestion($id);
    }
}