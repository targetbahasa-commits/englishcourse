import sys

content = """<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repeat Sentence Practice - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @php
            if(Auth::check()) {
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student');
            } else {
                $sidebarRole = 'guest';
            }
        @endphp
        @if($sidebarRole === 'admin')
            @include('components.sidebar-admin')
        @elseif($sidebarRole === 'teacher')
            @include('components.sidebar-teacher')
        @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content Wrapper --}}
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen" x-data="repeatSentenceApp()" x-cloak>

            {{-- Top Navigation Bar --}}
            <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-4">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.index') }}#topic-{{ $topicId }}" class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold" style="background-color: #e0f2fe; color: #0284c7;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 leading-tight">Repeat Sentence</h1>
                            <p class="text-xs text-gray-500">PTE Academic Practice - Topic #{{ str_pad($topicId, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Main Test Area --}}
            <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8">
                
                {{-- Top Light Blue Header Banner --}}
                <div class="font-bold text-lg px-6 py-3.5 rounded-xl mb-4 shadow-sm" style="background-color: #00b4d8; color: #ffffff;">
                    Sample Question {{ $topicId }}: {{ $topic['title'] }}
                </div>

                {{-- Status / Timer --}}
                <div class="mb-4">
                    <p class="text-base font-bold text-gray-800">
                        Beginning in <span style="color: #00b4d8; font-weight: 800;" x-text="promptCountdown + ' sec'">2 sec</span>
                    </p>
                </div>

                {{-- Prompt Audio Box (Reference Style) --}}
                <div class="rounded-xl p-5 mb-6 flex flex-col md:flex-row items-center gap-4 shadow-sm" style="background-color: #ffffff; border: 1px solid #00b4d8;">
                    <button @click="playPrompt()" class="w-10 h-10 rounded-full flex items-center justify-center text-white shadow shrink-0 cursor-pointer transition-transform hover:scale-105" style="background-color: #f97316;">
                        <svg x-show="!isPlayingPrompt" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        <svg x-show="isPlayingPrompt" x-cloak class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                    </button>
                    <span class="text-xs font-mono font-bold text-gray-500 shrink-0" x-text="formatTime(promptCurrentTime)">00:00</span>
                    
                    <div class="flex-1 w-full h-2.5 bg-gray-200 rounded-full overflow-hidden relative">
                        <div class="h-full rounded-full transition-all duration-300" style="background-color: #00b4d8;" :style="`width: ${promptProgress}%`"></div>
                    </div>

                    <span class="text-xs font-mono font-bold text-gray-500 shrink-0" x-text="formatTime(promptTotalTime)">00:03</span>

                    {{-- Speed Control Pill --}}
                    <div class="relative" x-data="{ openSpeed: false }">
                        <button @click="openSpeed = !openSpeed" class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 border shrink-0 bg-white cursor-pointer" style="border-color: #00b4d8; color: #00b4d8;">
                            <span x-text="playbackSpeed.toFixed(1)">1.0</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openSpeed" @click.away="openSpeed = false" class="absolute right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-20 w-20 text-xs text-center font-bold">
                            <template x-for="spd in [0.8, 1.0, 1.2, 1.5]" :key="spd">
                                <div @click="setSpeed(spd); openSpeed = false" class="py-1.5 hover:bg-gray-100 cursor-pointer" :class="playbackSpeed === spd ? 'text-[#00b4d8]' : 'text-gray-700'" x-text="spd.toFixed(1)"></div>
                            </template>
                        </div>
                    </div>

                    {{-- Volume Indicator --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <svg class="w-5 h-5" style="color: #00b4d8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                        <div class="w-16 h-1.5 rounded-full" style="background-color: #00b4d8;"></div>
                    </div>
                </div>

                {{-- Recording Controls Area (Student Response) --}}
                <div class="border border-amber-100/80 rounded-xl p-6 md:p-8 mb-6 shadow-sm flex flex-col items-center justify-center relative" style="background-color: #fffcf8;">
                    <p class="text-gray-800 font-bold text-base mb-6 text-center" x-text="isRecording ? 'Recording in progress...' : 'Click to Start'">Click to Start</p>
                    
                    <div class="w-full max-w-3xl flex items-center gap-4">
                        <button @click="isRecording ? stopRecording() : startRecording()" 
                                class="w-10 h-10 rounded-full flex items-center justify-center shadow transition-all shrink-0 cursor-pointer"
                                style="background-color: #e87a5d; color: #ffffff;">
                            <svg x-show="!isRecording" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            <svg x-show="isRecording" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><rect x="6" y="6" width="12" height="12" rx="2"></rect></svg>
                        </button>
                        <span class="text-xs font-mono font-bold text-gray-500 shrink-0" x-text="formatTime(recordingTime)">00:00</span>
                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300" style="background-color: #00b4d8;" :style="isRecording ? `width: ${Math.min(100, (recordingTime/15)*100)}%` : 'width: 0%'"></div>
                        </div>
                        <span class="text-xs font-mono font-bold text-gray-500 shrink-0">00:15</span>
                    </div>
                </div>

                {{-- Action Pill Buttons --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <button @click="isRecording ? stopRecording() : startRecording()" class="px-6 py-2.5 font-bold rounded-full shadow transition-all cursor-pointer hover:opacity-90" style="background-color: #00b4d8; color: #ffffff;">
                        Practice with AI Scoring
                    </button>
                    <button @click="resetRecording()" class="px-6 py-2.5 font-medium rounded-full shadow-sm transition-all cursor-pointer hover:bg-gray-50" style="background-color: #ffffff; color: #374151; border: 1px solid #d1d5db;">
                        Restart
                    </button>
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <button onclick="PTEScorePopup.show({ skill: 'Speaking', score: 81, max: 90, breakdown: { 'Content': 85, 'Pronunciation': 79, 'Oral_Fluency': 80 }, feedback: 'Excellent repetition accuracy. Intonation matched prompt closely.' })" class="px-5 py-2.5 font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer hover:opacity-90" style="background-color: #f59e0b; color: #ffffff;" title="Khusus Admin: Preview Hasil Evaluasi AI">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview Evaluasi
                    </button>
                    @endif
                </div>

                {{-- Transcript Accordion --}}
                <div class="mt-4 mb-8">
                    <button @click="showAnswer = !showAnswer" class="text-xs font-bold px-4 py-2 rounded-full border transition-all flex items-center gap-1.5" style="background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="showAnswer ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        <span x-text="showAnswer ? 'Hide Transcript' : 'Show Transcript'">Show Transcript</span>
                    </button>
                    
                    <div x-show="showAnswer" x-cloak class="mt-3 bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-gray-800 text-base leading-relaxed font-sans">{{ $topic['content'] }}</p>
                    </div>
                </div>
            </main>

            {{-- Bottom Action Bar & Helpers --}}
            <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
                <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.practice', ['id' => max(1, $topicId - 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId <= 1 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.practice', ['id' => min(300, $topicId + 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId >= 300 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Next
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex-1 sm:w-48">
                            <input type="text" placeholder="Question ..." class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm">
                            <button class="absolute right-0 top-0 bottom-0 px-3 font-medium text-white rounded-r-lg transition-colors flex items-center justify-center" style="background-color: #00b4d8;">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Audio element for prompt (Kokoro TTS) --}}
    <audio id="promptAudio" src="{{ asset('storage/audio/pte/repeat-sentence/' . $topicId . '.wav') }}" class="hidden"></audio>
    <audio id="playbackAudio" class="hidden"></audio>

    @include('components.pte-score-popup')
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('repeatSentenceApp', () => ({
                promptAudio: document.getElementById('promptAudio'),
                isPlayingPrompt: false,
                promptProgress: 0,
                promptCurrentTime: 0,
                promptTotalTime: 0,
                promptCountdown: 2,
                playbackSpeed: 1.0,

                isRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                audioUrl: null,
                audioBlob: null,
                recordingTime: 0,
                recordingInterval: null,
                
                playbackAudio: document.getElementById('playbackAudio'),
                isPlayingPlayback: false,
                showAnswer: false,

                init() {
                    this.promptAudio.addEventListener('timeupdate', () => {
                        this.promptCurrentTime = this.promptAudio.currentTime;
                        if (this.promptTotalTime > 0) {
                            this.promptProgress = (this.promptCurrentTime / this.promptTotalTime) * 100;
                        }
                    });

                    this.promptAudio.addEventListener('ended', () => {
                        this.isPlayingPrompt = false;
                        this.promptProgress = 0;
                        this.promptCurrentTime = 0;
                    });
                    
                    this.promptAudio.addEventListener('loadedmetadata', () => {
                        this.promptTotalTime = this.promptAudio.duration;
                    });
                },

                formatTime(seconds) {
                    if (!seconds || isNaN(seconds)) return '00:00';
                    let sec = Math.floor(seconds);
                    let m = Math.floor(sec / 60);
                    let s = sec % 60;
                    return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
                },

                setSpeed(spd) {
                    this.playbackSpeed = spd;
                    this.promptAudio.playbackRate = spd;
                },

                playPrompt() {
                    if (this.isPlayingPrompt) {
                        this.promptAudio.pause();
                        this.promptAudio.currentTime = 0;
                        this.isPlayingPrompt = false;
                        this.promptProgress = 0;
                        this.promptCurrentTime = 0;
                    } else {
                        if (this.isRecording) this.stopRecording();
                        this.promptAudio.playbackRate = this.playbackSpeed;
                        this.promptAudio.play().catch(e => console.log('Audio play error:', e));
                        this.isPlayingPrompt = true;
                    }
                },

                async startRecording() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.audioChunks = [];

                        this.mediaRecorder.ondataavailable = (event) => {
                            if (event.data.size > 0) this.audioChunks.push(event.data);
                        };

                        this.mediaRecorder.onstop = () => {
                            this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                            this.audioUrl = URL.createObjectURL(this.audioBlob);
                            this.playbackAudio.src = this.audioUrl;
                            stream.getTracks().forEach(track => track.stop());
                        };

                        this.mediaRecorder.start();
                        this.isRecording = true;
                        this.recordingTime = 0;
                        this.recordingInterval = setInterval(() => {
                            this.recordingTime++;
                            if (this.recordingTime >= 15) this.stopRecording();
                        }, 1000);
                        
                        if (this.isPlayingPrompt) {
                            this.promptAudio.pause();
                            this.promptAudio.currentTime = 0;
                            this.isPlayingPrompt = false;
                        }
                    } catch (err) {
                        alert("Tidak dapat mengakses mikrofon. Pastikan Anda telah memberikan izin.");
                    }
                },

                stopRecording() {
                    if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                        this.mediaRecorder.stop();
                        this.isRecording = false;
                        clearInterval(this.recordingInterval);
                    }
                },

                resetRecording() {
                    if (this.isRecording) this.stopRecording();
                    this.audioUrl = null;
                    this.audioBlob = null;
                    this.recordingTime = 0;
                    clearInterval(this.recordingInterval);
                }
            }));
        });
    </script>
</body>
</html>
"""

with open('resources/views/assignments/pte-academic/repeat-sentence/practice.blade.php', 'w') as f:
    f.write(content)

print('Updated Repeat Sentence practice view successfully.')
