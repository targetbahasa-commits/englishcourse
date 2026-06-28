<?php

namespace App\Application\IeltsWriting;

use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;
use App\Models\IeltsWritingMeeting;

class ResolveIeltsWritingNavigation
{
    public function __construct(
        private readonly IeltsWritingRepository $repository,
    ) {}
    public function buildPracticeIndexData(?string $task, ?string $type): array
    {
        $items = collect();
        $task2Meetings = collect();

        if ($task == '1' && $type && isset($this->practiceRanges()[$type])) {
            [$min, $max] = $this->practiceRanges()[$type];
            $items = $this->repository->getMeetingsBetweenNumbers($min, $max, 'practice_item', 1);
        }

        $task2Types = ['advantages_disadvantages', 'opinion', 'agree_disagree', 'problem_solution', 'discussion'];
        if ($task == '2' && $type && in_array($type, $task2Types, true)) {
            $task2Meetings = $this->repository->getMeetingsByTaskAndViewType(2, 'practice', $type);
        }

        return [
            'items' => $items,
            'task2Meetings' => $task2Meetings,
        ];
    }

    public function determineBackUrl(int $task, IeltsWritingMeeting $meeting): string
    {
        if ($meeting->category === 'practice' && (int) $meeting->task_type === 2) {
            return route('assignments.ielts-academic.writing.practice.index', [
                'task' => 2,
                'type' => $meeting->view_type,
            ]);
        }

        if ($meeting->category === 'practice_item') {
            $practiceType = $this->practiceItemType($meeting->meeting_number);
            if ($practiceType !== null) {
                return route('assignments.ielts-academic.writing.practice.index', [
                    'task' => $task,
                    'type' => $practiceType,
                ]);
            }

            $parent = $this->resolvePracticeItemParent($meeting->meeting_number);
            if ($parent) {
                return route('assignments.ielts-academic.writing.meeting', ['task' => $task, 'id' => $parent->id]);
            }
        }

        return route('assignments.ielts-academic.writing.index', ['task' => $task]);
    }

    public function practiceSelectionRange(int $meetingNumber): array
    {
        return match ($meetingNumber) {
            100 => [101, 105],
            111 => [106, 110],
            120 => [112, 116],
            130 => [121, 125],
            101 => [1010, 1019],
            102 => [1020, 1029],
            103 => [1030, 1039],
            104 => [1040, 1049],
            105 => [1050, 1059],
            106 => [1060, 1069],
            107 => [1070, 1079],
            default => [101, 105],
        };
    }

    public function resolveMeetingView(?string $viewType): string
    {
        return match ($viewType) {
            'graphical_sentences' => 'assignments.ielts.writing.graphical_sentences',
            'connecting_trend' => 'assignments.ielts.writing.connecting_trend',
            'graphical_practice' => 'assignments.ielts.writing.graphical_practice',
            'layout_builder' => 'assignments.ielts.writing.layout_builder',
            'layout_builder_3body' => 'assignments.ielts.writing.layout_builder_3body',
            'lesson_introduction' => 'assignments.ielts.writing.lesson_introduction',
            'labeling_trends' => 'assignments.ielts.writing.labeling_trends',
            'parts_of_paragraph' => 'assignments.ielts.writing.parts_of_paragraph',
            'using_prepositions' => 'assignments.ielts.writing.using_prepositions',
            'numbers_percentages' => 'assignments.ielts.writing.numbers_percentages',
            'comparison_structures' => 'assignments.ielts.writing.comparison_structures',
            'reducing_clauses' => 'assignments.ielts.writing.reducing_clauses',
            'writing_introduction' => 'assignments.ielts.writing.introduction',
            'writing_overview' => 'assignments.ielts.writing.overview',
            'writing_body' => 'assignments.ielts.writing.body_paragraph',
            'writing_practice' => 'assignments.ielts.writing.practice_view',
            default => 'assignments.ielts.writing.meeting',
        };
    }

    public function practiceRanges(): array
    {
        return [
            'line' => [1010, 1029],
            'bar' => [1030, 1049],
            'pie' => [1050, 1069],
            'table' => [1070, 1089],
            'mixed' => [1090, 1109],
            'flowchart' => [1110, 1129],
            'mapping' => [1130, 1149],
        ];
    }

    public function practiceItemType(int $meetingNumber): ?string
    {
        return match (true) {
            $meetingNumber >= 1010 && $meetingNumber <= 1029 => 'line',
            $meetingNumber >= 1030 && $meetingNumber <= 1049 => 'bar',
            $meetingNumber >= 1050 && $meetingNumber <= 1069 => 'pie',
            $meetingNumber >= 1070 && $meetingNumber <= 1089 => 'table',
            $meetingNumber >= 1090 && $meetingNumber <= 1109 => 'mixed',
            $meetingNumber >= 1110 && $meetingNumber <= 1129 => 'flowchart',
            $meetingNumber >= 1130 && $meetingNumber <= 1149 => 'mapping',
            default => null,
        };
    }

    public function resolvePracticeItemParent(int $meetingNumber): mixed
    {
        $parentNumber = match (true) {
            $meetingNumber >= 101 && $meetingNumber <= 105 => 100,
            $meetingNumber >= 106 && $meetingNumber <= 110 => 111,
            $meetingNumber >= 112 && $meetingNumber <= 116 => 120,
            $meetingNumber >= 121 && $meetingNumber <= 125 => 130,
            $meetingNumber >= 1010 && $meetingNumber <= 1019 => 101,
            $meetingNumber >= 1020 && $meetingNumber <= 1029 => 102,
            $meetingNumber >= 1030 && $meetingNumber <= 1039 => 103,
            $meetingNumber >= 1040 && $meetingNumber <= 1049 => 104,
            $meetingNumber >= 1050 && $meetingNumber <= 1059 => 105,
            $meetingNumber >= 1060 && $meetingNumber <= 1069 => 106,
            $meetingNumber >= 1070 && $meetingNumber <= 1079 => 107,
            default => null,
        };

        if (!$parentNumber) {
            return null;
        }

        return $this->repository->findMeetingByNumber($parentNumber);
    }
}