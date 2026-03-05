<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 12)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 12,
                'title' => 'Sentences with Inverted Subjects and Verbs (Review)',
                'description' => 'Structure Meeting 12 - Inverted Subjects and Verbs Review',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Rarely ______ located near city lights or at lower elevations.',
                'option_a' => 'observatories are',
                'option_b' => 'are',
                'option_c' => 'in the observatories',
                'option_d' => 'are observatories',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 2,
                'question_text' => 'There are geographic, economic, and cultural reasons why ______ around the world.',
                'option_a' => 'diets differ',
                'option_b' => 'do diets differ',
                'option_c' => 'are diets different',
                'option_d' => 'to differ a diet',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Were ______ millions of dollars each year replenishing eroding beaches, the coastline would be changing even more rapidly.',
                'option_a' => 'the U.S. Army Corps of Engineers not spending',
                'option_b' => 'the U.S. Army Corps of Engineers not spend',
                'option_c' => 'the U.S. Army Corps of Engineers does not spend',
                'option_d' => 'not spending the U.S. Army Corps of Engineers',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Nowhere ______ more skewed than in the auto industry.',
                'option_a' => 'that retail trade figures',
                'option_b' => 'retail trade figures are',
                'option_c' => 'are retail trade figures',
                'option_d' => 'retail trade figures',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => 'New York City\'s Central Park is nearly twice as large ______ second smallest country, Monaco.',
                'option_a' => 'as',
                'option_b' => 'is the',
                'option_c' => 'as is',
                'option_d' => 'as is the',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Potassium has a valence of positive one because it usually loses one electron when ______ with other elements.',
                'option_a' => 'does it combine',
                'option_b' => 'it combines',
                'option_c' => 'in combining',
                'option_d' => 'combination',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The economic background of labor legislation will not be mentioned in this course, ______ be treated.',
                'option_a' => 'trade unionism will not',
                'option_b' => 'nor trade unionism will',
                'option_c' => 'nor will trade unionism',
                'option_d' => 'neither trade unionism will',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => '______ test positive for antibiotics when tanker trucks arrive at a milk processing plant, according to federal law, the entire truckload must be discarded.',
                'option_a' => 'Should milk',
                'option_b' => 'If milk',
                'option_c' => 'If milk is',
                'option_d' => 'Milk should',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Located behind ______ the two lacrimal glands.',
                'option_a' => 'each eyelid',
                'option_b' => 'is each eyelid',
                'option_c' => 'each eyelid are',
                'option_d' => 'each eyelid which is',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Only for a short period of time ______ run at top speed.',
                'option_a' => 'cheetahs',
                'option_b' => 'do cheetahs',
                'option_c' => 'that a cheetah can',
                'option_d' => 'can',
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
