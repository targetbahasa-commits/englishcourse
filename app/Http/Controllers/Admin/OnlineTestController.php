<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\ToeflMockup\ToeflScoreConverter;
use App\Models\OnlineTestBatch;
use App\Models\OnlineTestUserAccess;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class OnlineTestController extends Controller
{
    /**
     * @var array<string, array<int, string>>
     */
    private const PACKAGE_BANK_SECTION_KEYS = [
        'ielts_academic' => ['listening', 'reading', 'writing', 'speaking'],
        'ielts_general' => ['listening', 'reading', 'writing', 'speaking'],
        'toefl_itp' => ['listening', 'structure', 'reading'],
    ];

    /**
     * @var array<string, array<string, string>>
     */
    private const TEST_DEFAULTS = [
        'ielts_academic' => [
            'label' => 'IELTS Academic',
            'description' => 'Prepare for IELTS Academic with focused practice across all exam sections.',
        ],
        'ielts_general' => [
            'label' => 'IELTS General',
            'description' => 'Build confidence for IELTS General with practical learning materials and drills.',
        ],
        'toefl_itp' => [
            'label' => 'TOEFL ITP',
            'description' => 'Practice TOEFL ITP listening, structure, and reading in one place.',
        ],
        'pte_academic' => [
            'label' => 'PTE Academic',
            'description' => 'Get ready for PTE Academic with integrated speaking, listening, reading, and writing.',
        ],
    ];

    public function index()
    {
        $settings = Setting::query()
            ->where('key', 'like', 'online_test_%')
            ->pluck('value', 'key')
            ->toArray();

        $tests = [];

        foreach (self::TEST_DEFAULTS as $slug => $default) {
            $activeBatch = OnlineTestBatch::forSlug($slug)->active()->first();
            $batches = OnlineTestBatch::forSlug($slug)->orderByDesc('created_at')->get();

            $tests[] = [
                'slug'          => $slug,
                'label'         => $default['label'],
                'enabled'       => ($settings["online_test_{$slug}_enabled"] ?? '1') === '1',
                'description'   => $settings["online_test_{$slug}_description"] ?? $default['description'],
                'package_number' => max(1, min(16, (int) ($settings["online_test_{$slug}_package_number"] ?? 1))),
                'reference_test_id' => 1,
                'active_batch'  => $activeBatch,
                'batches'       => $batches,
            ];
        }

        // For user access panel - load all users with their per-test access overrides
        $users = \App\Models\User::whereIn('role', ['student', 'test-taker'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $userAccessRecords = OnlineTestUserAccess::whereIn('test_slug', array_keys(self::TEST_DEFAULTS))
            ->get()
            ->groupBy('user_id');

        return view('admin.online-tests.index', compact('tests', 'users', 'userAccessRecords'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tests'              => ['required', 'array'],
            'tests.*.enabled'   => ['nullable', 'in:1'],
            'tests.*.description' => ['nullable', 'string', 'max:500'],
            'tests.*.package_number' => ['nullable', 'integer', 'min:1', 'max:16'],
        ]);

        $inputTests = $validated['tests'] ?? [];
        $existingSettings = Setting::query()
            ->where('key', 'like', 'online_test_%')
            ->pluck('value', 'key')
            ->toArray();

        foreach (self::TEST_DEFAULTS as $slug => $default) {
            $enabled     = isset($inputTests[$slug]['enabled']) ? '1' : '0';
            $description = trim((string) ($inputTests[$slug]['description'] ?? $default['description']));
            $packageNumber = (int) ($inputTests[$slug]['package_number'] ?? ($existingSettings["online_test_{$slug}_package_number"] ?? 1));

            if ($packageNumber < 1 || $packageNumber > 16) {
                $packageNumber = 1;
            }

            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_enabled"],
                ['value' => $enabled, 'type' => 'boolean']
            );

            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_description"],
                ['value' => $description !== '' ? $description : $default['description'], 'type' => 'string']
            );

            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_package_number"],
                ['value' => (string) $packageNumber, 'type' => 'integer']
            );

            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_reference_test_id"],
                ['value' => '1', 'type' => 'integer']
            );
        }

        return redirect()->route('admin.online-tests.index')->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Generate a new active batch code for a test.
     */
    public function generateCode(Request $request, string $slug)
    {
        $request->validate([
            'label' => ['required', 'string', 'max:100'],
        ]);

        // Deactivate all current active batches for this slug
        OnlineTestBatch::forSlug($slug)->active()->update(['is_active' => false]);

        // Generate a random code
        $code = strtoupper(Str::random(6));

        OnlineTestBatch::create([
            'test_slug'           => $slug,
            'label'               => $request->label,
            'code'                => $code,
            'is_active'           => true,
            'code_access_enabled' => true,
        ]);

        return redirect()->route('admin.online-tests.index')
            ->with('success', "Kode batch baru ({$code}) berhasil dibuat dan diaktifkan.");
    }

    /**
     * Toggle whether the active batch requires a code to enter.
     */
    public function toggleCodeAccess(Request $request, string $slug)
    {
        $batch = OnlineTestBatch::forSlug($slug)->active()->firstOrFail();
        $batch->update(['code_access_enabled' => !$batch->code_access_enabled]);

        $status = $batch->code_access_enabled ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.online-tests.index')
            ->with('success', "Validasi kode akses untuk {$slug} berhasil {$status}.");
    }

    /**
     * Archive (deactivate) a batch.
     */
    public function archiveBatch(int $id)
    {
        $batch = OnlineTestBatch::findOrFail($id);
        $batch->update(['is_active' => false]);

        return redirect()->route('admin.online-tests.index')
            ->with('success', "Batch \"{$batch->label}\" berhasil diarsipkan.");
    }

    /**
     * Toggle batch status (active/non-active) for a test.
     */
    public function toggleBatchActive(Request $request, int $id)
    {
        $validated = $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        $batch = OnlineTestBatch::findOrFail($id);
        $shouldBeActive = (bool) $validated['active'];

        if ($shouldBeActive) {
            // Ensure only one active batch exists per test slug.
            OnlineTestBatch::forSlug($batch->test_slug)->update(['is_active' => false]);
        }

        $batch->update(['is_active' => $shouldBeActive]);

        $statusText = $shouldBeActive ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.online-tests.index')
            ->with('success', "Batch \"{$batch->label}\" berhasil {$statusText}.");
    }

    /**
     * Delete an archived batch from history.
     */
    public function destroyBatch(int $id)
    {
        $batch = OnlineTestBatch::findOrFail($id);
        $batch->delete();

        return redirect()->route('admin.online-tests.index')
            ->with('success', "Batch \"{$batch->label}\" berhasil dihapus.");
    }

    /**
     * Grant or revoke per-user access for a specific test.
     */
    public function toggleUserAccess(Request $request)
    {
        $request->validate([
            'taker_id'  => ['required', 'exists:online_test_takers,id'],
            'test_slug' => ['required', 'string'],
            'grant'     => ['required', 'boolean'],
        ]);

        OnlineTestUserAccess::updateOrCreate(
            [
                'online_test_taker_id' => $request->taker_id,
                'test_slug' => $request->test_slug,
            ],
            [
                'access_granted' => $request->boolean('grant'),
                'granted_by'     => Auth::id(),
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Update instruction video URL for a specific section.
     */
    public function updateSectionVideo(Request $request, string $slug, string $section)
    {
        if (!array_key_exists($slug, self::TEST_DEFAULTS)) {
            abort(404);
        }

        $validated = $request->validate([
            'video_url' => ['nullable', 'url', 'max:2000'],
        ]);

        $settingKey = sprintf('online_test_%s_section_%s_video_url', $slug, $section);
        $videoUrl = trim((string) ($validated['video_url'] ?? ''));

        Setting::updateOrCreate(
            ['key' => $settingKey],
            ['value' => $videoUrl, 'type' => 'string']
        );

        return redirect()
            ->route('online-test.show', ['slug' => $slug])
            ->with('success', 'Video instruksi section berhasil diperbarui.');
    }

    public function packageBank(string $slug)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $settings = Setting::query()
            ->where('key', 'like', 'online_test_%')
            ->pluck('value', 'key')
            ->toArray();

        $packageBank = $this->decodePackageBank($settings["online_test_{$slug}_package_bank"] ?? null);

        return view('admin.online-tests.package-bank', [
            'test' => [
                'slug' => $slug,
                'label' => self::TEST_DEFAULTS[$slug]['label'],
                'package_number' => max(1, min(16, (int) ($settings["online_test_{$slug}_package_number"] ?? 1))),
            ],
            'packageBank' => $packageBank,
            'sectionKeys' => self::PACKAGE_BANK_SECTION_KEYS[$slug],
        ]);
    }

    public function updatePackageBank(Request $request, string $slug)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $sectionKeys = self::PACKAGE_BANK_SECTION_KEYS[$slug];

        $validated = $request->validate([
            'packages' => ['required', 'array'],
            'packages.*.title' => ['nullable', 'string', 'max:150'],
            'packages.*.subtitle' => ['nullable', 'string', 'max:150'],
            'packages.*.description' => ['nullable', 'string', 'max:500'],
            'packages.*.notes' => ['nullable', 'string', 'max:5000'],
            'packages.*.sections' => ['nullable', 'array'],
            'packages.*.sections.listening' => ['nullable', 'string', 'max:20000'],
            'packages.*.sections.reading' => ['nullable', 'string', 'max:20000'],
            'packages.*.sections.structure' => ['nullable', 'string', 'max:20000'],
            'packages.*.sections.writing' => ['nullable', 'string', 'max:20000'],
            'packages.*.sections.speaking' => ['nullable', 'string', 'max:20000'],
        ]);

        $packages = [];

        foreach (range(1, 16) as $number) {
            $packageInput = $validated['packages'][$number] ?? [];
            $title = trim((string) ($packageInput['title'] ?? ''));
            $subtitle = trim((string) ($packageInput['subtitle'] ?? ''));
            $description = trim((string) ($packageInput['description'] ?? ''));
            $notes = trim((string) ($packageInput['notes'] ?? ''));
            $sections = is_array($packageInput['sections'] ?? null) ? $packageInput['sections'] : [];

            $packages[$number] = [
                'package_number' => $number,
                'title' => $title !== '' ? $title : 'Paket ' . $number,
                'subtitle' => $subtitle,
                'description' => $description,
                'notes' => $notes,
                'sections' => collect($sectionKeys)->mapWithKeys(
                    fn (string $key): array => [$key => trim((string) ($sections[$key] ?? ''))]
                )->all(),
            ];
        }

        Setting::updateOrCreate(
            ['key' => "online_test_{$slug}_package_bank"],
            ['value' => json_encode($packages, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'type' => 'json']
        );

        return redirect()
            ->route('admin.online-tests.package-bank', ['slug' => $slug])
            ->with('success', 'Bank paket ' . self::TEST_DEFAULTS[$slug]['label'] . ' berhasil disimpan.');
    }

    public function editPackageAnswerKey(string $slug, int $package, string $section)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $section = strtolower(trim($section));
        if (!in_array($section, self::PACKAGE_BANK_SECTION_KEYS[$slug], true)) {
            abort(404);
        }

        $package = max(1, min(16, $package));
        $allAnswerKeys = $this->decodePackageAnswerKeyStorage(
            Setting::query()->where('key', "online_test_{$slug}_package_answer_keys")->value('value')
        );

        $currentAnswerKey = $allAnswerKeys[$package][$section] ?? [];
        if (!is_array($currentAnswerKey)) {
            $currentAnswerKey = [];
        }

        return view('admin.online-tests.package-answer-key', [
            'test' => [
                'slug' => $slug,
                'label' => self::TEST_DEFAULTS[$slug]['label'] ?? $slug,
            ],
            'package' => $package,
            'section' => $section,
            'answerKeyJson' => json_encode($currentAnswerKey, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function updatePackageAnswerKey(Request $request, string $slug, int $package, string $section)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $section = strtolower(trim($section));
        if (!in_array($section, self::PACKAGE_BANK_SECTION_KEYS[$slug], true)) {
            abort(404);
        }

        $package = max(1, min(16, $package));

        $validated = $request->validate([
            'answer_key_json' => ['required', 'string'],
        ]);

        $decodedInput = json_decode((string) $validated['answer_key_json'], true);
        if (!is_array($decodedInput)) {
            return back()->withErrors(['answer_key_json' => 'Format JSON tidak valid.'])->withInput();
        }

        try {
            $decodedInput = $this->normalizePackageAnswerKey($decodedInput, $slug, $section);
        } catch (\InvalidArgumentException $exception) {
            return back()->withErrors(['answer_key_json' => $exception->getMessage()])->withInput();
        }

        $allAnswerKeys = $this->decodePackageAnswerKeyStorage(
            Setting::query()->where('key', "online_test_{$slug}_package_answer_keys")->value('value')
        );

        if (!isset($allAnswerKeys[$package]) || !is_array($allAnswerKeys[$package])) {
            $allAnswerKeys[$package] = [];
        }

        $allAnswerKeys[$package][$section] = $decodedInput;

        Setting::updateOrCreate(
            ['key' => "online_test_{$slug}_package_answer_keys"],
            ['value' => json_encode($allAnswerKeys, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'type' => 'json']
        );

        return redirect()
            ->route('admin.online-tests.package-answer-key.edit', [
                'slug' => $slug,
                'package' => $package,
                'section' => $section,
            ])
            ->with('success', 'Answer key paket berhasil diperbarui.');
    }

    public function packageAnswerKeyJson(string $slug, int $package, string $section)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $section = strtolower(trim($section));
        if (!in_array($section, self::PACKAGE_BANK_SECTION_KEYS[$slug], true)) {
            abort(404);
        }

        $package = max(1, min(16, $package));

        $allAnswerKeys = $this->decodePackageAnswerKeyStorage(
            Setting::query()->where('key', "online_test_{$slug}_package_answer_keys")->value('value')
        );

        $currentAnswerKey = $allAnswerKeys[$package][$section] ?? [];
        if (!is_array($currentAnswerKey)) {
            $currentAnswerKey = [];
        }

        return response()->json([
            'slug' => $slug,
            'package' => $package,
            'section' => $section,
            'answer_key' => $currentAnswerKey,
        ]);
    }

    public function updatePackageAnswerKeyJson(Request $request, string $slug, int $package, string $section)
    {
        if (!array_key_exists($slug, self::PACKAGE_BANK_SECTION_KEYS)) {
            abort(404);
        }

        $section = strtolower(trim($section));
        if (!in_array($section, self::PACKAGE_BANK_SECTION_KEYS[$slug], true)) {
            abort(404);
        }

        $package = max(1, min(16, $package));

        $validated = $request->validate([
            'answer_key' => ['required', 'array'],
        ]);

        try {
            $answerKey = $this->normalizePackageAnswerKey($validated['answer_key'], $slug, $section);
        } catch (\InvalidArgumentException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }

        $allAnswerKeys = $this->decodePackageAnswerKeyStorage(
            Setting::query()->where('key', "online_test_{$slug}_package_answer_keys")->value('value')
        );

        if (!isset($allAnswerKeys[$package]) || !is_array($allAnswerKeys[$package])) {
            $allAnswerKeys[$package] = [];
        }

        $allAnswerKeys[$package][$section] = $answerKey;

        Setting::updateOrCreate(
            ['key' => "online_test_{$slug}_package_answer_keys"],
            ['value' => json_encode($allAnswerKeys, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'type' => 'json']
        );

        return response()->json([
            'success' => true,
            'message' => 'Answer key paket berhasil diperbarui.',
            'answer_key' => $answerKey,
        ]);
    }

    public function editToeflScore()
    {
        $scoreTables = $this->decodeToeflScoreTables(
            Setting::query()->where('key', 'online_test_toefl_itp_score_tables')->value('value')
        );

        return view('admin.online-tests.toefl-score', [
            'scoreTablesJson' => json_encode($scoreTables, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function updateToeflScore(Request $request)
    {
        $validated = $request->validate([
            'score_tables_json' => ['required', 'string'],
        ]);

        $decodedInput = json_decode((string) $validated['score_tables_json'], true);
        if (!is_array($decodedInput)) {
            return back()->withErrors(['score_tables_json' => 'Format JSON tidak valid.'])->withInput();
        }

        $scoreTables = $this->decodeToeflScoreTables($decodedInput);

        Setting::updateOrCreate(
            ['key' => 'online_test_toefl_itp_score_tables'],
            ['value' => json_encode($scoreTables, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'type' => 'json']
        );

        return redirect()
            ->route('admin.online-tests.toefl-score.edit')
            ->with('success', 'Tabel konversi TOEFL ITP berhasil diperbarui.');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function decodePackageBank(?string $json): array
    {
        if (!$json) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function decodePackageAnswerKeyStorage(?string $json): array
    {
        if (!$json) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param  array<string, mixed>  $rawAnswerKey
     * @return array<string, string|array<int, string>>
     */
    private function normalizePackageAnswerKey(array $rawAnswerKey, string $slug, string $section): array
    {
        $expectedQuestionCount = $this->expectedQuestionCountForSection($slug, $section);
        $normalizedAnswerKey = [];

        foreach ($rawAnswerKey as $questionKey => $answerValue) {
            $normalizedQuestionKey = strtolower(trim((string) $questionKey));

            if ($normalizedQuestionKey === '' || !preg_match('/^q(\d+)$/', $normalizedQuestionKey, $matches)) {
                continue;
            }

            $questionNumber = (int) $matches[1];
            if ($expectedQuestionCount !== null && ($questionNumber < 1 || $questionNumber > $expectedQuestionCount)) {
                throw new \InvalidArgumentException(
                    'Nomor soal harus berada pada rentang 1-' . $expectedQuestionCount . ' untuk section ' . ucfirst($section) . '.'
                );
            }

            $normalizedAnswer = $this->normalizeAnswerValueForSection($answerValue, $slug, $section, $questionNumber);
            if ($normalizedAnswer === null) {
                continue;
            }

            $normalizedAnswerKey['q' . $questionNumber] = $normalizedAnswer;
        }

        return $normalizedAnswerKey;
    }

    /**
     * @return string|array<int, string>|null
     */
    private function normalizeAnswerValueForSection(mixed $answerValue, string $slug, string $section, int $questionNumber): string|array|null
    {
        $strictChoiceMode = $slug === 'toefl_itp' && in_array($section, ['listening', 'structure', 'reading'], true);

        if (is_array($answerValue)) {
            $tokens = array_values(array_filter(
                array_map(static fn ($item): string => trim((string) $item), $answerValue),
                static fn (string $item): bool => $item !== ''
            ));
        } else {
            $raw = trim((string) $answerValue);
            if ($raw === '') {
                return null;
            }

            $tokens = str_contains($raw, '|')
                ? array_values(array_filter(array_map('trim', explode('|', $raw)), static fn (string $item): bool => $item !== ''))
                : [$raw];
        }

        if ($tokens === []) {
            return null;
        }

        if ($strictChoiceMode) {
            $normalizedTokens = [];
            foreach ($tokens as $token) {
                $upperToken = strtoupper($token);
                if (!in_array($upperToken, ['A', 'B', 'C', 'D'], true)) {
                    throw new \InvalidArgumentException(
                        'Jawaban untuk section ' . ucfirst($section) . ' nomor ' . $questionNumber . ' harus pilihan A, B, C, atau D.'
                    );
                }

                $normalizedTokens[] = $upperToken;
            }

            $normalizedTokens = array_values(array_unique($normalizedTokens));

            return count($normalizedTokens) === 1 ? $normalizedTokens[0] : $normalizedTokens;
        }

        return count($tokens) === 1 ? $tokens[0] : $tokens;
    }

    private function expectedQuestionCountForSection(string $slug, string $section): ?int
    {
        if ($slug !== 'toefl_itp') {
            return null;
        }

        return match ($section) {
            'listening', 'reading' => 50,
            'structure' => 40,
            default => null,
        };
    }

    /**
     * @param  string|array<string, mixed>|null  $payload
     * @return array<string, array<int, int>>
     */
    private function decodeToeflScoreTables(string|array|null $payload): array
    {
        $defaults = ToeflScoreConverter::defaultTables();

        $decoded = is_string($payload) ? json_decode($payload, true) : $payload;
        if (!is_array($decoded)) {
            return $defaults;
        }

        $normalized = [];

        foreach ($defaults as $section => $defaultTable) {
            $inputTable = $decoded[$section] ?? [];

            if (!is_array($inputTable)) {
                $normalized[$section] = $defaultTable;
                continue;
            }

            $table = [];

            foreach ($inputTable as $raw => $scaled) {
                if (!is_numeric($raw) || !is_numeric($scaled)) {
                    continue;
                }

                $rawScore = (int) $raw;
                $scaledScore = (int) $scaled;

                // Accept both section score format (e.g. 68) and x10 format (e.g. 680).
                if ($scaledScore >= 100) {
                    $scaledScore = (int) round($scaledScore / 10);
                }

                if ($rawScore < 0) {
                    continue;
                }

                $table[$rawScore] = $scaledScore;
            }

            krsort($table);
            $normalized[$section] = $table !== [] ? $table : $defaultTable;
        }

        return $normalized;
    }

    public function referenceAvailability(Request $request)
    {
        $validated = $request->validate([
            'edition' => ['required', 'integer', 'min:1', 'max:16'],
        ]);

        $edition = (int) $validated['edition'];
        $testId = 1;

        $status = [
            'listening' => $this->viewExistsForSkill('listening', $edition, $testId),
            'reading' => $this->viewExistsForSkill('reading', $edition, $testId),
            'writing' => $this->viewExistsForSkill('writing', $edition, $testId),
            'speaking' => $this->viewExistsForSkill('speaking', $edition, $testId),
        ];

        return response()->json(['status' => $status]);
    }

    public function referenceSuggestion(Request $request)
    {
        $validated = $request->validate([
            'preferred_edition' => ['nullable', 'integer', 'min:1', 'max:16'],
        ]);

        $preferredEdition = isset($validated['preferred_edition']) ? (int) $validated['preferred_edition'] : null;

        $candidates = [];

        if ($preferredEdition !== null) {
            $candidates[] = [$preferredEdition, 1];
        }

        foreach (range(1, 16) as $edition) {
            $candidates[] = [$edition, 1];
        }

        $seen = [];

        foreach ($candidates as [$edition, $testId]) {
            $key = $edition . '-' . $testId;
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;

            $status = [
                'listening' => $this->viewExistsForSkill('listening', $edition, $testId),
                'reading' => $this->viewExistsForSkill('reading', $edition, $testId),
                'writing' => $this->viewExistsForSkill('writing', $edition, $testId),
                'speaking' => $this->viewExistsForSkill('speaking', $edition, $testId),
            ];

            if ($status['listening'] && $status['reading'] && $status['writing'] && $status['speaking']) {
                return response()->json([
                    'found' => true,
                    'edition' => $edition,
                    'test_id' => $testId,
                    'status' => $status,
                ]);
            }
        }

        return response()->json([
            'found' => false,
            'edition' => null,
            'test_id' => null,
            'status' => null,
        ]);
    }

    private function viewExistsForSkill(string $skill, int $edition, int $testId): bool
    {
        if ($skill === 'reading') {
            return View::exists('assignments.ielts.mockup.c' . $edition . '-reading-test-' . $testId)
                || View::exists('assignments.ielts.mockup.reading-test-' . $testId);
        }

        if ($skill === 'writing') {
            return View::exists('assignments.ielts.mockup.c' . $edition . '-writing-test-' . $testId)
                || View::exists('assignments.ielts.mockup.writing-test-' . $testId);
        }

        if ($skill === 'speaking') {
            return View::exists('assignments.ielts.mockup.c' . $edition . '-speaking-test-' . $testId)
                || View::exists('assignments.ielts.mockup.speaking-test-' . $testId);
        }

        return View::exists('assignments.ielts.mockup.c' . $edition . '-listening-test-' . $testId)
            || ($testId === 1 && View::exists('assignments.ielts.mockup.listening-test'))
            || ($testId === 2 && View::exists('assignments.ielts.mockup.listening-test-2'))
            || ($testId === 3 && View::exists('assignments.ielts.mockup.listening-test-3'))
            || ($testId === 4 && View::exists('assignments.ielts.mockup.listening-test-4'));
    }
}
