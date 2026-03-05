<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting11Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 11)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 11,
                'title' => 'Sentences with Inverted Subjects and Verbs',
                'description' => 'Structure Meeting 11 - Sentences with Inverted Subjects and Verbs',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'In the United States ______ approximately four million miles of roads, streets, and highways.',
                'option_a' => 'there',
                'option_b' => 'is',
                'option_c' => 'they',
                'option_d' => 'there are',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 2,
                'question_text' => '______ twelve million immigrants entered the United States via Ellis Island.',
                'option_a' => 'More than',
                'option_b' => 'There were more than',
                'option_c' => 'Of more than',
                'option_d' => 'The report of',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'The television, ______ so long been a part of our culture, has an enormous influence.',
                'option_a' => 'has',
                'option_b' => 'it has',
                'option_c' => 'which',
                'option_d' => 'which has',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Psychologists have traditionally maintained that infants cannot formulate long-term memories until ______ the age of eight or nine months.',
                'option_a' => 'they',
                'option_b' => 'they reach',
                'option_c' => 'to reach',
                'option_d' => 'reach',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => '______ a cheese shop has since grown into a small conglomerate consisting of a catering business and two retail stores.',
                'option_a' => 'In the beginning of',
                'option_b' => 'It began as',
                'option_c' => 'Its beginning which was',
                'option_d' => 'What began as',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Primarily a government contractor, ______ preferential treatment from government agencies as both a minority-group member and a woman.',
                'option_a' => 'receives Weber',
                'option_b' => 'Weber receives',
                'option_c' => 'the reception of Weber',
                'option_d' => 'according to Weber\'s reception',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Because the project depends on ______ at the federal level, the city and county may have to wait until the budget cutting ends.',
                'option_a' => 'it happens',
                'option_b' => 'which happening',
                'option_c' => 'what happens',
                'option_d' => 'that it happens',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => '______ definitive study of a western hard-rock mining community cemetery appears to have been done in Silver City, Nevada.',
                'option_a' => 'Most',
                'option_b' => 'The most',
                'option_c' => 'Where most',
                'option_d' => 'Where the most',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'One of the areas of multimedia that is growing quickly ______ is sound.',
                'option_a' => 'yet is easily overlooked',
                'option_b' => 'is easily overlooked',
                'option_c' => 'it is easily overlooked',
                'option_d' => 'that is easily overlooked',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => '______, early approaches for coping with workplace stress dealt with the problem only after its symptoms had appeared.',
                'option_a' => 'Although well-intending',
                'option_b' => 'Although it is a good intention',
                'option_c' => 'Although a good intention',
                'option_d' => 'Although well-intended',
                'correct_answer' => 'D',
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
