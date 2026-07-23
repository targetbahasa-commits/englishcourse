<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Pool;
use App\Services\GroqKeyManager;
use App\Services\AiProviderKeyManager;

class PromoTestController extends Controller
{
    public function index()
    {
        $writingPromos = DB::table('ielts_writing_meetings')->where('is_free_tier', true)->get();
        $speakingPromos = DB::table('ielts_speaking_topics')->where('is_free_tier', true)->get();

        return view('promo.index', compact('writingPromos', 'speakingPromos'));
    }

    public function show($type, $id)
    {
        $testConfig = null;
        if (str_starts_with($type, 'writing')) {
            $testConfig = DB::table('ielts_writing_meetings')->where('id', $id)->first();
            if ($testConfig && isset($testConfig->task_type)) {
                $type = 'writing_t' . $testConfig->task_type;
            }
        } elseif ($type === 'grammar') {
            $testConfig = DB::table('meetings')->where('id', $id)->first();
        } else {
            $testConfig = DB::table('ielts_speaking_topics')->where('id', $id)->first();
            if ($testConfig) {
                // Fetch random Part 1 questions for the promo test
                $part1Topic = DB::table('ielts_speaking_topics')
                    ->where('part', 1)
                    ->whereNull('subtopics')
                    ->whereNotNull('questions')
                    ->orderBy('id')
                    ->first();
                
                $part1Questions = [];
                if ($part1Topic && $part1Topic->questions) {
                    $decoded = json_decode($part1Topic->questions, true);
                    if (is_array($decoded)) {
                        // Take 3 questions from part 1
                        $part1Questions = array_slice($decoded, 0, 3);
                    }
                }
                $testConfig->part1_questions = $part1Questions;
            }
        }

        $test = $testConfig;

        if (!$test) {
            abort(404);
        }

        if (!$test->is_free_tier || 
            ($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture()) || 
            ($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())) {
            return view('promo.expired');
        }

        return view('promo.show', compact('type', 'id', 'test'));
    }

    public function submit(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'cf-turnstile-response' => 'required|string',
            'answer_text' => 'required_without:audio_files|string', // for writing
            'audio_files' => 'array',
            'audio_files.*' => 'file|mimes:mp3,wav,webm,mp4,m4a',
            'questions' => 'array',
            'questions.*' => 'string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,webm,mp4,m4a', // legacy
        ]);

        // Verify Turnstile
        $turnstileResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$turnstileResponse->successful() || !$turnstileResponse->json('success')) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi captcha gagal. Silakan coba lagi.'
            ], 422);
        }

        $aiFeedback = [];
        $bandScore = null;

        if ($type === 'writing') {
            $testConfig = DB::table('ielts_writing_meetings')->where('id', $id)->first();
            if ($testConfig && isset($testConfig->task_type)) {
                $type = 'writing_t' . $testConfig->task_type;
            }
        }

        try {
            if ($request->input('is_admin_debug') == '1' && auth()->check() && auth()->user()->isAdmin()) {
                $bandScore = (float) $request->input('target_band_score', 7.5);
                $aiFeedback = [
                    'overall_band_score' => $bandScore,
                    'task_response_score' => $bandScore,
                    'task_response' => '<p>Dummy Task Response summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                    'coherence_cohesion_score' => $bandScore,
                    'coherence_cohesion' => '<p>Dummy Coherence summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                    'lexical_resource_score' => $bandScore,
                    'lexical_resource' => '<p>Dummy Lexical summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Good</td><td class="border border-gray-200 p-2">Excellent</td></tr></tbody></table>',
                    'grammatical_range_score' => $bandScore,
                    'grammatical_range' => '<p>Dummy Grammar summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                    'pronunciation_score' => $bandScore,
                    'pronunciation' => '<p>Dummy Pronunciation summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                    'fluency_and_coherence_score' => $bandScore,
                    'fluency_and_coherence' => '<p>Dummy Fluency summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                    'overall_comment' => 'This is an admin debug submission for Target Band Score: ' . $bandScore,
                    'band_9_version' => '<p>Dummy band 9 version.</p>',
                    'correction_html' => '<p>Dummy <del>correction</del> <ins>html</ins>.</p>',
                    'recordings' => [
                        [
                            'question' => 'Do you currently work or study?',
                            'audio_url' => ''
                        ],
                        [
                            'question' => 'What do you enjoy most about your work or study?',
                            'audio_url' => ''
                        ],
                        [
                            'question' => 'Do you prefer to do your work or study alone or with others?',
                            'audio_url' => ''
                        ]
                    ]
                ];
            } else if ($type === 'writing_t1') {
                $aiFeedback = $this->evaluateWritingTask1($id, $validated['answer_text'] ?? '');
                $bandScore = $aiFeedback['overall_band_score'] ?? null;
            } elseif ($type === 'writing_t2') {
                $aiFeedback = $this->evaluateWritingTask2($id, $validated['answer_text'] ?? '');
                $bandScore = $aiFeedback['overall_band_score'] ?? null;
            } elseif ($type === 'speaking') {
                $audioFiles = $request->file('audio_files') ?? [];
                if ($request->hasFile('audio_file')) {
                    $audioFiles[] = $request->file('audio_file');
                }
                $questions = $request->input('questions', []);
                $aiFeedback = $this->evaluateSpeaking($id, $audioFiles, $questions);
                $bandScore = $aiFeedback['overall_band_score'] ?? null;

                $recordings = [];
                foreach ($audioFiles as $index => $audioFile) {
                    $path = $audioFile->store('promo_recordings', 'public');
                    $recordings[] = [
                        'question' => $questions[$index] ?? 'Part ' . ($index + 1),
                        'audio_url' => asset('storage/' . $path)
                    ];
                }
                $aiFeedback['recordings'] = $recordings;
            }

            $leadId = DB::table('free_test_submissions')->insertGetId([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'test_type' => $type,
                'estimated_band_score' => is_numeric($bandScore) ? $bandScore : null,
                'ai_raw_json_feedback' => json_encode($aiFeedback),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            event(new \App\Events\PromoTestCompleted($leadId, $validated['whatsapp_number'] ?? null, $aiFeedback));

            return response()->json([
                'success' => true,
                'feedback' => $aiFeedback,
                'submission_id' => $leadId,
            ]);
        } catch (\Exception $e) {
            Log::error('Promo Test Submission Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during AI evaluation: ' . $e->getMessage()
            ], 500);
        }
    }

    private function evaluateWritingTask1($questionId, $answerText)
    {
        $rubric = file_get_contents(storage_path('app/IELTS_band_descriptors/writing_ielts_rubic/ielts_grader_system_prompt.txt'));
        
        $question = DB::table('ielts_writing_meetings')->find($questionId);
        $graphData = $question->graph_data_json ?? '{}';
        $systemOverride1 = $question->system_prompt_override ?? "Evaluate Task Achievement based on the graph data: $graphData.\n\n$rubric";
        $systemOverride1 .= "\n\nCRITICAL INSTRUCTION: You must provide a LOT of specific, actionable suggestions for improvement based on the candidate's actual writing. You MUST analyze the essay comprehensively from the first sentence to the last. Your table MUST contain AT LEAST 5 to 10 rows of detailed corrections and feedback. You MUST check the word count of the essay. If it is under 150 words, you MUST mention this as a severe penalty in the Task Achievement summary.";
        $systemOverride1 .= "\n\nIGNORE THE 'OUTPUT FORMAT' SECTION FROM THE RUBRIC ABOVE. YOU MUST FORMAT YOUR DETAILED FEEDBACK AS AN HTML TABLE. Present your actionable feedback using exactly this styled HTML table format:\n`<table class=\"w-full text-left border-collapse border border-gray-200 mt-4 mb-4\"><thead class=\"bg-gray-50\"><tr><th class=\"border border-gray-200 p-2\">Kutipan Asli (English)</th><th class=\"border border-gray-200 p-2\">Masalah / Kesalahan</th><th class=\"border border-gray-200 p-2\">Penjelasan</th><th class=\"border border-gray-200 p-2\">Perbaikan (English)</th></tr></thead><tbody><tr><td class=\"border border-gray-200 p-2\">...</td>...</tr></tbody></table>`";
        $systemOverride1 .= "\nLanguage Rules for the Table: 'Kutipan Asli' MUST be the exact snippet from the candidate's essay in English. 'Masalah / Kesalahan' and 'Penjelasan' MUST be entirely in Bahasa Indonesia. 'Perbaikan' MUST be the corrected snippet in English.";
        $systemOverride1 .= "\n\nYou MUST return a JSON object with the keys 'task_achievement_score' (number) and 'task_achievement' (string). The 'task_achievement' string MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.";

        $systemOverride2 = "Evaluate Grammar, Lexical Resource, and Coherence based on the rubric.\n\n$rubric\n\n 
CRITICAL INSTRUCTION: You must provide a LOT of specific, actionable suggestions for improvement for Coherence, Lexical Resource, and Grammar based on the candidate's actual writing. You MUST analyze the essay comprehensively from the first sentence to the last. Each table MUST contain AT LEAST 5 to 10 rows of detailed corrections and feedback, covering issues from the introduction, body paragraphs, and conclusion.
IGNORE THE 'OUTPUT FORMAT' SECTION FROM THE RUBRIC ABOVE. YOU MUST FORMAT YOUR DETAILED FEEDBACK STRINGS AS HTML TABLES. Present your actionable feedback using exactly this styled HTML table format for EACH criteria field:
`<table class=\"w-full text-left border-collapse border border-gray-200 mt-4 mb-4\"><thead class=\"bg-gray-50\"><tr><th class=\"border border-gray-200 p-2\">Kutipan Asli (English)</th><th class=\"border border-gray-200 p-2\">Masalah / Kesalahan</th><th class=\"border border-gray-200 p-2\">Penjelasan</th><th class=\"border border-gray-200 p-2\">Perbaikan (English)</th></tr></thead><tbody><tr><td class=\"border border-gray-200 p-2\">...</td>...</tr></tbody></table>`
Language Rules for the Table: 'Kutipan Asli' MUST be the exact snippet from the candidate's essay in English. 'Masalah / Kesalahan' and 'Penjelasan' MUST be entirely in Bahasa Indonesia. 'Perbaikan' MUST be the corrected snippet in English.

You MUST return a JSON object with EXACTLY the following keys:
- 'overall_band_score': (number)
- 'coherence_cohesion_score': (number)
- 'coherence_cohesion': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.
- 'lexical_resource_score': (number)
- 'lexical_resource': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the main HTML table (<table>...</table>), and THEN you MUST provide a SECOND HTML table listing vocabulary upgrades with 2 columns: 'Kosa Kata Asli' (Original Vocabulary) and 'Kosa Kata yang Lebih Baik' (Band 9 Alternative). This second table MUST contain AT LEAST 10 ROWS of vocabulary upgrades.
- 'grammatical_range_score': (number)
- 'grammatical_range': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.
- 'overall_comment': (string) General feedback. If under 150 words, mention the word count penalty here too.
- 'band_9_version': (string) A complete Band 9 version of the essay answering the same prompt. It MUST be at least 150 words. It MUST have distinct paragraphs, and you MUST wrap EVERY single paragraph with <p class=\"mb-4\"> and </p> tags to ensure proper spacing.
- 'correction_html': (string) The FULL original essay text, paragraph by paragraph using <p> tags. Wrap errors in <del>error</del> and corrections in <ins>correction</ins>.";

        $providers = ['sambanova', 'gemini', 'openrouter'];
        $taskAchievement = null;
        $otherCriteria = null;

        foreach ($providers as $provider) {
            $keys = \App\Services\AiProviderKeyManager::getKeys($provider);
            if (empty($keys)) {
                continue;
            }

            foreach ($keys as $index => $key) {
                try {
                    $responses = null;
                    if ($provider === 'sambanova') {
                        $responses = Http::pool(fn (Pool $pool) => [
                            // DeepSeek for Task Achievement
                            $pool->as('task_achievement')->withHeaders([
                                'Authorization' => 'Bearer ' . $key,
                                'Content-Type' => 'application/json'
                            ])->post('https://api.sambanova.ai/v1/chat/completions', [
                                'model' => 'DeepSeek-V3.1',
                                'messages' => [
                                    ['role' => 'system', 'content' => $systemOverride1],
                                    ['role' => 'user', 'content' => $answerText]
                                ],
                                'response_format' => ['type' => 'json_object']
                            ]),

                            // Llama 3.3 for Grammar, Lexical Resource, Coherence
                            $pool->as('other_criteria')->withHeaders([
                                'Authorization' => 'Bearer ' . $key,
                                'Content-Type' => 'application/json'
                            ])->post('https://api.sambanova.ai/v1/chat/completions', [
                                'model' => 'Meta-Llama-3.3-70B-Instruct',
                                'messages' => [
                                    ['role' => 'system', 'content' => $systemOverride2],
                                    ['role' => 'user', 'content' => $answerText]
                                ],
                                'response_format' => ['type' => 'json_object']
                            ])
                        ]);
                    } elseif ($provider === 'gemini') {
                        $responses = Http::pool(fn (Pool $pool) => [
                            $pool->as('task_achievement')->withHeaders([
                                'Content-Type' => 'application/json'
                            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $key, [
                                'contents' => [
                                    ['parts' => [
                                        ['text' => $systemOverride1],
                                        ['text' => $answerText]
                                    ]]
                                ],
                                'generationConfig' => [
                                    'responseMimeType' => 'application/json',
                                ]
                            ]),
                            $pool->as('other_criteria')->withHeaders([
                                'Content-Type' => 'application/json'
                            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $key, [
                                'contents' => [
                                    ['parts' => [
                                        ['text' => $systemOverride2],
                                        ['text' => $answerText]
                                    ]]
                                ],
                                'generationConfig' => [
                                    'responseMimeType' => 'application/json',
                                ]
                            ])
                        ]);
                    } elseif ($provider === 'openrouter') {
                        $responses = Http::pool(fn (Pool $pool) => [
                            $pool->as('task_achievement')->withHeaders([
                                'Authorization' => 'Bearer ' . $key,
                                'Content-Type' => 'application/json',
                                'HTTP-Referer' => 'https://targetbahasa.com',
                                'X-Title' => 'Target Bahasa Course'
                            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                                'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                                'messages' => [
                                    ['role' => 'system', 'content' => $systemOverride1],
                                    ['role' => 'user', 'content' => $answerText]
                                ],
                                'response_format' => ['type' => 'json_object']
                            ]),
                            $pool->as('other_criteria')->withHeaders([
                                'Authorization' => 'Bearer ' . $key,
                                'Content-Type' => 'application/json',
                                'HTTP-Referer' => 'https://targetbahasa.com',
                                'X-Title' => 'Target Bahasa Course'
                            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                                'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                                'messages' => [
                                    ['role' => 'system', 'content' => $systemOverride2],
                                    ['role' => 'user', 'content' => $answerText]
                                ],
                                'response_format' => ['type' => 'json_object']
                            ])
                        ]);
                    }

                    if ($responses && $responses['task_achievement']->successful() && $responses['other_criteria']->successful()) {
                        $rawTa = '';
                        $rawOc = '';
                        if ($provider === 'gemini') {
                            $rawTa = $responses['task_achievement']->json('candidates.0.content.parts.0.text');
                            $rawOc = $responses['other_criteria']->json('candidates.0.content.parts.0.text');
                        } else {
                            $rawTa = $responses['task_achievement']->json('choices.0.message.content');
                            $rawOc = $responses['other_criteria']->json('choices.0.message.content');
                        }

                        $decodedTa = json_decode($rawTa, true);
                        $decodedOc = json_decode($rawOc, true);

                        if (!empty($decodedTa) && !empty($decodedOc)) {
                            Log::info("Writing Task 1 evaluation succeeded using provider: {$provider}");
                            return array_merge($decodedTa, $decodedOc);
                        }
                    } else {
                        Log::warning("Writing Task 1: {$provider} key #{$index} pool request failed.");
                    }
                } catch (\Exception $e) {
                    Log::warning("Writing Task 1: {$provider} key #{$index} pool threw exception: " . $e->getMessage());
                }
            }
        }

        return [];
    }

    private function evaluateWritingTask2($questionId, $answerText)
    {
        $rubric = file_get_contents(storage_path('app/IELTS_band_descriptors/writing_ielts_rubic/ielts_grader_system_prompt.txt'));
        
        $question = DB::table('ielts_writing_meetings')->find($questionId);
        $systemOverride = $question->system_prompt_override ?? "You are an expert IELTS Writing Task 2 examiner. Evaluate the essay based on the rubric.\n\n$rubric";
        $systemOverride .= "\n\nCRITICAL INSTRUCTION: You must provide a LOT of specific, actionable suggestions for improvement for Task Response, Coherence & Cohesion, Lexical Resource, and Grammatical Range. You MUST analyze the essay comprehensively from the first sentence to the last. Each table MUST contain AT LEAST 5 to 10 rows of detailed corrections and feedback. You MUST check the word count of the essay. If it is under 250 words, you MUST mention this as a severe penalty in the Task Response summary.";
        $systemOverride .= "\n\nIGNORE THE 'OUTPUT FORMAT' SECTION FROM THE RUBRIC ABOVE. YOU MUST FORMAT YOUR DETAILED FEEDBACK STRINGS AS HTML TABLES. Present your actionable feedback using exactly this styled HTML table format for EACH criteria field:\n`<table class=\"w-full text-left border-collapse border border-gray-200 mt-4 mb-4\"><thead class=\"bg-gray-50\"><tr><th class=\"border border-gray-200 p-2\">Kutipan Asli (English)</th><th class=\"border border-gray-200 p-2\">Masalah / Kesalahan</th><th class=\"border border-gray-200 p-2\">Penjelasan</th><th class=\"border border-gray-200 p-2\">Perbaikan (English)</th></tr></thead><tbody><tr><td class=\"border border-gray-200 p-2\">...</td>...</tr></tbody></table>`";
        $systemOverride .= "\nLanguage Rules for the Table: 'Kutipan Asli' MUST be the exact snippet from the candidate's essay in English. 'Masalah / Kesalahan' and 'Penjelasan' MUST be entirely in Bahasa Indonesia. 'Perbaikan' MUST be the corrected snippet in English.";
        $systemOverride .= "\n\nYou MUST return a JSON object with EXACTLY the following keys:
- 'overall_band_score': (number)
- 'task_response_score': (number)
- 'task_response': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.
- 'coherence_cohesion_score': (number)
- 'coherence_cohesion': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.
- 'lexical_resource_score': (number)
- 'lexical_resource': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the main HTML table (<table>...</table>), and THEN you MUST provide a SECOND HTML table listing vocabulary upgrades with 2 columns: 'Kosa Kata Asli' (Original Vocabulary) and 'Kosa Kata yang Lebih Baik' (Band 9 Alternative). This second table MUST contain AT LEAST 10 ROWS of vocabulary upgrades.
- 'grammatical_range_score': (number)
- 'grammatical_range': (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table (<table>...</table>) containing detailed feedback.
- 'overall_comment': (string) General feedback. If under 250 words, mention the word count penalty here too.
- 'band_9_version': (string) A complete Band 9 version of the essay answering the same prompt. It MUST be at least 250 words. It MUST have distinct paragraphs, and you MUST wrap EVERY single paragraph with <p class=\"mb-4\"> and </p> tags to ensure proper spacing.
- 'correction_html': (string) The FULL original essay text, paragraph by paragraph using <p> tags. Wrap errors in <del>error</del> and corrections in <ins>correction</ins>.";

        $providers = ['sambanova', 'gemini', 'openrouter'];
        $feedback = [];

        foreach ($providers as $provider) {
            $keys = \App\Services\AiProviderKeyManager::getKeys($provider);
            if (empty($keys)) {
                continue;
            }

            foreach ($keys as $index => $key) {
                try {
                    $response = null;
                    if ($provider === 'sambanova') {
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                            'Content-Type' => 'application/json'
                        ])->timeout(60)->post('https://api.sambanova.ai/v1/chat/completions', [
                            'model' => 'Meta-Llama-3.3-70B-Instruct',
                            'messages' => [
                                ['role' => 'system', 'content' => $systemOverride],
                                ['role' => 'user', 'content' => $answerText]
                            ],
                            'response_format' => ['type' => 'json_object']
                        ]);
                    } elseif ($provider === 'gemini') {
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json'
                        ])->timeout(60)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $key, [
                            'contents' => [
                                ['parts' => [
                                    ['text' => $systemOverride],
                                    ['text' => $answerText]
                                ]]
                            ],
                            'generationConfig' => [
                                'responseMimeType' => 'application/json',
                            ]
                        ]);
                    } elseif ($provider === 'openrouter') {
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $key,
                            'Content-Type' => 'application/json',
                            'HTTP-Referer' => 'https://targetbahasa.com',
                            'X-Title' => 'Target Bahasa Course'
                        ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
                            'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                            'messages' => [
                                ['role' => 'system', 'content' => $systemOverride],
                                ['role' => 'user', 'content' => $answerText]
                            ],
                            'response_format' => ['type' => 'json_object']
                        ]);
                    }

                    if ($response && $response->successful()) {
                        $rawContent = '';
                        if ($provider === 'gemini') {
                            $rawContent = $response->json('candidates.0.content.parts.0.text');
                        } else {
                            $rawContent = $response->json('choices.0.message.content');
                        }

                        $decoded = json_decode($rawContent, true);
                        if (!empty($decoded) && is_array($decoded)) {
                            Log::info("Writing Task 2 evaluation succeeded using provider: {$provider}");
                            return $decoded;
                        }
                    } else {
                        Log::warning("Writing Task 2: {$provider} key #{$index} failed. Status: " . ($response ? $response->status() : 'No response'));
                    }
                } catch (\Exception $e) {
                    Log::warning("Writing Task 2: {$provider} key #{$index} threw exception: " . $e->getMessage());
                }
            }
        }

        return null;
    }

    public function result($type, $id, $submission_id)
    {
        if ($submission_id === 'mock') {
            $bandScore = 7.5;
            $aiFeedback = [
                'overall_band_score' => $bandScore,
                'task_achievement_score' => $bandScore,
                'task_response_score' => $bandScore,
                'task_achievement' => '<p>Dummy Task Achievement summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                'task_response' => '<p>Dummy Task Response summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                'coherence_cohesion_score' => $bandScore,
                'coherence_cohesion' => '<p>Dummy Coherence summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                'lexical_resource_score' => $bandScore,
                'lexical_resource' => '<p>Dummy Lexical summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Good</td><td class="border border-gray-200 p-2">Excellent</td></tr></tbody></table>',
                'grammatical_range_score' => $bandScore,
                'grammatical_range' => '<p>Dummy Grammar summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
                'overall_comment' => 'This is a mock admin preview evaluation.',
                'band_9_version' => '<p>Dummy band 9 version.</p>',
                'correction_html' => '<p>Dummy <del>correction</del> <ins>html</ins>.</p>',
            ];
            $submission = (object) [
                'id' => 'mock',
                'name' => 'Admin Preview',
                'email' => 'admin@example.com',
                'whatsapp' => '08123456789',
                'test_type' => $type,
                'test_id' => $id,
                'ai_raw_json_feedback' => json_encode($aiFeedback),
                'created_at' => now(),
            ];
        } else {
            $submission = DB::table('free_test_submissions')->where('id', $submission_id)->first();
            if (!$submission) {
                abort(404);
            }
            // Decode the JSON feedback
            $aiFeedback = json_decode($submission->ai_raw_json_feedback, true);
        }

        // Fetch test prompt/questions based on type
        $prompt = '';
        if ($type === 'writing_t1' || $type === 'writing_t2') {
            $test = DB::table('ielts_writing_meetings')->where('id', $id)->first();
            $prompt = $test ? $test->prompt : '';
        } elseif ($type === 'speaking') {
            $test = DB::table('ielts_speaking_topics')->where('id', $id)->first();
            if ($test) {
                $q = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;
                $prompt = is_array($q) ? implode(' ', $q) : ($test->questions ?? '');
            } else {
                $prompt = '';
            }
        }

        return view('promo.result', compact('type', 'id', 'submission_id', 'submission', 'aiFeedback', 'prompt'));
    }

    public function sendWaResult(Request $request, $type, $id, $submission_id)
    {
        $request->validate([
            'whatsapp' => 'required|string|max:20'
        ]);

        $submission = DB::table('free_test_submissions')->where('id', $submission_id)->first();
        if (!$submission) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Update the WhatsApp number in the database for marketing purposes
        DB::table('free_test_submissions')
            ->where('id', $submission_id)
            ->update(['whatsapp_number' => $request->whatsapp]);

        $aiFeedback = json_decode($submission->ai_raw_json_feedback, true);
        
        $waNumber = $request->whatsapp;
        $message = "";

        if ($type === 'toefl') {
            $totalScore = $aiFeedback['total_score'] ?? 'N/A';
            $listening = $aiFeedback['listening_score'] ?? 'N/A';
            $structure = $aiFeedback['structure_score'] ?? 'N/A';
            $reading = $aiFeedback['reading_score'] ?? 'N/A';

            $message = "Halo! Berikut adalah summary hasil evaluasi Free Test TOEFL ITP Anda dari *Target Bahasa*:\n\n";
            $message .= "⭐️ *Total Score: {$totalScore}*\n\n";
            $message .= "Rincian Skor:\n";
            $message .= "- Listening Comprehension: {$listening}\n";
            $message .= "- Structure & Written Expression: {$structure}\n";
            $message .= "- Reading Comprehension: {$reading}\n\n";
            $message .= "Terus semangat belajar! Untuk panduan dan course TOEFL terbaik, segera hubungi admin Target Bahasa.";
        } elseif (in_array($type, ['toefl_listening', 'toefl_structure', 'toefl_reading'])) {
            $score = $aiFeedback['score'] ?? 'N/A';
            $sectionType = '';
            if ($type === 'toefl_listening') $sectionType = 'Listening Comprehension';
            if ($type === 'toefl_structure') $sectionType = 'Structure & Written Expression';
            if ($type === 'toefl_reading') $sectionType = 'Reading Comprehension';

            $message = "Halo! Berikut adalah summary hasil evaluasi Free Test TOEFL ITP Anda dari *Target Bahasa*:\n\n";
            $message .= "⭐️ *Section Score: {$score}*\n";
            $message .= "Tipe: {$sectionType}\n\n";
            $message .= "Terus semangat belajar! Untuk panduan dan course TOEFL terbaik, segera hubungi admin Target Bahasa.";
        } elseif (in_array($type, ['ielts_listening', 'ielts_reading_general', 'ielts_reading_academic'])) {
            $bandScore = $aiFeedback['band_score'] ?? 'N/A';

            $message = "Halo! Berikut adalah summary hasil evaluasi Free Test IELTS Anda dari *Target Bahasa*:\n\n";
            $message .= "⭐️ *Band Score: {$bandScore}*\n\n";
            $message .= "Terus semangat belajar! Untuk panduan dan course IELTS terbaik, segera hubungi admin Target Bahasa.";
        } else {
            // Default to IELTS formats (Writing/Speaking)
            $bandScore = $aiFeedback['overall_band_score'] ?? 'N/A';
            // Speaking uses pronunciation_score, writing uses task_response_score or task_achievement_score
            $taskScoreLabel = str_contains($type, 'speaking') ? 'Pronunciation' : 'Task Response';
            $coherenceLabel = str_contains($type, 'speaking') ? 'Fluency & Coherence' : 'Coherence/Cohesion';

            $taskScore = $aiFeedback['task_response_score'] ?? $aiFeedback['task_achievement_score'] ?? $aiFeedback['pronunciation_score'] ?? 'N/A';
            $coherence = $aiFeedback['coherence_cohesion_score'] ?? $aiFeedback['fluency_and_coherence_score'] ?? 'N/A';
            $lexical = $aiFeedback['lexical_resource_score'] ?? 'N/A';
            $grammar = $aiFeedback['grammatical_range_score'] ?? 'N/A';
            
            $saran = $aiFeedback['feedback'] ?? $aiFeedback['overall_comment'] ?? 'Terus tingkatkan latihan Anda.';
            
            $message = "Halo! Berikut adalah summary hasil evaluasi Free Test IELTS Anda dari *Target Bahasa*:\n\n";
            $message .= "⭐️ *Overall Band Score: {$bandScore}*\n\n";
            $message .= "Rincian Skor:\n";
            $message .= "- {$taskScoreLabel}: {$taskScore}\n";
            $message .= "- {$coherenceLabel}: {$coherence}\n";
            $message .= "- Lexical Resource: {$lexical}\n";
            $message .= "- Grammatical Range: {$grammar}\n\n";
            $message .= "Saran Perbaikan:\n{$saran}\n\n";
            
            if (str_contains($type, 'writing') && !empty($aiFeedback['correction_html'])) {
                $html = $aiFeedback['correction_html'];
                // Replace <del> with ~ for WhatsApp strikethrough
                $html = preg_replace('/<del[^>]*>(.*?)<\/del>/i', '~$1~', $html);
                // Replace <ins> with * for WhatsApp bold
                $html = preg_replace('/<ins[^>]*>(.*?)<\/ins>/i', '*$1*', $html);
                // Strip remaining HTML tags
                $html = strip_tags($html);
                $message .= "Detailed Text Analysis:\n{$html}\n\n";
            }
            
            $message .= "Terus semangat belajar! Untuk panduan dan course IELTS terbaik, segera hubungi admin Target Bahasa.";
        }

        try {
            $apiKey = config('services.whatsapp.fonnte.token') ?? env('FONNTE_API_KEY');
            if (empty($apiKey)) {
                 // Simulate success if no API key is provided but log it
                 \Log::warning("Fonnte API Key is not set. WhatsApp message was not actually sent to {$waNumber}");
                 return response()->json(['success' => true, 'message' => '(Simulasi) Hasil evaluasi berhasil dikirim ke WhatsApp Anda! Tambahkan API Key Fonnte di .env untuk fungsi asli.']);
            }

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $apiKey, 
            ])->post('https://api.fonnte.com/send', [
                'target' => $waNumber,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful() && $response->json('status')) {
                return response()->json(['success' => true, 'message' => 'Hasil evaluasi berhasil dikirim ke WhatsApp Anda!']);
            } else {
                \Log::error("Fonnte Error: " . $response->body());
                return response()->json(['success' => false, 'message' => 'Gagal mengirim pesan WhatsApp. Cek token Fonnte / limit.']);
            }
        } catch (\Exception $e) {
            \Log::error("Fonnte Exception: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem saat mengirim WhatsApp.']);
        }
    }

    private function evaluateSpeaking($topicId, $audioFiles, $questions = [])
    {
        $topic = DB::table('ielts_speaking_topics')->find($topicId);
        
        $systemOverride = $topic->system_prompt_override ?? "You are an expert IELTS Speaking examiner. Assess the candidate's speaking audio based on the official IELTS Speaking Band Descriptors: Fluency & Coherence, Lexical Resource, Grammatical Range & Accuracy, and Pronunciation. Assign precise band scores (0-9) and provide highly detailed, analytical feedback. Ensure your evaluation is rigorous and aligns strictly with the official public IELTS grading standards.";
        
        $systemOverride .= "\n\nCRITICAL INSTRUCTION: You must provide a LOT of specific, actionable suggestions for improvement based on the candidate's actual speaking. You MUST analyze the audio comprehensively from start to finish. Each table MUST contain AT LEAST 5 to 10 rows of detailed corrections and feedback.";
        $systemOverride .= "\n\nYOU MUST FORMAT YOUR DETAILED FEEDBACK STRINGS AS HTML TABLES. Present your actionable feedback using exactly this styled HTML table format for EACH criteria field:\n`<table class=\"w-full text-left border-collapse border border-gray-200 mt-4 mb-4\"><thead class=\"bg-gray-50\"><tr><th class=\"border border-gray-200 p-2\">Kutipan Lisan (English)</th><th class=\"border border-gray-200 p-2\">Masalah / Kesalahan</th><th class=\"border border-gray-200 p-2\">Penjelasan</th><th class=\"border border-gray-200 p-2\">Perbaikan (English)</th></tr></thead><tbody><tr><td class=\"border border-gray-200 p-2\">...</td>...</tr></tbody></table>`";
        $systemOverride .= "\nLanguage Rules for the Table: 'Kutipan Lisan' MUST be the exact transcribed snippet from the candidate's audio in English. 'Masalah / Kesalahan' and 'Penjelasan' MUST be entirely in Bahasa Indonesia. 'Perbaikan' MUST be the corrected snippet in English.";
        $systemOverride .= "\n\nYou MUST return a JSON object with EXACTLY the following keys:
- 'overall_band_score' (number)
- 'pronunciation_score' (number)
- 'pronunciation' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'fluency_and_coherence_score' (number)
- 'fluency_and_coherence' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'lexical_resource_score' (number)
- 'lexical_resource' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the main HTML table. THEN you MUST provide a SECOND HTML table listing vocabulary upgrades with 2 columns: 'Kosa Kata Asli' and 'Kosa Kata yang Lebih Baik'. This second table MUST contain AT LEAST 10 ROWS of vocabulary upgrades.
- 'grammatical_range_score' (number)
- 'grammatical_range' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'overall_comment' (string, general summary in Bahasa Indonesia)";

        $parts = [
            ['text' => $systemOverride]
        ];

        // Check if any valid audio is provided
        $hasAudio = false;
        foreach ($audioFiles as $audioFile) {
            if ($audioFile && $audioFile->getSize() > 0) {
                $hasAudio = true;
                break;
            }
        }

        if (!$hasAudio) {
            return [
                'overall_band_score' => 0,
                'pronunciation_score' => 0,
                'fluency_and_coherence_score' => 0,
                'lexical_resource_score' => 0,
                'grammatical_range_score' => 0,
                'pronunciation' => '<p>Anda tidak merekam audio apa pun. Oleh karena itu, tidak ada nilai yang dapat diberikan.</p>',
                'fluency_and_coherence' => '<p>Anda tidak merekam audio apa pun. Oleh karena itu, tidak ada nilai yang dapat diberikan.</p>',
                'lexical_resource' => '<p>Anda tidak merekam audio apa pun. Oleh karena itu, tidak ada nilai yang dapat diberikan.</p>',
                'grammatical_range' => '<p>Anda tidak merekam audio apa pun. Oleh karena itu, tidak ada nilai yang dapat diberikan.</p>',
                'overall_comment' => '<p>Tidak ada audio yang terekam. Pastikan mikrofon Anda berfungsi dengan baik.</p>',
            ];
        }

        foreach ($audioFiles as $index => $audioFile) {
            if (isset($questions[$index])) {
                $parts[] = ['text' => "Question: " . $questions[$index]];
            }
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $audioFile->getMimeType(),
                    'data' => base64_encode(file_get_contents($audioFile->getRealPath()))
                ]
            ];
        }
        $geminiKeys = AiProviderKeyManager::getKeys('gemini');
        $feedback = [];

        foreach ($geminiKeys as $index => $key) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $key, [
                'contents' => [
                    ['parts' => $parts]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $rawContent = $response->json('candidates.0.content.parts.0.text');
                $feedback = json_decode($rawContent, true) ?? [];
                break;
            }
            Log::warning("Gemini key #{$index} failed in evaluateSpeaking");
        }

        return $feedback;
    }

    public function updateAdmin(Request $request, $type, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        if (!str_starts_with($type, 'writing')) {
            abort(400, 'Only writing tests are supported for this action');
        }

        $testConfig = DB::table('ielts_writing_meetings')->where('id', $id)->first();
        if (!$testConfig) {
            abort(404);
        }

        $updateData = [];

        if ($request->has('prompt')) {
            $updateData['prompt'] = $request->input('prompt');
        }

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:svg,png,jpg,jpeg|max:2048'
            ]);
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/promo'), $filename);
            $updateData['image'] = 'images/promo/' . $filename;
        }

        if (!empty($updateData)) {
            DB::table('ielts_writing_meetings')->where('id', $id)->update($updateData);
        }

        return redirect()->back()->with('success', 'Test updated successfully');
    }

    public function getEchomimicAvatar()
    {
        $script = storage_path('app/scripts/echomimic.py');
        $output = shell_exec("python3 " . escapeshellarg($script) . " 2>&1");
        $decoded = json_decode($output, true);
        
        if ($decoded && isset($decoded['success']) && $decoded['success']) {
            $videoPath = $decoded['video_path'] ?? null;
            if ($videoPath && file_exists($videoPath)) {
                $publicDir = public_path('avatars');
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
                
                $publicName = 'avatar_' . md5($videoPath) . '.mp4';
                copy($videoPath, $publicDir . '/' . $publicName);
                
                return response()->json([
                    'success' => true, 
                    'url' => asset('avatars/' . $publicName)
                ]);
            }
        }
        
        return response()->json([
            'success' => false, 
            'error' => 'Failed to fetch avatar from Hugging Face',
            'output' => $output
        ]);
    }
    public function showIeltsListeningPromo(Request $request, $meeting, $test)
    {
        $meetingModel = \App\Models\Meeting::where('program_id', \App\Models\Program::where('slug', 'ielts-academic-listening')->value('id'))
            ->where('meeting_number', $meeting)
            ->firstOrFail();

        // Check promo status
        if (!$meetingModel->is_free_tier || 
            ($meetingModel->promo_start && \Carbon\Carbon::parse($meetingModel->promo_start)->isFuture()) || 
            ($meetingModel->promo_deadline && \Carbon\Carbon::parse($meetingModel->promo_deadline)->isPast())) {
            return view('promo.expired');
        }

        $section = $meetingModel->ieltsSections->where('section_number', $meeting)->first();

        return view('assignments.ielts.mockup.listening-promo', [
            'meetingNumber' => $meeting,
            'testId' => $test,
            'title' => $meetingModel->title,
            'section' => $section,
        ]);
    }

    public function submitIeltsListeningPromo(Request $request, $meeting, $test)
    {
        // Simple success redirect for promo test
        return redirect()->back()->with('success', 'Your IELTS Listening answers have been submitted successfully!');
    }

    public function showToeflListening()
    {
        // Meeting 21 is the free tier listening meeting
        $number = 21;
        $mockupViewData = app(\App\Application\ToeflMockup\BuildMockupPackageViewData::class)->handle(1);
        $mockupViewData['isFullMockTest'] = false;
        $mockupViewData['packageMode'] = true;
        $mockupViewData['listeningSubmitRoute'] = route('promo.test.toefl_listening.submit');
        $mockupViewData['promoMode'] = true;

        return view('assignments.toefl-itp.mockup', $mockupViewData);
    }

    public function submitToeflListening(\Illuminate\Http\Request $request)
    {
        $number = 21;
        $userId = auth()->id();
        if (!$userId && session()->has('quick_guest_id')) {
            $userId = session('quick_guest_id');
        }

        if (!$userId) {
            return redirect()->back()->with('error', 'Authentication expired. Please try again.');
        }

        $answers = $request->all();
        $submitter = app(\App\Application\ToeflListening\SubmitListeningMeeting::class);
        $result = $submitter->handle($number, $userId, null, $answers);

        return redirect()->route('promo.test.toefl_listening')
            ->with('success', "Score: {$result['score']}% ({$result['correct_count']}/{$result['total_question']} correct)")
            ->with('score_data', $result);
    }
}
