<?php

namespace App\Application\IeltsWriting;

class BuildIeltsWritingAiPrompt
{
    public function grading(string $essay, string $taskType): string
    {
        $context = $this->gradingContext($taskType);

        return "You are a strict IELTS Examiner. Analyze the following IELTS Writing Task {$taskType} essay.
        
        Original Essay:
        \"{$essay}\"

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

    public function feedback(string $essay, string $taskType): string
    {
        $context = $this->feedbackContext($taskType);

        return "You are a Senior IELTS Writing Examiner. You are experienced, objective, and constructive. Analyze the following IELTS Writing Task {$taskType} essay.
        
        Original Essay:
        \"{$essay}\"

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
           - For 'overall_comment', provide a brief summary of the candidate's performance.

        
        Provide a strictly JSON response with this structure:
        {
            \"feedback\": {
                \"task_achievement\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"coherence_cohesion\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"lexical_resource\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"grammatical_range\": \"... (Concise Indonesian feedback, max 3 bullet points)\",
                \"overall_comment\": \"... (Brief Indonesian summary)\"
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
           - Create a list of 'lexical_improvements'.
           - Identify simple words or weak collocations used in the essay.
           - Provide higher-level (Band 7-9) synonyms or collocations.
           - Explain why the improvement is better in Bahasa Indonesia.
        
        2. Provide a list of 'topic_vocabularies' (Band 8/9) that matches the SPECIFIC TOPIC of this essay.
           - These should be words/phrases the candidate *could have used* to boost their score.
           - Include 6 items.
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
        - Create a list of 'coherence_improvements'.
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
        - Create a list of 'task_response_improvements'.
        - Identify arguments that are underdeveloped, unclear, or lack supporting examples.
        - Identify if the writer's position is unclear or not maintained.
        - Provide a concrete 'improved' version of the argument or paragraph (Band 7-9 style).
        - Explain why the improvement better addresses the prompt (in Bahasa Indonesia).
        - IMPORTANT: If the 'text' field describes a MISSING element (e.g. 'Thesis statement is missing'), write that description in **Bahasa Indonesia** (e.g. 'Esai ini tidak memiliki pernyataan tesis'). If it is a quote, keep it in English.

        Provide a strictly JSON response with this structure:
        {
            \"task_response_improvements\": [
                {
                    \"text\": \"original weak argument/paragraph\",
                    \"improved\": \"better argument/paragraph (fully developed)\",
                    \"explanation\": \"Why this improves Task Response (in Indonesian)\"
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
           - Create a list of 'grammar_improvements'.
           - Identify sentences that are too simple, repetitive, or grammatically weak.
           - Suggest a 'better_structure' (e.g., using passive voice, complex sentence, conditional, inversion) to increase the band score.
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
        - CRITICAL: Do NOT use actual newlines inside strings. Use '\\n' for line breaks.

        Provide a strictly JSON response with this structure:
        {
            \"better_version\": \"Full Band 9 example essay...\"
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
            CRITICAL SCORING RULES (Task 1):
            1. WORD COUNT PENALTY (Task Achievement):
               - If the report is UNDER 150 words, the Task Achievement (TA) score MUST be penalized.
               - TA cannot exceed Band 5.0 if the report is significantly underlength.
            2. NO OVERVIEW (Task Achievement):
               - If there is NO clear overview of main trends, differences, or stages, Task Achievement cannot exceed Band 5.0.
            ",
                'reminder' => "
            REMINDER:
            - Report < 150 words? -> TA Max 5.0
            - No Overview? -> TA Max 5.0
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
              **CRITICAL**: IF no Clear Overview, explicitly state it.
            - **Coherence**: Evaluate paragraphing and linking.
            - **Lexical**: Evaluate vocabulary range and accuracy.
            - **Grammar**: Evaluate sentence structures and error density.
             ",
                'tone' => "
             TONE & APPROACH (Task 1 Report):
             1. **Objective & Factual**: Comment on the accuracy of data reporting.
             2. **Band 6+**: Acknowledge if the overview is clear.
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
}