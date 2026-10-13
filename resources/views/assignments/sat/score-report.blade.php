<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Digital SAT Estimasi Skor Latihan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&family=merriweather:300,400,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sat-header-bg {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
            background-color: #0284c7 !important;
        }
        .sat-glass-box {
            background-color: rgba(255, 255, 255, 0.16) !important;
            border: 1px solid rgba(255, 255, 255, 0.35) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .sat-blue-bg {
            background-color: #0284c7 !important;
        }
        .sat-blue-text {
            color: #0284c7 !important;
        }
        .sat-blue-btn {
            background-color: #0284c7 !important;
            color: #ffffff !important;
        }
        .sat-blue-btn:hover {
            background-color: #0369a1 !important;
        }
        .sat-blue-badge {
            color: #0284c7 !important;
            background-color: #f0f9ff !important;
            border: 1px solid #bae6fd !important;
        }
    </style>
</head>
<body class="min-h-full bg-slate-100 text-slate-800 font-sans p-4 sm:p-8" x-data="{ showScoreInsight: false }">
    @php
        $satRoutePrefix = request()->routeIs('mock-test.*') ? 'mock-test.sat.' : 'assignments.sat.';
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Top Navigation -->
        <div class="flex items-center justify-between flex-wrap gap-3">
            <a href="{{ route(rtrim($satRoutePrefix, '.')) }}" 
               class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-2xs hover:shadow-xs transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Menu SAT</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route($satRoutePrefix . 'score-report.download', $testNumber) }}" 
                   class="inline-flex items-center gap-2 text-xs font-bold text-white bg-[#0284c7] hover:bg-[#0369a1] px-4 py-2.5 rounded-xl shadow-xs hover:shadow-sm transition"
                   style="background-color: #0284c7 !important; color: #ffffff !important;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download Estimasi Skor (PDF)</span>
                </a>
                <div class="hidden sm:flex items-center gap-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest bg-white px-3.5 py-1.5 rounded-lg border border-slate-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Estimasi &mdash; Bukan Skor Resmi College Board</span>
                </div>
            </div>
        </div>

        <!-- Disclaimer: this is a self-generated practice estimate, not an official College Board score -->
        <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p class="text-xs sm:text-sm text-amber-800 leading-relaxed">
                <strong>Ini adalah estimasi skor latihan internal Target Bahasa</strong>, dihitung dari rasio jawaban benar pada simulasi ini. Ini <strong>bukan skor resmi Digital SAT</strong> dan tidak diterbitkan, diverifikasi, atau diakui oleh College Board. Gunakan sebagai indikator kemajuan belajar, bukan dokumen untuk keperluan pendaftaran kampus.
            </p>
        </div>

        <!-- Main Score Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- College Board Vibrant Blue Header -->
            <div class="sat-header-bg text-white p-8 sm:p-10 border-b border-sky-500 shadow-xs" 
                 style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important; background-color: #0284c7 !important;">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2.5">
                            <span class="text-[11px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full bg-white/20 text-white backdrop-blur-xs" style="background-color: rgba(255, 255, 255, 0.25) !important;">
                                Digital SAT Practice Test
                            </span>
                            <span class="text-xs text-sky-100 font-medium tracking-wide">Standard Assessment</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                                Your Score Report
                            </h1>
                            <p class="text-sky-100 text-xs sm:text-sm font-medium mt-2">
                                Test Taker: <strong class="text-white font-bold">{{ Auth::user()->name }}</strong> &bull; Completed: {{ now()->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Score Display Card with Visual Indicator -->
                    <div class="sat-glass-box rounded-2xl p-6 text-center shrink-0 min-w-[240px] shadow-sm space-y-3"
                         style="background-color: rgba(255, 255, 255, 0.16) !important; border: 1px solid rgba(255, 255, 255, 0.35) !important;">
                        <span class="text-[11px] font-black uppercase tracking-widest text-sky-100 block">
                            Total Score
                        </span>
                        <div class="text-5xl sm:text-6xl font-black text-white tracking-tight leading-none py-1">
                            {{ $totalSatScore }}
                        </div>
                        <span class="text-[11px] font-medium text-sky-100 block">
                            Score Range: 400 &ndash; 1600
                        </span>

                        <!-- Total Score Progress Bar -->
                        @php
                            $totalPercent = max(0, min(100, (($totalSatScore - 400) / (1600 - 400)) * 100));
                        @endphp
                        <div class="pt-2">
                            <div class="w-full h-2.5 rounded-full overflow-hidden p-0.5" style="background-color: rgba(0, 0, 0, 0.25) !important;">
                                <div class="h-full rounded-full transition-all duration-700 shadow-2xs" 
                                     style="width: {{ max(4, $totalPercent) }}%; background-color: #fde047 !important;"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-sky-100 font-mono mt-2 px-0.5">
                                <span>400</span>
                                <span>{{ $totalSatScore }}</span>
                                <span>1600</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 space-y-10">
                
                <!-- Section Breakdown Header -->
                <div class="space-y-2">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                        <span class="w-2.5 h-6 rounded-full inline-block sat-blue-bg" style="background-color: #0284c7 !important;"></span>
                        <span>Section Scores</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 pl-5">
                        Two section scores combine to calculate your total Digital SAT score.
                    </p>
                </div>

                <!-- Two Sections Comparison Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- 1. Reading and Writing Section -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:shadow-xs transition flex flex-col justify-between space-y-6">
                        <div class="space-y-6">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1.5">
                                    <span class="text-[11px] font-extrabold uppercase tracking-wider block sat-blue-text" style="color: #0284c7 !important;">Section 1</span>
                                    <h3 class="text-lg font-bold text-slate-900 leading-snug">Reading and Writing</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl sm:text-4xl font-black text-slate-900 leading-none">
                                        {{ $rwScaledScore }}
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">200 &ndash; 800</span>
                                </div>
                            </div>

                            <!-- RW Progress Bar -->
                            @php
                                $rwPercent = max(0, min(100, (($rwScaledScore - 200) / (800 - 200)) * 100));
                            @endphp
                            <div class="space-y-2">
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden border border-slate-200/60 p-0.5">
                                    <div class="h-full rounded-full transition-all duration-500 sat-blue-bg" 
                                         style="width: {{ max(4, $rwPercent) }}%; background-color: #0284c7 !important;"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-slate-400 font-mono px-0.5">
                                    <span>200</span>
                                    <span>500</span>
                                    <span>800</span>
                                </div>
                            </div>

                            <!-- Module Performance Details -->
                            <div class="pt-5 border-t border-slate-100 space-y-3 text-xs sm:text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600 font-medium">Module 1</span>
                                    <span class="font-bold text-slate-900">{{ $rwM1Correct }} / {{ $rwM1Total }} Correct</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600 font-medium">Module 2</span>
                                    <span class="font-bold text-slate-900">{{ $rwM2Correct }} / {{ $rwM2Total }} Correct</span>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <span class="text-slate-500 text-xs">Section Accuracy</span>
                                    <span class="font-extrabold text-slate-900 text-xs">
                                        {{ $rwTotalQuestions > 0 ? round(($rwTotalCorrect / $rwTotalQuestions) * 100) : 0 }}% ({{ $rwTotalCorrect }}/{{ $rwTotalQuestions }})
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-medium">Review answers:</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route($satRoutePrefix . 'practice-test', $rwModule1MeetingNumber ?? 1) }}" 
                                   class="text-xs font-bold text-slate-700 hover:text-sky-600 bg-slate-50 hover:bg-sky-50 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-sky-300 transition">
                                    Module 1
                                </a>
                                <a href="{{ route($satRoutePrefix . 'practice-test', $rwModule2MeetingNumber ?? 2) }}" 
                                   class="text-xs font-bold text-slate-700 hover:text-sky-600 bg-slate-50 hover:bg-sky-50 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-sky-300 transition">
                                    Module 2
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Mathematics Section -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:shadow-xs transition flex flex-col justify-between space-y-6">
                        <div class="space-y-6">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1.5">
                                    <span class="text-[11px] font-extrabold uppercase tracking-wider block sat-blue-text" style="color: #0284c7 !important;">Section 2</span>
                                    <h3 class="text-lg font-bold text-slate-900 leading-snug">Mathematics</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl sm:text-4xl font-black text-slate-900 leading-none">
                                        {{ $mathScaledScore }}
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">200 &ndash; 800</span>
                                </div>
                            </div>

                            <!-- Math Progress Bar -->
                            @php
                                $mathPercent = max(0, min(100, (($mathScaledScore - 200) / (800 - 200)) * 100));
                            @endphp
                            <div class="space-y-2">
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden border border-slate-200/60 p-0.5">
                                    <div class="h-full rounded-full transition-all duration-500 sat-blue-bg" 
                                         style="width: {{ max(4, $mathPercent) }}%; background-color: #0284c7 !important;"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-slate-400 font-mono px-0.5">
                                    <span>200</span>
                                    <span>500</span>
                                    <span>800</span>
                                </div>
                            </div>

                            <!-- Module Performance Details -->
                            <div class="pt-5 border-t border-slate-100 space-y-3 text-xs sm:text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600 font-medium">Module 1</span>
                                    <span class="font-bold text-slate-900">{{ $mathM1Correct }} / {{ $mathM1Total }} Correct</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600 font-medium">Module 2</span>
                                    <span class="font-bold text-slate-900">{{ $mathM2Correct }} / {{ $mathM2Total }} Correct</span>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <span class="text-slate-500 text-xs">Section Accuracy</span>
                                    <span class="font-extrabold text-slate-900 text-xs">
                                        {{ $mathTotalQuestions > 0 ? round(($mathTotalCorrect / $mathTotalQuestions) * 100) : 0 }}% ({{ $mathTotalCorrect }}/{{ $mathTotalQuestions }})
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-medium">Review answers:</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route($satRoutePrefix . 'math.practice-test', $mathModule1MeetingNumber ?? 1) }}" 
                                   class="text-xs font-bold text-slate-700 hover:text-sky-600 bg-slate-50 hover:bg-sky-50 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-sky-300 transition">
                                    Module 1
                                </a>
                                <a href="{{ route($satRoutePrefix . 'math.practice-test', $mathModule2MeetingNumber ?? 2) }}" 
                                   class="text-xs font-bold text-slate-700 hover:text-sky-600 bg-slate-50 hover:bg-sky-50 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-sky-300 transition">
                                    Module 2
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Official Knowledge and Skills Performance Bands (College Board Format) -->
                <div class="space-y-5 pt-4 border-t border-slate-100">
                    <div class="space-y-1.5">
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            <span class="w-2 h-5 rounded-full inline-block sat-blue-bg" style="background-color: #0284c7 !important;"></span>
                            <span>Knowledge and Skills Performance</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 pl-4">
                            Performance across core academic content domains defined by the College Board.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <!-- Domain 1: Information and Ideas / Craft and Structure (RW) -->
                        <div class="p-5 sm:p-6 bg-white rounded-2xl border border-slate-200/90 shadow-2xs space-y-5">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100 text-xs">
                                <span class="font-bold text-slate-800 uppercase tracking-wide text-[11px]">Reading and Writing Domains</span>
                                <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Performance Band</span>
                            </div>

                            <div class="space-y-5 text-xs">
                                @php
                                    $rwDomainScore = max(200, min(800, $rwScaledScore));
                                @endphp
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-700 font-medium">Craft and Structure / Information and Ideas</span>
                                        <span class="font-bold px-2 py-0.5 rounded-md sat-blue-badge" style="color: #0284c7 !important; background-color: #f0f9ff !important; border: 1px solid #bae6fd !important;">
                                            {{ $rwDomainScore >= 600 ? 'Advanced' : ($rwDomainScore >= 450 ? 'Proficient' : 'Developing') }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden flex gap-1.5 p-0.5 border border-slate-200/50">
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 350 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 450 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 600 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 700 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-700 font-medium">Standard English Conventions &amp; Expression</span>
                                        <span class="font-bold px-2 py-0.5 rounded-md sat-blue-badge" style="color: #0284c7 !important; background-color: #f0f9ff !important; border: 1px solid #bae6fd !important;">
                                            {{ $rwDomainScore >= 550 ? 'Proficient' : 'Developing' }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden flex gap-1.5 p-0.5 border border-slate-200/50">
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 350 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 480 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 620 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $rwDomainScore >= 720 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Domain 2: Algebra & Advanced Math (Math) -->
                        <div class="p-5 sm:p-6 bg-white rounded-2xl border border-slate-200/90 shadow-2xs space-y-5">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100 text-xs">
                                <span class="font-bold text-slate-800 uppercase tracking-wide text-[11px]">Mathematics Domains</span>
                                <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Performance Band</span>
                            </div>

                            <div class="space-y-5 text-xs">
                                @php
                                    $mathDomainScore = max(200, min(800, $mathScaledScore));
                                @endphp
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-700 font-medium">Algebra &amp; Advanced Math</span>
                                        <span class="font-bold px-2 py-0.5 rounded-md sat-blue-badge" style="color: #0284c7 !important; background-color: #f0f9ff !important; border: 1px solid #bae6fd !important;">
                                            {{ $mathDomainScore >= 600 ? 'Advanced' : ($mathDomainScore >= 450 ? 'Proficient' : 'Developing') }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden flex gap-1.5 p-0.5 border border-slate-200/50">
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 350 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 450 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 600 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 700 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-700 font-medium">Problem-Solving, Data &amp; Geometry</span>
                                        <span class="font-bold px-2 py-0.5 rounded-md sat-blue-badge" style="color: #0284c7 !important; background-color: #f0f9ff !important; border: 1px solid #bae6fd !important;">
                                            {{ $mathDomainScore >= 550 ? 'Proficient' : 'Developing' }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden flex gap-1.5 p-0.5 border border-slate-200/50">
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 350 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 480 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 620 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                        <div class="h-full rounded-full flex-1 transition-all" style="background-color: {{ $mathDomainScore >= 720 ? '#0284c7' : '#e2e8f0' }} !important;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Understanding Your Score (Subtle & Elegant Tooltip Accordion) -->
                <div class="pt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="showScoreInsight = !showScoreInsight" 
                            class="flex items-center justify-between w-full text-left text-xs sm:text-sm font-semibold text-slate-600 hover:text-sky-600 transition py-2 px-3 rounded-xl hover:bg-sky-50/60 cursor-pointer">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 sat-blue-text" style="color: #0284c7 !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Understanding Your Score &amp; Digital SAT Methodology</span>
                        </span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="showScoreInsight ? 'rotate-180 sat-blue-text' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="showScoreInsight" 
                         x-transition 
                         class="mt-3 p-5 rounded-2xl bg-sky-50/50 border border-sky-100/80 text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5"
                         style="display: none;">
                        <p class="font-medium text-slate-700">
                            Digital SAT scores are reported on a scale of 400&ndash;1600. The test is multistage adaptive: your performance on the first module influences the difficulty level of questions presented in the second module, allowing for a precise evaluation within a shorter test duration.
                        </p>
                        <p class="text-xs text-slate-500">
                            There is no penalty for incorrect answers. Review your completed modules above to analyze specific question explanations with your instructor.
                        </p>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="text-xs text-slate-500 font-medium">
                        Target Bahasa Course &bull; Estimasi skor latihan, bukan skor resmi College Board
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route($satRoutePrefix . 'score-report.download', $testNumber) }}" 
                           class="px-5 py-3 rounded-xl border border-[#0284c7] text-[#0284c7] hover:bg-sky-50 font-bold text-xs sm:text-sm transition flex items-center gap-2 cursor-pointer"
                           style="color: #0284c7 !important; border-color: #0284c7 !important;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Score Report (PDF)</span>
                        </a>

                        <a href="{{ route(rtrim($satRoutePrefix, '.')) }}" 
                           class="px-6 py-3 rounded-xl sat-blue-btn font-bold text-xs sm:text-sm transition shadow-sm hover:shadow-md flex items-center gap-2"
                           style="background-color: #0284c7 !important; color: #ffffff !important;">
                            <span>Kembali ke Dashboard SAT</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
