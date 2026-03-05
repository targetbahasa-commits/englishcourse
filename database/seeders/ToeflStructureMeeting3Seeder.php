<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 3)->firstOrFail();
        
        // Clear existing questions for this meeting
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The North Platte River ____ from Wyoming into Nebraska.',
                'option_a' => 'it flowed',
                'option_b' => 'flows',
                'option_c' => 'flowing',
                'option_d' => 'with flowing water',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => '____ Biloxi received its name from a Sioux word meaning "first people."',
                'option_a' => 'The city of',
                'option_b' => 'Located in',
                'option_c' => 'It is in',
                'option_d' => 'The tour included',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'A pride of lions ____ up to forty lions, including one to three males, several females, and cubs.',
                'option_a' => 'can contain',
                'option_b' => 'it contains',
                'option_c' => 'contain',
                'option_d' => 'containing',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => '____ tea plant are small and white.',
                'option_a' => 'The',
                'option_b' => 'On the',
                'option_c' => 'Having flowers the',
                'option_d' => 'The flowers of the',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The tetracyclines, ____ antibiotics, are used to treat infections.',
                'option_a' => 'are a family of',
                'option_b' => 'being a family',
                'option_c' => 'a family of',
                'option_d' => 'their family is',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Any possible academic assistance from taking stimulants ____ marginal at best.',
                'option_a' => 'it is',
                'option_b' => 'there is',
                'option_c' => 'is',
                'option_d' => 'as',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Henry Adams, born in Boston, ____ famous as a historian and novelist.',
                'option_a' => 'became',
                'option_b' => 'and became',
                'option_c' => 'he was',
                'option_d' => 'and he became',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 8,
                'question_text' => 'The major cause ____ the pull of the Moon on the Earth.',
                'option_a' => 'the ocean tides are',
                'option_b' => 'of ocean tides is',
                'option_c' => 'of the tides in the ocean',
                'option_d' => 'the oceans\' tides',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Still a novelty in the late nineteenth century, ____ limited to the rich.',
                'option_a' => 'was',
                'option_b' => 'was photography',
                'option_c' => 'it was photography',
                'option_d' => 'photography was',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => 'A computerized map of the freeways using information gathered by sensors embedded in the pavement ____ on a local cable channel during rush hours.',
                'option_a' => 'airs',
                'option_b' => 'airing',
                'option_c' => 'air',
                'option_d' => 'to air',
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
