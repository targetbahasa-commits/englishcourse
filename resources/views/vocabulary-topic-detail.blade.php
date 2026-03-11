<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Vocabulary A1</title>
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
            ['from' => 'from-blue-400', 'to' => 'to-blue-600', 'accent' => 'bg-blue-500', 'light' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'bg_light' => 'bg-blue-50'],
            ['from' => 'from-purple-400', 'to' => 'to-purple-600', 'accent' => 'bg-purple-500', 'light' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-100', 'bg_light' => 'bg-purple-50'],
            ['from' => 'from-pink-400', 'to' => 'to-pink-600', 'accent' => 'bg-pink-500', 'light' => 'bg-pink-50', 'text' => 'text-pink-600', 'border' => 'border-pink-100', 'bg_light' => 'bg-pink-50'],
            ['from' => 'from-indigo-400', 'to' => 'to-indigo-600', 'accent' => 'bg-indigo-500', 'light' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100', 'bg_light' => 'bg-indigo-50'],
            ['from' => 'from-cyan-400', 'to' => 'to-cyan-600', 'accent' => 'bg-cyan-500', 'light' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100', 'bg_light' => 'bg-cyan-50'],
        ];
        // Adjust index to match 0-based array (topicId starts at 1)
        $color = $colors[($topicId - 1) % 5];
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
            @elseif(Auth::user()->role === 'guest')
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
                @php
                    if (isset($level)) {
                        if ($level === 'A2') {
                            $backRoute = 'vocabulary-a2';
                        } elseif ($level === 'B1') {
                            $backRoute = 'vocabulary-b1';
                        } elseif ($level === 'B2') {
                            $backRoute = 'vocabulary-b2';
                        } elseif ($level === 'C1') {
                            $backRoute = 'vocabulary-c1';
                        } else {
                            $backRoute = 'vocabulary-a1';
                        }
                    } else {
                        $backRoute = 'vocabulary-a1';
                    }
                @endphp
                <a href="{{ route($backRoute) }}" class="inline-flex items-center {{ $color['text'] }} hover:opacity-80 mb-6 font-medium transition-all hover:gap-3 gap-2 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Topics
                </a>
                
                <div class="bg-white/70 backdrop-blur-md rounded-3xl p-8 shadow-2xl border-2 border-white/50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-2xl flex items-center justify-center shadow-xl">
                                <span class="text-3xl font-bold text-white">{{ $topicId }}</span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} bg-clip-text text-transparent">
                                    {{ $title }}
                                </h1>
                                <p class="text-gray-600 mt-1">{{ count($vocabularies) }} vocabulary words</p>
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
                                <div class="text-2xl font-bold {{ $color['text'] }}">0/{{ count($vocabularies) }}</div>
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
                                    <p class="text-sm text-gray-600">Click to hear the pronunciation</p>
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
                                    <p class="text-sm text-gray-600">Speak the word and get feedback</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vocabulary Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vocabularies as $index => $vocab)
                <div class="vocab-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:scale-105" data-word="{{ $vocab['word'] }}">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="text-xs font-bold text-white/80 mb-2">VOCABULARY #{{ $index + 1 }}</div>
                            <h3 class="text-3xl font-bold text-white mb-2">{{ $vocab['word'] }}</h3>
                            <p class="text-white/90 text-lg">{{ $vocab['translation'] }}</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Example Section -->
                        <div class="mb-6">
                            <p class="text-xs font-bold text-gray-400 mb-2">EXAMPLE:</p>
                            <div class="{{ $color['light'] }} rounded-xl p-4 border {{ $color['border'] }}">
                                <p class="text-gray-800 font-medium mb-1">"{{ $vocab['example_en'] }}"</p>
                                <p class="text-gray-600 text-sm italic">"{{ $vocab['example_id'] }}"</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Listen Button -->
                            <button onclick="speakText(this)" 
                                    data-word="{{ $vocab['word'] }}" 
                                    data-example="{{ $vocab['example_en'] }}"
                                    class="listen-btn flex items-center justify-center gap-2 bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} text-white py-3 px-4 rounded-xl font-bold hover:opacity-90 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                </svg>
                                <span>Listen</span>
                            </button>

                            <!-- Practice Button -->
                            <button onclick="toggleRecognition('{{ $vocab['word'] }}', this)" class="practice-btn flex items-center justify-center gap-2 bg-white border-2 {{ $color['border'] }} {{ $color['text'] }} py-3 px-4 rounded-xl font-bold hover:bg-gray-50 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
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
        // Text to Speech Function with Natural Voice
        function speakText(button) {
            const word = button.dataset.word;
            const example = button.dataset.example;

            // CRITICAL: Stop any active recognition to prevent self-recording
            if (activeRecognition) {
                console.log('Stopping recognition before playing audio...');
                isManuallyStopped = true;
                activeRecognition.stop();
                
                // Reset the practice button UI
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
                // Cancel any ongoing speech
                window.speechSynthesis.cancel();
                
                // Add visual feedback
                button.classList.add('listening');
                
                // Get available voices
                let voices = window.speechSynthesis.getVoices();
                
                // If voices not loaded yet, wait for them
                if (voices.length === 0) {
                    window.speechSynthesis.onvoiceschanged = function() {
                        voices = window.speechSynthesis.getVoices();
                        speakWithVoice(voices);
                    };
                } else {
                    speakWithVoice(voices);
                }
                
                function speakWithVoice(voices) {
                    // Select the best English voice (prefer Google or Microsoft natural voices)
                    let selectedVoice = null;
                    
                    // Priority 1: Google voices (most natural)
                    selectedVoice = voices.find(voice => 
                        voice.lang.startsWith('en') && 
                        (voice.name.includes('Google') || voice.name.includes('Natural'))
                    );
                    
                    // Priority 2: Microsoft voices
                    if (!selectedVoice) {
                        selectedVoice = voices.find(voice => 
                            voice.lang.startsWith('en') && 
                            voice.name.includes('Microsoft')
                        );
                    }
                    
                    // Priority 3: Any female voice (usually more pleasant)
                    if (!selectedVoice) {
                        selectedVoice = voices.find(voice => 
                            voice.lang.startsWith('en') && 
                            (voice.name.includes('Female') || voice.name.includes('Samantha') || voice.name.includes('Karen'))
                        );
                    }
                    
                    // Priority 4: Any English voice
                    if (!selectedVoice) {
                        selectedVoice = voices.find(voice => voice.lang.startsWith('en'));
                    }
                    
                    // Fallback: Use first available voice
                    if (!selectedVoice && voices.length > 0) {
                        selectedVoice = voices[0];
                    }
                    
                    console.log('Selected voice:', selectedVoice ? selectedVoice.name : 'Default');
                    
                    // Speak the word with optimized parameters
                    const utterance = new SpeechSynthesisUtterance(word);
                    if (selectedVoice) {
                        utterance.voice = selectedVoice;
                    }
                    utterance.lang = 'en-US';
                    utterance.rate = 0.75; // Slower for better learning & clarity
                    utterance.pitch = 1.05; // Slightly higher pitch for warmth
                    utterance.volume = 1.0; // Full volume
                    
                    utterance.onend = function() {
                        button.classList.remove('listening');
                        // Speak the example after a pause
                        setTimeout(() => {
                            const exampleUtterance = new SpeechSynthesisUtterance(example);
                            if (selectedVoice) {
                                exampleUtterance.voice = selectedVoice;
                            }
                            exampleUtterance.lang = 'en-US';
                            exampleUtterance.rate = 0.85; // Slightly faster for natural sentence flow
                            exampleUtterance.pitch = 1.02; // Subtle variation for naturalness
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

        // ========== LocalStorage Score Management ==========
        const STORAGE_KEY = 'vocabulary_scores';
        const currentTopicId = {{ $topicId }};
        const serverScore = {{ $progress ? $progress->score : 'null' }};
        const totalQuestions = {{ $total_questions ?? count($vocabularies) }};

        // Get all scores from localStorage
        function getAllScores() {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : {};
        }

        // Get scores for current topic
        function getTopicScores() {
            const allScores = getAllScores();
            return allScores[`topic_${currentTopicId}`] || { scores: [], average: 0, lastPracticed: null };
        }

        // Save new score for current topic
        function saveScore(score) {
            const allScores = getAllScores();
            const topicKey = `topic_${currentTopicId}`;
            
            if (!allScores[topicKey]) {
                allScores[topicKey] = { scores: [], average: 0, lastPracticed: null };
            }
            
            // Add new score
            allScores[topicKey].scores.push(score);
            
            // Keep only last 20 scores to prevent localStorage bloat
            if (allScores[topicKey].scores.length > 20) {
                allScores[topicKey].scores = allScores[topicKey].scores.slice(-20);
            }
            
            // Calculate new average
            const scores = allScores[topicKey].scores;
            const average = scores.reduce((sum, s) => sum + s, 0) / scores.length;
            allScores[topicKey].average = Math.round(average);
            allScores[topicKey].lastPracticed = new Date().toISOString();
            
            // Save to localStorage
            localStorage.setItem(STORAGE_KEY, JSON.stringify(allScores));
            
            // Update display
            updateScoreDisplay(allScores[topicKey].average);
            
            
            console.log('Score saved:', score, 'New average:', allScores[topicKey].average);

            // Send to server
            updateServerProgress(allScores[topicKey].average);
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
                    lesson_slug: 'vocabulary-a1-topic-' + currentTopicId,
                    score: score,
                    total_questions: totalQuestions
                })
            })
            .then(response => response.json())
            .then(data => console.log('Server progress updated', data))
            .catch(error => console.error('Error updating progress:', error));
        }

        // Update score display in UI
        function updateScoreDisplay(average) {
            const scoreElement = document.getElementById('averageScore');
            if (scoreElement) {
                const scoreSpan = scoreElement.querySelector('span');
                if (scoreSpan) {
                    scoreSpan.textContent = average + '%';
                    
                    // Color code based on score
                    const svg = scoreElement.querySelector('svg');
                    if (average >= 90) {
                        svg.classList.remove('text-yellow-500', 'text-blue-500', 'text-orange-500', 'text-gray-400');
                        svg.classList.add('text-green-500'); // Excellent
                    } else if (average >= 75) {
                        svg.classList.remove('text-green-500', 'text-yellow-500', 'text-orange-500', 'text-gray-400');
                        svg.classList.add('text-blue-500'); // Good
                    } else if (average >= 60) {
                        svg.classList.remove('text-green-500', 'text-blue-500', 'text-yellow-500', 'text-gray-400');
                        svg.classList.add('text-orange-500'); // Fair
                    } else {
                        svg.classList.remove('text-green-500', 'text-blue-500', 'text-orange-500', 'text-yellow-500');
                        svg.classList.add('text-gray-400'); // Needs improvement
                    }
                }
            }
        }

        // Load and display score on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Prioritize server score if available
            if (serverScore !== null) {
                updateScoreDisplay(serverScore);
                
                // Sync local storage if needed (optional, but good for consistency)
                const allScores = getAllScores();
                const topicKey = `topic_${currentTopicId}`;
                if (!allScores[topicKey] || allScores[topicKey].average !== serverScore) {
                     if (!allScores[topicKey]) {
                        allScores[topicKey] = { scores: [], average: serverScore, lastPracticed: new Date().toISOString() };
                     } else {
                        allScores[topicKey].average = serverScore;
                     }
                     localStorage.setItem(STORAGE_KEY, JSON.stringify(allScores));
                }
            } else {
                const topicData = getTopicScores();
                if (topicData.average > 0) {
                    updateScoreDisplay(topicData.average);
                }
            }
        });


        // Global variables for speech recognition
        let activeRecognition = null;
        let activeButton = null;
        let isManuallyStopped = false;

        // Web Speech API Recognition Function with Toggle
        function toggleRecognition(targetWord, button) {
            // Check browser support
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert('Sorry, your browser does not support speech recognition. Please use Chrome or Edge.');
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const card = button.closest('.vocab-card');
            const feedbackArea = card.querySelector('.feedback-area');
            const feedbackMessage = card.querySelector('.feedback-message');
            
            // Standard button content for reset
            const practiceButtonHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                </svg>
                <span>Practice</span>
            `;

            // 1. Global Cleanup: Reset ANY button that looks like it's recording
            // This acts as a failsafe for any UI that got out of sync
            document.querySelectorAll('.listen-btn, .practice-btn').forEach(btn => {
                if (btn !== button && btn.classList.contains('listening')) {
                    btn.classList.remove('listening');
                    if (btn.classList.contains('practice-btn')) {
                        btn.innerHTML = practiceButtonHTML;
                    }
                }
            });

            // 2. Handle Active Recognition
            if (activeRecognition) {
                // If clicking the SAME button, just stop it
                if (activeButton === button) {
                    console.log('Stopping current recognition...');
                    isManuallyStopped = true;
                    activeRecognition.stop();
                    return;
                }
                
                // If clicking a DIFFERENT button, stop previous one
                console.log('Stopping previous recognition to start new one...');
                isManuallyStopped = true;
                activeRecognition.stop();
                
                // Note: We do NOT nullify onend here anymore. We let it fire.
                // The onend handler will check activeRecognition !== recognition and exit gracefully.
            }

            // Initialize new recognition
            const recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.continuous = true;
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            // Update global state immediately
            activeRecognition = recognition;
            activeButton = button;
            isManuallyStopped = false;

            recognition.onstart = function() {
                console.log('Recognition started');
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
                console.log('Recognition result event:', event);
                
                if (!event.results || event.results.length === 0) {
                    console.warn('No results found');
                    return;
                }

                const lastResultIndex = event.results.length - 1;
                const result = event.results[lastResultIndex][0];
                
                if (!result) {
                    console.warn('No result object');
                    return;
                }

                const spokenWord = result.transcript.toLowerCase().trim();
                const confidence = Math.round(result.confidence * 100);
                const targetLower = targetWord.toLowerCase().trim();
                
                console.log('Spoken:', spokenWord, 'Target:', targetLower, 'Confidence:', confidence + '%');

                if (feedbackArea) {
                    feedbackArea.classList.remove('hidden');
                    feedbackArea.style.display = 'block';
                }
                
                // Normalize text to handle numbers (e.g. "16" -> "sixteen")
                function normalizeText(text) {
                    const numbers = {
                        '0': 'zero', '1': 'one', '2': 'two', '3': 'three', '4': 'four', 
                        '5': 'five', '6': 'six', '7': 'seven', '8': 'eight', '9': 'nine', 
                        '10': 'ten', '11': 'eleven', '12': 'twelve', '13': 'thirteen', 
                        '14': 'fourteen', '15': 'fifteen', '16': 'sixteen', '17': 'seventeen', 
                        '18': 'eighteen', '19': 'nineteen', '20': 'twenty'
                    };
                    
                    // Replace digits with words
                    let normalized = text;
                    for (let digit in numbers) {
                        // Use regex to replace whole words or isolated digits
                        const regex = new RegExp(`\\b${digit}\\b`, 'g');
                        normalized = normalized.replace(regex, numbers[digit]);
                    }
                    return normalized;
                }

                const normalizedSpoken = normalizeText(spokenWord);
                const normalizedTarget = normalizeText(targetLower);
                
                console.log('Normalized Spoken:', normalizedSpoken, 'Normalized Target:', normalizedTarget);
                
                const isMatch = normalizedSpoken === normalizedTarget || normalizedSpoken.includes(normalizedTarget);
                
                if (isMatch) {
                    // Correct! - Save score based on confidence
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
                                You said: "${spokenWord}" <span class="opacity-75">(${confidence}% confidence)</span>
                            </div>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        card.style.borderColor = '';
                        card.classList.remove('success-feedback');
                    }, 3000);
                } else {
                    // Incorrect
                    card.style.borderColor = '#ef4444';
                    feedbackMessage.className = 'feedback-message p-3 rounded-xl text-center font-bold bg-red-50 text-red-700 border border-red-200';
                    feedbackMessage.innerHTML = `
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-center gap-2 text-lg">
                                <span>❌</span>
                                <span>Try Again</span>
                            </div>
                            <div class="text-sm font-normal text-red-800">
                                You said: "${spokenWord}"
                            </div>
                        </div>
                    `;
                    
                    setTimeout(() => {
                        card.style.borderColor = '';
                    }, 3000);
                }
            };

            recognition.onerror = function(event) {
                console.error('Recognition error:', event.error);
                
                // Ignore aborted error if manually stopped
                if (event.error === 'aborted' && isManuallyStopped) {
                    return;
                }
                
                // If I am no longer the active recognition, ignore errors
                if (activeRecognition !== recognition) {
                    return;
                }
                
                feedbackArea.classList.remove('hidden');
                feedbackArea.style.display = 'block';
                
                let errorMsg = '';
                if (event.error === 'not-allowed' || event.error === 'permission-denied') {
                    errorMsg = '⚠️ Microphone access denied. Please allow microphone access.';
                } else if (event.error === 'network') {
                    feedbackMessage.className = 'feedback-message p-3 rounded-xl text-center font-bold bg-red-100 text-red-700 border border-red-200';
                    errorMsg = `
                        <div class="flex flex-col gap-1">
                            <div class="text-lg">📡 Network Required</div>
                            <div class="text-sm font-normal">
                                Internet connection is required for speech recognition. Please check your connection.
                            </div>
                        </div>
                    `;
                } else if (event.error === 'no-speech') {
                    // Ignore no-speech errors for auto-restart
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
                console.log('Recognition ended');
                
                // CRITICAL: If I am no longer the active recognition (because another button was clicked),
                // just reset MY UI and exit. Do NOT touch global state or restart.
                if (activeRecognition !== recognition) {
                     console.log('Recognition replaced by new instance. Exiting.');
                     button.classList.remove('listening');
                     button.innerHTML = practiceButtonHTML;
                     return;
                }
                
                // Auto-restart if not manually stopped
                if (!isManuallyStopped) {
                    console.log('Auto-restarting recognition...');
                    try {
                        recognition.start();
                    } catch (e) {
                        console.log('Could not restart:', e);
                        resetUI();
                    }
                } else {
                    resetUI();
                }
            };

            function resetUI() {
                button.classList.remove('listening');
                button.innerHTML = practiceButtonHTML;
                
                // Only clear global state if I am still the active recognition
                if (activeRecognition === recognition) {
                    activeRecognition = null;
                    activeButton = null;
                }
            }

            try {
                recognition.start();
            } catch (error) {
                console.error('Failed to start recognition:', error);
                // If start fails, ensure we clean up
                resetUI();
            }
        }
    </script>
</body>
</html>
```
