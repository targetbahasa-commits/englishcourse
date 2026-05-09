<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;
use Illuminate\Http\UploadedFile;

class ManageIeltsWritingContent
{
    public function __construct(
        private readonly IeltsWritingRepository $repository,
    ) {}

    public function createMeeting(array $attributes): void
    {
        $this->repository->createMeeting($attributes);
    }

    public function updateMeeting(int $id, array $attributes, ?UploadedFile $image = null): void
    {
        $data = $attributes;

        if ($image) {
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/practice'), $imageName);
            $data['image'] = 'images/practice/' . $imageName;
        }

        $this->repository->updateMeeting($id, $data);
    }

    public function deleteMeeting(int $id): void
    {
        $this->repository->deleteMeeting($id);
    }

    public function toggleMeetingLock(int $id): bool
    {
        return $this->repository->toggleMeetingLock($id);
    }

    public function toggleSpeakingLock(int $id): bool
    {
        return $this->repository->toggleSpeakingTopicLock($id);
    }

    public function createQuestion(array $attributes): void
    {
        $this->repository->createQuestion($attributes);
    }

    public function updateQuestion(int $id, array $attributes): void
    {
        $this->repository->updateQuestion($id, $attributes);
    }

    public function deleteQuestion(int $id): void
    {
        $this->repository->deleteQuestion($id);
    }

    public function reorderMeetings(array $order): void
    {
        $this->repository->reorderMeetings($order);
    }
}
