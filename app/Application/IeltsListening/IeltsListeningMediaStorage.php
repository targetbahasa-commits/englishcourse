<?php

namespace App\Application\IeltsListening;

use App\Application\ToeflMockup\MockupMediaStorage;

class IeltsListeningMediaStorage
{
    public function __construct(
        private readonly MockupMediaStorage $mediaStorage,
    ) {
    }

    public function storeUploadedAudio(string $directory, $file, string $filenamePrefix = 'audio'): string
    {
        return $this->mediaStorage->storeUploadedFileWithExtension($directory, $file, $filenamePrefix);
    }

    public function deleteExistingPublicFile(?string $relativePath): void
    {
        $this->mediaStorage->deletePublicFile($relativePath);
    }
}