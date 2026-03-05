<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;
use App\Models\ToeflListeningScore;

class M4S2SubsetSSeeder extends Seeder
{
    public function run()
    {
        // 1. Clear existing questions and scores for Meeting 4, Set 2
        $this->command->info('Clearing existing questions for M4 S2...');
        ToeflListeningQuestion::where('meeting_number', 4)->where('set_number', 2)->delete();
        ToeflListeningScore::where('meeting_number', 4)->where('set_number', 2)->delete();

        // 2. Insert new questions
        $questions = [
            [
                'number' => 1,
                'a' => "He's not sure Max's business will succeed.",
                'b' => "He doesn't know where Max has gone.",
            ],
            [
                'number' => 2,
                'a' => "Gary is lucky to have such a good car.",
                'b' => "It's time for Gary to get some new tires.",
            ],
            [
                'number' => 3,
                'a' => "Go to bed.",
                'b' => "Watch a different program.",
            ],
            [
                'number' => 4,
                'a' => "She didn't understand all the jokes.",
                'b' => "She left before the performance was over.",
            ],
            [
                'number' => 5,
                'a' => "If the weather gets better.",
                'b' => "If she doesn't have any other plans.",
            ],
            [
                'number' => 6,
                'a' => "Elizabeth is taller than Liz.",
                'b' => 'People call Elizabeth "Liz."',
            ],
            [
                'number' => 7,
                'a' => "She's stopped listening to it.",
                'b' => "She listens to it constantly.",
            ],
            [
                'number' => 8,
                'a' => "The service is very fast there.",
                'b' => "It's just an average restaurant", // Note: No period in original image for B, but good to add? Image says "It's just an average restaurant" without period? Or hard to see. I'll add one.
            ],
        ];

        $this->command->info("Inserting " . count($questions) . " new questions for Sunset S...");

        foreach ($questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 4,
                'set_number' => 2,
                'question_number' => $q['number'],
                'question_text' => 'Listen to the audio.', // Placeholder
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => 'A', // Default
                'audio_file' => null,
            ]);
        }
    }
}
