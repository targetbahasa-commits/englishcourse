<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repeat Sentence Practice - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::check())
            @php($sidebarRole = strtolower(Auth::user()->active_role ?? 'student'))
            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'teacher')
                @include('components.sidebar-teacher')
            @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto" x-data="repeatSentenceApp()" x-cloak>
                
                <!-- Header with Back Button -->
                <div class="mb-8">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.index') }}" class="inline-flex items-center text-gray-600 hover:text-teal-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-teal-100 rounded-xl text-teal-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Repeat Sentence</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

    <!-- Main Practice Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden min-h-[500px] flex flex-col relative">
            
            <div class="p-8 md:p-12 flex-1 flex flex-col justify-center items-center text-center">
                
                <!-- Prompt Audio Player -->
                <div class="w-full max-w-lg mx-auto bg-white rounded-3xl p-6 mb-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col items-center gap-6">
                    <!-- Play Button -->
                    <button @click="playPrompt()" class="w-20 h-20 flex-shrink-0 flex items-center justify-center rounded-full bg-gradient-to-tr from-teal-400 to-teal-500 text-white shadow-xl shadow-teal-500/30 transition-all duration-300 hover:scale-105 hover:shadow-teal-500/50 relative">
                        <div x-show="isPlayingPrompt" class="absolute inset-0 rounded-full border-2 border-teal-400 animate-ping opacity-75"></div>
                        <svg x-show="!isPlayingPrompt" class="w-10 h-10 ml-1 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        <svg x-show="isPlayingPrompt" x-cloak class="w-10 h-10 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                    </button>
                    
                    <!-- Progress Bar -->
                    <div class="w-full px-4">
                        <div class="h-2.5 w-full bg-gray-100 rounded-full overflow-hidden relative mb-3">
                            <div class="absolute top-0 left-0 h-full bg-teal-500 transition-all duration-300" :style="`width: ${promptProgress}%`"></div>
                        </div>
                        <div class="flex justify-center items-center">
                            <div class="text-sm font-bold text-gray-400 tracking-wider font-mono">
                                <span x-text="formatTime(promptCurrentTime)"></span> / <span x-text="formatTime(promptTotalTime)"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instruction -->
                <div class="mb-8 h-6" x-show="!isRecording && !audioUrl">
                    <p class="text-gray-400">Tekan tombol rekam setelah mendengarkan kalimat untuk mengulanginya.</p>
                </div>

                <!-- Recording Controls (Similar to IELTS) -->
                <div class="w-full max-w-sm mx-auto space-y-6">
                    
                    <!-- Recorder Status -->
                    <div class="h-24 flex items-center justify-center w-full">
                        <template x-if="isRecording">
                             <div class="flex items-center justify-center gap-3 w-full max-w-md mx-auto">
                                <div class="flex-shrink-0 animate-pulse">
                                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
                                        <path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                                    </svg>
                                </div>
                                <div class="text-red-500 font-mono text-2xl font-bold" x-text="formatTime(recordingTime)"></div>
                            </div>
                        </template>

                        <template x-if="audioUrl && !isRecording">
                             <div class="flex flex-col items-center gap-3 w-full animate-fadeIn">
                                 <!-- Recorded Audio Player -->
                                 <div class="flex items-center gap-4 bg-gray-50 rounded-full px-5 py-3 border border-gray-200 shadow-inner w-full max-w-xs mx-auto">
                                     <button @click="togglePlayback()" class="text-teal-600 hover:text-teal-700 focus:outline-none transition-transform hover:scale-110">
                                        <svg x-show="!isPlayingPlayback" class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>
                                        <svg x-show="isPlayingPlayback" x-cloak class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                     </button>
                                     <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden relative">
                                         <div class="absolute top-0 left-0 h-full bg-teal-500" :style="`width: ${playbackProgress}%`"></div>
                                     </div>
                                     <div class="text-xs font-bold text-gray-500 w-16 text-right font-mono tracking-tighter">
                                         <span x-text="formatTime(playbackCurrentTime)"></span> / <span x-text="formatTime(playbackTotalTime)"></span>
                                     </div>
                                 </div>
                             </div>
                        </template>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-center gap-4 h-16">
                        <template x-if="!isRecording && !audioUrl">
                            <button @click="startRecording()" 
                                    class="w-16 h-16 rounded-full bg-red-500 hover:bg-red-600 text-white shadow-lg flex items-center justify-center transition-all hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-red-200">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                        </template>

                        <template x-if="isRecording">
                            <button @click="stopRecording()" 
                                    class="w-16 h-16 rounded-full border-4 border-red-500 flex items-center justify-center hover:bg-red-50 transition-all focus:outline-none">
                                <div class="w-6 h-6 bg-red-500 rounded-sm"></div>
                            </button>
                        </template>

                        <!-- Re-record -->
                        <template x-if="audioUrl && !isRecording">
                             <button @click="resetRecording()" 
                                    class="px-6 py-2 rounded-full border border-gray-200 text-gray-500 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 transition-all flex items-center gap-2 focus:outline-none font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Re-record
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Transcript / Answer Toggle -->
                <div class="mt-12">
                    <button @click="showAnswer = !showAnswer" class="text-teal-600 hover:text-teal-700 font-medium text-sm flex items-center justify-center gap-2 mx-auto transition-colors bg-teal-50 px-4 py-2 rounded-full border border-teal-100 hover:border-teal-200">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="showAnswer ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        <span x-text="showAnswer ? 'Hide Transcript' : 'Show Transcript'"></span>
                    </button>
                    
                    <div x-show="showAnswer" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4"
                         class="mt-4">
                        <div class="p-6 bg-teal-50 rounded-2xl border border-teal-100 max-w-lg mx-auto shadow-inner text-left relative">
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-teal-100 text-teal-800 text-xs font-bold px-3 py-1 rounded-full border border-teal-200">Transcript</div>
                            <p class="text-gray-700 text-lg leading-relaxed mt-2 text-center">{{ $topic['content'] }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Card Footer / Navigation -->
            <div class="bg-gray-50 p-6 flex justify-between items-center border-t border-gray-100">
                <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.practice', ['id' => max(1, $topicId - 1)]) }}" 
                   class="px-6 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-200 transition-colors {{ $topicId <= 1 ? 'pointer-events-none opacity-50' : '' }}">
                    Previous
                </a>

                <div class="flex items-center gap-3">
                    <!-- Action buttons or hints could go here -->
                </div>

                <a href="{{ route('assignments.pte-academic.speaking-writing.repeat-sentence.practice', ['id' => min(300, $topicId + 1)]) }}" 
                   class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= 300 ? 'pointer-events-none opacity-50' : '' }}">
                    <span>Next Question</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Audio element for prompt (Kokoro TTS) --}}
    <audio id="promptAudio" src="{{ asset('storage/audio/pte/repeat-sentence/' . $topicId . '.wav') }}" class="hidden"></audio>
    
    {{-- Audio element for playback --}}
    <audio id="playbackAudio" class="hidden"></audio>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('repeatSentenceApp', () => ({
            // Prompt Player (TTS)
            promptAudio: document.getElementById('promptAudio'),
            isPlayingPrompt: false,
            promptProgress: 0,
            promptCurrentTime: 0,
            promptTotalTime: 0,

            // Recording
            isRecording: false,
            mediaRecorder: null,
            audioChunks: [],
            audioUrl: null,
            audioBlob: null,
            recordingTime: 0,
            recordingInterval: null,
            
            // Playback
            playbackAudio: document.getElementById('playbackAudio'),
            isPlayingPlayback: false,
            playbackProgress: 0,
            playbackCurrentTime: 0,
            playbackTotalTime: 0,
            
            // UI Toggles
            showAnswer: false,

            init() {
                // Setup Prompt Audio Listeners
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

                // Setup Playback Audio Listeners
                this.playbackAudio.addEventListener('timeupdate', () => {
                    this.playbackCurrentTime = this.playbackAudio.currentTime;
                    if (this.playbackTotalTime > 0) {
                        this.playbackProgress = (this.playbackCurrentTime / this.playbackTotalTime) * 100;
                    }
                });

                this.playbackAudio.addEventListener('ended', () => {
                    this.isPlayingPlayback = false;
                    this.playbackProgress = 0;
                    this.playbackCurrentTime = 0;
                });
                
                this.playbackAudio.addEventListener('loadedmetadata', () => {
                    this.playbackTotalTime = this.playbackAudio.duration;
                });
            },

            formatTime(seconds) {
                if (!seconds || isNaN(seconds)) return '00:00';
                let sec = Math.floor(seconds);
                let m = Math.floor(sec / 60);
                let s = sec % 60;
                return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
            },

            playPrompt() {
                if (this.isPlayingPrompt) {
                    this.promptAudio.pause();
                    this.promptAudio.currentTime = 0;
                    this.isPlayingPrompt = false;
                    this.promptProgress = 0;
                    this.promptCurrentTime = 0;
                } else {
                    // Stop recording if playing prompt
                    if (this.isRecording) {
                        this.stopRecording();
                    }
                    this.promptAudio.play();
                    this.isPlayingPrompt = true;
                }
            },

            async startRecording() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    this.mediaRecorder = new MediaRecorder(stream);
                    this.audioChunks = [];

                    this.mediaRecorder.ondataavailable = (event) => {
                        if (event.data.size > 0) {
                            this.audioChunks.push(event.data);
                        }
                    };

                    this.mediaRecorder.onstop = () => {
                        this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                        this.audioUrl = URL.createObjectURL(this.audioBlob);
                        this.playbackAudio.src = this.audioUrl;
                        
                        // Stop all tracks to release mic
                        stream.getTracks().forEach(track => track.stop());
                    };

                    this.mediaRecorder.start();
                    this.isRecording = true;
                    this.audioUrl = null; // Hide playback while recording
                    
                    // Timer for recording
                    this.recordingTime = 0;
                    this.recordingInterval = setInterval(() => {
                        this.recordingTime++;
                    }, 1000);
                    
                    // If prompt is playing, stop it
                    if (this.isPlayingPrompt) {
                        this.promptAudio.pause();
                        this.promptAudio.currentTime = 0;
                        this.isPlayingPrompt = false;
                    }

                } catch (err) {
                    console.error("Error accessing microphone:", err);
                    alert("Could not access microphone. Please ensure you have granted permission.");
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
                if (this.isRecording) {
                    this.stopRecording();
                }
                this.audioUrl = null;
                this.audioBlob = null;
                this.recordingTime = 0;
                clearInterval(this.recordingInterval);
                
                if (this.isPlayingPlayback) {
                    this.playbackAudio.pause();
                    this.isPlayingPlayback = false;
                }
            },

            togglePlayback() {
                if (!this.audioUrl) return;

                if (this.isPlayingPlayback) {
                    this.playbackAudio.pause();
                    this.isPlayingPlayback = false;
                } else {
                    this.playbackAudio.play();
                    this.isPlayingPlayback = true;
                }
            }
        }));
    });
</script>
        </main>
    </div>
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
