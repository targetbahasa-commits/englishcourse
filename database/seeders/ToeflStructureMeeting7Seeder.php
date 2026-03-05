<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 7)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 7,
                'title' => 'Noun Clauses',
                'description' => 'Structure Meeting 7 - Noun Clauses',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Today, the true story of ______ at Little Bighorn remains a mystery.',
                'option_a' => 'happened',
                'option_b' => 'it happened',
                'option_c' => 'what happened',
                'option_d' => 'what happening',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 2,
                'question_text' => 'For more than a decade, ______ that certain species are becoming scarce.',
                'option_a' => 'the warnings of bird-watchers',
                'option_b' => 'warn the bird-watchers',
                'option_c' => 'bird-watchers have warned',
                'option_d' => 'a warning for bird-watchers',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Early in the eighteenth century, Halley accurately predicted when ______ of 1682 would return.',
                'option_a' => 'the comet',
                'option_b' => 'was the comet',
                'option_c' => 'the comet was',
                'option_d' => 'had the comet',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'No single factor explains why ______ vary so greatly among individuals.',
                'option_a' => 'aging affects',
                'option_b' => 'the effects of aging',
                'option_c' => 'aging has an effect',
                'option_d' => 'the aging effect',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => "Lack of clarity about ______ the party in the coming year will be removed at the party's convention.",
                'option_a' => 'will lead',
                'option_b' => 'lead',
                'option_c' => 'they will lead',
                'option_d' => 'who will lead',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'We do not ______ the bow drill was first developed for woodworking or fire making.',
                'option_a' => 'whether it',
                'option_b' => 'know whether it',
                'option_c' => 'know whether',
                'option_d' => 'sure whether',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Minute Man National Historical Park is a monument to where ______.',
                'option_a' => 'the beginning of the Revolutionary War',
                'option_b' => 'in the beginning of the Revolutionary War',
                'option_c' => 'the Revolutionary War to begin',
                'option_d' => 'the Revolutionary War began',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Tests on the colors of cars were conducted at the University of California to determine ______ the safest colors for cars.',
                'option_a' => 'which',
                'option_b' => 'which were',
                'option_c' => 'if',
                'option_d' => 'how were',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The National Institute of Dental Research estimates ______ in fluoridated areas have about 25 percent less tooth decay than children elsewhere.',
                'option_a' => 'for school children',
                'option_b' => 'school children\'s',
                'option_c' => 'that school children',
                'option_d' => 'that for school children',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The process of photosynthesis explains how ______ able to use the energy in sunlight to manufacture foods from the simple chemicals in air and water.',
                'option_a' => 'green plants',
                'option_b' => 'green plants are',
                'option_c' => 'planting greens',
                'option_d' => 'with green plants are',
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
