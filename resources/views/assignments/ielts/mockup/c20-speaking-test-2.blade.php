<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Speaking Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .cambridge-text { font-family: Arial, Helvetica, sans-serif; color: #1a1a1a; line-height: 1.5; }
        .cambridge-part-title { font-size: 1.25rem; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 1rem; text-transform: uppercase; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="speakingMockup()" x-cloak>
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

<div class="fixed inset-0 z-0 flex flex-col">

    <!-- Start Test Overlay -->
    <div x-show="!hasStarted" class="fixed inset-0 z-50 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center transition-opacity" x-transition>
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform transition-all scale-100">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Speaking Mock Test</h3>
            <p class="text-gray-500 mb-8 leading-relaxed">Ensure your microphone is ready. The automated examiner will begin speaking immediately after you start.</p>
            <button @click="startIntroSequence()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 mt-2">
                Begin Test
            </button>
        </div>
    </div>

    {{-- Top header --}}
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Speaking – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition }} Speaking Practice</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-pink-50 text-pink-700 rounded-lg border border-pink-100 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-text="formattedGlobalTime">15:00</span>
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    Exit
                </a>
            </div>
        </div>
    </div>

    {{-- Full screen Layout --}}
    <div class="flex-1 min-h-[80vh] flex flex-col items-center justify-center relative bg-gray-50">
        <div class="bg-white border-l border-gray-200 flex flex-col items-center justify-center p-8 relative shadow-sm rounded-xl" style="width:100%; max-width:600px; padding:3em;">
            
            <div class="absolute top-8 left-8">
                <div class="text-sm font-bold tracking-wider text-pink-500 uppercase bg-pink-50 px-4 py-1.5 rounded-full inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></span>
                    <span x-text="'PART ' + currentPart">PART 1</span>
                </div>
            </div>

            <div class="w-full text-center mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Record Your Answer</h2>
                <p class="text-gray-500 mb-12" x-text="currentPart === 1 && introState <= 2 ? 'Listen to the examiner and answer when the mic turns red.' : 'Listen to the prompt, and speak your answer. Once finished, proceed to the next part.'"></p>

                <!-- Visualizer / Status -->
                <div class="h-32 flex items-center justify-center w-full mb-8 bg-gray-50 rounded-2xl border border-gray-100">
                    <template x-if="!recordings[currentPart] && !isRecording && !isPreparing && !isReadingPrompt">
                        <div class="flex flex-col items-center p-4">
                            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                            </svg>
                            <p class="text-gray-400 text-sm">Ready to record Part <span x-text="currentPart"></span></p>
                        </div>
                    </template>

                    <template x-if="isPreparing">
                        <div class="flex flex-col items-center p-4">
                            <div class="w-12 h-12 rounded-full border-4 border-indigo-200 border-t-indigo-500 animate-spin flex items-center justify-center mb-2">
                                <span class="text-indigo-600 font-bold text-lg" x-text="countdownTimer"></span>
                            </div>
                            <p class="text-indigo-500 font-semibold animate-pulse">Get Ready...</p>
                        </div>
                    </template>

                    <template x-if="isReadingPrompt">
                        <div class="flex flex-col items-center p-4">
                            <svg class="w-8 h-8 text-blue-500 mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                            <p class="text-blue-500 font-semibold animate-pulse">Reading Question...</p>
                        </div>
                    </template>

                    <template x-if="isRecording">
                            <div class="flex flex-col items-center w-full px-8">
                            <div class="flex items-center justify-center gap-3 w-full mb-3">
                                <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                                <div class="text-red-500 font-mono text-xl" x-text="formattedRecordTime">00:00</div>
                            </div>
                            <!-- Waveform Bars -->
                            <div class="flex items-center justify-center h-12 gap-1 w-full max-w-[200px]">
                                <template x-for="(barHeight, index) in visualizerBars" :key="index">
                                    <div class="w-2 bg-red-500 rounded-sm transition-all duration-75 ease-linear" 
                                            :style="'height: ' + Math.max(10, barHeight) + '%; opacity: ' + (barHeight > 15 ? 1 : 0.5)"></div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="recordings[currentPart] && !isRecording">
                            <div class="flex flex-col items-center text-green-600 font-medium">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span x-text="'Part ' + currentPart + ' Recorded'"></span>
                            </div>
                    </template>
                </div>

                <!-- Record Buttons -->
                <div class="flex items-center justify-center gap-6 mb-12 min-h-[5rem]">
                    <template x-if="!isRecording && !recordings[currentPart] && !isPreparing && !isReadingPrompt">
                        <button @click="startPreparation()" 
                                class="w-20 h-20 rounded-full bg-red-500 hover:bg-red-600 shadow-xl shadow-red-500/30 text-white flex items-center justify-center transition-transform hover:scale-105">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
                                <path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                            </svg>
                        </button>
                    </template>

                    <template x-if="isPreparing">
                        <div class="w-20 h-20 rounded-full bg-indigo-500 text-white flex items-center justify-center text-3xl font-bold animate-pulse shadow-xl shadow-indigo-500/30">
                            <span x-text="countdownTimer"></span>
                        </div>
                    </template>

                    <template x-if="isReadingPrompt">
                        <div class="w-20 h-20 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-xl shadow-blue-500/30">
                            <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                        </div>
                    </template>

                    <template x-if="isRecording">
                        <div class="flex flex-col items-center gap-4">
                            <button @click="stopRecording()" 
                                    class="w-20 h-20 rounded-full border-4 border-red-500 flex items-center justify-center hover:bg-red-50 transition-colors group">
                                <div class="w-8 h-8 bg-red-500 rounded-sm group-hover:scale-110 transition-transform"></div>
                            </button>
                            <button @click="repeatQuestion()" 
                                    class="px-5 py-2 rounded-full border border-gray-200 text-gray-500 font-medium hover:border-gray-800 hover:text-gray-800 transition-colors flex items-center gap-2 text-sm mt-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                Repeat Question
                            </button>
                        </div>
                    </template>

                    <template x-if="recordings[currentPart] && !isRecording">
                            <button @click="resetRecording()" 
                                class="px-6 py-2.5 rounded-full border-2 border-gray-200 text-gray-500 font-semibold hover:border-gray-800 hover:text-gray-800 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Re-record
                        </button>
                    </template>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between items-center w-full pt-8 border-t border-gray-100">
                    <button @click="prevPart()" 
                            :class="{'opacity-0 pointer-events-none': currentPart === 1}"
                            class="px-6 py-2.5 rounded-xl text-gray-500 font-medium hover:bg-gray-100 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Part <span x-text="currentPart - 1"></span>
                    </button>
                    
                    <button @click="nextPart()" 
                            x-show="currentPart < 3"
                            :disabled="!recordings[currentPart]"
                            :class="!recordings[currentPart] ? 'opacity-50 cursor-not-allowed bg-gray-200 text-gray-400' : 'bg-gray-900 hover:bg-gray-800 text-white shadow-md hover:-translate-y-0.5'"
                            class="px-8 py-3 rounded-xl font-bold transition-all flex items-center gap-2">
                        Next Part
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <button @click="submitAll()" 
                            x-show="currentPart === 3"
                            :disabled="!recordings[3]"
                            :class="!recordings[3] ? 'opacity-50 cursor-not-allowed bg-pink-300 text-white' : 'bg-pink-600 hover:bg-pink-700 text-white shadow-md hover:-translate-y-0.5 shadow-pink-500/30'"
                            class="px-8 py-3 rounded-xl font-bold transition-all flex items-center gap-2">
                        Submit Test
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('speakingMockup', () => ({
            hasStarted: false,
            currentPart: 1,
            globalTime: 15 * 60,
            recordTime: 0,
            timerInterval: null,
            recordInterval: null,
            
            isPreparing: false,
            isReadingPrompt: false,
            countdownTimer: 3,
            preparationInterval: null,
            ttsUtterance: null,
            introState: 0,

            prompts: {
                1: [
                    "Good afternoon. My name is Alex. Can you tell me your full name, please?",
                    "Thank you. And what shall I call you?",
                    "And can you tell me where you're from?",
                    "Now, in this first part, I'd like to ask you some questions about yourself. Let's talk about fruit. What's your favourite fruit?",
                    "Are there any kinds of fruit that you don't like eating?",
                    "Do you like eating cooked food that has fruit in it?",
                    "Where's the best place to buy fruit where you live?"
                ],
                2: "Part 2. Describe a time when you changed a plan you had made. You should say: what your original plan was. why you changed it. what new plan you made. And explain how you felt about changing your plan.",
                3: "Part 3. Discussion topics. First, let's talk about making plans. What kinds of plans do friends make together? Do you think it's better to discuss future plans with friends or with family? When making plans for the future, is it important not to copy friends? Now let's consider future careers. When people are choosing what to study, how important is it that their course should lead directly to a career? Why is it a good idea to get some work experience before deciding on a future career? How easy do you think it is for people to change from one career to another?"
            },
            
            isRecording: false,
            mediaRecorder: null,
            audioChunks: [],
            recordings: {
                1: null,
                2: null,
                3: null
            },
            
            visualizerBars: Array(15).fill(10),
            audioContext: null,
            analyser: null,
            microphone: null,
            animationFrame: null,
            dataArray: null,

            init() {
                this.timerInterval = setInterval(() => {
                    if (this.globalTime > 0) {
                        this.globalTime--;
                    }
                }, 1000);
            },

            startIntroSequence() {
                this.hasStarted = true;
                
                if ('speechSynthesis' in window) {
                    let unlock = new SpeechSynthesisUtterance('');
                    unlock.volume = 0;
                    window.speechSynthesis.speak(unlock);
                }

                if (this.currentPart === 1) {
                    this.startPreparation();
                }
            },
            
            get formattedGlobalTime() {
                const m = Math.floor(this.globalTime / 60).toString().padStart(2, '0');
                const s = (this.globalTime % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            get formattedRecordTime() {
                const m = Math.floor(this.recordTime / 60).toString().padStart(2, '0');
                const s = (this.recordTime % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            startPreparation() {
                this.isPreparing = true;
                this.countdownTimer = 3;
                this.preparationInterval = setInterval(() => {
                    this.countdownTimer--;
                    if (this.countdownTimer === 0) {
                        clearInterval(this.preparationInterval);
                        this.isPreparing = false;
                        this.readPromptAndRecord();
                    }
                }, 1000);
            },

            readPromptAndRecord() {
                this.isReadingPrompt = true;
                
                const expectedPart = this.currentPart;
                const expectedIntroState = this.introState;

                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    
                    let ttsText = this.currentPart === 1 ? this.prompts[1][this.introState] : this.prompts[this.currentPart];
                    
                    this.ttsUtterance = new SpeechSynthesisUtterance(ttsText);
                    
                    let voices = window.speechSynthesis.getVoices();
                    let gbVoice = voices.find(v => v.lang === 'en-GB' || v.lang === 'en-UK' || v.lang.startsWith('en'));
                    if(gbVoice) this.ttsUtterance.voice = gbVoice;
                    else this.ttsUtterance.lang = 'en-GB';
                    
                    this.ttsUtterance.rate = 0.9;
                    
                    this.ttsUtterance.onend = () => {
                        if (this.currentPart === expectedPart && this.introState === expectedIntroState && this.isReadingPrompt) {
                            this.isReadingPrompt = false;
                            this.startRecording();
                        }
                    };

                    this.ttsUtterance.onerror = (e) => {
                        if (this.currentPart === expectedPart && this.introState === expectedIntroState && this.isReadingPrompt) {
                            this.isReadingPrompt = false;
                            this.startRecording();
                        }
                    };

                    window.speechSynthesis.speak(this.ttsUtterance);
                } else {
                    this.isReadingPrompt = false;
                    this.startRecording();
                }
            },

            cancelPreparations() {
                if (this.preparationInterval) {
                   clearInterval(this.preparationInterval);
                }
                this.isPreparing = false;
                this.isReadingPrompt = false;
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                }
            },

            async startRecording() {
                try {
                    if (this.mediaRecorder && this.mediaRecorder.state === 'paused') {
                        this.isRecording = true;
                        this.mediaRecorder.resume();
                        
                        this.recordInterval = setInterval(() => { this.recordTime++; }, 1000);
                        
                        const updateWaveform = () => {
                            if (!this.isRecording) return;
                            if (this.analyser) {
                                this.analyser.getByteFrequencyData(this.dataArray);
                                const step = Math.floor(this.dataArray.length / 15);
                                for (let i = 0; i < 15; i++) {
                                    const value = this.dataArray[i * step];
                                    this.visualizerBars[i] = Math.max(10, (value / 255) * 100);
                                }
                            }
                            this.animationFrame = requestAnimationFrame(updateWaveform);
                        };
                        updateWaveform();
                        return;
                    }

                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    this.isRecording = true;
                    this.recordTime = 0;
                    this.audioChunks = [];

                    this.recordInterval = setInterval(() => {
                        this.recordTime++;
                    }, 1000);

                    this.mediaRecorder = new MediaRecorder(stream);
                    
                    this.mediaRecorder.ondataavailable = (event) => {
                        if (event.data.size > 0) {
                            this.audioChunks.push(event.data);
                        }
                    };

                    this.mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        this.recordings[this.currentPart] = audioUrl;
                    };

                    this.mediaRecorder.start();

                    this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    this.analyser = this.audioContext.createAnalyser();
                    this.analyser.fftSize = 64;
                    this.microphone = this.audioContext.createMediaStreamSource(stream);
                    this.microphone.connect(this.analyser);
                    
                    this.dataArray = new Uint8Array(this.analyser.frequencyBinCount);
                    
                    const updateWaveform = () => {
                        if (!this.isRecording) return;
                        this.analyser.getByteFrequencyData(this.dataArray);
                        
                        const step = Math.floor(this.dataArray.length / 15);
                        for (let i = 0; i < 15; i++) {
                            const value = this.dataArray[i * step];
                            this.visualizerBars[i] = Math.max(10, (value / 255) * 100);
                        }
                        
                        this.animationFrame = requestAnimationFrame(updateWaveform);
                    };
                    updateWaveform();

                } catch (err) {
                    console.error("Error accessing mic:", err);
                    alert("Could not access microphone! " + err);
                }
            },

            repeatQuestion() {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    
                    let ttsText = "";
                    if (this.currentPart === 1) {
                        ttsText = this.prompts[1][this.introState];
                    } else {
                        ttsText = this.prompts[this.currentPart];
                    }
                    
                    if (ttsText) {
                        let utterance = new SpeechSynthesisUtterance(ttsText);
                        
                        let voices = window.speechSynthesis.getVoices();
                        let mbrolaVoice = voices.find(v => v.name.includes('en-GB') || v.name.includes('Daniel') || v.name.includes('UK English'));
                        let gbVoice = voices.find(v => v.lang === 'en-GB' || v.lang === 'en-UK' || v.lang.startsWith('en'));
                        
                        if(mbrolaVoice) utterance.voice = mbrolaVoice;
                        else if(gbVoice) utterance.voice = gbVoice;
                        else utterance.lang = 'en-GB';
                        
                        utterance.rate = 0.9;
                        
                        window.speechSynthesis.speak(utterance);
                    }
                }
            },

            stopRecording() {
                if (this.mediaRecorder && (this.isRecording || this.mediaRecorder.state === 'recording')) {
                    this.isRecording = false;
                    clearInterval(this.recordInterval);
                    
                    if (this.animationFrame) {
                        cancelAnimationFrame(this.animationFrame);
                    }
                    this.visualizerBars = Array(15).fill(10);
                    
                    if (this.currentPart === 1 && this.introState < this.prompts[1].length - 1) {
                        this.mediaRecorder.pause();
                        this.introState++;
                        this.readPromptAndRecord();
                    } else {
                        this.mediaRecorder.stop();
                        this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                        
                        if (this.audioContext && this.audioContext.state !== 'closed') {
                            this.audioContext.close();
                        }
                        if (this.currentPart === 1) {
                            this.introState = this.prompts[1].length;
                        }
                    }
                }
            },

            resetRecording() {
                this.cancelPreparations();
                if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                    this.mediaRecorder.stop();
                    this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                }
                this.recordings[this.currentPart] = null;
                if (this.currentPart === 1) {
                    this.introState = 0;
                }
            },

            nextPart() {
                this.cancelPreparations();
                if (this.currentPart < 3 && this.recordings[this.currentPart]) {
                    this.currentPart++;
                }
            },

            prevPart() {
                this.cancelPreparations();
                if (this.currentPart > 1) {
                    this.currentPart--;
                }
            },

            submitAll() {
                if (this.recordings[1] && this.recordings[2] && this.recordings[3]) {
                    alert("Mock Test submitted successfully! (This is a frontend demonstration)");
                    window.location.href = '{{ route("assignments.ielts-academic.mockup.cambridge.skills", ["edition" => $edition, "id" => $testId]) }}';
                }
            }
        }));
    });
</script>

</body>
</html>
