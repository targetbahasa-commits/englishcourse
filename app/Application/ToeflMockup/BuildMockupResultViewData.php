<?php

namespace App\Application\ToeflMockup;

use App\Application\ToeflMockup\ViewData\MockupResultViewData;
use App\Domain\ToeflMockup\Repositories\MockupResultRepository;
use RuntimeException;

class BuildMockupResultViewData
{
    public function __construct(
        private readonly MockupResultRepository $mockupResultRepository,
    ) {
    }

    public function handle(int $resultId): MockupResultViewData
    {
        $result = $this->mockupResultRepository->findById($resultId);

        if (!$result) {
            throw new RuntimeException('Mockup result not found.');
        }

        return MockupResultViewData::fromModel($result);
    }
}