<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeeting14Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meeting = \App\Models\ToeflStructureMeeting::where('meeting_number', 14)->first();
        
        if (!$meeting) {
            $meeting = \App\Models\ToeflStructureMeeting::create([
                'meeting_number' => 14,
                'title' => 'Structure Exercise: Review (Skills 1-15)',
                'is_locked' => false
            ]);
        }
        
        // Clear existing questions
        \App\Models\ToeflStructureQuestion::where('section_id', $meeting->id)->delete();

        $questions = [
            // Multiple Choice (1-4)
            [
                'question_number' => 1,
                'question_text' => 'Most cells in multicelled organisms perform _______ functions.',
                'option_a' => 'specialize',
                'option_b' => 'specialized',
                'option_c' => 'they specialize',
                'option_d' => 'specialization',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 2,
                'question_text' => 'The big island of Hawaii, in the middle of the Pacific Ocean, _______ by five volcanoes.',
                'option_a' => 'creation',
                'option_b' => 'it was created',
                'option_c' => 'creating',
                'option_d' => 'was created',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 3,
                'question_text' => 'The Sun uses up over 4 million tons of hydrogen per second, _______ still has enough hydrogen to last for the next 5 billion years.',
                'option_a' => 'it does not',
                'option_b' => 'it',
                'option_c' => 'but it',
                'option_d' => 'to it',
                'correct_answer' => 'C',
            ],
            [
                'question_number' => 4,
                'question_text' => 'For Katherine L. Bates, who _______ the top of Pikes Peak in 1893, the view provided the inspiration for her hymn "America the Beautiful."',
                'option_a' => 'reached',
                'option_b' => 'she reached',
                'option_c' => 'reaching',
                'option_d' => 'she was reaching',
                'correct_answer' => 'A',
            ],
            // Written Expression (5-10)
            [
                'question_number' => 5,
                'question_text' => 'Coal, petroleum, and natural <span class="error-option" data-label="A">gaseous</span> <span class="error-option" data-label="B">are</span> all fossil <span class="error-option" data-label="C">fuels</span> <span class="error-option" data-label="D"></span>.',
                // Wait, Q5: "Coal, petroleum, and natural gaseous are all fossil fuels."
                // Labels: A under Coal?? No.
                // Image: "Coal, petroleum, and natural gaseous are all fossil fuels."
                // Underlines: Coal (A), gaseous (B), are (C), fuels (D). Wait, looking closely at line segments.
                // ___ Coal (A if preceding line? No, usually under words).
                // Actually, standard TOEFL:
                // A: gaseous (No, wait. "Coal" has line A? Or is line A under "Coal"? It looks like line A is under "Coal"?)
                // Actually, usually 4 underlines.
                // "Coal" (A), "gaseous" (B), "are" (C), "fuels" (D).
                // "natural gaseous" -> "natural gas". Adjective vs Noun parallelism.
                // So B is likely the answer.
                // Let's assume A is Coal.
                'question_text' => '<span class="error-option" data-label="A">Coal</span>, petroleum, and natural <span class="error-option" data-label="B">gaseous</span> <span class="error-option" data-label="C">are</span> all fossil <span class="error-option" data-label="D">fuels</span>.',
                'option_a' => 'Coal',
                'option_b' => 'gaseous',
                'option_c' => 'are',
                'option_d' => 'fuels',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 6,
                'question_text' => 'The mass of <span class="error-option" data-label="A">neutron stars</span> generally <span class="error-option" data-label="B">range</span> from one-tenth to <span class="error-option" data-label="C">twice</span> the <span class="error-option" data-label="D">mass</span> of the Sun.',
                'option_a' => 'neutron stars',
                'option_b' => 'range',
                'option_c' => 'twice',
                'option_d' => 'mass',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 7,
                'question_text' => '<span class="error-option" data-label="A">Grasses</span> <span class="error-option" data-label="B">grow</span> in ways <span class="error-option" data-label="C">that help</span> them to survive being nibbled, <span class="error-option" data-label="D">chilly</span>, or dried.',
                // Wait, underlining.
                // "Grasses" line A? No.
                // Line A is under "Grasses"? Or "grow"?
                // Let's look at letters.
                // Q7: Line A under "grow"? Or "Grasses"?
                // Actually: "Grasses grow in ways that help them to survive being nibbled, chilly, or dried."
                // Underline A: grow. Underline B: ways (or "in ways"?).
                // Underline C: help (or "that help"?). Underline D: chilly.
                // Let's assume typical placement.
                // A: grow. (Subject Grasses plural, grow plural. OK).
                // B: ways. (Correct).
                // C: help. (relative clause).
                // D: chilly. (Parallelism error).
                // I will use these.
                'question_text' => 'Grasses <span class="error-option" data-label="A">grow</span> in <span class="error-option" data-label="B">ways</span> that help them <span class="error-option" data-label="C">to survive</span> being nibbled, <span class="error-option" data-label="D">chilly</span>, or dried.',
                'option_a' => 'grow',
                'option_b' => 'ways',
                'option_c' => 'to survive',
                'option_d' => 'chilly',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 8,
                'question_text' => '<span class="error-option" data-label="A">Most of</span> Hemingway\'s novels <span class="error-option" data-label="B">glorifies</span> heroic <span class="error-option" data-label="C">exploits</span> such as <span class="error-option" data-label="D">bullfighting</span> or boxing.',
                'option_a' => 'Most of',
                'option_b' => 'glorifies',
                'option_c' => 'exploits',
                'option_d' => 'bullfighting',
                'correct_answer' => 'B',
            ],
            [
                'question_number' => 9,
                'question_text' => 'Paleographers study <span class="error-option" data-label="A">ancient</span> and medieval <span class="error-option" data-label="B">handwriting</span> in order to <span class="error-option" data-label="C">establish</span> not only its age <span class="error-option" data-label="D">and also</span> its background.',
                'option_a' => 'ancient',
                'option_b' => 'handwriting',
                'option_c' => 'establish',
                'option_d' => 'and also',
                'correct_answer' => 'D',
            ],
            [
                'question_number' => 10,
                'question_text' => 'The sounds <span class="error-option" data-label="A">produced</span> by bullfrogs and toads <span class="error-option" data-label="B">vary</span> greatly because each species <span class="error-option" data-label="C">have</span> its <span class="error-option" data-label="D">own</span> particular call.',
                'option_a' => 'produced',
                'option_b' => 'vary',
                'option_c' => 'have',
                'option_d' => 'own',
                'correct_answer' => 'C',
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
