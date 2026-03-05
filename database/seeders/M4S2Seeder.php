<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M4S2Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 4;
        $setNumber = 2;

        // Clear existing data to avoid duplicates
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'get off the ground',
                'option_a' => 'He\'s not sure Max\'s business will succeed.',
                'option_b' => 'He doesn\'t know where Max has gone.',
                'answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'push one\'s luck',
                'option_a' => 'Gary is lucky to have such a good car.',
                'option_b' => 'It\'s time for Gary to get some new tires.',
                'answer' => 'B',
            ],
            [
                'question_number' => 3,
                'question_text' => 'turn in',
                'option_a' => 'Go to bed.',
                'option_b' => 'Watch a different program.',
                'answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'over one\'s head',
                'option_a' => 'She didn\'t understand all the jokes.',
                'option_b' => 'She left before the performance was over.',
                'answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'clear up',
                'option_a' => 'If the weather gets better.',
                'option_b' => 'If she doesn\'t have any other plans.',
                'answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'short for',
                'option_a' => 'Elizabeth is taller than Liz.',
                'option_b' => 'People call Elizabeth "Liz."',
                'answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => 'hours on end',
                'option_a' => 'She\'s stopped listening to it.',
                'option_b' => 'She listens to it constantly.',
                'answer' => 'B',
            ],
            [
                'question_number' => 8,
                'question_text' => 'run of the mill',
                'option_a' => 'The service is very fast there.',
                'option_b' => 'It\'s just an average restaurant',
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
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => $q['answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
