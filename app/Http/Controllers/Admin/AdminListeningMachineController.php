<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListeningBank;
use App\Models\ListeningQuestion;
use App\Services\GroqKeyManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminListeningMachineController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  CONSTANTS
    // ─────────────────────────────────────────────────────────────────────────

    private const GROQ_URL  = 'https://api.groq.com/openai/v1/chat/completions';
    private const GROQ_MODEL = 'llama-3.3-70b-versatile';

    private const LEVELS  = ['Band 4', 'Band 5', 'Band 6', 'Band 7', 'Band 8', 'Band 9', 'TOEFL 400', 'TOEFL 500', 'TOEFL 600'];
    private const ACCENTS = ['UK', 'US', 'AUS', 'NZ'];
    private const VOICES  = ['Single Male', 'Single Female', 'Mixed (Male + Female)', 'Mixed (Male + Male)', 'Mixed (Female + Female)'];
    private const BACKGROUNDS = ['none', 'cafe', 'airport', 'library', 'office', 'classroom', 'street', 'custom_upload'];

    private const ENGINES = ['Kokoro', 'F5-TTS', 'XTTS', 'ChatTTS'];

    // Kokoro voice IDs  (https://huggingface.co/hexgrad/Kokoro-82M)
    private const KOKORO_VOICES = [
        'af_heart'  => 'Female – Heart (US)',
        'af_bella'  => 'Female – Bella (US)',
        'af_sarah'  => 'Female – Sarah (US)',
        'am_adam'   => 'Male – Adam (US)',
        'am_michael'=> 'Male – Michael (US)',
        'bf_emma'   => 'Female – Emma (UK)',
        'bf_isabella'=> 'Female – Isabella (UK)',
        'bm_george' => 'Male – George (UK)',
        'bm_lewis'  => 'Male – Lewis (UK)',
    ];

    private const F5_VOICES = [
        'f5_female_1' => 'F5 Female 1',
        'f5_female_2' => 'F5 Female 2',
        'f5_male_1'   => 'F5 Male 1',
        'f5_male_2'   => 'F5 Male 2',
    ];

    private const XTTS_VOICES = [
        'Claribel Dervla' => 'Claribel Dervla (Female)',
        'Daisy Studious'  => 'Daisy Studious (Female)',
        'Craig Goya'      => 'Craig Goya (Male)',
        'Damien Black'    => 'Damien Black (Male)',
    ];

    private const CHATTTS_SEEDS = [
        'seed_100' => 'Seed 100 (Female)',
        'seed_200' => 'Seed 200 (Female)',
        'seed_300' => 'Seed 300 (Male)',
        'seed_400' => 'Seed 400 (Male)',
    ];

    // ─────────────────────────────────────────────────────────────────────────
    //  CRUD VIEWS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Dashboard – paginated list.
     */
    public function index(Request $request)
    {
        $banks = ListeningBank::query()
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%")
                ->orWhere('topic', 'like', "%{$s}%"))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->level,  fn ($q, $l) => $q->where('level', $l))
            ->withCount('questions')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'      => ListeningBank::count(),
            'ready'      => ListeningBank::where('status', 'ready')->count(),
            'processing' => ListeningBank::where('status', 'processing')->count(),
            'draft'      => ListeningBank::where('status', 'draft')->count(),
        ];

        return view('admin.listening-machine.index', compact('banks', 'stats'));
    }

    /**
     * Creation wizard form.
     */
    public function create()
    {
        return view('admin.listening-machine.create', [
            'engines'      => self::ENGINES,
            'levels'       => self::LEVELS,
            'accents'      => self::ACCENTS,
            'voices'       => self::VOICES,
            'backgrounds'  => self::BACKGROUNDS,
            'kokoroVoices' => self::KOKORO_VOICES,
            'f5Voices'     => self::F5_VOICES,
            'xttsVoices'   => self::XTTS_VOICES,
            'chatttsSeeds' => self::CHATTTS_SEEDS,
        ]);
    }

    /**
     * Persist a draft bank (called by the wizard's final Save step).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'level'                => 'required|string',
            'topic'                => 'nullable|string|max:255',
            'accent'               => 'required|string',
            'voice'                => 'required|string',
            'background_sound'     => 'required|string',
            'transcript'           => 'required|string',
            'humanized_transcript' => 'nullable|string',
            'audio_path'           => 'nullable|string',
            'duration'             => 'nullable|integer',
            'questions'            => 'nullable|array',
            'questions.*.type'           => 'required_with:questions|string',
            'questions.*.question_text'  => 'required_with:questions|string',
            'questions.*.options'        => 'nullable|array',
            'questions.*.correct_answer' => 'required_with:questions|string',
            'questions.*.explanation'    => 'nullable|string',
        ]);

        $status = 'draft';
        if (!empty($validated['audio_path'])) {
            $status = 'ready';
        }

        $bank = ListeningBank::create([
            'title'                => $validated['title'],
            'level'                => $validated['level'],
            'topic'                => $validated['topic'] ?? null,
            'accent'               => $validated['accent'],
            'voice'                => $validated['voice'],
            'background_sound'     => $validated['background_sound'],
            'transcript'           => $validated['transcript'],
            'humanized_transcript' => $validated['humanized_transcript'] ?? null,
            'audio'                => $validated['audio_path'] ?? null,
            'duration'             => $validated['duration'] ?? null,
            'status'               => $status,
        ]);

        // Bulk-insert questions
        if (!empty($validated['questions'])) {
            $rows = collect($validated['questions'])->map(fn ($q, $i) => [
                'listening_bank_id' => $bank->id,
                'type'              => $q['type'],
                'question_text'     => $q['question_text'],
                'options'           => isset($q['options']) ? json_encode($q['options']) : null,
                'correct_answer'    => $q['correct_answer'],
                'explanation'       => $q['explanation'] ?? null,
                'order'             => $i + 1,
                'created_at'        => now(),
                'updated_at'        => now(),
            ])->toArray();

            ListeningQuestion::insert($rows);
        }

        return redirect()
            ->route('admin.listening-machine.show', $bank)
            ->with('success', 'Listening Bank berhasil disimpan!');
    }

    /**
     * Detail view for a single bank.
     */
    public function show(ListeningBank $bank)
    {
        $bank->load('questions');
        return view('admin.listening-machine.show', compact('bank'));
    }

    /**
     * Delete bank + audio file.
     */
    public function destroy(ListeningBank $bank)
    {
        if ($bank->audio && Storage::disk('public')->exists($bank->audio)) {
            Storage::disk('public')->delete($bank->audio);
        }
        $bank->delete();

        return redirect()
            ->route('admin.listening-machine.index')
            ->with('success', 'Listening Bank dihapus.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 1 — HUMANIZE TRANSCRIPT
    // ─────────────────────────────────────────────────────────────────────────

    public function humanize(Request $request)
    {
        $request->validate([
            'transcript'    => 'required|string|min:50',
            'voice_mode'    => 'required|string',
            'level'         => 'required|string',
            'accent'        => 'required|string',
            'custom_prompt' => 'nullable|string|max:500',
        ]);

        $voiceType = strtolower($request->voice_mode);
        $isSingle = str_contains($voiceType, 'single');
        
        if ($isSingle) {
            $gender = str_contains($voiceType, 'female') ? 'female' : 'male';
            $speakerDir = 'as a single ' . $gender . ' narrator speaking in a ' . $request->accent . ' accent';
        } else {
            if (str_contains($voiceType, 'male + male')) {
                $dialogueType = '[Speaker A] (male) and [Speaker B] (male)';
            } elseif (str_contains($voiceType, 'female + female')) {
                $dialogueType = '[Speaker A] (female) and [Speaker B] (female)';
            } else {
                $dialogueType = '[Speaker A] (female) and [Speaker B] (male)';
            }
            $speakerDir = 'as a natural dialogue between ' . $dialogueType . ' in ' . $request->accent . ' accent. Each turn must start with [Speaker A]: or [Speaker B]: on a new line.';
        }

        $systemPrompt = <<<PROMPT
You are an expert IELTS/TOEFL listening script writer. Your task is to rewrite a raw transcript into a natural, exam-quality listening script.

Rules:
1. Maintain the same core information — do NOT invent new facts.
2. ALWAYS start the script with a [Moderator]: reading a short introductory context (e.g., "Listen to a conversation between a student and a professor...", or "Listen to a lecture about...").
3. Add natural fillers where appropriate: "well", "um", "actually", "you know", "right", "I see", "that's right", "exactly", etc.
4. Use contractions naturally (e.g. "it's", "we're", "I'd", "doesn't").
5. Style it {$speakerDir}.
6. Target language level: {$request->level}. Match vocabulary and sentence complexity accordingly.
7. Length should be 200-350 words for a proper exam audio section.
8. Output ONLY the rewritten script. No preamble, no explanations.
PROMPT;

        // Append user custom instructions if provided
        $customPrompt = trim($request->input('custom_prompt', ''));
        if ($customPrompt !== '') {
            $systemPrompt .= "\n\nAdditional user instructions (follow these carefully):\n" . $customPrompt;
        }

        try {
            $result = GroqKeyManager::callWithFallback('listening', [
                'model'       => self::GROQ_MODEL,
                'temperature' => 0.7,
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => "Raw transcript:\n\n" . $request->transcript],
                ],
            ], 60);

            $humanized = trim($result['body']['choices'][0]['message']['content'] ?? '');

            // Detect speakers from the rewritten text
            preg_match_all('/\[(Speaker [A-Z]|Moderator)\]:/i', $humanized, $matches);
            $speakerTags = array_unique($matches[0] ?? []);

            return response()->json([
                'success'       => true,
                'humanized'     => $humanized,
                'speaker_tags'  => $speakerTags,
                'is_dialogue'   => count($speakerTags) > 1,
                'key_used'      => $result['key_used'],
            ]);

        } catch (\Exception $e) {
            Log::error('Humanize exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 2a — GENERATE SPEECH (Kokoro TTS via Python microservice)
    // ─────────────────────────────────────────────────────────────────────────

    public function generateAudio(Request $request)
    {
        set_time_limit(30);

        $request->validate([
            'file_id'              => 'required|string',
            'humanized_transcript' => 'required|string',
            'speakers'             => 'required|array|min:1',
            'speakers.*.tag'       => 'required|string',
            'speakers.*.voice_id'  => 'required|string',
            'engine'               => 'nullable|string',
        ]);

        $apiUrl = rtrim(env('LISTENING_MACHINE_API_URL', 'http://127.0.0.1:8100'), '/');
        $fileId = $request->input('file_id');

        try {
            $response = Http::timeout(15)
                ->post("{$apiUrl}/api/generate-speech", [
                    'job_id'   => $fileId,
                    'text'     => $request->humanized_transcript,
                    'speakers' => $request->speakers,
                    'engine'   => $request->input('engine', 'Kokoro'),
                ]);

            if (!$response->successful()) {
                $detail = $response->json('detail') ?? $response->body();
                return response()->json(['error' => "Speech generation failed: {$detail}"], 500);
            }

            // Python returns immediately — job is running in background
            return response()->json([
                'success' => true,
                'status'  => 'processing',
                'file_id' => $fileId,
            ]);

        } catch (\Exception $e) {
            Log::error('generateAudio exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 2b — GENERATE SFX (AudioGen via Python microservice)
    // ─────────────────────────────────────────────────────────────────────────

    public function generateSfx(Request $request)
    {
        set_time_limit(30);

        $request->validate([
            'file_id'    => 'required|string',
            'sfx_prompt' => 'required|string|min:3',
            'duration'   => 'nullable|integer|min:5|max:30',
        ]);

        $apiUrl = rtrim(env('LISTENING_MACHINE_API_URL', 'http://127.0.0.1:8100'), '/');
        $fileId = $request->input('file_id');

        try {
            $response = Http::timeout(15)
                ->post("{$apiUrl}/api/generate-sfx", [
                    'job_id'   => $fileId,
                    'prompt'   => $request->sfx_prompt,
                    'duration' => $request->input('duration', 10),
                ]);

            if (!$response->successful()) {
                $detail = $response->json('detail') ?? $response->body();
                return response()->json(['error' => "SFX generation failed: {$detail}"], 500);
            }

            return response()->json([
                'success' => true,
                'status'  => 'processing',
                'file_id' => $fileId,
            ]);

        } catch (\Exception $e) {
            Log::error('generateSfx exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 2c — COMPILE AUDIO (Mix Speech + SFX)
    // ─────────────────────────────────────────────────────────────────────────

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 2b — UPLOAD CUSTOM SFX
    // ─────────────────────────────────────────────────────────────────────────

    public function uploadSfx(Request $request)
    {
        $request->validate([
            'file_id' => 'required|string',
            'audio'   => 'required|file|mimes:mp3,wav,m4a,ogg|max:20480',
        ]);

        $fileId = $request->input('file_id');
        $file = $request->file('audio');

        // Python expects {job_id}_sfx.wav
        $filename = "{$fileId}_sfx.wav";
        // We will store it in the same directory as generated audios
        $file->storeAs('public/listening-banks', $filename);

        return response()->json([
            'success' => true,
            'message' => 'Custom background sound uploaded successfully'
        ]);
    }

    public function compileAudio(Request $request)
    {
        set_time_limit(30);

        $request->validate([
            'file_id'    => 'required|string',
            'sfx_volume' => 'nullable|integer|min:-40|max:0',
        ]);

        $apiUrl = rtrim(env('LISTENING_MACHINE_API_URL', 'http://127.0.0.1:8100'), '/');
        $fileId = $request->input('file_id');

        try {
            $response = Http::timeout(15)
                ->post("{$apiUrl}/api/compile-audio", [
                    'job_id'     => $fileId,
                    'sfx_volume' => $request->input('sfx_volume', -15),
                ]);

            if (!$response->successful()) {
                $detail = $response->json('detail') ?? $response->body();
                return response()->json(['error' => "Compile failed: {$detail}"], 500);
            }

            // Python returns immediately — compile running in background
            return response()->json([
                'success' => true,
                'status'  => 'processing',
                'file_id' => $fileId,
            ]);

        } catch (\Exception $e) {
            Log::error('compileAudio exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: JOB STATUS PROXY  (avoids CORS — browser → Laravel → Python)
    // ─────────────────────────────────────────────────────────────────────────

    public function jobStatus(string $jobId)
    {
        $apiUrl = rtrim(env('LISTENING_MACHINE_API_URL', 'http://127.0.0.1:8100'), '/');
        try {
            $response = Http::timeout(5)->get("{$apiUrl}/api/job-status/{$jobId}");
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 3 — AUTO QUESTION GENERATOR
    // ─────────────────────────────────────────────────────────────────────────

    public function generateQuestions(Request $request)
    {
        $request->validate([
            'humanized_transcript' => 'required|string',
            'question_type'        => 'required|in:multiple_choice,true_false_not_given',
            'question_count'       => 'required|integer|min:3|max:10',
            'level'                => 'required|string',
        ]);

        $type  = $request->question_type;
        $count = (int) $request->question_count;

        if ($type === 'multiple_choice') {
            $formatInstructions = <<<INSTR
Each question must have exactly 4 options labeled A, B, C, D.
The "correct_answer" field must be a single letter: "A", "B", "C", or "D".
INSTR;
        } else {
            $formatInstructions = <<<INSTR
Each question is a statement. The "options" array should be ["True", "False", "Not Given"].
The "correct_answer" field must be exactly one of: "True", "False", or "Not Given".
"Not Given" means the information is not mentioned in the passage at all.
INSTR;
        }

        $systemPrompt = <<<PROMPT
You are an expert IELTS/TOEFL exam question writer. You will generate exam questions from a listening transcript.

IMPORTANT: You must respond with ONLY valid JSON matching this exact schema:
{
  "questions": [
    {
      "type": "{$type}",
      "question_text": "...",
      "options": ["..."],
      "correct_answer": "...",
      "explanation": "Brief explanation referencing the transcript."
    }
  ]
}

Rules:
- Generate exactly {$count} questions.
- Language level: {$request->level}.
- Questions must be based strictly on the provided transcript content.
- {$formatInstructions}
- Vary question styles: detail, inference, main idea, purpose, attitude.
- Do NOT include any text outside the JSON object.
PROMPT;

        try {
            $result = GroqKeyManager::callWithFallback('listening', [
                'model'           => self::GROQ_MODEL,
                'temperature'     => 0.4,
                'response_format' => ['type' => 'json_object'],
                'messages'        => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => "Listening transcript:\n\n" . $request->humanized_transcript],
                ],
            ], 90);

            $raw       = $result['body']['choices'][0]['message']['content'] ?? '{}';
            $decoded   = json_decode($raw, true);
            $questions = $decoded['questions'] ?? [];

            if (empty($questions)) {
                return response()->json(['error' => 'LLM returned no questions. Raw: ' . $raw], 500);
            }

            return response()->json([
                'success'   => true,
                'questions' => $questions,
                'key_used'  => $result['key_used'],
            ]);

        } catch (\Exception $e) {
            Log::error('Question generation exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  AJAX: STEP 4 — EXPORT AUDIO TO PUBLIC FOLDER
    // ─────────────────────────────────────────────────────────────────────────

    public function exportToPublic(Request $request)
    {
        $request->validate([
            'audio_path' => 'required|string',
            'class_type' => 'required|string',
            'level'      => 'required|string',
            'title'      => 'required|string',
        ]);

        if (!Storage::disk('public')->exists($request->audio_path)) {
            return response()->json(['error' => 'Audio file not found in storage. Ensure you generate audio first.'], 404);
        }

        // Determine destination based on class_type
        $classType = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $request->class_type));
        $targetDir = public_path('audio/' . $classType . '/listening');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Sanitize the title to create a clean filename
        $safeTitle = Str::slug($request->title);
        if (empty($safeTitle)) {
            $safeTitle = 'listening_audio_' . time();
        }
        $filename = $safeTitle . '.mp3';

        // Check for uniqueness to avoid overwriting
        $destPath = $targetDir . '/' . $filename;
        if (file_exists($destPath)) {
            $filename = $safeTitle . '_' . time() . '.mp3';
            $destPath = $targetDir . '/' . $filename;
        }

        $sourcePath = Storage::disk('public')->path($request->audio_path);
        
        try {
            copy($sourcePath, $destPath);
            return response()->json([
                'success' => true,
                'message' => 'Audio berhasil disalin ke folder: public/audio/' . $classType . '/listening/' . $filename
            ]);
        } catch (\Exception $e) {
            Log::error('Export Audio Exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyalin file: ' . $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Rough duration estimate: average speech rate ~130 words/minute.
     */
    private function estimateDuration(string $text): int
    {
        $words = str_word_count(strip_tags($text));
        return (int) ceil(($words / 130) * 60);
    }
}
