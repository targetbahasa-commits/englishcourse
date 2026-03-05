<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M7Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 7;
        $numberOfQuestions = 16;
        $setNumber = 1;

        // Clear existing questions for this meeting
        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
            
        // Also clear scores to avoid mismatches
        DB::table('toefl_listening_scores')->where('meeting_number', $meetingNumber)->delete();

        $questionsData = [
            [
                'q' => 1,
                'a' => "declining an offer",
                'b' => "making a suggestion",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 2,
                'a' => "accepting an invitation",
                'b' => "making an offer",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 3,
                'a' => "declining an offer",
                'b' => "making a suggestion",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 4,
                'a' => "rejecting a request",
                'b' => "agreeing to a request",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 5,
                'a' => "giving an invitation",
                'b' => "making a suggestion",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 6,
                'a' => "agreeing to a request",
                'b' => "turning down an offer",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 7,
                'a' => "receive a suggestion",
                'b' => "make an offer",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 8,
                'a' => "suggesting a solution",
                'b' => "offering help",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 9,
                'a' => "giving an invitation",
                'b' => "accepting an offer",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => "declining an offer",
                'b' => "making a request",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 11,
                'a' => "do what the woman suggests",
                'b' => "turn down the woman's invitation",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 12,
                'a' => "agreeing to an offer",
                'b' => "refusing a request",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => "making a suggestion",
                'b' => "accepting an invitation",
                'c' => "",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 14,
                'a' => "requesting that the man do something",
                'b' => "giving the woman a suggestion",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 15,
                'a' => "rejecting a suggestion",
                'b' => "agreeing with a suggestion",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 16,
                'a' => "he can't accept her invitation",
                'b' => "he'd enjoy another sandwich",
                'c' => "",
                'd' => "",
                'ans' => 'B'
            ],
        ];

        $insertData = [];
        foreach ($questionsData as $item) {
            // Determine question text based on Q number
            $qText = "Question " . $item['q'];
            if ($item['q'] == 1) $qText = "The man is ...";
            if ($item['q'] == 2) $qText = "The woman is ...";
            if ($item['q'] == 3) $qText = "The woman is ...";
            if ($item['q'] == 4) $qText = "Mark is ...";
            if ($item['q'] == 5) $qText = "The woman is ...";
            if ($item['q'] == 6) $qText = "The man is ...";
            if ($item['q'] == 7) $qText = "Ed is probably going to ...";
            if ($item['q'] == 8) $qText = "The woman is ...";
            if ($item['q'] == 9) $qText = "Cynthia is ...";
            if ($item['q'] == 10) $qText = "The woman is ...";
            if ($item['q'] == 11) $qText = "The man will probably ...";
            if ($item['q'] == 12) $qText = "Bob is ...";
            if ($item['q'] == 13) $qText = "The man is ...";
            if ($item['q'] == 14) $qText = "The man is ...";
            if ($item['q'] == 15) $qText = "Paul is ...";
            if ($item['q'] == 16) $qText = "James tells the woman that ...";

            $insertData[] = [
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $item['q'],
                'question_text' => $qText,
                'audio_file' => null, 
                'option_a' => $item['a'],
                'option_b' => $item['b'],
                'option_c' => $item['c'],
                'option_d' => $item['d'],
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
