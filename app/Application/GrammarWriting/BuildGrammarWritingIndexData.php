<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;

class BuildGrammarWritingIndexData
{
    public function __construct(
        private readonly GrammarWritingRepository $repository
    ) {}

    public function handle(mixed $user): array
    {
        $program = $this->repository->findProgramBySlugWithMeetingsAndClassPeriods('grammar-for-writing');

        $selectedClassPeriod = null;
        if (!empty($program->period)) {
            $selectedClassPeriod = $program->classPeriods->firstWhere('name', $program->period);
        }

        $periodMeetingStatus = collect();
        if ($selectedClassPeriod) {
            $periodMeetingStatus = $selectedClassPeriod->meetings()
                ->pluck('class_period_meetings.is_open', 'meetings.id');
        }

        $program->meetings->transform(function ($meeting) use ($user, $selectedClassPeriod, $periodMeetingStatus) {
            if ($selectedClassPeriod) {
                $meeting->is_locked = !((bool) ($periodMeetingStatus[$meeting->id] ?? false));
            } else {
                $meeting->is_locked = $meeting->isLockedFor($user);
            }

            return $meeting;
        });

        return [
            'program' => $program,
            'scores' => $this->repository->getScoresForUser($user?->id),
            'meetingTopics' => $this->meetingTopics(),
            'selectedClassPeriod' => $selectedClassPeriod,
        ];
    }

    private function meetingTopics(): array
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