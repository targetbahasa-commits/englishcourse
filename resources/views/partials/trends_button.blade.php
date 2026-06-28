<div x-data="{
    open: false,
    x: window.innerWidth / 2 + 370,
    y: window.innerHeight - 85,
    dragging: false,
    offset: { x: 0, y: 0 },
    hasMoved: false,
    init() {
        window.addEventListener('resize', () => {
            this.x = Math.min(this.x, window.innerWidth - 60);
            this.y = Math.min(this.y, window.innerHeight - 60);
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
        }
    }
}"
@mousemove.window="doDrag"
@touchmove.window="doDrag"
@mouseup.window="stopDrag"
@touchend.window="stopDrag"
class="fixed z-50 select-none touch-none"
:style="`left: ${x}px; top: ${y}px;`">
    <button @mousedown="startDrag"
            @touchstart="startDrag"
            @click="handleClick"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transform transition hover:scale-105 flex items-center gap-2 cursor-move">
        <span>📈</span> Trends Vocab
    </button>

    <!-- Modal -->
    <div x-show="open" 
         style="display: none;"
         class="fixed inset-0 bg-black bg-opacity-75 z-[60] flex items-center justify-center p-4"
         x-transition.opacity>
        
        <div @click.outside="open = false" class="relative max-w-5xl max-h-[90vh] bg-white rounded-xl shadow-2xl overflow-auto">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 z-10 bg-white/50 rounded-full p-1">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img src="{{ asset('images/materials/ielts-writing/trends_vocabulary.png') }}" alt="Trends Vocabulary" class="w-full h-auto block">
        </div>
    </div>
</div>
