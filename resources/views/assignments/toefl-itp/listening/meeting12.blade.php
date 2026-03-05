@extends('layouts.admin')

@section('content')
<style>
    /* Custom Scrollbar - Forced Visibility */
    div.custom-scrollbar::-webkit-scrollbar {
        width: 10px !important;
        height: 10px !important;
        display: block !important;
    }
    div.custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9 !important; /* slate-100 */
        border-radius: 4px;
    }
    div.custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #94a3b8 !important; /* slate-400 */
        border-radius: 4px;
        border: 2px solid #f1f5f9 !important;
    }
    div.custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #64748b !important; /* slate-500 */
    }
    /* Firefox */
    div.custom-scrollbar {
        scrollbar-width: auto !important;
        scrollbar-color: #94a3b8 #f1f5f9 !important;
    }
    /* Force white background for this page */
    
    
    
    
    
    body {
        background-color: white !important;
    }
    
    /* TOEFL Listening Answer Styling */
    
    
    

    /* Student Result Feedback Overrides */
    .answer-label.is-correct {
        background-color: #dcfce7 !important; /* green-100 */
        border: 2px solid #22c55e !important; /* green-500 */
    }
    .answer-label.is-correct span {
        color: #15803d !important; /* green-700 */
        font-weight: bold;
    }
    
    .answer-label.is-wrong {
        background-color: #fef2f2 !important; /* red-50 */
        border: 2px solid #ef4444 !important; /* red-500 */
    }
    .answer-label.is-wrong span {
        color: #991b1b !important; /* red-800 */
    }
</style>

<div class="container mx-auto px-4 py-8 relative bg-white min-h-screen">
    
    {{-- Main Paper Card --}}
    <div class="bg-white max-w-7xl mx-auto rounded-xl shadow-lg border border-gray-100 p-8 md:p-12 relative overflow-hidden">
        
        {{-- Top Decoration --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

        {{-- Header Section --}}
        <div class="mb-10 border-b border-gray-100 pb-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Latihan Soal</h1>
                <div class="flex items-center gap-2 px-4 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    TOEFL Listening
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                <p class="mb-3 text-gray-700 leading-relaxed"><strong class="text-gray-900">Focus:</strong> listening to dialogs that involve agreement and disagreement, and answering questions about them.</p>
                <p class="mb-0 text-gray-700 leading-relaxed"><strong class="text-gray-900">Directions:</strong> listen to the following dialogs. Decide which choice <span class="bg-white px-2 py-0.5 rounded border border-gray-200 text-sm font-mono">(A)</span>, <span class="bg-white px-2 py-0.5 rounded border border-gray-200 text-sm font-mono">(B)</span>, or <span class="bg-white px-2 py-0.5 rounded border border-gray-200 text-sm font-mono">(C)</span> best answers the question and mark the appropriate answer. The first one is done as an example.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg flex items-center shadow-sm">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-center shadow-sm">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-red-800 font-bold">Validation Error</h3>
                </div>
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!isset($set))
            {{-- Practice Buttons Section - Only show when no set is selected --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Pilih Latihan</h2>
                    @if(Auth::user()->isAdmin())
                        <div class="flex items-center gap-2">
                            {{-- Remove Set Button --}}
                            <form action="{{ route('assignments.toefl-itp.listening.meeting.remove-set', ['number' => $number]) }}" 
                                  method="POST"
                                  id="removeSetForm">
                                @csrf
                                <input type="hidden" name="set_number" id="removeSetNumber" value="">
                                <button type="button"
                                        onclick="removeSetClicked()"
                                        class="p-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors"
                                        title="Remove Practice Set">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                            </form>

                            {{-- Add Set Button --}}
                            <form action="{{ route('assignments.toefl-itp.listening.meeting.add-set', ['number' => $number]) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="p-2 bg-green-100 text-green-600 rounded-full hover:bg-green-200 transition-colors"
                                        title="Add New Practice Set">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($availableSets as $s)
                        @php
                            // Cycle colors: Blue, Indigo, Purple, Pink, Rose, Amber...
                            $colors = [
                                ['from' => 'from-blue-500', 'to' => 'to-blue-600'],
                                ['from' => 'from-indigo-500', 'to' => 'to-indigo-600'],
                                ['from' => 'from-purple-500', 'to' => 'to-purple-600'],
                                ['from' => 'from-pink-500', 'to' => 'to-pink-600'],
                                ['from' => 'from-rose-500', 'to' => 'to-rose-600'],
                                ['from' => 'from-amber-500', 'to' => 'to-amber-600'],
                            ];
                            $color = $colors[($s - 1) % count($colors)];
                        @endphp

                        <div class="relative group">
                            @if(Auth::user()->isAdmin())
                                <form action="{{ route('assignments.toefl-itp.listening.meeting.remove-set', ['number' => $number]) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus Latihan {{ $s }}? Semua soal di dalamnya akan dihapus.');"
                                      class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    <input type="hidden" name="set_number" value="{{ $s }}">
                                    <button type="submit" class="p-1.5 bg-white/20 hover:bg-red-500 hover:text-white text-white rounded-full transition-colors backdrop-blur-sm" title="Hapus Latihan {{ $s }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif

                        <a href="{{ route('assignments.toefl-itp.listening.meeting.practice', ['number' => $number, 'set' => $s]) }}" 
                           class="block p-6 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">
                                        {{ $s == 3 && $number == 2 ? 'Review' : 'Latihan ' . $s }}
                                    </h3>
                                </div>
                                <svg class="w-6 h-6 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <p class="text-blue-50 text-sm">
                                {{ $s == 3 && $number == 2 ? 'Latihan gabungan (Review)' : 'Klik untuk memulai latihan ' . $s }}
                            </p>
                        </a>
                        </div>
                    @endforeach
                </div>
            </div>     {{-- Back Button --}}
                <div class="mt-8 flex justify-start">
                    <a href="{{ route('assignments.toefl-itp.listening') }}" class="px-8 py-3 bg-white border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        @else
            {{-- Questions Section - Only show when a set is selected --}}
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-blue-800 font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Latihan {{ $set }}
                </p>
            </div>

            {{-- Audio Player Section - Fixed/Floating --}}
            <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b-2 border-indigo-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                            </div>
                            <span class="text-lg font-bold text-indigo-900">Audio Session - Latihan {{ $set }}</span>
                        </div>
                        
                        {{-- Custom Audio Player with Skip Controls --}}
                        <div class="flex-1 flex items-center gap-3 max-w-3xl">
                            {{-- Backward 10s Button --}}
                            <button type="button" onclick="skipAudio(-10)" 
                                    class="p-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Mundur 10 detik">
                                <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                                </svg>
                            </button>

                            {{-- Play/Pause Button --}}
                            <button type="button" id="playPauseBtn" onclick="togglePlayPause()" 
                                    class="p-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors flex-shrink-0">
                                <svg id="playIcon" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <svg id="pauseIcon" class="w-6 h-6 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                                </svg>
                            </button>

                            {{-- Progress Bar Container --}}
                            <div class="flex-1 flex flex-col gap-1">
                                {{-- Time Display --}}
                                <div class="flex justify-between text-xs text-indigo-700 font-medium">
                                    <span id="currentTime">0:00</span>
                                    <span id="duration">0:00</span>
                                </div>
                                
                                {{-- Seekable Progress Bar --}}
                                <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                                    <div id="progressBar" class="absolute h-full bg-indigo-600 rounded-full transition-all" style="width: 0%"></div>
                                    <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                                </div>
                            </div>

                            {{-- Forward 10s Button --}}
                            <button type="button" onclick="skipAudio(10)" 
                                    class="p-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Maju 10 detik">
                                <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                                </svg>
                            </button>

                            {{-- Transcript Toggle Button --}}
                            @if(isset($transcript_enabled) && $transcript_enabled)
                                <button type="button" onclick="toggleTranscriptDrawer()" 
                                        class="p-2 bg-yellow-400 border-2 border-yellow-500 hover:bg-yellow-500 rounded-lg transition-colors flex-shrink-0 flex items-center gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                                    <svg class="w-5 h-5 text-black group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-black hidden sm:inline">Terjemah</span>
                                </button>
                            @endif

                            {{-- Hidden Audio Element --}}
                            <audio id="mainAudio" class="hidden" preload="auto">
                                <source src="{{ $questions->first() && $questions->first()->audio_file ? asset($questions->first()->audio_file) : '' }}" type="audio/mpeg">
                            </audio>
                        </div>

                        {{-- Admin Upload Audio Button --}}
                        @if(Auth::user()->isAdmin())
                            <div class="flex gap-2">
                                <button type="button" 
                                        onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" 
                                        class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Upload SRT
                                </button>
                                
                                <button type="button" 
                                        onclick="console.log('Upload button clicked'); document.getElementById('uploadAudioModal').classList.remove('hidden');" 
                                        class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload Audio
                                </button>
                            </div>
                        @endif
                    </div>
                    {{-- Transcript Drawer (Collapsible) --}}
                    @if(isset($transcript_enabled) && $transcript_enabled)
                        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex flex-col transition-all duration-300 ease-in-out shadow-md">
                            <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                                {{-- English Column --}}
                                <div class="flex flex-col h-full bg-slate-50">
                                    {{-- Header --}}
                                    <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                                        <div class="flex items-center gap-2">
                                            <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                                        </div>
                                        <div class="flex items-center gap-2">
                                            {{-- Sync Controls --}}
                                            <div class="flex items-center gap-2">
                                                <label class="flex items-center gap-1 cursor-pointer text-xs text-slate-500 hover:text-slate-700" title="Toggle Auto-Scroll">
                                                    <input type="checkbox" id="autoScrollToggle" checked class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-3.5 h-3.5">
                                                    <span>Auto-Scroll</span>
                                                </label>
                                                
                                                <div class="flex items-center rounded-md bg-white border border-gray-300 shadow-sm overflow-hidden" title="Adjust Sync">
                                                    <button onclick="adjustSync(-0.5)" class="px-2 py-0.5 hover:bg-gray-100 text-xs text-gray-600 border-r border-gray-200 font-mono transition-colors">&laquo;</button>
                                                    <span id="syncOffsetDisplay" class="px-2 py-0.5 text-xs text-gray-500 font-mono min-w-[40px] text-center">0s</span>
                                                    <button onclick="adjustSync(0.5)" class="px-2 py-0.5 hover:bg-gray-100 text-xs text-gray-600 border-l border-gray-200 font-mono transition-colors">&raquo;</button>
                                                </div>
                                            </div>

                                            @if(Auth::user()->isAdmin())
                                                <button onclick="document.getElementById('editTranscriptModal').classList.remove('hidden')" class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded hover:bg-blue-200">Edit</button>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Content Wrapper --}}
                                    <div class="flex-1 relative overflow-hidden">
                                        <div id="transcript-en" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                                            @if($questions->first() && $questions->first()->transcript_en)
                                                @php
                                                    $transcriptEn = $questions->first()->transcript_en;
                                                    $isJsonEn = false;
                                                    $jsonEn = json_decode($transcriptEn, true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn)) {
                                                        $isJsonEn = true;
                                                    }
                                                @endphp

                                                @if($isJsonEn)
                                                    <div class="space-y-2">
                                                        @foreach($jsonEn as $block)
                                                            @php
                                                                $words = explode(' ', $block['text']);
                                                                $startTime = $block['start'];
                                                                $totalDuration = $block['end'] - $startTime;
                                                                $wordCount = count($words);
                                                                $durationPerWord = $wordCount > 0 ? $totalDuration / $wordCount : 0;
                                                            @endphp
                                                            <div class="mb-2">
                                                                @foreach($words as $index => $word)
                                                                    @php
                                                                        $wordStart = $startTime + ($index * $durationPerWord);
                                                                        $wordEnd = $startTime + (($index + 1) * $durationPerWord);
                                                                    @endphp
                                                                    <span class="transcript-word cursor-pointer hover:bg-yellow-100 transition-colors duration-200 rounded px-0.5 inline-block"
                                                                          data-start="{{ $wordStart }}"
                                                                          data-end="{{ $wordEnd }}"
                                                                          onclick="seekAudio({{ $wordStart }})">
                                                                        {{ $word }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    {!! nl2br(e($transcriptEn)) !!}
                                                @endif
                                            @else
                                                <div class="text-center text-slate-400 italic mt-4">No transcript available.</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Indonesian Column --}}
                                <div class="flex flex-col h-full bg-indigo-50">
                                    {{-- Header --}}
                                    <div class="flex-none px-4 py-2 bg-indigo-100 border-b border-indigo-200 font-semibold text-indigo-800 flex items-center justify-between z-10">
                                          <div class="flex items-center gap-2">
                                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Terjemahan Indonesia
                                          </div>
                                          <button onclick="toggleTranscriptDrawer()" class="text-gray-400 hover:text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                          </button>
                                    </div>
                                    
                                    {{-- Content Wrapper --}}
                                    <div class="flex-1 relative overflow-hidden">
                                        <div id="transcript-id" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-indigo-900/80 custom-scrollbar pr-2">
                                            @if($questions->first() && $questions->first()->transcript_id)
                                                @php
                                                    $transcriptId = $questions->first()->transcript_id;
                                                    $isJsonId = false;
                                                    $jsonId = json_decode($transcriptId, true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($jsonId)) {
                                                        $isJsonId = true;
                                                    }
                                                @endphp

                                                @if($isJsonId)
                                                    <div class="space-y-2">
                                                        @foreach($jsonId as $block)
                                                            @php
                                                                $words = explode(' ', $block['text']);
                                                                $startTime = $block['start'];
                                                                $totalDuration = $block['end'] - $startTime;
                                                                $wordCount = count($words);
                                                                $durationPerWord = $wordCount > 0 ? $totalDuration / $wordCount : 0;
                                                            @endphp
                                                            <div class="mb-2">
                                                                @foreach($words as $index => $word)
                                                                    @php
                                                                        $wordStart = $startTime + ($index * $durationPerWord);
                                                                        $wordEnd = $startTime + (($index + 1) * $durationPerWord);
                                                                    @endphp
                                                                    <span class="transcript-word-id cursor-pointer hover:bg-yellow-100 transition-colors duration-200 rounded px-0.5 inline-block"
                                                                          data-start="{{ $wordStart }}"
                                                                          data-end="{{ $wordEnd }}"
                                                                          onclick="seekAudio({{ $wordStart }})">
                                                                        {{ $word }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    {!! nl2br(e($transcriptId)) !!}
                                                @endif
                                            @else
                                                 <div class="text-center text-indigo-400 italic mt-4">Belum ada terjemahan.</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Bottom Collapse Bar --}}
                            <div class="bg-gray-50 border-t border-gray-200 py-1 flex justify-center hover:bg-gray-100 transition-colors cursor-pointer group" onclick="toggleTranscriptDrawer()" title="Tutup Transkrip">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" transform="rotate(-90 12 12)"></path>
                                </svg>
                            </div>
                        </div>

                        <script>
                            function seekAudio(time) {
                                const audio = document.getElementById('mainAudio');
                                if (audio) {
                                    audio.currentTime = time;
                                    audio.play();
                                }
                            }

                            document.addEventListener('DOMContentLoaded', function() {
                                const audio = document.getElementById('mainAudio');
                                if (!audio) return;

                                let animationFrameId;
                                let syncOffset = 0;
                                let isAutoScroll = true;

                                const autoScrollToggle = document.getElementById('autoScrollToggle');
                                if (autoScrollToggle) {
                                    autoScrollToggle.addEventListener('change', function() {
                                        isAutoScroll = this.checked;
                                    });
                                }

                                window.openTranscriptDrawer = function() {
                                    const drawer = document.getElementById('transcriptDrawer');
                                    if (drawer.classList.contains('hidden')) {
                                        drawer.classList.remove('hidden');
                                        // Force reflow
                                        void drawer.offsetWidth;
                                        drawer.classList.remove('h-0');
                                        drawer.classList.add('h-80');
                                    }
                                };

                                window.closeTranscriptDrawer = function() {
                                    const drawer = document.getElementById('transcriptDrawer');
                                    if (!drawer.classList.contains('hidden')) {
                                        drawer.classList.remove('h-80');
                                        drawer.classList.add('h-0');
                                        setTimeout(() => {
                                            drawer.classList.add('hidden');
                                        }, 300);
                                    }
                                };

                                window.toggleTranscriptDrawer = function() {
                                    const drawer = document.getElementById('transcriptDrawer');
                                    if (drawer.classList.contains('hidden')) {
                                        openTranscriptDrawer();
                                    } else {
                                        closeTranscriptDrawer();
                                    }
                                };

                                window.jumpToTime = function(seconds) {
                                    if (seconds === null || seconds === undefined) return;
                                    
                                    // Ensure drawer is open
                                    openTranscriptDrawer();
                                    
                                    // Seek audio
                                    const audio = document.getElementById('mainAudio');
                                    if (audio) {
                                        audio.currentTime = seconds;
                                        
                                        // Optional: Auto-play if not playing?
                                        if (audio.paused) {
                                            audio.play().catch(e => console.log('Autoplay blocked:', e));
                                        }
                                    }
                                };

                                // Expose adjustSync to global scope
                                window.adjustSync = function(offset) {
                                    syncOffset += offset;
                                    // Round to 1 decimal place to avoid floating point errors
                                    syncOffset = Math.round(syncOffset * 10) / 10;
                                    
                                    const display = document.getElementById('syncOffsetDisplay');
                                    if(display) {
                                        const sign = syncOffset > 0 ? '+' : '';
                                        display.textContent = `${sign}${syncOffset}s`;
                                        // Visual feedback based on offset direction
                                        if (syncOffset > 0) display.className = "px-2 py-0.5 text-xs font-mono min-w-[40px] text-center text-green-600 font-bold";
                                        else if (syncOffset < 0) display.className = "px-2 py-0.5 text-xs font-mono min-w-[40px] text-center text-red-600 font-bold";
                                        else display.className = "px-2 py-0.5 text-xs text-gray-500 font-mono min-w-[40px] text-center";
                                    }
                                    
                                    // Force update immediately
                                    updateHighlights();
                                };

                                function updateHighlights() {
                                    const currentTime = audio.currentTime + syncOffset; // Apply offset here

                                    // Efficiency: select all words once, or cache them? 
                                    // For now, selecting each frame is okay for small text, but let's optimize slightly by defining selector outside if possible.
                                    // Actually, just running the loop is fine for modern browsers for < 1000 elements.
                                    
                                    // Highlight English
                                    const enWords = document.querySelectorAll('#transcript-en .transcript-word');
                                    let enScrolled = false;
                                    
                                    enWords.forEach(segment => {
                                        const start = parseFloat(segment.getAttribute('data-start'));
                                        const end = parseFloat(segment.getAttribute('data-end'));

                                        if (currentTime >= start && currentTime <= end) {
                                            if (!segment.classList.contains('active-word')) {
                                                segment.classList.add('active-word', 'bg-yellow-300', 'text-black', 'font-bold', 'scale-110');
                                                if (isAutoScroll && !enScrolled) {
                                                    const enContainer = document.getElementById('transcript-en');
                                                    const parentDiv = segment.closest('div.mb-2');
                                                    if (enContainer && parentDiv) {
                                                        const offsetTop = parentDiv.offsetTop;
                                                        enContainer.scrollTop = offsetTop - 40;
                                                        enScrolled = true;
                                                    }
                                                }
                                            }
                                        } else {
                                            if (segment.classList.contains('active-word')) {
                                                segment.classList.remove('active-word', 'bg-yellow-300', 'text-black', 'font-bold', 'scale-110');
                                            }
                                        }
                                    });

                                    // Highlight Indonesian
                                    const idWords = document.querySelectorAll('#transcript-id .transcript-word-id');
                                    let idScrolled = false;
                                    
                                    idWords.forEach(segment => {
                                        const start = parseFloat(segment.getAttribute('data-start'));
                                        const end = parseFloat(segment.getAttribute('data-end'));

                                        if (currentTime >= start && currentTime <= end) {
                                            if (!segment.classList.contains('active-word')) {
                                                segment.classList.add('active-word', 'bg-yellow-300', 'text-black', 'font-bold', 'scale-110');
                                                if (isAutoScroll && !idScrolled) {
                                                    const idContainer = document.getElementById('transcript-id');
                                                    const parentDiv = segment.closest('div.mb-2');
                                                    if (idContainer && parentDiv) {
                                                        const offsetTop = parentDiv.offsetTop;
                                                        idContainer.scrollTop = offsetTop - 40;
                                                        idScrolled = true;
                                                    }
                                                }
                                            }
                                        } else {
                                            if (segment.classList.contains('active-word')) {
                                                segment.classList.remove('active-word', 'bg-yellow-300', 'text-black', 'font-bold', 'scale-110');
                                            }
                                        }
                                    });

                                    if (!audio.paused) {
                                        animationFrameId = requestAnimationFrame(updateHighlights);
                                    }
                                }

                                audio.addEventListener('play', function() {
                                    cancelAnimationFrame(animationFrameId);
                                    updateHighlights();
                                });

                                audio.addEventListener('pause', function() {
                                    cancelAnimationFrame(animationFrameId);
                                });

                                audio.addEventListener('ended', function() {
                                    cancelAnimationFrame(animationFrameId);
                                });
                                
                                // Fallback for seeking while paused
                                audio.addEventListener('seeked', function() {
                                    if(audio.paused) updateHighlights();
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
            </div>

            {{-- Spacer to prevent content from being hidden under fixed player --}}
            <div class="h-20 mb-8"></div>



            {{-- Edit Transcript Modal --}}
    @if(Auth::user()->isAdmin())
        <div id="editTranscriptModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Transcript (Set {{ $set }})</h3>
                    <form action="{{ route('assignments.toefl-itp.listening.meeting.update-transcript', ['number' => $number, 'set' => $set]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">English Script</label>
                            <textarea name="transcript_en" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $questions->first() ? $questions->first()->transcript_en : '' }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Use newline for paragraphs.</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Indonesian Translation</label>
                            <textarea name="transcript_id" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $questions->first() ? $questions->first()->transcript_id : '' }}</textarea>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('editTranscriptModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- JavaScript for Audio Player Controls --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const audio = document.getElementById('mainAudio');
                    const playPauseBtn = document.getElementById('playPauseBtn');
                    const playIcon = document.getElementById('playIcon');
                    const pauseIcon = document.getElementById('pauseIcon');
                    const progressBar = document.getElementById('progressBar');
                    const progressHandle = document.getElementById('progressHandle');
                    const progressContainer = document.getElementById('progressContainer');
                    const currentTimeDisplay = document.getElementById('currentTime');
                    const durationDisplay = document.getElementById('duration');

                    if (!audio || !progressContainer) {
                        console.error('Audio player elements not found');
                        return;
                    }

                    // Force load audio metadata
                    audio.load();

                    // Error handling
                    audio.addEventListener('error', function(e) {
                         console.error('Audio Error:', e);
                         const errorCode = audio.error ? audio.error.code : 'unknown';
                         const errorMsg = {
                             1: 'MEDIA_ERR_ABORTED',
                             2: 'MEDIA_ERR_NETWORK',
                             3: 'MEDIA_ERR_DECODE',
                             4: 'MEDIA_ERR_SRC_NOT_SUPPORTED'
                         }[errorCode] || 'Unknown Error';
                         
                         @if(Auth::user()->isAdmin())
                            alert('Audio Error: ' + errorMsg + '. Check console for details. Path: ' + audio.currentSrc);
                         @endif
                    });

                    let isDragging = false;

                    // Format time in MM:SS
                    function formatTime(seconds) {
                        if (isNaN(seconds)) return '0:00';
                        const mins = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${mins}:${secs.toString().padStart(2, '0')}`;
                    }

                    // Toggle play/pause
                    window.togglePlayPause = function() {
                        if (audio.paused) {
                            audio.play();
                            playIcon.classList.add('hidden');
                            pauseIcon.classList.remove('hidden');
                        } else {
                            audio.pause();
                            playIcon.classList.remove('hidden');
                            pauseIcon.classList.add('hidden');
                        }
                    };

                    // Skip audio by seconds
                    window.skipAudio = function(seconds) {
                        if (audio && audio.duration) {
                            const newTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                            console.log(`Attempting skip: Current=${audio.currentTime}, Target=${newTime}`);
                            
                            // Check if seekable
                            if (audio.seekable.length > 0) {
                                const ranges = [];
                                for(let i=0; i<audio.seekable.length; i++) {
                                    ranges.push(`${audio.seekable.start(i)}-${audio.seekable.end(i)}`);
                                }
                                console.log('Seekable ranges:', ranges.join(', '));
                            } else {
                                console.warn('Audio reports no seekable ranges');
                            }

                            audio.currentTime = newTime;
                            
                            // Check immediately after
                            setTimeout(() => {
                                console.log(`After skip: Current=${audio.currentTime}`);
                            }, 100);
                        }
                    };

                    // Seek to position when clicking or dragging progress bar
                    function seekAudio(event) {
                        if (!audio.duration) return;
                        
                        const rect = progressContainer.getBoundingClientRect();
                        const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
                        const clickX = clientX - rect.left;
                        const width = rect.width;
                        
                        // Validasi koordinat
                        console.log(`Seek Debug: ClientX=${clientX}, RectLeft=${rect.left}, ClickX=${clickX}, Width=${width}`);
                        
                        if (width === 0) {
                            console.warn('Progress bar width is 0, cannot calculate percentage');
                            return;
                        }

                        let percentage = clickX / width;
                        percentage = Math.max(0, Math.min(1, percentage));
                        
                        const newTime = percentage * audio.duration;
                        console.log(`Seek Calc: %=${percentage.toFixed(4)}, TargetTime=${newTime.toFixed(2)}`);
                        
                        audio.currentTime = newTime;
                    }

                    // Mouse down on progress bar
                    progressContainer.addEventListener('mousedown', (e) => {
                        isDragging = true;
                        seekAudio(e);
                        e.preventDefault();
                    });

                    // Mouse move - drag to seek
                    document.addEventListener('mousemove', (e) => {
                        if (isDragging) {
                            seekAudio(e);
                        }
                    });

                    // Mouse up - stop dragging
                    document.addEventListener('mouseup', () => {
                        if (isDragging) {
                            isDragging = false;
                        }
                    });

                    // Touch support for mobile
                    progressContainer.addEventListener('touchstart', (e) => {
                        isDragging = true;
                        const touch = e.touches[0];
                        seekAudio(touch);
                        e.preventDefault();
                    });

                    document.addEventListener('touchmove', (e) => {
                        if (isDragging) {
                            const touch = e.touches[0];
                            seekAudio(touch);
                        }
                    });

                    document.addEventListener('touchend', () => {
                        if (isDragging) {
                            isDragging = false;
                        }
                    });

                    // Update progress bar and time display
                    audio.addEventListener('timeupdate', () => {
                        if (audio.duration && !isDragging) {
                            const percentage = (audio.currentTime / audio.duration) * 100;
                            progressBar.style.width = percentage + '%';
                            progressHandle.style.left = percentage + '%';
                            currentTimeDisplay.textContent = formatTime(audio.currentTime);
                        }
                    });

                    // Set duration when metadata is loaded
                    audio.addEventListener('loadedmetadata', () => {
                        durationDisplay.textContent = formatTime(audio.duration);
                        console.log('Audio loaded. Duration:', audio.duration);
                    });

                    // Reset play button when audio ends
                    audio.addEventListener('ended', () => {
                        playIcon.classList.remove('hidden');
                        pauseIcon.classList.add('hidden');
                    });

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                            e.preventDefault();
                            window.togglePlayPause();
                        } else if (e.code === 'ArrowLeft') {
                            e.preventDefault();
                            window.skipAudio(-10);
                        } else if (e.code === 'ArrowRight') {
                            e.preventDefault();
                            window.skipAudio(10);
                        }
                    });

                    console.log('Audio player initialized successfully');
                });
            </script>



        @endif

        @if(isset($set))
        <form method="POST" action="{{ route('assignments.toefl-itp.listening.meeting.submit', $number) }}">
            @csrf
            <input type="hidden" name="set_number" value="{{ $set }}">
            
            {{-- Instruction Header --}}
            <p class="mb-4 text-gray-700 font-medium h7-instruction">Putar audio, ulangi jika perlu hingga semua alike-sound jawaban bergaris bawah.</p>

            {{-- Two Column Layout --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            @php
                $splitIndex = ceil($questions->count() / 2);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-0">
                
            {{-- Parse Transcript timestamps map --}}
            @php
                $questionTimestamps = [];
                $numberWords = [
                    1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
                    6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
                    11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen'
                ];

                if ($questions->isNotEmpty() && $questions->first()->transcript_en) {
                    $decoded = json_decode($questions->first()->transcript_en, true);
                    // Handle double-encoding if necessary, or just use decoded
                    $json = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];

                    if (!empty($json)) {
                        foreach ($questions as $q) {
                            $num = $q->question_number;
                            $word = $numberWords[$num] ?? null;
                            
                            foreach ($json as $block) {
                                $text = $block['text'];
                                $found = false;

                                // 1. Check Numeric patterns: "1.", "1)", "Number 1"
                                // Avoid "2.1" by blocking matches where dot is followed by a digit.
                                // Regex: Prefix + Num bound | Num + (Dot/Paren) + NotDigit
                                if (preg_match('/(?:Number|Question|No\.?)\s+' . $num . '\b|\b' . $num . '[\.\)](?!\d)/i', $text)) {
                                    $found = true;
                                } 
                                // 2. Check Word patterns: "One.", "Number One"
                                // Word form is less likely to be part of a decimal, but safe to check boundaries.
                                elseif ($word && preg_match('/(?:Number|Question|No\.?)\s+' . $word . '\b|\b' . $word . '[\.\)]/i', $text)) {
                                    $found = true;
                                }

                                if ($found) {
                                    $questionTimestamps[$q->id] = $block['start'];
                                    break;
                                }
                            }
                        }
                    }
                }
            @endphp
            <script>
                console.log('--- DEBUG TIMESTAMP PARSING ---');
                const timestamps = @json($questionTimestamps);
                console.log('Timestamps Map:', timestamps);
                
                // Debug Transcript Text (First 50 blocks)
                @if(isset($json) && is_array($json))
                    const transcriptSample = @json(array_slice($json, 0, 50));
                    console.log('Transcript Text Sample:', transcriptSample.map(b => b.text));
                @endif
                console.log('-------------------------------');
            </script>

            {{-- Column 1: Questions 1-{{ $splitIndex }} --}}
            <div class="space-y-0 divide-y divide-gray-100">
                @foreach($questions->take($splitIndex) as $question)
                    <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2 relative">
                        <div class="flex items-baseline gap-3">
                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                            </div>
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <button type="button" 
                                        onclick="openEditQuestionModal({{ $question }})" 
                                        class="absolute top-3 right-10 w-6 h-6 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 flex items-center justify-center text-xs font-bold transition-all shadow-sm hover:scale-110" 
                                        title="Edit Question">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            @endif
                            @if(isset($transcript_enabled) && $transcript_enabled)
                                <button type="button" 
                                        onclick="jumpToTime({{ $questionTimestamps[$question->id] ?? 'null' }})" 
                                        class="absolute top-3 right-2 w-6 h-6 rounded-full bg-purple-100 text-purple-600 hover:bg-purple-200 flex items-center justify-center text-xs font-bold transition-all shadow-sm hover:scale-110" 
                                        title="Lihat Transkrip & Dengar Audio">
                                    ?
                                </button>
                            @endif
                            <div class="flex flex-col gap-2 flex-1">
                                @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                    @if($text !== 'N/A' && $text !== '')
                                    @php
                                        $canSeeKey = auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher());
                                        $isCorrectVal = $canSeeKey ? ($question->correct_answer === $option ? 'true' : 'false') : '';
                                        
                                        // Student Result Highlighting
                                        $studentClass = '';
                                        if (session('score_data')) {
                                            $userAnswers = session('score_data')['user_answers'];
                                            $userAns = $userAnswers[$question->id] ?? null;
                                            $correctAns = $question->correct_answer;
                                            
                                            if ($option === $correctAns) {
                                                // Correct Answer always Green
                                                $studentClass = 'is-correct'; 
                                            } elseif ($option === $userAns && $userAns !== $correctAns) {
                                                // Wrong User Answer Red
                                                $studentClass = 'is-wrong'; 
                                            }
                                        }
                                    @endphp
                                    <label class="answer-label flex items-center cursor-pointer group/option w-full py-2 hover:bg-gray-50 rounded-lg px-3 transition-all {{ $studentClass }}"
                                           @if($canSeeKey) data-is-correct="{{ $isCorrectVal }}" @endif>
                                            {{-- Hidden Radio Input --}}
                                            <input type="radio" 
                                                   name="question_{{ $question->id }}" 
                                                   value="{{ $option }}" 
                                                   class="sr-only peer"
                                                   @if($existingScore && isset($existingScore->answers[$question->id]) && $existingScore->answers[$question->id] === $option) checked @endif
                                                   required>
                                            
                                            {{-- Visual Bubble --}}
                                            <div class="flex items-center justify-center mr-3 flex-none">
                                                <div class="w-8 h-8 shrink-0 aspect-square rounded-full border border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center">
                                                    <span class="text-base font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">@if(isset($option)){{ $option }}@endif</span>
                                                </div>
                                            </div>
                                            
                                            {{-- Label Text --}}
                                            <span class="text-xl text-gray-800 font-medium peer-checked:text-red-600 peer-checked:font-semibold group-hover/option:text-red-500 transition-colors">{{ $text }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Column 2: Questions {{ $splitIndex + 1 }}-End --}}
            <div class="space-y-0 divide-y divide-gray-100">
                @foreach($questions->skip($splitIndex) as $question)
                    <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2 relative">
                        <div class="flex items-baseline gap-3">
                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                            </div>
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <button type="button" 
                                        onclick="openEditQuestionModal({{ $question }})" 
                                        class="absolute top-3 right-10 w-6 h-6 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 flex items-center justify-center text-xs font-bold transition-all shadow-sm hover:scale-110" 
                                        title="Edit Question">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            @endif
                            @if(isset($transcript_enabled) && $transcript_enabled)
                                <button type="button" 
                                        onclick="jumpToTime({{ $questionTimestamps[$question->id] ?? 'null' }})" 
                                        class="absolute top-3 right-2 w-6 h-6 rounded-full bg-purple-100 text-purple-600 hover:bg-purple-200 flex items-center justify-center text-xs font-bold transition-all shadow-sm hover:scale-110" 
                                        title="Lihat Transkrip & Dengar Audio">
                                    ?
                                </button>
                            @endif
                            <div class="flex flex-col gap-2 flex-1">
                                @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                    @if($text !== 'N/A' && $text !== '')
                                    @php
                                        $canSeeKey = auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher());
                                        $isCorrectVal = $canSeeKey ? ($question->correct_answer === $option ? 'true' : 'false') : '';
                                        
                                        // Student Result Highlighting
                                        $studentClass = '';
                                        if (session('score_data')) {
                                            $userAnswers = session('score_data')['user_answers'];
                                            $userAns = $userAnswers[$question->id] ?? null;
                                            $correctAns = $question->correct_answer;
                                            
                                            if ($option === $correctAns) {
                                                // Correct Answer always Green
                                                $studentClass = 'is-correct'; 
                                            } elseif ($option === $userAns && $userAns !== $correctAns) {
                                                // Wrong User Answer Red
                                                $studentClass = 'is-wrong'; 
                                            }
                                        }
                                    @endphp
                                    <label class="answer-label flex items-center cursor-pointer group/option w-full py-2 hover:bg-gray-50 rounded-lg px-3 transition-all {{ $studentClass }}"
                                           @if($canSeeKey) data-is-correct="{{ $isCorrectVal }}" @endif>
                                            {{-- Hidden Radio Input --}}
                                            <input type="radio" 
                                                   name="question_{{ $question->id }}" 
                                                   value="{{ $option }}" 
                                                   class="sr-only peer"
                                                   @if($existingScore && isset($existingScore->answers[$question->id]) && $existingScore->answers[$question->id] === $option) checked @endif
                                                   required>
                                            
                                            {{-- Visual Bubble --}}
                                            <div class="flex items-center justify-center mr-3 flex-none">
                                                <div class="w-8 h-8 shrink-0 aspect-square rounded-full border border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center">
                                                    <span class="text-base font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">@if(isset($option)){{ $option }}@endif</span>
                                                </div>
                                            </div>
                                            
                                            {{-- Label Text --}}
                                            <span class="text-xl text-gray-800 font-medium peer-checked:text-red-600 peer-checked:font-semibold group-hover/option:text-red-500 transition-colors">{{ $text }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            </div>
            </div>

            <div class="mt-8 flex flex-col gap-6">
                {{-- Score Report Section (Bottom) --}}
                 @if(session('score_data'))
                    @php
                        $sData = session('score_data');
                        $score = $sData['score'];
                        $correct = $sData['correct_count'];
                        $total = $sData['total_question'];
                        
                        // Color Logic
                        if ($score >= 80) {
                            $scoreColor = 'green';
                            $scoreMsg = 'Excellent! Keep it up!';
                        } elseif ($score >= 60) {
                            $scoreColor = 'blue';
                            $scoreMsg = 'Good job! Practice makes perfect.';
                        } else {
                            $scoreColor = 'red';
                            $scoreMsg = 'Keep practicing! You can do better.';
                        }
                    @endphp
                    <div id="scoreReport" class="bg-{{ $scoreColor }}-50 border-l-4 border-{{ $scoreColor }}-500 p-6 rounded-r-lg shadow-sm animate-fade-in-down mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    @if($score >= 80)
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($score >= 60)
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    @else
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl leading-6 font-bold text-{{ $scoreColor }}-800">
                                        Hasil Latihan
                                    </h3>
                                    <div class="mt-2 text-{{ $scoreColor }}-700 grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                        <div class="flex items-baseline gap-3">
                                            <span class="text-5xl font-extrabold tracking-tight">{{ round($score) }}%</span>
                                            <span class="text-sm font-semibold uppercase tracking-wide opacity-80">Score</span>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <div class="text-lg font-semibold">Benar {{ $correct }} / {{ $total }}</div>
                                            <p class="text-sm opacity-90 italic">{{ $scoreMsg }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block text-{{ $scoreColor }}-200 opacity-20 transform rotate-12">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    {{-- Auto Scroll to Score --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const scoreReport = document.getElementById('scoreReport');
                            if(scoreReport) {
                                scoreReport.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    </script>
                @endif
            
            <div class="flex justify-end gap-4">
                 <a href="{{ route('assignments.toefl-itp.listening.meeting', $number) }}" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Set Selection
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    {{ $existingScore ? 'Resubmit Answers' : 'Submit Answers' }}
                </button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@section('modals')
    {{-- Upload SRT Modal (Admin Only) --}}
    @if(Auth::user()->isAdmin())
        <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="z-index: 10000;"
             onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 relative transform transition-all">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload Transcript (.srt)</h3>
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('assignments.toefl-itp.listening.meeting.upload-srt', ['number' => $number ?? 0, 'set' => $set ?? 0]) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Target Language</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="en" checked class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-700">English Script 🇺🇸</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="id" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-700">Indonesian 🇮🇩</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            SRT File (.srt - Max 2MB)
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                            <input type="file" id="srtFileInput" name="srt_file" accept=".srt"
                                   class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0].name">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                        </div>
                    </div>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-2 bg-white text-sm text-gray-500 font-semibold">OR PASTE TEXT</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                           Paste SRT Content Directly
                        </label>
                        <textarea name="srt_content" rows="4" 
                                  class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono"
                                  placeholder="1
00:00:10,000 --> 00:00:15,000
Start translating here..."></textarea>
                    </div>

                    <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                        <p class="text-xs text-yellow-800">
                            <strong>Note:</strong> Auto-parsing will remove timestamps (<code>00:00:10 --> ...</code>) and keep only the text dialog.
                        </p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                            Upload & Parse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Upload Audio Modal (Admin Only) --}}
    @if(Auth::user()->isAdmin())
        <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="z-index: 10000;"
             onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload Audio File</h3>
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('assignments.toefl-itp.listening.meeting.upload-audio', ['number' => $number ?? 0, 'set' => $set ?? 0]) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div class="text-xs text-red-500 breaking-all">
                        debug_url: {{ route('assignments.toefl-itp.listening.meeting.upload-audio', ['number' => $number ?? 0, 'set' => $set ?? 0]) }}
                    </div>
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Audio File (MP3, WAV, OGG - Max 10MB)
                        </label>
                        <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>

                    @if(isset($questions) && $questions->first() && $questions->first()->audio_file)
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800">
                                <span class="font-semibold">Current file:</span> 
                                {{ basename($questions->first()->audio_file) }}
                                <br>
                                <span class="text-xs text-gray-500">Full Path: {{ $questions->first()->audio_file }}</span>
                            </p>
                        </div>
                    @endif

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{-- Floating Add Question Button (Admin Only) --}}
    @if(Auth::user()->isAdmin())
        <button onclick="openCreateQuestionModal()" 
                class="fixed bottom-8 right-8 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 hover:scale-110 transition-all duration-200 flex items-center justify-center z-40 group"
                title="Add New Question">
            <svg class="w-8 h-8 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>
    @endif

    {{-- Question Modal (Create/Edit) --}}
    <div id="questionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeQuestionModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('assignments.toefl-itp.listening.question.store') }}" method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf
                    {{-- Hidden ID for update --}}
                    <input type="hidden" name="id" id="question_id">
                    <input type="hidden" name="meeting_number" value="{{ $number }}">
                    {{-- Default set to 1 if not present, or hidden input to be dynamic? Review requests? 
                         Actually, standard questions might default to set 1 or current set context.
                         For now, let's assume specific set context or default. 
                         If $set is available, use it. If not, maybe select? 
                         Wait, the current view might be generic 'meeting12' or specific set.
                         Let's inject a hidden Set Number input if we are in a practice view, otherwise default to 1?
                         The controller validation doesn't explicitly require set_number in stored question?
                         Let's check controller validation again. It doesn't validate set_number in the snippet I saw!
                         Wait, the snippet I saw: 'meeting_number' => 'required', but NO 'set_number'.
                         This suggests 'set_number' might be missing in validation or handled loosely.
                         However, database definitely has 'set_number'. I should add it.
                    --}}
                    @if(isset($set))
                        <input type="hidden" name="set_number" value="{{ $set }}">
                    @else
                        {{-- If no set selected, maybe default to 1 or allow selection? 
                             The user is on the main meeting page usually? No, user is likely on specific practice page?
                             Wait, 'meeting12.blade.php' handles BOTH main listing AND practice sets if logic allows.
                             But usually 'practice/{set}' routes to this view with $set variable.
                             If $set is duplicate/missing, I should add a Select for Set Number if not present.
                             For now, let's add a hidden Set Number input that defaults to {{ $set ?? 1 }} 
                        --}}
                        <input type="hidden" name="set_number" id="question_set_number" value="{{ $set ?? 1 }}">
                    @endif
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modalTitle">
                                    New Question
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Question Number</label>
                                            <input type="number" name="question_number" id="question_number" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                 {{-- Radio-like buttons or Select? Image shows ABCD buttons? 
                                                      Actually image shows "Correct Answer" with A B C D buttons.
                                                      Let's stick to Select for simplicity unless requested.
                                                      Wait, request says "like image".
                                                      Image: Blue outline buttons, selected one is filled blue.
                                                      I'll use a hidden input and JS buttons.
                                                 --}}
                                                 <input type="hidden" name="correct_answer" id="correct_answer" required>
                                                 <div class="flex gap-2 w-full">
                                                     @foreach(['A','B','C','D'] as $opt)
                                                        <button type="button" onclick="selectAnswer('{{ $opt }}')" 
                                                                id="btn_answer_{{ $opt }}"
                                                                class="flex-1 py-1 px-2 border rounded-md text-sm font-semibold transition-colors hover:bg-gray-50 focus:outline-none answer-btn">
                                                            {{ $opt }}
                                                        </button>
                                                     @endforeach
                                                 </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Audio File (MP3/WAV)</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <label class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-l-md text-gray-700 bg-gray-50 hover:bg-gray-100">
                                                Choose File
                                                <input type="file" name="audio_file" accept=".mp3,.wav" class="hidden" onchange="document.getElementById('audio_file_name').textContent = this.files[0] ? this.files[0].name : 'No file chosen'">
                                            </label>
                                            <span class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 shadow-sm text-sm text-gray-500 rounded-r-md w-full bg-white truncate" id="audio_file_name">
                                                No file chosen
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                        <textarea name="question_text" id="question_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Type the question content here..."></textarea>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach(['A','B','C','D'] as $opt)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Option {{ $opt }}</label>
                                                <div class="flex">
                                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm font-bold">
                                                        {{ $opt }}
                                                    </span>
                                                    <input type="text" name="option_{{ strtolower($opt) }}" id="option_{{ strtolower($opt) }}" required class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Question
                        </button>
                        <button type="button" onclick="closeQuestionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectAnswer(ans) {
            document.getElementById('correct_answer').value = ans;
            // Update visual state
            document.querySelectorAll('.answer-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            });
            const selectedBtn = document.getElementById('btn_answer_' + ans);
            if(selectedBtn) {
                 selectedBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                 selectedBtn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
            }
        }

        function openCreateQuestionModal() {
            document.getElementById('questionForm').reset();
            document.getElementById('question_id').value = '';
            document.getElementById('modalTitle').textContent = 'New Question';
            document.getElementById('audio_file_name').textContent = 'No file chosen';
            
            // Clear correct answer selection
            document.getElementById('correct_answer').value = '';
            document.querySelectorAll('.answer-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            });
            
            document.getElementById('questionModal').classList.remove('hidden');
        }

        function openEditQuestionModal(question) {
            document.getElementById('questionForm').reset();
            document.getElementById('question_id').value = question.id;
            document.getElementById('modalTitle').textContent = 'Edit Question ' + question.question_number;
            document.getElementById('question_number').value = question.question_number;
            document.getElementById('question_text').value = question.question_text || '';
            document.getElementById('option_a').value = question.option_a;
            document.getElementById('option_b').value = question.option_b;
            document.getElementById('option_c').value = question.option_c;
            document.getElementById('option_d').value = question.option_d;
            document.getElementById('audio_file_name').textContent = 'Keep current audio';
            
            selectAnswer(question.correct_answer);
            
            document.getElementById('questionModal').classList.remove('hidden');
        }

        function closeQuestionModal() {
            document.getElementById('questionModal').classList.add('hidden');
        }

        // Global function for delete button
        function removeSetClicked() {
            // Available sets from PHP/Blade data
            const availableSets = @json($availableSets);
            
            // Prompt user to select which set to remove
            if (availableSets.length === 0) {
                alert('Tidak ada latihan untuk dihapus.');
                return;
            }
            
            let setNumber = prompt(
                'Masukkan nomor latihan yang ingin dihapus:\n\nLatihan yang tersedia: ' + availableSets.join(', '),
                availableSets[availableSets.length - 1]
            );
            
            if (setNumber === null) return; // User cancelled
            
            setNumber = parseInt(setNumber);
            
            if (!availableSets.includes(setNumber)) {
                alert('Nomor latihan tidak valid. Silakan pilih dari: ' + availableSets.join(', '));
                return;
            }
            
            if (confirm('Hapus Latihan ' + setNumber + '? Semua soal di dalamnya akan dihapus.')) {
                document.getElementById('removeSetNumber').value = setNumber;
                document.getElementById('removeSetForm').submit();
            }
        }
    </script>
@endsection
