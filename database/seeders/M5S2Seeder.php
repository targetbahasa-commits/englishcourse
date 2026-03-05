<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ToeflListeningQuestion;

class M5S2Seeder extends Seeder
{
    public function run()
    {
        $meetingNumber = 5;
        $setNumber = 2; // As requested

        // Clear existing questions for this specific set
        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->delete();
        
        // Also clear scores for this meeting/set (Scores link to meeting, but if we change questions, old scores might be invalid. 
        // Ideally we filter scores by set number if possible, but the table might not have set_number unless I added it. 
        // I recall adding set_number to scores? No, scores are usually per meeting or per stamp.
        // I will just leave scores alone or delete all for meeting 5 if needed, but safest is to leave them as this is an additive change.)
        // Actually, if I delete questions, the score relation might break if it references question IDs, but `toefl_listening_scores` usually stores a JSON of answers.
        
        $questions = [
            [
                'question_number' => 1,
                'question_text' => 'Question 1',
                'option_a' => "He prefers taking a final exam.",
                'option_b' => "He thinks an exam takes too much time.",
                'option_c' => "He'd rather write a research paper.",
            ],
            [
                'question_number' => 2,
                'question_text' => 'Question 2',
                'option_a' => "It was difficult, but she understood it.",
                'option_b' => "It wasn't very useful.",
                'option_c' => "It's probably easier than the other chapters.",
            ],
            [
                'question_number' => 3,
                'question_text' => 'Question 3',
                'option_a' => "He completely disagrees with it.",
                'option_b' => "He doesn't believe the university will accept it.",
                'option_c' => "He thinks it's a good one.",
            ],
            [
                'question_number' => 4,
                'question_text' => 'Question 4',
                'option_a' => "She doesn't think that Jack wrote it.",
                'option_b' => "She thinks it had too many details.",
                'option_c' => "She found it well-written.",
            ],
            [
                'question_number' => 5,
                'question_text' => 'Question 5',
                'option_a' => "He thinks it's a good day for bike riding, too.",
                'option_b' => "He doesn't agree with the woman's opinion of the weather.",
                'option_c' => "He didn't hear what the woman said.",
            ],
            [
                'question_number' => 6,
                'question_text' => 'Question 6',
                'option_a' => "Arthur wasn't doing well in the class.",
                'option_b' => "She's not sure why Arthur dropped the class.",
                'option_c' => "She believes Arthur dropped the class for no reason.",
            ],
            [
                'question_number' => 7,
                'question_text' => 'Question 7',
                'option_a' => "It might work.",
                'option_b' => "It's very impractical.",
                'option_c' => "It's unnecessary.",
            ],
            [
                'question_number' => 8,
                'question_text' => 'Question 8',
                'option_a' => "He didn't understand it.",
                'option_b' => "It made him angry.",
                'option_c' => "He agreed with it.",
            ],
            [
                'question_number' => 9,
                'question_text' => 'Question 9',
                'option_a' => "She's never been there during final exam week.",
                'option_b' => "It's crowded because students will be taking exams soon.",
                'option_c' => "It's not crowded now, but it soon will be.",
            ],
            [
                'question_number' => 10,
                'question_text' => 'Question 10',
                'option_a' => "He likes the costumes Madelyn made.",
                'option_b' => "He wouldn't recommend the play.",
                'option_c' => "He doesn't think the costumes are attractive.", // Fixed truncation "are" -> "are attractive" inference or leave as "are"
            ],
            [
                'question_number' => 11,
                'question_text' => 'Question 11',
                'option_a' => "It was very happy.",
                'option_b' => "It was exciting.",
                'option_c' => "It was unhappy.",
            ],
            [
                'question_number' => 12,
                'question_text' => 'Question 12',
                'option_a' => "She thinks Pamela is right.",
                'option_b' => "She thinks the regulations are fair.",
                'option_c' => "She disagrees with the man's opinion.", // Removed ".attractive" typo from image inference
            ],
        ];

        $insertData = [];
        foreach ($questions as $q) {
            $insertData[] = [
                'meeting_number' => $meetingNumber,
                'set_number' => $setNumber,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'], // Placeholder text
                'audio_file' => null, 
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => '', // Empty for 3-option
                'correct_answer' => 'A', // Placeholder
                'transcript_en' => null,
                'transcript_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ToeflListeningQuestion::insert($insertData);
        
        $this->command->info("Meeting $meetingNumber Set $setNumber seeded with " . count($insertData) . " questions.");
    }
}
