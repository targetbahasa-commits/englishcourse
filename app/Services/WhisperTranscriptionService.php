<?php

namespace App\Services;

use App\Services\GroqKeyManager;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

/**
 * WhisperTranscriptionService
 *
 * Transcribes an audio file using the local Whisper CLI,
 * then formats & translates the transcript using a multi-provider
 * AI chain: Groq → SambaNova → Gemini.
 *
 * Long SRT files are split into chunks so JSON output is never truncated.
 *
 * Returns:
 *   [
 *       'en'           => string|null,   // original English transcript (plain text)
 *       'id'           => string|null,   // AI-translated Indonesian
 *       'srt_en'       => string|null,   // raw SRT content (English)
 *       'formatted_en' => string|null,   // JSON-encoded dialogues array
 *       'formatted_id' => string|null,   // JSON-encoded dialogues array (with translation)
 *       'success'      => bool,
 *       'message'      => string,
 *   ]
 */
class WhisperTranscriptionService
{
    // ── Groq ─────────────────────────────────────────────────────────────────
    private const GROQ_URL   = 'https://api.groq.com/openai/v1/chat/completions';
    private const GROQ_MODEL = 'openai/gpt-oss-120b';

    // ── SambaNova ─────────────────────────────────────────────────────────────
    private const SAMBANOVA_URL   = 'https://api.sambanova.ai/v1/chat/completions';
    private const SAMBANOVA_MODEL = 'Meta-Llama-3.3-70B-Instruct'; // Large context, high-quality

    // ── Gemini (OpenAI-compatible endpoint) ───────────────────────────────────
    private const GEMINI_URL   = 'https://generativelanguage.googleapis.com/v1beta/openai/chat/completions';
    private const GEMINI_MODEL = 'gemini-3.6-flash';

    /**
     * Max SRT lines processed in a single AI call.
     * Groq has tight output limits; chunking avoids truncation.
     */
    private const CHUNK_SIZE_LINES = 60;

    // ─────────────────────────────────────────────────────────────────────────
    //  Public entry point
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * @param  string $audioPublicPath   Full public filesystem path to the audio file.
     * @param  string $outputDir         Directory where Whisper writes its .srt output.
     * @return array{en:string|null, id:string|null, srt_en:string|null, formatted_en:string|null, formatted_id:string|null, success:bool, message:string}
     */
    public function transcribeAndTranslate(string $audioPublicPath, string $outputDir): array
    {
        $result = [
            'en'           => null,
            'id'           => null,
            'srt_en'       => null,
            'formatted_en' => null,
            'formatted_id' => null,
            'success'      => false,
            'message'      => '',
        ];

        // ── Step 1: Whisper transcription ─────────────────────────────────────
        [$srtContent, $whisperMessage] = $this->runWhisper($audioPublicPath, $outputDir);

        if ($srtContent === null) {
            $result['message'] = $whisperMessage;
            return $result;
        }

        $result['srt_en']  = $srtContent;
        $englishText       = $this->srtToPlainText($srtContent);
        $result['en']      = $englishText;
        $result['success'] = true;
        $result['message'] = $whisperMessage;

        // ── Step 2: Format + translate with multi-provider AI ─────────────────
        if ($srtContent) {
            [$formattedEn, $formattedId, $aiMsg] = $this->formatAndTranslateTranscript($srtContent);

            $result['formatted_en'] = $formattedEn;
            $result['formatted_id'] = $formattedId;

            // Fallback: plain-text Indonesian translation if structured formatting failed
            if (!$formattedId) {
                [$idText] = $this->translateToIndonesian($englishText);
                $result['id'] = $idText;
            }

            if ($formattedId || $result['id']) {
                $result['message'] = 'Audio berhasil ditranskrip dan diterjemahkan.';
            } else {
                $result['message'] = 'Audio berhasil ditranskrip. Terjemahan gagal: ' . $aiMsg;
            }
        }

        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Whisper
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * @return array{string|null, string}  [srtContent|null, message]
     */
    private function runWhisper(string $audioPublicPath, string $outputDir): array
    {
        if (!file_exists($audioPublicPath)) {
            return [null, 'Audio file not found for transcription: ' . $audioPublicPath];
        }

        $whisperBin = $this->resolveWhisperBinary();

        if (!$whisperBin) {
            return [null, 'Whisper CLI not found. Run: pip install openai-whisper'];
        }

        $expectedSrtPath = $outputDir . '/' . pathinfo($audioPublicPath, PATHINFO_FILENAME) . '.srt';

        $command = [
            $whisperBin,
            $audioPublicPath,
            '--model', 'base',
            '--language', 'en',
            '--output_format', 'srt',
            '--output_dir', $outputDir,
            '--fp16', 'False',
        ];

        try {
            $process = new Process($command);

            // Ensure Homebrew and local binaries are in PATH so Whisper finds ffmpeg
            $currentPath = getenv('PATH') ?: '/usr/bin:/bin:/usr/sbin:/sbin';
            $process->setEnv(['PATH' => $currentPath . ':/opt/homebrew/bin:/usr/local/bin']);

            $process->setTimeout(600);
            $process->run();

            if ($process->isSuccessful() && file_exists($expectedSrtPath)) {
                $srtContent = file_get_contents($expectedSrtPath);
                @unlink($expectedSrtPath);
                return [$srtContent, 'Transkripsi Whisper berhasil.'];
            }

            Log::warning('Whisper transcription failed', [
                'exit_code' => $process->getExitCode(),
                'stderr'    => $process->getErrorOutput(),
                'audio'     => $audioPublicPath,
            ]);

            return [null, 'Whisper gagal: ' . trim($process->getErrorOutput())];

        } catch (\Exception $e) {
            Log::error('Whisper exception', ['error' => $e->getMessage()]);
            return [null, 'Whisper error: ' . $e->getMessage()];
        }
    }

    /**
     * Try common whisper binary paths.
     */
    private function resolveWhisperBinary(): ?string
    {
        $candidates = [
            'whisper',
            '/usr/local/bin/whisper',
            '/opt/homebrew/bin/whisper',
            base_path('venv/bin/whisper'),
            base_path('tools/listening-machine-api/venv/bin/whisper'),
        ];

        foreach ($candidates as $bin) {
            if ($bin === 'whisper') {
                $check = new Process(['which', 'whisper']);
                $check->run();
                if ($check->isSuccessful()) {
                    return 'whisper';
                }
                continue;
            }

            if (file_exists($bin)) {
                return $bin;
            }
        }

        return null;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  SRT parser helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Strip timecodes and sequence numbers from SRT → plain paragraph text.
     */
    public function srtToPlainText(string $srt): string
    {
        $text = preg_replace('/^\d+\s*$/m', '', $srt);
        $text = preg_replace('/\d{1,2}:\d{2}:\d{2}[,.]\d{1,3}\s*-->\s*\d{1,2}:\d{2}:\d{2}[,.]\d{1,3}/m', '', (string) $text);
        $text = preg_replace('/\n{2,}/', ' ', (string) $text);
        return trim((string) $text);
    }

    /**
     * Split SRT content into chunks of at most CHUNK_SIZE_LINES subtitle blocks.
     * Each SRT block is: index line + timecode line + text line(s) + blank line.
     *
     * @return string[]
     */
    private function splitSrtIntoChunks(string $srtContent): array
    {
        // Normalise line endings
        $srtContent = str_replace(["\r\n", "\r"], "\n", $srtContent);

        // Split on double newline (SRT block separator)
        $blocks = preg_split('/\n{2,}/', trim($srtContent));
        $blocks = array_values(array_filter($blocks));

        $chunks = [];
        for ($i = 0; $i < count($blocks); $i += self::CHUNK_SIZE_LINES) {
            $slice    = array_slice($blocks, $i, self::CHUNK_SIZE_LINES);
            $chunks[] = implode("\n\n", $slice);
        }

        return $chunks;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Multi-provider AI call
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Call AI with fallback chain: Groq → SambaNova → Gemini.
     * Returns the raw content string on success, or null on total failure.
     *
     * @param  array  $payload   Messages array + model options (model key will be overridden per provider)
     * @param  int    $timeout
     * @return array{string|null, string}  [content|null, errorMessage]
     */
    private function callAiWithFallback(array $payload, int $timeout = 150): array
    {
        $providers = $this->buildProviderChain();
        $lastError = 'No providers available.';

        foreach ($providers as $providerName => $providerConfig) {
            try {
                $callPayload          = $payload;
                $callPayload['model'] = $providerConfig['model'];

                // SambaNova does not support response_format json_object — remove it
                if ($providerName === 'sambanova' || $providerName === 'gemini') {
                    unset($callPayload['response_format']);
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $providerConfig['key'],
                    'Content-Type'  => 'application/json',
                ])->timeout($timeout)->post($providerConfig['url'], $callPayload);

                if (!$response->successful()) {
                    $lastError = "{$providerName} HTTP {$response->status()}";
                    Log::warning("AI fallback: {$providerName} returned HTTP {$response->status()}");
                    continue;
                }

                $body    = $response->json();
                $content = trim($body['choices'][0]['message']['content'] ?? '');

                if (!$content) {
                    $lastError = "{$providerName} returned empty content";
                    Log::warning("AI fallback: {$providerName} returned empty content");
                    continue;
                }

                Log::info("AI fallback: succeeded with provider [{$providerName}]");
                return [$content, ''];

            } catch (\Exception $e) {
                $lastError = "{$providerName}: " . $e->getMessage();
                Log::warning("AI fallback: {$providerName} threw exception: " . $e->getMessage());
                continue;
            }
        }

        return [null, "All AI providers failed. Last error: {$lastError}"];
    }

    /**
     * Build the ordered provider chain based on available API keys.
     *
     * @return array<string, array{url:string, model:string, key:string}>
     */
    private function buildProviderChain(): array
    {
        $chain = [];

        // 1. Groq (primary)
        $groqKeys = GroqKeyManager::getKeysForFeature('listening');
        if (!empty($groqKeys)) {
            $chain['groq'] = [
                'url'   => self::GROQ_URL,
                'model' => self::GROQ_MODEL,
                'key'   => $groqKeys[0],
            ];
        }

        // 2. SambaNova (first fallback — large context, no truncation)
        $sambanovaKey = env('SAMBANOVA_API_KEY');
        if ($sambanovaKey) {
            $chain['sambanova'] = [
                'url'   => self::SAMBANOVA_URL,
                'model' => self::SAMBANOVA_MODEL,
                'key'   => $sambanovaKey,
            ];
        }

        // 3. Gemini (second fallback)
        $geminiKey = env('GEMINI_API_KEY');
        if ($geminiKey) {
            $chain['gemini'] = [
                'url'   => self::GEMINI_URL,
                'model' => self::GEMINI_MODEL,
                'key'   => $geminiKey,
            ];
        }

        return $chain;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Format + translate  (main method called externally)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Format the raw SRT into a structured JSON dialogues array with translations.
     * Long SRTs are processed in chunks and merged so output is never truncated.
     *
     * @return array{string|null, string|null, string}  [formattedEn, formattedId, errorMessage]
     */
    public function formatAndTranslateTranscript(string $srtContent): array
    {
        $systemPrompt = <<<PROMPT
Anda adalah asisten AI yang bertugas merapikan dan menerjemahkan transkrip audio IELTS/TOEFL.
Anda akan diberikan teks SRT mentah (berisi timestamps dan teks tanpa label pembicara).

Tugas Anda:
1. Analisis teks dan identifikasi pergantian pembicara secara AKURAT berdasarkan konteks percakapan.
2. Tambahkan label pembicara (misalnya "Speaker 1", "Speaker 2", dst) secara KONSISTEN.
3. Terjemahkan ke dalam Bahasa Indonesia yang alami, baku (EYD/PUEBI), dan mudah dipahami.

PENTING: Kembalikan respons sebagai JSON MURNI (tanpa markdown code block) dengan struktur:
{
    "dialogues": [
        {
            "start": "00:00:00,000",
            "end": "00:00:05,000",
            "speaker": "Speaker 1",
            "english": "Original English text",
            "indonesian": "Terjemahan Bahasa Indonesia"
        }
    ]
}

Aturan:
- Gabungkan baris dari pembicara SAMA yang berurutan menjadi satu blok, gunakan start dari baris pertama dan end dari baris terakhir.
- Jika ada pergantian pembicara, buat blok baru.
- PROSES SELURUH baris dari awal hingga akhir tanpa ada yang terlewat atau terpotong.
- Keluarkan HANYA JSON murni, tidak ada teks lain sebelum atau sesudah JSON.
PROMPT;

        $chunks      = $this->splitSrtIntoChunks($srtContent);
        $totalChunks = count($chunks);
        $allDialogues = [];
        $lastError   = '';

        Log::info("formatAndTranslateTranscript: processing {$totalChunks} chunk(s)");

        foreach ($chunks as $chunkIndex => $chunk) {
            $chunkNum = $chunkIndex + 1;

            $payload = [
                'temperature'     => 0.1,
                'max_tokens'      => 4096,
                'messages'        => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $chunk],
                ],
                'response_format' => ['type' => 'json_object'],
            ];

            [$rawContent, $aiError] = $this->callAiWithFallback($payload, 150);

            if (!$rawContent) {
                $lastError = "Chunk {$chunkNum}/{$totalChunks} failed: {$aiError}";
                Log::error("formatAndTranslateTranscript: {$lastError}");
                // Continue with remaining chunks — partial result is better than nothing
                continue;
            }

            // Strip markdown code fences if any provider wraps output
            $rawContent = preg_replace('/^```(?:json)?\s*/i', '', trim($rawContent));
            $rawContent = preg_replace('/\s*```$/', '', $rawContent);

            $json = json_decode($rawContent, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($json['dialogues'])) {
                $lastError = "Chunk {$chunkNum}/{$totalChunks}: invalid JSON — " . json_last_error_msg();
                Log::warning("formatAndTranslateTranscript: {$lastError}", ['raw' => substr($rawContent, 0, 300)]);
                continue;
            }

            $allDialogues = array_merge($allDialogues, $json['dialogues']);
            Log::info("formatAndTranslateTranscript: chunk {$chunkNum}/{$totalChunks} OK — " . count($json['dialogues']) . " dialogues");
        }

        if (empty($allDialogues)) {
            return [null, null, $lastError ?: 'Semua chunk gagal diproses.'];
        }

        $jsonString = json_encode($allDialogues, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return [$jsonString, $jsonString, $lastError];
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Plain-text Indonesian translation (fallback)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * @return array{string|null, string}  [translatedText|null, errorMessage]
     */
    private function translateToIndonesian(string $englishText): array
    {
        $systemPrompt = <<<PROMPT
Anda adalah penerjemah profesional IELTS/TOEFL. Terjemahkan teks bahasa Inggris berikut ke dalam Bahasa Indonesia yang alami, baku, dan mudah dipahami oleh pelajar Indonesia.

Aturan:
1. Pertahankan semua istilah akademik dan teknis yang relevan.
2. Gunakan Bahasa Indonesia baku (EYD/PUEBI).
3. Jangan tambahkan komentar, preamble, atau catatan—keluarkan HANYA teks terjemahan.
4. Pertahankan struktur paragraf asli.
PROMPT;

        $payload = [
            'temperature' => 0.3,
            'max_tokens'  => 4096,
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $englishText],
            ],
        ];

        [$content, $error] = $this->callAiWithFallback($payload, 90);

        if ($content) {
            return [$content, ''];
        }

        Log::error('translateToIndonesian: all providers failed', ['error' => $error]);
        return [null, $error];
    }
}
