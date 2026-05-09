<?php

namespace App\Infrastructure\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupPackageRepository;
use App\Models\ToeflMockupListeningDirectionAudio;
use App\Models\ToeflMockupQuestion;
use App\Models\ToeflReadingPassage;
use Illuminate\Support\Facades\Schema;

class EloquentMockupPackageRepository implements MockupPackageRepository
{
    public function getListeningQuestionsByPart(int $package, array $partAliases): array
    {
        return ToeflMockupQuestion::where('section', 'listening')
            ->where('package_number', $package)
            ->whereIn('part', $partAliases)
            ->orderBy('question_number')
        ->get()->all();
    }

    public function getListeningQuestionsByRange(int $package, int $start, int $end): array
    {
        return ToeflMockupQuestion::where('section', 'listening')
            ->where('package_number', $package)
            ->whereBetween('question_number', [$start, $end])
            ->orderBy('question_number')
        ->get()->all();
    }

    public function getStructureQuestionsByPart(int $package, string $part): array
    {
        return ToeflMockupQuestion::where('section', 'structure')
            ->where('part', $part)
            ->where('package_number', $package)
            ->orderBy('question_number')
        ->get()->all();
    }

    public function getReadingPassagesWithQuestions(int $package): array
    {
        return ToeflReadingPassage::with(['questions' => function ($query) {
                $query->orderBy('question_number');
            }])
            ->where('package_number', $package)
            ->orderBy('passage_number')
        ->get()->all();
    }

    public function getReadingQuestions(int $package): array
    {
        return ToeflMockupQuestion::where('section', 'reading')
            ->where('package_number', $package)
            ->orderBy('question_number')
        ->get()->all();
    }

    public function getPackageQuestionsIndexedById(int $package): array
    {
        return ToeflMockupQuestion::where('package_number', $package)
            ->get()
        ->keyBy('id')
        ->all();
    }

    public function hasListeningDirectionAudioTable(): bool
    {
        return Schema::hasTable('toefl_mockup_listening_direction_audios');
    }

    public function findListeningDirectionAudio(int $package): mixed
    {
        return ToeflMockupListeningDirectionAudio::where('package_number', $package)->first();
    }
}