<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting9Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 9
        $meeting = ToeflReadingMeeting::where('meeting_number', 9)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 9,
                'title' => 'Vocabulary in Context',
                'is_locked' => false
            ]);
        }

        // For vocabulary questions without passages, we create a dummy passage
        $passage = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => 'This meeting contains vocabulary in context questions.'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 1,
            'question_text' => 'The planet Mercury is visible to the naked eye but is not the easiest planet to spot.',
            'option_a' => 'unclothed',
            'option_b' => 'unaided',
            'option_c' => 'unarmed',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 2,
            'question_text' => 'Every atlas has its own legend.',
            'option_a' => 'mythical story',
            'option_b' => 'famous person',
            'option_c' => 'explanation of symbols',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 3,
            'question_text' => 'Above the snowline, any mountain hollow is permanently occupied with snow.',
            'option_a' => 'filled',
            'option_b' => 'busy',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 4,
            'question_text' => 'The glass factories of Toledo, Ohio, boomed after Michael Owens invented a process that turned out bottles by the thousands.',
            'option_a' => 'exploded',
            'option_b' => 'resounded',
            'option_c' => 'prospered',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 5,
            'question_text' => 'Dr. Rene Dubos, a French physician who came to the United States in 1924, searched for substances that would check the growth of bacteria.',
            'option_a' => 'restrict',
            'option_b' => 'investigate',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 6,
            'question_text' => 'The root of the horseradish plant has a biting taste.',
            'option_a' => 'chewing',
            'option_b' => 'sharp',
            'option_c' => 'sarcastic',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 7,
            'question_text' => 'The double-bass is shaped like a viola and has a deep rich tone.',
            'option_a' => 'valuable',
            'option_b' => 'resonant',
            'option_c' => 'abundant',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 8,
            'question_text' => 'A public library is a resource the entire community can draw on.',
            'option_a' => 'illustrate',
            'option_b' => 'approach',
            'option_c' => 'use',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 9,
            'question_text' => 'A business concern with two or more owners is referred to as a partnership.',
            'option_a' => 'firm',
            'option_b' => 'worry',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 10,
            'question_text' => 'Table salt is finer than rock salt.',
            'option_a' => 'made up of smaller particles',
            'option_b' => 'of better quality',
            'option_c' => 'freer of impurities',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 11,
            'question_text' => 'Shirley Jackson\'s sometimes chilling, sometimes hilarious stories were largely ignored by critics at the time they were published.',
            'option_a' => 'freezing',
            'option_b' => 'frightening',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 12,
            'question_text' => 'As a child, the sharpshooter Annie Oakley hunted game with such success that, by selling it, she was able to payoff the mortgage on her family\'s farm.',
            'option_a' => 'animals',
            'option_b' => 'athletic competition',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 13,
            'question_text' => 'All chimpanzees are extremely curious about their surroundings.',
            'option_a' => 'strange',
            'option_b' => 'inquisitive',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 14,
            'question_text' => 'Furniture design and manufacture were originally the work of individuals, but by the eighteenth century, many furniture makers had teams of craftsmen to help them carry out their plans.',
            'option_a' => 'transport',
            'option_b' => 'obey',
            'option_c' => 'implement',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 15,
            'question_text' => 'Samuel Latham Mitchell helped found Rutgers Medical College in New Jersey in 1826, and he produced several important works in chemistry and geology.',
            'option_a' => 'books',
            'option_b' => 'accomplishments',
            'option_c' => 'factories',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        $this->command->info('TOEFL Reading Meeting 9 seeded successfully!');
    }
}
