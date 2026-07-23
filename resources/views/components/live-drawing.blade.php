{{--
    ===================================================
    live-drawing.blade.php
    Blade Component: Real-Time Drawing Synchronization
    ===================================================

    Usage: <x-live-drawing /> (include in any Blade layout)

    Modes:
      - SENDER  : URL contains ?live_preview_for={studentId}
                  Admin/Intern draws; canvas state is synced to the student.
      - RECEIVER: Default mode; uses the authenticated student's user ID.
                  Polls the server every 1.5s for new drawing data.

    Transport Strategy:
      1. Primary  → Laravel Echo WebSocket whisper (Reverb / Pusher) — low latency.
      2. Fallback → HTTP API Polling every 1500ms — works when BROADCAST_CONNECTION=null.

    The polling fallback is always active for receivers regardless of WebSocket
    status, ensuring drawings are synced even when the student's page loads
    before the WebSocket channel is established, or when WS is disabled entirely.

    Sync Endpoint (POST /api/live-drawing/sync):
      Body: { targetUserId: int, payload: string }
      payload = canvas.toDataURL('image/png') OR the literal string 'clear'

    Fetch Endpoint (GET /api/live-drawing/fetch/{targetUserId}?last_time={float}):
      Returns: { success: bool, payload?: string, time: float }
      Only sends payload when server has newer data than client's last_time.
--}}

<div id="live-drawing-container"
     x-data="liveDrawingApp()"
     style="position: absolute; pointer-events: none; z-index: 260;"
     @resize.window="resizeCanvas()">

    {{-- =========================================================
         CANVAS OVERLAY
         - Sits on top of the entire page (absolute, fullscreen)
         - pointer-events-none when not in drawing mode so clicks
           pass through to the underlying page content
         ========================================================= --}}
    <canvas id="global-live-drawing-canvas"
            style="display:block; position: absolute; top: 0; left: 0; width: 100%; height: 100%; max-width: none;"
            :class="{
                'pointer-events-none': !explanationMode || mode === 'receiver',
                'pointer-events-auto cursor-crosshair': explanationMode && mode === 'sender'
            }"
            @pointerdown="startDrawing($event)"
            @pointermove="draw($event)"
            @pointerup="stopDrawing($event)"
            @pointerout="stopDrawing($event)"
            @pointercancel="stopDrawing($event)">
    </canvas>

    {{-- =========================================================
         LASER CANVAS OVERLAY
         Used to render fading laser pointer strokes.
         ========================================================= --}}
    <canvas id="laser-live-drawing-canvas"
            class="pointer-events-none"
            style="display:block; position: absolute; top: 0; left: 0; width: 100%; height: 100%; max-width: none; z-index: 261;">
    </canvas>

    {{-- =========================================================
         TEXT INPUT OVERLAY
         Shown when the 'text' tool is used.
         ========================================================= --}}
    <input type="text"
           id="live-drawing-text-input"
           x-show="textInput.visible"
           x-model="textInput.text"
           @keydown.enter="finalizeText()"
           @blur="finalizeText()"
           class="fixed bg-transparent border border-dashed border-gray-400 outline-none px-1"
           :style="`left: ${textInput.px}px; top: ${textInput.py - 12}px; color: ${color}; font-size: 24px; font-family: sans-serif; pointer-events: auto; z-index: 9999; min-width: 150px;`"
           placeholder="Ketik teks..."
           style="transform: translateY(-50%);"
    >

    {{-- =========================================================
         SENDER TOOLBAR
         Only visible to Admin/Intern in sender mode.
         Includes: toggle button + tool bar (pen/highlight/laser/eraser/text)
         ========================================================= --}}
    <div x-show="mode === 'sender'" style="pointer-events: auto;">

        {{-- Toggle button moved to parent Admin window --}}

        {{-- Drawing Toolbar (shown when explanationMode is active, centered bottom) --}}
        <div x-show="explanationMode"
             class="fixed flex items-center gap-4 rounded-full border border-gray-700"
             style="bottom: 104px; left: 50%; transform: translateX(-50%); background: #111827; color: #fff; padding: 12px 24px; z-index: 9999; pointer-events: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.4);">

            {{-- Pen Tool --}}
            <button @click="setTool('pen')"
                    class="flex flex-col items-center transition"
                    title="Pen"
                    :style="tool === 'pen' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span style="font-size:10px;">Pen</span>
            </button>

            {{-- Highlighter Tool --}}
            <button @click="setTool('highlight')"
                    class="flex flex-col items-center transition"
                    title="Stabilo / Highlighter"
                    :style="tool === 'highlight' ? 'color: #FACC15; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                <span style="font-size:10px;">Stabilo</span>
            </button>

            {{-- Text Tool --}}
            <button @click="setTool('text')"
                    class="flex flex-col items-center transition"
                    title="Text"
                    :style="tool === 'text' ? 'color: #10B981; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7V4h16v3M12 4v16M8 20h8"/>
                </svg>
                <span style="font-size:10px;">Teks</span>
            </button>

            {{-- Laser Pointer Tool --}}
            <button @click="setTool('laser')"
                    class="flex flex-col items-center transition"
                    title="Laser Pointer"
                    :style="tool === 'laser' ? 'color: #F87171; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" fill="currentColor"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h10"/>
                </svg>
                <span style="font-size:10px;">Laser</span>
            </button>

            {{-- Eraser Tool --}}
            <button @click="setTool('eraser')"
                    class="flex flex-col items-center transition"
                    title="Eraser"
                    :style="tool === 'eraser' ? 'color: #fff; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L17.5 6.5M6 6l12 12"/>
                </svg>
                <span style="font-size:10px;">Hapus</span>
            </button>

            {{-- Separator --}}
            <div style="width:1px;height:32px;background:#374151;margin:0 8px;"></div>

            {{-- Color Palette (shown for pen / highlight tools) --}}
            <div x-show="tool === 'pen' || tool === 'highlight'" class="flex items-center gap-2">
                <template x-for="c in (tool === 'highlight' ? colors.highlight : colors.pen)" :key="c">
                    <button @click="baseColor = c; updateColor()"
                            class="rounded-full border-2 transition"
                            style="width:24px;height:24px;"
                            :style="'background-color: ' + c + '; border-color: ' + (baseColor === c ? '#fff' : 'transparent') + '; transform: scale(' + (baseColor === c ? '1.2' : '1') + ');'">
                    </button>
                </template>
            </div>

            {{-- Separator --}}
            <div style="width:1px;height:32px;background:#374151;margin:0 8px;"></div>

            {{-- Clear All --}}
            <button @click="clearAllCanvases()"
                    class="flex flex-col items-center"
                    title="Clear All"
                    style="color: #F87171;">
                <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span style="font-size:10px;">Clear All</span>
            </button>
        </div>
    </div>
</div>

<script>
/**
 * Live Drawing AlpineJS Component
 * =================================
 * Registers the `liveDrawingApp` Alpine data factory once.
 *
 * Transport layers:
 *   1. WebSocket whisper (window.Echo)  — real-time, stroke-by-stroke
 *   2. HTTP polling (fetch API)         — every 1500ms, sends full canvas snapshot
 *
 * The polling layer acts as both:
 *   a) A WebSocket fallback when BROADCAST_CONNECTION=null
 *   b) A reliability guarantee even when WebSockets ARE enabled
 *      (catches missed whispers / late-joining students)
 */
(function () {
    function registerLiveDrawing() {
        if (typeof window.Alpine === 'undefined') return;
        if (window._liveDrawingRegistered) return;
        window._liveDrawingRegistered = true;

        Alpine.data('liveDrawingApp', () => ({
            // ── State ──────────────────────────────────────────────────────
            /** 'sender' (Admin) or 'receiver' (Student) */
            mode: 'receiver',
            /** Student user ID being targeted */
            targetUserId: null,
            /** Laravel Echo channel instance */
            channel: null,
            /** Canvas 2D rendering context */
            ctx: null,

            // Drawing state
            isDrawing: false,
            lastX: 0,
            lastY: 0,

            // UI state
            /** Whether the drawing overlay is active */
            explanationMode: false,
            /** Active tool: 'pen' | 'highlight' | 'laser' | 'eraser' */
            tool: 'pen',
            /** Current resolved color (may include rgba for highlight) */
            color: '#EF4444',
            /** Base hex color before opacity conversion */
            baseColor: '#EF4444',
            /** Opacity for highlight tool */
            opacity: 0.35,
            lineWidth: 3,

            /** Available color palettes */
            colors: {
                pen:       ['#EF4444', '#3B82F6', '#10B981', '#FACC15', '#8B5CF6'],
                highlight: ['#FFFF00', '#93C5FD', '#86EFAC', '#F9A8D4', '#FDBA74'],
            },

            /** Laser paths state */
            laserPaths: [],
            laserCtx: null,

            /** Text tool visual state */
            textInput: { visible: false, x: 0, y: 0, px: 0, py: 0, text: '' },

            // Polling state
            /** The microtime timestamp of the last successful fetch */
            lastFetchTime: 0,
            /** setInterval handle for polling */
            pollingInterval: null,
            /** Prevent concurrent sync requests */
            _syncInFlight: false,

            // ── Lifecycle ──────────────────────────────────────────────────

            init() {
                window.addEventListener('message', (e) => {
                    if (e.data && e.data.type === 'TOGGLE_CORET') {
                        this.toggleExplanationMode();
                    }
                });

                const href = window.location.href;

                // Detect sender mode: URL contains ?live_preview_for={id}
                // e.g. /admin/students/91/current-assignment?live_preview_for=42
                const senderMatch = href.match(/live_preview_for=(\d+)/);
                if (senderMatch) {
                    this.mode         = 'sender';
                    this.targetUserId = senderMatch[1];
                    console.log('[LiveDrawing] Mode: SENDER → targeting student ID:', this.targetUserId);
                } else {
                    this.mode         = 'receiver';
                    // Blade renders the authenticated user's ID server-side
                    this.targetUserId = {{ auth()->id() ?? 'null' }};
                    console.log('[LiveDrawing] Mode: RECEIVER → my student ID:', this.targetUserId);
                }

                this.$nextTick(() => {
                    this.initCanvas();
                    this.initWebSocket();

                    // Reposition canvas when page scrolls (tracks .max-w-5xl absolutely)
                    window.addEventListener('scroll', () => this.resizeCanvas(), { passive: true });

                    // Receiver always polls — it's both the primary transport
                    // when WS is disabled, and a reliability layer when WS is enabled.
                    if (this.mode === 'receiver') {
                        this.initPolling();
                    }

                    // Start laser animation loop
                    this.animateLaser();
                });
            },

            // ── Canvas Setup ───────────────────────────────────────────────

            initCanvas() {
                const target = document.querySelector('.max-w-5xl') || document.body;
                const canvasContainer = document.getElementById('live-drawing-container');
                const canvas = document.getElementById('global-live-drawing-canvas');
                const laserCanvas = document.getElementById('laser-live-drawing-canvas');
                
                // Make the canvas container an absolute overlay covering the target element exactly
                canvasContainer.style.position = 'absolute';
                canvasContainer.style.pointerEvents = 'none';
                canvasContainer.style.zIndex = '9998'; // Just below toolbar
                
                const rect = target.getBoundingClientRect();
                canvasContainer.style.left = (rect.left + window.scrollX) + 'px';
                canvasContainer.style.top = (rect.top + window.scrollY) + 'px';
                canvasContainer.style.width = rect.width + 'px';
                canvasContainer.style.height = rect.height + 'px';

                canvas.width  = rect.width;
                canvas.height = rect.height;
                canvas.style.width = rect.width + 'px';
                canvas.style.height = rect.height + 'px';
                canvas.style.maxWidth = 'none';
                
                laserCanvas.width  = rect.width;
                laserCanvas.height = rect.height;
                laserCanvas.style.width = rect.width + 'px';
                laserCanvas.style.height = rect.height + 'px';
                laserCanvas.style.maxWidth = 'none';

                this.ctx = canvas.getContext('2d');
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';

                this.laserCtx = laserCanvas.getContext('2d');
                this.laserCtx.lineCap = 'round';
                this.laserCtx.lineJoin = 'round';
            },

            /** 
             * Update canvas physical size and reposition the overlay 
             * to perfectly track the target container if the window resizes.
             */
            resizeCanvas() {
                const canvas = document.getElementById('global-live-drawing-canvas');
                const laserCanvas = document.getElementById('laser-live-drawing-canvas');
                const canvasContainer = document.getElementById('live-drawing-container');
                const target = document.querySelector('.max-w-5xl') || document.body;
                
                if (!canvas || !this.ctx || !laserCanvas || !this.laserCtx || !canvasContainer || !target) return;

                const rect = target.getBoundingClientRect();
                
                canvasContainer.style.left = (rect.left + window.scrollX) + 'px';
                canvasContainer.style.top = (rect.top + window.scrollY) + 'px';
                canvasContainer.style.width = rect.width + 'px';
                canvasContainer.style.height = rect.height + 'px';

                if (canvas.width !== Math.floor(rect.width) || canvas.height !== Math.floor(rect.height)) {
                    // Save content, resize, and restore
                    const imageData = this.ctx.getImageData(0, 0, canvas.width, canvas.height);
                    
                    canvas.width  = rect.width;
                    canvas.height = rect.height;
                    canvas.style.width = rect.width + 'px';
                    canvas.style.height = rect.height + 'px';
                    canvas.style.maxWidth = 'none';
                    
                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                    this.ctx.putImageData(imageData, 0, 0);

                    laserCanvas.width  = rect.width;
                    laserCanvas.height = rect.height;
                    laserCanvas.style.width = rect.width + 'px';
                    laserCanvas.style.height = rect.height + 'px';
                    laserCanvas.style.maxWidth = 'none';

                    this.laserCtx.lineCap = 'round';
                    this.laserCtx.lineJoin = 'round';
                }
            },

            // ── WebSocket Layer ────────────────────────────────────────────

            /**
             * Attempt to connect to the Laravel Echo private channel.
             * Retries every 500ms if Echo hasn't loaded yet (Vite async).
             * When `_broadcastingEnabled` is false (null broadcaster),
             * this becomes a no-op and polling handles all sync.
             */
            initWebSocket() {
                if (typeof window.Echo === 'undefined') {
                    setTimeout(() => this.initWebSocket(), 500);
                    return;
                }
                if (!this.targetUserId) return;

                // Subscribe to the private channel for this student
                this.channel = window.Echo.private('remote-view.' + this.targetUserId);

                if (this.mode === 'receiver' && window.Echo._broadcastingEnabled) {
                    // Listen for real-time stroke whispers from the sender
                    this.channel.listenForWhisper('live-draw', (e) => {
                        this.handleRemoteDraw(e);
                    });
                    console.log('[LiveDrawing] WebSocket channel subscribed for student:', this.targetUserId);
                }
            },

            /**
             * Whisper a drawing event over the Echo private channel.
             * This is stroke-level real-time sync (pen-up/pen-down/move).
             * Only called when Echo WebSocket is genuinely connected.
             */
            broadcastWhisper(payload) {
                if (
                    this.mode === 'sender' &&
                    this.channel &&
                    window.Echo &&
                    window.Echo._broadcastingEnabled === true
                ) {
                    this.channel.whisper('live-draw', payload);
                }
            },

            // ── HTTP Polling Layer (Fallback + Reliability) ────────────────

            /**
             * Start polling the server every 1500ms for new drawing state.
             *
             * Strategy:
             *  - Send `last_time` → server compares with cached timestamp.
             *  - If server has newer data: receive full canvas snapshot, render it.
             *  - If no new data: only receive current timestamp (no payload).
             *
             * This runs unconditionally for receivers because:
             *  a) It is the ONLY transport when BROADCAST_CONNECTION=null.
             *  b) It guarantees late-joining students catch up even with WS.
             */
            initPolling() {
                if (!this.targetUserId) return;
                if (this.pollingInterval) return; // Prevent double-start

                console.log('[LiveDrawing] Polling started for student:', this.targetUserId);

                this.pollingInterval = setInterval(() => {
                    this.pollDrawingState();
                }, 1500);
            },

            /**
             * Single polling request. Fetches drawing state from the server
             * and renders it if newer than what we've already displayed.
             */
            pollDrawingState() {
                if (!this.targetUserId) return;

                fetch(`/api/live-drawing/fetch/${this.targetUserId}?last_time=${this.lastFetchTime}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (!data.success) return;

                    if (data.time) {
                        this.lastFetchTime = data.time;
                    }

                    // `payload` key is only present when there's new data
                    if (data.payload !== undefined) {
                        this.renderBase64ToCanvas(data.payload);
                    }
                })
                .catch(err => {
                    // Silent fail — polling will retry on next interval
                    console.warn('[LiveDrawing] Poll error:', err.message);
                });
            },

            /**
             * Sync the current canvas snapshot to the server via HTTP POST.
             * Called after the sender lifts the pointer (pointerup) or clears.
             *
             * @param {boolean} forceClear - If true, sends 'clear' payload.
             */
            syncDrawingToServer(forceClear = false) {
                if (!this.targetUserId) return;
                
                if (this._syncInFlight) {
                    this._pendingSync = forceClear ? 'clear' : true;
                    return; // Debounce rapid sync calls by queuing
                }

                const canvas = document.getElementById('global-live-drawing-canvas');
                if (!canvas) return;

                const now = Date.now();
                const laserData = this.laserPaths.map(path => ({
                    points: path.points.map(p => ({
                        x: p.x,
                        y: p.y,
                        age: now - p.time
                    }))
                }));

                const payload = forceClear ? 'clear' : JSON.stringify({
                    image: canvas.toDataURL('image/png'),
                    laserData: laserData
                });

                this._syncInFlight = true;

                fetch('/api/live-drawing/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'Accept':           'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        targetUserId: this.targetUserId,
                        payload:      payload,
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('[LiveDrawing] Synced to server. Time:', data.time);
                    }
                })
                .catch(err => {
                    console.error('[LiveDrawing] Sync error:', err);
                })
                .finally(() => {
                    this._syncInFlight = false;
                    if (this._pendingSync) {
                        const clear = this._pendingSync === 'clear';
                        this._pendingSync = false;
                        this.syncDrawingToServer(clear);
                    }
                });
            },

            // ── Rendering ──────────────────────────────────────────────────

            /**
             * Render a base64 PNG (or 'clear') onto the receiver's canvas.
             * Scales the image to fill the current canvas dimensions so
             * drawings from different screen sizes still look correct.
             *
             * @param {string} base64 - Data URI or 'clear'.
             */
            renderBase64ToCanvas(base64) {
                const canvas = document.getElementById('global-live-drawing-canvas');
                if (!canvas || !this.ctx) return;

                if (base64 === 'clear' || !base64) {
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    return;
                }

                // Handle legacy JSON payload format (backwards compatibility)
                let imageSrc = base64;
                if (base64.startsWith('{')) {
                    try {
                        const parsed = JSON.parse(base64);
                        imageSrc = parsed.image || base64;
                        
                        if (parsed.laserData) {
                            const now = Date.now();
                            this.laserPaths = parsed.laserData.map(path => ({
                                points: path.points.map(p => ({
                                    x: p.x,
                                    y: p.y,
                                    time: now - p.age
                                }))
                            }));
                        }
                    } catch (e) { /* ignore */ }
                }

                const img = new Image();
                img.onload = () => {
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    // Draw at 1:1 scale at origin — canvas overlays the same template
                    this.ctx.drawImage(img, 0, 0);
                };
                img.onerror = () => {
                    console.warn('[LiveDrawing] Failed to decode image payload.');
                };
                img.src = imageSrc;
            },

            // ── Sender UI Controls ─────────────────────────────────────────

            /**
             * Toggle the drawing overlay on/off.
             * On exit, optionally clears the canvas (with confirmation).
             */
            toggleExplanationMode() {
                if (this.textInput.visible) {
                    this.finalizeText();
                }
                
                this.explanationMode = !this.explanationMode;

                if (!this.explanationMode) {
                    // Ask whether to clear drawings when leaving mode
                    if (confirm('Bersihkan coretan saat keluar mode coret-coret?')) {
                        this.executeDraw({ type: 'clear' });
                        this.broadcastWhisper({ type: 'clear' });
                        this.syncDrawingToServer(true); // POST 'clear' to server
                    }
                }
            },

            /** Switch active tool and apply appropriate defaults. */
            setTool(t) {
                if (this.textInput.visible) {
                    this.finalizeText();
                }

                this.tool = t;
                if (t === 'highlight') {
                    this.lineWidth = 25;
                    this.baseColor = this.colors.highlight[0];
                } else if (t === 'eraser') {
                    this.lineWidth = 40;
                } else if (t === 'laser' || t === 'text') {
                    // Doesn't change line width
                } else {
                    this.lineWidth = 3;
                    this.baseColor = this.colors.pen[0];
                }
                this.updateColor();
            },

            /** Clear both the local canvas and sync 'clear' to the server. */
            clearAllCanvases() {
                if (this.mode === 'sender') {
                    if (confirm('Bersihkan semua coretan? Coretan di layar siswa juga akan terhapus.')) {
                        this.executeDraw({ type: 'clear' });
                        this.broadcastWhisper({ type: 'clear' });
                        this.syncDrawingToServer(true);
                    }
                } else {
                    // Receiver can only clear their local view
                    this.executeDraw({ type: 'clear' });
                }
            },

            // ── Color Helpers ──────────────────────────────────────────────

            /**
             * Convert a hex color string to an rgba() string.
             * Used to apply transparency to the highlight tool.
             */
            hexToRgba(hex, alpha) {
                const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                if (!result) return hex;
                const r = parseInt(result[1], 16);
                const g = parseInt(result[2], 16);
                const b = parseInt(result[3], 16);
                return `rgba(${r},${g},${b},${alpha})`;
            },

            /** Recompute `this.color` from `this.baseColor` and `this.tool`. */
            updateColor() {
                if (this.tool === 'highlight') {
                    this.color = this.hexToRgba(this.baseColor, this.opacity);
                } else {
                    this.color = this.baseColor;
                }
            },

            // ── Pointer Event Handlers ─────────────────────────────────────

            /**
             * Return pointer/touch coordinates relative to the canvas.
             */
            getPointerPos(e) {
                const canvas = document.getElementById('global-live-drawing-canvas');
                const rect = canvas.getBoundingClientRect();
                const pageX = e.pageX ?? (e.touches?.[0]?.pageX ?? 0);
                const pageY = e.pageY ?? (e.touches?.[0]?.pageY ?? 0);
                
                return {
                    x: pageX - (rect.left + window.scrollX),
                    y: pageY - (rect.top + window.scrollY),
                };
            },

            /** Pointer pressed down — begin a stroke. */
            startDrawing(e) {
                if (this.mode !== 'sender' || !this.explanationMode) return;
                
                // If they click while text tool is active, finalize any pending text
                if (this.textInput.visible) {
                    this.finalizeText();
                    // If they just clicked outside to blur, don't immediately start a new text box
                    // unless they click again, or let them start a new one right away?
                    // We'll let them start a new one right away if it's the text tool.
                }

                const pos = this.getPointerPos(e);

                if (this.tool === 'laser') {
                    const payload = {
                        type: 'laser_start',
                        x: pos.x, y: pos.y,
                    };
                    this.executeDraw(payload);
                    this.broadcastWhisper(payload);
                    this.isDrawing = true;
                    return;
                }

                if (this.tool === 'text') {
                    this.textInput.visible = true;
                    this.textInput.x = pos.x;
                    this.textInput.y = pos.y;
                    this.textInput.px = e.pageX ?? (e.touches?.[0]?.pageX ?? 0);
                    this.textInput.py = e.pageY ?? (e.touches?.[0]?.pageY ?? 0);
                    this.textInput.text = '';
                    this.$nextTick(() => {
                        document.getElementById('live-drawing-text-input')?.focus();
                    });
                    return;
                }

                this.isDrawing = true;
                this.lastX     = pos.x;
                this.lastY     = pos.y;

                const payload = {
                    type: 'start', tool: this.tool,
                    color: this.color, lineWidth: this.lineWidth,
                    x: pos.x, y: pos.y,
                };
                this.executeDraw(payload);
                this.broadcastWhisper(payload);
            },

            /** Pointer moved — continue a stroke. */
            draw(e) {
                if (this.mode !== 'sender' || !this.explanationMode) return;
                const pos = this.getPointerPos(e);

                // Handle laser pointer movement
                if (this.tool === 'laser' && this.isDrawing) {
                    const payload = {
                        type: 'laser_draw',
                        x: pos.x, y: pos.y,
                    };
                    this.executeDraw(payload);
                    // Throttle laser whispers to every 50ms to avoid flooding
                    if (!this._lastLaserTime || Date.now() - this._lastLaserTime > 50) {
                        this.broadcastWhisper(payload);
                        this._lastLaserTime = Date.now();
                    }
                    
                    if (!this._syncInFlight) {
                        this.syncDrawingToServer();
                    }
                    return;
                }

                if (!this.isDrawing) return;

                const payload = {
                    type: 'draw', tool: this.tool,
                    color: this.color, lineWidth: this.lineWidth,
                    x: pos.x, y: pos.y,
                    lastX: this.lastX, lastY: this.lastY,
                };
                this.executeDraw(payload);
                this.broadcastWhisper(payload);
                this.lastX = pos.x;
                this.lastY = pos.y;
            },

            /**
             * Pointer lifted — end the stroke and capture a full snapshot.
             *
             * After `pointerup`, the canvas has the complete stroke rendered.
             * We capture it as base64 PNG and POST it to /api/live-drawing/sync
             * so that the student's polling will receive the full updated drawing.
             */
            stopDrawing(e) {
                if (this.mode !== 'sender' || !this.explanationMode) return;
                if (!this.isDrawing) return;

                this.isDrawing = false;
                this.broadcastWhisper({ type: 'stop' });

                // ✅ KEY: Capture canvas → base64 PNG → POST to server cache
                // This is the HTTP Polling sync trigger (called on every stroke end)
                this.syncDrawingToServer();
            },

            /** Finalizes the text tool input and draws it to the canvas. */
            finalizeText() {
                if (!this.textInput.visible) return;
                
                this.textInput.visible = false;
                
                const text = this.textInput.text.trim();
                if (!text) {
                    this.textInput.text = '';
                    return;
                }

                const payload = {
                    type: 'text',
                    text: text,
                    color: this.color,
                    fontSize: 24,
                    x: this.textInput.x,
                    y: this.textInput.y,
                };

                this.executeDraw(payload);
                this.broadcastWhisper(payload);
                this.syncDrawingToServer();
                
                this.textInput.text = '';
            },

            // ── Laser Pointer ──────────────────────────────────────────────

            animateLaser() {
                if (!this.laserCtx) {
                    requestAnimationFrame(() => this.animateLaser());
                    return;
                }

                const laserCanvas = document.getElementById('laser-live-drawing-canvas');
                if (!laserCanvas) return;

                const now = Date.now();
                const fadeDuration = 2000;

                this.laserCtx.clearRect(0, 0, laserCanvas.width, laserCanvas.height);

                for (let i = 0; i < this.laserPaths.length; i++) {
                    const path = this.laserPaths[i];
                    
                    if (path.points.length === 1) {
                        const p = path.points[0];
                        const age = now - p.time;
                        if (age <= fadeDuration) {
                            const opacity = Math.max(0, 1 - (age / fadeDuration));
                            this.laserCtx.beginPath();
                            this.laserCtx.arc(p.x, p.y, 3, 0, 2 * Math.PI);
                            this.laserCtx.fillStyle = `rgba(59, 130, 246, ${opacity})`; // Blue
                            this.laserCtx.fill();
                        }
                    } else {
                        for (let j = 1; j < path.points.length; j++) {
                            const p1 = path.points[j - 1];
                            const p2 = path.points[j];
                            
                            const age = now - p2.time;
                            if (age > fadeDuration) continue; // older than 2 seconds

                            // Calculate opacity based on age (1 to 0 over 2 seconds)
                            const opacity = Math.max(0, 1 - (age / fadeDuration));
                            
                            this.laserCtx.beginPath();
                            this.laserCtx.moveTo(p1.x, p1.y);
                            this.laserCtx.lineTo(p2.x, p2.y);
                            this.laserCtx.strokeStyle = `rgba(59, 130, 246, ${opacity})`; // Blue
                            this.laserCtx.lineWidth = 6;
                            this.laserCtx.stroke();
                        }
                    }

                    // Clean up old points
                    path.points = path.points.filter(p => now - p.time <= fadeDuration);
                }

                // Remove paths that have no more active points
                this.laserPaths = this.laserPaths.filter(path => path.points.length > 0);

                requestAnimationFrame(() => this.animateLaser());
            },

            // ── Canvas Drawing Engine ──────────────────────────────────────

            /**
             * Execute a drawing command on the local canvas.
             * Called by BOTH the sender (local feedback) and receiver (remote replay).
             *
             * Payload types:
             *   { type: 'clear' }                   → clearRect entire canvas
             *   { type: 'laser', x, y }             → show laser dot
             *   { type: 'start', tool, color, lineWidth, x, y }
             *   { type: 'draw',  tool, color, lineWidth, x, y, lastX, lastY }
             */
            executeDraw(payload) {
                if (!this.ctx) return;

                if (payload.type === 'clear') {
                    const canvas = document.getElementById('global-live-drawing-canvas');
                    if (canvas) this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    return;
                }

                if (payload.type === 'laser_start') {
                    this.laserPaths.push({
                        points: [{x: payload.x, y: payload.y, time: Date.now()}]
                    });
                    return;
                }

                if (payload.type === 'laser_draw') {
                    if (this.laserPaths.length > 0) {
                        const lastPath = this.laserPaths[this.laserPaths.length - 1];
                        lastPath.points.push({x: payload.x, y: payload.y, time: Date.now()});
                    }
                    return;
                }
                
                const x = payload.x;
                const y = payload.y;

                if (payload.type === 'text') {
                    this.ctx.globalCompositeOperation = 'source-over';
                    this.ctx.fillStyle = payload.color;
                    this.ctx.font = `${payload.fontSize}px sans-serif`;
                    this.ctx.textBaseline = 'middle';
                    this.ctx.fillText(payload.text, x, y);
                    return;
                }

                if (payload.type === 'start') {
                    this.ctx.lineWidth  = payload.lineWidth;
                    this.ctx.strokeStyle = payload.color;
                    this.ctx.lineCap    = payload.tool === 'highlight' ? 'butt'   : 'round';
                    this.ctx.lineJoin   = payload.tool === 'highlight' ? 'bevel'  : 'round';
                    this.ctx.globalCompositeOperation =
                        payload.tool === 'eraser' ? 'destination-out' : 'source-over';
                    this.ctx.beginPath();
                    this.ctx.moveTo(x, y);
                    // Draw a tiny line for single-click dots
                    if (payload.tool !== 'eraser') {
                        this.ctx.lineTo(x + 0.1, y + 0.1);
                        this.ctx.stroke();
                    }
                } else if (payload.type === 'draw') {
                    const lastX = payload.lastX;
                    const lastY = payload.lastY;
                    
                    this.ctx.lineWidth  = payload.lineWidth;
                    this.ctx.strokeStyle = payload.color;
                    this.ctx.globalCompositeOperation =
                        payload.tool === 'eraser' ? 'destination-out' : 'source-over';
                    this.ctx.beginPath();
                    this.ctx.moveTo(lastX, lastY);
                    this.ctx.lineTo(x, y);
                    this.ctx.stroke();
                }
            },

            /**
             * Handle a remote drawing event received via WebSocket whisper.
             * Simply delegates to executeDraw() since the payload format is identical.
             */
            handleRemoteDraw(e) {
                this.executeDraw(e);
            },
        }));
    }

    // Register the component when Alpine.js initializes
    document.addEventListener('alpine:init', registerLiveDrawing);

    // If Alpine is already initialized (e.g., loaded synchronously), register immediately
    if (typeof window.Alpine !== 'undefined') {
        registerLiveDrawing();
    }
})();
</script>
