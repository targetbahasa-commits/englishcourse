<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M4S1Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 4;
        $setNumber = 1;

        // Clear existing data to avoid duplicates
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'get into hot water',
                'option_a' => 'She was in trouble.',
                'option_b' => 'She took a warm bath.',
                'answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'run into',
                'option_a' => 'He met Caroline unexpectedly at the coffee shop.',
                'option_b' => 'Caroline and I jogged to the coffee shop.',
                'answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'hit it off',
                'option_a' => 'He and Chuck argued as soon as they met.',
                'option_b' => 'He and Chuck quickly became friends.',
                'answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'a piece of cake',
                'option_a' => 'The exam was simple.',
                'option_b' => 'She had a snack after the test.',
                'answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'at the drop of a hat',
                'option_a' => 'He can\'t leave until he finds his hat.',
                'option_b' => 'He\'s ready to leave immediately.',
                'answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => 'on edge',
                'option_a' => 'He walks back and forth when he\'s nervous',
                'option_b' => 'He likes to walk along the edge',
                'answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'under the weather',
                'option_a' => 'She didn\'t want to practice because of the bad weather.',
                'option_b' => 'She wasn\'t there because she felt a little sick.',
                'answer' => 'B',
            ],
            [
                'question_number' => 8,
                'question_text' => 'take after',
                'option_a' => 'He looks like his grandfather.',
                'option_b' => 'He takes care of his grandfather.',
                'answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => 'for good',
                'option_a' => 'He doesn\'t want the professor to quit teaching permanently.',
                'option_b' => 'He hopes Professor Holmes has a good reason for quitting.',
                'answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'give a hand with',
                'option_a' => 'Hand her the box .',
                'option_b' => 'Help her carry the box.',
                'answer' => 'B',
            ],
            [
                'question_number' => 11,
                'question_text' => 'a stone\'s throw from',
                'option_a' => 'He likes to throw rocks in the park.',
                'option_b' => 'He lives close to the park.',
                'answer' => 'B',
            ],
            [
                'question_number' => 12,
                'question_text' => 'not think much of',
                'option_a' => 'She didn\'t consider it.',
                'option_b' => 'She didn\'t like it.',
                'answer' => 'B',
            ]
        ];

        foreach ($questions as $q) {
            DB::table('toefl_listening_questions')->insert([
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => 'N/A', // 2 options only
                'option_d' => 'N/A', // 2 options only
                'correct_answer' => $q['answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
