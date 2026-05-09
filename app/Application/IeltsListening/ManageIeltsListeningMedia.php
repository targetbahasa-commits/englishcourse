<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class ManageIeltsListeningMedia
{
    public function __construct(
        private readonly \App\Application\IeltsListening\IeltsListeningMediaStorage $mediaStorage,
        private readonly IeltsListeningRepository $repository,
    ) {
    }

    public function uploadAudio(int $meetingId, int $set, $file): void
    {
        $directory = "audio/ielts-listening/meeting-{$meetingId}/part-{$set}";
        $audioPath = $this->mediaStorage->storeUploadedAudio($directory, $file);

        $section = $this->repository->findSectionByMeetingAndNumber($meetingId, $set);

        if (!$section) {
            throw new \RuntimeException('Section not found.');
        }

        $this->mediaStorage->deleteExistingPublicFile($section->audio_file);

        $this->repository->updateSection($section->id, ['audio_file' => $audioPath]);
    }

    public function updateTranscript(int $meetingId, int $set, ?string $transcriptEn, ?string $transcriptId): void
    {
        $section = $this->repository->findSectionByMeetingAndNumber($meetingId, $set);

        if (!$section) {
            throw new \RuntimeException('Section not found.');
        }

        $this->repository->updateSection($section->id, [
            'transcript_en' => $transcriptEn,
            'transcript_id' => $transcriptId,
        ]);
    }
}