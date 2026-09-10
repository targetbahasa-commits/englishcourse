<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Final Test</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased {{ request()->routeIs('admin.manage-final-test') ? 'bg-gradient-to-br from-blue-50 via-white to-white' : 'bg-gradient-to-br from-slate-100 via-slate-50 to-white' }}">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        @php
            $programMeta = [
                'toefl-itp' => [
                    'accent' => 'emerald',
                    'code' => 'ITP',
                    'sections' => 'Listening, Structure, Reading',
                    'duration' => '115 min',
                    'mode' => 'Full mockup',
                ],
                'ielts-academic' => [
                    'accent' => 'violet',
                    'code' => 'AC',
                    'sections' => 'Listening, Reading, Writing, Speaking',
                    'duration' => '165 min',
                    'mode' => 'Academic band',
                ],
                'ielts-general' => [
                    'accent' => 'rose',
                    'code' => 'GT',
                    'sections' => 'Listening, Reading, Writing, Speaking',
                    'duration' => '165 min',
                    'mode' => 'General band',
                ],
                'pte-academic' => [
                    'accent' => 'amber',
                    'code' => 'PTE',
                    'sections' => 'Speaking, Writing, Reading, Listening',
                    'duration' => '120 min',
                    'mode' => 'Integrated test',
                ],
            ];

            $accentClasses = [
                'emerald' => [
                    'line'   => 'bg-gradient-to-r from-emerald-400 to-emerald-500',
                    'text'   => 'text-emerald-700',
                    'soft'   => 'bg-white text-emerald-700 border-emerald-200',
                    'button' => 'bg-emerald-600 hover:bg-emerald-500 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-white text-emerald-800 border-emerald-200',
                    'ring'   => 'ring-emerald-100',
                ],
                'violet' => [
                    'line'   => 'bg-gradient-to-r from-violet-400 to-violet-500',
                    'text'   => 'text-violet-700',
                    'soft'   => 'bg-violet-50 text-violet-700 border-violet-200',
                    'button' => 'bg-violet-600 hover:bg-violet-500 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-violet-100 text-violet-800 border-violet-200',
                    'ring'   => 'ring-violet-100',
                ],
                'rose' => [
                    'line'   => 'bg-gradient-to-r from-rose-400 to-rose-500',
                    'text'   => 'text-rose-700',
                    'soft'   => 'bg-rose-50 text-rose-700 border-rose-200',
                    'button' => 'bg-rose-600 hover:bg-rose-500 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-rose-100 text-rose-800 border-rose-200',
                    'ring'   => 'ring-rose-100',
                ],
                'amber' => [
                    'line'   => 'bg-gradient-to-r from-amber-400 to-amber-500',
                    'text'   => 'text-amber-700',
                    'soft'   => 'bg-white text-amber-700 border-amber-200',
                    'button' => 'bg-amber-500 hover:bg-amber-400 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-white text-amber-800 border-amber-200',
                    'ring'   => 'ring-amber-100',
                ],
                'blue' => [
                    'line'   => 'bg-gradient-to-r from-blue-400 to-blue-500',
                    'text'   => 'text-blue-700',
                    'soft'   => 'bg-white text-blue-700 border-blue-200',
                    'button' => 'bg-blue-600 hover:bg-blue-500 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-white text-blue-800 border-blue-200',
                    'ring'   => 'ring-blue-100',
                ],
                'slate' => [
                    'line'   => 'bg-gradient-to-r from-slate-400 to-slate-500',
                    'text'   => 'text-slate-700',
                    'soft'   => 'bg-white text-slate-700 border-slate-200',
                    'button' => 'bg-slate-800 hover:bg-slate-700 shadow-md hover:shadow-lg hover:-translate-y-0.5',
                    'badge'  => 'bg-white text-slate-800 border-slate-200',
                    'ring'   => 'ring-slate-100',
                ],
            ];
        @endphp

        <main class="flex-1 md:ml-64">
            <div class="{{ request()->routeIs('admin.manage-final-test') ? 'p-6 md:p-8 pb-32' : 'px-5 py-6 sm:px-8 lg:px-10' }}">
                <header class="{{ request()->routeIs('admin.manage-final-test') ? 'mb-8' : 'mb-6 border-b border-slate-200 pb-6' }} {{ ($studentFocusedView ?? false) ? 'text-center' : '' }}">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            @unless(request()->routeIs('admin.manage-final-test'))
                                <div class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">
                                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                                    Final Assessment
                                </div>
                            @endunless
                            <h1 class="{{ request()->routeIs('admin.manage-final-test') ? 'text-3xl font-bold font-serif text-gray-900' : 'mt-4 text-3xl font-bold tracking-tight text-slate-950' }}">Final Test Center</h1>
                            <p class="{{ request()->routeIs('admin.manage-final-test') ? 'mt-1 text-gray-500' : 'mt-2 max-w-2xl text-sm leading-6 text-slate-600' }}">
                                @if($studentFocusedView ?? false)
                                    Final test untuk program yang Anda ambil. Selesaikan assessment sesuai kelas Anda.
                                @else
                                    {{ request()->routeIs('admin.manage-final-test') ? 'Manage access and active batches for final assessment tracks.' : 'Pilih jalur final test dengan URL khusus. Setiap program terbuka di halaman final test sendiri.' }}
                                @endif
                            </p>
                        </div>

                        @if(!($studentFocusedView ?? false) && !request()->routeIs('admin.manage-final-test'))
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xl font-black text-slate-900 leading-none">{{ count($primaryPrograms) }}</p>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Programs</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xl font-black text-slate-900 leading-none">{{ count($grammarPrograms) + count($speakingPrograms) }}</p>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Tracks</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-purple-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xl font-black text-slate-900 leading-none">{{ empty($allowedAssignmentProgramSlugs) ? 'All' : count($allowedAssignmentProgramSlugs) }}</p>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Access</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if(session('error'))
                        <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mt-5 rounded-lg border border-emerald-200 bg-white px-4 py-3 text-sm font-medium text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif
                </header>

                @if(!request()->routeIs('admin.manage-final-test') && !($studentFocusedView ?? false))
                <div class="relative mb-10 mt-6 overflow-hidden rounded-[2rem] bg-gradient-to-r from-indigo-500 via-violet-600 to-indigo-600 p-8 md:p-12 shadow-2xl">
                    <div class="absolute -right-20 -top-20 h-[500px] w-[500px] rounded-full bg-white opacity-5 blur-[80px]"></div>
                    <div class="absolute -left-20 -bottom-20 h-[300px] w-[300px] rounded-full bg-white opacity-10 blur-[60px]"></div>
                    
                    <!-- Decorative patterns -->
                    <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="max-w-2xl">
                            <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-white backdrop-blur-sm">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Final Assessment Center
                            </div>
                            <h1 class="mt-6 text-4xl font-black tracking-tight text-white sm:text-5xl">Pilih Program Final Test</h1>
                            <p class="mt-4 max-w-xl text-lg leading-relaxed text-indigo-100">Selesaikan final test sesuai jalur program Anda. Setiap program memiliki halaman ujian tersendiri.</p>
                        </div>
                        
                        <!-- Illustration Placeholder (Reference had a 3D laptop/books/cap) -->
                        <div class="hidden lg:block relative shrink-0">
                            <div class="relative h-64 w-64">
                                <div class="absolute right-0 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-6 backdrop-blur-md border border-white/20">
                                    <svg class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div class="absolute right-20 top-10 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 p-4 shadow-lg rotate-12">
                                    <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(request()->routeIs('admin.manage-final-test'))
                    @php
                        $enabledFinalTests = collect($finalTestSettings)->filter(fn ($settings) => !empty($settings['enabled']))->count();
                        $availableBatchCount = collect($classPeriodsByFinalTest)
                            ->flatMap(fn ($periods) => $periods)
                            ->unique('id')
                            ->count();
                    @endphp
                    <section class="mb-6">
                        <form method="POST" action="{{ route('final-test.settings.update') }}" x-data="{ searchQuery: '' }">
                            @csrf
                            <input type="hidden" name="return_to" value="admin.manage-final-test" />

                            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                                <div class="flex flex-col gap-4 border-b border-gray-100 bg-white p-5 xl:flex-row xl:items-center xl:justify-between">
                                    <div class="relative w-full xl:w-96">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input
                                            x-model="searchQuery"
                                            type="text"
                                            placeholder="Search final test track..."
                                            class="block w-full rounded-xl border border-gray-200 bg-white py-2 pl-10 pr-3 text-sm leading-5 placeholder-gray-400 transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                    </div>

                                    <div class="grid w-full grid-cols-3 overflow-hidden rounded-xl border border-gray-100 bg-white text-sm shadow-sm xl:w-auto">
                                        <div class="px-4 py-3">
                                            <p class="text-xs text-gray-400">Tracks</p>
                                            <p class="text-lg font-bold text-gray-900">{{ count($finalTestSettings) }}</p>
                                        </div>
                                        <div class="border-x border-gray-100 px-4 py-3">
                                            <p class="text-xs text-gray-400">Enabled</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $enabledFinalTests }}</p>
                                        </div>
                                        <div class="px-4 py-3">
                                            <p class="text-xs text-gray-400">Batches</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $availableBatchCount }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-0 divide-y divide-gray-50 lg:grid-cols-2 lg:divide-x lg:divide-y-0 2xl:grid-cols-3">
                                    @foreach($finalTestSettings as $slug => $settings)
                                        @php
                                            $label = str_replace('-', ' ', $slug);
                                            $periods = $classPeriodsByFinalTest[$slug] ?? collect();
                                            $selectedIds = $settings['class_period_ids'] ?? [];
                                            $selectedPeriods = $periods->whereIn('id', $selectedIds);
                                            $meta = $programMeta[$slug] ?? [
                                                'accent' => str_contains($slug, 'speaking') ? 'amber' : (str_contains($slug, 'grammar') ? 'blue' : 'slate'),
                                                'code' => strtoupper(substr($label, 0, 3)),
                                                'sections' => str_contains($slug, 'speaking') ? 'Speaking final test' : (str_contains($slug, 'grammar') ? 'Grammar writing final test' : 'Final assessment'),
                                                'duration' => 'Flexible',
                                                'mode' => str_contains($slug, 'speaking') || str_contains($slug, 'grammar') ? 'Track test' : 'Program test',
                                            ];
                                            $accent = $accentClasses[$meta['accent']] ?? $accentClasses['slate'];
                                        @endphp
                                        <article
                                            class="group relative bg-white p-5 transition-colors hover:bg-white"
                                            x-show="!searchQuery || '{{ strtolower(addslashes($label . ' ' . $meta['sections'] . ' ' . $meta['mode'])) }}'.includes(searchQuery.toLowerCase())"
                                        >
                                            <div class="absolute left-0 top-5 h-10 w-1.5 rounded-r-full {{ $accent['line'] }}"></div>
                                            <div class="flex items-start justify-between gap-4 pl-3">
                                                <div class="flex min-w-0 items-start gap-3">
                                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border {{ $accent['soft'] }} text-xs font-bold">
                                                        {{ $meta['code'] }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <h3 class="text-base font-bold text-gray-900 group-hover:text-blue-600">{{ ucwords($label) }}</h3>
                                                            <span class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium {{ $accent['soft'] }}">{{ $meta['mode'] }}</span>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500">{{ $meta['sections'] }}</p>
                                                    </div>
                                                </div>

                                                <label class="inline-flex shrink-0 cursor-pointer items-center gap-2 rounded-full border px-3 py-1.5 text-sm font-semibold transition {{ !empty($settings['enabled']) ? 'border-emerald-200 bg-white text-emerald-700' : 'border-gray-200 bg-white text-gray-500' }}">
                                                    <input type="hidden" name="tests[{{ $slug }}][enabled]" value="0" />
                                                    <input type="checkbox" name="tests[{{ $slug }}][enabled]" value="1" {{ !empty($settings['enabled']) ? 'checked' : '' }} class="form-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                    <span>Enabled</span>
                                                </label>
                                            </div>

                                            <div class="mt-5 pl-3">
                                                <div class="mb-2 flex items-center justify-between gap-3">
                                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Allowed batches</p>
                                                    <span class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-100">{{ $selectedPeriods->count() }} selected</span>
                                                </div>

                                                <div class="min-h-8">
                                                    @if($selectedPeriods->isEmpty())
                                                        <div class="rounded-xl border border-dashed border-gray-200 bg-white px-3 py-2 text-sm italic text-gray-400">No active batches selected</div>
                                                    @else
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($selectedPeriods as $period)
                                                                <span class="inline-flex items-center gap-2 rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-100">
                                                                    {{ $period->batch_number ? 'Batch ' . $period->batch_number : 'Batch' }} — {{ Illuminate\Support\Str::limit($period->name ?? $period->id, 28) }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <details class="mt-4 rounded-xl border border-gray-100 bg-white p-3 shadow-sm">
                                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm font-medium text-gray-600 marker:hidden">
                                                        <span>Select batches (multiple)</span>
                                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-white text-gray-400">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </span>
                                                    </summary>
                                                    <div class="mt-3 max-h-44 space-y-1 overflow-auto pr-1">
                                                        @forelse($periods as $period)
                                                            <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2 text-sm transition hover:bg-white">
                                                                <input type="checkbox" name="tests[{{ $slug }}][class_period_ids][]" value="{{ $period->id }}" {{ in_array($period->id, $settings['class_period_ids'] ?? [], true) ? 'checked' : '' }} class="form-checkbox mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                                <span class="min-w-0 flex-1">
                                                                    <span class="flex flex-wrap items-center gap-2">
                                                                        <span class="inline-flex items-center rounded bg-white px-2 py-0.5 text-xs font-bold text-blue-800">
                                                                            {{ $period->batch_number ? 'Batch ' . $period->batch_number : 'Batch' }}
                                                                        </span>
                                                                        <span class="font-semibold text-gray-800">{{ $period->name ?? 'Class Period' }}</span>
                                                                    </span>
                                                                    <span class="mt-1 block text-xs text-gray-500">
                                                                        {{ $period->program->name ?? 'All Programs' }}
                                                                        @if($period->start_date || $period->end_date)
                                                                            · {{ $period->start_date ? $period->start_date->format('M d, Y') : 'TBD' }} to {{ $period->end_date ? $period->end_date->format('M d, Y') : 'TBD' }}
                                                                        @endif
                                                                    </span>
                                                                    <span class="mt-1 flex flex-wrap items-center gap-2 text-[11px]">
                                                                        @if($period->learning_mode)
                                                                            <span class="rounded px-1.5 py-0.5 font-medium {{ $period->learning_mode === 'online' ? 'bg-white text-blue-800' : 'bg-white text-purple-800' }}">
                                                                                {{ ucfirst($period->learning_mode) }}
                                                                            </span>
                                                                        @endif
                                                                        <span class="text-gray-400">{{ $period->users_count ?? 0 }} enrolled</span>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        @empty
                                                            <div class="rounded-lg bg-white p-3 text-xs text-gray-400">No batches available for this program.</div>
                                                        @endforelse
                                                    </div>
                                                    <div class="mt-4 flex items-center justify-end border-t border-gray-100 pt-3">
                                                        <button type="submit" class="inline-flex h-9 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </details>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center">
                                <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Save changes
                                </button>
                                <a href="{{ route('final-test') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-white px-5 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                                    Back to final test
                                </a>
                            </div>
                        </form>
                    </section>

                @elseif($studentFocusedView ?? false)
                    <section class="flex min-h-[55vh] items-center justify-center py-8">
                        <div class="w-full max-w-md">
                            @forelse($studentFinalTestCards ?? [] as $program)
                                @php
                                    $slug = $program['slug'] ?? \Illuminate\Support\Str::slug($program['name']);
                                    $meta = $programMeta[$slug] ?? [
                                        'accent' => str_contains($slug, 'speaking') ? 'amber' : (str_contains($slug, 'grammar') ? 'blue' : 'slate'),
                                        'code' => strtoupper(substr($program['name'], 0, 3)),
                                        'sections' => 'Final assessment',
                                        'duration' => 'Flexible',
                                        'mode' => ($program['card_type'] ?? 'primary') === 'track' ? 'Track test' : 'Program test',
                                    ];
                                    $accent = $accentClasses[$meta['accent']] ?? $accentClasses['slate'];
                                @endphp

                                <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl">
                                    <div class="absolute inset-x-0 top-0 h-1.5 {{ $accent['line'] }}"></div>
                                    <div class="p-6">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex min-w-0 items-center gap-3">
                                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl border {{ $accent['soft'] }} text-base font-bold">
                                                    {{ $meta['code'] }}
                                                </div>
                                                <div class="min-w-0">
                                                    <h2 class="text-xl font-bold text-slate-950">{{ $program['name'] }}</h2>
                                                    <p class="mt-1 text-xs font-semibold uppercase tracking-wide {{ $accent['text'] }}">{{ $meta['mode'] }}</p>
                                                </div>
                                            </div>
                                            <div class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                {{ $meta['duration'] }}
                                            </div>
                                        </div>

                                        <p class="mt-5 text-sm leading-6 text-slate-600">{{ $program['description'] ?? 'Final assessment untuk program Anda.' }}</p>

                                        <div class="mt-5 rounded-xl border border-slate-200 bg-white p-4">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sections</p>
                                            <p class="mt-1 text-sm font-medium text-slate-800">{{ $meta['sections'] }}</p>
                                        </div>

                                        <div class="mt-6 flex items-center justify-between gap-3">
                                            <span class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm font-semibold text-emerald-700">
                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                Ready
                                            </span>
                                            <a href="{{ $program['route'] }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg px-5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-4 {{ $accent['button'] }}">
                                                Open
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                                    <p class="text-sm font-semibold text-slate-800">Belum ada final test untuk program Anda.</p>
                                    <p class="mt-2 text-sm text-slate-500">Hubungi admin jika program Anda seharusnya sudah tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                @else
                <section class="grid grid-cols-1 gap-5 xl:grid-cols-2 2xl:grid-cols-4">
                    @foreach($primaryPrograms as $program)
                        @php
                            $slug = $program['slug'] ?? \Illuminate\Support\Str::slug($program['name']);
                            $meta = $programMeta[$slug] ?? [
                                'accent' => 'slate',
                                'code' => strtoupper(substr($program['name'], 0, 3)),
                                'sections' => 'Final assessment',
                                'duration' => 'Flexible',
                                'mode' => 'Program test',
                            ];
                            $accent = $accentClasses[$meta['accent']] ?? $accentClasses['slate'];
                            $isProgramLocked = !empty($allowedAssignmentProgramSlugs) && !in_array($slug, $allowedAssignmentProgramSlugs, true);
                            $isBatchLocked = empty($program['batch_allowed']);
                            $isHidden = empty($program['enabled']);
                            $isLocked = $isProgramLocked || $isBatchLocked || $isHidden;
                        @endphp

                        @continue(!Auth::user()->isAdmin() && ($isHidden || $isBatchLocked))

                        <article class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-[0_4px_24px_rgba(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_12px_40px_rgba(0,0,0,0.12)]">
                            <div class="absolute inset-x-0 top-0 h-1.5 opacity-90 transition-opacity duration-300 group-hover:opacity-100 {{ $accent['line'] }}"></div>
                            <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-4">
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 bg-white text-lg font-black shadow-sm transition-transform duration-300 group-hover:scale-105 {{ $accent['soft'] }}">
                                        {{ $meta['code'] }}
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="truncate text-xl font-semibold tracking-tight text-slate-900">{{ $program['name'] }}</h2>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-bold uppercase tracking-wider {{ $accent['badge'] }}">{{ $meta['mode'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="shrink-0 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-500 shadow-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $meta['duration'] }}
                                    </span>
                                </div>
                            </div>

                            <p class="mt-4 min-h-[44px] text-sm leading-relaxed text-slate-500">{{ $program['description'] }}</p>

                            <div class="mt-4 rounded-xl border border-slate-100 bg-gradient-to-br from-slate-50 to-slate-50/50 p-4">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sections</p>
                                <p class="mt-1.5 text-sm font-semibold text-slate-700">{{ $meta['sections'] }}</p>
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-3">
                                @if($isLocked)
                                    <span class="inline-flex items-center gap-2 rounded-xl border border-amber-200/60 bg-white px-4 py-2.5 text-sm font-bold text-amber-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4" />
                                        </svg>
                                        {{ $isHidden ? 'Hidden' : ($isBatchLocked ? 'Batch Restricted' : 'Locked') }}
                                    </span>
                                    @if(!Auth::user()->isAdmin())
                                        <a href="{{ route('student.payments.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 text-sm font-bold text-white shadow-md transition-all hover:scale-105 hover:shadow-lg">
                                            Unlock
                                        </a>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-2.5 rounded-xl border border-emerald-200/60 bg-white px-4 py-2.5 text-sm font-bold text-emerald-700">
                                        <span class="relative flex h-2.5 w-2.5">
                                          <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                        </span>
                                        Ready
                                    </span>
                                    <a href="{{ $program['route'] }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl px-6 text-sm font-bold text-white transition-all focus:outline-none focus:ring-4 {{ $accent['button'] }}">
                                        Open
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            </div>
                        </article>
                    @endforeach
                </section>

                <section class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">
                    @php
                        $trackGroups = [
                            [
                                'slug' => 'grammar-for-writing',
                                'title' => 'Grammar for Writing',
                                'description' => 'Track final assessment berdasarkan level grammar writing.',
                                'items' => $grammarPrograms,
                                'accent' => $accentClasses['blue'],
                                'per_track_settings' => true,
                            ],
                            [
                                'slug' => 'speaking',
                                'title' => 'Speaking',
                                'description' => 'Pilih level speaking final test sesuai program.',
                                'items' => $speakingPrograms,
                                'accent' => $accentClasses['amber'],
                                'per_track_settings' => true,
                            ],
                        ];
                    @endphp

                    @if(!($studentFocusedView ?? false))
                    <div class="col-span-full mb-1 flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Track Selections</span>
                            <div class="h-px flex-1 bg-slate-200"></div>
                        </div>
                        <a href="#" class="hidden lg:inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-blue-600 shadow-sm transition hover:bg-white">
                            Lihat Semua Track
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Track Selections</span>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>
                    @endif

                    @foreach($trackGroups as $group)
                        @php
                            $groupProgramLocked = !empty($allowedAssignmentProgramSlugs) && !in_array($group['slug'], $allowedAssignmentProgramSlugs, true);
                        @endphp

                        @if($group['per_track_settings'] ?? false)
                            @continue(!Auth::user()->isAdmin() && (empty($group['items']) || $groupProgramLocked))
                        @else
                            @php
                                $groupSettings = $finalTestSettings[$group['slug']] ?? ['enabled' => true, 'class_period_ids' => []];
                                $groupBatchIds = array_map('intval', $groupSettings['class_period_ids'] ?? []);
                                $groupHidden = empty($groupSettings['enabled']);
                                $groupBatchLocked = !Auth::user()->isAdmin() && !empty($groupBatchIds) && empty(array_intersect($groupBatchIds, $userClassPeriodIds ?? []));
                                $groupLocked = $groupHidden || $groupBatchLocked || $groupProgramLocked;
                            @endphp

                            @continue(!Auth::user()->isAdmin() && ($groupHidden || $groupBatchLocked))
                        @endif

                        <article x-data="{ open: false }" class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition-all hover:shadow-lg">
                            <div class="absolute inset-x-0 top-0 h-1.5 opacity-90 {{ $group['accent']['line'] }}"></div>
                            <div class="p-8">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <div class="flex items-start md:items-center gap-5">
                                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl border-2 {{ $group['accent']['soft'] }}">
                                            @if($group['slug'] === 'grammar-for-writing')
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            @else
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold uppercase tracking-widest {{ $group['accent']['text'] }}">Track Selection</div>
                                            <h2 class="mt-1 text-2xl font-bold text-slate-900">{{ $group['title'] }}</h2>
                                            <p class="mt-1 text-sm text-slate-500">{{ $group['description'] }}</p>
                                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                                <span class="rounded-md border {{ $group['accent']['soft'] }} px-2.5 py-1 text-xs font-bold">{{ count($group['items']) }} Level</span>
                                                @foreach($group['items'] as $item)
                                                    <span class="rounded-md bg-white border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $item['short_name'] ?? explode(' ', $item['name'])[0] }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shrink-0">
                                        <button @click="open = !open" class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-sm font-bold text-white shadow-sm transition-all focus:ring-4 {{ $group['accent']['button'] }}">
                                            Pilih Level
                                            <svg class="h-4 w-4 transition-transform" :class="{'rotate-180': open, 'translate-x-1': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div x-show="open" x-transition class="mt-8 border-t border-slate-100 pt-8">
                                @if(($group['per_track_settings'] ?? false) && $groupProgramLocked)
                                    <div class="flex flex-col gap-3 rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Akses Terkunci</p>
                                            <p class="mt-1 text-sm text-slate-500">Anda tidak memiliki akses ke {{ $group['title'] }}.</p>
                                        </div>
                                        @if(!Auth::user()->isAdmin())
                                            <a href="{{ route('student.payments.index') }}" class="inline-flex h-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 text-sm font-bold text-white shadow-[0_4px_14px_0_rgba(245,158,11,0.39)] transition-all hover:scale-105 hover:shadow-[0_6px_20px_rgba(245,158,11,0.23)]">
                                                Unlock
                                            </a>
                                        @endif
                                    </div>
                                @elseif(!($group['per_track_settings'] ?? false) && ($groupLocked ?? false))
                                    <div class="flex flex-col gap-3 rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Akses Terkunci</p>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ ($groupHidden ?? false) ? 'Track ini disembunyikan dari non-admin.' : (($groupBatchLocked ?? false) ? 'Batch Anda belum memiliki akses ke track ini.' : 'Anda tidak memiliki akses ke ' . $group['title'] . '.') }}
                                            </p>
                                        </div>
                                        @if(!Auth::user()->isAdmin())
                                            <a href="{{ route('student.payments.index') }}" class="inline-flex h-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 text-sm font-bold text-white shadow-[0_4px_14px_0_rgba(245,158,11,0.39)] transition-all hover:scale-105 hover:shadow-[0_6px_20px_rgba(245,158,11,0.23)]">
                                                Unlock
                                            </a>
                                        @endif
                                    </div>
                                @elseif(empty($group['items']))
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-center">
                                        <p class="text-sm font-medium text-slate-500">Belum ada track {{ $group['title'] }} yang tersedia untuk batch Anda.</p>
                                    </div>
                                @else
                                    <div class="flex flex-col gap-3">
                                        @foreach($group['items'] as $index => $item)
                                            @php
                                                $itemLocked = false;
                                                if ($group['per_track_settings'] ?? false) {
                                                    if (!Auth::user()->isAdmin()) {
                                                        $itemSettings = $finalTestSettings[$item['settings_slug'] ?? ''] ?? ['enabled' => true, 'class_period_ids' => []];
                                                        $itemBatchIds = array_map('intval', $itemSettings['class_period_ids'] ?? []);
                                                        $itemHidden = empty($itemSettings['enabled']);
                                                        $itemBatchLocked = !empty($itemBatchIds) && empty(array_intersect($itemBatchIds, $userClassPeriodIds ?? []));
                                                        $itemLocked = $itemHidden || $itemBatchLocked;
                                                    }
                                                }
                                            @endphp

                                            @if($itemLocked)
                                                <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white px-5 py-4 transition-colors">
                                                    <div class="flex min-w-0 items-center gap-4">
                                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-200 text-sm font-black text-slate-400 shadow-inner">{{ $index + 1 }}</span>
                                                        <span class="truncate text-base font-bold text-slate-400">{{ $item['name'] }}</span>
                                                    </div>
                                                    <span class="shrink-0 rounded-lg border border-amber-200/60 bg-white px-3 py-1.5 text-xs font-bold text-amber-700 shadow-[0_0_15px_rgba(245,158,11,0.1)]">Restricted</span>
                                                </div>
                                            @else
                                                <a href="{{ $item['route'] }}" class="group/item flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white px-5 py-4 transition-all hover:-translate-x-px hover:border-slate-200 hover:bg-white hover:shadow-md">
                                                    <div class="flex min-w-0 items-center gap-4">
                                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border bg-white text-sm font-black shadow-sm transition-all group-hover/item:scale-110 {{ $group['accent']['soft'] }}">{{ $index + 1 }}</span>
                                                        <span class="truncate text-base font-bold text-slate-700 transition-colors group-hover/item:text-slate-900">{{ $item['name'] }}</span>
                                                    </div>
                                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-slate-400 transition-all group-hover/item:bg-slate-900 group-hover/item:text-white group-hover/item:shadow-sm">
                                                        <svg class="h-4 w-4 transition-transform group-hover/item:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            </div>
                        </article>
                    @endforeach
                </section>

                @if(isset($offlineTestResults) && count($offlineTestResults) > 0)
                <section class="mt-10">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Offline Test Certificates</h2>
                            <p class="mt-1 text-sm text-slate-500">Unduh sertifikat hasil ujian offline Anda di sini.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($offlineTestResults as $result)
                        <div class="flex flex-col justify-between rounded-[1.5rem] border border-slate-100 bg-white p-6 shadow-sm hover:shadow-md transition">
                            <div class="mb-4">
                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white text-indigo-600 mb-4">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">{{ str($result->test_type)->replace('_', ' ')->title() }}</h3>
                                <p class="text-sm text-slate-500 mt-1">Tanggal Ujian: {{ $result->created_at->format('d M Y') }}</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-500">Nilai:</span>
                                    <span class="inline-flex items-center rounded-lg bg-white px-2.5 py-1 text-sm font-bold text-emerald-700">{{ $result->score + 0 }}</span>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-slate-100 mt-auto">
                                @if(\App\Models\OfflineTestCertificate::where('test_type', $result->test_type)->where('is_active', true)->exists())
                                    <a href="{{ route('offline-test.certificate.download', $result->id) }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 hover:-translate-y-0.5 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download Sertifikat
                                    </a>
                                @else
                                    <div class="flex w-full items-center justify-center gap-2 rounded-xl bg-white border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-400">
                                        Sertifikat Belum Tersedia
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <section class="mt-10 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="flex items-start gap-4 rounded-[1.25rem] bg-white p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">URL Khusus</h3>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">Setiap program memiliki URL final test tersendiri.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 rounded-[1.25rem] bg-white p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Akses Fleksibel</h3>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">Akses kapan saja sesuai jadwal yang ditentukan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 rounded-[1.25rem] bg-white p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Hasil Akurat</h3>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">Sistem penilaian otomatis dan akurat.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 rounded-[1.25rem] bg-white p-5 border border-slate-100 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Keamanan Terjamin</h3>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">Data dan hasil ujian aman dan terlindungi.</p>
                        </div>
                    </div>
                </section>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
