@extends('layouts.admin')

@section('title', 'Scholarships')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Scholarship Management</h1>
            <p class="text-sm text-gray-500 mt-1">Manage and publish scholarship opportunities.</p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Import CSV button -->
            <a href="{{ route('admin.scholarships.import.form') }}" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg px-4 py-2 inline-flex items-center transition shadow-sm">
                <svg class="w-4 h-4 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span class="ml-2 font-medium">Import CSV</span>
            </a>
            <!-- Add button -->
            <a href="{{ route('admin.scholarships.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 inline-flex items-center transition">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="ml-2 font-medium">Add Scholarship</span>
            </a>
        </div>

    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 flex justify-between items-center" x-init="setTimeout(() => show = false, 7000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if ($errors->has('source_url') || $errors->has('source_urls'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"></path></svg>
                <span>{{ $errors->first('source_urls') ?: $errors->first('source_url') }}</span>
            </div>
        </div>
    @endif

    <div class="mb-6 grid gap-4 md:grid-cols-3">
        @foreach($ingestHealth as $sourceKey => $sourceStat)
            @php
                $cardTone = match($sourceKey) {
                    'manual' => 'border-slate-200 bg-slate-50/70 text-slate-700',
                    'csv' => 'border-cyan-200 bg-cyan-50/70 text-cyan-700',
                    default => 'border-violet-200 bg-violet-50/70 text-violet-700',
                };
            @endphp
            <div class="rounded-xl border p-4 {{ $cardTone }}">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] opacity-80">Ingest Health</p>
                        <h2 class="mt-1 text-lg font-bold">{{ $sourceStat['label'] }}</h2>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold">{{ $sourceStat['count'] }} items</span>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                    <div class="rounded-lg bg-white/80 p-3">
                        <div class="text-[10px] uppercase tracking-wide text-gray-400">Quality Pass</div>
                        <div class="mt-1 text-base font-bold text-gray-800">{{ $sourceStat['pass_rate'] }}%</div>
                        <div class="text-[10px] text-gray-500">{{ $sourceStat['pass_count'] }} / {{ $sourceStat['count'] }}</div>
                    </div>
                    <div class="rounded-lg bg-white/80 p-3">
                        <div class="text-[10px] uppercase tracking-wide text-gray-400">Last Ingest</div>
                        <div class="mt-1 text-sm font-bold text-gray-800">
                            {{ $sourceStat['last_ingested_at'] ? $sourceStat['last_ingested_at']->format('d M Y') : '—' }}
                        </div>
                        <div class="text-[10px] text-gray-500">
                            {{ $sourceStat['last_ingested_at'] ? $sourceStat['last_ingested_at']->format('H:i') : 'No data' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-6 grid gap-4 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-xl border border-emerald-200 bg-emerald-50/60 p-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-emerald-700/80">Last 24h Ingest</p>
                    <h2 class="mt-1 text-lg font-bold text-emerald-900">Recent Activity</h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold text-emerald-800">
                    {{ $recentIngestSummary['count'] }} items
                </span>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-3 text-xs">
                <div class="rounded-lg bg-white/80 p-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400">Total</div>
                    <div class="mt-1 text-base font-bold text-gray-800">{{ $recentIngestSummary['count'] }}</div>
                </div>
                <div class="rounded-lg bg-white/80 p-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400">Pass</div>
                    <div class="mt-1 text-base font-bold text-emerald-700">{{ $recentIngestSummary['pass_count'] }}</div>
                </div>
                <div class="rounded-lg bg-white/80 p-3">
                    <div class="text-[10px] uppercase tracking-wide text-gray-400">Fail</div>
                    <div class="mt-1 text-base font-bold text-amber-700">{{ $recentIngestSummary['fail_count'] }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50/60 p-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-amber-700/80">Recent Ingest Failures</p>
                    <h2 class="mt-1 text-lg font-bold text-amber-900">Needs Review</h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold text-amber-800">
                    {{ $recentIngestFailures->count() }} latest
                </span>
            </div>

            @if($recentIngestFailures->isNotEmpty())
                <div class="mt-4 space-y-2">
                    @foreach($recentIngestFailures as $failure)
                        <div class="rounded-lg bg-white/80 p-3 text-xs">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-800 truncate">{{ $failure->title }}</div>
                                    <div class="mt-1 flex flex-wrap items-center gap-1.5 text-[10px]">
                                        @if($failure->ingest_source_type)
                                            <a href="{{ route('admin.scholarships.index', ['filter' => 'source-' . $failure->ingest_source_type]) }}"
                                               class="inline-flex items-center rounded bg-slate-100 px-2 py-0.5 font-semibold text-slate-700 hover:bg-slate-200 transition"
                                               title="Filter by source: {{ strtoupper($failure->ingest_source_type) }}">
                                                {{ strtoupper($failure->ingest_source_type) }}
                                            </a>
                                        @endif
                                        @if($failure->ingest_parser)
                                            <span class="inline-flex items-center rounded bg-cyan-100 px-2 py-0.5 font-semibold text-cyan-700">{{ $failure->ingest_parser }}</span>
                                        @endif
                                    </div>
                                    @if($failure->ingest_source_ref)
                                        <div class="mt-1 break-all text-[10px] text-gray-400">{{ $failure->ingest_source_ref }}</div>
                                    @endif
                                </div>
                                <div class="shrink-0 text-right text-[10px] text-amber-700">
                                    {{ $failure->ingested_at?->format('d M Y') ?? '—' }}
                                    <div>{{ $failure->ingested_at?->format('H:i') ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-4 rounded-lg bg-white/80 p-4 text-xs text-gray-500">
                    Tidak ada ingest failure terbaru.
                </div>
            @endif
        </div>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.scholarships.index', ['filter' => 'all']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'all' ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>All</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $allCount }}</span>
        </a>
        <a href="{{ route('admin.scholarships.index', ['filter' => 'active-scholarships']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'active-scholarships' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>Active Scholarships</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $activeScholarshipsCount }}</span>
        </a>
        <a href="{{ route('admin.scholarships.index', ['filter' => 'event-drafts']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'event-drafts' ? 'border-amber-200 bg-amber-50 text-amber-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>Event Drafts</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $eventDraftsCount }}</span>
        </a>
        <a href="{{ route('admin.scholarships.index', ['filter' => 'source-manual']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'source-manual' ? 'border-slate-200 bg-slate-100 text-slate-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>Manual Source</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $manualSourceCount }}</span>
        </a>
        <a href="{{ route('admin.scholarships.index', ['filter' => 'source-csv']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'source-csv' ? 'border-cyan-200 bg-cyan-50 text-cyan-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>CSV Source</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $csvSourceCount }}</span>
        </a>
        <a href="{{ route('admin.scholarships.index', ['filter' => 'source-url-scrape']) }}"
           class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium transition {{ $filter === 'source-url-scrape' ? 'border-violet-200 bg-violet-50 text-violet-700' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }}">
            <span>URL Scrape Source</span>
            <span class="rounded-full bg-white/80 px-2 py-0.5 text-[10px] font-semibold">{{ $urlScrapeSourceCount }}</span>
        </a>
    </div>

    @php
        $previewOptions = $scrapePreview['options'] ?? [];
        $modeValue = old('import_mode', $previewOptions['import_mode'] ?? 'event');
        $publishChecked = old('publish_now', (isset($previewOptions['publish_now']) && $previewOptions['publish_now']) ? '1' : null);
        $overwriteChecked = old('overwrite_existing', (isset($previewOptions['overwrite_existing']) ? ($previewOptions['overwrite_existing'] ? '1' : null) : '1'));
    @endphp

    <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50/40 p-4">
        <h2 class="text-sm font-semibold text-blue-900">Quick Scraper (Multi-URL + Preview)</h2>
        <p class="mt-1 text-xs text-blue-700">Paste beberapa URL (satu per baris), lalu klik Preview. Data belum disimpan sebelum kamu commit.</p>
        <form id="quick-scraper-form" action="{{ route('admin.scholarships.scrape.preview') }}" method="POST" class="mt-3 space-y-3">
            @csrf
            <textarea
                id="quick-scraper-source-urls"
                name="source_urls"
                rows="4"
                placeholder="https://www.chevening.org/scholarships\nhttps://www.daad.de/en/\nhttps://australiaawardsindonesia.org/"
                class="w-full rounded-lg border border-blue-200 bg-white px-3 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-400 focus:ring-blue-400"
            >{{ old('source_urls') }}</textarea>

            <div class="grid gap-3 md:grid-cols-[auto_auto_auto_auto] md:justify-start">
                <select id="quick-scraper-import-mode" name="import_mode" class="rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs text-blue-900 focus:border-blue-400 focus:ring-blue-400">
                    <option value="scholarship" {{ $modeValue === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                    <option value="event" {{ $modeValue === 'event' ? 'selected' : '' }}>Event</option>
                </select>
                <label class="inline-flex items-center gap-2 rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs font-medium text-blue-900">
                    <input id="quick-scraper-publish" type="checkbox" name="publish_now" value="1" {{ $publishChecked ? 'checked' : '' }} class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                    Publish
                </label>
                <label class="inline-flex items-center gap-2 rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs font-medium text-blue-900">
                    <input id="quick-scraper-overwrite" type="checkbox" name="overwrite_existing" value="1" {{ $overwriteChecked ? 'checked' : '' }} class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                    Overwrite Existing
                </label>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                    Preview Scrape
                </button>
            </div>

            <div class="flex items-center justify-end">
                <button type="button" id="quick-scraper-reset-saved" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
                    Reset Saved Form
                </button>
            </div>

            <div id="quick-scraper-reset-toast" class="hidden rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-medium text-emerald-700">
                Saved form reset.
            </div>
        </form>
    </div>

    <script>
        (function () {
            const form = document.getElementById('quick-scraper-form');
            if (!form) {
                return;
            }

            const storageKey = 'scholarship_quick_scraper_form';
            const sourceUrls = document.getElementById('quick-scraper-source-urls');
            const importMode = document.getElementById('quick-scraper-import-mode');
            const publishNow = document.getElementById('quick-scraper-publish');
            const overwriteExisting = document.getElementById('quick-scraper-overwrite');
            const resetSavedBtn = document.getElementById('quick-scraper-reset-saved');
            const resetToast = document.getElementById('quick-scraper-reset-toast');
            let resetToastTimer = null;

            function safeParse(raw) {
                try {
                    return JSON.parse(raw || '{}');
                } catch (error) {
                    return {};
                }
            }

            function readCurrentState() {
                return {
                    source_urls: sourceUrls ? sourceUrls.value : '',
                    import_mode: importMode ? importMode.value : 'event',
                    publish_now: publishNow ? publishNow.checked : false,
                    overwrite_existing: overwriteExisting ? overwriteExisting.checked : true,
                };
            }

            function persistState() {
                try {
                    localStorage.setItem(storageKey, JSON.stringify(readCurrentState()));
                } catch (error) {
                    // Ignore localStorage restrictions.
                }
            }

            function showResetToast() {
                if (!resetToast) {
                    return;
                }

                resetToast.classList.remove('hidden');

                if (resetToastTimer) {
                    clearTimeout(resetToastTimer);
                }

                resetToastTimer = setTimeout(function () {
                    resetToast.classList.add('hidden');
                }, 1800);
            }

            function restoreState() {
                let stored = {};
                try {
                    stored = safeParse(localStorage.getItem(storageKey));
                } catch (error) {
                    stored = {};
                }

                if (sourceUrls && sourceUrls.value.trim() === '' && typeof stored.source_urls === 'string') {
                    sourceUrls.value = stored.source_urls;
                }

                if (importMode && typeof stored.import_mode === 'string' && ['scholarship', 'event'].includes(stored.import_mode)) {
                    importMode.value = stored.import_mode;
                }

                if (publishNow && !publishNow.checked && stored.publish_now === true) {
                    publishNow.checked = true;
                }

                if (overwriteExisting && stored.overwrite_existing === false) {
                    overwriteExisting.checked = false;
                }
            }

            restoreState();

            if (sourceUrls) {
                sourceUrls.addEventListener('input', persistState);
            }

            if (importMode) {
                importMode.addEventListener('change', persistState);
            }

            if (publishNow) {
                publishNow.addEventListener('change', persistState);
            }

            if (overwriteExisting) {
                overwriteExisting.addEventListener('change', persistState);
            }

            if (resetSavedBtn) {
                resetSavedBtn.addEventListener('click', function () {
                    try {
                        localStorage.removeItem(storageKey);
                    } catch (error) {
                        // Ignore localStorage restrictions.
                    }

                    if (sourceUrls) {
                        sourceUrls.value = '';
                    }

                    if (importMode) {
                        importMode.value = 'event';
                    }

                    if (publishNow) {
                        publishNow.checked = false;
                    }

                    if (overwriteExisting) {
                        overwriteExisting.checked = true;
                    }

                    showResetToast();
                });
            }

            form.addEventListener('submit', persistState);
        })();
    </script>

    @if(!empty($scrapePreview['items']))
        @php
            $previewItems = collect($scrapePreview['items']);
            $previewOkCount = $previewItems->where('status', 'ok')->count();
            $previewErrorCount = $previewItems->whereIn('status', ['error', 'rate_limited'])->count();
            $previewExistingCount = $previewItems->where('existing', true)->count();
            $previewQualityFailCount = $previewItems
                ->where('status', 'ok')
                ->where('quality_pass', false)
                ->count();
            $previewPublishNow = !empty($previewOptions['publish_now']);
            $previewReasonSummary = $previewItems
                ->where('status', 'ok')
                ->where('quality_pass', false)
                ->flatMap(function ($item) {
                    $reasons = $item['quality_reasons'] ?? [];
                    return is_array($reasons) ? $reasons : [];
                })
                ->countBy()
                ->sortDesc();
        @endphp
        <div class="mb-6 rounded-xl border border-indigo-200 bg-indigo-50/40 p-4" data-preview-publish="{{ $previewPublishNow ? '1' : '0' }}">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h3 class="text-sm font-semibold text-indigo-900">Scrape Preview</h3>
                    <p class="text-xs text-indigo-700">Generated at {{ $scrapePreview['created_at'] ?? '-' }}. Pilih item yang ingin disimpan.</p>
                    <p id="preview-filter-info" class="mt-1 text-[11px] text-indigo-600">Showing {{ count($scrapePreview['items']) }} of {{ count($scrapePreview['items']) }} rows</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 text-[11px]">
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 font-semibold text-blue-700">Ready {{ $previewOkCount }}</span>
                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 font-semibold text-amber-700">Fail {{ $previewQualityFailCount }}</span>
                    <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 font-semibold text-red-700">Error {{ $previewErrorCount }}</span>
                    <span class="inline-flex items-center rounded-full bg-violet-100 px-2 py-0.5 font-semibold text-violet-700">Existing {{ $previewExistingCount }}</span>
                </div>
            </div>

            @if($previewReasonSummary->isNotEmpty())
                <div class="mt-3 rounded-lg border border-amber-100 bg-amber-50 p-3">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-800">Quality Fail Breakdown</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($previewReasonSummary as $reason => $count)
                            <span class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-[11px] font-medium text-amber-800 ring-1 ring-amber-200">
                                {{ $reason }} ({{ $count }})
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-3 flex flex-wrap items-center gap-2">
                <button type="button" id="preview-select-all" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Select All Ready
                </button>
                <button type="button" id="preview-select-pass" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Select Only Pass
                </button>
                <button type="button" id="preview-unselect-all" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Unselect All
                </button>
                <button type="button" data-preview-filter="all" class="preview-filter-btn inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white transition">
                    All {{ count($scrapePreview['items']) }}
                </button>
                <button type="button" data-preview-filter="ready" class="preview-filter-btn inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Ready {{ $previewOkCount }}
                </button>
                <button type="button" data-preview-filter="fail" class="preview-filter-btn inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Fail {{ $previewQualityFailCount }}
                </button>
                <button type="button" data-preview-filter="error" class="preview-filter-btn inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Error {{ $previewErrorCount }}
                </button>
                <button type="button" data-preview-filter="existing" class="preview-filter-btn inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50 transition">
                    Existing {{ $previewExistingCount }}
                </button>
                <form action="{{ route('admin.scholarships.scrape.preview.clear') }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-white px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50 transition">
                        Clear Preview
                    </button>
                </form>
            </div>

            <form id="preview-commit-form" action="{{ route('admin.scholarships.scrape.commit') }}" method="POST" class="mt-3">
                @csrf
                <div class="overflow-x-auto rounded-lg border border-indigo-100 bg-white">
                    <table class="min-w-full text-xs text-left text-gray-700">
                        <thead class="bg-indigo-50 text-indigo-800 uppercase tracking-wide">
                            <tr>
                                <th class="px-3 py-2">
                                    <input type="checkbox" id="select-all-checkbox" class="rounded border-indigo-300 text-indigo-600 focus:ring-indigo-500">
                                </th>
                                <th class="px-3 py-2">Title</th>
                                <th class="px-3 py-2">Provider</th>
                                <th class="px-3 py-2">Deadline</th>
                                <th class="px-3 py-2">Quality</th>
                                <th class="px-3 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-50">
                            @foreach($scrapePreview['items'] as $i => $item)
                                <tr
                                    data-preview-row="1"
                                    data-preview-status="{{ (($item['status'] ?? '') === 'ok') ? 'ready' : 'error' }}"
                                    data-preview-fail="{{ (($item['status'] ?? '') === 'ok' && ($item['quality_pass'] ?? false) === false) ? '1' : '0' }}"
                                    data-preview-existing="{{ !empty($item['existing']) ? '1' : '0' }}"
                                >
                                    <td class="px-3 py-2 align-top">
                                        @if(($item['status'] ?? '') === 'ok')
                                            <input type="checkbox" name="selected_indexes[]" value="{{ $i }}" checked data-preview-pick="1" class="rounded border-indigo-300 text-indigo-600 focus:ring-indigo-500">
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <div class="font-medium text-gray-900">{{ $item['parsed']['title'] ?? '-' }}</div>
                                        <div class="mt-1 text-[11px] text-gray-500 break-all">{{ $item['url'] ?? '-' }}</div>
                                    </td>
                                    <td class="px-3 py-2 align-top">{{ $item['parsed']['provider'] ?? '-' }}</td>
                                    <td class="px-3 py-2 align-top">{{ $item['parsed']['deadline'] ?? '-' }}</td>
                                    <td class="px-3 py-2 align-top">
                                        @if(($item['quality_pass'] ?? false) === true)
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">Pass</span>
                                        @elseif(($item['status'] ?? '') === 'ok')
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700">Fail</span>
                                            @if(!empty($item['quality_reasons']) && is_array($item['quality_reasons']))
                                                <ul class="mt-1 list-disc pl-4 text-[11px] text-amber-700">
                                                    @foreach($item['quality_reasons'] as $reason)
                                                        <li>{{ $reason }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        @if(($item['status'] ?? '') === 'ok')
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">Ready</span>
                                            @if(!empty($item['existing']))
                                                <span class="inline-flex ml-1 items-center rounded-full bg-violet-100 px-2 py-0.5 text-[10px] font-semibold text-violet-700">Existing</span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-700">{{ $item['status'] ?? 'error' }}</span>
                                            <div class="mt-1 text-[11px] text-red-600">{{ $item['error'] ?? 'Unknown error' }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 flex items-center justify-end gap-2">
                    <button type="button" id="preview-commit-visible" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 bg-white px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-50 transition">
                        Commit Only Visible
                    </button>
                    <button type="submit" id="preview-commit-selected" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition">
                        Commit Selected
                    </button>
                </div>

                <div id="preview-commit-toast" class="mt-2 hidden rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-xs font-medium text-indigo-700">
                    Processing commit, please wait...
                </div>
            </form>
        </div>

        <script>
            (function () {
                const previewBox = document.querySelector('[data-preview-publish]');
                const publishEnabled = previewBox && previewBox.dataset.previewPublish === '1';
                const filterStorageKey = 'scholarship_preview_filter';
                const allowedFilters = ['all', 'ready', 'fail', 'error', 'existing'];
                const readyChecks = document.querySelectorAll('input[data-preview-pick="1"]');
                const selectAllBtn = document.getElementById('preview-select-all');
                const selectPassBtn = document.getElementById('preview-select-pass');
                const unselectAllBtn = document.getElementById('preview-unselect-all');
                const commitForm = document.getElementById('preview-commit-form');
                const commitVisibleBtn = document.getElementById('preview-commit-visible');
                const commitSelectedBtn = document.getElementById('preview-commit-selected');
                const commitToast = document.getElementById('preview-commit-toast');
                const filterButtons = document.querySelectorAll('.preview-filter-btn');
                const previewRows = document.querySelectorAll('tr[data-preview-row="1"]');
                const filterInfo = document.getElementById('preview-filter-info');
                let activeFilter = 'all';

                function refreshVisibleCount() {
                    const totalRows = previewRows.length;
                    let visibleRows = 0;

                    previewRows.forEach(function (row) {
                        if (row.style.display !== 'none') {
                            visibleRows += 1;
                        }
                    });

                    if (filterInfo) {
                        filterInfo.textContent = 'Showing ' + visibleRows + ' of ' + totalRows + ' rows';
                    }
                }

                if (selectAllBtn) {
                    selectAllBtn.addEventListener('click', function () {
                        readyChecks.forEach(function (el) { el.checked = true; });
                    });
                }

                if (selectPassBtn) {
                    selectPassBtn.addEventListener('click', function () {
                        previewRows.forEach(function (row) {
                            const check = row.querySelector('input[data-preview-pick="1"]');
                            if (!check) {
                                return;
                            }

                            const isPass = row.dataset.previewFail !== '1';
                            check.checked = isPass;
                        });
                    });
                }

                if (unselectAllBtn) {
                    unselectAllBtn.addEventListener('click', function () {
                        readyChecks.forEach(function (el) { el.checked = false; });
                    });
                }

                function rowMatchesFilter(row, filterKey) {
                    if (filterKey === 'all') {
                        return true;
                    }

                    if (filterKey === 'ready') {
                        return row.dataset.previewStatus === 'ready';
                    }

                    if (filterKey === 'fail') {
                        return row.dataset.previewFail === '1';
                    }

                    if (filterKey === 'error') {
                        return row.dataset.previewStatus === 'error';
                    }

                    if (filterKey === 'existing') {
                        return row.dataset.previewExisting === '1';
                    }

                    return true;
                }

                function applyFilter(filterKey) {
                    activeFilter = allowedFilters.includes(filterKey) ? filterKey : 'all';

                    previewRows.forEach(function (row) {
                        row.style.display = rowMatchesFilter(row, activeFilter) ? '' : 'none';
                    });

                    refreshVisibleCount();

                    filterButtons.forEach(function (btn) {
                        const active = btn.dataset.previewFilter === activeFilter;
                        btn.classList.toggle('bg-indigo-600', active);
                        btn.classList.toggle('text-white', active);
                        btn.classList.toggle('bg-white', !active);
                        btn.classList.toggle('text-indigo-700', !active);
                    });

                    try {
                        localStorage.setItem(filterStorageKey, activeFilter);
                    } catch (error) {
                        // Ignore localStorage restrictions.
                    }
                }

                filterButtons.forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        applyFilter(btn.dataset.previewFilter || 'all');
                    });
                });

                if (publishEnabled) {
                    previewRows.forEach(function (row) {
                        if (row.dataset.previewFail === '1') {
                            const check = row.querySelector('input[data-preview-pick="1"]');
                            if (check) {
                                check.checked = false;
                            }
                        }
                    });
                }

                if (commitVisibleBtn && commitForm) {
                    commitVisibleBtn.addEventListener('click', function () {
                        previewRows.forEach(function (row) {
                            const check = row.querySelector('input[data-preview-pick="1"]');
                            if (!check) {
                                return;
                            }

                            if (row.style.display === 'none') {
                                check.checked = false;
                            }
                        });

                        commitForm.requestSubmit();
                    });
                }

                function setCommitLoadingState(isLoading, source) {
                    if (commitToast) {
                        commitToast.classList.toggle('hidden', !isLoading);
                    }

                    if (commitVisibleBtn) {
                        commitVisibleBtn.disabled = isLoading;
                        commitVisibleBtn.classList.toggle('opacity-60', isLoading);
                        commitVisibleBtn.classList.toggle('cursor-not-allowed', isLoading);
                        commitVisibleBtn.textContent = isLoading && source === 'visible' ? 'Committing Visible...' : 'Commit Only Visible';
                    }

                    if (commitSelectedBtn) {
                        commitSelectedBtn.disabled = isLoading;
                        commitSelectedBtn.classList.toggle('opacity-60', isLoading);
                        commitSelectedBtn.classList.toggle('cursor-not-allowed', isLoading);
                        commitSelectedBtn.textContent = isLoading && source === 'selected' ? 'Committing Selected...' : 'Commit Selected';
                    }
                }

                let commitSource = 'selected';
                if (commitVisibleBtn) {
                    commitVisibleBtn.addEventListener('click', function () {
                        commitSource = 'visible';
                    });
                }

                if (commitSelectedBtn) {
                    commitSelectedBtn.addEventListener('click', function () {
                        commitSource = 'selected';
                    });
                }

                if (commitForm) {
                    commitForm.addEventListener('submit', function (event) {
                        const selectedCount = Array.from(readyChecks).filter(function (el) {
                            return el.checked;
                        }).length;

                        if (selectedCount === 0) {
                            event.preventDefault();
                            window.alert('Pilih minimal 1 item sebelum commit.');
                            setCommitLoadingState(false, commitSource);
                            return;
                        }

                        setCommitLoadingState(true, commitSource);
                    });
                }

                let initialFilter = 'all';
                try {
                    const storedFilter = localStorage.getItem(filterStorageKey);
                    if (storedFilter && allowedFilters.includes(storedFilter)) {
                        initialFilter = storedFilter;
                    }
                } catch (error) {
                    initialFilter = 'all';
                }

                applyFilter(initialFilter);
            })();
        </script>
    @endif

    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50/70 p-3">
        <form id="bulk-review-form" action="{{ route('admin.scholarships.bulk-review') }}" method="POST" class="flex flex-wrap items-center gap-2">
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var form = document.getElementById('bulk-review-form');
                        var select = document.getElementById('bulk-action-select');
                        if (form && select) {
                            form.addEventListener('submit', function(e) {
                                if (select.value === 'publish') {
                                    form.action = "{{ route('admin.scholarships.bulk-publish') }}";
                                } else {
                                    form.action = "{{ route('admin.scholarships.bulk-review') }}";
                                }
                            });
                        }
                    });
                    </script>
            @csrf
            <input type="hidden" name="filter" value="{{ $filter }}">
            <span class="text-xs font-medium text-amber-800">Bulk Review:</span>
            <select name="bulk_action" id="bulk-action-select" required class="rounded-lg border border-amber-300 bg-white px-3 py-2 text-xs text-amber-900 focus:border-amber-400 focus:ring-amber-400">
                <option value="">Pilih aksi</option>
                <option value="approve">Approve as Scholarship</option>
                <option value="publish">Publish (Langsung Aktif)</option>
                <option value="reject">Keep as Event Draft</option>
            </select>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-3 py-2 text-xs font-medium text-white hover:bg-amber-700 transition">
                Apply to Selected
            </button>
            <span class="text-[11px] text-amber-700">Centang data di tabel lalu jalankan aksi massal.</span>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-4 font-semibold">
                            <input type="checkbox" id="select-all-checkbox" class="rounded border-indigo-300 text-indigo-600 focus:ring-indigo-500" title="Select All">
                        </th>
                        <th scope="col" class="px-6 py-4 font-semibold">Scholarship</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Location</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Level</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Min. IELTS / TOEFL</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Deadline</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($scholarships as $scholarship)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 align-top">
                                <input form="bulk-review-form" type="checkbox" name="selected_ids[]" value="{{ $scholarship->id }}" class="row-checkbox rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-3 sm:mr-4 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden">
                                        @if($scholarship->image_path)
                                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }}">
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $scholarship->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $scholarship->provider }}</div>
                                        <div class="mt-1 flex flex-wrap items-center gap-1.5 text-[10px]">
                                            @if($scholarship->ingest_source_type)
                                                <span class="inline-flex items-center rounded bg-slate-100 px-2 py-0.5 font-semibold text-slate-700">
                                                    Source: {{ strtoupper($scholarship->ingest_source_type) }}
                                                </span>
                                            @endif
                                            @if($scholarship->ingest_parser)
                                                <span class="inline-flex items-center rounded bg-cyan-100 px-2 py-0.5 font-semibold text-cyan-700">
                                                    Parser: {{ $scholarship->ingest_parser }}
                                                </span>
                                            @endif
                                            @if(!is_null($scholarship->ingest_quality_pass))
                                                @if($scholarship->ingest_quality_pass)
                                                    <span class="inline-flex items-center rounded bg-emerald-100 px-2 py-0.5 font-semibold text-emerald-700">Q: Pass</span>
                                                @else
                                                    <span class="inline-flex items-center rounded bg-amber-100 px-2 py-0.5 font-semibold text-amber-700">Q: Fail</span>
                                                @endif
                                            @endif
                                            @if($scholarship->ingested_at)
                                                <span class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 font-semibold text-indigo-700">
                                                    Ingested: {{ $scholarship->ingested_at->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($scholarship->ingest_source_ref)
                                            <div class="mt-1 text-[10px] text-gray-400 break-all">Ref: {{ $scholarship->ingest_source_ref }}</div>
                                        @endif
                                        @if(($scholarship->funding_type ?? 'scholarship') === 'event')
                                            <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-700">Event</span>
                                        @else
                                            <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-100 text-indigo-700">Scholarship</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $scholarship->location }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block">{{ $scholarship->level_of_study }}</span>
                                @if($scholarship->requires_certification)
                                    <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800">
                                        Cert. Req.
                                    </span>
                                @else
                                    <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">
                                        No Cert. Req.
                                    </span>
                                @endif
                            </td>
                            <!-- Min Scores column -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @if($scholarship->min_ielts)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-100 text-indigo-700">IELTS {{ number_format($scholarship->min_ielts, 1) }}+</span>
                                    @endif
                                    @if($scholarship->min_toefl)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-100 text-purple-700">TOEFL {{ $scholarship->min_toefl }}+</span>
                                    @endif
                                    @if(!$scholarship->min_ielts && !$scholarship->min_toefl)
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($scholarship->opening_date)
                                    <span class="block text-xs text-gray-500 mb-1">Opens: {{ $scholarship->opening_date->format('d M Y') }}</span>
                                @endif
                                <span class="font-medium text-gray-800">{{ $scholarship->deadline->format('d M Y') }}</span>
                                @if($scholarship->deadline->isPast())
                                    <span class="block text-xs text-red-500 mt-1">Expired</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($scholarship->is_active)
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if($scholarship->min_ielts || $scholarship->min_toefl)
                                    <a href="{{ route('admin.scholarships.match', $scholarship) }}" class="text-green-600 hover:text-green-800 mx-1 transition text-xs font-medium">Smart Match</a>
                                @endif
                                <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="text-indigo-600 hover:text-indigo-900 mx-1 transition">Edit</a>
                                <form action="{{ route('admin.scholarships.destroy', $scholarship) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-gray-400">No scholarships found. Let's add one!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scholarships->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $scholarships->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectAll = document.getElementById('select-all-checkbox');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input.row-checkbox');
            checkboxes.forEach(function(cb) { cb.checked = selectAll.checked; });
        });
    }
});
</script>
