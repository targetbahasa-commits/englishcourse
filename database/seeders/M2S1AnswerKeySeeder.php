<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M2S1AnswerKeySeeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 2;
        $setNumber = 1;

        // Answer Key from user image (Exercise 2.1)
        // 1.B, 2.B, 3.A, 4.A, 5.A, 6.A, 7.B, 8.B, 9.B, 10.A, 11.B, 12.A, 13.B, 14.B, 15.B
        $answers = [
            1 => 'B',
            2 => 'B',
            3 => 'A',
            4 => 'A',
            5 => 'A',
            6 => 'A',
            7 => 'B',
            8 => 'B',
            9 => 'B',
            10 => 'A',
            11 => 'B',
            12 => 'A',
            13 => 'B',
            14 => 'B',
            15 => 'B',
        ];

        foreach ($answers as $qNum => $correctAnswer) {
            DB::table('toefl_listening_questions')
                ->where('meeting_number', $meetingNumber)
                ->where('set_number', $setNumber)
                ->where('question_number', $qNum)
                ->update(['correct_answer' => $correctAnswer]);
        }
    }
}
