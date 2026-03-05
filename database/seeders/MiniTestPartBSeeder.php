<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class MiniTestPartBSeeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 102;
        $numberOfQuestions = 8; // Moved from M13S3
        $setNumber = 1;
        
        $questionsData = [
            [
                'q' => 1,
                'a' => "To look up some terms.",
                'b' => "To meet Stanley.",
                'c' => "To get a snack.",
                'd' => "To prepare for an exam.",
                'ans' => 'A'
            ],
            [
                'q' => 2,
                'a' => "His library card.",
                'b' => "A statistics book.",
                'c' => "Some index cards.",
                'd' => "A notebook.",
                'ans' => 'C'
            ],
            [
                'q' => 3,
                'a' => "Piles of note cards.",
                'b' => "The part of the library where journals are stored.",
                'c' => "The part of the library where books are shelved.",
                'd' => "A place to get something to eat.",
                'ans' => 'C'
            ],
            [
                'q' => 4,
                'a' => "Behind the main desk.",
                'b' => "The periodicals room.",
                'c' => "A lost and found office.",
                'd' => "The reference room.",
                'ans' => 'D'
            ],
            [
                'q' => 5,
                'a' => "The sport of mountain climbing.",
                'b' => "Classes the man is taking.",
                'c' => "An exhibit the man saw in a museum.",
                'd' => "A new activity the man is involved in.",
                'ans' => 'D'
            ],
            [
                'q' => 6,
                'a' => "A means of descending slopes.",
                'b' => "A method of climbing cliffs.",
                'c' => "A way to clean walls.",
                'd' => "A type of graffiti.",
                'ans' => 'A'
            ],
            [
                'q' => 7,
                'a' => "Educating people about geology.",
                'b' => "Cleaning up after careless people.",
                'c' => "Photographing mountain peaks.",
                'd' => "Rescuing people who are in danger.",
                'ans' => 'B'
            ],
            [
                'q' => 8,
                'a' => "Explore a cave with him.",
                'b' => "Take some photographs.",
                'c' => "Attend a meeting.",
                'd' => "Examine a crystal.",
                'ans' => 'C'
            ],
        ];

        $insertData = [];
        // Clear existing questions for this meeting
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
        foreach ($questionsData as $item) {
            $insertData[] = [
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $item['q'],
                'question_text' => 'Question ' . $item['q'],
                'audio_file' => null, 
                'option_a' => $item['a'],
                'option_b' => $item['b'],
                'option_c' => $item['c'],
                'option_d' => $item['d'],
                'correct_answer' => $item['ans'] ?? 'A',
                'transcript_en' => null,
                'transcript_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ToeflListeningQuestion::insert($insertData);
        
        $this->command->info("Mini Test Part B (Meeting $meetingNumber) seeded with " . count($insertData) . " questions.");
    }
}
