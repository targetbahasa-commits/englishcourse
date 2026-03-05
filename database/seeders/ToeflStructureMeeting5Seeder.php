<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 5)->firstOrFail();
        
        // Clear existing questions for this meeting
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => '____ first settled the Hawaiian Islands between A.D. 300 and 750.',
                'option_a' => 'The Polynesians',
                'option_b' => 'The Polynesians arrived',
                'option_c' => 'Because of the Polynesians',
                'option_d' => 'It was the Polynesians',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'In 1066, a bright comet ____ in the sky attracted much attention.',
                'option_a' => 'was appearing',
                'option_b' => 'appears',
                'option_c' => 'it appeared',
                'option_d' => 'appearing',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => 'In some daguerreotype cameras, ____ through a hole in the back of the box.',
                'option_a' => 'the object\'s view',
                'option_b' => 'the object was viewed',
                'option_c' => 'from the view of the object',
                'option_d' => 'viewed the object',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'In the Stone Age, stone tools ____ with other rock materials.',
                'option_a' => 'polishing',
                'option_b' => 'they polished',
                'option_c' => 'for polish',
                'option_d' => 'were polished',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The first steamship to cross the Atlantic ____ Savannah, in 1819.',
                'option_a' => 'was the',
                'option_b' => 'it was the',
                'option_c' => 'the',
                'option_d' => 'in it the',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The Earth\'s plates meet each other at cracks in the Earth ____ faults.',
                'option_a' => 'were called',
                'option_b' => 'calls',
                'option_c' => 'called',
                'option_d' => 'it was called',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The first plant-like organisms probably ____ in the sea, perhaps 3 billion years ago.',
                'option_a' => 'life',
                'option_b' => 'living',
                'option_c' => 'lived',
                'option_d' => 'it was living',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'In male pattern baldness, ____ strongly influences the degree of hair loss.',
                'option_a' => 'heredity',
                'option_b' => 'inherited',
                'option_c' => 'inherits',
                'option_d' => 'heredity has',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => 'In Watch the Skies, Curtis Peebles ____ attempt to explain America\'s belief in flying saucers.',
                'option_a' => 'makes a fascinating',
                'option_b' => 'making a fascinating',
                'option_c' => 'fascination with making',
                'option_d' => 'fascination made a',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The irregular coastline of ____ a succession of bays and inlets, with the hook of the Cape Cod peninsula in the southeast.',
                'option_a' => 'Massachusetts',
                'option_b' => 'Massachusetts is',
                'option_c' => 'Massachusetts it is',
                'option_d' => 'Massachusetts on',
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
