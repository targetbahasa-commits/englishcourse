<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Writing Mock Test 3 - {{ config('app.name', 'Target Bahasa') }}</title>
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
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0 md:pl-64 lg:pl-72 transition-all duration-300" id="main-header">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Mobile menu button --}}
                <button type="button" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" onclick="document.dispatchEvent(new CustomEvent('toggle-sidebar'))">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="p-2.5 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md hidden sm:block">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Writing – Mock Test 3</h1>
                    <p class="text-sm text-gray-500 hidden sm:block">Cambridge IELTS Writing Practice</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-white text-indigo-700 rounded-lg border border-indigo-100 font-semibold text-sm sm:text-base" id="time-remaining">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    60:00
                </div>
                <button type="button" class="flex justify-center items-center gap-2 px-4 border border-transparent font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm py-2 shadow-sm transition-colors opacity-0 pointer-events-none" id="save-progress-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Save
                </button>
            </div>
        </div>
    </div>

    {{-- Main Content block --}}
    <div class="flex-1 min-h-0 flex flex-col md:pl-64 lg:pl-72 transition-all duration-300" id="main-content">
        {{-- Inner Split screen --}}
        <div class="flex-1 min-h-0 flex flex-col lg:flex-row overflow-hidden">

            {{-- LEFT: Writing Prompt (Image) --}}
            <div class="h-1/2 lg:h-full lg:w-1/2 overflow-y-auto bg-white border-b lg:border-b-0 lg:border-r border-gray-200 custom-scrollbar relative z-0">
                <div class="px-6 sm:px-8 py-6 sm:py-8 lg:pb-24 max-w-2xl mx-auto" id="task-1-prompt">
                    {{-- WRITING header --}}
                    <div class="flex justify-center mb-6 sm:mb-8">
                        <span class="text-lg sm:text-xl font-bold bg-black text-white px-5 sm:px-6 py-1.5 uppercase tracking-widest leading-none">WRITING</span>
                    </div>
                    
                    {{-- Prompt Content Task 1 --}}
                    <div class="mb-8 space-y-4 text-gray-800 text-[14px] sm:text-[15px] leading-relaxed">
                        <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 1</p>
                        <p>You should spend about 20 minutes on this task.</p>
                        
                        <div class="border-2 border-gray-800 p-4 sm:p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4">
                            <p class="text-center font-bold text-lg mb-4 not-italic">Little Chalfont Library</p>
                            <p class="mb-4">The charts below show information about the age of library members, loans by category, and the total number of loans at Little Chalfont Library.</p>
                            <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                        </div>
                        
                        <p class="mb-8 sm:mb-10">Write at least 150 words.</p>
                    </div>

                    {{-- Charts Container Task 1 --}}
                    <div class="space-y-12 pb-8">
                        
                        {{-- Top Section: Pie Chart & Table --}}
                        <div class="flex flex-col xl:flex-row gap-8 items-center xl:items-start justify-center">
                            {{-- Chart 1 (Pie) --}}
                            <div class="w-full xl:w-1/2 flex flex-col items-center">
                                <h4 class="text-center font-bold text-[13px] sm:text-[14px] text-gray-900 mb-4 sm:mb-6">Age of library members (2016)</h4>
                                <div class="relative h-[250px] w-full max-w-[280px]">
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>

                            {{-- Table --}}
                            <div class="w-full xl:w-1/2 flex flex-col items-center xl:items-stretch overflow-x-auto">
                                <h4 class="text-center font-bold text-[13px] sm:text-[14px] text-gray-900 mb-4 sm:mb-6">Total loans by category (2016)</h4>
                                <table class="w-full max-w-[320px] text-[13px] sm:text-sm border-collapse border-2 border-gray-800 bg-white">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-800 p-2 sm:p-2.5 text-left font-bold bg-white">Category</th>
                                            <th class="border border-gray-800 p-2 sm:p-2.5 text-center font-bold bg-white">%</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-800">
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Children's fiction</td><td class="border border-gray-800 p-2 text-center">38%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Children's non-fiction</td><td class="border border-gray-800 p-2 text-center">6%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Children's DVDs</td><td class="border border-gray-800 p-2 text-center">1%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Young adults</td><td class="border border-gray-800 p-2 text-center">2%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Adult fiction</td><td class="border border-gray-800 p-2 text-center">38%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Adult non-fiction</td><td class="border border-gray-800 p-2 text-center">13%</td></tr>
                                        <tr><td class="border border-gray-800 p-2 pl-3 sm:pl-4">Adult audio books</td><td class="border border-gray-800 p-2 text-center">2%</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Chart 2 (Bar) --}}
                        <div class="pt-8 sm:pt-12">
                            <h4 class="text-center font-bold text-[13px] sm:text-[14px] text-gray-900 mb-4 sm:mb-6">Total number of loans (2007–2016)</h4>
                            <div class="relative h-[300px] sm:h-[350px] w-full px-2 max-w-xl mx-auto">
                                <canvas id="barChart"></canvas>
                            </div>
                            <p class="text-center text-[12px] font-bold text-gray-800 mt-2">Year</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 sm:px-8 py-6 sm:py-8 lg:pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                    {{-- WRITING header --}}
                    <div class="flex justify-center mb-6 sm:mb-8">
                        <span class="text-lg sm:text-xl font-bold bg-black text-white px-5 sm:px-6 py-1.5 uppercase tracking-widest leading-none">WRITING</span>
                    </div>
                    
                    {{-- Prompt Content Task 2 --}}
                    <div class="mb-8 space-y-4 text-gray-800 text-[14px] sm:text-[15px] leading-relaxed">
                        <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 2</p>
                        <p>You should spend about 40 minutes on this task. Write about the following topic:</p>
                        
                        <div class="border-2 border-gray-800 p-4 sm:p-6 font-bold bg-white shadow-sm mt-5 mb-5 md:mx-4 space-y-4 break-words text-[15px] sm:text-[16px] leading-[1.7] sm:leading-[1.8] sm:tracking-wide">
                            <p>Some people have decided to reduce the number of times they fly every year or to stop flying altogether.</p>
                            <p>Do you think the environmental benefits of this development outweigh the disadvantages for individuals and businesses?</p>
                        </div>
                        
                        <p class="mt-4 sm:mt-6">Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                        <p class="mb-8 sm:mb-10 font-bold">Write at least 250 words.</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Text editor area --}}
            <div class="h-1/2 lg:h-full lg:w-1/2 bg-white custom-scrollbar flex flex-col relative z-10 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] lg:shadow-none">
                <div class="p-3 sm:p-4 lg:p-6 flex-1 flex flex-col w-full h-full pb-[env(safe-area-inset-bottom)]">
                    
                    <form id="writing-form-1" class="flex-1 flex flex-col bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200">
                        
                        {{-- Editor Toolbar Area / Options --}}
                        <div class="flex items-center justify-between border-b border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-white rounded-t-xl sm:rounded-t-2xl">
                            <div>
                                <h3 class="text-xs sm:text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 1)</h3>
                            </div>
                            <div class="text-[11px] sm:text-sm text-gray-500 font-medium">
                                Status: <span class="text-gray-400 font-semibold flex items-center gap-1 inline-flex" id="save-status-1">Unsaved</span>
                            </div>
                        </div>

                        {{-- Textarea --}}
                        <div class="flex-1 relative">
                            <textarea 
                                id="essay-input"
                                name="essay"
                                class="absolute inset-0 w-full h-full p-4 sm:p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-[15px] sm:text-base leading-relaxed"
                                placeholder="Type your answer here..."
                                spellcheck="false"
                            ></textarea>
                        </div>

                        {{-- Footer area (Word Count & Submit) --}}
                        <div class="border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-white rounded-b-xl sm:rounded-b-2xl flex items-center justify-between shrink-0">
                            <div class="flex flex-col">
                                <span class="text-xl sm:text-2xl font-bold text-gray-700 font-mono" id="word-count">0</span>
                                <span class="text-[10px] sm:text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                            </div>
                            <button type="button" id="btn-go-to-task-2" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm sm:text-base">
                                Go to Task 2
                            </button>
                        </div>

                    </form>

                    <form id="writing-form-2" class="hidden flex-1 flex-col bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200">
                        
                        {{-- Editor Toolbar Area / Options --}}
                        <div class="flex items-center justify-between border-b border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-white rounded-t-xl sm:rounded-t-2xl">
                            <div>
                                <h3 class="text-xs sm:text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 2)</h3>
                            </div>
                            <div class="text-[11px] sm:text-sm text-gray-500 font-medium">
                                Status: <span class="text-gray-400 font-semibold flex items-center gap-1 inline-flex" id="save-status-2">Unsaved</span>
                            </div>
                        </div>

                        {{-- Textarea --}}
                        <div class="flex-1 relative">
                            <textarea 
                                id="essay-input-2"
                                name="essay_2"
                                class="absolute inset-0 w-full h-full p-4 sm:p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-[15px] sm:text-base leading-relaxed"
                                placeholder="Type your answer here..."
                                spellcheck="false"
                            ></textarea>
                        </div>

                        {{-- Footer area (Word Count & Submit) --}}
                        <div class="border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-white rounded-b-xl sm:rounded-b-2xl flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-0 shrink-0">
                            <div class="flex items-center justify-between sm:justify-start sm:gap-6">
                                <div class="flex flex-col">
                                    <span class="text-xl sm:text-2xl font-bold text-gray-700 font-mono" id="word-count-2">0</span>
                                    <span class="text-[10px] sm:text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                                </div>
                                <button type="button" id="btn-go-to-task-1" class="px-3 sm:px-4 py-1.5 sm:py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all text-xs sm:text-sm border border-gray-200">
                                    Back to Task 1
                                </button>
                            </div>
                            <button type="button" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-sm sm:text-base">
                                Submit All Answers
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Sidebar Logic ---
        const sidebar = document.getElementById('program-sidebar');
        const mainHeader = document.getElementById('main-header');
        const mainContent = document.getElementById('main-content');

        if (sidebar && mainHeader && mainContent) {
            // Check initial state from toggle component
            const isSidebarOpen = sidebar.getAttribute('data-sidebar-open') === 'true';
            
            if (!isSidebarOpen) {
                mainHeader.classList.remove('md:pl-64', 'lg:pl-72');
                mainContent.classList.remove('md:pl-64', 'lg:pl-72');
            }

            document.addEventListener('sidebar-toggled', (e) => {
                if (e.detail.isOpen) {
                    mainHeader.classList.add('md:pl-64', 'lg:pl-72');
                    mainContent.classList.add('md:pl-64', 'lg:pl-72');
                } else {
                    mainHeader.classList.remove('md:pl-64', 'lg:pl-72');
                    mainContent.classList.remove('md:pl-64', 'lg:pl-72');
                }
            });
        }

        // --- Word Counter Logic ---
        const setupWordCounter = (inputId, counterId, minWords, statusId) => {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            const status = document.getElementById(statusId);
            
            if (!input || !counter) return;

            let timeoutId;

            input.addEventListener('input', () => {
                const text = input.value;
                // Count words strictly by valid alphanumeric blocks, matching standard word count tools better
                const words = text.trim() ? text.trim().split(/\s+/) : [];
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

                // Simulate saving status
                if (status) {
                    status.innerHTML = '<span class="text-orange-500 font-medium">Saving...</span>';
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        status.innerHTML = '<span class="text-green-600 font-semibold flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>';
                    }, 800);
                }
            });
        };

        setupWordCounter('essay-input', 'word-count', 150, 'save-status-1');
        setupWordCounter('essay-input-2', 'word-count-2', 250, 'save-status-2');

        // --- Task Toggle Logic ---
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

        // --- Basic Timer Simulation ---
        let timeLeft = 60 * 60; // 60 minutes
        const timerObj = document.getElementById('time-remaining');
        
        setInterval(() => {
            if(timeLeft > 0) {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerObj.innerHTML = `<svg class="w-4 h-4 sm:w-5 sm:h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if(timeLeft < 300) { // Under 5 minutes
                    timerObj.classList.replace('bg-white', 'bg-red-50');
                    timerObj.classList.replace('text-indigo-700', 'text-red-700');
                    timerObj.classList.replace('border-indigo-100', 'border-red-200');
                }
            }
        }, 1000);

        // --- CHART JS CONFIGURATION ---
        
        // 1. Pie Chart
        const pieCtx = document.getElementById('pieChart')?.getContext('2d');
        if (pieCtx) {
            // Data from the image: Children (22), Young adults 13-17 (15), Adults 18-64 (51), Adults 65 and over (12)
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Children', 'Young adults 13–17', 'Adults 18–64', 'Adults 65 and over'],
                    datasets: [{
                        data: [22, 15, 51, 12],
                        // Using flat distinct colors indicating the different sections, 
                        // simulating the black, crosshatch, grey, diagonal stripes pattern from the image
                        backgroundColor: [
                            '#111827', // Black
                            '#cbd5e1', // Light Gray 
                            '#94a3b8', // Gray
                            '#f1f5f9'  // Very Light Gray
                        ],
                        borderColor: '#111827',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: { size: 11, family: 'sans-serif' },
                                color: '#111827'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Bar Chart
        const barCtx = document.getElementById('barChart')?.getContext('2d');
        if (barCtx) {
            // Data approximated from the bar chart image
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016'],
                    datasets: [{
                        label: 'Total loans',
                        data: [15800, 19000, 19200, 20500, 21000, 20800, 19500, 20200, 21100, 21500],
                        backgroundColor: '#4b5563', // Slate-600, matching the dark bars in the image
                        borderColor: '#374151',
                        borderWidth: 1,
                        barPercentage: 0.5,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 25000,
                            ticks: {
                                stepSize: 5000,
                                color: '#4B5563',
                                font: { size: 11 },
                                callback: function(value) {
                                    // add comma formatting
                                    return value.toLocaleString();
                                }
                            },
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: true
                            },
                            ticks: { color: '#111827', font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // no legend in the original bar chart
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    layout: { padding: { top: 10, bottom: 20 } }
                }
            });
        }
    });
</script>
</body>
</html>
