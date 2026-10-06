<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiManagementController extends Controller
{
    /**
     * All AI configurations used in this project.
     */
    private function getAiConfig(): array
    {
        return [
            'providers' => [
                [
                    'id'          => 'groq',
                    'name'        => 'Groq',
                    'logo'        => 'https://groq.com/favicon.ico',
                    'website'     => 'https://console.groq.com',
                    'account'     => env('MAIL_FROM_ADDRESS', '—'),
                    'api_key_env' => 'GROQ_API_KEY',
                    'api_key'     => env('GROQ_API_KEY'),
                    'status_url'  => 'https://api.groq.com/openai/v1/models',
                    'models' => [
                        [
                            'name'      => 'openai/gpt-oss-120b',
                            'use_case'  => 'High-capacity reasoning & grading (GPT OSS 120B)',
                        ],
                        [
                            'name'      => 'qwen/qwen3.8-27b',
                            'use_case'  => 'Qwen 3.8 27B fast instruction following & grading',
                        ],
                        [
                            'name'      => 'openai/gpt-oss-20b',
                            'use_case'  => 'General AI Chat & quick collocations/translations',
                        ],
                    ],
                    'functions' => [
                        'IELTS Writing Task 2 full rubric grading (Task Response, Coherence, Lexical, Grammar)',
                        'General AI assistant / chat endpoint',
                        'Collocation & vocabulary lookup',
                        'Grammar translation helper',
                        'Listening Machine — script humanisation & question generation',
                    ],
                ],
                [
                    'id'          => 'sambanova',
                    'name'        => 'SambaNova Cloud',
                    'logo'        => 'https://sambanova.ai/favicon.ico',
                    'website'     => 'https://cloud.sambanova.ai',
                    'account'     => env('MAIL_FROM_ADDRESS', '—'),
                    'api_key_env' => 'SAMBANOVA_API_KEY',
                    'api_key'     => env('SAMBANOVA_API_KEY'),
                    'status_url'  => null,
                    'models' => [
                        [
                            'name'      => 'DeepSeek-V3.1',
                            'use_case'  => 'IELTS Writing Task 1 — Task Achievement evaluation',
                        ],
                        [
                            'name'      => 'Meta-Llama-3.3-70B-Instruct',
                            'use_case'  => 'IELTS Writing Task 1 — Grammar, Lexical & Coherence evaluation',
                        ],
                    ],
                    'functions' => [
                        'IELTS Writing Task 1 parallel evaluation (Task Achievement + Grammar/Lexical/Coherence)',
                    ],
                ],
                [
                    'id'          => 'google',
                    'name'        => 'Google Gemini',
                    'logo'        => 'https://www.google.com/favicon.ico',
                    'website'     => 'https://aistudio.google.com',
                    'account'     => env('MAIL_FROM_ADDRESS', '—'),
                    'api_key_env' => 'GEMINI_API_KEY',
                    'api_key'     => env('GEMINI_API_KEY'),
                    'status_url'  => null,
                    'models' => [
                        [
                            'name'      => 'gemini-3.6-flash',
                            'use_case'  => 'IELTS Speaking evaluation (pronunciation, fluency, lexical, grammar)',
                        ],
                    ],
                    'functions' => [
                        'IELTS Speaking full evaluation from audio transcripts',
                        'Speaking model answer generation',
                        'Fluency & pronunciation analysis',
                        'Hybrid AI fallback (when Groq is busy)',
                    ],
                ],
                [
                    'id'          => 'fonnte',
                    'name'        => 'Fonnte (WhatsApp API)',
                    'logo'        => 'https://fonnte.com/favicon.ico',
                    'website'     => 'https://fonnte.com',
                    'account'     => config('services.whatsapp.fonnte.token') ? '—' : '(not configured)',
                    'api_key_env' => 'FONNTE_TOKEN',
                    'api_key'     => config('services.whatsapp.fonnte.token'),
                    'status_url'  => null,
                    'models' => [],
                    'functions' => [
                        'Send IELTS/TOEFL evaluation results via WhatsApp to students after promo test',
                        'WhatsApp outbound notifications (broadcast, reminders)',
                    ],
                ],
                [
                    'id'          => 'listening_machine',
                    'name'        => 'Listening Machine API (Local)',
                    'logo'        => null,
                    'website'     => env('LISTENING_MACHINE_API_URL'),
                    'account'     => 'Self-hosted (localhost)',
                    'api_key_env' => 'LISTENING_MACHINE_API_URL',
                    'api_key'     => env('LISTENING_MACHINE_API_URL'),
                    'status_url'  => env('LISTENING_MACHINE_API_URL') . '/health',
                    'models' => [
                        [
                            'name'      => 'Kokoro TTS',
                            'use_case'  => 'Text-to-Speech for IELTS Listening materials (UK/US/AU accents)',
                        ],
                    ],
                    'functions' => [
                        'Text-to-Speech synthesis for listening material audio files',
                        'Multi-speaker dialogue generation (Male + Female voices)',
                        'Background ambient sound mixing (Café, Airport, Office, etc.)',
                    ],
                ],
            ],
        ];
    }

    public function index()
    {
        $config = $this->getAiConfig();

        // Load per-feature Groq keys from DB settings
        $groqFeatureKeys = [
            'general'   => \DB::table('settings')->where('key', 'groq_keys_general')->value('value') ?? '',
            'writing'   => \DB::table('settings')->where('key', 'groq_keys_writing')->value('value') ?? '',
            'speaking'  => \DB::table('settings')->where('key', 'groq_keys_speaking')->value('value') ?? '',
            'listening' => \DB::table('settings')->where('key', 'groq_keys_listening')->value('value') ?? '',
        ];

        // Load other provider keys
        $otherProviderKeys = [
            'sambanova'   => \DB::table('settings')->where('key', 'sambanova_keys')->value('value') ?? '',
            'openrouter'  => \DB::table('settings')->where('key', 'openrouter_keys')->value('value') ?? '',
            'deepinfra'   => \DB::table('settings')->where('key', 'deepinfra_keys')->value('value') ?? '',
            'huggingface' => \DB::table('settings')->where('key', 'huggingface_keys')->value('value') ?? '',
            'cerebras'    => \DB::table('settings')->where('key', 'cerebras_keys')->value('value') ?? '',
            'gemini'      => \DB::table('settings')->where('key', 'gemini_keys')->value('value') ?? '',
        ];

        // Check Local API Status
        $localApiStatus = false;
        try {
            $context = stream_context_create(['http' => ['timeout' => 1]]);
            $statusJson = @file_get_contents('http://127.0.0.1:8100/health', false, $context);
            if ($statusJson) {
                $statusData = json_decode($statusJson, true);
                if (isset($statusData['status']) && $statusData['status'] === 'ok') {
                    $localApiStatus = true;
                }
            }
        } catch (\Exception $e) {}

        return view('admin.ai-management.index', compact('config', 'groqFeatureKeys', 'otherProviderKeys', 'localApiStatus'));
    }

    public function updateKey(Request $request)
    {
        $key   = $request->input('key');
        $value = $request->input('value');

        $allowedKeys = ['GROQ_API_KEY', 'SAMBANOVA_API_KEY', 'GEMINI_API_KEY', 'FONNTE_TOKEN', 'WABLAS_TOKEN', 'WABLAS_DOMAIN'];
        if (!in_array($key, $allowedKeys)) {
            return back()->with('error', 'Key tidak diizinkan.');
        }

        $envPath     = base_path('.env');
        $envContents = file_get_contents($envPath);

        if (preg_match("/^{$key}=.*/m", $envContents)) {
            $envContents = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContents);
        } else {
            $envContents .= "\n{$key}=\"{$value}\"";
        }

        file_put_contents($envPath, $envContents);

        return back()->with('success', "API key {$key} berhasil diperbarui.");
    }

    /**
     * Save per-feature Groq key pools (stored in DB settings).
     */
    public function saveGroqKeys(Request $request)
    {
        $features = ['general', 'writing', 'speaking', 'listening'];
        $updated  = [];

        foreach ($features as $feature) {
            $rawValue = $request->input("groq_{$feature}", '');

            // Normalise: trim each key, remove blanks
            $keys = array_filter(array_map('trim', explode(',', $rawValue)));
            $value = implode(',', $keys);

            \DB::table('settings')->updateOrInsert(
                ['key' => "groq_keys_{$feature}"],
                ['value' => $value]
            );

            $updated[] = ucfirst($feature);
        }

        // Flush cache so changes take effect immediately
        \App\Services\GroqKeyManager::flushCache();

        // Also bust the global settings cache
        \Illuminate\Support\Facades\Cache::forget('app_settings');

        return back()->with('success', 'Groq key pools berhasil diperbarui untuk: ' . implode(', ', $updated) . '. Cache telah di-refresh.');
    }

    /**
     * Save key pools for other AI providers (SambaNova, Gemini, OpenRouter, etc.)
     */
    public function saveOtherProviderKeys(Request $request)
    {
        $providers = ['sambanova', 'openrouter', 'deepinfra', 'huggingface', 'cerebras', 'gemini'];
        $updated   = [];

        foreach ($providers as $provider) {
            $rawValue = $request->input("{$provider}_keys", '');

            // Normalise: trim each key, remove blanks
            $keys = array_filter(array_map('trim', explode(',', $rawValue)));
            $value = implode(',', $keys);

            \DB::table('settings')->updateOrInsert(
                ['key' => "{$provider}_keys"],
                ['value' => $value]
            );

            \App\Services\AiProviderKeyManager::flushCache($provider);
            $updated[] = ucfirst($provider);
        }

        // Bust the global settings cache
        \Illuminate\Support\Facades\Cache::forget('app_settings');

        return back()->with('success', 'API key pools untuk provider berhasil diperbarui: ' . implode(', ', $updated) . '. Cache telah di-refresh.');
    }

    /**
     * Toggle the Local TTS Python API Server (Start/Stop via bash script)
     */
    public function toggleLocalApi(Request $request)
    {
        $action     = $request->input('action'); // 'start' or 'stop'
        $scriptPath = base_path('api-manager.sh');

        if (!file_exists($scriptPath)) {
            return response()->json(['success' => false, 'message' => 'API Manager script not found at ' . $scriptPath], 404);
        }

        if (!in_array($action, ['start', 'stop'])) {
            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
        }

        // Run script
        shell_exec("bash {$scriptPath} {$action} 2>&1");

        // Wait a moment then verify actual state
        sleep($action === 'start' ? 3 : 1);

        $isOnline = $this->isTtsServerOnline();

        if ($action === 'start') {
            $message = $isOnline
                ? '✅ Server TTS berhasil dinyalakan!'
                : '⏳ Server sedang menyala. Model AI sedang di-load, tunggu ~10 detik.';
        } else {
            $message = !$isOnline
                ? '🛑 Server TTS berhasil dimatikan. RAM kembali lega!'
                : '⚠️ Server masih berjalan. Coba matikan lagi.';
        }

        return response()->json([
            'success' => true,
            'online'  => $isOnline,
            'message' => $message,
        ]);
    }

    /**
     * Check TTS server status
     */
    public function ttsServerStatus()
    {
        $online = $this->isTtsServerOnline();
        return response()->json(['online' => $online]);
    }

    private function isTtsServerOnline(): bool
    {
        $apiUrl = rtrim(env('LISTENING_MACHINE_API_URL', 'http://127.0.0.1:8100'), '/');
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(3)->get("{$apiUrl}/health");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}

