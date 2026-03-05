<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class ToeflListeningMeeting2Set3Seeder extends Seeder
{
    public function run(): void
    {
        // Delete existing questions for Meeting 2, Set 3
        ToeflListeningQuestion::where('meeting_number', 2)
            ->where('set_number', 3)
            ->delete();

        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'She went to the center with her friend.',
                'option_b' => 'She wrote her friend a letter.',
                'option_c' => 'She told her friend to call her later.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'He has an appointment with the president.',
                'option_b' => 'He was just appointed vice-president.',
                'option_c' => "He's unhappy because he lost the election.",
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'It is a study of the life of plants.',
                'option_b' => 'It concerns the breeding of cattle.',
                'option_c' => 'It deals with life on Earth.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Listen to the audio.',
                'option_a' => "They can't leave until the rain is over.",
                'option_b' => 'Their drain has stopped up.',
                'option_c' => "He shouldn't board the train until it completely stops.",
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'He offered his help to Darlene.',
                'option_b' => "He made an offer to Darlene's sister.",
                'option_c' => 'When Darlene was gone, he missed her.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Get a copy made.',
                'option_b' => 'Buy some cough drops.',
                'option_c' => 'Eat in the coffee shop.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Listen to the audio.',
                'option_a' => "He didn't hear what the woman said.",
                'option_b' => 'He can lend the man a pen.',
                'option_c' => 'He had a pain behind his ear.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Listen to the audio.',
                'option_a' => "The food in this town isn't very good.",
                'option_b' => 'She needed boots when she left home.',
                'option_c' => 'The flooding in her neighborhood was severe.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Listen to the audio.',
                'option_a' => "She's been weakened by the sickness.",
                'option_b' => 'She was awakened by the coughing.',
                'option_c' => 'She missed class because of her cough.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 10,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Evaluate the texts.',
                'option_b' => 'Correct the exams.',
                'option_c' => 'Collect the tests.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 11,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'His apartment is more comfortable now.',
                'option_b' => 'He recently bought a new van.',
                'option_c' => "He's been feeling fine lately.",
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 12,
                'question_text' => 'Listen to the audio.',
                'option_a' => 'Her name is not on the list.',
                'option_b' => 'The lease is difficult to read.',
                'option_c' => 'The lawyer told her to call the police.',
                'option_d' => 'N/A',
                'correct_answer' => 'A',
            ],
        ];

        foreach ($questions as $q) {
            ToeflListeningQuestion::create([
                'meeting_number' => 2,
                'set_number' => 3,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'], 
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'audio_file' => null, 
            ]);
        }
    }
}
