<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;
use App\Services\WhisperTranscriptionService;

class ManageIeltsListeningMedia
{
    public function __construct(
        private readonly IeltsListeningMediaStorage $mediaStorage,
        private readonly IeltsListeningRepository $repository,
        private readonly WhisperTranscriptionService $whisper,
    ) {
    }

    public function uploadAudio(int $meetingId, int $set, $file): string
    {
        $directory = "audio/ielts-listening/meeting-{$meetingId}/part-{$set}";
        $audioPath = $this->mediaStorage->storeUploadedAudio($directory, $file);

        $section = $this->repository->findSectionByMeetingAndNumber($meetingId, $set);

        if (!$section) {
            throw new \RuntimeException('Section not found.');
        }

        $this->mediaStorage->deleteExistingPublicFile($section->audio_file);
        $this->repository->updateSection($section->id, ['audio_file' => $audioPath]);

        // ── Auto-transcribe + translate ───────────────────────────────────────
        try {
            $publicDir      = public_path(dirname($audioPath));
            $fullAudioPath  = public_path($audioPath);

            $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicDir);

            $updates = [];
            if ($transcription['en']) {
                $updates['transcript_en'] = $transcription['en'];
            }
            if ($transcription['id']) {
                $updates['transcript_id'] = $transcription['id'];
            }
            if (!empty($updates)) {
                $this->repository->updateSection($section->id, $updates);
            }

            return $transcription['message'] ?: 'Audio berhasil diupload.';
        } catch (\Exception $e) {
            return 'Audio berhasil diupload. Error transkripsi: ' . $e->getMessage();
        }
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