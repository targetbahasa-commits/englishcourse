<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting8Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 8)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 8,
                'title' => 'Adjective Clauses',
                'description' => 'Structure Meeting 8 - Adjective Clauses',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Modern humans, who first appeared about 600,000 years ago, ______ Homo sapiens.',
                'option_a' => 'calling',
                'option_b' => 'were called',
                'option_c' => 'they called',
                'option_d' => 'they were called',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The first writing ______ evidence of is on Mesopotamian clay tablets.',
                'option_a' => 'we',
                'option_b' => 'that we',
                'option_c' => 'has',
                'option_d' => 'that we have',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => '______ drought-resistant plants which store water in fleshy tissue.',
                'option_a' => 'Succulents are',
                'option_b' => 'Succulents',
                'option_c' => 'They are succulents',
                'option_d' => 'Succulents which are',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Benjamin Kabelsky, whom ______ as Jack Benny, was a famous comedian in vaudeville and on radio and television.',
                'option_a' => "most people's knowledge",
                'option_b' => 'most people know',
                'option_c' => 'knowing most people',
                'option_d' => 'the knowledge of most people',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => '______ that hunted other animals tended to have very narrow, sharp, curved claws.',
                'option_a' => 'For dinosaurs',
                'option_b' => 'Dinosaurs are known',
                'option_c' => 'Dinosaurs',
                'option_d' => 'Like dinosaurs',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The first eyeglasses had convex lenses for the aged who ______ farsighted.',
                'option_a' => 'had become',
                'option_b' => 'they had become',
                'option_c' => 'becoming',
                'option_d' => 'it became',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Chimney Rock, ______ 500 feet above the North Platte River, has eroded considerably in the last two centuries.',
                'option_a' => 'stands',
                'option_b' => 'is standing',
                'option_c' => 'it stands',
                'option_d' => 'which stands',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => '______ that accompany recurring bouts of severe depression reduce bone density.',
                'option_a' => 'It changes hormones',
                'option_b' => 'Hormonal changes',
                'option_c' => 'The hormones change',
                'option_d' => 'The change in hormones is',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Willa Cather is an author ______ for her evocative and memorable vision of frontier prairie life.',
                'option_a' => 'whom readers',
                'option_b' => 'the praise of readers',
                'option_c' => 'whom praisings',
                'option_d' => 'whom readers praise',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => "Mars's tiny moon Phobos is a small mountain of rock that ______ from the asteroid belt by Mars's gravitational pull.",
                'option_a' => 'was probably captured',
                'option_b' => 'it probably',
                'option_c' => 'the probable capture',
                'option_d' => 'probably the capture',
                'correct_answer' => 'A',
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
