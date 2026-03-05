<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsSpeakingTopic;

class RestorePart1TopicsSeeder extends Seeder
{
    public function run()
    {
        $topics = [
            [
                'title' => 'Hometown',
                'slug' => 'hometown',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                'color' => 'blue',
                'questions' => [
                    'Where is your hometown?',
                    'What do you like most about your hometown?',
                    'Is your hometown a good place for young people?',
                    'Has your hometown changed much since you were a child?'
                ]
            ],
            [
                'title' => 'Work & Studies',
                'slug' => 'work-studies',
                'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'indigo',
                'questions' => [
                    'Do you work or are you a student?',
                    'What do you enjoy most about your work/studies?',
                    'Why did you choose this job/subject?',
                    'Do you plan to change your job/major in the future?'
                ]
            ],
            [
                'title' => 'Family & Friends',
                'slug' => 'family-friends',
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'color' => 'green',
                'questions' => [
                    'Do you spend a lot of time with your family?',
                    'Who are you closest to in your family?',
                    'Do you prefer spending time with family or friends?',
                    'What do you usually do with your friends?'
                ]
            ],
            [
                'title' => 'Hobbies & Interests',
                'slug' => 'hobbies-interests',
                'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'yellow',
                'questions' => [
                    'Do you have any hobbies?',
                    'How long have you been doing this hobby?',
                    'Is it important to have a hobby?',
                    'What new hobby would you like to try?'
                ]
            ],
            [
                'title' => 'Daily Routine',
                'slug' => 'daily-routine',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'orange',
                'questions' => [
                    'What is your daily routine like?',
                    'Do you usually do the same things at the same time every day?',
                    'What is your favorite part of the day?',
                    'Would you like to change anything about your daily routine?'
                ]
            ],
            [
                'title' => 'Weather',
                'slug' => 'weather',
                'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z',
                'color' => 'cyan', // Changed from sky to cyan to fix icon
                'questions' => [
                    'What is the weather usually like in your hometown?',
                    'What is your favorite kind of weather?',
                    'Do you check the weather forecast often?',
                    'Does the weather affect your mood?'
                ]
            ],
            [
                'title' => 'Travel & Holidays',
                'slug' => 'travel-holidays',
                'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'emerald',
                'questions' => [
                    'Do you like traveling?',
                    'Where was the last place you traveled to?',
                    'Do you prefer traveling alone or with others?',
                    'What place would you like to visit in the future?'
                ]
            ],
            [
                'title' => 'Music',
                'slug' => 'music',
                'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
                'color' => 'purple',
                'questions' => [
                    'Do you like listening to music?',
                    'What kind of music do you like?',
                    'Can you play any musical instruments?',
                    'Do you prefer live music or recorded music?'
                ]
            ],
            [
                'title' => 'Movies',
                'slug' => 'movies',
                'icon' => 'M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z',
                'color' => 'rose',
                'questions' => [
                    'Do you like watching movies?',
                    'What kind of movies do you like?',
                    'How often do you go to the cinema?',
                    'Do you prefer watching movies at home or in the cinema?'
                ]
            ],
            [
                'title' => 'Food & Cooking',
                'slug' => 'food-cooking',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'amber',
                'questions' => [
                    'What is your favorite food?',
                    'Do you like cooking?',
                    'Who usually does the cooking in your home?',
                    'Have you ever tried foreign food?'
                ]
            ],
            [
                'title' => 'Sport',
                'slug' => 'sport',
                'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z', // Simplified bolt for energy/sport
                'color' => 'cyan',
                'questions' => [
                    'Do you like playing sports?',
                    'What is the most popular sport in your country?',
                    'Do you prefer watching sports or playing them?',
                    'Did you play any sports when you were a child?'
                ]
            ],
            [
                'title' => 'Technology',
                'slug' => 'technology',
                'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                'color' => 'slate',
                'questions' => [
                    'Do you use the internet often?',
                    'What do you use the internet for?',
                    'Do you possess any high-tech devices?',
                    'How has technology changed your life?'
                ]
            ],
            [
                'title' => 'Accommodation',
                'slug' => 'accommodation',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                'color' => 'teal',
                'questions' => [
                    'Do you live in a house or an apartment?',
                    'Which is your favorite room in your home?',
                    'Would you like to move to a different home in the future?',
                    'What kind of accommodation do most people live in your city?'
                ]
            ],
            [
                'title' => 'Transportation',
                'slug' => 'transportation',
                'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
                'color' => 'red',
                'questions' => [
                    'How do you usually travel to work or school?',
                    'Is public transportation good in your city?',
                    'Do you prefer public transport or private cars?',
                    'What is the most popular means of transport in your country?'
                ]
            ],
            [
                'title' => 'Shopping',
                'slug' => 'shopping',
                'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                'color' => 'pink',
                'questions' => [
                    'Do you like shopping?',
                    'How often do you go shopping?',
                    'Do you prefer shopping online or in stores?',
                    'What is the most expensive thing you have ever bought?'
                ]
            ],
            [
                'title' => 'Clothes & Fashion',
                'slug' => 'clothes-fashion',
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                'color' => 'fuchsia',
                'questions' => [
                    'Are you interested in fashion?',
                    'What kind of clothes do you usually wear?',
                    'Do you wear different clothes for work/school and leisure?',
                    'Do you think clothes are important to people?'
                ]
            ],
            [
                'title' => 'Colors',
                'slug' => 'colors',
                'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                'color' => 'violet',
                'questions' => [
                    'What is your favorite color?',
                    'Did you have a favorite color when you were a child?',
                    'Do you usually wear clothes in your favorite color?',
                    'Are there any colors you dislike?'
                ]
            ],
            [
                'title' => 'Animals',
                'slug' => 'animals',
                'icon' => 'M14.121 14.121L19 19m-7-7l-7-7m0 0l5 5V4a2 2 0 012-2h2a2 2 0 012 2v10m-5 5h.01',
                'color' => 'lime',
                'questions' => [
                    'Do you like animals?',
                    'What is your favorite animal?',
                    'Have you ever had a pet?',
                    'Are there many wild animals in your country?'
                ]
            ],
            [
                'title' => 'Dictionaries',
                'slug' => 'dictionaries',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'color' => 'slate',
                'questions' => [
                    'Do you often use a dictionary?',
                    'Do you prefer paper dictionaries or electronic ones?',
                    'How does a dictionary help you learn a language?',
                    'When was the last time you used a dictionary?'
                ]
            ],
            [
                'title' => 'Gifts',
                'slug' => 'gifts',
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'color' => 'rose',
                'questions' => [
                    'Do you like giving gifts?',
                    'What kind of gifts do you usually give?',
                    'When do you send gifts?',
                    'What was the last gift you received?'
                ]
            ]
        ];

        foreach ($topics as $index => $topic) {
            IeltsSpeakingTopic::updateOrCreate(
                ['slug' => $topic['slug']],
                [
                    'title' => $topic['title'],
                    'icon' => $topic['icon'],
                    'color' => $topic['color'],
                    'questions' => $topic['questions'],
                    'subtopics' => null,
                    'order' => 100 + $index // Order after lessons
                ]
            );
        }
    }
}
