<?php

namespace App\Application\ToeflListeningPractice;

use App\Application\ToeflMockup\MockupMediaStorage;
use App\Application\ToeflMockup\SrtTranscriptParser;
use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;
use App\Services\WhisperTranscriptionService;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class ManageListeningPracticePackageMedia
{
    public function __construct(
        private readonly ListeningPracticeRepository $listeningPracticeRepository,
        private readonly MockupMediaStorage $mediaStorage,
        private readonly SrtTranscriptParser $srtTranscriptParser,
        private readonly WhisperTranscriptionService $whisper,
    ) {
    }

    public function updateAudio(int $package, ?UploadedFile $audioFile, ?string $existingAudioPath): array
    {
        $questions = collect($this->listeningPracticeRepository->getAllQuestions());

        if ($questions->isEmpty()) {
            throw new RuntimeException('Listening questions for this package are not available yet.');
        }

        $currentAudioPath = (string) ($questions->first()->audio_file ?? '');
        $this->mediaStorage->deletePublicFileWithinPrefix(
            $currentAudioPath,
            'audio/toefl/listening/practice/package-' . $package . '/'
        );

        $directory  = 'audio/toefl/listening/practice/package-' . $package;
        $publicPath = $this->mediaStorage->ensurePublicDirectoryExists($directory);
        $audioPath  = $this->storeAudio($audioFile, $existingAudioPath, $publicPath, $directory);

        $this->listeningPracticeRepository->updateAllQuestionAudio($audioPath);

        // ── Auto-transcribe + translate (runs for both Upload and Choose Audio) ─
        try {
            $fullAudioPath = public_path($audioPath);
            $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicPath);

            $updates = [];
            if ($transcription['en']) {
                $updates['transcript_en'] = $transcription['en'];
            }
            if ($transcription['id']) {
                $updates['transcript_id'] = $transcription['id'];
            }
            if (!empty($updates)) {
                $this->listeningPracticeRepository->updateAllQuestionTranscripts($updates);
            }

            $baseMsg = $audioFile !== null ? 'Audio berhasil diupload.' : 'Audio dari folder berhasil dipilih.';
            return ['message' => $transcription['message'] ?: $baseMsg . ' Transkripsi ' . ($transcription['success'] ? 'selesai.' : 'gagal.')];
        } catch (\Exception $e) {
            $baseMsg = $audioFile !== null ? 'Audio berhasil diupload.' : 'Audio berhasil dipilih dari folder.';
            return ['message' => $baseMsg . ' Error transkripsi: ' . $e->getMessage()];
        }
    }

    public function updateTranscript(?string $transcriptEn, ?string $transcriptId): void
    {
        $this->listeningPracticeRepository->updateAllQuestionTranscripts([
            'transcript_en' => $transcriptEn,
            'transcript_id' => $transcriptId,
        ]);
    }

    public function uploadSrt(int $package, string $content, string $language): void
    {
        $normalizedContent = $this->srtTranscriptParser->normalizeContent($content);
        $parsedBlocks = $this->srtTranscriptParser->parse($normalizedContent);
        $finalText = $parsedBlocks === [] ? $normalizedContent : json_encode($parsedBlocks);
        $column = $language === 'en' ? 'transcript_en' : 'transcript_id';

        $this->listeningPracticeRepository->updateAllQuestionTranscripts([$column => $finalText]);

        $directory = 'audio/toefl/listening/practice/package-' . $package;
        $filename = $language === 'en' ? 'transcript_en.srt' : 'transcript_id.srt';
        $this->mediaStorage->writePublicFile($directory, $filename, $normalizedContent);
    }

    private function storeAudio(?UploadedFile $audioFile, ?string $existingAudioPath, string $publicPath, string $directory): string
    {
        if ($audioFile !== null) {
            return $this->mediaStorage->storeUploadedFileWithExtension($directory, $audioFile, 'audio');
        }

        return $this->mediaStorage->copySelectedToeflListeningAudio((string) $existingAudioPath, $publicPath, $directory);
    }
}