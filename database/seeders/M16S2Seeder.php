<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M16S2Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 16;
        $setNumber = 2;

        $questions = [
            [
                'q' => 1,
                'a' => 'Two years.',
                'b' => 'Three years.',
                'c' => 'Five years.',
                'ans' => 'B'
            ],
            [
                'q' => 2,
                'a' => 'Student fees.',
                'b' => 'Room-and-board charges at the dormitory.',
                'c' => 'Student insurance rates.',
                'ans' => 'C'
            ],
            [
                'q' => 3,
                'a' => 'Its tuition rates are going up faster than the ones at Hambleton University.',
                'b' => 'It has the highest tuition rates in the state.',
                'c' => 'Its tuition rates are still lower than those at Hambleton University.',
                'ans' => 'B'
            ],
            [
                'q' => 4,
                'a' => 'An executive on the Student Council.',
                'b' => 'A member of the Board of Regents.',
                'c' => 'A spokesperson for the administration.',
                'ans' => 'A'
            ],
            [
                'q' => 5,
                'a' => 'A new dormitory will not be built.',
                'b' => 'The proposal to increase student services will not be adopted.',
                'c' => 'The tuition will not be raised.',
                'ans' => 'B'
            ],
            [
                'q' => 6,
                'a' => 'A starfish.',
                'b' => 'A salamander.',
                'c' => 'A mammal.',
                'ans' => 'A'
            ],
            [
                'q' => 7,
                'a' => 'A snake sheds its skin and grows a new one.',
                'b' => 'An insect grows a new limb.',
                'c' => 'A baby gets its first set of teeth.',
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => 'Embryonic cells.',
                'b' => 'Specialized cells.',
                'c' => 'Nerve cells.',
                'ans' => 'A'
            ],
            [
                'q' => 9,
                'a' => 'To treat diseases among animals.',
                'b' => 'To learn to speed up the process among lower animals.',
                'c' => 'To apply what they learn to human medicine.',
                'ans' => 'C'
            ],
            [
                'q' => 10,
                'a' => 'Before the Revolutionary War.',
                'b' => 'During the Revolutionary War.',
                'c' => 'After American independence.',
                'ans' => 'B'
            ],
            [
                'q' => 11,
                'a' => 'His military service.',
                'b' => 'His political philosophy.',
                'c' => 'His dictionary.',
                'ans' => 'C'
            ],
            [
                'q' => 12,
                'a' => 'T-H-E-A-T-R-E instead of T-H-E-A-T-E-R.',
                'b' => 'L-A-B-O-U-R instead of L-A-B-O-R.',
                'c' => 'N-I-F instead of K-N-I-F-E.',
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
                'question_text' => 'Question ' . $q['q'], // Placeholder question text as usual
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
