<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Application\IeltsSpeaking\BuildIeltsSpeakingAiPrompt;
use App\Services\GroqKeyManager;

class AiController extends Controller
{
    private function sendToHybridAi(array $messages, bool $jsonMode = false, int $maxTokens = 4096, float $temperature = 0.3)
    {
        $payload = [
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
            'stream' => false,
        ];
        if ($jsonMode) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        try {
            $payload['model'] = 'llama-3.1-8b-instant';
            $result = GroqKeyManager::callWithFallback('general', $payload, 30);
            return [
                'content' => $result['body']['choices'][0]['message']['content'],
                'source'  => 'Groq (Llama 3.1) [key ' . $result['key_used'] . ']',
            ];
        } catch (\Exception $e) {
            Log::warning("Groq failed in AiController (all keys exhausted): " . $e->getMessage());
        }

        $geminiKeys = \App\Services\AiProviderKeyManager::getKeys('gemini');
        $payload['model'] = 'gemini-2.5-flash';
        
        foreach ($geminiKeys as $index => $geminiKey) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $geminiKey,
                ])->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/openai/chat/completions", $payload);

                if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                    return [
                        'content' => $response->json()['choices'][0]['message']['content'],
                        'source' => 'Gemini API [key ' . \App\Services\GroqKeyManager::maskKey($geminiKey) . ']'
                    ];
                }
                \Log::warning("Gemini fallback key #{$index} failed in AiController", ['status' => $response->status()]);
            } catch (\Exception $e) {
                \Log::error("Gemini exception key #{$index} in AiController: " . $e->getMessage());
            }
        }

        throw new \Exception('All AI services failed (Groq and Gemini)');
    }

    private function sendToGeminiOnly(array $messages, bool $jsonMode = false, int $maxTokens = 4096, float $temperature = 0.3)
    {
        $parts = [];
        foreach ($messages as $msg) {
            $parts[] = ['text' => $msg['content']];
        }

        $payload = [
            'contents' => [
                ['parts' => $parts]
            ],
            'generationConfig' => [
                'temperature' => $temperature,
                'maxOutputTokens' => $maxTokens,
            ]
        ];

        if ($jsonMode) {
            $payload['generationConfig']['responseMimeType'] = 'application/json';
        }

        $geminiKeys = \App\Services\AiProviderKeyManager::getKeys('gemini');
        
        foreach ($geminiKeys as $index => $geminiKey) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->timeout(60)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $geminiKey, $payload);

                if ($response->successful() && $response->json('candidates.0.content.parts.0.text')) {
                    return [
                        'content' => $response->json('candidates.0.content.parts.0.text'),
                        'source' => 'Gemini API [key ' . \App\Services\GroqKeyManager::maskKey($geminiKey) . ']'
                    ];
                }
                \Log::warning("Gemini key #{$index} failed in sendToGeminiOnly", ['status' => $response->status()]);
            } catch (\Exception $e) {
                \Log::error("Gemini exception key #{$index} in sendToGeminiOnly: " . $e->getMessage());
            }
        }

        return $this->sendToHybridAi($messages, $jsonMode, $maxTokens, $temperature); // fallback to Hybrid
    }

    private function queryAI($prompt, $jsonMode = false, $useLocalIfAvailable = true)
    {
        if ($useLocalIfAvailable) {
            // 1. Try Local Ollama (Llama 3)
            try {
                $response = Http::connectTimeout(1)->timeout(30)->post('http://localhost:11434/api/chat', [
                    'model' => 'llama3',
                    'messages' => [
                        ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'stream' => false,
                    'format' => $jsonMode ? 'json' : ''
                ]);
                if ($response->successful() && isset($response->json()['message']['content'])) {
                    return [
                        'content' => $response->json()['message']['content'],
                        'source' => 'Local Llama 3 (Ollama)'
                    ];
                }
            } catch (\Exception $e) { /* ignore */ }

            // 2. Try Local LM Studio (Llama 3)
            try {
                $response = Http::connectTimeout(1)->timeout(30)->post('http://localhost:1234/v1/chat/completions', [
                    'model' => 'local-model',
                    'messages' => [
                        ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.3,
                    'stream' => false
                ]);
                if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                    return [
                        'content' => $response->json()['choices'][0]['message']['content'],
                        'source' => 'Local Llama 3 (LM Studio)'
                    ];
                }
            } catch (\Exception $e) { /* ignore */ }
        }

        return $this->sendToHybridAi([
            ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $prompt]
        ], $jsonMode);
    }

    public function getCollocations(Request $request)
    {
        $word = $request->input('word');
        if (!$word) return response()->json(['error' => 'Word is required'], 400);

        $prompt = "If the word '{$word}' is not in English (e.g., Indonesian), translate it to English first. Then, analyze the usage of that English word. 
        Provide strongly associated ENGLISH collocations in JSON format:
        {
            \"collocations\": [
                { \"phrase\": \"(English collocation phrase)\", \"type\": \"Verb+Noun\", \"explanation\": \"(Explanation in English)\", \"example\": \"(Example sentence in English)\" }
            ]
        }
        IMPORTANT: All phrases, explanations, and examples MUST be in English. Return ONLY valid JSON.";

        try {
            $result = $this->queryAI($prompt, true);
            $json = json_decode($result['content'], true);
            
            // If JSON decode failed (common with local LLMs adding chat text), try to extract JSON
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }
            
            if ($json) {
                $json['source'] = 'Llama 3 (' . $result['source'] . ')'; // Add Source info
                return response()->json($json);
            }
            
            throw new \Exception('Invalid JSON from AI');

        } catch (\Exception $e) {
            \Log::error("Collocation error: " . $e->getMessage());
            return response()->json([
                'error' => 'AI Offline or failed',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function translate(Request $request)
    {
        $text = $request->input('text');
        // $target is ignored because we auto-detect
        
        $prompt = "Analyze the word \"{$text}\".
1. Detect if it is Indonesian or English.
2. Translate it to the OTHER language.
3. Determine the part of speech of the English word (e.g., noun, verb, adjective, adverb, pronoun, preposition, conjunction, interjection).
4. Return strictly JSON: { \"detected_source\": \"id\" or \"en\", \"translation\": \"translated_word\", \"part_of_speech\": \"noun\" }
5. NO chatter. NO poems. NO explanations. MAX 5 WORDS.

Example: 
Input: \"buku\" 
Output: { \"detected_source\": \"id\", \"translation\": \"book\", \"part_of_speech\": \"noun\" }

Input: \"house\" 
Output: { \"detected_source\": \"en\", \"translation\": \"rumah\", \"part_of_speech\": \"noun\" }

Input: \"{$text}\"
Output:";

        try {
            $result = $this->queryAI($prompt, true, true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json && isset($json['translation'])) {
                // ECHO SAFEGUARD (Removed - Many words are identical in EN and ID like "habitat")
                // HALLUCINATION SAFEGUARD (Poem / Explanation Filter)
                $wordCountInput = str_word_count($text);
                $wordCountOutput = str_word_count($json['translation']);
                $charCountOutput = strlen($json['translation']);

                // 1. Length Check: No single word translation should be > 50 chars
                if ($charCountOutput > 50 && strlen($text) < 20) {
                     \Log::warning("AI Hallucination Blocked (Length > 50): " . $json['translation']);
                     throw new \Exception('AI Hallucination: Too Long');
                }

                // 2. Word Count Check: Single word input -> Max 5 words output
                if ($wordCountInput === 1 && $wordCountOutput > 5) {
                    \Log::warning("AI Hallucination Blocked (Words > 5): " . $json['translation']);
                    throw new \Exception('AI Hallucination: Too Many Words');
                }

                $json['rotation_source'] = $result['source']; // Debug info
                return response()->json($json);
            }
            throw new \Exception('Translation Failed');

        } catch (\Exception $e) {
            \Log::error("Translate error: " . $e->getMessage());
            return response()->json([
                'error' => 'All AI Offline or Failed',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function translateSentence(Request $request)
    {
        $text = $request->input('text');

        if (!$text || trim($text) === '') {
            return response()->json(['error' => 'No text provided.'], 400);
        }

        $prompt = "You are a professional Indonesian-to-English translator for IELTS writing practice.

Translate the following Indonesian sentence into natural, grammatically correct, academic English suitable for IELTS writing.

Rules:
1. Translate ONLY the sentence. Do NOT add explanations, alternatives, or commentary.
2. Use formal/academic English appropriate for IELTS essays.
3. Maintain the original meaning precisely.
4. Return ONLY valid JSON: { \"translation\": \"the English sentence\" }

Indonesian sentence: \"{$text}\"

Output:";

        try {
            $result = $this->queryAI($prompt, true, true);
            $json = json_decode($result['content'], true);

            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json && isset($json['translation'])) {
                return response()->json([
                    'translation' => $json['translation'],
                    'source' => $result['source'] ?? 'unknown'
                ]);
            }

            throw new \Exception('Translation Failed - unexpected format');

        } catch (\Exception $e) {
            \Log::error("TranslateSentence error: " . $e->getMessage());
            return response()->json([
                'error' => 'Translation failed. Please try again.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function academicWords(Request $request)
    {
        $word = $request->input('word');
        if (!$word) return response()->json(['error' => 'Word required'], 400);

        $prompt = "Provide 3 to 5 academic synonyms for the English word \"{$word}\". 
Assign a CEFR level (e.g., B1, B2, C1, C2) to each.
Determine the part of speech for each word (e.g., noun, verb, adjective, adverb).
Return strictly JSON format: { \"academic_words\": [ { \"word\": \"...\", \"cefr\": \"...\", \"part_of_speech\": \"...\" } ] }
NO chatter. NO markdown blocks. Just the JSON object.";

        try {
            $result = $this->queryAI($prompt, true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json && isset($json['academic_words'])) {
                return response()->json($json);
            }
            throw new \Exception('Failed to generate academic words');

        } catch (\Exception $e) {
            \Log::error("Academic words error: " . $e->getMessage());
            return response()->json([
                'error' => 'All AI Offline or Failed',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
    public function gradeSpeaking($transcripts, int $part = 1, string $topicTitle = '')
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Q: " . ($t['question'] ?? 'Question ' . ($index + 1)) . "\n";
            $transcriptText .= "A: " . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->grading($transcriptText, $part, $topicTitle);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json) {
                return $json;
            }
            
            return null; // AI failed to produce JSON
        } catch (\Exception $e) {
            \Log::error("Using Fallback Grading: " . $e->getMessage());
            return null;
        }
    }

    public function generateModelAnswers(array $transcripts)
    {
        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->modelAnswers($transcripts);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json && isset($json['model_answers'])) {
                return $json['model_answers'];
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error("Using Fallback Model Answers: " . $e->getMessage());
            return null;
        }
    }

    public function analyzeFluency(array $transcripts)
    {
        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->fluencyAnalysis($transcripts);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json) {
                return $json;
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error("Using Fallback Fluency Analysis: " . $e->getMessage());
            return null;
        }
    }

    public function checkGrammar(array $transcripts)
    {
        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->checkGrammar($transcripts);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json && preg_match('/\[.*\]/s', $result['content'], $matches)) {
                $json = json_decode($matches[0], true);
            }

            if (is_array($json)) {
                return $json;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error("Using Fallback Grammar Check: " . $e->getMessage());
            return null;
        }
    }

    public function upgradeGrammar(array $transcripts)
    {
        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->upgradeGrammar($transcripts);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json && preg_match('/\[.*\]/s', $result['content'], $matches)) {
                $json = json_decode($matches[0], true);
            }

            if (is_array($json)) {
                return $json;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error("Using Fallback Grammar Upgrade: " . $e->getMessage());
            return null;
        }
    }

    public function analyzePronunciation(array $transcripts)
    {
        $promptBuilder = new BuildIeltsSpeakingAiPrompt();
        $prompt = $promptBuilder->analyzePronunciation($transcripts);

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $prompt]], true);
            $json = json_decode($result['content'], true);
            
            if (!$json && preg_match('/\{.*\}/s', $result['content'], $matches)) {
                $json = json_decode($matches[0], true);
            }

            if (is_array($json) && isset($json['categories'])) {
                return $json;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error("Using Fallback Pronunciation Analysis: " . $e->getMessage());
            return null;
        }
    }

    public function chat(Request $request)
    {
        $message = $request->input('message');
        $history = $request->input('history', []);
        
        if (!$message) {
            return response()->json(['error' => 'Message is required'], 400);
        }

        // Build messages array from history + new message
        $messages = [];
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'content' => $msg['content']
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        try {
            $result = $this->sendToHybridAi($messages, false, 4096, 0.7);
            return response()->json([
                'response' => $result['content'],
                'source' => $result['source'],
                'model' => 'Hybrid Stack'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API AI gagal dihubungi.'
            ], 503);
        }
    }

    public function getIdeas(Request $request)
    {
        $prompt = $request->input('prompt');
        $task = $request->input('task', 2);
        if (!$prompt) return response()->json(['error' => 'Prompt is required'], 400);

        if ($task == 1) {
            $systemPrompt = "Analyze the following IELTS Writing Task 1 prompt:\n\"{$prompt}\"\n\nProvide a highly structured and detailed vocabulary guide in Markdown format EXACTLY matching this structure.\nDo NOT include the instructions in your output. Output the ACTUAL data.\n\n### 1. Sinonim Kata Kunci dari Soal\n\n| Kata Asli (Soal) | Sinonim Akademik (Bahasa Inggris) | Contoh dalam Kalimat (Bahasa Inggris) |\n|---|---|---|\n| [Isi kata] | [Isi sinonim] | [Isi contoh kalimat] |\n\n### 2. Kosakata Khusus Task 1\n\n#### [Kategori Tren/Perbandingan]\n- **[Kosakata 1]** ([Arti Bahasa Indonesia]) *[Contoh kalimat bahasa inggris]*\n- **[Kosakata 2]** ([Arti Bahasa Indonesia]) *[Contoh kalimat bahasa inggris]*\n\nRespond ONLY with the filled Markdown text. Make it comprehensive and suitable for Band 7+.";
        } elseif ($task == 'speaking') {
            $systemPrompt = "Analyze the following IELTS Speaking question:\n\"{$prompt}\"\n\nProvide 3 distinct, natural, and highly-scoring ideas to answer this question. Format the output in Markdown.\n\nStructure for each idea:\n### Idea [Number]: [Main Concept]\n- **Penjelasan:** [Brief explanation of the idea in Indonesian]\n- **Contoh Jawaban (English):** [Example sentences in English demonstrating the idea]\n- **Kosakata:** [2-3 useful advanced English words/phrases with Indonesian meaning]\n\nRespond ONLY with the Markdown text. Make it high quality for Band 7+.";
        } else {
            $systemPrompt = "Analyze the following IELTS Writing Task 2 prompt:\n\"{$prompt}\"\n\nProvide a comprehensive, highly structured vocabulary and idea guide in Markdown format EXACTLY matching this structure.\n\nDo NOT include the instructions in parentheses in your output. Output the ACTUAL data.\n\n### 1. Sinonim untuk Variasi Paragraf Introduksi\n\nGunakan kosakata ini di paragraf pertama saat melakukan paraphrasing agar tidak mengulang kata-kata dari soal.\n\n| Kata Asli (Soal) | Sinonim Akademik (Bahasa Inggris) | Contoh dalam Kalimat (Bahasa Inggris) |\n|---|---|---|\n| [Isi kata dari soal] | [Isi sinonim] | [Isi contoh kalimat] |\n\n### 2. Kosakata untuk Argumen Utama (Dampak Positif / Setuju)\n\n#### [Nama Kategori 1]\n- **[Kosakata 1]** ([Arti Bahasa Indonesia]) *[Contoh kalimat bahasa inggris]*\n- **[Kosakata 2]** ([Arti Bahasa Indonesia]) *[Contoh kalimat bahasa inggris]*\n\n### 3. Kosakata untuk Argumen Alternatif (Dampak Negatif / Tidak Setuju)\n\n#### [Nama Kategori 2]\n- **[Kosakata 1]** ([Arti Bahasa Indonesia]) *[Contoh kalimat bahasa inggris]*\n\nRespond ONLY with the filled Markdown text, replacing the placeholders with real, high-quality Band 7+ vocabulary. Make sure to leave blank lines before and after tables and headers.";
        }

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $systemPrompt]], false);
            if ($result && isset($result['content'])) {
                $content = trim($result['content']);
                // Extract markdown from code block if present
                if (preg_match('/```(?:markdown)?\s*(.*?)\s*```/s', $content, $matches)) {
                    $markdown = $matches[1];
                } else {
                    $markdown = $content;
                }
                
                $html = \Illuminate\Support\Str::markdown($markdown);
                return response()->json(['html' => $html]);
            }
        } catch (\Exception $e) {
            \Log::error("Get Ideas Failed: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['error' => 'Failed to get response'], 500);
    }
    public function getTopicCollocations(Request $request)
    {
        $prompt = $request->input('prompt');
        $task = $request->input('task', 2);
        if (!$prompt) return response()->json(['error' => 'Prompt is required'], 400);

        $systemPrompt = "Analyze the following IELTS Writing Task {$task} prompt:\n\"{$prompt}\"\n\nProvide 5 to 10 highly relevant English collocations that would be extremely useful for writing an essay or report on this topic. \nReturn strictly JSON format: { \"collocations\": [ { \"phrase\": \"...\", \"meaning\": \"(Indonesian meaning)\", \"example\": \"(English example sentence)\" } ] }\nNO chatter. NO markdown blocks. Just the JSON object.";

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $systemPrompt]], true);
            $json = json_decode($result['content'], true);
            if (!$json && preg_match('/\{.*\}/s', $result['content'], $matches)) {
                $json = json_decode($matches[0], true);
            }
            if ($json && isset($json['collocations'])) {
                return response()->json($json);
            }
            throw new \Exception('Failed to generate collocations');
        } catch (\Exception $e) {
            \Log::error("Topic collocations error: " . $e->getMessage());
            return response()->json(['error' => 'AI Failed', 'debug' => $e->getMessage()], 500);
        }
    }

    public function getTopicIdioms(Request $request)
    {
        $prompt = $request->input('prompt');
        $task = $request->input('task', 2);
        if (!$prompt) return response()->json(['error' => 'Prompt is required'], 400);

        $systemPrompt = "Analyze the following IELTS Writing Task {$task} prompt:\n\"{$prompt}\"\n\nProvide 3 to 6 highly relevant English idioms or idiomatic expressions that could naturally be used in an essay or report on this topic. \nReturn strictly JSON format: { \"idioms\": [ { \"phrase\": \"...\", \"meaning\": \"(Indonesian meaning)\", \"example\": \"(English example sentence)\" } ] }\nNO chatter. NO markdown blocks. Just the JSON object.";

        try {
            $result = $this->sendToGeminiOnly([['role' => 'user', 'content' => $systemPrompt]], true);
            $json = json_decode($result['content'], true);
            if (!$json && preg_match('/\{.*\}/s', $result['content'], $matches)) {
                $json = json_decode($matches[0], true);
            }
            if ($json && isset($json['idioms'])) {
                return response()->json($json);
            }
            throw new \Exception('Failed to generate idioms');
        } catch (\Exception $e) {
            \Log::error("Topic idioms error: " . $e->getMessage());
            return response()->json(['error' => 'AI Failed', 'debug' => $e->getMessage()], 500);
        }
    }
}
