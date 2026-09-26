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
     * Scoring & Tier Mapping (20 questions = 5% per question):
     * - Q1–Q8   (A1–A2): Introductory Grammar for Writing (< 50% / 0–9 benar)
     * - Q9–Q12  (B1)   : Fast Track Grammar for Writing (50%–64% / 10–12 benar)
     * - Q13–Q16 (B2)   : Complexity Grammar for Writing (65%–79% / 13–15 benar)
     * - Q17–Q20 (C1–C2): Proficiency Grammar for Writing (80%–100% / 16–20 benar)
     */
    public function run(): void
    {
        $package = GrammarPlacementPackage::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Paket Standar',
                'description' => 'Tes penempatan kelas Grammar for Writing (Introductory, Fast Track, Complexity, & Proficiency).',
                'is_active' => true,
            ]
        );

        $questions = [
            // =====================================================================
            // TIER 1: INTRODUCTORY GRAMMAR FOR WRITING (A1 - A2)
            // Topics: Simple Present (Verbal/Nominal/Passive), Simple Past (Verbal/
            // Irregular/Passive), Pronouns, Present Continuous, Present Perfect,
            // Modals, Noun Phrase Order
            // =====================================================================
            [
                'order' => 1,
                'cefr_level' => 'A1',
                'question_text' => 'Most university students ___ classes on weekends, so they usually spend their time studying independently.',
                'option_a' => 'do not attend',
                'option_b' => 'does not attend',
                'option_c' => 'are not attend',
                'option_d' => 'not attend',
                'correct_option' => 'a',
            ],
            [
                'order' => 2,
                'cefr_level' => 'A1',
                'question_text' => 'Dr. Rahmat is very strict with ___ students, but he always helps ___ understand difficult concepts.',
                'option_a' => 'him / they',
                'option_b' => 'his / them',
                'option_c' => 'he / their',
                'option_d' => 'his / theirs',
                'correct_option' => 'b',
            ],
            [
                'order' => 3,
                'cefr_level' => 'A1',
                'question_text' => 'Last semester, our writing instructor ___ us how to organize an academic paragraph step by step.',
                'option_a' => 'teach',
                'option_b' => 'teaches',
                'option_c' => 'taught',
                'option_d' => 'was taught',
                'correct_option' => 'c',
            ],
            [
                'order' => 4,
                'cefr_level' => 'A2',
                'question_text' => 'The final research reports ___ by the academic committee before the graduation ceremony last Friday.',
                'option_a' => 'evaluated',
                'option_b' => 'are evaluated',
                'option_c' => 'was evaluated',
                'option_d' => 'were evaluated',
                'correct_option' => 'd',
            ],
            [
                'order' => 5,
                'cefr_level' => 'A2',
                'question_text' => 'Please use the stairs on the left because the main elevator ___ by the maintenance team right now.',
                'option_a' => 'is repairing',
                'option_b' => 'is being repaired',
                'option_c' => 'has repaired',
                'option_d' => 'was repaired',
                'correct_option' => 'b',
            ],
            [
                'order' => 6,
                'cefr_level' => 'A2',
                'question_text' => 'Public awareness of environmental issues ___ significantly since the government launched the green campaign in 2020.',
                'option_a' => 'has increased',
                'option_b' => 'have increased',
                'option_c' => 'increased',
                'option_d' => 'is increasing',
                'correct_option' => 'a',
            ],
            [
                'order' => 7,
                'cefr_level' => 'A2',
                'question_text' => 'All scholarship applicants ___ submit their recommendation letters before Friday; otherwise, their applications will be disqualified.',
                'option_a' => 'may',
                'option_b' => 'might',
                'option_c' => 'could',
                'option_d' => 'must',
                'correct_option' => 'd',
            ],
            [
                'order' => 8,
                'cefr_level' => 'A2',
                'question_text' => 'The university library recently purchased ___ to support students conducting historical research.',
                'option_a' => 'several reference valuable books',
                'option_b' => 'valuable several reference books',
                'option_c' => 'several valuable reference books',
                'option_d' => 'several books valuable reference',
                'correct_option' => 'c',
            ],

            // =====================================================================
            // TIER 2: FAST TRACK GRAMMAR FOR WRITING (B1)
            // Topics: To-Infinitive & Gerund, Cross-Tenses (Silang-silang 16 Tenses),
            // Preposition + Gerund, Comparative/Superlative/Positive Degree
            // =====================================================================
            [
                'order' => 9,
                'cefr_level' => 'B1',
                'question_text' => 'Many young professionals choose ___ an intensive English course in order to improve their career prospects abroad.',
                'option_a' => 'to take',
                'option_b' => 'taking',
                'option_c' => 'take',
                'option_d' => 'taken',
                'correct_option' => 'a',
            ],
            [
                'order' => 10,
                'cefr_level' => 'B1',
                'question_text' => 'By the time the chief editor arrived at the office this morning, the writers ___ the first draft of the report.',
                'option_a' => 'already completed',
                'option_b' => 'have already completed',
                'option_c' => 'had already completed',
                'option_d' => 'were already completing',
                'correct_option' => 'c',
            ],
            [
                'order' => 11,
                'cefr_level' => 'B1',
                'question_text' => 'In academic writing, researchers are responsible for ___ their sources accurately to avoid plagiarism.',
                'option_a' => 'cite',
                'option_b' => 'citing',
                'option_c' => 'to cite',
                'option_d' => 'cited',
                'correct_option' => 'b',
            ],
            [
                'order' => 12,
                'cefr_level' => 'B1',
                'question_text' => 'According to recent urban studies, public transportation in this metropolitan area has become ___ than it was a decade ago.',
                'option_a' => 'much efficienter',
                'option_b' => 'as efficient',
                'option_c' => 'the most efficient',
                'option_d' => 'far more efficient',
                'correct_option' => 'd',
            ],

            // =====================================================================
            // TIER 3: COMPLEXITY GRAMMAR FOR WRITING (B2)
            // Topics: Adverbial Clauses (Concession/Cause), Parallel Structures,
            // Adjective Clauses (RPS/RPO/RPP/RA), Noun Clauses
            // =====================================================================
            [
                'order' => 13,
                'cefr_level' => 'B2',
                'question_text' => '___ the initial clinical trial yielded promising results, the scientists decided to conduct further testing before publishing their findings.',
                'option_a' => 'Although',
                'option_b' => 'Despite',
                'option_c' => 'Because of',
                'option_d' => 'Nevertheless',
                'correct_option' => 'a',
            ],
            [
                'order' => 14,
                'cefr_level' => 'B2',
                'question_text' => 'Writing a strong argumentative essay requires not only gathering reliable evidence ___ counterarguments objectively.',
                'option_a' => 'and also analyze',
                'option_b' => 'but also analyzing',
                'option_c' => 'but also to analyze',
                'option_d' => 'but it also analyzes',
                'correct_option' => 'b',
            ],
            [
                'order' => 15,
                'cefr_level' => 'B2',
                'question_text' => 'The panel interviewed several startup founders ___ innovative business models had transformed the local economy.',
                'option_a' => 'who',
                'option_b' => 'whom',
                'option_c' => 'whose',
                'option_d' => 'which',
                'correct_option' => 'c',
            ],
            [
                'order' => 16,
                'cefr_level' => 'B2',
                'question_text' => 'The research team has not yet determined ___ the new policy will significantly reduce carbon emissions in industrial zones.',
                'option_a' => 'that if',
                'option_b' => 'what',
                'option_c' => 'why will',
                'option_d' => 'whether',
                'correct_option' => 'd',
            ],

            // =====================================================================
            // TIER 4: PROFICIENCY GRAMMAR FOR WRITING (C1 - C2)
            // Topics: Suffixes & Nominalization, Reducing Clauses (Participle
            // Clauses), Negative Inversion, Fronting, Cleft Sentences,
            // Emphatic Subjunctive & Inverted Conditionals
            // =====================================================================
            [
                'order' => 17,
                'cefr_level' => 'C1',
                'question_text' => 'The rapid ___ of artificial intelligence into modern healthcare has raised complex ethical questions regarding patient privacy.',
                'option_a' => 'integration',
                'option_b' => 'integrate',
                'option_c' => 'integrated',
                'option_d' => 'integrating',
                'correct_option' => 'a',
            ],
            [
                'order' => 18,
                'cefr_level' => 'C1',
                'question_text' => '___ by the sudden decline in global demand, the manufacturing company decided to restructure its entire supply chain.',
                'option_a' => 'Alarming',
                'option_b' => 'Having alarmed',
                'option_c' => 'Alarmed',
                'option_d' => 'To alarm',
                'correct_option' => 'c',
            ],
            [
                'order' => 19,
                'cefr_level' => 'C2',
                'question_text' => 'Only after the independent audit was completed ___ the full extent of the financial discrepancy.',
                'option_a' => 'the board realized',
                'option_b' => 'did the board realize',
                'option_c' => 'realized the board',
                'option_d' => 'the board did realize',
                'correct_option' => 'b',
            ],
            [
                'order' => 20,
                'cefr_level' => 'C2',
                'question_text' => '___ for the emergency funding provided by the central bank, several regional institutions would have collapsed during the crisis.',
                'option_a' => 'If it was not',
                'option_b' => 'Were it not',
                'option_c' => 'Should it not be',
                'option_d' => 'Had it not been',
                'correct_option' => 'd',
            ],
        ];

        DB::transaction(function () use ($package, $questions) {
            $keepIds = [];

            foreach ($questions as $index => $qData) {
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
