<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 10)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 10,
                'title' => 'Sentences with Reduced Clauses',
                'description' => 'Structure Meeting 10 - Sentences with Reduced Clauses',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'When ______ nests during spring nesting season, Canadian geese are fiercely territorial.',
                'option_a' => 'building',
                'option_b' => 'are building',
                'option_c' => 'built',
                'option_d' => 'are built',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'In 1870, Calvin, along with Adirondack hunter Alvah Dunning, made the first known ascent of Seward Mountain, ______ far from roads or trails.',
                'option_a' => 'a remote peak',
                'option_b' => 'it is a remote peak',
                'option_c' => 'a remote peak is',
                'option_d' => 'which a remote peak',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Kokanee salmon begin to deteriorate and die soon ______ at the age of four.',
                'option_a' => 'they spawn',
                'option_b' => 'after spawning',
                'option_c' => 'spawn',
                'option_d' => 'spawned the salmon',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => '______ behind government secrecy for nearly half a century, the Hanford plant in central Washington produced plutonium for the nuclear weapons of the Cold War.',
                'option_a' => 'It is hidden',
                'option_b' => 'Hidden',
                'option_c' => 'Which is hidden',
                'option_d' => 'The plant is hiding',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Until ______ incorrect, astronomers had assumed that the insides of white dwarfs were uniform.',
                'option_a' => 'they',
                'option_b' => 'their proof',
                'option_c' => 'the astronomers recently proven',
                'option_d' => 'recently proven',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => '______ artifacts from the early Chinese dynasties, numerous archeologists have explored the southern Silk Road.',
                'option_a' => 'They were searching for',
                'option_b' => 'It was a search for',
                'option_c' => 'Searched for',
                'option_d' => 'Searching for',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 7,
                'question_text' => "In Hailey, the best-known lecturer was women's rights activist Abigail Scott Duniway of Portland, Oregon, who could usually be persuaded to speak ______ town visiting her son.",
                'option_a' => 'she was in',
                'option_b' => 'while in',
                'option_c' => 'while she was',
                'option_d' => 'was in',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 8,
                'question_text' => 'The National Restaurant ______ Washington, says that federal efforts to regulate workplace smoking would limit restaurants\' ability to respond to the desires of their patrons.',
                'option_a' => 'Association in',
                'option_b' => 'Association is in',
                'option_c' => 'Association which is in',
                'option_d' => 'Association, based in',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => '______ in North American waterways a little over a decade ago, zebra mussels have already earned a nasty reputation for their expensive habit of clogging water pipes in the Great Lakes area.',
                'option_a' => 'The first sighting',
                'option_b' => 'Although first sighted',
                'option_c' => 'Zebra mussels were first sighted',
                'option_d' => 'First sighting',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Small companies may take their goods abroad for trade shows without paying foreign value-added taxes by acquiring ______ an ATA carnet.',
                'option_a' => 'a document calls',
                'option_b' => 'a document called',
                'option_c' => 'calls a document',
                'option_d' => 'called a document',
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
