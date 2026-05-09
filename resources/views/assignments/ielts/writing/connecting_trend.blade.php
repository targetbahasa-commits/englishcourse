@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="connectingTrend({{ $meeting->id }})">
    <form method="POST" action="#" id="connectingTrendForm">
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

        <div class="flex gap-4 items-center">
             <button type="button" @click.prevent="submit()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
                <span>Submit</span>
             </button>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32 w-full">
        <aside class="lg:col-span-5 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                        <h2 class="text-2xl font-extrabold text-red-700 leading-tight">Connecting trends</h2>
                        <p class="text-lg font-bold text-red-700 mt-1">Similar or different trends</p>

                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <h3 class="text-xl font-bold text-red-700 text-center mb-2">Figure 1 (Addition)</h3>
                                <div class="rounded-2xl border border-gray-300 bg-gray-50 p-3">
                                    <svg viewBox="0 0 420 250" class="w-full h-auto" role="img" aria-label="Figure 1 addition chart">
                                        <rect x="52" y="24" width="340" height="180" fill="#f3f4f6" stroke="#3b82f6" stroke-width="3"></rect>
                                        <line x1="52" y1="204" x2="392" y2="204" stroke="#111827" stroke-width="1.5"></line>
                                        <line x1="52" y1="24" x2="52" y2="204" stroke="#111827" stroke-width="1.5"></line>
                                        <polyline points="74,196 126,188 178,180 230,132 282,78 334,26" fill="none" stroke="#111827" stroke-width="6"></polyline>
                                        <g fill="#dc2626">
                                            <rect x="68" y="190" width="12" height="12" transform="rotate(45 74 196)"></rect>
                                            <rect x="120" y="182" width="12" height="12" transform="rotate(45 126 188)"></rect>
                                            <rect x="172" y="174" width="12" height="12" transform="rotate(45 178 180)"></rect>
                                            <rect x="224" y="126" width="12" height="12" transform="rotate(45 230 132)"></rect>
                                            <rect x="276" y="72" width="12" height="12" transform="rotate(45 282 78)"></rect>
                                            <rect x="328" y="20" width="12" height="12" transform="rotate(45 334 26)"></rect>
                                        </g>
                                        <text x="222" y="18" text-anchor="middle" font-size="12" font-weight="700" fill="#111827">GM car sales</text>
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-red-700 text-center mb-2">Figure 2 (Contrast)</h3>
                                <div class="rounded-2xl border border-gray-300 bg-gray-50 p-3">
                                    <svg viewBox="0 0 420 250" class="w-full h-auto" role="img" aria-label="Figure 2 contrast chart">
                                        <rect x="52" y="24" width="340" height="180" fill="#f3f4f6" stroke="#ef4444" stroke-width="3"></rect>
                                        <line x1="52" y1="204" x2="392" y2="204" stroke="#111827" stroke-width="1.5"></line>
                                        <line x1="52" y1="24" x2="52" y2="204" stroke="#111827" stroke-width="1.5"></line>
                                        <polyline points="74,170 126,142 178,116 230,50 282,92 334,114" fill="none" stroke="#111827" stroke-width="6"></polyline>
                                        <g fill="#dc2626">
                                            <rect x="68" y="164" width="12" height="12" transform="rotate(45 74 170)"></rect>
                                            <rect x="120" y="136" width="12" height="12" transform="rotate(45 126 142)"></rect>
                                            <rect x="172" y="110" width="12" height="12" transform="rotate(45 178 116)"></rect>
                                            <rect x="224" y="44" width="12" height="12" transform="rotate(45 230 50)"></rect>
                                            <rect x="276" y="86" width="12" height="12" transform="rotate(45 282 92)"></rect>
                                            <rect x="328" y="108" width="12" height="12" transform="rotate(45 334 114)"></rect>
                                        </g>
                                        <text x="222" y="18" text-anchor="middle" font-size="12" font-weight="700" fill="#111827">GM car sales</text>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4 text-gray-800">
                            <div>
                                <h4 class="text-2xl font-extrabold text-red-700">Figure 1 example:</h4>
                                <p class="mt-2 text-lg leading-relaxed">✓ GM car sales increased gradually to $24,000 in 1980, and then it continued its upward trend in the next four years to reach a peak at $105,000 in 2010.</p>
                            </div>
                            <div>
                                <h4 class="text-2xl font-extrabold text-red-700">Figure 2 example:</h4>
                                <p class="mt-2 text-lg leading-relaxed">✓ There was a sharp increase in GM car sales between 1960 and 1990 until it reached a high of almost $95,000; however, sales began to decrease swiftly to under $65,000 in 2010.</p>
                            </div>
                        </div>
            </div>
        </aside>

        <div class="lg:col-span-7 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <!-- Answer Section -->
            <div class="grid grid-cols-1 gap-6">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col h-full card-hover relative overflow-hidden">
                        <!-- Badge -->
                        <div class="absolute top-0 right-0 bg-teal-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg shadow-sm z-10" x-text="'Graph ' + item.id"></div>

                        <!-- SVG Chart (sharp rendering) -->
                        <div class="px-4 pt-8 pb-4 border-b border-gray-100 bg-white">
                            <h4 class="text-center text-4xl font-bold text-gray-600 leading-none mb-2" x-text="item.title"></h4>
                            <div class="mx-auto w-full max-w-[360px]">
                                <svg viewBox="0 0 560 360" class="w-full h-auto" role="img" :aria-label="'Graph ' + item.id">
                                    <rect x="24" y="24" width="512" height="312" rx="24" ry="24" fill="#f9fafb" stroke="#9ca3af" stroke-width="2"></rect>

                                    <rect
                                        :x="chart.plotX"
                                        :y="chart.plotY"
                                        :width="chart.plotW"
                                        :height="chart.plotH"
                                        fill="#f3f4f6"
                                        :stroke="item.color"
                                        stroke-width="4"
                                    ></rect>

                                    <template x-for="tick in chart.yTicks" :key="'y-' + item.id + '-' + tick">
                                        <line
                                            :x1="chart.plotX"
                                            :x2="chart.plotX + chart.plotW"
                                            :y1="valueToY(tick)"
                                            :y2="valueToY(tick)"
                                            stroke="#9ca3af"
                                            stroke-width="1.5"
                                        ></line>
                                    </template>

                                    <polyline
                                        :points="polylinePoints(item)"
                                        fill="none"
                                        stroke="#111827"
                                        stroke-width="8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></polyline>

                                    <rect :x="indexToX(0) - 7" :y="valueToY(item.values[0]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(0)} ${valueToY(item.values[0])})`"></rect>
                                    <rect :x="indexToX(1) - 7" :y="valueToY(item.values[1]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(1)} ${valueToY(item.values[1])})`"></rect>
                                    <rect :x="indexToX(2) - 7" :y="valueToY(item.values[2]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(2)} ${valueToY(item.values[2])})`"></rect>
                                    <rect :x="indexToX(3) - 7" :y="valueToY(item.values[3]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(3)} ${valueToY(item.values[3])})`"></rect>
                                    <rect :x="indexToX(4) - 7" :y="valueToY(item.values[4]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(4)} ${valueToY(item.values[4])})`"></rect>
                                    <rect :x="indexToX(5) - 7" :y="valueToY(item.values[5]) - 7" width="14" height="14" rx="1" fill="#dc2626" :transform="`rotate(45 ${indexToX(5)} ${valueToY(item.values[5])})`"></rect>

                                    <template x-for="tick in chart.yTicks" :key="'yl-' + item.id + '-' + tick">
                                        <text
                                            :x="chart.plotX - 24"
                                            :y="valueToY(tick) + 6"
                                            text-anchor="end"
                                            font-size="12"
                                            font-weight="700"
                                            fill="#374151"
                                            x-text="tick"
                                        ></text>
                                    </template>

                                    <template x-for="(year, index) in chart.years" :key="'x-' + item.id + '-' + year">
                                        <text
                                            :x="indexToX(index)"
                                            :y="chart.plotY + chart.plotH + 34"
                                            transform-origin="center"
                                            :transform="`rotate(-35 ${indexToX(index)} ${chart.plotY + chart.plotH + 34})`"
                                            text-anchor="middle"
                                            font-size="10"
                                            font-weight="700"
                                            fill="#4b5563"
                                            x-text="year"
                                        ></text>
                                    </template>
                                </svg>
                            </div>
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <textarea
                                class="w-full min-h-[6rem] p-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 focus:outline-none transition-all resize-none overflow-hidden text-sm leading-relaxed"
                                :placeholder="'Describe trend ' + item.id + '...'"
                                x-model="answers[item.id]"
                                :name="'answer_' + item.id"
                                @input="autoResize($event.target)"
                                x-init="$nextTick(() => autoResize($el))"
                            ></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    </form>

</div>

<!-- Alpine Data for the page -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('connectingTrend', (meetingId) => ({
            answers: {},
            loading: false,
            chart: {
                plotX: 110,
                plotY: 70,
                plotW: 390,
                plotH: 210,
                yMin: 5,
                yMax: 105,
                yTicks: [105, 85, 65, 45, 25, 5],
                years: [1960, 1970, 1980, 1990, 2000, 2010],
            },
            items: [
                { id: 'A', title: "A (Net users in '000)", color: '#3b82f6', values: [95, 55, 30, 25, 25, 20] },
                { id: 'B', title: 'B (Net users)', color: '#ef4444', values: [20, 45, 95, 95, 95, 95] },
                { id: 'C', title: 'C (Net users)', color: '#3b82f6', values: [20, 30, 50, 80, 100, 105] },
                { id: 'D', title: 'D (Birds population)', color: '#84cc16', values: [95, 70, 60, 20, 50, 70] },
                { id: 'E', title: 'E (Birds population)', color: '#f97316', values: [95, 80, 20, 18, 18, 18] },
                { id: 'F', title: 'F (Birds population)', color: '#06b6d4', values: [85, 20, 70, 20, 80, 105] },
            ],
            valueToY(value) {
                const ratio = (value - this.chart.yMin) / (this.chart.yMax - this.chart.yMin);
                return this.chart.plotY + this.chart.plotH - (ratio * this.chart.plotH);
            },
            indexToX(index) {
                const step = this.chart.plotW / (this.chart.years.length - 1);
                return this.chart.plotX + (index * step);
            },
            pointObjects(item) {
                return item.values.map((value, index) => ({
                    x: this.indexToX(index),
                    y: this.valueToY(value),
                }));
            },
            polylinePoints(item) {
                return this.pointObjects(item)
                    .map((point) => `${point.x},${point.y}`)
                    .join(' ');
            },
            autoResize(el) {
                if (!el) return;
                el.style.height = 'auto';
                el.style.height = `${el.scrollHeight}px`;
            },
            init() {
                // Initialize External AutoSave
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }

                // Restore from AutoSave (optional overlap, but AutoSave handles restoration)
                // However, we need to sync x-model 'answers' with the restored DOM values if AutoSave runs first.
                // Actually AutoSave updates DOM values. Alpine might overwrite them if 'answers' is empty.
                // Let's rely on AutoSave restoring to input, then syncing back to x-model? 
                // Or better: Let AutoSave handle it, and we update 'answers' from DOM after valid restore?
                setTimeout(() => {
                    this.items.forEach(item => {
                        const el = document.querySelector(`[name="answer_${item.id}"]`);
                        if(el && el.value) {
                             this.answers[item.id] = el.value;
                        }
                    });
                    this.$nextTick(() => {
                        document.querySelectorAll('textarea[name^="answer_"]').forEach(el => this.autoResize(el));
                    });
                }, 500);
            },
            submit() {
                this.loading = true;
                const key = 'connecting_trend_autosave_' + meetingId;
                localStorage.setItem(key, JSON.stringify(this.answers));
                
                setTimeout(() => {
                    this.loading = false;
                    alert('Practice saved successfully!');
                }, 1000);
            }
        }))
    })
</script>
@include('assignments.ielts.writing.practice_toolbar')
@endsection
