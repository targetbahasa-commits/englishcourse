<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting16Seeder extends Seeder
{
    /**
     * Meeting 16 — Listening: Mini-Talks (Part C) — Longer Talks about various topics
     * Coordinator seeder: calls M16S1 & M16S2 for Sets 1-2, seeds proper Set 3 directly.
     */
    public function run(): void
    {
        // Run existing seeders for Sets 1 and 2
        $this->call([
            M16S1Seeder::class,
            M16S2Seeder::class,
        ]);

        // ── SET 3: New mini-talk questions with correct answer keys ────────────
        ToeflListeningQuestion::where('meeting_number', 16)
            ->where('set_number', 3)
            ->delete();

        $set3 = [
            // Mini-talk A: About a city's public transportation history
            ['q' => 1,  'a' => "A subway system.",                                   'b' => "A bus network.",                                    'c' => "A tram system.",                                'correct' => 'C'],
            ['q' => 2,  'a' => "To reduce traffic.",                                  'b' => "To connect suburban neighborhoods.",                'c' => "To serve the growing tourist industry.",         'correct' => 'B'],
            ['q' => 3,  'a' => "They were powered by horses.",                        'b' => "They ran on electricity.",                         'c' => "They used steam engines.",                      'correct' => 'A'],
            ['q' => 4,  'a' => "In the 1880s.",                                       'b' => "In the 1920s.",                                    'c' => "In the 1950s.",                                 'correct' => 'B'],
            ['q' => 5,  'a' => "The rise of automobile ownership.",                   'b' => "A major fire that destroyed the infrastructure.",  'c' => "A flood that damaged the rail lines.",          'correct' => 'A'],
            ['q' => 6,  'a' => "It was demolished.",                                  'b' => "It was converted to a museum.",                   'c' => "It is still in use today.",                     'correct' => 'C'],

            // Mini-talk B: University research on memory
            ['q' => 7,  'a' => "Sleep has no effect on memory.",                     'b' => "Memory improves significantly during sleep.",      'c' => "Caffeine enhances memory retention.",           'correct' => 'B'],
            ['q' => 8,  'a' => "College students.",                                   'b' => "Elderly patients.",                               'c' => "Professional athletes.",                        'correct' => 'A'],
            ['q' => 9,  'a' => "Six hours.",                                          'b' => "Seven to eight hours.",                          'c' => "Nine hours.",                                   'correct' => 'B'],
            ['q' => 10, 'a' => "They were asked to memorize word lists.",            'b' => "They were given a physical fitness test.",        'c' => "They completed a mathematical exam.",          'correct' => 'A'],
            ['q' => 11, 'a' => "It was conducted at a sleep clinic.",                'b' => "It compared participants from different countries.", 'c' => "It spanned more than ten years.",             'correct' => 'C'],
            ['q' => 12, 'a' => "Recommend healthy sleep habits to students.",        'b' => "Develop a new sleep medication.",                  'c' => "Continue research on other cognitive functions.", 'correct' => 'A'],
        ];

        foreach ($set3 as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 16,
                'set_number'     => 3,
                'question_number'=> $q['q'],
                'question_text'  => 'Question ' . $q['q'],
                'option_a'       => $q['a'],
                'option_b'       => $q['b'],
                'option_c'       => $q['c'],
                'option_d'       => '',
                'correct_answer' => $q['correct'],
                'audio_file'     => null,
                'transcript_en'  => null,
                'transcript_id'  => null,
            ]);
        }

        $this->command->info('Meeting 16 Set 3 seeded with ' . count($set3) . ' questions.');
    }
}
