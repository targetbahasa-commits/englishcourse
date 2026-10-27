@extends('layouts.admin')

@section('title', 'Self-Study Class')

@section('content')
<div class="p-6 md:p-8 space-y-8 pb-32">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold font-serif text-gray-900">Self-Study Class</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        {{ count($selfStudyCards) }} Modul Mandiri
                    </span>
                </div>
                <p class="text-gray-500 mt-1">Pusat pembelajaran mandiri untuk mengasah Grammar, IELTS Academic Writing, dan Digital SAT Preparation.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Assignment
            </a>
            @if(Auth::check() && in_array(strtolower(Auth::user()->active_role ?? Auth::user()->role), ['admin', 'superadmin', 'intern', 'teacher']))
            <a href="{{ route('admin.writing-practice-submissions.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Hasil & Nilai Submission
            </a>
            @endif
        </div>
    </div>

    <!-- Self-Study Cards Grid -->
    <div>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Program Belajar Mandiri (Self-Study Cards)</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih salah satu kelas di bawah ini untuk mengakses materi, latihan soal, dan panduan belajar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach($selfStudyCards as $card)
                <div class="group relative bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
                    
                    <!-- Top Gradient Header with Icon -->
                    <div>
                        <div class="h-32 bg-gradient-to-br {{ $card['gradient'] }} relative p-6 flex items-start justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm {{ $card['accent'] }} shadow-sm">
                                {{ $card['tag'] }}
                            </span>
                            <span class="text-xs font-medium text-white/90 bg-black/20 px-3 py-1 rounded-full backdrop-blur-xs">
                                {{ $card['stats_label'] }}
                            </span>

                            <!-- Floating Card Icon -->
                            <div class="absolute -bottom-6 left-6 w-14 h-14 bg-white rounded-2xl shadow-lg border border-gray-100 flex items-center justify-center text-gray-800 group-hover:scale-105 transition-transform">
                                @if($card['icon'] === 'document-text')
                                    <svg class="w-7 h-7 {{ $card['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($card['icon'] === 'chart-bar')
                                    <svg class="w-7 h-7 {{ $card['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                @elseif($card['icon'] === 'academic-cap')
                                    <svg class="w-7 h-7 {{ $card['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path>
                                    </svg>
                                @else
                                    <svg class="w-7 h-7 {{ $card['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="pt-10 px-6 pb-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $card['title'] }}
                            </h3>
                            <p class="text-xs font-semibold text-gray-500 mt-1 mb-3">
                                {{ $card['subtitle'] }}
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $card['description'] }}
                            </p>

                            <!-- Highlights List -->
                            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Cakupan Materi:</p>
                                <ul class="space-y-1.5">
                                    @foreach($card['highlights'] as $highlight)
                                        <li class="flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>{{ $highlight }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer & Action -->
                    <div class="p-6 pt-2">
                        <a href="{{ $card['route'] }}" class="flex items-center justify-center gap-2 w-full text-center bg-gray-900 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 text-sm shadow-sm hover:shadow group-hover:bg-blue-600">
                            <span>Buka Kelas Mandiri</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
