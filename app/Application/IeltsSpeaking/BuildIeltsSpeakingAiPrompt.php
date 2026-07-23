<?php

namespace App\Application\IeltsSpeaking;

class BuildIeltsSpeakingAiPrompt
{
    public function grading(string $transcriptText, int $part = 1, string $topicTitle = ''): string
    {
        $context = $this->gradingContext();
        $partContext = $this->partContext($part, $topicTitle);

        return "You are a strict IELTS Speaking Examiner. Analyze the following IELTS Speaking {$partContext['label']} transcript.

        Topic: \"{$topicTitle}\"
        
        {$partContext['description']}
        
        Transcript:
        \"{$transcriptText}\"

        Rubric / Band Descriptors (STRICTLY FOLLOW THESE):
        {$context['band_descriptors']}

        {$context['role_instruction']}
    
        MENTAL STATE:
        - You evaluate the transcript text objectively as an official examiner.
        - Because you cannot hear the audio, evaluate Pronunciation and Fluency based on textual clues (e.g., filler words like 'uh', 'um', repetitions, self-corrections if present, sentence complexity, and overall conversational flow).
        - Provide scores that reflect reality. If the answers are very short or use basic vocabulary, the score MUST be low (Band 4.0 - 5.0).
        - Band 6.0 is for candidates who are willing to speak at length but may make mistakes. Band 7.0 requires some idiomatic language and frequent error-free complex sentences.

        {$partContext['scoring_notes']}

        COMMON CRITICAL SCORING RULES:
        1. SHORT ANSWERS: If the answers are extremely short (e.g., 'Yes, I do. It is fun.') the Fluency and Lexical Resource CANNOT exceed Band 5.0.
        2. BASIC VOCABULARY: If the vocabulary is basic ('good', 'bad', 'happy', 'sad', 'thing'), Lexical Resource CANNOT exceed Band 5.0.
        3. PRONUNCIATION / FLUENCY via TEXT: Assume a candidate who gives very short, simple, broken sentences with repetition likely struggles with fluency.

        Perform the following tasks:
        1. Grade the transcript (Band 1.0 - 9.0) for each rubric and overall based on the Constraints.
        2. Provide constructive feedback in Bahasa Indonesia. Use 'kandidat' or 'Anda'. Max 3 short bullet points per category.
        
        Provide a strictly JSON response with this structure:
        {
          \"overall_score\": 0.0,
          \"categories\": {
            \"fluency_coherence\": {
              \"score\": 0.0,
              \"feedback\": \"... (Concise Indonesian feedback)\",
              \"details\": [
                { \"question\": \"Avoid silence or hesitation?\", \"description\": \"...\" },
                { \"question\": \"Speak at length on each topic?\", \"description\": \"...\" },
                { \"question\": \"Use words to connect ideas?\", \"description\": \"...\" }
              ]
            },
            \"lexical_resource\": {
              \"score\": 0.0,
              \"feedback\": \"... (Concise Indonesian feedback)\",
              \"details\": [
                { \"question\": \"Use a wide range of vocabulary?\", \"description\": \"...\" },
                { \"question\": \"Use idioms and collocation?\", \"description\": \"...\" },
                { \"question\": \"Paraphrase?\", \"description\": \"...\" }
              ]
            },
            \"grammatical_range\": {
              \"score\": 0.0,
              \"feedback\": \"... (Concise Indonesian feedback)\",
              \"details\": [
                { \"question\": \"Speak in complex sentences?\", \"description\": \"...\" },
                { \"question\": \"Use a variety of grammatical forms?\", \"description\": \"...\" },
                { \"question\": \"Avoid grammatical mistakes?\", \"description\": \"...\" }
              ]
            },
            \"pronunciation\": {
              \"score\": 0.0,
              \"feedback\": \"... (Concise Indonesian feedback)\",
              \"details\": [
                { \"question\": \"Pronounce words accurately?\", \"description\": \"...\" },
                { \"question\": \"Join sounds together?\", \"description\": \"...\" },
                { \"question\": \"Vary intonation?\", \"description\": \"...\" }
              ]
            }
          },
          \"general_feedback\": \"... (Brief Indonesian summary of performance)\"
        }

        Important: For the 'description' fields inside 'details', provide highly detailed, objective feedback in English or Bahasa Indonesia based exactly on the candidate's answers, similar to an official examiner's report. Include specific examples from the transcript if possible.
        Do NOT output markdown code blocks. Output ONLY raw JSON. Ensure all double quotes inside strings are strictly escaped.
        CRITICAL: The example scores above are placeholders (0.0). You MUST generate ACTUAL scores (1.0 - 9.0) based on the candidate's answers.";
    }

    private function gradingContext(): array
    {
        return [
            'band_descriptors' => "
            BAND 9:
            - FC: Fluent with only rare repetition or self-correction. Speech is appropriately extended.
            - LR: Total flexibility and precise use in all contexts. Idiomatic language used naturally.
            - GRA: Full range of structures used naturally and accurately.
            - PR: (Inferred) Conversational flow is flawless and easily understood.

            BAND 8:
            - FC: Fluent with occasional repetition or hesitation (content-related). Coherent topic development.
            - LR: Wide vocabulary. Skillful use of uncommon/idiomatic items. Occasional inaccuracies.
            - GRA: Wide range of structures flexibly used. Most sentences are error-free.
            - PR: (Inferred) Wide range of features, easily understood throughout.

            BAND 7:
            - FC: Speaks at length without noticeable effort. Some hesitation or self-correction.
            - LR: Discusses a variety of topics flexibly. Uses some less common idiomatic items.
            - GRA: Range of complex structures with some flexibility. Frequent error-free sentences.
            - PR: (Inferred) Generally easily understood, some positive features of Band 8.

            BAND 6:
            - FC: Willing to speak at length. Coherence may sometimes be lost due to repetition/hesitation. Uses discourse markers but not always appropriately.
            - LR: Sufficient vocabulary to discuss topics at length. Meaning is generally clear.
            - GRA: Mix of simple and complex structures. Frequent errors in complex structures but rarely impede communication.
            - PR: (Inferred) Can generally be understood without much effort.

            BAND 5:
            - FC: Maintains flow but relies on repetition, self-correction, or slow speech. Overuses certain connectives.
            - LR: Manages to talk about familiar/unfamiliar topics but flexibility is limited.
            - GRA: Basic sentences fairly accurate. Complex sentences attempted but often faulty.
            - PR: (Inferred) Pronunciation features are limited, causing some strain.

            BAND 4:
            - FC: Noticeable pauses. Slow speech with frequent repetition. Links simple sentences but repetitively.
            - LR: Able to talk about familiar topics but only basic meaning on unfamiliar topics.
            - GRA: Basic sentence forms attempted. Subordinate clauses are rare. Errors are frequent.
            - PR: (Inferred) Frequent mispronunciations, requiring effort to understand.

            BAND 3:
            - FC: Long pauses. Limited ability to link simple sentences.
            - LR: Simple vocabulary for personal info only.
            - GRA: Numerous grammatical errors in basic forms.
            - PR: (Inferred) Often unintelligible.
            ",
            'role_instruction' => "Role: Bertindaklah sebagai Senior IELTS Speaking Examiner yang sangat berpengalaman, OBJEKTIF, dan TEGAS. Tugas Anda adalah menilai simulasi IELTS Speaking test berdasarkan \"IELTS Speaking Band Descriptors (Public Version)\".
            
            Instructions:
            - FC (Fluency & Coherence): Seberapa lancar, nyambung, dan ekstensif jawaban kandidat.
            - LR (Lexical Resource): Seberapa bervariasi dan canggih kosakata (termasuk idiom/kolokasi) yang digunakan.
            - GRA (Grammatical Range & Accuracy): Seberapa akurat dan kompleks struktur kalimat kandidat.
            - PR (Pronunciation): Nilai kefasihan berdasarkan tulisan (ketiadaan kata-kata terbata-bata/filler, struktur yang mendukung intonasi alami).
            "
        ];
    }

    private function partContext(int $part, string $topicTitle): array
    {
        if ($part === 1) {
            return [
                'label'         => 'Part 1 (Introduction & Interview)',
                'description'   => 'In IELTS Speaking Part 1, the examiner asks about familiar, everyday topics (home, family, studies, work, hobbies). Answers are expected to be 2–4 sentences each, showing natural conversational ability. The candidate should NOT ramble excessively, but should extend answers beyond one-word or one-sentence responses.',
                'scoring_notes' => 'PART 1 SCORING NOTES: Expect shorter answers (2-4 sentences). If answers are too short (1 sentence), penalize Fluency. If answers are too long and off-topic, note it but do not heavily penalize. Focus on naturalness and range of vocabulary for everyday topics.',
            ];
        }

        if ($part === 2) {
            return [
                'label'         => 'Part 2 (Long Turn / Individual Long Turn)',
                'description'   => 'In IELTS Speaking Part 2, the candidate speaks for 1-2 minutes on a given topic (cue card). They must address all bullet points on the cue card. The response MUST be a long, sustained monologue. Scoring is strict: a short response (e.g. under 150 words) is a major fluency failure.',
                'scoring_notes' => 'PART 2 SCORING NOTES: A response shorter than approximately 150 words indicates the candidate FAILED to speak for the required 1-2 minutes. This MUST result in a Fluency score no higher than Band 5.0. Evaluate how well all cue card points are addressed in the topic development.',
            ];
        }

        if ($part === 3) {
            return [
                'label'         => 'Part 3 (Discussion)',
                'description'   => 'In IELTS Speaking Part 3, the examiner asks abstract, opinion-based questions related to the Part 2 topic. Candidates are expected to discuss ideas, compare viewpoints, speculate, and justify opinions. Answers should be substantive (4-6+ sentences), showing the ability to reason and use sophisticated language.',
                'scoring_notes' => 'PART 3 SCORING NOTES: This is the hardest part. Expect complex, analytical answers. A candidate who only gives basic opinions without explanation (e.g. "I think it is good because it helps people.") cannot exceed Band 5.5 in Fluency or Lexical Resource. Look for discourse markers, hedging language, and abstract vocabulary.',
            ];
        }

        return [
            'label'         => 'Speaking Test',
            'description'   => 'General IELTS Speaking practice.',
            'scoring_notes' => '',
        ];
    }

    public function modelAnswers(array $transcripts): string
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Question " . ($index + 1) . ":\n" . ($t['question'] ?? 'Unknown') . "\n\n";
        }

        return "You are an expert IELTS Speaking instructor. Based on the following IELTS Speaking questions, generate a perfect Band 9 model answer for each question.
        
        Questions:
        {$transcriptText}
        
        Guidelines for your answers:
        - The answers must sound natural and spoken (not like a formal essay), using natural conversational connectors.
        - Demonstrate a wide range of advanced vocabulary, idioms, and collocations (Band 8-9 level).
        - For Part 1 questions (everyday topics), write 3-5 sentences.
        - For Part 2 questions (cue cards starting with 'Describe a... You should say...'), write a full 1-2 minute long monologue (approx 180-250 words). Address all bullet points seamlessly.
        - For Part 3 questions (abstract topics), write 5-8 sentences with complex reasoning, speculation, or comparison.
        
        Output strictly in JSON format:
        {
          \"model_answers\": [
             {
                \"question\": \"(Copy the exact question here)\",
                \"answer\": \"(Your Band 9 model answer text)\",
                \"highlight\": \"Band 9 Vocabulary: <strong>word1, word2, idiomatic phrase</strong>\"
             }
          ]
        }
        
        Do not output markdown formatting like ```json. Output ONLY raw JSON.";
    }

    public function fluencyAnalysis(array $transcripts): string
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Question " . ($index + 1) . ":\n" . ($t['question'] ?? 'Unknown') . "\n";
            $transcriptText .= "Answer " . ($index + 1) . ":\n" . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        return "You are an expert IELTS Speaking examiner analyzing a candidate's transcript for Fluency and Coherence.
        
        Transcript:
        {$transcriptText}
        
        Analyze the text for signs of fluency issues:
        - Repetition (e.g., 'I... I think')
        - Self-correction (e.g., 'I go, I mean, I went')
        - Fillers indicating pauses (e.g., 'um', 'uh', 'ah')
        - Extremely short answers indicating lack of willingness to speak.
        
        If the transcript is empty or says '(No answer recorded)', you MUST return empty errors and a very low score.
        
        Output strictly in JSON format:
        {
          \"score\": 5.5,
          \"errors\": [
            {
              \"type\": \"Repetition / Self-correction / Pause / Short Answer\",
              \"detail\": \"(Explain the issue in Bahasa Indonesia based on the text)\",
              \"time\": \"(Just put '-' since we don't have exact audio timestamps)\"
            }
          ],
          \"descriptor_feedback\": [
            {
              \"point\": \"(e.g., Willingness to speak, Use of connectives, Hesitation)\",
              \"description\": \"(Feedback in Bahasa Indonesia)\",
              \"status\": \"positive\" // or \"negative\", \"mixed\"
            }
          ]
        }
        
        Provide up to 3 errors and exactly 3 descriptor_feedbacks.
        Output ONLY raw JSON. No markdown.";
    }

    public function checkGrammar(array $transcripts): string
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Question " . ($index + 1) . ":\n" . ($t['question'] ?? 'Unknown') . "\n";
            $transcriptText .= "Answer " . ($index + 1) . ":\n" . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        return "You are an expert IELTS Speaking examiner analyzing a candidate's transcript for Grammatical Range and Accuracy.
        
        Transcript:
        {$transcriptText}
        
        Identify up to 3 grammatical errors in the transcript. Provide the original sentence containing the error, the corrected version, and a brief explanation in Bahasa Indonesia.
        If the transcript is empty or says '(No answer recorded)', return empty errors.
        
        Output strictly in JSON format:
        [
          {
            \"original\": \"(sentence with error)\",
            \"corrected\": \"(fixed sentence)\",
            \"explanation\": \"(Explanation in Bahasa Indonesia)\"
          }
        ]
        
        Output ONLY raw JSON array. No markdown.";
    }

    public function upgradeGrammar(array $transcripts): string
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Answer " . ($index + 1) . ":\n" . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        return "You are an expert IELTS Speaking instructor.
        
        Transcript:
        {$transcriptText}
        
        Suggest exactly 3 advanced grammatical structures (e.g., Relative Clauses, Conditionals, Gerunds as Subjects) that the candidate could have used in their answers to improve their band score.
        Provide a concrete example of how they could have said it, and an explanation in Bahasa Indonesia.
        
        If the transcript is empty or says '(No answer recorded)', just provide 3 generic examples of advanced grammar that are good for IELTS.
        
        Output strictly in JSON format:
        [
          {
            \"type\": \"(e.g., Adjective Clause, Conditional Type 2)\",
            \"example\": \"(Write an example sentence highlighting the structure in HTML tags like <span class='text-indigo-600 font-bold'>...</span>)\",
            \"explanation\": \"(Explanation in Bahasa Indonesia)\"
          }
        ]
        
        Output ONLY raw JSON array. No markdown.";
    }

    public function analyzePronunciation(array $transcripts): string
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Answer " . ($index + 1) . ":\n" . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        return "You are an expert IELTS Speaking examiner.
        Since you only have the transcript and not the audio, estimate the candidate's pronunciation based on their textual responses.
        
        Transcript:
        {$transcriptText}
        
        Provide scores and feedback (in Bahasa Indonesia) for 4 categories:
        1. Clarity (Kejelasan)
        2. Word Stress (Penekanan kata)
        3. Sentence Stress & Intonation
        4. Connected Speech
        
        If the transcript is empty or very short, give low scores and explain that there isn't enough speech to judge.
        
        Output strictly in JSON format:
        {
          \"categories\": [
            {
              \"name\": \"Clarity (Kejelasan)\",
              \"score\": 65,
              \"feedback\": \"(Feedback in Bahasa Indonesia)\",
              \"color\": \"blue\"
            },
            {
              \"name\": \"Word Stress (Penekanan kata)\",
              \"score\": 65,
              \"feedback\": \"...\",
              \"color\": \"indigo\"
            },
            {
              \"name\": \"Sentence Stress & Intonation\",
              \"score\": 65,
              \"feedback\": \"...\",
              \"color\": \"purple\"
            },
            {
              \"name\": \"Connected Speech\",
              \"score\": 65,
              \"feedback\": \"...\",
              \"color\": \"emerald\"
            }
          ],
          \"mispronounced_words\": [
            {
              \"word\": \"example_word\",
              \"phonetic\": \"/ɪɡˈzɑːmpəl/\",
              \"user_phonetic\": \"/ɛkˈzæmpəl/\",
              \"accuracy\": 60,
              \"issue\": \"(Explain typical issue in Bahasa Indonesia)\"
            }
          ]
        }
        
        Provide up to 2 mispronounced_words based on words in the transcript that are commonly mispronounced by non-native speakers. If transcript is empty, leave it empty.
        Output ONLY raw JSON. No markdown.";
    }
}
