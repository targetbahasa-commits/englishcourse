<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lead Tracker - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ viewRawJson: null }">
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
        </div>
    @endif

    <div class="mb-8 flex flex-wrap justify-between items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Lead Tracker</h1>
            <p class="mt-2 text-sm text-gray-500">Manage submissions from Free Promotional Tests.</p>
        </div>
        <form method="POST" action="{{ route('admin.leads.reevaluate-failed') }}" onsubmit="return confirm('Kirim ulang semua AI untuk submission tersimpan yang belum dinilai?')">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-sm hover:shadow-md transition text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Kirim Ulang Semua AI (Belum Dinilai)</span>
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Leads</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalLeads }}</dd>
            </div>
        </div>
        <div class="bg-yellow-50 overflow-hidden shadow-sm rounded-lg border border-yellow-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-yellow-800 truncate">Pending Follow-up</dt>
                <dd class="mt-1 text-3xl font-semibold text-yellow-900">{{ $pendingLeads }}</dd>
            </div>
        </div>
        <div class="bg-blue-50 overflow-hidden shadow-sm rounded-lg border border-blue-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-blue-800 truncate">Contacted</dt>
                <dd class="mt-1 text-3xl font-semibold text-blue-900">{{ $contactedLeads }}</dd>
            </div>
        </div>
        <div class="bg-green-50 overflow-hidden shadow-sm rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-green-800 truncate">Enrolled</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-900">{{ $enrolledLeads }}</dd>
            </div>
        </div>
    </div>

    <!-- Filters Container -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="space-y-4">
            
            <!-- Row 1: Search & Dropdown Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                
                <!-- Search Input -->
                <div class="lg:col-span-1">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Lead</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau WA..." class="w-full pl-9 pr-3 py-2 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Status Follow-Up -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Follow-up</label>
                    <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Follow-up</option>
                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="enrolled" {{ request('status') == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                    </select>
                </div>

                <!-- Program / Test Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Program / Tes</label>
                    <select name="test_category" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Semua Program</option>
                        <option value="grammar" {{ request('test_category') == 'grammar' ? 'selected' : '' }}>Grammar & Writing</option>
                        <option value="ielts" {{ request('test_category') == 'ielts' ? 'selected' : '' }}>IELTS Academic</option>
                        <option value="toefl_itp" {{ request('test_category') == 'toefl_itp' ? 'selected' : '' }}>TOEFL ITP</option>
                        <option value="toefl_ibt" {{ request('test_category') == 'toefl_ibt' ? 'selected' : '' }}>TOEFL iBT</option>
                        <option value="pte" {{ request('test_category') == 'pte' ? 'selected' : '' }}>PTE Academic</option>
                        <option value="cambridge" {{ request('test_category') == 'cambridge' ? 'selected' : '' }}>Cambridge English</option>
                    </select>
                </div>

                <!-- CEFR Level -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tingkat CEFR</label>
                    <select name="cefr_level" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Semua Level CEFR</option>
                        <option value="C2" {{ request('cefr_level') == 'C2' ? 'selected' : '' }}>C2 (Mastery / Band 8-9)</option>
                        <option value="C1" {{ request('cefr_level') == 'C1' ? 'selected' : '' }}>C1 (Proficient / Band 7)</option>
                        <option value="B2" {{ request('cefr_level') == 'B2' ? 'selected' : '' }}>B2 (Vantage / Band 5.5-6.5)</option>
                        <option value="B1" {{ request('cefr_level') == 'B1' ? 'selected' : '' }}>B1 (Threshold / Band 4-5)</option>
                        <option value="A2" {{ request('cefr_level') == 'A2' ? 'selected' : '' }}>A2 (Elementary / Band 3-3.5)</option>
                        <option value="A1" {{ request('cefr_level') == 'A1' ? 'selected' : '' }}>A1 (Beginner)</option>
                    </select>
                </div>

                <!-- Status Penilaian AI -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Penilaian AI</label>
                    <select name="eval_status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Semua Status AI</option>
                        <option value="completed" {{ request('eval_status') == 'completed' ? 'selected' : '' }}>Sudah Dinilai AI</option>
                        <option value="pending" {{ request('eval_status') == 'pending' ? 'selected' : '' }}>Pending AI</option>
                        <option value="failed" {{ request('eval_status') == 'failed' ? 'selected' : '' }}>Gagal AI</option>
                    </select>
                </div>

            </div>

            <!-- Row 2: Date Filters & Action Buttons -->
            <div class="pt-3 border-t border-gray-100 flex flex-wrap items-end justify-between gap-3">
                
                <!-- Date Presets & Date Range Inputs -->
                <div class="flex flex-wrap items-center gap-3">
                    
                    <!-- Date Presets -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Periode Tanggal</label>
                        <select name="date_preset" onchange="if(this.value){ this.form.date_from.value=''; this.form.date_to.value=''; }" class="rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">Semua Tanggal / Custom</option>
                            <option value="today" {{ request('date_preset') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="yesterday" {{ request('date_preset') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                            <option value="7_days" {{ request('date_preset') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="30_days" {{ request('date_preset') == '30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="this_month" {{ request('date_preset') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <!-- Submit & Clear Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Terapkan Filter</span>
                    </button>

                    @if(request('status') || request('search') || request('test_category') || request('cefr_level') || request('eval_status') || request('date_preset') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center gap-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prospect</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target & Saran AI</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil & CEFR</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengerjaan & Durasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AI JSON</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Re-evaluate AI</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                <div class="text-sm text-gray-500">{{ $lead->email }}</div>
                                <div class="text-sm text-gray-500">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp_number) }}" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.981-.342-1.714-.651-2.836-2.42-2.92-2.532-.084-.112-.697-.927-.697-1.769s.434-1.261.587-1.423c.153-.162.336-.202.448-.202.112 0 .223.004.321.009.106.005.249-.041.385.285.14.337.476 1.161.518 1.246.042.085.069.184.014.296-.055.112-.084.183-.168.283l-.224.225c-.083.085-.171.178-.075.343.097.166.434.717.935 1.166.65.583 1.196.764 1.36.85.165.085.262.069.359-.041.098-.112.422-.493.535-.662.112-.17.223-.142.373-.085.15.056.949.448 1.111.528.161.08.269.121.309.189.039.068.039.395-.105.801z"/></svg>
                                        {{ $lead->whatsapp_number }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-lg {{ $lead->test_type_badge_class }}">
                                    {{ $lead->formatted_test_type }}
                                </span>
                            </td>
                            {{-- Target & Saran AI --}}
                            <td class="px-6 py-4">
                                <div class="space-y-1 min-w-[200px]">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="text-gray-400 font-medium shrink-0">Minat:</span>
                                        <span class="font-bold text-blue-900 truncate">{{ $lead->target_program_display }}</span>
                                    </div>
                                    <div class="p-2 bg-emerald-50/90 border border-emerald-200/90 rounded-xl text-[11px] text-emerald-900 leading-snug shadow-2xs">
                                        <span class="font-black text-emerald-700 block text-[10px] uppercase tracking-wide">💡 Rekomendasi AI:</span>
                                        <span class="font-bold text-emerald-950">{{ $lead->ai_recommended_program_display }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lead->estimated_band_score !== null)
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-black rounded-lg {{ $lead->score_badge_class }}">
                                            {{ $lead->score_display }}
                                        </span>

                                        @if($lead->cefr_level)
                                            <span class="px-2 py-0.5 inline-flex text-[11px] font-extrabold rounded-md {{ $lead->cefr_badge_class }}">
                                                {{ $lead->cefr_level }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum Dinilai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                <div class="space-y-1.5">
                                    {{-- Completion Rate --}}
                                    <div class="flex items-center gap-2">
                                        <div class="w-14 bg-gray-200 rounded-full h-1.5 overflow-hidden shrink-0">
                                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $lead->completion_percentage }}%"></div>
                                        </div>
                                        <span class="font-bold text-gray-800 text-[11px]">{{ $lead->completion_display }}</span>
                                    </div>

                                    {{-- Duration --}}
                                    @if($lead->duration_display)
                                        <div class="flex items-center gap-1 text-gray-500 font-medium text-[11px]">
                                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $lead->duration_display }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($lead->ai_raw_json_feedback)
                                    <button type="button" data-json="{{ json_encode($lead->ai_raw_json_feedback) }}" @click="viewRawJson = $el.dataset.json" class="text-blue-600 hover:text-blue-900 underline">View JSON</button>
                                @else
                                    <span class="text-gray-400 italic">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if(!empty($lead->answer_text) || !empty($lead->audio_paths))
                                    <form method="POST" action="{{ route('admin.leads.reevaluate', $lead->id) }}" onsubmit="return confirm('Kirim ulang & evaluasi AI untuk {{ addslashes($lead->name) }}?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-300 transition shadow-sm" title="Kirim ulang teks/rekaman ke AI untuk mendapatkan penilaian">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <span>Kirim Ulang AI</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">No Answer Saved</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <form method="POST" action="{{ route('admin.leads.status.update', $lead->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-medium
                                        {{ $lead->follow_up_status == 'pending' ? 'text-yellow-800 bg-yellow-50' : '' }}
                                        {{ $lead->follow_up_status == 'contacted' ? 'text-blue-800 bg-blue-50' : '' }}
                                        {{ $lead->follow_up_status == 'enrolled' ? 'text-green-800 bg-green-50' : '' }}
                                    ">
                                        <option value="pending" {{ $lead->follow_up_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted" {{ $lead->follow_up_status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="enrolled" {{ $lead->follow_up_status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                No leads found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($leads->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $leads->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- JSON Viewer Modal -->
    <div x-show="viewRawJson" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="viewRawJson" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="viewRawJson = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="viewRawJson" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                AI Raw Feedback JSON
                            </h3>
                            <div class="mt-4">
                                <pre class="bg-gray-800 text-green-400 p-4 rounded-md overflow-x-auto text-xs font-mono" x-text="
                                    (() => {
                                        let obj = viewRawJson;
                                        let limit = 5;
                                        while (typeof obj === 'string' && limit > 0) {
                                            try {
                                                let parsed = JSON.parse(obj);
                                                if (obj === parsed) break;
                                                obj = parsed;
                                                limit--;
                                            } catch (e) {
                                                break;
                                            }
                                        }
                                        return JSON.stringify(obj, null, 2);
                                    })()
                                "></pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="viewRawJson = null" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
</main>
    </div>
</body>
</html>
