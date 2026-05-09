<?php

namespace App\Domain\ToeflMockup\Repositories;

interface MockupMediaRepository
{
    public function updateListeningDirectionAudio(int $package, string $column, string $path): void;

    public function hasListeningQuestions(int $package): bool;

    public function listeningQuestionExists(int $package, int $questionId): bool;

    public function updateListeningAudio(int $package, ?int $questionId, string $path): void;

    public function updateListeningTranscript(int $package, array $attributes): void;

    public function findQuestionAudioMetadata(int $package, int $questionId): ?array;

    public function updateQuestionAudio(int $package, int $questionId, string $path): void;
}