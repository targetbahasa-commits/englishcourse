<?php

namespace Database\Seeders;

use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementQuestion;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeds the placement test used to gate the self-study Grammar for Writing
 * course into two tracks: a low score (CEFR A1/A2) routes the student into
 * the everyday A1-A2-to-B1-B2 escalating track, a high score (CEFR B1+)
 * routes them into the B1-C2 academic track. Questions run from very easy
 * to quite hard so a student's raw percentage spreads naturally across the
 * CEFR ladder used by ResolvePlacementCefrLevel.
 */
class SelfStudyGrammarPlacementSeeder extends Seeder
{
    public function run(): void
    {
        $package = GrammarPlacementPackage::updateOrCreate(
            ['title' => 'Self-Study Grammar for Writing - Placement Test'],
            [
                'description' => 'Tes penempatan awal untuk menentukan jalur kosakata (A1-B2 bertahap atau B1-C2) pada kursus mandiri Grammar for Writing.',
                'is_active' => true,
            ]
        );

        $package->questions()->delete();

        $questions = [
            // A1 - very easy
            [
                'question_text' => 'My sister ___ to school every morning with her friends.',
                'option_a' => 'walk', 'option_b' => 'walks', 'option_c' => 'walking', 'option_d' => 'walked',
                'correct_option' => 'b', 'cefr_level' => 'A1',
            ],
            [
                'question_text' => 'There ___ two cats sleeping under the table right now.',
                'option_a' => 'is', 'option_b' => 'am', 'option_c' => 'are', 'option_d' => 'be',
                'correct_option' => 'c', 'cefr_level' => 'A1',
            ],
            [
                'question_text' => '___ you like coffee or tea in the morning?',
                'option_a' => 'Does', 'option_b' => 'Do', 'option_c' => 'Is', 'option_d' => 'Are',
                'correct_option' => 'b', 'cefr_level' => 'A1',
            ],
            [
                'question_text' => 'He ___ a new bicycle last weekend at the market.',
                'option_a' => 'buy', 'option_b' => 'buys', 'option_c' => 'bought', 'option_d' => 'buying',
                'correct_option' => 'c', 'cefr_level' => 'A1',
            ],
            [
                'question_text' => 'This bag is mine, and that one is ___.',
                'option_a' => 'she', 'option_b' => 'her', 'option_c' => 'hers', 'option_d' => 'herself',
                'correct_option' => 'c', 'cefr_level' => 'A1',
            ],
            // A2 - easy
            [
                'question_text' => 'We ___ dinner when the electricity suddenly went out.',
                'option_a' => 'have', 'option_b' => 'had', 'option_c' => 'were having', 'option_d' => 'has',
                'correct_option' => 'c', 'cefr_level' => 'A2',
            ],
            [
                'question_text' => 'This cake ___ by my mother for my sister\'s birthday party last night.',
                'option_a' => 'made', 'option_b' => 'is made', 'option_c' => 'was made', 'option_d' => 'were made',
                'correct_option' => 'c', 'cefr_level' => 'A2',
            ],
            [
                'question_text' => 'You ___ bring an umbrella; it looks like it might rain later.',
                'option_a' => 'should', 'option_b' => 'should to', 'option_c' => 'must to', 'option_d' => 'should be',
                'correct_option' => 'a', 'cefr_level' => 'A2',
            ],
            [
                'question_text' => 'By the time we arrived at the cinema, the movie ___ already ___.',
                'option_a' => 'has / started', 'option_b' => 'had / started', 'option_c' => 'was / starting', 'option_d' => 'have / start',
                'correct_option' => 'b', 'cefr_level' => 'A2',
            ],
            [
                'question_text' => 'The man ___ lives next door works as an engineer.',
                'option_a' => 'who', 'option_b' => 'whom', 'option_c' => 'which', 'option_d' => 'whose',
                'correct_option' => 'a', 'cefr_level' => 'A2',
            ],
            // B1 - moderate
            [
                'question_text' => 'I ___ my homework yet, so I can\'t go out and play now.',
                'option_a' => 'didn\'t finish', 'option_b' => 'haven\'t finished', 'option_c' => 'wasn\'t finished', 'option_d' => 'don\'t finish',
                'correct_option' => 'b', 'cefr_level' => 'B1',
            ],
            [
                'question_text' => 'If it ___ tomorrow, we will cancel the picnic.',
                'option_a' => 'rains', 'option_b' => 'will rain', 'option_c' => 'rained', 'option_d' => 'would rain',
                'correct_option' => 'a', 'cefr_level' => 'B1',
            ],
            [
                'question_text' => 'The new policy ___ by the city council next month, according to the announcement.',
                'option_a' => 'will review', 'option_b' => 'will be reviewed', 'option_c' => 'is reviewing', 'option_d' => 'reviews',
                'correct_option' => 'b', 'cefr_level' => 'B1',
            ],
            [
                'question_text' => 'She suggested ___ the meeting until Friday, since several managers were still traveling.',
                'option_a' => 'to postpone', 'option_b' => 'postponing', 'option_c' => 'postpone', 'option_d' => 'postponed',
                'correct_option' => 'b', 'cefr_level' => 'B1',
            ],
            [
                'question_text' => '___ he studied harder, he would have passed the exam.',
                'option_a' => 'If', 'option_b' => 'Had', 'option_c' => 'Unless', 'option_d' => 'Should',
                'correct_option' => 'b', 'cefr_level' => 'B1',
            ],
            // B2 - harder
            [
                'question_text' => 'Not only ___ the report late, but she also forgot to attach the budget sheet.',
                'option_a' => 'she submitted', 'option_b' => 'did she submit', 'option_c' => 'she did submit', 'option_d' => 'submitted she',
                'correct_option' => 'b', 'cefr_level' => 'B2',
            ],
            [
                'question_text' => 'The committee insisted that the proposal ___ revised before the next vote.',
                'option_a' => 'is', 'option_b' => 'was', 'option_c' => 'be', 'option_d' => 'will be',
                'correct_option' => 'c', 'cefr_level' => 'B2',
            ],
            [
                'question_text' => 'Despite ___ warned repeatedly about the risks, the investors proceeded with the deal.',
                'option_a' => 'being', 'option_b' => 'to be', 'option_c' => 'be', 'option_d' => 'have been',
                'correct_option' => 'a', 'cefr_level' => 'B2',
            ],
            // C1 - advanced
            [
                'question_text' => 'Rarely ___ such a dramatic shift in consumer behavior within a single quarter.',
                'option_a' => 'we have witnessed', 'option_b' => 'have we witnessed', 'option_c' => 'we witnessed', 'option_d' => 'did we witnessed',
                'correct_option' => 'b', 'cefr_level' => 'C1',
            ],
            [
                'question_text' => 'The findings, ___ contradicted earlier assumptions, prompted the agency to revise its guidelines.',
                'option_a' => 'that', 'option_b' => 'what', 'option_c' => 'which', 'option_d' => 'whom',
                'correct_option' => 'c', 'cefr_level' => 'C1',
            ],
        ];

        foreach ($questions as $index => $q) {
            GrammarPlacementQuestion::create(array_merge($q, [
                'grammar_placement_package_id' => $package->id,
                'order' => $index + 1,
                'is_active' => true,
            ]));
        }

        Setting::updateOrCreate(
            ['key' => 'self_study_grammar_placement_package_id'],
            ['value' => (string) $package->id, 'type' => 'string']
        );

        $this->command?->info("Self-study grammar placement package seeded (id={$package->id}, ".count($questions).' questions).');
    }
}
