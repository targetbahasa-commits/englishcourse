<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $classPeriod->name }} - Meeting {{ $meetingNumber }} Speaking</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F8FAFC]" x-data="speakingPracticeApp()">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <div class="max-w-5xl mx-auto space-y-6">

                <!-- Topbar -->
                <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">
                    <div class="relative w-full md:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="w-full py-2.5 pl-9 pr-4 bg-white rounded-full text-xs md:text-sm border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Cari...">
                    </div>
                    <div class="flex items-center gap-4">
                        @include('components.topbar-action-icons')
                        <div class="flex items-center gap-2.5">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <div class="w-8 h-8 bg-blue-100 text-blue-700 font-bold rounded-full flex items-center justify-center text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('assignments.custom-class') }}" class="hover:text-blue-600 transition">Kelas Custom</a>
                    <span>/</span>
                    <a href="{{ route('assignments.custom-class.show', $classPeriod->id) }}" class="hover:text-blue-600 transition truncate max-w-[160px]">{{ $classPeriod->name }}</a>
                    <span>/</span>
                    <a href="{{ route('assignments.custom-class.meeting.show', [$classPeriod->id, $meetingNumber]) }}" class="hover:text-blue-600 transition">Meeting {{ $meetingNumber }}</a>
                    <span>/</span>
                    <span class="text-gray-900 font-bold">Speaking Practice</span>
                </div>

                <!-- Clean Compact Header -->
                <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-200/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 text-[11px] font-extrabold uppercase bg-blue-100 text-blue-800 rounded-md">Meeting {{ $meetingNumber }} &bull; Sesi 2</span>
                            <span class="text-xs font-semibold text-gray-500">{{ $classPeriod->name }}</span>
                        </div>
                        <h1 class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-tight">
                            {{ $speakingData['title'] }}
                        </h1>
                        <p class="text-xs md:text-sm text-gray-600">
                            {{ $speakingData['subtitle'] ?? 'Tema Fokus: Kecerdasan Buatan & Otomatisasi Alur Kerja' }}
                        </p>
                    </div>

                    <!-- Action Controls -->
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Toggle Tips Modal / Drawer -->
                        <button type="button" @click="showTipsModal = true"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition border border-gray-200">
                            <span>💡</span>
                            <span class="hidden sm:inline">Tips &amp; Signposting</span>
                            <span class="sm:hidden">Tips</span>
                        </button>

                        @php
                            $zoomUrl = $meeting->effective_meeting_link ?: $classPeriod->zoom_link;
                        @endphp
                        @if($zoomUrl)
                            <a href="{{ $zoomUrl }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Zoom
                            </a>
                        @endif

                        <a href="{{ route('assignments.custom-class.meeting.show', [$classPeriod->id, $meeting->meeting_number]) }}"
                           class="inline-flex items-center gap-1 px-3.5 py-2 bg-gray-700 hover:bg-gray-800 text-white font-bold text-xs rounded-xl transition shadow-sm">
                            &larr; <span class="hidden sm:inline">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- CLEAN SEGMENTED PILL NAVIGATION (4 MODUL INTI) -->
                <div class="bg-white p-1.5 rounded-2xl border border-gray-200 shadow-sm flex flex-wrap sm:flex-nowrap gap-1.5">
                    <button type="button" @click="activeTab = 'translation'; showAll = false"
                            class="flex-1 py-2.5 px-3 text-xs md:text-sm font-bold rounded-xl transition text-center flex items-center justify-center gap-2"
                            :class="activeTab === 'translation' && !showAll ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-black"
                              :class="activeTab === 'translation' && !showAll ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">1</span>
                        <span>Translate (20)</span>
                    </button>

                    <button type="button" @click="activeTab = 'qa20'; showAll = false"
                            class="flex-1 py-2.5 px-3 text-xs md:text-sm font-bold rounded-xl transition text-center flex items-center justify-center gap-2"
                            :class="activeTab === 'qa20' && !showAll ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-black"
                              :class="activeTab === 'qa20' && !showAll ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">2</span>
                        <span>Tanya Jawab (20)</span>
                    </button>

                    <button type="button" @click="activeTab = 'qa10'; showAll = false"
                            class="flex-1 py-2.5 px-3 text-xs md:text-sm font-bold rounded-xl transition text-center flex items-center justify-center gap-2"
                            :class="activeTab === 'qa10' && !showAll ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-black"
                              :class="activeTab === 'qa10' && !showAll ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">3</span>
                        <span>Diskusi Kasus (10)</span>
                    </button>

                    <button type="button" @click="activeTab = 'monologue'; showAll = false"
                            class="flex-1 py-2.5 px-3 text-xs md:text-sm font-bold rounded-xl transition text-center flex items-center justify-center gap-2 cursor-pointer"
                            :class="activeTab === 'monologue' && !showAll ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-black"
                              :class="activeTab === 'monologue' && !showAll ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">4</span>
                        <span>Presentasi</span>
                    </button>

                    <button type="button" @click="activeTab = 'aiInterview'; showAll = false"
                            class="flex-1 py-2.5 px-3 text-xs md:text-sm font-bold rounded-xl transition text-center flex items-center justify-center gap-2 cursor-pointer"
                            :class="activeTab === 'aiInterview' && !showAll ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-black"
                              :class="activeTab === 'aiInterview' && !showAll ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">5</span>
                        <span>AI Interview</span>
                    </button>
                </div>


                <!-- ========================================================================= -->
                <!-- 1. TRANSLATE 20 KALIMAT BAHASA INDONESIA KE BAHASA INGGRIS -->
                <!-- ========================================================================= -->
                <div x-show="activeTab === 'translation' || showAll" class="space-y-4" x-cloak>
                    <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 gap-3 flex-wrap sm:flex-nowrap">
                            <div>
                                <h2 class="text-base md:text-lg font-bold text-gray-900">1. Translate 20 Kalimat (Indonesia &rarr; Inggris)</h2>
                                <p class="text-xs text-gray-600">Latihan terjemahan terbagi dalam 10 kalimat topik General (aktivitas sehari-hari) &amp; 10 kalimat Environmental Science (sains lingkungan) menggunakan pola Aktif, Pasif, dan Nominal.</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click="toggleAllVocabs()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 transition text-amber-900 shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <span>💡</span>
                                    <span x-text="showAllVocabs ? 'Tutup Semua Kosa Kata' : 'Buka Semua Kosa Kata'"></span>
                                </button>
                                <button type="button" @click="toggleAllTranslations()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-800 shadow-xs cursor-pointer">
                                    <span x-text="showAllTranslations ? 'Tutup Kunci' : 'Buka Semua Kunci'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- 20 Translation Items -->
                        <div class="space-y-3">
                            @foreach($speakingData['translations'] as $tIndex => $tItem)
                                @if($tIndex === 0)
                                    <div class="flex items-center gap-2 pt-1 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-blue-100 text-blue-900 border border-blue-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                            BAGIAN A: 10 KALIMAT GENERAL (KEHIDUPAN SEHARI-HARI)
                                        </span>
                                        <div class="h-px bg-blue-200 flex-1"></div>
                                    </div>
                                @endif
                                @if($tIndex === 10)
                                    <div class="flex items-center gap-2 pt-4 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            BAGIAN B: 10 KALIMAT ENVIRONMENTAL SCIENCE (SAINS LINGKUNGAN)
                                        </span>
                                        <div class="h-px bg-emerald-200 flex-1"></div>
                                    </div>
                                @endif

                                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50 transition space-y-3 shadow-sm"
                                     style="background-color: #ebf5ff; border: 1px solid #bfdbfe;"
                                     x-data="{ openAns: false, showVocab: false }">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <span class="w-6 h-6 rounded-md {{ ($tItem['section'] ?? '') === 'environmental' ? 'bg-emerald-600' : 'bg-blue-600' }} text-white font-extrabold text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                                {{ $tItem['num'] }}
                                            </span>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                    @if(!empty($tItem['category']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold border {{ ($tItem['category'] === 'Environmental Science' || ($tItem['section'] ?? '') === 'environmental') ? 'bg-emerald-50 text-emerald-900 border-emerald-300' : 'bg-white text-blue-900 border-blue-200 shadow-xs' }}">
                                                            {{ $tItem['category'] }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($tItem['sub_category']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-emerald-100/70 text-emerald-800 border border-emerald-200 shadow-2xs">
                                                            {{ $tItem['sub_category'] }}
                                                        </span>
                                                    @endif
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-semibold bg-amber-50 text-amber-900 border border-amber-300 shadow-xs">
                                                        {{ $tItem['grammar_point'] }}
                                                    </span>
                                                </div>
                                                <p class="text-sm md:text-[15px] font-semibold text-gray-900 leading-snug">
                                                    {{ $tItem['id_text'] }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @if(!empty($tItem['vocab_hint']))
                                                <button type="button" @click="showVocab = !showVocab"
                                                        class="px-2.5 py-1 text-xs font-bold rounded-lg transition border flex items-center gap-1 shadow-xs cursor-pointer"
                                                        :class="(showVocab || showAllVocabs) ? 'bg-amber-500 text-white border-amber-600 shadow-xs' : 'bg-white border-amber-300 text-amber-900 hover:bg-amber-50 shadow-xs'">
                                                    <span>💡</span>
                                                    <span x-text="(showVocab || showAllVocabs) ? 'Tutup Kosa Kata' : 'Kosa Kata'"></span>
                                                </button>
                                            @endif
                                            <button type="button" @click="openAns = !openAns"
                                                    class="px-2.5 py-1 text-xs font-bold rounded-lg transition shrink-0 cursor-pointer"
                                                    :class="(openAns || showAllTranslations) ? 'bg-blue-600 text-white shadow-xs' : 'bg-white border border-blue-200 text-blue-900 hover:bg-white/80 shadow-xs'">
                                                <span x-text="(openAns || showAllTranslations) ? 'Tutup Kunci' : 'Lihat Terjemahan'"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- VOCABULARY ASSISTANCE BOX (BISA DI-HIDE / DI-TOGGLE) -->
                                    @if(!empty($tItem['vocab_hint']))
                                        <div x-show="showVocab || showAllVocabs" x-cloak
                                             class="p-3 rounded-xl bg-amber-50/90 border border-amber-300 shadow-2xs space-y-1.5">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                                    <span>💡</span> Kosa Kata Bantuan (Vocabulary Clues):
                                                </span>
                                                <button type="button" @click="showVocab = false"
                                                        class="text-[10px] font-bold text-amber-800 hover:text-amber-950 underline cursor-pointer">
                                                    Sembunyikan
                                                </button>
                                            </div>
                                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                                @php
                                                    $hints = array_map('trim', explode(',', $tItem['vocab_hint']));
                                                @endphp
                                                @foreach($hints as $h)
                                                    @if(str_contains($h, ':'))
                                                        @php
                                                            [$idWord, $enWord] = array_map('trim', explode(':', $h, 2));
                                                        @endphp
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-xs shadow-2xs">
                                                            <span class="text-gray-600 font-normal">{{ $idWord }}:</span>
                                                            <span class="font-bold text-amber-950">{{ $enWord }}</span>
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-950 font-bold text-xs shadow-2xs">
                                                            {{ $h }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Reveal English Target -->
                                    <div x-show="openAns || showAllTranslations" x-cloak class="p-3.5 rounded-xl bg-white border border-emerald-300 shadow-xs flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-900 uppercase tracking-wider">Kunci Terjemahan:</span>
                                            <p class="text-sm md:text-[15px] font-bold text-emerald-950 font-serif leading-relaxed">
                                                &ldquo;{{ $tItem['en_text'] }}&rdquo;
                                            </p>
                                        </div>
                                        <button type="button" @click="speakText('{{ addslashes($tItem['en_text']) }}')"
                                                class="p-1.5 text-emerald-800 hover:bg-emerald-100 rounded-lg transition shrink-0 cursor-pointer"
                                                title="Dengarkan pengucapan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- ========================================================================= -->
                <!-- 2. 20 PERTANYAAN SESI INTERVIEW (TUTOR DENGAN TEACHER) -->
                <!-- ========================================================================= -->
                <div x-show="activeTab === 'qa20' || showAll" class="space-y-4" x-cloak>
                    <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 gap-3 flex-wrap sm:flex-nowrap">
                            <div>
                                <h2 class="text-base md:text-lg font-bold text-gray-900">2. Sesi Interview: 20 Pertanyaan Komprehensif (Tutor &amp; Teacher)</h2>
                                <p class="text-xs text-gray-600">Terdiri dari 5 Pertanyaan Pribadi (A2/B1), 5 Opini Isu Sosial (B1/B2), 5 Kehidupan di Amerika &amp; Kampus (B2/C1), dan 5 Environmental Science (C1/C2). Komposisi: 10% A1-A2, 60% B1-B2, 30% C1-C2.</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click="toggleAllQA20Vocabs()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 transition text-amber-900 shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <span>💡</span>
                                    <span x-text="showAllQA20Vocabs ? 'Tutup Kosa Kata' : 'Kosa Kata Bantuan'"></span>
                                </button>
                                <button type="button" @click="toggleAllQA20()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-800 shadow-xs cursor-pointer">
                                    <span x-text="showAllQA20 ? 'Tutup Respon' : 'Buka Semua Respon'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- 20 Clean Q&A Items with Cluster Dividers -->
                        <div class="space-y-3">
                            @foreach($speakingData['qa20'] as $qIndex => $qItem)
                                @if($qIndex === 0)
                                     <div class="flex items-center gap-2 pt-1 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-blue-100 text-blue-900 border border-blue-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            BAGIAN 1: 5 PERTANYAAN PRIBADI (PERSONAL &amp; DAILY LIFE) • LEVEL A2 / B1
                                        </span>
                                        <div class="h-px bg-blue-200 flex-1"></div>
                                    </div>
                                @elseif($qIndex === 5)
                                    <div class="flex items-center gap-2 pt-4 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-sky-100 text-sky-900 border border-sky-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                            BAGIAN 2: 5 PERTANYAAN OPINI TENTANG ISU SOSIAL &amp; MASYARAKAT (SOCIAL ISSUES) • LEVEL B1 / B2
                                        </span>
                                        <div class="h-px bg-sky-200 flex-1"></div>
                                    </div>
                                @elseif($qIndex === 10)
                                    <div class="flex items-center gap-2 pt-4 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-indigo-100 text-indigo-900 border border-indigo-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            BAGIAN 3: 5 PERTANYAAN KEHIDUPAN DI AMERIKA DAN KAMPUS (US LIFE &amp; CAMPUS) • LEVEL B2 / C1
                                        </span>
                                        <div class="h-px bg-indigo-200 flex-1"></div>
                                    </div>
                                @elseif($qIndex === 15)
                                    <div class="flex items-center gap-2 pt-4 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            BAGIAN 4: 5 PERTANYAAN ENVIRONMENTAL SCIENCE &amp; SUSTAINABILITY • LEVEL C1 / C2
                                        </span>
                                        <div class="h-px bg-emerald-200 flex-1"></div>
                                    </div>
                                @endif

                                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50 transition space-y-3 shadow-sm"
                                     style="background-color: #ebf5ff; border: 1px solid #bfdbfe;"
                                     x-data="{ openTeacher: false, showQA20Vocab: false }">
                                    
                                    <!-- Tutor Question -->
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-2.5">
                                            <span class="w-6 h-6 rounded-md {{ $qIndex >= 15 ? 'bg-emerald-600' : ($qIndex >= 10 ? 'bg-indigo-600' : ($qIndex >= 5 ? 'bg-sky-600' : 'bg-blue-600')) }} text-white font-extrabold text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                                {{ $qItem['num'] }}
                                            </span>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                    <span class="text-[11px] font-extrabold text-blue-900 uppercase tracking-wider bg-white px-2 py-0.5 rounded-md border border-blue-200 shadow-xs">Tutor</span>
                                                    @if(!empty($qItem['level']))
                                                        @php
                                                            $levelBg = match($qItem['level']) {
                                                                'A1', 'A2' => 'bg-sky-100 text-sky-900 border-sky-300',
                                                                'B1', 'B2' => 'bg-indigo-100 text-indigo-900 border-indigo-300',
                                                                'C1', 'C2' => 'bg-purple-100 text-purple-900 border-purple-300',
                                                                default => 'bg-gray-100 text-gray-900 border-gray-300'
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black border {{ $levelBg }} shadow-2xs">
                                                            {{ $qItem['level'] }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($qItem['category']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold border {{ ($qItem['category'] === 'Environmental Science' || ($qItem['cluster'] ?? '') === 'Environmental Science') ? 'bg-emerald-50 text-emerald-900 border-emerald-300' : 'bg-white text-blue-900 border-blue-200 shadow-xs' }}">
                                                            {{ $qItem['category'] }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($qItem['focus']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold font-mono bg-amber-50 text-amber-900 border border-amber-300 shadow-xs">
                                                            <span class="font-bold text-amber-800 mr-1">Pola:</span> {{ $qItem['focus'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm md:text-[15px] font-bold text-gray-900 leading-snug">
                                                    {{ $qItem['tutor_question'] }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @if(!empty($qItem['vocab_hint']))
                                                <button type="button" @click="showQA20Vocab = !showQA20Vocab"
                                                        class="px-2.5 py-1 text-xs font-bold rounded-lg transition border flex items-center gap-1 shadow-xs cursor-pointer"
                                                        :class="(showQA20Vocab || showAllQA20Vocabs) ? 'bg-amber-500 text-white border-amber-600 shadow-xs' : 'bg-white border-amber-300 text-amber-900 hover:bg-amber-50 shadow-xs'">
                                                    <span>💡</span>
                                                    <span x-text="(showQA20Vocab || showAllQA20Vocabs) ? 'Tutup Kosa Kata' : 'Kosa Kata'"></span>
                                                </button>
                                            @endif
                                            <button type="button" @click="speakText('{{ addslashes($qItem['tutor_question']) }}')"
                                                    class="p-1.5 text-blue-700 hover:text-blue-900 hover:bg-blue-100 rounded-lg transition cursor-pointer" title="Dengarkan pertanyaan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                            </button>
                                            <button type="button" @click="openTeacher = !openTeacher"
                                                    class="px-2.5 py-1 text-xs font-bold rounded-lg transition cursor-pointer"
                                                    :class="(openTeacher || showAllQA20) ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white border border-blue-200 text-blue-900 hover:bg-white/80 shadow-xs'">
                                                <span x-text="(openTeacher || showAllQA20) ? 'Tutup' : 'Respon'"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- VOCABULARY ASSISTANCE BOX FOR Q&A (BISA DI-HIDE / DI-TOGGLE) -->
                                    @if(!empty($qItem['vocab_hint']))
                                        <div x-show="showQA20Vocab || showAllQA20Vocabs" x-cloak
                                             class="p-3 rounded-xl bg-amber-50/90 border border-amber-300 shadow-2xs space-y-1.5">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                                    <span>💡</span> Kosa Kata Bantuan (Vocabulary Clues):
                                                </span>
                                                <button type="button" @click="showQA20Vocab = false"
                                                        class="text-[10px] font-bold text-amber-800 hover:text-amber-950 underline cursor-pointer">
                                                    Sembunyikan
                                                </button>
                                            </div>
                                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                                @php
                                                    $qHints = array_map('trim', explode(',', $qItem['vocab_hint']));
                                                @endphp
                                                @foreach($qHints as $qh)
                                                    @if(str_contains($qh, ':'))
                                                        @php
                                                            [$idPart, $enPart] = array_map('trim', explode(':', $qh, 2));
                                                        @endphp
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-xs shadow-2xs">
                                                            <span class="text-gray-600 font-normal">{{ $idPart }}:</span>
                                                            <span class="font-bold text-amber-950">{{ $enPart }}</span>
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-950 font-bold text-xs shadow-2xs">
                                                            {{ $qh }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Teacher Model Answer -->
                                    <div x-show="openTeacher || showAllQA20" x-cloak class="p-3.5 rounded-xl bg-white border border-emerald-300 shadow-xs flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-900 uppercase tracking-wider">Teacher / Student:</span>
                                            <p class="text-sm md:text-[15px] font-semibold text-emerald-950 font-serif leading-relaxed">
                                                &ldquo;{{ $qItem['teacher_answer'] }}&rdquo;
                                            </p>
                                        </div>
                                        <button type="button" @click="speakText('{{ addslashes($qItem['teacher_answer']) }}')"
                                                class="p-1.5 text-emerald-800 hover:bg-emerald-100 rounded-lg transition shrink-0 cursor-pointer" title="Dengarkan respon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- ========================================================================= -->
                <!-- 3. 10 DISKUSI KASUS (TUTOR DAN TEACHER) -->
                <!-- ========================================================================= -->
                <div x-show="activeTab === 'qa10' || showAll" class="space-y-4" x-cloak>
                    <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 gap-3 flex-wrap sm:flex-nowrap">
                            <div>
                                <h2 class="text-base md:text-lg font-bold text-gray-900">3. 10 Diskusi Kasus (Tutor &amp; Teacher)</h2>
                                <p class="text-xs text-gray-600">Terdiri dari 5 Soal Isu Sosial &amp; Kemasyarakatan (Level B1-B2) dan 5 Soal Environmental Science Populer (Level B1-B2). Dilengkapi panduan pola tata bahasa Meeting 1.</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click="toggleAllQA10Vocabs()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 transition text-amber-900 shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <span>💡</span>
                                    <span x-text="showAllQA10Vocabs ? 'Tutup Kosa Kata' : 'Kosa Kata Bantuan'"></span>
                                </button>
                                <button type="button" @click="toggleAllQA10()"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-800 shadow-xs cursor-pointer">
                                    <span x-text="showAllQA10 ? 'Tutup Respon' : 'Buka Semua Respon'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- 10 In-Depth Discussion Items with Cluster Dividers -->
                        <div class="space-y-3.5">
                            @foreach($speakingData['qa10'] as $dIndex => $dItem)
                                @if($dIndex === 0)
                                    <div class="flex items-center gap-2 pt-1 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-blue-100 text-blue-900 border border-blue-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            BAGIAN 1: 5 SOAL DISKUSI ISU SOSIAL &amp; MASYARAKAT (SOCIAL ISSUES) • LEVEL B1 - B2
                                        </span>
                                        <div class="h-px bg-blue-200 flex-1"></div>
                                    </div>
                                @elseif($dIndex === 5)
                                    <div class="flex items-center gap-2 pt-4 pb-1">
                                        <span class="px-3 py-1 rounded-lg text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            BAGIAN 2: 5 SOAL ENVIRONMENTAL SCIENCE POPULER (LEVEL B1 - B2)
                                        </span>
                                        <div class="h-px bg-emerald-200 flex-1"></div>
                                    </div>
                                @endif

                                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50 transition space-y-3 shadow-sm"
                                     style="background-color: #ebf5ff; border: 1px solid #bfdbfe;"
                                     x-data="{ openDeep: false, showQA10Vocab: false }">
                                    
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-2.5">
                                            <span class="w-6 h-6 rounded-md {{ $dIndex >= 5 ? 'bg-emerald-700' : 'bg-teal-700' }} text-white font-extrabold text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                                {{ $dItem['num'] }}
                                            </span>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                    <span class="text-[11px] font-extrabold text-blue-900 uppercase tracking-wider bg-white px-2 py-0.5 rounded-md border border-blue-200 shadow-xs">Tutor</span>
                                                    @if(!empty($dItem['level']))
                                                        @php
                                                            $levelBg = match($dItem['level']) {
                                                                'A1', 'A2' => 'bg-sky-100 text-sky-900 border-sky-300',
                                                                'B1', 'B2' => 'bg-indigo-100 text-indigo-900 border-indigo-300',
                                                                'C1', 'C2' => 'bg-purple-100 text-purple-900 border-purple-300',
                                                                default => 'bg-gray-100 text-gray-900 border-gray-300'
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black border {{ $levelBg }} shadow-2xs">
                                                            Level {{ $dItem['level'] }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($dItem['category']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold border {{ ($dItem['cluster'] ?? '') === 'Environmental Science' || str_contains(strtolower($dItem['category']), 'environment') ? 'bg-emerald-50 text-emerald-900 border-emerald-300' : 'bg-white text-teal-900 border-teal-200 shadow-2xs' }}">
                                                            {{ $dItem['category'] }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($dItem['focus']))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold font-mono bg-teal-50 text-teal-900 border border-teal-300 shadow-2xs">
                                                            <span class="font-bold text-teal-800 mr-1">Fokus:</span> {{ $dItem['focus'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm md:text-[15px] font-bold text-gray-900 leading-snug">
                                                    {{ $dItem['tutor_question'] }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @if(!empty($dItem['vocab_hint']))
                                                <button type="button" @click="showQA10Vocab = !showQA10Vocab"
                                                        class="px-2.5 py-1 text-xs font-bold rounded-lg transition border flex items-center gap-1 shadow-xs cursor-pointer"
                                                        :class="(showQA10Vocab || showAllQA10Vocabs) ? 'bg-amber-500 text-white border-amber-600 shadow-xs' : 'bg-white border-amber-300 text-amber-900 hover:bg-amber-50 shadow-xs'">
                                                    <span>💡</span>
                                                    <span x-text="(showQA10Vocab || showAllQA10Vocabs) ? 'Tutup Kosa Kata' : 'Kosa Kata'"></span>
                                                </button>
                                            @endif
                                            <button type="button" @click="speakText('{{ addslashes($dItem['tutor_question']) }}')"
                                                    class="p-1.5 text-teal-700 hover:text-teal-900 hover:bg-teal-100 rounded-lg transition cursor-pointer" title="Dengarkan kasus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                            </button>
                                            <button type="button" @click="openDeep = !openDeep"
                                                    class="px-2.5 py-1 text-xs font-bold rounded-lg transition cursor-pointer"
                                                    :class="(openDeep || showAllQA10) ? 'text-white shadow-xs' : 'bg-white border border-blue-200 text-gray-800 hover:bg-white/80 shadow-xs'"
                                                    :style="(openDeep || showAllQA10) ? 'background-color: #0f766e !important; color: #ffffff !important;' : ''">
                                                <span x-text="(openDeep || showAllQA10) ? 'Tutup' : 'Respon'"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- VOCABULARY ASSISTANCE BOX FOR QA10 (BISA DI-HIDE / DI-TOGGLE) -->
                                    @if(!empty($dItem['vocab_hint']))
                                        <div x-show="showQA10Vocab || showAllQA10Vocabs" x-cloak
                                             class="p-3 rounded-xl bg-amber-50/90 border border-amber-300 shadow-2xs space-y-1.5">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                                    <span>💡</span> Kosa Kata Bantuan (Vocabulary Clues):
                                                </span>
                                                <button type="button" @click="showQA10Vocab = false"
                                                        class="text-[10px] font-bold text-amber-800 hover:text-amber-950 underline cursor-pointer">
                                                    Sembunyikan
                                                </button>
                                            </div>
                                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                                @php
                                                    $dHints = array_map('trim', explode(',', $dItem['vocab_hint']));
                                                @endphp
                                                @foreach($dHints as $dh)
                                                    @if(str_contains($dh, ':'))
                                                        @php
                                                            [$idPart, $enPart] = array_map('trim', explode(':', $dh, 2));
                                                        @endphp
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-xs shadow-2xs">
                                                            <span class="text-gray-600 font-normal">{{ $idPart }}:</span>
                                                            <span class="font-bold text-amber-950">{{ $enPart }}</span>
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-950 font-bold text-xs shadow-2xs">
                                                            {{ $dh }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Teacher / Student Model Response -->
                                    <div x-show="openDeep || showAllQA10" x-cloak class="p-3.5 rounded-xl bg-white border border-teal-300 shadow-xs flex items-start justify-between gap-3">
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-teal-100 text-teal-950 uppercase tracking-wider">Teacher / Student:</span>
                                            <p class="text-sm md:text-[15px] font-semibold text-teal-950 font-serif leading-relaxed">
                                                &ldquo;{{ $dItem['teacher_answer'] }}&rdquo;
                                            </p>
                                        </div>
                                        <button type="button" @click="speakText('{{ addslashes($dItem['teacher_answer']) }}')"
                                                class="p-1.5 text-teal-800 hover:bg-teal-100 rounded-lg transition shrink-0 cursor-pointer" title="Dengarkan respon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </button>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- ========================================================================= -->
                <!-- 4. SESI PRESENTASI MAHASISWA (UNDERGRADUATE ENVIRONMENTAL SCIENCE) -->
                <!-- ========================================================================= -->
                <div x-show="activeTab === 'monologue' || showAll" class="space-y-4" x-cloak>
                    <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm space-y-5">
                        
                        <!-- Header Presentasi -->
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <div>
                                <h2 class="text-base md:text-lg font-bold text-gray-900">4. Sesi Presentasi Mahasiswa (2-3 Menit)</h2>
                                <p class="text-xs text-gray-600">Paparan presentasi akademik lisan mandiri (Long Turn Speaking) mengenai topik Environmental Science tingkat sarjana (S1).</p>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 bg-purple-100 text-purple-900 rounded-lg border border-purple-200 shadow-2xs">
                                ⏱️ 2-3 Menit
                            </span>
                        </div>

                        <!-- Topik, Prompt & Panduan Struktur Presentasi -->
                        <div class="p-4 bg-purple-50 rounded-xl border border-purple-200 space-y-3">
                            <div class="space-y-1.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black uppercase tracking-wider bg-purple-200 text-purple-950 border border-purple-300 shadow-2xs">
                                    Environmental Science • Undergraduate Presentation
                                </span>
                                <h3 class="text-sm md:text-base font-bold text-purple-950">
                                    {{ $speakingData['monologue']['topic'] }}
                                </h3>
                                <p class="text-xs md:text-sm text-purple-900 leading-relaxed font-medium">
                                    {{ $speakingData['monologue']['prompt'] }}
                                </p>
                            </div>

                            <!-- 3-Stage Presentation Outline Guide -->
                            @if(!empty($speakingData['monologue']['outline_guide']))
                                <div class="pt-2.5 border-t border-purple-200/80">
                                    <h4 class="text-xs font-bold text-purple-950 mb-2 flex items-center gap-1.5">
                                        <span>📋</span> Panduan Alur 3 Bagian Presentasi:
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2.5">
                                        @foreach($speakingData['monologue']['outline_guide'] as $stage => $desc)
                                            <div class="p-2.5 bg-white rounded-lg border border-purple-200 shadow-2xs space-y-1">
                                                <div class="text-[11px] font-bold text-purple-900 flex items-center gap-1">
                                                    <span>⏱️</span> {{ $stage }}
                                                </div>
                                                <div class="text-[11px] text-gray-700 leading-snug">
                                                    {{ $desc }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Kosa Kata Bantuan Presentasi -->
                            @if(!empty($speakingData['monologue']['vocab_hint']))
                                <div class="pt-2.5 border-t border-purple-200/80" x-data="{ showPresVocab: false }">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <button type="button" @click="showPresVocab = !showPresVocab"
                                                class="text-xs font-bold px-2.5 py-1 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 transition text-amber-900 shadow-2xs flex items-center gap-1.5 cursor-pointer">
                                            <span>💡</span>
                                            <span x-text="showPresVocab ? 'Tutup Kosa Kata Bantuan' : 'Kosa Kata Bantuan Presentasi'"></span>
                                        </button>
                                        <span class="text-[11px] text-purple-800 italic">Gunakan istilah ilmiah berikut saat berbicara</span>
                                    </div>

                                    <div x-show="showPresVocab" x-cloak class="mt-2.5 p-3 rounded-xl bg-white border border-amber-300 shadow-2xs space-y-1.5">
                                        <div class="flex flex-wrap gap-1.5">
                                            @php
                                                $pvHints = array_map('trim', explode(',', $speakingData['monologue']['vocab_hint']));
                                            @endphp
                                            @foreach($pvHints as $pvh)
                                                @if(str_contains($pvh, ':'))
                                                    @php
                                                        [$idPart, $enPart] = array_map('trim', explode(':', $pvh, 2));
                                                    @endphp
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50/70 border border-amber-200 text-xs shadow-2xs">
                                                        <span class="text-gray-600 font-normal">{{ $idPart }}:</span>
                                                        <span class="font-bold text-amber-950">{{ $enPart }}</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50/70 border border-amber-200 text-amber-950 font-bold text-xs shadow-2xs">
                                                        {{ $pvh }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- BAGAN ALUR PROSES GAMBAR (ENVIRONMENTAL SCIENCE PROCESS FLOWCHART) -->
                        @if(!empty($speakingData['monologue']['process_diagram']))
                            <div class="p-4 bg-white rounded-xl border border-purple-200 shadow-sm space-y-4" x-data="{ zoomModal: false, showStepCards: true }">
                                <div class="flex items-center justify-between pb-2.5 border-b border-purple-100 flex-wrap gap-2">
                                    <div class="flex items-center gap-2">
                                        <span class="p-1.5 bg-purple-100 text-purple-800 rounded-lg shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </span>
                                        <div>
                                            <h4 class="text-xs md:text-sm font-bold text-gray-900 flex items-center gap-1.5">
                                                <span>📊</span> Gambar Bagan Alur: {{ $speakingData['monologue']['process_diagram']['title'] }}
                                            </h4>
                                            <p class="text-[11px] text-gray-500">
                                                {{ $speakingData['monologue']['process_diagram']['subtitle'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="zoomModal = true"
                                                class="px-2.5 py-1 text-xs font-bold rounded-lg border border-purple-200 bg-purple-50 text-purple-900 hover:bg-purple-100 transition flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                            <span>Perbesar Bagan</span>
                                        </button>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-2xs">
                                            5 Tahapan Siklus Tertutup
                                        </span>
                                    </div>
                                </div>

                                <!-- Process Diagram Image Banner (Bagan Gambar) -->
                                <div class="rounded-2xl overflow-hidden border border-purple-200 bg-slate-50 relative group cursor-pointer shadow-xs hover:border-purple-400 transition"
                                     @click="zoomModal = true">
                                    <img src="{{ asset($speakingData['monologue']['process_diagram']['image_url'] ?? '/images/custom-class/plastic_recycling_flowchart.jpg') }}"
                                         alt="{{ $speakingData['monologue']['process_diagram']['title'] }}"
                                         class="w-full h-auto object-contain mx-auto rounded-xl transition duration-300 group-hover:scale-[1.01]">
                                    <div class="absolute bottom-3 right-3 bg-gray-900/85 hover:bg-gray-900 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 backdrop-blur-xs transition shadow-md">
                                        <svg class="w-3.5 h-3.5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6m0 0v6m0-6L14 10M9 21H3m0 0v-6m0 6l7-7"/></svg>
                                        <span>Klik untuk Memperbesar</span>
                                    </div>
                                </div>

                                <!-- Modal Zoom Gambar Fullscreen (Lightbox) -->
                                <div x-show="zoomModal" x-cloak
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                                     @click.self="zoomModal = false">
                                    <div class="relative max-w-5xl w-full bg-white rounded-2xl p-4 shadow-2xl space-y-3">
                                        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                                            <div>
                                                <h3 class="text-sm font-bold text-gray-900">
                                                    {{ $speakingData['monologue']['process_diagram']['title'] }}
                                                </h3>
                                                <p class="text-xs text-gray-500">
                                                    Bagan Alur 5 Tahap Pengolahan Sampah Plastik Kampus (Closed-Loop Cycle)
                                                </p>
                                            </div>
                                            <button type="button" @click="zoomModal = false"
                                                    class="text-gray-400 hover:text-gray-700 text-2xl font-bold p-1 cursor-pointer transition">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="overflow-auto max-h-[80vh]">
                                            <img src="{{ asset($speakingData['monologue']['process_diagram']['image_url'] ?? '/images/custom-class/plastic_recycling_flowchart.jpg') }}"
                                                 alt="{{ $speakingData['monologue']['process_diagram']['title'] }}"
                                                 class="w-full h-auto object-contain rounded-xl">
                                        </div>
                                    </div>
                                </div>

                                <!-- Kosa Kata Bantuan Khusus Bagan Alur (Vocabulary Clues under Flowchart Image) -->
                                <div class="p-3.5 rounded-xl bg-amber-50/90 border border-amber-300 shadow-2xs space-y-2"
                                     x-data="{ showDiagramVocab: true }">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                                            <span>💡</span> Kosa Kata Bantuan Bagan Alur (Flowchart Vocabulary Clues):
                                        </span>
                                        <button type="button" @click="showDiagramVocab = !showDiagramVocab"
                                                class="text-xs font-bold text-amber-800 hover:text-amber-950 underline cursor-pointer">
                                            <span x-text="showDiagramVocab ? 'Sembunyikan Kosa Kata' : 'Tampilkan Kosa Kata'"></span>
                                        </button>
                                    </div>

                                    <div x-show="showDiagramVocab" class="flex flex-wrap gap-1.5 pt-0.5">
                                        @php
                                            $rawDiagVocab = $speakingData['monologue']['process_diagram']['diagram_vocab'] ?? ($speakingData['monologue']['vocab_hint'] ?? '');
                                            $diagVocabList = array_map('trim', explode(',', $rawDiagVocab));
                                        @endphp
                                        @foreach($diagVocabList as $dv)
                                            @if(str_contains($dv, ':'))
                                                @php
                                                    [$idPart, $enPart] = array_map('trim', explode(':', $dv, 2));
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-xs shadow-2xs">
                                                    <span class="text-gray-600 font-normal">{{ $idPart }}:</span>
                                                    <span class="font-bold text-amber-950">{{ $enPart }}</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-950 font-bold text-xs shadow-2xs">
                                                    {{ $dv }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- 5-Step Process Explanatory Cards (Bagan Teks Pendukung) -->
                                <div class="pt-2 border-t border-purple-100">
                                    <div class="flex items-center justify-between mb-2.5">
                                        <span class="text-xs font-bold text-purple-950 flex items-center gap-1.5">
                                            <span>📝</span> Panduan Bahasa Tiap Tahap (Fokus Tata Bahasa Meeting {{ $meetingNumber }}):
                                        </span>
                                        <button type="button" @click="showStepCards = !showStepCards"
                                                class="text-xs font-bold text-purple-700 hover:text-purple-900 underline cursor-pointer">
                                            <span x-text="showStepCards ? 'Sembunyikan Rincian' : 'Tampilkan Rincian'"></span>
                                        </button>
                                    </div>

                                    <div x-show="showStepCards" class="grid grid-cols-1 md:grid-cols-5 gap-2.5">
                                        @foreach($speakingData['monologue']['process_diagram']['steps'] as $step)
                                            <div class="p-3 bg-purple-50/70 rounded-xl border border-purple-200 text-left space-y-1.5 shadow-2xs hover:border-purple-300 transition">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-purple-600 text-white shadow-2xs">
                                                        Tahap {{ $step['step'] }}
                                                    </span>
                                                    <span class="text-base">{{ $step['icon'] }}</span>
                                                </div>
                                                <h5 class="text-xs font-bold text-gray-900 leading-tight">
                                                    {{ $step['title'] }}
                                                </h5>
                                                <p class="text-[10px] text-purple-800 font-semibold">
                                                    {{ $step['title_id'] }}
                                                </p>
                                                <p class="text-[11px] text-gray-600 leading-snug font-sans">
                                                    {{ $step['description'] }}
                                                </p>
                                                <div class="pt-1 border-t border-purple-100">
                                                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-white text-purple-950 border border-purple-200 shadow-2xs">
                                                        {{ $step['key_verb'] }}
                                                    </span>
                                                </div>
                                                @if(!empty($step['vocab']))
                                                    <div class="pt-1.5 mt-1 border-t border-purple-100/70">
                                                        <div class="text-[10px] font-bold text-amber-900 mb-1 flex items-center gap-1">
                                                            <span>💡</span> Istilah:
                                                        </div>
                                                        <div class="flex flex-col gap-1">
                                                            @foreach(array_map('trim', explode(',', $step['vocab'])) as $sv)
                                                                <span class="text-[10px] px-1.5 py-0.5 bg-white rounded border border-amber-200 text-amber-950 font-medium">
                                                                    {{ $sv }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Contoh Naskah Presentasi (Tabs: Formal / Conversational) -->
                        <div class="space-y-3" x-data="{ scriptTab: 'formal' }">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <div class="inline-flex p-1 bg-gray-100 rounded-xl text-xs font-semibold gap-1.5 border border-gray-200 shadow-2xs">
                                    <button type="button" @click="scriptTab = 'formal'"
                                            class="px-4 py-2 rounded-lg transition font-bold cursor-pointer text-xs"
                                            :style="scriptTab === 'formal' ? 'background-color: #2563eb !important; color: #ffffff !important; box-shadow: 0 1px 2px rgba(0,0,0,0.1);' : 'background-color: transparent !important; color: #374151 !important;'">
                                        Naskah Formal (Seminar Akademik)
                                    </button>
                                    <button type="button" @click="scriptTab = 'conversational'"
                                            class="px-4 py-2 rounded-lg transition font-bold cursor-pointer text-xs"
                                            :style="scriptTab === 'conversational' ? 'background-color: #2563eb !important; color: #ffffff !important; box-shadow: 0 1px 2px rgba(0,0,0,0.1);' : 'background-color: transparent !important; color: #374151 !important;'">
                                        Naskah Santai (Diskusi Kampus)
                                    </button>
                                </div>
                                <button type="button"
                                        @click="speakText(scriptTab === 'formal' ? '{{ addslashes($speakingData['monologue']['monologue_formal']) }}' : '{{ addslashes($speakingData['monologue']['monologue_conversational']) }}')"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl transition cursor-pointer shadow-2xs">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    <span>Dengar Naskah</span>
                                </button>
                            </div>

                            <div x-show="scriptTab === 'formal'"
                                 class="p-4 rounded-xl border border-slate-300 shadow-2xs"
                                 style="background-color: #f8fafc; color: #0f172a; line-height: 1.8; font-size: 14.5px; font-family: Georgia, Cambria, 'Times New Roman', Times, serif;">
                                &ldquo;{{ $speakingData['monologue']['monologue_formal'] }}&rdquo;
                            </div>

                            <div x-show="scriptTab === 'conversational'" x-cloak
                                 class="p-4 rounded-xl border border-slate-300 shadow-2xs"
                                 style="background-color: #f8fafc; color: #0f172a; line-height: 1.8; font-size: 14.5px; font-family: Georgia, Cambria, 'Times New Roman', Times, serif;">
                                &ldquo;{{ $speakingData['monologue']['monologue_conversational'] }}&rdquo;
                            </div>
                        </div>

                        <!-- Clean Audio Recording Studio -->
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-700">Studio Rekaman Suara Presentasi</span>
                                <span class="font-mono text-xs font-black px-2 py-0.5 rounded bg-white border border-gray-200"
                                      :class="isRecording ? 'text-red-600 animate-pulse' : 'text-gray-600'"
                                      x-text="recordingDurationFormatted">
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" @click="startRecording()" x-show="!isRecording && !hasRecording"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-sm transition inline-flex items-center gap-2 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"></circle></svg>
                                    Mulai Merekam
                                </button>

                                <button type="button" @click="stopRecording()" x-show="isRecording"
                                        class="px-4 py-2 bg-gray-900 text-white font-bold text-xs rounded-xl transition inline-flex items-center gap-2 cursor-pointer">
                                    <span class="w-2.5 h-2.5 bg-red-500 rounded-sm animate-ping"></span>
                                    Selesai Merekam
                                </button>

                                <div x-show="hasRecording && !isRecording" class="flex-1 flex flex-wrap items-center gap-3" x-cloak>
                                    <audio id="audioPlayback" controls class="h-8 max-w-[240px]"></audio>
                                    <button type="button" @click="resetRecording()" class="px-3 py-1.5 text-xs font-semibold bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                                        Rekam Ulang
                                    </button>
                                    <a :href="audioBlobUrl" download="speaking-m{{ $meetingNumber }}-presentation.webm" class="px-3 py-1.5 text-xs font-bold bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition cursor-pointer">
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Presentation Scratchpad Notes -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <label class="font-bold text-gray-700">Presentation Notes &amp; Outline Scratchpad</label>
                                <span x-text="savedNotesStatus"></span>
                            </div>
                            <textarea x-model="speechNotes" @input="saveNotes()"
                                      placeholder="Tuliskan 3 pointer utama presentasi: 1. Pembuka (opening), 2. Pembahasan temuan (body), 3. Rencana aksi keberlanjutan (conclusion)..."
                                      rows="3"
                                      class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs md:text-sm text-gray-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
                        </div>

                        <!-- Self-Evaluation & Delivery Checklist -->
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200/80 space-y-2.5">
                            <h4 class="text-xs font-bold text-gray-800">Self-Evaluation &amp; Delivery Checklist</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-gray-700">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Struktur jelas (Opening, Body, Conclusion)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Menggunakan signposting &amp; transisi kalimat</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Artikulasi jelas &amp; tempo bicara terkontrol</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Durasi berkisar 2-3 menit</span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- ========================================================================= -->
                <!-- 5. AI INTERVIEW (VOICE PRACTICE + AI GRADING) -->
                <!-- ========================================================================= -->
                <div x-show="activeTab === 'aiInterview' || showAll" class="space-y-4" x-cloak>
                    <div class="rounded-2xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden flex flex-col items-center justify-center text-center"
                         style="background: linear-gradient(135deg, #1d4ed8 0%, #1e293b 100%); min-height: 520px;">
                        <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
                        <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full bg-amber-400/20 blur-3xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col items-center gap-5 max-w-xl mx-auto py-6">
                            <h2 class="text-base md:text-lg font-bold">5. AI Interview: Latihan &amp; Penilaian Speaking oleh AI</h2>
                            <p class="text-xs md:text-sm text-blue-100">
                                AI akan menanyakan <span x-text="aiQuestions.length"></span> pertanyaan secara lisan. Jawab dengan suara Anda, lalu dapatkan skor dan feedback otomatis dari AI setelah sesi selesai.
                            </p>

                            <div class="relative flex items-center justify-center mt-2">
                                <div x-show="aiState === 'speaking'" class="absolute w-56 h-56 rounded-full border-4 border-white/60 animate-ping pointer-events-none"></div>
                                <div x-show="aiState === 'listening'" class="absolute w-56 h-56 rounded-full border-4 border-amber-400 animate-ping pointer-events-none"></div>
                                <div x-show="aiState === 'idle'" class="absolute w-48 h-48 rounded-full bg-white/15 animate-pulse pointer-events-none"></div>

                                <button type="button" @click="toggleAiInteraction()"
                                        class="w-36 h-36 sm:w-40 sm:h-40 shrink-0 rounded-full bg-white shadow-[0_0_60px_rgba(255,255,255,0.6)] flex items-center justify-center relative z-10 transition-all duration-300 hover:scale-105 active:scale-95 border-4 cursor-pointer"
                                        :class="aiState === 'speaking' ? 'border-blue-500' : (aiState === 'listening' ? 'border-amber-400' : 'border-white')">
                                    <svg x-show="aiState !== 'listening'" class="w-14 h-14 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m-4 0h8M12 14a3 3 0 01-3-3V6a3 3 0 116 0v5a3 3 0 01-3 3z"/>
                                    </svg>
                                    <svg x-show="aiState === 'listening'" class="w-14 h-14 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m-4 0h8M12 14a3 3 0 01-3-3V6a3 3 0 116 0v5a3 3 0 01-3 3z"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-1">
                                <template x-if="aiState === 'idle'">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-amber-500 text-white shadow">
                                        Klik Lingkaran untuk Mulai Wawancara
                                    </span>
                                </template>
                                <template x-if="aiState === 'speaking'">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-slate-900 border border-sky-400 text-white animate-pulse">
                                        AI sedang bertanya...
                                    </span>
                                </template>
                                <template x-if="aiState === 'listening'">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-amber-500 text-white animate-pulse">
                                        Giliran Anda: silakan bicara
                                    </span>
                                </template>
                                <template x-if="aiState === 'finished'">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-emerald-600 text-white">
                                        Sesi Selesai!
                                    </span>
                                </template>
                            </div>

                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                <button type="button" @click="showQuestionText = !showQuestionText"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition border border-white/25 cursor-pointer">
                                    <span x-text="showQuestionText ? 'Sembunyikan Teks Pertanyaan' : 'Tampilkan Teks Pertanyaan (Bantuan)'"></span>
                                </button>
                                <button type="button" x-show="aiState !== 'idle'" @click="restartAiInterview()"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition border border-white/25 cursor-pointer">
                                    Ulangi dari Awal
                                </button>
                            </div>

                            <div x-show="showQuestionText" x-transition class="w-full p-4 sm:p-5 rounded-2xl bg-white/15 border border-white/30 backdrop-blur-sm">
                                <template x-if="currentAiQuestion">
                                    <div>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white">
                                            Pertanyaan <span x-text="currentAiQIdx + 1"></span>/<span x-text="aiQuestions.length"></span>
                                        </span>
                                        <p class="text-sm sm:text-base font-bold text-white mt-2" x-text="'&ldquo;' + currentAiQuestion.question + '&rdquo;'"></p>
                                        <p x-show="currentAiQuestion.hint" class="text-xs text-amber-200 mt-2 font-semibold p-2 rounded-lg bg-black/20" x-text="currentAiQuestion.hint"></p>
                                    </div>
                                </template>
                            </div>

                            <div x-show="userSpokenText" class="w-full p-3.5 rounded-xl bg-amber-500/20 border border-white/30 text-white text-xs sm:text-sm font-bold">
                                <span class="text-amber-200 font-black">Suara Anda:</span> &ldquo;<span x-text="userSpokenText"></span>&rdquo;
                            </div>

                            <template x-if="isSubmittingEvaluation">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 text-white text-xs font-bold border border-white/30">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Menilai jawaban Anda dengan AI, mohon tunggu...
                                </span>
                            </template>
                            <template x-if="evaluationError">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="px-4 py-2 rounded-full bg-red-500/90 text-white text-xs font-bold" x-text="evaluationError"></span>
                                    <button type="button" @click="submitInterviewForEvaluation()" class="px-4 py-1.5 rounded-full bg-white text-slate-800 text-xs font-bold hover:bg-slate-100 transition cursor-pointer">
                                        Coba Lagi
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- AI Evaluation Result Panel (inline, shown once a score exists) -->
                    <div x-show="evaluationResult" x-cloak class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 flex-wrap gap-3">
                            <div>
                                <h3 class="text-sm md:text-base font-bold text-gray-900">Hasil Penilaian AI Interview</h3>
                                <p class="text-xs text-gray-500">Dinilai otomatis berdasarkan CEFR Can-Do Descriptors.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1.5 rounded-xl bg-blue-600 text-white text-sm font-black" x-text="(evaluationResult?.overall_score ?? 0) + '/100'"></span>
                                <span x-show="evaluationResult?.cefr_level" class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-900 border border-amber-300 text-sm font-black" x-text="'Level ' + evaluationResult?.cefr_level"></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <template x-for="cat in ['fluency', 'vocabulary', 'grammar', 'pronunciation']" :key="cat">
                                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-black uppercase tracking-wider text-blue-900" x-text="cat"></span>
                                        <span class="text-sm font-black text-blue-800" x-text="(evaluationResult?.categories?.[cat]?.score ?? 0) + '/100'"></span>
                                    </div>
                                    <p class="text-[11px] text-gray-700 leading-snug" x-text="evaluationResult?.categories?.[cat]?.feedback ?? ''"></p>
                                </div>
                            </template>
                        </div>

                        <div x-show="evaluationResult?.general_feedback" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200">
                            <span class="text-[11px] font-black uppercase tracking-wider text-emerald-900">Catatan Umum:</span>
                            <p class="text-xs text-emerald-950 mt-1 leading-relaxed" x-text="evaluationResult?.general_feedback"></p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL / DRAWER: TIPS & SIGNPOSTING (DIBUKA HANYA KETIKA DIBUTUHKAN) -->
    <div x-show="showTipsModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="showTipsModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-5 border border-gray-100"
                 @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">💡</span>
                        <h3 class="font-extrabold text-gray-900 text-base">Panduan Delivery &amp; Signposting</h3>
                    </div>
                    <button type="button" @click="showTipsModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <!-- Aturan Delivery Ringkas -->
                <div class="space-y-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-gray-500">Aturan Delivery</h4>
                    <ul class="text-xs text-gray-700 space-y-1.5 list-disc list-inside">
                        <li>Dilarang menjawab secara singkat "Yes/No".</li>
                        <li>Awali argumen dengan klausul konsesi / signposting ("Much as I acknowledge...").</li>
                        <li>Pertahankan tempo bicara tenang dan artikulasi jelas.</li>
                    </ul>
                </div>

                <!-- Signposting Quick Copy -->
                <div class="space-y-3 pt-2 border-t border-gray-100">
                    <h4 class="text-xs font-black uppercase tracking-wider text-gray-500">Frasa Pembuka &amp; Transisi</h4>
                    <div class="space-y-1.5 text-xs">
                        @foreach(array_merge($speakingData['framework']['openers'] ?? [], $speakingData['framework']['transitions'] ?? []) as $ph)
                            <div class="p-2 bg-gray-50 rounded-lg flex items-center justify-between gap-2">
                                <span class="text-gray-800 font-medium truncate">&ldquo;{{ $ph }}&rdquo;</span>
                                <button type="button" @click="insertPhrase('{{ addslashes($ph) }}'); showTipsModal = false"
                                        class="px-2 py-0.5 bg-blue-600 text-white rounded text-[10px] font-bold shrink-0">
                                    Pakai
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" @click="showTipsModal = false"
                            class="w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FLOATING HELPER BUTTONS STACK -->
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-adverb-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>

    <script>
        function speakingPracticeApp() {
            return {
                activeTab: 'translation', // 'translation', 'qa20', 'qa10', 'monologue', 'aiInterview'
                showAll: false,
                showAllTranslations: false,
                showAllVocabs: false,
                showAllQA20: false,
                showAllQA20Vocabs: false,
                showAllQA10: false,
                showAllQA10Vocabs: false,
                showTipsModal: false,

                // AI Interview State
                aiQuestions: @js($speakingData['ai_interview'] ?? []),
                currentAiQIdx: 0,
                aiState: 'idle', // 'idle', 'speaking', 'listening', 'finished'
                showQuestionText: false,
                userSpokenText: '',
                recognitionInstance: null,
                interviewAnswers: [],
                aiInterviewAudioBlobs: [],
                aiInterviewRecorder: null,
                aiInterviewAudioChunks: [],
                aiInterviewStream: null,
                isSubmittingEvaluation: false,
                evaluationError: '',
                evaluationResult: @js($aiInterviewEvaluation ? [
                    'overall_score' => $aiInterviewEvaluation->overall_score,
                    'cefr_level' => $aiInterviewEvaluation->cefr_level,
                    'categories' => $aiInterviewEvaluation->scores_data['categories'] ?? [],
                    'general_feedback' => $aiInterviewEvaluation->general_feedback,
                ] : null),

                get currentAiQuestion() {
                    return this.aiQuestions[this.currentAiQIdx] || null;
                },

                startAiInterview() {
                    this.currentAiQIdx = 0;
                    this.userSpokenText = '';
                    this.interviewAnswers = [];
                    this.aiInterviewAudioBlobs = [];
                    this.evaluationError = '';
                    this.askCurrentAiQuestion();
                },

                toggleAiInteraction() {
                    if (this.aiState === 'idle') {
                        this.startAiInterview();
                    } else if (this.aiState === 'speaking') {
                        window.speechSynthesis.cancel();
                        this.aiState = 'listening';
                        this.startAiSpeechRecognition();
                    } else if (this.aiState === 'listening') {
                        this.stopAiSpeechRecognition();
                        this.nextAiQuestion();
                    } else if (this.aiState === 'finished') {
                        this.restartAiInterview();
                    }
                },

                askCurrentAiQuestion() {
                    const qObj = this.currentAiQuestion;
                    if (!qObj) {
                        this.aiState = 'finished';
                        return;
                    }

                    this.aiState = 'speaking';
                    this.userSpokenText = '';

                    if (!('speechSynthesis' in window)) {
                        this.aiState = 'listening';
                        this.startAiSpeechRecognition();
                        return;
                    }

                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(qObj.question);
                    utterance.lang = 'en-US';
                    utterance.rate = 0.95;
                    utterance.onend = () => {
                        if (this.aiState === 'speaking') {
                            this.aiState = 'listening';
                            this.startAiSpeechRecognition();
                        }
                    };
                    utterance.onerror = () => {
                        this.aiState = 'listening';
                        this.startAiSpeechRecognition();
                    };
                    window.speechSynthesis.speak(utterance);
                },

                startAiSpeechRecognition() {
                    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                    if (SpeechRecognition) {
                        try {
                            if (this.recognitionInstance) {
                                this.recognitionInstance.stop();
                            }
                            this.recognitionInstance = new SpeechRecognition();
                            this.recognitionInstance.lang = 'en-US';
                            this.recognitionInstance.interimResults = true;
                            this.recognitionInstance.continuous = false;

                            this.recognitionInstance.onresult = (event) => {
                                const transcript = Array.from(event.results)
                                    .map(result => result[0].transcript)
                                    .join('');
                                this.userSpokenText = transcript;
                            };
                            this.recognitionInstance.onerror = (event) => {
                                console.log('Speech recognition notice:', event.error);
                            };

                            this.recognitionInstance.start();
                        } catch (e) {
                            console.log('Speech recognition not available:', e);
                        }
                    }
                    this.startAiInterviewRecording();
                },

                stopAiSpeechRecognition() {
                    if (this.recognitionInstance) {
                        try { this.recognitionInstance.stop(); } catch (e) {}
                    }
                },

                startAiInterviewRecording() {
                    if (!navigator.mediaDevices?.getUserMedia) return;
                    navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                        this.aiInterviewStream = stream;
                        this.aiInterviewAudioChunks = [];
                        this.aiInterviewRecorder = new MediaRecorder(stream);
                        this.aiInterviewRecorder.ondataavailable = (e) => {
                            if (e.data.size > 0) this.aiInterviewAudioChunks.push(e.data);
                        };
                        this.aiInterviewRecorder.start();
                    }).catch(() => {
                        // Mic denied/unavailable - evaluation falls back to
                        // text-transcript-only grading server-side.
                    });
                },

                stopAiInterviewRecording() {
                    return new Promise((resolve) => {
                        if (!this.aiInterviewRecorder || this.aiInterviewRecorder.state === 'inactive') {
                            resolve(null);
                            return;
                        }
                        this.aiInterviewRecorder.onstop = () => {
                            const blob = this.aiInterviewAudioChunks.length ? new Blob(this.aiInterviewAudioChunks, { type: 'audio/webm' }) : null;
                            if (this.aiInterviewStream) {
                                this.aiInterviewStream.getTracks().forEach(t => t.stop());
                                this.aiInterviewStream = null;
                            }
                            resolve(blob);
                        };
                        try {
                            this.aiInterviewRecorder.stop();
                        } catch (e) {
                            resolve(null);
                        }
                    });
                },

                async commitCurrentAnswer() {
                    const qObj = this.currentAiQuestion;
                    if (!qObj) return;
                    const blob = await this.stopAiInterviewRecording();
                    this.interviewAnswers.push({
                        question: qObj.question,
                        answer: this.userSpokenText && this.userSpokenText.trim() ? this.userSpokenText.trim() : '(No answer recorded)',
                    });
                    this.aiInterviewAudioBlobs.push(blob);
                },

                async nextAiQuestion() {
                    this.stopAiSpeechRecognition();
                    await this.commitCurrentAnswer();
                    if (this.currentAiQIdx < this.aiQuestions.length - 1) {
                        this.currentAiQIdx++;
                        this.askCurrentAiQuestion();
                    } else {
                        this.aiState = 'finished';
                        this.submitInterviewForEvaluation();
                    }
                },

                async submitInterviewForEvaluation() {
                    this.isSubmittingEvaluation = true;
                    this.evaluationError = '';

                    const formData = new FormData();
                    this.interviewAnswers.forEach((entry, index) => {
                        formData.append('questions[' + index + ']', entry.question);
                        formData.append('answers[' + index + ']', entry.answer);
                        const blob = this.aiInterviewAudioBlobs[index];
                        if (blob) {
                            formData.append('audio_blobs[' + index + ']', blob, 'ai_interview_q' + index + '.webm');
                        }
                    });

                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                    try {
                        const response = await fetch('{{ route("assignments.custom-class.meeting.speaking.ai-interview.evaluate", [$classPeriod->id, $meetingNumber]) }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: formData,
                        });
                        const data = await response.json();
                        if (data.success && data.evaluation) {
                            this.evaluationResult = data.evaluation;
                        } else {
                            this.evaluationError = data.message || 'Gagal mendapatkan evaluasi. Silakan coba lagi.';
                        }
                    } catch (e) {
                        this.evaluationError = 'Gagal menghubungi server. Periksa koneksi Anda.';
                    } finally {
                        this.isSubmittingEvaluation = false;
                    }
                },

                restartAiInterview() {
                    this.stopAiSpeechRecognition();
                    window.speechSynthesis?.cancel();
                    this.interviewAnswers = [];
                    this.aiInterviewAudioBlobs = [];
                    this.evaluationError = '';
                    this.currentAiQIdx = 0;
                    this.userSpokenText = '';
                    this.aiState = 'idle';
                },

                speechNotes: localStorage.getItem('tb_speaking_notes_m{{ $meetingNumber }}') || '',
                savedNotesStatus: '',

                // Audio Recording States
                isRecording: false,
                hasRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                recordingSeconds: 0,
                recordingTimer: null,
                audioBlobUrl: null,

                get recordingDurationFormatted() {
                    const mins = Math.floor(this.recordingSeconds / 60);
                    const secs = this.recordingSeconds % 60;
                    return (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
                },

                toggleAllVocabs() {
                    this.showAllVocabs = !this.showAllVocabs;
                },

                toggleAllTranslations() {
                    this.showAllTranslations = !this.showAllTranslations;
                },

                toggleAllQA20() {
                    this.showAllQA20 = !this.showAllQA20;
                },

                toggleAllQA20Vocabs() {
                    this.showAllQA20Vocabs = !this.showAllQA20Vocabs;
                },

                toggleAllQA10() {
                    this.showAllQA10 = !this.showAllQA10;
                },

                toggleAllQA10Vocabs() {
                    this.showAllQA10Vocabs = !this.showAllQA10Vocabs;
                },

                insertPhrase(phrase) {
                    if (this.speechNotes) {
                        this.speechNotes += '\n• ' + phrase;
                    } else {
                        this.speechNotes = '• ' + phrase;
                    }
                    this.saveNotes();
                },

                saveNotes() {
                    try {
                        localStorage.setItem('tb_speaking_notes_m{{ $meetingNumber }}', this.speechNotes);
                        this.savedNotesStatus = 'Tersimpan';
                        setTimeout(() => { this.savedNotesStatus = ''; }, 1500);
                    } catch(e) {}
                },

                speakText(text) {
                    if (!('speechSynthesis' in window)) {
                        alert('Browser Anda tidak mendukung Web Speech Audio Synthesis.');
                        return;
                    }
                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'en-US';
                    utterance.rate = 0.95;
                    window.speechSynthesis.speak(utterance);
                },

                async startRecording() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        this.audioChunks = [];
                        this.mediaRecorder = new MediaRecorder(stream);

                        this.mediaRecorder.ondataavailable = (event) => {
                            if (event.data.size > 0) {
                                this.audioChunks.push(event.data);
                            }
                        };

                        this.mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                            this.audioBlobUrl = URL.createObjectURL(audioBlob);
                            const player = document.getElementById('audioPlayback');
                            if (player) {
                                player.src = this.audioBlobUrl;
                            }
                            this.hasRecording = true;
                            stream.getTracks().forEach(track => track.stop());
                        };

                        this.mediaRecorder.start();
                        this.isRecording = true;
                        this.recordingSeconds = 0;
                        this.recordingTimer = setInterval(() => {
                            this.recordingSeconds++;
                            if (this.recordingSeconds >= 180) { // max 3 mins
                                this.stopRecording();
                            }
                        }, 1000);
                    } catch (err) {
                        alert('Tidak dapat mengakses mikrofon. Pastikan Anda memberikan izin akses mikrofon di browser.');
                    }
                },

                stopRecording() {
                    if (this.mediaRecorder && this.isRecording) {
                        this.mediaRecorder.stop();
                        this.isRecording = false;
                        if (this.recordingTimer) {
                            clearInterval(this.recordingTimer);
                        }
                    }
                },

                resetRecording() {
                    if (confirm('Rekam ulang akan menghapus rekaman sebelumnya. Lanjutkan?')) {
                        this.hasRecording = false;
                        this.audioBlobUrl = null;
                        this.recordingSeconds = 0;
                        const player = document.getElementById('audioPlayback');
                        if (player) {
                            player.src = '';
                        }
                    }
                }
            };
        }
    </script>
</body>
</html>
