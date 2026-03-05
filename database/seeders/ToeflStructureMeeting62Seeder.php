<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting62Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 62)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 62,
                'title' => 'Adverbial Clause (Exercise 2)',
                'description' => 'Structure Meeting 6 - Exercise 2',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'A spacecraft is freed from friction ______ launched into space.',
                'option_a' => 'it',
                'option_b' => 'it is',
                'option_c' => 'after is',
                'option_d' => 'after it is',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 2,
                'question_text' => '______ with their surroundings, or they hide in crevices for protection.',
                'option_a' => 'Lobsters',
                'option_b' => 'Lobsters blend',
                'option_c' => 'Lobsters blending',
                'option_d' => 'Because lobsters blend',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 3,
                'question_text' => '______ a ball-and-socket joint, the elbow is a simple hinge joint.',
                'option_a' => 'While the shoulder',
                'option_b' => 'While the shoulder is',
                'option_c' => 'The shoulder is',
                'option_d' => 'The shoulder',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'A car has several sections with moving parts, ______ of those parts is essential.',
                'option_a' => 'good lubrication',
                'option_b' => 'well lubricated',
                'option_c' => 'and good lubrication',
                'option_d' => 'and well lubricated',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Bears cannot see well ______ small eyes.',
                'option_a' => 'bears have',
                'option_b' => 'because having',
                'option_c' => 'because they have',
                'option_d' => 'because of bears',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => '______ at the Isthmus of Panama, so animals were able to migrate between North and South America.',
                'option_a' => 'A land bridge existed',
                'option_b' => 'When a land bridge existed',
                'option_c' => 'A land bridge',
                'option_d' => 'With a land bridge',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => '______ mostly made of granite, it also contains some human-made materials.',
                'option_a' => 'The Empire State Building',
                'option_b' => 'The Empire State Building is',
                'option_c' => 'Although the Empire State Building is',
                'option_d' => 'Although the Empire State Building is built',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Pressure differences make the eardrum vibrate ______ the ear.',
                'option_a' => 'enters the sound waves',
                'option_b' => 'as sound waves',
                'option_c' => 'sound waves enter',
                'option_d' => 'as sound waves enter',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 9,
                'question_text' => 'An optical microscope magnifies as much as 2,000 times, but an electron microscope ______ as much as a million times.',
                'option_a' => 'magnifying',
                'option_b' => 'it magnifies',
                'option_c' => 'can magnify',
                'option_d' => 'magnify it',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => 'If scientific estimates are accurate, ______ with the Earth about 20,000 years ago.',
                'option_a' => 'the Cañon Diablo meteorite collided',
                'option_b' => 'the collision of the Cañon Diablo meteorite',
                'option_c' => 'the Cañon Diablo meteorite colliding',
                'option_d' => 'colliding the Cañon Diablo meteorite',
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
