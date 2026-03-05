<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M13S2Seeder extends Seeder
{
    public function run()
    {
        // Meeting 13, Set 2
        $meetingNumber = 13;
        $setNumber = 2;

        // Clear existing questions for this set
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => null,
                'option_a' => 'North of Los Angeles.',
                'option_b' => 'Between Los Angeles and San Diego.',
                'option_c' => 'East of San Diego.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => null,
                'option_a' => 'They are a type of insect.',
                'option_b' => 'They are a kind of fish.',
                'option_c' => 'They are a type of bird.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => null,
                'option_a' => 'In March.',
                'option_b' => 'In early summer.',
                'option_c' => 'In October.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => null,
                'option_a' => 'About 200 miles.',
                'option_b' => 'About 1,000 miles.',
                'option_c' => 'About 7,000 miles.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => null,
                'option_a' => 'The swallows\' arrival.',
                'option_b' => 'The parade.',
                'option_c' => 'The swallows\' departure.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => null,
                'option_a' => 'Only during the first week of classes.',
                'option_b' => 'Whenever students ask for them.',
                'option_c' => 'Only in the afternoon.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => null,
                'option_a' => 'A tour guide.',
                'option_b' => 'A classroom.',
                'option_c' => 'A map.',
                'option_d' => 'N/A',
                'correct_answer' => 'B', // Corrected "gUide" to "guide"
            ],
            [
                'question_number' => 8,
                'question_text' => null,
                'option_a' => 'In the Science Building.',
                'option_b' => 'In the Student Center Building.',
                'option_c' => 'In the University Recreation Center.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => null,
                'option_a' => 'A test in a composition class.',
                'option_b' => 'A road test.',
                'option_c' => 'The written test for her driver\'s license.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => null,
                'option_a' => 'He drove too fast.',
                'option_b' => 'He couldn\'t park well.',
                'option_c' => 'He made an improper turn.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 11,
                'question_text' => null,
                'option_a' => 'Drive her to the test site.',
                'option_b' => 'Help her get ready for the road test.',
                'option_c' => 'Sell her a car.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 12,
                'question_text' => null,
                'option_a' => 'It doesn\'t belong to her.',
                'option_b' => 'She\'s not a licensed driver.',
                'option_c' => 'It isn\'t running right.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ]
        ];

        foreach ($questions as $q) {
            DB::table('toefl_listening_questions')->insert([
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $q['question_number'],
                'question_text' => 'Question ' . $q['question_number'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'audio_file' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
