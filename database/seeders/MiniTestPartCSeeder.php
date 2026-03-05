<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MiniTestPartCSeeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 103;
        $setNumber = 1;

        // Ensure Meeting 103 exists in the meetings table
        $exists = DB::table('toefl_listening_meetings')->where('meeting_number', $meetingNumber)->exists();
        if (!$exists) {
            DB::table('toefl_listening_meetings')->insert([
                'meeting_number' => $meetingNumber,
                'title' => 'Mini Test Part C',
                'is_locked' => false,
                'transcript_enabled' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info("Created Meeting $meetingNumber record.");
        }

        // Placeholder questions for Mini Test Part C
        // Replace this with actual content when available
        $questions = [
            [
                'q' => 1,
                'a' => 'An improved toothbrush.',
                'b' => 'Recent developments in genetics.',
                'c' => 'New uses for bacteria.',
                'd' => 'A means of fighting tooth decay.',
                'ans' => 'D'
            ],
            [
                'q' => 2,
                'a' => 'They have many side effects.',
                'b' => 'They occur naturally in people\'s mouths.',
                'c' => 'They attack one type of bacteria.',
                'd' => 'They cause tooth decay.',
                'ans' => 'C'
            ],
            [
                'q' => 3,
                'a' => 'Microbiology.',
                'b' => 'Genetic engineering.',
                'c' => 'Dentistry.',
                'd' => 'Civil engineering.',
                'ans' => 'B'
            ],
            [
                'q' => 4,
                'a' => 'Plan A includes dinner, but Plan B does not.',
                'b' => 'Plan B is more expensive than Plan A.',
                'c' => 'Plan B includes Sunday dinner, but Plan A does not.',
                'd' => 'Plan A provides for three meals on most days while Plan B provides for only two.',
                'ans' => 'D'
            ],
            [
                'q' => 5,
                'a' => 'The Bengal Grill.',
                'b' => 'Restaurants near campus.',
                'c' => 'The Tiger\'s Lair.',
                'd' => 'The dormitory cafeterias.',
                'ans' => 'D'
            ],
            [
                'q' => 6,
                'a' => 'A receipt.',
                'b' => 'A check.',
                'c' => 'A student ID card.',
                'd' => 'A friend.',
                'ans' => 'C'
            ],
            [
                'q' => 7,
                'a' => 'Selling one\'s meal tickets to anyone else.',
                'b' => 'Eating at a dormitory where one does not live.',
                'c' => 'Eating at a cafeteria if one lives off campus.',
                'd' => 'Going back for more than one serving of food.',
                'ans' => 'A'
            ],
            [
                'q' => 8,
                'a' => 'They are open longer hours.',
                'b' => 'They serve many more students.',
                'c' => 'They offer a wider variety of foods.',
                'd' => 'They charge lower prices.',
                'ans' => 'C'
            ],
            [
                'q' => 9,
                'a' => 'Visitors to the Bronx Zoo.',
                'b' => 'Zoology students.',
                'c' => 'Visitors to the City Zoological Gardens.',
                'd' => 'New employees at the zoo.',
                'ans' => 'C'
            ],
            [
                'q' => 10,
                'a' => 'They were usually sleeping when visitors were present.',
                'b' => 'They were uncomfortable because they were exposed to direct sunlight.',
                'c' => 'They couldn\'t be observed because they were always in darkness.',
                'd' => 'They couldn\'t sleep well and therefore became ill.',
                'ans' => 'A'
            ],
            [
                'q' => 11,
                'a' => 'To make them visible to observers.',
                'b' => 'To put them to sleep.',
                'c' => 'To simulate natural daylight.',
                'd' => 'To allow them to see clearly.',
                'ans' => 'A'
            ],
            [
                'q' => 12,
                'a' => 'Study marsupial mammals.',
                'b' => 'Leave the zoo.',
                'c' => 'Look at the nocturnal animals.',
                'd' => 'Go to the World Down Under exhibit.',
                'ans' => 'C'
            ],
        ];

        // Clean up existing questions for this set
        DB::table('toefl_listening_questions')
            ->where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();

        foreach ($questions as $q) {
            DB::table('toefl_listening_questions')->insert([
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $q['q'],
                'question_text' => 'Question ' . $q['q'],
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => $q['c'],
                'option_d' => 'N/A',
                'correct_answer' => $q['ans'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
