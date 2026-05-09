<?php

namespace App\Domain\ToeflListeningPractice\Repositories;

interface ListeningPracticeRepository
{
    public function countQuestionsByPart(string $part): int;

    public function getQuestionsByPart(string $part): array;

    public function getAllQuestions(): array;

    public function updateAllQuestionAudio(string $audioPath): void;

    public function updateAllQuestionTranscripts(array $attributes): void;

    public function getListeningPartAQuestionNumbers(): array;

    public function getListeningPartAQuestionsByRange(int $start, int $end): array;
}