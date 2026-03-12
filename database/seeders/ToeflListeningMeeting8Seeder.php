<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting8Seeder extends Seeder
{
    /**
     * Meeting 8 — Listening: Inference & Understanding Implied Meaning
     * Format: 3-option multiple choice dialogs (20 questions per set)
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 8)->delete();

        $setsData = [

            // ── SET 1 (from M8Seeder, with corrected answer keys) ──────────────
            1 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "Ginny is definitely coming to dinner.",          'b' => "Ginny likes fish better than chicken.",       'c' => "Ginny likes chicken.",                             'correct' => 'C'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "She had already moved.",                          'b' => "She hadn't found a new apartment yet.",       'c' => "She'd already made an appointment.",               'correct' => 'B'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "What the man's name is.",                        'b' => "Who told the man to see the dean.",            'c' => "Who the dean is.",                                 'correct' => 'B'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "He wants to take part in the election.",         'b' => "He's not interested in running for office.",  'c' => "He wants to get more facts from the president.",    'correct' => 'B'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "She couldn't type very fast.",                   'b' => "She had already finished the final draft.",   'c' => "She hadn't completed the research.",               'correct' => 'C'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "He doesn't really like horseback riding.",       'b' => "He rides horses whenever possible.",          'c' => "He doesn't talk about riding very much.",          'correct' => 'A'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "When his insurance agent called.",               'b' => "What his insurance agent wanted.",            'c' => "What time he should return the call.",             'correct' => 'B'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "He was working full time.",                      'b' => "He was eating in the cafeteria.",             'c' => "He didn't want a job.",                            'correct' => 'A'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "When they returned.",                            'b' => "How long their hike was.",                   'c' => "Where they hiked.",                                'correct' => 'C'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He thinks the clothes are expensive.",           'b' => "He doesn't think the clothes are very nice.", 'c' => "He thinks the woman is being unreasonable.",       'correct' => 'B'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "Where the meeting will be held.",                'b' => "When the meeting will start.",               'c' => "Where the recreation center will be built.",       'correct' => 'A'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "Joy did not want to study abroad.",              'b' => "The overseas program had been canceled.",     'c' => "Joy would study overseas sooner than next year.",  'correct' => 'C'],
                ['q' => 13, 'text' => 'Question 13', 'a' => "If the party was at Ben's house.",              'b' => "What time the party ended.",                 'c' => "If the man enjoyed the party.",                    'correct' => 'C'],
                ['q' => 14, 'text' => 'Question 14', 'a' => "All of Ted's answers were incorrect.",          'b' => "Most of the problems were done correctly.",  'c' => "Ted doesn't have to solve the problems.",          'correct' => 'B'],
                ['q' => 15, 'text' => 'Question 15', 'a' => "How she got to the grocery store.",             'b' => "Why she went to the grocery store.",         'c' => "How much she paid for groceries.",                 'correct' => 'B'],
                ['q' => 16, 'text' => 'Question 16', 'a' => "Robin's brother didn't help her get a job.",   'b' => "Robin didn't get a job.",                    'c' => "Robin was able to help her brother.",              'correct' => 'C'],
                ['q' => 17, 'text' => 'Question 17', 'a' => "The flashlight had needed batteries.",           'b' => "There had been some other problem with the flashlight.", 'c' => "The woman hadn't changed the batteries.", 'correct' => 'B'],
                ['q' => 18, 'text' => 'Question 18', 'a' => "Professor Brennon surely won't lead the seminar.", 'b' => "Professor Brennon's permission is not required.", 'c' => "The woman doesn't need to take the seminar.", 'correct' => 'B'],
                ['q' => 19, 'text' => 'Question 19', 'a' => "Why Steve is in the Pacific Northwest.",        'b' => "How long Steve has been traveling.",          'c' => "When Steve will return from his trip.",            'correct' => 'C'],
                ['q' => 20, 'text' => 'Question 20', 'a' => "It hadn't been released yet.",                  'b' => "It wouldn't be very good.",                  'c' => "It can no longer be considered new.",              'correct' => 'C'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "She was surprised by his behavior.",             'b' => "She expected him to act that way.",           'c' => "She thinks he is usually well-mannered.",          'correct' => 'B'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "He'd prefer to postpone the meeting.",          'b' => "He is available to meet today.",              'c' => "He has already cancelled the meeting.",           'correct' => 'B'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "The plane arrived late.",                        'b' => "She almost missed her flight.",               'c' => "She didn't have to rush to the airport.",         'correct' => 'C'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "She prefers taking the bus.",                    'b' => "She can't afford a car.",                    'c' => "Her car is being repaired.",                      'correct' => 'C'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "The course is too easy for him.",               'b' => "He should drop the course.",                 'c' => "He finds the course challenging.",                 'correct' => 'C'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "She wants a different roommate.",               'b' => "She gets along well with her roommate.",     'c' => "She's looking for an apartment.",                  'correct' => 'B'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "He spent more than he planned.",               'b' => "His vacation was not expensive.",             'c' => "He stayed within his budget.",                    'correct' => 'A'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "She read the book more than once.",             'b' => "The book is not worth reading.",              'c' => "She hasn't started reading the book.",            'correct' => 'A'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "He disagrees with the professor.",              'b' => "He didn't attend the lecture.",              'c' => "He found the lecture hard to follow.",            'correct' => 'C'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He will apply for the scholarship.",            'b' => "He doesn't meet the requirements.",          'c' => "He hasn't heard about the scholarship.",          'correct' => 'B'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "She was late to the appointment.",              'b' => "She went to the wrong location.",            'c' => "She cancelled the appointment in advance.",       'correct' => 'B'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "The project is behind schedule.",               'b' => "They finished ahead of time.",               'c' => "The deadline has been extended.",                  'correct' => 'A'],
                ['q' => 13, 'text' => 'Question 13', 'a' => "She's very good at math.",                     'b' => "Math is her weakest subject.",               'c' => "She doesn't need to study math.",                  'correct' => 'B'],
                ['q' => 14, 'text' => 'Question 14', 'a' => "He doesn't like the new policy.",              'b' => "He fully supports the new policy.",          'c' => "He hasn't read the new policy.",                   'correct' => 'A'],
                ['q' => 15, 'text' => 'Question 15', 'a' => "The restaurant is always crowded.",             'b' => "He recommends going somewhere else.",        'c' => "The restaurant has just opened.",                   'correct' => 'B'],
                ['q' => 16, 'text' => 'Question 16', 'a' => "She's planning to move soon.",                 'b' => "She enjoys living in the city.",             'c' => "She has lived there for a long time.",             'correct' => 'C'],
                ['q' => 17, 'text' => 'Question 17', 'a' => "He's satisfied with his grade.",               'b' => "He expected a higher score.",                'c' => "He didn't take the test.",                         'correct' => 'B'],
                ['q' => 18, 'text' => 'Question 18', 'a' => "The weather is perfect for hiking.",            'b' => "She'd rather stay indoors.",                'c' => "The forecast is uncertain.",                       'correct' => 'B'],
                ['q' => 19, 'text' => 'Question 19', 'a' => "She finished the assignment early.",            'b' => "She needs more time to complete the work.",  'c' => "She doesn't understand the instructions.",        'correct' => 'B'],
                ['q' => 20, 'text' => 'Question 20', 'a' => "He found a good solution.",                    'b' => "He gave up trying to fix the problem.",      'c' => "He needs more help.",                              'correct' => 'A'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'text' => 'Question 1',  'a' => "He already owns a bicycle.",                    'b' => "He'd like to buy a bicycle.",               'c' => "He doesn't know how to ride a bicycle.",          'correct' => 'A'],
                ['q' => 2,  'text' => 'Question 2',  'a' => "The store was closed.",                         'b' => "She forgot to buy what she needed.",         'c' => "She bought the wrong item.",                       'correct' => 'B'],
                ['q' => 3,  'text' => 'Question 3',  'a' => "The lecture will start early.",                 'b' => "He's responsible for setting up the room.",  'c' => "He doesn't know when the lecture starts.",        'correct' => 'B'],
                ['q' => 4,  'text' => 'Question 4',  'a' => "The exam had too many questions.",             'b' => "She thought the exam was manageable.",       'c' => "She failed her exam.",                             'correct' => 'B'],
                ['q' => 5,  'text' => 'Question 5',  'a' => "He's not ready to present yet.",               'b' => "His presentation was well-received.",        'c' => "He rehearsed the presentation many times.",        'correct' => 'B'],
                ['q' => 6,  'text' => 'Question 6',  'a' => "She is unhappy with her current job.",         'b' => "She plans to change careers soon.",          'c' => "She's satisfied with her job.",                    'correct' => 'C'],
                ['q' => 7,  'text' => 'Question 7',  'a' => "The train was early.",                         'b' => "He missed the train.",                       'c' => "The train service was delayed.",                   'correct' => 'C'],
                ['q' => 8,  'text' => 'Question 8',  'a' => "She prefers tea to coffee.",                   'b' => "She drinks coffee every morning.",           'c' => "She doesn't drink either tea or coffee.",         'correct' => 'A'],
                ['q' => 9,  'text' => 'Question 9',  'a' => "The book was out of stock.",                   'b' => "She chose a different book.",               'c' => "She already has the book.",                        'correct' => 'C'],
                ['q' => 10, 'text' => 'Question 10', 'a' => "He's not confident about the interview.",      'b' => "He feels ready for the interview.",         'c' => "He cancelled the interview.",                      'correct' => 'B'],
                ['q' => 11, 'text' => 'Question 11', 'a' => "The class was too long.",                      'b' => "She found the class informative.",          'c' => "She slept through the class.",                     'correct' => 'B'],
                ['q' => 12, 'text' => 'Question 12', 'a' => "He's going to leave early.",                   'b' => "He'll stay until the event is over.",       'c' => "He wasn't planning to attend.",                    'correct' => 'B'],
                ['q' => 13, 'text' => 'Question 13', 'a' => "She can't find her keys.",                     'b' => "She locked herself out.",                   'c' => "She has a spare key.",                             'correct' => 'C'],
                ['q' => 14, 'text' => 'Question 14', 'a' => "The restaurant closed early.",                 'b' => "They arrived just in time.",                'c' => "They had to wait for a table.",                    'correct' => 'B'],
                ['q' => 15, 'text' => 'Question 15', 'a' => "He thinks the plan is risky.",                 'b' => "He's enthusiastic about the plan.",         'c' => "He needs more details before deciding.",           'correct' => 'C'],
                ['q' => 16, 'text' => 'Question 16', 'a' => "She's never traveled abroad.",                 'b' => "She prefers domestic travel.",              'c' => "She has been to many countries.",                  'correct' => 'C'],
                ['q' => 17, 'text' => 'Question 17', 'a' => "He finds cooking difficult.",                  'b' => "He cooks every night.",                     'c' => "He prefers eating out.",                           'correct' => 'A'],
                ['q' => 18, 'text' => 'Question 18', 'a' => "She submitted the report late.",               'b' => "She finished the report on time.",          'c' => "She didn't complete the report.",                  'correct' => 'B'],
                ['q' => 19, 'text' => 'Question 19', 'a' => "He's not familiar with the software.",         'b' => "He learned the software quickly.",          'c' => "He taught the software to others.",                'correct' => 'B'],
                ['q' => 20, 'text' => 'Question 20', 'a' => "She's worried about the test result.",         'b' => "She's confident she passed.",               'c' => "She doesn't care about the result.",               'correct' => 'B'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 8,
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
            $this->command->info("Meeting 8 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
