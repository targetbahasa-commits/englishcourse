<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsSpeakingTopic;

class IeltsSpeakingTopicsSeeder extends Seeder
{
    public function run()
    {
        $topics = [
            [
                'slug' => 'lesson-1',
                'title' => 'No Hmmmm',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'red',
                'questions' => null,
                'subtopics' => [
                    [
                        'slug' => 'books-and-reading',
                        'title' => 'Books & Reading',
                        'questions' => [
                            'Do you often read books? Why or why not?',
                            'What is your favorite kind of book to read?',
                            'Do you prefer reading paper books or e-books?',
                            'Did you enjoy reading when you were a child?',
                        ]
                    ],
                    [
                        'slug' => 'robots',
                        'title' => 'Robots',
                        'questions' => [
                            'Are you interested in robots?',
                            'Would you like to have a robot at home to help you?',
                            'Do you think robots will replace humans at work in the future?',
                            'How do you feel about robots in movies?',
                        ]
                    ],
                    [
                        'slug' => 'tea-or-coffee',
                        'title' => 'Tea or Coffee',
                        'questions' => [
                            'Do you prefer drinking tea or coffee?',
                            'When was the last time you went to a cafe?',
                            'Is tea or coffee more popular in your country?',
                            'Do you usually prepare it yourself or buy it?',
                        ]
                    ]
                ]
            ],
            [
                'slug' => 'lesson-2',
                'title' => 'Nominal & Passive',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'blue',
                'questions' => [
                    'What is a nominal sentence?',
                    'Give an example of a passive voice sentence.',
                    'When do we use the passive voice?',
                    'Change this active sentence to passive.'
                ],
                'subtopics' => null
            ],
            [
                'slug' => 'lesson-3',
                'title' => 'Part 2 + Adjective Clause',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'green',
                'questions' => [
                    'Describe a person who matches your description.',
                    'Use an adjective clause to describe them.',
                    'What makes this topic interesting?',
                    'Explain the importance of adjective clauses.'
                ],
                'subtopics' => null
            ],
            [
                'slug' => 'lesson-4',
                'title' => 'Part 3 + Gerund as Subject',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'purple',
                'questions' => [
                    'Discuss a broader issue related to Part 2.',
                    'Use a gerund as subject in your answer.',
                    'Why is using gerunds effective?',
                    'Give an example of a gerund phrase.'
                ],
                'subtopics' => null
            ],
            [
                'slug' => 'lesson-5',
                'title' => 'Past + Modal',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'yellow',
                'questions' => [
                    'Talk about a past event.',
                    'Use a modal verb (could, would, should) in your response.',
                    'How does the modal change the meaning?',
                    'Give another example using a past modal.'
                ],
                'subtopics' => null
            ],
            [
                'slug' => 'lesson-6',
                'title' => 'Adverbial Clause & Bridging',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'indigo',
                'questions' => [
                    'Use an adverbial clause to explain why or when.',
                    'Practice bridging ideas smoothly.',
                    'What linkers can you use?',
                    'Create a complex sentence with an adverbial clause.'
                ],
                'subtopics' => null
            ],
            [
                'slug' => 'lesson-7',
                'title' => 'Idiom & Collocation',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'pink',
                'questions' => [
                    'Use an idiom in a sentence.',
                    'What is a collocation?',
                    'Give examples of common collocations.',
                    'Why are idioms important in speaking?'
                ],
                'subtopics' => null
            ],
        ];

        foreach ($topics as $index => $topic) {
            IeltsSpeakingTopic::updateOrCreate(
                ['slug' => $topic['slug']],
                [
                    'title' => $topic['title'],
                    'icon' => $topic['icon'],
                    'color' => $topic['color'],
                    'questions' => $topic['questions'],
                    'subtopics' => $topic['subtopics'],
                    'order' => $index
                ]
            );
        }
    }
}
