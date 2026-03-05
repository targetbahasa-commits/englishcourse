@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="writingOverview({{ $meeting->id }})">
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
                    <h2 class="text-lg font-bold text-indigo-900">How to Write a General Overview</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        A general overview is a summary of the main features compared in the chart. You should not specific data (numbers/figures) in the overview; instead, focus on <strong>general trends</strong> and <strong>overall patterns</strong>.
                    </p>
                    <p>
                        Look for:
                        <ul class="list-disc pl-5 space-y-1 mt-1">
                            <li>Overall increase or decrease.</li>
                            <li>Highest and lowest values (peaks/troughs) if significant generally.</li>
                            <li>Stability or fluctuation.</li>
                        </ul>
                    </p>

                    <div class="bg-red-50 p-4 rounded-lg border border-red-100 mt-4">
                        <h4 class="font-bold text-red-800 mb-3">Useful language to refer to graphs:</h4>
                        <ul class="list-disc pl-5 space-y-1 text-red-900">
                            <li>As can be seen from the graph...</li>
                            <li>It can be seen from the graph that...</li>
                            <li>The graph shows...</li>
                            <li>It can be concluded from the graph that...</li>
                            <li>From the figures/statistics, it can be inferred that...</li>
                            <li>The graph illustrates...</li>
                            <li>It is noticeable that...</li>
                            <li>We can see that...</li>
                            <li>It is clear that...</li>
                            <li>Overall, ...</li>
                            <li>It is clear from the ... that ...</li>
                        </ul>
                    </div>
                </div>
                <!-- Reference Image -->
                <div class="border-t border-gray-100 p-4 bg-gray-50 flex flex-col gap-4">
                    <p class="text-sm font-bold text-gray-700 mb-2">Example Chart:</p>
                    <img src="{{ asset('images/ielts_writing_task1_lesson9_example_chart.png') }}" class="w-full h-auto rounded shadow-sm" alt="Example Chart: Marriages">
                    
                    <p class="text-sm font-bold text-gray-700 mt-2 mb-2">Example Overview:</p>
                    <img src="{{ asset('images/ielts_writing_task1_lesson9_example_text.png') }}" class="w-full h-auto rounded shadow-sm border border-gray-200" alt="Example Overview Text">
                </div>
            </div>
        </div>

        <!-- Right Column: Practice (Sticky) -->
        <div class="lg:col-span-7 space-y-8 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            
            <!-- Exercise 1: Line Graph -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                    <h3 class="text-lg font-bold text-blue-800">Exercise 1: Line Graph</h3>
                    <p class="text-sm text-blue-600 mt-1">Topic: Fast food consumption by teenagers in Australia (1975-2000).</p>
                </div>
                <div class="py-6 px-2 border-b border-gray-100">
                     <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="fastFoodChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write your overview:</label>
                    <textarea name="overview_line" x-model="answers.overview_line" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 transition-all text-sm placeholder-gray-400" placeholder="Overall, ..."></textarea>
                </div>
            </div>

            <!-- Exercise 2: vs Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                    <h3 class="text-lg font-bold text-green-800">Exercise 2: Table</h3>
                    <p class="text-sm text-green-600 mt-1">Topic: Consumer spending on different items in five countries (2002).</p>
                </div>
                <div class="p-6 border-b border-gray-100 overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Country</th>
                                <th class="px-6 py-3">Food/Drinks/Tobacco</th>
                                <th class="px-6 py-3">Clothing/Footwear</th>
                                <th class="px-6 py-3">Leisure/Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Ireland</td>
                                <td class="px-6 py-4">28.91%</td>
                                <td class="px-6 py-4">6.43%</td>
                                <td class="px-6 py-4">2.21%</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Italy</td>
                                <td class="px-6 py-4">16.36%</td>
                                <td class="px-6 py-4">9.00%</td>
                                <td class="px-6 py-4">3.20%</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Spain</td>
                                <td class="px-6 py-4">18.80%</td>
                                <td class="px-6 py-4">6.51%</td>
                                <td class="px-6 py-4">1.98%</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Sweden</td>
                                <td class="px-6 py-4">15.77%</td>
                                <td class="px-6 py-4">5.40%</td>
                                <td class="px-6 py-4">3.22%</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">Turkey</td>
                                <td class="px-6 py-4">32.14%</td>
                                <td class="px-6 py-4">6.63%</td>
                                <td class="px-6 py-4">4.35%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write your overview:</label>
                    <textarea name="overview_table" x-model="answers.overview_table" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 transition-all text-sm placeholder-gray-400" placeholder="Overall, ..."></textarea>
                </div>
            </div>

            <!-- Exercise 3: Bar Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
                    <h3 class="text-lg font-bold text-purple-800">Exercise 3: Bar Chart</h3>
                    <p class="text-sm text-purple-600 mt-1">Topic: Global Water Use by Sector (1900-2000).</p>
                </div>
                <div class="py-6 px-2 border-b border-gray-100">
                     <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="waterUseChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write your overview:</label>
                    <textarea name="overview_bar" x-model="answers.overview_bar" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 transition-all text-sm placeholder-gray-400" placeholder="Overall, ..."></textarea>
                </div>
            </div>

            <!-- Exercise 4: Pie Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-orange-50 px-6 py-4 border-b border-orange-100">
                    <h3 class="text-lg font-bold text-orange-800">Exercise 4: Pie Chart</h3>
                    <p class="text-sm text-orange-600 mt-1">Topic: Energy Production in France (1995 vs 2005).</p>
                </div>
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row gap-8 justify-center items-center">
                     <div class="flex flex-col items-center w-full max-w-[200px]">
                         <p class="text-center font-bold mb-2 text-gray-700">1995</p>
                         <div class="relative w-full h-[200px]">
                            <canvas id="energy1995Chart"></canvas>
                         </div>
                    </div>
                     <div class="flex flex-col items-center w-full max-w-[200px]">
                         <p class="text-center font-bold mb-2 text-gray-700">2005</p>
                         <div class="relative w-full h-[200px]">
                            <canvas id="energy2005Chart"></canvas>
                         </div>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write your overview:</label>
                    <textarea name="overview_pie" x-model="answers.overview_pie" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 transition-all text-sm placeholder-gray-400" placeholder="Overall, ..."></textarea>
                </div>
            </div>

            <!-- Exercise 5: Mixed Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-pink-50 px-6 py-4 border-b border-pink-100">
                    <h3 class="text-lg font-bold text-pink-800">Exercise 5: Mixed Chart</h3>
                    <p class="text-sm text-pink-600 mt-1">Topic: Average monthly temperature and rainfall in London.</p>
                </div>
                <div class="py-6 px-2 border-b border-gray-100">
                     <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="mixedChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write your overview:</label>
                    <textarea name="overview_mixed" x-model="answers.overview_mixed" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 transition-all text-sm placeholder-gray-400" placeholder="Overall, ..."></textarea>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Line Chart (Fast Food)
    const ctx1 = document.getElementById('fastFoodChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['1975', '1980', '1985', '1990', '1995', '2000'],
            datasets: [
                { label: 'Fish and Chips', data: [100, 85, 60, 50, 45, 39], borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 3, tension: 0.4 },
                { label: 'Pizza', data: [10, 20, 35, 55, 70, 85], borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 3, tension: 0.4 },
                { label: 'Hamburgers', data: [15, 25, 40, 50, 65, 75], borderColor: 'rgb(234, 179, 8)', backgroundColor: 'rgba(234, 179, 8, 0.1)', borderWidth: 3, tension: 0.4 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Fast Food Consumption' } } }
    });

    // 3. Bar Chart (Water Use)
    const ctx3 = document.getElementById('waterUseChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['1900', '1920', '1940', '1960', '1980', '2000'],
            datasets: [
                { label: 'Agriculture', data: [500, 800, 1200, 1900, 2500, 3000], backgroundColor: 'rgba(34, 197, 94, 0.7)' },
                { label: 'Industrial Use', data: [100, 200, 400, 800, 1100, 1300], backgroundColor: 'rgba(168, 85, 247, 0.7)' },
                { label: 'Domestic Use', data: [50, 80, 120, 200, 300, 400], backgroundColor: 'rgba(234, 179, 8, 0.7)' }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, title: { display: true, text: 'Km³' } } }, plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Global Water Use' } } }
    });

    // 4. Pie Charts (Energy)
    const pieOptions = { 
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: { 
            legend: { 
                position: 'bottom',
                labels: { boxWidth: 10, font: { size: 10 } } // Smaller legend
            } 
        } 
    };
    const pieLabels = ['Coal', 'Gas', 'Nuclear', 'Petro', 'Other'];
    const pieColors = ['#4b5563', '#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
    
    new Chart(document.getElementById('energy1995Chart').getContext('2d'), {
        type: 'pie',
        data: { labels: pieLabels, datasets: [{ data: [29, 30, 6, 29, 6], backgroundColor: pieColors }] },
        options: pieOptions
    });
    new Chart(document.getElementById('energy2005Chart').getContext('2d'), {
        type: 'pie',
        data: { labels: pieLabels, datasets: [{ data: [31, 30, 10, 20, 9], backgroundColor: pieColors }] },
        options: pieOptions
    });

    // 5. Mixed Chart (London Climate)
    const ctx5 = document.getElementById('mixedChart').getContext('2d');
    new Chart(ctx5, {
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                { type: 'bar', label: 'Rainfall (mm)', data: [50, 40, 40, 40, 50, 50, 50, 60, 50, 70, 60, 60], backgroundColor: 'rgba(59, 130, 246, 0.6)', yAxisID: 'y' },
                { type: 'line', label: 'Temperature (°C)', data: [5, 6, 8, 10, 14, 17, 20, 19, 16, 12, 8, 6], borderColor: 'rgb(239, 68, 68)', borderWidth: 3, yAxisID: 'y1' }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'Rainfall (mm)' } },
                y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'Temperature (°C)' }, grid: { drawOnChartArea: false } }
            },
            plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Climate in London' } }
        }
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.data('writingOverview', (meetingId) => ({
        answers: {
            overview_line: '',
            overview_table: '',
            overview_bar: '',
            overview_pie: '',
            overview_mixed: ''
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
@endpush
@include('assignments.ielts.writing.practice_toolbar')
@endsection
