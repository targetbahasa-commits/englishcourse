<?php

namespace Database\Seeders;

use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrammarPlacementQuestionSeeder extends Seeder
{
    /**
     * Seed the Grammar for Writing Placement Test questions (Package 1).
     *
     * 10 Questions with vocabulary and grammar progressing from A1 to C1:
     * - 0–4 benar (0%–40%, A1–A2) : Introductory Grammar for Writing
     * - 5–6 benar (50%–60%, B1)   : Fast Track Grammar for Writing
     * - 7 benar   (70%, B2)       : Complexity Grammar for Writing
     * - 8–10 benar (80%–100%, C1+): Proficiency Grammar for Writing
     */
    public function run(): void
    {
        $package = GrammarPlacementPackage::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Paket Standar',
                'description' => 'Tes penempatan kelas Grammar for Writing (10 soal, level A1–C1).',
                'is_active' => true,
            ]
        );

        $questions = [
            // =====================================================================
            // LEVEL A1–A2: INTRODUCTORY GRAMMAR FOR WRITING (Kosakata A1–A2)
            // =====================================================================
            [
                'order' => 1,
                'cefr_level' => 'A1',
                'question_text' => 'My brother ___ at the office on Sundays, so he usually stays at home with his family.',
                'option_a' => 'does not work',
                'option_b' => 'do not work',
                'option_c' => 'is not work',
                'option_d' => 'not works',
                'correct_option' => 'a',
            ],
            [
                'order' => 2,
                'cefr_level' => 'A1',
                'question_text' => 'Sarah is a kind teacher. ___ students really like her because she always helps ___ in class.',
                'option_a' => 'She / they',
                'option_b' => 'Her / them',
                'option_c' => 'Hers / their',
                'option_d' => 'Her / they',
                'correct_option' => 'b',
            ],
            [
                'order' => 3,
                'cefr_level' => 'A2',
                'question_text' => 'This delicious chocolate cake ___ by my mother for my sister\'s birthday party last night.',
                'option_a' => 'made',
                'option_b' => 'is made',
                'option_c' => 'was made',
                'option_d' => 'were made',
                'correct_option' => 'c',
            ],
            [
                'order' => 4,
                'cefr_level' => 'A2',
                'question_text' => 'Rina and her family ___ in this city since they moved here in 2021.',
                'option_a' => 'lived',
                'option_b' => 'has lived',
                'option_c' => 'are living',
                'option_d' => 'have lived',
                'correct_option' => 'd',
            ],

            // =====================================================================
            // LEVEL B1: FAST TRACK GRAMMAR FOR WRITING (Kosakata B1)
            // =====================================================================
            [
                'order' => 5,
                'cefr_level' => 'B1',
                'question_text' => 'After thinking about his budget, Kevin decided ___ some money to buy a new laptop next month.',
                'option_a' => 'to save',
                'option_b' => 'saving',
                'option_c' => 'save',
                'option_d' => 'saved',
                'correct_option' => 'a',
            ],
            [
                'order' => 6,
                'cefr_level' => 'B1',
                'question_text' => 'When we arrived at the station this morning, the train ___ for Jakarta.',
                'option_a' => 'already left',
                'option_b' => 'has already left',
                'option_c' => 'had already left',
                'option_d' => 'is already leaving',
                'correct_option' => 'c',
            ],

            // =====================================================================
            // LEVEL B2: COMPLEXITY GRAMMAR FOR WRITING (Kosakata B2)
            // =====================================================================
            [
                'order' => 7,
                'cefr_level' => 'B2',
                'question_text' => '___ it rained heavily all afternoon, the outdoor concert continued as scheduled.',
                'option_a' => 'Despite',
                'option_b' => 'Although',
                'option_c' => 'Because of',
                'option_d' => 'However',
                'correct_option' => 'b',
            ],
            [
                'order' => 8,
                'cefr_level' => 'B2',
                'question_text' => 'The company only interviews candidates ___ work experience matches the job requirements.',
                'option_a' => 'who',
                'option_b' => 'whom',
                'option_c' => 'which',
                'option_d' => 'whose',
                'correct_option' => 'd',
            ],

            // =====================================================================
            // LEVEL C1: PROFICIENCY GRAMMAR FOR WRITING (Kosakata C1)
            // =====================================================================
            [
                'order' => 9,
                'cefr_level' => 'C1',
                'question_text' => '___ by the positive feedback from readers, the young author decided to write a second novel.',
                'option_a' => 'Encouraged',
                'option_b' => 'Encouraging',
                'option_c' => 'Having encourage',
                'option_d' => 'To encourage',
                'correct_option' => 'a',
            ],
            [
                'order' => 10,
                'cefr_level' => 'C1',
                'question_text' => 'Not only ___ the project ahead of schedule, but she also helped her colleagues finish their tasks.',
                'option_a' => 'she completed',
                'option_b' => 'completed she',
                'option_c' => 'did she complete',
                'option_d' => 'she did complete',
                'correct_option' => 'c',
            ],
        ];

        DB::transaction(function () use ($package, $questions) {
            $keepIds = [];

            foreach ($questions as $qData) {
                $existing = GrammarPlacementQuestion::where('grammar_placement_package_id', $package->id)
                    ->where('order', $qData['order'])
                    ->first();

                if ($existing) {
                    $existing->update(array_merge($qData, [
                        'grammar_placement_package_id' => $package->id,
                        'is_active' => true,
                    ]));
                    $keepIds[] = $existing->id;
                } else {
                    $created = GrammarPlacementQuestion::create(array_merge($qData, [
                        'grammar_placement_package_id' => $package->id,
                        'is_active' => true,
                    ]));
                    $keepIds[] = $created->id;
                }
            }

            GrammarPlacementQuestion::where('grammar_placement_package_id', $package->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
        });
    }
}
