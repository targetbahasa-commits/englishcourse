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
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" id="task-1-prompt">
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>
                
                {{-- Task 1 Prompt --}}
                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 1</p>
                    <p>You should spend about 20 minutes on this task.</p>
                    
                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4 space-y-4">
                        <p>The graph below shows the average monthly change in the prices of three metals during 2014.</p>
                        <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                    </div>
                    
                    <p class="mb-6">Write at least 150 words.</p>
                </div>

                {{-- Line Graph (Chart.js) --}}
                <div class="pb-8">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <canvas id="metalsChart" width="500" height="400"></canvas>
                        <div id="legend-container" class="mt-4"></div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>
                
                {{-- Task 2 Prompt --}}
                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 2</p>
                    <p>You should spend about 40 minutes on this task.</p>
                    <p>Write about the following topic:</p>
                    
                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4 space-y-4">
                        <p>In many countries, people are now living longer than ever before. Some people say an ageing population creates problems for governments. Other people think there are benefits if society has more elderly people.</p>
                        <p>To what extent do the advantages of having an ageing population outweigh the disadvantages?</p>
                    </div>
                    
                    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                    <p class="mb-10 mt-6">Write at least 250 words.</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Text editor area --}}
        <div class="h-full overflow-y-auto bg-white custom-scrollbar flex flex-col">
            <div class="px-4 py-6 flex-1 flex flex-col w-full">
                
                <form id="writing-form-1" class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-200">
                    
                    {{-- Editor Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-white rounded-t-2xl">
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

                    {{-- Footer (Word Count & Submit) --}}
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
                    
                    {{-- Editor Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-white rounded-t-2xl">
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

                    {{-- Footer (Word Count & Submit) --}}
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ── Custom HTML Legend Plugin ──
        const getOrCreateLegendList = (chart, id) => {
            const legendContainer = document.getElementById(id);
            let listContainer = legendContainer.querySelector('ul');

            if (!listContainer) {
                listContainer = document.createElement('ul');
                listContainer.style.display = 'flex';
                listContainer.style.flexDirection = 'row';
                listContainer.style.margin = '0';
                listContainer.style.padding = '10px 15px';
                listContainer.style.listStyle = 'none';
                listContainer.style.border = '1px solid #333';
                listContainer.style.justifyContent = 'center';
                listContainer.style.gap = '20px';
                
                legendContainer.appendChild(listContainer);
                legendContainer.style.display = 'flex';
                legendContainer.style.justifyContent = 'center';
                legendContainer.style.marginTop = '10px';
            }

            return listContainer;
        };

        const htmlLegendPlugin = {
            id: 'htmlLegend',
            afterUpdate(chart, args, options) {
                const ul = getOrCreateLegendList(chart, options.containerID);
                while (ul.firstChild) {
                    ul.firstChild.remove();
                }

                const items = chart.options.plugins.legend.labels.generateLabels(chart);

                items.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.style.display = 'flex';
                    li.style.alignItems = 'center';
                    li.style.cursor = 'pointer';
                    li.style.color = '#333';
                    li.style.fontFamily = 'serif';
                    li.style.fontSize = '14px';
                    li.style.textDecoration = item.hidden ? 'line-through' : '';

                    li.onclick = () => {
                        const {type} = chart.config;
                        if (type === 'pie' || type === 'doughnut') {
                            chart.toggleDataVisibility(item.index);
                        } else {
                            chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                        }
                        chart.update();
                    };

                    // Line container
                    const boxSpan = document.createElement('span');
                    boxSpan.style.display = 'flex';
                    boxSpan.style.alignItems = 'center';
                    boxSpan.style.marginRight = '8px';
                    boxSpan.style.width = '30px';
                    boxSpan.style.height = '14px';
                    boxSpan.style.position = 'relative';

                    // Draw the line
                    const line = document.createElement('div');
                    line.style.width = '100%';
                    line.style.height = item.lineWidth + 'px';
                    line.style.backgroundColor = item.strokeStyle;
                    if (item.lineDash && item.lineDash.length > 0) {
                        line.style.backgroundColor = 'transparent';
                        line.style.borderTop = `${item.lineWidth}px dashed ${item.strokeStyle}`;
                    }
                    line.style.position = 'absolute';
                    line.style.top = '50%';
                    line.style.transform = 'translateY(-50%)';
                    boxSpan.appendChild(line);

                    // Draw the point marker
                    const marker = document.createElement('div');
                    marker.style.position = 'absolute';
                    marker.style.left = '50%';
                    marker.style.top = '50%';
                    marker.style.transform = 'translate(-50%, -50%)';
                    
                    if (index === 0) { // Copper (o)
                        marker.style.width = '10px';
                        marker.style.height = '10px';
                        marker.style.borderRadius = '50%';
                        marker.style.backgroundColor = '#ccc'; // Filled gray
                        marker.style.border = '2px solid #333';
                    } else if (index === 1) { // Nickel (solid dot)
                        marker.style.width = '10px';
                        marker.style.height = '10px';
                        marker.style.borderRadius = '50%';
                        marker.style.backgroundColor = '#333';
                    } else if (index === 2) { // Zinc (x)
                        marker.innerHTML = '&#10005;'; // X symol
                        marker.style.fontSize = '12px';
                        marker.style.color = '#777';
                        marker.style.fontWeight = 'bold';
                        marker.style.lineHeight = '1';
                    }
                    
                    boxSpan.appendChild(marker);

                    const textContainer = document.createElement('span');
                    textContainer.style.color = item.fontColor;
                    textContainer.style.margin = 0;
                    textContainer.style.padding = 0;
                    textContainer.textContent = item.text;

                    li.appendChild(boxSpan);
                    li.appendChild(textContainer);
                    ul.appendChild(li);
                });
            }
        };

        // ── Metals Price Chart ──
        const ctx = document.getElementById('metalsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
                    datasets: [
                        {
                            label: 'Copper',
                            data: [2, 1, 0.5, 0.5, -0.5, -0.5, 1, 1, 1, 0.5, 0.5, 1.5],
                            borderColor: '#333',
                            backgroundColor: '#333',
                            borderWidth: 2,
                            borderDash: [6, 4],
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBackgroundColor: '#ccc',
                            pointBorderColor: '#333',
                            pointBorderWidth: 2,
                            tension: 0, // Set to 0 for straight lines like the original
                            fill: false
                        },
                        {
                            label: 'Nickel',
                            data: [6, 4, 1, 1, 0.5, -3, -1, -1, -1, -2, 1, 1],
                            borderColor: '#333',
                            backgroundColor: '#333',
                            borderWidth: 2,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBackgroundColor: '#333',
                            pointBorderColor: '#333',
                            pointBorderWidth: 2,
                            tension: 0, // Set to 0 for straight lines like the original
                            fill: false
                        },
                        {
                            label: 'Zinc',
                            data: [1, 3, 2, 1.5, 1, -1, -0.5, -0.5, -0.5, -1, 1.5, 2],
                            borderColor: '#777',
                            backgroundColor: '#777',
                            borderWidth: 1.5,
                            pointStyle: 'crossRot',
                            pointRadius: 6,
                            pointBackgroundColor: '#777',
                            pointBorderColor: '#777',
                            pointBorderWidth: 2,
                            tension: 0, // Set to 0 for straight lines like the original
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        title: {
                            display: true,
                            text: ['Average monthly change in prices of', 'copper, nickel and zinc (2014)'],
                            font: { size: 14, weight: 'bold', family: 'serif' },
                            color: '#111',
                            padding: { bottom: 16 }
                        },
                        legend: {
                            display: false, // Disable default legend
                        },
                        htmlLegend: {
                            containerID: 'legend-container'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month',
                                font: { size: 13, weight: 'bold', family: 'serif' },
                                color: '#333'
                            },
                            grid: {
                                color: '#e5e7eb',
                                drawTicks: true
                            },
                            ticks: {
                                font: { size: 12, family: 'sans-serif' },
                                color: '#333'
                            }
                        },
                        y: {
                            min: -4,
                            max: 7,
                            ticks: {
                                stepSize: 1,
                                font: { size: 12, family: 'sans-serif' },
                                color: '#333'
                            },
                            title: {
                                display: true,
                                text: '% change in price compared with previous month',
                                font: { size: 12, weight: 'bold', family: 'sans-serif' },
                                color: '#333'
                            },
                            grid: {
                                color: '#b0b0b0',
                                lineWidth: 1
                            }
                        }
                    }
                },
                plugins: [htmlLegendPlugin]
            });
        }

        // ── Word counter ──
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

        // ── Task toggle logic ──
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

        // ── Timer ──
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

