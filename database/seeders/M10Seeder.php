<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M10Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 10;
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
                'a' => "Doug is happy to be Rose's friend.",
                'b' => "Doug and Rose are no longer good friends.",
                'ans' => 'B'
            ],
            [
                'q' => 2,
                'a' => "He can do the job as well as a professional.",
                'b' => "He should hire an electrician to do the job.",
                'ans' => 'B'
            ],
            [
                'q' => 3,
                'a' => "This station now plays classical music.",
                'b' => "The station doesn't broadcast anything but news.",
                'ans' => 'B'
            ],
            [
                'q' => 4,
                'a' => "Changing the oil was easy for her.",
                'b' => "The oil didn't need to be changed.",
                'ans' => 'A'
            ],
            [
                'q' => 5,
                'a' => "He's not accustomed to early classes yet.",
                'b' => "His classes are difficult, too.",
                'ans' => 'A'
            ],
            [
                'q' => 6,
                'a' => "She's finally accustomed to roller-skating.",
                'b' => "She doesn't go skating as often as she once did.",
                'ans' => 'B'
            ],
            [
                'q' => 7,
                'a' => "He's going to clean his tie.",
                'b' => "He's going to take his tie to the laundry.",
                'ans' => 'B'
            ],
            [
                'q' => 8,
                'a' => "He moved the poster.",
                'b' => "He no longer likes the poster.",
                'ans' => 'A'
            ],
            [
                'q' => 9,
                'a' => "She may not be able to take a vacation in August.",
                'b' => "She's not sure when the busiest time will be.",
                'ans' => 'A'
            ],
            [
                'q' => 10,
                'a' => "She asked Greg to explain the point.",
                'b' => "She explained the point to Greg.",
                'ans' => 'A'
            ],
            [
                'q' => 11,
                'a' => "He isn't accustomed to his glasses.",
                'b' => "He looks quite different without glasses.",
                'ans' => 'B'
            ],
            [
                'q' => 12,
                'a' => "This type of weather is not new to him.",
                'b' => "He once lived in a very different climate.",
                'ans' => 'A'
            ],
            [
                'q' => 13,
                'a' => "She's going to take a picture of the members of her club.",
                'b' => "Someone is going to photograph her club.",
                'ans' => 'B'
            ],
            [
                'q' => 14,
                'a' => "She's never cooked with it.",
                'b' => "She doesn't feel comfortable using it.",
                'ans' => 'B'
            ],
            [
                'q' => 15,
                'a' => "If the deer will come near them.",
                'b' => "If they can approach the deer.",
                'ans' => 'B'
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
                'option_c' => '', // 2 Options only
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
