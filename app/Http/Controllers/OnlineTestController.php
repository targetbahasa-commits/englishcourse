<?php

namespace App\Http\Controllers;

use App\Application\OnlineTest\OnlineTestCatalog;
use App\Models\IeltsListeningMockup;
use App\Models\OnlineTestBatch;
use App\Models\OnlineTestResult;
use App\Models\OnlineTestTaker;
use App\Models\OnlineTestUserAccess;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Process\Process;

class OnlineTestController extends Controller
{
    public function __construct(
        private readonly OnlineTestCatalog $catalog,
    ) {
    }

    public function index()
    {
        $tests = $this->catalog->getEnabledTests();

        $tests = array_map(function (array $test): array {
            $slug = $test['slug'];
            $activeBatch = OnlineTestBatch::forSlug($slug)->active()->first();

            $test['url'] = route('online-test.show', ['slug' => $slug]);
            $test['has_session_access'] = session("test_access_{$slug}") === true;
            $test['verify_url'] = route('online-test.verify-access-code', ['slug' => $slug]);
            $test['code_access_enabled'] = $activeBatch ? (bool) $activeBatch->code_access_enabled : false;

            return $test;
        }, $tests);

        $stats = [];

        return view('online-test.index', compact('tests', 'stats'));
    }

    public function endSession(string $slug)
    {
        session()->forget("test_access_{$slug}");

        $cookie = cookie()->forget('online_test_taker');

        return redirect()->route('online-test.index')->withCookie($cookie);
    }

    public function verifyAccessCode(Request $request, string $slug)
    {
        $test = $this->catalog->getEnabledTestBySlug($slug);

        if (!$test) {
            abort(404);
        }

        $request->validate([
            'access_code' => ['required', 'string'],
        ]);

        $activeBatch = OnlineTestBatch::forSlug($slug)->active()->first();

        if (!$activeBatch) {
            return redirect()->route('online-test.index')
                ->withErrors(["access_code_{$slug}" => 'Tidak ada batch aktif untuk tes ini.']);
        }

        if (!$activeBatch->code_access_enabled) {
            return redirect()->route('online-test.index')
                ->withErrors(["access_code_{$slug}" => 'Akses dengan kode sedang dinonaktifkan.']);
        }

        if ((string) $request->input('access_code') !== (string) $activeBatch->code) {
            return redirect()->route('online-test.index')
                ->withErrors(["access_code_{$slug}" => 'Kode akses yang Anda masukkan salah.']);
        }

        // Store access grant in session
        session(["test_access_{$slug}" => true]);

        return redirect()->route('online-test.show', $slug);
    }

    public function show(Request $request, string $slug)
    {
        // Auto-verify if ?code= is provided in the URL (shared link flow)
        $codeParam = $request->query('code');
        if ($codeParam && !session("test_access_{$slug}")) {
            $activeBatch = OnlineTestBatch::forSlug($slug)->active()->first();
            if ($activeBatch && $activeBatch->code_access_enabled) {
                if ((string) $codeParam === (string) $activeBatch->code) {
                    session(["test_access_{$slug}" => true]);
                }
            }
        }

        [$test, $latestResult] = $this->loadAccessibleEnabledTest($slug);

        return view('online-test.show', compact('test', 'latestResult'));
    }

    public function packageSection(string $slugAlias, int $package, string $section)
    {
        $slug = $this->normalizeRouteSlug($slugAlias);
        [$test, $latestResult] = $this->loadAccessibleEnabledTest($slug);

        $package = max(1, min(16, $package));
        $sectionKey = strtolower(trim($section));

        $sectionData = collect($test['sections'] ?? [])->firstWhere('key', $sectionKey);

        if (!is_array($sectionData)) {
            abort(404);
        }

        $packageBank = is_array($test['package_bank'] ?? null) ? $test['package_bank'] : [];
        $packageMeta = is_array($packageBank[$package] ?? null) ? $packageBank[$package] : [];
        $packageSections = is_array($packageMeta['sections'] ?? null) ? $packageMeta['sections'] : [];
        $sectionContent = trim((string) ($packageSections[$sectionKey] ?? ''));
        $packageTitle = trim((string) ($packageMeta['title'] ?? ''));
        $material = null;
        $latestPackageSectionResult = null;
        $packageAnswerKey = $this->resolvePackageAnswerKey($slug, $package, $sectionKey);

        if ($slug === 'ielts_academic' && $sectionKey === 'listening') {
            // Reserve a dedicated test_id range for internal package listening materials.
            $material = IeltsListeningMockup::firstOrCreate([
                'test_id' => 900000 + $package,
            ]);
        }

        $taker = $this->resolveCurrentTaker();
        $userId = Auth::id();

        $latestCandidates = OnlineTestResult::query()
            ->where(function ($query) use ($taker, $userId) {
                $query->where('online_test_taker_id', $taker->id);

                if ($userId !== null) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('test_slug', $slug)
            ->where('status', 'completed')
            ->latest('id')
            ->limit(50)
            ->get();

        $latestPackageSectionResult = $latestCandidates->first(function (OnlineTestResult $result) use ($package, $sectionKey) {
            $answersData = is_array($result->answers_data) ? $result->answers_data : [];

            return ($answersData['mode'] ?? null) === 'package-section'
                && (int) ($answersData['package'] ?? 0) === (int) $package
                && strtolower((string) ($answersData['section'] ?? '')) === $sectionKey;
        });

        $test['package_number'] = $package;
        $test['package_meta'] = $packageMeta;
        $test['package_label'] = $packageTitle !== ''
            ? $packageTitle
            : ((string) $test['label']) . ' Paket ' . $package;

        $customView = 'online-test.packages.' . str_replace('_', '-', $slug) . '.paket' . $package . '.' . $sectionKey;

        if (View::exists($customView)) {
            return view($customView, [
                'test' => $test,
                'latestResult' => $latestResult,
                'section' => $sectionData,
                'sectionContent' => $sectionContent,
                'slugAlias' => $slugAlias,
                'material' => $material,
                'latestPackageSectionResult' => $latestPackageSectionResult,
                'packageSectionSubmitUrl' => route('online-test.package-section.submit', [
                    'slugAlias' => $slugAlias,
                    'package' => $package,
                    'section' => $sectionKey,
                ]),
                'packageAnswerKey' => $packageAnswerKey,
            ]);
        }

        return view('online-test.package-section', [
            'test' => $test,
            'latestResult' => $latestResult,
            'section' => $sectionData,
            'sectionContent' => $sectionContent,
            'slugAlias' => $slugAlias,
            'material' => $material,
            'latestPackageSectionResult' => $latestPackageSectionResult,
            'packageSectionSubmitUrl' => route('online-test.package-section.submit', [
                'slugAlias' => $slugAlias,
                'package' => $package,
                'section' => $sectionKey,
            ]),
            'packageAnswerKey' => $packageAnswerKey,
        ]);
    }

    public function submitPackageSection(Request $request, string $slugAlias, int $package, string $section)
    {
        $slug = $this->normalizeRouteSlug($slugAlias);
        [$test] = $this->loadAccessibleEnabledTest($slug);

        $package = max(1, min(16, $package));
        $sectionKey = strtolower(trim($section));
        $sectionData = collect($test['sections'] ?? [])->firstWhere('key', $sectionKey);

        if (!is_array($sectionData)) {
            abort(404);
        }

        $validated = $request->validate([
            'score' => ['nullable', 'numeric', 'min:0'],
            'total_questions' => ['nullable', 'integer', 'min:0'],
            'wrong_numbers' => ['nullable', 'array'],
            'wrong_numbers.*' => ['integer', 'min:1'],
            'answers' => ['nullable', 'array'],
        ]);

        $score = isset($validated['score']) ? (float) $validated['score'] : null;
        $totalQuestions = (int) ($validated['total_questions'] ?? ($sectionData['question_count'] ?? 0));
        $scorePercent = $score;

        if ($score !== null && $totalQuestions > 0) {
            $scorePercent = round(($score / $totalQuestions) * 100, 2);
        }

        $taker = $this->resolveCurrentTaker();
        $now = now();

        $result = new OnlineTestResult();
        $result->forceFill([
            'user_id' => Auth::id(),
            'online_test_taker_id' => $taker->id,
            'test_slug' => $slug,
            'test_label' => (string) ($test['label'] ?? $slug),
            'status' => 'completed',
            'duration_minutes' => (int) ($sectionData['minutes'] ?? $test['duration_minutes'] ?? 0),
            'time_spent_seconds' => null,
            'score' => $scorePercent,
            'answers_data' => [
                'mode' => 'package-section',
                'package' => $package,
                'section' => $sectionKey,
                'answers' => $validated['answers'] ?? [],
            ],
            'evaluation_data' => [
                'score_correct' => $score,
                'score_total' => $totalQuestions,
                'score_percent' => $scorePercent,
                'wrong_numbers' => $validated['wrong_numbers'] ?? [],
                'submitted_at' => $now->toIso8601String(),
            ],
            'started_at' => $now,
            'completed_at' => $now,
        ])->save();

        return response()->json([
            'message' => 'Berhasil disimpan',
            'result_id' => $result->id,
            'score' => $score,
            'score_percent' => $scorePercent,
        ]);
    }

    public function ieltsAcademicBandReport(Request $request, int $package)
    {
        $package = max(1, min(16, $package));
        [$test] = $this->loadAccessibleEnabledTest('ielts_academic');
        $certificateConfig = $this->resolveIeltsAcademicCertificateConfig($package);

        $sections = ['listening', 'reading', 'writing', 'speaking'];
        $taker = $this->resolveIeltsAcademicBandReportTaker($request, $package);
        $userId = (int) ($taker->source_user_id ?? 0) === (int) Auth::id() ? Auth::id() : null;

        $latestCandidates = OnlineTestResult::query()
            ->where(function ($query) use ($taker, $userId) {
                $query->where('online_test_taker_id', $taker->id);

                if ($userId !== null) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('test_slug', 'ielts_academic')
            ->where('status', 'completed')
            ->latest('id')
            ->limit(200)
            ->get();

        $latestBySection = [];
        foreach ($sections as $sectionKey) {
            $latestBySection[$sectionKey] = $latestCandidates->first(function (OnlineTestResult $result) use ($package, $sectionKey) {
                $answersData = is_array($result->answers_data) ? $result->answers_data : [];

                return ($answersData['mode'] ?? null) === 'package-section'
                    && (int) ($answersData['package'] ?? 0) === $package
                    && strtolower((string) ($answersData['section'] ?? '')) === $sectionKey;
            });
        }

        $bands = [
            'listening' => $this->resolveListeningBandScore($latestBySection['listening']),
            'reading' => $this->resolveReadingBandScore($latestBySection['reading']),
            'writing' => $this->resolveProductiveBandScore($latestBySection['writing']),
            'speaking' => $this->resolveProductiveBandScore($latestBySection['speaking']),
        ];

        $allSectionsComplete = collect($sections)->every(fn (string $key): bool => $bands[$key] !== null);
        $overallBand = null;

        if ($allSectionsComplete) {
            $rawAverage = array_sum($bands) / 4;
            $overallBand = $this->roundBandToHalf($rawAverage);
        }

        return view('online-test.packages.ielts-academic.band-report', [
            'test' => $test,
            'package' => $package,
            'bands' => $bands,
            'overallBand' => $overallBand,
            'allSectionsComplete' => $allSectionsComplete,
            'latestBySection' => $latestBySection,
            'certificateConfig' => $certificateConfig,
            'taker' => $taker,
        ]);
    }

    public function ieltsGeneralBandReport(Request $request, int $package)
    {
        $package = max(1, min(16, $package));
        [$test] = $this->loadAccessibleEnabledTest("ielts_general");

        $sections = ["listening", "reading", "writing", "speaking"];
        $taker = $this->resolveIeltsAcademicBandReportTaker($request, $package, "ielts_general");
        $userId = (int) ($taker->source_user_id ?? 0) === (int) Auth::id() ? Auth::id() : null;

        $latestCandidates = OnlineTestResult::query()
            ->where(function ($query) use ($taker, $userId) {
                $query->where("online_test_taker_id", $taker->id);

                if ($userId !== null) {
                    $query->orWhere("user_id", $userId);
                }
            })
            ->where("test_slug", "ielts_general")
            ->where("status", "completed")
            ->latest("id")
            ->limit(200)
            ->get();

        $latestBySection = [];
        foreach ($sections as $sectionKey) {
            $latestBySection[$sectionKey] = $latestCandidates->first(function (OnlineTestResult $result) use ($package, $sectionKey) {
                $answersData = is_array($result->answers_data) ? $result->answers_data : [];

                return ($answersData["mode"] ?? null) === "package-section"
                    && (int) ($answersData["package"] ?? 0) === $package
                    && strtolower((string) ($answersData["section"] ?? "")) === $sectionKey;
            });
        }

        $bands = [
            "listening" => $this->resolveListeningBandScore($latestBySection["listening"]),
            "reading" => $this->resolveReadingBandScore($latestBySection["reading"]),
            "writing" => $this->resolveProductiveBandScore($latestBySection["writing"]),
            "speaking" => $this->resolveProductiveBandScore($latestBySection["speaking"]),
        ];

        $allSectionsComplete = collect($sections)->every(fn (string $key): bool => $bands[$key] !== null);
        $overallBand = null;

        if ($allSectionsComplete) {
            $rawAverage = array_sum($bands) / 4;
            $overallBand = $this->roundBandToHalf($rawAverage);
        }

        return view("online-test.packages.ielts-general.band-report", [
            "test" => $test,
            "package" => $package,
            "bands" => $bands,
            "overallBand" => $overallBand,
            "allSectionsComplete" => $allSectionsComplete,
            "latestBySection" => $latestBySection,
        ]);
    }

    public function toeflItpScoreReport(Request $request, int $package)
    {
        $package = max(1, min(16, $package));
        [$test] = $this->loadAccessibleEnabledTest('toefl_itp');

        $sections = ['listening', 'structure', 'reading'];
        $taker = $this->resolveIeltsAcademicBandReportTaker($request, $package, 'toefl_itp');
        $userId = (int) ($taker->source_user_id ?? 0) === (int) Auth::id() ? Auth::id() : null;

        $latestCandidates = OnlineTestResult::query()
            ->where(function ($query) use ($taker, $userId) {
                $query->where('online_test_taker_id', $taker->id);

                if ($userId !== null) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('test_slug', 'toefl_itp')
            ->where('status', 'completed')
            ->latest('id')
            ->limit(200)
            ->get();

        $latestBySection = [];
        foreach ($sections as $sectionKey) {
            $latestBySection[$sectionKey] = $latestCandidates->first(function (OnlineTestResult $result) use ($package, $sectionKey) {
                $answersData = is_array($result->answers_data) ? $result->answers_data : [];

                return ($answersData['mode'] ?? null) === 'package-section'
                    && (int) ($answersData['package'] ?? 0) === $package
                    && strtolower((string) ($answersData['section'] ?? '')) === $sectionKey;
            });
        }

        $converter = new \App\Domain\ToeflMockup\ToeflScoreConverter();

        $scores = [
            'listening' => null,
            'structure' => null,
            'reading' => null,
        ];

        foreach ($sections as $sectionKey) {
            $sectionResult = $latestBySection[$sectionKey] ?? null;
            if ($sectionResult) {
                $evaluation = is_array($sectionResult->evaluation_data) ? $sectionResult->evaluation_data : [];
                $correct = (int) ($evaluation['score_correct'] ?? 0);
                $scores[$sectionKey] = $converter->convert($sectionKey, $correct);
            }
        }

        $allSectionsComplete = collect($sections)->every(fn (string $key): bool => $scores[$key] !== null);
        $totalScore = null;

        if ($allSectionsComplete) {
            $sum = $scores['listening'] + $scores['structure'] + $scores['reading'];
            $totalScore = (int) round(($sum * 10) / 3);
        }

        return view('online-test.packages.toefl-itp.score-report', [
            'test' => $test,
            'package' => $package,
            'scores' => $scores,
            'totalScore' => $totalScore,
            'allSectionsComplete' => $allSectionsComplete,
            'latestBySection' => $latestBySection,
            'taker' => $taker,
        ]);
    }

    public function updateIeltsAcademicCertificate(Request $request, int $package)
    {
        $package = max(1, min(16, $package));
        $taker = $this->resolveIeltsAcademicBandReportTaker($request, $package);

        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:120'],
            'title' => ['nullable', 'string', 'max:120'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'intro' => ['nullable', 'string', 'max:500'],
            'main_text' => ['nullable', 'string', 'max:200'],
            'body' => ['nullable', 'string', 'max:500'],
            'footer_left_label' => ['nullable', 'string', 'max:120'],
            'footer_right_label' => ['nullable', 'string', 'max:120'],
            'signature_name' => ['nullable', 'string', 'max:120'],
            'score_label' => ['nullable', 'string', 'max:120'],
            'date_of_birth' => ['nullable', 'date'],
            'sex' => ['nullable', 'string', 'in:M,F'],
            'country_of_origin' => ['nullable', 'string', 'max:120'],
            'country_of_nationality' => ['nullable', 'string', 'max:120'],
            'first_language' => ['nullable', 'string', 'max:120'],
            'test_type' => ['nullable', 'string', 'max:120'],
        ]);

        $config = $this->resolveIeltsAcademicCertificateConfig($package);

        foreach ($validated as $key => $value) {
            $config[$key] = trim((string) $value);
        }

        Setting::updateOrCreate(
            ['key' => "online_test_ielts_academic_package_{$package}_certificate"],
            ['value' => json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'type' => 'json']
        );

        $profileUpdates = [
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'sex' => $validated['sex'] ?? null,
            'country_of_origin' => trim((string) ($validated['country_of_origin'] ?? '')),
            'country_of_nationality' => trim((string) ($validated['country_of_nationality'] ?? '')),
            'first_language' => trim((string) ($validated['first_language'] ?? '')),
            'test_type' => trim((string) ($validated['test_type'] ?? '')),
        ];

        $taker->forceFill([
            'date_of_birth' => $profileUpdates['date_of_birth'],
            'sex' => $profileUpdates['sex'] !== '' ? $profileUpdates['sex'] : null,
            'country_of_origin' => $profileUpdates['country_of_origin'] !== '' ? $profileUpdates['country_of_origin'] : null,
            'country_of_nationality' => $profileUpdates['country_of_nationality'] !== '' ? $profileUpdates['country_of_nationality'] : null,
            'first_language' => $profileUpdates['first_language'] !== '' ? $profileUpdates['first_language'] : null,
            'test_type' => $profileUpdates['test_type'] !== '' ? $profileUpdates['test_type'] : 'Academic',
        ])->save();

        return redirect()
            ->route('online-test.ielts-academic.band-report', ['package' => $package, 'taker_id' => $taker->id])
            ->with('success', 'Template sertifikat dan profil kandidat berhasil diperbarui.');
    }

    public function exam(string $slug, OnlineTestResult $onlineTestResult)
    {
        $test = $this->catalog->getTestBySlug($slug);

        if (!$test) {
            abort(404);
        }

        $taker = $this->resolveCurrentTaker();
        $ownsAttempt = (int) $onlineTestResult->online_test_taker_id === (int) $taker->id
            || ((int) $onlineTestResult->online_test_taker_id === 0 && (int) $onlineTestResult->user_id === (int) Auth::id());

        if ((string) $onlineTestResult->test_slug !== $slug || !$ownsAttempt) {
            abort(403);
        }

        if ($onlineTestResult->status === 'completed') {
            return redirect()->route('online-test.result', ['slug' => $slug, 'onlineTestResult' => $onlineTestResult->id]);
        }

        return view('online-test.exam', [
            'test' => $test,
            'attempt' => $onlineTestResult,
        ]);
    }

    public function result(string $slug, OnlineTestResult $onlineTestResult)
    {
        $test = $this->catalog->getTestBySlug($slug);

        if (!$test) {
            abort(404);
        }

        $taker = $this->resolveCurrentTaker();
        $ownsResult = (int) $onlineTestResult->online_test_taker_id === (int) $taker->id
            || ((int) $onlineTestResult->online_test_taker_id === 0 && (int) $onlineTestResult->user_id === (int) Auth::id());

        if ((string) $onlineTestResult->test_slug !== $slug || !$ownsResult) {
            abort(403);
        }

        return view('online-test.result', [
            'test' => $test,
            'result' => $onlineTestResult,
        ]);
    }

    /**
     * The shared host's default python3 is 3.6.8, far too old for
     * Kokoro/torch - a dedicated venv with Python 3.11 is installed at this
     * fixed path for that reason. Falls back to plain python3 wherever that
     * venv doesn't exist (e.g. local dev).
     */
    private function kokoroPythonBinary(): string
    {
        $venvPython = '/home/u822472458/kokoro_venv/bin/python3.11';

        return file_exists($venvPython) ? $venvPython : 'python3';
    }

    public function streamKokoroSpeech(Request $request)
    {
        $text = trim((string) $request->query('text'));
        $voice = trim((string) $request->query('voice', 'af_heart'));
        if (empty($text)) abort(400, 'Text required');

        $lang = str_starts_with($voice, 'b') ? 'b' : 'a';

        $publicDir = storage_path('app/public/kokoro-tts');
        File::ensureDirectoryExists($publicDir);

        $hash = sha1('kokoro|' . $voice . '|wav|' . $text);
        $filename = 'tts_' . $hash . '.wav';
        $absoluteOutput = $publicDir . '/' . $filename;

        if (!file_exists($absoluteOutput)) {
            $scriptPath = base_path('scripts/kokoro_tts.py');
            $kokoro = new Process([
                $this->kokoroPythonBinary(),
                $scriptPath,
                '--text',
                $text,
                '--output',
                $absoluteOutput,
                '--voice',
                $voice,
                '--lang',
                $lang,
            ], null, ['HF_HUB_DISABLE_XET' => '1']);
            $kokoro->setTimeout(120);
            $kokoro->run();

            if (!$kokoro->isSuccessful()) {
                abort(500, 'TTS Generation failed');
            }
        }

        return response()->file($absoluteOutput, [
            'Content-Type' => 'audio/wav',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    public function synthesizeKokoroSpeech(Request $request)
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:600'],
            'voice' => ['nullable', 'string', 'max:50'],
        ]);

        $text = trim((string) $validated['text']);
        $voice = trim((string) ($validated['voice'] ?? 'af_heart'));
        $lang = str_starts_with($voice, 'b') ? 'b' : 'a';

        $publicDir = storage_path('app/public/kokoro-tts');
        File::ensureDirectoryExists($publicDir);

        $hash = sha1('kokoro|' . $voice . '|wav|' . $text);
        $filename = 'tts_' . $hash . '.wav';
        $absoluteOutput = $publicDir . '/' . $filename;

        if (!file_exists($absoluteOutput)) {
            $scriptPath = base_path('scripts/kokoro_tts.py');
            
            $kokoro = new Process([
                $this->kokoroPythonBinary(),
                $scriptPath,
                '--text',
                $text,
                '--output',
                $absoluteOutput,
                '--voice',
                $voice,
                '--lang',
                $lang,
            ], null, ['HF_HUB_DISABLE_XET' => '1']);

            // Set timeout very long for first-run model downloads (up to 5 minutes)
            // Kokoro downloads ~500MB model on first use
            $kokoro->setTimeout(300);
            $kokoro->run();

            if (!$kokoro->isSuccessful() || !file_exists($absoluteOutput)) {
                $errorOutput = $kokoro->getErrorOutput();
                $errorMsg = $kokoro->isSuccessful() ? 'File not created' : $errorOutput;
                
                return response()->json([
                    'message' => 'Failed to synthesize speech with Kokoro.',
                    'error' => $errorMsg,
                    'hint' => 'First-time model download may take 2-5 minutes. Please try again.'
                ], 500);
            }
        }

        return response()->json([
            'audio_url' => route('online-test.kokoro-tts.file', ['filename' => $filename]),
            'engine' => 'kokoro',
            'voice' => 'af_heart',
        ]);
    }

    public function serveSynthesizedSpeech(string $filename): BinaryFileResponse
    {
        if (!preg_match('/^tts_[a-f0-9]+\.(aiff|wav)$/', $filename)) {
            abort(404);
        }

        $absolutePath = storage_path('app/public/kokoro-tts/' . $filename);

        if (!is_file($absolutePath)) {
            abort(404);
        }

        $contentType = str_ends_with($filename, '.wav') ? 'audio/wav' : 'audio/aiff';

        return response()->file($absolutePath, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    private function resolveCurrentTaker(): OnlineTestTaker
    {
        $user = Auth::user();

        $this->assignTestTakerRoleIfNeeded($user);

        $taker = OnlineTestTaker::firstOrCreate(
            ['source_user_id' => $user->id],
            [
                'name' => (string) ($user->name ?: 'Test Taker'),
                'email' => (string) ($user->email ?: ('user' . $user->id . '@targetbahasa.local')),
            ]
        );

        return $this->ensureTakerIdentityProfile($taker, $user);
    }

    private function resolveIeltsAcademicBandReportTaker(Request $request, int $package, string $testSlug = 'ielts_academic'): OnlineTestTaker
    {
        $currentTaker = $this->resolveCurrentTaker();
        $user = Auth::user();

        if (!$user || !method_exists($user, 'isAdmin') || !$user->isAdmin()) {
            return $currentTaker;
        }

        $requestedTakerId = (int) ($request->input('taker_id', $request->query('taker_id', 0)));

        if ($requestedTakerId > 0) {
            $requestedTaker = OnlineTestTaker::query()->findOrFail($requestedTakerId);

            return $this->ensureTakerIdentityProfile($requestedTaker, null);
        }

        $latestPackageResult = OnlineTestResult::query()
            ->where('test_slug', $testSlug)
            ->where('status', 'completed')
            ->whereNotNull('online_test_taker_id')
            ->latest('id')
            ->limit(500)
            ->get()
            ->first(function (OnlineTestResult $result) use ($package): bool {
                $answersData = is_array($result->answers_data) ? $result->answers_data : [];

                return ($answersData['mode'] ?? null) === 'package-section'
                    && (int) ($answersData['package'] ?? 0) === $package;
            });

        $resolvedTaker = $latestPackageResult?->taker ?: $currentTaker;

        return $this->ensureTakerIdentityProfile($resolvedTaker, null);
    }

    private function ensureTakerIdentityProfile(OnlineTestTaker $taker, $user = null): OnlineTestTaker
    {
        $updates = [];

        if (!$taker->candidate_id) {
            $updates['candidate_id'] = OnlineTestTaker::generateCandidateId((int) $taker->id);
        }

        if (!$taker->name && $user && isset($user->name)) {
            $updates['name'] = (string) $user->name;
        }

        if (!$taker->email && $user && isset($user->email)) {
            $updates['email'] = (string) $user->email;
        }

        if (!$taker->test_type) {
            $updates['test_type'] = 'Academic';
        }

        if ($updates !== []) {
            $taker->forceFill($updates)->save();
            $taker->refresh();
        }

        return $taker;
    }

    private function assignTestTakerRoleIfNeeded($user): void
    {
        if (!$user) {
            return;
        }

        if (in_array($user->role, ['admin', 'teacher', 'student'], true)) {
            return;
        }

        if ($user->role !== 'test-taker') {
            $user->forceFill(['role' => 'test-taker'])->save();
        }
    }

    /**
     * @return array{0: array<string, mixed>, 1: ?OnlineTestResult}
     */
    private function loadAccessibleEnabledTest(string $slug): array
    {
        $test = $this->catalog->getEnabledTestBySlug($slug);

        if (!$test) {
            abort(404);
        }

        $taker = $this->resolveCurrentTaker();
        $userId = Auth::id();

        $userAccess = OnlineTestUserAccess::where(function ($query) use ($taker, $userId) {
                $query->where('online_test_taker_id', $taker->id);

                if ($userId !== null) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('test_slug', $slug)
            ->first();

        if ($userAccess && !$userAccess->access_granted) {
            return redirect()->route('online-test.index')
                ->withErrors(["access_code_{$slug}" => 'Akses Anda ke tes ini telah dicabut oleh admin.'])
                ->throwResponse();
        }

        $latestResult = OnlineTestResult::query()
            ->where(function ($query) use ($taker, $userId) {
                $query->where('online_test_taker_id', $taker->id);

                if ($userId !== null) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->where('test_slug', $slug)
            ->latest('id')
            ->first();

        $currentUser = Auth::user();
        $adminGranted = $userAccess && $userAccess->access_granted;
        $hasAccess = $adminGranted
            || session("test_access_{$slug}") === true
            || $latestResult !== null
            || ($currentUser && method_exists($currentUser, 'isAdmin') && $currentUser->isAdmin());

        if (!$hasAccess) {
            return redirect()->route('online-test.index')
                ->withErrors(["access_code_{$slug}" => 'Masukkan kode akses terlebih dahulu.'])
                ->throwResponse();
        }

        return [$test, $latestResult];
    }

    private function normalizeRouteSlug(string $slugAlias): string
    {
        return str_replace('-', '_', strtolower(trim($slugAlias)));
    }

    private function resolveListeningBandScore(?OnlineTestResult $result): ?float
    {
        if (!$result) {
            return null;
        }

        $evaluation = is_array($result->evaluation_data) ? $result->evaluation_data : [];
        $correct = (int) ($evaluation['score_correct'] ?? 0);

        return $this->mapCorrectAnswersToBand($correct);
    }

    private function resolveReadingBandScore(?OnlineTestResult $result): ?float
    {
        if (!$result) {
            return null;
        }

        $evaluation = is_array($result->evaluation_data) ? $result->evaluation_data : [];
        $correct = (int) ($evaluation['score_correct'] ?? 0);

        return $this->mapCorrectAnswersToBand($correct);
    }

    private function resolveProductiveBandScore(?OnlineTestResult $result): ?float
    {
        if (!$result) {
            return null;
        }

        $answersData = is_array($result->answers_data) ? $result->answers_data : [];
        $answers = is_array($answersData['answers'] ?? null) ? $answersData['answers'] : [];

        if (isset($answers['estimated_band']) && is_numeric($answers['estimated_band'])) {
            return $this->roundBandToHalf((float) $answers['estimated_band']);
        }

        $evaluation = is_array($result->evaluation_data) ? $result->evaluation_data : [];
        if (!isset($evaluation['score_percent']) || !is_numeric($evaluation['score_percent'])) {
            return null;
        }

        $percent = (float) $evaluation['score_percent'];
        $band = ($percent / 100) * 9;

        return $this->roundBandToHalf($band);
    }

    private function mapCorrectAnswersToBand(int $correct): float
    {
        return match (true) {
            $correct >= 39 => 9.0,
            $correct >= 37 => 8.5,
            $correct >= 35 => 8.0,
            $correct >= 33 => 7.5,
            $correct >= 30 => 7.0,
            $correct >= 27 => 6.5,
            $correct >= 23 => 6.0,
            $correct >= 19 => 5.5,
            $correct >= 15 => 5.0,
            $correct >= 13 => 4.5,
            $correct >= 10 => 4.0,
            $correct >= 8 => 3.5,
            $correct >= 6 => 3.0,
            $correct >= 4 => 2.5,
            $correct >= 3 => 2.0,
            $correct >= 2 => 1.5,
            $correct >= 1 => 1.0,
            default => 0.0,
        };
    }

    private function roundBandToHalf(float $score): float
    {
        return round($score * 2) / 2;
    }

    /**
     * @return array<string, mixed>
     */
    private function resolvePackageAnswerKey(string $slug, int $package, string $section): array
    {
        $setting = Setting::query()->where('key', "online_test_{$slug}_package_answer_keys")->value('value');
        if (!is_string($setting) || trim($setting) === '') {
            return [];
        }

        $decoded = json_decode($setting, true);
        if (!is_array($decoded)) {
            return [];
        }

        $packageData = $decoded[$package] ?? null;
        if (!is_array($packageData)) {
            return [];
        }

        $sectionData = $packageData[$section] ?? null;

        return is_array($sectionData) ? $sectionData : [];
    }

    /**
     * @return array<string, string>
     */
    private function resolveIeltsAcademicCertificateConfig(int $package): array
    {
        $defaults = [
            'eyebrow' => 'IELTS ACADEMIC PAKET ' . $package,
            'title' => 'Band Score Certificate',
            'subtitle' => 'Official download for IELTS Academic package completion',
            'intro' => 'This certifies that',
            'main_text' => 'Band Score Report',
            'body' => 'has completed the IELTS Academic package and earned the band summary shown below.',
            'footer_left_label' => 'Date Completed',
            'footer_right_label' => 'Authorized Signature',
            'signature_name' => 'Target Bahasa Team',
            'score_label' => 'Overall Band Score',
        ];

        $setting = Setting::query()->where('key', "online_test_ielts_academic_package_{$package}_certificate")->value('value');
        if (!is_string($setting) || trim($setting) === '') {
            return $defaults;
        }

        $decoded = json_decode($setting, true);

        if (!is_array($decoded)) {
            return $defaults;
        }

        return array_merge($defaults, array_intersect_key($decoded, $defaults));
    }
}
