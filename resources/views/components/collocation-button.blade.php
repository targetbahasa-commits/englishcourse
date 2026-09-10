<div x-data="{
    open: false,
    query: '',
    results: [],
    loading: false,
    error: null,
    x: window.innerWidth / 2 - 170,
    y: window.innerHeight - 85,
    isDragging: false,
    startX: 0,
    startY: 0,
    initialX: 0,
    initialY: 0,
    
    init() {
        window.addEventListener('resize', () => {
            this.x = Math.min(this.x, window.innerWidth - 60);
            this.y = Math.min(this.y, window.innerHeight - 60);
        });
    },

    startDrag(e) {
        this.isDragging = true;
        this.startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        this.startY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
        this.initialX = this.x;
        this.initialY = this.y;
    },
    doDrag(e) {
        if (!this.isDragging) return;
        e.preventDefault();
        const currentX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        const currentY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
        const dx = currentX - this.startX;
        const dy = currentY - this.startY;
        this.x = this.initialX + dx;
        this.y = this.initialY + dy;
    },
    stopDrag() {
        this.isDragging = false;
    },
    handleClick() {
        if (!this.isDragging) {
            this.open = true;
        }
    },

    async search() {
        if(!this.query.trim()) return;
        this.loading = true;
        this.error = null;
        this.results = [];
        
        try {
            // Call our Local Brain proxy
            const response = await fetch(`/api/ollama/collocation?word=${encodeURIComponent(this.query.trim())}`);
            
            if (!response.ok) {
                let errMessage = 'Failed to fetch collocations.';
                try {
                    const errData = await response.json();
                    if (errData.error) errMessage = errData.error;
                    if (errData.debug) errMessage += ' - ' + errData.debug;
                } catch(e) {}
                throw new Error(errMessage);
            }

            const data = await response.json();
            
            if (data.collocations && Array.isArray(data.collocations)) {
                this.results = data.collocations;
            } else {
                this.error = 'AI returned unexpected format.';
            }

        } catch(e) {
            this.error = e.message;
            console.error(e);
        } finally {
            this.loading = false;
        }
    },
    
    getGroups() {
        if (!this.results.length) return {};
        // Group by 'type'
        return this.results.reduce((acc, item) => {
            const type = item.type || 'General';
            if (!acc[type]) acc[type] = [];
            acc[type].push(item);
            return acc;
        }, {});
    }
}"
@mousemove.window="doDrag"
@touchmove.window="doDrag"
@mouseup.window="stopDrag"
@touchend.window="stopDrag"
class="fixed z-50"
:style="`left: ${x}px; top: ${y}px;`">
    
    <!-- Floating Button -->
    <button @mousedown="startDrag"
            @touchstart="startDrag"
            @click="handleClick"
            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2 cursor-move select-none touch-none opacity-60 hover:opacity-100 transition-all duration-300">
        Collocation Dictionary
    </button>

    <!-- Modal Backdrop -->
    <template x-teleport="body">
        <div x-show="open"
             x-transition.opacity
             class="fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4"
             style="display: none;">
            
            <!-- Modal Content (Absolute Layout / Inline Styles) -->
            <div @click.outside="open = false"
                 class="bg-white rounded-xl shadow-2xl w-full max-w-2xl relative overflow-hidden z-50"
                 style="height: 80vh;">
                
                <!-- Fixed Header/Search (Absolute Top) -->
                <div class="absolute top-0 left-0 right-0 bg-white shadow-sm flex flex-col z-20" 
                     style="height: 150px;">
                
                <!-- Header -->
            <div class="p-4 bg-purple-50 border-b border-purple-100 flex justify-between items-center" style="height: 70px;">
                <div class="flex items-center gap-2">
                    <h3 class="text-xl font-bold text-purple-900">Collocation Dictionary</h3>
                    <span class="text-xs bg-purple-200 text-purple-800 px-2 py-1 rounded-full opacity-60 hover:opacity-100 transition-all duration-300">Hybrid</span>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Search Area -->
            <div class="p-4 border-b border-gray-100 bg-white" style="height: 80px;">
                <form @submit.prevent="search" class="flex gap-2 h-full items-center">
                    <input type="text" x-model="query" 
                           placeholder="Type a word to ask Llama..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 font-medium disabled:opacity-50" :disabled="loading">
                        <span x-show="!loading">Ask AI</span>
                        <span x-show="loading" class="animate-pulse">Thinking...</span>
                    </button>
                </form>
                </div>
                </div>
                <!-- End Fixed Header -->

            <!-- Results Area (Absolute Bottom) -->
            <div class="absolute left-0 right-0 bottom-0 overflow-y-auto p-6 bg-gray-50 touch-auto select-text"
                 style="top: 150px;">
                <!-- End Fixed Header -->


                
                <!-- Loading -->
                <div x-show="loading" class="flex flex-col items-center justify-center py-10 text-gray-500">
                   <svg class="w-12 h-12 text-purple-600 animate-spin mb-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                   <p class="font-medium">Connecting to Local Llama 3...</p>
                   <p class="text-xs text-gray-400 mt-1">This may take a few seconds.</p>
                </div>

                <!-- Error -->
                <div x-show="error" class="text-center py-8">
                     <div class="text-red-500 text-lg font-bold mb-2">Connection Error</div>
                     <p class="text-gray-600" x-text="error"></p>
                     <p class="text-xs text-gray-400 mt-2">To fix this, check your Groq/Gemini API limits or turn on your Local Llama 3 (via LM Studio or Ollama).</p>
                </div>

                <!-- Content -->
                <div x-show="!loading && !error && results.length > 0" class="space-y-8">
                    
                    <!-- Title -->
                    <div class="text-center pb-2 border-b border-gray-200">
                        <h2 class="text-3xl font-bold text-gray-800" x-text="query"></h2>
                        <p class="text-sm text-gray-500">AI Analysis</p>
                    </div>

                    <!-- Groups -->
                    <template x-for="(items, type) in getGroups()" :key="type">
                        <div>
                             <h4 class="text-md font-bold text-purple-700 uppercase tracking-widest mb-3 border-l-4 border-purple-500 pl-3" x-text="type"></h4>
                             <div class="grid grid-cols-1 gap-4">
                                 <template x-for="item in items" :key="item.phrase">
                                     <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                         <!-- Phrase -->
                                         <div class="flex items-center gap-2 mb-2">
                                             <span class="text-lg font-bold text-gray-900" x-text="item.phrase"></span>
                                             <button @click="query = item.phrase; search()" class="text-gray-300 hover:text-purple-500" title="Research this phrase">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                             </button>
                                         </div>
                                         
                                         <!-- Explanation -->
                                         <p class="text-sm text-gray-600 mb-3 leading-relaxed">
                                             <span class="font-bold text-gray-400 text-xs uppercase mr-1">Why:</span>
                                             <span x-text="item.explanation"></span>
                                         </p>
                                         
                                         <!-- Example -->
                                         <div class="bg-purple-50 p-3 rounded-lg border border-purple-100">
                                              <p class="text-sm text-purple-900 italic font-medium">
                                                  "<span x-text="item.example"></span>"
                                              </p>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                        </div>
                    </template>
                    
                </div>
                
                <!-- Initial -->
                <div x-show="!loading && !error && results.length === 0" class="text-center py-10 text-gray-400">
                    <span class="text-5xl block mb-4">🧠</span>
                    <p class="text-lg">Ask the Brain.</p>
                    <p class="text-sm">Type a word to get deep AI-powered insights.</p>
                </div>

            </div>
        </div>
    </div>
    </template>
</div>
