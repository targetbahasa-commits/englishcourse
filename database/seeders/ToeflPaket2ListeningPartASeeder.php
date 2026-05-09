<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflMockupQuestion;

class ToeflPaket2ListeningPartASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // Question 1
            [
                'question_number' => 1,
                'question_text' => '(Audio plays a short conversation about airline tickets)',
                'option_a' => 'There are many different airline fares available.',
                'option_b' => 'Travel agents are all the same.',
                'option_c' => 'It matters where tickets are issued.',
                'option_d' => 'It makes no difference where the tickets are purchased.',
                'correct_answer' => 'C',
            ],
            // Question 2
            [
                'question_number' => 2,
                'question_text' => '(Audio plays a short conversation about picking fruit)',
                'option_a' => 'They should be picked before they\'re ripe.',
                'option_b' => 'They should have been picked already.',
                'option_c' => 'They\'ll get picked when they turn a certain color.',
                'option_d' => 'They won\'t be picked until next year.',
                'correct_answer' => 'C',
            ],
            // Question 3
            [
                'question_number' => 3,
                'question_text' => '(Audio plays a short conversation about apartment and campus housing)',
                'option_a' => 'A two-bedroom apartment may be too expensive.',
                'option_b' => 'The woman should not move off campus.',
                'option_c' => 'The woman should pay the rent by check.',
                'option_d' => 'The university has a list of rental properties.',
                'correct_answer' => 'D',
            ],
            // Question 4
            [
                'question_number' => 4,
                'question_text' => '(Audio plays a short conversation about Judy\'s haircut)',
                'option_a' => 'The man often flatters Judy.',
                'option_b' => 'Judy is thinking about getting her hair cut.',
                'option_c' => 'She hasn\'t seen Judy\'s new haircut.',
                'option_d' => 'She agrees with the man about Judy\'s appearance.',
                'correct_answer' => 'D',
            ],
            // Question 5
            [
                'question_number' => 5,
                'question_text' => '(Audio plays a short conversation about evening activities)',
                'option_a' => 'Watching a movie.',
                'option_b' => 'Talking on the phone.',
                'option_c' => 'Picking up her friends.',
                'option_d' => 'Eating dinner.',
                'correct_answer' => 'A',
            ],
            // Question 6
            [
                'question_number' => 6,
                'question_text' => '(Audio plays a short conversation about mail and moving)',
                'option_a' => 'Notify the post office of his new address.',
                'option_b' => 'Check to see if the mail has arrived.',
                'option_c' => 'Send the letter by special delivery.',
                'option_d' => 'Answer the letters after he moves.',
                'correct_answer' => 'A',
            ],
            // Question 7
            [
                'question_number' => 7,
                'question_text' => '(Audio plays a short conversation about glasses)',
                'option_a' => 'He doesn\'t like his new glasses.',
                'option_b' => 'His regular glasses are being repaired.',
                'option_c' => 'He thinks his eyesight is improving.',
                'option_d' => 'He\'s decided to go without glasses.',
                'correct_answer' => 'B',
            ],
            // Question 8
            [
                'question_number' => 8,
                'question_text' => '(Audio plays a short conversation about Dr. Boyd and library)',
                'option_a' => 'Talk to Dr. Boyd about an assignment.',
                'option_b' => 'Return their books to the library.',
                'option_c' => 'Meet Dr. Boyd at the library.',
                'option_d' => 'Make an appointment with their teacher on Friday.',
                'correct_answer' => 'B',
            ],
            // Question 9
            [
                'question_number' => 9,
                'question_text' => '(Audio plays a short conversation about orange juice machine)',
                'option_a' => 'There is no orange juice in the machine.',
                'option_b' => 'He doesn\'t like orange juice.',
                'option_c' => 'He prefers milk to orange juice.',
                'option_d' => 'The machine is broken.',
                'correct_answer' => 'D',
            ],
            // Question 10
            [
                'question_number' => 10,
                'question_text' => '(Audio plays a short conversation about job promotion)',
                'option_a' => 'The man shouldn\'t take the new job.',
                'option_b' => 'She\'s sorry the man isn\'t being promoted.',
                'option_c' => 'It isn\'t easy to keep secrets at work.',
                'option_d' => 'She won\'t tell anyone about the man\'s promotion.',
                'correct_answer' => 'D',
            ],
            // Question 11
            [
                'question_number' => 11,
                'question_text' => '(Audio plays a short conversation about lunch plans)',
                'option_a' => 'He has made other plans for lunch.',
                'option_b' => 'He has already eaten his lunch.',
                'option_c' => 'He\'d like to ask Bill to join them.',
                'option_d' => 'He\'s meeting Bill in the cafeteria tomorrow.',
                'correct_answer' => 'C',
            ],
            // Question 12
            [
                'question_number' => 12,
                'question_text' => '(Audio plays a short conversation about an argument)',
                'option_a' => 'Complaining about the man\'s behavior.',
                'option_b' => 'Repeating an insensitive remark.',
                'option_c' => 'Denying her involvement in an argument.',
                'option_d' => 'Accepting the man\'s apology.',
                'correct_answer' => 'D',
            ],
            // Question 13
            [
                'question_number' => 13,
                'question_text' => '(Audio plays a short conversation about telephone call)',
                'option_a' => 'The man may use the telephone soon.',
                'option_b' => 'The man should hurry.',
                'option_c' => 'She\'ll call George for the man.',
                'option_d' => 'She\'s waiting for a call.',
                'correct_answer' => 'A',
            ],
            // Question 14
            [
                'question_number' => 14,
                'question_text' => '(Audio plays a short conversation about Professor Brown)',
                'option_a' => 'She\'s difficult to understand.',
                'option_b' => 'She gives longer assignments than Professor Brown.',
                'option_c' => 'Her lectures are interesting.',
                'option_d' => 'Her class meets more often than Professor Brown\'s.',
                'correct_answer' => 'B',
            ],
            // Question 15
            [
                'question_number' => 15,
                'question_text' => '(Audio plays a short conversation about exam difficulty)',
                'option_a' => 'The exam had more sections than she expected.',
                'option_b' => 'She was surprised that the exam was so difficult.',
                'option_c' => 'Part of the exam was easier than she expected.',
                'option_d' => 'She didn\'t have time to study for the exam.',
                'correct_answer' => 'C',
            ],
            // Question 16
            [
                'question_number' => 16,
                'question_text' => '(Audio plays a short conversation about lunch break)',
                'option_a' => 'He\'s only finished half of his lunch.',
                'option_b' => 'He\'s going to eat soon.',
                'option_c' => 'He\'ll continue to work until he finishes.',
                'option_d' => 'He\'ll start working half an hour from now.',
                'correct_answer' => 'C',
            ],
            // Question 17
            [
                'question_number' => 17,
                'question_text' => '(Audio plays a short conversation about bank hours)',
                'option_a' => 'The bank was closed when she got there.',
                'option_b' => 'The bank stayed open later than usual.',
                'option_c' => 'She was able to do her banking.',
                'option_d' => 'She didn\'t have enough time to go to the bank.',
                'correct_answer' => 'C',
            ],
            // Question 18
            [
                'question_number' => 18,
                'question_text' => '(Audio plays a short conversation about conference registration)',
                'option_a' => 'The man has to sign his name.',
                'option_b' => 'The woman will give the man an information kit.',
                'option_c' => 'The woman can\'t find the list.',
                'option_d' => 'The man has already paid to attend the conference.',
                'correct_answer' => 'D',
            ],
            // Question 19
            [
                'question_number' => 19,
                'question_text' => '(Audio plays a short conversation about finding a café)',
                'option_a' => 'She doesn\'t know the way.',
                'option_b' => 'The café is near the information desk.',
                'option_c' => 'The man should get his own map.',
                'option_d' => 'The café isn\'t marked on the map.',
                'correct_answer' => 'B',
            ],
            // Question 20
            [
                'question_number' => 20,
                'question_text' => '(Audio plays a short conversation about going downtown)',
                'option_a' => 'He\'d like to get a ride from the woman.',
                'option_b' => 'He lives very near the woman.',
                'option_c' => 'He doesn\'t want to go downtown.',
                'option_d' => 'He thinks the woman is going the wrong way.',
                'correct_answer' => 'A',
            ],
            // Question 21
            [
                'question_number' => 21,
                'question_text' => '(Audio plays a short conversation about dentist appointment)',
                'option_a' => 'He\'ll see the woman at the dentist\'s office.',
                'option_b' => 'He\'ll miss seeing the woman at work.',
                'option_c' => 'He\'ll try to make arrangements for the woman.',
                'option_d' => 'He\'ll schedule a different dental appointment.',
                'correct_answer' => 'B',
            ],
            // Question 22
            [
                'question_number' => 22,
                'question_text' => '(Audio plays a short conversation about cold weather)',
                'option_a' => 'The woman should avoid getting cold.',
                'option_b' => 'It\'s easy to get sick in cold weather.',
                'option_c' => 'The woman should get more rest.',
                'option_d' => 'Dressing warmly can prevent illness.',
                'correct_answer' => 'D',
            ],
            // Question 23
            [
                'question_number' => 23,
                'question_text' => '(Audio plays a short conversation about tonight\'s class)',
                'option_a' => 'The man won\'t be ready for tonight\'s class.',
                'option_b' => 'The man will not be able to go to the store before class.',
                'option_c' => 'She\'ll take the man to the mall tonight.',
                'option_d' => 'The class schedule has been changed.',
                'correct_answer' => 'B',
            ],
            // Question 24
            [
                'question_number' => 24,
                'question_text' => '(Audio plays a short conversation about Richard leaving work)',
                'option_a' => 'Richard often goes home early.',
                'option_b' => 'The woman expected Richard to be at home.',
                'option_c' => 'Richard should not leave work early.',
                'option_d' => 'The woman called Richard 30 minutes ago.',
                'correct_answer' => 'A',
            ],
            // Question 25
            [
                'question_number' => 25,
                'question_text' => '(Audio plays a short conversation about grocery store)',
                'option_a' => 'She doesn\'t have time to buy groceries now.',
                'option_b' => 'The store will probably go out of business soon.',
                'option_c' => 'She hopes the store hasn\'t already closed.',
                'option_d' => 'The store on the corner has inconvenient hours.',
                'correct_answer' => 'C',
            ],
            // Question 26
            [
                'question_number' => 26,
                'question_text' => '(Audio plays a short conversation about TV problems)',
                'option_a' => 'The man\'s house has no electricity.',
                'option_b' => 'The TV\'s plug might be broken.',
                'option_c' => 'The man can\'t afford to fix the TV.',
                'option_d' => 'The TV might not need to be fixed.',
                'correct_answer' => 'D',
            ],
            // Question 27
            [
                'question_number' => 27,
                'question_text' => '(Audio plays a short conversation about office space)',
                'option_a' => 'Get a new computer for the woman.',
                'option_b' => 'Ask Gary to move the woman\'s furniture.',
                'option_c' => 'Find out if a bigger office is available.',
                'option_d' => 'Request a new chair for the woman.',
                'correct_answer' => 'C',
            ],
            // Question 28
            [
                'question_number' => 28,
                'question_text' => '(Audio plays a short conversation about supervisor feedback)',
                'option_a' => 'The supervisor hasn\'t explained what he needs to do.',
                'option_b' => 'His work is viewed favorably.',
                'option_c' => 'He\'s impressed by his supervisor.',
                'option_d' => 'His back problems have affected his work recently.',
                'correct_answer' => 'B',
            ],
            // Question 29
            [
                'question_number' => 29,
                'question_text' => '(Audio plays a short conversation about slide projector and meeting)',
                'option_a' => 'The slide projector has been repaired.',
                'option_b' => 'The room is ready for the meeting.',
                'option_c' => 'He\'ll take care of the slide projector after lunch.',
                'option_d' => 'Everyone is waiting for the meeting to begin.',
                'correct_answer' => 'C',
            ],
            // Question 30
            [
                'question_number' => 30,
                'question_text' => '(Audio plays a short conversation about weather and clothing)',
                'option_a' => 'Wear a blue jacket.',
                'option_b' => 'Dress warmly.',
                'option_c' => 'Wear something cool.',
                'option_d' => 'Wear cotton pants.',
                'correct_answer' => 'B',
            ],
        ];

        foreach ($questions as $q) {
            ToeflMockupQuestion::create([
                'section' => 'listening',
                'part' => 'A',
                'package_number' => 2,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'audio_file' => null,
                'transcript_en' => null,
                'transcript_id' => null,
            ]);
        }

        $this->command->info('Successfully seeded 30 Listening Part A questions for Package 2');
    }
}
