@extends('layouts.admin')

@section('title', !empty($isMockTestView) ? 'Manage Mock Tests' : 'Manage Programs')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@php
    $isMockProgram = static function ($program) {
        return \Illuminate\Support\Str::startsWith($program->slug, 'cambridge-')
            || \Illuminate\Support\Str::startsWith($program->slug, 'toefl-itp-mock-package-');
    };
@endphp
<div class="p-6 md:p-8 space-y-8 pb-32">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold font-serif text-gray-900">{{ !empty($isMockTestView) ? 'Manage Mock Tests' : 'Manage Programs' }}</h1>
            <p class="text-gray-500 mt-1">{{ !empty($isMockTestView) ? 'Manage pricing and settings for independent test packages.' : 'Design course products, build syllabuses, and track active enrollments.' }}</p>
        </div>
        @if(empty($isMockTestView))
        <button 
            x-data
            @click="$dispatch('open-program-modal')"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Program
        </button>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Programs Master Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ searchQuery: '', activeTab: 'online' }">

        <!-- Table Toolbar -->
        <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    x-model="searchQuery"
                    type="text"
                    placeholder="Search program name or description..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors sm:text-sm"
                >
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="p-1 bg-gray-100 rounded-xl inline-flex w-full md:w-auto">
                    <button type="button" @click="activeTab = 'online'"
                            :class="activeTab === 'online' ? 'bg-white text-sky-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'"
                            class="flex-1 md:flex-none px-4 py-2 text-sm rounded-lg transition-all whitespace-nowrap">
                        Online
                    </button>
                    <button type="button" @click="activeTab = 'offline'"
                            :class="activeTab === 'offline' ? 'bg-white text-teal-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'"
                            class="flex-1 md:flex-none px-4 py-2 text-sm rounded-lg transition-all whitespace-nowrap">
                        Offline
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs uppercase tracking-wider text-gray-400 font-semibold">
                        <th class="p-5 w-2/5">Program Details</th>
                        <th class="p-5">Duration / Meetings</th>
                        <th class="p-5">Active Enrollees</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                        $groupedPrograms = collect($programs)->groupBy(function($program) {
                            $name = strtolower($program->name);
                            if (str_contains($name, 'ielts')) return 'IELTS Programs';
                            if (str_contains($name, 'toefl')) return 'TOEFL Programs';
                            if (str_contains($name, 'pte')) return 'PTE Programs';
                            if (str_contains($name, 'speaking')) return 'Speaking Programs';
                            if (str_contains($name, 'grammar')) return 'Grammar Programs';
                            if (str_contains($name, 'pronunciation')) return 'Pronunciation Programs';
                            if (str_contains($name, 'reading')) return 'Reading Programs';
                            if (str_contains($name, 'listening')) return 'Listening Programs';
                            if (str_contains($name, 'writing')) return 'Writing Programs';
                            if (str_contains($name, 'cambridge')) return 'Cambridge Mock Tests';
                            return 'Other Programs';
                        });
                    @endphp
                    @forelse($groupedPrograms as $category => $categoryPrograms)
                        @php
                            $categoryHasOnline = $categoryPrograms->contains(fn($p) => $p->delivery_mode === 'online');
                            $categoryHasOffline = $categoryPrograms->contains(fn($p) => $p->delivery_mode === 'offline');
                        @endphp
                        <tr class="bg-gray-100/70 border-b border-gray-200"
                            x-show="!searchQuery && ((activeTab === 'online' && {{ $categoryHasOnline ? 'true' : 'false' }}) || (activeTab === 'offline' && {{ $categoryHasOffline ? 'true' : 'false' }}))">
                            <td colspan="5" class="px-5 py-3 font-extrabold text-red-600 text-sm uppercase tracking-wider">
                                {{ $category }}
                            </td>
                        </tr>
                        @foreach($categoryPrograms as $program)
                                        <tr x-show="activeTab === '{{ $program->delivery_mode }}'">
                                            <td colspan="5" class="bg-blue-50/30 p-0 border-t-0">
                                                <div class="px-8 pb-4 pt-2">
                                                    <div class="text-xs font-semibold text-blue-700 mb-1">Access Audit Log</div>
                                                    <div class="overflow-x-auto">
                                                        <table class="min-w-full text-xs mb-2">
                                                            <thead>
                                                                <tr class="text-left text-[11px] text-gray-500 uppercase border-b">
                                                                    <th class="py-1 pr-4">User</th>
                                                                    <th class="py-1 pr-4">Email</th>
                                                                    <th class="py-1 pr-4">Status</th>
                                                                    <th class="py-1 pr-4">IP</th>
                                                                    <th class="py-1 pr-4">Time</th>
                                                                    <th class="py-1 pr-4">Note</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach(\App\Models\ProgramAccessLog::where('program_id', $program->id)->orderByDesc('created_at')->limit(5)->get() as $log)
                                                                    <tr class="border-b last:border-0">
                                                                        <td class="py-1 pr-4 font-medium text-gray-800">{{ $log->user->name ?? '-' }}</td>
                                                                        <td class="py-1 pr-4 text-gray-600">{{ $log->user->email ?? '-' }}</td>
                                                                        <td class="py-1 pr-4 text-{{ $log->status === 'success' ? 'green' : 'red' }}-600">{{ ucfirst($log->status) }}</td>
                                                                        <td class="py-1 pr-4 text-gray-500">{{ $log->ip_address }}</td>
                                                                        <td class="py-1 pr-4 text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</td>
                                                                        <td class="py-1 pr-4 text-gray-400">{{ $log->note }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                @if(\App\Models\ProgramAccessLog::where('program_id', $program->id)->count() === 0)
                                                                    <tr><td colspan="6" class="py-1 text-gray-400">No access log yet.</td></tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group"
                        x-data="{
                            isActive: {{ $program->is_active ? 'true' : 'false' }},
                            toggleLoading: false,
                            async toggleActiveStatus() {
                                if (this.toggleLoading) return;
                                this.toggleLoading = true;
                                try {
                                    const res = await fetch('{{ route('programs.toggle-active', $program->id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                        },
                                    });
                                    if (res.ok) {
                                        const data = await res.json();
                                        this.isActive = !!Number(data.program.is_active);
                                    }
                                } finally {
                                    this.toggleLoading = false;
                                }
                            }
                        }"
                        x-show="activeTab === '{{ $program->delivery_mode }}' && (!searchQuery || '{{ strtolower(addslashes($program->name . ' ' . $program->description)) }}'.includes(searchQuery.toLowerCase()))">
                        <td class="p-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold shadow-sm" style="background-color: {{ $program->color ?? '#3B82F6' }}; color: white;">
                                    @if($program->icon)
                                        <i class="bi bi-{{ $program->icon }} text-lg"></i>
                                    @else
                                        {{ substr($program->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $program->name }}
                                        @if($program->delivery_mode === 'offline')
                                            <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-teal-100 text-teal-800 border border-teal-200" title="Program mode Offline">
                                                🏫 Offline
                                            </span>
                                        @else
                                            <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-sky-100 text-sky-800 border border-sky-200" title="Program mode Online">
                                                💻 Online
                                            </span>
                                        @endif
                                        @if($program->offlineSibling)
                                            <button type="button" @click="$dispatch('open-program-modal', { program: {{ Js::from($program->offlineSibling->load('discounts')) }} })" class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200" title="Buka versi Offline: {{ $program->offlineSibling->name }}">
                                                🔗 Versi Offline: {{ $program->offlineSibling->name }}
                                            </button>
                                        @elseif($program->onlineSibling)
                                            <button type="button" @click="$dispatch('open-program-modal', { program: {{ Js::from($program->onlineSibling->load('discounts')) }} })" class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200" title="Buka versi Online: {{ $program->onlineSibling->name }}">
                                                🔗 Versi Online: {{ $program->onlineSibling->name }}
                                            </button>
                                        @endif
                                        @if($program->min_cefr_level || $program->max_cefr_level)
                                            @php
                                                $cefrText = $program->min_cefr_level ?? 'A1';
                                                if ($program->max_cefr_level && $program->max_cefr_level !== $program->min_cefr_level) {
                                                    $cefrText .= ' – ' . $program->max_cefr_level;
                                                }
                                            @endphp
                                            <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-indigo-100 text-indigo-800 border border-indigo-200" title="Target Level CEFR untuk Rekomendasi AI">
                                                🎯 CEFR: {{ $cefrText }}
                                            </span>
                                        @else
                                            <span class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200" title="Level CEFR belum ditentukan">
                                                ⚠️ CEFR: Belum Diatur
                                            </span>
                                        @endif
                                        @php $activeDiscountCount = $program->discounts()->where('is_active', true)->count(); @endphp
                                        @if($isMockProgram($program))
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-50 text-pink-700 border border-pink-200">
                                                🎯 Mock Test
                                            </span>
                                        @endif
                                        @if($activeDiscountCount > 0)
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-50 text-orange-700 border border-orange-200">
                                                🏷️ {{ $activeDiscountCount }} diskon aktif
                                            </span>
                                        @endif
                                        @if($program->brochure_image || $program->brochure_pdf)
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                                📄 Brosur
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                        @if($program->price && $program->price > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-50 text-green-700 border border-green-200" title="Reguler Online Price">
                                                Reguler Online: IDR {{ number_format($program->price, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($program->price_offline && $program->price_offline > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-teal-50 text-teal-700 border border-teal-200" title="Reguler Pare Price">
                                                Reguler Pare: IDR {{ number_format($program->price_offline, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($program->price_semi_private && $program->price_semi_private > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200" title="Semi Private Online Price">
                                                Semi Online: IDR {{ number_format($program->price_semi_private, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($program->price_semi_private_offline && $program->price_semi_private_offline > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-cyan-50 text-cyan-700 border border-cyan-200" title="Semi Private Pare Price">
                                                Semi Pare: IDR {{ number_format($program->price_semi_private_offline, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($program->price_private && $program->price_private > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-violet-50 text-violet-700 border border-violet-200" title="Private Online Price">
                                                Private Online: IDR {{ number_format($program->price_private, 0, ',', '.') }}
                                            </span>
                                        @endif
                                        @if($program->price_private_offline && $program->price_private_offline > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200" title="Private Pare Price">
                                                Private Pare: IDR {{ number_format($program->price_private_offline, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $program->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 align-top">
                            @php
                                $activeBatches = collect($program->classPeriods)->whereIn('status', ['active', 'upcoming']);
                                $allBatches    = collect($program->classPeriods);
                                $batchPreviewLimit = 2;
                                $extraActiveBatchesCount = max(0, $activeBatches->count() - $batchPreviewLimit);
                            @endphp

                            @if($activeBatches->isEmpty())
                                <p class="text-xs text-gray-400 italic">Belum ada batch aktif</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $program->meetings_count }} total meetings</p>
                            @else
                                <div class="space-y-1.5" x-data="{ showAllBatches: false }">
                                    @foreach($activeBatches as $batchIndex => $batch)
                                    <div class="flex items-center gap-2"
                                         x-data="{ hovered: false }"
                                         @mouseenter="hovered = true"
                                         @mouseleave="hovered = false"
                                         @if($batchIndex >= $batchPreviewLimit) x-show="showAllBatches" x-cloak @endif>
                                        <span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1 flex-wrap">
                                                @if($batch->batch_number)
                                                    <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-1 py-0.5 rounded">B{{ $batch->batch_number }}</span>
                                                @endif
                                                <span class="text-xs font-semibold text-gray-800">{{ $batch->name }}</span>
                                                @if($batch->learning_mode)
                                                <span class="text-[10px] px-1.5 py-0.5 rounded font-medium {{ $batch->learning_mode === 'online' ? 'bg-purple-50 text-purple-700' : 'bg-orange-50 text-orange-700' }}">
                                                    {{ $batch->learning_mode === 'online' ? 'Online' : 'Offline' }}
                                                </span>
                                                @endif
                                            </div>
                                            @if($batch->start_date && $batch->end_date)
                                            <p class="text-[10px] text-gray-400 mt-0.5">
                                                {{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}
                                                · {{ $batch->users_count ?? 0 }} siswa
                                            </p>
                                            @endif
                                        </div>
                                        <button type="button"
                                            x-show="hovered"
                                            x-transition.opacity.duration.150ms
                                            @click="$dispatch('open-edit-batch-modal', { batch: {{ Js::from($batch) }} })"
                                            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit Batch">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button type="button"
                                            x-show="hovered"
                                            x-transition.opacity.duration.150ms
                                            @click="$dispatch('open-batch-calendar', { classPeriodId: {{ $batch->id }}, batchName: '{{ addslashes($batch->name) }}' })"
                                            class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="View Meetings Calendar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </button>
                                    </div>
                                    @endforeach

                                    @if($extraActiveBatchesCount > 0)
                                        <button type="button" @click="showAllBatches = !showAllBatches"
                                            class="text-[10px] font-semibold text-blue-600 hover:text-blue-800 pl-4">
                                            <span x-show="!showAllBatches">+{{ $extraActiveBatchesCount }} batch lainnya</span>
                                            <span x-show="showAllBatches" x-cloak>Sembunyikan</span>
                                        </button>
                                    @endif

                                    @if($allBatches->count() > $activeBatches->count())
                                        <p class="text-[10px] text-gray-400 pl-4">+{{ $allBatches->count() - $activeBatches->count() }} closed</p>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="p-5">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $program->active_enrollees_count }}
                            </div>
                        </td>
                        <td class="p-5">
                            <div>
                                <button type="button" @click="toggleActiveStatus()" :disabled="toggleLoading"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border transition disabled:opacity-50 disabled:cursor-wait"
                                    :class="isActive ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200'"
                                    :title="isActive ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="isActive ? 'bg-emerald-500' : 'bg-gray-400'"></span>
                                    <span x-text="isActive ? 'Active' : 'Not Active'"></span>
                                </button>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="flex justify-end items-center gap-2">
                                @if(!$isMockProgram($program))
                                    {{-- Manage Batches Button --}}
                                    <button 
                                        type="button" 
                                        x-data 
                                        @click="$dispatch('open-batch-modal', { program: {{ Js::from($program) }} })"
                                        class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors border border-transparent hover:border-emerald-100" 
                                        title="Manage Class Batches"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </button>
                                    
                                    {{-- Build Syllabus --}}
                                    <a href="{{ route('programs.syllabus', $program->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors border border-transparent hover:border-indigo-100" title="Build Syllabus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    </a>
                                @endif

                                {{-- Discount Settings --}}
                                <a href="{{ route('programs.discounts.index', $program->id) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors border border-transparent hover:border-orange-100" title="Pengaturan Diskon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M17 17h.01M7 17h.01M17 7h.01M3 3l18 18M3 3h18M3 21h18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l6 6"/></svg>
                                </a>

                                {{-- Brochure Upload --}}
                                <a href="{{ route('programs.brochure', $program->id) }}" class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors border border-transparent hover:border-purple-100" title="Upload Brosur">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                </a>
                                
                                {{-- Edit Button --}}
                                <button
                                    type="button"
                                    @click="$dispatch('open-program-modal', { program: Object.assign({{ Js::from($program->load('discounts')) }}, { is_active: isActive ? 1 : 0 }) })"
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100"
                                    title="Edit Program Settings / Price"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>

                                {{-- Dropdown for more actions (e.g. Delete) --}}
                                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                    <button @click="open = !open" type="button" class="p-2 text-gray-400 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         x-transition.opacity
                                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-10 py-1"
                                         style="display: none;">
                                        
                                        <template x-if="isActive">
                                            {{-- Step 1: Deactivate (for active programs) --}}
                                            <form method="POST" action="{{ route('programs.deactivate', $program->id) }}" onsubmit="return confirm('Deactivate program \'{{ addslashes($program->name) }}\'? It will be hidden from students. You can delete it permanently after deactivating.');">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-orange-600 hover:bg-orange-50 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                    Deactivate Program
                                                </button>
                                            </form>
                                        </template>
                                        <template x-if="!isActive">
                                            <div>
                                                {{-- Step 2: Delete Permanently (only for inactive programs) --}}
                                                <div class="px-4 py-2 border-b border-gray-100">
                                                    <p class="text-xs text-gray-400 font-medium">Program is inactive</p>
                                                </div>
                                                <form method="POST" action="{{ route('programs.destroy', $program->id) }}" onsubmit="return confirm('PERMANENTLY DELETE \'{{ addslashes($program->name) }}\'? This cannot be undone!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        Delete Permanently
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">No Programs Found</h3>
                            <p class="text-gray-500 mb-6">You haven't created any course programs yet.</p>
                            <button 
                                x-data
                                @click="$dispatch('open-program-modal')"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create First Program
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create / Edit Modal (Alpine Component) --}}
@endsection

@section('modals')
<div 
    x-data="{ 
        isOpen: false, 
        isEdit: false,
        form: {
            id: null,
            name: '',
            description: '',
            period: '',
            price: '',
            price_private: '',
            price_private_offline: '',
            price_semi_private: '',
            price_semi_private_offline: '',
            price_discount_type: '',
            price_discount_value: '',
            price_offline_discount_type: '',
            price_offline_discount_value: '',
            price_semi_private_discount_type: '',
            price_semi_private_discount_value: '',
            price_semi_private_offline_discount_type: '',
            price_semi_private_offline_discount_value: '',
            price_private_discount_type: '',
            price_private_discount_value: '',
            price_private_offline_discount_type: '',
            price_private_offline_discount_value: '',
            program_type: 'paket',
            delivery_mode: 'online',
            min_cefr_level: '',
            max_cefr_level: '',
            subprograms: [],
            access_key: '',
            is_active: true
        },
        discounts: [],
        // Live 'harga setelah diskon' preview next to a price field, using
        // whatever type/value are currently in the two sibling discount
        // inputs - purely client-side, mirrors Program::discountedPrice()
        // on the backend so what the admin sees here matches what gets saved.
        discountedPreview(priceField, typeField, valueField) {
            const base = parseInt(String(this.form[priceField] || '0').replace(/[^0-9]/g, ''), 10) || 0;
            const type = this.form[typeField];
            const value = parseInt(String(this.form[valueField] || '0').replace(/[^0-9]/g, ''), 10) || 0;
            if (base <= 0 || !type || value <= 0) {
                return null;
            }
            let discountAmount = type === 'percentage'
                ? Math.floor(base * Math.min(100, Math.max(0, value)) / 100)
                : Math.min(base, value);
            const net = Math.max(0, base - discountAmount);
            return net.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    }"
    @open-program-modal.window="
        isOpen = true;
        if($event.detail && $event.detail.program) {
            isEdit = true;
            form.id = $event.detail.program.id;
            form.name = $event.detail.program.name;
            form.description = $event.detail.program.description;
            form.period = $event.detail.program.period;
            form.price = $event.detail.program.price ? $event.detail.program.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_offline = $event.detail.program.price_offline ? $event.detail.program.price_offline.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_private = $event.detail.program.price_private ? $event.detail.program.price_private.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_private_offline = $event.detail.program.price_private_offline ? $event.detail.program.price_private_offline.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_semi_private = $event.detail.program.price_semi_private ? $event.detail.program.price_semi_private.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_semi_private_offline = $event.detail.program.price_semi_private_offline ? $event.detail.program.price_semi_private_offline.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            form.price_discount_type = $event.detail.program.price_discount_type || '';
            form.price_discount_value = $event.detail.program.price_discount_value ?? '';
            form.price_offline_discount_type = $event.detail.program.price_offline_discount_type || '';
            form.price_offline_discount_value = $event.detail.program.price_offline_discount_value ?? '';
            form.price_semi_private_discount_type = $event.detail.program.price_semi_private_discount_type || '';
            form.price_semi_private_discount_value = $event.detail.program.price_semi_private_discount_value ?? '';
            form.price_semi_private_offline_discount_type = $event.detail.program.price_semi_private_offline_discount_type || '';
            form.price_semi_private_offline_discount_value = $event.detail.program.price_semi_private_offline_discount_value ?? '';
            form.price_private_discount_type = $event.detail.program.price_private_discount_type || '';
            form.price_private_discount_value = $event.detail.program.price_private_discount_value ?? '';
            form.price_private_offline_discount_type = $event.detail.program.price_private_offline_discount_type || '';
            form.price_private_offline_discount_value = $event.detail.program.price_private_offline_discount_value ?? '';
            form.program_type = $event.detail.program.program_type || 'paket';
            form.delivery_mode = $event.detail.program.delivery_mode || 'online';
            form.min_cefr_level = $event.detail.program.min_cefr_level || '';
            form.max_cefr_level = $event.detail.program.max_cefr_level || '';
            form.subprograms = $event.detail.program.subprograms ? $event.detail.program.subprograms.map(p => p.id) : [];
            form.access_key = $event.detail.program.access_key || '';
            form.is_active = $event.detail.program.is_active == 1;
            discounts = $event.detail.program.discounts || [];
        } else {
            isEdit = false;
            form.id = null;
            form.name = '';
            form.description = '';
            form.period = '';
            form.price = '';
            form.price_offline = '';
            form.price_private = '';
            form.price_private_offline = '';
            form.price_semi_private = '';
            form.price_semi_private_offline = '';
            form.price_discount_type = '';
            form.price_discount_value = '';
            form.price_offline_discount_type = '';
            form.price_offline_discount_value = '';
            form.price_semi_private_discount_type = '';
            form.price_semi_private_discount_value = '';
            form.price_semi_private_offline_discount_type = '';
            form.price_semi_private_offline_discount_value = '';
            form.price_private_discount_type = '';
            form.price_private_discount_value = '';
            form.price_private_offline_discount_type = '';
            form.price_private_offline_discount_value = '';
            form.program_type = 'paket';
            form.delivery_mode = 'online';
            form.min_cefr_level = '';
            form.max_cefr_level = '';
            form.subprograms = [];
            form.access_key = '';
            form.is_active = true;
            discounts = [];
        }
    "
    x-show="isOpen" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div 
            x-show="isOpen" 
            x-transition.opacity 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            @click="isOpen = false"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div 
            x-show="isOpen" 
            x-transition.duration.300ms.scale.95
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full"
        >
            <div class="bg-white">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold font-serif text-gray-900" id="modal-title" x-text="isEdit ? 'Edit Program' : 'Create New Program'"></h3>
                        <p class="text-sm text-gray-500 mt-1" x-text="isEdit ? 'Update settings and details' : 'Deploy a new course product for students'"></p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>


                <!-- Form -->
                <form x-ref="programForm" :action="isEdit ? '/admin/programs/' + form.id : '{{ route('programs.store') }}'" method="POST" class="px-6 py-5 space-y-5">
                    @csrf
                    <!-- Dynamic Method Injection for PUT requests -->
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    <!-- Program Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Program Name <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.name" name="name" id="name" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., IELTS Intensive Masterclass">
                    </div>

                    <!-- Duration Tag & Tipe Program -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="period" class="block text-sm font-semibold text-gray-700 mb-1">Duration Tag <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.period" name="period" id="period" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 3 Months, 20 Meetings">
                        </div>
                        <div>
                            <label for="program_type" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Program <span class="text-red-500">*</span></label>
                            <select x-model="form.program_type" name="program_type" id="program_type" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                <option value="paket">Program Paket (IELTS/TOEFL/PTE)</option>
                                <option value="satuan">Program Satuan / Skill Khusus</option>
                            </select>
                        </div>
                        <div>
                            <label for="delivery_mode" class="block text-sm font-semibold text-gray-700 mb-1">Moda Belajar <span class="text-red-500">*</span></label>
                            <select x-model="form.delivery_mode" name="delivery_mode" id="delivery_mode" required
                                @change="if(form.delivery_mode === 'online') { form.price_offline = ''; form.price_semi_private_offline = ''; form.price_private_offline = ''; } else { form.price = ''; form.price_semi_private = ''; form.price_private = ''; }"
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                <option value="online">💻 Online</option>
                                <option value="offline">🏫 Offline (Pare)</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Program ini punya kurikulum sendiri untuk moda yang dipilih.</p>
                        </div>
                    </div>

                    <!-- Level CEFR (Saran AI Tes Kompetensi) -->
                    <div class="space-y-2 pt-1 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-semibold text-gray-700">
                                Target Level CEFR Kelas <span class="text-gray-400 font-normal">(Untuk Rekomendasi AI)</span>
                            </label>
                            <template x-if="form.min_cefr_level || form.max_cefr_level">
                                <span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-md">
                                    Range: <span x-text="form.min_cefr_level || 'A1'"></span> – <span x-text="form.max_cefr_level || form.min_cefr_level || 'C2'"></span>
                                </span>
                            </template>
                        </div>

                        <!-- Quick Range Buttons -->
                        <div class="flex flex-wrap items-center gap-1.5 p-2 bg-gray-50 rounded-xl border border-gray-200">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mr-1">Pilih Range:</span>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'A1'; form.max_cefr_level = 'A2'" 
                                    :class="(form.min_cefr_level === 'A1' && form.max_cefr_level === 'A2') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                A1 – A2 (Dasar)
                            </button>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'B1'; form.max_cefr_level = 'B1'" 
                                    :class="(form.min_cefr_level === 'B1' && form.max_cefr_level === 'B1') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                B1 (Fast Track)
                            </button>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'B1'; form.max_cefr_level = 'B2'" 
                                    :class="(form.min_cefr_level === 'B1' && form.max_cefr_level === 'B2') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                B1 – B2 (Menengah)
                            </button>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'B2'; form.max_cefr_level = 'B2'" 
                                    :class="(form.min_cefr_level === 'B2' && form.max_cefr_level === 'B2') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                B2 (Complexity)
                            </button>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'C1'; form.max_cefr_level = 'C2'" 
                                    :class="(form.min_cefr_level === 'C1' && form.max_cefr_level === 'C2') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                C1 – C2 (Mahir)
                            </button>
                            <button type="button" 
                                    @click="form.min_cefr_level = 'A1'; form.max_cefr_level = 'C2'" 
                                    :class="(form.min_cefr_level === 'A1' && form.max_cefr_level === 'C2') ? 'bg-blue-600 text-white font-bold shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 font-medium'"
                                    class="px-2.5 py-1 rounded-lg text-xs transition cursor-pointer">
                                A1 – C2 (Semua)
                            </button>
                        </div>

                        <!-- Dual Min & Max Dropdown -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <div>
                                <label for="min_cefr_level" class="block text-xs font-semibold text-gray-600 mb-1">
                                    Min CEFR Level
                                </label>
                                <select x-model="form.min_cefr_level" name="min_cefr_level" id="min_cefr_level" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                    <option value="">— Tidak Dibatasi —</option>
                                    @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                                        <option value="{{ $lvl }}">Level {{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="max_cefr_level" class="block text-xs font-semibold text-gray-600 mb-1">
                                    Max CEFR Level
                                </label>
                                <select x-model="form.max_cefr_level" name="max_cefr_level" id="max_cefr_level" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                    <option value="">— Tidak Dibatasi —</option>
                                    @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                                        <option value="{{ $lvl }}">Level {{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Each program row is only ever online OR offline (see the Moda Belajar
                         select above) - showing both price columns regardless of that mode
                         just invited filling in a price for a delivery mode this program
                         doesn't even offer. Only the input matching form.delivery_mode is
                         shown; the other's value is cleared by the @change handler on that
                         select above whenever an admin actively switches modes.

                         Each price now has its own inline discount (fixed IDR or %) right
                         next to it - separate from the audience-based "Diskon Program" list
                         further down. This one actually reduces what a student pays at
                         checkout for that exact price field (see Program::discountedPrice()
                         and its use in InitiatePayment/BuildStudentPaymentIndexData). --}}

                    <!-- Regular Price -->
                    <div class="grid grid-cols-1 gap-4 pt-2 border-t border-gray-100">
                        <div x-show="form.delivery_mode === 'online'">
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Regular Online Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price" @input="form.price = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price" id="price" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 5.000.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_discount_type" name="price_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_discount_value" @input="form.price_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price', 'price_discount_type', 'price_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price', 'price_discount_type', 'price_discount_value')"></span></span></p>
                            </template>
                        </div>
                        <div x-show="form.delivery_mode === 'offline'">
                            <label for="price_offline" class="block text-sm font-semibold text-gray-700 mb-1">Regular Offline / Pare Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price_offline" @input="form.price_offline = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price_offline" id="price_offline" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 5.500.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_offline_discount_type" name="price_offline_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_offline_discount_value" @input="form.price_offline_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_offline_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price_offline', 'price_offline_discount_type', 'price_offline_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price_offline', 'price_offline_discount_type', 'price_offline_discount_value')"></span></span></p>
                            </template>
                        </div>
                    </div>

                    <!-- Semi Private Price -->
                    <div class="grid grid-cols-1 gap-4 pt-2 border-t border-gray-100">
                        <div x-show="form.delivery_mode === 'online'">
                            <label for="price_semi_private" class="block text-sm font-semibold text-gray-700 mb-1">Semi Private Online Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price_semi_private" @input="form.price_semi_private = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price_semi_private" id="price_semi_private" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 8.000.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_semi_private_discount_type" name="price_semi_private_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_semi_private_discount_value" @input="form.price_semi_private_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_semi_private_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price_semi_private', 'price_semi_private_discount_type', 'price_semi_private_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price_semi_private', 'price_semi_private_discount_type', 'price_semi_private_discount_value')"></span></span></p>
                            </template>
                        </div>
                        <div x-show="form.delivery_mode === 'offline'">
                            <label for="price_semi_private_offline" class="block text-sm font-semibold text-gray-700 mb-1">Semi Private Offline Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price_semi_private_offline" @input="form.price_semi_private_offline = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price_semi_private_offline" id="price_semi_private_offline" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 8.500.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_semi_private_offline_discount_type" name="price_semi_private_offline_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_semi_private_offline_discount_value" @input="form.price_semi_private_offline_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_semi_private_offline_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price_semi_private_offline', 'price_semi_private_offline_discount_type', 'price_semi_private_offline_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price_semi_private_offline', 'price_semi_private_offline_discount_type', 'price_semi_private_offline_discount_value')"></span></span></p>
                            </template>
                        </div>
                    </div>

                    <!-- Private Price -->
                    <div class="grid grid-cols-1 gap-4 pt-2 border-t border-gray-100">
                        <div x-show="form.delivery_mode === 'online'">
                            <label for="price_private" class="block text-sm font-semibold text-gray-700 mb-1">Private Online Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price_private" @input="form.price_private = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price_private" id="price_private" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 12.000.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_private_discount_type" name="price_private_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_private_discount_value" @input="form.price_private_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_private_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price_private', 'price_private_discount_type', 'price_private_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price_private', 'price_private_discount_type', 'price_private_discount_value')"></span></span></p>
                            </template>
                        </div>
                        <div x-show="form.delivery_mode === 'offline'">
                            <label for="price_private_offline" class="block text-sm font-semibold text-gray-700 mb-1">Private Offline Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" inputmode="numeric" x-model="form.price_private_offline" @input="form.price_private_offline = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" name="price_private_offline" id="price_private_offline" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 12.500.000">
                                <div class="flex gap-2 sm:w-48 shrink-0">
                                    <select x-model="form.price_private_offline_discount_type" name="price_private_offline_discount_type" class="block w-20 border border-gray-300 rounded-xl px-2 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="">Diskon</option>
                                        <option value="percentage">%</option>
                                        <option value="fixed_idr">Rp</option>
                                    </select>
                                    <input type="text" inputmode="numeric" x-model="form.price_private_offline_discount_value" @input="form.price_private_offline_discount_value = $event.target.value.replace(/[^0-9]/g, '')" name="price_private_offline_discount_value" class="block flex-1 min-w-0 border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="0">
                                </div>
                            </div>
                            <template x-if="discountedPreview('price_private_offline', 'price_private_offline_discount_type', 'price_private_offline_discount_value')">
                                <p class="text-xs text-emerald-600 mt-1">Harga setelah diskon: <span class="font-semibold">Rp <span x-text="discountedPreview('price_private_offline', 'price_private_offline_discount_type', 'price_private_offline_discount_value')"></span></span></p>
                            </template>
                        </div>
                    </div>

                    <!-- Access Key -->
                    <div class="pt-2 border-t border-gray-100">
                        <label for="access_key" class="block text-sm font-semibold text-gray-700 mb-1">Access Key <span class="text-gray-400 font-normal">(Optional, can be changed anytime)</span></label>
                        <input type="text" x-model="form.access_key" name="access_key" id="access_key" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., secret2026">
                        <span class="text-xs text-gray-400 mt-0.5 block">Kosongkan jika program ini tidak memerlukan kunci akses khusus.</span>
                    </div>

                    <!-- Discounts -->
                    <div class="pt-2 border-t border-gray-100" x-show="isEdit" x-cloak
                        x-data="{
                            showAddForm: false,
                            saving: false,
                            error: '',
                            newDiscount: { type: 'guest', label: '', discount_type: 'percentage', discount_value: '', start_date: '', end_date: '', regions: '', is_active: true },
                            typeLabels: { guest: '👤 Guest', new_user: '🆕 New User', student: '🎓 Student', referral: '🤝 Referral Teman', holiday: '🎉 Hari Libur', region: '📍 Daerah Khusus' },
                            formattedValue(d) {
                                return d.discount_type === 'percentage'
                                    ? d.discount_value + '%'
                                    : 'Rp ' + Number(d.discount_value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            },
                            resetNewDiscount() {
                                this.newDiscount = { type: 'guest', label: '', discount_type: 'percentage', discount_value: '', start_date: '', end_date: '', regions: '', is_active: true };
                                this.error = '';
                            },
                            async addDiscount() {
                                this.saving = true;
                                this.error = '';
                                try {
                                    const body = new FormData();
                                    body.append('type', this.newDiscount.type);
                                    body.append('label', this.newDiscount.label);
                                    body.append('discount_type', this.newDiscount.discount_type);
                                    body.append('discount_value', this.newDiscount.discount_value);
                                    if (this.newDiscount.start_date) body.append('start_date', this.newDiscount.start_date);
                                    if (this.newDiscount.end_date) body.append('end_date', this.newDiscount.end_date);
                                    if (this.newDiscount.regions) body.append('regions', this.newDiscount.regions);
                                    if (this.newDiscount.is_active) body.append('is_active', '1');
                                    const res = await fetch(`/admin/programs/${form.id}/discounts`, {
                                        method: 'POST',
                                        body,
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content
                                        }
                                    });
                                    if (res.status === 422) {
                                        const data = await res.json();
                                        this.error = Object.values(data.errors || {}).flat().join(' ') || 'Data diskon tidak valid.';
                                        return;
                                    }
                                    if (!res.ok) { this.error = 'Gagal menyimpan diskon.'; return; }
                                    const data = await res.json();
                                    discounts.push(data.discount);
                                    this.resetNewDiscount();
                                    this.showAddForm = false;
                                } catch (e) {
                                    this.error = 'Terjadi kesalahan jaringan.';
                                } finally {
                                    this.saving = false;
                                }
                            },
                            async toggleDiscount(d) {
                                const body = new FormData();
                                body.append('_method', 'PUT');
                                body.append('toggle_active', '1');
                                const res = await fetch(`/admin/programs/${form.id}/discounts/${d.id}`, {
                                    method: 'POST',
                                    body,
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content
                                    }
                                });
                                if (res.ok) {
                                    const data = await res.json();
                                    d.is_active = data.discount.is_active;
                                }
                            },
                            async deleteDiscount(d) {
                                if (!confirm('Hapus diskon \'' + d.label + '\'?')) return;
                                const body = new FormData();
                                body.append('_method', 'DELETE');
                                const res = await fetch(`/admin/programs/${form.id}/discounts/${d.id}`, {
                                    method: 'POST',
                                    body,
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content
                                    }
                                });
                                if (res.ok) {
                                    discounts.splice(discounts.indexOf(d), 1);
                                }
                            }
                        }">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-semibold text-gray-700">🏷️ Diskon Program</label>
                            <button type="button" @click="showAddForm = !showAddForm; if (!showAddForm) resetNewDiscount()" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                <span x-show="!showAddForm">+ Tambah Diskon</span>
                                <span x-show="showAddForm" x-cloak>Batal</span>
                            </button>
                        </div>

                        <!-- Existing discounts list -->
                        <template x-if="discounts.length === 0">
                            <p class="text-xs text-gray-400 italic bg-gray-50 rounded-lg px-3 py-2">Belum ada diskon untuk program ini.</p>
                        </template>
                        <div class="space-y-1.5" x-show="discounts.length > 0">
                            <template x-for="d in discounts" :key="d.id">
                                <div class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200" :class="d.is_active ? 'bg-white' : 'bg-gray-50 opacity-60'">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-gray-100 text-gray-600" x-text="typeLabels[d.type] || d.type"></span>
                                            <span class="text-xs font-semibold text-gray-800" x-text="d.label"></span>
                                            <span class="text-xs font-bold text-orange-600" x-text="formattedValue(d)"></span>
                                        </div>
                                    </div>
                                    <button type="button" @click="toggleDiscount(d)" class="relative inline-flex items-center shrink-0" :title="d.is_active ? 'Nonaktifkan' : 'Aktifkan'">
                                        <div class="w-8 h-4.5 rounded-full transition-colors" :class="d.is_active ? 'bg-emerald-500' : 'bg-gray-300'"></div>
                                        <div class="absolute w-3.5 h-3.5 bg-white rounded-full shadow transition-all m-0.5" :class="d.is_active ? 'left-3.5' : 'left-0'"></div>
                                    </button>
                                    <button type="button" @click="deleteDiscount(d)" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Add discount form -->
                        <div x-show="showAddForm" x-cloak class="mt-3 p-3 bg-orange-50/50 rounded-xl border border-orange-100 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe</label>
                                    <select x-model="newDiscount.type" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400 bg-white">
                                        <option value="guest">👤 Guest</option>
                                        <option value="new_user">🆕 New User</option>
                                        <option value="student">🎓 Student</option>
                                        <option value="referral">🤝 Referral Teman</option>
                                        <option value="holiday">🎉 Hari Libur Khusus</option>
                                        <option value="region">📍 Daerah Khusus</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Label</label>
                                    <input type="text" x-model="newDiscount.label" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400" placeholder="e.g., Diskon Lebaran">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis</label>
                                    <select x-model="newDiscount.discount_type" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400 bg-white">
                                        <option value="percentage">% Persentase</option>
                                        <option value="fixed_idr">Rp Nominal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nilai</label>
                                    <input type="number" min="1" x-model="newDiscount.discount_value" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400" placeholder="e.g., 20">
                                </div>
                            </div>
                            <div x-show="newDiscount.type === 'holiday'" x-cloak class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mulai</label>
                                    <input type="date" x-model="newDiscount.start_date" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Selesai</label>
                                    <input type="date" x-model="newDiscount.end_date" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                                </div>
                            </div>
                            <div x-show="newDiscount.type === 'region'" x-cloak>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Daerah (pisahkan koma)</label>
                                <input type="text" x-model="newDiscount.regions" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400" placeholder="e.g., Jakarta, Bandung">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 text-xs font-medium text-gray-600">
                                    <input type="checkbox" x-model="newDiscount.is_active" class="w-3.5 h-3.5 text-orange-600 border-gray-300 rounded focus:ring-orange-400">
                                    Aktifkan sekarang
                                </label>
                            </div>
                            <p x-show="error" x-cloak class="text-xs text-red-600" x-text="error"></p>
                            <button type="button" @click="addDiscount()" :disabled="saving || !newDiscount.label || !newDiscount.discount_value"
                                class="w-full py-2 bg-orange-500 hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-lg transition-colors">
                                <span x-show="!saving">Simpan Diskon</span>
                                <span x-show="saving" x-cloak>Menyimpan...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Subprograms for Paket -->
                    <div x-show="form.program_type === 'paket'" class="pt-2 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Program Satuan Penyusun Paket <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        
                        @if(isset($satuanPrograms) && $satuanPrograms->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-1 mb-3">
                                @foreach($satuanPrograms as $sat)
                                    <label class="flex items-start p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors" :class="{'bg-blue-50 border-blue-200': form.subprograms.includes({{ $sat->id }})}">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="subprograms[]" value="{{ $sat->id }}" x-model="form.subprograms" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="font-medium text-gray-900">{{ $sat->name }}</span>
                                            <div class="text-gray-500 text-xs mt-0.5">IDR {{ number_format($sat->price ?? 0, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Total Harga Satuan:</span>
                                    <span class="font-bold text-gray-900" x-text="
                                        'IDR ' + form.subprograms.reduce((total, id) => {
                                            const prog = {{ Js::from($satuanPrograms->mapWithKeys(fn($p) => [$p->id => $p->price ?? 0])) }}[id] || 0;
                                            return total + prog;
                                        }, 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
                                    "></span>
                                </div>
                                <div class="flex justify-between items-center text-sm mt-2 border-t border-blue-100 pt-2">
                                    <span class="text-blue-800 font-medium">Diskon (Penghematan):</span>
                                    <span class="font-bold text-green-600" x-text="
                                        (() => {
                                            const totalSatuan = form.subprograms.reduce((total, id) => {
                                                return total + ({{ Js::from($satuanPrograms->mapWithKeys(fn($p) => [$p->id => $p->price ?? 0])) }}[id] || 0);
                                            }, 0);
                                            const hargaPaket = parseInt(form.price.replace(/\./g, '') || 0);
                                            const diff = totalSatuan - hargaPaket;
                                            return diff > 0 ? 'IDR ' + diff.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : 'IDR 0';
                                        })()
                                    "></span>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 bg-gray-50 p-4 rounded-xl">Belum ada program satuan yang dibuat.</p>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="pt-2 border-t border-gray-100">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                        <textarea x-model="form.description" name="description" id="description" rows="3" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 resize-none h-24 placeholder:text-gray-400" placeholder="Enter a brief summary of what this program covers and who it is for..."></textarea>
                    </div>

                    <!-- Program Status -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Program Status</h4>
                            <p class="text-xs text-gray-500">Enable this to allow students to see and enroll in this program.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" :checked="form.is_active" @change="form.is_active = $event.target.checked">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700" x-text="form.is_active ? 'Active' : 'Draft'"></span>
                        </label>
                    </div>

                    <!-- Modal Actions -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 -mx-6 -mb-5 rounded-b-2xl">
                        <button type="button" @click="isOpen = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 border border-transparent text-white rounded-xl font-medium hover:bg-blue-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Manage Batches Modal (Alpine Component) --}}
<div 
    x-data="{ 
        isOpen: false, 
        program: null,
        form: {
            name: '',
            start_date: '',
            end_date: '',
            status: 'active',
            batch_type: 'regular'
        },
        initCalendar() {
            // No-op: using native date inputs
        }
    }"
    @open-batch-modal.window="
        isOpen = true;
        program = $event.detail.program;
        form = { name: '', start_date: '', end_date: '', status: 'active', batch_type: 'regular', learning_mode: 'online' };
    "
    x-show="isOpen" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div 
            x-show="isOpen" 
            x-transition.opacity 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            @click="isOpen = false"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div 
            x-show="isOpen" 
            x-transition.duration.300ms.scale.95
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
        >
            <div class="bg-white">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-bold font-serif text-gray-900" x-text="'Batches: ' + (program ? program.name : '')"></h3>
                        <p class="text-sm text-gray-500 mt-1">Manage schedules or deploy a new timeline.</p>
                    </div>
                </div>
                
                <div class="px-6 py-5">
                    <!-- Current Batches List -->
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Existing Batches</h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="batch in program?.class_periods" :key="batch.id">
                                <div class="flex justify-between items-center p-3 bg-white border border-gray-200 rounded-xl hover:shadow-sm transition-shadow">
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center bg-gray-100 text-gray-800 rounded px-1.5 py-0.5 text-[10px] font-bold mr-1" x-show="batch.batch_number" x-text="'Batch ' + batch.batch_number"></span>
                                            <span x-text="batch.name"></span>
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-purple-100 text-purple-700 border border-purple-200" x-show="batch.batch_type === 'private'">Private</span>
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-gray-100 text-gray-700 border border-gray-200" x-show="batch.batch_type === 'regular'">Regular</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 font-medium" x-text="batch.start_date.substring(0,10) + ' to ' + batch.end_date.substring(0,10)"></div>
                                    </div>
                                    <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-bold rounded-md" 
                                        :class="{
                                            'bg-emerald-50 text-emerald-700 border border-emerald-200': batch.status === 'active',
                                            'bg-blue-50 text-blue-700 border border-blue-200': batch.status === 'upcoming',
                                            'bg-gray-100 text-gray-600 border border-gray-200': batch.status === 'closed'
                                        }" 
                                        x-text="batch.status"></span>
                                </div>
                            </template>
                            <template x-if="!program?.class_periods || program?.class_periods.length === 0">
                                <div class="text-sm text-gray-500 italic p-4 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    No batches exist for this program yet.
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Create New Batch Form -->
                    <form action="{{ route('class-periods.store') }}" method="POST" class="border-t border-gray-100 pt-5 space-y-4">
                        @csrf
                        <input type="hidden" name="program_id" :value="program?.id">
                        
                        <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Deploy New Batch</h4>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Batch Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900" placeholder="e.g., Intensive Sept 2024">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                 <label class="block text-sm font-semibold text-gray-700 mb-1">Batch Type</label>
                                 <select name="batch_type" x-model="form.batch_type" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700">
                                     <option value="regular">Regular (Group Class)</option>
                                     <option value="private">Private Class</option>
                                 </select>
                            </div>
                            <div>
                                 <label class="block text-sm font-semibold text-gray-700 mb-1">Learning Mode <span class="text-red-500">*</span></label>
                                 <select name="learning_mode" x-model="form.learning_mode" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700">
                                     <option value="online">Online (Zoom/Meet)</option>
                                     <option value="offline">Offline (Tatap Muka)</option>
                                 </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" x-model="form.start_date" required
                                       class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">End Date <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" x-model="form.end_date" required
                                       :min="form.start_date"
                                       class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900">
                            </div>
                        </div>

                        <div>
                             <label class="block text-sm font-semibold text-gray-700 mb-1">Initial Status</label>
                             <select name="status" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 text-gray-700">
                                 <option value="upcoming">Upcoming (Pre-enrollment)</option>
                                 <option value="active" selected>Active (Ongoing)</option>
                             </select>
                        </div>

                        <!-- Buttons are pinned to bottom -->
                        <div class="mt-8 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="isOpen = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                                Close
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-gray-900 border border-transparent text-white rounded-xl font-medium hover:bg-black transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Deploy Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.meetings-calendar-modal')

{{-- Edit Batch Modal --}}
<div
    x-data="{
        isOpen: false,
        batch: null,
        init() {
            window.addEventListener('open-edit-batch-modal', (e) => {
                this.batch = e.detail.batch;
                this.isOpen = true;
            });
        }
    }"
    x-show="isOpen"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display:none;"
    role="dialog" aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="isOpen = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div x-show="isOpen" x-transition.duration.300ms.scale.95
             class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Edit Batch</h3>
                    <p class="text-sm text-gray-500 mt-0.5" x-text="batch?.name"></p>
                </div>
                <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <template x-if="batch">
                <form :action="'/admin/class-periods/' + batch.id" method="POST" class="px-6 py-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="program_id" :value="batch.program_id">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Batch</label>
                        <input type="text" name="name" :value="batch.name" required
                               class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Batch Type</label>
                            <select name="batch_type" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="regular" :selected="batch.batch_type === 'regular'">Regular (Group)</option>
                                <option value="private" :selected="batch.batch_type === 'private'">Private Class</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Learning Mode</label>
                            <select name="learning_mode" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="online" :selected="batch.learning_mode === 'online'">Online (Zoom/Meet)</option>
                                <option value="offline" :selected="batch.learning_mode === 'offline'">Offline (Tatap Muka)</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date</label>
                            <input type="date" name="start_date" :value="batch.start_date ? batch.start_date.substring(0,10) : ''" required
                                   class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                            <input type="date" name="end_date" :value="batch.end_date ? batch.end_date.substring(0,10) : ''" required
                                   class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="upcoming" :selected="batch.status === 'upcoming'">Upcoming (Pre-enrollment)</option>
                            <option value="active" :selected="batch.status === 'active'">Active (Ongoing)</option>
                            <option value="closed" :selected="batch.status === 'closed'">Closed</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div>
                            <button type="button" @click="if(confirm('Apakah Anda yakin ingin menghapus batch ini secara permanen? Data presensi dan pertemuan kelas juga akan terhapus jika ada.')) { $refs.deleteForm.submit() }"
                                    class="px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-xl font-medium transition-colors">
                                Hapus Batch
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="isOpen = false"
                                    class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium">Batal</button>
                            <button type="submit"
                                    class="px-5 py-2 text-sm bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold shadow-sm">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
                
                <form x-ref="deleteForm" :action="'/admin/class-periods/' + batch.id" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </template>
        </div>
    </div>
</div>
@endsection
