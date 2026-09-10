<script>
    try {
        // PHP-side debug: Check for JSON errors
        @if(json_last_error() !== JSON_ERROR_NONE)
            console.error("PHP JSON Encoding Error: {{ json_last_error_msg() }}");
        @endif

        var preloadedAdverbs = {!! json_encode($advanced_adverbs ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
        window.advancedAdverbsData = preloadedAdverbs;
        console.log('Advanced Adverbs injected (Safe Mode):', window.advancedAdverbsData);
    } catch (e) {
        console.error('Failed to parse advanced adverbs:', e);
        window.advancedAdverbsData = [];
    }
</script>

<div x-data="{ 
    open: false, 
    search: '', 
    items: window.advancedAdverbsData || [],
    x: window.innerWidth / 2 - 350,
    y: window.innerHeight - 85,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    
    init() {
        // Self-initialize from server data to avoid race conditions
        if (typeof window.advancedAdverbsData !== 'undefined' && Array.isArray(window.advancedAdverbsData)) {
             if (window.advancedAdverbsData.length > 0 && Array.isArray(window.advancedAdverbsData[0])) {
                 // It's grouped by question, show first group (matching practice.blade.php init logic)
                 this.items = window.advancedAdverbsData[0];
             } else {
                 this.items = window.advancedAdverbsData;
             }
             console.log('Advanced Adverbs Modal Initialized with:', this.items.length, 'items');
        }

        // Listen for updates from the main practice component
        window.addEventListener('update-advanced-adverbs', (e) => {
            console.log('Advanced Adverbs Updated:', e.detail);
            this.items = e.detail || [];
        });
    },

    
    startDrag(e) {
        this.dragging = true;
        this.hasMoved = false;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        this.offset.x = clientX - this.x;
        this.offset.y = clientY - this.y;
    },
    doDrag(e) {
        if (this.dragging) {
            this.hasMoved = true;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            this.x = clientX - this.offset.x;
            this.y = clientY - this.offset.y;
        }
    },
    stopDrag() {
        this.dragging = false;
    },
    handleClick() {
        if (!this.hasMoved) {
            this.open = true;
            this.search = '';
        }
    }
}" 
@mousemove.window="doDrag"
@touchmove.window="doDrag"
@mouseup.window="stopDrag"
@touchend.window="stopDrag"
class="fixed z-50 select-none touch-none font-sans" 
x-cloak
:style="`left: ${x}px; top: ${y}px;`">

    <!-- Trigger Button -->
    <button @mousedown="startDrag"
            @touchstart="startDrag"
            @click="handleClick"
            class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-3 transition-all duration-300 transform hover:scale-105 hover:shadow-xl group cursor-move">
        <span class="bg-white/20 p-1.5 rounded-lg group-hover:rotate-12 transition-transform duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </span>
        <span class="font-semibold tracking-wide">Advanced Adverb</span>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[60] flex items-center justify-center p-4 content-center" 
         @click="open = false"
         style="display: none;">
        
        <!-- Modal Content -->
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col pointer-events-auto overflow-hidden" @click.stop>
            
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Advanced Adverbs List</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-200 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" x-model="search" placeholder="Search vocabulary..." 
                           class="w-full pl-10 pr-4 py-2 border border-teal-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    
                    <button x-show="search" @click="search = ''" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Verified Count -->
                <div class="mt-2 text-sm text-gray-600" x-show="search">
                    <span x-text="items.filter(i => search === '' || (i.phrase && i.phrase.toLowerCase().includes(search.toLowerCase())) || (i.meaning && i.meaning.toLowerCase().includes(search.toLowerCase())) || (i.meaning_id && i.meaning_id.toLowerCase().includes(search.toLowerCase()))).length"></span> results found
                </div>
            </div>

            <!-- Scrollable List (Table) -->
            <div x-ref="list" class="overflow-y-auto px-6 pb-6 bg-white overscroll-contain" style="max-height: 60vh;">
                 <table class="w-full text-sm text-left border-collapse mt-4">
                    <thead class="text-white sticky top-0 z-10">
                        <tr>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md w-16 text-center">No.</th>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md">Adverb</th>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md w-1/4">Arti</th>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md w-24 text-center">Level</th>
                            <th class="p-3 border border-teal-600 bg-teal-500 sticky top-0 z-10 shadow-md">Meaning & Example</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, index) in items.filter(i => search === '' || (i.phrase && i.phrase.toLowerCase().includes(search.toLowerCase())) || (i.meaning && i.meaning.toLowerCase().includes(search.toLowerCase())) || (i.meaning_id && i.meaning_id.toLowerCase().includes(search.toLowerCase())))" :key="index">
                            <tr class="odd:bg-white even:bg-white hover:bg-white transition-colors group">
                                <td class="p-3 border border-gray-200 text-center text-gray-500 font-mono" x-text="index + 1"></td>
                                <td class="p-3 border border-gray-200 font-bold text-gray-800 text-base" x-text="item.phrase"></td>
                                <td class="p-3 border border-gray-200 text-gray-700 italic font-medium" x-text="item.meaning_id"></td>
                                <td class="p-3 border border-gray-200 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold tracking-wider"
                                          :class="{
                                            'bg-white text-blue-800 border border-blue-200': item.level === 'B2',
                                            'bg-white text-purple-800 border border-purple-200': item.level === 'C1',
                                            'bg-rose-100 text-rose-800 border border-rose-200': item.level === 'C2'
                                          }" x-text="item.level"></span>
                                </td>
                                <td class="p-3 border border-gray-200">
                                    <div class="mb-2">
                                        <span class="text-gray-800 font-medium leading-relaxed" x-text="item.meaning"></span>
                                    </div>
                                    <div class="text-gray-600 text-xs italic bg-white/50 p-1.5 rounded border border-gray-100 inline-block w-full">
                                        <span class="font-bold text-teal-600 not-italic">Ex:</span> <span x-text="item.example"></span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        
                        <!-- Empty State -->
                        <tr x-show="items.filter(i => search === '' || i.phrase.toLowerCase().includes(search.toLowerCase()) || i.meaning.toLowerCase().includes(search.toLowerCase())).length === 0">
                            <td colspan="5" class="p-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p>No matching adverbs found.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Footer -->
            <div class="p-4 bg-white border-t border-teal-100 text-center text-xs text-gray-500">
                Tip: Use <span class="font-bold text-rose-600">C1/C2</span> words to boost your Lexical Resource score.
            </div>
        </div>
    </div>
</div>
