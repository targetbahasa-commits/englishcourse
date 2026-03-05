<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M8Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 8;
        $numberOfQuestions = 20;
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
                'a' => "Ginny is definitely coming to dinner.",
                'b' => "Ginny likes fish better than chicken.",
                'c' => "Ginny likes chicken.",
            ],
            [
                'q' => 2,
                'a' => "She had already moved.",
                'b' => "She hadn't found a new apartment yet.",
                'c' => "She'd already made an appointment.",
            ],
            [
                'q' => 3,
                'a' => "What the man's name is.",
                'b' => "Who told the man to see the dean.",
                'c' => "Who the dean is.",
            ],
            [
                'q' => 4,
                'a' => "He wants to take part in the election.",
                'b' => "He's not interested in running for office.",
                'c' => "He wants to get more facts from the president.",
            ],
            [
                'q' => 5,
                'a' => "She couldn't type very fast.",
                'b' => "She had already finished the final draft.",
                'c' => "She hadn't completed the research.",
            ],
            [
                'q' => 6,
                'a' => "He doesn't really like horseback riding.",
                'b' => "He rides horses whenever possible.",
                'c' => "He doesn't talk about riding very much.",
            ],
            [
                'q' => 7,
                'a' => "When his insurance agent called.",
                'b' => "What his insurance agent wanted.",
                'c' => "What time he should return the call.",
            ],
            [
                'q' => 8,
                'a' => "He was working full time.",
                'b' => "He was eating in the cafeteria.",
                'c' => "He didn't want a job.",
            ],
            [
                'q' => 9,
                'a' => "When they returned.",
                'b' => "How long their hike was.",
                'c' => "Where they hiked.",
            ],
            [
                'q' => 10,
                'a' => "He thinks the clothes are expensive.",
                'b' => "He doesn't think the clothes are very nice.",
                'c' => "He thinks the woman is being unreasonable.",
            ],
            [
                'q' => 11,
                'a' => "Where the meeting will be held.",
                'b' => "When the meeting will start.",
                'c' => "Where the recreation center will be built.",
            ],
            [
                'q' => 12,
                'a' => "Joy did not want to study abroad.",
                'b' => "The overseas program had been canceled.",
                'c' => "Joy would study overseas sooner than next year.",
            ],
            [
                'q' => 13,
                'a' => "If the party was at Ben's house.",
                'b' => "What time the party ended.",
                'c' => "If the man enjoyed the party.",
            ],
            [
                'q' => 14,
                'a' => "All of Ted's answers were incorrect.",
                'b' => "Most of the problems were done correctly.",
                'c' => "Ted doesn't have to solve the problems.",
            ],
            [
                'q' => 15,
                'a' => "How she got to the grocery store.",
                'b' => "Why she went to the grocery store.",
                'c' => "How much she paid for groceries.",
            ],
            [
                'q' => 16,
                'a' => "Robin's brother didn't help her get a job.",
                'b' => "Robin didn't get a job.",
                'c' => "Robin was able to help her brother.",
            ],
            [
                'q' => 17,
                'a' => "The flashlight had needed batteries.",
                'b' => "There had been some other problem with the flashlight.",
                'c' => "The woman hadn't changed the batteries.",
            ],
            [
                'q' => 18,
                'a' => "Professor Brennon surely won't lead the seminar.",
                'b' => "Professor Brennon's permission is not required.",
                'c' => "The woman doesn't need to take the seminar.",
            ],
            [
                'q' => 19,
                'a' => "Why Steve is in the Pacific Northwest.",
                'b' => "How long Steve has been traveling.",
                'c' => "When Steve will return from his trip.",
            ],
            [
                'q' => 20,
                'a' => "It hadn't been released yet.",
                'b' => "It wouldn't be very good.",
                'c' => "It can no longer be considered new.",
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
                'correct_answer' => 'A', // Placeholder
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
