<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Digital SAT 10-Minute Break</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&family=merriweather:300,400,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
@php
    $satRoutePrefix = request()->routeIs('mock-test.*') ? 'mock-test.sat.' : 'assignments.sat.';
@endphp
<body class="h-full bg-slate-900 text-white flex flex-col justify-between font-sans select-none"
      x-data="satBreakTimer()"
      x-init="init()"
      x-cloak>

    <!-- Top Header -->
    <header class="bg-slate-800/80 border-b border-slate-700/80 px-6 py-4 flex items-center justify-between backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <span class="px-2.5 py-1 rounded-md bg-amber-500 text-slate-950 text-xs font-black tracking-wider uppercase">
                Section 1 Selesai
            </span>
            <span class="text-sm font-bold text-slate-200">
                Digital SAT Practice Test: Official Scheduled Break
            </span>
        </div>
        <div>
            <a href="{{ route(rtrim($satRoutePrefix, '.')) }}" class="text-xs font-bold text-slate-400 hover:text-white transition">
                Simpan &amp; Keluar
            </a>
        </div>
    </header>

    <!-- Main Break Display -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="max-w-xl w-full bg-slate-800/90 border border-slate-700 rounded-3xl p-8 sm:p-10 shadow-2xl text-center backdrop-blur-md">
            
            <div class="w-20 h-20 rounded-full bg-amber-500/10 border-2 border-amber-500/40 text-amber-400 mx-auto flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-black tracking-widest uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">
                10-Minute Break (Istirahat Terjadwal)
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-4">
                Section 1: Reading and Writing Telah Selesai!
            </h1>
            <p class="text-slate-300 text-sm mt-2 leading-relaxed">
                Anda telah menyelesaikan 2 Modul (54 Soal) pada bagian Reading and Writing. Sesuai regulasi resmi Digital SAT, Anda memiliki waktu istirahat opsional selama 10 menit sebelum memulai <strong class="text-emerald-400">Section 2: Math</strong>.
            </p>

            <!-- Large Countdown Display -->
            <div class="my-8 p-6 bg-slate-950/60 rounded-2xl border border-slate-700/80 inline-block w-full max-w-sm">
                <div class="text-5xl sm:text-6xl font-black font-mono tracking-wider text-amber-400" x-text="formatTime(breakSeconds)">
                    10:00
                </div>
                <div class="text-xs font-bold text-slate-400 mt-2 uppercase tracking-widest">
                    Sisa Waktu Istirahat
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ route($satRoutePrefix . 'math.practice-test', $mathModule1MeetingNumber ?? 1) }}"
                   class="inline-flex items-center justify-center w-full px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold text-base shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-[1.02] cursor-pointer">
                    <span>Lanjutkan Sekarang ke Section 2: Math (Modul 1)</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>

                <p class="text-xs text-slate-400">
                    *Ujian Math terdiri dari 2 modul (masing-masing 35 menit) dengan kalkulator Desmos bawaan.
                </p>
            </div>
        </div>
    </main>

    <!-- Footer Status -->
    <footer class="bg-slate-900 border-t border-slate-800 px-6 py-3 text-center text-xs text-slate-400">
        Digital SAT Official Adaptive Mockup &bull; Target Bahasa Education System
    </footer>

    <script>
        function satBreakTimer() {
            return {
                breakSeconds: 600, // 10 minutes
                timerInterval: null,

                init() {
                    const saved = sessionStorage.getItem('sat_break_timer');
                    if (saved && !isNaN(saved) && Number(saved) > 0) {
                        this.breakSeconds = Number(saved);
                    }

                    this.timerInterval = setInterval(() => {
                        if (this.breakSeconds > 0) {
                            this.breakSeconds--;
                            sessionStorage.setItem('sat_break_timer', this.breakSeconds);
                        } else {
                            clearInterval(this.timerInterval);
                            sessionStorage.removeItem('sat_break_timer');
                            window.location.href = "{{ route($satRoutePrefix . 'math.practice-test', $mathModule1MeetingNumber ?? 1) }}";
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const m = Math.floor(seconds / 60);
                    const s = seconds % 60;
                    return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
                }
            }
        }
    </script>
</body>
</html>
