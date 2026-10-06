<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructureMeeting2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 2],
            [
                'title' => 'Verb Palsu',
                'description' => '',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The complex process of photosynthesis involves chlorophyll _____ light energy into chemical energy to fuel the organism\'s activities.',
                'option_a' => 'convert',
                'option_b' => 'converting',
                'option_c' => 'to convert',
                'option_d' => 'converted',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Astrophysicists generally consider the James Webb Space Telescope _____ a revolutionary tool for observing the earliest galaxies in the universe.',
                'option_a' => 'be',
                'option_b' => 'being',
                'option_c' => 'to be',
                'option_d' => 'is',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Historically, many nomadic tribes across the Eurasian Steppe specialized in _____ horses for both warfare and transportation.',
                'option_a' => 'breeding',
                'option_b' => 'breed',
                'option_c' => 'to breed',
                'option_d' => 'bred',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'The primary objective of the Antarctic Treaty is _____ the continent for peaceful scientific research only.',
                'option_a' => 'reserve',
                'option_b' => 'to reserve',
                'option_c' => 'reserving',
                'option_d' => 'reserved',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Economists emphasize that the central bank cannot risk _____ interest rates too sharply without affecting consumer spending.',
                'option_a' => 'to raise',
                'option_b' => 'raising',
                'option_c' => 'rise',
                'option_d' => 'raised',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Sociologists have observed that human beings possess an innate tendency _____ social hierarchies within any given community.',
                'option_a' => 'to form',
                'option_b' => 'forming',
                'option_c' => 'for forming',
                'option_d' => 'formed',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Modern surgical techniques aim at _____ the recovery time for patients undergoing invasive procedures.',
                'option_a' => 'minimize',
                'option_b' => 'to minimize',
                'option_c' => 'minimized',
                'option_d' => 'minimizing',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Ancient civilizations often used complex irrigation systems to avoid _____ their crops during periods of severe drought.',
                'option_a' => 'lose',
                'option_b' => 'to lose',
                'option_c' => 'losing',
                'option_d' => 'lost',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Scholars continue to debate whether the Voynich Manuscript was intended _____ a genuine scientific treatise or a sophisticated hoax.',
                'option_a' => 'be',
                'option_b' => 'been',
                'option_c' => 'being',
                'option_d' => 'to be',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Environmentalists have succeeded in _____ several endangered species from the brink of extinction through habitat restoration.',
                'option_a' => 'prevent',
                'option_b' => 'to prevent',
                'option_c' => 'preventing',
                'option_d' => 'prevented',
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
                'explanation' => $q['explanation'] ?? null,
            ]);
        }
    }
}
