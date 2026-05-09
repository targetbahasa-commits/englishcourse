<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\FreeTestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Application\Scholarship\ScholarshipCsvImportParser;
use App\Application\Scholarship\ScholarshipHtmlScraper;
use App\Application\Scholarship\ScholarshipQualityGate;

class ScholarshipController extends Controller
{
    public function __construct(
        private ScholarshipCsvImportParser $csvParser,
        private ScholarshipHtmlScraper $htmlScraper,
        private ScholarshipQualityGate $qualityGate,
    ) {}

    /**
     * Bulk publish selected scholarships (set is_active = true)
     */
    public function bulkPublish(Request $request)
    {
        $validated = $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'integer|exists:scholarships,id',
        ]);

        $selectedIds = $validated['selected_ids'];
        $updated = Scholarship::whereIn('id', $selectedIds)->update(['is_active' => true]);

        return redirect()->back()->with('success', $updated.' scholarships published.');
    }
    /**
     * Display a listing of the scholarships.
     */
    public function index()
    {
        $filter = request()->query('filter', 'all');

        $query = Scholarship::query();

        if ($filter === 'active-scholarships') {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('funding_type')
                        ->orWhere('funding_type', 'scholarship');
                });
        } elseif ($filter === 'event-drafts') {
            $query->where(function ($q) {
                $q->where('funding_type', 'event')
                    ->orWhere('is_active', false);
            });
        } elseif ($filter === 'source-manual') {
            $query->where('ingest_source_type', 'manual');
        } elseif ($filter === 'source-csv') {
            $query->where('ingest_source_type', 'csv');
        } elseif ($filter === 'source-url-scrape') {
            $query->where('ingest_source_type', 'url_scrape');
        }

        $scholarships = $query->latest()->paginate(10)->withQueryString();

        $allCount = Scholarship::count();
        $activeScholarshipsCount = Scholarship::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('funding_type')
                    ->orWhere('funding_type', 'scholarship');
            })
            ->count();
        $eventDraftsCount = Scholarship::where(function ($q) {
            $q->where('funding_type', 'event')
                ->orWhere('is_active', false);
        })->count();
        $manualSourceCount = Scholarship::where('ingest_source_type', 'manual')->count();
        $csvSourceCount = Scholarship::where('ingest_source_type', 'csv')->count();
        $urlScrapeSourceCount = Scholarship::where('ingest_source_type', 'url_scrape')->count();
        $ingestHealth = [
            'manual' => $this->buildIngestHealthStat('manual', 'Manual'),
            'csv' => $this->buildIngestHealthStat('csv', 'CSV'),
            'url_scrape' => $this->buildIngestHealthStat('url_scrape', 'URL Scrape'),
        ];
        $last24hCutoff = now()->subDay();
        $recentIngestSummary = [
            'count' => Scholarship::where('ingested_at', '>=', $last24hCutoff)->count(),
            'pass_count' => Scholarship::where('ingested_at', '>=', $last24hCutoff)
                ->where('ingest_quality_pass', true)
                ->count(),
            'fail_count' => Scholarship::where('ingested_at', '>=', $last24hCutoff)
                ->where('ingest_quality_pass', false)
                ->count(),
        ];
        $recentIngestFailures = Scholarship::query()
            ->where('ingest_quality_pass', false)
            ->whereNotNull('ingested_at')
            ->latest('ingested_at')
            ->limit(5)
            ->get();

        $scrapePreview = session('scholarship_scrape_preview');

        return view('admin.scholarships.index', compact(
            'scholarships',
            'filter',
            'allCount',
            'activeScholarshipsCount',
            'eventDraftsCount',
            'manualSourceCount',
            'csvSourceCount',
            'urlScrapeSourceCount',
            'ingestHealth',
            'recentIngestSummary',
            'recentIngestFailures',
            'scrapePreview'
        ));
    }

    private function buildIngestHealthStat(string $sourceType, string $label): array
    {
        $baseQuery = Scholarship::where('ingest_source_type', $sourceType);
        $count = (clone $baseQuery)->count();
        $passCount = (clone $baseQuery)->where('ingest_quality_pass', true)->count();
        $lastIngestedAt = (clone $baseQuery)->whereNotNull('ingested_at')->max('ingested_at');

        return [
            'label' => $label,
            'count' => $count,
            'pass_count' => $passCount,
            'pass_rate' => $count > 0 ? round(($passCount / $count) * 100, 1) : 0,
            'last_ingested_at' => $lastIngestedAt ? Carbon::parse($lastIngestedAt) : null,
        ];
    }

    /**
     * Show the form for creating a new scholarship.
     */
    public function create()
    {
        return view('admin.scholarships.create');
    }

    /**
     * Store a newly created scholarship in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'requires_certification' => 'boolean',
            'country' => 'nullable|string|max:255',
            'min_ielts' => 'nullable|numeric|min:0|max:9',
            'min_toefl' => 'nullable|integer|min:0|max:677',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship = new Scholarship($validated);
        $scholarship->is_active = $request->boolean('is_active', true);
        $scholarship->requires_certification = $request->boolean('requires_certification', true);
        $scholarship->ingest_source_type = 'manual';
        $scholarship->ingest_source_ref = 'admin_form';
        $scholarship->ingest_parser = 'manual_admin';
        $scholarship->ingested_at = now();
        $scholarship->ingest_quality_pass = $this->qualityGate->passes(array_merge($validated, [
            'apply_link' => $validated['apply_link'] ?? '',
            'deadline' => $validated['deadline'] ?? '',
            'title' => $validated['title'] ?? '',
        ]));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship created successfully.');
    }

    /**
     * Show the form for editing the specified scholarship.
     */
    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    /**
     * Update the specified scholarship in storage.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'opening_date' => 'nullable|date',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'requires_certification' => 'boolean',
            'country' => 'nullable|string|max:255',
            'min_ielts' => 'nullable|numeric|min:0|max:9',
            'min_toefl' => 'nullable|integer|min:0|max:677',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship->fill($validated);
        $scholarship->is_active = $request->boolean('is_active', false);
        $scholarship->requires_certification = $request->boolean('requires_certification', false);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($scholarship->image_path) {
                Storage::disk('public')->delete($scholarship->image_path);
            }
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship updated successfully.');
    }

    /**
     * Remove the specified scholarship from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->image_path) {
            Storage::disk('public')->delete($scholarship->image_path);
        }
        
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship deleted successfully.');
    }

    /**
     * Show the CSV bulk import form.
     */
    public function importForm()
    {
        return view('admin.scholarships.import');
    }

    /**
     * Process the uploaded CSV and bulk-insert scholarships.
     */
    public function importProcess(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            'import_mode' => 'nullable|in:scholarship,event',
            'publish_now' => 'nullable|boolean',
        ]);

        $importMode = $request->input('import_mode', 'event');
        $publishNow = $request->boolean('publish_now', false);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $sourceFileName = $file->getClientOriginalName() ?: 'uploaded.csv';

        // Read header row (can be clean headers or noisy CSS-class headers from browser scraper tools)
        $header = fgetcsv($handle) ?: [];
        $normalizedHeader = array_map(function ($h) {
            return Str::of((string) $h)->lower()->replaceMatches('/[^a-z0-9]+/', ' ')->trim()->toString();
        }, $header);

        $headerMap = [
            'title' => $this->csvParser->findHeaderIndex($normalizedHeader, ['title', 'judul', 'scholarship', 'nama']),
            'provider' => $this->csvParser->findHeaderIndex($normalizedHeader, ['provider', 'organizer', 'penyelenggara', 'host']),
            'location' => $this->csvParser->findHeaderIndex($normalizedHeader, ['location', 'lokasi', 'country', 'negara']),
            'level' => $this->csvParser->findHeaderIndex($normalizedHeader, ['level', 'jenjang', 'degree', 'study']),
            'opening_date' => $this->csvParser->findHeaderIndex($normalizedHeader, ['opening', 'open date', 'mulai']),
            'deadline' => $this->csvParser->findHeaderIndex($normalizedHeader, ['deadline', 'closing', 'batas', 'end date']),
            'apply_link' => $this->csvParser->findHeaderIndex($normalizedHeader, ['apply', 'link', 'url', 'href']),
            'min_ielts' => $this->csvParser->findHeaderIndex($normalizedHeader, ['ielts']),
            'min_toefl' => $this->csvParser->findHeaderIndex($normalizedHeader, ['toefl']),
            'description' => $this->csvParser->findHeaderIndex($normalizedHeader, ['description', 'deskripsi']),
            'requirements' => $this->csvParser->findHeaderIndex($normalizedHeader, ['requirement', 'eligibility', 'syarat']),
            'benefits' => $this->csvParser->findHeaderIndex($normalizedHeader, ['benefit', 'coverage', 'fasilitas']),
            'age' => $this->csvParser->findHeaderIndex($normalizedHeader, ['age', 'usia']),
        ];

        // Heuristic: if headers are mostly noisy (e.g. "flex", "font-semibold"), we fallback to position-based parsing.
        $hasUsefulHeader = collect($headerMap)
            ->filter(fn ($v) => $v !== null)
            ->count() >= 3;

        $imported = 0;
        $errors   = [];
        $qualityWarnings = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) {
                $errors[] = 'Skipped a row with insufficient columns.';
                continue;
            }

            $parsed = $hasUsefulHeader
                ? $this->csvParser->parseRowWithHeaderMap($row, $headerMap)
                : $this->csvParser->parseNoisyScraperRow($row);

            if (empty($parsed['title']) || empty($parsed['apply_link'])) {
                $errors[] = 'Skipped row: could not detect title/apply_link.';
                continue;
            }

            try {
                $passesQualityGate = $this->qualityGate->passes($parsed);
                if ($publishNow && $importMode === 'scholarship' && !$passesQualityGate) {
                    $qualityWarnings++;
                }

                Scholarship::updateOrCreate(
                    ['apply_link' => $parsed['apply_link']],
                    [
                        'title' => $parsed['title'],
                        'provider' => $parsed['provider'],
                        'location' => $parsed['location'],
                        'level_of_study' => $parsed['level_of_study'],
                        'opening_date' => $parsed['opening_date'],
                        'deadline' => $parsed['deadline'],
                        'country' => $parsed['country'],
                        'description' => $parsed['description'],
                        'requirements' => $parsed['requirements'],
                        'benefits' => $parsed['benefits'],
                        'min_ielts' => $parsed['min_ielts'],
                        'min_toefl' => $parsed['min_toefl'],
                        'funding_type' => $importMode,
                        'requires_certification' => (!empty($parsed['min_ielts']) || !empty($parsed['min_toefl'])),
                        'is_active' => $publishNow && $importMode === 'scholarship' && $passesQualityGate,
                        'ingest_source_type' => 'csv',
                        'ingest_source_ref' => Str::limit($sourceFileName, 500, ''),
                        'ingest_parser' => $hasUsefulHeader ? 'csv_header_map' : 'csv_noisy_fallback',
                        'ingested_at' => now(),
                        'ingest_quality_pass' => $passesQualityGate,
                    ]
                );
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Failed to import '{$parsed['title']}': " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Successfully imported {$imported} record(s).";
        if ($errors) {
            $message .= ' Skipped ' . count($errors) . ' row(s) with issues.';
        }
        if ($qualityWarnings > 0) {
            $message .= " {$qualityWarnings} row(s) failed quality gate and were saved as inactive for review.";
        }
        $message .= $publishNow && $importMode === 'scholarship'
            ? ' Mode: Scholarship (published).' 
            : ' Mode: ' . ucfirst($importMode) . ' (saved as inactive for review).';

        return redirect()->route('admin.scholarships.index')->with('success', $message);
    }

    /**
     * Bulk review actions for imported scholarship/event drafts.
     */
    public function bulkReview(Request $request)
    {
        $validated = $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'integer|exists:scholarships,id',
            'bulk_action' => 'required|in:approve,reject',
        ]);

        $selectedIds = $validated['selected_ids'];
        $bulkAction = $validated['bulk_action'];

        $records = Scholarship::whereIn('id', $selectedIds)->get();

        $updated = 0;
        $qualityFails = 0;

        /** @var \App\Models\Scholarship $record */
        foreach ($records as $record) {
            if ($bulkAction === 'approve') {
                $passes = $this->qualityGate->passes([
                    'title' => $record->title,
                    'apply_link' => $record->apply_link,
                    'deadline' => optional($record->deadline)->toDateString(),
                ]);

                $record->funding_type = 'scholarship';
                $record->is_active = $passes;

                if (!$passes) {
                    $qualityFails++;
                }
            } else {
                $record->funding_type = 'event';
                $record->is_active = false;
            }

            $record->save();
            $updated++;
        }

        $message = "Bulk action berhasil untuk {$updated} item.";
        if ($bulkAction === 'approve' && $qualityFails > 0) {
            $message .= " {$qualityFails} item gagal quality gate dan tetap inactive.";
        }

        return redirect()->route('admin.scholarships.index', ['filter' => request('filter', 'all')])
            ->with('success', $message);
    }

    /**
     * Preview scrape results from one or many URLs before saving.
     */
    public function scrapePreview(Request $request)
    {
        $validated = $request->validate([
            'source_urls' => 'nullable|string|max:50000',
            'source_url' => 'nullable|url|max:1000',
            'overwrite_existing' => 'nullable|boolean',
            'import_mode' => 'nullable|in:scholarship,event',
            'publish_now' => 'nullable|boolean',
        ]);

        $urls = $this->htmlScraper->extractSourceUrlsFromInput(
            $validated['source_urls'] ?? null,
            $validated['source_url'] ?? null
        );

        if (count($urls) === 0) {
            return redirect()->route('admin.scholarships.index')
                ->with('error', 'Masukkan minimal satu URL valid untuk di-scrape.');
        }

        $importMode = $request->input('import_mode', 'event');
        $publishNow = $request->boolean('publish_now', false);
        $overwrite = $request->boolean('overwrite_existing', true);

        $items = [];
        foreach ($urls as $url) {
            $host = parse_url($url, PHP_URL_HOST) ?: 'unknown';
            $parserName = $this->htmlScraper->detectParserNameFromUrl($url);
            $rateKey = 'scholarship-scrape:' . (Auth::id() ?? 'guest') . ':' . $host;
            if (RateLimiter::tooManyAttempts($rateKey, 8)) {
                $items[] = [
                    'url' => $url,
                    'status' => 'rate_limited',
                    'error' => 'Rate limit domain tercapai. Coba lagi nanti.',
                    'parser_name' => $parserName,
                ];
                continue;
            }
            RateLimiter::hit($rateKey, 60);

            try {
                $response = Http::timeout(20)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (compatible; TargetBahasaScholarshipBot/1.0)',
                        'Accept-Language' => 'en-US,en;q=0.9,id;q=0.8',
                    ])
                    ->get($url);

                if (!$response->ok()) {
                    $items[] = [
                        'url' => $url,
                        'status' => 'error',
                        'error' => 'HTTP ' . $response->status(),
                        'parser_name' => $parserName,
                    ];
                    continue;
                }

                $parsed = $this->htmlScraper->parseScholarshipFromHtml($response->body(), $url);
                $qualityPass = $this->qualityGate->passes($parsed);
                $qualityReasons = $qualityPass ? [] : $this->qualityGate->failureReasons($parsed);
                $existing = Scholarship::where('apply_link', $url)->exists();

                $items[] = [
                    'url' => $url,
                    'status' => 'ok',
                    'existing' => $existing,
                    'quality_pass' => $qualityPass,
                    'quality_reasons' => $qualityReasons,
                    'parser_name' => $parserName,
                    'parsed' => $parsed,
                ];
            } catch (\Throwable $e) {
                $items[] = [
                    'url' => $url,
                    'status' => 'error',
                    'error' => $e->getMessage(),
                    'parser_name' => $parserName,
                ];
            }
        }

        session()->put('scholarship_scrape_preview', [
            'items' => $items,
            'options' => [
                'import_mode' => $importMode,
                'publish_now' => $publishNow,
                'overwrite_existing' => $overwrite,
            ],
            'created_at' => now()->toDateTimeString(),
        ]);

        $okCount = collect($items)->where('status', 'ok')->count();
        $errCount = collect($items)->whereIn('status', ['error', 'rate_limited'])->count();

        return redirect()->route('admin.scholarships.index')
            ->with('success', "Preview selesai. {$okCount} URL siap diproses, {$errCount} URL bermasalah.");
    }

    /**
     * Commit selected preview rows into database.
     */
    public function scrapeCommit(Request $request)
    {
        $validated = $request->validate([
            'selected_indexes' => 'required|array|min:1',
            'selected_indexes.*' => 'integer|min:0',
        ]);

        $preview = session('scholarship_scrape_preview');
        if (!$preview || empty($preview['items'])) {
            return redirect()->route('admin.scholarships.index')
                ->with('error', 'Preview tidak ditemukan atau sudah kadaluarsa. Silakan preview ulang.');
        }

        $items = $preview['items'];
        $options = $preview['options'] ?? [];
        $importMode = $options['import_mode'] ?? 'event';
        $publishNow = (bool) ($options['publish_now'] ?? false);
        $overwrite = (bool) ($options['overwrite_existing'] ?? true);

        $selectedIndexes = collect($validated['selected_indexes'])->unique()->values();

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $qualityFails = 0;

        foreach ($selectedIndexes as $idx) {
            $row = $items[$idx] ?? null;
            if (!$row || ($row['status'] ?? null) !== 'ok' || empty($row['parsed'])) {
                $skipped++;
                continue;
            }

            $url = $row['url'];
            $parsed = $row['parsed'];

            $existing = Scholarship::where('apply_link', $url)->first();
            if ($existing && !$overwrite) {
                $skipped++;
                continue;
            }

            $passesQualityGate = $this->qualityGate->passes($parsed);
            if ($publishNow && $importMode === 'scholarship' && !$passesQualityGate) {
                $qualityFails++;
            }

            $finalIsActive = $publishNow && $importMode === 'scholarship' && $passesQualityGate;

            $payload = array_merge($parsed, [
                'funding_type' => $importMode,
                'is_active' => $finalIsActive,
                'ingest_source_type' => 'url_scrape',
                'ingest_source_ref' => Str::limit((string) $url, 500, ''),
                'ingest_parser' => Str::limit((string) ($row['parser_name'] ?? $this->htmlScraper->detectParserNameFromUrl($url)), 120, ''),
                'ingested_at' => now(),
                'ingest_quality_pass' => $passesQualityGate,
            ]);

            if ($existing) {
                $existing->fill($payload);
                $existing->save();
                $updated++;
            } else {
                Scholarship::create($payload);
                $created++;
            }
        }

        session()->forget('scholarship_scrape_preview');

        $message = "Commit selesai. Created: {$created}, Updated: {$updated}, Skipped: {$skipped}.";
        if ($qualityFails > 0) {
            $message .= " {$qualityFails} item gagal quality gate dan disimpan inactive.";
        }

        return redirect()->route('admin.scholarships.index')
            ->with('success', $message);
    }

    /**
     * Clear staged scrape preview from session.
     */
    public function scrapePreviewClear()
    {
        session()->forget('scholarship_scrape_preview');

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Preview scrape berhasil dibersihkan.');
    }

    /**
     * Scrape a scholarship page by URL and create/update a scholarship record.
     */
    public function scrapeProcess(Request $request)
    {
        $request->validate([
            'source_url' => 'required|url|max:1000',
            'overwrite_existing' => 'nullable|boolean',
            'import_mode' => 'nullable|in:scholarship,event',
            'publish_now' => 'nullable|boolean',
        ]);

        // Backward-compatible endpoint: keep accepting single URL but use preview-first flow.
        $request->merge([
            'source_urls' => trim((string) $request->input('source_url', '')),
        ]);

        return $this->scrapePreview($request);
    }

    /**
     * Smart Match: find students whose best IELTS or TOEFL score meets the scholarship requirement.
     */
    public function smartMatch(Scholarship $scholarship)
    {
        // For each user who has at least one free test result, get their best relevant score.
        $hasIelts = $scholarship->min_ielts !== null;
        $hasToefl = $scholarship->min_toefl !== null;

        // Build a list of user_ids that qualify
        $eligibleIelts = collect();
        $eligibleToefl = collect();

        if ($hasIelts) {
            // IELTS test_type examples: 'ielts_academic', 'ielts_general'
            $eligibleIelts = FreeTestResult::whereIn('test_type', ['ielts_academic', 'ielts_general', 'ielts'])
                ->select('user_id', DB::raw('MAX(score) as best_score'))
                ->groupBy('user_id')
                ->having('best_score', '>=', $scholarship->min_ielts)
                ->with('user')
                ->get();
        }

        if ($hasToefl) {
            // TOEFL test_type examples: 'toefl_itp', 'toefl'
            $eligibleToefl = FreeTestResult::whereIn('test_type', ['toefl_itp', 'toefl'])
                ->select('user_id', DB::raw('MAX(score) as best_score'))
                ->groupBy('user_id')
                ->having('best_score', '>=', $scholarship->min_toefl)
                ->with('user')
                ->get();
        }

        // Merge and de-duplicate by user_id, keeping highest score representation
        $allUserIds = $eligibleIelts->pluck('user_id')
            ->merge($eligibleToefl->pluck('user_id'))
            ->unique();

        $matchedUsers = User::whereIn('id', $allUserIds)->get()->map(function ($user) use ($eligibleIelts, $eligibleToefl) {
            $ieltsEntry = $eligibleIelts->firstWhere('user_id', $user->id);
            $toeflEntry = $eligibleToefl->firstWhere('user_id', $user->id);
            $user->best_ielts = $ieltsEntry ? $ieltsEntry->best_score : null;
            $user->best_toefl = $toeflEntry ? $toeflEntry->best_score : null;
            return $user;
        });

        return view('admin.scholarships.match', compact('scholarship', 'matchedUsers'));
    }
}

