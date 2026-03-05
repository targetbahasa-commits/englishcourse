<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting69Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 69)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 69,
                'title' => 'Structure Review Exercise (Skills 9-12)',
                'description' => 'Structure Meeting 69 - Review Skills 9-12',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Dolphins form extremely complicated allegiances and ______ continually change.',
                'option_a' => 'enmities that',
                'option_b' => 'that are enmities',
                'option_c' => 'enmities that are',
                'option_d' => 'that enmities',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Scientists are now beginning to conduct experiments on ______ trigger different sorts of health risks.',
                'option_a' => 'noise pollution can',
                'option_b' => 'that noise pollution',
                'option_c' => 'how noise pollution',
                'option_d' => 'how noise pollution can',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => "The Apollo 11 astronauts ______ of the Earth's inhabitants witnessed on the famous first moonwalk on July 20, 1969, were Neil Armstrong and Buzz Aldrin.",
                'option_a' => 'whom',
                'option_b' => 'whom millions',
                'option_c' => 'were some',
                'option_d' => 'whom some were',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'At the end of the nineteenth century, Alfred Binet developed a test for measuring intelligence ______ served as the basis of modern IQ tests.',
                'option_a' => 'has',
                'option_b' => 'it has',
                'option_c' => 'and',
                'option_d' => 'which has',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 5,
                'question_text' => '______ have at least four hours of hazardous materials response training is mandated by federal law.',
                'option_a' => 'All police officers',
                'option_b' => 'All police officers must',
                'option_c' => 'That all police officers',
                'option_d' => 'For all police officers',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => "A cloud's reservoir of negative charge extends upward from the altitude at ______ the freezing point.",
                'option_a' => 'temperatures hit',
                'option_b' => 'hit temperatures',
                'option_c' => 'which temperatures hit',
                'option_d' => 'which hit temperatures',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => "In a 1988 advanced officers' training program, Sampson developed a plan to incorporate police in enforcing environmental protection laws whenever ______ feasible.",
                'option_a' => 'it is',
                'option_b' => 'is',
                'option_c' => 'has',
                'option_d' => 'it has',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 8,
                'question_text' => '______ will be carried in the next space shuttle payload has not yet been announced to the public.',
                'option_a' => 'It',
                'option_b' => 'What',
                'option_c' => 'When',
                'option_d' => 'That',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'During free fall, ______ up to a full minute, a skydiver will fall at a constant speed of 120 m.p.h.',
                'option_a' => 'it is',
                'option_b' => 'which is',
                'option_c' => 'being',
                'option_d' => 'is',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The fact ______ the most important ratings period is about to begin has caused all the networks to shore up their schedules.',
                'option_a' => 'is that',
                'option_b' => 'of',
                'option_c' => 'that',
                'option_d' => 'what',
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
