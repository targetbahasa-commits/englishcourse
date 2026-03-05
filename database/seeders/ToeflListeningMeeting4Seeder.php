<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing questions for Meeting 4
        ToeflListeningQuestion::where('meeting_number', 4)->delete();

        // Data based on User Image (Idioms)
        $questions = [
            [
                'q' => 1,
                'text' => 'get into hot water',
                'a' => 'She was in trouble.',
                'b' => 'She took a warm bath.',
                'correct' => 'A'
            ],
            [
                'q' => 2,
                'text' => 'run into',
                'a' => 'He met Caroline unexpectedly at the coffee shop.',
                'b' => 'Caroline and I jogged to the coffee shop.',
                'correct' => 'A'
            ],
            [
                'q' => 3,
                'text' => 'hit it off',
                'a' => 'He and Chuck argued as soon as they met.',
                'b' => 'He and Chuck quickly became friends.',
                'correct' => 'B'
            ],
            [
                'q' => 4,
                'text' => 'a piece of cake',
                'a' => 'The exam was simple.',
                'b' => 'She had a snack after the test.',
                'correct' => 'A'
            ],
            [
                'q' => 5,
                'text' => 'at the drop of a hat',
                'a' => "He can't leave until he finds his hat.",
                'b' => "He's ready to leave immediately.",
                'correct' => 'B'
            ],
            [
                'q' => 6,
                'text' => 'on edge',
                'a' => "He walks back and forth when he's nervous",
                'b' => 'He likes to walk along the edge',
                'correct' => 'A'
            ],
            [
                'q' => 7,
                'text' => 'under the weather',
                'a' => "She didn't want to practice because of the bad weather.",
                'b' => "She wasn't there because she felt a little sick.",
                'correct' => 'B'
            ],
            [
                'q' => 8,
                'text' => 'take after',
                'a' => 'He looks like his grandfather.',
                'b' => 'He takes care of his grandfather.',
                'correct' => 'A'
            ],
            [
                'q' => 9,
                'text' => 'for good',
                'a' => "He doesn't want the professor to quit teaching permanently.",
                'b' => 'He hopes Professor Holmes has a good reason for quitting.',
                'correct' => 'A'
            ],
            [
                'q' => 10,
                'text' => 'give a hand with',
                'a' => 'Hand her the box.',
                'b' => 'Help her carry the box.',
                'correct' => 'B'
            ],
            [
                'q' => 11,
                'text' => "a stone's throw from",
                'a' => 'He likes to throw rocks in the park.',
                'b' => 'He lives close to the park.',
                'correct' => 'B'
            ],
            [
                'q' => 12,
                'text' => 'not think much of',
                'a' => "She didn't consider it.",
                'b' => "She didn't like it.",
                'correct' => 'B'
            ],
        ];

        foreach ($questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 4,
                'set_number' => 1, // Default to set 1
                'question_number' => $q['q'],
                'question_text' => $q['text'],
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => 'N/A', // Set defaults for 2-option q
                'option_d' => 'N/A',
                'correct_answer' => $q['correct'],
                'audio_file' => null,
            ]);
        }
    }
}
