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
                                        <h2 class="text-xl font-bold text-purple-900">Tips Write From Dictation (WFD)</h2>
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
                                        <h4 class="font-bold text-purple-900">Daftar Kosakata Pembantu (Grammar Fillers)</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>Hafalkan dan tambahkan <em>articles, conjunctions, prepositions,</em> dan <em>modals</em> di bawah ini pada akhir/sela kalimat jika Anda merasa ada kata minor yang terlewat saat dikte:</p>
                                        <div class="bg-purple-50 p-4 rounded-lg font-medium leading-loose border border-purple-100">
                                            a, an, at, the, on, in, by, to, from, with, of, for, into, onto, out, off, and, but, or, so, yet, because, if, that, is, am, are, was, were, be, been, while, when, where, being, have, has, had, do, does, did, can, could, will, would, shall, should, may, might, must, through, about, over, under, across, behind, beside, around, before, after, during, within, without, between, against, although, though, since, unless, ought, this, these, those, some, any, much, many, few, little, who, whom, whose, which, what, whichever, whenever, wherever, maybe.
                                        </div>
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

insert_before_main('resources/views/assignments/pte-academic/listening-write-from-dictation/index.blade.php')
insert_before_main('resources/views/assignments/pte-academic/listening-write-from-dictation/practice.blade.php')
print('Injected tips successfully.')
