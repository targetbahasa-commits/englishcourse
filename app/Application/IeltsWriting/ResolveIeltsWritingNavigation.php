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

        if ($task == '1' && $type === 'flowchart') {
            // 1110-1129 is a second, older flowchart range in addition to
            // 1500-1549; both are shown together without dropping either.
            $items = collect($this->repository->getMeetingsBetweenNumbers(1110, 1129, 'practice_item', 1))
                ->merge($this->repository->getMeetingsBetweenNumbers(1500, 1549, 'practice_item', 1))
                ->sortBy('meeting_number')
                ->values()
                ->all();
        } elseif ($task == '1' && $type === 'mapping') {
            // 1130-1139 is a second, older map range (10 legacy images —
            // Paradise Island, Felixstone, etc.) in addition to 1600-1649;
            // both are shown together without dropping either.
            $items = collect($this->repository->getMeetingsBetweenNumbers(1130, 1139, 'practice_item', 1))
                ->merge($this->repository->getMeetingsBetweenNumbers(1600, 1649, 'practice_item', 1))
                ->sortBy('meeting_number')
                ->values()
                ->all();
        } elseif ($task == '1' && $type === 'bar') {
            // 1110-1129 belongs to the flowchart range and 1130-1139 to the
            // mapping range above, not bar, so both are excluded here to
            // avoid the same meetings appearing in more than one listing.
            $items = collect($this->repository->getMeetingsBetweenNumbers(1100, 1109, 'practice_item', 1))
                ->merge($this->repository->getMeetingsBetweenNumbers(1140, 1149, 'practice_item', 1))
                ->sortBy('meeting_number')
                ->values()
                ->all();
        } elseif ($task == '1' && $type && isset($this->practiceRanges()[$type])) {
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

    public function determineBackUrl(int $task, IeltsWritingMeeting $meeting, bool $isGeneral = false): string
    {
        // $isGeneral reflects which of the two identical routes (ielts-academic
        // vs ielts-general, both pointing at showMeeting) was actually used to
        // reach this page, so the back button returns to the same section
        // instead of always assuming academic.
        $practiceIndexRoute = $isGeneral
            ? 'assignments.ielts-general.writing.practice.index'
            : 'assignments.ielts-academic.writing.practice.index';
        $meetingRoute = $isGeneral
            ? 'assignments.ielts-general.writing.meeting'
            : 'assignments.ielts-academic.writing.meeting';
        $indexRoute = $isGeneral
            ? 'assignments.ielts-general.writing.index'
            : 'assignments.ielts-academic.writing.index';

        if ($meeting->category === 'practice' && (int) $meeting->task_type === 2) {
            return route($practiceIndexRoute, [
                'task' => 2,
                'type' => $meeting->view_type,
            ]);
        }

        if ($meeting->category === 'practice_item') {
            $practiceType = $this->practiceItemType($meeting->meeting_number);
            if ($practiceType !== null) {
                return route($practiceIndexRoute, [
                    'task' => $task,
                    'type' => $practiceType,
                ]);
            }

            $parent = $this->resolvePracticeItemParent($meeting->meeting_number);
            if ($parent) {
                return route($meetingRoute, ['task' => $task, 'id' => $parent->id]);
            }
        }

        return route($indexRoute, ['task' => $task]);
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
            // 'introduction'/'body_paragraph' (no 'writing_' prefix) are
            // what's actually stored for some existing meetings - without
            // these, they silently fell through to the generic essay page
            // (`default` below) instead of their intended guided-exercise
            // template. Kept alongside the prefixed values rather than
            // renamed, since it's safer to accept both spellings here than
            // to update the meeting rows themselves.
            'writing_introduction', 'introduction' => 'assignments.ielts.writing.introduction',
            'writing_overview' => 'assignments.ielts.writing.overview',
            'writing_body', 'body_paragraph' => 'assignments.ielts.writing.body_paragraph',
            // Same bare-vs-'writing_'-prefixed mismatch as above - at least
            // one real lesson ("Review & Practice: Discuss Both Views")
            // has the bare value and was falling through to the essay page.
            'writing_practice', 'practice_view' => 'assignments.ielts.writing.practice_view',
            default => 'assignments.ielts.writing.meeting',
        };
    }

    public function practiceRanges(): array
    {
        return [
            'line' => [1010, 1059],
            'bar' => [1100, 1149],
            'pie' => [1200, 1249],
            'table' => [1300, 1349],
            'mixed' => [1400, 1449],
            'flowchart' => [1500, 1549],
            'mapping' => [1600, 1649],
            'formal' => [2001, 2050],
            'informal' => [2051, 2100],
        ];
    }

    public function practiceItemType(int $meetingNumber): ?string
    {
        return match (true) {
            $meetingNumber >= 1010 && $meetingNumber <= 1059 => 'line',
            $meetingNumber >= 1110 && $meetingNumber <= 1129 => 'flowchart',
            $meetingNumber >= 1130 && $meetingNumber <= 1139 => 'mapping',
            ($meetingNumber >= 1100 && $meetingNumber <= 1109) || ($meetingNumber >= 1140 && $meetingNumber <= 1149) => 'bar',
            $meetingNumber >= 1200 && $meetingNumber <= 1249 => 'pie',
            $meetingNumber >= 1300 && $meetingNumber <= 1349 => 'table',
            $meetingNumber >= 1400 && $meetingNumber <= 1449 => 'mixed',
            $meetingNumber >= 1500 && $meetingNumber <= 1549 => 'flowchart',
            $meetingNumber >= 1600 && $meetingNumber <= 1649 => 'mapping',
            $meetingNumber >= 2001 && $meetingNumber <= 2050 => 'formal',
            $meetingNumber >= 2051 && $meetingNumber <= 2100 => 'informal',
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