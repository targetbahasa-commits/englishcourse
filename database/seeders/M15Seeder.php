<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M15Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 15;
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
                'a' => "A teacher.",
                'b' => "A tour guide.",
                'c' => "A photographer.",
                'ans' => 'B'
            ],
            [
                'q' => 2,
                'a' => "A description of the wildlife preserve.",
                'b' => "Advice about outdoor photography.",
                'c' => "The scientific classification of buffaloes.",
                'ans' => 'A'
            ],
            [
                'q' => 3,
                'a' => "To explain the traditions of handball.",
                'b' => "To give information about the rules of tennis.",
                'c' => "To discuss the rules of handball.",
                'ans' => 'C'
            ],
            [
                'q' => 4,
                'a' => "At the end of a tournament.",
                'b' => "Before an exhibition game.",
                'c' => "During a game.",
                'ans' => 'B'
            ],
            [
                'q' => 5,
                'a' => "Factory workers.",
                'b' => "Visitors to a factory.",
                'c' => "Management trainees.",
                'ans' => 'B'
            ],
            [
                'q' => 6,
                'a' => "The process of canning soft drinks.",
                'b' => "Management-labor teamwork.",
                'c' => "The life cycle of plants.",
                'ans' => 'A'
            ],
            [
                'q' => 7,
                'a' => "The physical rewards of dancing.",
                'b' => "The importance of the program to the university.",
                'c' => "The disadvantages of being in the program.",
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => "Director of a dance program.",
                'b' => "Professor of psychology.",
                'c' => "Athletics coach.",
                'ans' => 'A'
            ],
            [
                'q' => 9,
                'a' => "A host at a party.",
                'b' => "The president of a society.",
                'c' => "The captain of a ship.",
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => "The role of the State Historical Society.",
                'b' => "The history of New England.",
                'c' => "The story of some shipwrecks.",
                'ans' => 'C'
            ],
            [
                'q' => 11,
                'a' => "Composition.",
                'b' => "Fine arts.",
                'c' => "Architecture.",
                'ans' => 'A'
            ],
            [
                'q' => 12,
                'a' => "The use of blueprints.",
                'b' => "Methods of organization.",
                'c' => "Editing papers.",
                'ans' => 'C'
            ],
            [
                'q' => 13,
                'a' => "Experienced skiers.",
                'b' => "Ski instructors.",
                'c' => "Beginning skiers.",
                'ans' => 'C'
            ],
            [
                'q' => 14,
                'a' => "The fundamentals of skiing.",
                'b' => "Championship skiers.",
                'c' => "The development of ski resorts.",
                'ans' => 'A'
            ],
            [
                'q' => 15,
                'a' => "Law.",
                'b' => "Economics.",
                'c' => "Classical languages.",
                'ans' => 'B'
            ],
            [
                'q' => 16,
                'a' => "A few weeks after the beginning of class.",
                'b' => "In the first class meeting.",
                'c' => "During the final exam.",
                'ans' => 'B'
            ],
            [
                'q' => 17,
                'a' => "On a boat.",
                'b' => "At an aquarium.",
                'c' => "On a plane.",
                'ans' => 'A'
            ],
            [
                'q' => 18,
                'a' => "The habits of whales.",
                'b' => "Types of whales.",
                'c' => "Efforts to protect whales.",
                'ans' => 'A'
            ],
            [
                'q' => 19,
                'a' => "Students who own bicycles.",
                'b' => "New members of the campus police force.",
                'c' => "Pedestrians concerned about safety.",
                'ans' => 'A'
            ],
            [
                'q' => 20,
                'a' => "To describe some recent accidents.",
                'b' => "To introduce a new program.",
                'c' => "To provide safety and security hints.",
                'ans' => 'C'
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
