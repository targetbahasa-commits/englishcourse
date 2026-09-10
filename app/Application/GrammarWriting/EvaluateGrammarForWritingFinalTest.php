<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarForWritingFinalTest
{
    use ScoresWordMatchAnswers;

    /**
     * Evaluates the 3-paragraph Grammar for Writing Final Test.
     *
     * @param array $paragraphAnswers Array of student answers: [1 => string, 2 => string, 3 => string]
     * @param array $testData The test data array containing paragraphs, vocab, and targets
     * @return array Comprehensive evaluation result
     */
    public function evaluate(array $paragraphAnswers, array $testData): array
    {
        $p1User = trim((string) ($paragraphAnswers[1] ?? ($paragraphAnswers['1'] ?? '')));
        $p2User = trim((string) ($paragraphAnswers[2] ?? ($paragraphAnswers['2'] ?? '')));
        $p3User = trim((string) ($paragraphAnswers[3] ?? ($paragraphAnswers['3'] ?? '')));

        $fullUserTranslation = implode("\n\n", array_filter([$p1User, $p2User, $p3User]));
        $fullModelTranslation = (string) ($testData['full_text_en'] ?? '');

        // 1. Evaluate individual paragraphs
        $paragraphMaxScores = [1 => 33, 2 => 33, 3 => 34];
        $scoredParagraphs = [];
        $totalParagraphScore = 0;

        foreach ($testData['paragraphs'] as $pNum => $pMeta) {
            $userAns = match ($pNum) {
                1 => $p1User,
                2 => $p2User,
                3 => $p3User,
                default => ''
            };

            $maxScore = $paragraphMaxScores[$pNum] ?? 33;
            $modelEn = (string) ($pMeta['text_en'] ?? '');
            $vocabList = $pMeta['vocab'] ?? [];

            // A. Word Match & Diff
            $wordMatch = $this->scoreWordMatchAnswer($userAns, $modelEn, $maxScore);

            // B. Paragraph Grammar Targets Check
            $grammarCheck = $this->checkParagraphGrammarTargets($pNum, $userAns, $pMeta);

            // C. Vocabulary Usage Check
            $vocabCheck = $this->checkVocabularyUsage($userAns, $vocabList);

            // D. Weighted Paragraph Score:
            // 40% Word match accuracy, 35% Grammar targets hit, 25% Academic vocabulary
            if (empty(trim($userAns))) {
                $weightedScore = 0;
            } else {
                $rawScore = ($wordMatch['score'] * 0.40)
                    + (($grammarCheck['score'] / 100) * $maxScore * 0.35)
                    + (($vocabCheck['score'] / 100) * $maxScore * 0.25);
                $weightedScore = min($maxScore, max(0, (int) round($rawScore)));
            }

            $totalParagraphScore += $weightedScore;

            $scoredParagraphs[$pNum] = [
                'id' => $pNum,
                'title' => $pMeta['title'] ?? 'Paragraf ' . $pNum,
                'focus' => $pMeta['focus'] ?? '',
                'text_id' => $pMeta['text_id'] ?? '',
                'text_en' => $modelEn,
                'user_answer' => $userAns,
                'score' => $weightedScore,
                'max_score' => $maxScore,
                'formatted_answer' => $wordMatch['formatted_answer'],
                'grammar_targets' => $grammarCheck['targets'],
                'grammar_summary' => $grammarCheck['summary'],
                'vocab_found' => $vocabCheck['found'],
                'vocab_missing' => $vocabCheck['missing'],
                'vocab_coverage_percent' => $vocabCheck['score'],
            ];
        }

        // 2. Comprehensive 10-Module Diagnostic
        $moduleDiagnostics = $this->diagnoseAllTenModules($p1User, $p2User, $p3User, $testData);

        // 3. Multi-Criterion Rubric Scoring (Total: 100)
        // Criterion 1: Grammar & Structural Complexity (40 pts)
        $grammarScore = min(40, max(0, (int) round(($moduleDiagnostics['mastered_count'] / 10) * 40)));
        
        // Criterion 2: Lexical Resource & Academic Register (30 pts)
        $allVocab = $testData['combined_vocab'] ?? [];
        $totalVocabCheck = $this->checkVocabularyUsage($fullUserTranslation, $allVocab);
        $lexicalScore = min(30, max(0, (int) round(($totalVocabCheck['score'] / 100) * 30)));

        // Criterion 3: Translation Accuracy & Faithfulness (30 pts)
        $wholeDiff = $this->scoreWordMatchAnswer($fullUserTranslation, $fullModelTranslation, 30);
        $accuracyScore = min(30, max(0, (int) $wholeDiff['score']));

        // Final Aggregate Score
        $overallScore = min(100, max(0, $grammarScore + $lexicalScore + $accuracyScore));
        if ($totalParagraphScore > 0 && abs($overallScore - $totalParagraphScore) > 10) {
            $overallScore = (int) round(($overallScore + $totalParagraphScore) / 2);
        }

        // 4. CEFR Level & Predicate Determination
        $cefrData = $this->determineCefrAndPredicate($overallScore);

        // 5. Qualitative Feedback & Strengths / Improvements
        $feedbackSummary = $this->generateQualitativeFeedback($moduleDiagnostics, $totalVocabCheck, $overallScore);

        return [
            'type' => 'full_essay_translation',
            'summary_badge' => $testData['summary_badge'] ?? 'Summary 10 Pertemuan',
            'score' => $overallScore,
            'max_score' => 100,
            'cefr_level' => $cefrData['cefr'],
            'predicate' => $cefrData['predicate'],
            'ielts_equivalent' => $cefrData['ielts_equivalent'],
            'passed' => $overallScore >= 70,
            'criteria' => [
                'grammar_complexity' => [
                    'label' => 'Grammar & Structural Mastery (10 Modul)',
                    'score' => $grammarScore,
                    'max_score' => 40,
                    'percentage' => round(($grammarScore / 40) * 100),
                ],
                'lexical_resource' => [
                    'label' => 'Lexical Resource & Academic Keywords',
                    'score' => $lexicalScore,
                    'max_score' => 30,
                    'percentage' => round(($lexicalScore / 30) * 100),
                ],
                'translation_accuracy' => [
                    'label' => 'Translation Fidelity & Completeness',
                    'score' => $accuracyScore,
                    'max_score' => 30,
                    'percentage' => round(($accuracyScore / 30) * 100),
                ],
            ],
            'module_diagnostics' => $moduleDiagnostics['modules'],
            'mastered_modules_count' => $moduleDiagnostics['mastered_count'],
            'review_modules_count' => 10 - $moduleDiagnostics['mastered_count'],
            'full_text_id' => $testData['full_text_id'] ?? '',
            'full_text_en' => $fullModelTranslation,
            'user_translation' => $fullUserTranslation,
            'formatted_answer' => $wholeDiff['formatted_answer'],
            'paragraphs' => $scoredParagraphs,
            'feedback' => $feedbackSummary,
        ];
    }

    /**
     * Check grammar targets for a specific paragraph.
     */
    protected function checkParagraphGrammarTargets(int $pNum, string $text, array $pMeta = []): array
    {
        $targets = [];
        $pointsEarned = 0;
        $totalWeight = 0;

        if (!empty($pMeta['grammar_targets']) && is_array($pMeta['grammar_targets'])) {
            $checks = $pMeta['grammar_targets'];
        } elseif ($pNum === 1) {
            // P1: Inversion (Rarely has...), Adverbial Clause (Although...), Present Perfect, Modal (must)
            $checks = [
                [
                    'name' => 'Negative Inversion (Rarely has / have / did)',
                    'pattern' => '/\b(rarely|scarcely|seldom|barely)\s+(has|have|had|do|does|did|is|are)\b/i',
                    'hint' => 'Contoh target: "Rarely has the international community confronted..."',
                    'weight' => 35
                ],
                [
                    'name' => 'Initial Adverbial Clause (Although / While / Even though)',
                    'pattern' => '/^(although|while|even though|though)\s+[a-z\s]+,/i',
                    'hint' => 'Contoh target: "Although modern industrialization has driven...,"',
                    'weight' => 25
                ],
                [
                    'name' => 'Present Perfect & Passive Voice',
                    'pattern' => '/\b(has|have)\s+(driven|triggered|confronted|allocated|transformed|reduced|[a-z]+ed)\b|\b(can|must|is|are)\s+be\s+([a-z]+ed|reduced)\b/i',
                    'hint' => 'Contoh target: "has driven", "has triggered", "can be significantly reduced"',
                    'weight' => 20
                ],
                [
                    'name' => 'Adjective Clause RPS (that / which requires)',
                    'pattern' => '/\b(that|which)\s+(requires|demands|necessitates|triggers)\b/i',
                    'hint' => 'Contoh target: "...an existential threat that requires urgent decarbonization."',
                    'weight' => 20
                ]
            ];
        } elseif ($pNum === 2) {
            // P2: Double Comparative (The more... the more...), Gerund (By utilizing...), RPP (whose), Noun Clause (That CRISPR... is...)
            $checks = [
                [
                    'name' => 'Double Comparative (The more... the more...)',
                    'pattern' => '/\bthe\s+(more|less|greater|faster|higher)\b.*,\s*the\s+(more|less|greater|profound|deeper)\b/i',
                    'hint' => 'Contoh target: "The more sophisticated... become, the more profound their influence..."',
                    'weight' => 35
                ],
                [
                    'name' => 'Noun Clause as Subject (That [Subject + Verb] is...)',
                    'pattern' => '/^that\s+[a-z\s]+\s+(is|represents|remains)\b/i',
                    'hint' => 'Contoh target: "That CRISPR-based genetic engineering offers... is the most..."',
                    'weight' => 25
                ],
                [
                    'name' => 'Adjective Clause - RPP (whose + noun)',
                    'pattern' => '/\bwhose\s+[a-z]+\s+(are|is|were|was|have|has)\b/i',
                    'hint' => 'Contoh target: "...researchers whose laboratories are equipped with..."',
                    'weight' => 20
                ],
                [
                    'name' => 'Preposition + Gerund & Infinitive of Purpose',
                    'pattern' => '/\b(by|in)\s+([a-z]+ing)\b|\b(in order to|to)\s+(predict|prevent|reduce)\b/i',
                    'hint' => 'Contoh target: "By utilizing advanced...", "in order to prevent..."',
                    'weight' => 20
                ]
            ];
        } else {
            // P3: Negative Inversion (Not only... but also), Middle Adverbial Clause, RA (why), Prepositional Phrase
            $checks = [
                [
                    'name' => 'Negative Inversion (Not only do/does... but [also])',
                    'pattern' => '/\bnot only\s+(do|does|did|are|is|can)\b.*\bbut\s+(also)?\b/i',
                    'hint' => 'Contoh target: "Not only do external debt burdens constrain..., but global interest rate..."',
                    'weight' => 35
                ],
                [
                    'name' => 'Middle Adverbial Clause (, while / when...,)',
                    'pattern' => '/[a-z]+,\s*(while|when|although)\s+[a-z\s]+,\s*[a-z]+/i',
                    'hint' => 'Contoh target: "Multilateral institutions, while designing assistance packages, must ascertain..."',
                    'weight' => 25
                ],
                [
                    'name' => 'Relative Adverb (explaining why...) & Noun Clause (whether...)',
                    'pattern' => '/\b(explaining|reason)\s+why\b|\b(ascertain|determine|ensure)\s+whether\b/i',
                    'hint' => 'Contoh target: "...explaining why economic recovery can endure...", "whether mechanisms align..."',
                    'weight' => 20
                ],
                [
                    'name' => 'Advanced Prepositional Phrases',
                    'pattern' => '/^(in|during|under)\s+[a-z\s]+,|\bbetween\s+[a-z\s]+and\s+[a-z]+/i',
                    'hint' => 'Contoh target: "In the dynamic post-pandemic economic landscape,", "between banking institutions and monetary authorities"',
                    'weight' => 20
                ]
            ];
        }

        foreach ($checks as $chk) {
            $totalWeight += $chk['weight'];
            $matched = (bool) preg_match($chk['pattern'], $text);
            if ($matched) {
                $pointsEarned += $chk['weight'];
            }
            $targets[] = [
                'name' => $chk['name'],
                'matched' => $matched,
                'hint' => $chk['hint']
            ];
        }

        $percentage = $totalWeight > 0 ? (int) round(($pointsEarned / $totalWeight) * 100) : 0;

        return [
            'score' => $percentage,
            'targets' => $targets,
            'summary' => $pointsEarned . '/' . $totalWeight . ' poin struktur terdeteksi (' . $percentage . '%)'
        ];
    }

    /**
     * Check which academic vocabulary words were utilized.
     */
    protected function checkVocabularyUsage(string $text, array $vocabList): array
    {
        if (empty($vocabList) || empty(trim($text))) {
            return ['score' => 0, 'found' => [], 'missing' => array_keys($vocabList)];
        }

        $normalizedText = strtolower($text);
        $found = [];
        $missing = [];

        foreach ($vocabList as $enWord => $meta) {
            $cleanEn = strtolower(trim($enWord));
            $words = preg_split('/\s+/', $cleanEn, -1, PREG_SPLIT_NO_EMPTY);
            $allFound = true;
            foreach ($words as $w) {
                $stem = rtrim($w, 'sedingly');
                if (strlen($stem) > 3) {
                    if (!str_contains($normalizedText, $stem)) {
                        $allFound = false;
                        break;
                    }
                } else {
                    if (!str_contains($normalizedText, $w)) {
                        $allFound = false;
                        break;
                    }
                }
            }

            if ($allFound) {
                $found[] = $enWord;
            } else {
                $missing[] = $enWord;
            }
        }

        $totalCount = count($vocabList);
        $foundCount = count($found);
        $score = $totalCount > 0 ? (int) round(($foundCount / $totalCount) * 100) : 0;

        return [
            'score' => $score,
            'found' => $found,
            'missing' => $missing,
        ];
    }

    /**
     * Diagnose each of the grammar modules for this track.
     */
    protected function diagnoseAllTenModules(string $p1, string $p2, string $p3, array $testData = []): array
    {
        $allText = $p1 . ' ' . $p2 . ' ' . $p3;

        if (!empty($testData['modules_covered']) && is_array($testData['modules_covered'])) {
            $modules = [];
            foreach ($testData['modules_covered'] as $m) {
                $num = $m['num'] ?? (count($modules) + 1);
                $modules[$num] = [
                    'tag' => $m['tag'] ?? ('M' . $num),
                    'name' => $m['name'] ?? 'Grammar Module ' . $num,
                    'regex' => $m['regex'] ?? '/\b[a-z]{3,}\b/i',
                    'description' => $m['description'] ?? '',
                ];
            }
        } else {
            $modules = [
                1 => [
                    'tag' => 'M1/M2',
                    'name' => 'Tenses & Aspect (Present Perfect)',
                    'regex' => '/\b(has|have)\s+([a-z]+ed|driven|triggered|confronted|become|offered)\b/i',
                    'description' => 'Penggunaan Present Perfect tense secara presisi untuk aksi yang dampaknya berlanjut.',
                ],
            2 => [
                'tag' => 'M2',
                'name' => 'Passive Voice Konstruksi Formal',
                'regex' => '/\b(is|are|was|were|be|been)\s+([a-z]+ed|equipped|reduced|applied|recognized)\b/i',
                'description' => 'Penggunaan kalimat pasif akademik (can be reduced, are equipped with).',
            ],
            3 => [
                'tag' => 'M3',
                'name' => 'Modal Verbs (Necessity & Potential)',
                'regex' => '/\b(must|should|could|might|may)\s+[a-z]+/i',
                'description' => 'Modal auxiliary verbs (must allocate, must transform, could trigger).',
            ],
            4 => [
                'tag' => 'M4',
                'name' => 'Negative Inversion (Rarely / Not Only... But)',
                'regex' => '/\b(rarely|seldom|scarcely)\s+(has|have|had|do|did)\b|\bnot only\s+(do|does|did|are|is)\b/i',
                'description' => 'Inversi pola kalimat untuk penekanan formal tingkat tinggi (C1-C2).',
            ],
            5 => [
                'tag' => 'M5',
                'name' => 'Gerund & Infinitive of Purpose',
                'regex' => '/\b(by|in)\s+([a-z]+ing)\b|\b(in order to|to)\s+(predict|prevent|accelerate)\b/i',
                'description' => 'Preposisi diikuti gerund (by utilizing) dan infinitive tujuan (in order to prevent).',
            ],
            6 => [
                'tag' => 'M6',
                'name' => 'Double Comparative (The more..., the more...)',
                'regex' => '/\bthe\s+(more|less|greater|higher)\b.*,\s*the\s+(more|less|greater|profound)\b/i',
                'description' => 'Struktur perbandingan korelatif ganda untuk korelasi dinamis.',
            ],
            7 => [
                'tag' => 'M7',
                'name' => 'Adverbial Clauses (3 Posisi & FANBOYS)',
                'regex' => '/^(although|while|even though)\b|,\s*(while|when|although)\s+[a-z\s]+,|\bso that\b/i',
                'description' => 'Klausa adverbia di posisi awal, tengah, dan akhir (Although, while designing, so that).',
            ],
            8 => [
                'tag' => 'M8',
                'name' => 'Adjective Clause (RPS & RPO)',
                'regex' => '/\b(that|which)\s+(requires|offers|leads|triggers|demands)\b|\bwhere\s+[a-z]+/i',
                'description' => 'Klausa relatif subjek dan objek (that requires urgent decarbonization).',
            ],
            9 => [
                'tag' => 'M9',
                'name' => 'Adjective Clause (RPP whose & RA why)',
                'regex' => '/\bwhose\s+[a-z]+\s+(are|is|were)\b|\bwhy\s+[a-z]+/i',
                'description' => 'Kepemilikan whose (whose laboratories) dan keterangan alasan why (why recovery can endure).',
            ],
            10 => [
                'tag' => 'M10',
                'name' => 'Noun Clause & Prepositional Phrases',
                'regex' => '/^that\s+[a-z\s]+\s+is\b|\bwhether\s+[a-z]+|\bin the dynamic|\bbetween\s+[a-z\s]+and\b/i',
                'description' => 'Noun clause sebagai subjek (That CRISPR... is) dan frasa preposisi pembuka.',
            ],
        ];
        }

        $masteredCount = 0;
        $diagnosed = [];

        foreach ($modules as $num => $m) {
            $matched = (bool) preg_match($m['regex'], $allText);
            if ($matched) {
                $masteredCount++;
            }
            $diagnosed[$num] = array_merge($m, [
                'num' => $num,
                'status' => $matched ? 'Mastered' : 'Needs Review',
                'matched' => $matched,
            ]);
        }

        return [
            'modules' => $diagnosed,
            'mastered_count' => $masteredCount,
        ];
    }

    /**
     * Determine CEFR Level and Predicate based on score.
     */
    protected function determineCefrAndPredicate(int $score): array
    {
        if ($score >= 90) {
            return [
                'cefr' => 'C2 Mastery',
                'predicate' => 'High Distinction (Sangat Memuaskan)',
                'ielts_equivalent' => 'IELTS Band 7.5 - 8.5',
            ];
        } elseif ($score >= 80) {
            return [
                'cefr' => 'C1 Advanced',
                'predicate' => 'Distinction (Memuaskan)',
                'ielts_equivalent' => 'IELTS Band 7.0',
            ];
        } elseif ($score >= 70) {
            return [
                'cefr' => 'B2+ Upper-Intermediate',
                'predicate' => 'Merit Pass (Lulus Baik)',
                'ielts_equivalent' => 'IELTS Band 6.0 - 6.5',
            ];
        } elseif ($score >= 60) {
            return [
                'cefr' => 'B1 - B2 Intermediate',
                'predicate' => 'Pass (Lulus Standar)',
                'ielts_equivalent' => 'IELTS Band 5.5',
            ];
        } else {
            return [
                'cefr' => 'A2 - B1 Developing',
                'predicate' => 'Review Needed (Perlu Penguatan Modul)',
                'ielts_equivalent' => 'IELTS Band < 5.5',
            ];
        }
    }

    /**
     * Generate qualitative feedback notes based on evaluation.
     */
    protected function generateQualitativeFeedback(array $modules, array $vocabCheck, int $score): array
    {
        $masteredModules = array_filter($modules['modules'], fn($m) => $m['matched']);
        $unmasteredModules = array_filter($modules['modules'], fn($m) => !$m['matched']);

        $strengths = [];
        foreach (array_slice($masteredModules, 0, 4) as $m) {
            $strengths[] = 'Penguasaan struktur ' . $m['name'] . ' sudah terlihat jelas dalam susunan kalimat Anda.';
        }
        if (empty($strengths)) {
            $strengths[] = 'Mampu menyusun kalimat terjemahan dasar dengan alur kalimat yang dapat dipahami.';
        }

        $improvements = [];
        foreach (array_slice($unmasteredModules, 0, 4) as $m) {
            $improvements[] = 'Perkuat kembali struktur ' . $m['name'] . ' (' . $m['description'] . ').';
        }
        if (empty($improvements)) {
            $improvements[] = 'Pertahankan konsistensi akurasi tanda baca dan variasi register kosakata formal.';
        }

        return [
            'overview' => $score >= 70
                ? 'Selamat! Hasil pengerjaan Final Test Anda menunjukkan penguasaan yang solid terhadap materi Grammar for Writing (Fast-Track 10 Pertemuan). Struktur kalimat kompleks berhasil diterapkan dengan baik.'
                : 'Pengerjaan Final Test Anda telah terekam. Meskipun beberapa konsep dasar telah dipahami, Anda disarankan mengulang latihan pada modul-modul yang membutuhkan penguatan struktur kalimat.',
            'strengths' => $strengths,
            'improvements' => $improvements,
            'vocab_summary' => 'Menemukan ' . count($vocabCheck['found']) . ' dari ' . (count($vocabCheck['found']) + count($vocabCheck['missing'])) . ' istilah kosakata target (' . $vocabCheck['score'] . '% coverage).',
        ];
    }
}
