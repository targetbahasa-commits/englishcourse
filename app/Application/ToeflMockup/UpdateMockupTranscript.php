<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use RuntimeException;

class UpdateMockupTranscript
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
    ) {
    }

    public function handle(int $package, ?string $transcriptEn, ?string $transcriptId): void
    {
        if (!$this->mediaRepository->hasListeningQuestions($package)) {
            throw new RuntimeException('Listening questions not found for this mock test package.');
        }

        $this->mediaRepository->updateListeningTranscript($package, [
            'transcript_en' => $transcriptEn,
            'transcript_id' => $transcriptId,
        ]);
    }
}