<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M4S4Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 4;
        $setNumber = 4;

        // Content from user image for Practice 4 (Set C)
        // Idioms: by heart, ring a bell, call it a day, slowly but surely, come around, take a lot of nerve, go without saying, take into account
        // Numbering 17-24
        
        $questions = [
            [
                'question_number' => 17,
                'question_text' => 'take a lot of nerve',
                'option_a' => 'She seems too nervous.',
                'option_b' => 'She took a bold approach.',
                'answer' => 'B',
            ],
            [
                'question_number' => 18,
                'question_text' => 'call it a day',
                'option_a' => 'He doesn\'t want to do any more painting today.',
                'option_b' => 'He\'ll phone the woman later today.',
                'answer' => 'A',
            ],
            [
                'question_number' => 19,
                'question_text' => 'by heart',
                'option_a' => 'She spoke the lines in an emotional way',
                'option_b' => 'She\'s memorized all the lines.',
                'answer' => 'B',
            ],
            [
                'question_number' => 20,
                'question_text' => 'come around',
                'option_a' => 'At some point, they\'ll agree to let her go',
                'option_b' => 'They\'ll come with her to Alaska',
                'answer' => 'A',
            ],
            [
                'question_number' => 21,
                'question_text' => 'ring a bell',
                'option_a' => 'Rob Martin hasn\'t called him yet.',
                'option_b' => 'He doesn\'t think Rob Martin was on the team.',
                'answer' => 'B',
            ],
            [
                'question_number' => 22,
                'question_text' => 'take into account',
                'option_a' => 'He didn\'t count his money carefully.',
                'option_b' => 'He forgot about the tax.',
                'answer' => 'B',
            ],
            [
                'question_number' => 23,
                'question_text' => 'slowly but surely',
                'option_a' => 'She\'s making steady progress.',
                'option_b' => 'She thinks the work is going too slowly.',
                'answer' => 'A',
            ],
            [
                'question_number' => 24,
                'question_text' => 'go without saying',
                'option_a' => 'Of course she was sorry that Molly left.',
                'option_b' => 'Molly left without saying goodbye.',
                'answer' => 'A',
            ],
        ];

         // Clean up existing questions for this set
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
