<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M16S1Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 16;
        $setNumber = 1;

        $questions = [
            // Talk A
            [
                'q' => 1,
                'a' => 'It covers some difficult topics.',
                'b' => 'It\'s unlike other biology courses.',
                'c' => 'It has never been offered by this department.',
                'ans' => 'B'
            ],
            [
                'q' => 2,
                'a' => 'By visiting a coral reef.',
                'b' => 'By going to the library.',
                'c' => 'By going to a farm.',
                'ans' => 'A'
            ],
            [
                'q' => 3,
                'a' => 'Diving.',
                'b' => 'Photography.',
                'c' => 'Biology.',
                'ans' => 'C'
            ],
            [
                'q' => 4,
                'a' => 'As harmful.',
                'b' => 'As easily damaged.',
                'c' => 'As frightening.',
                'ans' => 'B'
            ],
            [
                'q' => 5,
                'a' => 'Transportation.',
                'b' => 'Housing.',
                'c' => 'Basic equipment.',
                'ans' => 'C'
            ],
            [
                'q' => 6,
                'a' => 'Traveling by ship.',
                'b' => 'Trying to get financial aid.',
                'c' => 'Applying to another university.',
                'ans' => 'B'
            ],
            // Talk B
            [
                'q' => 7,
                'a' => 'They have such impressive appetites.',
                'b' => 'They sometimes walk on two legs.',
                'c' => 'They frequently attack people.',
                'ans' => 'B'
            ],
            [
                'q' => 8,
                'a' => 'They will eat anything except plants.',
                'b' => 'They eat only honey.',
                'c' => 'They aren\'t limited to a few types of food.',
                'ans' => 'C'
            ],
            [
                'q' => 9,
                'a' => 'Five feet.',
                'b' => 'Ten feet.',
                'c' => 'Fifteen feet.',
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => 'In Alaska.',
                'b' => 'In Yellowstone National Park.',
                'c' => 'All over the United States.',
                'ans' => 'B'
            ],
            [
                'q' => 11,
                'a' => 'The kodiak bear.',
                'b' => 'The grizzly bear.',
                'c' => 'The black bear.',
                'ans' => 'C'
            ],
            [
                'q' => 12,
                'a' => 'They are sometimes not as friendly as they seem.',
                'b' => 'They are much more dangerous than grizzly bears.',
                'c' => 'They look dangerous but are usually friendly.',
                'ans' => 'A'
            ],
            // Talk C
            [
                'q' => 13,
                'a' => 'In the 1950\'s.',
                'b' => 'In the 1970\'s.',
                'c' => 'In the 1990\'s.',
                'ans' => 'A'
            ],
            [
                'q' => 14,
                'a' => 'They fly off into deep space.',
                'b' => 'They remain in orbit forever.',
                'c' => 'They burn up in the atmosphere.',
                'ans' => 'C'
            ],
            [
                'q' => 15,
                'a' => 'Three to four hundred.',
                'b' => 'Eight thousand.',
                'c' => 'Half a million.',
                'ans' => 'B'
            ],
            [
                'q' => 16,
                'a' => 'They are too small.',
                'b' => 'They are too far away.',
                'c' => 'They are moving too fast.',
                'ans' => 'A'
            ],
            [
                'q' => 17,
                'a' => 'A large booster rocket.',
                'b' => 'A piece of metal the size of an aspirin.',
                'c' => 'A tiny fleck of paint.',
                'ans' => 'B'
            ],
            [
                'q' => 18,
                'a' => 'Their high speed.',
                'b' => 'Their jagged shape.',
                'c' => 'Their tremendous size.',
                'ans' => 'A'
            ],
            [
                'q' => 19,
                'a' => 'An aspirin.',
                'b' => 'A piece of debris.',
                'c' => 'A model of the debris collector.',
                'ans' => 'C'
            ],
            [
                'q' => 20,
                'a' => 'They detect the debris.',
                'b' => 'They store the debris.',
                'c' => 'They collect the debris.',
                'ans' => 'C'
            ],
            [
                'q' => 21,
                'a' => 'It has already been tested on Earth.',
                'b' => 'It has not been built yet.',
                'c' => 'It has already been used on a spacecraft.',
                'ans' => 'B'
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
                'question_text' => 'Question ' . $q['q'], // Placeholder question text
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => $q['c'],
                'option_d' => 'N/A',
                'correct_answer' => $q['ans'], // Defaulting to A
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
