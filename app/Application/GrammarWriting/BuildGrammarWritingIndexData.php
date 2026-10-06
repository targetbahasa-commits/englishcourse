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

        // Auto-seed Fast Track meetings if they don't exist yet (for live server)
        if ($programSlug === 'fast-track-grammar-for-writing' && $program->meetings->isEmpty()) {
            $topics = [
                1 => 'Silang - silang tenses',
                2 => 'Latihan penerapan tenses',
                3 => 'Modal',
                4 => 'Negative sentence',
                5 => 'To Infinitive & Gerund',
                6 => 'Noun Phrase, Comparative, Superlative, & Positive Degree',
                7 => 'FANBOYS & Adverbial Clause',
                8 => 'Adjective Clause - RPS / RPO',
                9 => 'Adjective Clause RPP, RA',
                10 => 'Noun Clause & Prepositional Phrase',
            ];
            foreach ($topics as $i => $topic) {
                \App\Models\Meeting::firstOrCreate(
                    ['program_id' => $program->id, 'meeting_number' => $i],
                    ['title' => 'Meeting ' . $i, 'description' => 'Fast Track meeting ' . $i, 'order' => $i, 'is_locked' => false]
                );
            }
            $program->load('meetings'); // Reload meetings after creation
        }

        // Auto-seed Bonus Meeting 11 for Fast Track if missing (default is_locked = true)
        if ($programSlug === 'fast-track-grammar-for-writing' && $program) {
            $bonusMeeting = $program->meetings->firstWhere('meeting_number', 11);
            if (!$bonusMeeting) {
                \App\Models\Meeting::firstOrCreate(
                    ['program_id' => $program->id, 'meeting_number' => 11],
                    [
                        'title' => 'Pertemuan Bonus: Peringkasan (Reducing, Abridgement, Omitting)',
                        'description' => 'Materi & latihan komprehensif teknik peringkasan: Reducing, Abridgement, dan Omitting.',
                        'order' => 11,
                        'is_locked' => true,
                    ]
                );
                $program->load('meetings');
            }
        }

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

        // Keyed by meeting id, keeping the full pivot row (not just
        // is_open) - ClassPeriod::meetings() already declares
        // ->withTimestamps(), so pivot->updated_at is the exact moment an
        // admin/teacher last toggled this meeting's lock for this batch via
        // toggleMeetingLock(). That's a more trustworthy "this meeting
        // became available on X" signal than classMeeting->meeting_date,
        // which is just the auto-calculated (start_date + N weeks)
        // schedule and can drift from reality once a meeting's been
        // manually opened/locked out of band.
        $periodMeetingStatus = collect();
        if ($selectedClassPeriod) {
            $periodMeetingStatus = $selectedClassPeriod->meetings()->get()->keyBy('id');
        }

        $program->meetings->transform(function ($meeting) use ($user, $selectedClassPeriod, $periodMeetingStatus, $classMeetings) {
            if ($selectedClassPeriod) {
                $pivotMeeting = $periodMeetingStatus->get($meeting->id);
                $meeting->is_locked = !((bool) ($pivotMeeting->pivot->is_open ?? false));
                $meeting->lock_toggled_at = $pivotMeeting?->pivot->updated_at;
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
