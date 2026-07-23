<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'IELTS Academic' }} Writing - Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
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
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.cambridge-guest-signup-modal')
    @include('components.program-sidebar')

    <div class="fixed inset-0 z-0 flex flex-col">
        <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-2.5 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">{{ $test['label'] ?? 'IELTS Academic' }} Writing - Paket {{ $test['package_number'] ?? 1 }}</h1>
                        <p class="text-sm text-gray-500">Internal package writing practice</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 font-semibold" id="time-remaining">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        60:00
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 1fr 1fr;">
            <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar">
                <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" id="task-1-prompt">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                    </div>

                    <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                        <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 1</p>
                        <p>You should spend about 20 minutes on this task.</p>

                        <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4">
                            <p class="mb-4">The graph below shows the percentage of Australian exports to four countries from 1990 to 2012.</p>
                            <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                        </div>

                        <p class="mb-10">Write at least 150 words.</p>
                    </div>

                    <div class="pb-8">
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <div class="relative w-full" style="height: 530px; min-height: 530px;">
                                <canvas id="exportsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8 pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                    <div class="flex justify-center mb-8">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                    </div>

                    <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                        <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 2</p>
                        <p>You should spend about 40 minutes on this task.</p>
                        <p>Write about the following topic:</p>

                        <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-5 mb-5 md:mx-4 space-y-4">
                            <p>In many countries today, many people tend to move away from their friends and families for work.</p>
                            <p>Do you think the advantages of this development outweigh the disadvantages?</p>
                        </div>

                        <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                        <p class="mb-10 mt-6">Write at least 250 words.</p>
                    </div>
                </div>
            </div>

            <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar flex flex-col">
                <div class="px-4 py-6 flex-1 flex flex-col w-full">
                    <form id="writing-form-1" class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 1)</h3>
                            </div>
                            <div class="text-sm text-gray-500 font-medium">
                                Min words: <span class="font-semibold text-gray-700">150</span>
                            </div>
                        </div>

                        <div class="flex-1 relative">
                            <textarea
                                id="essay-input"
                                name="essay"
                                class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                                placeholder="Type your answer for Task 1 here..."
                                spellcheck="false"
                            ></textarea>
                        </div>

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
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 2)</h3>
                            </div>
                            <div class="text-sm text-gray-500 font-medium">
                                Min words: <span class="font-semibold text-gray-700">250</span>
                            </div>
                        </div>

                        <div class="flex-1 relative">
                            <textarea
                                id="essay-input-2"
                                name="essay_2"
                                class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                                placeholder="Type your answer for Task 2 here..."
                                spellcheck="false"
                            ></textarea>
                        </div>

                        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count-2">0</span>
                                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                                </div>
                            </div>
                            <button id="submitWritingTasksBtn" type="button" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Submit Tasks
                            </button>
                        </div>
                    </form>

                    <div id="writingSubmitPanel" class="hidden mt-4 rounded-xl border p-4 text-sm"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countWords = (text) => {
                const tokens = String(text || '').trim().split(/\s+/).filter(Boolean);

                // Count only tokens containing letters; pure numbers/punctuation are excluded.
                return tokens.filter((token) => /[A-Za-z]/.test(token)).length;
            };

            const setupWordCounter = (inputId, counterId, minWords) => {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);
                if (!input || !counter) return;

                input.addEventListener('input', () => {
                    const wordsCount = countWords(input.value);
                    counter.textContent = wordsCount;

                    if (wordsCount > 0 && wordsCount < minWords) {
                        counter.classList.add('text-orange-500');
                        counter.classList.remove('text-green-600', 'text-gray-700');
                    } else if (wordsCount >= minWords) {
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

            const btnGoToTask2 = document.getElementById('btn-go-to-task-2');
            const btnGoToTask1 = document.getElementById('btn-go-to-task-1');
            const submitBtn = document.getElementById('submitWritingTasksBtn');
            const submitPanel = document.getElementById('writingSubmitPanel');
            const task1Input = document.getElementById('essay-input');
            const task2Input = document.getElementById('essay-input-2');
            const task1Prompt = document.getElementById('task-1-prompt');
            const task2Prompt = document.getElementById('task-2-prompt');
            const writingForm1 = document.getElementById('writing-form-1');
            const writingForm2 = document.getElementById('writing-form-2');
            const submitUrl = @json($packageSectionSubmitUrl ?? null);
            const redirectUrl = @json(route('online-test.show', ['slug' => 'ielts_academic']));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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

            if (submitBtn && submitPanel && task1Input && task2Input) {
                submitBtn.addEventListener('click', async () => {
                    const task1Text = String(task1Input.value || '').trim();
                    const task2Text = String(task2Input.value || '').trim();
                    const task1Words = countWords(task1Text);
                    const task2Words = countWords(task2Text);

                    submitPanel.classList.remove('hidden', 'border-red-200', 'bg-red-50', 'text-red-800', 'border-green-200', 'bg-green-50', 'text-green-800');

                    if (!task1Text || !task2Text) {
                        submitPanel.classList.add('border-red-200', 'bg-red-50', 'text-red-800');
                        submitPanel.innerHTML = '<p class="font-semibold">Task 1 dan Task 2 wajib diisi sebelum submit.</p>';
                        return;
                    }

                    let estimatedBand = 4;
                    if (task1Words >= 150) estimatedBand += 1;
                    if (task2Words >= 250) estimatedBand += 1;
                    if ((task1Words + task2Words) >= 450) estimatedBand += 1;
                    if ((task1Words + task2Words) >= 650) estimatedBand += 1;
                    estimatedBand = Math.max(0, Math.min(9, estimatedBand));

                    submitPanel.classList.add('border-green-200', 'bg-green-50', 'text-green-800');
                    submitPanel.innerHTML = `
                        <p class="font-semibold">Estimasi band Writing: ${estimatedBand.toFixed(1)}</p>
                        <p class="mt-1">Task 1: ${task1Words} kata | Task 2: ${task2Words} kata</p>
                    `;

                    if (!submitUrl) {
                        submitPanel.innerHTML += '<p class="mt-2 text-xs">Status simpan: endpoint tidak tersedia.</p>';
                        return;
                    }

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-60', 'cursor-not-allowed');

                    try {
                        const response = await fetch(submitUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                score: estimatedBand,
                                total_questions: 9,
                                answers: {
                                    task_1: task1Text,
                                    task_2: task2Text,
                                    task_1_words: task1Words,
                                    task_2_words: task2Words,
                                    estimated_band: estimatedBand,
                                },
                            }),
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const data = await response.json();
                        submitPanel.innerHTML += `<p class="mt-2 text-xs">Status simpan: ${data.message || 'Berhasil'} (ID: ${data.result_id ?? '-'})</p>`;
                        submitPanel.innerHTML += '<p class="mt-2 text-xs">Mengalihkan ke halaman IELTS Academic...</p>';

                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1200);
                    } catch (error) {
                        submitPanel.classList.remove('border-green-200', 'bg-green-50', 'text-green-800');
                        submitPanel.classList.add('border-red-200', 'bg-red-50', 'text-red-800');
                        submitPanel.innerHTML += `<p class="mt-2 text-xs">Status simpan: gagal (${error?.message || 'unknown error'})</p>`;
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                    }
                });
            }

            let timeLeft = 60 * 60;
            const timerObj = document.getElementById('time-remaining');

            setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerObj.innerHTML = `<svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    if (timeLeft < 300) {
                        timerObj.classList.replace('bg-indigo-50', 'bg-red-50');
                        timerObj.classList.replace('text-indigo-700', 'text-red-700');
                        timerObj.classList.replace('border-indigo-100', 'border-red-200');
                    }
                }
            }, 1000);

            const exportsCtx = document.getElementById('exportsChart')?.getContext('2d');
            if (exportsCtx) {
                new Chart(exportsCtx, {
                    type: 'line',
                    data: {
                        labels: ['1990', '1995', '2000', '2005', '2010', '2012'],
                        datasets: [
                            {
                                label: 'Japan',
                                data: [26, 20, 18, 18, 17, 17],
                                borderColor: '#2F6CC0',
                                backgroundColor: '#2F6CC0',
                                borderWidth: 3,
                                pointRadius: 0,
                                tension: 0
                            },
                            {
                                label: 'US',
                                data: [11, 8, 11, 8, 5, 7],
                                borderColor: '#E58B2A',
                                backgroundColor: '#E58B2A',
                                borderWidth: 3,
                                pointRadius: 0,
                                tension: 0
                            },
                            {
                                label: 'China',
                                data: [2, 3, 5, 11, 25, 28],
                                borderColor: '#8E8E8E',
                                backgroundColor: '#8E8E8E',
                                borderWidth: 3,
                                pointRadius: 0,
                                tension: 0
                            },
                            {
                                label: 'India',
                                data: [1, 1, 1, 5, 7, 5],
                                borderColor: '#F2C500',
                                backgroundColor: '#F2C500',
                                borderWidth: 3,
                                pointRadius: 0,
                                tension: 0
                            }
                        ]
                    },
                    options: {
                        animation: false,
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'line',
                                    boxWidth: 30,
                                    color: '#374151',
                                    padding: 18,
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 30,
                                ticks: {
                                    stepSize: 5,
                                    color: '#6B7280',
                                },
                                grid: {
                                    color: '#E5E7EB',
                                },
                                border: {
                                    display: false,
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#6B7280',
                                },
                                grid: {
                                    display: false,
                                },
                                border: {
                                    color: '#D1D5DB',
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
