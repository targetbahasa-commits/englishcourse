<?php

namespace App\Application\IeltsWriting;

use App\Application\IeltsShared\IeltsBatchResolver;
use App\Application\ToeflShared\ToeflBatchResolver;
use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;

class BuildIeltsWritingIndexData
{
    public function __construct(
        private readonly IeltsBatchResolver $ieltsBatchResolver,
        private readonly ToeflBatchResolver $batchResolver,
        private readonly IeltsWritingRepository $repository,
    ) {
    }

    public function handle($user, ?string $task): array
    {
        $batchProgram = $this->ieltsBatchResolver->resolveBatchProgramForIelts($user);
        $selectedClassPeriod = $this->batchResolver->resolveSelectedClassPeriodForProgram($batchProgram);

        if ($task) {
            $allMeetings = $this->repository->getMeetingsByTaskAndCategory($task, 'lesson');

            return [
                'view' => 'assignments.ielts.writing.task_list',
                'data' => [
                    'task' => $task,
                    'lessons' => $allMeetings,
                    'batchProgram' => $batchProgram,
                    'selectedClassPeriod' => $selectedClassPeriod,
                ],
            ];
        }

        return [
            'view' => 'assignments.ielts.writing.index',
            'data' => [
                'meetings' => collect([]),
                'batchProgram' => $batchProgram,
                'selectedClassPeriod' => $selectedClassPeriod,
            ],
        ];
    }
}