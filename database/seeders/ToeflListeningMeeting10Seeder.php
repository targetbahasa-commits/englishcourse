<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting10Seeder extends Seeder
{
    /**
     * Meeting 10 — Listening: Paraphrase & Restatement (Short Conversations)
     * Format: 2-option (A/B) restatement questions — choose the correct rephrasing
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 10)->delete();

        $setsData = [

            // ── SET 1 (from M10Seeder — real content, correct answers) ─────────
            1 => [
                ['q' => 1,  'a' => "Doug is happy to be Rose's friend.",                    'b' => "Doug and Rose are no longer good friends.",                    'correct' => 'B'],
                ['q' => 2,  'a' => "He can do the job as well as a professional.",          'b' => "He should hire an electrician to do the job.",                 'correct' => 'B'],
                ['q' => 3,  'a' => "This station now plays classical music.",                'b' => "The station doesn't broadcast anything but news.",             'correct' => 'B'],
                ['q' => 4,  'a' => "Changing the oil was easy for her.",                    'b' => "The oil didn't need to be changed.",                           'correct' => 'A'],
                ['q' => 5,  'a' => "He's not accustomed to early classes yet.",             'b' => "His classes are difficult, too.",                              'correct' => 'A'],
                ['q' => 6,  'a' => "She's finally accustomed to roller-skating.",           'b' => "She doesn't go skating as often as she once did.",             'correct' => 'B'],
                ['q' => 7,  'a' => "He's going to clean his tie.",                          'b' => "He's going to take his tie to the laundry.",                   'correct' => 'B'],
                ['q' => 8,  'a' => "He moved the poster.",                                   'b' => "He no longer likes the poster.",                               'correct' => 'A'],
                ['q' => 9,  'a' => "She may not be able to take a vacation in August.",     'b' => "She's not sure when the busiest time will be.",                'correct' => 'A'],
                ['q' => 10, 'a' => "She asked Greg to explain the point.",                  'b' => "She explained the point to Greg.",                             'correct' => 'A'],
                ['q' => 11, 'a' => "He isn't accustomed to his glasses.",                   'b' => "He looks quite different without glasses.",                    'correct' => 'B'],
                ['q' => 12, 'a' => "This type of weather is not new to him.",               'b' => "He once lived in a very different climate.",                   'correct' => 'A'],
                ['q' => 13, 'a' => "She's going to take a picture of the members of her club.", 'b' => "Someone is going to photograph her club.",               'correct' => 'B'],
                ['q' => 14, 'a' => "She's never cooked with it.",                           'b' => "She doesn't feel comfortable using it.",                       'correct' => 'B'],
                ['q' => 15, 'a' => "If the deer will come near them.",                      'b' => "If they can approach the deer.",                               'correct' => 'B'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'a' => "She doesn't enjoy her current position.",               'b' => "Her job keeps her very busy.",                                 'correct' => 'B'],
                ['q' => 2,  'a' => "He rarely uses his bicycle.",                           'b' => "His bicycle needs to be repaired.",                            'correct' => 'A'],
                ['q' => 3,  'a' => "The coffee was too strong.",                             'b' => "She would prefer weaker coffee.",                              'correct' => 'B'],
                ['q' => 4,  'a' => "He's going to sign up for the class.",                  'b' => "The class has already started.",                               'correct' => 'A'],
                ['q' => 5,  'a' => "She missed the doctor's appointment.",                  'b' => "She rescheduled the appointment.",                             'correct' => 'B'],
                ['q' => 6,  'a' => "He finished the project before the deadline.",          'b' => "He submitted the project late.",                               'correct' => 'A'],
                ['q' => 7,  'a' => "The library closes earlier than she expected.",         'b' => "She couldn't find the book she needed.",                       'correct' => 'A'],
                ['q' => 8,  'a' => "He agreed to lend her the money.",                      'b' => "He refused to give her a loan.",                               'correct' => 'B'],
                ['q' => 9,  'a' => "She hasn't started her research yet.",                  'b' => "She has been working on her research for a while.",            'correct' => 'B'],
                ['q' => 10, 'a' => "He's planning to move to a new city.",                  'b' => "He has already moved into his new apartment.",                 'correct' => 'B'],
                ['q' => 11, 'a' => "She doesn't remember where she put her keys.",          'b' => "She locked her keys inside the car.",                          'correct' => 'A'],
                ['q' => 12, 'a' => "The party ended sooner than expected.",                  'b' => "Fewer people came to the party than planned.",                 'correct' => 'A'],
                ['q' => 13, 'a' => "He decided not to apply for the award.",                'b' => "He applied but didn't win the award.",                         'correct' => 'B'],
                ['q' => 14, 'a' => "Her sister helped her study for the test.",             'b' => "She studied alone and passed the test.",                       'correct' => 'A'],
                ['q' => 15, 'a' => "He isn't satisfied with his apartment.",                'b' => "He's been living in his new apartment for a month.",           'correct' => 'A'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => "She is comfortable with the new software.",             'b' => "She finds the new software difficult to use.",                 'correct' => 'B'],
                ['q' => 2,  'a' => "The professor canceled today's class.",                  'b' => "The class started later than scheduled.",                      'correct' => 'A'],
                ['q' => 3,  'a' => "He bought a new suit for the interview.",               'b' => "He borrowed clothes for the interview.",                       'correct' => 'A'],
                ['q' => 4,  'a' => "She's familiar with the neighborhood.",                 'b' => "She got lost trying to find the place.",                       'correct' => 'B'],
                ['q' => 5,  'a' => "He didn't enjoy the film.",                             'b' => "He thought the film was longer than expected.",                'correct' => 'A'],
                ['q' => 6,  'a' => "She's not used to the cold weather.",                   'b' => "She prefers winter to summer.",                                'correct' => 'A'],
                ['q' => 7,  'a' => "The restaurant was fully booked.",                       'b' => "They had to wait a long time for a table.",                    'correct' => 'A'],
                ['q' => 8,  'a' => "He has already started his new diet.",                  'b' => "He decided not to change his eating habits.",                  'correct' => 'B'],
                ['q' => 9,  'a' => "She was pleased with the feedback she received.",       'b' => "The feedback was not very helpful to her.",                    'correct' => 'A'],
                ['q' => 10, 'a' => "He needs to renew his library card.",                   'b' => "He can't find his library card.",                              'correct' => 'B'],
                ['q' => 11, 'a' => "She took a different route to avoid traffic.",          'b' => "She was stuck in traffic for a long time.",                    'correct' => 'B'],
                ['q' => 12, 'a' => "He forgot to return the call.",                         'b' => "He couldn't reach the person he called.",                      'correct' => 'A'],
                ['q' => 13, 'a' => "She's looking forward to the weekend trip.",            'b' => "She's not sure she can go on the trip.",                       'correct' => 'B'],
                ['q' => 14, 'a' => "He accepted the job offer right away.",                 'b' => "He asked for more time to decide.",                            'correct' => 'B'],
                ['q' => 15, 'a' => "They arrived at the station just in time.",             'b' => "They missed their train.",                                     'correct' => 'A'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 10,
                    'set_number'     => $setNumber,
                    'question_number'=> $q['q'],
                    'question_text'  => 'Question ' . $q['q'],
                    'option_a'       => $q['a'],
                    'option_b'       => $q['b'],
                    'option_c'       => '',
                    'option_d'       => '',
                    'correct_answer' => $q['correct'],
                    'audio_file'     => null,
                    'transcript_en'  => null,
                    'transcript_id'  => null,
                ]);
            }
            $this->command->info("Meeting 10 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
