<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting3Seeder extends Seeder
{
    public function run(): void
    {
        // Delete existing questions for Meeting 3
        ToeflListeningQuestion::where('meeting_number', 3)->delete();

        // Data for Set 1 (Exercise 1) - Homophones
        $set1Questions = [
            ['q' => 1, 'a' => 'presence', 'b' => 'presents', 'correct' => 'B'],
            ['q' => 2, 'a' => 'overdue', 'b' => 'overdo', 'correct' => 'B'],
            ['q' => 3, 'a' => 'pain', 'b' => 'pane', 'correct' => 'B'],
            ['q' => 4, 'a' => 'where', 'b' => 'wear', 'correct' => 'A'],
            ['q' => 5, 'a' => 'fined', 'b' => 'find', 'correct' => 'B'],
            ['q' => 6, 'a' => 'right', 'b' => 'write', 'correct' => 'A'],
            ['q' => 7, 'a' => 'board', 'b' => 'bored', 'correct' => 'B'],
            ['q' => 8, 'a' => 'brakes', 'b' => 'breaks', 'correct' => 'B'],
            ['q' => 9, 'a' => 'sail', 'b' => 'sale', 'correct' => 'B'],
            ['q' => 10, 'a' => 'site', 'b' => 'sight', 'correct' => 'A'],
            ['q' => 11, 'a' => 'rose', 'b' => 'rows', 'correct' => 'B'],
            ['q' => 12, 'a' => 'aloud', 'b' => 'allowed', 'correct' => 'B'],
        ];

        foreach ($set1Questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 3,
                'set_number' => 1,
                'question_number' => $q['q'],
                'question_text' => '', // Empty string instead of null for Set 1
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => $q['correct'], 
                'audio_file' => null,
            ]);
        }

        // Data for Set 2 (Exercise 2) - Context/Definitions
        $set2Questions = [
            ['q' => 1, 'text' => 'cold', 'a' => 'minor illness', 'b' => 'chilly weather'],
            ['q' => 2, 'text' => 'kind', 'a' => 'type', 'b' => 'considerate'],
            ['q' => 3, 'text' => 'light', 'a' => 'not heavy', 'b' => 'not dark'],
            ['q' => 4, 'text' => 'wing', 'a' => 'part of an airplane', 'b' => 'part of a building'],
            ['q' => 5, 'text' => 'tables', 'a' => 'charts', 'b' => 'furniture'],
            ['q' => 6, 'text' => 'coat', 'a' => 'layer', 'b' => 'warm clothing'],
            ['q' => 7, 'text' => 'field', 'a' => 'outside the classroom', 'b' => 'area of study'],
            ['q' => 8, 'text' => 'playing', 'a' => 'taking part in a game', 'b' => 'appearing'],
            ['q' => 9, 'text' => 'party', 'a' => 'celebration', 'b' => 'group'],
            ['q' => 10, 'text' => 'period', 'a' => 'punctuation mark', 'b' => 'class time'],
        ];

        foreach ($set2Questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 3,
                'set_number' => 2,
                'question_number' => $q['q'],
                'question_text' => $q['text'],
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => 'N/A',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
                'audio_file' => null,
            ]);
        }

        // Data for Set 3 (Review)
        // Data for Set 3 (Review)
        $set3Questions = [
            ['q' => 1, 'correct' => 'A'],
            ['q' => 2, 'correct' => 'B'],
            ['q' => 3, 'correct' => 'B'],
            ['q' => 4, 'correct' => 'A'],
            ['q' => 5, 'correct' => 'B'],
            ['q' => 6, 'correct' => 'A'],
            ['q' => 7, 'correct' => 'A'],
            ['q' => 8, 'correct' => 'A'],
            ['q' => 9, 'correct' => 'B'],
            ['q' => 10, 'correct' => 'A'],
            ['q' => 11, 'correct' => 'B'],
            ['q' => 12, 'correct' => 'A'],
        ];

        foreach ($set3Questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 3,
                'set_number' => 3,
                'question_number' => $q['q'],
                'question_text' => 'Listen to the audio and answer the question.',
                'option_a' => 'Option A',
                'option_b' => 'Option B',
                'option_c' => 'Option C',
                'option_d' => 'Option D',
                'correct_answer' => $q['correct'],
                'audio_file' => null,
            ]);
        }
    }
}
