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

class ScholarshipController extends Controller
{
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
        $scholarship->ingest_quality_pass = $this->passesQualityGate(array_merge($validated, [
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
            'title' => $this->findHeaderIndex($normalizedHeader, ['title', 'judul', 'scholarship', 'nama']),
            'provider' => $this->findHeaderIndex($normalizedHeader, ['provider', 'organizer', 'penyelenggara', 'host']),
            'location' => $this->findHeaderIndex($normalizedHeader, ['location', 'lokasi', 'country', 'negara']),
            'level' => $this->findHeaderIndex($normalizedHeader, ['level', 'jenjang', 'degree', 'study']),
            'opening_date' => $this->findHeaderIndex($normalizedHeader, ['opening', 'open date', 'mulai']),
            'deadline' => $this->findHeaderIndex($normalizedHeader, ['deadline', 'closing', 'batas', 'end date']),
            'apply_link' => $this->findHeaderIndex($normalizedHeader, ['apply', 'link', 'url', 'href']),
            'min_ielts' => $this->findHeaderIndex($normalizedHeader, ['ielts']),
            'min_toefl' => $this->findHeaderIndex($normalizedHeader, ['toefl']),
            'description' => $this->findHeaderIndex($normalizedHeader, ['description', 'deskripsi']),
            'requirements' => $this->findHeaderIndex($normalizedHeader, ['requirement', 'eligibility', 'syarat']),
            'benefits' => $this->findHeaderIndex($normalizedHeader, ['benefit', 'coverage', 'fasilitas']),
            'age' => $this->findHeaderIndex($normalizedHeader, ['age', 'usia']),
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
                ? $this->parseRowWithHeaderMap($row, $headerMap)
                : $this->parseNoisyScraperRow($row);

            if (empty($parsed['title']) || empty($parsed['apply_link'])) {
                $errors[] = 'Skipped row: could not detect title/apply_link.';
                continue;
            }

            try {
                $passesQualityGate = $this->passesQualityGate($parsed);
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

        foreach ($records as $record) {
            if ($bulkAction === 'approve') {
                $passes = $this->passesQualityGate([
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

        $urls = $this->extractSourceUrlsFromInput(
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
            $parserName = $this->detectParserNameFromUrl($url);
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

                $parsed = $this->parseScholarshipFromHtml($response->body(), $url);
                $qualityPass = $this->passesQualityGate($parsed);
                $qualityReasons = $qualityPass ? [] : $this->qualityGateFailureReasons($parsed);
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

            $passesQualityGate = $this->passesQualityGate($parsed);
            if ($publishNow && $importMode === 'scholarship' && !$passesQualityGate) {
                $qualityFails++;
            }

            $finalIsActive = $publishNow && $importMode === 'scholarship' && $passesQualityGate;

            $payload = array_merge($parsed, [
                'funding_type' => $importMode,
                'is_active' => $finalIsActive,
                'ingest_source_type' => 'url_scrape',
                'ingest_source_ref' => Str::limit((string) $url, 500, ''),
                'ingest_parser' => Str::limit((string) ($row['parser_name'] ?? $this->detectParserNameFromUrl($url)), 120, ''),
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

    private function findHeaderIndex(array $headers, array $needles): ?int
    {
        foreach ($headers as $index => $header) {
            foreach ($needles as $needle) {
                if ($header !== '' && str_contains($header, $needle)) {
                    return $index;
                }
            }
        }

        return null;
    }

    private function parseRowWithHeaderMap(array $row, array $map): array
    {
        $get = function (?int $idx) use ($row): string {
            return ($idx !== null && isset($row[$idx])) ? trim((string) $row[$idx]) : '';
        };

        $applyLink = $get($map['apply_link']);
        if ($applyLink === '') {
            $applyLink = $this->extractFirstUrl($row);
        }

        $title = $get($map['title']);
        if ($title === '') {
            $title = $this->extractLikelyTitle($row);
        }

        $provider = $get($map['provider']);
        if ($provider === '' && $applyLink !== '') {
            $provider = preg_replace('/^www\./', '', (string) parse_url($applyLink, PHP_URL_HOST));
        }

        $location = $get($map['location']) ?: 'Indonesia';
        $level = $get($map['level']) ?: $this->extractLevelFromRow($row);
        if ($level === '') {
            $level = 'SMA / Diploma / S1';
        }

        $openingDate = $this->parseDateValue($get($map['opening_date']));
        $deadline = $this->parseDateValue($get($map['deadline'])) ?: now()->addDays(90);

        $country = $location;
        $description = $get($map['description']) ?: 'Imported via CSV scraper. Mohon review deskripsi.';

        $ageInfo = $get($map['age']);
        $requirements = $get($map['requirements']);
        if ($requirements === '') {
            $requirements = 'Lihat website resmi untuk detail persyaratan.';
            if ($ageInfo !== '') {
                $requirements .= ' Usia: ' . $ageInfo . '.';
            }
        }

        $benefits = $get($map['benefits']) ?: 'Lihat website resmi untuk detail benefit.';

        $minIeltsRaw = $get($map['min_ielts']);
        $minToeflRaw = $get($map['min_toefl']);

        $minIelts = is_numeric($minIeltsRaw) ? (float) $minIeltsRaw : null;
        $minToefl = is_numeric($minToeflRaw) ? (int) $minToeflRaw : null;

        return [
            'title' => Str::limit($title !== '' ? $title : 'Imported Scholarship', 255, ''),
            'provider' => Str::limit($provider !== '' ? $provider : 'Unknown Provider', 255, ''),
            'location' => Str::limit($location, 255, ''),
            'level_of_study' => Str::limit($level, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink,
            'country' => Str::limit($country, 255, ''),
            'description' => $description,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'min_ielts' => $minIelts,
            'min_toefl' => $minToefl,
        ];
    }

    private function parseNoisyScraperRow(array $row): array
    {
        $cells = array_map(fn ($v) => trim((string) $v), $row);
        $cells = array_values(array_filter($cells, fn ($v) => $v !== ''));

        $applyLink = $this->extractFirstUrl($cells);

        if ($applyLink && str_contains(strtolower($applyLink), 'luarkampus.id')) {
            return $this->parseLuarkampusRow($cells, $applyLink);
        }

        $provider = $applyLink ? preg_replace('/^www\./', '', (string) parse_url($applyLink, PHP_URL_HOST)) : 'Unknown Provider';

        $allDates = [];
        foreach ($cells as $cell) {
            $d = $this->parseDateValue($cell);
            if ($d) {
                $allDates[] = $d;
            }
        }

        $openingDate = $allDates[0] ?? null;
        $deadline = $allDates[1] ?? $allDates[0] ?? now()->addDays(90);

        $title = $this->extractLikelyTitle($cells);
        $level = $this->extractLevelFromRow($cells);
        if ($level === '') {
            $level = 'SMA / Diploma / S1';
        }

        $ageInfo = collect($cells)->first(function ($cell) {
            return (bool) preg_match('/^\d+\+$/', $cell);
        });

        return [
            'title' => Str::limit($title !== '' ? $title : 'Imported Scholarship', 255, ''),
            'provider' => Str::limit($provider !== '' ? $provider : 'Unknown Provider', 255, ''),
            'location' => 'Indonesia',
            'level_of_study' => Str::limit($level, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink ?: '',
            'country' => 'Indonesia',
            'description' => 'Imported from scraper table. Mohon review detail beasiswa.',
            'requirements' => $ageInfo ? ('Periksa syarat resmi. Indikasi usia: ' . $ageInfo . '.') : 'Periksa syarat resmi di halaman sumber.',
            'benefits' => 'Lihat halaman sumber untuk detail benefit.',
            'min_ielts' => null,
            'min_toefl' => null,
        ];
    }

    private function parseLuarkampusRow(array $cells, string $applyLink): array
    {
        $nonUrlCells = array_values(array_filter($cells, function ($cell) {
            return !filter_var($cell, FILTER_VALIDATE_URL);
        }));

        $allDates = [];
        foreach ($nonUrlCells as $cell) {
            $d = $this->parseDateValue($cell);
            if ($d) {
                $allDates[] = $d;
            }
        }

        $openingDate = $allDates[0] ?? null;
        $deadline = $allDates[1] ?? $allDates[0] ?? now()->addDays(90);

        $levelTokens = [];
        foreach ($nonUrlCells as $cell) {
            $upper = strtoupper($cell);
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/', $upper)) {
                $levelTokens[] = $upper;
            }
        }
        $levelTokens = array_values(array_unique($levelTokens));
        $levelOfStudy = count($levelTokens) > 0 ? implode(' / ', $levelTokens) : 'SMA / Diploma / S1';

        $ageInfo = collect($nonUrlCells)->first(function ($cell) {
            return (bool) preg_match('/^\d+\+$/', trim($cell));
        });

        $title = '';
        foreach (array_reverse($nonUrlCells) as $cell) {
            $candidate = trim($cell);
            if ($candidate === '') {
                continue;
            }
            if ($this->parseDateValue($candidate)) {
                continue;
            }
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/i', $candidate)) {
                continue;
            }
            if (preg_match('/^\d+\+$/', $candidate)) {
                continue;
            }
            if (mb_strlen($candidate) >= 6) {
                $title = $candidate;
                break;
            }
        }

        if ($title === '') {
            $title = 'Imported Event dari Luarkampus';
        }

        $requirements = 'Periksa syarat resmi di halaman sumber.';
        if ($ageInfo) {
            $requirements .= ' Indikasi usia minimum: ' . $ageInfo . '.';
        }
        if (count($levelTokens) > 0) {
            $requirements .= ' Jenjang target: ' . implode(' / ', $levelTokens) . '.';
        }

        return [
            'title' => Str::limit($title, 255, ''),
            'provider' => 'luarkampus.id',
            'location' => 'Indonesia',
            'level_of_study' => Str::limit($levelOfStudy, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink,
            'country' => 'Indonesia',
            'description' => 'Imported from luarkampus.id via CSV scraper. Mohon review apakah ini beasiswa/event yang sesuai sebelum publish.',
            'requirements' => $requirements,
            'benefits' => 'Lihat halaman sumber untuk detail benefit atau hadiah.',
            'min_ielts' => null,
            'min_toefl' => null,
        ];
    }

    private function extractFirstUrl(array $cells): ?string
    {
        foreach ($cells as $cell) {
            if (filter_var($cell, FILTER_VALIDATE_URL)) {
                return $cell;
            }
        }

        return null;
    }

    private function extractLikelyTitle(array $cells): string
    {
        foreach (array_reverse($cells) as $cell) {
            if (filter_var($cell, FILTER_VALIDATE_URL)) {
                continue;
            }
            if (mb_strlen($cell) >= 10 && !preg_match('/^\d+[\/-]\d+[\/-]\d+$/', $cell)) {
                return $cell;
            }
        }

        return '';
    }

    private function extractLevelFromRow(array $cells): string
    {
        $tokens = [];
        foreach ($cells as $cell) {
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/i', strtoupper($cell))) {
                $tokens[] = strtoupper($cell);
            }
        }

        $tokens = array_values(array_unique($tokens));
        return implode(' / ', $tokens);
    }

    private function parseDateValue(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        $raw = trim($value);
        $formats = ['d M Y', 'd F Y', 'Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $raw);
            } catch (\Throwable $e) {
                // try next format
            }
        }

        try {
            return Carbon::parse($raw);
        } catch (\Throwable $e) {
            return null;
        }
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

    private function extractSourceUrlsFromInput(?string $bulkInput, ?string $singleInput): array
    {
        $raw = [];

        if ($singleInput && trim($singleInput) !== '') {
            $raw[] = trim($singleInput);
        }

        if ($bulkInput && trim($bulkInput) !== '') {
            $chunks = preg_split('/[\r\n,;\t ]+/', $bulkInput);
            foreach ($chunks as $chunk) {
                $v = trim((string) $chunk);
                if ($v !== '') {
                    $raw[] = $v;
                }
            }
        }

        $raw = array_values(array_unique($raw));

        return array_values(array_filter($raw, function ($url) {
            return (bool) filter_var($url, FILTER_VALIDATE_URL);
        }));
    }

    private function detectParserNameFromUrl(string $url): string
    {
        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?? ''));

        if (str_contains($host, 'daad.de')) {
            return 'site_daad';
        }

        if (str_contains($host, 'chevening.org')) {
            return 'site_chevening';
        }

        if (str_contains($host, 'australiaawardsindonesia.org')) {
            return 'site_australia_awards';
        }

        if (str_contains($host, 'luarkampus.id')) {
            return 'site_luarkampus';
        }

        return 'html_generic';
    }

    private function passesQualityGate(array $parsed): bool
    {
        return count($this->qualityGateFailureReasons($parsed)) === 0;
    }

    private function qualityGateFailureReasons(array $parsed): array
    {
        $reasons = [];

        $title = trim((string) ($parsed['title'] ?? ''));
        $applyLink = trim((string) ($parsed['apply_link'] ?? ''));
        $deadlineRaw = trim((string) ($parsed['deadline'] ?? ''));

        if (mb_strlen($title) < 8) {
            $reasons[] = 'Title terlalu pendek (min 8 karakter).';
        }

        if (!filter_var($applyLink, FILTER_VALIDATE_URL)) {
            $reasons[] = 'Apply link tidak valid.';
        }

        $deadline = null;
        try {
            $deadline = Carbon::parse($deadlineRaw);
        } catch (\Throwable $e) {
            $reasons[] = 'Deadline tidak bisa diparse sebagai tanggal valid.';
        }

        if ($deadline && $deadline->lt(now()->subDay())) {
            $reasons[] = 'Deadline sudah lewat.';
        }

        return $reasons;
    }

    private function parseScholarshipFromHtml(string $html, string $url): array
    {
        $xpath = $this->makeXPath($html);

        $title = $this->extractFirst($xpath, [
            "//meta[@property='og:title']/@content",
            "//meta[@name='twitter:title']/@content",
            "//h1[1]/text()",
            "//title/text()",
        ]);

        $description = $this->extractFirst($xpath, [
            "//meta[@name='description']/@content",
            "//meta[@property='og:description']/@content",
            "//article//p[1]/text()",
            "//main//p[1]/text()",
            "//p[1]/text()",
        ]);

        $bodyText = Str::of(strip_tags($html))->replaceMatches('/\s+/', ' ')->lower()->toString();

        $country = $this->inferCountry($bodyText);
        $location = $country ?: 'Global';
        $level = $this->inferLevelOfStudy($bodyText);
        $deadline = $this->extractDeadline($bodyText);
        $minIelts = $this->extractFirstNumber($bodyText, '/ielts[^0-9]{0,20}([4-9](?:\.[05])?)/i');
        $minToefl = $this->extractFirstNumber($bodyText, '/toefl(?:\s*(?:itp|ibt))?[^0-9]{0,20}(\d{2,3})/i');

        $provider = parse_url($url, PHP_URL_HOST) ?: 'Unknown Provider';
        $provider = preg_replace('/^www\./', '', $provider);

        $requirements = $this->extractSectionByKeywords($html, ['requirement', 'eligibility', 'criteria', 'syarat']);
        $benefits = $this->extractSectionByKeywords($html, ['benefit', 'funding', 'coverage', 'award', 'beasiswa']);

        $title = $title ?: Str::title(str_replace(['-', '_'], ' ', $provider . ' scholarship'));
        $description = $description ?: 'Imported by scraper. Mohon review deskripsi dari sumber resmi.';
        $requirements = $requirements ?: 'Lihat website resmi untuk detail persyaratan.';
        $benefits = $benefits ?: 'Lihat website resmi untuk detail benefit.';

        $base = [
            'title' => Str::limit(trim($title), 255, ''),
            'provider' => Str::limit(trim((string) $provider), 255, ''),
            'location' => Str::limit(trim((string) $location), 255, ''),
            'level_of_study' => Str::limit(trim((string) $level), 255, ''),
            'description' => trim($description),
            'requirements' => trim($requirements),
            'benefits' => trim($benefits),
            'deadline' => $deadline->toDateString(),
            'opening_date' => null,
            'requires_certification' => !is_null($minIelts) || !is_null($minToefl),
            'country' => $country,
            'min_ielts' => $minIelts,
            'min_toefl' => $minToefl ? (int) round($minToefl) : null,
            'is_active' => true,
            'apply_link' => $url,
        ];

        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?? ''));
        $siteSpecific = $this->parseSiteSpecific($xpath, $html, $host);

        foreach ($siteSpecific as $k => $v) {
            if ($v !== null && $v !== '') {
                $base[$k] = $v;
            }
        }

        return $base;
    }

    private function parseSiteSpecific(\DOMXPath $xpath, string $html, string $host): array
    {
        if (str_contains($host, 'daad.de')) {
            return $this->parseDaadSpecific($xpath, $html);
        }
        if (str_contains($host, 'chevening.org')) {
            return $this->parseCheveningSpecific($xpath, $html);
        }
        if (str_contains($host, 'australiaawardsindonesia.org')) {
            return $this->parseAustraliaAwardsSpecific($xpath, $html);
        }

        return [];
    }

    private function parseDaadSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[contains(@class,'title')]/text()",
            "//h1[1]/text()",
            "//title/text()",
        ]);

        $requirements = $this->extractSectionByKeywords($html, ['application requirements', 'requirements', 'eligibility']);
        $benefits = $this->extractSectionByKeywords($html, ['funding', 'benefits', 'scholarship value']);

        return [
            'title' => $title,
            'provider' => 'DAAD',
            'country' => 'Germany',
            'location' => 'Germany',
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function parseCheveningSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[1]/text()",
            "//meta[@property='og:title']/@content",
            "//title/text()",
        ]);
        $description = $this->extractFirst($xpath, [
            "//meta[@name='description']/@content",
            "//article//p[1]/text()",
        ]);
        $requirements = $this->extractSectionByKeywords($html, ['eligible', 'eligibility', 'requirements']);
        $benefits = $this->extractSectionByKeywords($html, ['fully funded', 'benefits', 'what is included']);

        return [
            'title' => $title,
            'provider' => 'Chevening',
            'country' => 'United Kingdom',
            'location' => 'United Kingdom',
            'description' => $description,
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function parseAustraliaAwardsSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[1]/text()",
            "//meta[@property='og:title']/@content",
            "//title/text()",
        ]);
        $requirements = $this->extractSectionByKeywords($html, ['eligibility', 'persyaratan', 'requirements']);
        $benefits = $this->extractSectionByKeywords($html, ['benefits', 'what you will receive', 'pendanaan']);

        return [
            'title' => $title,
            'provider' => 'Australia Awards Indonesia',
            'country' => 'Australia',
            'location' => 'Australia',
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function makeXPath(string $html): \DOMXPath
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        return new \DOMXPath($dom);
    }

    private function extractFirst(\DOMXPath $xpath, array $queries): ?string
    {
        foreach ($queries as $query) {
            $nodes = $xpath->query($query);
            if ($nodes && $nodes->length > 0) {
                $value = trim($nodes->item(0)->nodeValue ?? '');
                if ($value !== '') {
                    return preg_replace('/\s+/', ' ', $value);
                }
            }
        }

        return null;
    }

    private function inferCountry(string $text): ?string
    {
        $map = [
            'australia' => 'Australia',
            'united kingdom' => 'United Kingdom',
            'uk ' => 'United Kingdom',
            'england' => 'United Kingdom',
            'united states' => 'United States',
            'usa' => 'United States',
            'canada' => 'Canada',
            'japan' => 'Japan',
            'korea' => 'South Korea',
            'germany' => 'Germany',
            'france' => 'France',
            'netherlands' => 'Netherlands',
            'singapore' => 'Singapore',
            'new zealand' => 'New Zealand',
        ];

        foreach ($map as $needle => $country) {
            if (str_contains($text, $needle)) {
                return $country;
            }
        }

        return null;
    }

    private function inferLevelOfStudy(string $text): string
    {
        $levels = [];
        if (str_contains($text, 'bachelor') || str_contains($text, 'undergraduate') || str_contains($text, 's1')) {
            $levels[] = 'Bachelor';
        }
        if (str_contains($text, 'master') || str_contains($text, 'postgraduate') || str_contains($text, 's2')) {
            $levels[] = 'Master';
        }
        if (str_contains($text, 'phd') || str_contains($text, 'doctoral') || str_contains($text, 's3')) {
            $levels[] = 'PhD';
        }

        if (count($levels) === 0) {
            return 'Bachelor / Master / PhD';
        }

        return implode(' / ', $levels);
    }

    private function extractDeadline(string $text): Carbon
    {
        $patterns = [
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}([a-z]{3,9}\s+\d{1,2},?\s+\d{4})/i',
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4})/i',
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}(\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    return Carbon::parse(trim($matches[1]));
                } catch (\Throwable $e) {
                    // Continue to next pattern.
                }
            }
        }

        return now()->addDays(90);
    }

    private function extractFirstNumber(string $text, string $pattern): ?float
    {
        if (preg_match($pattern, $text, $matches)) {
            return is_numeric($matches[1]) ? (float) $matches[1] : null;
        }

        return null;
    }

    private function extractSectionByKeywords(string $html, array $keywords): ?string
    {
        $plain = preg_replace('/\s+/', ' ', strip_tags($html));

        foreach ($keywords as $keyword) {
            $pattern = '/(?:' . preg_quote($keyword, '/') . ')[^\.\n]{0,220}(?:\.|\n)/i';
            if (preg_match($pattern, $plain, $matches)) {
                $text = trim($matches[0]);
                if ($text !== '') {
                    return $text;
                }
            }
        }

        return null;
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

