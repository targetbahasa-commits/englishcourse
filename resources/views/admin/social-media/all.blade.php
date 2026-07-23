<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Social Media — All Programs | Target Bahasa Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .platform-badge { @apply inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium; }
        .status-draft     { @apply bg-gray-100 text-gray-600; }
        .status-scheduled { @apply bg-blue-100 text-blue-700; }
        .status-published { @apply bg-green-100 text-green-700; }
        .status-cancelled { @apply bg-red-100 text-red-600; }
        .program-pill-grammar-writing  { background: #ede9fe; color: #7c3aed; }
        .program-pill-toefl-itp        { background: #fef3c7; color: #92400e; }
        .program-pill-ielts-academic   { background: #dbeafe; color: #1d4ed8; }
        .program-pill-ielts-general    { background: #e0f2fe; color: #0369a1; }
        .program-pill-toefl-ibt        { background: #fce7f3; color: #9d174d; }
        .program-pill-pte-academic     { background: #d1fae5; color: #065f46; }
        .program-pill-speaking         { background: #fff7ed; color: #9a3412; }

        /* Calendar tooltip on hover */
        .cal-cell { position: relative; }
        .cal-cell:hover .cal-tooltip { display: block; }
        .cal-tooltip {
            display: none;
            position: absolute;
            z-index: 60;
            min-width: 220px;
            left: 50%;
            transform: translateX(-50%);
            top: calc(100% + 4px);
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.14);
            padding: 10px;
        }
        /* Fix last column tooltips going off screen */
        .cal-cell:nth-child(7n) .cal-tooltip { left: auto; right: 0; transform: none; }
        .cal-cell:nth-child(7n+1) .cal-tooltip { left: 0; transform: none; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100"
      x-data="{
          activeView: new URLSearchParams(window.location.search).get('view') === 'calendar' ? 'calendar' : 'table',
          heatmapEnabled: false,
          showToast: false,
          toastMsg: ''
      }">
@include('components.impersonation-banner')
<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64 p-6">

        {{-- ===== TOP BAR ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🌐 Social Media — All Programs</h1>
                <p class="text-sm text-gray-500 mt-0.5">Unified view of content planning across all programs</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                {{-- View Toggle --}}
                <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                    <button @click="activeView = 'table'"
                            :class="activeView === 'table' ? 'bg-indigo-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/></svg>
                        Table
                    </button>
                    <button @click="activeView = 'calendar'"
                            :class="activeView === 'calendar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Calendar
                    </button>
                </div>
                <a href="{{ route('admin.social-media.export-all') }}"
                   class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export All CSV
                </a>
            </div>
        </div>

        {{-- ===== GLOBAL SUMMARY CARDS ===== --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            @php
                $cards = [
                    ['label'=>'Total Content', 'value'=>$stats['total'],      'color'=>'indigo'],
                    ['label'=>'Draft',         'value'=>$stats['draft'],      'color'=>'gray'],
                    ['label'=>'Scheduled',     'value'=>$stats['scheduled'],  'color'=>'blue'],
                    ['label'=>'Published',     'value'=>$stats['published'],  'color'=>'green'],
                    ['label'=>'This Month',    'value'=>$stats['this_month'], 'color'=>'purple'],
                ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $card['value'] }}</div>
                <div class="text-xs text-gray-500">{{ $card['label'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- ===== PROGRAM QUICK LINKS ===== --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 mb-6">
            @foreach(\App\Models\SocialMediaPost::programs() as $slug => $label)
            <a href="{{ route('admin.social-media.index', $slug) }}"
               class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all p-4 text-center group">
                <div class="text-xs font-semibold text-gray-600 group-hover:text-indigo-600 transition leading-snug">{{ $label }}</div>
                <div class="text-xs text-gray-400 mt-1">→ Manage</div>
            </a>
            @endforeach
        </div>

        {{-- ==================================================================== --}}
        {{-- TABLE VIEW --}}
        {{-- ==================================================================== --}}
        <div x-show="activeView === 'table'" x-cloak>

            {{-- ===== FILTERS ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4">
                <form method="GET" class="p-4">
                    <div class="flex flex-wrap gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Program</label>
                            <select name="filter_program" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Programs</option>
                                @foreach(\App\Models\SocialMediaPost::programs() as $slug => $label)
                                    <option value="{{ $slug }}" {{ request('filter_program') === $slug ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Platform</label>
                            <select name="filter_platform" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Platforms</option>
                                @foreach(['Instagram','TikTok','Facebook','WhatsApp','YouTube','LinkedIn'] as $p)
                                    <option value="{{ $p }}" {{ request('filter_platform') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="filter_status" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Status</option>
                                @foreach(['draft','scheduled','published','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ request('filter_status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Content Type</label>
                            <select name="filter_content_type" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Types</option>
                                @foreach(['Tips','Vocabulary','Grammar','Promotion','Student Story','Testimonial','Quiz','Motivation','FAQ','Announcement'] as $ct)
                                    <option value="{{ $ct }}" {{ request('filter_content_type') === $ct ? 'selected' : '' }}>{{ $ct }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Month</label>
                            <input type="month" name="filter_month" value="{{ request('filter_month') }}" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                        </div>
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                            <input type="text" name="search" placeholder="Title or caption..." value="{{ request('search') }}"
                                   class="w-full text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">Filter</button>
                            <a href="{{ route('admin.social-media.all') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Clear</a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ===== MASTER TABLE ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Program</th>
                                <th class="px-4 py-3 text-left">Platform</th>
                                <th class="px-4 py-3 text-left">Type</th>
                                <th class="px-4 py-3 text-left">Publish Date</th>
                                <th class="px-4 py-3 text-left">Assigned To</th>
                                <th class="px-4 py-3 text-left">Progress</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($posts as $post)
                                @php
                                    $pct = $post->checklist_percentage;
                                    $platformColors = ['Instagram'=>'bg-pink-100 text-pink-700','TikTok'=>'bg-gray-900 text-white','Facebook'=>'bg-blue-100 text-blue-700','WhatsApp'=>'bg-green-100 text-green-700','YouTube'=>'bg-red-100 text-red-700','LinkedIn'=>'bg-sky-100 text-sky-700'];
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition group">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-800 max-w-[180px] truncate">{{ $post->title }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold program-pill-{{ $post->program }}">
                                            {{ $post->program_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($post->platforms ?? [], 0, 2) as $platform)
                                                <span class="platform-badge {{ $platformColors[$platform] ?? 'bg-gray-100 text-gray-600' }}">{{ $platform }}</span>
                                            @endforeach
                                            @if(count($post->platforms ?? []) > 2)
                                                <span class="platform-badge bg-gray-100 text-gray-500">+{{ count($post->platforms) - 2 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $post->content_type }}</td>
                                    <td class="px-4 py-3">
                                        @if($post->publish_date)
                                            <div class="font-medium text-gray-700">{{ $post->publish_date->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $post->publish_time ? \Carbon\Carbon::parse($post->publish_time)->format('H:i') : '—' }}</div>
                                        @else
                                            <span class="text-gray-300">Not set</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 max-w-[100px] truncate">{{ $post->assigned_to ?: '—' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-14 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $pct === 100 ? 'bg-green-500' : ($pct >= 60 ? 'bg-yellow-400' : 'bg-gray-300') }}"
                                                     style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold status-{{ $post->status }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end">
                                            <a href="{{ route('admin.social-media.index', $post->program) }}"
                                               class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition opacity-0 group-hover:opacity-100"
                                               title="Manage in {{ $post->program_label }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-16 text-center text-gray-400">
                                        <div class="text-4xl mb-3">📭</div>
                                        <div class="font-medium">No posts found</div>
                                        <div class="text-sm mt-1">Create posts from each program's Social Media Management page.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($posts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $posts->withQueryString()->links() }}
                </div>
                @endif
            </div>

            {{-- ===== KANBAN OVERVIEW BY PROGRAM ===== --}}
            <div class="mt-8">
                <h2 class="text-base font-bold text-gray-800 mb-4">This Month's Posts by Program</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach(\App\Models\SocialMediaPost::programs() as $slug => $label)
                        @php
                            $programPosts = \App\Models\SocialMediaPost::where('program', $slug)
                                ->where('is_archived', false)
                                ->whereMonth('publish_date', now()->month)
                                ->whereYear('publish_date', now()->year)
                                ->orderBy('publish_date')
                                ->orderBy('publish_time')
                                ->get();
                            $draft     = $programPosts->where('status','draft')->count();
                            $scheduled = $programPosts->where('status','scheduled')->count();
                            $published = $programPosts->where('status','published')->count();
                        @endphp
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-50 flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-800">{{ $label }}</span>
                                <a href="{{ route('admin.social-media.index', $slug) }}" class="text-xs text-indigo-600 hover:underline">Manage →</a>
                            </div>
                            <div class="p-4">
                                @if($programPosts->isEmpty())
                                    <div class="text-xs text-gray-400 italic text-center py-3">No posts this month</div>
                                @else
                                    <div class="flex items-center gap-3 mb-3 text-xs font-medium">
                                        @if($draft)     <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-300"></span>{{ $draft }} draft</span> @endif
                                        @if($scheduled) <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span>{{ $scheduled }} scheduled</span> @endif
                                        @if($published) <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-400"></span>{{ $published }} published</span> @endif
                                    </div>
                                    <div class="space-y-1.5">
                                        @foreach($programPosts->take(5) as $p)
                                        <div class="flex items-start gap-2 text-xs">
                                            <span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 {{ $p->status === 'published' ? 'bg-green-400' : ($p->status === 'scheduled' ? 'bg-blue-400' : 'bg-gray-300') }}"></span>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-700 truncate">{{ $p->title }}</div>
                                                <div class="text-gray-400">{{ $p->publish_date?->format('d M') }} {{ $p->publish_time ? '· '.substr($p->publish_time,0,5) : '' }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if($programPosts->count() > 5)
                                            <div class="text-xs text-gray-400 italic">+{{ $programPosts->count() - 5 }} more posts</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>{{-- END table view --}}

        {{-- ==================================================================== --}}
        {{-- CALENDAR VIEW --}}
        {{-- ==================================================================== --}}
        <div x-show="activeView === 'calendar'" x-cloak>
            @php
                use Carbon\Carbon;

                $programColors = [
                    'grammar-writing' => ['dot'=>'bg-violet-500', 'badge'=>'bg-violet-100 text-violet-800', 'border'=>'border-l-violet-400'],
                    'toefl-itp'       => ['dot'=>'bg-amber-500',  'badge'=>'bg-amber-100 text-amber-800',  'border'=>'border-l-amber-400'],
                    'ielts-academic'  => ['dot'=>'bg-blue-500',   'badge'=>'bg-blue-100 text-blue-800',    'border'=>'border-l-blue-400'],
                    'ielts-general'   => ['dot'=>'bg-sky-500',    'badge'=>'bg-sky-100 text-sky-800',      'border'=>'border-l-sky-400'],
                    'toefl-ibt'       => ['dot'=>'bg-pink-500',   'badge'=>'bg-pink-100 text-pink-800',    'border'=>'border-l-pink-400'],
                    'pte-academic'    => ['dot'=>'bg-emerald-500','badge'=>'bg-emerald-100 text-emerald-800','border'=>'border-l-emerald-400'],
                    'speaking'        => ['dot'=>'bg-orange-500', 'badge'=>'bg-orange-100 text-orange-800','border'=>'border-l-orange-400'],
                ];
                $programLabels = \App\Models\SocialMediaPost::programs();

                $mFirst    = Carbon::createFromDate($calendarYear, $calendarMonth, 1);
                $mDays     = $mFirst->daysInMonth;
                $mStartDow = $mFirst->dayOfWeek; // 0=Sun
                $mPrev     = $mFirst->copy()->subMonth();
                $mNext     = $mFirst->copy()->addMonth();
            @endphp

            {{-- Calendar Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Nav Bar --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $mFirst->format('F Y') }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Upload schedule across all programs</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.social-media.all') }}?cal_year={{ $mPrev->year }}&cal_month={{ $mPrev->month }}&view=calendar"
                           onclick="document.querySelector('[x-data]').__x.$data.activeView='calendar'"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            {{ $mPrev->format('M Y') }}
                        </a>
                        <a href="{{ route('admin.social-media.all') }}?cal_year={{ now()->year }}&cal_month={{ now()->month }}&view=calendar"
                           class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">
                            Today
                        </a>
                        <a href="{{ route('admin.social-media.all') }}?cal_year={{ $mNext->year }}&cal_month={{ $mNext->month }}&view=calendar"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-50 transition">
                            {{ $mNext->format('M Y') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="px-6 py-3 border-b border-gray-50 flex flex-wrap gap-x-4 gap-y-2 items-center">
                    @foreach($programColors as $slug => $colors)
                        @if(isset($programLabels[$slug]))
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full {{ $colors['dot'] }}"></span>
                            <span class="text-xs text-gray-600 font-medium">{{ $programLabels[$slug] }}</span>
                        </div>
                        @endif
                    @endforeach
                    <div class="ml-auto flex items-center gap-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-gray-300 inline-block"></span>Draft</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-blue-400 inline-block"></span>Scheduled</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-green-400 inline-block"></span>Published</span>
                    </div>

                    <!-- Heatmap Toggle -->
                    <div class="flex items-center gap-2 ml-4 border-l border-gray-200 pl-4">
                        <label class="relative inline-flex items-center cursor-pointer" title="Color code days based on post density">
                          <input type="checkbox" x-model="heatmapEnabled" class="sr-only peer">
                          <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                          <span class="ml-2 text-xs font-semibold text-gray-600">Heatmap Mode</span>
                        </label>
                    </div>
                </div>

                {{-- Day Headers --}}
                <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50/40">
                    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dName)
                    <div class="py-2.5 text-center text-xs font-bold text-gray-400 uppercase tracking-wide">{{ $dName }}</div>
                    @endforeach
                </div>

                {{-- Calendar Grid --}}
                <div class="grid grid-cols-7" style="grid-auto-rows: minmax(110px, auto)">

                    {{-- Leading empty cells --}}
                    @for($i = 0; $i < $mStartDow; $i++)
                        <div class="border-r border-b border-gray-100 bg-gray-50/20 {{ ($i + 1) % 7 === 0 ? 'border-r-0' : '' }}"></div>
                    @endfor

                    {{-- Day cells --}}
                    @for($day = 1; $day <= $mDays; $day++)
                        @php
                            $colIdx    = ($mStartDow + $day - 1) % 7;
                            $isWeekend = ($colIdx === 0 || $colIdx === 6);
                            $isToday   = (now()->year == $calendarYear && now()->month == $calendarMonth && now()->day == $day);
                            $dayPosts  = $calendarPosts->get($day, collect());
                            $postCount = $dayPosts->count();
                            $isLastCol = ($colIdx === 6);
                            
                            $heatmapColor = '';
                            if ($postCount == 1) $heatmapColor = '#f0fdf4'; // green-50
                            elseif ($postCount == 2) $heatmapColor = '#fefce8'; // yellow-50
                            elseif ($postCount == 3) $heatmapColor = '#fef9c3'; // yellow-100
                            elseif ($postCount == 4) $heatmapColor = '#ffedd5'; // orange-100
                            elseif ($postCount >= 5) $heatmapColor = '#fee2e2'; // red-100
                        @endphp
                        <div class="cal-cell border-b border-gray-100 p-1.5 transition-colors hover:bg-indigo-50/20
                            {{ $isLastCol ? '' : 'border-r border-gray-100' }}
                            {{ $isWeekend ? 'bg-gray-50/30' : 'bg-white' }}
                            {{ $isToday ? 'ring-2 ring-inset ring-indigo-400 !bg-indigo-50/40' : '' }}"
                            :style="heatmapEnabled && '{{ $heatmapColor }}' ? 'background-color: {{ $heatmapColor }} !important;' : ''">

                            {{-- Date number --}}
                            <div class="flex items-center justify-between mb-1">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                    {{ $isToday ? 'bg-indigo-600 text-white' : 'text-gray-500' }}">
                                    {{ $day }}
                                </span>
                                @if($postCount > 0)
                                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded-full leading-none">
                                        {{ $postCount }}
                                    </span>
                                @endif
                            </div>

                            {{-- Post events (up to 3) --}}
                            <div class="space-y-0.5">
                                @foreach($dayPosts->take(3) as $post)
                                    @php
                                        $pc = $programColors[$post->program] ?? ['dot'=>'bg-gray-400','badge'=>'bg-gray-100 text-gray-700','border'=>'border-l-gray-300'];
                                        $dot = $post->status === 'published' ? 'bg-green-400' : ($post->status === 'scheduled' ? 'bg-blue-400' : 'bg-gray-300');
                                        $t   = $post->publish_time ? \Carbon\Carbon::parse($post->publish_time)->format('H:i') : '';
                                    @endphp
                                    <a href="{{ route('admin.social-media.index', $post->program) }}"
                                       class="flex items-center gap-1 px-1.5 py-0.5 rounded border-l-2 {{ $pc['border'] }} {{ $pc['badge'] }} hover:opacity-75 transition text-[10px] leading-tight"
                                       title="{{ $post->title }} — {{ $programLabels[$post->program] ?? $post->program }}{{ $t ? ' @ '.$t : '' }} ({{ ucfirst($post->status) }})">
                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dot }}"></span>
                                        <span class="truncate font-semibold">{{ \Illuminate\Support\Str::limit($post->title, 16) }}</span>
                                        @if($t)<span class="ml-auto flex-shrink-0 opacity-60 font-normal">{{ $t }}</span>@endif
                                    </a>
                                @endforeach

                                @if($postCount > 3)
                                    <div class="text-[10px] font-bold text-indigo-500 px-1.5">+{{ $postCount - 3 }} more</div>
                                @endif
                            </div>

                            {{-- Hover tooltip --}}
                            @if($postCount > 0)
                            <div class="cal-tooltip">
                                <div class="text-xs font-bold text-gray-700 mb-2">
                                    {{ Carbon::createFromDate($calendarYear, $calendarMonth, $day)->format('l, d M Y') }}
                                </div>
                                @foreach($dayPosts as $post)
                                    @php
                                        $pcc = $programColors[$post->program] ?? ['dot'=>'bg-gray-400','badge'=>'bg-gray-100 text-gray-700','border'=>'border-l-gray-300'];
                                        $dot = $post->status === 'published' ? 'bg-green-400' : ($post->status === 'scheduled' ? 'bg-blue-400' : 'bg-gray-300');
                                        $tt  = $post->publish_time ? \Carbon\Carbon::parse($post->publish_time)->format('H:i') : '';
                                    @endphp
                                    <a href="{{ route('admin.social-media.index', $post->program) }}"
                                       class="flex items-start gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition mb-0.5">
                                        <span class="mt-1 w-2 h-2 rounded-full flex-shrink-0 {{ $dot }}"></span>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-xs text-gray-800 truncate">{{ $post->title }}</div>
                                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-semibold {{ $pcc['badge'] }}">
                                                    {{ $programLabels[$post->program] ?? $post->program }}
                                                </span>
                                                @if($tt)<span class="text-[10px] text-gray-400">{{ $tt }}</span>@endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endfor

                    {{-- Trailing filler cells --}}
                    @php
                        $totalCells = $mStartDow + $mDays;
                        $remainder  = $totalCells % 7;
                        $fillers    = $remainder > 0 ? 7 - $remainder : 0;
                    @endphp
                    @for($i = 0; $i < $fillers; $i++)
                        <div class="border-b border-gray-100 bg-gray-50/20 {{ $i < $fillers - 1 ? 'border-r border-gray-100' : '' }}"></div>
                    @endfor
                </div>
            </div>

            {{-- ===== UPCOMING SCHEDULED POSTS ===== --}}
            @php
                $upcomingPosts = \App\Models\SocialMediaPost::where('is_archived', false)
                    ->where('status', 'scheduled')
                    ->where('publish_date', '>=', now()->toDateString())
                    ->orderBy('publish_date')
                    ->orderBy('publish_time')
                    ->limit(15)
                    ->get();
            @endphp
            @if($upcomingPosts->isNotEmpty())
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">📅 Upcoming Scheduled Posts</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Next uploads across all programs</p>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $upcomingPosts->count() }} posts</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($upcomingPosts as $post)
                        @php
                            $pcu = $programColors[$post->program] ?? ['dot'=>'bg-gray-400','badge'=>'bg-gray-100 text-gray-700','border'=>'border-l-gray-300'];
                            $daysUntil = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($post->publish_date)->startOfDay(), false);
                        @endphp
                        <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-gray-50/50 transition group">
                            {{-- Date block --}}
                            <div class="flex-shrink-0 w-12 text-center">
                                <div class="text-[10px] uppercase font-bold text-gray-400">{{ \Carbon\Carbon::parse($post->publish_date)->format('D') }}</div>
                                <div class="text-2xl font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($post->publish_date)->format('d') }}</div>
                                <div class="text-[10px] uppercase font-medium text-gray-400">{{ \Carbon\Carbon::parse($post->publish_date)->format('M') }}</div>
                            </div>
                            <div class="w-px h-10 bg-gray-150 self-stretch my-auto border-l border-gray-200"></div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-800 text-sm truncate">{{ $post->title }}</div>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $pcu['badge'] }}">
                                        {{ $programLabels[$post->program] ?? $post->program }}
                                    </span>
                                    @if($post->publish_time)
                                        <span class="text-xs text-gray-400">⏰ {{ \Carbon\Carbon::parse($post->publish_time)->format('H:i') }}</span>
                                    @endif
                                    @if($post->assigned_to)
                                        <span class="text-xs text-gray-400">👤 {{ $post->assigned_to }}</span>
                                    @endif
                                    @if(count($post->platforms ?? []))
                                        <span class="text-xs text-gray-400">📱 {{ implode(', ', $post->platforms) }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- Countdown badge --}}
                            <div class="flex-shrink-0">
                                @if($daysUntil === 0)
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1.5 rounded-full">Today!</span>
                                @elseif($daysUntil === 1)
                                    <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2.5 py-1.5 rounded-full">Tomorrow</span>
                                @elseif($daysUntil <= 7)
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2.5 py-1.5 rounded-full">{{ $daysUntil }}d</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2.5 py-1.5 rounded-full">{{ $daysUntil }}d</span>
                                @endif
                            </div>
                            {{-- Manage link --}}
                            <a href="{{ route('admin.social-media.index', $post->program) }}"
                               class="flex-shrink-0 p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
                <div class="text-3xl mb-2">🗓️</div>
                <div class="font-medium text-gray-600">No upcoming scheduled posts</div>
                <p class="text-sm mt-1">Schedule posts from each program's management page to see them here.</p>
            </div>
            @endif

        </div>{{-- END calendar view --}}

    </main>
</div>
</body>
</html>
