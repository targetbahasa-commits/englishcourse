<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        @keyframes success-bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .listening { animation: pulse-ring 1.5s ease-in-out infinite; }
        .success-feedback { animation: success-bounce 0.5s ease; }
    </style>
    @php
        $colors = [
            'Basic' => ['from' => 'from-red-400', 'to' => 'to-red-600', 'light' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-100', 'bg_light' => 'bg-red-50'],
            'Intermediate' => ['from' => 'from-orange-400', 'to' => 'to-orange-600', 'light' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100', 'bg_light' => 'bg-orange-50'],
            'Advanced' => ['from' => 'from-rose-400', 'to' => 'to-rose-600', 'light' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'border-rose-100', 'bg_light' => 'bg-rose-50'],
        ];
        $color = $colors[$level];
    @endphp
</head>
<body class="font-sans antialiased bg-gradient-to-br {{ $color['bg_light'] }} via-white to-gray-50 min-h-screen">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @auth
            @if(Auth::user()->isAdmin())
                @include('components.sidebar-admin')
            @elseif(Auth::user()->isTeacher())
                @include('components.sidebar-teacher')
            @elseif(in_array(Auth::user()->active_role, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endauth

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('idioms') }}" class="inline-flex items-center {{ $color['text'] }} hover:opacity-80 mb-6 font-medium transition-all hover:gap-3 gap-2 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Idioms
                </a>
                
                <div class="bg-white/70 backdrop-blur-md rounded-3xl p-8 shadow-2xl border-2 border-white/50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} bg-clip-text text-transparent">
                                    {{ $title }}
                                </h1>
                                <p class="text-gray-600 mt-1">{{ count($idioms) }} idioms</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <!-- Average Score -->
                            <div class="text-right">
                                <div class="text-sm text-gray-500 mb-1">Average Score</div>
                                <div id="averageScore" class="flex items-center justify-end gap-2">
                                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-2xl font-bold {{ $color['text'] }}">--</span>
                                </div>
                            </div>
                            <!-- Progress -->
                            <div class="text-right">
                                <div class="text-sm text-gray-500 mb-1">Progress</div>
                                <div class="text-2xl font-bold {{ $color['text'] }}">0/{{ count($idioms) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="mb-8 bg-white/70 backdrop-blur-md rounded-3xl p-8 shadow-xl border-2 border-white/50">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">How to Use</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Listen</p>
                                    <p class="text-sm text-gray-600">Click to hear the idiom</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Practice</p>
                                    <p class="text-sm text-gray-600">Speak the idiom and get feedback</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Idioms Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($idioms as $index => $idiom)
                <div class="idiom-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:scale-105" data-idiom="{{ $idiom['idiom'] }}">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="text-xs font-bold text-white/80 mb-2">IDIOM #{{ $index + 1 }}</div>
                            <h3 class="text-2xl font-bold text-white mb-2 leading-tight">{{ $idiom['idiom'] }}</h3>
                            <p class="text-white/90 text-lg italic">{{ $idiom['translation'] }}</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Meaning Section -->
                        <div class="mb-4">
                            <p class="text-xs font-bold text-gray-400 mb-2">MEANING:</p>
                            <div class="{{ $color['light'] }} rounded-xl p-3 border {{ $color['border'] }}">
                                <p class="text-gray-700 text-sm">{{ $idiom['meaning'] }}</p>
                            </div>
                        </div>

                        <!-- Example Section -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-2">EXAMPLE:</p>
                            <div class="{{ $color['light'] }} rounded-xl p-4 border {{ $color['border'] }}">
                                <p class="text-gray-800 font-medium">"{{ $idiom['example'] }}"</p>
                                @if(!empty($idiom['example_id']))
                                <p class="text-gray-500 text-sm mt-1 italic">"{{ $idiom['example_id'] }}"</p>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Listen Button -->
                            <button onclick="speakText(this)" 
                                    data-idiom="{{ $idiom['idiom'] }}" 
                                    data-example="{{ $idiom['example'] }}"
                                    class="listen-btn flex items-center justify-center gap-2 bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} text-white py-3 px-4 rounded-xl font-bold hover:opacity-90 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                </svg>
                                <span>Listen</span>
                            </button>

                            <!-- Practice Button -->
                            <button onclick="toggleRecognition('{{ $idiom['idiom'] }}', this)" class="practice-btn flex items-center justify-center gap-2 bg-white border-2 {{ $color['border'] }} {{ $color['text'] }} py-3 px-4 rounded-xl font-bold hover:bg-gray-50 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                </svg>
                                <span>Practice</span>
                            </button>
                        </div>

                        <!-- Feedback Area -->
                        <div class="feedback-area mt-4 hidden">
                            <div class="feedback-message p-3 rounded-xl text-center font-bold"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <script>
        // Text to Speech Function
        function speakText(button) {
            const idiom = button.dataset.idiom;
            const example = button.dataset.example;

            if (activeRecognition) {
                isManuallyStopped = true;
                activeRecognition.stop();
                
                if (activeButton) {
                    activeButton.classList.remove('listening');
                    activeButton.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                        <span>Practice</span>
                    `;
                    activeButton = null;
                    activeRecognition = null;
                }
            }

            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                button.classList.add('listening');
                
                let voices = window.speechSynthesis.getVoices();
                
                if (voices.length === 0) {
                    window.speechSynthesis.onvoiceschanged = function() {
                        voices = window.speechSynthesis.getVoices();
                        speakWithVoice(voices);
                    };
                } else {
                    speakWithVoice(voices);
                }
                
                function speakWithVoice(voices) {
                    let selectedVoice = voices.find(voice => 
                        voice.lang.startsWith('en') && 
                        (voice.name.includes('Google') || voice.name.includes('Natural'))
                    );
                    
                    if (!selectedVoice) {
                        selectedVoice = voices.find(voice => 
                            voice.lang.startsWith('en') && 
                            voice.name.includes('Microsoft')
                        );
                    }
                    
                    if (!selectedVoice) {
                        selectedVoice = voices.find(voice => voice.lang.startsWith('en'));
                    }
                    
                    const utterance = new SpeechSynthesisUtterance(idiom);
                    if (selectedVoice) utterance.voice = selectedVoice;
                    utterance.lang = 'en-US';
                    utterance.rate = 0.75;
                    utterance.pitch = 1.05;
                    utterance.volume = 1.0;
                    
                    utterance.onend = function() {
                        button.classList.remove('listening');
                        setTimeout(() => {
                            const exampleUtterance = new SpeechSynthesisUtterance(example);
                            if (selectedVoice) exampleUtterance.voice = selectedVoice;
                            exampleUtterance.lang = 'en-US';
                            exampleUtterance.rate = 0.85;
                            exampleUtterance.pitch = 1.02;
                            exampleUtterance.volume = 1.0;
                            window.speechSynthesis.speak(exampleUtterance);
                        }, 600);
                    };
                    
                    window.speechSynthesis.speak(utterance);
                }
            } else {
                alert('Sorry, your browser does not support text-to-speech.');
            }
        }

        // LocalStorage Score Management
        const STORAGE_KEY = 'idiom_scores';

        const currentLevel = '{{ strtolower($level) }}';
        const serverScore = {{ $progress ? $progress->score : 'null' }};
        const totalQuestions = {{ $total_questions ?? count($idioms) }};

        function getAllScores() {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : {};
        }

        function getLevelScores() {
            const allScores = getAllScores();
            return allScores[currentLevel] || { scores: [], average: 0, lastPracticed: null };
        }

        function saveScore(score) {
            const allScores = getAllScores();
            
            if (!allScores[currentLevel]) {
                allScores[currentLevel] = { scores: [], average: 0, lastPracticed: null };
            }
            
            allScores[currentLevel].scores.push(score);
            
            if (allScores[currentLevel].scores.length > 20) {
                allScores[currentLevel].scores = allScores[currentLevel].scores.slice(-20);
            }
            
            const scores = allScores[currentLevel].scores;
            const average = scores.reduce((sum, s) => sum + s, 0) / scores.length;
            allScores[currentLevel].average = Math.round(average);
            allScores[currentLevel].lastPracticed = new Date().toISOString();
            
            localStorage.setItem(STORAGE_KEY, JSON.stringify(allScores));
            
            console.log('Score saved:', score, 'New average:', allScores[currentLevel].average);

            // Send to server
            updateServerProgress(allScores[currentLevel].average);
        }

        // Send score to server
        function updateServerProgress(score) {
            fetch('/free-lesson/progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    lesson_slug: 'idioms-' + currentLevel,
                    score: score,
                    total_questions: totalQuestions
                })
            })
            .then(response => response.json())
            .then(data => console.log('Server progress updated', data))
            .catch(error => console.error('Error updating progress:', error));
        }

        function updateScoreDisplay(average) {
            const scoreElement = document.getElementById('averageScore');
            if (scoreElement) {
                const scoreSpan = scoreElement.querySelector('span');
                if (scoreSpan) {
                    scoreSpan.textContent = average + '%';
                    
                    const svg = scoreElement.querySelector('svg');
                    if (average >= 90) {
                        svg.classList.remove('text-yellow-500', 'text-blue-500', 'text-orange-500', 'text-gray-400');
                        svg.classList.add('text-green-500');
                    } else if (average >= 75) {
                        svg.classList.remove('text-green-500', 'text-yellow-500', 'text-orange-500', 'text-gray-400');
                        svg.classList.add('text-blue-500');
                    } else if (average >= 60) {
                        svg.classList.remove('text-green-500', 'text-blue-500', 'text-yellow-500', 'text-gray-400');
                        svg.classList.add('text-orange-500');
                    } else {
                        svg.classList.remove('text-green-500', 'text-blue-500', 'text-orange-500', 'text-yellow-500');
                        svg.classList.add('text-gray-400');
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Prioritize server score if available
            if (serverScore !== null) {
                updateScoreDisplay(serverScore);
                
                // Sync local storage if needed
                const allScores = getAllScores();
                if (!allScores[currentLevel] || allScores[currentLevel].average !== serverScore) {
                     if (!allScores[currentLevel]) {
                        allScores[currentLevel] = { scores: [], average: serverScore, lastPracticed: new Date().toISOString() };
                     } else {
                        allScores[currentLevel].average = serverScore;
                     }
                     localStorage.setItem(STORAGE_KEY, JSON.stringify(allScores));
                }
            } else {
                const levelData = getLevelScores();
                if (levelData.average > 0) {
                    updateScoreDisplay(levelData.average);
                }
            }
        });

        // Global variables for speech recognition
        let activeRecognition = null;
        let activeButton = null;
        let isManuallyStopped = false;

        // Speech Recognition Function
        function toggleRecognition(targetIdiom, button) {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert('Sorry, your browser does not support speech recognition. Please use Chrome or Edge.');
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const card = button.closest('.idiom-card');
            const feedbackArea = card.querySelector('.feedback-area');
            const feedbackMessage = card.querySelector('.feedback-message');
            
            const practiceButtonHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                </svg>
                <span>Practice</span>
            `;

            document.querySelectorAll('.listen-btn, .practice-btn').forEach(btn => {
                if (btn !== button && btn.classList.contains('listening')) {
                    btn.classList.remove('listening');
                    if (btn.classList.contains('practice-btn')) {
                        btn.innerHTML = practiceButtonHTML;
                    }
                }
            });

            if (activeRecognition) {
                if (activeButton === button) {
                    isManuallyStopped = true;
                    activeRecognition.stop();
                    return;
                }
                
                isManuallyStopped = true;
                activeRecognition.stop();
            }

            const recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.continuous = true;
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            activeRecognition = recognition;
            activeButton = button;
            isManuallyStopped = false;

            recognition.onstart = function() {
                button.classList.add('listening');
                button.innerHTML = `
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <div class="flex flex-col text-left leading-tight">
                        <span>Merekam...</span>
                        <span class="text-[10px] font-normal opacity-80">Tekan ulang utk berhenti</span>
                    </div>
                `;
                feedbackArea.classList.add('hidden');
            };

            recognition.onresult = function(event) {
                if (!event.results || event.results.length === 0) return;

                const lastResultIndex = event.results.length - 1;
                const result = event.results[lastResultIndex][0];
                
                if (!result) return;

                const spokenText = result.transcript.toLowerCase().trim();
                const confidence = Math.round(result.confidence * 100);
                const targetLower = targetIdiom.toLowerCase().trim();

                if (feedbackArea) {
                    feedbackArea.classList.remove('hidden');
                    feedbackArea.style.display = 'block';
                }
                
                const isMatch = spokenText === targetLower || spokenText.includes(targetLower);
                
                if (isMatch) {
                    saveScore(confidence);
                    
                    card.classList.add('success-feedback');
                    card.style.borderColor = '#10b981';
                    feedbackMessage.className = 'feedback-message p-3 rounded-xl text-center font-bold bg-green-100 text-green-700 border border-green-200';
                    feedbackMessage.innerHTML = `
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-center gap-2 text-lg">
                                <span>✅</span>
                                <span>Excellent!</span>
                            </div>
                            <div class="text-sm font-normal text-green-800">
                                You said: "${spokenText}" <span class="opacity-75">(${confidence}% confidence)</span>
                            </div>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        card.style.borderColor = '';
                        card.classList.remove('success-feedback');
                    }, 3000);
                } else {
                    card.style.borderColor = '#ef4444';
                    feedbackMessage.className = 'feedback-message p-3 rounded-xl text-center font-bold bg-red-50 text-red-700 border border-red-200';
                    feedbackMessage.innerHTML = `
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-center gap-2 text-lg">
                                <span>❌</span>
                                <span>Try Again</span>
                            </div>
                            <div class="text-sm font-normal text-red-800">
                                You said: "${spokenText}"
                            </div>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        card.style.borderColor = '';
                    }, 3000);
                }
            };

            recognition.onerror = function(event) {
                if (event.error === 'aborted' && isManuallyStopped) return;
                if (activeRecognition !== recognition) return;
                
                feedbackArea.classList.remove('hidden');
                feedbackArea.style.display = 'block';
                
                let errorMsg = '';
                if (event.error === 'not-allowed' || event.error === 'permission-denied') {
                    errorMsg = '⚠️ Microphone access denied. Please allow microphone access.';
                } else if (event.error === 'network') {
                    errorMsg = '📡 Network Required - Internet connection is required for speech recognition.';
                } else if (event.error === 'no-speech') {
                    return;
                } else {
                    errorMsg = '⚠️ Error: ' + event.error + '. Please try again.';
                }
                
                feedbackMessage.className = 'feedback-message p-3 rounded-xl text-center font-bold bg-yellow-100 text-yellow-700 border border-yellow-200';
                feedbackMessage.innerHTML = errorMsg;
                
                if (event.error !== 'no-speech') {
                    isManuallyStopped = true;
                    resetUI();
                }
            };

            recognition.onend = function() {
                if (activeRecognition !== recognition) {
                     button.classList.remove('listening');
                     button.innerHTML = practiceButtonHTML;
                     return;
                }
                
                if (!isManuallyStopped) {
                    try {
                        recognition.start();
                    } catch (e) {
                        resetUI();
                    }
                } else {
                    resetUI();
                }
            };

            function resetUI() {
                button.classList.remove('listening');
                button.innerHTML = practiceButtonHTML;
                
                if (activeRecognition === recognition) {
                    activeRecognition = null;
                    activeButton = null;
                }
            }

            try {
                recognition.start();
            } catch (error) {
                resetUI();
            }
        }
    </script>
</body>
</html>
