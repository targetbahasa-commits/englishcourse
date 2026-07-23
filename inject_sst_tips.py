import sys
import re

content = """
            {{-- Floating Tips Button --}}
            <div x-data="{ 
                showTips: false,
                isDragged: false,
                dragging: false,
                x: window.innerWidth / 2 - 50,
                y: window.innerHeight - 100,
                startX: 0,
                startY: 0,
                start(e) {
                    this.dragging = true;
                    this.isDragged = false;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.startX = clientX - this.x;
                    this.startY = clientY - this.y;
                },
                move(e) {
                    if (!this.dragging) return;
                    e.preventDefault();
                    this.isDragged = true;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.x = clientX - this.startX;
                    this.y = clientY - this.startY;
                    
                    // Keep within screen bounds
                    this.x = Math.max(0, Math.min(this.x, window.innerWidth - 60));
                    this.y = Math.max(0, Math.min(this.y, window.innerHeight - 60));
                },
                end() {
                    this.dragging = false;
                    // Reset position if dragged out of bounds
                    if (this.x < 0) this.x = 0;
                    if (this.y < 0) this.y = 0;
                    if (this.x > window.innerWidth - 60) this.x = window.innerWidth - 60;
                    if (this.y > window.innerHeight - 60) this.y = window.innerHeight - 60;
                }
            }" 
            @mousemove.window="move" @mouseup.window="end" @touchmove.window="move" @touchend.window="end">
                <button @click.prevent="if(!isDragged) showTips = true" 
                        @mousedown="start" @touchstart="start"
                        class="fixed z-50 text-white p-4 rounded-full shadow-2xl flex items-center gap-2 select-none"
                        :style="`left: ${x}px; top: ${y}px; background-color: #eab308; touch-action: none;`"
                        :class="dragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                        title="Tips & Strategi">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold hidden md:inline text-white">Tips</span>
                </button>

                {{-- Tips Modal --}}
                <template x-teleport="body">
                    <div x-show="showTips" style="display: none;" class="fixed inset-0 bg-transparent z-[100] flex items-center justify-center p-4">
                        <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                            <div class="flex items-center justify-between p-6 border-b border-purple-100 bg-purple-50 shrink-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-purple-900">Tips Summarize Spoken Text (SST)</h2>
                                        <p class="text-purple-600 text-sm">Panduan dan format jawaban Anda.</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-purple-400 hover:text-purple-600 hover:bg-purple-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-gray-50 flex-1">

                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Syarat</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-2">
                                        <p>Tulis frasa (2 kata atau lebih). Jawaban tidak boleh lebih dari 70 kata.</p>
                                        <p>Frasa adalah gabungan kata yang memiliki makna kesatuan namun tanpa Subjek dan Predikat.</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Template Jawaban</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>
                                            The lecture gives information about many aspects of the effects of <span class="text-amber-600 font-bold">[Phrases 1]</span>. While the impacts of <span class="text-amber-600 font-bold">[Phrases 2]</span>, such as <span class="text-amber-600 font-bold">[Phrases 3]</span>, are important for <span class="text-amber-600 font-bold">[Phrases 4]</span>, the influences of <span class="text-amber-600 font-bold">[Phrases 5]</span>, such as <span class="text-amber-600 font-bold">[Phrases 6]</span>, are remarkable for <span class="text-amber-600 font-bold">[Phrases 7]</span>. Finally, the effects of having <span class="text-amber-600 font-bold">[Phrases 8]</span>, such as <span class="text-amber-600 font-bold">[Phrases 9]</span>, are significant for <span class="text-amber-600 font-bold">[Phrases 10]</span>.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Contoh Jawaban</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>
                                            The lecture gives information about many aspects of the effects of <span class="text-amber-600 font-bold">[climate change on oceans]</span>. While the impacts of <span class="text-amber-600 font-bold">[raising global temperature]</span>, such as <span class="text-amber-600 font-bold">[raising sea levels]</span>, are important for <span class="text-amber-600 font-bold">[marine life]</span>, the influences of <span class="text-amber-600 font-bold">[this environmental issue]</span>, such as <span class="text-amber-600 font-bold">[biodiversity]</span>, are remarkable for <span class="text-amber-600 font-bold">[coastal lives]</span>. Finally, the effects of having <span class="text-amber-600 font-bold">[actions]</span>, such as <span class="text-amber-600 font-bold">[preserving the environment]</span>, are significant for <span class="text-amber-600 font-bold">[protecting the community]</span>.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>
            </div>
"""

def insert_before_main(filepath):
    with open(filepath, 'r') as f:
        file_content = f.read()

    new_content = re.sub(r'(\s*</main>)', content + r'\1', file_content)

    with open(filepath, 'w') as f:
        f.write(new_content)

insert_before_main('resources/views/assignments/pte-academic/summarize-spoken-text/index.blade.php')
insert_before_main('resources/views/assignments/pte-academic/summarize-spoken-text/practice.blade.php')
print('Injected tips successfully.')
