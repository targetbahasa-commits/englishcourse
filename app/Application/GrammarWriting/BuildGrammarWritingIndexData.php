<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

class BuildGrammarWritingIndexData
{
    public function __construct(
        private readonly GrammarWritingRepository $repository
    ) {}

    public function handle(mixed $user, string $programSlug = 'fast-track-grammar-for-writing'): array
    {
        $program = $this->repository->findProgramBySlugWithMeetingsAndClassPeriods($programSlug);

        $selectedClassPeriod = null;
        if ($user && $user->isStudent()) {
            $enrollment = $user->enrollments()->where('program_id', $program->id)->whereHas('classPeriod')->first();
            if ($enrollment) {
                $selectedClassPeriod = $enrollment->classPeriod;
            }
        } elseif ($program->active_class_period_id) {
            $selectedClassPeriod = $program->classPeriods->firstWhere('id', $program->active_class_period_id);
        }

        $classMeetings = collect();
        if ($selectedClassPeriod) {
            $classMeetings = $selectedClassPeriod->classMeetings()->whereIn('meeting_id', $program->meetings->pluck('id'))->get()->keyBy('meeting_id');
        }

        $periodMeetingStatus = collect();
        if ($selectedClassPeriod) {
            $periodMeetingStatus = $selectedClassPeriod->meetings()
                ->pluck('class_period_meetings.is_open', 'meetings.id');
        }

        $program->meetings->transform(function ($meeting) use ($user, $selectedClassPeriod, $periodMeetingStatus, $classMeetings) {
            if ($selectedClassPeriod) {
                $meeting->is_locked = !((bool) ($periodMeetingStatus[$meeting->id] ?? false));
            } else {
                $meeting->is_locked = $meeting->isLockedFor($user);
            }
            
            $meeting->classMeeting = $classMeetings->get($meeting->id);

            return $meeting;
        });

        return [
            'program' => $program,
            'scores' => $this->repository->getScoresForUser($user?->id),
            'meetingTopics' => $this->meetingTopics(),
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }

    public function meetingTopics(): array
    {
        return [
            1 => 'Pronoun',
            2 => 'Tenses',
            3 => 'Menentukan Tenses',
            4 => 'Modal & Semi modal & Part of Speech',
            5 => 'Negative Sentences',
            6 => 'Verb Palsu (Gerund & To Infininitive)',
            7 => 'Noun Phrase',
            8 => 'Prepositional Phrase',
            9 => 'Writing Structure 1',
            10 => 'Comparative, Superlative, & Positive Degree',
            11 => 'FANBOYS',
            12 => 'Adverbial Clause',
            13 => 'Adjective Clause RPO',
            14 => 'Adjective Clause RPS',
            15 => 'Adjective Clause RPP & RA',
            16 => 'Writing Structure 2',
            17 => 'Noun Clause',
            18 => 'Reducing & Participle',
            19 => 'Adverb of Sentences, Verb, Adjective, and Adverb',
            20 => 'Writing Structure 3',
        ];
    }
}
