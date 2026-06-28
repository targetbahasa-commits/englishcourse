<?php

namespace App\Application\IeltsShared;

use App\Application\ToeflMockup\MockupMediaStorage;
use App\Application\ToeflMockup\SrtTranscriptParser;
use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;
use App\Services\WhisperTranscriptionService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ManageCambridgeMockupMaterial
{
    public function __construct(
        private readonly MockupMediaStorage $mediaStorage,
        private readonly SrtTranscriptParser $srtTranscriptParser,
        private readonly IeltsSharedRepository $repository,
        private readonly WhisperTranscriptionService $whisper,
    ) {
    }

    public function uploadAudio(int $edition, int $id, int $part, UploadedFile $file, bool $autoTranscribe = true): void
    {
        $material = $this->findOrCreate($edition, $id);

        $directory = "audio/ielts-academic/mockup/cambridge-{$edition}-test-{$id}";
        $column = 'audio_file_' . $part;
        $oldPath = $material->{$column};

        $audioPath = $this->mediaStorage->storeUploadedFileWithExtension($directory, $file, "audio_part_{$part}", true);

        if ($oldPath && $oldPath !== $audioPath) {
            $this->mediaStorage->deletePublicFile($oldPath);
        }

        $material->update([
            $column => $audioPath,
            'transcript_en_' . $part => null,
            'transcript_id_' . $part => null,
        ]);

        if ($autoTranscribe) {
            $this->dispatchTranscriptionBackground($edition, $id, $part);
        }
    }

    public function transcribeExistingAudio(int $edition, int $id, int $part): void
    {
        $material = $this->findOrCreate($edition, $id);
        $column = 'audio_file_' . $part;
        if (empty($material->{$column})) {
            throw new \RuntimeException('Audio file not found.');
        }

        $audioPath = $material->{$column};
        $publicPath = public_path();
        $fullAudioPath = public_path($audioPath);

        $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicPath);
        
        if (!empty($transcription['formatted_en'])) {
            $material->update(['transcript_en_' . $part => $transcription['formatted_en']]);
        } elseif (!empty($transcription['srt_en'])) {
            $blocksEn = $this->srtTranscriptParser->parse($transcription['srt_en']);
            $material->update(['transcript_en_' . $part => json_encode($blocksEn)]);
        }
        
        if (!empty($transcription['formatted_id'])) {
            $material->update(['transcript_id_' . $part => $transcription['formatted_id']]);
        } elseif (!empty($transcription['id'])) {
            $material->update(['transcript_id_' . $part => $transcription['id']]);
        }
    }

    public function uploadSrt(int $edition, int $id, int $part, string $content, string $language): void
    {
        $material = $this->findOrCreate($edition, $id);

        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $blocks   = $this->srtTranscriptParser->parse($content);
        $finalText = empty($blocks) ? $content : json_encode($blocks);

        $column = ($language === 'en' ? 'transcript_en_' : 'transcript_id_') . $part;
        $material->update([$column => $finalText]);
    }

    public function updateAnswerKey(int $edition, int $id, int $part, string $answerKey): void
    {
        $material = $this->findOrCreate($edition, $id);
        $material->update(['answer_key_' . $part => $answerKey]);
    }

    /**
     * Dispatch the Whisper transcription as a detached background process so the
     * HTTP request can return immediately (avoids Apache 500 timeout).
     */
    private function dispatchTranscriptionBackground(int $edition, int $id, int $part): void
    {
        $phpBin  = PHP_BINARY;
        $artisan = base_path('artisan');
        $logFile = storage_path("logs/transcribe-cambridge-{$edition}-{$id}-{$part}.log");

        // Build command: run artisan in background, redirect output to a log file
        $cmd = escapeshellcmd($phpBin)
             . ' ' . escapeshellarg($artisan)
             . ' cambridge:transcribe-audio'
             . ' ' . (int) $edition
             . ' ' . (int) $id
             . ' ' . (int) $part
             . ' >> ' . escapeshellarg($logFile)
             . ' 2>&1 &';

        exec($cmd);

        Log::info("cambridge:transcribe-audio dispatched in background for Cambridge {$edition} Test {$id} Part {$part}");
    }

    private function findOrCreate(int $edition, int $id): mixed
    {
        $uniqueTestId = $edition . str_pad((string) $id, 2, '0', STR_PAD_LEFT);

        return $this->repository->findOrCreateMockupByTestId($uniqueTestId);
    }
}
