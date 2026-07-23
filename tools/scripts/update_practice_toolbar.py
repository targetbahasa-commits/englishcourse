import re

file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# 1. Update JS logic
old_js = """<div x-data="{
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
        },"""
new_js = """<div x-data="{
        x: 0, 
        y: 0,
        isMobile() { return window.innerWidth < 768; },
        updatePosition() {
            let w = this.$el.offsetWidth > 0 ? this.$el.offsetWidth : 48;
            let h = this.$el.offsetHeight > 0 ? this.$el.offsetHeight : 300;
            if (this.isMobile()) {
                this.x = window.innerWidth - w - 15;
                this.y = (window.innerHeight - h) / 2;
            } else {
                this.x = (window.innerWidth - w) / 2;
                this.y = window.innerHeight - h - 20;
            }
            if (this.y < 15) this.y = 15;
        },
        init() {
            this.x = this.isMobile() ? window.innerWidth - 60 : (window.innerWidth - 400) / 2;
            this.y = this.isMobile() ? window.innerHeight / 2 - 100 : window.innerHeight - 100;
            
            setTimeout(() => this.updatePosition(), 100);
            window.addEventListener('resize', () => this.updatePosition());
        },"""
content = content.replace(old_js, new_js)

# 2. Update wrapper class
old_class = """class="flex flex-col items-center gap-2 sm:gap-3 p-1 cursor-move select-none">"""
new_class = """class="flex flex-col md:flex-row items-center justify-center gap-2 sm:gap-3 cursor-move select-none p-1 md:bg-white/90 md:backdrop-blur-sm md:p-3 md:rounded-2xl md:shadow-2xl md:border md:border-gray-200">"""
content = content.replace(old_class, new_class)

# 3. Describing Trends button
old_trends = """<button @click="open = true"
                class="bg-gray-700 hover:bg-gray-800 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                Describing Trends
            </button>"""
new_trends = """<button @click="open = true"
                class="bg-gray-700 hover:bg-gray-800 text-white font-bold shadow-sm transform transition hover:scale-105 flex items-center justify-center whitespace-nowrap w-10 h-10 p-0 rounded-full md:w-auto md:h-auto md:py-2 md:px-4 md:rounded-xl md:gap-2">
                <svg class="w-5 h-5 block md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span class="hidden md:inline text-sm">Describing Trends</span>
            </button>"""
content = content.replace(old_trends, new_trends)

# 4. Making Comparisons
old_comp = """<button @click="open = true"
                    class="bg-pink-600 hover:bg-pink-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                    Making Comparisons
                </button>"""
new_comp = """<button @click="open = true"
                    class="bg-pink-600 hover:bg-pink-700 text-white font-bold shadow-sm transform transition hover:scale-105 flex items-center justify-center whitespace-nowrap w-10 h-10 p-0 rounded-full md:w-auto md:h-auto md:py-2 md:px-4 md:rounded-xl md:gap-2">
                    <svg class="w-5 h-5 block md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    <span class="hidden md:inline text-sm">Making Comparisons</span>
                </button>"""
content = content.replace(old_comp, new_comp)

# 5. Direction & Maps
old_dir = """<button @click="open = true"
            class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Direction & Maps
        </button>"""
new_dir = """<button @click="open = true"
            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-sm transform transition hover:scale-105 flex items-center justify-center whitespace-nowrap w-10 h-10 p-0 rounded-full md:w-auto md:h-auto md:py-2 md:px-4 md:rounded-xl md:gap-2">
            <svg class="w-5 h-5 block md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span class="hidden md:inline text-sm">Direction & Maps</span>
        </button>"""
content = content.replace(old_dir, new_dir)

# 6. Describing Process
old_proc = """<button @click="open = true"
            class="bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-sm transform transition hover:scale-105 flex items-center gap-2 whitespace-nowrap">
            Describing Process
        </button>"""
new_proc = """<button @click="open = true"
            class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold shadow-sm transform transition hover:scale-105 flex items-center justify-center whitespace-nowrap w-10 h-10 p-0 rounded-full md:w-auto md:h-auto md:py-2 md:px-4 md:rounded-xl md:gap-2">
            <svg class="w-5 h-5 block md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            <span class="hidden md:inline text-sm">Describing Process</span>
        </button>"""
content = content.replace(old_proc, new_proc)

with open(file_path, "w") as f:
    f.write(content)

print("Updates applied.")
