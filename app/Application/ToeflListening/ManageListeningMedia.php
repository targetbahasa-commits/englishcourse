<?php

namespace App\Application\ToeflListening;

use App\Application\ToeflListeningPractice\ToeflListeningSourceAudioOptions;
use App\Application\ToeflMockup\MockupMediaStorage;
use App\Application\ToeflMockup\SrtTranscriptParser;
use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;
use App\Services\WhisperTranscriptionService;

class ManageListeningMedia
{
    public function __construct(
        private readonly ToeflListeningSourceAudioOptions $sourceAudioOptions,
        private readonly MockupMediaStorage $mediaStorage,
        private readonly SrtTranscriptParser $srtTranscriptParser,
        private readonly ToeflListeningRepository $repository,
        private readonly WhisperTranscriptionService $whisper,
    ) {
    }

    public function sourceAudioOptions(): array
    {
        return $this->sourceAudioOptions->handle();
    }

    public function updateTranscript(int $number, int $set, ?string $transcriptEn, ?string $transcriptId): void
    {
        $this->repository->updateTranscriptByMeetingAndSet($number, $set, $transcriptEn, $transcriptId);
    }

    public function uploadSrt(int $number, int $set, string $language, string $content): bool
    {
        if ($content === '') {
            return false;
        }

        $content = $this->srtTranscriptParser->normalizeContent($content);
        $finalText = $this->parseSrtContentForStorage($content);
        $column = $language === 'en' ? 'transcript_en' : 'transcript_id';

        $this->storeToeflListeningTranscriptFile($number, $set, $language, $content);

        $this->repository->updateSingleTranscript($number, $set, $language, $finalText);

        return true;
    }

    public function uploadAudio(int $number, int $set, $audioFile = null, ?string $existingAudioPath = null): string
    {
        $existingQuestion = $this->repository->findFirstQuestionByMeetingAndSet($number, $set);

        if ($existingQuestion && $existingQuestion->audio_file) {
            $this->mediaStorage->deletePublicFile($existingQuestion->audio_file);
        }

        $directory = $this->getToeflListeningSetDirectory($number, $set);
        $publicPath = $this->mediaStorage->ensurePublicDirectoryExists($directory);
        $filename = null;

        if ($audioFile) {
            try {
                $audioPath = $this->mediaStorage->storeUploadedFileWithExtension($directory, $audioFile, 'audio');
                $filename = basename($audioPath);
            } catch (\RuntimeException $exception) {
                return $exception->getMessage();
            }
        } else {
            try {
                $audioPath = $this->mediaStorage->copySelectedToeflListeningAudio((string) $existingAudioPath, $publicPath, $directory);
                $filename = basename($audioPath);
            } catch (\RuntimeException $exception) {
                return $exception->getMessage();
            }
        }

        if (!file_exists($publicPath . '/' . $filename)) {
            return 'Audio file was not saved correctly.';
        }

        $this->repository->updateAudioByMeetingAndSet($number, $set, $audioPath);

        // ── Auto-transcribe + translate (runs for both Upload and Choose Audio) ─
        try {
            $fullAudioPath = public_path($audioPath);

            $transcription = $this->whisper->transcribeAndTranslate($fullAudioPath, $publicPath);

            if ($transcription['srt_en']) {
                $this->storeToeflListeningTranscriptFile($number, $set, 'en', $transcription['srt_en']);
                $this->repository->updateSingleTranscript($number, $set, 'en', $this->parseSrtContentForStorage($transcription['srt_en']));
            }

            if ($transcription['id']) {
                $this->repository->updateSingleTranscript($number, $set, 'id', $transcription['id']);
            }

            return $transcription['message']
                ?: ($audioFile ? 'Audio berhasil diupload.' : 'Audio dari folder berhasil dipilih.') . ' Transkripsi ' . ($transcription['success'] ? 'selesai.' : 'gagal.');
        } catch (\Exception $e) {
            $baseMsg = $audioFile ? 'Audio berhasil diupload!' : 'Audio berhasil dipilih dari folder!';
            return $baseMsg . ' Error transkripsi: ' . $e->getMessage();
        }
    }

    private function getToeflListeningSetDirectory(int $number, int $set): string
    {
        return "audio/toefl/listening/meeting-{$number}/set-{$set}";
    }

    private function parseSrtContentForStorage(string $content): string
    {
        $content = $this->srtTranscriptParser->normalizeContent($content);
        $pattern = '/(\d+)\s+(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s*-->\s*(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s+([\s\S]*?)(?=(?:\n\s*\d+\s+\d{1,2}:\d{2}:\d{2})|$)/';

        $blocks = [];
        $matches = [];

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $startTime = $this->srtTimeToSeconds($match[2]);
                $endTime = $this->srtTimeToSeconds($match[3]);
                $text = trim(str_replace("\n", ' ', $match[4]));

                if ($text !== '') {
                    $blocks[] = [
                        'start' => $startTime,
                        'end' => $endTime,
                        'text' => $text,
                    ];
                }
            }
        }

        if ($blocks === []) {
            return $matches === [] ? $content : json_encode($blocks);
        }

        return json_encode($blocks);
    }

    private function getToeflListeningTranscriptPublicPath(int $number, int $set, string $language): string
    {
        return $this->mediaStorage->publicFilePath(
            $this->getToeflListeningSetDirectory($number, $set),
            'transcript-' . $language . '.srt'
        );
    }

    private function storeToeflListeningTranscriptFile(int $number, int $set, string $language, string $content): void
    {
        $this->mediaStorage->writePublicFile(
            $this->getToeflListeningSetDirectory($number, $set),
            'transcript-' . $language . '.srt',
            $this->srtTranscriptParser->normalizeContent($content)
        );
    }

    private function srtTimeToSeconds(string $time): float
    {
        [$hours, $minutes, $seconds] = preg_split('/[:]/', str_replace(',', '.', $time));

        return ((float) $hours * 3600) + ((float) $minutes * 60) + (float) $seconds;
    }
}