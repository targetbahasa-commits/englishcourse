<?php

namespace App\Application\ToeflListeningPractice;

use App\Application\ToeflMockup\ViewData\MockupQuestionViewData;
use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;

class BuildListeningPracticePackageViewData
{
    public function __construct(
        private readonly ListeningPracticeRepository $listeningPracticeRepository,
        private readonly \App\Application\ToeflListeningPractice\ToeflListeningSourceAudioOptions $sourceAudioOptions,
    ) {
    }

    public function handle(int $package): array
    {
        $listeningPartA = $this->listeningPracticeRepository->getQuestionsByPart('A')
            ->map(fn ($question) => MockupQuestionViewData::fromModel($question))
            ->values();

        $listeningPartB = $this->listeningPracticeRepository->getQuestionsByPart('B')
            ->map(fn ($question) => MockupQuestionViewData::fromModel($question))
            ->values();

        $listeningPartC = $this->listeningPracticeRepository->getQuestionsByPart('C')
            ->map(fn ($question) => MockupQuestionViewData::fromModel($question))
            ->values();

        return [
            'listeningPartA' => $listeningPartA,
            'listeningPartB' => $listeningPartB,
            'listeningPartC' => $listeningPartC,
            'listeningQuestions' => $listeningPartA,
            'structureQuestions' => collect(),
            'writtenQuestions' => collect(),
            'packageMode' => true,
            'packageNumber' => $package,
            'audioModalContext' => 'package',
            'sourceAudioOptions' => $this->sourceAudioOptions->handle(),
        ];
    }
}