<?php

namespace App\Domain\ToeflMockup\Repositories;

interface MockupPackageRepository
{
    public function getListeningQuestionsByPart(int $package, array $partAliases): array;

    public function getListeningQuestionsByRange(int $package, int $start, int $end): array;

    public function getStructureQuestionsByPart(int $package, string $part): array;

    public function getReadingPassagesWithQuestions(int $package): array;

    public function getReadingQuestions(int $package): array;

    public function getPackageQuestionsIndexedById(int $package): array;

    public function hasListeningDirectionAudioTable(): bool;

    public function findListeningDirectionAudio(int $package): mixed;
}