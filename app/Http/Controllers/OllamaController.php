<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OllamaController extends Controller
{
    private function queryAI($prompt, $jsonMode = false)
    {
        $ports = [
            1234,  // LM Studio (Preferred by User)
            11434  // Ollama
        ];

        foreach ($ports as $port) {
            try {
                $url = "http://127.0.0.1:{$port}/v1/chat/completions";
                
                // LM Studio requires 'local-model' or exact match. Ollama requires exact installed model name.
                $modelName = ($port === 1234) ? 'local-model' : 'llama3';

                // Construct Payload (OpenAI Compatible)
                $payload = [
                    'model' => $modelName, 
                    'messages' => [
                        ['role' => 'system', 'content' => $jsonMode ? 'Output ONLY valid JSON.' : 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.3,
                    'stream' => false
                ];

                if ($jsonMode) {
                    // LM Studio / Ollama sometimes crash with 'json_object' flag if model doesn't support it.
                    // Rely on System Prompt instead.
                    // $payload['response_format'] = ['type' => 'json_object']; 
                }

                // Increase timeout to 30s (Server might be waking up)
                $response = Http::timeout(30)->post($url, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['choices'][0]['message']['content'])) {
                        return [
                            'content' => $data['choices'][0]['message']['content'],
                            'source' => ($port === 1234 ? 'LM Studio' : 'Ollama')
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Log the error for debugging if needed: \Log::error("Port $port failed: " . $e->getMessage());
                continue; // Try next port
            }
        }

        throw new \Exception('No Local AI reachable on ports 1234 or 11434');
    }

    public function getCollocations(Request $request)
    {
        $word = $request->input('word');
        if (!$word) return response()->json(['error' => 'Word is required'], 400);

        $prompt = "Analyze usage of the word '{$word}'. 
        Provide strongly associated collocations in JSON format:
        {
            \"collocations\": [
                { \"phrase\": \"...\", \"type\": \"Verb+Noun\", \"explanation\": \"...\", \"example\": \"...\" }
            ]
        }
        Return ONLY valid JSON.";

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
            return $this->fallbackToDataMuse($word);
        }
    }

    public function translate(Request $request)
    {
        $text = $request->input('text');
        // $target is ignored because we auto-detect
        
        $prompt = "Analyze the word \"{$text}\".
1. Detect if it is Indonesian or English.
2. Translate it to the OTHER language.
3. Return strictly JSON: { \"detected_source\": \"id\" or \"en\", \"translation\": \"translated_word\" }
4. NO chatter. NO poems. NO explanations. MAX 5 WORDS.

Example: 
Input: \"buku\" 
Output: { \"detected_source\": \"id\", \"translation\": \"book\" }

Input: \"house\" 
Output: { \"detected_source\": \"en\", \"translation\": \"rumah\" }

Input: \"{$text}\"
Output:";

        try {
            $result = $this->queryAI($prompt, true);
            $json = json_decode($result['content'], true);
            
            if (!$json) {
                if (preg_match('/\{.*\}/s', $result['content'], $matches)) {
                    $json = json_decode($matches[0], true);
                }
            }

            if ($json && isset($json['translation'])) {
                // ECHO SAFEGUARD
                $cleanInput = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $text));
                $cleanTrans = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $json['translation']));
                
                if ($cleanInput === $cleanTrans || (strlen($cleanTrans) > 5 && strpos($cleanTrans, $cleanInput) !== false)) {
                     throw new \Exception('AI Echoed Input (Backend Check)');
                }
                
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
            return response()->json([
                'error' => 'All AI Offline or Failed',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
    public function gradeSpeaking($transcripts)
    {
        $transcriptText = "";
        foreach ($transcripts as $index => $t) {
            $transcriptText .= "Q: " . ($t['question'] ?? 'Question ' . ($index + 1)) . "\n";
            $transcriptText .= "A: " . ($t['answer'] ?? '(No answer)') . "\n\n";
        }

        $prompt = "You are an expert IELTS Speaking examiner. Grade the following speaking test based on the 4 criteria: Fluency and Coherence, Lexical Resource, Grammatical Range and Accuracy, and Pronunciation.\n\n" .
            "Transcripts:\n" . $transcriptText . "\n\n" .
            "Provide the output in STRICT JSON format with the following structure:\n" .
            "{\n" .
            "  \"overall_score\": (float, 0-9),\n" .
            "  \"categories\": {\n" .
            "    \"fluency_coherence\": { \"score\": (float), \"feedback\": \"...\" },\n" .
            "    \"lexical_resource\": { \"score\": (float), \"feedback\": \"...\" },\n" .
            "    \"grammatical_range\": { \"score\": (float), \"feedback\": \"...\" },\n" .
            "    \"pronunciation\": { \"score\": (float), \"feedback\": \"...\" }\n" .
            "  },\n" .
            "  \"general_feedback\": \"...\"\n" .
            "}\n" .
            "IMPORTANT: \n" .
            "1. Give honest scores based heavily on the transcript quality. Short/empty answers should get low scores (1.0 - 4.0).\n" .
            "2. Feedback should be constructive and in Indonesian language.\n" .
            "3. Return ONLY valid JSON.";

        try {
            $result = $this->queryAI($prompt, true);
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
}
