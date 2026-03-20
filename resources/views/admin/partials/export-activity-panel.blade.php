<div class="mt-6 overflow-hidden rounded-2xl border border-gray-100" x-data="{ exportViewMode: localStorage.getItem('exportActivityViewMode') || 'detailed', showExportShortcuts: (localStorage.getItem('exportActivityShowShortcuts') || '1') === '1', exportSearch: '', matchedExportCount: {{ isset($recentExportActivities) ? $recentExportActivities->count() : 0 }}, setExportViewMode(mode) { this.exportViewMode = mode; localStorage.setItem('exportActivityViewMode', mode); }, toggleExportShortcuts() { this.showExportShortcuts = !this.showExportShortcuts; localStorage.setItem('exportActivityShowShortcuts', this.showExportShortcuts ? '1' : '0'); }, matchesExportRow(haystack) { const needle = this.exportSearch.trim().toLowerCase(); return needle === '' || String(haystack || '').includes(needle); }, escapeRegExp(value) { return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }, escapeHtml(value) { return String(value).replace(/[&<>\x22\x27]/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '\x22': '&quot;', '\x27': '&#39;' }[char])); }, highlightExportText(value) { const text = this.escapeHtml(value ?? ''); const needle = this.exportSearch.trim(); if (!needle) { return text; } const pattern = new RegExp('(' + this.escapeRegExp(needle) + ')', 'ig'); return text.replace(pattern, '<mark class=\'rounded bg-amber-100 px-0.5 text-amber-900\'>$1</mark>'); }, refreshExportMatchCount() { const rows = this.$root.querySelectorAll('tr[data-export-row]'); let count = 0; rows.forEach((row) => { if (this.matchesExportRow(row.dataset.searchHaystack || '')) { count += 1; } }); this.matchedExportCount = count; } }" x-init="refreshExportMatchCount(); $watch('exportSearch', () => refreshExportMatchCount())" @keydown.window="if (($event.key === '/' || $event.key === '?') && !$event.metaKey && !$event.ctrlKey && !$event.altKey && !$event.target.closest('input, textarea, [contenteditable=true], select')) { $event.preventDefault(); $refs.exportSearchInput.focus(); $refs.exportSearchInput.select(); }">
    <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-gray-800">Export Activity (Last 10)</h3>
                    <button type="button" @click="toggleExportShortcuts()" class="rounded-md border border-gray-200 bg-white px-2 py-0.5 text-[10px] font-semibold text-gray-600 transition hover:bg-gray-100" x-text="showExportShortcuts ? 'Hide shortcuts' : 'Show shortcuts'"></button>
                </div>
                <p class="mt-1 text-[11px] text-gray-500" x-show="showExportShortcuts" x-cloak>
                    Shortcuts:
                    <span class="rounded bg-white px-1.5 py-0.5 font-semibold text-gray-600 border border-gray-200">/</span> focus search,
                    <span class="rounded bg-white px-1.5 py-0.5 font-semibold text-gray-600 border border-gray-200">Esc</span> clear search,
                    <span class="rounded bg-white px-1.5 py-0.5 font-semibold text-gray-600 border border-gray-200">Cmd/Ctrl + C</span> copy replay (when Replay is focused)
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <input type="text" x-ref="exportSearchInput" x-model.debounce.200ms="exportSearch" @keydown.escape.prevent="exportSearch=''; refreshExportMatchCount()" placeholder="Search preset/admin/filter..." title="Press / to focus, Esc to clear search" class="w-56 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs text-gray-700 placeholder:text-gray-400 focus:border-slate-400 focus:outline-none">
                <div class="mr-2 inline-flex rounded-lg border border-gray-200 bg-white p-0.5">
                    <button type="button" @click="setExportViewMode('detailed')" :class="exportViewMode === 'detailed' ? 'bg-slate-900 text-white' : 'text-gray-600 hover:bg-gray-100'" class="rounded-md px-2.5 py-1 text-[11px] font-semibold transition">Detailed</button>
                    <button type="button" @click="setExportViewMode('compact')" :class="exportViewMode === 'compact' ? 'bg-slate-900 text-white' : 'text-gray-600 hover:bg-gray-100'" class="rounded-md px-2.5 py-1 text-[11px] font-semibold transition">Compact</button>
                </div>
                @php
                    $activitySortFilters = [
                        'newest' => 'Newest',
                        'oldest' => 'Oldest',
                        'rows_desc' => 'Rows High-Low',
                    ];
                    $activityTypeFilters = [
                        'all' => 'All',
                        'registration_leads' => 'Registration Leads',
                        'campaign_signups' => 'Campaign Signups',
                    ];
                @endphp
                @foreach($activitySortFilters as $sortKey => $sortLabel)
                    <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['export_activity_sort' => $sortKey])) }}"
                       class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ ($exportActivitySort ?? 'newest') === $sortKey ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                        {{ $sortLabel }}
                    </a>
                @endforeach
                @foreach($activityTypeFilters as $typeKey => $typeLabel)
                    <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['export_activity_type' => $typeKey])) }}"
                       class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ ($exportActivityType ?? 'all') === $typeKey ? 'bg-slate-900 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                        {{ $typeLabel }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @if(isset($recentExportActivities) && $recentExportActivities->isNotEmpty())
        @php
            $exportSortLabelMap = [
                'newest' => 'Newest',
                'oldest' => 'Oldest',
                'rows_desc' => 'Rows High-Low',
            ];
            $exportTypeLabelMap = [
                'all' => 'All',
                'registration_leads' => 'Registration Leads',
                'campaign_signups' => 'Campaign Signups',
            ];
        @endphp
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 bg-white px-5 py-2 text-[11px] text-gray-500">
            <div class="flex flex-wrap items-center gap-2">
                <span>Sorted by: <span class="font-semibold text-gray-700">{{ $exportSortLabelMap[$exportActivitySort ?? 'newest'] ?? 'Newest' }}</span></span>
                <span class="text-gray-300">|</span>
                <span>Scope: <span class="font-semibold text-gray-700">{{ $exportTypeLabelMap[$exportActivityType ?? 'all'] ?? 'All' }}</span></span>
            </div>
            <div class="flex items-center gap-2">
                <span x-text="'Showing ' + matchedExportCount + ' of {{ $recentExportActivities->count() }}'"></span>
                <button type="button" x-show="exportSearch.trim() !== ''" @click="exportSearch=''; refreshExportMatchCount()" class="rounded-md border border-gray-200 bg-white px-2 py-1 text-[10px] font-semibold text-gray-600 transition hover:bg-gray-100">
                    Reset Search
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-white text-xs uppercase tracking-[0.12em] text-gray-400">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Time</th>
                        <th class="px-5 py-3 font-semibold">Admin</th>
                        <th class="px-5 py-3 font-semibold" :class="exportViewMode === 'compact' ? 'hidden' : ''">Action</th>
                        <th class="px-5 py-3 font-semibold">Preset</th>
                        <th class="px-5 py-3 font-semibold" :class="exportViewMode === 'compact' ? 'hidden' : ''">Rows</th>
                        <th class="px-5 py-3 font-semibold" :class="exportViewMode === 'compact' ? 'hidden' : ''">Filter Snapshot</th>
                        <th class="px-5 py-3 font-semibold text-right">Replay</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($recentExportActivities as $activity)
                        @php
                            $meta = [];
                            if (!empty($activity->meta)) {
                                $decodedMeta = json_decode($activity->meta, true);
                                $meta = is_array($decodedMeta) ? $decodedMeta : [];
                            }
                            $rowsCount = $meta['rows'] ?? '-';
                            $filters = $meta['filters'] ?? [];
                            $filters = is_array($filters) ? $filters : [];
                            unset($filters['export_preset']);

                            $replayUrl = null;
                            if ($activity->action === 'registration_leads_export') {
                                $replayUrl = route('admin.registration-leads.index', $filters);
                            } elseif ($activity->action === 'campaign_signups_export') {
                                $replayUrl = route('admin.dashboard', $filters);
                            }

                            $filterSummary = collect($filters)
                                ->filter(fn ($value) => $value !== null && $value !== '')
                                ->take(4)
                                ->map(fn ($value, $key) => $key . '=' . (is_scalar($value) ? (string) $value : '[complex]'))
                                ->implode(', ');

                            $searchHaystack = strtolower(implode(' ', [
                                (string) ($activity->user_name ?? ''),
                                (string) ($activity->action ?? ''),
                                (string) ($activity->preset ?? ''),
                                (string) $rowsCount,
                                (string) $filterSummary,
                            ]));
                        @endphp
                        <tr data-export-row="1" data-search-haystack="{{ $searchHaystack }}" x-show="matchesExportRow(@js($searchHaystack))">
                            <td class="px-5 py-4 text-gray-700">{{ \Illuminate\Support\Carbon::parse($activity->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $activity->user_name ?? 'Unknown Admin' }}</td>
                            <td class="px-5 py-4 text-gray-600" :class="exportViewMode === 'compact' ? 'hidden' : ''">{{ $activity->action }}</td>
                            <td class="px-5 py-4 font-semibold text-gray-800"><span x-html="highlightExportText(@js((string) ($activity->preset ?: '-')))" ></span></td>
                            <td class="px-5 py-4 font-semibold text-gray-800" :class="exportViewMode === 'compact' ? 'hidden' : ''">{{ $rowsCount }}</td>
                            <td class="px-5 py-4 text-gray-500" :class="exportViewMode === 'compact' ? 'hidden' : ''"><span x-html="highlightExportText(@js((string) ($filterSummary !== '' ? $filterSummary : '—')))" ></span></td>
                            <td class="px-5 py-4 text-right">
                                @if(!empty($replayUrl))
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ $replayUrl }}" data-replay-url="{{ $replayUrl }}" title="Tip: focus this button then press Cmd/Ctrl + C to copy replay link" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                            Replay
                                            <span class="hidden rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold text-gray-500 sm:inline">Cmd/Ctrl+C</span>
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                        <button type="button"
                                                data-copy-url="{{ $replayUrl }}"
                                                onclick="copyReplayLink(this.dataset.copyUrl)"
                                                class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                            Copy Link
                                        </button>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr x-show="exportSearch.trim() !== '' && matchedExportCount === 0">
                        <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-400">
                            No matching export activity.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="px-5 py-10 text-sm text-gray-400">Belum ada histori export.</div>
    @endif
</div>
