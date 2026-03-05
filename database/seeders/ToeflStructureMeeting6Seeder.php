<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting6Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 6)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 6,
                'title' => 'Adverbial Clause',
                'description' => 'Structure Meeting 6',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The three basic chords in ______ the tonic, the dominant, and the subdominant.',
                'option_a' => 'functional harmony',
                'option_b' => 'functional harmony is',
                'option_c' => 'functional harmony are',
                'option_d' => 'functional harmony they are',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 2,
                'question_text' => '______ Hale Telescope, at the Palomar Observatory in southern California, scientists can photograph objects several billion light years away.',
                'option_a' => 'The',
                'option_b' => 'With the',
                'option_c' => 'They use the',
                'option_d' => 'It is the',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Without the proper card installed inside the computer, ______ impossible to run a graphics program.',
                'option_a' => 'is definitely',
                'option_b' => 'because of',
                'option_c' => 'it is',
                'option_d' => 'is',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 4,
                'question_text' => 'The charter for the Louisiana lottery was coming up for renewal, ______ spared no expense in the fight to win renewal.',
                'option_a' => 'the lottery committee',
                'option_b' => 'so the lottery committee and',
                'option_c' => 'so the lottery committee',
                'option_d' => 'the lottery committee made',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'While in reality Alpha Centauri is a triple star, ______ to the naked eye to be a single star.',
                'option_a' => 'it appears',
                'option_b' => 'but it appears',
                'option_c' => 'appears',
                'option_d' => 'despite it',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => "The Sun's gravity severely distorted the path of the comet ______ entered its wildly erratic orbit around Jupiter.",
                'option_a' => 'it',
                'option_b' => 'when',
                'option_c' => 'after the comet came into it',
                'option_d' => 'once the comet',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => "Each object ______ Jupiter's magnetic field is deluged with electrical charges.",
                'option_a' => 'enters',
                'option_b' => 'it enters',
                'option_c' => 'entering',
                'option_d' => 'enter',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'As its name suggests, the Prairie Wetlands Resource Center ______ the protection of wetlands on the prairies of the Dakotas, Montana, Minnesota, and Nebraska.',
                'option_a' => 'it focuses',
                'option_b' => 'focuses on',
                'option_c' => 'focusing',
                'option_d' => 'to focus on',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 9,
                'question_text' => "One of the largest and most powerful birds of prey in the world, ______ a six-foot wingspan and legs and talons roughly the size of a man's arms and legs.",
                'option_a' => 'so the harpy has',
                'option_b' => 'the harpy having',
                'option_c' => 'with the harpy having',
                'option_d' => 'the harpy has',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => '______ creation of such a community was a desirable step, the requisite political upheaval had to be accepted.',
                'option_a' => 'Since the',
                'option_b' => 'The',
                'option_c' => 'Later, the',
                'option_d' => 'It was the',
                'correct_answer' => 'B',
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
