@if(!defined('IELTS_READING_ANNOTATIONS_INCLUDED'))
@php define('IELTS_READING_ANNOTATIONS_INCLUDED', true); @endphp
<script>
(function() {
    if (window.__readingAnnotationsLoaded) return;
    window.__readingAnnotationsLoaded = true;

    /* ── Persistence key, same pattern as ReadingAutoSave's answer storage ── */
    function annotationStorageKey() {
        let edition = '{{ $edition ?? "" }}';
        let testId = '{{ $testId ?? "" }}';
        if (!edition || !testId) {
            const match = window.location.pathname.match(/cambridge\/(\d+)\/test-(\d+)\//i);
            if (match) { edition = match[1]; testId = match[2]; }
        }
        edition = edition || '16';
        testId = testId || '1';
        const userId = '{{ Auth::id() ?? "guest" }}';
        return `ielts_reading_annotations_cambridge_${edition}_test_${testId}_user_${userId}`;
    }

    function loadStore() {
        try {
            const raw = localStorage.getItem(annotationStorageKey());
            return raw ? JSON.parse(raw) : {};
        } catch (e) { return {}; }
    }

    function saveStore(store) {
        try { localStorage.setItem(annotationStorageKey(), JSON.stringify(store)); } catch (e) {}
    }

    function getPassageId(node) {
        const el = node.nodeType === Node.TEXT_NODE ? node.parentElement : node;
        const container = el ? el.closest('[id^="passage-"], #questions-panel, [id^="questions-pane"]') : null;
        return container ? (container.id || 'questions-panel') : null;
    }

    /**
     * Converts a Range boundary (node + in-node offset) into a single
     * character offset relative to a passage's full text, and back. Offsets
     * are computed over TEXT NODES ONLY, so they stay valid regardless of
     * which wrapper elements exist around the text at save vs. restore time
     * (translate-word spans, the vocab cross-reference <mark>, an earlier
     * restored highlight) - none of those change the underlying characters.
     */
    function textOffset(container, targetNode, targetOffset) {
        const walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);
        let total = 0, node;
        while ((node = walker.nextNode())) {
            if (node === targetNode) return total + targetOffset;
            total += node.nodeValue.length;
        }
        return total;
    }

    function rangeFromOffsets(container, start, end) {
        const walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);
        let total = 0, node, startNode = null, startOffset = 0, endNode = null, endOffset = 0;
        while ((node = walker.nextNode())) {
            const len = node.nodeValue.length;
            if (startNode === null && start <= total + len) { startNode = node; startOffset = start - total; }
            if (endNode === null && end <= total + len) { endNode = node; endOffset = end - total; break; }
            total += len;
        }
        if (!startNode || !endNode) return null;
        const range = document.createRange();
        range.setStart(startNode, Math.max(0, startOffset));
        range.setEnd(endNode, Math.max(0, endOffset));
        return range;
    }

    let highlightIdCounter = 0;
    const nextHighlightId = () => 'h' + Date.now().toString(36) + '-' + (highlightIdCounter++);
    const HIGHLIGHT_COLORS = { yellow: '#fef08a', green: '#bbf7d0', blue: '#bfdbfe', pink: '#fbcfe8' };

    /**
     * range.surroundContents() throws whenever the range only partially
     * selects an existing element (e.g. it crosses into the vocab
     * cross-reference <mark> around "Grossmann", or a translate-word span
     * left over from the Translate tool) - that used to be caught and
     * silently dropped, so clicking Highlight visibly did nothing. The
     * fallback here extracts the selected fragment and wraps each of its
     * top-level nodes in its own <mark>, which works across those
     * boundaries instead of requiring a single clean text run.
     */
    function wrapRangeInMark(range, bg, highlightId) {
        const makeMark = () => {
            const mark = document.createElement('mark');
            mark.style.backgroundColor = bg;
            mark.style.borderRadius = '2px';
            mark.className = 'user-highlight';
            mark.dataset.highlightId = highlightId;
            return mark;
        };
        try {
            range.surroundContents(makeMark());
            return true;
        } catch (e) {
            try {
                const frag = range.extractContents();
                const wrapperFrag = document.createDocumentFragment();
                Array.from(frag.childNodes).forEach(node => {
                    const mark = makeMark();
                    mark.appendChild(node);
                    wrapperFrag.appendChild(mark);
                });
                range.insertNode(wrapperFrag);
                return true;
            } catch (e2) {
                console.error('[Highlight] Failed to apply highlight:', e2);
                return false;
            }
        }
    }

    /* ── Text highlight ── */
    window.applyAnnotation = function(type, color, customContainer = null) {
        const sel = window.getSelection();
        if (!sel || sel.rangeCount === 0 || sel.isCollapsed) return;
        const range = sel.getRangeAt(0);
        const passageId = customContainer ? (customContainer.id || 'questions-panel') : getPassageId(range.commonAncestorContainer);
        const containerEl = passageId ? document.getElementById(passageId) : null;
        const contentEl = containerEl ? (containerEl.querySelector('.passage-content') || containerEl.querySelector('.px-4, .sm\\:px-6') || containerEl) : null;

        let start = null, end = null;
        if (contentEl) {
            start = textOffset(contentEl, range.startContainer, range.startOffset);
            end = textOffset(contentEl, range.endContainer, range.endOffset);
        }

        const bg = HIGHLIGHT_COLORS[color] || HIGHLIGHT_COLORS.yellow;
        const highlightId = nextHighlightId();
        const applied = wrapRangeInMark(range, bg, highlightId);
        sel.removeAllRanges();

        if (applied && passageId && start !== null && end !== null && end > start) {
            const store = loadStore();
            if (!store[passageId]) store[passageId] = { highlights: [], drawing: null };
            store[passageId].highlights.push({ id: highlightId, start, end, color });
            saveStore(store);
        }
    };

    /* ── Remove highlight ── */
    window.removeHighlight = function(event) {
        let el = event.target;
        while (el && el.tagName !== 'MARK') {
            if (el.classList && (el.classList.contains('passage-content') || el.id === 'questions-panel' || el.id === 'questions-pane')) break;
            el = el.parentElement;
        }
        // Only ever touch highlights WE created - never the vocab
        // cross-reference <mark> the Questions panel injects, which
        // happens to share the same tag.
        if (!el || el.tagName !== 'MARK' || !el.classList.contains('user-highlight')) return;

        const highlightId = el.dataset.highlightId;
        const passageContainer = el.closest('[id^="passage-"], #questions-panel, [id^="questions-pane"]');
        const passageId = passageContainer ? (passageContainer.id || 'questions-panel') : null;

        const marks = highlightId
            ? Array.from(document.querySelectorAll(`mark.user-highlight[data-highlight-id="${highlightId}"]`))
            : [el];

        marks.forEach(mark => {
            const parent = mark.parentNode;
            while (mark.firstChild) parent.insertBefore(mark.firstChild, mark);
            parent.removeChild(mark);
            parent.normalize();
        });

        if (passageId && highlightId) {
            const store = loadStore();
            if (store[passageId] && store[passageId].highlights) {
                store[passageId].highlights = store[passageId].highlights.filter(h => h.id !== highlightId);
                saveStore(store);
            }
        }
    };

    function restoreHighlights(passageEl) {
        const contentEl = passageEl.querySelector('.passage-content') || passageEl.querySelector('.px-4, .sm\\:px-6') || passageEl;
        if (!contentEl) return;
        const store = loadStore();
        const saved = store[passageEl.id || 'questions-panel'];
        if (!saved || !Array.isArray(saved.highlights)) return;

        saved.highlights.forEach(h => {
            const range = rangeFromOffsets(contentEl, h.start, h.end);
            if (!range) return;
            wrapRangeInMark(range, HIGHLIGHT_COLORS[h.color] || HIGHLIGHT_COLORS.yellow, h.id);
        });
    }

    /* ── Drawing canvas (pencil / eraser), persisted as a PNG data URL ──
       Idempotent via canvasControllers: both the eager restore-on-load pass
       below AND each passage's existing Alpine $watch('pencilMode'/
       'eraserMode', ...) call this - whichever runs first creates the
       controller, the other just gets the cached one back. */
    function getMarkAtPoint(clientX, clientY) {
        const marks = document.querySelectorAll('mark.user-highlight');
        for (let i = 0; i < marks.length; i++) {
            const m = marks[i];
            const rects = m.getClientRects();
            for (let j = 0; j < rects.length; j++) {
                const r = rects[j];
                if (clientX >= r.left - 4 && clientX <= r.right + 4 && clientY >= r.top - 4 && clientY <= r.bottom + 4) {
                    return m;
                }
            }
        }
        return null;
    }

    const canvasControllers = new WeakMap();

    window.initDrawingCanvas = function(canvas, customContainer = null) {
        if (canvasControllers.has(canvas)) return canvasControllers.get(canvas);

        const passageContainer = customContainer || canvas.closest('[id^="passage-"], #questions-panel, [id^="questions-pane"]');
        const passageId = passageContainer ? (passageContainer.id || 'questions-panel') : null;
        const ctx = canvas.getContext('2d');
        let drawing = false, mode = 'draw', persistTimer = null;

        const persistDrawing = () => {
            if (!passageId) return;
            clearTimeout(persistTimer);
            persistTimer = setTimeout(() => {
                const store = loadStore();
                if (!store[passageId]) store[passageId] = { highlights: [], drawing: null };
                store[passageId].drawing = canvas.toDataURL('image/png');
                saveStore(store);
            }, 300);
        };

        const resize = () => {
            const parent = canvas.parentElement;
            if (!parent) return;
            const rect = parent.getBoundingClientRect();
            const targetW = Math.max(rect.width, parent.scrollWidth || 0);
            const targetH = Math.max(rect.height, parent.scrollHeight || 0);
            if (targetW === 0 || targetH === 0) return;

            const dpr  = Math.min(window.devicePixelRatio || 1, 1.5);
            const newW = Math.round(targetW * dpr);
            const newH = Math.round(targetH * dpr);
            if (canvas.width === newW && canvas.height === newH) return;

            let snap = null;
            if (canvas.width > 0 && canvas.height > 0) {
                try { snap = ctx.getImageData(0, 0, canvas.width, canvas.height); } catch(e){}
            }
            canvas.width  = newW;
            canvas.height = newH;
            ctx.scale(dpr, dpr);
            if (snap) {
                try { ctx.putImageData(snap, 0, 0); } catch(e){}
            }
        };

        const pos = e => {
            const r = canvas.getBoundingClientRect();
            const clientX = (e.touches && e.touches.length > 0) ? e.touches[0].clientX : e.clientX;
            const clientY = (e.touches && e.touches.length > 0) ? e.touches[0].clientY : e.clientY;
            return { x: clientX - r.left, y: clientY - r.top };
        };

        const start = e => {
            drawing = true;
            const p = pos(e);
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            if (mode === 'erase') {
                const clientX = (e.touches && e.touches.length > 0) ? e.touches[0].clientX : e.clientX;
                const clientY = (e.touches && e.touches.length > 0) ? e.touches[0].clientY : e.clientY;
                const mark = getMarkAtPoint(clientX, clientY);
                if (mark) { window.removeHighlight({ target: mark }); }
            }
        };

        const move = e => {
            if (!drawing) return;
            const p = pos(e);
            if (mode === 'draw') {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = '#2563eb'; ctx.lineWidth = 2.5; ctx.lineCap = 'round'; ctx.lineJoin = 'round';
            } else {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.lineWidth = 24; ctx.lineCap = 'round'; ctx.lineJoin = 'round';

                const clientX = (e.touches && e.touches.length > 0) ? e.touches[0].clientX : e.clientX;
                const clientY = (e.touches && e.touches.length > 0) ? e.touches[0].clientY : e.clientY;
                const mark = getMarkAtPoint(clientX, clientY);
                if (mark) { window.removeHighlight({ target: mark }); }
            }
            ctx.lineTo(p.x, p.y); ctx.stroke(); ctx.beginPath(); ctx.moveTo(p.x, p.y);
        };

        const end = () => {
            if (!drawing) return;
            drawing = false;
            ctx.globalCompositeOperation = 'source-over';
            persistDrawing();
        };

        canvas.addEventListener('mousedown', start); canvas.addEventListener('mousemove', move);
        canvas.addEventListener('mouseup',   end);   canvas.addEventListener('mouseleave', end);
        canvas.addEventListener('touchstart', e => { e.preventDefault(); start(e); }, { passive: false });
        canvas.addEventListener('touchmove',  e => { e.preventDefault(); move(e);  }, { passive: false });
        canvas.addEventListener('touchend',   end);

        resize();

        if (passageId) {
            const saved = loadStore()[passageId];
            if (saved && saved.drawing) {
                const img = new Image();
                img.onload = () => {
                    ctx.save();
                    ctx.setTransform(1, 0, 0, 1, 0, 0);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    ctx.restore();
                };
                img.src = saved.drawing;
            }
        }

        const controller = {
            setMode: m => { mode = m; },
            resize,
            clear: () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                persistDrawing();
            }
        };
        canvasControllers.set(canvas, controller);
        return controller;
    };

    const highlightStyle = document.createElement('style');
    highlightStyle.innerHTML = `
        mark.user-highlight {
            cursor: pointer !important;
            transition: filter 0.15s ease;
        }
        mark.user-highlight:hover {
            filter: brightness(0.93);
        }
    `;
    document.head.appendChild(highlightStyle);


    /* ── Restore highlights + drawings on load, independent of whether the
       student ever toggles Pencil/Highlight again this session ── */
    const restoreAll = () => {
        document.querySelectorAll('[id^="passage-"]').forEach(passageEl => {
            restoreHighlights(passageEl);
            const canvas = passageEl.querySelector('canvas[x-ref="drawingCanvas"]');
            if (canvas) window.initDrawingCanvas(canvas);
        });

        const qPanel = document.getElementById('questions-panel') || document.getElementById('questions-pane');
        if (qPanel) {
            restoreHighlights(qPanel);
            const qCanvas = document.getElementById('questions-drawing-canvas');
            if (qCanvas) window.initDrawingCanvas(qCanvas, qPanel);
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', restoreAll);
    } else {
        restoreAll();
    }
})();
</script>
@endif
