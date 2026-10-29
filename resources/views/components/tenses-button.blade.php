{{-- Tenses Chart Button Component --}}
<div x-data="{ open: false, activeTab: 'matrix' }">
    <button @click="open = true"
            title="Tenses Chart"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold p-2.5 sm:py-2.5 sm:px-4 rounded-full shadow-lg transition hover:scale-105 flex items-center justify-center gap-2 text-sm opacity-70 hover:opacity-100 transition-all duration-300">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        <span class="hidden sm:inline">Tenses Chart</span>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-4"
         style="display: none;"
         @keydown.escape.window="open = false">
        <div @click.outside="open = false"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-blue-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-blue-50">
                <div class="flex items-center gap-3">
                    <span class="bg-tb-primary text-white w-7 h-7 flex items-center justify-center rounded-lg shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </span>
                    <h3 class="text-lg sm:text-xl font-bold text-tb-primary">Tenses Chart</h3>
                    <div class="flex items-center rounded-xl bg-gray-100 p-1 border border-gray-200 text-xs font-semibold">
                        <button type="button" @click="activeTab = 'matrix'"
                                :class="activeTab === 'matrix' ? 'bg-white text-tb-primary shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                                class="px-3 py-1.5 rounded-lg transition">
                            Formula &amp; Matriks
                        </button>
                        <button type="button" @click="activeTab = 'azar'"
                                :class="activeTab === 'azar' ? 'bg-white text-tb-primary shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                                class="px-3 py-1.5 rounded-lg transition">
                            Timeline Chart (Betty Azar)
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto">
                    <a :href="activeTab === 'matrix' ? '{{ asset('images/materials/grammar/tenses-chart.png') }}' : '{{ asset('images/materials/grammar/verb_tense_chart_azar.svg') }}'"
                       target="_blank"
                       class="text-xs font-semibold text-gray-600 hover:text-tb-primary bg-gray-50 hover:bg-gray-100 border border-gray-200 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Tab Baru
                    </a>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="overflow-y-auto p-4 sm:p-6 bg-gray-50 flex items-center justify-center" style="max-height: 80vh;">
                <div x-show="activeTab === 'matrix'" class="w-full flex justify-center">
                    <img src="{{ asset('images/materials/grammar/tenses-chart.png') }}"
                         alt="Tenses Formula Matrix"
                         class="max-w-full h-auto rounded-xl shadow-md border border-gray-200 bg-white">
                </div>
                <div x-show="activeTab === 'azar'" class="w-full" style="display: none;">
                    <x-interactive-azar-tenses-chart :embeddedInModal="true" />
                </div>
            </div>
            <div class="p-3.5 bg-blue-50 border-t border-blue-100 text-center">
                <p class="text-xs text-gray-600">Gunakan bagan timeline dan matriks tenses ini sebagai panduan dalam menentukan tenses kalimat.</p>
            </div>
        </div>
    </div>
</div>
