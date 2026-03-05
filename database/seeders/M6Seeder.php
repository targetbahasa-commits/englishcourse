<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M6Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 6;
        $setNumber = 1;

        // Clear existing questions for this set only
        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        $questionsData = [
            ['q' => 1, 'ans' => 'A'],
            ['q' => 2, 'ans' => 'A'],
            ['q' => 3, 'ans' => 'B'],
            ['q' => 4, 'ans' => 'A'],
            ['q' => 5, 'ans' => 'B'],
            ['q' => 6, 'ans' => 'B'],
            ['q' => 7, 'ans' => 'A'],
            ['q' => 8, 'ans' => 'B'],
            ['q' => 9, 'ans' => 'A'],
            ['q' => 10, 'ans' => 'B'],
            ['q' => 11, 'ans' => 'A'],
            ['q' => 12, 'ans' => 'A'],
        ];

        $questions = [];
        foreach ($questionsData as $data) {
            $questions[] = [
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $data['q'],
                'question_text' => "Question " . $data['q'],
                'audio_file' => null,
                'option_a' => 'Agree',
                'option_b' => 'Disagree',
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => $data['ans'],
                'transcript_en' => null,
                'transcript_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ToeflListeningQuestion::insert($questions);
        
        $this->command->info("Meeting $meetingNumber Set 1 seeded with 12 questions.");
    }
}
