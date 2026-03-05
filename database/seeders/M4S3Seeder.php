<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M4S3Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 4;
        $setNumber = 3;

        // Content from user image for Practice 3 (Set 3)
        // Idioms: believe one's eyes, lend a hand, a breeze, look who's talking, chip in, music to one's ears, get in one's blood, what the doctor ordered
        // Numbering 9-16
        
        $questions = [
            [
                'question_number' => 9,
                'question_text' => 'what the doctor ordered',
                'option_a' => 'Ice water sounds perfect.',
                'option_b' => 'The doctor told her to drink a lot of water.',
                'answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'get in one\'s blood',
                'option_a' => 'Skiing can be a dangerous sport.',
                'option_b' => 'It\'s easy to get into the habit of skiing.',
                'answer' => 'B',
            ],
            [
                'question_number' => 11,
                'question_text' => 'music to one\'s ears',
                'option_a' => 'She enjoys the sound of nature.',
                'option_b' => 'She wishes she\'d brought a radio.',
                'answer' => 'A',
            ],
            [
                'question_number' => 12,
                'question_text' => 'look who\'s talking',
                'option_a' => 'She wants to talk to Norman.',
                'option_b' => 'Norman doesn\'t study much himself.',
                'answer' => 'B',
            ],
            [
                'question_number' => 13,
                'question_text' => 'a breeze',
                'option_a' => 'There\'s not enough wind to go sailing.',
                'option_b' => 'It won\'t be too hard to learn to sail.',
                'answer' => 'B',
            ],
            [
                'question_number' => 14,
                'question_text' => 'lend a hand',
                'option_a' => 'Lend him some money.',
                'option_b' => 'Give him some help.',
                'answer' => 'B',
            ],
            [
                'question_number' => 15,
                'question_text' => 'chip in',
                'option_a' => 'They\'ll all pay for the gasoline.',
                'option_b' => 'Gasoline is very inexpensive.',
                'answer' => 'A',
            ],
            [
                'question_number' => 16,
                'question_text' => 'believe one\'s eyes',
                'option_a' => 'She doesn\'t think the man is telling the truth.',
                'option_b' => 'She was surprised to see the snow.',
                'answer' => 'B',
            ],
        ];

        // Clean up existing questions for this set to avoid duplicates/constraints
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

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
