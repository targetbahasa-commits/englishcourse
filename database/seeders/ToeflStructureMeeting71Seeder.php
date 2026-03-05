<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting71Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 71)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 71,
                'title' => 'Structure Review Exercise (Skills 1-12)',
                'description' => 'Structure Meeting 71 - Review Skills 1-12',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '______ loom high above the northern and northeastern boundaries of the expanding city of Tucson.',
                'option_a' => 'The Santa Catalina mountains',
                'option_b' => 'Because the Santa Catalina mountains',
                'option_c' => 'The Santa Catalina mountains are',
                'option_d' => 'That the Santa Catalina mountains',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Radioactive ______ provides a powerful way to measure geologic time.',
                'option_a' => 'it',
                'option_b' => 'dates',
                'option_c' => 'dating',
                'option_d' => 'can',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => '______ contained in the chromosomes, and they are thought of as the units of heredity.',
                'option_a' => 'Genes which are',
                'option_b' => 'Genes are',
                'option_c' => 'When genes',
                'option_d' => 'Because of genes',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'The benefit ______ the study is that it provides necessary information to anyone who needs it.',
                'option_a' => 'of',
                'option_b' => 'which',
                'option_c' => 'that',
                'option_d' => 'because',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The same symptoms that occur ______ occur with cocaine.',
                'option_a' => 'amphetamines can',
                'option_b' => 'with amphetamines can',
                'option_c' => 'so amphetamines',
                'option_d' => 'with amphetamines they',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Many companies across the country have molded the concepts ______ describes into an integrated strategy for preventing stress.',
                'option_a' => 'and Wolf',
                'option_b' => 'that Wolf',
                'option_c' => 'what Wolf',
                'option_d' => 'so Wolf',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => '______ in the first draft of the budget will not necessarily be in the final draft.',
                'option_a' => 'Although it appears',
                'option_b' => 'It appears',
                'option_c' => 'What appears',
                'option_d' => 'Despite its appearance',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'If a food label indicates that a food is mostly carbohydrate, it does not mean ______ is a good food to eat.',
                'option_a' => 'and it',
                'option_b' => 'and',
                'option_c' => 'that it',
                'option_d' => 'when',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 9,
                'question_text' => 'A need for space law to include commercial concerns has been recognized inasmuch ______ been expanding drastically in recent years.',
                'option_a' => 'the commercial launch industry',
                'option_b' => 'the commercial launch industry has',
                'option_c' => 'as has the commercial launch industry',
                'option_d' => 'as the commercial launch industry has',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The report on the nuclear power plant indicated that when the plant had gone on line ______ unsafe.',
                'option_a' => 'and it had been',
                'option_b' => 'it had been',
                'option_c' => 'had been',
                'option_d' => 'that it had been',
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
