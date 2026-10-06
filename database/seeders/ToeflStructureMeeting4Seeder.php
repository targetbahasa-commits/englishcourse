<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::updateOrCreate(
            ['meeting_number' => 4],
            [
                'title' => 'FANBOYS',
                'description' => '',
                'is_locked' => false,
            ]
        );

        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'The first ____ appeared during the last period of the dinosaurs\' reign.',
                'option_a' => 'flowers are plants',
                'option_b' => 'plants have flowers',
                'option_c' => 'plants flowers',
                'option_d' => 'flowering plants',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The earliest medicines ____ from plants of various sorts.',
                'option_a' => 'obtaining',
                'option_b' => 'they obtained',
                'option_c' => 'were obtained',
                'option_d' => 'they were obtained',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Simple sails were made from canvas ____ over a frame.',
                'option_a' => 'a stretch',
                'option_b' => 'stretched',
                'option_c' => 'was stretched',
                'option_d' => 'it was stretched',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Pluto\'s moon, Charon, ____ in a slightly elliptical path around the planet.',
                'option_a' => 'moving',
                'option_b' => 'is moving',
                'option_c' => 'it was moving',
                'option_d' => 'in its movement',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Techniques of breath control form an essential part of any ____ program to improve the voice.',
                'option_a' => 'it trains',
                'option_b' => 'train',
                'option_c' => 'trains',
                'option_d' => 'training',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Robert E. Lee ____ the Confederate army to General Grant in 1865 at the Appomattox Courthouse.',
                'option_a' => 'surrendered',
                'option_b' => 'he surrendered',
                'option_c' => 'surrendering',
                'option_d' => 'surrender',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The pituitary gland, ____ the brain, releases hormones to control other glands.',
                'option_a' => 'finds itself below',
                'option_b' => 'it is found below',
                'option_c' => 'its foundation below',
                'option_d' => 'found below',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'At around two years of age, many children regularly produce sentences ____ three or four words.',
                'option_a' => 'are containing',
                'option_b' => 'containing',
                'option_c' => 'contain',
                'option_d' => 'contains',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Multinational companies ____ it increasingly important to employ internationally acceptable brand names.',
                'option_a' => 'are finding',
                'option_b' => 'finding',
                'option_c' => 'they find',
                'option_d' => 'they are finding',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The cornea is located under the conjunctiva, on ____ of the eye.',
                'option_a' => 'the part is exposed',
                'option_b' => 'exposed the part',
                'option_c' => 'the exposed part',
                'option_d' => 'exposes the part',
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
