<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class PopulateToeflListeningMeeting2Seeder extends Seeder
{
    public function run(): void
    {
        // Delete existing questions for Meeting 2
        ToeflListeningQuestion::where('meeting_number', 2)->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Get in a different lane.',
                'option_b' => 'Stand in another line.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Go down the slide.',
                'option_b' => 'Play on the sled.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Put them in a file.',
                'option_b' => 'Throw them in a pile.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Listen to the audio.',
                'option_a' => "He can't shut his suitcase.",
                'option_b' => "His suitcase doesn't fit in the closet.",
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'She made bread from whole wheat.',
                'option_b' => 'She baked some white bread.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Listen to the audio.',
                'option_a' => "It's being audio.",
                'option_b' => 'Brenda is typing it.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Emily bought new clothes.',
                'option_b' => 'Emily recently moved.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Its taste has improved.',
                'option_b' => 'It tastes slightly bitter.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'How much the ticket cost.',
                'option_b' => 'What Ellen might win.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Listen to the audio.',
                'option_a' => "It's been chipped.",
                'option_b' => "There's a ship inside it.",
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 11,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'He tripped in the aisle.',
                'option_b' => 'He slipped in some oil.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 12,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'For its fast horses.',
                'option_b' => 'For its natural resources.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 13,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Thinking about the decision.',
                'option_b' => 'Arguing about the issue.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 14,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'The color is too bright.',
                'option_b' => "It doesn't fit around the neck.",
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 15,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Wrote his name on the paper.',
                'option_b' => 'Told his students to write a paper.',
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
        ];

        foreach ($questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 2,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'], 
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'audio_file' => null, 
            ]);
        }
    }
}
