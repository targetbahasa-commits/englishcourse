@extends('layouts.admin')

@section('content')
<style>
    @media (min-width: 768px) {
        .dynamic-sidebar-padding {
            padding-left: var(--admin-sidebar-offset, var(--teacher-sidebar-offset, var(--student-sidebar-offset, var(--guest-sidebar-offset, 16rem)))) !important;
        }
    }
</style>
<div class="fixed inset-0 bg-gray-100 p-6 pt-8 overflow-hidden transition-all duration-200 dynamic-sidebar-padding" x-data="speakingEvaluation()">
    <div class="flex flex-col lg:flex-row gap-6 h-full pl-4 lg:pl-8">
        
        <!-- Left Column: Transcripts & Analysis -->
        <div class="w-full lg:w-4/12 flex flex-col gap-6 h-full overflow-hidden">
            <!-- Header -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 shrink-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Hasil Latihan Bicara</h1>
                        <p class="text-gray-500 mt-1">Part {{ $topic['part'] ?? 1 }} — Topic: <span class="font-medium text-gray-700">{{ $topic['title'] ?? 'Unknown Topic' }}</span></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('assignments.ielts-academic.speaking.index', ['part' => $topic['part'] ?? 1]) }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">
                            Back to Topic
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transcripts Scrollable Area -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex-1 overflow-y-auto p-6 custom-scrollbar">
                <div class="flex items-center gap-2 mb-6 sticky top-0 bg-white z-10 py-2 border-b">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                    <h2 class="text-lg font-bold text-gray-800">Transkrip & Analisis Detail</h2>
                </div>

                <div class="space-y-6">
                    @if(isset($result['transcripts']) && count($result['transcripts']) > 0)
                        @foreach($result['transcripts'] as $index => $item)
                        <div class="group">
                            <h3 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Pertanyaan {{ $loop->iteration }}</h3>
                            @php
                                $questionHtml = nl2br(e($item['question']));
                                $questionHtml = preg_replace('/-\s*-\s*/', '• ', $questionHtml);
                                $questionHtml = preg_replace('/(?<=\n|<br>|^)-\s*/', '• ', $questionHtml);
                            @endphp
                            <p class="text-gray-800 font-medium mb-3 leading-relaxed">{!! $questionHtml !!}</p>
                            
                            <div class="relative pl-4 border-l-4 border-indigo-100 group-hover:border-indigo-300 transition-colors">
                                <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed italic">
                                    "{{ $item['answer'] }}"
                                    
                                    @if(isset($item['audio_url']))
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <audio controls class="w-full h-8">
                                                <source src="{{ $item['audio_url'] }}" type="audio/webm">
                                                Browser Anda tidak mendukung elemen audio.
                                            </audio>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-gray-400">
                            Tidak ada transkrip tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Evaluation Scorecard -->
        <div class="w-full lg:w-8/12 h-full flex flex-col min-h-0">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col h-full overflow-hidden">
                <!-- Overall Score Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8 text-white relative overflow-hidden shrink-0">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-center">
                        <div>
                            <p class="text-indigo-100 font-medium mb-1">Skor Band Keseluruhan</p>
                            <div class="text-5xl font-black tracking-tight">{{ $result['overall_score'] ?? '0.0' }}</div>
                        </div>
                        <div class="text-right">
                             <div class="flex gap-1 mb-2">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-indigo-100">Evaluation</p>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex border-b border-gray-100 overflow-x-auto bg-gray-50/50 shrink-0">
                    <button @click="tab = 'general'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'general', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'general'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all">
                        General
                    </button>
                    <button @click="tab = 'fluency'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'fluency', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'fluency'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all">
                        Fluency
                    </button>
                    <button @click="tab = 'lexical'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'lexical', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'lexical'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all">
                        Lexical
                    </button>
                    <button @click="tab = 'grammar'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'grammar', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'grammar'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all">
                        Grammar
                    </button>
                    <button @click="tab = 'pronunciation'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'pronunciation', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'pronunciation'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all">
                        Pronunciation
                    </button>
                    <button @click="tab = 'model_answer'" :class="{'border-indigo-500 text-indigo-600 bg-white': tab === 'model_answer', 'border-transparent text-gray-500 hover:text-gray-700': tab !== 'model_answer'}" class="flex-1 py-4 px-4 text-center text-sm font-bold border-b-2 transition-all whitespace-nowrap">
                        Jawaban Band 9
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="flex-1 overflow-y-auto custom-scrollbar min-h-0 bg-white p-8 md:p-16">
                    <div>
                    <!-- General Tab -->
                    <div x-show="tab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Penguji</h3>
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                {!! $result['general_feedback'] ?? 'Tidak ada umpan balik.' !!}
                            </p>
                        </div>

@php
    $fc_details = $result['categories']['fluency_coherence']['details'] ?? null;
    $lr_details = $result['categories']['lexical_resource']['details'] ?? null;
    $gr_details = $result['categories']['grammatical_range']['details'] ?? null;
    $pr_details = $result['categories']['pronunciation']['details'] ?? null;
    $has_details = $fc_details || $lr_details || $gr_details || $pr_details;
@endphp

@if($has_details)
<h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3 mt-8">Detail Evaluasi Rubrik</h4>
<div class="overflow-x-auto mb-8 border border-gray-200 rounded-lg shadow-sm">
    <table class="min-w-full bg-white text-sm text-left border-collapse">
        <thead class="bg-gray-100 text-gray-700 uppercase font-bold text-xs border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 w-1/4 border-r border-gray-200">Aspects</th>
                <th class="py-3 px-4 w-1/4 border-r border-gray-200">Does candidate ...</th>
                <th class="py-3 px-4 w-5/12 border-r border-gray-200">DESCRIPTION</th>
                <th class="py-3 px-4 w-1/12 text-center">SCORE</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fluency & Coherence -->
            @if($fc_details && count($fc_details) > 0)
                @foreach($fc_details as $index => $detail)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold align-bottom uppercase text-gray-800 border-r border-gray-200" rowspan="{{ count($fc_details) }}">FLUENCY AND COHERENCE</td>
                        @endif
                        <td class="py-3 px-4 text-gray-700 align-bottom border-r border-gray-200">{{ $detail['question'] }}</td>
                        <td class="py-3 px-4 text-gray-600 italic border-r border-gray-200">{{ $detail['description'] }}</td>
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold text-center text-lg align-bottom" rowspan="{{ count($fc_details) }}">{{ $result['categories']['fluency_coherence']['score'] }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif

            <!-- Lexical Resource -->
            @if($lr_details && count($lr_details) > 0)
                @foreach($lr_details as $index => $detail)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold align-bottom uppercase text-gray-800 border-r border-gray-200" rowspan="{{ count($lr_details) }}">LEXICAL RESOURCES</td>
                        @endif
                        <td class="py-3 px-4 text-gray-700 align-bottom border-r border-gray-200">{{ $detail['question'] }}</td>
                        <td class="py-3 px-4 text-gray-600 italic border-r border-gray-200">{{ $detail['description'] }}</td>
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold text-center text-lg align-bottom" rowspan="{{ count($lr_details) }}">{{ $result['categories']['lexical_resource']['score'] }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif

            <!-- Grammatical Range -->
            @if($gr_details && count($gr_details) > 0)
                @foreach($gr_details as $index => $detail)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold align-bottom uppercase text-gray-800 border-r border-gray-200" rowspan="{{ count($gr_details) }}">GRAMMATICAL RANGE AND ACCURACY</td>
                        @endif
                        <td class="py-3 px-4 text-gray-700 align-bottom border-r border-gray-200">{{ $detail['question'] }}</td>
                        <td class="py-3 px-4 text-gray-600 italic border-r border-gray-200">{{ $detail['description'] }}</td>
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold text-center text-lg align-bottom" rowspan="{{ count($gr_details) }}">{{ $result['categories']['grammatical_range']['score'] }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif

            <!-- Pronunciation -->
            @if($pr_details && count($pr_details) > 0)
                @foreach($pr_details as $index => $detail)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold align-bottom uppercase text-gray-800 border-r border-gray-200" rowspan="{{ count($pr_details) }}">PRONUNCIATION</td>
                        @endif
                        <td class="py-3 px-4 text-gray-700 align-bottom border-r border-gray-200">{{ $detail['question'] }}</td>
                        <td class="py-3 px-4 text-gray-600 italic border-r border-gray-200">{{ $detail['description'] }}</td>
                        @if($index === 0)
                            <td class="py-3 px-4 font-bold text-center text-lg align-bottom" rowspan="{{ count($pr_details) }}">{{ $result['categories']['pronunciation']['score'] }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif
            
            <tr class="bg-gray-100 border-t-2 border-gray-300">
                <td class="py-3 px-4 font-bold uppercase text-gray-800 border-r border-gray-200" colspan="3">OVERALL COMMENTS AND BANDSCORE</td>
                <td class="py-3 px-4 font-black text-center text-xl text-gray-900">{{ $result['overall_score'] ?? '0.0' }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endif
                        
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">Rincian Skor</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Fluency & Coherence</span>
                                <span class="font-bold text-gray-800">{{ $result['categories']['fluency_coherence']['score'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Lexical Resource</span>
                                <span class="font-bold text-gray-800">{{ $result['categories']['lexical_resource']['score'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Grammatical Range</span>
                                <span class="font-bold text-gray-800">{{ $result['categories']['grammatical_range']['score'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Pronunciation</span>
                                <span class="font-bold text-gray-800">{{ $result['categories']['pronunciation']['score'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Fluency Tab -->
                    <div x-show="tab === 'fluency'" x-cloak>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Fluency & Coherence</h3>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold text-sm">{{ $result['categories']['fluency_coherence']['score'] ?? '-' }}</span>
                        </div>
                        <div class="prose prose-sm text-gray-600 mb-6">
                             <p>{{ $result['categories']['fluency_coherence']['feedback'] ?? 'Tidak ada umpan balik spesifik.' }}</p>
                        </div>

                        <!-- Fluency Analysis Button -->
                        <div class="mb-6">
                            <button @click="analyzeFluency()" :disabled="analyzingFluency" class="w-full py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!analyzingFluency" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    Analisis Kelancaran
                                </span>
                                <span x-show="analyzingFluency" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menganalisis...
                                </span>
                            </button>
                        </div>

                        <!-- Fluency Analysis Results -->
                        <div x-show="fluencyAnalysis" class="space-y-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            
                            <!-- Errors List -->
                            <div>
                                <h4 class="font-bold text-gray-800 border-b pb-2 mb-3">Masalah Kelancaran Terdeteksi</h4>
                                <div class="space-y-3">
                                    <template x-for="(error, index) in fluencyAnalysis?.errors" :key="index">
                                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex items-start gap-3">
                                            <div class="bg-white p-2 rounded-lg text-blue-600 font-bold text-xs shadow-sm whitespace-nowrap" x-text="error.time"></div>
                                            <div>
                                                <div class="font-bold text-gray-800 text-sm mb-1" x-text="error.type"></div>
                                                <p class="text-xs text-gray-600 italic" x-text="error.detail"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Descriptor Feedback -->
                            <div>
                                <h4 class="font-bold text-gray-800 border-b pb-2 mb-3">Penilaian Berdasarkan Deskriptor (Band 6)</h4>
                                <div class="grid grid-cols-1 gap-3">
                                    <template x-for="(item, index) in fluencyAnalysis?.descriptor_feedback" :key="index">
                                        <div class="p-4 rounded-xl border" 
                                            :class="{
                                                'bg-green-50 border-green-100': item.status === 'positive',
                                                'bg-yellow-50 border-yellow-100': item.status === 'mixed',
                                                'bg-red-50 border-red-100': item.status === 'negative'
                                            }">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg x-show="item.status === 'positive'" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                <svg x-show="item.status === 'mixed'" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                <svg x-show="item.status === 'negative'" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <h5 class="font-bold text-gray-800 text-sm" x-text="item.point"></h5>
                                            </div>
                                            <div class="text-xs text-gray-700 leading-relaxed" x-html="item.description"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lexical Tab -->
                    <div x-show="tab === 'lexical'" x-cloak>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Lexical Resource</h3>
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full font-bold text-sm">{{ $result['categories']['lexical_resource']['score'] ?? '-' }}</span>
                        </div>
                        <div class="prose prose-sm text-gray-600 mb-6">
                             <p>{{ $result['categories']['lexical_resource']['feedback'] ?? 'Tidak ada umpan balik spesifik.' }}</p>
                        </div>

                        <!-- Upgrade Button -->
                        <div class="mb-6">
                            <button @click="upgradeLexical()" :disabled="improving || suggestingCollocations" class="w-full py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!improving" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    Tingkatkan Kosakata
                                </span>
                                <span x-show="improving" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menganalisis...
                                </span>
                            </button>
                        </div>

                        <!-- Improvements List -->
                        <div x-show="lexicalImprovements" class="mb-8 space-y-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            <h4 class="font-bold text-gray-800 border-b pb-2">Peningkatan Kosakata</h4>
                            <template x-for="(item, index) in lexicalImprovements" :key="index">
                                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-red-400 line-through text-sm" x-text="item.original"></span>
                                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        <span class="text-green-600 font-bold bg-green-100 px-2 py-0.5 rounded text-sm shadow-sm" x-text="item.improved"></span>
                                    </div>
                                    <p class="text-xs text-gray-600 italic" x-text="item.explanation"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Collocations Section -->
                        <div class="border-t border-gray-100 pt-6">
                             <button @click="suggestCollocations()" :disabled="improving || suggestingCollocations" class="w-full py-3 bg-white border-2 border-purple-100 text-purple-600 rounded-xl font-bold hover:bg-purple-50 hover:border-purple-200 transition-all flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed mb-6">
                                <span x-show="!suggestingCollocations" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                    Saran Idiom & Collocations
                                </span>
                                <span x-show="suggestingCollocations" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memuat...
                                </span>
                            </button>

                            <!-- Collocations List -->
                            <div x-show="collocations" class="mt-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">Collocations & Idiom Topik</h4>
                                <div class="grid grid-cols-1 gap-3">
                                    <template x-for="(item, index) in collocations" :key="index">
                                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm hover:border-purple-300 transition-colors">
                                            <div class="flex justify-between items-start mb-1">
                                                <span class="font-bold text-purple-700" x-text="item.term"></span>
                                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-gray-100 text-gray-500" x-text="item.type"></span>
                                            </div>
                                            <p class="text-xs text-gray-600 mb-2" x-text="item.definition"></p>
                                            <div class="bg-gray-50 p-2 rounded text-xs italic text-gray-700 border-l-2 border-purple-200">
                                                <span class="font-bold text-purple-400 mr-1">Ex:</span>
                                                <span x-html="item.example"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grammar Tab -->
                    <div x-show="tab === 'grammar'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                         <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Grammatical Range</h3>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-sm">{{ $result['categories']['grammatical_range']['score'] ?? '-' }}</span>
                        </div>
                         <div class="prose prose-sm text-gray-600 mb-6">
                             <p>{{ $result['categories']['grammatical_range']['feedback'] ?? 'Tidak ada umpan balik spesifik.' }}</p>
                        </div>

                         <!-- Grammar Analysis Button -->
                        <div class="mb-6">
                            <button @click="analyzeGrammar()" :disabled="analyzingGrammar" class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!analyzingGrammar" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    Analisis Kesalahan Tata Bahasa
                                </span>
                                <span x-show="analyzingGrammar" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menganalisis...
                                </span>
                            </button>
                        </div>

                        <!-- Grammar Errors List -->
                        <div x-show="grammarErrors" class="space-y-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            <h4 class="font-bold text-gray-800 border-b pb-2">Koreksi Tata Bahasa</h4>
                            <template x-for="(item, index) in grammarErrors" :key="index">
                                <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                    <div class="mb-2">
                                        <div class="text-red-500 line-through text-sm mb-1" x-text="item.original"></div>
                                        <div class="text-gray-800 font-medium text-sm flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            <span x-html="item.correction"></span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-600 italic bg-white p-2 rounded border border-red-100" x-text="item.explanation"></p>
                                </div>
                            </template>
                        </div>


                         <!-- Grammar Upgrade Button -->
                        <div class="mb-6 border-t pt-6">
                            <h4 class="font-bold text-gray-800 mb-3">Band 9 Structures</h4>
                            <button @click="upgradeGrammar()" :disabled="upgradingGrammar" class="w-full py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!upgradingGrammar" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    Upgrade Grammar (Band 9)
                                </span>
                                <span x-show="upgradingGrammar" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Generating Suggestions...
                                </span>
                            </button>
                        </div>

                        <!-- Grammar Upgrades List -->
                        <div x-show="grammarUpgrades" class="space-y-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            <template x-for="(item, index) in grammarUpgrades" :key="index">
                                <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="px-2 py-0.5 rounded bg-indigo-200 text-indigo-800 text-[10px] font-bold uppercase tracking-wider" x-text="item.type"></span>
                                    </div>
                                    <div class="text-gray-800 font-medium text-sm mb-2" x-html="item.example"></div>
                                    <p class="text-xs text-gray-600 italic bg-white p-2 rounded border border-indigo-100" x-text="item.explanation"></p>
                                </div>
                            </template>
                        </div>
                        </div>
                    </div>

                    <!-- Pronunciation Tab -->
                    <!-- Pronunciation Tab -->
                    <div x-show="tab === 'pronunciation'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                         <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Pronunciation</h3>
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold text-sm">{{ $result['categories']['pronunciation']['score'] ?? '-' }}</span>
                        </div>
                         <div class="prose prose-sm text-gray-600 mb-6">
                             <p>{{ $result['categories']['pronunciation']['feedback'] ?? 'No specific feedback.' }}</p>
                        </div>

                         <!-- Pronunciation Analysis Button -->
                        <div class="mb-6">
                            <button @click="analyzePronunciation()" :disabled="analyzingPronunciation" class="w-full py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!analyzingPronunciation" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>
                                    Analisis Pelafalan
                                </span>
                                <span x-show="analyzingPronunciation" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menganalisis Audio...
                                </span>
                            </button>
                        </div>

                        <!-- Pronunciation Analysis Results -->
                        <div x-show="pronunciationAnalysis" class="space-y-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            
                            <!-- Mispronounced Words -->
                            <div>
                                <h4 class="font-bold text-gray-800 border-b pb-2 mb-3">Kata yang Salah Ucap</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <template x-for="(item, index) in pronunciationAnalysis?.mispronounced_words" :key="index">
                                        <div class="bg-red-50 rounded-xl p-4 border border-red-100 shadow-sm">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="font-bold text-gray-900 text-lg" x-text="item.word"></span>
                                                <span class="bg-white text-red-600 px-3 py-1 rounded-full border border-red-100 text-xs font-bold shadow-sm" x-text="item.accuracy + '% Akurasi'"></span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4 mb-3">
                                                <div class="bg-white p-2 rounded-lg border border-red-100">
                                                    <span class="text-xs text-gray-400 uppercase font-bold block mb-1">Anda Ucapkan</span>
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>
                                                        <span class="font-mono text-red-600 font-medium" x-text="item.user_phonetic"></span>
                                                    </div>
                                                </div>
                                                <div class="bg-white p-2 rounded-lg border border-green-100">
                                                     <span class="text-xs text-gray-400 uppercase font-bold block mb-1">Benar</span>
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        <span class="font-mono text-green-600 font-medium" x-text="item.phonetic"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-2 bg-white p-3 rounded-lg border border-red-100/50">
                                                <svg class="w-4 h-4 text-red-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <p class="text-xs text-gray-600 italic" x-text="item.issue"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Categories Score Breakdown -->
                            <div>
                                <h4 class="font-bold text-gray-800 border-b pb-2 mb-3">Analisis Detail</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <template x-for="(cat, index) in pronunciationAnalysis?.categories" :key="index">
                                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 h-full">
                                            <div class="flex justify-between items-center mb-2">
                                                <h5 class="font-bold text-gray-800 text-sm" x-text="cat.name"></h5>
                                                <span class="font-bold text-sm px-2 py-0.5 rounded" 
                                                    :class="{
                                                        'bg-blue-100 text-blue-700': cat.color === 'blue',
                                                        'bg-indigo-100 text-indigo-700': cat.color === 'indigo',
                                                        'bg-purple-100 text-purple-700': cat.color === 'purple',
                                                        'bg-emerald-100 text-emerald-700': cat.color === 'emerald'
                                                    }" 
                                                    x-text="cat.score + '/100'"></span>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                                <div class="h-2 rounded-full transition-all duration-1000" 
                                                    :class="{
                                                        'bg-blue-500': cat.color === 'blue',
                                                        'bg-indigo-500': cat.color === 'indigo',
                                                        'bg-purple-500': cat.color === 'purple',
                                                        'bg-emerald-500': cat.color === 'emerald'
                                                    }" 
                                                    :style="'width: ' + cat.score + '%'"></div>
                                            </div>

                                            <div class="text-xs text-gray-600 leading-relaxed" x-html="cat.feedback"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Band 9 Answer Tab -->
                     <div x-show="tab === 'model_answer'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                          <div class="flex flex-col gap-3 mb-6">
                             <div class="bg-emerald-600 rounded-xl p-6 text-white text-left shadow-sm">
                                 <h3 class="font-bold text-lg mb-2">Jawaban Ideal</h3>
                                 <p class="text-emerald-50 text-sm opacity-90">Lihat bagaimana penutur asli menjawab pertanyaan-pertanyaan ini untuk mendapatkan skor Band 9. Bandingkan jawaban Anda untuk mempelajari kosakata dan struktur baru.</p>
                             </div>

                            <button @click="generateModelAnswers()" :disabled="generatingModelAnswers" class="w-full py-3 bg-white border-2 border-emerald-500 text-emerald-600 rounded-xl font-bold hover:bg-emerald-50 transition-all transform flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span x-show="!generatingModelAnswers" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                    Buatkan Contoh Jawaban
                                </span>
                                <span x-show="generatingModelAnswers" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Sedang Membuat...
                                </span>
                            </button>

                            <div x-show="modelAnswers" class="space-y-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <template x-for="(item, index) in modelAnswers" :key="index">
                                    <div class="bg-emerald-50/50 rounded-xl border border-emerald-100 overflow-hidden">
                                        <div class="bg-emerald-100/50 px-4 py-3 border-b border-emerald-100">
                                            <h4 class="font-bold text-emerald-800 text-sm" x-text="'Q: ' + item.question"></h4>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-gray-800 leading-relaxed italic mb-4">"<span x-text="item.answer"></span>"</p>
                                            <div class="text-xs bg-white p-3 rounded-lg border border-emerald-100 text-emerald-700" x-html="item.highlight"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function speakingEvaluation() {
        return {
            tab: 'general',
            improving: false,
            suggestingCollocations: false,
            analyzingGrammar: false,
            upgradingGrammar: false,
            lexicalImprovements: null,
            collocations: null,
            grammarErrors: null,
            grammarUpgrades: null,
            generatingModelAnswers: false,
            modelAnswers: null,
            analyzingPronunciation: false,
            pronunciationAnalysis: null,
            analyzingFluency: false,
            fluencyAnalysis: null,

            async analyzeFluency() {
                this.analyzingFluency = true;
                this.fluencyAnalysis = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.analyze-fluency') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ transcripts: {{ Js::from($result['transcripts'] ?? []) }} })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.fluencyAnalysis = data.analysis;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal menganalisis kelancaran.');
                } finally {
                    this.analyzingFluency = false;
                }
            },

            async upgradeLexical() {
                this.improving = true;
                this.lexicalImprovements = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.upgrade-lexical') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ transcripts: {{ Js::from($result['transcripts'] ?? []) }} })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.lexicalImprovements = data.improvements;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal meningkatkan kosakata.');
                } finally {
                    this.improving = false;
                }
            },

            async suggestCollocations() {
                this.suggestingCollocations = true;
                this.collocations = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.collocations') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ topic: '{{ $topic['slug'] ?? '' }}' })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.collocations = data.collocations;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal mengambil saran collocations.');
                } finally {
                    this.suggestingCollocations = false;
                }
            },

            async analyzeGrammar() {
                this.analyzingGrammar = true;
                this.grammarErrors = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.check-grammar') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ transcripts: {{ Js::from($result['transcripts'] ?? []) }} })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.grammarErrors = data.errors;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal menganalisis tata bahasa.');
                } finally {
                    this.analyzingGrammar = false;
                }
            },



            async upgradeGrammar() {
                this.upgradingGrammar = true;
                this.grammarUpgrades = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.upgrade-grammar') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ 
                            transcripts: {{ Js::from($result['transcripts'] ?? []) }},
                            topic: '{{ $topic['slug'] ?? '' }}'
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.grammarUpgrades = data.upgrades;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal meningkatkan tata bahasa.');
                } finally {
                    this.upgradingGrammar = false;
                }
            },

            async generateModelAnswers() {
                this.generatingModelAnswers = true;
                this.modelAnswers = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.model-answer') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ transcripts: {{ Js::from($result['transcripts'] ?? []) }} })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.modelAnswers = data.model_answers;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal menyusun contoh jawaban.');
                } finally {
                    this.generatingModelAnswers = false;
                }
            },

            async analyzePronunciation() {
                this.analyzingPronunciation = true;
                this.pronunciationAnalysis = null; // Reset
                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.analyze-pronunciation') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ transcripts: {{ Js::from($result['transcripts'] ?? []) }} })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        this.pronunciationAnalysis = data.analysis;
                    }
                } catch (e) {
                    console.error(e);
                    alert('Gagal menganalisis pelafalan.');
                } finally {
                    this.analyzingPronunciation = false;
                }
            },

            init() {
                // Future initialization if needed
            }
        }
    }
</script>

<style>
    /* Custom Scrollbar for better aesthetics */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    [x-cloak] { display: none !important; }
</style>
@endsection
