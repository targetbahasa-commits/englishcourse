<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflStructureMeeting;
use App\Models\ToeflStructureQuestion;

class StructureMeeting2Seeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Meeting 2 exists
        $meeting = ToeflStructureMeeting::firstOrCreate(
            ['meeting_number' => 2],
            [
                'title' => 'Structure Meeting 2',
                'description' => 'Gerunds and Infinitives',
                'is_locked' => false,
            ]
        );

        // 2. Clear existing questions for this meeting to avoid duplicates
        ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        // 3. Insert new questions
        $questions = [
            [
                'question_text' => 'The complex process of photosynthesis involves chlorophyll _____ light energy into chemical energy to fuel the organism\'s activities.',
                'option_a' => 'convert',
                'option_b' => 'converting',
                'option_c' => 'to convert',
                'option_d' => 'converted',
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Astrophysicists generally consider the James Webb Space Telescope _____ a revolutionary tool for observing the earliest galaxies in the universe.',
                'option_a' => 'be',
                'option_b' => 'being',
                'option_c' => 'to be',
                'option_d' => 'is',
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Historically, many nomadic tribes across the Eurasian Steppe specialized in _____ horses for both warfare and transportation.',
                'option_a' => 'breeding',
                'option_b' => 'breed',
                'option_c' => 'to breed',
                'option_d' => 'bred',
                'correct_answer' => 'A',
            ],
            [
                'question_text' => 'The primary objective of the Antarctic Treaty is _____ the continent for peaceful scientific research only.',
                'option_a' => 'reserve',
                'option_b' => 'to reserve',
                'option_c' => 'reserving',
                'option_d' => 'reserved',
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Economists emphasize that the central bank cannot risk _____ interest rates too sharply without affecting consumer spending.',
                'option_a' => 'to raise',
                'option_b' => 'raising',
                'option_c' => 'rise',
                'option_d' => 'raised',
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Sociologists have observed that human beings possess an innate tendency _____ social hierarchies within any given community.',
                'option_a' => 'forming',
                'option_b' => 'to form',
                'option_c' => 'for forming',
                'option_d' => 'formed',
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Modern surgical techniques aim at _____ the recovery time for patients undergoing invasive procedures.',
                'option_a' => 'minimize',
                'option_b' => 'to minimize',
                'option_c' => 'minimizing',
                'option_d' => 'minimized',
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Ancient civilizations often used complex irrigation systems to avoid _____ their crops during periods of severe drought.',
                'option_a' => 'lose',
                'option_b' => 'to lose',
                'option_c' => 'losing',
                'option_d' => 'lost',
                'correct_answer' => 'C',
            ],
            [
                'question_text' => 'Scholars continue to debate whether the Voynich Manuscript was intended _____ a genuine scientific treatise or a sophisticated hoax.',
                'option_a' => 'be',
                'option_b' => 'to be',
                'option_c' => 'being',
                'option_d' => 'been',
                'correct_answer' => 'B',
            ],
            [
                'question_text' => 'Environmentalists have succeeded in _____ several endangered species from the brink of extinction through habitat restoration.',
                'option_a' => 'prevent',
                'option_b' => 'to prevent',
                'option_c' => 'preventing',
                'option_d' => 'prevented',
                'correct_answer' => 'C',
            ],
        ];

        foreach ($questions as $index => $q) {
            ToeflStructureQuestion::create([
                'section_id' => $meeting->id,
                'question_number' => $index + 1,
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        $this->command->info('Structure Meeting 2 seeded successfully with 10 new questions!');
    }
}
