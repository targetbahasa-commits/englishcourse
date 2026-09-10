{{-- Tenses Chart Button Component --}}
<div x-data="{ open: false }">
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
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div @click.outside="open = false"
             class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-white">
                <h3 class="text-xl font-bold text-gray-800">📊 Tenses Chart</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto p-5" style="max-height: 80vh;">
                <img src="{{ asset('images/materials/grammar/tenses-chart.png') }}"
                     alt="Tenses Chart"
                     class="w-full h-auto rounded-lg shadow-md">
            </div>
            <div class="p-4 bg-white border-t border-cyan-100 text-center">
                <p class="text-sm text-gray-600">Gunakan tabel tenses ini sebagai panduan rumus dalam memilih pola kalimat yang tepat.</p>
            </div>
        </div>
    </div>
</div>
