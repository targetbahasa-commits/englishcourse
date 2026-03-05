<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting67Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 67)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 67,
                'title' => 'Structure Review Exercise (Skills 1-8)',
                'description' => 'Structure Meeting 67 - Review Skills 1-8',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '______ of the Pueblo Indians centered on intensive agriculture.',
                'option_a' => 'The economic activity',
                'option_b' => 'Because the economic activity',
                'option_c' => 'The economy was active',
                'option_d' => 'When the economic activity',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'In popular terminology, any long snowstorm with ______ is called a blizzard.',
                'option_a' => 'the amount of wind is large',
                'option_b' => 'a large amount of wind',
                'option_c' => 'it is very windy',
                'option_d' => 'very windy',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Nuclear power can be produced by fusion, ______ produced by fission.',
                'option_a' => 'it can also be',
                'option_b' => 'it can also',
                'option_c' => 'just as it can be',
                'option_d' => 'and it can also',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 4,
                'question_text' => '______, igneous rocks may be changed into gneisses.',
                'option_a' => 'The temperature is high',
                'option_b' => 'If the temperature is high',
                'option_c' => 'High temperatures',
                'option_d' => 'If high temperature',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => 'In 1905, Henry Flagler ______ his plans to extend his Florida East Coast Railway out across the sea to Key West.',
                'option_a' => 'it was announced',
                'option_b' => 'announcement',
                'option_c' => 'the announcement of',
                'option_d' => 'announced',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The sound ______ from a vibrating object will be high or low depending on the number of vibrations.',
                'option_a' => 'comes',
                'option_b' => 'it is coming',
                'option_c' => 'is coming',
                'option_d' => 'coming',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 7,
                'question_text' => 'During the late 1880s, urban streetcars were electrified through ______ large motors.',
                'option_a' => 'they used',
                'option_b' => 'used',
                'option_c' => 'the use of',
                'option_d' => 'when they used',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => '______ almost 274 square miles, but 96 percent of the park is under water.',
                'option_a' => 'Although Biscayne National Park encompasses',
                'option_b' => 'Biscayne National Park encompasses',
                'option_c' => 'Biscayne National Park encompassing',
                'option_d' => 'Biscayne National Park',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Legislation ______ in 1916 and 1917 gave the Wilson administration authority to intervene in the national economy if it proved necessary.',
                'option_a' => 'it was passed',
                'option_b' => 'was passed',
                'option_c' => 'passed',
                'option_d' => 'passes',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => "Because a family of birds set up housekeeping in Joel Chandler Harris's mailbox when the birds were in need of a place to stay, ______ the Wren's Nest.",
                'option_a' => 'the home is named',
                'option_b' => 'so the home is named',
                'option_c' => 'naming the home',
                'option_d' => "the home's name",
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
