<?php

namespace App\Infrastructure\ToeflListeningPractice;

use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;
use App\Models\ToeflMockupQuestion;

class EloquentListeningPracticeRepository implements ListeningPracticeRepository
{
    public function countQuestionsByPart(string $part): int
    {
        return ToeflMockupQuestion::where('section', 'listening')
            ->where('part', $part)
            ->count();
    }

    public function getQuestionsByPart(string $part): array
    {
        return ToeflMockupQuestion::where('section', 'listening')
            ->where('part', $part)
            ->orderBy('question_number')
            ->get()->all();
    }

    public function getAllQuestions(): array
    {
        return ToeflMockupQuestion::where('section', 'listening')
            ->whereIn('part', ['A', 'B', 'C'])
            ->orderBy('question_number')
            ->get()->all();
    }

    public function updateAllQuestionAudio(string $audioPath): void
    {
        ToeflMockupQuestion::where('section', 'listening')
            ->whereIn('part', ['A', 'B', 'C'])
            ->update(['audio_file' => $audioPath]);
    }

    public function updateAllQuestionTranscripts(array $attributes): void
    {
        ToeflMockupQuestion::where('section', 'listening')
            ->whereIn('part', ['A', 'B', 'C'])
            ->update($attributes);
    }

    public function getListeningPartAQuestionNumbers(): array
    {
        return ToeflMockupQuestion::query()
            ->where('section', 'listening')
            ->where('part', 'A')
            ->pluck('question_number')
            ->map(fn ($number) => (int) $number)
            ->all();
    }

    public function getListeningPartAQuestionsByRange(int $start, int $end): array
    {
        return ToeflMockupQuestion::query()
            ->where('section', 'listening')
            ->where('part', 'A')
            ->whereBetween('question_number', [$start, $end])
            ->orderBy('question_number')
            ->get()->all();
    }
}