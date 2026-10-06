<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 1],
            [
                'title' => 'Subject + Verb + Preposition',
                'description' => '',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Mark Twain ____ the years after the Civil War the "Gilded Age."',
                'option_a' => 'called',
                'option_b' => 'calling',
                'option_c' => 'he called',
                'option_d' => 'his calls',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Early ____ toes instead of hooves on their feet.',
                'option_a' => 'horses',
                'option_b' => 'had horses',
                'option_c' => 'horses had',
                'option_d' => 'horses having',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => '____ grow close to the ground in the short Arctic summer.',
                'option_a' => 'Above tundra plants',
                'option_b' => 'Tundra plants',
                'option_c' => 'Tundra plants are found',
                'option_d' => 'For tundra plants',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'In 1867, ____ Alaska from the Russians for $7.2 million.',
                'option_a' => 'purchased the United States',
                'option_b' => 'to purchase the United States',
                'option_c' => 'the United States\' purchase of',
                'option_d' => 'the United States purchased',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Between 1725 and 1750, New England witnessed an increase in the specialization of ____.',
                'option_a' => 'occupations',
                'option_b' => 'occupies',
                'option_c' => 'they occupied',
                'option_d' => 'it occupied them',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The large carotid artery ____ to the main parts of the brain.',
                'option_a' => 'carrying blood',
                'option_b' => 'blood is carried',
                'option_c' => 'carries blood',
                'option_d' => 'blood carries',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => '____ radio as the first practical system of wireless telegraphy.',
                'option_a' => 'Marconi\'s development',
                'option_b' => 'The development by Marconi',
                'option_c' => 'Developing Marconi',
                'option_d' => 'Marconi developed',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'In 1975, the first successful space probe to ____ beginning to send information back to Earth.',
                'option_a' => 'Venus',
                'option_b' => 'Venus the',
                'option_c' => 'Venus was',
                'option_d' => 'Venus it was',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The two biggest resort ____ Arkansas are Hot Springs and Eureka Springs.',
                'option_a' => 'in',
                'option_b' => 'towns in',
                'option_c' => 'towns are',
                'option_d' => 'towns are in',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => 'NASA\'s Lyndon B. Johnson Space Center ____ control center for the Mercury, Gemini, and Apollo space flights.',
                'option_a' => 'it was at the',
                'option_b' => 'it was the',
                'option_c' => 'the',
                'option_d' => 'was the',
                'correct_answer' => 'D',
            ],
        ];

        foreach ($questions as $q) {
            \App\Models\ToeflStructureQuestion::create([
                'section_id' => $meeting->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'explanation' => $q['explanation'] ?? null,
            ]);
        }
    }
}
