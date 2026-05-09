<?php

namespace App\Infrastructure\ToeflListening;

use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;
use App\Models\ClassPeriod;
use App\Models\ClassPeriodToeflMeeting;
use App\Models\ToeflListeningMeeting;
use App\Models\ToeflListeningQuestion;
use App\Models\ToeflListeningScore;

class EloquentToeflListeningRepository implements ToeflListeningRepository
{
    public function getAllMeetings(): array
    {
        return ToeflListeningMeeting::orderBy('meeting_number')->get()->all();
    }

    public function findMeetingByNumber(int $number): mixed
    {
        return ToeflListeningMeeting::where('meeting_number', $number)->first();
    }

    public function findMeetingByNumberOrFail(int $number): mixed
    {
        return ToeflListeningMeeting::where('meeting_number', $number)->firstOrFail();
    }

    public function getModuleLockMap(int $classPeriodId, string $module): array
    {
        return ClassPeriodToeflMeeting::where('class_period_id', $classPeriodId)
            ->where('module', $module)
            ->pluck('is_open', 'meeting_number')
            ->all();
    }

    public function getScoreForUser(int $userId, int $meetingNumber, ?int $setNumber = null): mixed
    {
        $query = ToeflListeningScore::where('user_id', $userId)
            ->where('meeting_number', $meetingNumber);

        if ($setNumber !== null) {
            $query->where('set_number', $setNumber);
        }

        return $query->first();
    }

    public function getQuestions(int $meetingNumber, ?int $setNumber = null): array
    {
        $query = ToeflListeningQuestion::byMeeting($meetingNumber);

        if ($setNumber !== null) {
            $query->where('set_number', $setNumber);
        }

        return $query->get()->all();
    }

    public function getAvailableSets(int $meetingNumber): array
    {
        return ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->distinct()
            ->pluck('set_number')
            ->sort()
            ->values()
            ->toArray();
    }

    public function getMaxSetNumber(int $meetingNumber): ?int
    {
        return ToeflListeningQuestion::where('meeting_number', $meetingNumber)->max('set_number');
    }

    public function createQuestion(array $data): void
    {
        ToeflListeningQuestion::create($data);
    }

    public function deleteQuestionsByMeetingAndSet(int $meetingNumber, int $setNumber): bool
    {
        return (bool) ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
    }

    public function findQuestion(int $id): mixed
    {
        return ToeflListeningQuestion::findOrFail($id);
    }

    public function updateQuestion(int $id, array $data): void
    {
        ToeflListeningQuestion::findOrFail($id)->update($data);
    }

    public function deleteQuestion(int $id): void
    {
        ToeflListeningQuestion::findOrFail($id)->delete();
    }

    public function findBatchRuleForMeeting(int $classPeriodId, string $module, int $meetingNumber): mixed
    {
        return ClassPeriodToeflMeeting::where('class_period_id', $classPeriodId)
            ->where('module', $module)
            ->where('meeting_number', $meetingNumber)
            ->first();
    }

    public function createBatchRule(array $data): void
    {
        ClassPeriodToeflMeeting::create($data);
    }

    public function updateBatchRule(int $id, bool $isOpen): void
    {
        ClassPeriodToeflMeeting::findOrFail($id)->update(['is_open' => $isOpen]);
    }

    public function findClassPeriod(int $classPeriodId): mixed
    {
        return ClassPeriod::find($classPeriodId);
    }

    public function toggleMeetingLock(int $meetingNumber): void
    {
        $meeting = ToeflListeningMeeting::where('meeting_number', $meetingNumber)->firstOrFail();
        $meeting->is_locked = !$meeting->is_locked;
        $meeting->save();
    }

    public function toggleMeetingTranscript(int $meetingNumber): string
    {
        $meeting = ToeflListeningMeeting::where('meeting_number', $meetingNumber)->firstOrFail();
        $meeting->transcript_enabled = !$meeting->transcript_enabled;
        $meeting->save();

        return 'Transcript ' . ($meeting->transcript_enabled ? 'enabled' : 'disabled') . ' for Meeting ' . $meetingNumber;
    }

    public function saveScore(array $criteria, array $data): void
    {
        ToeflListeningScore::updateOrCreate($criteria, $data);
    }

    public function updateTranscriptByMeetingAndSet(int $number, int $set, ?string $en, ?string $id): void
    {
        ToeflListeningQuestion::where('meeting_number', $number)
            ->where('set_number', $set)
            ->update([
                'transcript_en' => $en,
                'transcript_id' => $id,
            ]);
    }

    public function findFirstQuestionByMeetingAndSet(int $number, int $set): mixed
    {
        return ToeflListeningQuestion::where('meeting_number', $number)
            ->where('set_number', $set)
            ->first();
    }

    public function updateAudioByMeetingAndSet(int $number, int $set, string $audioPath): void
    {
        ToeflListeningQuestion::where('meeting_number', $number)
            ->where('set_number', $set)
            ->update(['audio_file' => $audioPath]);
    }

    public function updateSingleTranscript(int $number, int $set, string $language, string $text): void
    {
        $column = $language === 'en' ? 'transcript_en' : 'transcript_id';
        ToeflListeningQuestion::where('meeting_number', $number)
            ->where('set_number', $set)
            ->update([$column => $text]);
    }
}
