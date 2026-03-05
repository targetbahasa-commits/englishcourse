<?php
// Script to fix incorrect line references in Reading Meeting 13

use Illuminate\Support\Facades\DB;

// Passage 1 fixes
DB::table('toefl_reading_questions')->where('question_number', 2)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 5', 'line 6')")
]);

DB::table('toefl_reading_questions')->where('question_number', 3)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 7', 'line 8')")
]);

DB::table('toefl_reading_questions')->where('question_number', 5)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 13', 'line 14')")
]);

DB::table('toefl_reading_questions')->where('question_number', 10)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 22', 'line 25')")
]);

// Passage 3 fixes
DB::table('toefl_reading_questions')->where('question_number', 24)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 7', 'line 6')")
]);

DB::table('toefl_reading_questions')->where('question_number', 26)->update([
    'question_text' => DB::raw("REPLACE(question_text, 'line 13', 'line 12')")
]);

echo "Fixed 6 line number references in Reading Meeting 13\n";
