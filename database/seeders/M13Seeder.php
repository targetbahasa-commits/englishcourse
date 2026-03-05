<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M13Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 13;
        $numberOfQuestions = 17;
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
                'a' => "A doctor.",
                'b' => "A newspaper.",
                'c' => "A magazine.",
            ],
            [
                'q' => 2,
                'a' => "It's too tiring.",
                'b' => "It can cause injuries.",
                'c' => "It's not demanding enough.",
            ],
            [
                'q' => 3,
                'a' => "Downhill skiing.",
                'b' => "Jogging.",
                'c' => "Cross-country skiing.",
            ],
            [
                'q' => 4,
                'a' => "It doesn't require much snow.",
                'b' => "It is a recently developed sport.",
                'c' => "It can be done in flat areas.",
            ],
            [
                'q' => 5,
                'a' => "Use a cross-country ski machine.",
                'b' => "Travel to ski resorts.",
                'c' => "Take up jogging.",
            ],
            [
                'q' => 6,
                'a' => "The expense.",
                'b' => "The weather conditions.",
                'c' => "The danger.",
            ],
            [
                'q' => 7,
                'a' => "He stayed up most of the night.",
                'b' => "He's been studying all morning.",
                'c' => "He took an exam last night.",
            ],
            [
                'q' => 8,
                'a' => "It was an improvement.",
                'b' => "It was disappointing.",
                'c' => "It was unfair.",
            ],
            [
                'q' => 9,
                'a' => "Undergraduate students.",
                'b' => "Teachers.",
                'c' => "Graduate students.",
            ],
            [
                'q' => 10,
                'a' => "She learned how to do research.",
                'b' => "She was prepared for her sociology test.",
                'c' => "She learned teaching techniques.",
            ],
            [
                'q' => 11,
                'a' => "Basic scientific research.",
                'b' => "Business management.",
                'c' => "Test-taking skills.",
            ],
            [
                'q' => 12,
                'a' => "In the library.",
                'b' => "In the Physics Tower.",
                'c' => "In Staunton Hall.",
            ],
            [
                'q' => 13,
                'a' => "Study for his next exam.",
                'b' => "Go to the Study Skills Center.",
                'c' => "Get some sleep.",
            ],
            [
                'q' => 14,
                'a' => "To buy something at an auction.",
                'b' => "To pay for employees' salaries.",
                'c' => "To improve their broadcasts.",
            ],
            [
                'q' => 15,
                'a' => "Apply for a job at the station.",
                'b' => "Donate his services for the station's auction.",
                'c' => "Direct the construction of a new tower.",
            ],
            [
                'q' => 16,
                'a' => "She must work on her own research project.",
                'b' => "She has to help her parents.",
                'c' => "She must study for exams.",
            ],
            [
                'q' => 17,
                'a' => "They seldom attend auctions.",
                'b' => "They might bid on the man's services.",
                'c' => "They use the library often.",
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
