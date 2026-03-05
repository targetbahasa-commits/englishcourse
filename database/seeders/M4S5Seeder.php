<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M4S5Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 4;
        $setNumber = 5;

        // Content from user image for Practice 5
        // 20 Questions, 3 Options (mostly)
        
        $questions = [
            [
                'q' => 1,
                'a' => 'Go to work with Jim.',
                'b' => 'Go out for coffee.',
                'c' => 'Get some exercise.',
                'ans' => 'C'
            ],
            [
                'q' => 2,
                'a' => 'If the woman will go to the party with him.',
                'b' => 'If the red tie looks good with his shirt.',
                'c' => 'If he should wear a tie to the party.',
                'ans' => 'B'
            ],
            [
                'q' => 3,
                'a' => 'She missed Friday\'s class, too.',
                'b' => 'They both missed class because they went sailing.',
                'c' => 'He should take better notes during Professor Morrison\'s class.',
                'ans' => 'A'
            ],
            [
                'q' => 4,
                'a' => 'He cut himself while he was preparing food.',
                'b' => 'He doesn\'t want to work in a restaurant.',
                'c' => 'He\'s planning to open up his own restaurant.',
                'ans' => 'B'
            ],
            [
                'q' => 5,
                'a' => 'He wants to know if the woman is joking.',
                'b' => 'He wants the woman to leave him alone.',
                'c' => 'He\'d like to know what the quiz will be about.',
                'ans' => 'A'
            ],
            [
                'q' => 6,
                'a' => 'The program was canceled.',
                'b' => 'The shuttle was launched yesterday.',
                'c' => 'The launch was delayed.',
                'ans' => 'C'
            ],
            [
                'q' => 7,
                'a' => 'She stood up and left the lecture.',
                'b' => 'She was waiting outside the lecture hall.',
                'c' => 'Her sweater made her easy to spot.',
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => 'He deserved to get a ticket.',
                'b' => 'He was going to a good restaurant.',
                'c' => 'He probably wasn\'t speeding.',
                'ans' => 'A'
            ],
            [
                'q' => 9,
                'a' => 'He\'ll be glad to help.',
                'b' => 'If he helps, it will save the man some money.',
                'c' => 'He won\'t be very cooperative.',
                'ans' => 'C'
            ],
            [
                'q' => 10,
                'a' => 'It\'s about buying large real estate properties.',
                'b' => 'N/A', // Not visible in image
                'c' => 'N/A', // Not visible in image
                'ans' => 'C'
            ],
            [
                'q' => 11,
                'a' => 'The man didn\'t get Jill a watch.',
                'b' => 'The weather will be cool on graduation day.',
                'c' => 'Jill won\'t be graduating.',
                'ans' => 'A'
            ],
            [
                'q' => 12,
                'a' => 'She ordinarily works in a florist shop.',
                'b' => 'In the end, she won\'t have a problem.',
                'c' => 'She wears too much perfume to work.',
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => 'She doesn\'t want any fruit.',
                'b' => 'She doesn\'t want to celebrate her birthday.',
                'c' => 'She doesn\'t like candy.',
                'ans' => 'C'
            ],
            [
                'q' => 14,
                'a' => 'He doesn\'t have any questions for her.',
                'b' => 'He won\'t be able to take a trip.',
                'c' => 'He can\'t study during spring break.',
                'ans' => 'B'
            ],
            [
                'q' => 15,
                'a' => 'Mick\'s father told him to go to medical school.',
                'b' => 'Mick\'s father studied medicine.',
                'c' => 'Mick and his father walked to the school.',
                'ans' => 'B'
            ],
            [
                'q' => 16,
                'a' => 'Fred would be upset if he\'d lost money.',
                'b' => 'Fred shouldn\'t be paid for singing.',
                'c' => 'Fred is generally very sympathetic.',
                'ans' => 'A'
            ],
            [
                'q' => 17,
                'a' => 'If Wally has been injured.',
                'b' => 'If Wally has been informed.',
                'c' => 'If Wally\'s trip has been canceled.',
                'ans' => 'B'
            ],
            [
                'q' => 18,
                'a' => 'He can\'t find some of his pictures.',
                'b' => 'He didn\'t go to the Grand Canyon.',
                'c' => 'Not all of his photos were good.',
                'ans' => 'C'
            ],
            [
                'q' => 19,
                'a' => 'She thinks they\'re certain to do well.',
                'b' => 'She thinks they\'re talented but lack experience.',
                'c' => 'She doesn\'t like their style of photography.',
                'ans' => 'A'
            ],
            [
                'q' => 20,
                'a' => 'The lake is not very scenic.',
                'b' => 'Her parents won\'t let them use the cabin.',
                'c' => 'N/A', // Not visible in image
                'ans' => 'C'
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
                'question_number' => $q['q'],
                'question_text' => 'Practice 5 Question ' . $q['q'], // No question text in image, just options
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => $q['c'],
                'option_d' => 'N/A',
                'correct_answer' => $q['ans'], // Defaulting to A as answer key is unknown
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
