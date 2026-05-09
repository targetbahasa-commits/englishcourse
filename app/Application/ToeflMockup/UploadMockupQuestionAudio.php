<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class UploadMockupQuestionAudio
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly MockupMediaStorage $mediaStorage,
    ) {
    }

    public function handle(int $package, int $questionId, UploadedFile $audioFile): void
    {
        $question = $this->mediaRepository->findQuestionAudioMetadata($package, $questionId);
        if (!$question) {
            throw new RuntimeException('Question not found for this package.');
        }

        $directory = 'audio/toefl/mockup/package-' . $package . '/questions';
        $this->mediaStorage->deletePublicFile($question['audio_file'] ?? null);

        $audioPath = $this->mediaStorage->storeUploadedFileWithExtension(
            $directory,
            $audioFile,
            'q_' . $question['question_number']
        );

        $this->mediaRepository->updateQuestionAudio($package, $questionId, $audioPath);
    }
}