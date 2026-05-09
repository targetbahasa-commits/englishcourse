<?php

namespace App\Application\ToeflMockup\ViewData;

use Illuminate\Support\Collection;

class MockupPackagePageViewData
{
    public function __construct(
        private readonly Collection $listeningPartA,
        private readonly Collection $listeningPartB,
        private readonly Collection $listeningPartC,
        private readonly Collection $structureQuestions,
        private readonly Collection $writtenQuestions,
        private readonly Collection $readingQuestions,
        private readonly array $readingPassages,
        private readonly int $packageNumber,
        private readonly ?\App\Application\ToeflMockup\ViewData\ListeningDirectionAudioViewData $listeningDirectionAudio,
    ) {
    }

    public function toArray(): array
    {
        return [
            'listeningPartA' => $this->listeningPartA,
            'listeningPartB' => $this->listeningPartB,
            'listeningPartC' => $this->listeningPartC,
            'listeningQuestions' => $this->listeningPartA,
            'structureQuestions' => $this->structureQuestions,
            'writtenQuestions' => $this->writtenQuestions,
            'readingQuestions' => $this->readingQuestions,
            'readingPassages' => $this->readingPassages,
            'packageMode' => true,
            'packageNumber' => $this->packageNumber,
            'isFullMockTest' => true,
            'listeningDirectionAudio' => $this->listeningDirectionAudio,
        ];
    }
}