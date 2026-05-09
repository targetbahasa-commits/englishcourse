<?php

namespace App\Application\ToeflListening;

use App\Application\ToeflMockup\MockupMediaStorage;
use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;

class ManageListeningQuestions
{
    public function __construct(
        private readonly MockupMediaStorage $mediaStorage,
        private readonly ToeflListeningRepository $repository,
    ) {
    }

    public function store(array $data, $audioFile = null): string
    {
        $payload = collect($data)->except(['id', 'audio_file'])->toArray();

        if ($audioFile) {
            $payload['audio_file'] = $this->mediaStorage->storeUploadedFileWithOriginalName('audio/listening', $audioFile, 'audio_');
        }

        if (!empty($data['id'])) {
            $question = $this->repository->findQuestion((int) $data['id']);

            if ($audioFile && $question->audio_file) {
                $this->mediaStorage->deletePublicFile($question->audio_file);
            }

            $this->repository->updateQuestion((int) $data['id'], $payload);

            return 'Question updated successfully.';
        }

        $this->repository->createQuestion($payload);

        return 'Question created successfully.';
    }

    public function delete(int $id): void
    {
        $question = $this->repository->findQuestion($id);

        if ($question->audio_file) {
            $this->mediaStorage->deletePublicFile($question->audio_file);
        }

        $this->repository->deleteQuestion($id);
    }
}