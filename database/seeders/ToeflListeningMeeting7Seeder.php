<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting7Seeder extends Seeder
{
    /**
     * Meeting 7 — Listening: Restatements, Suggestions, Offers & Requests
     * Wraps Set 1 (M7Seeder), Set 2 (M7S2Seeder), and adds Set 3.
     */
    public function run(): void
    {
        // Call existing seeders that already have real content
        $this->call([
            M7Seeder::class,
            M7S2Seeder::class,
        ]);

        // ── SET 3: Mixed restatement / inference questions ─────────────────────
        $set3 = [
            ['q' => 1,  'text' => 'The woman wants the man to ...',                   'a' => 'return her notes.',              'b' => 'lend her his notes.',                       'c' => 'stop taking notes.',                         'correct' => 'B'],
            ['q' => 2,  'text' => 'What does the man mean?',                          'a' => "He won't be free until Monday.", 'b' => "He's ready to meet today.",                 'c' => 'He forgot about the appointment.',           'correct' => 'B'],
            ['q' => 3,  'text' => 'What is the woman suggesting?',                    'a' => 'That the man take a nap.',      'b' => 'That the man see a doctor.',                'c' => 'That the man drink more water.',             'correct' => 'A'],
            ['q' => 4,  'text' => 'What does the man offer to do?',                   'a' => 'Drive the woman to class.',     'b' => 'Carry her books.',                          'c' => 'Buy her a car.',                             'correct' => 'A'],
            ['q' => 5,  'text' => 'What does the woman imply?',                       'a' => 'She already has a ticket.',     'b' => 'She wants the man to get a ticket for her.','c' => 'The concert has been cancelled.',             'correct' => 'B'],
            ['q' => 6,  'text' => 'The man is ...',                                   'a' => 'declining an invitation.',      'b' => 'accepting an offer.',                       'c' => 'making a request.',                          'correct' => 'A'],
            ['q' => 7,  'text' => 'What does the woman mean?',                        'a' => "The exam isn't until Friday.",  'b' => 'She has already taken the exam.',           'c' => 'She wants to postpone studying.',            'correct' => 'A'],
            ['q' => 8,  'text' => 'Sandra probably wants the man to ...',             'a' => 'turn down the music.',          'b' => 'play a different song.',                    'c' => 'leave the room.',                            'correct' => 'A'],
            ['q' => 9,  'text' => 'What does the man suggest?',                       'a' => 'Renting a car.',                'b' => 'Taking the train instead.',                 'c' => 'Calling a taxi.',                            'correct' => 'B'],
            ['q' => 10, 'text' => 'What does the woman offer?',                       'a' => 'To proofread the report.',      'b' => 'To rewrite the report.',                    'c' => 'To submit the report.',                      'correct' => 'A'],
            ['q' => 11, 'text' => 'The man is ...',                                   'a' => 'asking for directions.',        'b' => 'offering to show the way.',                 'c' => 'refusing to help.',                          'correct' => 'B'],
            ['q' => 12, 'text' => 'What does the woman imply about the project?',    'a' => "It's almost done.",             'b' => 'More time is needed.',                      'c' => "They shouldn't work on it.",                 'correct' => 'B'],
            ['q' => 13, 'text' => 'Tom is probably going to ...',                     'a' => 'cancel the dinner.',            'b' => 'arrive late.',                              'c' => 'bring a guest.',                             'correct' => 'B'],
            ['q' => 14, 'text' => 'The woman is ...',                                 'a' => 'giving the man permission.',    'b' => 'denying a request.',                        'c' => 'making a complaint.',                        'correct' => 'A'],
            ['q' => 15, 'text' => 'What does the man mean?',                          'a' => "He doesn't enjoy hiking.",      'b' => "He'd love to go hiking.",                   'c' => 'He needs new hiking gear.',                  'correct' => 'B'],
            ['q' => 16, 'text' => 'The woman tells the man that ...',                 'a' => "the deadline has passed.",      'b' => 'she can extend the deadline.',              'c' => 'the deadline doesn\'t apply to him.',        'correct' => 'B'],
        ];

        // Clear any existing Set 3 data
        \App\Models\ToeflListeningQuestion::where('meeting_number', 7)
            ->where('set_number', 3)
            ->delete();

        foreach ($set3 as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 7,
                'set_number'     => 3,
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

        $this->command->info('Meeting 7 Set 3 seeded with ' . count($set3) . ' questions.');
    }
}
