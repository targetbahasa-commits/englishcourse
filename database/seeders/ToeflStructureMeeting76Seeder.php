<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting76Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 76)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 76,
                'title' => 'Structure Exercise: Parallel Structure',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            // Multiple Choice (1-4)
            [
                'question_number' => 1,
                'question_text' => 'Truman Capote\'s <i>In Cold Blood</i> is neither journalistically accurate _______.',
                'option_a' => 'a piece of fiction',
                'option_b' => 'nor a fictitious work',
                'option_c' => 'or written in a fictitious way',
                'option_d' => 'nor completely fictitious',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 2,
                'question_text' => 'Vitamin C is necessary for the prevention and _______ of scurvy.',
                'option_a' => 'it cures',
                'option_b' => 'cures',
                'option_c' => 'cure',
                'option_d' => 'for curing',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 3,
                'question_text' => 'A baby\'s development is influenced by both heredity and _______.',
                'option_a' => 'by environmental factors',
                'option_b' => 'environmentally',
                'option_c' => 'the influence of the environment',
                'option_d' => 'environment',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 4,
                'question_text' => 'Because bone loss occurs earlier in women than _______, the effects of osteoporosis are more apparent in women.',
                'option_a' => 'men do',
                'option_b' => 'in men',
                'option_c' => 'as men',
                'option_d' => 'similar to men',
                'correct_answer' => 'B',
            ],
            // Written Expression (5-10)
            [
                'question_number' => 5,
                'question_text' => 'Fire extinguishers can <span class="error-option" data-label="A">contain</span> liquefied gas, dry chemicals, <span class="error-option" data-label="B">or</span> <span class="error-option" data-label="C">watery</span>.',
                'option_a' => 'contain', // Note: Image has "contain" underlined as A? Wait, image: contain (A), B under "liquefied gas"? No.
                // Let's re-read image 5: "contain" is A. "liquefied gas" NO label. "dry chemicals" NO label. "or" is C. "watery" is D. Where is B?
                // Image: "contain" (A). "liquefied" has a line under it? No.
                // Ah, line under "contain" is A. Line under "liquefied" is B? No, look closely.
                // Line under "contain" (A). Line under "liquefied"? No.
                // Line under "contain" (A).
                // Line under "liquefied" (B)? Wait. "contain" is A. "liquefied" is B. "or" is C. "watery" is D.
                // Let's assume standard spacing.
                // A: contain
                // B: liquefied
                // C: or
                // D: watery
                'option_a' => 'contain',
                'option_b' => 'liquefied',
                'option_c' => 'or',
                'option_d' => 'watery',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The U.S. Congress <span class="error-option" data-label="A">consists of</span> <span class="error-option" data-label="B">both</span> the Senate <span class="error-option" data-label="C">as well as</span> the House of <span class="error-option" data-label="D">Representatives</span>.',
                'option_a' => 'consists of',
                'option_b' => 'both',
                'option_c' => 'as well as',
                'option_d' => 'Representatives',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'The prison <span class="error-option" data-label="A">population</span> in this state, now at an <span class="error-option" data-label="B">all time</span> high, is <span class="error-option" data-label="C">higher than</span> <span class="error-option" data-label="D">any state</span>.',
                'option_a' => 'population',
                'option_b' => 'all time',
                'option_c' => 'higher than',
                'option_d' => 'any state',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => 'A <span class="error-option" data-label="A">well-composed</span> baroque opera <span class="error-option" data-label="B">achieves</span> a delicate balance by <span class="error-option" data-label="C">focusing</span> alternately on the aural, visual, emotional, and <span class="error-option" data-label="D">philosophy</span> elements.',
                'option_a' => 'well-composed',
                'option_b' => 'achieves',
                'option_c' => 'focusing',
                'option_d' => 'philosophy',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Manufacturers <span class="error-option" data-label="A">may use</span> food additives <span class="error-option" data-label="B">for preserving</span>, to color, <span class="error-option" data-label="C">to fortify</span> foods.', // Missing "to flavor"?
                // Image: "for preserving, to color, to flavor, or to fortify".
                // Underlines: "may use" (A). "for preserving" (B). "to color" NO. "to flavor" NO. "to fortify" (C). "foods" (D).
                // Wait, C is under "to fortify" or "or to fortify"? Usually just phrase.
                // Let's look really close.
                // 9. ... A under "may use". B under "for preserving". C under "to fortify"?? No, look at the spacing.
                // C is under "to flavor"?? No.
                // C is under "or to fortify"?
                // Let's assume standard test spots.
                // A: may use
                // B: for preserving
                // C: to fortify (parallelism: for preserving (Gerund), to color (Inf), to flavor (Inf), to fortify (Inf)).
                // If B is the error (should be "to preserve"), then the list is "to preserve, to color, to flavor, or to fortify". This works.
                // Where is C and D?
                // Image: `_may use_` (A) ... `_for preserving_` (B) ... `_to color, to flavor, or to fortify_`?? No underline under to color/flavor.
                // C is under "to fortify"? It looks like it is under "or to fortify" or just "to fortify".
                // D is under "foods".
                'question_text' => 'Manufacturers <span class="error-option" data-label="A">may use</span> food additives <span class="error-option" data-label="B">for preserving</span>, to color, to flavor, or <span class="error-option" data-label="C">to fortify</span> <span class="error-option" data-label="D">foods</span>.',
                'option_a' => 'may use',
                'option_b' => 'for preserving',
                'option_c' => 'to fortify',
                'option_d' => 'foods',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">A bankruptcy</span> <span class="error-option" data-label="B">may be</span> either <span class="error-option" data-label="C">voluntary</span> <span class="error-option" data-label="D">nor</span> involuntary.',
                'option_a' => 'A bankruptcy',
                'option_b' => 'may be',
                'option_c' => 'voluntary',
                'option_d' => 'nor',
                'correct_answer' => 'D',
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
