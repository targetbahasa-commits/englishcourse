<?php

namespace App\Application\ToeflMockup;

use App\Application\ToeflMockup\ViewData\ListeningDirectionAudioViewData;
use App\Application\ToeflMockup\ViewData\MockupPackagePageViewData;
use App\Application\ToeflMockup\ViewData\MockupQuestionViewData;
use App\Application\ToeflMockup\ViewData\ReadingPassageViewData;
use App\Domain\ToeflMockup\Repositories\MockupPackageRepository;
use Illuminate\Support\Collection;

class BuildMockupPackageViewData
{
    public function __construct(
        private readonly MockupPackageRepository $mockupPackageRepository,
        private readonly \App\Application\ToeflMockup\ResolveMockupPackageContent $packageContentResolver,
    ) {
    }

    public function handle(int $package): array
    {
        $partAliases = [
            'A' => ['A', 'Part A', 'PART A', 'part a'],
            'B' => ['B', 'Part B', 'PART B', 'part b'],
            'C' => ['C', 'Part C', 'PART C', 'part c'],
        ];

        $listeningPartA = $this->packageContentResolver->resolveListeningPartQuestions($package, 'A', $partAliases['A'], 1, 30);
        $listeningPartB = $this->packageContentResolver->resolveListeningPartQuestions($package, 'B', $partAliases['B'], 31, 38);
        $listeningPartC = $this->packageContentResolver->resolveListeningPartQuestions($package, 'C', $partAliases['C'], 39, 50);

        $structureQuestions = $this->packageContentResolver->resolveStructureQuestions($package, 'Structure');
        $writtenQuestions = $this->packageContentResolver->resolveStructureQuestions($package, 'Written Expression');

        $readingResolution = $this->packageContentResolver->resolveReadingPassages($package);
        $readingPassagesData = $readingResolution['passages'];
        $readingSourcePackage = $readingResolution['sourcePackage'];

        $readingPassages = collect($readingPassagesData)
            ->map(fn ($passage) => ReadingPassageViewData::fromModel($passage)->toArray())
            ->values()
            ->all();

        $readingQuestions = $this->mapQuestions(
            $this->mockupPackageRepository->getReadingQuestions($readingSourcePackage)
        );

        $listeningDirectionAudio = null;
        if ($this->mockupPackageRepository->hasListeningDirectionAudioTable()) {
            $audio = $this->mockupPackageRepository->findListeningDirectionAudio($package);
            $listeningDirectionAudio = $audio ? ListeningDirectionAudioViewData::fromModel($audio) : null;
        }

        return new MockupPackagePageViewData(
            listeningPartA: $this->mapQuestions($listeningPartA),
            listeningPartB: $this->mapQuestions($listeningPartB),
            listeningPartC: $this->mapQuestions($listeningPartC),
            structureQuestions: $this->mapQuestions($structureQuestions),
            writtenQuestions: $this->mapQuestions($writtenQuestions),
            readingQuestions: $readingQuestions,
            readingPassages: $readingPassages,
            packageNumber: $package,
            listeningDirectionAudio: $listeningDirectionAudio,
        )->toArray();
    }

    private function mapQuestions(iterable $questions): Collection
    {
        return collect($questions)
            ->map(fn ($question) => MockupQuestionViewData::fromModel($question))
            ->values();
    }
}