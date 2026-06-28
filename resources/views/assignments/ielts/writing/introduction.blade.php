@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="writingIntroduction({{ $meeting->id }})">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => 1]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-teal-600 tracking-wider uppercase">IELTS Writing Task 1</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32 w-full">
        <!-- Left Column: Reference (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <!-- Theory Box -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                    <h2 class="text-lg font-bold text-indigo-900">How to Write an Introduction</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        The opening sentence for the first paragraph should define what the graph is about: 
                        <strong>the date, location, and what is being described.</strong>
                    </p>
                    <p>
                        The easiest way to start writing is by <strong>paraphrasing the topic</strong>. 
                        Use the table below to find synonyms and restructure sentences.
                    </p>
                </div>
                <!-- Reference Image -->
                <div class="border-t border-gray-100 p-4 bg-gray-50 flex flex-col gap-4">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson8_intro_phrases.png') }}" class="w-full h-auto rounded shadow-sm" alt="Introductory Phrases">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson8_useful_phrases.png') }}" class="w-full h-auto rounded shadow-sm border border-gray-200" alt="Useful Phrases List">
                </div>
            </div>

            <!-- Theory Box -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                    <h2 class="text-lg font-bold text-indigo-900">How to Write an Introduction</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        The opening sentence for the first paragraph should define what the graph is about: 
                        <strong>the date, location, and what is being described.</strong>
                    </p>
                    <p>
                        The easiest way to start writing is by <strong>paraphrasing the topic</strong>. 
                        Use the table below to find synonyms and restructure sentences.
                    </p>
                </div>
                <!-- Reference Image -->
                <div class="border-t border-gray-100 p-4 bg-gray-50 flex flex-col gap-4">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson8_intro_phrases.png') }}" class="w-full h-auto rounded shadow-sm" alt="Introductory Phrases">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson8_useful_phrases.png') }}" class="w-full h-auto rounded shadow-sm border border-gray-200" alt="Useful Phrases List">
                </div>
            </div>
        </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('unemploymentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mar 93', 'Mar 94', 'Mar 95', 'Mar 96', 'Mar 97', 'Mar 98', 'Mar 99'],
            datasets: [
                {
                    label: 'United States',
                    data: [7.0, 6.2, 5.5, 5.2, 4.8, 4.5, 4.4], // Approximated decreasing trend
                    borderColor: 'rgb(59, 130, 246)', // Blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.1,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Japan',
                    data: [2.5, 2.9, 3.2, 3.5, 3.9, 4.5, 4.9], // Approximated increasing trend
                    borderColor: 'rgb(239, 68, 68)', // Red-500
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    tension: 0.1,
                    pointBackgroundColor: 'rgb(239, 68, 68)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: "'Figtree', sans-serif",
                            size: 14,
                            weight: 'bold'
                        },
                        usePointStyle: true,
                        boxWidth: 8
                    }
                },
                title: {
                    display: true,
                    text: 'Unemployment Rates (1993-1999)',
                    font: {
                        family: "'Figtree', sans-serif",
                        size: 16,
                        weight: 'bold'
                    },
                    padding: {
                        bottom: 20
                    },
                    color: '#1f2937'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    bodyFont: {
                        family: "'Figtree', sans-serif"
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 8,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        },
                        font: {
                            family: "'Figtree', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Figtree', sans-serif"
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
});
</script>
@endpush

        <!-- Right Column: Practice -->
        <div class="lg:col-span-7 space-y-8 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <!-- Exercise 1: Line Graph -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Exercise 1: Line Graph</h3>
                    <div class="mt-2 bg-blue-50 p-3 rounded border border-blue-100">
                        <p class="text-blue-900 italic text-sm">"The graph below shows the unemployment rates in the US and Japan between March 1993 and March 1999."</p>
                    </div>
                </div>
                <!-- Chart -->
                <div class="py-6 px-2 border-b border-gray-100">
                    <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="unemploymentChart"></canvas>
                    </div>
                </div>
                <div class="p-6 space-y-8">
                    <!-- Attempt 1 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium">Attempt 1 (Use "The line graph compares...")</label>
                        <textarea name="attempt1" x-model="answers.attempt1" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 transition-all text-base placeholder-gray-400" placeholder="The line graph compares..."></textarea>
                    </div>
                    <!-- Attempt 2 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium">Attempt 2 (Use "The chart illustrates...")</label>
                        <textarea name="attempt2" x-model="answers.attempt2" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 transition-all text-base placeholder-gray-400" placeholder="The chart illustrates..."></textarea>
                    </div>
                    <!-- Attempt 3 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium">Attempt 3 (Change time expression "between... and...")</label>
                        <textarea name="attempt3" x-model="answers.attempt3" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 transition-all text-base placeholder-gray-400" placeholder="The line graph shows changes in... from... to..."></textarea>
                    </div>
                    
                     <!-- Reveal Sample Button -->
                     <div class="pt-4 border-t border-gray-100">
                          <button @click="showSamples = !showSamples" class="text-indigo-600 font-medium hover:underline flex items-center gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             <span x-text="showSamples ? 'Hide Sample Answers' : 'Reveal Sample Answers'"></span>
                          </button>
 
                          <div x-show="showSamples" x-transition class="mt-4 bg-gray-50 p-5 rounded-lg border border-gray-200 space-y-3">
                              <p class="text-sm text-gray-600 font-bold uppercase tracking-wider mb-2">Sample Answers (Ex 1):</p>
                              <ul class="space-y-3 text-gray-800 list-disc pl-5">
                                  <li>The line graph compares the levels of unemployment in the United States and Japan over a period of six years.</li>
                                  <li>The chart illustrates how the number of people without work changed in the US and Japan from March 1993 to March 1999.</li>
                                  <li>The line graph shows changes in the jobless rate in two different countries over a six-year period.</li>
                              </ul>
                          </div>
                     </div>
                </div>
            </div>

            <!-- Exercise 2: Bar Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
                    <h3 class="text-lg font-bold text-purple-800">Exercise 2: Bar Chart</h3>
                    <div class="mt-2 bg-purple-100 p-3 rounded border border-purple-200">
                        <p class="text-purple-900 italic text-sm">"The chart below shows the Gross Domestic Product (GDP) from the IT and Service Industry in the UK from 1992 to 2000."</p>
                    </div>
                </div>
                <div class="py-6 px-2 border-b border-gray-100">
                     <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="gdpBarChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write an introduction:</label>
                    <textarea name="intro_bar" x-model="answers.intro_bar" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 transition-all text-base placeholder-gray-400" placeholder="The bar chart..."></textarea>
                </div>
            </div>

            <!-- Exercise 3: Table Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                    <h3 class="text-lg font-bold text-green-800">Exercise 3: Table</h3>
                    <div class="mt-2 bg-green-100 p-3 rounded border border-green-200">
                        <p class="text-green-900 italic text-sm">"The table below gives information about the percentage of family budget spent on entertainment in different regions in 1995 and 2000."</p>
                    </div>
                </div>
                <div class="p-6 border-b border-gray-100 overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Region</th>
                                <th class="px-6 py-3">1995</th>
                                <th class="px-6 py-3">2000</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4 font-medium">North America</td><td class="px-6 py-4">12%</td><td class="px-6 py-4">14%</td></tr>
                            <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4 font-medium">Europe</td><td class="px-6 py-4">10%</td><td class="px-6 py-4">12%</td></tr>
                            <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4 font-medium">Asia</td><td class="px-6 py-4">8%</td><td class="px-6 py-4">11%</td></tr>
                            <tr class="bg-white border-b hover:bg-gray-50"><td class="px-6 py-4 font-medium">South America</td><td class="px-6 py-4">7%</td><td class="px-6 py-4">9%</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write an introduction:</label>
                    <textarea name="intro_table" x-model="answers.intro_table" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition-all text-base placeholder-gray-400" placeholder="The table compares..."></textarea>
                </div>
            </div>

            <!-- Exercise 4: Pie Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-orange-50 px-6 py-4 border-b border-orange-100">
                    <h3 class="text-lg font-bold text-orange-800">Exercise 4: Pie Chart</h3>
                    <div class="mt-2 bg-orange-100 p-3 rounded border border-orange-200">
                        <p class="text-orange-900 italic text-sm">"The pie charts below show the main causes of land degradation in the world today."</p>
                    </div>
                </div>
                <div class="py-6 px-2 border-b border-gray-100 flex justify-center">
                     <div class="w-full max-w-[400px] h-[400px]">
                         <canvas id="landPieChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write an introduction:</label>
                    <textarea name="intro_pie" x-model="answers.intro_pie" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 transition-all text-base placeholder-gray-400" placeholder="The pie charts show..."></textarea>
                </div>
            </div>

            <!-- Exercise 5: Mixed Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-pink-50 px-6 py-4 border-b border-pink-100">
                    <h3 class="text-lg font-bold text-pink-800">Exercise 5: Mixed Chart</h3>
                    <div class="mt-2 bg-pink-100 p-3 rounded border border-pink-200">
                        <p class="text-pink-900 italic text-sm">"The charts below show the results of a survey of visitors to a local library and their reading preferences."</p>
                    </div>
                </div>
                <div class="py-6 px-2 border-b border-gray-100 flex flex-col items-center gap-8">
                     <!-- Pie Part -->
                     <div class="w-full flex flex-col items-center">
                        <p class="font-bold mb-2">Visitor Frequency</p>
                        <div class="w-full max-w-[300px] h-[300px]">
                            <canvas id="libraryPieChart"></canvas>
                        </div>
                     </div>
                     <!-- Table Part -->
                     <div class="w-full overflow-x-auto">
                        <p class="font-bold mb-2 text-center">Book Preferences (Ranked 1-5)</p>
                        <table class="min-w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Genre</th>
                                    <th class="px-6 py-3">Men</th>
                                    <th class="px-6 py-3">Women</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b"><td class="px-6 py-3">Fiction</td><td class="px-6 py-3">3</td><td class="px-6 py-3">1</td></tr>
                                <tr class="border-b"><td class="px-6 py-3">Non-Fiction</td><td class="px-6 py-3">1</td><td class="px-6 py-3">4</td></tr>
                                <tr class="border-b"><td class="px-6 py-3">Magazines</td><td class="px-6 py-3">2</td><td class="px-6 py-3">2</td></tr>
                            </tbody>
                        </table>
                     </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write an introduction:</label>
                    <textarea name="intro_mixed" x-model="answers.intro_mixed" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 transition-all text-base placeholder-gray-400" placeholder="The mixed charts illustrate..."></textarea>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Line Chart (Unemployment)
    const ctx1 = document.getElementById('unemploymentChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Mar 93', 'Mar 94', 'Mar 95', 'Mar 96', 'Mar 97', 'Mar 98', 'Mar 99'],
            datasets: [
                { label: 'United States', data: [7.0, 6.2, 5.5, 5.2, 4.8, 4.5, 4.4], borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 2, tension: 0.1 },
                { label: 'Japan', data: [2.5, 2.9, 3.2, 3.5, 3.9, 4.5, 4.9], borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 2, tension: 0.1 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' }, title: { display: true, text: 'Unemployment Rates (1993-1999)' } }, scales: { y: { beginAtZero: true, max: 8 } } }
    });

    // 2. Bar Chart (GDP)
    const ctx2 = document.getElementById('gdpBarChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['1992', '1994', '1996', '1998', '2000'],
            datasets: [
                { label: 'IT Industry', data: [6, 8, 10, 12, 15], backgroundColor: 'rgba(147, 51, 234, 0.7)' },
                { label: 'Service Industry', data: [4, 5, 6, 7, 8], backgroundColor: 'rgba(236, 72, 153, 0.7)' }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'GDP from IT and Service Industry (% of total)' } }, scales: { y: { beginAtZero: true, title: { display: true, text: 'Percentage of GDP' } } } }
    });

    // 4. Pie Chart (Land Degradation)
    const ctx4 = document.getElementById('landPieChart').getContext('2d');
    new Chart(ctx4, {
        type: 'pie',
        data: {
            labels: ['Over-grazing', 'Deforestation', 'Over-cultivation', 'Other'],
            datasets: [{ data: [35, 30, 28, 7], backgroundColor: ['#f97316', '#22c55e', '#eab308', '#64748b'] }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Main Causes of Land Degradation' } } }
    });

    // 5. Mixed Chart (Pie part - Library Visitors)
    const ctx5 = document.getElementById('libraryPieChart').getContext('2d');
    new Chart(ctx5, {
        type: 'pie',
        data: {
            labels: ['Daily', 'Weekly', 'Monthly', 'Never'],
            datasets: [{ data: [15, 40, 30, 15], backgroundColor: ['#3b82f6', '#8b5cf6', '#ec4899', '#94a3b8'] }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.data('writingIntroduction', (meetingId) => ({
        answers: {
            attempt1: '',
            attempt2: '',
            attempt3: '',
            intro_bar: '',
            intro_table: '',
            intro_pie: '',
            intro_mixed: ''
        },
        showSamples: false,

        init() {
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }
            
            setTimeout(() => {
                const textareas = document.querySelectorAll('textarea[name]');
                textareas.forEach(el => {
                    if (el.value) {
                         this.answers[el.name] = el.value;
                    }
                });
            }, 500);

            this.$watch('answers', (val) => {
                // AutoSave handles storage
            });
        }
    }));
});
</script>
@endsection
