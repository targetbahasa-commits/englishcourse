<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Writing Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

<div class="fixed inset-0 z-0 flex flex-col">

    {{-- Top header --}}
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Writing – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition }} Writing Practice</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-white text-indigo-700 rounded-lg border border-indigo-100 font-semibold" id="time-remaining">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    60:00
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    Exit
                </a>
            </div>
        </div>
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 1fr 1fr;">

        {{-- LEFT: Writing Prompt --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar">
            
            {{-- TASK 1 PROMPT --}}
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" id="task-1-prompt">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>
                
                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase text-gray-700">WRITING TASK 1</p>
                    <p>You should spend about 20 minutes on this task.</p>
                    
                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4">
                        <p class="mb-4">The plans below show the site of a farm in 1950 and the same site today.</p>
                        <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                    </div>
                    
                    <p class="mb-4">Write at least 150 words.</p>
                </div>

                {{-- Maps Container --}}
                <div class="space-y-8 pb-8 text-[14px]">
                    <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Beechwood Farm</h2>

                    {{-- 1950 MAP --}}
                    <div>
                        <p class="font-bold text-gray-800 mb-2 text-base">1950</p>
                        <div class="border border-gray-400 overflow-hidden bg-white">
                            <svg viewBox="0 0 480 340" xmlns="http://www.w3.org/2000/svg" class="w-full" style="font-family: Arial, sans-serif; font-size: 13px;">
                                <!-- Background -->
                                <rect width="480" height="340" fill="#f5f5f0"/>

                                <!-- River (curved, bottom-left) -->
                                <path d="M 0 200 Q 30 280 80 320 Q 130 360 200 340 Q 280 320 340 340" stroke="#aaaacc" stroke-width="22" fill="none" opacity="0.6"/>
                                <text x="85" y="318" fill="#666" transform="rotate(-25, 85, 280)" font-size="11" font-style="italic">River</text>
                                <text x="310" y="338" fill="#666" font-size="11" font-style="italic">River</text>

                                <!-- Road (top-left diagonal) -->
                                <path d="M -10 80 Q 40 60 110 20 Q 160 0 200 0" stroke="#444" stroke-width="18" fill="none"/>
                                <path d="M -10 80 Q 40 60 110 20 Q 160 0 200 0" stroke="white" stroke-width="4" fill="none" stroke-dasharray="12,10"/>

                                <!-- Farm fields (left side) - divided into 3 sections -->
                                <!-- Fruit trees section -->
                                <rect x="40" y="40" width="110" height="90" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="95" y="82" text-anchor="middle" fill="#333" font-size="12">Fruit</text>
                                <text x="95" y="98" text-anchor="middle" fill="#333" font-size="12">trees</text>

                                <!-- Soft fruits section -->
                                <rect x="40" y="130" width="110" height="80" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="95" y="175" text-anchor="middle" fill="#333" font-size="12">Soft</text>
                                <text x="95" y="191" text-anchor="middle" fill="#333" font-size="12">fruits</text>

                                <!-- Vegetables section -->
                                <rect x="40" y="210" width="110" height="85" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="95" y="258" text-anchor="middle" fill="#333" font-size="12">Vegetables</text>

                                <!-- Sheep area (top right) -->
                                <rect x="210" y="20" width="240" height="120" fill="#eef4e8" stroke="#888" stroke-width="1.5"/>
                                <text x="330" y="85" text-anchor="middle" fill="#333" font-size="12">Sheep</text>

                                <!-- Track (diagonal Y-shape from fields to right) -->
                                <!-- Left arm of Y -->
                                <path d="M 150 90 L 220 160" stroke="#ccc" stroke-width="6" fill="none" stroke-dasharray="4,3"/>
                                <text x="167" y="125" fill="#555" font-size="11" transform="rotate(42, 167, 125)">Track</text>
                                <!-- Right arm of Y -->
                                <path d="M 220 160 L 290 120" stroke="#ccc" stroke-width="6" fill="none" stroke-dasharray="4,3"/>
                                <!-- Vertical stem of Y -->
                                <path d="M 220 160 L 220 220" stroke="#ccc" stroke-width="6" fill="none" stroke-dasharray="4,3"/>
                                <!-- Horizontal track -->
                                <path d="M 290 120 L 450 120" stroke="#ccc" stroke-width="6" fill="none" stroke-dasharray="4,3"/>
                                <text x="355" y="113" fill="#555" font-size="11">Track</text>

                                <!-- Barn -->
                                <rect x="310" y="135" width="110" height="50" fill="white" stroke="#333" stroke-width="2"/>
                                <text x="365" y="165" text-anchor="middle" fill="#333" font-size="12" font-weight="bold">Barn</text>

                                <!-- Farmhouse -->
                                <rect x="310" y="195" width="110" height="50" fill="white" stroke="#333" stroke-width="2"/>
                                <text x="365" y="225" text-anchor="middle" fill="#333" font-size="12" font-weight="bold">Farmhouse</text>

                                <!-- Chickens (dashed border) -->
                                <rect x="320" y="254" width="90" height="50" fill="white" stroke="#333" stroke-width="1.5" stroke-dasharray="6,3"/>
                                <text x="365" y="283" text-anchor="middle" fill="#333" font-size="12">Chickens</text>
                            </svg>
                        </div>
                    </div>

                    {{-- TODAY MAP --}}
                    <div>
                        <p class="font-bold text-gray-800 mb-2 text-base">Today</p>
                        <div class="border border-gray-400 overflow-hidden bg-white">
                            <svg viewBox="0 0 480 340" xmlns="http://www.w3.org/2000/svg" class="w-full" style="font-family: Arial, sans-serif; font-size: 13px;">
                                <!-- Background -->
                                <rect width="480" height="340" fill="#f5f5f0"/>

                                <!-- River -->
                                <path d="M 0 200 Q 30 280 80 320 Q 130 360 200 340 Q 280 320 340 340" stroke="#aaaacc" stroke-width="22" fill="none" opacity="0.6"/>
                                <text x="85" y="318" fill="#666" transform="rotate(-25, 85, 280)" font-size="11" font-style="italic">River</text>
                                <text x="310" y="338" fill="#666" font-size="11" font-style="italic">River.</text>

                                <!-- Road (top-left diagonal) -->
                                <path d="M -10 80 Q 40 60 110 20 Q 160 0 200 0" stroke="#444" stroke-width="18" fill="none"/>
                                <path d="M -10 80 Q 40 60 110 20 Q 160 0 200 0" stroke="white" stroke-width="4" fill="none" stroke-dasharray="12,10"/>

                                <!-- Fruit trees (still there) -->
                                <rect x="30" y="100" width="90" height="80" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="75" y="136" text-anchor="middle" fill="#333" font-size="12">Fruit</text>
                                <text x="75" y="152" text-anchor="middle" fill="#333" font-size="12">trees</text>

                                <!-- Soft fruits (still there) -->
                                <rect x="30" y="180" width="110" height="70" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="85" y="220" text-anchor="middle" fill="#333" font-size="12">Soft</text>
                                <text x="85" y="236" text-anchor="middle" fill="#333" font-size="12">fruits</text>

                                <!-- Vegetables (still there) -->
                                <rect x="30" y="250" width="130" height="70" fill="#e8f0e0" stroke="#888" stroke-width="1.5"/>
                                <text x="95" y="290" text-anchor="middle" fill="#333" font-size="12">Vegetables</text>

                                <!-- Farm shop (new, top-left corner) -->
                                <rect x="40" y="45" width="80" height="48" fill="white" stroke="#555" stroke-width="1.5"/>
                                <text x="80" y="65" text-anchor="middle" fill="#333" font-size="11" font-weight="bold">Farm</text>
                                <text x="80" y="80" text-anchor="middle" fill="#333" font-size="11" font-weight="bold">shop</text>

                                <!-- Parking top-left -->
                                <rect x="140" y="15" width="75" height="50" fill="white" stroke="#555" stroke-width="1.5"/>
                                <text x="178" y="45" text-anchor="middle" fill="#333" font-size="12">Parking</text>

                                <!-- Tree (camping area) -->
                                <circle cx="260" cy="60" r="22" fill="#6a8f4a" opacity="0.7"/>
                                <rect x="256" y="78" width="8" height="14" fill="#7a5c3a"/>

                                <!-- Camping field -->
                                <rect x="215" y="20" width="110" height="120" fill="#f0f8e8" stroke="#888" stroke-width="1.5"/>
                                <text x="270" y="75" text-anchor="middle" fill="#555" font-size="11">Camping</text>
                                <text x="270" y="90" text-anchor="middle" fill="#555" font-size="11">field</text>
                                <!-- Tent symbols -->
                                <polygon points="240,120 255,100 270,120" fill="none" stroke="#666" stroke-width="1.5"/>
                                <polygon points="260,120 275,100 290,120" fill="none" stroke="#666" stroke-width="1.5"/>

                                <!-- Solar panels (top right) -->
                                <text x="380" y="20" text-anchor="middle" fill="#333" font-size="11">Solar</text>
                                <text x="380" y="34" text-anchor="middle" fill="#333" font-size="11">panels</text>
                                <!-- Panel grid 1 -->
                                <rect x="340" y="38" width="30" height="22" fill="#b8d4e8" stroke="#555" stroke-width="1"/>
                                <line x1="355" y1="38" x2="355" y2="60" stroke="#555" stroke-width="0.5"/>
                                <line x1="340" y1="49" x2="370" y2="49" stroke="#555" stroke-width="0.5"/>
                                <!-- Panel grid 2 -->
                                <rect x="378" y="38" width="30" height="22" fill="#b8d4e8" stroke="#555" stroke-width="1"/>
                                <line x1="393" y1="38" x2="393" y2="60" stroke="#555" stroke-width="0.5"/>
                                <line x1="378" y1="49" x2="408" y2="49" stroke="#555" stroke-width="0.5"/>
                                <!-- Panel grid 3 -->
                                <rect x="340" y="66" width="30" height="22" fill="#b8d4e8" stroke="#555" stroke-width="1"/>
                                <line x1="355" y1="66" x2="355" y2="88" stroke="#555" stroke-width="0.5"/>
                                <line x1="340" y1="77" x2="370" y2="77" stroke="#555" stroke-width="0.5"/>
                                <!-- Panel grid 4 -->
                                <rect x="378" y="66" width="30" height="22" fill="#b8d4e8" stroke="#555" stroke-width="1"/>
                                <line x1="393" y1="66" x2="393" y2="88" stroke="#555" stroke-width="0.5"/>
                                <line x1="378" y1="77" x2="408" y2="77" stroke="#555" stroke-width="0.5"/>

                                <!-- Parking right -->
                                <rect x="340" y="100" width="110" height="45" fill="white" stroke="#555" stroke-width="1.5"/>
                                <text x="395" y="128" text-anchor="middle" fill="#333" font-size="12">Parking</text>

                                <!-- Holiday cottages -->
                                <rect x="340" y="155" width="110" height="48" fill="white" stroke="#555" stroke-width="1.5"/>
                                <text x="395" y="175" text-anchor="middle" fill="#333" font-size="11" font-weight="bold">Holiday cottages</text>

                                <!-- Farmhouse -->
                                <rect x="340" y="213" width="110" height="48" fill="white" stroke="#333" stroke-width="2"/>
                                <text x="395" y="242" text-anchor="middle" fill="#333" font-size="12" font-weight="bold">Farmhouse</text>

                                <!-- Chickens (dashed) -->
                                <rect x="345" y="268" width="90" height="44" fill="white" stroke="#333" stroke-width="1.5" stroke-dasharray="6,3"/>
                                <text x="390" y="294" text-anchor="middle" fill="#333" font-size="12">Chickens</text>

                                <!-- Barn (moved lower) -->
                                <rect x="215" y="230" width="80" height="45" fill="white" stroke="#333" stroke-width="2"/>
                                <text x="255" y="257" text-anchor="middle" fill="#333" font-size="12" font-weight="bold">Barn</text>

                                <!-- Roads (Y-shape - new roads replacing tracks) -->
                                <path d="M 155 15 L 230 130" stroke="#888" stroke-width="9" fill="none"/>
                                <path d="M 155 15 L 230 130" stroke="white" stroke-width="2" fill="none" stroke-dasharray="6,8"/>
                                <text x="178" y="72" fill="#555" font-size="10" transform="rotate(50, 178, 72)">Road</text>

                                <path d="M 230 130 L 290 170" stroke="#888" stroke-width="9" fill="none"/>
                                <path d="M 230 130 L 290 170" stroke="white" stroke-width="2" fill="none" stroke-dasharray="6,8"/>
                                <text x="248" y="148" fill="#555" font-size="10" transform="rotate(36, 248, 148)">Road</text>

                                <path d="M 230 130 L 255 230" stroke="#888" stroke-width="9" fill="none"/>
                                <path d="M 230 130 L 255 230" stroke="white" stroke-width="2" fill="none" stroke-dasharray="6,8"/>
                                <text x="248" y="185" fill="#555" font-size="10" transform="rotate(77, 248, 185)">Road</text>

                                <path d="M 290 170 L 340 155" stroke="#888" stroke-width="9" fill="none"/>
                                <path d="M 290 170 L 340 155" stroke="white" stroke-width="2" fill="none" stroke-dasharray="6,8"/>
                                <text x="305" y="156" fill="#555" font-size="10">Road</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TASK 2 PROMPT --}}
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>

                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase text-gray-700">WRITING TASK 2</p>
                    <p>You should spend about 40 minutes on this task. Write about the following topic:</p>

                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4">
                        <p class="mb-3">In many countries, primary and secondary schools close for two months or more in the summer holidays.</p>
                        <p class="mb-3">What is the value of long school holidays?</p>
                        <p>What are the arguments in favour of shorter school holidays?</p>
                    </div>

                    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                    <p>Write at least 250 words.</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Writing Area --}}
        <div class="h-full flex flex-col overflow-hidden bg-white">
            <div class="flex-1 min-h-0 flex flex-col p-4 gap-4">

                <form id="writing-form-1" class="flex flex-1 flex-col bg-white rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-white rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 1)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    <div class="flex-1 relative">
                        <textarea 
                            id="essay-input"
                            name="essay"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4 bg-white rounded-b-2xl flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count">0</span>
                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                        </div>
                        <button type="button" id="btn-go-to-task-2" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Go to Task 2
                        </button>
                    </div>
                </form>

                <form id="writing-form-2" class="hidden flex-1 flex-col bg-white rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-white rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 2)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    <div class="flex-1 relative">
                        <textarea 
                            id="essay-input-2"
                            name="essay_2"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4 bg-white rounded-b-2xl flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="flex flex-col">
                                <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count-2">0</span>
                                <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                            </div>
                            <button type="button" id="btn-go-to-task-1" class="px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all text-sm">
                                Back to Task 1
                            </button>
                        </div>
                        <button type="button" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Submit Tasks
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Word counter
        const setupWordCounter = (inputId, counterId, minWords) => {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (!input || !counter) return;

            input.addEventListener('input', () => {
                const text = input.value.trim();
                const words = text ? text.split(/\s+/) : [];
                counter.textContent = words.length;
                
                if (words.length > 0 && words.length < minWords) {
                    counter.classList.add('text-orange-500');
                    counter.classList.remove('text-green-600', 'text-gray-700');
                } else if (words.length >= minWords) {
                    counter.classList.add('text-green-600');
                    counter.classList.remove('text-orange-500', 'text-gray-700');
                } else {
                    counter.classList.add('text-gray-700');
                    counter.classList.remove('text-orange-500', 'text-green-600');
                }
            });
        };

        setupWordCounter('essay-input', 'word-count', 150);
        setupWordCounter('essay-input-2', 'word-count-2', 250);

        // Task toggle logic
        const btnGoToTask2 = document.getElementById('btn-go-to-task-2');
        const btnGoToTask1 = document.getElementById('btn-go-to-task-1');
        const task1Prompt = document.getElementById('task-1-prompt');
        const task2Prompt = document.getElementById('task-2-prompt');
        const writingForm1 = document.getElementById('writing-form-1');
        const writingForm2 = document.getElementById('writing-form-2');

        if (btnGoToTask2) {
            btnGoToTask2.addEventListener('click', () => {
                task1Prompt.classList.add('hidden');
                writingForm1.classList.add('hidden');
                writingForm1.classList.remove('flex');
                
                task2Prompt.classList.remove('hidden');
                writingForm2.classList.remove('hidden');
                writingForm2.classList.add('flex');
            });
        }

        if (btnGoToTask1) {
            btnGoToTask1.addEventListener('click', () => {
                task2Prompt.classList.add('hidden');
                writingForm2.classList.add('hidden');
                writingForm2.classList.remove('flex');
                
                task1Prompt.classList.remove('hidden');
                writingForm1.classList.remove('hidden');
                writingForm1.classList.add('flex');
            });
        }

        // Timer
        let timeLeft = 60 * 60;
        const timerObj = document.getElementById('time-remaining');
        
        setInterval(() => {
            if(timeLeft > 0) {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerObj.innerHTML = `<svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if(timeLeft < 300) {
                    timerObj.classList.replace('bg-white', 'bg-red-50');
                    timerObj.classList.replace('text-indigo-700', 'text-red-700');
                    timerObj.classList.replace('border-indigo-100', 'border-red-200');
                }
            }
        }, 1000);
    });
</script>

</body>
</html>
