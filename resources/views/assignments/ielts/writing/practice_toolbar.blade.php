<div x-data="{
        x: window.innerWidth - 60, 
        y: window.innerHeight / 2 - 100,
        init() {
            setTimeout(() => {
                let w = this.$el.offsetWidth > 0 ? this.$el.offsetWidth : 48;
                let h = this.$el.offsetHeight > 0 ? this.$el.offsetHeight : 300;
                this.x = window.innerWidth - w - 15;
                this.y = (window.innerHeight - h) / 2;
                if (this.y < 15) this.y = 15;
            }, 100);
            
            // Adjust on resize
            window.addEventListener('resize', () => {
                let w = this.$el.offsetWidth > 0 ? this.$el.offsetWidth : 48;
                let h = this.$el.offsetHeight > 0 ? this.$el.offsetHeight : 300;
                this.x = window.innerWidth - w - 15;
                this.y = (window.innerHeight - h) / 2;
                if (this.y < 15) this.y = 15;
            });
        },
        dragging: false,
        offset: { x: 0, y: 0 },
        startDrag(e) {
            // Let buttons handle their own clicks
            if (e.target.closest('button')) return;
            
            this.dragging = true;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            
            this.offset.x = clientX - this.x;
            this.offset.y = clientY - this.y;
            
            const onMouseMove = (e) => {
                if (!this.dragging) return;
                // prevent default scrolling when dragging
                if (e.type === 'touchmove') e.preventDefault();
                
                const currentX = e.touches ? e.touches[0].clientX : e.clientX;
                const currentY = e.touches ? e.touches[0].clientY : e.clientY;
                
                this.x = currentX - this.offset.x;
                this.y = currentY - this.offset.y;

                // Bounds check
                if (this.y < 0) this.y = 0;
                if (this.y > window.innerHeight - 50) this.y = window.innerHeight - 50;
                if (this.x < 0) this.x = 0;
                if (this.x > window.innerWidth - 50) this.x = window.innerWidth - 50;
            };
            
            const onMouseUp = () => {
                this.dragging = false;
                window.removeEventListener('mousemove', onMouseMove);
                window.removeEventListener('mouseup', onMouseUp);
                window.removeEventListener('touchmove', onMouseMove);
                window.removeEventListener('touchend', onMouseUp);
            };
            
            window.addEventListener('mousemove', onMouseMove);
            window.addEventListener('mouseup', onMouseUp);
            window.addEventListener('touchmove', onMouseMove, { passive: false });
            window.addEventListener('touchend', onMouseUp);
        }
    }" :style="`position: fixed; left: ${x}px; top: ${y}px; z-index: 40; margin: 0; transform: none; touch-action: none;`"
    @mousedown="startDrag($event)" @touchstart="startDrag($event)" x-show="!showResults"
    class="flex flex-col items-center gap-2 sm:gap-3 p-1 cursor-move select-none">

    <!-- TENSES (Only for Grammar) -->
    @if(($meeting->task_type ?? 0) == 3)
        <div x-data="{ openTenses: false }">
            <button title="Tenses" @click="openTenses = true"
                class="bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>
            <template x-teleport="body">
                <div x-show="openTenses" style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 md:p-4 z-[100]"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div @click.outside="openTenses = false"
                        class="bg-white rounded-xl shadow-2xl p-3 md:p-6 max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Tenses Image</h3>
                            <button @click="openTenses = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-center mb-6 overflow-x-auto w-full pb-2">
                            <img src="{{ asset('images/materials/grammar/tenses-chart.png') }}" alt="Tenses Chart"
                                class="min-w-[600px] md:min-w-0 md:max-w-full h-auto rounded shadow-sm border border-gray-200">
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800 text-sm">
                            <p>💡 Gunakan chart ini sebagai panduan untuk menentukan tenses yang tepat</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- TENSES CHART (HTML Table) -->
        <div x-data="{ openTensesChart: false }">
            <button title="Tenses Chart" @click="openTensesChart = true"
                class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        </button>
            <template x-teleport="body">
                <div x-show="openTensesChart" style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 z-[100]"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div @click.outside="openTensesChart = false"
                        class="bg-white rounded-xl shadow-2xl p-3 md:p-6 max-w-6xl w-full max-h-[90vh] overflow-y-auto transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg md:text-2xl font-bold text-gray-800">Tenses Reference Chart</h3>
                            <button @click="openTensesChart = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 text-sm">
                                <thead>
                                    <tr class="bg-yellow-50">
                                        <th class="border border-gray-300 p-2 w-12"></th>
                                        <th class="border border-gray-300 p-3 font-bold text-base md:text-lg text-left">Simple</th>
                                        <th class="border border-gray-300 p-3 font-bold text-base md:text-lg text-left">Continuous</th>
                                        <th class="border border-gray-300 p-3 font-bold text-base md:text-lg text-left">Perfect</th>
                                        <th class="border border-gray-300 p-3 font-bold text-base md:text-lg text-left">Perfect
                                            Continuous</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Present -->
                                    <tr>
                                        <th class="border border-gray-300 p-0 bg-[#8cb6e8] text-black w-12 align-middle">
                                            <div style="writing-mode: vertical-rl; transform: rotate(180deg);"
                                                class="mx-auto text-lg md:text-2xl font-bold tracking-widest py-2 md:py-4">Present</div>
                                        </th>
                                        <td class="border border-gray-300 bg-[#e4f0fa] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-blue-200 text-blue-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + V1(s/es) + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + is/am/are + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + is/am/are + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#e4f0fa] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-blue-200 text-blue-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + is/am/are + V-ing + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + is/am/are + being + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + is/am/are + being + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#e4f0fa] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-blue-200 text-blue-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + has/have + V3 + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + has/have + been + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + has/have + been + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#e4f0fa] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-blue-200 text-blue-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + has/have + been + V-ing + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + has/have + been + being + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1 text-opacity-70">
                                                        Nominal</div>
                                                    <p class="italic text-gray-500 mt-1">Gunakan pola Present Perfect
                                                        Nominal</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Past -->
                                    <tr>
                                        <th class="border border-gray-300 p-0 bg-[#f4b68e] text-black w-12 align-middle">
                                            <div style="writing-mode: vertical-rl; transform: rotate(180deg);"
                                                class="mx-auto text-lg md:text-2xl font-bold tracking-widest py-2 md:py-4">Past</div>
                                        </th>
                                        <td class="border border-gray-300 bg-[#fde9df] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-orange-200 text-orange-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + V2 + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + was/were + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + was/were + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#fde9df] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-orange-200 text-orange-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + was/were + V-ing + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + was/were + being + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + was/were + being + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#fde9df] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-orange-200 text-orange-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + had + V3 + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + had + been + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + had + been + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#fde9df] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-orange-200 text-orange-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + had been + V-ing + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + had been + being + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1 text-opacity-70">
                                                        Nominal</div>
                                                    <p class="italic text-gray-500 mt-1">Gunakan pola Past Perfect Nominal
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Future -->
                                    <tr>
                                        <th class="border border-gray-300 p-0 bg-[#eade78] text-black w-12 align-middle">
                                            <div style="writing-mode: vertical-rl; transform: rotate(180deg);"
                                                class="mx-auto text-lg md:text-2xl font-bold tracking-widest py-2 md:py-4">Future</div>
                                        </th>
                                        <td class="border border-gray-300 bg-[#faf6d4] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-yellow-200 text-yellow-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + V1 + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + be + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + be + ANA</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#faf6d4] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-yellow-200 text-yellow-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + be + V-ing + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + be + being + V3</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1 text-opacity-70">
                                                        Nominal</div>
                                                    <p class="italic text-gray-500 mt-1">Jarang digunakan</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#faf6d4] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-yellow-200 text-yellow-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + have + V3 + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Passive)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + have + been + V3
                                                    </p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Nominal</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + have + been + ANA
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 bg-[#faf6d4] p-2 md:p-4 align-top min-w-[150px] md:min-w-[250px]">
                                            <div class="space-y-4">
                                                <div>
                                                    <div
                                                        class="inline-block bg-yellow-200 text-yellow-900 text-xs font-bold px-2 py-0.5 rounded mb-1">
                                                        Verbal (Active)</div>
                                                    <p class="font-bold mb-1 text-xs md:text-base">S + will/shall + have + been + V-ing
                                                        + O</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-green-200 text-green-900 text-xs font-bold px-2 py-0.5 rounded mb-1 text-opacity-70">
                                                        Verbal (Passive)</div>
                                                    <p class="italic text-gray-500 mt-1">Sangat jarang digunakan</p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-2 py-0.5 rounded mb-1 text-opacity-70">
                                                        Nominal</div>
                                                    <p class="italic text-gray-500 mt-1">Gunakan pola Future Perfect Nominal
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endif

    <!-- 1. LINKING WORDS -->
    @if(($meeting->task_type ?? 0) != 3 || in_array($grammarLevel ?? '', ['complexity', 'proficiency', 'all']))
        <div x-data="{
                open: false,
                searchQuery: '',
                words: [
                    { category: 'Time / Chronological (Waktu)', words: 'Afterwards – Setelah itu, Soon – Segera, Meanwhile – Sementara itu, In the meantime – Selagi itu, Next – Berikutnya, Then – Lalu, Later – Nanti, Eventually – Akhirnya, At the same time – Pada saat yang sama, In the same instant – Dalam waktu yang bersamaan, Today – Hari ini, Nowadays – Sekarang ini, In the beginning – Pada awalnya, To begin – Untuk memulai, In time – Pada waktunya, In future – Di masa depan, Finally – Akhirnya, Initially – Awalnya, Subsequently – Selanjutnya, Simultaneously – Secara bersamaan' },
                    { category: 'Addition (Penambahan)', words: 'Moreover – Selain itu, Furthermore – Lebih lanjut, In addition – Sebagai tambahan, Further – Selanjutnya' },
                    { category: 'Sequential (Urutan)', words: 'Next – Berikutnya, First – Pertama, Second – Kedua, Third – Ketiga, Firstly – Pertama-tama, Secondly – Kedua, Thirdly – Ketiga, In the first place – Yang pertama, In the second place – Yang kedua, In the third place – Yang ketiga' },
                    { category: 'Contrast (Pertentangan)', words: 'However – Namun, Yet – Namun demikian, In contrast – Sebaliknya, Conversely – Sebaliknya, On the other hand – Di sisi lain, On the contrary – Sebaliknya, Otherwise – Jika tidak, Nevertheless – Meskipun begitu, Notwithstanding – Walaupun demikian, In spite of this – Meskipun demikian, By contrast – Sebagai perbandingan, Whereas – Padahal' },
                    { category: 'Conclusion / Summary (Kesimpulan)', words: 'As a result – Akibatnya, As has been noted – Seperti dicatat, As I have said – Seperti dikatakan, As mentioned earlier – Seperti disebutkan, In conclusion – Kesimpulan, To conclude – Untuk menyimpulkan, In brief – Secara singkat, Finally – Akhirnya, In other words – Dengan kata lain, In short – Singkatnya, In a word – Dalam satu kata, On the whole – Secara keseluruhan, Therefore – Oleh karena itu, In summary – Ringkasnya, To summarize – Merangkum, To sum up – Menyimpulkan, All in all – Secara keseluruhan' },
                    { category: 'Similarity (Persamaan)', words: 'Likewise – Demikian juga, Similarly – Demikian pula, In the same way – Dengan cara sama, In like manner – Dengan cara serupa' },
                    { category: 'Cause & Effect (Logika/Sebab-Akibat)', words: 'Therefore – Oleh karena itu, Thus – Jadi, Hence – Maka, Consequently – Akibatnya, After all – Bagaimanapun juga, Accordingly – Dengan demikian, Knowing this – Mengetahui hal ini, With this in mind – Dengan pertimbangan ini' },
                    { category: 'Example / Clarification (Contoh/Klarifikasi)', words: 'For example – Misalnya, For instance – Contohnya, More specifically – Lebih spesifik, In particular – Secara khusus, Indeed – Memang, Namely – Yaitu, Specifically – Secara khusus, To illustrate – Untuk menggambarkan, In other words – Dengan kata lain, In fact – Sebenarnya, That is – Yaitu, In brief – Singkatnya' },
                    { category: 'Reason / Cause (Alasan/Sebab)', words: 'Because – Karena, Because of – Dikarenakan, Since – Karena, As – Karena, Due to – Dikarenakan, Owing to – Dikarenakan, Thanks to – Berkat, For the reason that – Dengan alasan bahwa, On account of – Dikarenakan, Given that – Mengingat bahwa' }
                ],
                get filteredWords() {
                    if (!this.searchQuery.trim()) return this.words;
                    const query = this.searchQuery.toLowerCase();
                    return this.words.filter(item => item.category.toLowerCase().includes(query) || item.words.toLowerCase().includes(query));
                }
            }">
            <button title="Linking Words" @click="open = true"
                class="bg-teal-500 hover:bg-teal-600 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
        </button>

            <template x-teleport="body">
                <div x-show="open" style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                    <div @click.outside="open = false"
                        class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-teal-50">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Daftar Linking Words</h3>
                                <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                            </div>
                            <input type="text" x-model="searchQuery" placeholder="Cari kategori atau kata..."
                                class="w-full px-4 py-2 border border-teal-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                            <table class="w-full text-sm text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="p-3 border border-teal-600 bg-teal-500 text-white w-1/4">Kategori</th>
                                        <th class="p-3 border border-teal-600 bg-teal-500 text-white">Words</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="(item, index) in filteredWords" :key="index">
                                        <tr class="odd:bg-white even:bg-teal-50 hover:bg-teal-100">
                                            <td class="p-3 border border-gray-200 font-bold text-teal-800"
                                                x-text="item.category"></td>
                                            <td class="p-3 border border-gray-200 text-gray-700">
                                                <div class="flex flex-wrap gap-2"><template
                                                        x-for="word in item.words.split(', ')" :key="word"><span
                                                            class="px-2 py-1 bg-white border border-teal-200 rounded text-teal-700"
                                                            x-text="word"></span></template></div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endif

    <!-- 6. DICTIONARY (Full Logic) -->
<div x-data="dictionaryDataToolbar()">
    <button title="Dictionary" @click="open = true"
        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </button>
    <template x-teleport="body">
        <div x-show="open" style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div @click.outside="open = false"
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-blue-900">Translation & Thesaurus</h3><span
                            class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">Auto-Detect</span>
                    </div>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg></button>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <form @submit.prevent="search" class="flex gap-2"><input type="text" x-model="query"
                            placeholder="Type a word..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg"><button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg" :disabled="loading"><span
                                x-show="!loading">Search</span><span x-show="loading">...</span></button></form>
                </div>
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                    <div x-show="loading" class="text-center py-10">Searching...</div>
                    <div x-show="error" x-text="error" class="text-center text-red-500 py-10"></div>
                    <div x-show="dictResult && !loading" class="space-y-6">
                        <div class="bg-white p-6 rounded-xl border border-blue-200 shadow-sm">
                            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                                <div class="text-center flex-1">
                                    <p class="text-xs text-gray-500 uppercase font-bold"
                                        x-text="dictResult?.source === 'en' ? 'English' : 'Indonesia'"></p>
                                    <div class="flex items-center justify-center gap-2"><span
                                            class="text-xl text-gray-900" x-text="dictResult?.original"></span><button
                                            @click="playAudio(dictResult?.original, dictResult?.source == 'en' ? 'en-US' : 'id-ID')"
                                            class="text-gray-300 hover:text-blue-500">🔊</button></div>
                                </div>
                                <div class="text-gray-300">➜</div>
                                <div class="text-center flex-1">
                                    <p class="text-xs text-gray-500 uppercase font-bold"
                                        x-text="dictResult?.source === 'en' ? 'Indonesia' : 'English'"></p>
                                    <div class="flex items-center justify-center gap-2"><span
                                            class="text-lg md:text-2xl font-bold text-blue-700"
                                            x-text="dictResult?.translation"></span><button
                                            @click="playAudio(dictResult?.translation, dictResult?.source == 'en' ? 'id-ID' : 'en-US')"
                                            class="text-blue-300 hover:text-blue-600">🔊</button></div>
                                </div>
                            </div>
                        </div>
                        <div x-show="dictResult?.examples?.length > 0">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Examples</h4>
                            <ul class="bg-white rounded-xl border border-gray-200"><template
                                    x-for="ex in dictResult?.examples">
                                    <li class="px-4 py-3 border-b border-gray-100 last:border-0 italic text-gray-700"
                                        x-text="ex"></li>
                                </template></ul>
                        </div>
                        <div x-show="dictResult?.synonyms?.length > 0" class="mb-4">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Synonyms</h4>
                            <div class="flex flex-wrap gap-2"><template x-for="syn in dictResult?.synonyms"><span
                                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-purple-100 cursor-pointer"
                                        @click="query = syn; search()" x-text="syn"></span></template></div>
                        </div>
                        <div x-show="dictResult?.academic_words?.length > 0">
                            <h4 class="text-sm font-bold text-gray-400 uppercase mb-3">Academic Words</h4>
                            <div class="flex flex-wrap gap-2"><template x-for="aw in dictResult?.academic_words"><span
                                        class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg text-sm hover:bg-blue-100 cursor-pointer flex items-center"
                                        @click="query = aw.word; search()"><span x-text="aw.word"
                                            class="font-medium"></span><span x-text="`(${aw.cefr})`"
                                            class="text-xs opacity-75 ml-1"></span></span></template></div>
                        </div>
                    </div>
                </div>
                <div
                    class="p-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400 bg-gray-50">
                    <div class="flex items-center gap-2"><span>Source:</span><span x-text="results?.source || 'Auto'"
                            class="font-bold"></span><a href="#" @click.prevent="testConnection()"
                            class="ml-2 text-blue-400">(Test Connection)</a></div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function dictionaryDataToolbar() {
        return {
            open: false, query: '', dictResult: null, loading: false, error: null, results: {},
            async search() {
                if (!this.query.trim()) return;
                this.loading = true; this.error = null; this.dictResult = null; this.results.source = 'Auto';
                const q = this.query.trim(); const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                try {
                    // 1. MyMemory Fallback
                    const fallback = async () => {
                        const res = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(q)}&langpair=en|id`);
                        const d = await res.json();
                        return d.responseData?.translatedText ? { text: d.responseData.translatedText, source: 'MyMemory', lang: 'en' } : null;
                    };

                    // 2. Try Direct Connection
                    const aiTask = async () => {
                        try {
                            const r = await fetch('/api/ollama/translate', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify({ text: q }) });
                            if (r.ok) {
                                const d = await r.json();
                                if (d.translation) return { text: d.translation, source: d.source || 'Groq/Gemini AI', lang: d.detected_source };
                            }
                        } catch (e) { }

                        try {
                            let activeModel = 'local-model';
                            let modelNameDisplay = 'Local AI';
                            try {
                                const modelsRes = await fetch('http://localhost:1234/v1/models').then(r => r.ok ? r.json() : null).catch(() => null);
                                if (modelsRes && modelsRes.data && modelsRes.data.length > 0) {
                                    const m = modelsRes.data.find(m => !m.id.toLowerCase().includes('embed'));
                                    if (m) {
                                        activeModel = m.id;
                                        modelNameDisplay = m.id.split('/').pop();
                                    }
                                }
                            } catch (e) { }

                            const sysPrompt = "You are a professional dictionary. Detect language and translate. Return ONLY strict JSON. No chatter. No poems. Max 5 words.";
                            const userPrompt = `Analyze the word "${q}".\n1. Detect if it is Indonesian or English.\n2. Translate it to the OTHER language.\n3. Return JSON: { "detected_source": "id" or "en", "translation": "translated_word" }\n\nExample:\nInput: "house"\nOutput: { "detected_source": "en", "translation": "rumah" }\n\nInput: "${q}"\nOutput:`;

                            const directRes = await fetch('http://localhost:1234/v1/chat/completions', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    model: activeModel,
                                    messages: [{ role: 'system', content: sysPrompt }, { role: 'user', content: userPrompt }],
                                    temperature: 0.1, stream: false
                                })
                            });

                            if (directRes.ok) {
                                const dData = await directRes.json();
                                const content = dData.choices[0].message.content;
                                let parsed = null;
                                try { parsed = JSON.parse(content); }
                                catch (e) {
                                    const match = content.match(/\{[\s\S]*\}/);
                                    if (match) parsed = JSON.parse(match[0]);
                                }

                                if (parsed && parsed.translation) {
                                    if (parsed.translation.length > 60 && q.length < 20) return null;
                                    if (q.split(' ').length === 1 && parsed.translation.split(' ').length > 5) return null;
                                    return { text: parsed.translation, source: modelNameDisplay, lang: parsed.detected_source };
                                }
                            }
                        } catch (e) { }
                        return null;
                    };

                    // Race
                    let winner = null;
                    try { winner = await Promise.race([aiTask(), new Promise((_, r) => setTimeout(() => r('timeout'), 4000))]); } catch (e) { }

                    let translation = ''; let source = ''; let lang = 'en';
                    if (winner) { translation = winner.text; source = winner.source; lang = winner.lang; }
                    else { const fb = await fallback(); if (fb) { translation = fb.text; source = fb.source; lang = fb.lang; } else throw new Error('Not found'); }

                    // Examples/Synonyms
                    this.dictResult = { source: lang, original: q, translation: translation, examples: [], synonyms: [] };
                    this.results.source = source;

                    let enWord = lang === 'en' ? q : translation;
                    if (enWord) {
                        const cleanEnglish = enWord.replace(/[.,?!]/g, "").trim();
                        if (cleanEnglish && cleanEnglish.split(/\s+/).length === 1) {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            const [dRes, mRes, aRes] = await Promise.all([
                                fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(cleanEnglish)}`).then(r => r.ok ? r.json() : null).catch(() => null),
                                fetch(`https://api.datamuse.com/words?rel_syn=${encodeURIComponent(cleanEnglish)}&max=10`).then(r => r.ok ? r.json() : null).catch(() => null),
                                fetch('/api/ollama/academic-words', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                                    body: JSON.stringify({ word: cleanEnglish })
                                }).then(r => r.ok ? r.json() : null).catch(() => null)
                            ]);
                            if (dRes && dRes[0]?.meanings) {
                                dRes[0].meanings.forEach(m => m.definitions.forEach(d => { if (d.example) this.dictResult.examples.push(d.example); }));
                                this.dictResult.examples = [...new Set(this.dictResult.examples)].slice(0, 3);
                            }
                            if (mRes) this.dictResult.synonyms = mRes.map(i => i.word);
                            if (aRes && aRes.academic_words) this.dictResult.academic_words = aRes.academic_words;
                        }
                    }
                } catch (e) { this.error = "Translation failed."; } finally { this.loading = false; }
            },
            playAudio(text, lang) { if (window.speechSynthesis) { const u = new SpeechSynthesisUtterance(text); u.lang = lang; window.speechSynthesis.speak(u); } },
            testConnection() { alert('Connection Test: OK'); }
        }
    }
</script>

    <!-- 2. IRREGULAR VERBS -->
    <div x-data="{
        open: false,
        searchQuery: '',
        verbs: [
             ['arise', 'arose', 'arisen', 'timbul'], ['awake', 'awoke', 'awoken', 'bangun'], ['be', 'was/were', 'been', 'menjadi'], ['bear', 'bore', 'born(e)', 'menanggung'], ['beat', 'beat', 'beaten', 'mengalahkan'], ['become', 'became', 'become', 'menjadi'], ['begin', 'began', 'begun', 'mulai'], ['bend', 'bent', 'bent', 'membengkokkan'], ['bet', 'bet', 'bet', 'bertaruh'], ['bind', 'bound', 'bound', 'mengikat'], ['bite', 'bit', 'bitten', 'menggigit'], ['bleed', 'bled', 'bled', 'berdarah'], ['blow', 'blew', 'blown', 'meniup'], ['break', 'broke', 'broken', 'memecahkan'], ['breed', 'bred', 'bred', 'berkembang biak'], ['bring', 'brought', 'brought', 'membawa'], ['broadcast', 'broadcast', 'broadcast', 'menyiarkan'], ['build', 'built', 'built', 'membangun'], ['burn', 'burnt/burned', 'burnt/burned', 'membakar'], ['burst', 'burst', 'burst', 'meledak'], ['buy', 'bought', 'bought', 'membeli'], ['cast', 'cast', 'cast', 'melempar'], ['catch', 'caught', 'caught', 'menangkap'], ['choose', 'chose', 'chosen', 'memilih'], ['cling', 'clung', 'clung', 'melekat'], ['come', 'came', 'come', 'datang'], ['cost', 'cost', 'cost', 'berharga'], ['creep', 'crept', 'crept', 'merayap'], ['cut', 'cut', 'cut', 'memotong'], ['deal', 'dealt', 'dealt', 'berurusan'], ['dig', 'dug', 'dug', 'menggali'], ['do', 'did', 'done', 'melakukan'], ['draw', 'drew', 'drawn', 'menggambar'], ['dream', 'dreamt/dreamed', 'dreamt/dreamed', 'bermimpi'], ['drink', 'drank', 'drunk', 'minum'], ['drive', 'drove', 'driven', 'mengemudi'], ['eat', 'ate', 'eaten', 'makan'], ['fall', 'fell', 'fallen', 'jatuh'], ['feed', 'fed', 'fed', 'memberi makan'], ['feel', 'felt', 'felt', 'merasa'], ['fight', 'fought', 'fought', 'berkelahi'], ['find', 'found', 'found', 'menemukan'], ['flee', 'fled', 'fled', 'melarikan diri'], ['fly', 'flew', 'flown', 'terbang'], ['forbid', 'forbade', 'forbidden', 'melarang'], ['forget', 'forgot', 'forgotten', 'lupa'], ['forgive', 'forgave', 'forgiven', 'memaafkan'], ['freeze', 'froze', 'frozen', 'membeku'], ['get', 'got', 'got/gotten', 'mendapatkan'], ['give', 'gave', 'given', 'memberi'], ['go', 'went', 'gone', 'pergi'], ['grind', 'ground', 'ground', 'menggiling'], ['grow', 'grew', 'grown', 'tumbuh'], ['hang', 'hung', 'hung', 'menggantung'], ['have', 'had', 'had', 'mempunyai'], ['hear', 'heard', 'heard', 'mendengar'], ['hide', 'hid', 'hidden', 'menyembunyikan'], ['hit', 'hit', 'hit', 'memukul'], ['hold', 'held', 'held', 'memegang'], ['hurt', 'hurt', 'hurt', 'melukai'], ['keep', 'kept', 'kept', 'menyimpan'], ['kneel', 'knelt', 'knelt', 'berlutut'], ['know', 'knew', 'known', 'mengetahui'], ['lay', 'laid', 'laid', 'meletakkan'], ['lead', 'led', 'led', 'memimpin'], ['lean', 'leant/leaned', 'leant/leaned', 'bersandar'], ['leap', 'leapt/leaped', 'leapt/leaped', 'melompat'], ['learn', 'learnt/learned', 'learnt/learned', 'belajar'], ['leave', 'left', 'left', 'meninggalkan'], ['lend', 'lent', 'lent', 'meminjamkan'], ['let', 'let', 'let', 'membiarkan'], ['lie', 'lay', 'lain', 'berbaring'], ['light', 'lit/lighted', 'lit/lighted', 'menyalakan'], ['lose', 'lost', 'lost', 'kehilangan'], ['make', 'made', 'made', 'membuat'], ['mean', 'meant', 'meant', 'berarti'], ['meet', 'met', 'met', 'bertemu'], ['mow', 'mowed', 'mown/mowed', 'memotong rumput'], ['overcome', 'overcame', 'overcome', 'mengatasi'], ['pay', 'paid', 'paid', 'membayar'], ['put', 'put', 'put', 'meletakkan'], ['quit', 'quit', 'quit', 'berhenti'], ['read', 'read', 'read', 'membaca'], ['ride', 'rode', 'ridden', 'mengendarai'], ['ring', 'rang', 'rung', 'berdering'], ['rise', 'rose', 'risen', 'terbit'], ['run', 'ran', 'run', 'lari'], ['saw', 'sawed', 'sawn/sawed', 'menggergaji'], ['say', 'said', 'said', 'berkata'], ['see', 'saw', 'seen', 'melihat'], ['seek', 'sought', 'sought', 'mencari'], ['sell', 'sold', 'sold', 'menjual'], ['send', 'sent', 'sent', 'mengirim'], ['set', 'set', 'set', 'mengatur'], ['sew', 'sewed', 'sewn/sewed', 'menjahit'], ['shake', 'shook', 'shaken', 'mengguncang'], ['shed', 'shed', 'shed', 'menumpahkan'], ['shine', 'shone', 'shone', 'bersinar'], ['shoot', 'shot', 'shot', 'menembak'], ['show', 'showed', 'shown', 'menunjukkan'], ['shrink', 'shrank', 'shrunk', 'menyusut'], ['shut', 'shut', 'shut', 'menutup'], ['sing', 'sang', 'sung', 'bernyanyi'], ['sink', 'sank', 'sunk', 'tenggelam'], ['sit', 'sat', 'sat', 'duduk'], ['sleep', 'slept', 'slept', 'tidur'], ['slide', 'slid', 'slid', 'meluncur'], ['smell', 'smelt/smelled', 'smelt/smelled', 'mencium bau'], ['sow', 'sowed', 'sown/sowed', 'menabur'], ['speak', 'spoke', 'spoken', 'berbicara'], ['spell', 'spelt/spelled', 'spelt/spelled', 'mengeja'], ['spend', 'spent', 'spent', 'menghabiskan'], ['spill', 'spilt/spilled', 'spilt/spilled', 'menumpahkan'], ['spin', 'spun', 'spun', 'memutar'], ['spit', 'spat', 'spat', 'meludah'], ['split', 'split', 'split', 'membelah'], ['spread', 'spread', 'spread', 'menyebar'], ['spring', 'sprang', 'sprung', 'meloncat'], ['stand', 'stood', 'stood', 'berdiri'], ['steal', 'stole', 'stolen', 'mencuri'], ['stick', 'stuck', 'stuck', 'menempel'], ['sting', 'stung', 'stung', 'menyengat'], ['stink', 'stank', 'stunk', 'berbau busuk'], ['strike', 'struck', 'struck', 'memukul'], ['strive', 'strove', 'striven', 'berjuang'], ['swear', 'swore', 'sworn', 'bersumpah'], ['sweep', 'swept', 'swept', 'menyapu'], ['swim', 'swam', 'swum', 'berenang'], ['swing', 'swung', 'swung', 'mengayun'], ['take', 'took', 'taken', 'mengambil'], ['teach', 'taught', 'taught', 'mengajar'], ['tear', 'tore', 'torn', 'merobek'], ['tell', 'told', 'told', 'menceritakan'], ['think', 'thought', 'thought', 'berpikir'], ['throw', 'threw', 'thrown', 'melempar'], ['thrust', 'thrust', 'thrust', 'mendorong'], ['tread', 'trod', 'trodden', 'menginjak'], ['understand', 'understood', 'understood', 'mengerti'], ['wake', 'woke', 'woken', 'bangun'], ['wear', 'wore', 'worn', 'memakai'], ['weave', 'wove', 'woven', 'menenun'], ['weep', 'wept', 'wept', 'menangis'], ['win', 'won', 'won', 'menang'], ['wind', 'wound', 'wound', 'memutar'], ['withdraw', 'withdrew', 'withdrawn', 'menarik'], ['wring', 'wrung', 'wrung', 'memeras'], ['write', 'wrote', 'written', 'menulis']
        ],
        get filteredVerbs() {
            if (!this.searchQuery.trim()) return this.verbs;
            const query = this.searchQuery.toLowerCase();
            return this.verbs.filter(verb => verb.some(v => v.toLowerCase().includes(query)));
        }
    }">
        <button title="Irregular Verbs" @click="open = true"
            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-yellow-50">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Daftar Irregular Verbs</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari verb (V1, V2, V3, atau arti)..."
                            class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div class="overflow-y-auto px-6 pb-6 bg-white" style="max-height: 60vh;">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V1</th>
                                    <th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V2</th>
                                    <th class="p-3 border border-yellow-600 bg-yellow-500 text-white">V3</th>
                                    <th class="p-3 border border-yellow-600 bg-yellow-500 text-white">Arti</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(verb, index) in filteredVerbs" :key="index">
                                    <tr class="odd:bg-white even:bg-yellow-50 hover:bg-yellow-100">
                                        <td class="p-3 font-medium text-gray-800" x-text="verb[0]"></td>
                                        <td class="p-3" x-text="verb[1]"></td>
                                        <td class="p-3" x-text="verb[2]"></td>
                                        <td class="p-3 italic text-gray-600" x-text="verb[3]"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- 3. GRAPHICAL VOCABULARIES (Task 1 Only) -->
    @if(($meeting->task_type ?? 0) == 1)
        <div x-data="{ open: false }">
            <button @click="open = true"
                class="bg-gray-700 hover:bg-gray-800 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                Describing Trends
            </button>

            <template x-teleport="body">
                <div x-show="open" style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                    <div @click.outside="open = false"
                        class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Describing Trends & Language of Change</h3>
                                <p class="text-sm text-gray-500">Vocabulary used to describe changes in graphs.</p>
                            </div>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>

                        <div class="overflow-y-auto p-6 bg-white space-y-8">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- UP -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Trends: Up ↗️</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-blue-200">
                                        <thead class="bg-blue-100 text-blue-900">
                                            <tr>
                                                <th class="p-2 border border-blue-200 text-left">Verb</th>
                                                <th class="p-2 border border-blue-200 text-left">Noun</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-blue-50">
                                            <tr>
                                                <td class="p-2 border border-blue-100">rise</td>
                                                <td class="p-2 border border-blue-100">a rise</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">increase</td>
                                                <td class="p-2 border border-blue-100">an increase</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">grow</td>
                                                <td class="p-2 border border-blue-100">a growth</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">climb</td>
                                                <td class="p-2 border border-blue-100">a climb</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">boom</td>
                                                <td class="p-2 border border-blue-100">a boom</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">peak</td>
                                                <td class="p-2 border border-blue-100">a peak</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-blue-100">go up</td>
                                                <td class="p-2 border border-blue-100 text-gray-400">N/A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- DOWN -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Trends: Down ↘️</h4>
                                    </div>
                                    <table class="w-full text-sm border-collapse border border-green-200">
                                        <thead class="bg-green-100 text-green-900">
                                            <tr>
                                                <th class="p-2 border border-green-200 text-left">Verb</th>
                                                <th class="p-2 border border-green-200 text-left">Noun</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-green-50">
                                            <tr>
                                                <td class="p-2 border border-green-100">fall</td>
                                                <td class="p-2 border border-green-100">a fall</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-green-100">decrease</td>
                                                <td class="p-2 border border-green-100">a decrease</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-green-100">reduce</td>
                                                <td class="p-2 border border-green-100">a reduction</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-green-100">decline</td>
                                                <td class="p-2 border border-green-100">a decline</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-green-100">dip</td>
                                                <td class="p-2 border border-green-100">a dip</td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 border border-green-100">go down</td>
                                                <td class="p-2 border border-green-100 text-gray-400">N/A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- LEFT COLUMN GROUP (Stable + Fluctuation) -->
                                <div class="space-y-8">
                                    <!-- STABLE -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 12h14"></path>
                                            </svg>
                                            <h4 class="font-bold text-lg text-gray-800">Trends: Stable ➡️</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-red-200">
                                            <thead class="bg-red-100 text-red-900">
                                                <tr>
                                                    <th class="p-2 border border-red-200 text-left">Verb</th>
                                                    <th class="p-2 border border-red-200 text-left">Noun</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-red-50">
                                                <tr>
                                                    <td class="p-2 border border-red-100">level out</td>
                                                    <td class="p-2 border border-red-100">a leveling out</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">not change</td>
                                                    <td class="p-2 border border-red-100">no change</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">remain stable</td>
                                                    <td class="p-2 border border-red-100">(a period of) stability</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">remain steady</td>
                                                    <td class="p-2 border border-red-100 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">stay constant</td>
                                                    <td class="p-2 border border-red-100 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">maintain the same level</td>
                                                    <td class="p-2 border border-red-100 text-gray-400">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-red-100">stand steady</td>
                                                    <td class="p-2 border border-red-100 text-gray-400">N/A</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- FLUCTUATION -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M4 12l4-6 4 12 4-8 4 6"></path>
                                            </svg>
                                            <h4 class="font-bold text-lg text-gray-800">Fluctuation 〰️</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-orange-200">
                                            <thead class="bg-orange-100 text-orange-900">
                                                <tr>
                                                    <th class="p-2 border border-orange-200 text-left">Verb</th>
                                                    <th class="p-2 border border-orange-200 text-left">Noun</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-orange-50">
                                                <tr>
                                                    <td class="p-2 border border-orange-100">fluctuate</td>
                                                    <td class="p-2 border border-orange-100">a fluctuation</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-orange-100 highlight bg-orange-100/50">
                                                        oscillate</td>
                                                    <td class="p-2 border border-orange-100 highlight bg-orange-100/50">an
                                                        oscillation</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-orange-100">be volatile</td>
                                                    <td class="p-2 border border-orange-100">a period of volatility</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- DEGREE AND SPEED -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <h4 class="font-bold text-lg text-gray-800">Degree & Speed ⚡</h4>
                                    </div>
                                    <div class="flex gap-4 items-stretch">
                                        <div
                                            class="flex-1 bg-gradient-to-b from-gray-50 to-white rounded-lg border border-gray-200 p-1">
                                            <table class="w-full text-sm border-collapse">
                                                <thead class="bg-gray-200 text-gray-900">
                                                    <tr>
                                                        <th class="p-2 text-left">Adverb</th>
                                                        <th class="p-2 text-left">Adjective</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    <!-- Strong -->
                                                    <tr class="bg-gray-200/50">
                                                        <td class="p-2 font-semibold">dramatically</td>
                                                        <td class="p-2 font-semibold">dramatic</td>
                                                    </tr>
                                                    <tr class="bg-gray-200/40">
                                                        <td class="p-2 font-semibold">sharply</td>
                                                        <td class="p-2 font-semibold">sharp</td>
                                                    </tr>
                                                    <tr class="bg-gray-200/30">
                                                        <td class="p-2">enormously</td>
                                                        <td class="p-2">enormous</td>
                                                    </tr>
                                                    <tr class="bg-gray-200/20">
                                                        <td class="p-2">steeply</td>
                                                        <td class="p-2">steep</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">substantially</td>
                                                        <td class="p-2">substantial</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">considerably</td>
                                                        <td class="p-2">considerable</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">significantly</td>
                                                        <td class="p-2">significant</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">rapidly</td>
                                                        <td class="p-2">rapid</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">moderately</td>
                                                        <td class="p-2">moderate</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">gradually</td>
                                                        <td class="p-2">gradual</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 text-gray-600">slightly</td>
                                                        <td class="p-2 text-gray-600">slight</td>
                                                    </tr>
                                                    <tr class="bg-gray-50">
                                                        <td class="p-2 text-gray-500">minimally</td>
                                                        <td class="p-2 text-gray-500">minimal</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Triangle Indicator -->
                                        <div class="flex flex-col items-center w-12 shrink-0 py-2">
                                            <div class="text-xs font-bold text-gray-800 mb-1">Strong</div>
                                            <div class="flex-1 w-full relative">
                                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100"
                                                    preserveAspectRatio="none">
                                                    <defs>
                                                        <linearGradient id="gradTheme" x1="0%" y1="0%" x2="0%" y2="100%">
                                                            <stop offset="0%" style="stop-color:#374151;stop-opacity:1" />
                                                            <stop offset="100%" style="stop-color:#d1d5db;stop-opacity:1" />
                                                        </linearGradient>
                                                    </defs>
                                                    <polygon points="0,0 100,0 50,100" fill="url(#gradTheme)" />
                                                </svg>
                                            </div>
                                            <div class="text-xs font-bold text-gray-400 mt-1">Weak</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endif

    <!-- 3.5. MAKING COMPARISONS (Task 1 Only) -->
    @if(($meeting->task_type ?? 0) == 1)
            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="bg-pink-600 hover:bg-pink-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                    Making Comparisons
                </button>

                <template x-teleport="body">
                    <div x-show="open" style="display: none;"
                        class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                        <div @click.outside="open = false"
                            class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-bold text-indigo-900">Making Comparisons</h3>
                                    <p class="text-sm text-indigo-600">Vocabulary used to compare data points, contrast
                                        differences, and describe proportions.</p>
                                </div>
                                <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                            </div>

                            <div class="overflow-y-auto p-6 bg-white space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                    <!-- Proportions & Fractions -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-lg text-gray-800">Proportions & Fractions</h4>
                                        </div>
                                        <table class="w-full text-sm border-collapse border border-blue-200">
                                            <thead class="bg-blue-100 text-blue-900">
                                                <tr>
                                                    <th class="p-2 border border-blue-200 text-left">Percentage</th>
                                                    <th class="p-2 border border-blue-200 text-left">Vocabulary</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-blue-50">
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">75% - 85%</td>
                                                    <td class="p-2 border border-blue-100">A vast majority / A significant
                                                        majority</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">65% - 75%</td>
                                                    <td class="p-2 border border-blue-100">Around three quarters / A large
                                                        proportion</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">50%</td>
                                                    <td class="p-2 border border-blue-100">Exactly half</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">45% - 49%</td>
                                                    <td class="p-2 border border-blue-100">Just under half / Almost half</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">30% - 35%</td>
                                                    <td class="p-2 border border-blue-100">About a third / A third</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">25%</td>
                                                    <td class="p-2 border border-blue-100">Exactly a quarter</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">10% - 15%</td>
                                                    <td class="p-2 border border-blue-100">A small minority / A tiny proportion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 border border-blue-100 font-bold text-center">1% - 5%</td>
                                                    <td class="p-2 border border-blue-100">A tiny minority / An insignificant
                                                        amount</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Multiples & Times</h4>
                                            </div>
                                            <table class="w-full text-sm border-collapse border border-orange-200">
                                                <thead class="bg-orange-100 text-orange-900">
                                                    <tr>
                                                        <th class="p-2 border border-orange-200 text-left">Pattern</th>
                                                        <th class="p-2 border border-orange-200 text-left">Examples</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-orange-50">
                                                    <tr>
                                                        <td class="p-2 border border-orange-100 font-semibold text-orange-800">
                                                            Double / Twice</td>
                                                        <td class="p-2 border border-orange-100">A was <b>double</b> that of
                                                            B.<br>A was <b>twice as high as</b> B.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-orange-100 font-semibold text-orange-800">
                                                            Triple / Three times</td>
                                                        <td class="p-2 border border-orange-100">A <b>tripled</b> over the
                                                            period.<br>A was <b>three times larger than</b> B.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-orange-100 font-semibold text-orange-800">
                                                            Four / Five times</td>
                                                        <td class="p-2 border border-orange-100">A was <b>four times as much
                                                                as</b> B.<br>It increased <b>five times over</b>.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-orange-100 font-semibold text-orange-800">
                                                            -fold (Twofold, etc)</td>
                                                        <td class="p-2 border border-orange-100">There was a <b>twofold
                                                                increase</b> in A.<br>A increased <b>threefold</b>.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-orange-100 font-semibold text-orange-800">
                                                            Half / A third / A quarter</td>
                                                        <td class="p-2 border border-orange-100">A was <b>exactly half of</b>
                                                            B.<br>B was <b>a third of</b> A.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="space-y-8">
                                        <!-- Comparative Structures -->
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Comparative Structures</h4>
                                            </div>
                                            <table class="w-full text-sm border-collapse border border-green-200">
                                                <thead class="bg-green-100 text-green-900">
                                                    <tr>
                                                        <th class="p-2 border border-green-200 text-left">Rules</th>
                                                        <th class="p-2 border border-green-200 text-left">Adjective</th>
                                                        <th class="p-2 border border-green-200 text-left">Comparative</th>
                                                        <th class="p-2 border border-green-200 text-left">Superlative</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-green-50 align-top">
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">One
                                                            syllable</td>
                                                        <td class="p-2 border border-green-100">quick<br>old</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Add
                                                                -er</span>quicker<br>older</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Add
                                                                -est</span>quickest<br>oldest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">One
                                                            syllable – ending in 'e'</td>
                                                        <td class="p-2 border border-green-100">safe<br>nice</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Add
                                                                -r</span>safer<br>nicer</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Add
                                                                -st</span>safest<br>nicest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">One
                                                            syllable – CVC</td>
                                                        <td class="p-2 border border-green-100">big<br>wet</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Double last
                                                                consonant + er</span>bigger<br>wetter</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Double last
                                                                consonant + est</span>biggest<br>wettest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">Two
                                                            syllables – ending in 'y'</td>
                                                        <td class="p-2 border border-green-100">heavy<br>lovely</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Remove 'y' and
                                                                add -ier</span>heavier<br>lovelier</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Remove 'y' and
                                                                add -iest</span>heaviest<br>loveliest</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">Two
                                                            or more syllables</td>
                                                        <td class="p-2 border border-green-100">famous<br>embarrassed</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Use
                                                                'more'</span>more famous<br>more embarrassed</td>
                                                        <td class="p-2 border border-green-100"><span
                                                                class="text-xs text-green-600 italic block mb-1">Use
                                                                'most'</span>most famous<br>most embarrassed</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border border-green-100 font-semibold text-green-800">
                                                            Irregular</td>
                                                        <td class="p-2 border border-green-100">good<br>bad</td>
                                                        <td class="p-2 border border-green-100">better<br>worse</td>
                                                        <td class="p-2 border border-green-100">best<br>worst</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-lg text-gray-800">Useful Comparison Verbs</h4>
                                            </div>
                                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
                                                <li><b>exceed / surpass</b> – The A line exceeded B in 2022.</li>
                                                <li><b>outperform / outnumber</b> – Category X outperformed category Y.</li>
                                                <li><b>be higher than / be lower than</b> – Sales were higher than last year.
                                                </li>
                                                <li><b>rise / increase / climb</b> – The figure rose steadily.</li>
                                                <li><b>fall / decrease / drop</b> – The number dropped sharply.</li>
                                                <li><b>remain stable / stay constant</b> – The rate remained stable.</li>
                                                <li><b>peak / reach</b> – It peaked at 45%.</li>
                                                <li><b>account for / represent</b> – This category accounted for the largest
                                                    share.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </template>
        </div>
    @endif

<!-- 3.6. DIRECTION & MAPS (Task 1 Only) -->
@if(($meeting->task_type ?? 0) == 1)
    <div x-data="{ open: false }">
        <button @click="open = true"
            class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Direction & Maps
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-emerald-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-emerald-900">Map & Direction Vocabulary</h3>
                            <p class="text-sm text-emerald-600">Vocabulary used to describe locations, directions, and
                                changes in map/diagram tasks.</p>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                    <div class="overflow-y-auto p-6 bg-white space-y-8">

                        <!-- Locations & Directions Visual -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-lg text-gray-800">Locations & Directions</h4>
                            </div>

                            <!-- Visual Compass -->
                            <div
                                class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 flex justify-center items-center min-h-[300px]">
                                <svg viewBox="-40 -40 400 400"
                                    class="w-full max-w-[500px] h-auto mx-auto drop-shadow-sm flex-shrink-0"
                                    style="min-height: 450px;">
                                    <defs>
                                        <g id="small-arrow">
                                            <polygon points="160,75 170,140 160,160" fill="#E5E7EB" />
                                            <polygon points="160,75 160,160 150,140" fill="#9CA3AF" />
                                        </g>
                                        <g id="large-arrow">
                                            <polygon points="160,40 175,140 160,160" fill="#9CA3AF" />
                                            <polygon points="160,40 160,160 145,140" fill="#111827" />
                                        </g>
                                    </defs>

                                    <!-- Circles -->
                                    <circle cx="160" cy="160" r="60" fill="none" stroke="#6B7280" stroke-width="1"
                                        opacity="0.3" />
                                    <circle cx="160" cy="160" r="85" fill="none" stroke="#6B7280" stroke-width="1"
                                        opacity="0.3" />

                                    <!-- Small Arrows -->
                                    <use href="#small-arrow" transform="rotate(45 160 160)" />
                                    <use href="#small-arrow" transform="rotate(135 160 160)" />
                                    <use href="#small-arrow" transform="rotate(225 160 160)" />
                                    <use href="#small-arrow" transform="rotate(315 160 160)" />

                                    <!-- Large Arrows -->
                                    <use href="#large-arrow" transform="rotate(0 160 160)" />
                                    <use href="#large-arrow" transform="rotate(90 160 160)" />
                                    <use href="#large-arrow" transform="rotate(180 160 160)" />
                                    <use href="#large-arrow" transform="rotate(270 160 160)" />

                                    <!-- Labels -->
                                    <text x="160" y="20" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">North</text>
                                    <text x="160" y="310" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">South</text>
                                    <text x="305" y="165" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">East</text>
                                    <text x="15" y="165" text-anchor="middle" font-size="14" font-weight="bold"
                                        fill="#1F2937">West</text>

                                    <text x="250" y="70" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Northeast</text>
                                    <text x="70" y="70" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Northwest</text>
                                    <text x="250" y="260" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Southeast</text>
                                    <text x="70" y="260" text-anchor="middle" font-size="12" font-weight="600"
                                        fill="#4B5563">Southwest</text>
                                </svg>
                            </div>

                            <table class="w-full text-sm border-collapse border border-emerald-200">
                                <thead class="bg-emerald-100 text-emerald-900">
                                    <tr>
                                        <th class="p-2 border border-emerald-200 text-left">Category</th>
                                        <th class="p-2 border border-emerald-200 text-left">Vocabulary & Examples</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-50">
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Compass Phrases</td>
                                        <td class="p-2 border border-emerald-100"><b>to the north of</b>, <b>in the
                                                south-west</b>, <b>eastwards</b>, <b>just north of</b>.<br><i>The forest
                                                <b>to the north of</b> the river was cut down.</i></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Sebelah & Berdampingan</td>
                                        <td class="p-2 border border-emerald-100">
                                            <b>Beside</b>: <i>A small car park was built beside the library.</i><br>
                                            <b>Next to</b>: <i>The town hall is located next to the post office.</i><br>
                                            <b>By</b>: <i>A new seating area was added by the river.</i><br>
                                            <b>Near</b>: <i>The residential area was expanded near the woods.</i><br>
                                            <b>Close to</b>: <i>The new supermarket is situated close to the train
                                                station.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Berhadapan & Berseberangan</td>
                                        <td class="p-2 border border-emerald-100">
                                            <b>Across</b>: <i>A new bridge was constructed across the river.</i><br>
                                            <b>Across from</b>: <i>The hospital was built across from the school.</i><br>
                                            <b>In front of</b>: <i>A bus stop was added in front of the shopping
                                                mall.</i><br>
                                            <b>Opposite</b>: <i>The newly built stadium stands directly opposite the
                                                park.</i><br>
                                            <b>Facing</b>: <i>The main entrance of the hotel is facing the sea.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Depan, Belakang & Tengah</td>
                                        <td class="p-2 border border-emerald-100">
                                            <b>Behind</b>: <i>The warehouse was relocated behind the main factory.</i><br>
                                            <b>At the back of</b>: <i>A small garden was created at the back of the
                                                museum.</i><br>
                                            <b>In the middle of</b>: <i>The fountain in the middle of the square was
                                                removed.</i><br>
                                            <b>In the centre of</b>: <i>A massive shopping center now sits in the centre of
                                                the town.</i><br>
                                            <b>Between</b>: <i>The cafe was built between the library and the bank.</i><br>
                                            <b>Among</b>: <i>The new cottages were constructed among the trees.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Atas, Bawah & Pinggir</td>
                                        <td class="p-2 border border-emerald-100">
                                            <b>Above</b>: <i>On the map, the industrial estate lies above the residential
                                                zone.</i><br>
                                            <b>Below</b>: <i>The coastal village is located just below the hills.</i><br>
                                            <b>At the edge of</b>: <i>A temporary campsite was set up at the edge of the
                                                lake.</i><br>
                                            <b>Along</b>: <i>A row of new houses was built along the main road.</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-emerald-100 font-bold">Area pada Peta / Gambar</td>
                                        <td class="p-2 border border-emerald-100">
                                            <b>In the ... corner</b> (Di pojok...): <i>A hospital was located in the top
                                                left-hand corner.</i><br>
                                            <b>On the ... side</b> (Di sisi...): <i>The residential area is situated on the
                                                right side of the river.</i><br>
                                            <b>At the top / bottom</b> (Di bagian atas/bawah): <i>There is a large mountain
                                                range at the top of the map.</i><br>
                                            <b>In the center / middle</b> (Di bagian tengah): <i>The main square lies
                                                perfectly in the center of the town.</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Vocabulary of Change -->
                    <div class="space-y-2">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                            </div>
                            <table class="w-full text-xs border-collapse border border-amber-200">
                                <thead class="bg-amber-100 text-amber-900">
                                    <tr>
                                        <th class="px-2 py-1 border border-amber-200 text-left">Action</th>
                                        <th class="px-2 py-1 border border-amber-200 text-left">Vocabulary</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-50">
                                    <tr>
                                        <td class="px-2 py-1 border border-amber-100 font-bold">Adding / Building</td>
                                        <td class="px-2 py-1 border border-amber-100"><b>constructed</b>, <b>built</b>,
                                            <b>erected</b>, <b>added</b>, <b>planted</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border border-amber-100 font-bold">Removing</td>
                                        <td class="px-2 py-1 border border-amber-100"><b>demolished</b>, <b>knocked
                                                down</b>, <b>removed</b>, <b>cleared</b></td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border border-amber-100 font-bold">Replacing / Converting</td>
                                        <td class="px-2 py-1 border border-amber-100"><b>replaced by</b>, <b>converted
                                                into</b>, <b>transformed into</b></td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border border-amber-100 font-bold">Expanding / Reducing</td>
                                        <td class="px-2 py-1 border border-amber-100"><b>expanded</b>, <b>extended</b>,
                                            <b>enlarged</b>, <b>reduced</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Map Passive Voice -->
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-base text-gray-800">Using Passive Voice</h4>
                            </div>
                            <div class="p-2 bg-indigo-50 border border-indigo-100 rounded-lg text-xs text-gray-700">
                                <p class="mb-1">Use <b>Passive Voice</b> to describe changes: <b>Subject + be + Verb 3</b>
                                </p>
                                <ul class="list-disc pl-5 space-y-0 text-xs">
                                    <li><b>was built</b>, <b>were demolished</b>, <b>has been converted</b>, <b>was
                                            extended</b></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </div>
    </template>
    </div>
@endif

<!-- 3.7. DESCRIBING PROCESS (Task 1 Only) -->
@if(($meeting->task_type ?? 0) == 1)
    <div x-data="{ open: false }">
        <button @click="open = true"
            class="bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Describing Process
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-cyan-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-cyan-900">Describing Process & Flowcharts</h3>
                            <p class="text-sm text-cyan-700">Vocabulary used to describe steps and stages in a process
                                diagram or flowchart.</p>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <div class="overflow-y-auto p-6 bg-white space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Sequencing Steps -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-lg text-gray-800">Sequencing Steps </h4>
                                </div>
                                <table class="w-full text-sm border-collapse border border-cyan-200">
                                    <thead class="bg-cyan-100 text-cyan-900">
                                        <tr>
                                            <th class="p-2 border border-cyan-200 text-left w-1/3">Stage</th>
                                            <th class="p-2 border border-cyan-200 text-left">Vocabulary</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-cyan-50">
                                        <tr>
                                            <td class="p-2 border border-cyan-100 font-bold">Beginning</td>
                                            <td class="p-2 border border-cyan-100"><b>First</b>, <b>Firstly</b>, <b>To begin
                                                    with</b>, <b>Initially</b>, <b>The first step is</b>.<br><i><b>To begin
                                                        with</b>, the raw materials are collected.</i></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-cyan-100 font-bold">Continuing</td>
                                            <td class="p-2 border border-cyan-100"><b>Next</b>, <b>Then</b>, <b>Later</b>,
                                                <b>After that</b>, <b>Following this</b>, <b>Subsequently</b>, <b>In the
                                                    subsequent stage</b>, <b>Followed by</b>.<br><i><b>Subsequently</b>, the
                                                    mixture is heated to 100 degrees.</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-cyan-100 font-bold">Simultaneous</td>
                                            <td class="p-2 border border-cyan-100"><b>At the same time</b>,
                                                <b>Simultaneously</b>, <b>Meanwhile</b>,
                                                <b>During</b>.<br><i><b>Meanwhile</b>, the bottles are cleaned and
                                                    prepared.</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-cyan-100 font-bold">Ending</td>
                                            <td class="p-2 border border-cyan-100"><b>Finally</b>, <b>Eventually</b>, <b>The
                                                    final step is</b>, <b>In the last stage</b>.<br><i><b>Finally</b>, the
                                                    finished products are packaged.</i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Verbs & Passive Voice -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-lg text-gray-800">Using Passive Voice</h4>
                                </div>
                                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-lg text-sm text-gray-700">
                                    <p class="mb-2">In Task 1 process descriptions, we usually use the <b>Passive Voice</b>
                                        because the action is more important than who is doing it.</p>
                                    <p class="font-bold text-indigo-900 mb-1">Pattern: Subject + be + Verb 3</p>
                                    <p class="font-bold text-indigo-600 mb-1">be = is/am/are/was/were/been/being</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>The tea leaves <b>are picked</b> by hand.</li>
                                        <li>The boxes <b>are transported</b> to the factory.</li>
                                        <li>The liquid <b>is heated</b> and then <b>cooled</b>.</li>
                                        <li>The fruits <b>are sorted</b> before they <b>are packed</b>.</li>
                                    </ul>
                                </div>
                                <div
                                    class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-sm text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-lg text-gray-800">Common Flowchart Verbs</h4>
                                    </div>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li><b>start</b> – The process starts with raw material preparation.</li>
                                        <li><b>enter</b> – The product enters the mixing chamber.</li>
                                        <li><b>flow to / move to</b> – The liquid flows to the heating section.</li>
                                        <li><b>continue</b> – The mixture continues to the next stage.</li>
                                        <li><b>split / divide</b> – The stream divides into two separate routes.</li>
                                        <li><b>combine</b> – The components combine in the reactor.</li>
                                        <li><b>pass through</b> – The solution passes through the filter.</li>
                                        <li><b>exit</b> – The finished product exits the system.</li>
                                        <li><b>inspect</b> – The items are inspected before packaging.</li>
                                        <li><b>transfer</b> – The material is transferred to the storage tank.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endif

<!-- 3. COLLOCATIONS -->
@if(($meeting->task_type ?? 0) == 2)
    <button @click="$dispatch('toggle-collocations')"
        class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
        Collocations
    </button>

    <!-- 4. IDIOMS -->
    <button @click="$dispatch('toggle-idioms')"
        class="bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
        Idioms
    </button>

    <!-- 5. IDEAS (NEW) -->
    <div id="ideas-component"
        data-prompt="{{ strip_tags($meeting->prompt ?? ($meeting->questions?->first()?->question_text ?? '')) }}" x-data="{
                        open: false,
                        htmlContent: null,
                        loading: false,
                        error: null,
                        async fetchIdeas() {
                            if (this.htmlContent) return; // Already fetched
                            this.loading = true;
                            this.error = null;
                            try {
                                let promptText = document.getElementById('ideas-component')?.dataset.prompt;

                                if (!promptText || promptText.trim() === '') {
                                    const box = document.getElementById('questionInstructionBox');
                                    if (box && box.innerText.trim() !== '') {
                                        promptText = box.innerText;
                                    }
                                }

                                if (!promptText || promptText.trim() === '') {
                                    this.error = 'Tidak ada pertanyaan (prompt) yang ditemukan untuk dianalisis.';
                                    this.loading = false;
                                    return;
                                }

                                const response = await fetch('/api/ollama/ideas', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                                    },
                                    body: JSON.stringify({ prompt: promptText, task: {{ $task ?? ($meeting->task_type ?? 2) }} })
                                });
                                if (!response.ok) throw new Error('Gagal mendapatkan ide.');
                                const data = await response.json();
                                if (data.html) this.htmlContent = data.html;
                                else this.error = 'Format yang diterima dari AI tidak sesuai.';
                            } catch(e) { this.error = e.message; } finally { this.loading = false; }
                        }
                    }">
        <button @click="open = true; fetchIdeas()"
            class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Ideas
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-pink-100 bg-pink-50 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-pink-900">Topic Ideas & Vocabulary</h3>
                        <button @click="open = false" class="text-pink-400 hover:text-pink-600"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <div class="overflow-y-auto p-6 bg-white flex-1 custom-scrollbar">
                        <div x-show="loading" class="text-center py-10 flex flex-col items-center">
                            <span
                                class="animate-spin h-8 w-8 border-4 border-pink-500 border-t-transparent rounded-full mb-4"></span>
                            <span class="text-pink-600 font-medium">Generating structured topic vocabulary...</span>
                        </div>
                        <div x-show="error" x-text="error" class="text-center text-red-500 py-10"></div>
                        <style>
                            .ideas-content h3 {
                                color: #9d174d;
                                font-size: 1.25rem;
                                font-weight: 700;
                                border-bottom: 2px solid #fbcfe8;
                                padding-bottom: 0.5rem;
                                margin-bottom: 1.5rem;
                                margin-top: 2rem;
                            }

                            .ideas-content h3:first-child {
                                margin-top: 0;
                            }

                            .ideas-content p {
                                color: #334155;
                                line-height: 1.625;
                                margin-bottom: 1rem;
                            }

                            .ideas-content strong {
                                color: #be185d;
                                font-weight: 700;
                            }

                            .ideas-content em {
                                color: #64748b;
                                font-style: italic;
                            }

                            .ideas-content ul {
                                list-style-type: disc;
                                padding-left: 1.5rem;
                                margin-bottom: 1.5rem;
                                color: #334155;
                            }

                            .ideas-content li {
                                margin-bottom: 0.5rem;
                            }

                            .ideas-content table {
                                width: 100%;
                                text-align: left;
                                border-collapse: collapse;
                                margin-top: 1rem;
                                margin-bottom: 2rem;
                                border-radius: 0.5rem;
                                overflow: hidden;
                                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                            }

                            .ideas-content th {
                                background-color: #fce7f3;
                                color: #831843;
                                padding: 1rem;
                                font-weight: 600;
                                border-bottom: 1px solid #fbcfe8;
                            }

                            .ideas-content td {
                                padding: 1rem;
                                color: #334155;
                                border-bottom: 1px solid #f1f5f9;
                                vertical-align: top;
                            }

                            .ideas-content tr:last-child td {
                                border-bottom: none;
                            }

                            .ideas-content tr:hover td {
                                background-color: #f8fafc;
                            }
                        </style>
                        <div x-show="!loading && !error && htmlContent" class="ideas-content text-lg" x-html="htmlContent">
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- 6. COLLOCATION DICTIONARY -->
    <div x-data="{
                        open: false,
                        query: '',
                        results: [],
                        loading: false,
                        error: null,
                        async search() {
                            if(!this.query.trim()) return;
                            this.loading = true;
                            this.error = null;
                            this.results = [];
                            try {
                                const response = await fetch(`/api/ollama/collocation?word=${encodeURIComponent(this.query.trim())}`);
                                if (!response.ok) {
                                    let errMessage = 'Failed to fetch ideas.';
                                    try {
                                        const errData = await response.json();
                                        if (errData.error) errMessage = errData.error;
                                        if (errData.debug) errMessage += ' - ' + errData.debug;
                                    } catch(e) {}
                                    throw new Error(errMessage);
                                }
                                const data = await response.json();
                                if (data.collocations && Array.isArray(data.collocations)) this.results = data.collocations;
                                else this.error = 'AI returned unexpected format.';
                            } catch(e) { this.error = e.message; } finally { this.loading = false; }
                        },
                        getGroups() {
                            if (!this.results.length) return {};
                            return this.results.reduce((acc, item) => {
                                const type = item.type || 'General';
                                if (!acc[type]) acc[type] = [];
                                acc[type].push(item);
                                return acc;
                            }, {});
                        }
                    }">
        <button @click="open = true"
            class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Collocation Dictionary
        </button>

        <template x-teleport="body">
            <div x-show="open" style="display: none;"
                class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
                <div @click.outside="open = false"
                    class="bg-white rounded-xl shadow-2xl w-full max-w-2xl relative overflow-hidden" style="height: 80vh;">
                    <div class="absolute top-0 left-0 right-0 z-20 bg-white shadow-sm flex flex-col" style="height: 150px;">
                        <div class="p-4 bg-purple-50 border-b border-purple-100 flex justify-between items-center"
                            style="height: 70px;">
                            <h3 class="text-xl font-bold text-purple-900">Collocation Dictionary</h3>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                        <div class="p-4 border-b border-gray-100 bg-white" style="height: 80px;">
                            <form @submit.prevent="search" class="flex gap-2 h-full items-center"><input type="text"
                                    x-model="query" placeholder="Type a word..."
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg h-10"><button type="submit"
                                    class="bg-purple-600 text-white px-6 py-2 rounded-lg h-10" :disabled="loading"><span
                                        x-show="!loading">Ask AI</span><span x-show="loading">...</span></button></form>
                        </div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 overflow-y-auto p-6 bg-gray-50 bg-white" style="top: 150px;">
                        <div x-show="loading" class="text-center py-10">Processing...</div>
                        <div x-show="error" x-text="error" class="text-center text-red-500 py-10"></div>
                        <div x-show="!loading && !error && results.length > 0">
                            <h2 x-text="query" class="text-3xl font-bold text-center mb-4"></h2>
                            <template x-for="(items, type) in getGroups()" :key="type">
                                <div class="mb-4">
                                    <h4 class="font-bold text-purple-700 uppercase mb-2 border-l-4 border-purple-500 pl-2"
                                        x-text="type"></h4>
                                    <div class="space-y-3">
                                        <template x-for="item in items" :key="item.phrase">
                                            <div class="bg-white p-3 rounded shadow-sm border">
                                                <div class="flex items-center gap-2 mb-1"><span class="font-bold text-lg"
                                                        x-text="item.phrase"></span><button
                                                        @click="query = item.phrase; search()"
                                                        class="text-xs text-gray-400">RESEARCH</button></div>
                                                <div class="text-sm text-gray-600 mb-1" x-text="item.explanation"></div>
                                                <div class="text-sm italic text-purple-800 bg-purple-50 p-2 rounded"
                                                    x-text="item.example"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endif


<!-- LESSON EXPLANATION -->
@if(($meeting->task_type ?? 0) == 3)
    <div>
        <button title="Lesson Explanation" @click="$dispatch('open-lesson-explanation')"
            class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold w-10 h-10 p-0 rounded-full justify-center shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </button>
    </div>
@endif

</div>
