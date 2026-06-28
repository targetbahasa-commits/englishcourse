<?php

namespace App\Application\IeltsListening;

use App\Application\ToeflMockup\SrtTranscriptParser;
use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;
use App\Services\WhisperTranscriptionService;

class ManageIeltsListeningMaterialMedia
{
    public function __construct(
        private readonly IeltsListeningMediaStorage $mediaStorage,
        private readonly SrtTranscriptParser $srtTranscriptParser,
        private readonly IeltsListeningRepository $repository,
        private readonly WhisperTranscriptionService $whisper,
    ) {
    }

    public function uploadAudio(int $id, $file): string
    {
        $material = $this->repository->findMaterialByTypeId($id);
        if (!$material) {
            throw new \RuntimeException('Material not found.');
        }
        $directory = "audio/ielts-academic/listening/material-{$id}";
        $audioPath = $this->mediaStorage->storeUploadedAudio($directory, $file);

        $this->mediaStorage->deleteExistingPublicFile($material->audio_file);
        $this->repository->updateMaterial($material->id, ['audio_file' => $audioPath]);

        // ── Auto-transcribe + translate ───────────────────────────────────────
        try {
            $publicDir     = public_path(dirname($audioPath));
            $fullAudioPath = public_path($audioPath);

            $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicDir);

            $updates = [];
            if (!empty($transcription['formatted_en'])) {
                $updates['transcript_en'] = $transcription['formatted_en'];
            } elseif (!empty($transcription['en'])) {
                $updates['transcript_en'] = $transcription['en'];
            }
            if (!empty($transcription['formatted_id'])) {
                $updates['transcript_id'] = $transcription['formatted_id'];
            } elseif (!empty($transcription['id'])) {
                $updates['transcript_id'] = $transcription['id'];
            }
            if (!empty($updates)) {
                $this->repository->updateMaterial($material->id, $updates);
            }

            return $transcription['message'] ?: 'Audio berhasil diupload.';
        } catch (\Exception $e) {
            return 'Audio berhasil diupload. Error transkripsi: ' . $e->getMessage();
        }
    }

    public function uploadTranscript(int $id, string $language, ?string $srtContent, $srtFile): void
    {
        $material = $this->repository->findMaterialByTypeId($id);
        if (!$material) {
            throw new \RuntimeException('Material not found.');
        }

        $content = '';
        if ($srtFile) {
            $content = file_get_contents($srtFile->getRealPath());
        } else {
            $content = (string) $srtContent;
        }

        if ($content === '') {
            throw new \RuntimeException('No content provided.');
        }

        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $blocks = $this->srtTranscriptParser->parse($content);

        $finalText = $blocks === [] ? $content : json_encode($blocks);
        $column = $language === 'en' ? 'transcript_en' : 'transcript_id';
        $this->repository->updateMaterial($material->id, [$column => $finalText]);
    }

    public function updateAnswerKey(int $id, string $answerKey): void
    {
        $material = $this->repository->findMaterialByTypeId($id);
        if (!$material) {
            throw new \RuntimeException('Material not found.');
        }
        $this->repository->updateMaterial($material->id, ['answer_key' => $answerKey]);
    }
}