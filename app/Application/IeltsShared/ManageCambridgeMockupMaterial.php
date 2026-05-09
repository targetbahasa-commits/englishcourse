<?php

namespace App\Application\IeltsShared;

use App\Application\ToeflMockup\MockupMediaStorage;
use App\Application\ToeflMockup\SrtTranscriptParser;
use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;
use Illuminate\Http\UploadedFile;

class ManageCambridgeMockupMaterial
{
    public function __construct(
        private readonly MockupMediaStorage $mediaStorage,
        private readonly SrtTranscriptParser $srtTranscriptParser,
        private readonly IeltsSharedRepository $repository,
    ) {
    }

    public function uploadAudio(int $edition, int $id, UploadedFile $file): void
    {
        $material = $this->findOrCreate($edition, $id);

        $directory = "audio/ielts-academic/mockup/cambridge-{$edition}-test-{$id}";
        $audioPath = $this->mediaStorage->storeUploadedFileWithExtension($directory, $file, 'audio');

        $this->mediaStorage->deletePublicFile($material->audio_file);

        $material->update(['audio_file' => $audioPath]);
    }

    public function uploadSrt(int $edition, int $id, string $content, string $language): void
    {
        $material = $this->findOrCreate($edition, $id);

        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $blocks   = $this->srtTranscriptParser->parse($content);
        $finalText = empty($blocks) ? $content : json_encode($blocks);

        $column = $language === 'en' ? 'transcript_en' : 'transcript_id';
        $material->update([$column => $finalText]);
    }

    public function updateAnswerKey(int $edition, int $id, string $answerKey): void
    {
        $material = $this->findOrCreate($edition, $id);
        $material->update(['answer_key' => $answerKey]);
    }

    private function findOrCreate(int $edition, int $id): mixed
    {
        $uniqueTestId = $edition . str_pad((string) $id, 2, '0', STR_PAD_LEFT);

        return $this->repository->findOrCreateMockupByTestId($uniqueTestId);
    }
}
