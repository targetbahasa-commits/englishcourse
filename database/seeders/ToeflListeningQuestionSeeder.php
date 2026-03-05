<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Create 40 questions across 20 meetings (2 questions per meeting)
        for ($meeting = 1; $meeting <= 20; $meeting++) {
            // Question 1 for this meeting
            ToeflListeningQuestion::create([
                'meeting_number' => $meeting,
                'question_number' => 1,
                'audio_file' => null, // Placeholder for audio file
                'question_text' => "Meeting {$meeting} - Question 1: What is the main topic of the conversation?",
                'option_a' => 'A university course registration',
                'option_b' => 'A library book reservation',
                'option_c' => 'A campus tour schedule',
                'option_d' => 'A student club meeting',
                'correct_answer' => 'A',
            ]);

            // Question 2 for this meeting
            ToeflListeningQuestion::create([
                'meeting_number' => $meeting,
                'question_number' => 2,
                'audio_file' => null, // Placeholder for audio file
                'question_text' => "Meeting {$meeting} - Question 2: What does the speaker suggest?",
                'option_a' => 'Taking notes during the lecture',
                'option_b' => 'Reading the textbook chapter',
                'option_c' => 'Attending the study group',
                'option_d' => 'Consulting with the professor',
                'correct_answer' => 'C',
            ]);
        }
    }
}
