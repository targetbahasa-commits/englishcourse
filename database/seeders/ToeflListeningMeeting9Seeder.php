<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting9Seeder extends Seeder
{
    /**
     * Meeting 9 — Listening: What Will the Person Probably Do? (Short Conversations)
     * Format: 3-option questions about speakers' future actions/intentions
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 9)->delete();

        $setsData = [

            // ── SET 1 (from M9Seeder — real content with correct answers) ──────
            1 => [
                ['q' => 1,  'a' => "Road conditions.",                                       'b' => "A weather report.",                            'c' => "Motel reservations.",                              'correct' => 'A'],
                ['q' => 2,  'a' => "Go to the concert.",                                     'b' => "Listen to jazz on the radio.",                 'c' => "Buy more tickets.",                                'correct' => 'A'],
                ['q' => 3,  'a' => "The man's car is not running.",                         'b' => "The man isn't going to the party.",            'c' => "The car isn't big enough for four people.",        'correct' => 'C'],
                ['q' => 4,  'a' => "Stay inside.",                                           'b' => "Find his umbrella.",                           'c' => "Look outside.",                                    'correct' => 'A'],
                ['q' => 5,  'a' => "A store.",                                               'b' => "A bridge.",                                   'c' => "A street.",                                        'correct' => 'B'],
                ['q' => 6,  'a' => "Shop for groceries.",                                    'b' => "Leave for a camping trip.",                   'c' => "Go to a circus.",                                  'correct' => 'B'],
                ['q' => 7,  'a' => "Ask for medicine for his headaches.",                    'b' => "Buy some new frames for his eyeglasses.",     'c' => "Get different lenses for his glasses.",            'correct' => 'C'],
                ['q' => 8,  'a' => "Clothing.",                                              'b' => "Hair styling.",                               'c' => "Painting.",                                        'correct' => 'C'],
                ['q' => 9,  'a' => "Take a trip.",                                           'b' => "Watch television.",                           'c' => "Examine some documents.",                          'correct' => 'B'],
                ['q' => 10, 'a' => "He lent it to someone else.",                            'b' => "It was ruined in the rain.",                  'c' => "He forgot where he left it.",                      'correct' => 'B'],
                ['q' => 11, 'a' => "A car.",                                                 'b' => "A magazine.",                                 'c' => "A computer.",                                      'correct' => 'C'],
                ['q' => 12, 'a' => "Go directly to business school.",                        'b' => "Look for a job with a big company.",          'c' => "Start her own business.",                          'correct' => 'B'],
                ['q' => 13, 'a' => "Playing cards.",                                         'b' => "Making dinner.",                              'c' => "Repairing a boat.",                                 'correct' => 'A'],
                ['q' => 14, 'a' => "He doesn't have Phyllis's address.",                    'b' => "He's upset with Phyllis.",                    'c' => "He doesn't have a stamp.",                         'correct' => 'C'],
                ['q' => 15, 'a' => "Order a salad.",                                         'b' => "Go to another restaurant.",                   'c' => "Put some salt in her soup.",                       'correct' => 'A'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'a' => "Call the airline.",                                      'b' => "Check the departure board.",                  'c' => "Wait at the gate.",                                'correct' => 'B'],
                ['q' => 2,  'a' => "Make a reservation at a different hotel.",              'b' => "Arrive earlier than planned.",                 'c' => "Stay at the hotel for another night.",             'correct' => 'A'],
                ['q' => 3,  'a' => "Submit the report tomorrow.",                            'b' => "Ask for an extension.",                       'c' => "Work through the night.",                          'correct' => 'C'],
                ['q' => 4,  'a' => "Return the book to the library.",                       'b' => "Renew the book for another week.",             'c' => "Pay the late fee.",                                'correct' => 'B'],
                ['q' => 5,  'a' => "Take the bus.",                                          'b' => "Call a taxi.",                                'c' => "Walk to the station.",                             'correct' => 'A'],
                ['q' => 6,  'a' => "Skip the meeting.",                                      'b' => "Arrive late.",                                'c' => "Ask someone to take notes.",                       'correct' => 'C'],
                ['q' => 7,  'a' => "Change her major.",                                      'b' => "Drop the advanced class.",                    'c' => "Get a tutor.",                                     'correct' => 'C'],
                ['q' => 8,  'a' => "Buy a new backpack.",                                    'b' => "Have his bag repaired.",                      'c' => "Borrow his roommate's bag.",                       'correct' => 'B'],
                ['q' => 9,  'a' => "Go to the campus gym.",                                 'b' => "Sign up for a fitness class.",                'c' => "Jog around the park.",                             'correct' => 'A'],
                ['q' => 10, 'a' => "Cancel the subscription.",                               'b' => "Upgrade to a premium plan.",                  'c' => "Share the account with a friend.",                 'correct' => 'A'],
                ['q' => 11, 'a' => "Visit the doctor.",                                      'b' => "Rest at home.",                               'c' => "Take some over-the-counter medicine.",             'correct' => 'B'],
                ['q' => 12, 'a' => "Apply for a scholarship.",                              'b' => "Get a part-time job.",                        'c' => "Borrow money from his parents.",                   'correct' => 'B'],
                ['q' => 13, 'a' => "Cook at home.",                                          'b' => "Order delivery.",                             'c' => "Eat at the new restaurant.",                       'correct' => 'C'],
                ['q' => 14, 'a' => "Send an email.",                                         'b' => "Make a phone call.",                          'c' => "Visit the office in person.",                      'correct' => 'C'],
                ['q' => 15, 'a' => "Look for a new apartment.",                             'b' => "Negotiate a lower rent.",                     'c' => "Find a roommate.",                                  'correct' => 'A'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => "Reschedule the dentist appointment.",                   'b' => "Go to the dentist on Friday.",                'c' => "Cancel the appointment.",                          'correct' => 'B'],
                ['q' => 2,  'a' => "Buy a used car.",                                        'b' => "Take public transportation.",                 'c' => "Rent a car for the month.",                        'correct' => 'B'],
                ['q' => 3,  'a' => "Print extra copies of the handout.",                    'b' => "Use the projector instead.",                  'c' => "Cancel the presentation.",                         'correct' => 'A'],
                ['q' => 4,  'a' => "Ask the professor for extra credit.",                   'b' => "Study harder for the next exam.",             'c' => "Withdraw from the class.",                         'correct' => 'B'],
                ['q' => 5,  'a' => "Eat at the cafeteria.",                                  'b' => "Bring lunch from home.",                      'c' => "Skip lunch to save time.",                         'correct' => 'A'],
                ['q' => 6,  'a' => "Switch to a new phone plan.",                           'b' => "Buy an extra charger.",                      'c' => "Get a replacement phone.",                         'correct' => 'A'],
                ['q' => 7,  'a' => "Read the textbook again.",                              'b' => "Join a study group.",                         'c' => "Ask the professor after class.",                   'correct' => 'C'],
                ['q' => 8,  'a' => "Borrow money from a classmate.",                        'b' => "Use a different ATM.",                        'c' => "Pay by credit card.",                              'correct' => 'C'],
                ['q' => 9,  'a' => "Watch the recorded version.",                           'b' => "Attend the lecture in person.",               'c' => "Skip the lecture entirely.",                       'correct' => 'A'],
                ['q' => 10, 'a' => "Find a different lab partner.",                         'b' => "Complete the experiment alone.",              'c' => "Ask the TA for help.",                             'correct' => 'C'],
                ['q' => 11, 'a' => "Register for a weekend workshop.",                      'b' => "Read some books on the topic.",               'c' => "Take an online course.",                           'correct' => 'C'],
                ['q' => 12, 'a' => "Submit the application early.",                         'b' => "Ask for a letter of recommendation.",        'c' => "Postpone applying until next year.",               'correct' => 'B'],
                ['q' => 13, 'a' => "Return the broken TV for a refund.",                   'b' => "Have it repaired at a shop.",                 'c' => "Buy a new one.",                                   'correct' => 'A'],
                ['q' => 14, 'a' => "Call her parents.",                                      'b' => "Drive home for the weekend.",                 'c' => "Stay on campus during the break.",                 'correct' => 'C'],
                ['q' => 15, 'a' => "Sign up for a language exchange program.",              'b' => "Hire a private tutor.",                      'c' => "Practice with an app on her phone.",               'correct' => 'A'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 9,
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
            $this->command->info("Meeting 9 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
