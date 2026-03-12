<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting5Seeder extends Seeder
{
    /**
     * Meeting 5 — Listening: Agreement & Disagreement Dialogs
     * Focus: Identifying what the man/woman means in short dialogs (3-option questions)
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 5)->delete();

        $setsData = [

            // ── SET 1 ──────────────────────────────────────────────────────────
            1 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "He prefers taking a final exam.",                         'b' => "He thinks an exam takes too much time.",          'c' => "He'd rather write a research paper.",              'correct' => 'C'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "It was difficult, but she understood it.",                 'b' => "It wasn't very useful.",                          'c' => "It's probably easier than the other chapters.",    'correct' => 'A'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "He completely disagrees with it.",                         'b' => "He doesn't believe the university will accept it.", 'c' => "He thinks it's a good one.",                      'correct' => 'C'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "She doesn't think that Jack wrote it.",                    'b' => "She thinks it had too many details.",              'c' => "She found it well-written.",                       'correct' => 'C'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "He thinks it's a good day for bike riding, too.",         'b' => "He doesn't agree with the woman's opinion of the weather.", 'c' => "He didn't hear what the woman said.",    'correct' => 'A'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "Arthur wasn't doing well in the class.",                  'b' => "She's not sure why Arthur dropped the class.",    'c' => "She believes Arthur dropped the class for no reason.", 'correct' => 'B'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "It might work.",                                           'b' => "It's very impractical.",                          'c' => "It's unnecessary.",                               'correct' => 'A'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "He didn't understand it.",                                 'b' => "It made him angry.",                              'c' => "He agreed with it.",                               'correct' => 'C'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "She's never been there during final exam week.",          'b' => "It's crowded because students will be taking exams soon.", 'c' => "It's not crowded now, but it soon will be.", 'correct' => 'B'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He likes the costumes Madelyn made.",                     'b' => "He wouldn't recommend the play.",                 'c' => "He doesn't think the costumes are attractive.",    'correct' => 'A'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "It was very happy.",                                       'b' => "It was exciting.",                                'c' => "It was unhappy.",                                  'correct' => 'B'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "She thinks Pamela is right.",                             'b' => "She thinks the regulations are fair.",             'c' => "She disagrees with the man's opinion.",            'correct' => 'C'],
            ],

            // ── SET 2 (from M5S2Seeder) ────────────────────────────────────────
            2 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "He prefers taking a final exam.",                         'b' => "He thinks an exam takes too much time.",           'c' => "He'd rather write a research paper.",             'correct' => 'A'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "It was difficult, but she understood it.",                 'b' => "It wasn't very useful.",                          'c' => "It's probably easier than the other chapters.",   'correct' => 'A'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "He completely disagrees with it.",                         'b' => "He doesn't believe the university will accept it.", 'c' => "He thinks it's a good one.",                     'correct' => 'C'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "She doesn't think that Jack wrote it.",                    'b' => "She thinks it had too many details.",              'c' => "She found it well-written.",                      'correct' => 'C'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "He thinks it's a good day for bike riding, too.",         'b' => "He doesn't agree with the woman's opinion of the weather.", 'c' => "He didn't hear what the woman said.",   'correct' => 'A'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "Arthur wasn't doing well in the class.",                  'b' => "She's not sure why Arthur dropped the class.",    'c' => "She believes Arthur dropped the class for no reason.", 'correct' => 'B'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "It might work.",                                           'b' => "It's very impractical.",                          'c' => "It's unnecessary.",                              'correct' => 'A'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "He didn't understand it.",                                 'b' => "It made him angry.",                              'c' => "He agreed with it.",                              'correct' => 'C'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "She's never been there during final exam week.",          'b' => "It's crowded because students will be taking exams soon.", 'c' => "It's not crowded now, but it soon will be.", 'correct' => 'B'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He likes the costumes Madelyn made.",                     'b' => "He wouldn't recommend the play.",                 'c' => "He doesn't think the costumes are attractive.",   'correct' => 'A'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "It was very happy.",                                       'b' => "It was exciting.",                                'c' => "It was unhappy.",                                 'correct' => 'B'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "She thinks Pamela is right.",                             'b' => "She thinks the regulations are fair.",             'c' => "She disagrees with the man's opinion.",           'correct' => 'C'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "The woman should stop studying late at night.",           'b' => "The woman usually doesn't have trouble sleeping.",  'c' => "The woman should try to relax more.",            'correct' => 'C'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "He doesn't think the man has a good idea.",               'b' => "He agrees that taking a break would help.",        'c' => "He thinks working harder is the only way.",       'correct' => 'B'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "She agrees that the lecture was boring.",                  'b' => "She doesn't agree with the man's assessment.",    'c' => "She wants to skip tomorrow's lecture.",           'correct' => 'B'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "He thinks the woman should join the club.",               'b' => "He doubts the woman would enjoy it.",              'c' => "He has already signed up for the club.",          'correct' => 'A'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "She'd rather not go to the library today.",               'b' => "She agrees it's the best place to study.",        'c' => "She prefers studying at home.",                   'correct' => 'B'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "He's changed his opinion about the new professor.",       'b' => "He still thinks the professor is strict.",        'c' => "He agrees with the woman's positive view.",       'correct' => 'C'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "She thinks canceling the trip is the right decision.",    'b' => "She disagrees with canceling the trip.",          'c' => "She's indifferent about the trip.",               'correct' => 'A'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "He thinks the assignment is too hard.",                   'b' => "He agrees the assignment is straightforward.",    'c' => "He hasn't started the assignment yet.",           'correct' => 'B'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "She suggests the man wait until tomorrow.",               'b' => "She thinks now is the right time to ask.",        'c' => "She offers to ask the dean herself.",             'correct' => 'B'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He's relieved that the test is postponed.",               'b' => "He thinks the postponement is unfair.",           'c' => "He's disappointed by the delay.",                 'correct' => 'A'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "She's happy to hear about the scholarship.",              'b' => "She doesn't think it's worth applying for.",      'c' => "She already applied for a different scholarship.", 'correct' => 'A'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "He agrees the documentary was excellent.",                'b' => "He found the documentary to be average.",         'c' => "He hasn't watched the documentary yet.",          'correct' => 'A'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 5,
                    'set_number'     => $setNumber,
                    'question_number'=> $q['q'],
                    'question_text'  => $q['text'],
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
            $this->command->info("Meeting 5 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
