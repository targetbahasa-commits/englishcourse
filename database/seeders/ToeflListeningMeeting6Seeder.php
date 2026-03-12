<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting6Seeder extends Seeder
{
    /**
     * Meeting 6 — Listening: Understanding Meaning in Context (Short Conversations)
     * Format: 3-option multiple choice dialogs
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 6)->delete();

        $setsData = [

            // ── SET 1 ──────────────────────────────────────────────────────────
            1 => [
                ['q' => 1,  'a' => 'He prefers taking a final exam.',                           'b' => 'He thinks an exam takes too much time.',              'c' => "He'd rather write a research paper.",                  'correct' => 'C'],
                ['q' => 2,  'a' => 'It was difficult, but she understood it.',                   'b' => "It wasn't very useful.",                              'c' => "It's probably easier than the other chapters.",         'correct' => 'A'],
                ['q' => 3,  'a' => 'He completely disagrees with it.',                           'b' => "He doesn't believe the university will accept it.",   'c' => "He thinks it's a good one.",                           'correct' => 'C'],
                ['q' => 4,  'a' => "She doesn't think that Jack wrote it.",                      'b' => 'She thinks it had too many details.',                 'c' => 'She found it well-written.',                          'correct' => 'C'],
                ['q' => 5,  'a' => "He thinks it's a good day for bike riding, too.",           'b' => "He doesn't agree with the woman's opinion of the weather.", 'c' => "He didn't hear what the woman said.",          'correct' => 'A'],
                ['q' => 6,  'a' => "Arthur wasn't doing well in the class.",                     'b' => "She's not sure why Arthur dropped the class.",        'c' => 'She believes Arthur dropped the class for no reason.',  'correct' => 'B'],
                ['q' => 7,  'a' => 'It might work.',                                             'b' => "It's very impractical.",                              'c' => "It's unnecessary.",                                    'correct' => 'A'],
                ['q' => 8,  'a' => "He didn't understand it.",                                   'b' => 'It made him angry.',                                  'c' => 'He agreed with it.',                                   'correct' => 'B'],
                ['q' => 9,  'a' => "She's never been there during final exam week.",             'b' => "It's crowded because students will be taking exams soon.", 'c' => "It's not crowded now, but it soon will be.",     'correct' => 'B'],
                ['q' => 10, 'a' => 'He likes the costumes Madelyn made.',                        'b' => "He wouldn't recommend the play.",                     'c' => "He doesn't think the costumes are attractive.",        'correct' => 'A'],
                ['q' => 11, 'a' => 'It was very happy.',                                         'b' => 'It was exciting.',                                    'c' => 'It was unhappy.',                                      'correct' => 'B'],
                ['q' => 12, 'a' => 'She thinks Pamela is right.',                                'b' => 'She thinks the regulations are fair.',                'c' => "She disagrees with the man's opinion.",                'correct' => 'B'],
            ],

            // ── SET 2 (from M6S2Seeder — verified content) ────────────────────
            2 => [
                ['q' => 1,  'a' => 'He prefers taking a final exam.',                           'b' => 'He thinks an exam takes too much time.',              'c' => "He'd rather write a research paper.",                  'correct' => 'A'],
                ['q' => 2,  'a' => 'It was difficult, but she understood it.',                   'b' => "It wasn't very useful.",                              'c' => "It's probably easier than the other chapters.",         'correct' => 'C'],
                ['q' => 3,  'a' => 'He completely disagrees with it.',                           'b' => "He doesn't believe the university will accept it.",   'c' => "He thinks it's a good one.",                           'correct' => 'C'],
                ['q' => 4,  'a' => "She doesn't think that Jack wrote it.",                      'b' => 'She thinks it had too many details.',                 'c' => 'She found it well-written.',                          'correct' => 'C'],
                ['q' => 5,  'a' => "He thinks it's a good day for bike riding, too.",           'b' => "He doesn't agree with the woman's opinion of the weather.", 'c' => "He didn't hear what the woman said.",          'correct' => 'A'],
                ['q' => 6,  'a' => "Arthur wasn't doing well in the class.",                     'b' => "She's not sure why Arthur dropped the class.",        'c' => 'She believes Arthur dropped the class for no reason.',  'correct' => 'B'],
                ['q' => 7,  'a' => 'It might work.',                                             'b' => "It's very impractical.",                              'c' => "It's unnecessary.",                                    'correct' => 'A'],
                ['q' => 8,  'a' => "He didn't understand it.",                                   'b' => 'It made him angry.',                                  'c' => 'He agreed with it.',                                   'correct' => 'B'],
                ['q' => 9,  'a' => "She's never been there during final exam week.",             'b' => "It's crowded because students will be taking exams soon.", 'c' => "It's not crowded now, but it soon will be.",     'correct' => 'B'],
                ['q' => 10, 'a' => 'He likes the costumes Madelyn made.',                        'b' => "He wouldn't recommend the play.",                     'c' => "He doesn't think the costumes are attractive.",        'correct' => 'A'],
                ['q' => 11, 'a' => 'It was very happy.',                                         'b' => 'It was exciting.',                                    'c' => 'It was unhappy.',                                      'correct' => 'C'],
                ['q' => 12, 'a' => 'She thinks Pamela is right.',                                'b' => 'She thinks the regulations are fair.',                'c' => "She disagrees with the man's opinion.",                'correct' => 'B'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => 'The seminar was canceled.',                                  'b' => 'She plans to attend the seminar.',                    'c' => 'She already attended the seminar.',                    'correct' => 'B'],
                ['q' => 2,  'a' => "He doesn't understand the assignment.",                      'b' => "He's willing to help with the assignment.",           'c' => "He has already finished the assignment.",              'correct' => 'B'],
                ['q' => 3,  'a' => 'She was surprised by the test results.',                     'b' => 'She expected to fail the test.',                      'c' => 'She thinks the test was unfair.',                      'correct' => 'A'],
                ['q' => 4,  'a' => 'He totally agrees with the plan.',                           'b' => 'He is uncertain about the plan.',                     'c' => "He doesn't think the plan will work.",                 'correct' => 'C'],
                ['q' => 5,  'a' => 'They should postpone the meeting.',                          'b' => 'The meeting was already held.',                       'c' => 'She wants to reschedule the meeting.',                 'correct' => 'A'],
                ['q' => 6,  'a' => 'The professor gave an interesting lecture.',                 'b' => "The lecture wasn't very informative.",                'c' => 'He missed the lecture.',                               'correct' => 'A'],
                ['q' => 7,  'a' => 'She got the scholarship she applied for.',                   'b' => "She didn't get the scholarship.",                     'c' => 'She decided not to apply for the scholarship.',        'correct' => 'A'],
                ['q' => 8,  'a' => 'He thinks the new dorm rules are reasonable.',              'b' => 'He disagrees with the new dorm rules.',               'c' => 'He was unaware of the new rules.',                     'correct' => 'B'],
                ['q' => 9,  'a' => 'She prefers studying alone.',                                'b' => 'She thinks studying with a group is more effective.',  'c' => "She doesn't have time to study.",                      'correct' => 'B'],
                ['q' => 10, 'a' => 'He found the physics textbook helpful.',                     'b' => 'The textbook is too expensive.',                      'c' => 'He returned the textbook to the library.',             'correct' => 'A'],
                ['q' => 11, 'a' => 'She enjoyed the campus tour.',                               'b' => 'She thinks the campus is too large.',                 'c' => 'She got lost during the tour.',                        'correct' => 'A'],
                ['q' => 12, 'a' => 'The cafeteria has changed its menu.',                        'b' => 'He prefers eating off campus.',                       'c' => "The cafeteria's food quality has improved.",           'correct' => 'C'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 6,
                    'set_number'     => $setNumber,
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
            $this->command->info("Meeting 6 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
