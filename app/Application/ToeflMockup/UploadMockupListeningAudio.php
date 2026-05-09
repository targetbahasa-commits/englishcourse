<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class UploadMockupListeningAudio
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly MockupMediaStorage $mediaStorage,
    ) {
    }

    public function handle(int $package, ?int $questionId, ?UploadedFile $audioFile, ?string $existingAudioPath): array
    {
        if (!$this->mediaRepository->hasListeningQuestions($package)) {
            throw new RuntimeException('Listening questions not found for this mock test package.');
        }

        if ($questionId !== null && !$this->mediaRepository->listeningQuestionExists($package, $questionId)) {
            throw new RuntimeException('Question not found for this package.');
        }

        $directory = 'audio/toefl-itp/mockup/package-' . $package;
        $publicPath = $this->mediaStorage->ensurePublicDirectoryExists($directory);
        $selectedPath = $this->mediaStorage->resolveSelectedAudioPath($audioFile, $existingAudioPath, $publicPath, $directory, 'audio');

        $this->mediaRepository->updateListeningAudio($package, $questionId, $selectedPath);

        return [
            'message' => $questionId !== null
                ? 'Audio untuk soal terpilih berhasil diupdate.'
                : 'Mockup audio uploaded successfully!',
        ];
    }
}