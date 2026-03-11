<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        @keyframes success-bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .listening { animation: pulse-ring 1.5s ease-in-out infinite; }
        .success-feedback { animation: success-bounce 0.5s ease; background-color: #ecfdf5 !important; }
        .error-feedback { background-color: #fef2f2 !important; }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }
        
        /* Custom Scrollbar for Table */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #a78bfa, #c084fc);
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #8b5cf6, #a78bfa);
            background-clip: padding-box;
        }
        
        /* Row hover effect */
        tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        tbody tr:hover {
            transform: scale(1.005);
            box-shadow: 0 4px 20px -2px rgba(139, 92, 246, 0.15);
        }
    </style>
    @php
        $color = ['from' => 'from-indigo-500', 'to' => 'to-violet-600', 'accent' => 'bg-violet-500', 'light' => 'bg-violet-50', 'text' => 'text-violet-600', 'border' => 'border-violet-100', 'bg_light' => 'bg-violet-50'];
    @endphp
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-indigo-50/30 to-violet-50/40 min-h-screen">
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
        <main class="flex-1 md:ml-64 p-4 md:p-6 pb-3">
            <!-- Header Section -->
            <div class="mb-4 relative overflow-hidden rounded-3xl bg-white shadow-2xl border-2 border-violet-200/60 p-5 md:p-6 fade-in-up">
                <!-- Decorative Background Pattern -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-gradient-to-br from-indigo-200 to-violet-200 blur-3xl opacity-70 pointer-events-none animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-80 h-80 rounded-full bg-gradient-to-tr from-violet-200 to-fuchsia-200 blur-3xl opacity-70 pointer-events-none animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 blur-3xl opacity-40 pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <a href="{{ route('free-lesson') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors text-sm mb-4 font-medium group">
                            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Free Lessons
                        </a>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-2xl flex items-center justify-center shadow-violet-300 shadow-2xl transform rotate-3 transition-all duration-300 hover:rotate-6 hover:scale-110 hover:shadow-violet-400">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-700 tracking-tight">
                                    {{ $title }}
                                </h1>
                                <p class="text-gray-500 mt-1 font-medium flex items-center gap-2">
                                    <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide">Mastery</span>
                                    {{ count($vocabularies) }} irregular verbs available
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Search & Score -->
                    <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4 w-full md:w-auto">
                        <!-- Search Bar -->
                        <div class="relative group w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="verbSearch" placeholder="Search verbs..." 
                                   class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-200 focus:border-purple-400 focus:bg-white transition-all outline-none placeholder-gray-400 text-gray-700 font-medium">
                        </div>

                        <!-- Score Display -->
                        <div class="bg-gray-50 px-4 py-2 rounded-xl border border-gray-100 flex items-center gap-3">
                             <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider text-right leading-tight">
                                Average<br>Score
                            </div>
                           <div id="averageScore" class="flex items-center gap-1.5">
                                <span class="text-2xl font-black {{ $color['text'] }}">--</span>
                                <svg class="w-5 h-5 text-gray-300 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-violet-200/60 flex flex-col h-[calc(100vh-200px)] min-h-[500px] fade-in-up" style="animation-delay: 0.1s;">
                <div class="overflow-y-auto custom-scrollbar flex-1 relative">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-rose-100/90 via-violet-100/90 via-blue-100/90 via-emerald-100/90 to-amber-100/90 backdrop-blur-md sticky top-0 z-20 shadow-lg border-b-2 border-violet-200">
                            <tr class="text-gray-700 text-xs font-extrabold uppercase tracking-wider">
                                <th class="p-5 w-1/6 border-r-2 border-rose-200/50 text-rose-800">Meaning</th>
                                <th class="p-5 w-1/4 border-r-2 border-violet-200/50 text-violet-800">Verb 1 (Base)</th>
                                <th class="p-5 w-1/6 border-r-2 border-blue-200/50 text-blue-800">Verb 2 (Past)</th>
                                <th class="p-5 w-1/6 border-r-2 border-emerald-200/50 text-emerald-800">Verb 3 (Participle)</th>
                                <th class="p-5 w-1/4 text-amber-800">Example Sentence</th>
                            </tr>
                        </thead>
                        <tbody id="verbsTableBody" class="divide-y divide-gray-100">
                            @foreach($vocabularies as $index => $vocab)
                            <tr class="group hover:bg-gradient-to-r hover:from-rose-50/50 hover:via-violet-50/50 hover:via-blue-50/50 hover:via-emerald-50/50 hover:to-amber-50/50 transition-all duration-300 border-b border-gray-100 hover:border-violet-200" 
                                data-base="{{ strtolower($vocab['base']) }}"
                                data-past="{{ strtolower($vocab['past']) }}"
                                data-participle="{{ strtolower($vocab['participle']) }}"
                                data-meaning="{{ strtolower($vocab['translation']) }}">
                                
                                <td class="p-5 align-top bg-gradient-to-br from-rose-50/30 to-pink-50/20 group-hover:from-rose-100/60 group-hover:to-pink-100/40 transition-all duration-300 border-r border-rose-100/50">
                                    <div class="font-bold text-rose-900 text-base group-hover:text-rose-950 group-hover:scale-105 transition-all">{{ $vocab['translation'] }}</div>
                                </td>
                                
                                <td class="p-5 align-top min-w-[240px] bg-gradient-to-br from-violet-50/50 via-purple-50/40 to-indigo-50/30 group-hover:from-violet-100/80 group-hover:via-purple-100/70 group-hover:to-indigo-100/60 transition-all duration-300 border-r border-violet-100/50 shadow-inner">
                                    <div class="flex flex-col gap-3">
                                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 group-hover:from-indigo-700 group-hover:via-violet-700 group-hover:to-purple-700 transition-all duration-300">{{ $vocab['base'] }}</span>
                                        
                                        <div class="flex items-center gap-2 opacity-90 group-hover:opacity-100 transition-opacity">
                                            <!-- Listen Button -->
                                            <button onclick="speakText(this, '{{ $vocab['base'] }}', '{{ $vocab['past'] }}', '{{ $vocab['participle'] }}', '{{ addslashes($vocab['example']) }}')" 
                                                    class="listen-btn p-2 rounded-lg bg-white border-2 border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 transition-all shadow-md hover:shadow-lg hover:scale-110"
                                                    title="Listen to pronunciation">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                                </svg>
                                            </button>
                                            
                                            <!-- Practice Button -->
                                            <button onclick="toggleRecognition('{{ $vocab['base'] }}', this)" 
                                                    class="practice-btn flex items-center gap-1.5 px-3 py-2 rounded-lg bg-white border-2 border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-300 hover:bg-purple-50 transition-all shadow-md hover:shadow-lg hover:scale-110"
                                                    title="Practice saying this word">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                                </svg>
                                                <span class="text-xs font-bold uppercase tracking-wider">Practice</span>
                                            </button>
                                        </div>

                                        <!-- Feedback Area -->
                                        <div class="feedback-message hidden text-xs font-bold p-2.5 rounded-lg border border-transparent animate-fade-in-down"></div>
                                    </div>
                                </td>
                                
                                <td class="p-5 align-top bg-gradient-to-br from-blue-50/30 to-cyan-50/20 group-hover:from-blue-100/60 group-hover:to-cyan-100/40 transition-all duration-300 border-r border-blue-100/50">
                                    <div class="font-semibold text-blue-800 group-hover:text-blue-950 group-hover:scale-105 transition-all">{{ $vocab['past'] }}</div>
                                </td>
                                
                                <td class="p-5 align-top bg-gradient-to-br from-emerald-50/30 to-teal-50/20 group-hover:from-emerald-100/60 group-hover:to-teal-100/40 transition-all duration-300 border-r border-emerald-100/50">
                                    <div class="font-semibold text-emerald-800 group-hover:text-emerald-950 group-hover:scale-105 transition-all">{{ $vocab['participle'] }}</div>
                                </td>
                                
                                <td class="p-5 align-top bg-gradient-to-br from-amber-50/30 to-orange-50/20 group-hover:from-amber-100/60 group-hover:to-orange-100/40 transition-all duration-300">
                                    <div class="bg-gradient-to-br from-amber-50/90 to-orange-50/60 rounded-xl p-3.5 border-2 border-amber-200/50 text-sm text-amber-950 italic leading-relaxed group-hover:bg-white group-hover:border-amber-300 group-hover:shadow-lg group-hover:scale-[1.02] transition-all duration-300">
                                        "{{ $vocab['example'] }}"
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Values Empty State -->
                    <div id="noResults" class="hidden flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">No verbs found</h3>
                        <p class="text-gray-500">Try searching for a different base form or meaning.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ========== Search Functionality ==========
        const searchInput = document.getElementById('verbSearch');
        const tableBody = document.getElementById('verbsTableBody');
        const rows = tableBody.querySelectorAll('tr');
        const noResults = document.getElementById('noResults');

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const base = row.getAttribute('data-base');
                const past = row.getAttribute('data-past');
                const participle = row.getAttribute('data-participle');
                const meaning = row.getAttribute('data-meaning');

                if (base.includes(query) || past.includes(query) || participle.includes(query) || meaning.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                noResults.classList.add('flex');
            } else {
                noResults.classList.add('hidden');
                noResults.classList.remove('flex');
            }
        });

        // ========== TTS Logic ==========
        function speakText(button, base, past, participle, example) {
            if (activeRecognition) {
                isManuallyStopped = true;
                activeRecognition.stop();
                resetActiveButton();
            }

            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                button.classList.add('listening', 'text-indigo-600', 'border-indigo-600', 'bg-indigo-50');
                
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
                    let selectedVoice = voices.find(voice => voice.lang.startsWith('en') && (voice.name.includes('Google') || voice.name.includes('Natural'))) || voices[0];
                    
                    const text = `${base}, ${past}, ${participle}`;
                    const utterance = new SpeechSynthesisUtterance(text);
                    if (selectedVoice) utterance.voice = selectedVoice;
                    utterance.lang = 'en-US';
                    utterance.rate = 0.8;
                    
                    utterance.onend = function() {
                        setTimeout(() => {
                            const exampleUtterance = new SpeechSynthesisUtterance(example);
                            if (selectedVoice) exampleUtterance.voice = selectedVoice;
                            exampleUtterance.rate = 0.9;
                            exampleUtterance.onend = function() {
                                button.classList.remove('listening', 'text-indigo-600', 'border-indigo-600', 'bg-indigo-50');
                            };
                            window.speechSynthesis.speak(exampleUtterance);
                        }, 400);
                    };
                    
                    window.speechSynthesis.speak(utterance);
                }
            } else {
                alert('TTS not supported');
            }
        }

        // ========== Score Logic ==========
        const STORAGE_KEY = 'irregular_verb_scores';
        const currentTopicId = 'all_verbs_v2'; 
        // Server side score passed via Blade
        const serverScore = {{ $progress ? $progress->score : 'null' }};

        function getAllScores() {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : {};
        }

        function getTopicScores() {
            const allScores = getAllScores();
            return allScores[`topic_${currentTopicId}`] || { scores: [], average: 0 };
        }

        function saveScore(score) {
            const allScores = getAllScores();
            const topicKey = `topic_${currentTopicId}`;
            if (!allScores[topicKey]) allScores[topicKey] = { scores: [], average: 0 };
            
            allScores[topicKey].scores.push(score);
            if (allScores[topicKey].scores.length > 50) allScores[topicKey].scores = allScores[topicKey].scores.slice(-50);
            
            const avg = allScores[topicKey].scores.reduce((a, b) => a + b, 0) / allScores[topicKey].scores.length;
            const finalAverage = Math.round(avg);
            
            allScores[topicKey].average = finalAverage;
            
            localStorage.setItem(STORAGE_KEY, JSON.stringify(allScores));
            updateScoreDisplay(finalAverage);
            syncScoreToServer(finalAverage);
        }

        function syncScoreToServer(score) {
            fetch('{{ route("free-lesson.progress") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lesson_slug: 'irregular-verbs',
                    score: score,
                    total_questions: 90 // Approximate
                })
            })
            .then(response => response.json())
            .then(data => console.log('Score saved:', data))
            .catch(error => console.error('Error saving score:', error));
        }

        function updateScoreDisplay(average) {
            const scoreElement = document.getElementById('averageScore');
            if (scoreElement) {
                const scoreSpan = scoreElement.querySelector('span');
                const svg = scoreElement.querySelector('svg');
                if (scoreSpan) scoreSpan.textContent = average + '%';
                
                svg.setAttribute('class', 'w-6 h-6 transition-colors duration-500');
                if (average >= 90) svg.classList.add('text-green-500');
                else if (average >= 75) svg.classList.add('text-blue-500');
                else if (average >= 60) svg.classList.add('text-orange-500');
                else svg.classList.add('text-gray-300');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const data = getTopicScores();
            // If we have a server score and no local score (or to ensure consistency), 
            // we could favor server score, but local storage tracks "session" history.
            // Let's just say: if server score exists, show it initially if local is empty?
            // Or better: Server score is the "source of truth" for persistence, Local is for "session calculation".
            
            if (serverScore !== null) {
                 updateScoreDisplay(serverScore);
                 // Optional: Seed local storage if empty? 
                 // If we don't, the first practice will start from 0 + current / 1, which might jump.
                 // But complex to reconstruction array from average. 
                 // Let's just rely on the fact that if they practice, it updates.
            } else if (data.average > 0) {
                updateScoreDisplay(data.average);
            }
        });

        // ========== Speech Recognition Logic ==========
        let activeRecognition = null;
        let activeButton = null;
        let isManuallyStopped = false;

        function toggleRecognition(targetWord, button) {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                alert('Browser not supported');
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const container = button.closest('.flex-col'); 
            const feedbackMsg = container.querySelector('.feedback-message');
            
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
            recognition.continuous = false;
            recognition.interimResults = false;

            activeRecognition = recognition;
            activeButton = button;
            isManuallyStopped = false;

            recognition.onstart = function() {
                button.classList.add('listening', 'bg-purple-100', 'text-purple-600', 'border-purple-300');
                feedbackMsg.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-50', 'text-red-700', 'border-green-200', 'border-red-200');
                feedbackMsg.textContent = 'Listening...';
                feedbackMsg.className = 'feedback-message text-xs font-bold p-2.5 rounded-lg border border-gray-200 mt-2 bg-gray-50 text-gray-500 animate-pulse';
                feedbackMsg.classList.remove('hidden');
            };

            recognition.onresult = function(event) {
                const result = event.results[event.results.length - 1][0];
                const spoken = result.transcript.toLowerCase().trim();
                const target = targetWord.toLowerCase().trim();
                const confidence = Math.round(result.confidence * 100);

                feedbackMsg.classList.remove('animate-pulse');
                
                if (spoken.includes(target) || target.includes(spoken)) { 
                    saveScore(confidence > 80 ? confidence : 80);
                    feedbackMsg.className = 'feedback-message text-xs font-bold p-2.5 rounded-lg border border-green-200 mt-2 bg-green-50 text-green-700 shadow-sm';
                    feedbackMsg.textContent = `✅ Good: "${spoken}"`;
                } else {
                    feedbackMsg.className = 'feedback-message text-xs font-bold p-2.5 rounded-lg border border-red-200 mt-2 bg-red-50 text-red-700 shadow-sm';
                    feedbackMsg.textContent = `❌ Heard: "${spoken}"`;
                }
                
                setTimeout(() => {
                    if (activeButton !== button) feedbackMsg.classList.add('hidden');
                }, 3000);
            };

            recognition.onend = function() {
                if (activeRecognition !== recognition) return;
                
                button.classList.remove('listening', 'bg-purple-100', 'text-purple-600', 'border-purple-300');
                
                if (!isManuallyStopped) {
                    activeRecognition = null;
                    activeButton = null;
                } else {
                    activeRecognition = null;
                    activeButton = null;
                }
            };

            recognition.start();
        }

        function resetActiveButton() {
            if (activeButton) {
                activeButton.classList.remove('listening', 'bg-purple-100', 'text-purple-600', 'border-purple-300');
                activeButton = null;
            }
        }
    </script>
</body>
</html>
