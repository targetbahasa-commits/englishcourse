<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupPackageRepository;
use Illuminate\Support\Collection;

class ResolveMockupPackageContent
{
    public function __construct(
        private readonly MockupPackageRepository $mockupPackageRepository,
    ) {
    }

    public function resolveListeningPartQuestions(int $package, string $part, array $partAliases, int $rangeStart, int $rangeEnd): Collection
    {
        $questions = collect($this->mockupPackageRepository->getListeningQuestionsByPart($package, $partAliases));

        if ($questions->isEmpty()) {
            $questions = collect($this->mockupPackageRepository->getListeningQuestionsByRange($package, $rangeStart, $rangeEnd));
        }

        if ($questions->isEmpty()) {
            $questions = collect($this->mockupPackageRepository->getListeningQuestionsByPart(1, $partAliases));
            if ($questions->isEmpty()) {
                $questions = collect($this->mockupPackageRepository->getListeningQuestionsByRange(1, $rangeStart, $rangeEnd));
            }
        }

        return $questions;
    }

    public function resolveStructureQuestions(int $package, string $part): Collection
    {
        $questions = collect($this->mockupPackageRepository->getStructureQuestionsByPart($package, $part));

        if ($questions->isEmpty()) {
            $questions = collect($this->mockupPackageRepository->getStructureQuestionsByPart(1, $part));
        }

        return $questions;
    }

    public function resolveReadingPassages(int $package): array
    {
        $sourcePackage = $package;
        $passages = collect($this->mockupPackageRepository->getReadingPassagesWithQuestions($package));

        if ($passages->isEmpty()) {
            $sourcePackage = 1;
            $passages = collect($this->mockupPackageRepository->getReadingPassagesWithQuestions(1));
        }

        return [
            'sourcePackage' => $sourcePackage,
            'passages' => $passages,
        ];
    }
}