<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M7S2Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 7;
        $setNumber = 2;

        // Clear existing questions for meeting 7 set 2
        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
            
        // We do NOT clear scores for the whole meeting here, because Set 1 might be in use and have scores.

        $questionsData = [
            [
                'q' => 1,
                'a' => "He would like a cigarette.",
                'b' => "The woman can smoke if she likes.",
                'c' => "He doesn't want the woman to smoke.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 2,
                'a' => "The man wears it quite often.",
                'b' => "It needs to be cleaned.",
                'c' => "The man should wear it.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 3,
                'a' => "Make more popcorn.",
                'b' => "Go to another theater.",
                'c' => "Buy some popcorn.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 4,
                'a' => "She could plan the trip.",
                'b' => "She may not feel well.",
                'c' => "She can go on the class trip.",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 5,
                'a' => "He doesn't want more coffee.",
                'b' => "He doesn't want to use his credit card.",
                'c' => "He'd like to make coffee.",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 6,
                'a' => "She doesn't think it's warm.",
                'b' => "She'll open the window herself.",
                'c' => "She wants the window closed.",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 7,
                'a' => "The soup is more expensive than sandwiches.",
                'b' => "She doesn't know what kind of soup there is.",
                'c' => "The man might enjoy some soup.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => "The kitchen also needs cleaning.",
                'b' => "The living room doesn't have to be cleaned.",
                'c' => "The man shouldn't do the cleaning.",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 9,
                'a' => "Go with her to the registrar's office.",
                'b' => "Help her find her way to the registrar's office.",
                'c' => "Tell her where to get her own map.",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => "Work on their chemistry homework.",
                'b' => "Have breakfast.",
                'c' => "Stop studying for a little while.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 11,
                'a' => "Buy a new toaster.",
                'b' => "Replace her old shoes.",
                'c' => "Have repairs done.",
                'd' => "",
                'ans' => 'A'
            ],
            [
                'q' => 12,
                'a' => "He'd like her to go away.",
                'b' => "She can read his magazine.",
                'c' => "He hasn't finished reading.",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => "Get an antique desk.",
                'b' => "Buy a new computer.",
                'c' => "Sit down and get to work.",
                'd' => "",
                'ans' => 'B'
            ],
            [
                'q' => 14,
                'a' => "He's already passed the test.",
                'b' => "He doesn't like to study at the library.",
                'c' => "He doesn't plan to study tonight.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 15,
                'a' => "He hasn't seen the letters.",
                'b' => "He doesn't know the right answers.",
                'c' => "He doesn't want to respond to the letters.",
                'd' => "",
                'ans' => 'C'
            ],
            [
                'q' => 16,
                'a' => "She wants to go even though it's raining.",
                'b' => "She can't come to lunch today.",
                'c' => "She'll pay for their lunch.",
                'd' => "",
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
                'option_c' => $item['c'],
                'option_d' => $item['d'],
                'correct_answer' => $item['ans'] ?? 'A', // Use provided answer or default to A
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
