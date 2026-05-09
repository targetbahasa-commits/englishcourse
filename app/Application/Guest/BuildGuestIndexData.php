<?php

namespace App\Application\Guest;

use App\Domain\Scholarship\Repositories\ScholarshipRepository;

class BuildGuestIndexData
{
    /**
     * Static list of free lesson modules available on the guest page.
     * Kept here in the Application layer (not the controller) as it is
     * presentation-agnostic data that drives feature discovery.
     */
    private const FREE_LESSONS = [
        ['id' => 'a1',            'title' => 'Vocabulary A1',       'description' => 'Essential vocabulary for absolute beginners. 20 topics covering everyday situations.',     'color' => 'blue'],
        ['id' => 'a2',            'title' => 'Vocabulary A2',       'description' => 'Elementary vocabulary to expand your daily communication skills.',                        'color' => 'green'],
        ['id' => 'b1',            'title' => 'Vocabulary B1',       'description' => 'Intermediate vocabulary for more complex conversations.',                                  'color' => 'purple'],
        ['id' => 'b2',            'title' => 'Vocabulary B2',       'description' => 'Upper-intermediate vocabulary for professional fluency.',                                  'color' => 'orange'],
        ['id' => 'c1',            'title' => 'Vocabulary C1',       'description' => 'Advanced vocabulary for near-native proficiency.',                                        'color' => 'red'],
        ['id' => 'verbs',         'title' => 'Verbs (A1-C1)',       'description' => 'Master English verbs across 5 proficiency levels.',                                       'color' => 'teal'],
        ['id' => 'adjectives',    'title' => 'Adjectives (A1-C1)',  'description' => 'Descriptive words to enhance your expression.',                                           'color' => 'yellow'],
        ['id' => 'adverbs',       'title' => 'Adverbs (A1-C1)',     'description' => 'Add nuance to your verbs and adjectives.',                                                'color' => 'indigo'],
        ['id' => 'expressions',   'title' => 'English Expressions', 'description' => 'Common expressions for natural conversation.',                                            'color' => 'cyan'],
        ['id' => 'idioms',        'title' => 'English Idioms',      'description' => 'Learn idioms to sound like a native speaker.',                                            'color' => 'pink'],
        ['id' => 'phrasal-verbs', 'title' => 'Phrasal Verbs',       'description' => 'Essential phrasal verbs for fluency.',                                                    'color' => 'orange'],
        ['id' => 'irregular-verbs','title' => 'Irregular Verbs',    'description' => 'Complete list of irregular verbs.',                                                       'color' => 'purple'],
    ];

    public function __construct(
        private readonly ScholarshipRepository $scholarshipRepository,
    ) {}

    public function handle(): array
    {
        $scholarships = $this->scholarshipRepository->getOpenScholarships(limit: 3);

        return [
            'freeLessons'    => self::FREE_LESSONS,
            'scholarships'   => $scholarships,
            'pageTitle'      => 'Guest Free Tests & Lessons',
            'pageDescription'=> 'Welcome back!',
        ];
    }
}
