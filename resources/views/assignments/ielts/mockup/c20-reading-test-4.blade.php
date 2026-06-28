<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test 4 - Cambridge 20 - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
        .dotted-line { border-bottom: 1px dotted #000; display: inline-block; width: 150px; }
        .reading-text p { margin-bottom: 1rem; line-height: 1.8; text-align: justify; }
        .reading-text p.indent { text-indent: 2rem; }
        .reading-text h2, .reading-text h3 { text-align: center; font-weight: bold; margin-bottom: 1.5rem; }
        .highlight-yellow { background-color: rgba(253, 224, 71, 0.4); border-bottom: 2px solid #eab308; }
        .highlight-green { background-color: rgba(134, 239, 172, 0.4); border-bottom: 2px solid #22c55e; }
        .highlight-blue { background-color: rgba(147, 197, 253, 0.4); border-bottom: 2px solid #3b82f6; }
        .highlight-pink { background-color: rgba(249, 168, 212, 0.4); border-bottom: 2px solid #ec4899; }
        [x-cloak] { display: none !important; }
        .drawing-canvas { position: absolute; inset: 0; pointer-events: none; z-index: 50; }
        .drawing-canvas.active { pointer-events: auto; cursor: crosshair; }
    </style>
    <script>
        window.readingTest = function() {
            return {
                activeTool: null,
                activeColor: null,
                isDrawingMode: false,
                penSize: 3,
                
                setTool(tool, color = null) {
                    if (this.activeTool === tool && this.activeColor === color) {
                        this.activeTool = null;
                        this.activeColor = null;
                    } else {
                        this.activeTool = tool;
                        this.activeColor = color;
                        this.isDrawingMode = false;
                    }
                    this.updateCursor();
                },

                toggleDrawing() {
                    this.isDrawingMode = !this.isDrawingMode;
                    if (this.isDrawingMode) {
                        this.activeTool = 'draw';
                        this.activeColor = 'blue';
                        this.initCanvas();
                    } else {
                        this.activeTool = null;
                    }
                    this.updateCursor();
                },

                updateCursor() {
                    const textPane = this.$refs.textPane;
                    const canvas = document.getElementById('drawingCanvas');
                    
                    if (this.isDrawingMode) {
                        textPane.style.cursor = 'crosshair';
                        canvas.classList.add('active');
                    } else if (this.activeTool === 'highlight') {
                        textPane.style.cursor = 'text';
                        canvas.classList.remove('active');
                    } else if (this.activeTool === 'remove_highlight') {
                        textPane.style.cursor = 'pointer';
                        canvas.classList.remove('active');
                    } else {
                        textPane.style.cursor = 'auto';
                        canvas.classList.remove('active');
                    }
                },

                startSelection(e) {
                    if (this.activeTool === 'remove_highlight') {
                        if (e.target.tagName === 'SPAN' && e.target.className.includes('highlight-')) {
                            const text = e.target.innerText;
                            const textNode = document.createTextNode(text);
                            e.target.parentNode.replaceChild(textNode, e.target);
                        }
                    }
                },

                handleMouseUp() {
                    if (this.activeTool !== 'highlight') return;
                    
                    const selection = window.getSelection();
                    if (!selection.rangeCount || selection.isCollapsed) return;

                    const range = selection.getRangeAt(0);
                    const container = range.commonAncestorContainer;
                    
                    if (this.$refs.textPane.contains(container.nodeType === 3 ? container.parentNode : container)) {
                        const span = document.createElement('span');
                        span.className = `highlight-${this.activeColor}`;
                        
                        try {
                            range.surroundContents(span);
                        } catch (e) {
                            console.warn("Complex selection spanning multiple elements. Simplifying.");
                            const text = range.toString();
                            const fragment = range.extractContents();
                            span.appendChild(fragment);
                            range.insertNode(span);
                        }
                        selection.removeAllRanges();
                    }
                },

                initCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    const textPane = this.$refs.textPane;
                    const ctx = canvas.getContext('2d');
                    
                    canvas.width = textPane.clientWidth;
                    canvas.height = window.innerHeight; // Fill viewport height to allow drawing across scroll
                    
                    let isDrawing = false;
                    let lastX = 0;
                    let lastY = 0;

                    const getPos = (e) => {
                        const rect = canvas.getBoundingClientRect();
                        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
                    };

                    const draw = (e) => {
                        if (!isDrawing || !this.isDrawingMode) return;
                        
                        const {x, y} = getPos(e);
                        ctx.beginPath();
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(x, y);
                        ctx.strokeStyle = 'rgba(59, 130, 246, 0.7)'; // blue-500 semantic
                        ctx.lineWidth = this.penSize;
                        ctx.lineCap = 'round';
                        ctx.lineJoin = 'round';
                        ctx.stroke();
                        [lastX, lastY] = [x, y];
                    };

                    canvas.onmousedown = (e) => {
                        if (!this.isDrawingMode) return;
                        isDrawing = true;
                        const {x, y} = getPos(e);
                        [lastX, lastY] = [x, y];
                    };
                    canvas.onmousemove = draw;
                    canvas.onmouseup = () => isDrawing = false;
                    canvas.onmouseout = () => isDrawing = false;
                },

                resizeCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    if(canvas && canvas.width) {
                        const textPane = this.$refs.textPane;
                        const ctx = canvas.getContext('2d');
                        const tempCanvas = document.createElement('canvas');
                        tempCanvas.width = canvas.width;
                        tempCanvas.height = canvas.height;
                        tempCanvas.getContext('2d').drawImage(canvas, 0, 0);
                        
                        canvas.width = textPane.clientWidth;
                        canvas.height = window.innerHeight;
                        ctx.drawImage(tempCanvas, 0, 0);
                    }
                },

                clearCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            };
        };
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 h-screen flex flex-col overflow-hidden" 
      x-data="readingTest()" 
      @mouseup="handleMouseUp" 
      @resize.window="resizeCanvas">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 z-30 relative px-6 py-4 flex-shrink-0">
        <div class="flex items-center justify-between max-w-[1400px] mx-auto pl-14">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                     <h1 class="text-xl font-bold text-gray-800">IELTS Reading Mock Test 4</h1>
                     <p class="text-sm text-gray-500">Cambridge IELTS 20</p>
                </div>
            </div>
            
                <div class="bg-gray-100 p-1.5 rounded-lg flex gap-1 hidden">
                    <!-- Removed passage navigation to match C16 style -->
                </div>

                <!-- Tools Menu -->
                <div class="relative" x-data="{ toolsOpen: false }" @click.away="toolsOpen = false">
                    <button @click="toolsOpen = !toolsOpen" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Tools
                    </button>
                    <div x-show="toolsOpen" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 mb-2">Highlighter</div>
                        <div class="grid grid-cols-4 gap-2 mb-3">
                            <button @click="setTool('highlight', 'yellow')" class="h-8 rounded flex items-center justify-center bg-yellow-200 hover:bg-yellow-300 ring-2 ring-transparent transition" :class="{'ring-yellow-500 shadow-md': activeTool === 'highlight' && activeColor === 'yellow'}"></button>
                            <button @click="setTool('highlight', 'green')" class="h-8 rounded flex items-center justify-center bg-green-200 hover:bg-green-300 ring-2 ring-transparent transition" :class="{'ring-green-500 shadow-md': activeTool === 'highlight' && activeColor === 'green'}"></button>
                            <button @click="setTool('highlight', 'blue')" class="h-8 rounded flex items-center justify-center bg-blue-200 hover:bg-blue-300 ring-2 ring-transparent transition" :class="{'ring-blue-500 shadow-md': activeTool === 'highlight' && activeColor === 'blue'}"></button>
                            <button @click="setTool('highlight', 'pink')" class="h-8 rounded flex items-center justify-center bg-pink-200 hover:bg-pink-300 ring-2 ring-transparent transition" :class="{'ring-pink-500 shadow-md': activeTool === 'highlight' && activeColor === 'pink'}"></button>
                        </div>
                        <button @click="setTool('remove_highlight')" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg flex items-center gap-2" :class="{'bg-gray-100 font-semibold': activeTool === 'remove_highlight'}">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Eraser (Highlights)
                        </button>

                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 mt-2 mb-2">Pen Tool</div>
                        <button @click="toggleDrawing()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg flex items-center justify-between" :class="{'bg-blue-50 text-blue-700 font-semibold': isDrawingMode}">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Draw on Screen
                            </div>
                            <div class="w-8 h-4 bg-gray-200 rounded-full relative transition-colors" :class="{'bg-blue-500': isDrawingMode}">
                                <div class="absolute left-0.5 top-0.5 w-3 h-3 bg-white rounded-full transition-transform" :class="{'translate-x-4': isDrawingMode}"></div>
                            </div>
                        </button>
                        <div x-show="isDrawingMode" class="mt-2 px-3 py-2 bg-gray-50 rounded-lg border border-gray-200">
                             <div class="flex text-xs justify-between mb-1 text-gray-500"><span>Size</span><span x-text="penSize+'px'"></span></div>
                             <input type="range" x-model="penSize" min="1" max="10" class="w-full accent-blue-600 block">
                             <button @click="clearCanvas()" class="mt-2 w-full text-center text-xs text-red-600 hover:text-red-700 font-semibold py-1 border border-red-200 hover:bg-red-50 rounded transition">Clear Drawings</button>
                        </div>
                    </div>
                </div>

                @if(Auth::check() && Auth::user()->isAdmin())
                <div class="relative" x-data="{ adminOpen: false }" @click.away="adminOpen = false">
                    <button @click="adminOpen = !adminOpen" class="px-4 py-2 bg-purple-600 text-white border border-purple-700 rounded-lg hover:bg-purple-700 flex items-center gap-2 font-medium shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Admin
                    </button>
                    <div x-show="adminOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        <button onclick="document.getElementById('uploadAnswerKeyModal').classList.remove('hidden')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-purple-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Upload Answer Key
                        </button>
                    </div>
                </div>
                @endif
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => 20, 'id' => 4]) }}" class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2 font-medium transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Exit
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Split Pane -->
    <div class="flex-1 flex overflow-hidden relative">
        <canvas id="drawingCanvas" class="drawing-canvas"></canvas>
        <div id="highlightArea" class="absolute inset-0 z-0"></div> <!-- Marker area for highlights -->

        <!-- Left Pane: Reading Text -->
        <div class="w-1/2 h-full bg-white border-r border-gray-300 overflow-y-auto relative z-10 custom-scrollbar reading-text shadow-[inset_-10px_0_15px_-10px_rgba(0,0,0,0.05)]"
             id="text-pane"
             @mousedown="startSelection"
             x-ref="textPane">
            
            <div class="max-w-3xl mx-auto px-12 py-16 pb-32">
            <div id="passage-1-section" class="mb-6 mt-4">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>
                <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Georgia O’Keeffe</h3>
                <p>For seven decades, Georgia O’Keeffe (1887–1986) was a major figure in American art. Remarkably, she remained independent from shifting art trends and her work stayed true to her own vision, which was based on finding the essential, abstract forms in nature. With exceptionally keen powers of observation and great finesse with a paintbrush, she recorded subtle nuances of colour, shape, and light that enlivened her paintings and attracted a wide audience.</p>
                <p>Born in 1887 near Sun Prairie, Wisconsin to cattle breeders Francis and Ida O’Keeffe, Georgia was raised on their farm along with her six siblings. By the time she graduated from high school in 1905, she had determined to make her way as an artist. She studied the techniques of traditional painting at the Art Institute of Chicago school (1905) and the Art Students League of New York (1907–8). After attending university and then training college, she became an art teacher and taught in elementary schools, high schools, and colleges in Virginia, Texas, and South Carolina from 1911 to 1918.</p>
                <p>During this period, O’Keeffe began to experiment with creating abstract compositions in charcoal, and produced a series of innovative drawings that led her art in a new direction. She sent some of these drawings to a friend in New York, who showed them to art collector and photographer Alfred Stieglitz in January 1916. Stieglitz was impressed, and exhibited the drawings later that year at his gallery on Fifth Avenue, New York City, where the works of many avant-garde artists and photographers were introduced to the American public.</p>
                <p>With Stieglitz’s encouragement and promise of financial support, O’Keeffe arrived in New York in June 1918 to begin a career as an artist. For the next three decades, Stieglitz vigorously promoted her work in twenty-two solo exhibitions and numerous group installations. The two were married in 1924. The ups and downs of their personal and professional relationship were recorded in Stieglitz’s celebrated black-and-white portraits of O’Keeffe, taken over the course of twenty years (1917–37).</p>
                <p>By the mid-1920s, O’Keeffe was recognized as one of America’s most important and successful artists, widely known for the architectural pictures that dramatically depict the soaring skyscrapers of New York. But most often, she painted botanical subjects, inspired by annual trips to the Stieglitz family summer home. In her magnified images depicting flowers, begun in 1924, O’Keeffe brings the viewer right into the picture.</p>
                <p>Enlarging the tiniest details to fill an entire metre-wide canvas emphasized their shapes and lines and made them appear abstract. Such daring compositions helped establish O’Keeffe’s reputation as an innovative modernist.</p>
                <p>In 1929, O’Keeffe made her first extended trip to the state of New Mexico. It was a visit that had a lasting impact on her life, and an immediate effect on her work. Over the next two decades she made almost annual trips to New Mexico, staying up to six months there, painting in relative solitude, then returning to New York each winter to exhibit the new work at Stieglitz’s gallery. This pattern continued until she moved permanently to New Mexico in 1949.</p>
                <p>There, O’Keeffe found new inspiration: at first, it was the numerous sun-bleached bones she came across in the state’s rugged terrain that sparked her imagination. Two of her earliest and most celebrated Southwestern paintings exquisitely reproduce a cow skull’s weathered surfaces, jagged edges, and irregular openings. Later, she also explored another variation on this theme in her large series of Pelvis pictures, which focused on the contrasts between convex and concave surfaces, and solid and open spaces.</p>
                <p>However, it was the region’s spectacular landscape, with its unusual geological formations, vivid colours, clarity of light, and exotic vegetation, that held the artist’s imagination for more than four decades. Often, she painted the rocks, cliffs, and mountains in striking close-up, just as she had done with her botanical subjects.</p>
                <p>O’Keeffe eventually owned two homes in New Mexico – the first, her summer retreat at Ghost Ranch, was nestled beneath 200-metre cliffs, while the second, used as her winter residence, was in the small town of Abiquiú. While both locales provided a wealth of imagery for her paintings, one feature of the Abiquiú house – the large walled patio with its black door – was particularly inspirational. In more than thirty pictures between 1946 and 1960, she reinvented the patio into an abstract arrangement of geometric shapes.</p>
                <p>From the 1950s into the 1970s, O’Keeffe travelled widely, making trips to Asia, the Middle East, and Europe. Flying in planes inspired her last two major series – aerial views of rivers and expansive paintings of the sky viewed from just above clouds. In both series, O’Keeffe increased the size of her canvases, sometimes to mural proportions, reflecting perhaps her newly expanded view of the world. When in 1965 she successfully translated one of her cloud motifs to a monumental canvas measuring 6 metres in length (with the help of assistants), it was an enormous challenge and a special feat for an artist nearing eighty years of age.</p>
                <p>The last two decades of the artist’s life were relatively unproductive as ill health and blindness hindered her ability to work. O’Keeffe died in 1986 at the age of ninety-eight, but her rich legacy of some 900 paintings has continued to attract subsequent generations of artists and art lovers who derive inspiration from these very American images.</p>
            </div>

            <!-- PASSAGE 2 TEXT -->
            <div id="passage-2-section" class="mb-6 mt-10">
                <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Adapting to the effects of climate change</h3>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">A</p>
                    <p class="mb-4">All around the world, nations are already preparing for, and adapting to, climate change and its impacts. Even if we stopped all CO2 emissions tomorrow, we would continue to see the impact of the CO2 already released since industrial times, with scientists forecasting that global warming would continue for around 40 years. In the meantime, ice caps would continue to melt and sea levels rise. Some countries and regions will suffer more extreme impacts from these changes than others. It’s in these places that innovation is thriving.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">B</p>
                    <p class="mb-4">In Miami Beach, Florida, USA, seawater isn’t just breaching the island city’s walls, it’s seeping up through the ground, so the only way to save the city is to lift it up above sea level. Starting in the lowest and most vulnerable neighbourhoods, roads have been raised by as much as 61 centimetres. The elevation work was carried out as part of Miami Beach’s ambitious but much-needed stormwater-management programme. In addition to the road adaptations, the city has set up new pumps that can remove up to 75,000 litres of water per minute. In the face of floods, climate-mitigation strategies have often been overlooked, says Yanira Pineda, a senior sustainability coordinator. She knows that they’re essential and that the job is far from over. ‘We know that in 20, 30, 40 years, we’ll need to go back in there and adjust to the changing environment,’ she says.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">C</p>
                    <p class="mb-4">Seawalls are a staple strategy for many coastal communities, but on the soft, muddy northern shores of Java, Indonesia, they frequently collapse, further exacerbating coastal erosion. There have been many attempts to restore the island’s coastal mangroves: ecosystems of trees and shrubs that help defend coastal areas by trapping sediment in their net-like root systems, elevating the sea bed and dampening the energy of waves and tidal currents. But Susanna Tol of the not-for-profit organisation Wetlands International says that, while hugely popular, the majority of mangrove-planting projects fail. So, Wetlands International started out with a different approach, building semi-permeable dams, made from bamboo poles and brushwood, to mimic the role of mangrove roots and create favourable conditions for mangroves to grow back naturally. The programme has seen moderate success, mainly in areas with less subsidence. ‘Unfortunately, traditional infrastructure is often single-solution focused,’ says Tol. ‘For long-term success, it’s critical that we transition towards multifunctional approaches that embed natural processes and that engage and benefit communities and local decision-makers.’</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">D</p>
                    <p class="mb-4">As the floodwaters rose in the rice fields of the Mekong Delta in September 2018, four small houses rose with them. Homes in this part of Vietnam are traditionally built on stilts but these ones had been built to float. The modifications were made by the Buoyant Foundation Project, a not-for-profit organisation that has been researching and retrofitting amphibious houses since 2006. ‘When I started this,’ explains founder Elizabeth English, ‘climate change was not on the tip of everybody’s tongue, but this technology is becoming necessary in places that didn’t previously need it.’ It’s much cheaper than permanently elevating houses, English explains – about a third of what it would cost to completely replace a building’s foundations. It also avoids the problem of taller houses being at greater risk from wind damage. Another plus comes from the fact that amphibious structures can be sensitively adapted to meet cultural needs and match the kind of houses that are already common in a community.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">E</p>
                    <p class="mb-4">Bangladesh is especially vulnerable to climate change. Most of the country is less than a metre above sea level and 80 per cent of its land lies on floodplains. ‘Almost 35 million people living on the coastal belt of Bangladesh are currently affected by soil and water salinity,’ says Raisa Chowdhury of the international development organisation ICCO Cooperation. Rather than fighting against it, one project is helping communities adapt to salt-affected soils. ICCO Cooperation has been working with 10,000 farmers in Bangladesh to start cultivating naturally salt-tolerant crops in the region. Certain varieties of carrot, potato, kohlrabi, cabbage and beetroot have been found to be better suited to salty soil than the rice and wheat that is typically grown there. Chowdhury says that the results are very visible, comparing a barren plot of land to the ‘beautiful, lush green vegetable garden’ sitting beside it, in which he and his team have been working with the farmers. Since the project began, farmers trained in saline agriculture have reported increases of two to three more harvests per year.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">F</p>
                    <p class="mb-4">Greg Spotts from Los Angeles (LA) in the USA is chief sustainability officer of the city’s street services department. He leads the Cool Streets LA programme, a series of pilot projects, which include the planting of trees and the installation of a ‘cool pavement’ system, designed to help reach the city’s goal of bringing down its average temperature by 1.5°C. ‘Urban cooling is literally a matter of life and death for our future in LA,’ says Spotts. Using a Geographic Information System data mapping tool, the programme identified streets with low tree canopy cover in three of the city’s neighbourhoods and covered them with a light-grey, light-reflecting coating, which had already been shown to lower road surface temperature in Los Angeles by 6°C. Spotts says one of these streets, in the Winnetka neighbourhood of San Fernando Valley, can now be seen as a pale crescent, the only cool spot on an otherwise red thermal image, from the International Space Station.</p>
                </div>
            </div>

            <!-- PASSAGE 3 TEXT -->
            <div id="passage-3-section" class="mb-6 mt-10">
                <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">A new role for livestock guard dogs</h3>
                <h4 class="font-normal italic text-center mb-6">Livestock guard dogs, traditionally used to protect farm animals from predators, are now being used to protect the predators themselves</h4>
                
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">A</p>
                    <p class="mb-4">For thousands of years, livestock guard dogs worked alongside shepherds to protect their sheep, goats and cattle from predators such as wolves and bears. But in the 19th and 20th centuries, when such predators were largely exterminated, most guard dogs lost their jobs. In recent years, however, as increased efforts have been made to protect wild animals, predators have become more widespread again. As a result, farmers once more need to protect their livestock, and guard dogs are enjoying an unexpected revival.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">B</p>
                    <p class="mb-4">Today there are around 50 breeds of guard dogs on duty in various parts of the world. These dogs are raised from an early age with the animals they will be watching and eventually these animals become the dog’s family. The dogs will place themselves between the livestock and any threat, barking loudly. If necessary, they will chase away predators, but often their mere presence is sufficient. ‘Their initial training is to make them understand that livestock is going to be their life,’ says Dan Macon, a shepherd with three guard dogs. ‘A fluffy white puppy is fun to be around, but too much human affection makes it a great dog for guarding the front porch, rather than a great livestock guard dog.’</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">C</p>
                    <p class="mb-4">The evidence indicates that guard dogs are highly effective. For example, in Portugal, biologist Silvia Ribeiro has found that more than 90 per cent of the farmers participating in a programme to train and use guard dogs to protect their herds against attack from wolves rate the performance of the dogs as very good or excellent. In a study carried out in Australia by Linda van Bommel and Chris Johnson at the University of Tasmania, more than 65 per cent of herders reported that predation stopped completely after they got the dogs, and almost all the rest saw a decrease in attacks. ‘If they are managed and used properly, livestock guard dogs are the most efficient control method that we have in terms of the amount of livestock that they save from predation,’ says van Bommel.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">D</p>
                    <p class="mb-4">But today’s guard dogs also have a new role – to help preserve the predators. It is hoped that reductions in livestock losses can make farmers more tolerant of predators and less likely to kill them. In Namibia, more than 90 per cent of cheetahs live outside protected areas, close to humans raising livestock. As a result, the cheetahs are often held responsible for animal losses, and large numbers have been killed by farmers. When guard dogs were introduced, more than 90 per cent of farmers reported a dramatic reduction in livestock losses, and said that as a result they were less likely to kill predators. Julie Young, at Utah State University in the US, believes this result applies widely. ‘There is common ground from the livestock perspective and from the conservation perspective,’ she says. ‘If ranchers don’t have a dead cow, they will not make a call to apply for a permit to kill a wolf.’</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">E</p>
                    <p class="mb-4">Looking at all the published evidence, Bethany Smith at Nottingham Trent University in the UK found that up to 88 per cent of farmers said they no longer killed predators after using dogs – but warned that such self-reported results must be taken with a pinch of salt. What’s more, it is possible that livestock guard dogs merely displace predators to unprotected neighbouring properties, where their fate isn’t recorded. ‘In some regions, we work with almost every farmer, but in others only one or two have dogs,’ says Ribeiro. ‘If we are not working with everybody, we are transferring the wolf pressure to the neighbour’s herd and he can use poison and kill an entire pack of wolves.’</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">F</p>
                    <p class="mb-4">Another concern is whether there may be unintended ecological effects of using guard dogs. Studies suggest that reducing deaths of one type of predator may have a negative impact on other species. The extent of this problem isn’t known, but the consequences are clear in Namibia. Cheetahs aren’t the only species that cause sheep and goat losses there: other predators also attack livestock. In 2015, researchers reported that in spite of the impact farmers obtaining guard dogs had on cheetahs, the number of jackals killed by dogs and people actually increased. Guard dogs have other ecological impacts too. They have been found to spread diseases to wild animals, including endangered Ethiopian wolves. They may also compete with other carnivores for food. And by creating a ‘landscape of fear’, their mere presence can influence the behaviour of prey animals.</p>
                </div>
                <div class="flex gap-4 mb-4">
                    <p class="font-bold text-lg">G</p>
                    <p class="mb-4">The evidence so far, however, indicates that these consequences aren’t always negative. Guard dogs can deliver unexpected benefits by protecting vulnerable wildlife from predators. For example, their presence has been found to protect birds which build their nests on the ground in fields, where foxes would normally raid them. Indeed, Australian researchers are now using dogs to enhance biodiversity and create refuges for species threatened by predation. So if we can get this right, there may be a bright future for guard dogs in promoting harmonious coexistence between humans and wildlife.</p>
                </div>
            </div>
            </div>
        </div>

        <!-- Right Pane: Questions -->
        <div class="w-1/2 h-full bg-[#f8fafc] overflow-y-auto relative z-10 custom-scrollbar" id="questions-pane" x-ref="questionsPane">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">
                <!-- PASSAGE 1 QUESTIONS -->
            <div class="mb-16">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    
                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The life and work of Georgia O’Keeffe</h4>
                        <div class="space-y-4 text-gray-800 leading-loose">
                            <div class="flex items-center gap-2">
                                <span>• studied art, then worked as a</span>
                                <span class="font-bold text-blue-600">1</span>
                                <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                <span>in various places in the USA</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>• created drawings using</span>
                                <span class="font-bold text-blue-600">2</span>
                                <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                <span>which were exhibited in New York City</span>
                            </div>
                            <div class="flex flex-col gap-2">
                                <span>• moved to New York and became famous for her paintings of the city’s</span>
                                <div class="flex gap-2">
                                    <span class="font-bold text-blue-600">3</span>
                                    <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>• produced a series of innovative close-up paintings of</span>
                                <span class="font-bold text-blue-600">4</span>
                                <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                            </div>
                            <div class="flex flex-col gap-2">
                                <span>• went to New Mexico and was initially inspired to paint the many</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-blue-600">5</span>
                                    <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                    <span>that could be found there</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <span>• continued to paint various features that together formed the dramatic</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-blue-600">6</span>
                                    <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                    <span>of New Mexico for over forty years</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 border-t border-dashed pt-4 mt-4">
                                <span>• travelled widely by plane in later years, and painted pictures of clouds and</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-blue-600">7</span>
                                    <input type="text" class="border border-gray-400 outline-none px-2 py-1 w-32 bg-transparent focus:border-blue-500 font-bold text-center shadow-inner rounded-sm">
                                    <span>seen from above</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        @php
                        $q8_13 = [
                            "8" => "Georgia O’Keeffe’s style was greatly influenced by the changing fashions in art over the seven decades of her career.",
                            "9" => "When O’Keeffe finished high school, she had already made her mind up about the career that she wanted.",
                            "10" => "Alfred Stieglitz first discovered O’Keeffe’s work when she sent some abstract drawings to his gallery in New York City.",
                            "11" => "O’Keeffe was the subject of Stieglitz’s photographic work for many years.",
                            "12" => "O’Keeffe’s paintings of the patio of her house in Abiquiú were among the artist’s favourite works.",
                            "13" => "O’Keeffe produced a greater quantity of work during the 1950s to 1970s than at any other time in her life."
                        ];
                        @endphp
                        @foreach($q8_13 as $num => $text)
                        <div class="flex items-start gap-4">
                            <span class="font-bold mt-1 text-blue-600">{{ $num }}</span>
                            <div class="flex-1">
                                <p class="mb-2">{{ $text }}</p>
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="TRUE">TRUE</option>
                                                <option value="FALSE">FALSE</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PASSAGE 2 QUESTIONS -->
            <div class="mt-8 mb-2">
                <div class="flex justify-center mb-4">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                </div>
            </div>
            
            <div class="mb-16 border-t border-gray-300 pt-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–17</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six paragraphs, <strong>A–F</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Which paragraph contains the following information?</p>

                    <div class="space-y-4 text-sm mt-4">
                        @php
                        $q14_17 = [
                            "14" => "how a type of plant functions as a natural protection for coastlines",
                            "15" => "a prediction about how long it could take to stop noticing the effects of climate change",
                            "16" => "a reference to the fact that a solution is particularly cost-effective",
                            "17" => "a mention of a technology used to locate areas most in need of intervention"
                        ];
                        @endphp
                        @foreach($q14_17 as $num => $text)
                        <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <span class="font-bold mt-1 text-blue-600">{{ $num }}</span>
                            <div class="flex-1 flex items-start gap-4 justify-between">
                                <p class="text-gray-800 leading-relaxed max-w-sm">{{ $text }}</p>
                                <div class="relative w-28 flex-none">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(range('A', 'F') as $char)
                                        <option value="{{ $char }}">{{ $char }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 18–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm space-y-4">
                        <p class="text-gray-800 leading-loose"><span class="font-bold text-blue-600 mr-1">18</span> The stormwater-management programme in Miami Beach has involved the installation of efficient <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> .</p>
                        <p class="text-gray-800 leading-loose"><span class="font-bold text-blue-600 mr-1">19</span> The construction of <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> was the first stage of a project to ensure the success of mangroves in Indonesia.</p>
                        <p class="text-gray-800 leading-loose"><span class="font-bold text-blue-600 mr-1">20</span> As a response to rising floodwaters in the Mekong Delta, a not-for-profit organisation has been building houses that can <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> .</p>
                        <p class="text-gray-800 leading-loose"><span class="font-bold text-blue-600 mr-1">21</span> Rising sea levels in Bangladesh have made it necessary to introduce various <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> that are suitable for areas of high salt content.</p>
                        <p class="text-gray-800 leading-loose"><span class="font-bold text-blue-600 mr-1">22</span> A project in LA has increased the number of <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> on the city’s streets.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23–26</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Look at the following statements (Questions 23–26) and the list of people below. Match each statement with the correct person, <strong>A–E</strong>.</p>
                    
                    <div class="border border-gray-300 rounded p-4 bg-gray-50 text-sm mb-5 inline-block">
                        <p class="font-bold text-center mb-2">List of People</p>
                        <div class="space-y-1">
                            <div><span class="font-bold">A</span>&nbsp; Yanira Pineda</div>
                            <div><span class="font-bold">B</span>&nbsp; Susanna Tol</div>
                            <div><span class="font-bold">C</span>&nbsp; Elizabeth English</div>
                            <div><span class="font-bold">D</span>&nbsp; Raisa Chowdhury</div>
                            <div><span class="font-bold">E</span>&nbsp; Greg Spotts</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Person</th>
                                </tr>
                            </thead>
                            <tbody>
                        @php
                        $q23_26 = [
                            "23" => "It is essential to adopt strategies which involve and help residents of the region.",
                            "24" => "Interventions which reduce heat are absolutely vital for our survival in this location.",
                            "25" => "More work will need to be done in future decades to deal with the impact of rising water levels.",
                            "26" => "The number of locations requiring action to adapt to flooding has grown in recent years."
                        ];
                        @endphp
                            @foreach($q23_26 as $num => $text)
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $text }}</td>
                                <td class="py-3 px-3 text-center">
                                    <div class="relative inline-block w-full">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>-</option>
                                            @foreach(range('A', 'E') as $char)
                                            <option value="{{ $char }}">{{ $char }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PASSAGE 3 QUESTIONS -->
            <div class="mt-8 mb-2">
                <div class="flex justify-center mb-4">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                </div>
            </div>

            <div class="mb-16 border-t border-gray-300 pt-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–31</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 3 has seven paragraphs, <strong>A–G</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Which paragraph contains the following information?</p>

                    <div class="space-y-4 text-sm mt-4">
                        @php
                        $q27_31 = [
                            "27" => "an example of how one predator has been protected by the introduction of livestock guard dogs",
                            "28" => "an optimistic suggestion about the possible positive developments in the use of livestock guard dogs",
                            "29" => "a description of how the methods used by livestock guard dogs help to keep predators away",
                            "30" => "claims by different academics that the use of livestock guard dogs is a successful way of protecting farmers' herds",
                            "31" => "a reference to how livestock guard dogs gain their skills"
                        ];
                        @endphp
                        @foreach($q27_31 as $num => $text)
                        <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <span class="font-bold mt-1 text-blue-600">{{ $num }}</span>
                            <div class="flex-1 flex items-start gap-4 justify-between">
                                <p class="text-gray-800 leading-relaxed max-w-sm">{{ $text }}</p>
                                <div class="relative w-28 flex-none">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(range('A', 'G') as $char)
                                        <option value="{{ $char }}">{{ $char }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 32–36</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Look at the following statements (Questions 32–36) and the list of people below. Match each statement with the correct person, <strong>A–E</strong>.</p>

                    <div class="border border-gray-300 rounded p-4 bg-gray-50 text-sm mb-5 inline-block">
                        <p class="font-bold text-center mb-2">List of People</p>
                        <div class="space-y-1">
                            <div><span class="font-bold">A</span>&nbsp; Dan Macon</div>
                            <div><span class="font-bold">B</span>&nbsp; Silvia Ribeiro</div>
                            <div><span class="font-bold">C</span>&nbsp; Linda van Bommel</div>
                            <div><span class="font-bold">D</span>&nbsp; Julie Young</div>
                            <div><span class="font-bold">E</span>&nbsp; Bethany Smith</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [32, "The use of guard dogs may save the lives of both livestock and wild animals."],
                                    [33, "Claims of a change in behaviour from those using livestock guard dogs may not be totally accurate."],
                                    [34, "There may be negative results if the use of livestock guard dogs is not sufficiently widespread."],
                                    [35, "Livestock guard dogs are the best way of protecting farm animals, as long as the dogs are appropriately handled."],
                                    [36, "Teaching a livestock guard dog how to do its work needs a different focus from teaching a house guard dog."]
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(range('A', 'E') as $char)
                                                <option value="{{ $char }}">{{ $char }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">Unintended ecological effects of using guard dogs</h4>
                        <p class="text-gray-800 leading-loose mb-4">In Namibia, livestock guard dogs have been used to protect domestic animals from attacks by cheetahs. This has led to a rise in the deaths of other predators, particularly <span class="font-bold text-blue-600 mr-1">37</span> <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> . In addition, it has been suggested that the dogs could have <span class="font-bold text-blue-600 mr-1">38</span> <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> which may affect other species, and that they may reduce the amount of <span class="font-bold text-blue-600 mr-1">39</span> <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> available to certain wild animals.</p>
                        <p class="text-gray-800 leading-loose">On the other hand, these dogs may help birds by protecting their nests. These might otherwise be threatened by predators such as <span class="font-bold text-blue-600 mr-1">40</span> <input type="text" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400"> .</p>
                    </div>
                </div>
            </div>
            
            </div>
        </div>
    </div>

    <!-- Modals -->
    @if(Auth::check() && Auth::user()->isAdmin())
    <div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-auto relative">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Upload Answer Key</h3>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => 20, 'id' => 4]) }}" method="POST">
                @csrf
                <div class="mb-6">
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key Content</label>
                     <textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1. teacher\n2. charcoal..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition shadow-sm">Save Key</button>
                </div>
            </form>
        </div>
    </div>
    @endif


</body>
</html>
