<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddQuestionMarksToMeeting6Seeder extends Seeder
{
    public function run()
    {
        $this->command->info('Adding question marks to Meeting 6 questions...');
        
        // Get Meeting 6
        $meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 6)->first();
        if (!$meeting) {
            $this->command->error('Meeting 6 not found!');
            return;
        }

        // Get all passages for Meeting 6
        $passages = DB::table('toefl_reading_passages')->where('meeting_id', $meeting->id)->get();
        
        foreach ($passages as $passage) {
            // Get all questions for this passage
            $questions = DB::table('toefl_reading_questions')
                ->where('passage_id', $passage->id)
                ->get();
            
            foreach ($questions as $question) {
                // Add question mark if not already present
                $questionText = $question->question_text;
                if (!str_ends_with($questionText, '?')) {
                    DB::table('toefl_reading_questions')
                        ->where('id', $question->id)
                        ->update(['question_text' => $questionText . '?']);
                    
                    $this->command->info("Added ? to Question {$question->question_number}");
                }
            }
        }

        $this->command->info('All question marks added successfully!');
    }
}
