<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use RuntimeException;
use App\Models\ToeflMockupQuestion;

class UploadMockupQuestionSrt
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly SrtTranscriptParser $parser,
    ) {
    }

    public function handle(int $package, int $questionId, string $language, string $content): void
    {
        if (!$this->mediaRepository->listeningQuestionExists($package, $questionId)) {
            throw new RuntimeException('Listening question not found for this package.');
        }

        $jsonTranscript = json_encode($this->parser->parse($content), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $updateField = $language === 'id' ? 'transcript_id' : 'transcript_en';

        // Update just the specific question
        ToeflMockupQuestion::where('package_number', $package)
            ->where('id', $questionId)
            ->update([$updateField => $jsonTranscript]);
    }
}
