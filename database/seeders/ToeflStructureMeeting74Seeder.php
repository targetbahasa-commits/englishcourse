<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting74Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 74)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 74,
                'title' => 'Structure Review Exercise (General)',
                'description' => 'Structure Meeting 74 - General Review Exercise',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '______ variety of flowers in the show, from simple carnations to the most exquisite roses.',
                'option_a' => 'A wide',
                'option_b' => 'There was a wide',
                'option_c' => 'Was there',
                'option_d' => 'Many',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The wedges ______ dart board are worth from one to twenty points each.',
                'option_a' => 'they are on a',
                'option_b' => 'are on a',
                'option_c' => 'are they on a',
                'option_d' => 'on a',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => '______ producing many new movies for release after the new season begins.',
                'option_a' => 'His company is',
                'option_b' => 'His companies',
                'option_c' => 'The company',
                'option_d' => 'Why the company is',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => '______ that Emily Dickinson wrote, 24 were given titles and 7 were published during her lifetime.',
                'option_a' => 'Of the 1,800 poems',
                'option_b' => 'There were 1,800 poems',
                'option_c' => 'Because the 1,800 poems',
                'option_d' => 'The 1,800 poems',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Since an immediate change was needed on an emergency basis, ______ by the governor to curtail railway expenditure.',
                'option_a' => 'so it was proposed',
                'option_b' => 'was proposed',
                'option_c' => 'because of the proposal',
                'option_d' => 'it was proposed',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'In the Morgan Library in New York City ______ of medieval and Renaissance manuscripts.',
                'option_a' => 'a collection is',
                'option_b' => 'in a collection',
                'option_c' => 'is a collection',
                'option_d' => 'which is a collection',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Some fishing fleets might not have been so inefficient in limiting their catch to target species ______ more strict in enforcing penalties.',
                'option_a' => 'the government had been',
                'option_b' => 'if the government had',
                'option_c' => 'had the government been',
                'option_d' => 'if the government',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'The Dewey Decimal System, currently used in libraries throughout the world, ______ all written works into ten classes according to subject.',
                'option_a' => 'dividing',
                'option_b' => 'divides',
                'option_c' => 'it would divide',
                'option_d' => 'was divided',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Individual differences in brain-wave activity may shed light on why some people are more prone to emotional stress disorders ______.',
                'option_a' => 'that others are',
                'option_b' => 'and others are',
                'option_c' => 'others are',
                'option_d' => 'than are others',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => '______ squeezed, the orange juice in a one-cup serving provides twice the minimum daily requirement for vitamin C.',
                'option_a' => 'It is freshly',
                'option_b' => 'If freshly',
                'option_c' => 'You freshly',
                'option_d' => 'If it freshly',
                'correct_answer' => 'B',
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
            ]);
        }
    }
}
