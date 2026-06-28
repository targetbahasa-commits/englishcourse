<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use App\Services\WhisperTranscriptionService;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class UploadMockupListeningAudio
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly MockupMediaStorage $mediaStorage,
        private readonly WhisperTranscriptionService $whisper,
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

        $directory  = 'audio/toefl-itp/mockup/package-' . $package;
        $publicPath = $this->mediaStorage->ensurePublicDirectoryExists($directory);
        $selectedPath = $this->mediaStorage->resolveSelectedAudioPath($audioFile, $existingAudioPath, $publicPath, $directory, 'audio');

        $this->mediaRepository->updateListeningAudio($package, $questionId, $selectedPath);

        // ── Auto-transcribe + translate (runs for both Upload and Choose Audio) ─
        // Only run transcription for the whole-package audio (questionId is null)
        if ($questionId === null) {
            try {
                $fullAudioPath = public_path($selectedPath);
                $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicPath);

                $updates = [];
                if ($transcription['en']) {
                    $updates['transcript_en'] = $transcription['en'];
                }
                if ($transcription['id']) {
                    $updates['transcript_id'] = $transcription['id'];
                }
                if (!empty($updates)) {
                    $this->mediaRepository->updateListeningTranscript($package, $updates);
                }

                $baseMsg = $audioFile !== null ? 'Audio berhasil diupload.' : 'Audio dari folder berhasil dipilih.';
                return ['message' => $transcription['message'] ?: $baseMsg . ' Transkripsi ' . ($transcription['success'] ? 'selesai.' : 'gagal.')];
            } catch (\Exception $e) {
                $baseMsg = $audioFile !== null ? 'Mockup audio uploaded successfully!' : 'Audio dari folder berhasil dipilih.';
                return ['message' => $baseMsg . ' Error transkripsi: ' . $e->getMessage()];
            }
        }

        return [
            'message' => $questionId !== null
                ? 'Audio untuk soal terpilih berhasil diupdate.'
                : 'Mockup audio uploaded successfully!',
        ];
    }
}