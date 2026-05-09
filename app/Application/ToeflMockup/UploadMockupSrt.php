<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use RuntimeException;

class UploadMockupSrt
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly SrtTranscriptParser $parser,
    ) {
    }

    public function handle(int $package, string $language, string $content): void
    {
        if (!$this->mediaRepository->hasListeningQuestions($package)) {
            throw new RuntimeException('Listening questions not found for this mock test package.');
        }

        $jsonTranscript = json_encode($this->parser->parse($content), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $updateField = $language === 'id' ? 'transcript_id' : 'transcript_en';

        $this->mediaRepository->updateListeningTranscript($package, [$updateField => $jsonTranscript]);
    }
}