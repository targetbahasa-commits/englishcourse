<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningMeeting;

class MiniTestPartASeeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 101;
        $setNumber = 1;

        // Ensure the meeting exists
        ToeflListeningMeeting::updateOrCreate(
            ['meeting_number' => $meetingNumber],
            [
                'title' => 'Mini Test Part A',
                'is_locked' => false,
                'transcript_enabled' => false,
            ]
        );

        // Clear existing questions for this meeting
        \App\Models\ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        // Clear scores
        \Illuminate\Support\Facades\DB::table('toefl_listening_scores')->where('meeting_number', $meetingNumber)->delete();

        $questionsData = [
            [
                'q' => 1,
                'a' => "She met her during the summer.",
                'b' => "She's never liked her very much.",
                'c' => "She warned her of a problem.",
                'd' => "Her impression of her has changed.",
                'ans' => 'D' 
            ],
            [
                'q' => 2,
                'a' => "Review the last point.",
                'b' => "Go on to the next chapter.",
                'c' => "Leave the classroom.",
                'd' => "Point out the teacher's mistake.",
                'ans' => 'A'
            ],
            [
                'q' => 3,
                'a' => "The weather will not be as nice tomorrow.",
                'b' => "She no longer reads the weather report.",
                'c' => "She went to the store for a newspaper.",
                'd' => "The weather reports will change soon.",
                'ans' => 'A'
            ],
            [
                'q' => 4,
                'a' => "Writing an advertisement.",
                'b' => "Playing a game.",
                'c' => "Looking at a newspaper.",
                'd' => "Discussing a book.",
                'ans' => 'C'
            ],
            [
                'q' => 5,
                'a' => "Grace may want to live with the man's sister.",
                'b' => "The woman thinks Grace already has a roommate.",
                'c' => "The woman doesn't know where Grace has moved.",
                'd' => "Grace doesn't know the man's sister.",
                'ans' => 'A'
            ],
            [
                'q' => 6,
                'a' => "Go to a meeting.",
                'b' => "Keep a budget.",
                'c' => "Reduce his expenses.",
                'd' => "Get some exercise.",
                'ans' => 'B'
            ],
            [
                'q' => 7,
                'a' => "The man should clean out his closet.",
                'b' => "The lamp will look better in a small space.",
                'c' => "She doesn't like the lamp very much.",
                'd' => "The living room is the best place for the lamp.",
                'ans' => 'C'
            ],
            [
                'q' => 8,
                'a' => "What Mark is writing.",
                'b' => "Where Mark is living now.",
                'c' => "Why Mark doesn't want to go.",
                'd' => "Why Mark is in a hurry.",
                'ans' => 'D'
            ],
            [
                'q' => 9,
                'a' => "He certainly likes Ernie's red car.",
                'b' => "The man in the red car resembles Ernie.",
                'c' => "Ernie has a car just like that red one.",
                'd' => "He can't see the man in the red car.",
                'ans' => 'B'
            ],
            [
                'q' => 10,
                'a' => "The man doesn't need his hat.",
                'b' => "It's not very cold today.",
                'c' => "She likes the way the hat looks.",
                'd' => "The man ought to wear his hat.",
                'ans' => 'D'
            ],
            [
                'q' => 11,
                'a' => "She's never seen it.",
                'b' => "It was made a long time ago.",
                'c' => "She likes it a lot.",
                'd' => "It's a very unusual movie.",
                'ans' => 'C'
            ],
            [
                'q' => 12,
                'a' => "He doesn't believe what the woman told him.",
                'b' => "He thinks the team was unprepared too.",
                'c' => "He disagrees with the woman's idea.",
                'd' => "He isn't ready to go to the game either.",
                'ans' => 'B'
            ],
            [
                'q' => 13,
                'a' => "The man would like to use that computer.",
                'b' => "Becky will need the computer for a long time.",
                'c' => "There are no longer any computers in the library.",
                'd' => "Becky would like the man to go to the library.",
                'ans' => 'A'
            ],
            [
                'q' => 14,
                'a' => "He hurt his hand when he was scuba diving.",
                'b' => "He hasn't gone scuba diving for a long time.",
                'c' => "He's not too old to go scuba diving.",
                'd' => "He's an experienced scuba diver.",
                'ans' => 'D'
            ],
            [
                'q' => 15,
                'a' => "His shoes hurt his feet.",
                'b' => "He was injured in a skiing accident.",
                'c' => "His shoes are old and in bad shape.",
                'd' => "He walked so far that his legs hurt.",
                'ans' => 'A'
            ],
            [
                'q' => 16,
                'a' => "She doesn't have time to listen now.",
                'b' => "She doesn't know what song she wants to hear.",
                'c' => "She wants to hear his song right away.",
                'd' => "She prefers old songs to new ones.",
                'ans' => 'C'
            ],
            [
                'q' => 17,
                'a' => "A television commercial.",
                'b' => "A history class.",
                'c' => "The woman's field of study.",
                'd' => "Some famous artists.",
                'ans' => 'C'
            ],
            [
                'q' => 18,
                'a' => "She was about to suggest the same thing.",
                'b' => "She doesn't feel like giving a party.",
                'c' => "She's completely surprised by the man's remark.",
                'd' => "She isn't hungry right now.",
                'ans' => 'A'
            ],
            [
                'q' => 19,
                'a' => "Sophie won't be at her apartment.",
                'b' => "The man can inform Sophie at the meeting.",
                'c' => "The man shouldn't bother Sophie.",
                'd' => "Sophie will think this is bad news.",
                'ans' => 'B'
            ],
            [
                'q' => 20,
                'a' => "He doesn't go out as often as he once did.",
                'b' => "He doesn't always tell the truth.",
                'c' => "He isn't as friendly as he once was.",
                'd' => "He hasn't always been so sociable.",
                'ans' => 'D'
            ],
            [
                'q' => 21,
                'a' => "The ring is quite attractive.",
                'b' => "Laura got a bargain on the ring.",
                'c' => "The ring was probably expensive.",
                'd' => "Laura had to sell her ring.",
                'ans' => 'C'
            ],
            [
                'q' => 22,
                'a' => "She didn't realize Bill had to work.",
                'b' => "Bill has not finished his work.",
                'c' => "The break has not lasted long enough.",
                'd' => "The work didn't take long to complete.",
                'ans' => 'B'
            ],
            [
                'q' => 23,
                'a' => "The woman has just begun to collect rocks.",
                'b' => "The man is unwilling to help.",
                'c' => "The box is very heavy.",
                'd' => "There's nothing in the box.",
                'ans' => 'C'
            ],
            [
                'q' => 24,
                'a' => "She doesn't like the length of her hair.",
                'b' => "She thinks the haircut took too long.",
                'c' => "She doesn't know where to get a haircut.",
                'd' => "She thinks haircuts are too expensive.",
                'ans' => 'A'
            ],
            [
                'q' => 25,
                'a' => "Professor Clayburn is going to speak some other night.",
                'b' => "He's never heard of Professor Clayburn.",
                'c' => "He didn't realize Professor Clayburn was speaking tonight.",
                'd' => "Professor Clayburn is giving his speech in this room.",
                'ans' => 'C'
            ],
            [
                'q' => 26,
                'a' => "The man may see her drawing.",
                'b' => "She'd like the man to visit.",
                'c' => "The man should draw a second picture.",
                'd' => "She's going to take a guess.",
                'ans' => 'A'
            ],
            [
                'q' => 27,
                'a' => "The weather has been very warm.",
                'b' => "Her car doesn't need a tune-up.",
                'c' => "She's starting to feel ill.",
                'd' => "She's already too warm.",
                'ans' => 'D'
            ],
            [
                'q' => 28,
                'a' => "Joe has been making too much noise.",
                'b' => "Dogs are not allowed in the dorm.",
                'c' => "No one understands the parking regulations.",
                'd' => "Joe is not allowed to leave his room.",
                'ans' => 'B'
            ],
            [
                'q' => 29,
                'a' => "Where the Medical Center is located.",
                'b' => "Which office Dr. Norton is in.",
                'c' => "What Dr. Norton told the man.",
                'd' => "Why the man went to see Doctor Norton.",
                'ans' => 'D'
            ],
            [
                'q' => 30,
                'a' => "She liked chemistry.",
                'b' => "She would graduate in May.",
                'c' => "She didn't have to repeat a course.",
                'd' => "She hadn't completed the required courses.",
                'ans' => 'D'
            ],
        ];

        $insertData = [];
        foreach ($questionsData as $item) {
            $insertData[] = [
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $item['q'],
                'question_text' => 'Question ' . $item['q'],
                'audio_file' => null, 
                'option_a' => $item['a'],
                'option_b' => $item['b'],
                'option_c' => $item['c'],
                'option_d' => $item['d'],
                'correct_answer' => $item['ans'],
                'transcript_en' => null,
                'transcript_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \App\Models\ToeflListeningQuestion::insert($insertData);

        $this->command->info('Mini Test Part A (Meeting 101) seeded with ' . count($insertData) . ' questions.');
    }
}
