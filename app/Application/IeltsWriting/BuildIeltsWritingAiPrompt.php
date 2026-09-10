<?php

namespace App\Application\IeltsWriting;

class BuildIeltsWritingAiPrompt
{
    public function grading(string $essay, string $taskType, ?int $meetingId = null): string
    {
        $context = $this->gradingContext($taskType);
        $meetingContext = $this->resolveMeetingContext($meetingId);
        $wordCount = str_word_count(strip_tags($essay));
        $minWords = $taskType === '1' ? 150 : 250;
        $wordCountRule = $wordCount < $minWords
            ? "\n        WORD COUNT PENALTY (MANDATORY — OFFICIAL IELTS POLICY):\n        - This essay contains exactly {$wordCount} words. The required minimum for Task {$taskType} is {$minWords} words.\n        - This is UNDER-LENGTH by " . ($minWords - $wordCount) . " words.\n        - Per official IELTS policy, an under-length response is very unlikely to have fully developed its ideas. You MUST cap 'task_achievement' at 5.0 or lower, REGARDLESS of how well-written or well-argued the essay otherwise is. Do NOT give task_achievement above 5.0 under any circumstance for this essay.\n"
            : "\n        WORD COUNT CHECK: This essay contains {$wordCount} words, which meets the Task {$taskType} minimum of {$minWords} words. No length penalty applies.\n";

        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        {$meetingContext}
        {$wordCountRule}
        Rubric / Band Descriptors ( STRICTLY FOLLOW THESE ):
        {$context['band_descriptors']}

        {$context['role_instruction']}

        MENTAL STATE:
        - Anda BUKAN guru yang menyemangati murid. Anda adalah EXAMINER UJIAN RESMI.
        - Anda menghargai presisi. Esai yang pendek, repetitif, atau terlalu sederhana HARUS dihukum dengan skor rendah.
        - JANGAN PERNAH merasa \"kasihan\". Skor harus mencerminkan kenyataan. Band 5 adalah skor untuk level \"Modest User\" (banyak kesalahan, kalimat sederhana).
        - Esai dengan kalimat sederhana seperti \"It is good\" atau \"People like it\" ADALAH BAND 4 atau 5. JANGAN BERI 6.

        Constraint: Gunakan nada yang profesional, konstruktif, dan jujur. Jangan memberikan skor tinggi jika esai masih memiliki kesalahan dasar pada subject-verb agreement atau penggunaan cohesive devices yang mekanis (seperti pada kriteria Band 5 atau 6).

        COMMON CRITICAL SCORING RULES:
        1. SENTENCE COMPLEXITY (GRA):
           - If the essay relies mostly on simple sentence structures (e.g., \"Online learning is good. It is easy.\"), the Grammatical Range & Accuracy (GRA) score CANNOT exceed Band 5.0.
           - Do NOT give high scores just for being \"understandable\" if the structure is too simple.
        2. VOCABULARY (LR):
           - If the vocabulary is basic (e.g., \"good\", \"bad\", \"thing\", \"people\"), the Lexical Resource score CANNOT exceed Band 5.0.
        
        {$context['critical_rules']}

        Perform the following tasks:
        1. Grade the essay (Band 1-9) for each rubric and overall based on the above Constraints.
        
        Provide a strictly JSON response with this structure:
        {
            \"scores\": {
                \"task_achievement\": 0.0,
                \"coherence_cohesion\": 0.0,
                \"lexical_resource\": 0.0,
                \"grammatical_range\": 0.0,
                \"overall_band\": 0.0
            }
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON. Ensure all double quotes inside strings are strictly escaped.
        CRITICAL: The example scores above are placeholders (0.0). You MUST generate ACTUAL scores (1.0 - 9.0) based on the essay quality.
        {$context['reminder']}
        - Simple sentences only? -> GRA Max 5.0
        - Basic vocabulary? -> LR Max 5.0";
    }

    public function feedback(string $essay, string $taskType, ?int $meetingId = null): string
    {
        $context = $this->feedbackContext($taskType);
        $meetingContext = $this->resolveMeetingContext($meetingId);

        return "You are a Senior IELTS Writing Examiner. You are experienced, objective, and constructive. Analyze the following IELTS Writing Task {$taskType} essay.
        
        Original Essay:
        \"{$essay}\"

        {$meetingContext}

        {$context['tone']}
        2.  **Band 6+ Context**: If the essay is competent (Band 6.0+), ACKNOWLEDGE the strengths.
        3.  **Band 4-5 Context**: If the essay has frequent errors, be direct.
        4.  **Consistency**: Ensure feedback matches the quality.

        Perform the following tasks:
        1. Provide detailed feedback for each rubric in **Bahasa Indonesia**.
           - The 'feedback' content MUST be in Indonesian.
           - Use the word 'kandidat' instead of 'calon'.
           {$context['score_criteria']}
           - **Overall**: Summarize performance. If Band 6+, be positive but point out the gap to Band 7.
           - The 'feedback' content MUST be in Indonesian.
           - **CRITICAL**: The feedback for EACH category MUST be concise, bulleted, and direct (max 3 bullet points).
           - For 'grammar_improvements', identify AS MANY specific grammatical errors or weak sentences from the essay AS POSSIBLE (maximum 20). Provide the original text, the corrected version, and a brief explanation in Indonesian.
           - For 'cohesive_devices_used', list the linking words and cohesive devices that the candidate ACTUALLY used in the essay. Evaluate if they are overused or used correctly (in Indonesian).
           - For 'good_vocabulary_used', list up to 5 advanced or topic-specific words/collocations the candidate ACTUALLY used in the essay, along with their meaning in Indonesian.
           - For 'vocabulary_improvements', identify AS MANY specific basic or repetitive words used by the candidate AS POSSIBLE (at least 15 to 20 items). Suggest Band 7-9 alternatives, with an explanation in Indonesian.
           - For 'overall_comment', write a comprehensive examiner-style summary of AT LEAST 6-8 sentences across 2 short paragraphs (do NOT write just 1-2 sentences).
             * Paragraph 1: State the overall band level and WHY, then briefly comment on the candidate's performance in EACH of the four criteria (Task Response, Coherence & Cohesion, Lexical Resource, Grammatical Range & Accuracy), citing at least one specific observation or example from the essay for each.
             * Paragraph 2: Close with 2-3 concrete, actionable suggestions the candidate should focus on to reach the next band.
             * Write it as a flowing narrative in Indonesian, not a bullet list, and do not simply repeat the other feedback fields verbatim — synthesize them into a coherent overview.

        
        Provide a strictly JSON response with this structure:
        {
            \"feedback\": {
                \"task_achievement\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"coherence_cohesion\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"lexical_resource\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"grammatical_range\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"cohesive_devices_used\": [
                    {
                        \"word\": \"linking word used\",
                        \"evaluation\": \"brief evaluation in Indonesian (e.g. 'Tepat', 'Terlalu sering', 'Kurang natural')\"
                    }
                ],
                \"good_vocabulary_used\": [
                    {
                        \"word\": \"advanced word/collocation\",
                        \"meaning\": \"Indonesian meaning\"
                    }
                ],
                \"vocabulary_improvements\": [
                    {
                        \"text\": \"basic word used\",
                        \"improved\": \"Band 7-9 alternative\",
                        \"explanation\": \"Why it's better (in Indonesian)\"
                    }
                ],
                \"grammar_improvements\": [
                    {
                        \"text\": \"original weak/incorrect sentence\",
                        \"improved\": \"better/corrected sentence\",
                        \"explanation\": \"Explanation of grammar error/improvement (in Indonesian)\"
                    }
                ],
                \"overall_comment\": \"... (Comprehensive Indonesian summary, at least 6-8 sentences across 2 paragraphs, covering all 4 criteria with specific examples plus actionable next-step suggestions)\"
            }
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON. Ensure all double quotes inside strings are strictly escaped.";
    }

    public function correction(string $essay, string $taskType): string
    {
        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.
        
        Original Essay:
        \"{$essay}\"

        Perform the following tasks:
        1. Create a 'correction_html' version of the FULL essay (keep text in English).
           - You MUST return the EXACT original essay text content, paragraph by paragraph.
           - Do NOT summarize, shorten, or truncate the text. If the essay is long, correct all of it.
           - Apply the following MARKDOWN tags to the text:
             * Wrap errors in {RED}error{/RED}
             * Wrap corrections in {GREEN}correction{/GREEN}
             * Wrap suggestions/improvements in {YELLOW}suggestion{/YELLOW}
           - Use <p> tags for each paragraph.
           - CRITICAL: The output MUST contain the full length of the original essay.

        Provide a strictly JSON response with this structure:
        {
            \"correction_html\": \"<p>Full text with highlights...</p>\"
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    public function vocabulary(string $essay, string $taskType): string
    {
        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        Perform the following task:
        1. Identify SPECIFIC Lexical Resource issues (Vocabulary & Collocations).
           - Create a list of 'lexical_improvements'. You MUST provide AT LEAST 15 to 20 items. Identify simple or repetitive words/phrases/collocations in the essay, or simple but correct words if needed, and upgrade them to advanced (Band 7-9) vocabulary.
           - Identify simple words or weak collocations used in the essay.
           - Provide higher-level (Band 7-9) synonyms or collocations.
           - Explain why the improvement is better in Bahasa Indonesia.
        
        2. Provide a list of 'topic_vocabularies': CEFR C1-level (IELTS Band 7-8) words/phrases and collocations that match the SPECIFIC TOPIC of this essay.
           - These should be words/phrases the candidate *could have used* in THIS essay to boost their score — genuinely usable for this specific topic, not generic advanced vocabulary.
           - You MUST include AT LEAST 15 items.
           - 'meaning' MUST be in Bahasa Indonesia.

        Provide a strictly JSON response with this structure:
        {
            \"lexical_improvements\": [
                {
                    \"text\": \"original weak word/phrase\",
                    \"improved\": \"better vocabulary/collocation\",
                    \"explanation\": \"Why this is better (in Indonesian)\"
                }
            ],
            \"topic_vocabularies\": [
                {
                    \"term\": \"advanced term/collocation\",
                    \"meaning\": \"Meaning in Indonesian\",
                    \"example\": \"English example sentence relevant to this topic\"
                }
            ]
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    public function coherence(string $essay, string $taskType): string
    {
        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        Perform the following task:
        Identify SPECIFIC Coherence & Cohesion issues related to Conjunctions/Linking Words.
        - Create a list of 'coherence_improvements'. You MUST provide EXACTLY 10 items. If there are fewer than 10 missing/bad cohesive devices, pick existing simple linking words and upgrade them to Band 7-9 alternatives.
        - Find linking words preventing a higher band or suggest where they are missing.
        - Provide better, high-level alternatives (Band 7-9 style).
        - Explain why the improvement is better in Bahasa Indonesia.

        Provide a strictly JSON response with this structure:
        {
            \"coherence_improvements\": [
                {
                    \"text\": \"original linking word/phrase\",
                    \"improved\": \"better linking word/phrase\",
                    \"explanation\": \"Why this improves coherence (in Indonesian)\"
                }
            ]
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    public function taskResponse(string $essay, string $taskType): string
    {
        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        Perform the following task:
        Identify SPECIFIC Task Response / Task Achievement issues.
        - Create a list of 'task_response_improvements'. You MUST provide AT LEAST 5 items and AT MOST 10 items — this is a strict requirement, never fewer than 5. If the essay has fewer than 5 major issues, break your analysis down further: examine EACH body paragraph and the introduction/conclusion separately for weak topic sentences, missing examples, underdeveloped explanations, or restated-not-analyzed ideas, and provide a Band 7-9 improved version for each. Do NOT stop at 3-4 items.
        - Identify arguments that are underdeveloped, unclear, or lack supporting examples.
        - Identify if the writer's position is unclear or not maintained.
        - Provide a concrete 'improved' version of the argument or paragraph (Band 7-9 style).
        - Explain why the improvement better addresses the prompt (in Bahasa Indonesia).
        - For 'steps', provide a step-by-step list (3-5 short, concrete, actionable steps in Bahasa Indonesia) explaining HOW the candidate should revise the original text to reach the improved version — not just WHAT changed, but the concrete editing steps to get there.
        - IMPORTANT: If the 'text' field describes a MISSING element (e.g. 'Thesis statement is missing'), write that description in **Bahasa Indonesia** (e.g. 'Esai ini tidak memiliki pernyataan tesis'). If it is a quote, keep it in English.

        Provide a strictly JSON response with this structure:
        {
            \"task_response_improvements\": [
                {
                    \"text\": \"original weak argument/paragraph\",
                    \"improved\": \"better argument/paragraph (fully developed)\",
                    \"explanation\": \"Why this improves Task Response (in Indonesian)\",
                    \"steps\": [\"Step 1 in Indonesian\", \"Step 2 in Indonesian\", \"Step 3 in Indonesian\"]
                }
            ]
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    public function grammar(string $essay, string $taskType): string
    {
        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        Perform the following task:
        1. Identify SPECIFIC Grammatical Structure issues.
           - Create a list of 'grammar_improvements'. You MUST provide EXACTLY 10 items.
           - If the essay has fewer than 10 grammatical errors, pick correct but simple sentences and suggest a more advanced 'better_structure' (e.g., using passive voice, complex sentence, conditional, inversion) to increase the band score.
           - Provide the 'improved' sentence.
           - Explain the specific grammar rule or structure used in the improvement (in Bahasa Indonesia).

        2. Provide a list of 'topic_grammar' (Advanced Structures) relevant to this essay's topic.
           - Generate 4 specific examples using the essay's topic for:
             a. Adjective Clause
             b. Noun Clause
             c. Gerund as Subject
             d. Adverbial Clause (Level Advanced)
           - 'example' must be a sentence using the structure about the essay topic.
           - 'explanation' in Bahasa Indonesia.

        Provide a strictly JSON response with this structure:
        {
            \"grammar_improvements\": [
                {
                    \"text\": \"original weak sentence\",
                    \"improved\": \"better structured sentence\",
                    \"explanation\": \"Explanation of grammar (e.g. Passive Voice, Inversion) (in Indonesian)\"
                }
            ],
            \"topic_grammar\": [
                {
                    \"type\": \"Adjective Clause\",
                    \"example\": \"Advanced sentence example...\",
                    \"explanation\": \"Brief explanation in Indonesian\"
                }
            ]
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    public function improve(string $essay, string $taskType): string
    {
        return "You are an expert IELTS Tutor. Review the following IELTS Writing Task {$taskType} essay.

        Original Essay:
        \"{$essay}\"

        Perform the following tasks:
        1. Write a 'better_version' of the essay that scores a perfect Band 9. It should be sophisticated but natural (English).
        - CRITICAL: Do NOT use actual newlines inside strings. You MUST wrap EVERY single paragraph with <p class=\"mb-4\"> and </p> tags to ensure proper spacing between paragraphs.

        Provide a strictly JSON response with this structure:
        {
            \"better_version\": \"<p class=\\\"mb-4\\\">Full Band 9 example essay paragraph 1...</p><p class=\\\"mb-4\\\">Paragraph 2...</p>\"
        }

        Do NOT output markdown code blocks. Output ONLY raw JSON.";
    }

    private function gradingContext(string $taskType): array
    {
        if ($taskType === '1') {
            return [
                'band_descriptors' => "
            BAND 9:
            - TA: Fully satisfies all the requirements of the task. Clearly presents a fully developed response.
            - CC: Uses cohesion in such a way that it attracts no attention. Skillfully manages paragraphing.
            - LR: Wide range of vocabulary, very natural. Rare minor errors.
            - GRA: Wide range of structures with full flexibility. Rare minor errors.

            BAND 8:
            - TA: Covers all requirements of the task sufficiently. Presents, highlights and illustrates key features/bullet points clearly and appropriately.
            - CC: Sequences information and ideas logically. Manages all aspects of cohesion well.
            - LR: Fluent and flexible uses of vocabulary. Occasional inaccuracies allowed.
            - GRA: Wide range of structures. Majority of sentences are error-free. Occasional errors allowed.

            BAND 7:
            - TA: Covers the requirements of the task. Presents a clear overview of main trends, differences or stages.
            - CC: Logically organises information and ideas. Clear progression. Range of cohesive devices.
            - LR: Sufficient range of vocabulary. Some awareness of style/collocation. Occasional errors in word choice.
            - GRA: Uses a variety of complex structures. Produces frequent error-free sentences. Good control of grammar/punctuation.

            BAND 6:
            - TA: Addresses the requirements of the task. Presents an overview with information appropriately selected.
            - CC: Arranges information coherently. Progression is clear. Cohesion within/between sentences may be faulty/mechanical.
            - LR: Adequate range for the task. Attempts less common vocabulary with some inaccuracy.
            - GRA: Mix of simple and complex sentence forms. Errors in grammar/punctuation occur but rarely reduce communication.

            BAND 5:
            - TA: Generally addresses the task; the format may be inappropriate in places. Recounts detail mechanically with no clear overview.
            - CC: Presents information with some organization but lack of progression. Inadequate/inaccurate use of cohesive devices.
            - LR: Limited range of vocabulary. Noticeable errors in spelling/word formation.
            - GRA: Limited range of structures. Attempts complex sentences but they are less accurate than simple sentences.

            BAND 4:
            - TA: Attempts to address the task but does not cover all key features/bullet points; the format may be inappropriate.
            - CC: Presents information but not arranged coherently. Basic cohesive devices used inaccurately.
            - LR: Basic vocabulary used repetitively.
            - GRA: Very limited range of structures. Subordinate clauses rare. Errors predominate.

            BAND 3:
            - TA: Fails to address the task, which may have been completely misunderstood.
            - CC: Does not organize ideas logically. Very limited cohesive devices.
            - LR: Very limited range of words/expressions. Errors severely distort meaning.
            - GRA: Attempts sentence forms but errors predominate and distort meaning.
            ",
                'role_instruction' => "Role: Bertindaklah sebagai Senior IELTS Writing Examiner yang sangat berpengalaman, OBJEKTIF, dan TEGAS (RUTHLESS). Tugas Anda adalah menilai laporan IELTS Writing Task 1 berdasarkan standar resmi \"IELTS Writing Task 1 Band Descriptors (Public Version)\".
            
            Instructions: Lakukan analisis mendalam terhadap laporan yang diberikan berdasarkan empat kriteria utama:
            - Task Achievement (TA): Sejauh mana laporan memenuhi persyaratan tugas, memberikan gambaran umum (overview) yang jelas tentang tren/perbedaan/tahapan utama, dan menyajikan poin-poin kunci secara jelas.
            - Coherence and Cohesion (CC): Logika pengaturan informasi, penggunaan kata penghubung (cohesive devices), dan efektivitas penggunaan paragraf.
            - Lexical Resource (LR): Variasi kosakata, ketepatan penggunaan kata (collocation), dan akurasi ejaan/pembentukan kata.
            - Grammatical Range and Accuracy (GRA): Variasi struktur kalimat (simple vs complex) dan tingkat kesalahan tata bahasa serta tanda baca.
            ",
                'critical_rules' => "
            CRITICAL SCORING RULES (Task 1 — Official IELTS Academic Task 1 assessment criteria):
            1. WORD COUNT PENALTY (Task Achievement):
               - If the report is UNDER 150 words, Task Achievement (TA) MUST be capped at Band 5.0 or lower, regardless of quality.
            2. OVERVIEW REQUIREMENT (Task Achievement):
               - The report MUST contain a clear, STANDALONE overview — typically a short paragraph after the introduction — that summarises the single most significant overall trend, feature, stage, or change, WITHOUT citing specific numbers or data points (the overview should be free of detailed figures; those belong in the body paragraphs).
               - If the overview is missing entirely, or is really just a restatement of one data point rather than a genuine summary, TA CANNOT exceed Band 5.0.
               - If the 'overview' only lists every category one by one instead of identifying the main pattern, that is NOT a genuine overview — score TA no higher than Band 5.0-6.0.
            3. DATA ACCURACY (Task Achievement) — only apply if SOURCE CHART DATA or SOURCE VISUAL context is provided above:
               - You MUST verify the essay's reported figures, trends, and stages against that real source data/visual.
               - If the essay describes a DIFFERENT topic than the source data/visual entirely (wrong subject matter), or fabricates figures/trends that contradict the real data, this is a severe failure to address the task — TA CANNOT exceed Band 2.0-3.0.
               - If the essay's numbers are mostly accurate but a few specific figures are wrong or imprecise, apply a smaller penalty instead (cap TA around Band 6.0), not a severe one.
            4. COMPARISONS REQUIREMENT (Task Achievement):
               - The task instruction requires the candidate to 'make comparisons where relevant'. If the chart/table has multiple categories, datasets, or time periods and the essay makes NO comparisons between them (only lists figures individually with no comparative language), penalize TA (cap around Band 5.0-6.0).
            5. TASK-TYPE-SPECIFIC OVERVIEW EXPECTATIONS:
               - Line/bar/pie/table/mixed data charts: the overview should state the overall trend or most striking feature(s), not restate every number.
               - Process diagrams/flowcharts: the overview should state how many main stages there are and where the process starts/ends, not describe every single step in detail.
               - Maps (before/after or two-period comparisons): the overview should state the most significant overall changes, not describe every location individually.
            6. STRICT BAND CEILINGS (STRICT CAMBRIDGE EXAMINER STANDARDS - DO NOT GIVE BAND 7-8 TO AVERAGE ESSAYS):
               - Band 8.0+ TA requires a sophisticated overview, key trends clearly synthesized, and thorough, highly accurate comparisons. If the candidate merely lists data sequentially year-by-year without high-level synthesis, TA CANNOT exceed 6.5.
               - Band 7.0+ Lexical Resource requires precise academic vocabulary and varied trend verbs/collocations (e.g., 'fluctuated', 'surged', 'plateaued', 'eclipsed'). If the essay relies on repetitive basic verbs ('went up', 'increased', 'showed', 'rose', 'high', 'low'), LR CANNOT exceed Band 6.0.
               - Band 7.0+ Grammatical Range & Accuracy requires frequent error-free complex structures (e.g., reduced relative clauses, passive voice, complex prepositional phrases). If the essay uses mostly simple/compound sentences, GRA CANNOT exceed Band 6.0.
               - Band 7.0+ Coherence & Cohesion requires varied and subtle cohesive devices. If linking words ('however', 'while', 'overall', 'meanwhile') are overused or used mechanically, CC CANNOT exceed Band 6.0.
            ",
                'reminder' => "
            REMINDER:
            - Report < 150 words? -> TA Max 5.0
            - No standalone overview (or overview is just a data restatement / a list of every category)? -> TA Max 5.0-6.0
            - Essay describes a different topic than the real chart, or fabricates data? -> TA Max 2.0-3.0
            - Minor figure inaccuracies only? -> TA Max 6.0
            - No comparisons made despite multiple categories/datasets? -> TA capped around 5.0-6.0
            - Basic vocabulary or repetitive sentence structures? -> LR/GRA capped at Band 6.0 max. BE STRICT & UNCOMPROMISING like an official Cambridge examiner!
            ",
            ];
        }

        return [
            'band_descriptors' => "
            BAND 9:
            - TR: Fully addresses all parts of the task. Fully developed position.
            - CC: Uses cohesion in such a way that it attracts no attention. Skillfully manages paragraphing.
            - LR: Wide range of vocabulary, very natural. Rare minor errors.
            - GRA: Wide range of structures with full flexibility. Rare minor errors.

            BAND 8:
            - TR: Sufficiently addresses all parts. Well-developed response.
            - CC: Sequences information and ideas logically. Manages all aspects of cohesion well.
            - LR: Fluent and flexible uses of vocabulary. Occasional inaccuracies allowed.
            - GRA: Wide range of structures. Majority of sentences are error-free. Occasional errors allowed.

            BAND 7:
            - TR: Addresses all parts of the task. Clear position throughout. Main ideas extended and supported.
            - CC: Logically organises information and ideas. Clear progression. Range of cohesive devices.
            - LR: Sufficient range of vocabulary. Some awareness of style/collocation. Occasional errors in word choice.
            - GRA: Uses a variety of complex structures. Produces frequent error-free sentences. Good control of grammar/punctuation.

            BAND 6:
            - TR: Addresses all parts (some more fully than others). Relevant position but conclusions may be unclear.
            - CC: Arranges information coherently. Progression is clear. Cohesion within/between sentences may be faulty/mechanical.
            - LR: Adequate range for the task. Attempts less common vocabulary with some inaccuracy.
            - GRA: Mix of simple and complex sentence forms. Errors in grammar/punctuation occur but rarely reduce communication.

            BAND 5:
            - TR: Addresses the task only partially. Position may be unclear. Main ideas limited/not sufficiently developed.
            - CC: Presents information with some organization but lack of progression. Inadequate/inaccurate use of cohesive devices.
            - LR: Limited range of vocabulary. Noticeable errors in spelling/word formation.
            - GRA: Limited range of structures. Attempts complex sentences but they are less accurate than simple sentences.

            BAND 4:
            - TR: Responds to task only in minimal way. format may be inappropriate.
            - CC: Presents information but not arranged coherently. Basic cohesive devices used inaccurately.
            - LR: Basic vocabulary used repetitively.
            - GRA: Very limited range of structures. Subordinate clauses rare. Errors predominate.

            BAND 3:
            - TR: Does not adequately address any part of the task.
            - CC: Does not organize ideas logically. Very limited cohesive devices.
            - LR: Very limited range of words/expressions. Errors severely distort meaning.
            - GRA: Attempts sentence forms but errors predominate and distort meaning.
            ",
            'role_instruction' => "Role: Bertindaklah sebagai Senior IELTS Writing Examiner yang sangat berpengalaman, OBJEKTIF, dan TEGAS (RUTHLESS). Tugas Anda adalah menilai esai IELTS Writing Task 2 berdasarkan standar resmi \"IELTS Writing Task 2 Band Descriptors (Public Version)\".
            
            Instructions: Lakukan analisis mendalam terhadap esai yang diberikan berdasarkan empat kriteria utama:
            - Task Response (TR): Sejauh mana esai menjawab seluruh bagian soal, kejelasan posisi/argumen, dan pengembangan ide.
            - Coherence and Cohesion (CC): Logika pengaturan informasi, penggunaan kata penghubung (cohesive devices), dan efektivitas penggunaan paragraf.
            - Lexical Resource (LR): Variasi kosakata, ketepatan penggunaan kata (collocation), dan akurasi ejaan/pembentukan kata.
            - Grammatical Range and Accuracy (GRA): Variasi struktur kalimat (simple vs complex) dan tingkat kesalahan tata bahasa serta tanda baca.
            ",
            'critical_rules' => "
            CRITICAL SCORING RULES (Task 2):
            1. WORD COUNT PENALTY (Task Response):
               - If the essay is UNDER 250 words, the Task Response (TR) score MUST be penalized.
               - TR cannot exceed Band 5.0 if the essay is significantly underlength.
            ",
            'reminder' => "
            REMINDER:
            - Essay < 250 words? -> TR Max 5.0
            ",
        ];
    }

    private function feedbackContext(string $taskType): array
    {
        if ($taskType === '1') {
            return [
                'score_criteria' => "
            - **Task Achievement**: Evaluate how well the prompt is addressed (Overview, Data features, Comparisons).
              **CRITICAL**: IF the report is under 150 words, you MUST explicitly state: \"Jumlah kata di bawah 150 kata (Hanya [X] kata). Ini mengurangi skor Task Achievement secara signifikan.\" inside the Task Achievement feedback.
              **CRITICAL**: IF there is no clear, standalone overview (free of specific numbers), explicitly state it — a list of every category one by one is NOT an overview.
              **CRITICAL**: IF SOURCE CHART DATA or SOURCE VISUAL context was provided above, explicitly state in Indonesian whether the essay's reported figures/trends/stages actually match the real data — call out any invented numbers, wrong topic, or contradicted trends.
              **CRITICAL**: IF the chart/table has multiple categories or datasets but the essay makes no comparisons between them, explicitly note this as a missed requirement (the task asks to 'make comparisons where relevant').
            - **Coherence**: Evaluate paragraphing and linking.
            - **Lexical**: Evaluate vocabulary range and accuracy.
            - **Grammar**: Evaluate sentence structures and error density.
             ",
                'tone' => "
             TONE & APPROACH (Task 1 Report):
             1. **Objective & Factual**: Comment on the accuracy of data reporting against the real source data, not just writing quality.
             2. **Band 6+**: Acknowledge if the overview is clear and data-accurate.
             ",
            ];
        }

        return [
            'score_criteria' => "
            - **Task Achievement**: Evaluate how well the prompt is addressed. 
              **CRITICAL**: IF the essay is under 250 words, you MUST explicitly state: \"Jumlah kata di bawah 250 kata (Hanya [X] kata). Ini mengurangi skor Task Response secara signifikan.\" inside the Task Achievement feedback.
            - **Coherence**: Evaluate paragraphing and linking.
            - **Lexical**: Evaluate vocabulary range and accuracy.
            - **Grammar**: Evaluate sentence structures and error density.
             ",
            'tone' => "
             TONE & APPROACH (Task 2 Essay):
             1. **Professional & Constructive**: Helpful, not discouraging.
             ",
        ];
    }

    private function resolveMeetingContext(?int $meetingId): string
    {
        if (!$meetingId) {
            return '';
        }

        $meeting = \App\Models\IeltsWritingMeeting::find($meetingId);
        if (!$meeting) {
            $meeting = \App\Models\IeltsWritingMeeting::where('meeting_number', $meetingId)->first();
        }

        if (!$meeting) {
            return '';
        }

        $text = "\nQUESTION & PROMPT CONTEXT:\nTitle: {$meeting->title}\nQuestion Prompt: " . strip_tags($meeting->prompt);
        if (!empty($meeting->graph_data_json)) {
            $text .= "\nGraph/Chart Data JSON: {$meeting->graph_data_json}";
        }

        $text .= $this->formatChartContext($meeting);

        return $text . "\n";
    }

    /**
     * IELTS Writing Task 1 requires describing a specific chart/graph/table/
     * diagram/map. Without this, the grading/feedback prompts only see the
     * essay text and the generic instruction ("Summarise the information..."),
     * with no way to judge whether the essay's numbers/trends/steps actually
     * match the source visual — Task Achievement can't genuinely be assessed.
     * This resolves the actual underlying chart data (line/bar/pie/table/mixed)
     * or diagram description (flowchart/map) and inlines it as text so every
     * prompt can check the essay against the real source data.
     */
    private function formatChartContext($meeting): string
    {
        if (!class_exists(\App\Support\IeltsTask1ChartResolver::class)) {
            return '';
        }

        $chart = \App\Support\IeltsTask1ChartResolver::resolve($meeting);
        $kind = $chart['kind'] ?? 'none';

        if ($kind === 'none') {
            return '';
        }

        if (in_array($kind, ['flowchart', 'map'], true)) {
            if (empty($chart['instructionTitle'])) {
                return '';
            }
            $label = $kind === 'flowchart' ? ($chart['instructionType'] ?? 'process diagram') : 'map/plan';
            return "\nSOURCE VISUAL ({$label}): This Task 1 item asks the candidate to describe {$chart['instructionTitle']}. Judge Task Achievement based on whether the essay's described stages/changes are plausible and well-organised for this specific topic.\n";
        }

        // Data-driven chart kinds (line/bar/pie/table/mixed): inline the actual
        // underlying numbers so the AI can verify the essay's claims against them.
        $json = json_encode($chart, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if (!$json) {
            return '';
        }

        return "\nSOURCE CHART DATA (kind: {$kind}) — this is the ACTUAL underlying data of the chart the candidate was asked to describe. Use it to verify whether the essay accurately reports the real figures, trends, and comparisons, and penalize Task Achievement if the essay invents numbers or describes trends that contradict this data:\n{$json}\n";
    }
}