<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class M6S2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Clear existing questions for Meeting 6, Set 2
        DB::table('toefl_listening_questions')
            ->where('meeting_number', 6)
            ->where('set_number', 2)
            ->delete();

        // 2. Clear existing scores for Meeting 6 to avoid inconsistencies (Optional, but good practice if questions change drastically)
        // Usually we might want to keep history, but if the content is new, old scores might be invalid.
        // For practice sets, maybe just delete answers associated?
        // Let's stick to just deleting questions. Validation usually handles missing questions.

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Question 1',
                'option_a' => 'He prefers taking a final exam.',
                'option_b' => 'He thinks an exam takes too much time.',
                'option_c' => 'He\'d rather write a research paper.',
                'option_d' => 'N/A', // Assuming 3 options only based on image
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Question 2',
                'option_a' => 'It was difficult, but she understood it.',
                'option_b' => 'It wasn\'t very useful.',
                'option_c' => 'It\'s probably easier than the other chapters.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Question 3',
                'option_a' => 'He completely disagrees with it.',
                'option_b' => 'He doesn\'t believe the university will accept it.',
                'option_c' => 'He thinks it\'s a good one.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Question 4',
                'option_a' => 'She doesn\'t think that Jack wrote it.',
                'option_b' => 'She thinks it had too many details.',
                'option_c' => 'She found it well-written.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Question 5',
                'option_a' => 'He thinks it\'s a good day for bike riding, too.',
                'option_b' => 'He doesn\'t agree with the woman\'s opinion of the weather.',
                'option_c' => 'He didn\'t hear what the woman said.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Question 6',
                'option_a' => 'Arthur wasn\'t doing well in the class.',
                'option_b' => 'She\'s not sure why Arthur dropped the class.',
                'option_c' => 'She believes Arthur dropped the class for no reason.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Question 7',
                'option_a' => 'It might work.',
                'option_b' => 'It\'s very impractical.',
                'option_c' => 'It\'s unnecessary.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Question 8',
                'option_a' => 'He didn\'t understand it.',
                'option_b' => 'It made him angry.',
                'option_c' => 'He agreed with it.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Question 9',
                'option_a' => 'She\'s never been there during final exam week.',
                'option_b' => 'It\'s crowded because students will be taking exams soon.',
                'option_c' => 'It\'s not crowded now, but it soon will be.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Question 10',
                'option_a' => 'He likes the costumes Madelyn made.',
                'option_b' => 'He wouldn\'t recommend the play.',
                'option_c' => 'He doesn\'t think the costumes are attractive.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 11,
                'question_text' => 'Question 11',
                'option_a' => 'It was very happy.',
                'option_b' => 'It was exciting.',
                'option_c' => 'It was unhappy.',
                'option_d' => 'N/A',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 12,
                'question_text' => 'Question 12',
                'option_a' => 'She thinks Pamela is right.',
                'option_b' => 'She thinks the regulations are fair.',
                'option_c' => 'She disagrees with the man\'s opinion.',
                'option_d' => 'N/A',
                'correct_answer' => 'B',
            ],
        ];

        foreach ($questions as $q) {
            DB::table('toefl_listening_questions')->insert([
                'meeting_number' => 6,
                'set_number' => 2,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'], // Placeholder
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
