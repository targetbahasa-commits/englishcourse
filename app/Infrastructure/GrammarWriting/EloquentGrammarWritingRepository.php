<?php

namespace App\Infrastructure\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;
use App\Models\ClassPeriod;
use App\Models\GrammarQuestion;
use App\Models\GrammarVocabulary;
use App\Models\Meeting;
use App\Models\MeetingScore;
use App\Models\Program;

class EloquentGrammarWritingRepository implements GrammarWritingRepository
{
    public function getQuestionsByMeetingExcludingParagraph(int $meetingNumber): array
    {
        return GrammarQuestion::where('meeting_number', $meetingNumber)
            ->where('question_type', '!=', 'paragraph')
            ->get()->all();
    }

    public function getQuestionsByMeetingWithNullSection(int $meetingNumber): array
    {
        return GrammarQuestion::where('meeting_number', $meetingNumber)
            ->whereNull('section')
            ->where('question_type', '!=', 'paragraph')
            ->get()->all();
    }

    public function getQuestionsByMeetingAndSection(int $meetingNumber, string $section): array
    {
        return GrammarQuestion::where('meeting_number', $meetingNumber)
            ->where('section', $section)
            ->get()->all();
    }

    public function getLegacyQuestionsByMeeting(int $meetingNumber, ?string $section = null): array
    {
        $query = GrammarQuestion::where('meeting_number', $meetingNumber)
            ->orderBy('question_number');

        if ($section !== null) {
            $query->where('section', $section);
        }

        return $query->get()->all();
    }

    public function getParagraphQuestion(int $meetingNumber, bool $useSection = true): mixed
    {
        $query = GrammarQuestion::where('meeting_number', $meetingNumber);

        if (\Illuminate\Support\Facades\Schema::hasColumn('grammar_questions', 'question_type')) {
            $query->where('question_type', 'paragraph');
        }

        if ($useSection) {
            $query->where('section', 'paragraph');
        } else {
            $query->where('question_number', 999);
        }

        return $query->first();
    }

    public function getQuestionsBySectionForMeeting(int $meetingNumber, string $section): array
    {
        return GrammarQuestion::where('meeting_number', $meetingNumber)
            ->where('section', $section)
            ->orderBy('question_number')
            ->get()->all();
    }

    public function createQuestion(array $data): void
    {
        GrammarQuestion::create($data);
    }

    public function getVocabularyByMeeting(int $meetingNumber): array
    {
        return GrammarVocabulary::where('meeting_number', $meetingNumber)->get()->all();
    }

    public function updateQuestion(int $id, array $data): void
    {
        GrammarQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        GrammarQuestion::findOrFail($id)->delete();
    }

    public function createVocabulary(array $data): void
    {
        GrammarVocabulary::create($data);
    }

    public function updateVocabulary(int $id, array $data): void
    {
        GrammarVocabulary::findOrFail($id)->update($data);
    }

    public function deleteVocabulary(int $id): void
    {
        GrammarVocabulary::findOrFail($id)->delete();
    }

    public function findProgramBySlugWithMeetingsAndClassPeriods(string $slug): mixed
    {
        return Program::where('slug', $slug)
            ->with(['meetings', 'classPeriods'])
            ->firstOrFail();
    }

    public function findProgramByIdWithClassPeriods(int $id): mixed
    {
        return Program::with('classPeriods')->findOrFail($id);
    }

    public function updateProgram(int $id, array $data): void
    {
        Program::findOrFail($id)->update($data);
    }

    public function getScoresForUser(?int $userId): array
    {
        if (!$userId) {
            return [];
        }

        return MeetingScore::where('is_reported', true)->where('user_id', $userId)->pluck('score', 'meeting_number')->toArray();
    }

    public function findMeetingOrFail(int $id): mixed
    {
        return Meeting::findOrFail($id);
    }

    public function findClassPeriodForProgram(int $classPeriodId, int $programId): mixed
    {
        return ClassPeriod::where('id', $classPeriodId)
            ->where('program_id', $programId)
            ->first();
    }

    public function updateMeeting(int $id, array $data): void
    {
        Meeting::findOrFail($id)->update($data);
    }

    public function toggleMeetingLock(int $meetingId, ?int $classPeriodId): array
    {
        $meeting = Meeting::findOrFail($meetingId);

        if ($classPeriodId) {
            $classPeriod = ClassPeriod::where('id', $classPeriodId)
                ->where('program_id', $meeting->program_id)
                ->first();

            if ($classPeriod) {
                $existing = $classPeriod->meetings()->where('meeting_id', $meeting->id)->first();
                $isOpenNow = false;

                if ($existing) {
                    $isOpenNow = !$existing->pivot->is_open;
                    $classPeriod->meetings()->updateExistingPivot($meeting->id, [
                        'is_open' => $isOpenNow,
                    ]);
                } else {
                    $classPeriod->meetings()->attach($meeting->id, ['is_open' => true]);
                    $isOpenNow = true;
                }

                $newLabel = $isOpenNow ? 'OPEN' : 'LOCKED';

                return [
                    'message' => $meeting->title . ' is now ' . $newLabel . ' for batch ' . $classPeriod->name . '.',
                    'success_state' => $isOpenNow ? 'open' : 'locked',
                ];
            }
        }

        $meeting->update(['is_locked' => !$meeting->is_locked]);
        $newLabel = $meeting->is_locked ? 'LOCKED' : 'OPEN';

        return [
            'message' => $meeting->title . ' is now ' . $newLabel . '.',
            'success_state' => $meeting->is_locked ? 'locked' : 'open',
        ];
    }
}
