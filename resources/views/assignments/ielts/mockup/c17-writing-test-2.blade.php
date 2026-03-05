<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Writing Mock Test 2 - Target Bahasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
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
                    <h1 class="text-xl font-bold text-gray-800">IELTS Writing – Mock Test 2</h1>
                    <p class="text-sm text-gray-500">Cambridge 17 Writing Practice</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 font-semibold" id="time-remaining">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    60:00
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => 17, 'id' => 2]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
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
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>

                <div class="mb-6 space-y-3 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 1</p>
                    <p>You should spend about 20 minutes on this task.</p>

                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-4 mb-4">
                        <p class="mb-3">The table and charts below give information on the police budget for 2017 and 2018 in one area of Britain. The table shows where the money came from and the charts show how it was distributed.</p>
                        <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                    </div>

                    <p>Write at least 150 words.</p>
                </div>

                <hr class="my-8 border-gray-200">

                {{-- Table: Police Budget --}}
                <h3 class="text-center font-bold text-[18px] text-gray-900 mb-6">Police Budget 2017–2018 (in £m)</h3>
                <table class="w-full text-[14px] text-left border-collapse font-sans mb-12">
                    <thead>
                        <tr>
                            <th class="border border-black bg-white px-4 py-2 font-bold w-1/2 text-center text-gray-900">Sources</th>
                            <th class="border border-black bg-white px-4 py-2 font-bold w-1/4 text-center text-gray-900">2017</th>
                            <th class="border border-black bg-white px-4 py-2 font-bold w-1/4 text-center text-gray-900">2018</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-black px-4 py-2 bg-white text-gray-800">National Government</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">175.5m</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">177.8m</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-4 py-2 bg-white text-gray-800">Local Taxes</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">91.2m</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">102.3m</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-4 py-2 bg-white text-gray-800">Other sources (eg grants)</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">38m</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-800">38.5m</td>
                        </tr>
                        <tr>
                            <td class="border border-black px-4 py-2 bg-white text-gray-900 font-bold">Total</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-900 font-bold">304.7m</td>
                            <td class="border border-black px-4 py-2 text-center bg-white text-gray-900 font-bold">318.6m</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Pie Charts --}}
                <h3 class="text-center font-bold text-[16px] text-gray-900 mb-6 mt-10">How the money was spent</h3>
                
                <div class="flex flex-wrap items-center justify-center mb-8" style="gap: 80px;">
                    
                    {{-- 2017 Pie --}}
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="relative w-48 h-48 rounded-full border-2 border-black overflow-hidden mb-4">
                            <svg viewBox="-20 -20 40 40" style="transform: rotate(-90deg);" class="absolute inset-0 w-full h-full">
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="#999999" stroke-width="31.831" stroke-dasharray="75 25" stroke-dashoffset="0"/>
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="white" stroke-width="31.831" stroke-dasharray="8 92" stroke-dashoffset="-75"/>
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="black" stroke-width="31.831" stroke-dasharray="17 83" stroke-dashoffset="-83"/>
                            </svg>
                            <svg viewBox="-20 -20 40 40" class="absolute inset-0 w-full h-full pointer-events-none">
                                {{-- Outlines --}}
                                <line x1="0" y1="0" x2="0" y2="-20" stroke="black" stroke-width="0.3"/>
                                <line x1="0" y1="0" x2="-20" y2="0" stroke="black" stroke-width="0.3"/>
                                <line x1="0" y1="0" x2="-17.54" y2="-9.63" stroke="black" stroke-width="0.3"/>
                                
                                {{-- Text. Rotate normal coordinates --}}
                                <text x="7" y="10" font-size="3" fill="white" font-weight="bold" text-anchor="middle">75%</text>
                                <text x="-12" y="-3" font-size="2.5" fill="black" font-weight="bold" text-anchor="middle">8%</text>
                                <text x="-7" y="-12" font-size="2.5" fill="white" font-weight="bold" text-anchor="middle">17%</text>
                            </svg>
                        </div>
                        <span class="font-bold text-gray-800 text-lg">2017</span>
                    </div>

                    {{-- 2018 Pie --}}
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="relative w-48 h-48 rounded-full border-2 border-black overflow-hidden mb-4">
                            <svg viewBox="-20 -20 40 40" style="transform: rotate(-90deg);" class="absolute inset-0 w-full h-full">
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="#999999" stroke-width="31.831" stroke-dasharray="69 31" stroke-dashoffset="0"/>
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="white" stroke-width="31.831" stroke-dasharray="14 86" stroke-dashoffset="-69"/>
                                <circle r="15.9155" cx="0" cy="0" fill="transparent" stroke="black" stroke-width="31.831" stroke-dasharray="17 83" stroke-dashoffset="-83"/>
                            </svg>
                            <svg viewBox="-20 -20 40 40" class="absolute inset-0 w-full h-full pointer-events-none">
                                {{-- Outlines --}}
                                <line x1="0" y1="0" x2="0" y2="-20" stroke="black" stroke-width="0.3"/>
                                <line x1="0" y1="0" x2="-18.61" y2="7.36" stroke="black" stroke-width="0.3"/>
                                <line x1="0" y1="0" x2="-17.54" y2="-9.63" stroke="black" stroke-width="0.3"/>
                                
                                {{-- Text labels --}}
                                <text x="10" y="8" font-size="3" fill="white" font-weight="bold" text-anchor="middle">69%</text>
                                <text x="-12" y="-1" font-size="2.5" fill="black" font-weight="bold" text-anchor="middle">14%</text>
                                <text x="-7" y="-12" font-size="2.5" fill="white" font-weight="bold" text-anchor="middle">17%</text>
                            </svg>
                        </div>
                        <span class="font-bold text-gray-800 text-lg">2018</span>
                    </div>

                </div>

                {{-- Pie Chart Legend --}}
                <div class="flex justify-center mb-8">
                    <div class="border border-black p-4 bg-white inline-flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-[#999999] border border-black"></div>
                            <span class="text-sm">Salaries (officers and staff)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-white border border-black"></div>
                            <span class="text-sm">Technology</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-black border border-black"></div>
                            <span class="text-sm">Buildings and transport</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- TASK 2 PROMPT --}}
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>

                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 2</p>
                    <p>You should spend about 40 minutes on this task.</p>
                    <p>Write about the following topic:</p>

                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-4 mb-4 space-y-4">
                        <p>Some children spend hours every day on their smartphones.</p>
                        <p>Why is this the case? Do you think this is a positive or a negative development?</p>
                    </div>

                    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                    <p class="mt-4">Write at least 250 words.</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Text editor area --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar flex flex-col">
            <div class="px-4 py-6 flex-1 flex flex-col w-full">

                <form id="writing-form-1" class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-200">

                    {{-- Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 1)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <div class="flex-1 relative">
                        <textarea
                            id="essay-input"
                            name="essay"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
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

                    {{-- Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 2)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <div class="flex-1 relative">
                        <textarea
                            id="essay-input-2"
                            name="essay_2"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="flex flex-col">
                                <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count-2">0</span>
                                <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                            </div>
                            <button type="button" id="btn-go-to-task-1" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all text-sm">
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

        // Task toggle
        const btnGoToTask2 = document.getElementById('btn-go-to-task-2');
        const btnGoToTask1 = document.getElementById('btn-go-to-task-1');
        const task1Prompt  = document.getElementById('task-1-prompt');
        const task2Prompt  = document.getElementById('task-2-prompt');
        const writingForm1 = document.getElementById('writing-form-1');
        const writingForm2 = document.getElementById('writing-form-2');

        btnGoToTask2?.addEventListener('click', () => {
            task1Prompt.classList.add('hidden');
            writingForm1.classList.add('hidden');
            writingForm1.classList.remove('flex');
            task2Prompt.classList.remove('hidden');
            writingForm2.classList.remove('hidden');
            writingForm2.classList.add('flex');
        });

        btnGoToTask1?.addEventListener('click', () => {
            task2Prompt.classList.add('hidden');
            writingForm2.classList.add('hidden');
            writingForm2.classList.remove('flex');
            task1Prompt.classList.remove('hidden');
            writingForm1.classList.remove('hidden');
            writingForm1.classList.add('flex');
        });

        // Timer
        let timeLeft = 60 * 60;
        const timerEl = document.getElementById('time-remaining');
        setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                timerEl.innerHTML = `<svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
                if (timeLeft < 300) {
                    timerEl.classList.replace('bg-indigo-50','bg-red-50');
                    timerEl.classList.replace('text-indigo-700','text-red-700');
                    timerEl.classList.replace('border-indigo-100','border-red-200');
                }
            }
        }, 1000);
    });
</script>

</body>
</html>
