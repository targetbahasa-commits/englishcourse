<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M9Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 9;
        $numberOfQuestions = 15;
        $setNumber = 1;

        // Clear existing questions for this meeting
        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
            
        // Also clear scores
        DB::table('toefl_listening_scores')->where('meeting_number', $meetingNumber)->delete();

        $questionsData = [
            [
                'q' => 1,
                'a' => "Road conditions.",
                'b' => "A weather report.",
                'c' => "Motel reservations.",
                'ans' => 'A'
            ],
            [
                'q' => 2,
                'a' => "Go to the concert.",
                'b' => "Listen to jazz on the radio.",
                'c' => "Buy more tickets.",
                'ans' => 'A'
            ],
            [
                'q' => 3,
                'a' => "The man's car is not running.",
                'b' => "The man isn't going to the party.",
                'c' => "The car isn't big enough for four people.",
                'ans' => 'C'
            ],
            [
                'q' => 4,
                'a' => "Stay inside.",
                'b' => "Find his umbrella.",
                'c' => "Look outside.",
                'ans' => 'A'
            ],
            [
                'q' => 5,
                'a' => "A store.",
                'b' => "A bridge.",
                'c' => "A street.",
                'ans' => 'B'
            ],
            [
                'q' => 6,
                'a' => "Shop for groceries.",
                'b' => "Leave for a camping trip.",
                'c' => "Go to a circus.",
                'ans' => 'B'
            ],
            [
                'q' => 7,
                'a' => "Ask for medicine for his headaches.",
                'b' => "Buy some new frames for his eyeglasses.",
                'c' => "Get different lenses for his glasses.",
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => "Clothing.",
                'b' => "Hair styling.",
                'c' => "Painting.",
                'ans' => 'C'
            ],
            [
                'q' => 9,
                'a' => "Take a trip.",
                'b' => "Watch television.",
                'c' => "Examine some documents.",
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => "He lent it to someone else.",
                'b' => "It was ruined in the rain.",
                'c' => "He forgot where he left it.",
                'ans' => 'B'
            ],
            [
                'q' => 11,
                'a' => "A car.",
                'b' => "A magazine.",
                'c' => "A computer.",
                'ans' => 'C'
            ],
            [
                'q' => 12,
                'a' => "Go directly to business school.",
                'b' => "Look for a job with a big company.",
                'c' => "Start her own business.",
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => "Playing cards.",
                'b' => "Making dinner.",
                'c' => "Repairing a boat.",
                'ans' => 'A'
            ],
            [
                'q' => 14,
                'a' => "He doesn't have Phyllis's address.",
                'b' => "He's upset with Phyllis.",
                'c' => "He doesn't have a stamp.",
                'ans' => 'C'
            ],
            [
                'q' => 15,
                'a' => "Order a salad.",
                'b' => "Go to another restaurant.",
                'c' => "Put some salt in her soup.",
                'ans' => 'A'
            ],
        ];

        $insertData = [];
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
                'option_d' => '',
                'correct_answer' => $item['ans'],
                'transcript_en' => null,
                'transcript_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ToeflListeningQuestion::insert($insertData);
        
        $this->command->info("Meeting $meetingNumber Set $setNumber seeded with " . count($insertData) . " questions.");
    }
}
