<?php

namespace App\Infrastructure\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use App\Models\ToeflMockupListeningDirectionAudio;
use App\Models\ToeflMockupQuestion;

class EloquentMockupMediaRepository implements MockupMediaRepository
{
    public function updateListeningDirectionAudio(int $package, string $column, string $path): void
    {
        ToeflMockupListeningDirectionAudio::updateOrCreate(
            ['package_number' => $package],
            [$column => $path]
        );
    }

    public function hasListeningQuestions(int $package): bool
    {
        return ToeflMockupQuestion::where('package_number', $package)
            ->where('section', 'listening')
            ->exists();
    }

    public function listeningQuestionExists(int $package, int $questionId): bool
    {
        return ToeflMockupQuestion::where('package_number', $package)
            ->where('section', 'listening')
            ->where('id', $questionId)
            ->exists();
    }

    public function updateListeningAudio(int $package, ?int $questionId, string $path): void
    {
        $query = ToeflMockupQuestion::where('package_number', $package)
            ->where('section', 'listening');

        if ($questionId !== null) {
            $query->where('id', $questionId);
        }

        $query->update(['audio_file' => $path]);
    }

    public function updateListeningTranscript(int $package, array $attributes): void
    {
        ToeflMockupQuestion::where('package_number', $package)
            ->where('section', 'listening')
            ->update($attributes);
    }

    public function findQuestionAudioMetadata(int $package, int $questionId): ?array
    {
        $question = ToeflMockupQuestion::where('package_number', $package)
            ->where('id', $questionId)
            ->first(['id', 'question_number', 'audio_file']);

        if (!$question) {
            return null;
        }

        return [
            'id' => $question->id,
            'question_number' => $question->question_number,
            'audio_file' => $question->audio_file,
        ];
    }

    public function updateQuestionAudio(int $package, int $questionId, string $path): void
    {
        ToeflMockupQuestion::where('package_number', $package)
            ->where('id', $questionId)
            ->update(['audio_file' => $path]);
    }
}