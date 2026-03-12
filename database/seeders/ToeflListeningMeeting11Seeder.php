<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting11Seeder extends Seeder
{
    /**
     * Meeting 11 — Listening: Agreement & Disagreement (Short Conversations)
     * Format: 3-option questions — what does the speaker mean/imply?
     * Focus: understanding agreement, disagreement, surprise, and implied meaning
     */
    public function run(): void
    {
        ToeflListeningQuestion::where('meeting_number', 11)->delete();

        $setsData = [

            // ── SET 1 ──────────────────────────────────────────────────────────
            1 => [
                ['q' => 1,  'a' => "She agrees that the test was hard.",                    'b' => "She thinks the test was easy.",                   'c' => "She didn't take the test.",                   'correct' => 'A'],
                ['q' => 2,  'a' => "He wishes he could have attended the lecture.",        'b' => "He didn't find the lecture interesting.",        'c' => "He agrees the lecture was boring.",           'correct' => 'A'],
                ['q' => 3,  'a' => "She thinks the proposal is a good one.",               'b' => "She disagrees with the proposal.",               'c' => "She hasn't read the proposal yet.",           'correct' => 'B'],
                ['q' => 4,  'a' => "He finds the assignment challenging.",                  'b' => "He already submitted the assignment.",           'c' => "He agrees the assignment was simple.",        'correct' => 'A'],
                ['q' => 5,  'a' => "She's surprised the event was cancelled.",             'b' => "She expected the event to be cancelled.",       'c' => "She cancelled the event herself.",            'correct' => 'A'],
                ['q' => 6,  'a' => "He thinks the new schedule works fine.",               'b' => "He disagrees with the schedule changes.",       'c' => "He made the new schedule.",                   'correct' => 'B'],
                ['q' => 7,  'a' => "She agrees the movie was excellent.",                  'b' => "She didn't enjoy the movie.",                   'c' => "She hasn't seen the movie.",                  'correct' => 'A'],
                ['q' => 8,  'a' => "He was surprised the team lost.",                      'b' => "He expected the team to lose.",                 'c' => "He didn't watch the game.",                   'correct' => 'B'],
                ['q' => 9,  'a' => "She thinks the price is too high.",                    'b' => "She agrees the price is fair.",                 'c' => "She didn't see the price.",                   'correct' => 'A'],
                ['q' => 10, 'a' => "He strongly supports the decision.",                    'b' => "He disagrees with the decision.",               'c' => "He wasn't informed about the decision.",      'correct' => 'B'],
                ['q' => 11, 'a' => "She agrees the food was delicious.",                   'b' => "She was disappointed with the meal.",           'c' => "She didn't eat at the restaurant.",           'correct' => 'B'],
                ['q' => 12, 'a' => "He thinks the presentation went well.",                'b' => "He was nervous about the presentation.",        'c' => "He disagrees the presentation was good.",     'correct' => 'A'],
            ],

            // ── SET 2 ──────────────────────────────────────────────────────────
            2 => [
                ['q' => 1,  'a' => "She's happy with her new apartment.",                  'b' => "She's not satisfied with the apartment.",      'c' => "She's looking for a new place to live.",     'correct' => 'B'],
                ['q' => 2,  'a' => "He thinks jogging every day is too much.",             'b' => "He agrees jogging is healthy.",                'c' => "He jogs every day himself.",                  'correct' => 'A'],
                ['q' => 3,  'a' => "She agrees the book was too long.",                    'b' => "She found the book enjoyable despite its length.", 'c' => "She hasn't finished the book.",           'correct' => 'B'],
                ['q' => 4,  'a' => "He thinks the meeting could have been an email.",     'b' => "He found the meeting very productive.",        'c' => "He missed the meeting.",                      'correct' => 'A'],
                ['q' => 5,  'a' => "She disagrees the project will be finished on time.", 'b' => "She's confident the project will be done.",    'c' => "She's not involved in the project.",         'correct' => 'A'],
                ['q' => 6,  'a' => "He's surprised the professor extended the deadline.", 'b' => "He expected an extension.",                    'c' => "He asked for a deadline extension.",           'correct' => 'A'],
                ['q' => 7,  'a' => "She agrees the concert was disappointing.",           'b' => "She enjoyed the concert very much.",           'c' => "She didn't attend the concert.",              'correct' => 'A'],
                ['q' => 8,  'a' => "He thinks the new rule is unfair.",                    'b' => "He supports the new rule.",                    'c' => "He wasn't aware of the new rule.",            'correct' => 'A'],
                ['q' => 9,  'a' => "She's surprised the shop closed so early.",           'b' => "She knew the shop would be closing.",          'c' => "She works at the shop.",                      'correct' => 'A'],
                ['q' => 10, 'a' => "He agrees the weather has been unusual.",              'b' => "He thinks the weather is normal.",             'c' => "He doesn't follow the weather forecast.",    'correct' => 'A'],
                ['q' => 11, 'a' => "She's glad the semester is almost over.",              'b' => "She wishes the semester were longer.",         'c' => "She's worried about the upcoming exams.",    'correct' => 'A'],
                ['q' => 12, 'a' => "He disagrees the course is too difficult.",            'b' => "He shares her view that the course is hard.", 'c' => "He dropped the course.",                      'correct' => 'B'],
            ],

            // ── SET 3 ──────────────────────────────────────────────────────────
            3 => [
                ['q' => 1,  'a' => "She thinks Mark is too strict.",                       'b' => "She agrees Mark is a fair supervisor.",        'c' => "She hasn't worked with Mark.",                'correct' => 'A'],
                ['q' => 2,  'a' => "He's surprised the library is closed on holidays.",   'b' => "He knew the library would be closed.",         'c' => "He works at the library.",                    'correct' => 'A'],
                ['q' => 3,  'a' => "She disagrees the seminar was informative.",          'b' => "She found the seminar helpful.",               'c' => "She missed the seminar.",                     'correct' => 'B'],
                ['q' => 4,  'a' => "He agrees they should cancel the trip.",              'b' => "He wants to go on the trip regardless.",      'c' => "He organized the trip.",                      'correct' => 'A'],
                ['q' => 5,  'a' => "She thinks the cafeteria food has gotten worse.",     'b' => "She agrees the food quality is fine.",        'c' => "She doesn't eat at the cafeteria.",          'correct' => 'A'],
                ['q' => 6,  'a' => "He's surprised she got a promotion so quickly.",      'b' => "He expected her to be promoted soon.",        'c' => "He recommended her for the promotion.",      'correct' => 'A'],
                ['q' => 7,  'a' => "She supports the new campus policy.",                 'b' => "She disagrees with the new policy.",          'c' => "She wasn't told about the policy.",          'correct' => 'B'],
                ['q' => 8,  'a' => "He thinks the internship was a great experience.",   'b' => "He found the internship disappointing.",      'c' => "He didn't complete the internship.",         'correct' => 'A'],
                ['q' => 9,  'a' => "She's surprised the store is out of stock.",          'b' => "She thinks other stores will have it.",       'c' => "She ordered from a different store.",        'correct' => 'B'],
                ['q' => 10, 'a' => "He agrees the traffic has been terrible lately.",     'b' => "He thinks the traffic isn't that bad.",       'c' => "He takes a different route.",                'correct' => 'A'],
                ['q' => 11, 'a' => "She wishes she had chosen a different major.",        'b' => "She's happy with her academic program.",      'c' => "She's thinking of changing her major.",      'correct' => 'B'],
                ['q' => 12, 'a' => "He disagrees they should start over.",                'b' => "He agrees the work should be redone.",        'c' => "He did most of the work himself.",           'correct' => 'B'],
            ],
        ];

        foreach ($setsData as $setNumber => $questions) {
            foreach ($questions as $q) {
                ToeflListeningQuestion::create([
                    'meeting_number' => 11,
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
            $this->command->info("Meeting 11 Set {$setNumber} seeded with " . count($questions) . " questions.");
        }
    }
}
