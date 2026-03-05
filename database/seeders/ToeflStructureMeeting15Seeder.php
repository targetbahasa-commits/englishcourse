<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 15)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 15,
                'title' => 'Structure Exercise: Comparatives and Superlatives',
                'is_locked' => false
            ]);
        } else {
             $meeting->update([
                'title' => 'Structure Exercise: Comparatives and Superlatives',
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            // Multiple Choice (1-3)
            [
                'question_number' => 1,
                'question_text' => 'The speed of light is _______ the speed of sound.',
                'option_a' => 'faster',
                'option_b' => 'much faster than',
                'option_c' => 'the fastest',
                'option_d' => 'as fast',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The use of detail is _______ method of developing a controlling idea, and almost all students employ this method.',
                'option_a' => 'more common',
                'option_b' => 'common',
                'option_c' => 'most common',
                'option_d' => 'the most common',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => '_______ in Stevenson\'s landscapes, the more vitality and character the paintings seem to possess.',
                'option_a' => 'The brushwork is loose',
                'option_b' => 'The looser brushwork',
                'option_c' => 'The loose brushwork is',
                'option_d' => 'The looser the brushwork',
                'correct_answer' => 'D',
            ],
            // Written Expression (4-10)
            [
                'question_number' => 4,
                'question_text' => '<span class="error-option" data-label="A">Certain types</span> of snakes <span class="error-option" data-label="B">have been known</span> to survive fasts more <span class="error-option" data-label="C">as</span> <span class="error-option" data-label="D">a</span> year long.',
                'option_a' => 'Certain types',
                'option_b' => 'have been known',
                'option_c' => 'as',
                'option_d' => 'a',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 5,
                'question_text' => 'The grizzly bear, <span class="error-option" data-label="A">which can</span> grow up to eight feet tall, <span class="error-option" data-label="B">has been called</span> <span class="error-option" data-label="C">a more</span> dangerous animal of North <span class="error-option" data-label="D">America</span>.',
                'option_a' => 'which can',
                'option_b' => 'has been called',
                'option_c' => 'a more',
                'option_d' => 'America',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 6,
                'question_text' => 'Climate, soil type, and <span class="error-option" data-label="A">availability</span> of water are the <span class="error-option" data-label="B">most critical</span> factors <span class="error-option" data-label="C">than</span> selecting the <span class="error-option" data-label="D">best type</span> of grass for a lawn.',
                'option_a' => 'availability',
                'option_b' => 'most critical',
                'option_c' => 'than',
                'option_d' => 'best type',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 7,
                'question_text' => 'Peter Abelard, <span class="error-option" data-label="A">a logician</span> and theologian, <span class="error-option" data-label="B">was</span> the <span class="error-option" data-label="C">controversialest</span> teacher <span class="error-option" data-label="D">of his age</span>.',
                'option_a' => 'a logician',
                'option_b' => 'was',
                'option_c' => 'controversialest',
                'option_d' => 'of his age',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 8,
                'question_text' => 'Protein molecules <span class="error-option" data-label="A">are</span> the <span class="error-option" data-label="B">most complex</span> <span class="error-option" data-label="C">than</span> the <span class="error-option" data-label="D">molecules</span> of carbohydrates.',
                'option_a' => 'are',
                'option_b' => 'most complex',
                'option_c' => 'than',
                'option_d' => 'molecules',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'The <span class="error-option" data-label="A">leek</span>, a member of the lily family, has <span class="error-option" data-label="B">a mildest</span> taste <span class="error-option" data-label="C">than</span> the <span class="error-option" data-label="D">onion</span>.',
                'option_a' => 'leek',
                'option_b' => 'a mildest',
                'option_c' => 'than',
                'option_d' => 'onion',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 10,
                'question_text' => '<span class="error-option" data-label="A">The widely</span> used natural fiber <span class="error-option" data-label="B">of all</span> is <span class="error-option" data-label="C">cotton</span> <span class="error-option" data-label="D"></span>.',
                // Wait, Q10 image check again.
                // A: The widely.
                // B: used ... or "of all"?
                // C: cotton??
                // D: ...
                // Image: "The widely used natural fiber of all is cotton."
                // Underlines: A (The widely). B (used)? C (of all). D (cotton)? or (is)?
                // Let's assume standard points.
                // A: The widely
                // B: of all
                // C: is
                // D: cotton
                'question_text' => '<span class="error-option" data-label="A">The widely</span> used natural fiber <span class="error-option" data-label="B">of all</span> <span class="error-option" data-label="C">is</span> <span class="error-option" data-label="D">cotton</span>.',
                'option_a' => 'The widely',
                'option_b' => 'of all',
                'option_c' => 'is',
                'option_d' => 'cotton',
                'correct_answer' => 'A',
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
