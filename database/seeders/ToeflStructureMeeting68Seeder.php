<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting68Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 68)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 68,
                'title' => 'Structure Review Exercise (Skills 1-8)',
                'description' => 'Structure Meeting 68 - Review Skills 1-8',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Air near the equator ______ a faster west-to-east motion than air farther from the equator.',
                'option_a' => 'to have',
                'option_b' => 'it has',
                'option_c' => 'has',
                'option_d' => 'having',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 2,
                'question_text' => 'About 4000 B.C., humans discovered that ______ obtained from special rocks called ores.',
                'option_a' => 'metals could be',
                'option_b' => 'the ability of metallic',
                'option_c' => 'possibly metallic',
                'option_d' => 'could metals be',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => '______ quickly after an animal dies.',
                'option_a' => 'In the degradation of DNA',
                'option_b' => 'Degrading DNA',
                'option_c' => 'DNA degrades',
                'option_d' => 'For DNA to degrade',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 4,
                'question_text' => '______ aerodynamic design has contributed greatly to reducing resistance to motion.',
                'option_a' => 'Improved',
                'option_b' => 'It improves',
                'option_c' => 'Improvement',
                'option_d' => 'They improve',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The southern part of Florida is much warmer in the winter than the northern part, so more ______ to the south.',
                'option_a' => 'flocking tourists',
                'option_b' => 'touring flocks',
                'option_c' => 'flocks of tourists',
                'option_d' => 'tourists flock',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => "The Moon's gravity pulls water on the near side of the Earth toward the Moon, and this is what ______ tides to occur.",
                'option_a' => 'the cause',
                'option_b' => 'causes',
                'option_c' => 'causing',
                'option_d' => 'the cause of',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => '______, they pick up fragments of rock which become frozen into the base of the ice.',
                'option_a' => 'Glaciers move',
                'option_b' => 'Glaciers moving',
                'option_c' => 'They were glaciers',
                'option_d' => 'As glaciers move',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'The tape measure first evolved from ______ used by the Egyptians.',
                'option_a' => 'the chains measure',
                'option_b' => 'the chains are measured',
                'option_c' => 'the chains are measuring',
                'option_d' => 'the measuring chains',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 9,
                'question_text' => 'A typical Atlantic hurricane starts as a low pressure system near ______.',
                'option_a' => 'Africa coasts',
                'option_b' => 'coast to Africa',
                'option_c' => 'the African coast',
                'option_d' => 'Africa has a coast',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => 'It is not clear whether the subdivisions of the neocortex ______ units.',
                'option_a' => 'individual',
                'option_b' => 'are individual',
                'option_c' => 'they are individual',
                'option_d' => 'individually',
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
