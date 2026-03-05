<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting78Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 78)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 78,
                'title' => 'Structure Exercise: General Review',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            // Multiple Choice (1-6)
            [
                'question_number' => 1,
                'question_text' => 'The growth of hair _______ cyclical process, with phases of activity and inactivity.',
                'option_a' => 'it is',
                'option_b' => 'is a',
                'option_c' => 'which is',
                'option_d' => 'a regular',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The fire _______ to have started in the furnace under the house.',
                'option_a' => 'is believed',
                'option_b' => 'that is believed',
                'option_c' => 'they believe',
                'option_d' => 'that they believe',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 3,
                'question_text' => 'In Roman numerals, _______ symbols for numeric values.',
                'option_a' => 'are letters of the alphabet',
                'option_b' => 'letters of the alphabet are',
                'option_c' => 'which uses letters of the alphabet',
                'option_d' => 'in which letters of the alphabet are',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 4,
                'question_text' => 'The legal systems of most countries can be classified _______ common law or civil law.',
                'option_a' => 'as either',
                'option_b' => 'either as',
                'option_c' => 'either to',
                'option_d' => 'to either',
                'correct_answer' => 'A',
            ],
            [
                'question_number' => 5,
                'question_text' => 'One difference between mathematics and language is that mathematics is precise _______ .',
                'option_a' => 'language is not',
                'option_b' => 'while language is not',
                'option_c' => 'but language not',
                'option_d' => 'while is language',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Your criticism of the three short stories should not be less than 2,000 words, nor _______ more than 3,000.',
                'option_a' => 'should it be',
                'option_b' => 'it should be',
                'option_c' => 'it is',
                'option_d' => 'should be it',
                'correct_answer' => 'A',
            ],
            // Written Expression (7-10)
            [
                'question_number' => 7,
                'question_text' => 'In 1870, the attorney general <span class="error-option" data-label="A">was made</span> head of the Department of Justice, given an <span class="error-option" data-label="B">enlarged</span> staff, and <span class="error-option" data-label="C">endow</span> with clear-cut law-enforcement <span class="error-option" data-label="D">functions</span>.',
                'option_a' => 'was made',
                'option_b' => 'enlarged',
                'option_c' => 'endow',
                'option_d' => 'functions',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'The General Sherman Tree, the <span class="error-option" data-label="A">largest</span> of all the giant sequoias, <span class="error-option" data-label="B">are</span> <span class="error-option" data-label="C">reputed</span> to be the world\'s largest living <span class="error-option" data-label="D">thing</span>.',
                'option_a' => 'largest',
                'option_b' => 'are',
                'option_c' => 'reputed',
                'option_d' => 'thing',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The skeleton of a shark <span class="error-option" data-label="A">is made</span> of cartilage <span class="error-option" data-label="B">rather</span> than <span class="error-option" data-label="C">having</span> <span class="error-option" data-label="D">bone</span>.',
                'option_a' => 'is made',
                'option_b' => 'rather',
                'option_c' => 'having',
                'option_d' => 'bone',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">At least</span> one sample of each of the brands contains measurable amounts of aflatoxin, and there <span class="error-option" data-label="B">is</span> three <span class="error-option" data-label="C">which</span> exceed the <span class="error-option" data-label="D">maximum</span>.',
                'option_a' => 'At least',
                'option_b' => 'is', // Based on image, underline is under "is".
                // Image: "...and there ___B__ three which..." -> "is" is B.
                // Wait.
                // Image check: "At least" (A). "contains" (No label).
                // "is" (B)? Wait.
                // Image: A under "At least".
                // B under "contains"?? No, look at line. "contains" has no letter.
                // "amounts of aflatoxin," ...
                // "is" (B)? In "there is three". Yes.
                // "which" (C).
                // "maximum" (D).
                // Re-read image for B.
                // Image: "contains measurable amounts of aflatoxin" -> B is under "is" in "there is three". 
                // Ah, Q10 Image: "At least one sample of each..." 
                // A under "At least".
                // B under "is"? No. 
                // B is under "amounts"? No. 
                // Look at the image crop for Q10...
                // "At least one sample... contains measurable amounts of aflatoxin... and there is three..."
                // Underlines: A (At least). B (is)? No.
                // Let's look closer.
                // B is under "contains"? NO.
                // B is under "is"? Yes, "there is three".
                // C is under "which".
                // D is under "maximum".
                // Wait, "contains" might be underlined?
                // Let's assume standard error: "there is three" -> "there are three". So B should be under "is".
                // BUT, "At least one sample... contains..." -> "contains" is correct.
                // So likely B is indeed under "is".
                'option_a' => 'At least',
                'option_b' => 'is',
                'option_c' => 'which',
                'option_d' => 'maximum',
                'correct_answer' => 'B',
            ],
        ];

        foreach ($questions as $q) {
            \App\Models\ToeflStructureQuestion::create([
                'section_id' => $meeting->id,
                'question_number' => $q['question_number'],
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }
    }
}
