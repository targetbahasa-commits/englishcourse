<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M12Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 12;
        $numberOfQuestions = 16;
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
                'a' => "Methods of predicting earthquakes.",
                'b' => "Ways to improve the man's presentation.",
                'c' => "The many new uses of computer graphics.",
                'ans' => 'B'
            ],
            [
                'q' => 2,
                'a' => "Statistics.",
                'b' => "Computer science.",
                'c' => "Geology.",
                'ans' => 'C'
            ],
            [
                'q' => 3,
                'a' => "A language teacher and a student.",
                'b' => "A dean and a teacher.",
                'c' => "A teacher and an assistant.",
                'ans' => 'A'
            ],
            [
                'q' => 4,
                'a' => "The language of the deaf.",
                'b' => "Methods of teaching German.",
                'c' => "Communication networks.",
                'ans' => 'A'
            ],
            [
                'q' => 5,
                'a' => "Professor Quinn's approach to teaching.",
                'b' => "The process of getting a student identification card.",
                'c' => "Procedures for checking out reserve material.",
                'ans' => 'C'
            ],
            [
                'q' => 6,
                'a' => "At a university library.",
                'b' => "In a psychology class.",
                'c' => "In a laboratory.",
                'ans' => 'A'
            ],
            [
                'q' => 7,
                'a' => "To ask for a job.",
                'b' => "To get some advice.",
                'c' => "To discuss medical research.",
                'ans' => 'B'
            ],
            [
                'q' => 8,
                'a' => "Academic advisor.",
                'b' => "Physician.",
                'c' => "Administrator.",
                'ans' => 'C'
            ],
            [
                'q' => 9,
                'a' => "Helpful.",
                'b' => "Discouraging.",
                'c' => "Inconsiderate.",
                'ans' => 'A'
            ],
            [
                'q' => 10,
                'a' => "The art of raising dogs.",
                'b' => "A softball game.",
                'c' => "A dogsled race.",
                'ans' => 'C'
            ],
            [
                'q' => 11,
                'a' => "An archaeologist.",
                'b' => "An anthropologist.",
                'c' => "A university student.",
                'ans' => 'C'
            ],
            [
                'q' => 12,
                'a' => "Their plans for the coming school year.",
                'b' => "Tina's volunteer position.",
                'c' => "Tina's trip to Europe.",
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => "A clerk at a bookstore.",
                'b' => "A librarian.",
                'c' => "A publisher's sales officer.",
                'ans' => 'C'
            ],
            [
                'q' => 14,
                'a' => "Before the spring term begins.",
                'b' => "In the middle of the spring term.",
                'c' => "After the spring term ends.",
                'ans' => 'A'
            ],
            [
                'q' => 15,
                'a' => "In Nicholson Hall.",
                'b' => "In the Graduate Admissions Office.",
                'c' => "In the Financial Aid Office.",
                'ans' => 'C'
            ],
            [
                'q' => 16,
                'a' => "Requirements for graduate admission.",
                'b' => "Directions to another office.",
                'c' => "The woman's need for a scholarship.",
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
