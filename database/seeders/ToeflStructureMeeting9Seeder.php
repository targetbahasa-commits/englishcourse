<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting9Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 9)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 9,
                'title' => 'Noun Clauses & Adjective Clauses',
                'description' => 'Structure Meeting 9 - Noun Clauses & Adjective Clauses',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '______ is famous as the home of the U.S. Naval Academy.',
                'option_a' => 'Annapolis',
                'option_b' => 'Because of Annapolis',
                'option_c' => 'Why Annapolis',
                'option_d' => 'Because Annapolis',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Some scientists think ______ be a planet but a moon of Neptune.',
                'option_a' => 'that Pluto does not seem',
                'option_b' => 'not Pluto',
                'option_c' => 'Pluto that might not',
                'option_d' => 'that Pluto might not',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => 'With ______ of sophisticated oil lamps, elaborate tools were made to cut the wicks.',
                'option_a' => 'appeared',
                'option_b' => 'the appearance',
                'option_c' => 'the appearance was',
                'option_d' => 'it appeared',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Fort Union was the site of what ______ principal fur-trading post on the upper Missouri River.',
                'option_a' => 'the',
                'option_b' => 'being the',
                'option_c' => 'was the',
                'option_d' => 'it was the',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Since ______ commercial risk, it has to appeal to a large audience to justify its cost.',
                'option_a' => 'the face of the movie',
                'option_b' => 'moving faces',
                'option_c' => 'a movie faces',
                'option_d' => 'to face a movie',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => 'A current of water known as the Gulf Stream comes up from the Gulf of Mexico, and then ______ the North Atlantic toward Europe.',
                'option_a' => 'it crosses',
                'option_b' => 'crossing',
                'option_c' => 'with its crosses',
                'option_d' => 'crosses it',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Systems ______ the two symbols 0 and 1 are called binary number systems.',
                'option_a' => 'use',
                'option_b' => 'they use',
                'option_c' => 'uses',
                'option_d' => 'using',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Genes, ______ the blueprints for cell construction, exist in tightly organized packages called chromosomes.',
                'option_a' => 'are',
                'option_b' => 'they are',
                'option_c' => 'which',
                'option_d' => 'which are',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 9,
                'question_text' => "The Earth's atmosphere consists of gases ______ in place around the Earth by the gravitational pull of the planet.",
                'option_a' => 'held',
                'option_b' => 'hold',
                'option_c' => 'it holds',
                'option_d' => 'the hold',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Oscar Hammerstein II collaborated with a number of composers including Jerome Kern, whom ______ in writing the musical Show Boat.',
                'option_a' => 'joined',
                'option_b' => 'was joined',
                'option_c' => 'he joined',
                'option_d' => 'joining',
                'correct_answer' => 'C',
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
