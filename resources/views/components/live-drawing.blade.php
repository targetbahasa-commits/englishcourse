{{--
    ===================================================
    live-drawing.blade.php
    Blade Component: Collaborative Whiteboard ("Coret-Coret")
    ===================================================

    Usage: <x-live-drawing /> (include in any Blade layout)

    Everyone with access to a "room" (a student's own assignment/meeting page)
    can BOTH draw AND see everyone else's strokes on the same canvas - this is
    not a one-way broadcast. Room resolution:
      - URL contains ?live_preview_for={studentId} → room = that student
        (used by Admin/Teacher "Live Student View" monitoring).
      - Otherwise → room = the currently authenticated user's own ID
        (a student on their own page, or an admin/teacher testing directly).

    Access is enforced server-side in LiveDrawingController: a user may only
    read/write a room that is their own, or if their role is admin/teacher/intern.

    Transport Strategy:
      1. Primary  → Laravel Echo WebSocket whisper (Reverb / Pusher) — low latency.
      2. Fallback → HTTP API Polling every 1500ms — works when BROADCAST_CONNECTION=null.

    Polling is always active for everyone in the room (not just one side),
    ensuring drawings sync even when a participant's page loads before the
    WebSocket channel is established, or when WS is disabled entirely.

    Sync Endpoint (POST /api/live-drawing/sync):
      Body: { targetUserId: int, payload: string }
      payload = canvas.toDataURL('image/png') OR the literal string 'clear'

    Fetch Endpoint (GET /api/live-drawing/fetch/{targetUserId}?last_time={float}):
      Returns: { success: bool, payload?: string, time: float }
      Only sends payload when server has newer data than client's last_time.

    Broadcast mode: any staff viewer can click "Aktifkan" in the panel to
    instantly start broadcasting from wherever they currently are - no
    separate page/class needed. Never retargets targetUserId - it stays this
    instance's own room the whole time (see toggleBroadcast()), so drawing
    is never interrupted and what the teacher sees never changes; every
    student polls for an active broadcast targeting them (see
    checkBatchStatus() below) and auto-attaches read-only. See
    LiveDrawingController's class docblock for the server side.
--}}

{{-- top:0/left:0 pins this container's own containing block to the true
     document origin - every child up to now has been position:fixed
     (viewport-relative regardless of ancestor position, so this never
     mattered), but directOverlayMode's panel below needs a reliable
     document-relative anchor to scroll along with the page - see
     directOverlayDocHeight. --}}
<div id="live-drawing-container"
     x-data="liveDrawingApp()"
     style="position: absolute; top: 0; left: 0; pointer-events: none; z-index: 260;"
     @resize.window="resizeCanvas()">

    {{-- Alpine's x-show only ever hides an element by writing
         `display:none` into its style ONCE Alpine has actually
         initialized - on a page that loads Alpine via a `defer`d
         <script> tag (every page that embeds this component does),
         there's a real window between first paint and Alpine mounting
         where every x-show="false-by-default" element below (the
         whole floating panel, popovers, overlays...) sits fully
         visible in raw, unstyled HTML. On a slow connection/cold CDN
         cache this is long enough to see - "whiteboard muncul
         sekejap" (whiteboard flashes visible) on every single page
         load, completely independent of any teacher/student session
         state. The standard fix is the `x-cloak` attribute (applied
         below to every TOP-LEVEL element in this component whose
         x-show defaults to false) paired with this CSS rule - unlike
         x-show, `[x-cloak]` is plain CSS that applies the instant the
         browser parses this <style> tag, no JS required, so as long
         as this tag appears before the elements it targets (it's the
         very first thing rendered in the component) nothing x-cloak'd
         can ever paint even for a single frame. Alpine then strips
         the x-cloak attribute itself once it finishes initializing,
         at which point x-show's own display toggling takes back over
         as normal. Scoped to this file only (not a page-wide <head>
         change) so it works correctly regardless of which of this
         component's 46+ including pages happens to render it. --}}
    <style>[x-cloak] { display: none !important; }</style>

    {{-- =========================================================
         FLOATING TOGGLE BUTTON
         Own on-page trigger so any participant (student on their own
         page, or staff visiting directly) can open the whiteboard
         without relying on an external control panel. Hidden while
         embedded in Admin's Live Student View iframe, since that page
         already has its own "Mode Coret-Coret" button which drives
         this same explanationMode via postMessage.
         ========================================================= --}}
    <button x-show="!isEmbeddedPreview"
            @click="toggleExplanationMode()"
            type="button"
            title="Whiteboard / Coret-Coret"
            class="flex items-center justify-center"
            :style="{
                position: 'fixed',
                top: '16px',
                left: '50%',
                transform: 'translateX(-50%)',
                width: '52px',
                height: '52px',
                borderRadius: '9999px',
                zIndex: 999999,
                pointerEvents: 'auto',
                boxShadow: '0 8px 24px rgba(0,0,0,0.25)',
                border: 'none',
                cursor: 'pointer',
                transition: 'background-color .15s',
                background: explanationMode ? '#EF4444' : '#4F46E5',
            }">
        <svg style="width:24px;height:24px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
    </button>

    {{-- =========================================================
         FLOATING WHITEBOARD PANEL
         A real draggable "papan putih" window - not an overlay stuck
         to the underlying page content. Always rendered above every-
         thing else (very high z-index) and stays fixed to the viewport
         regardless of page scroll, so it behaves like a genuine
         floating tool window.
         ========================================================= --}}
    {{-- `flex flex-col` is a static class (not part of :style) on purpose:
         x-show only ever toggles the element's inline `display` between
         'none' and '' (empty/unset), so it falls back to whatever display
         the CSS cascade gives it - these classes are what supply "flex"
         once x-show clears the inline override. Putting display:flex in
         the :style object instead gets silently clobbered by x-show. --}}
    {{-- No x-transition here on purpose: it fights the :style binding over
         the same `style` attribute (both write to it every tick), which can
         leave the panel stuck at display:none/opacity:0 mid-transition. --}}
    {{-- The full panel is only shown when NOT docked/hidden - while hidden,
         a separate small peek tab (below) represents it instead so nothing
         behind it is confusingly half-covered by an off-screen-clipped
         header/canvas. This hidden/docked state is pure local Alpine state
         (never sent to the sync API), so it only ever affects the viewing
         user's own browser - exactly what "hanya hide/unhide di akun
         mereka" requires. --}}
    <div x-show="explanationMode && !hidden"
         x-cloak
         id="whiteboard-panel"
         class="flex flex-col"
         :style="directOverlayMode ? {
             /* Lean direct-annotate overlay (Admin's Live Student View,
                'Mode Coret-Coret') - covers the whole viewport transparently
                so strokes appear directly on top of the visible content,
                instead of a small draggable opaque window. See
                directOverlayMode's docblock.
                position:absolute (NOT fixed) + spanning the FULL document
                height (not just one viewport) - see directOverlayDocHeight -
                so the browser's native page scroll carries this overlay
                (and the ink on it) along with the underlying content for
                free, instead of staying glued to a fixed screen position
                while the page scrolls underneath it. */
             position: 'absolute',
             top: '0px',
             left: '0px',
             width: '100vw',
             height: (directOverlayDocHeight > 0 ? directOverlayDocHeight + 'px' : '100vh'),
             background: 'transparent',
             borderRadius: '0px',
             boxShadow: 'none',
             zIndex: 999999,
             overflow: 'hidden',
             border: 'none',
             // A student watching a directOverlayMode auto-open (readOnlyMode
             // - see pollDrawingState()) needs clicks to pass all the way
             // through to the real page underneath, not just at the canvas
             // level - #whiteboard-canvas-zoom-wrapper/#whiteboard-canvas-body
             // sit BETWEEN the canvases (already pointer-events:none there,
             // see the student canvas's own comment) and this panel, and
             // without ALSO setting none here, one of those wrapping divs
             // (not the canvas itself) becomes the hit-test target instead of
             // whatever real content is behind the whole stack. The close
             // button below explicitly re-enables its own pointer-events, so
             // it stays clickable regardless.
             pointerEvents: (readOnlyMode ? 'none' : 'auto'),
         } : {
             position: 'fixed',
             top: panelY + 'px',
             left: panelX + 'px',
             width: panelWidth + 'px',
             height: panelHeight + 'px',
             background: '#ffffff',
             borderRadius: '16px',
             boxShadow: '0 25px 70px rgba(0,0,0,0.4)',
             zIndex: 999999,
             overflow: 'hidden',
             border: '1px solid #e2e8f0',
             pointerEvents: 'auto',
         }">

        {{-- Minimal close control for directOverlayMode - the normal
             header (with its own close button) is hidden entirely below,
             so this is the only in-page way to end the session on either
             side (staff or the auto-opened student) without relying solely
             on Admin's external "Tutup Coret-Coret" button. Pinned top-LEFT
             (not top-right) - Admin's Live Student View already renders its
             own "Student / LIVE" status badge at top-right of this exact
             iframe area (see admin/students/current-assignment.blade.php),
             which would otherwise sit right on top of this button. --}}
        <button id="whiteboard-direct-close-btn" x-show="directOverlayMode" @click="toggleExplanationMode()" type="button"
                title="Tutup" class="flex"
                {{-- class="flex" is a deliberate fallback for x-show's own
                     behavior: Alpine's x-show strips the `display` property
                     from this element's INLINE style the moment its effect
                     runs (even the very first time, if the expression starts
                     true) - relying on the static `display:flex` below alone
                     would silently break back to the browser's default
                     display (block/inline) the first time this element is
                     shown, with no CSS class left to fall back on. Same fix
                     applied to every other x-show'd element in this file
                     that has a static (non-`:style`-bound) display - a
                     `:style` binding is immune since Alpine re-writes the
                     whole object (including `display`) on every reactive
                     tick, unlike a plain `style` attribute that's only ever
                     written once at parse time. --}}
                style="position:fixed; top:12px; left:12px; width:32px; height:32px; border-radius:9999px; background:rgba(17,24,39,0.75); color:#fff; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:18px; line-height:1; z-index:1000000; pointer-events:auto;">
            &times;
        </button>

        {{-- Drag handle / header - also hosts the staff-only broadcast
             controls inline (see toggleBroadcast()) so activating broadcast
             doesn't need its own separate row. "Aktifkan" never retargets
             targetUserId - it stays this instance's own room, so it only
             makes sense on the staff member's own page, never while
             embedded-previewing a specific student's board (targetUserId
             would be THEIRS, not the staff member's own - presence() only
             registers a broadcast for the caller's own room, so this would
             otherwise silently do nothing). updateBatchTargets() posts the
             target selection on every change, read by isBatchTarget()
             server-side. Every control below stops pointerdown propagation
             so interacting with it doesn't also start dragging the panel.
             Hidden entirely in directOverlayMode - not draggable, and none
             of its controls (title/tabs/broadcast/dock/close) apply; see
             the dedicated close pill above instead. --}}
        {{-- class="flex" - x-show-strips-static-display fallback, see the
             close button's comment above. --}}
        <div x-show="!directOverlayMode" @pointerdown="startDrag($event)" class="flex"
             style="cursor: move; user-select: none; touch-action: none; background: #111827; color: #fff; height: 44px; flex-shrink: 0; display: flex; flex-wrap: nowrap; align-items: center; justify-content: space-between; padding: 0 8px 0 14px; gap: 10px; overflow: hidden;">
            <div style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; flex-shrink:0; white-space:nowrap;">
                <svg style="width:16px;height:16px;color:#93C5FD; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Whiteboard</span>
            </div>

            {{-- Student-only tab switcher: "Whiteboard" (existing broadcast
                 / individual-room view, unchanged) vs "Notebook" (a private,
                 independent canvas for personal notes - own Cache/DB layer,
                 never touched by broadcast logic or staff, see
                 LiveDrawingController class docblock). Staff never see this
                 - they only ever have the one whiteboard view (their
                 broadcast controls take this same header slot instead, see
                 below). Auto-switches back to Whiteboard the moment a
                 broadcast starts (see checkBatchStatus()), so a student
                 mid-note never misses the teacher starting to explain. --}}
            {{-- @pointerdown.stop lives on each BUTTON (not this wrapping
                 div) so the empty flex space around/between them stays
                 part of the draggable header - putting it on the div
                 itself (as this used to) swallowed pointerdown over that
                 whole flex:1-width area, leaving only a thin sliver near
                 the title actually draggable for students. Matches the
                 staff broadcast-controls row below, which already scopes
                 .stop to its buttons individually. --}}
            <div x-show="!isStaffViewer" class="flex"
                 style="display:flex; align-items:center; gap:4px; min-width:0; flex:1; overflow:hidden; height:100%;">
                <button @pointerdown.stop @click="switchTab('whiteboard')" type="button"
                        :style="activeTab === 'whiteboard'
                            ? 'background:#1f2937; border:1px solid #60a5fa; color:#fff;'
                            : 'background:none; border:1px solid transparent; color:#9ca3af;'"
                        style="padding:4px 10px; border-radius:6px; font-weight:600; font-size:11px; cursor:pointer; white-space:nowrap; flex-shrink:0;">
                    Whiteboard
                </button>
                <button @pointerdown.stop @click="switchTab('notebook')" type="button"
                        :style="activeTab === 'notebook'
                            ? 'background:#1f2937; border:1px solid #60a5fa; color:#fff;'
                            : 'background:none; border:1px solid transparent; color:#9ca3af;'"
                        style="padding:4px 10px; border-radius:6px; font-weight:600; font-size:11px; cursor:pointer; white-space:nowrap; flex-shrink:0;">
                    Notebook
                </button>
            </div>

            {{-- min-width:0 is what lets a flex item shrink below its
                 content's natural size at all (the flexbox default is
                 effectively min-width:auto, i.e. "never smaller than my
                 content") - without it on every level down to the status
                 text, the browser would rather grow this row's height
                 (wrapping text) than actually respect overflow:hidden. --}}
            <div x-show="isStaffViewer && !isEmbeddedPreview" class="flex"
                 style="display:flex; flex-wrap:nowrap; align-items:center; gap:6px; min-width:0; flex:1; overflow:hidden; height:100%;">
                <button @pointerdown.stop @click="toggleBroadcast()" type="button"
                        :style="broadcastActive
                            ? 'background:#dc2626; color:#fff; border:1px solid #b91c1c;'
                            : 'background:#4f46e5; color:#fff; border:1px solid #4338ca;'"
                        style="padding:4px 10px; border-radius:6px; font-weight:600; font-size:11px; cursor:pointer; display:flex; align-items:center; gap:4px; flex-shrink:0; white-space:nowrap;">
                    <span x-show="broadcastActive" class="inline-block" style="width:6px;height:6px;border-radius:9999px;background:#fff;display:inline-block;animation:pulse 1.5s infinite;"></span>
                    <span x-text="broadcastActive ? 'Nonaktifkan' : 'Aktifkan'"></span>
                </button>

                {{-- searchStudents() also fires here (not just on the search
                     box's own @focus/@input below) - otherwise switching to
                     "Siswa Tertentu" shows an empty "Tidak ada siswa
                     ditemukan" list until the teacher separately clicks into
                     the search box, which reads as the picker being broken. --}}
                <select @pointerdown.stop x-model="broadcastTargetMode"
                        @change="updateBatchTargets(); if (broadcastTargetMode === 'specific') { specificPickerExpanded = true; searchStudents(); }"
                        style="padding:4px 6px; border-radius:6px; border:1px solid #4b5563; background:#1f2937; color:#e5e7eb; font-weight:500; font-size:11px; flex-shrink:0; max-width:110px;">
                    <option value="all">Semua Siswa</option>
                    <option value="specific">Siswa Tertentu</option>
                </select>

                <span x-show="broadcastActive && broadcastTargetMode === 'all'"
                      x-text="'🔴 Menyiarkan ke semua siswa'"
                      style="color:#f87171; font-weight:600; font-size:11px; min-width:0; flex-shrink:1; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"></span>

                {{-- Collapse toggle for the specific-student picker row
                     below (see specificPickerExpanded) - lives here instead
                     of its own row so it doesn't take extra vertical space.
                     Same pill shape/padding as "Aktifkan"/"Siswa Tertentu"
                     above so the three sit flush together; outline:none
                     since the browser's default focus ring otherwise looks
                     like a stray blue box around just this one control. --}}
                <button x-show="broadcastTargetMode === 'specific'" @pointerdown.stop class="flex"
                        @click="specificPickerExpanded = !specificPickerExpanded" type="button"
                        style="display:flex; align-items:center; gap:6px; min-width:0; flex-shrink:1; overflow:hidden; background:#1f2937; border:1px solid #4b5563; border-radius:6px; cursor:pointer; color:#e5e7eb; font-size:11px; padding:4px 10px; white-space:nowrap; outline:none;">
                    <span x-text="selectedStudentIds.length === 0 ? 'Pilih siswa...' : (selectedStudentIds.length + ' siswa dipilih')"
                          style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"></span>
                    <span x-text="specificPickerExpanded ? '▲' : '▼ Ubah'" style="font-weight:600; color:#a5b4fc; flex-shrink:0;"></span>
                </button>
            </div>

            <div style="display:flex; align-items:center; gap:2px; flex-shrink:0;">
                <button @pointerdown.stop @click="dockToNearestSide()"
                        type="button"
                        title="Sembunyikan ke tepi layar"
                        style="color:#fff; opacity:.7; background:none; border:none; width:28px; height:28px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <button @pointerdown.stop @click="toggleExplanationMode()"
                        type="button"
                        title="Tutup Whiteboard"
                        style="color:#fff; opacity:.7; background:none; border:none; width:28px; height:28px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:18px; line-height:1;">
                    &times;
                </button>
            </div>
        </div>

        {{-- Specific-student target picker - a separate row below the
             header, only shown when that mode is selected AND expanded (the
             search box + checkbox list is too large to fit inline in the
             header). The collapse toggle itself lives in the header row
             above (next to the "Siswa Tertentu" select) so it doesn't need
             its own space here - see specificPickerExpanded. --}}
        <div x-show="isStaffViewer && !isEmbeddedPreview && broadcastTargetMode === 'specific' && specificPickerExpanded"
             style="flex-shrink:0; background:#f9fafb; border-bottom:1px solid #e5e7eb; font-size:12px; padding:8px 14px;">
                <input type="text" x-model="studentSearchQuery" @input.debounce.300ms="searchStudents()"
                       @focus="searchStudents()"
                       placeholder="Cari nama siswa..."
                       style="width:100%; padding:6px 10px; border-radius:8px; border:1px solid #d1d5db; margin-bottom:6px; box-sizing:border-box;">
                <p x-show="studentSearchScopedTo" style="color:#6b7280; margin:0 0 6px; font-size:11px;">
                    Menampilkan siswa dari batch: <span style="font-weight:600;" x-text="studentSearchScopedTo"></span>
                </p>
                <div style="max-height:140px; overflow-y:auto;">
                    <template x-for="student in studentSearchResults" :key="student.id">
                        <label style="display:flex; align-items:center; gap:6px; padding:4px 0; color:#374151; cursor:pointer;">
                            <input type="checkbox"
                                   :checked="selectedStudentIds.includes(student.id)"
                                   @change="
                                       if ($event.target.checked) { if (!selectedStudentIds.includes(student.id)) selectedStudentIds.push(student.id); }
                                       else { selectedStudentIds = selectedStudentIds.filter(id => id !== student.id); }
                                       updateBatchTargets();
                                   ">
                            <span x-text="student.name"></span>
                        </label>
                    </template>
                    <p x-show="studentSearchResults.length === 0" style="color:#9ca3af; padding:4px 0;">Tidak ada siswa ditemukan.</p>
                </div>
        </div>

        {{-- Canvas body - the actual white drawing surface. Ruled notebook
             lines (when toggled on) are a CSS background on this wrapper,
             sitting BEHIND the transparent canvas - purely decorative, so
             they're never part of the drawn/synced bitmap, never erasable,
             and never touched by undo. --}}
        <div id="whiteboard-canvas-body"
             :style="{
                 position: 'relative',
                 flex: '1',
                 // Transparent in directOverlayMode so the real content
                 // underneath (the mirrored iframe / the student's own
                 // page) shows through the drawing surface, instead of an
                 // opaque notebook page.
                 background: directOverlayMode ? 'transparent' : '#fff',
                 // 'auto' (not 'hidden') - the canvas's pixel buffer always
                 // matches this body's own unzoomed width (see
                 // resizeCanvas()), but zoomLevel > 1 makes it visually
                 // RENDER wider than that (see #whiteboard-canvas-zoom-wrapper),
                 // so horizontal scrolling has to be possible or a zoomed-in
                 // view would just clip content off the right edge with no
                 // way to reach it. directOverlayMode never grows past the
                 // viewport (see growCanvasHeight()'s early-return) and
                 // never zooms, so scrolling never applies there either.
                 overflowX: directOverlayMode ? 'hidden' : 'auto',
                 overflowY: directOverlayMode ? 'hidden' : 'auto',
             }">
            {{-- Invisible paste target - a <canvas> can never itself hold
                 keyboard focus, and browsers only ever fire a native
                 `paste` event (in response to the OS-level Ctrl+V/Cmd+V
                 shortcut) at a genuinely editable focus target
                 (contenteditable/input/textarea) - without this, pressing
                 paste anywhere over the whiteboard does nothing at all, no
                 event fires for handlePaste() to even catch. Kept focused
                 (see focusPasteCatcher(), called on every pointerdown in
                 the canvas) so paste keeps working right after
                 clicking/drawing, without the teacher needing to click some
                 specific hidden spot first. handlePaste() always
                 preventDefault()s an image paste, so nothing ever actually
                 lands as text inside this element itself.

                 position:fixed (NOT absolute) is deliberate: this div has
                 no explicit top/left, so as position:absolute its "static
                 position" sat at canvas-space (0,0) - the top-left of
                 #whiteboard-canvas-body's SCROLLABLE content, not the
                 viewport. Every focusPasteCatcher() call (every single
                 pointerdown) then made the browser's native "scroll the
                 newly-focused element into view" behavior snap the whole
                 scrollable body back to scrollTop 0 to reveal this
                 (invisible, 1x1, opacity:0) element - wiping out whatever
                 scroll position the teacher was actually at. That's what
                 caused the "canvas jumps to the default/top position"
                 bug: confirmed via a temporary scrollTop interceptor that
                 logged the exact moment as a native (non-JS-triggered)
                 scroll event, immediately after a click. Fixed simply by
                 taking this element out of the scrollable flow entirely -
                 position:fixed is positioned relative to the viewport, so
                 it's always already "in view" and the browser never has
                 anything to scroll for it, regardless of where it sits in
                 the DOM tree. Its own on-screen position is irrelevant
                 either way (1x1px, opacity:0, pointer-events:none). --}}
            <div id="whiteboard-paste-catcher" contenteditable="true" tabindex="-1"
                 style="position:fixed; top:0; left:0; width:1px; height:1px; opacity:0; overflow:hidden; pointer-events:none;"
                 @input="$event.target.innerHTML = ''"></div>

            {{-- Zoom wrapper - ONLY the 3 canvases live inside this, so
                 zoomLevel (see state comment) scales just the drawing
                 surface itself, never the eraser cursor/archive panel/
                 paste catcher siblings below. CSS `zoom` (not
                 transform:scale) so the browser keeps scroll/overflow
                 correct on its own as content grows/shrinks. width/height:
                 100% of #whiteboard-canvas-body (its own positioned
                 ancestor) - needed because its own children are all
                 position:absolute (removed from normal flow), so without
                 an explicit size here their "100%" would resolve against
                 a collapsed 0x0 box.

                 The ruled notebook-lines background (see toggleRuledLines())
                 lives HERE, not on #whiteboard-canvas-body - it has to be
                 inside the zoomed element itself to actually scale together
                 with the canvas content; on the unzoomed body its line
                 spacing would stay visually fixed while drawn text/strokes
                 (rendered via canvas, zoomed for free by this same wrapper)
                 grew or shrank around it, drifting out of alignment. No
                 backgroundAttachment override needed here (unlike before)
                 since this wrapper isn't itself the scrolling element - it
                 just moves normally as its ancestor scrolls, background
                 included. --}}
            {{-- Wrapper height mirrors canvasContentHeight (kept in sync by
                 resizeCanvas()/growCanvasHeight() as the canvas grows
                 taller than the viewport) instead of a flat 100% - this is
                 what the ruled-lines background below is painted on, and a
                 background only ever covers its own element's box. Falls
                 back to 100% before the first measurement (canvasContentHeight
                 starts at 0), so initial layout is unaffected. --}}
            <div id="whiteboard-canvas-zoom-wrapper"
                 :style="{
                     position: 'relative',
                     width: '100%',
                     // directOverlayMode never grows past the viewport (see
                     // growCanvasHeight()'s early-return), so it always
                     // stays a flat 100% instead of tracking
                     // canvasContentHeight.
                     height: (!directOverlayMode && canvasContentHeight > 0) ? canvasContentHeight + 'px' : '100%',
                     zoom: zoomLevel,
                     // Ruled notebook lines never apply to directOverlayMode
                     // (annotating live content, not writing notes).
                     backgroundImage: (ruledLines && !directOverlayMode)
                         ? `repeating-linear-gradient(to bottom, transparent, transparent ${ruledLineHeight - 1}px, #bfdbfe ${ruledLineHeight - 1}px, #bfdbfe ${ruledLineHeight}px), linear-gradient(to right, transparent 0, transparent 39px, #fca5a5 39px, #fca5a5 40px, transparent 40px)`
                         : 'none',
                 }">
                {{-- Staff/teacher layer (bottom) - also the original/legacy
                     canvas from before the two-layer split, kept as the same
                     element id for backward compatibility. Only receives
                     pointer input when the current viewer IS staff; otherwise
                     events pass through to the student canvas on top of it. --}}
                <canvas id="global-live-drawing-canvas"
                        class="cursor-crosshair"
                        :style="{ display: 'block', position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', maxWidth: 'none', pointerEvents: isStaffViewer ? 'auto' : 'none' }"
                        @pointerdown="startDrawing($event)"
                        @pointermove="draw($event)"
                        @pointerup="stopDrawing($event)"
                        @pointerout="stopDrawing($event)"
                        @pointercancel="stopDrawing($event)">
                </canvas>

                {{-- Student layer - sits above the staff layer (students
                     typically write in response to what the teacher already
                     explained, or their own work while a staff member
                     watches live via ?live_preview_for=...). Only receives
                     pointer input when the current viewer is NOT staff - a
                     student watching a batch broadcast (in the normal small
                     panel) has pointer-events left enabled here but
                     startDrawing() itself bails out via readOnlyMode, since
                     that's the room the teacher is actively drawing into
                     and the two must never overlap; blocking the small
                     panel's own area doesn't meaningfully affect the rest
                     of the page there. directOverlayMode is different - see
                     pollDrawingState()'s auto-open, which sets readOnlyMode
                     too - it's a FULL-PAGE overlay, so leaving pointer-
                     events enabled-but-inert would silently swallow every
                     click on the entire page (the student couldn't type
                     into their own answers while the teacher points at
                     something); forced to none there instead, so clicks
                     pass straight through to the real page underneath -
                     the ink itself still renders regardless of pointer-
                     events (that's a hit-testing property only). Same
                     handlers as the staff canvas - harmless to bind on the
                     one that's pointer-events:none, since it can never
                     actually receive events. --}}
                <canvas id="student-live-drawing-canvas"
                        class="cursor-crosshair"
                        :style="{ display: 'block', position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', maxWidth: 'none', zIndex: 1, pointerEvents: isStaffViewer ? 'none' : ((directOverlayMode && readOnlyMode) ? 'none' : 'auto') }"
                        @pointerdown="startDrawing($event)"
                        @pointermove="draw($event)"
                        @pointerup="stopDrawing($event)"
                        @pointerout="stopDrawing($event)"
                        @pointercancel="stopDrawing($event)">
                </canvas>

                {{-- Laser canvas overlay - renders fading laser pointer strokes --}}
                <canvas id="laser-live-drawing-canvas"
                        class="pointer-events-none"
                        style="display:block; position: absolute; top: 0; left: 0; width: 100%; height: 100%; max-width: none; z-index: 2;">
                </canvas>
            </div>

            {{-- Eraser-size preview circle - follows the pointer while the
                 Hapus tool is active, sized to match the actual erase
                 diameter (eraserWidth, the same value used as ctx.lineWidth
                 when erasing), so it's clear up front which area a stroke
                 will cover instead of finding out after the fact. --}}
            {{-- eraserCursor.x/y are TRUE canvas-space (from getPointerPos(),
                 which is zoom-corrected) - this div lives OUTSIDE the
                 zoomed wrapper above, in real screen-pixel space, so both
                 its position AND its diameter need to be scaled back UP by
                 zoomLevel to visually line up with (and correctly
                 represent the actual erased area of) the zoomed canvas. --}}
            <div x-show="tool === 'eraser' && eraserCursor.hovering"
                 class="pointer-events-none"
                 :style="{
                     position: 'absolute',
                     left: (eraserCursor.x * zoomLevel - (eraserWidth * zoomLevel) / 2) + 'px',
                     top: (eraserCursor.y * zoomLevel - (eraserWidth * zoomLevel) / 2) + 'px',
                     width: (eraserWidth * zoomLevel) + 'px',
                     height: (eraserWidth * zoomLevel) + 'px',
                     borderRadius: '50%',
                     border: '2px solid #EF4444',
                     backgroundColor: 'rgba(239, 68, 68, 0.12)',
                     zIndex: 3,
                 }">
            </div>

            {{-- Zoom controls - a sticky (not fixed/absolute) wrapper so it
                 stays pinned to the bottom-right of the VISIBLE canvas
                 viewport even while scrolled through a tall (grown)
                 canvas, without any manual position tracking - sticky
                 handles that natively since #whiteboard-canvas-body is the
                 scrolling container. pointer-events:none on the wrapper
                 (it spans the full width) / auto on the pill itself, so it
                 only intercepts clicks right where the pill actually is. --}}
            <div style="position:sticky; bottom:0; display:flex; justify-content:flex-end; pointer-events:none; z-index:5;">
                <div style="pointer-events:auto; display:flex; align-items:center; gap:2px; background:rgba(17,24,39,0.85); border-radius:999px; padding:4px; margin:0 10px 10px 0; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                    <button @click="zoomOut()" type="button" title="Perkecil"
                            style="width:24px; height:24px; border-radius:999px; border:none; background:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        &minus;
                    </button>
                    <button @click="resetZoom()" type="button" title="Reset ke 100%"
                            style="min-width:40px; padding:0 4px; border:none; background:none; color:#e5e7eb; font-size:11px; font-weight:600; cursor:pointer; text-align:center;"
                            x-text="Math.round(zoomLevel * 100) + '%'">
                    </button>
                    <button @click="zoomIn()" type="button" title="Perbesar"
                            style="width:24px; height:24px; border-radius:999px; border:none; background:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        &plus;
                    </button>
                </div>
            </div>

            {{-- Archive browser overlay - lists permanently-saved snapshots
                 for this room, separate from the single continuously
                 autosaved board underneath. Lives inside the (already
                 position:relative + overflow:hidden) canvas body so it
                 covers just the drawing area, not the toolbar. --}}
            <div x-show="showArchivePanel" class="flex"
                 style="position:absolute; inset:0; background:rgba(255,255,255,0.98); z-index:20; display:flex; flex-direction:column; padding:16px; overflow-y:auto;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                    <h3 style="font-weight:700; font-size:14px; color:#111827;">Arsip Whiteboard</h3>
                    <button @click="showArchivePanel = false" type="button"
                            style="background:none; border:none; cursor:pointer; color:#6B7280; font-size:20px; line-height:1;">
                        &times;
                    </button>
                </div>

                <div x-show="archivesLoading" style="text-align:center; color:#6B7280; font-size:13px; padding:24px 0;">
                    Memuat arsip...
                </div>

                <div x-show="!archivesLoading && archives.length === 0" style="text-align:center; color:#9CA3AF; font-size:13px; padding:24px 0;">
                    Belum ada arsip tersimpan. Klik "Arsipkan" di toolbar untuk menyimpan coretan saat ini.
                </div>

                <template x-for="item in archives" :key="item.id">
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; border:1px solid #E5E7EB; border-radius:10px; margin-bottom:8px;">
                        <span style="font-size:13px; color:#374151; font-weight:600;" x-text="item.title"></span>
                        <div style="display:flex; gap:8px; flex-shrink:0;">
                            <button @click="openArchive(item.id)" type="button" :disabled="openingArchiveId === item.id"
                                    style="font-size:12px; font-weight:700; color:#fff; background:#4F46E5; border:none; padding:6px 12px; border-radius:8px; cursor:pointer;"
                                    x-text="openingArchiveId === item.id ? 'Membuka...' : 'Buka'">
                            </button>
                            <button @click="deleteArchive(item.id)" type="button"
                                    style="font-size:12px; font-weight:700; color:#DC2626; background:#FEE2E2; border:none; padding:6px 10px; border-radius:8px; cursor:pointer;">
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Student "Notebook" tab - a private, independent canvas
                 (see LiveDrawingController class docblock / the tab
                 switcher above) covering the exact same area as the
                 whiteboard canvas above it (this element is the last
                 child of #whiteboard-canvas-body, which is
                 position:relative, so inset:0 lines it up perfectly).
                 Reuses the EXACT SAME drawing engine/toolbar as the
                 whiteboard (pen/highlight/text/list/shapes/table/ruled-
                 lines/zoom/undo-redo) - see switchTab()'s docblock for how
                 this.ctx/myCanvasId/otherCanvasId/history/redoStack get
                 repointed here while this tab is active, and
                 syncDrawingToServer()/pollDrawingState()'s activeTab
                 branches for how the network layer stays isolated from
                 the whiteboard's own room. --}}
            <div id="whiteboard-notebook-body"
                 x-show="activeTab === 'notebook' && !isStaffViewer"
                 style="position:absolute; inset:0; background:#fff; z-index:15; overflow:auto;">
                {{-- Same zoom + ruled-lines treatment as
                     #whiteboard-canvas-zoom-wrapper (shared zoomLevel/
                     ruledLines state - see this file's other zoom
                     wrapper for the full reasoning). --}}
                <div id="whiteboard-notebook-zoom-wrapper"
                     :style="{
                         position: 'relative',
                         width: '100%',
                         height: '100%',
                         zoom: zoomLevel,
                         backgroundImage: ruledLines
                             ? `repeating-linear-gradient(to bottom, transparent, transparent ${ruledLineHeight - 1}px, #bfdbfe ${ruledLineHeight - 1}px, #bfdbfe ${ruledLineHeight}px), linear-gradient(to right, transparent 0, transparent 39px, #fca5a5 39px, #fca5a5 40px, transparent 40px)`
                             : 'none',
                     }">
                    <canvas id="student-notebook-canvas"
                            class="cursor-crosshair"
                            :style="{ display: 'block', position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', maxWidth: 'none' }"
                            @pointerdown="startDrawing($event)"
                            @pointermove="draw($event)"
                            @pointerup="stopDrawing($event)"
                            @pointerout="stopDrawing($event)"
                            @pointercancel="stopDrawing($event)">
                    </canvas>
                    {{-- Never independently drawn into - see switchTab()'s
                         otherCanvasId docblock for why this needs to exist
                         at all (the whiteboard's generic canvas-sizing
                         code assumes a real, separate "other" canvas). --}}
                    <canvas id="notebook-other-dummy-canvas" style="display:none;"></canvas>
                </div>

                {{-- Zoom controls - identical to the whiteboard's own (see
                     that one's docblock), just anchored to this
                     container's own scroll instead. --}}
                <div style="position:sticky; bottom:0; display:flex; justify-content:flex-end; pointer-events:none; z-index:5;">
                    <div style="pointer-events:auto; display:flex; align-items:center; gap:2px; background:rgba(17,24,39,0.85); border-radius:999px; padding:4px; margin:0 10px 10px 0; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                        <button @click="zoomOut()" type="button" title="Perkecil"
                                style="width:24px; height:24px; border-radius:999px; border:none; background:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            &minus;
                        </button>
                        <button @click="resetZoom()" type="button" title="Reset ke 100%"
                                style="min-width:40px; padding:0 4px; border:none; background:none; color:#e5e7eb; font-size:11px; font-weight:600; cursor:pointer; text-align:center;"
                                x-text="Math.round(zoomLevel * 100) + '%'">
                        </button>
                        <button @click="zoomIn()" type="button" title="Perbesar"
                                style="width:24px; height:24px; border-radius:999px; border:none; background:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            &plus;
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================================
             DRAWING TOOLBAR
             Docked inside the whiteboard container itself (moves,
             resizes and hides together with the panel) rather than
             floating independently over the page. No x-show of its
             own needed - the outer panel already only renders this
             while open and not docked/hidden.
             ===================================================== --}}
        {{-- justify-start (not justify-center) is required here, not just
             cosmetic: with overflow-x:auto + justify-center, any overflow
             that lands on the START side is unreachable (scrollLeft can't
             go negative), permanently hiding/disabling whichever buttons
             end up off the left edge whenever the toolbar is wider than
             the panel. justify-start keeps all overflow on the reachable
             right side, scrollable from a 0 starting position. --}}
        {{-- Watching a batch broadcast (see checkBatchStatus()) is
             read-only for students - the toolbar itself only lets STAFF
             draw (see the student canvas layer's pointerEvents below), so
             nothing here would work anyway; hide it and show a small status
             banner instead. readOnlyMode can only ever be true while
             activeTab === 'whiteboard' - watching a broadcast always force-
             switches back to that tab first (see checkBatchStatus()) - so
             this never needs its own activeTab check. Students otherwise
             keep normal drawing access on their own individual room (e.g.
             the admin's "Live Student View", ?live_preview_for=... - see
             admin/students/current-assignment.blade.php) - that's a
             different room than whatever the teacher is currently
             broadcasting into, so the two never visually collide.
             !directOverlayMode too - this banner's "kelas"/class-broadcast
             wording doesn't fit a directOverlayMode auto-open (a teacher
             live-annotating THIS student's own page specifically, not a
             class-wide broadcast - see pollDrawingState()'s auto-open),
             and an opaque banner bar would contradict directOverlayMode's
             whole point of being a minimal, fully transparent overlay. --}}
        <div x-show="readOnlyMode && !directOverlayMode" class="flex"
             style="flex-shrink:0; background:#7f1d1d; color:#fecaca; padding:8px 16px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:6px;">
            <span style="width:8px;height:8px;border-radius:9999px;background:#ef4444;display:inline-block;animation:pulse 1.5s infinite;"></span>
            Menonton whiteboard kelas (mode baca saja)
        </div>

        {{-- Shared toolbar - serves BOTH the Whiteboard and Notebook tabs
             (see switchTab()'s docblock for how the underlying engine gets
             repointed at whichever one is active). Laser and Arsipkan/
             Arsip are the only exceptions, hidden specifically for
             Notebook - see their own buttons below for why. --}}
        {{-- position:fixed in directOverlayMode (removing it from the panel's
             flex flow entirely, per the CSS spec) instead of flowing as the
             panel's last flex child - once the panel spans the full document
             (see directOverlayDocHeight), a normal flex-child toolbar would
             end up scrolled all the way to the bottom of the page, out of
             reach. Pinning it to the viewport keeps it reachable regardless
             of scroll position; #whiteboard-canvas-body (flex:1) naturally
             reclaims the freed space. --}}
        <div id="whiteboard-direct-toolbar" x-show="!readOnlyMode" class="flex items-center justify-start gap-3"
             :style="directOverlayMode ? {
                 position: 'fixed', bottom: '0px', left: '0px', width: '100%',
                 flexShrink: '0', background: '#111827', color: '#fff',
                 padding: '10px 40px 10px 12px', borderTop: '1px solid #1f2937',
                 overflowX: 'auto', zIndex: 1000000,
             } : {
                 flexShrink: '0', background: '#111827', color: '#fff',
                 padding: '10px 40px 10px 12px', borderTop: '1px solid #1f2937',
                 overflowX: 'auto',
             }">

            {{-- Pen Tool --}}
            <button @click="setTool('pen')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Pen"
                    :style="tool === 'pen' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span style="font-size:9px;">Pen</span>
            </button>

            {{-- Highlighter Tool --}}
            <button @click="setTool('highlight')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Stabilo / Highlighter"
                    :style="tool === 'highlight' ? 'color: #FACC15; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                <span style="font-size:9px;">Stabilo</span>
            </button>

            {{-- Text Tool --}}
            <button @click="setTool('text')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Text"
                    :style="tool === 'text' ? 'color: #10B981; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7V4h16v3M12 4v16M8 20h8"/>
                </svg>
                <span style="font-size:9px;">Teks</span>
            </button>

            {{-- List Tool - each click/Enter places a bullet ("• ") line,
                 snapped to an even line grid like Buku (see startDrawing()/
                 commitTextInput()/handleTextEnterKey()). --}}
            <button @click="setTool('list')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Daftar (List)"
                    :style="tool === 'list' ? 'color: #10B981; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="4.5" cy="6" r="1.2" fill="currentColor" stroke="none"/>
                    <circle cx="4.5" cy="12" r="1.2" fill="currentColor" stroke="none"/>
                    <circle cx="4.5" cy="18" r="1.2" fill="currentColor" stroke="none"/>
                    <path stroke-linecap="round" stroke-width="2" d="M9 6h11M9 12h11M9 18h11"/>
                </svg>
                <span style="font-size:9px;">Daftar</span>
            </button>

            {{-- Laser Pointer Tool - hidden for Notebook: it's a live,
                 multi-viewer gesture (shows OTHER people where you're
                 pointing in real time), which has no purpose on a private,
                 single-owner canvas nobody else ever sees. --}}
            <button x-show="activeTab === 'whiteboard'" @click="setTool('laser')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Laser Pointer"
                    :style="tool === 'laser' ? 'color: #F87171; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" fill="currentColor"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h10"/>
                </svg>
                <span style="font-size:9px;">Laser</span>
            </button>

            {{-- Eraser Tool --}}
            <button @click="setTool('eraser')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Eraser"
                    :style="tool === 'eraser' ? 'color: #fff; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L17.5 6.5M6 6l12 12"/>
                </svg>
                <span style="font-size:9px;">Hapus</span>
            </button>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Rectangle Tool --}}
            <button @click="setTool('rectangle')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Kotak"
                    :style="tool === 'rectangle' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="4" y="6" width="16" height="12" rx="1.5" stroke-width="2"/>
                </svg>
                <span style="font-size:9px;">Kotak</span>
            </button>

            {{-- Ellipse Tool --}}
            <button @click="setTool('ellipse')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Lingkaran"
                    :style="tool === 'ellipse' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="12" rx="8" ry="6" stroke-width="2"/>
                </svg>
                <span style="font-size:9px;">Lingkaran</span>
            </button>

            {{-- Line Tool --}}
            <button @click="setTool('line')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Garis Lurus"
                    :style="tool === 'line' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M5 19L19 5"/>
                </svg>
                <span style="font-size:9px;">Garis</span>
            </button>

            {{-- Arrow Tool --}}
            <button @click="setTool('arrow')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Panah"
                    :style="tool === 'arrow' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19L19 5M19 5H10M19 5V14"/>
                </svg>
                <span style="font-size:9px;">Panah</span>
            </button>

            {{-- Table Tool - click-drag defines the bounding box like the
                 other shape tools, divided into tableRows x tableCols
                 cells (see the Baris/Kolom inputs below and
                 drawShapeOutline()). --}}
            <button @click="setTool('table')"
                    class="flex flex-col items-center transition shrink-0"
                    title="Tabel"
                    :style="tool === 'table' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3.5" y="4.5" width="17" height="15" rx="1" stroke-width="2"/>
                    <path stroke-width="2" d="M3.5 9.83h17M3.5 14.17h17M9.33 4.5v15M14.67 4.5v15"/>
                </svg>
                <span style="font-size:9px;">Tabel</span>
            </button>

            {{-- Table row/column count - only relevant while the Table
                 tool is active. Captured into shapePreview at click-time,
                 not live-bound, so changing these mid-drag doesn't shift an
                 in-progress table (see startDrawing()). --}}
            <div x-show="tool === 'table'" class="flex items-center gap-1 shrink-0" style="color:#9CA3AF; font-size:10px;">
                <label for="live-drawing-table-rows">Baris</label>
                <input id="live-drawing-table-rows" type="number" min="1" max="20" x-model.number="tableRows"
                       style="width:36px; background:#1F2937; color:#fff; border:1px solid #374151; border-radius:4px; padding:2px 4px; font-size:11px;">
                <label for="live-drawing-table-cols">Kolom</label>
                <input id="live-drawing-table-cols" type="number" min="1" max="20" x-model.number="tableCols"
                       style="width:36px; background:#1F2937; color:#fff; border:1px solid #374151; border-radius:4px; padding:2px 4px; font-size:11px;">
            </div>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Ruled Notebook Lines Toggle (local-only, see #whiteboard-canvas-body).
                 Hidden in directOverlayMode - ruled lines never apply there
                 (see #whiteboard-canvas-zoom-wrapper) since it annotates
                 live content, not an infinite notebook. --}}
            <button x-show="!directOverlayMode" @click="toggleRuledLines()"
                    class="flex flex-col items-center transition shrink-0"
                    title="Garis Buku Tulis"
                    :style="ruledLines ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span style="font-size:9px;">Buku</span>
            </button>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Undo --}}
            <button @click="undo()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Undo (batalkan aksi terakhir)"
                    :style="(undoing || history.length === 0) ? 'color: #4B5563; cursor: not-allowed;' : 'color: #9CA3AF; cursor: pointer;'"
                    :disabled="undoing || history.length === 0">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15L4 10m0 0l5-5m-5 5h11a4 4 0 010 8h-1"/>
                </svg>
                <span style="font-size:9px;">Undo</span>
            </button>

            {{-- Redo --}}
            <button @click="redo()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Redo (kembalikan aksi yang di-undo)"
                    :style="(redoing || redoStack.length === 0) ? 'color: #4B5563; cursor: not-allowed;' : 'color: #9CA3AF; cursor: pointer;'"
                    :disabled="redoing || redoStack.length === 0">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5-5m0 0l-5-5m5 5H9a4 4 0 000 8h1"/>
                </svg>
                <span style="font-size:9px;">Redo</span>
            </button>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Color Palette (shown for pen / highlight / shape / text tools,
                 and whenever ruled-lines mode is forcing text placement
                 regardless of which tool is visually selected). --}}
            <div x-show="['pen', 'highlight', 'rectangle', 'ellipse', 'line', 'arrow', 'text', 'list', 'table'].includes(tool) || ruledLines" class="flex items-center gap-2 shrink-0">
                <template x-for="c in (tool === 'highlight' ? colors.highlight : colors.pen)" :key="c">
                    {{-- Object-syntax :style (not a string) on purpose: a
                         string :style REPLACES the whole style attribute
                         instead of merging, which was silently wiping out
                         the width/height below and collapsing these to
                         0x0 - object syntax is the safe form here. --}}
                    <button @click="baseColor = c; updateColor()"
                            :title="c"
                            class="rounded-full transition shrink-0"
                            :style="{
                                width: '28px',
                                height: '28px',
                                borderWidth: '2px',
                                borderStyle: 'solid',
                                cursor: 'pointer',
                                backgroundColor: c,
                                borderColor: baseColor === c ? '#fff' : 'rgba(255,255,255,0.25)',
                                transform: 'scale(' + (baseColor === c ? 1.15 : 1) + ')',
                                boxShadow: baseColor === c ? '0 0 0 2px rgba(255,255,255,0.35)' : 'none',
                            }">
                    </button>
                </template>
            </div>

            {{-- Pen diameter slider --}}
            <div x-show="tool === 'pen'" class="flex flex-col items-center shrink-0" style="width:84px;">
                <input type="range" min="1" max="20" step="1" :value="penWidth"
                       @input="penWidth = parseInt($event.target.value); lineWidth = penWidth"
                       style="width:76px; accent-color:#60A5FA;">
                <span style="font-size:9px;color:#9CA3AF;" x-text="'Ukuran: ' + penWidth + 'px'"></span>
            </div>

            {{-- Eraser diameter slider --}}
            <div x-show="tool === 'eraser'" class="flex flex-col items-center shrink-0" style="width:84px;">
                <input type="range" min="10" max="80" step="2" :value="eraserWidth"
                       @input="eraserWidth = parseInt($event.target.value); lineWidth = eraserWidth"
                       style="width:76px; accent-color:#9CA3AF;">
                <span style="font-size:9px;color:#9CA3AF;" x-text="'Ukuran: ' + eraserWidth + 'px'"></span>
            </div>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Clear All - opens a small popover with the applicable
                 scope(s): students only ever see "Bersihkan Siswa" (their
                 own layer); staff see all three. Also enforced server-side
                 (see LiveDrawingController::handleClear()), this is just
                 not showing options that would 403 anyway. --}}
            <button @click="toggleClearMenu($event)"
                    class="flex flex-col items-center shrink-0"
                    title="Clear All"
                    style="color: #F87171;">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span style="font-size:9px;">Clear All</span>
            </button>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Manual Save (in addition to autosave already happening on every stroke) --}}
            <button @click="manualSave()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Simpan whiteboard sekarang"
                    :style="savingManually ? 'color: #4B5563; cursor: wait;' : (saveConfirmed ? 'color: #34D399;' : 'color: #60A5FA; cursor: pointer;')"
                    :disabled="savingManually">
                <svg x-show="!savingManually && !saveConfirmed" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8H7v8M7 3v5h8"/>
                </svg>
                <svg x-show="savingManually" class="animate-spin" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"/>
                </svg>
                <svg x-show="saveConfirmed && !savingManually" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span style="font-size:9px;" x-text="savingManually ? 'Menyimpan...' : (saveConfirmed ? 'Tersimpan!' : 'Simpan')"></span>
            </button>

            {{-- Checkpoint picker - every "Simpan" click above also leaves a
                 checkpoint behind (see manualSave()/createCheckpoint()); this
                 small chevron opens a dropdown to pick one and display it on
                 the live board for everyone in the room. Deliberately no
                 delete control here - see the Clear All popover below. --}}
            <button @click="toggleCheckpointPanel($event)"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Pilih checkpoint untuk ditampilkan"
                    :style="showCheckpointPanel ? 'color: #60A5FA;' : 'color: #9CA3AF; cursor: pointer;'">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
                <span style="font-size:9px;">Checkpoint</span>
            </button>

            {{-- Archive current canvas as a new, permanent, reopenable
                 snapshot. Hidden for Notebook - archives are tied to
                 WhiteboardArchive, a table scoped to the shared room
                 concept (staff+student layers, targetUserId) that the
                 private notebook layer isn't part of. --}}
            <button x-show="activeTab === 'whiteboard'" @click="archiveNow()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Simpan sebagai arsip baru (bisa dibuka lagi kapan saja)"
                    :style="archivingNow ? 'color: #4B5563; cursor: wait;' : (archiveConfirmed ? 'color: #34D399;' : 'color: #FBBF24; cursor: pointer;')"
                    :disabled="archivingNow">
                <svg x-show="!archivingNow && !archiveConfirmed" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8M10 12h4"/>
                </svg>
                <svg x-show="archivingNow" class="animate-spin" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"/>
                </svg>
                <svg x-show="archiveConfirmed && !archivingNow" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span style="font-size:9px;" x-text="archivingNow ? 'Mengarsip...' : (archiveConfirmed ? 'Diarsipkan!' : 'Arsipkan')"></span>
            </button>

            {{-- Browse / open / delete saved archives - see "Arsipkan"
                 above for why this is Whiteboard-only. --}}
            <button x-show="activeTab === 'whiteboard'" @click="toggleArchivePanel()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Lihat daftar arsip tersimpan"
                    :style="showArchivePanel ? 'color: #FBBF24; cursor: pointer;' : 'color: #9CA3AF; cursor: pointer;'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                <span style="font-size:9px;">Arsip</span>
            </button>

            {{-- Separator --}}
            <div class="shrink-0" style="width:1px;height:28px;background:#374151;"></div>

            {{-- Download as PDF --}}
            <button @click="downloadPdf()"
                    class="flex flex-col items-center shrink-0 transition"
                    title="Unduh catatan sebagai PDF"
                    :style="pdfExporting ? 'color: #4B5563; cursor: wait;' : 'color: #34D399; cursor: pointer;'"
                    :disabled="pdfExporting">
                <svg x-show="!pdfExporting" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M7 10l5 5 5-5M12 15V3"/>
                </svg>
                <svg x-show="pdfExporting" class="animate-spin" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"/>
                </svg>
                <span style="font-size:9px;" x-text="pdfExporting ? 'Membuat...' : 'Unduh PDF'"></span>
            </button>
        </div>

        {{-- Resize handle - bottom-right corner grip (28px hit target for
             comfortable grabbing, icon itself stays small/unobtrusive) --}}
        <div @pointerdown="startResize($event)"
             title="Ubah ukuran"
             style="position:absolute; bottom:0; right:0; width:28px; height:28px; cursor:nwse-resize; touch-action:none; z-index:2;">
            <svg style="width:16px;height:16px;position:absolute;bottom:4px;right:4px;color:#9CA3AF;" fill="currentColor" viewBox="0 0 16 16">
                <circle cx="13" cy="13" r="1.4"/>
                <circle cx="13" cy="8.3" r="1.4"/>
                <circle cx="8.3" cy="13" r="1.4"/>
            </svg>
        </div>
    </div>

    {{-- =========================================================
         CLEAR ALL POPOVER MENU
         position: fixed (not clipped by the toolbar's own overflow-x:
         auto scrolling), anchored above the Clear All button via
         toggleClearMenu(). Students only ever see "Bersihkan Siswa"
         (their own layer); staff see all three - also enforced
         server-side, not just hidden here.
         ========================================================= --}}
    <div x-show="showClearMenu"
         x-cloak
         @click.outside="showClearMenu = false"
         :style="{
             position: 'fixed',
             pointerEvents: 'auto',
             left: clearMenuX + 'px',
             top: clearMenuY + 'px',
             transform: 'translateY(-100%) translateY(-8px)',
             background: '#1F2937',
             border: '1px solid #374151',
             borderRadius: '8px',
             padding: '6px',
             zIndex: 999999,
             boxShadow: '0 8px 24px rgba(0,0,0,0.35)',
             minWidth: (clearMenuView === 'checkpoints' ? '280px' : '230px'),
             maxHeight: (clearMenuView === 'checkpoints' ? '320px' : 'none'),
             overflowY: (clearMenuView === 'checkpoints' ? 'auto' : 'visible'),
             display: 'flex',
             flexDirection: 'column',
             gap: '2px',
         }">
        <template x-if="clearMenuView === 'main'">
            <div class="flex" style="flex-direction:column; gap:2px;">
                <button x-show="isStaffViewer && activeTab === 'whiteboard'"
                        @click="clearCanvases('all')"
                        type="button"
                        style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#F87171; font-size:13px; cursor:pointer;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    Bersihkan Semua
                </button>
                <button x-show="isStaffViewer && activeTab === 'whiteboard'"
                        @click="clearCanvases('staff')"
                        type="button"
                        style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#FBBF24; font-size:13px; cursor:pointer;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    Bersihkan Coretan Guru/Admin
                </button>
                <button x-show="activeTab === 'whiteboard'"
                        @click="clearCanvases('student')"
                        type="button"
                        style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#60A5FA; font-size:13px; cursor:pointer;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    Bersihkan Coretan Siswa
                </button>
                {{-- Notebook's single-layer equivalent - only ever reachable
                     from the Notebook tab, since the "Clear All" trigger
                     button itself is what opens this popover regardless of
                     tab (see toggleClearMenu()). --}}
                <button x-show="activeTab === 'notebook'"
                        @click="clearCanvases('notebook')"
                        type="button"
                        style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#60A5FA; font-size:13px; cursor:pointer;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    Bersihkan Notebook
                </button>
                {{-- Checkpoints (see "Simpan"/manualSave()) are only ever
                     removable from here - this switches the SAME popover
                     into a checkbox list instead of opening a separate one. --}}
                <button x-show="activeTab === 'whiteboard'"
                        @click="toggleClearMenuCheckpointView()"
                        type="button"
                        style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#9CA3AF; font-size:13px; cursor:pointer; border-top:1px solid #374151; margin-top:2px; padding-top:10px;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    Hapus Checkpoint...
                </button>
            </div>
        </template>

        {{-- Checkpoint bulk-delete sub-view - the only path to removing a
             checkpoint (see createCheckpoint()/openCheckpoint() above). --}}
        <template x-if="clearMenuView === 'checkpoints'">
            <div class="flex" style="flex-direction:column; gap:2px;">
                <button @click="toggleClearMenuCheckpointView()" type="button"
                        style="display:flex; align-items:center; gap:6px; text-align:left; background:none; border:none; padding:6px 8px; border-radius:6px; color:#9CA3AF; font-size:12px; cursor:pointer; margin-bottom:2px;"
                        onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </button>

                <div x-show="checkpointsLoading" style="text-align:center; color:#9CA3AF; font-size:12px; padding:12px 0;">
                    Memuat checkpoint...
                </div>
                <div x-show="!checkpointsLoading && checkpoints.length === 0" style="text-align:center; color:#6B7280; font-size:12px; padding:12px 0;">
                    Belum ada checkpoint. Klik "Simpan" di toolbar untuk membuat satu.
                </div>

                <template x-for="item in checkpoints" :key="item.id">
                    <label style="display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:6px; cursor:pointer;"
                           onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'">
                        <input type="checkbox"
                               :checked="selectedCheckpointIdsForDelete.includes(item.id)"
                               @change="
                                   if ($event.target.checked) { if (!selectedCheckpointIdsForDelete.includes(item.id)) selectedCheckpointIdsForDelete.push(item.id); }
                                   else { selectedCheckpointIdsForDelete = selectedCheckpointIdsForDelete.filter(id => id !== item.id); }
                               ">
                        <span style="font-size:12px; color:#E5E7EB;" x-text="item.title"></span>
                    </label>
                </template>

                <button @click="deleteSelectedCheckpoints()" type="button"
                        :disabled="selectedCheckpointIdsForDelete.length === 0 || deletingCheckpoints"
                        :style="selectedCheckpointIdsForDelete.length === 0 || deletingCheckpoints
                            ? 'background:#374151; color:#6B7280; cursor:not-allowed;'
                            : 'background:#7f1d1d; color:#fecaca; cursor:pointer;'"
                        style="margin-top:6px; text-align:center; border:none; padding:8px 10px; border-radius:6px; font-size:13px; font-weight:600;"
                        x-text="deletingCheckpoints ? 'Menghapus...' : ('Hapus (' + selectedCheckpointIdsForDelete.length + ') Checkpoint Terpilih')">
                </button>
            </div>
        </template>
    </div>

    {{-- =========================================================
         CHECKPOINT DROPDOWN
         Small position:fixed popover (same anchoring pattern as the Clear
         All menu above) opened from the chevron next to "Simpan" - picks a
         checkpoint to display on the live board for everyone in the room
         (see openCheckpoint()). No delete control here on purpose - see
         the Clear All popover's own checkpoint sub-view instead.
         ========================================================= --}}
    <div x-show="showCheckpointPanel"
         x-cloak
         @click.outside="showCheckpointPanel = false"
         :style="{
             position: 'fixed',
             pointerEvents: 'auto',
             left: checkpointPanelX + 'px',
             top: checkpointPanelY + 'px',
             transform: 'translateY(-100%) translateY(-8px)',
             background: '#1F2937',
             border: '1px solid #374151',
             borderRadius: '8px',
             padding: '6px',
             zIndex: 999999,
             boxShadow: '0 8px 24px rgba(0,0,0,0.35)',
             minWidth: '220px',
             maxHeight: '320px',
             overflowY: 'auto',
             display: 'flex',
             flexDirection: 'column',
             gap: '2px',
         }">
        <div x-show="checkpointsLoading" style="text-align:center; color:#9CA3AF; font-size:12px; padding:12px 0;">
            Memuat checkpoint...
        </div>
        <div x-show="!checkpointsLoading && checkpoints.length === 0" style="text-align:center; color:#6B7280; font-size:12px; padding:12px 0;">
            Belum ada checkpoint. Klik "Simpan" di toolbar untuk membuat satu.
        </div>
        <template x-for="item in checkpoints" :key="item.id">
            <button @click="openCheckpoint(item.id)" type="button" :disabled="openingCheckpointId === item.id"
                    style="text-align:left; background:none; border:none; padding:8px 10px; border-radius:6px; color:#E5E7EB; font-size:13px; cursor:pointer;"
                    onmouseover="this.style.background='#374151'" onmouseout="this.style.background='none'"
                    x-text="openingCheckpointId === item.id ? 'Membuka...' : item.title">
            </button>
        </template>
    </div>

    {{-- =========================================================
         DOCKED PEEK TAB
         Shown instead of the full panel while hidden/docked to an
         edge. Slightly protrudes ("menonjol") from the left or right
         side of the screen; clicking it restores the panel to where
         it was. Local-only UI state - never synced to other users.
         ========================================================= --}}
    <button x-show="explanationMode && hidden"
            x-cloak
            @click="hidden = false"
            type="button"
            title="Tampilkan Whiteboard"
            class="flex items-center justify-center"
            :style="{
                position: 'fixed',
                top: panelY + 'px',
                left: hiddenSide === 'left' ? '0px' : 'auto',
                right: hiddenSide === 'right' ? '0px' : 'auto',
                width: '32px',
                height: '96px',
                background: '#111827',
                color: '#fff',
                borderRadius: hiddenSide === 'left' ? '0 12px 12px 0' : '12px 0 0 12px',
                boxShadow: '0 10px 30px rgba(0,0,0,0.35)',
                zIndex: 999999,
                border: 'none',
                cursor: 'pointer',
                pointerEvents: 'auto',
            }">
        <svg :style="{ width: '16px', height: '16px', transform: hiddenSide === 'left' ? 'none' : 'scaleX(-1)' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- =========================================================
         TEXT INPUT OVERLAY
         Shown when the 'text' tool is used.
         ========================================================= --}}
    <input type="text"
           id="live-drawing-text-input"
           x-show="textInput.visible"
           x-cloak
           x-model="textInput.text"
           @keydown.enter="handleTextEnterKey($event)"
           @blur="finalizeText()"
           class="fixed bg-transparent border border-dashed border-gray-400 outline-none px-1"
           :style="{
               left: textInput.px + 'px',
               top: (textInput.py - 12) + 'px',
               color: color,
               fontSize: '24px',
               fontFamily: 'sans-serif',
               pointerEvents: 'auto',
               zIndex: 999999,
               width: measureTextWidth() + 'px',
               transform: 'translateY(-50%)',
           }"
           placeholder="Ketik teks...">

    {{-- Small hint explaining the ruled-lines Enter/Shift+Enter behavior,
         shown right under the text input while it's active. --}}
    <div x-show="textInput.visible && ruledLines"
         x-cloak
         class="fixed"
         :style="{
             left: textInput.px + 'px',
             top: (textInput.py + 16) + 'px',
             fontSize: '11px',
             color: '#6B7280',
             fontFamily: 'sans-serif',
             background: 'rgba(255,255,255,0.92)',
             padding: '2px 8px',
             borderRadius: '6px',
             boxShadow: '0 2px 6px rgba(0,0,0,0.15)',
             pointerEvents: 'none',
             zIndex: 999999,
             whiteSpace: 'nowrap',
         }">
        Enter: baris baru &bull; Shift+Enter: selesai
    </div>

    {{-- =========================================================
         PENDING PASTED IMAGE OVERLAY
         Shown right after pasting an image (see handlePaste()/
         showPendingImage()) - resizable (drag a corner, aspect
         ratio locked) and movable (drag the image itself) before
         it's actually committed onto the canvas as real pixels,
         so "ukuran image yang dipaste" is never just "however big
         the source happened to be". width/height in the style below
         are *zoomLevel: pendingImage.width/height are canvas-space
         (what commitPendingImage() actually draws at) - this overlay
         lives outside the zoomed wrapper in real screen pixels, so its
         on-screen size has to scale up too.
         ========================================================= --}}
    <div x-show="pendingImage.visible"
         x-cloak
         class="fixed"
         :style="{
             left: pendingImage.px + 'px',
             top: pendingImage.py + 'px',
             width: (pendingImage.width * zoomLevel) + 'px',
             height: (pendingImage.height * zoomLevel) + 'px',
             zIndex: 999999,
             cursor: 'move',
             border: '2px dashed #4F46E5',
             boxSizing: 'border-box',
             touchAction: 'none',
             // #live-drawing-container (the whole component's root) sits at
             // pointer-events:none so it never blocks clicks on the actual
             // page underneath - every interactive piece has to opt back
             // in explicitly (see #whiteboard-panel and the text input
             // overlay for the same pattern). This overlay lives OUTSIDE
             // #whiteboard-panel's own DOM (positioned via fixed +
             // px/py to just visually align with it), so without this it
             // and everything inside it - handles included - silently
             // can't receive ANY clicks at all, not just the corner ones.
             pointerEvents: 'auto',
         }"
         @pointerdown.stop="startPendingImageDrag($event)">
        <img :src="pendingImage.src" draggable="false"
             style="display:block; width:100%; height:100%; object-fit:fill; pointer-events:none; user-select:none;">

        {{-- Corner resize handles - aspect ratio is always preserved (see resizePendingImage()). --}}
        <template x-for="corner in ['nw', 'ne', 'sw', 'se']" :key="corner">
            <div @pointerdown.stop="startPendingImageResize(corner, $event)"
                 :style="{
                     position: 'absolute',
                     width: '14px', height: '14px',
                     background: '#4F46E5',
                     border: '2px solid #fff',
                     borderRadius: '3px',
                     boxShadow: '0 1px 3px rgba(0,0,0,0.3)',
                     cursor: (corner === 'nw' || corner === 'se') ? 'nwse-resize' : 'nesw-resize',
                     top: corner.includes('n') ? '-7px' : 'auto',
                     bottom: corner.includes('s') ? '-7px' : 'auto',
                     left: corner.includes('w') ? '-7px' : 'auto',
                     right: corner.includes('e') ? '-7px' : 'auto',
                     touchAction: 'none',
                 }">
            </div>
        </template>

        {{-- Commit/cancel controls, anchored just below the image. --}}
        <div @pointerdown.stop style="position:absolute; bottom:-42px; left:0; display:flex; gap:6px; white-space:nowrap;">
            <button @click="commitPendingImage()" type="button"
                    style="background:#4F46E5; color:#fff; border:none; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                &check; Selesai
            </button>
            <button @click="cancelPendingImage()" type="button"
                    style="background:#fff; color:#374151; border:1px solid #d1d5db; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                &times; Batal
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
            /** The whiteboard room being viewed - a student's user ID. Everyone
             *  in the room (the student themselves, or staff via live-preview)
             *  can both draw and receive everyone else's strokes. */
            targetUserId: null,
            /** True when embedded in Admin/Teacher's Live Student View iframe
             *  (?live_preview_for=... present) - hides the on-page toggle
             *  button since that page drives explanationMode externally. */
            isEmbeddedPreview: false,
            /** True when this whiteboard session should render as a lean,
             *  transparent, full-viewport overlay directly on top of the
             *  visible content (no draggable panel/header/broadcast
             *  controls) instead of the normal floating "papan putih"
             *  window - see toggleExplanationMode()'s isEmbeddedPreview
             *  branch (staff side, via Admin's "Mode Coret-Coret") and
             *  pollDrawingState()'s auto-open branch (student side, mirrors
             *  whatever the staff member's presence ping reports via
             *  staffMode). Always false for the normal on-page Whiteboard
             *  tool (pencil-icon button, ruled lines, class broadcast,
             *  etc.) - those flows never touch this flag. */
            directOverlayMode: false,
            /** Measured full document height (see initCanvas()'s
             *  ResizeObserver), used only by directOverlayMode's panel so
             *  it spans the ENTIRE scrollable page (not just one viewport)
             *  and is position:absolute rather than position:fixed - the
             *  browser's native page scroll then moves the overlay (and
             *  the ink on it) together with the underlying content for
             *  free, with no manual scroll-syncing JS needed. Falls back
             *  to 100vh in the template until the first measurement. */
            directOverlayDocHeight: 0,
            /** directOverlayMode only: independently-scrollable sub-areas
             *  of the page detected once when the session opens (see
             *  setupScrollRegions()) - e.g. a sticky sidebar with its own
             *  overflow-y:auto, whose internal scroll never moves the main
             *  page/window scroll that directOverlayDocHeight tracks. Each
             *  entry is { key, el, myCanvasId, otherCanvasId } describing a
             *  small canvas pair injected as that container's own child (so
             *  the browser's native internal scroll carries it along
             *  automatically). `key` is a hash of the container's own class
             *  list (+ an occurrence counter for duplicates), NOT a plain
             *  0/1/2... position-in-DOM index - confirmed live that Admin's
             *  Live Student View iframe can render a different SET of
             *  scrollable containers than the real student's own page (it
             *  doesn't include this page's own nav sidebar), which silently
             *  shifted plain index-based matching onto the wrong element
             *  entirely. A class-derived key only depends on this element's
             *  own markup, so it still matches correctly regardless of what
             *  else does or doesn't also exist on either side. Empty array
             *  outside directOverlayMode. */
            scrollRegions: [],
            /** Other position:fixed page elements (e.g. a floating Save
             *  button) temporarily z-index-boosted by setupScrollRegions()
             *  so a region's own z-index:999999 never visually covers
             *  them - see that method's docblock. Each entry is
             *  { el, originalZIndex }, restored by teardownScrollRegions(). */
            protectedFixedEls: [],
            /** Which canvas a stroke is CURRENTLY targeting: null for the
             *  main page canvas, or the matching key into scrollRegions -
             *  set by startDrawing()'s context-switch (see its docblock) by
             *  reading which physical canvas the pointer actually landed
             *  on, then read by syncDrawingToServer() to tag the sync with
             *  the right region. Everything else in the drawing engine
             *  (draw()/stopDrawing()/every tool) is unaffected - they just
             *  keep operating on whatever this.ctx/this.myCanvasId already
             *  point to, exactly as before regions existed. */
            activeRegion: null,
            /** Per-region history/redoStack, keyed by canvasId - lazily
             *  created. startDrawing()'s context-switch swaps this.history/
             *  this.redoStack to point at the right entry here, mirroring
             *  the exact same swap-pointer pattern switchTab() already uses
             *  for the Notebook tab's separate history (see its docblock).
             *  The main canvas's own history never moves into here - it
             *  stays as this.history/this.redoStack's default identity. */
            regionHistory: {},

            // ── Batch broadcast mode ──────────────────────────────────────
            /** Staff-only: true while THIS staff member has broadcasting
             *  turned on via the "Aktifkan" button. Never touches
             *  targetUserId - it stays this instance's own room the whole
             *  time (see toggleBroadcast()); this only controls who ELSE is
             *  currently authorized to view it. */
            broadcastActive: false,
            /** 'all' | 'specific' - which target mode is selected in the
             *  broadcast control bar. */
            broadcastTargetMode: 'all',
            /** Current text in the "cari nama siswa" search box. */
            studentSearchQuery: '',
            /** Results of the last searchStudents() call - [{id, name}]. */
            studentSearchResults: [],
            /** Batch name the last searchStudents() call scoped results to
             *  (see LiveDrawingController::searchStudents()), or null when
             *  it fell back to an unscoped search across all students. */
            studentSearchScopedTo: null,
            /** Student ids picked from studentSearchResults when
             *  broadcastTargetMode === 'specific'. Posted via
             *  updateBatchTargets() on every change. */
            selectedStudentIds: [],
            /** Whether the specific-student picker's search box + checkbox
             *  list is expanded (vs. collapsed to just its summary row) -
             *  lets the teacher reclaim canvas space once they're done
             *  picking, without losing the current selection. */
            specificPickerExpanded: true,
            /** True while this student's canvas is showing a broadcast
             *  instead of their own individual room - see
             *  checkBatchStatus(). Locks drawing (readOnlyMode) since a
             *  broadcast is broadcaster-write/student-read-only. */
            batchViewActive: false,
            /** Saved so checkBatchStatus() can restore the student's own
             *  room's targetUserId once the batch broadcast ends. */
            preBatchTargetUserId: null,
            /** Saved so checkBatchStatus() can restore the student's own
             *  ruled-lines preference once the batch broadcast ends (see
             *  toggleRuledLines()) - while watching, it mirrors the
             *  broadcaster's own setting instead. */
            preBatchRuledLines: false,
            /** Saved so checkBatchStatus() can restore the student's own
             *  zoom level once the batch broadcast ends (see setZoom()) -
             *  while watching, it mirrors the broadcaster's own zoom instead. */
            preBatchZoomLevel: 1,
            /** setInterval handle for checkBatchStatus() - runs for every
             *  non-staff viewer (see init()). */
            batchCheckInterval: null,
            /** True while batchViewActive - blocks startDrawing() and hides
             *  the toolbar, since a batch broadcast is read-only for students. */
            readOnlyMode: false,
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
            /** setInterval handle for the staff-side presence heartbeat
             *  (see sendPresence()) - only ever set while isStaffViewer and
             *  explanationMode are both true. */
            presenceHeartbeat: null,
            /** setInterval handle for the broadcast-mode presence heartbeat
             *  (see toggleBroadcast()) - kept separate from presenceHeartbeat
             *  above so turning broadcasting on/off never affects the
             *  individual-room (live_preview_for) presence heartbeat. */
            broadcastHeartbeat: null,
            /** Student-side only: true once the student has manually closed
             *  a panel that was auto-opened by the teacher's presence, so
             *  the very next poll doesn't immediately reopen it. Reset back
             *  to false as soon as staffActive goes false→true again (a
             *  fresh activation), so it doesn't stay open forever. */
            autoOpenSuppressed: false,
            /** Active tool: 'pen' | 'highlight' | 'laser' | 'eraser' */
            tool: 'pen',
            /** Current resolved color (may include rgba for highlight) */
            color: '#EF4444',
            /** Base hex color before opacity conversion */
            baseColor: '#EF4444',
            /** Opacity for highlight tool */
            opacity: 0.35,
            lineWidth: 3,
            /** Remembered stroke diameters per tool, adjustable via the
             *  toolbar slider (see setTool()) - kept separate so picking a
             *  size for Pen doesn't silently also change Hapus's size (and
             *  vice versa) the next time that tool is selected. */
            penWidth: 3,
            eraserWidth: 40,
            /** Live eraser-size preview circle (canvas-space coordinates,
             *  same space as ctx drawing calls, since the canvas's pixel
             *  buffer and CSS size are always kept 1:1 - see resizeCanvas()).
             *  `hovering` hides it once the pointer leaves the canvas so it
             *  doesn't stay frozen in the last position. */
            eraserCursor: { x: 0, y: 0, hovering: false },
            /** Table tool grid size, adjustable via the toolbar's Baris/
             *  Kolom inputs while tool === 'table'. Captured into
             *  shapePreview at click-time (see startDrawing()) so an
             *  in-progress table's grid count doesn't shift mid-drag if
             *  these are changed. */
            tableRows: 3,
            tableCols: 3,

            /** Available color palettes */
            colors: {
                pen:       ['#EF4444', '#F97316', '#FACC15', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#111827', '#FFFFFF'],
                highlight: ['#FFFF00', '#FDBA74', '#86EFAC', '#93C5FD', '#F9A8D4', '#C4B5FD', '#FCA5A5', '#67E8F9'],
            },

            /** Laser paths state */
            laserPaths: [],
            laserCtx: null,

            /** Text tool visual state */
            textInput: { visible: false, x: 0, y: 0, px: 0, py: 0, text: '' },

            /** Pasted-image resize/move overlay state (see handlePaste()/
             *  showPendingImage()) - x/y/width/height are CANVAS-space (what
             *  actually gets drawn onto commit); px/py mirror textInput's
             *  own pattern, the derived VIEWPORT-space position the fixed
             *  overlay <div> is actually shown at. `src` is an object URL
             *  for the overlay's own <img> tag; the loaded Image element
             *  itself (needed again at commit time to draw onto the
             *  canvas) is kept OUTSIDE this reactive object, in
             *  _pendingImageEl, since Alpine proxying a live DOM element is
             *  asking for trouble. */
            pendingImage: { visible: false, src: null, aspectRatio: 1, x: 0, y: 0, width: 0, height: 0, px: 0, py: 0 },
            _pendingImageEl: null,
            _pendingImageDrag: null,
            _pendingImageResize: null,

            /** Live rubber-band preview while dragging a shape tool (rectangle/
             *  ellipse/line/arrow) - rendered onto the laser canvas each frame
             *  by animateLaser() so it doesn't fight that loop's own clearRect.
             *  null when no shape is currently being dragged. */
            shapePreview: null,

            /** Undo history: a stack of full-canvas PNG snapshots captured
             *  right before each mutating action (stroke/shape/text/clear).
             *  Capped so it can't grow unbounded during a long session. */
            history: [],
            historyLimit: 15,

            /** True while an undo() restore is in flight (the popped
             *  snapshot is an async image decode). Without this guard, a
             *  fast double-click/repeat click on Undo pops another history
             *  entry immediately - before the first pop has even been
             *  drawn/perceived - so what feels like "one click" can silently
             *  remove several strokes at once, emptying the whole board if
             *  there were only a couple to begin with. */
            undoing: false,

            /** Redo stack: mirror of `history`, but for states undo() has
             *  moved past. Every undo() pushes the state it's about to
             *  replace here; every redo() pops it back and pushes the
             *  pre-redo state onto `history` so it can be undone again.
             *  Cleared by pushHistory() whenever a genuinely NEW action
             *  happens, since the old "future" is no longer valid once the
             *  user draws something different after undoing. */
            redoStack: [],
            redoing: false,

            /** Ruled notebook-paper lines toggle. Purely a local CSS overlay
             *  (see #whiteboard-canvas-body) - not synced to the room, so
             *  each participant can turn their own alignment guide on/off
             *  without affecting what anyone else sees. While active, every
             *  click becomes text placement snapped to the nearest line
             *  (see startDrawing()), like typing on ruled paper. */
            ruledLines: false,
            /** Spacing between ruled lines in canvas pixels - must match the
             *  32px used in the #whiteboard-canvas-body background-image. */
            ruledLineHeight: 32,

            /** The canvas's current actual pixel height, which can be TALLER
             *  than the visible viewport (#whiteboard-canvas-body scrolls
             *  vertically when that happens). Never smaller than the
             *  viewport - only grows, via ensureCanvasHeight(), so writing
             *  or drawing never gets hard-clipped at the bottom edge.
             *  Reset back down to viewport height by clearCanvases('all'). */
            canvasContentHeight: 0,
            /** Same high-water-mark idea as canvasContentHeight, but for
             *  width: resizeCanvas() used to size the canvas to the panel
             *  body's CURRENT clientWidth on every call, with no floor - if
             *  the body ever got narrower even briefly (e.g. a scrollbar
             *  appearing on the page behind the panel, firing a window
             *  resize), the canvas shrank to match, and getImageData/
             *  putImageData's "preserve content" step silently clips
             *  anything to the right of the new, narrower width - gone for
             *  good even after the panel widens back out, since the pixels
             *  were never captured. Never smaller than the viewport, same
             *  reset-on-clear rule as canvasContentHeight. */
            canvasContentWidth: 0,
            /** How many px to grow the canvas by (at minimum) each time
             *  content approaches the bottom edge. */
            canvasGrowStep: 400,

            /** Canvas zoom level (1 = 100%). Applied as CSS `zoom` (a real
             *  layout property, unlike `transform:scale`) to a dedicated
             *  wrapper around just the 3 canvases (see
             *  #whiteboard-canvas-zoom-wrapper) - NOT to #whiteboard-canvas-body
             *  itself, so the eraser cursor/archive panel/paste catcher stay
             *  at normal UI scale regardless of zoom. Because it's a real
             *  layout zoom, the browser handles scrolling/overflow
             *  correctly on its own; what it does NOT do automatically is
             *  keep canvas-space math correct - every place that converts
             *  between screen pixels and canvas-space coordinates
             *  (getPointerPos(), the text input overlay, the pending-image
             *  overlay, the eraser cursor) has to divide/multiply by this
             *  explicitly, since those overlays live OUTSIDE the zoomed
             *  wrapper (positioned via `fixed`/`absolute` + computed px). */
            zoomLevel: 1,
            zoomMin: 0.5,
            zoomMax: 2,
            zoomStep: 0.1,

            // ── Student Notebook (see switchTab()/#whiteboard-notebook-body) ──
            /** 'whiteboard' | 'notebook' - which tab a STUDENT is currently
             *  viewing. Meaningless for staff (they never see the tab
             *  switcher and always effectively act as 'whiteboard'). Never
             *  synced anywhere - purely local UI state, same as `hidden`/
             *  `docked`. */
            activeTab: 'whiteboard',
            /** Fixed at init() to the actually-authenticated user's own id
             *  (see ownUserId assignment below) - unlike targetUserId, this
             *  NEVER changes, not for live_preview_for, not for watching a
             *  broadcast. The notebook is always "my own", regardless of
             *  whose room targetUserId currently points at. */
            ownUserId: null,
            notebookCanvasId: 'student-notebook-canvas',
            /** Undo/redo stacks for the Notebook tab - kept separate from
             *  the whiteboard's own `history`/`redoStack` (which this.history/
             *  this.redoStack point at instead while activeTab==='whiteboard')
             *  so switching tabs never lets you undo one surface's strokes
             *  from the other. See switchTab(). */
            notebookHistory: [],
            notebookRedoStack: [],
            /** Stash for the whiteboard's own history/redoStack while the
             *  Notebook tab is active (see switchTab()) - restored the
             *  moment the user switches back. */
            _wbHistory: [],
            _wbRedoStack: [],
            /** The notebook layer's own diffing cursor (see
             *  pollNotebookState()) - mirrors lastFetchTimeStaff/Student's
             *  role for the whiteboard. */
            notebookLastFetchTime: 0,
            notebookPollInterval: null,

            /** True while a grow-the-canvas resize is in flight (snapshot →
             *  resize → redraw is async), so overlapping grow calls don't
             *  race each other and corrupt the canvas content. */
            growingCanvas: false,

            /** True while a "Unduh PDF" request is in flight - disables the
             *  button and swaps its icon so a second click can't fire a
             *  duplicate download while the first is still generating. */
            pdfExporting: false,

            /** True while the manual "Simpan" button's save request is in
             *  flight. saveConfirmed briefly flips true after it succeeds so
             *  the button shows a checkmark before reverting to idle. */
            savingManually: false,
            saveConfirmed: false,

            /**
             * "Simpan" checkpoints - every manualSave() click, in addition to
             * the plain autosave it already did, also captures the current
             * canvas (both layers) as a new, permanent, named checkpoint row
             * (WhiteboardCheckpoint - separate table from WhiteboardArchive,
             * see LiveDrawingController). Deliberately NOT individually
             * deletable from this dropdown (no per-item delete button, no
             * DELETE-single-checkpoint route at all) - the only way to
             * remove one is selecting it in Clear All's own checkpoint
             * sub-view (see clearMenuView below), matching "checkpoint hanya
             * bisa dihapus menggunakan clear all".
             * showCheckpointPanel is a small position:fixed dropdown
             * (checkpointPanelX/Y, same anchoring pattern as
             * showClearMenu/clearMenuX/Y below) rather than a full-canvas
             * overlay like Arsip's browser - meant to be a quick "jump to an
             * earlier saved point" picker sitting right next to Simpan, not
             * a whole separate screen.
             */
            checkpoints: [],
            checkpointsLoading: false,
            showCheckpointPanel: false,
            checkpointPanelX: 0,
            checkpointPanelY: 0,
            openingCheckpointId: null,

            /** "Arsipkan" (save-as-new-archive) + "Arsip" (browse/open/delete
             *  archives) state. Archives are separate, permanent, named
             *  snapshots - unlike the single continuously-autosaved board
             *  above, they are never overwritten and stick around until the
             *  user deletes them. */
            archivingNow: false,
            archiveConfirmed: false,
            showArchivePanel: false,
            archivesLoading: false,
            archives: [],
            openingArchiveId: null,

            /** Clear All popover menu (Bersihkan Semua / Guru-Admin /
             *  Siswa) - position: fixed, anchored above the button it was
             *  opened from via toggleClearMenu(). clearMenuView switches the
             *  SAME popover between the normal scope buttons ('main') and a
             *  checkbox list of checkpoints to bulk-delete ('checkpoints') -
             *  see toggleClearMenuCheckpointView()/deleteSelectedCheckpoints() -
             *  the only place a checkpoint can ever be removed from. */
            showClearMenu: false,
            clearMenuX: 0,
            clearMenuY: 0,
            clearMenuView: 'main',
            selectedCheckpointIdsForDelete: [],
            deletingCheckpoints: false,

            // Floating panel position/drag state
            panelX: 100,
            panelY: 100,
            // Wide enough that the full toolbar (all tools + the larger,
            // fuller color palette) fits without needing to scroll it on a
            // typical screen; still resizable/scrollable for smaller ones.
            panelWidth: 760,
            panelHeight: 480,
            dragging: false,
            dragStartX: 0,
            dragStartY: 0,
            dragPanelStartX: 0,
            dragPanelStartY: 0,

            // Floating panel resize state
            resizing: false,
            resizeStartX: 0,
            resizeStartY: 0,
            resizeStartWidth: 0,
            resizeStartHeight: 0,
            panelMinWidth: 360,
            panelMinHeight: 280,

            /** Docked/hidden state - purely local UI state, never synced to
             *  the room API, so each participant hides/shows their own copy
             *  independently without affecting anyone else's view. */
            hidden: false,
            hiddenSide: 'right',

            // Polling state
            /** The microtime timestamp of the last successful fetch, per layer */
            lastFetchTimeStaff: 0,
            lastFetchTimeStudent: 0,
            /** Same out-of-order-guard/last-seen tracking as
             *  lastFetchTimeStaff/Student above, but per scroll region -
             *  keyed by "staff_r{key}"/"student_r{key}" (see scrollRegions'
             *  docblock for what `key` is and why). */
            regionFetchTimes: {},
            /** setInterval handle for polling */
            pollingInterval: null,
            /** Prevent concurrent sync requests */
            _syncInFlight: false,
            /** Bumped every time a local stroke/shape/text/undo/redo/clear
             *  starts touching MY OWN canvas; syncedEditVersion records
             *  which version was last confirmed synced to the server. While
             *  they differ, the local canvas has pixels the server doesn't
             *  know about yet - pollDrawingState() uses this to avoid
             *  clobbering them with a stale server snapshot (see
             *  renderBase64ToCanvas()). */
            localEditVersion: 0,
            syncedEditVersion: 0,

            // ── Dual-layer state (staff/teacher vs student, independently
            //    clearable - see Clear All menu and LiveDrawingController) ──
            /** Whether the current viewer is staff (admin/teacher/intern),
             *  resolved once at init() from the authenticated user's role.
             *  Determines which of the two canvases this viewer draws on. */
            isStaffViewer: false,
            /** DOM id of the canvas THIS viewer draws/undoes/erases on. */
            myCanvasId: 'global-live-drawing-canvas',
            /** DOM id of the canvas showing the OTHER role's content -
             *  read-only for this viewer, only ever painted from polling. */
            otherCanvasId: 'student-live-drawing-canvas',
            /** 2D context for otherCanvasId, set up alongside this.ctx in
             *  initCanvas()/resizeCanvas(). */
            otherCtx: null,

            // ── Lifecycle ──────────────────────────────────────────────────

            init() {
                window.addEventListener('message', (e) => {
                    if (e.data && e.data.type === 'TOGGLE_CORET') {
                        this.toggleExplanationMode();
                    }
                });

                // Global (not bound to the canvas itself, which can't hold
                // keyboard focus) - handlePaste() itself checks
                // explanationMode/readOnlyMode/focus target before acting,
                // so a paste anywhere else on the page (a real text field,
                // etc.) is left completely alone.
                window.addEventListener('paste', (e) => this.handlePaste(e));

                // Best-effort: if a staff member closes/navigates away
                // while their panel is open, tell the student's poll to
                // stop treating this room as "teacher active" instead of
                // waiting out the full presence TTL. keepalive lets the
                // request survive the page already unloading.
                window.addEventListener('beforeunload', () => {
                    if (this.isStaffViewer && this.explanationMode) {
                        this.sendPresence(false);
                    }
                });

                // Which layer this viewer draws on - resolved from their
                // actual authenticated role (never from URL/preview state),
                // so it's correct whether they're on their own page or
                // viewing someone else's room via live_preview_for.
                this.isStaffViewer = {{ auth()->user() && in_array(auth()->user()->role, ['admin', 'teacher', 'intern']) ? 'true' : 'false' }};
                // Always the actually-authenticated user's own id, entirely
                // separate from targetUserId (which live_preview_for and
                // batch-broadcast watching both legitimately repoint at
                // someone/something else) - see activeTab's docblock above.
                this.ownUserId = {{ auth()->id() ?? 'null' }};
                if (this.isStaffViewer) {
                    this.myCanvasId    = 'global-live-drawing-canvas';
                    this.otherCanvasId = 'student-live-drawing-canvas';
                } else {
                    this.myCanvasId    = 'student-live-drawing-canvas';
                    this.otherCanvasId = 'global-live-drawing-canvas';
                }

                const href = window.location.href;

                // Resolve which room this page belongs to: URL contains
                // ?live_preview_for={id} when staff are watching a specific
                // student (e.g. /admin/students/91/current-assignment?live_preview_for=42);
                // otherwise the room is the current authenticated user's own page.
                const previewMatch = href.match(/live_preview_for=(\d+)/);
                if (previewMatch) {
                    this.isEmbeddedPreview = true;
                    this.targetUserId      = previewMatch[1];
                    // Admin's Live Student View ("Mode Coret-Coret") always
                    // wants the lean direct-overlay presentation, for this
                    // instance's entire lifetime - see directOverlayMode's
                    // docblock.
                    this.directOverlayMode = true;
                    console.log('[LiveDrawing] Room (via live preview):', this.targetUserId);
                } else {
                    this.isEmbeddedPreview = false;
                    // Blade renders the authenticated user's ID server-side
                    this.targetUserId = {{ auth()->id() ?? 'null' }};
                    console.log('[LiveDrawing] Room (own page):', this.targetUserId);
                }

                // Default the floating panel to the right side of the
                // viewport, clear of the toggle button and other floating
                // widgets, but fully draggable from there afterward.
                this.panelX = Math.max(20, window.innerWidth - this.panelWidth - 20);
                this.panelY = 90;

                this.$nextTick(() => {
                    this.initCanvas();
                    this.initWebSocket();

                    // Everyone in the room always polls — it's both the primary
                    // transport when WS is disabled, and a reliability layer
                    // (catching missed whispers / late joiners) when WS is enabled.
                    this.initPolling();

                    // Start laser animation loop
                    this.animateLaser();

                    // Every non-staff viewer checks for an incoming batch
                    // broadcast - targeting isn't tied to a class/roster
                    // anymore, so any student could be picked by any staff
                    // member at any time (see checkBatchStatus()).
                    if (!this.isStaffViewer && !this.batchCheckInterval) {
                        this.checkBatchStatus();
                        this.batchCheckInterval = setInterval(() => this.checkBatchStatus(), 5000);
                    }
                });
            },

            // ── Drag Handling ──────────────────────────────────────────────

            /** Begin dragging the floating panel from its header. */
            startDrag(e) {
                this.dragging = true;
                this.dragStartX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                this.dragStartY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                this.dragPanelStartX = this.panelX;
                this.dragPanelStartY = this.panelY;

                const onMove = (ev) => this.onDrag(ev);
                const onUp = () => {
                    this.dragging = false;
                    window.removeEventListener('pointermove', onMove);
                    window.removeEventListener('pointerup', onUp);
                };
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
            },

            /** Follow the pointer while dragging, clamped to stay on-screen. */
            onDrag(e) {
                if (!this.dragging) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);

                const panel = document.getElementById('whiteboard-panel');
                const w = panel ? panel.offsetWidth : 640;
                const h = panel ? panel.offsetHeight : 480;

                let nextX = this.dragPanelStartX + (clientX - this.dragStartX);
                let nextY = this.dragPanelStartY + (clientY - this.dragStartY);

                // Keep at least a sliver of the header on-screen so it's
                // never lost/undraggable off the edge of the viewport.
                nextX = Math.min(Math.max(nextX, -w + 80), window.innerWidth - 80);
                nextY = Math.min(Math.max(nextY, 0), window.innerHeight - 44);

                this.panelX = nextX;
                this.panelY = nextY;
            },

            // ── Dock / Hide to Edge ────────────────────────────────────────

            /**
             * Collapse the panel to a small peeking tab on whichever edge
             * (left or right) it's currently closest to. panelX/panelY are
             * left untouched, so unhiding snaps the panel straight back to
             * exactly where it was. This is local-only UI state - it never
             * touches the sync API, so it can't affect what anyone else in
             * the room sees.
             */
            dockToNearestSide() {
                const panelCenter = this.panelX + (this.panelWidth / 2);
                this.hiddenSide = panelCenter < (window.innerWidth / 2) ? 'left' : 'right';
                this.hidden = true;
            },

            // ── Resize Handling ────────────────────────────────────────────

            /** Begin resizing the floating panel from its corner grip. */
            startResize(e) {
                this.resizing = true;
                this.resizeStartX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                this.resizeStartY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                this.resizeStartWidth = this.panelWidth;
                this.resizeStartHeight = this.panelHeight;

                const onMove = (ev) => this.onResize(ev);
                const onUp = () => {
                    this.resizing = false;
                    window.removeEventListener('pointermove', onMove);
                    window.removeEventListener('pointerup', onUp);
                    // Canvas dimensions must match the new panel body size -
                    // resizeCanvas() preserves the existing drawing content.
                    this.resizeCanvas();
                };
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
            },

            /** Follow the pointer while resizing, clamped to sane bounds. */
            onResize(e) {
                if (!this.resizing) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);

                let nextWidth  = this.resizeStartWidth + (clientX - this.resizeStartX);
                let nextHeight = this.resizeStartHeight + (clientY - this.resizeStartY);

                nextWidth  = Math.min(Math.max(nextWidth, this.panelMinWidth), window.innerWidth - this.panelX - 10);
                nextHeight = Math.min(Math.max(nextHeight, this.panelMinHeight), window.innerHeight - this.panelY - 10);

                this.panelWidth  = nextWidth;
                this.panelHeight = nextHeight;

                // Live-resize the canvas while dragging (not just on release)
                // so the drawing surface visibly tracks the grip in real time.
                // $nextTick because the DOM needs to reflect the new
                // panelWidth/panelHeight before we measure the body element.
                this.$nextTick(() => this.resizeCanvas());
            },

            // ── Canvas Setup ───────────────────────────────────────────────

            initCanvas() {
                // One-time setup: keep directOverlayDocHeight in sync with
                // the page's actual scrollable height, so directOverlayMode's
                // panel (see its :style below) can span the full document
                // instead of just one viewport. Harmless/cheap to always run
                // regardless of mode - guarded so re-entering initCanvas()
                // (e.g. via resizeCanvas()'s !this.ctx branch) never attaches
                // a second observer.
                if (!this._docHeightObserverSetup) {
                    this._docHeightObserverSetup = true;
                    const updateDocHeight = () => {
                        const next = Math.max(document.documentElement.scrollHeight, window.innerHeight);
                        if (next !== this.directOverlayDocHeight) {
                            this.directOverlayDocHeight = next;
                            if (this.directOverlayMode && this.explanationMode) {
                                this.resizeCanvas();
                            }
                        }
                    };
                    updateDocHeight();
                    new ResizeObserver(updateDocHeight).observe(document.documentElement);
                }

                const body = document.getElementById(this.activeCanvasBodyId());
                const canvas = document.getElementById(this.myCanvasId);
                const otherCanvas = document.getElementById(this.otherCanvasId);
                const laserCanvas = document.getElementById('laser-live-drawing-canvas');
                if (!body || !canvas || !otherCanvas || !laserCanvas) return;

                const width = body.clientWidth;
                // Never shorter than the visible viewport, but respects a
                // previously-grown height (e.g. panel re-opened after
                // writing several ruled lines) instead of resetting it.
                const height = Math.max(body.clientHeight, this.canvasContentHeight);
                // The panel is hidden (x-show) until explanationMode is first
                // toggled on, so its body has zero size at page-load time.
                // toggleExplanationMode() calls resizeCanvas() -> initCanvas()
                // again once it's actually visible and measurable.
                if (width === 0 || height === 0) return;

                [canvas, otherCanvas, laserCanvas].forEach((el) => {
                    el.width  = width;
                    el.height = height;
                    el.style.width = width + 'px';
                    el.style.height = height + 'px';
                    el.style.maxWidth = 'none';
                });

                this.canvasContentHeight = height;
                this.canvasContentWidth = width;

                this.ctx = canvas.getContext('2d');
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';

                // otherCtx is read-only from this viewer's perspective -
                // only ever painted into by polling (see pollDrawingState()),
                // never drawn on directly.
                this.otherCtx = otherCanvas.getContext('2d');
                this.otherCtx.lineCap = 'round';
                this.otherCtx.lineJoin = 'round';

                this.laserCtx = laserCanvas.getContext('2d');
                this.laserCtx.lineCap = 'round';
                this.laserCtx.lineJoin = 'round';
            },

            /**
             * Re-measure the panel's canvas body and resize the canvases to
             * match, preserving existing content. Needed both on window
             * resize AND right after the panel becomes visible again (while
             * hidden via x-show its body has zero width/height, so the very
             * first initCanvas() at page-load time can't size it correctly).
             */
            resizeCanvas() {
                if (!this.explanationMode) return;

                const body = document.getElementById(this.activeCanvasBodyId());
                const canvas = document.getElementById(this.myCanvasId);
                const otherCanvas = document.getElementById(this.otherCanvasId);
                const laserCanvas = document.getElementById('laser-live-drawing-canvas');

                if (!body || !canvas || !otherCanvas || !laserCanvas) return;

                // Math.max, not body.clientWidth directly - see
                // canvasContentWidth's docblock: shrinking the canvas even
                // briefly (e.g. a scrollbar toggling on the page behind the
                // panel) permanently clips any content to the right, since
                // getImageData/putImageData below can't preserve pixels
                // outside the new, narrower bounds.
                const width  = Math.max(body.clientWidth, this.canvasContentWidth);
                // Same "never shorter than viewport, but keep a grown
                // height" rule as initCanvas().
                const height = Math.max(body.clientHeight, this.canvasContentHeight);
                if (width === 0 || height === 0) return;

                if (!this.ctx) {
                    this.initCanvas();
                    return;
                }

                if (canvas.width !== width || canvas.height !== height) {
                    // Save MY OWN layer's content, resize, and restore.
                    const imageData = this.ctx.getImageData(0, 0, canvas.width, canvas.height);

                    canvas.width  = width;
                    canvas.height = height;
                    canvas.style.width = width + 'px';
                    canvas.style.height = height + 'px';
                    canvas.style.maxWidth = 'none';

                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                    this.ctx.putImageData(imageData, 0, 0);

                    // The OTHER (received-only) layer isn't preserved across
                    // a panel/window resize - it goes briefly blank and gets
                    // repainted by the next poll (≤1.5s). Resizing is rare
                    // enough that this is a fair trade for not having to
                    // track a duplicate copy of its last-received image just
                    // for this (unlike growCanvasHeight(), which runs on
                    // every stroke/line near the bottom edge and DOES
                    // preserve it - too frequent to accept the flicker there).
                    otherCanvas.width  = width;
                    otherCanvas.height = height;
                    otherCanvas.style.width = width + 'px';
                    otherCanvas.style.height = height + 'px';
                    otherCanvas.style.maxWidth = 'none';

                    // "Repainted by the next poll" above only actually
                    // happens if we also forget what we last saw - the poll
                    // only re-sends a layer's payload when the server has
                    // something NEWER than lastFetchTime*, so without this
                    // reset, a resize that lands after that layer's content
                    // was already fetched once would clear the canvas but
                    // never trigger a re-fetch, leaving it blank until the
                    // OTHER party draws something new. This is exactly the
                    // "otherwise correct" auto-attach flow in checkBatchStatus()
                    // being undone by a resize firing right after it (e.g.
                    // this is the FIRST resizeCanvas() call after ctx was
                    // already set from an earlier panel open, so it skips
                    // initCanvas()'s branch above and lands here instead).
                    if (this.isStaffViewer) {
                        this.lastFetchTimeStudent = 0;
                    } else {
                        this.lastFetchTimeStaff = 0;
                    }

                    laserCanvas.width  = width;
                    laserCanvas.height = height;
                    laserCanvas.style.width = width + 'px';
                    laserCanvas.style.height = height + 'px';
                    laserCanvas.style.maxWidth = 'none';

                    this.laserCtx.lineCap = 'round';
                    this.laserCtx.lineJoin = 'round';

                    this.canvasContentHeight = height;
                    this.canvasContentWidth = width;
                }
            },

            /**
             * directOverlayMode only: detect every independently-scrollable
             * sub-area of the page (e.g. a sticky sidebar with its own
             * overflow-y:auto - see directOverlayDocHeight's docblock for
             * why the main page-level overlay alone can't follow it) and
             * give each one its own small canvas pair, injected as an
             * actual DOM child of that container. Because it's a real
             * child, the browser's native internal scroll carries it along
             * automatically - no manual scroll-event syncing needed - and
             * clicks within that screen area naturally hit its own canvas
             * first (normal DOM stacking), falling through to the main page
             * canvas only outside any region - no manual hit-testing needed
             * either. See scrollRegions' docblock and startDrawing()'s
             * context-switch for how strokes get routed to the right one.
             *
             * A fixed snapshot taken once when the session opens (see
             * toggleExplanationMode()/pollDrawingState()'s auto-open) - a
             * page that changes its own scrollable structure mid-session
             * won't pick up new regions until reopened (see this feature's
             * plan for the full list of deliberate scope limits).
             */
            setupScrollRegions() {
                if (this.scrollRegions.length > 0) return;

                const candidates = [];
                document.querySelectorAll('*').forEach((el) => {
                    const style = getComputedStyle(el);
                    if ((style.overflowY === 'auto' || style.overflowY === 'scroll')
                        && el.scrollHeight > el.clientHeight + 5) {
                        candidates.push(el);
                    }
                });

                // Each region needs a STABLE key both sides (Admin's iframe
                // instance and the real student's own page load) will
                // independently arrive at for "the same" container - a
                // plain 0/1/2... position-in-DOM index isn't safe: confirmed
                // live that Admin's Live Student View iframe doesn't render
                // this page's own left nav sidebar at all (also
                // overflow-y:auto, also matched above), so the SAME index
                // pointed at completely different elements on each side
                // (student saw a stroke on their nav sidebar instead of the
                // reference panel it was actually drawn on). Hashing each
                // candidate's own class list is stable regardless of what
                // ELSE does or doesn't also match on either side - it only
                // depends on this element's own markup, which the same
                // Blade template renders identically either way. The
                // occurrence counter (keySeen) only matters for the rare
                // case of two candidates sharing the exact same class list.
                const keySeen = {};
                candidates.forEach((el) => {
                    const base = (el.className || el.tagName || 'unknown').toString();
                    let hash = 0;
                    for (let i = 0; i < base.length; i++) {
                        hash = ((hash << 5) - hash + base.charCodeAt(i)) | 0;
                    }
                    const hashKey = Math.abs(hash).toString(36);
                    const occurrence = keySeen[hashKey] || 0;
                    keySeen[hashKey] = occurrence + 1;
                    el._wbRegionKey = `${hashKey}-${occurrence}`;
                });

                candidates.forEach((el) => {
                    const key = el._wbRegionKey;
                    // Remember the container's own ORIGINAL inline
                    // position/z-index (before touching either below) so
                    // closing the session (see toggleExplanationMode()'s
                    // cleanup) can put them back exactly - this container is
                    // real page content, not something this feature owns.
                    const originalPosition = el.style.position;
                    const originalZIndex   = el.style.zIndex;

                    // Needed so the injected wrapper's position:absolute
                    // anchors to THIS container (not some other ancestor) -
                    // doesn't otherwise affect the container's own layout.
                    if (getComputedStyle(el).position === 'static') {
                        el.style.position = 'relative';
                    }

                    // z-index:999999 on the CONTAINER ITSELF (not just the
                    // wrapper below) - confirmed necessary via live testing:
                    // a position:sticky container (the exact case this
                    // feature exists for) establishes its OWN stacking
                    // context per spec, so a z-index set only on a
                    // descendant can only ever rank WITHIN that context: it
                    // has no way to out-rank #whiteboard-panel's document-
                    // level z-index:999999 from the outside, and the region
                    // canvas silently never received a single click
                    // (elementFromPoint() kept returning the main overlay
                    // canvas underneath) until the container's own z-index
                    // was raised too. Restored on close - see
                    // toggleExplanationMode(). Best-effort beyond this
                    // container's own immediate stacking context: a
                    // transform/filter/opacity<1 on some ANCESTOR further
                    // up could still trap it - not something controllable
                    // from here.
                    el.style.zIndex = '999999';

                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = `position:absolute; top:0; left:0; width:100%; height:${el.scrollHeight}px; pointer-events:none; z-index:999999;`;

                    const staffCanvas = document.createElement('canvas');
                    staffCanvas.id = `global-live-drawing-canvas-r${key}`;
                    const studentCanvas = document.createElement('canvas');
                    studentCanvas.id = `student-live-drawing-canvas-r${key}`;

                    // Staff layer first/bottom, student layer second/top -
                    // same stacking as the main canvas pair (see its own
                    // "Staff/teacher layer (bottom)" comment).
                    [staffCanvas, studentCanvas].forEach((c) => {
                        c.width  = el.clientWidth;
                        c.height = el.scrollHeight;
                        c.style.cssText = 'position:absolute; top:0; left:0; width:100%; height:100%; max-width:none; pointer-events:none;';
                        wrapper.appendChild(c);
                    });

                    const myCanvas    = this.isStaffViewer ? staffCanvas   : studentCanvas;
                    const otherCanvas = this.isStaffViewer ? studentCanvas : staffCanvas;
                    // Only the viewer's OWN layer is interactive - mirrors
                    // the main canvas's isStaffViewer-gated pointerEvents,
                    // including its readOnlyMode carve-out for a student
                    // watching a directOverlayMode auto-open (see that
                    // canvas's own comment for why this can't just stay
                    // enabled-but-inert here the way batch-broadcast does).
                    // setupScrollRegions() only ever runs while
                    // directOverlayMode is already true, so no need to
                    // check that flag again here.
                    myCanvas.style.pointerEvents = (!this.isStaffViewer && this.readOnlyMode) ? 'none' : 'auto';

                    // Plain native listeners (not Alpine @pointerdown
                    // directives) - Alpine doesn't automatically bind
                    // directives on elements created via
                    // document.createElement()/appendChild() after its
                    // initial DOM scan, and calling startDrawing()/draw()/
                    // stopDrawing() directly here is simpler and more
                    // reliable than reaching for Alpine.initTree().
                    // e.currentTarget inside them is still this exact
                    // canvas element, same as a native Alpine binding.
                    myCanvas.addEventListener('pointerdown', (e) => this.startDrawing(e));
                    myCanvas.addEventListener('pointermove', (e) => this.draw(e));
                    myCanvas.addEventListener('pointerup',   (e) => this.stopDrawing(e));
                    myCanvas.addEventListener('pointerout',  (e) => this.stopDrawing(e));

                    el.appendChild(wrapper);

                    this.scrollRegions.push({
                        key,
                        el,
                        wrapper,
                        originalPosition,
                        originalZIndex,
                        myCanvasId:    myCanvas.id,
                        otherCanvasId: otherCanvas.id,
                    });
                });

                // Also protect any OTHER position:fixed page UI (e.g. a
                // floating Save button) from being visually covered by a
                // region container's own z-index:999999 above - confirmed
                // live that the fast-track meeting pages' floating Save
                // button (z-index:50) sits exactly where the "Summary
                // Chart" region's sticky panel can reach while scrolled,
                // and got fully hidden underneath it once that panel was
                // boosted for click-routing. Anything with a lower z-index
                // than the regions just got would have the same problem,
                // not just Save specifically - swept generically rather
                // than hardcoding this one page's button id. Excludes the
                // whiteboard's own elements (container.contains(el)) since
                // those are already correctly layered on purpose. Restored
                // in teardownScrollRegions().
                const liveDrawingContainer = document.getElementById('live-drawing-container');
                this.protectedFixedEls = [];
                document.querySelectorAll('*').forEach((el) => {
                    if (liveDrawingContainer.contains(el) || el === liveDrawingContainer) return;
                    if (getComputedStyle(el).position !== 'fixed') return;
                    const z = parseInt(getComputedStyle(el).zIndex, 10);
                    if (isNaN(z) || z < 999999) {
                        this.protectedFixedEls.push({ el, originalZIndex: el.style.zIndex });
                        el.style.zIndex = '1000001';
                    }
                });

                // The toolbar's OWN z-index (1000000, set in the template)
                // can't actually save it from being visually covered here,
                // even though it's higher than a region's 999999 - CSS caps
                // a descendant's EFFECTIVE z-index at whatever its NEAREST
                // stacking-context-establishing ancestor declares, and
                // #live-drawing-container's own z-index:260 caps this
                // WHOLE subtree (toolbar included) for any comparison
                // against something outside it - which is also EXACTLY why
                // the main canvas correctly LOSES to a region for click-
                // routing (260 < 999999, intentional and working). Raising
                // an ancestor's z-index high enough to also fix the
                // toolbar would make the main canvas incorrectly win
                // against every region too, breaking the click-routing
                // this whole feature depends on (see startDrawing()'s
                // context-switch, which relies on natural DOM-stacking
                // hit-testing) - confirmed broken live when tried. Moving
                // the toolbar elsewhere in the DOM to escape the cap was
                // also tried and confirmed to break its Alpine reactivity
                // (x-show/:style stopped updating once moved outside
                // #live-drawing-container's x-data scope - Alpine binds a
                // descendant to its nearest x-data ancestor at scan time,
                // and that binding doesn't follow a later raw DOM move).
                //
                // Instead: clip-path each region's own boosted container so
                // its z-index:999999 (and the opaque content that comes
                // with it) never physically extends into the toolbar's own
                // screen area at the bottom of the viewport - the toolbar
                // (or real page content) then shows/receives clicks
                // normally in that reserved strip, exactly as if the
                // region container were simply shorter. Doesn't touch
                // click-routing or Alpine reactivity at all. See
                // updateRegionClipPaths() for why this has to be
                // recomputed dynamically rather than a single fixed value.
                if (!this.readOnlyMode) {
                    this.updateRegionClipPaths();
                    // CSS clip-path's inset() is relative to the element's
                    // OWN border box, NOT the viewport - confirmed live
                    // that a region whose natural height isn't
                    // viewport-constrained (unlike the "Summary Chart"
                    // panel this was first tested against, which happens
                    // to have its own max-h-[calc(100vh-2rem)] CSS) can
                    // have its visible-on-screen portion sit thousands of
                    // pixels away from its own bottom edge - clipping a
                    // fixed amount off THAT edge does nothing for the
                    // toolbar area if the element's bottom is nowhere near
                    // it. The clip has to be recalculated in VIEWPORT
                    // terms every time the region's on-screen position can
                    // change - i.e. on any scroll, anywhere (this region's
                    // own internal scroll, an ancestor's, or the window's -
                    // capture:true catches all of them via bubbling).
                    if (!this._regionClipScrollListener) {
                        this._regionClipScrollListener = () => {
                            if (this._regionClipRaf) return;
                            this._regionClipRaf = requestAnimationFrame(() => {
                                this._regionClipRaf = null;
                                this.updateRegionClipPaths();
                            });
                        };
                        window.addEventListener('scroll', this._regionClipScrollListener, { passive: true, capture: true });
                    }
                }
            },

            /**
             * Recomputes each scrollRegions entry's clip-path so the
             * bottom `directOverlayToolbarReserve`px of the VIEWPORT is
             * always excluded from that region's boosted (opaque,
             * z-index:999999) rendering, regardless of where the region's
             * own bounding box currently sits on screen - see
             * setupScrollRegions()'s docblock for why a single static
             * clip-path value isn't enough. Only ever touches regions that
             * currently reach into that reserved strip; a region that
             * doesn't (clip-path: 'none') is left completely untouched.
             */
            updateRegionClipPaths() {
                const reserve = 110; // px - see setupScrollRegions()'s original reasoning for this figure
                const protectedTop = window.innerHeight - reserve;
                this.scrollRegions.forEach((region) => {
                    const rect = region.el.getBoundingClientRect();
                    const overlap = Math.max(0, Math.ceil(rect.bottom - protectedTop));
                    region.el.style.clipPath = overlap > 0 ? `inset(0px 0px ${overlap}px 0px)` : 'none';
                });
            },

            /**
             * Undoes everything setupScrollRegions() did to real page
             * content - restores each container's original inline
             * position/z-index/clip-path, removes the injected canvas
             * wrapper, and stops the scroll listener updateRegionClipPaths()
             * runs on, then restores every protectedFixedEls entry's
             * original z-index - then clears scrollRegions/regionHistory/
             * activeRegion/protectedFixedEls so a later re-open starts
             * from a clean slate. Called whenever a directOverlayMode
             * session closes (see toggleExplanationMode()) - none of these
             * overrides must ever linger on real page content after the
             * teacher is done annotating.
             */
            teardownScrollRegions() {
                if (this._regionClipScrollListener) {
                    window.removeEventListener('scroll', this._regionClipScrollListener, { capture: true });
                    this._regionClipScrollListener = null;
                }
                if (this._regionClipRaf) {
                    cancelAnimationFrame(this._regionClipRaf);
                    this._regionClipRaf = null;
                }

                this.scrollRegions.forEach((region) => {
                    region.el.style.position  = region.originalPosition;
                    region.el.style.zIndex    = region.originalZIndex;
                    region.el.style.clipPath  = '';
                    region.wrapper.remove();
                });
                this.scrollRegions = [];
                this.regionHistory = {};
                this.activeRegion  = null;

                this.protectedFixedEls.forEach(({ el, originalZIndex }) => {
                    el.style.zIndex = originalZIndex;
                });
                this.protectedFixedEls = [];
            },

            /**
             * Grow the canvas taller (never shorter) so that `neededHeight`
             * (canvas-space Y) fits within it, preserving existing drawn
             * content, then scrolls #whiteboard-canvas-body down to reveal
             * the newly-available area. Called before writing/drawing
             * anything that would otherwise land past the current bottom
             * edge - see continueToNextLine() and startDrawing().
             *
             * Synchronous (unlike a toDataURL()+Image() round trip) since it
             * reuses the same getImageData/putImageData pixel-copy resizeCanvas()
             * already uses - no snapshot/redraw flicker or async ordering to
             * worry about before positioning the text input overlay.
             */
            growCanvasHeight(neededHeight) {
                if (this.growingCanvas) return;
                // directOverlayMode canvases stay fixed at viewport size -
                // this mode annotates exactly what's currently visible, not
                // an infinite notebook (see #whiteboard-canvas-zoom-wrapper).
                if (this.directOverlayMode) return;

                const canvas = document.getElementById(this.myCanvasId);
                const otherCanvas = document.getElementById(this.otherCanvasId);
                const laserCanvas = document.getElementById('laser-live-drawing-canvas');
                const body = document.getElementById(this.activeCanvasBodyId());
                if (!canvas || !otherCanvas || !laserCanvas || !body || !this.ctx) return;

                if (neededHeight > canvas.height) {
                    this.growingCanvas = true;

                    const newHeight = Math.max(neededHeight, canvas.height + this.canvasGrowStep);
                    const imageData = this.ctx.getImageData(0, 0, canvas.width, canvas.height);

                    canvas.height = newHeight;
                    canvas.style.height = newHeight + 'px';
                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                    this.ctx.putImageData(imageData, 0, 0);

                    // Grow the other (received-only) layer to match, WITH its
                    // content preserved - this path runs often (every stroke/
                    // line near the bottom edge), so losing that layer's
                    // content on every grow would be a much more noticeable
                    // flicker than the occasional resizeCanvas() case.
                    if (this.otherCtx) {
                        const otherImageData = this.otherCtx.getImageData(0, 0, otherCanvas.width, otherCanvas.height);
                        otherCanvas.height = newHeight;
                        otherCanvas.style.height = newHeight + 'px';
                        this.otherCtx.lineCap = 'round';
                        this.otherCtx.lineJoin = 'round';
                        this.otherCtx.putImageData(otherImageData, 0, 0);
                    }

                    laserCanvas.height = newHeight;
                    laserCanvas.style.height = newHeight + 'px';
                    this.laserCtx.lineCap = 'round';
                    this.laserCtx.lineJoin = 'round';

                    this.canvasContentHeight = newHeight;

                    this.growingCanvas = false;
                }

                // Keep `neededHeight` scrolled into view even when the
                // canvas buffer itself already had enough headroom from an
                // earlier +canvasGrowStep jump and didn't need to actually
                // grow again just now (the block above only runs every
                // ~canvasGrowStep/ruledLineHeight lines). Without this,
                // scrollTop only ever advanced on that infrequent resize
                // branch, so most individual ruled lines never scrolled
                // into view even though the fixed-position text input's
                // on-screen Y - computed from this same scroll position via
                // getBoundingClientRect() in continueToNextLine() - kept
                // climbing past the visible panel with every line typed.
                // That's what caused the "text bleeding out of the
                // whiteboard" bug when typing many lines in Buku mode.
                const targetScrollTop = (neededHeight * this.zoomLevel) - body.clientHeight;
                if (targetScrollTop > body.scrollTop) {
                    body.scrollTop = targetScrollTop;
                }
            },

            /**
             * Lets a pasted image (e.g. copied from another app, a
             * screenshot tool, or a browser image) land on the canvas as
             * drawable content - not a permanent overlay/attachment, an
             * actual part of MY OWN layer's bitmap once committed, exactly
             * like a pen stroke. That's what makes "coret-coret di atas
             * gambar" work for free: it's just pixels on the same canvas
             * everything else draws on, so the pen/highlighter/eraser/
             * shapes all already work on it without any special-casing,
             * and it syncs to the room the same way (syncDrawingToServer()
             * just re-reads whatever's currently on the canvas).
             *
             * Doesn't draw it immediately, though - see showPendingImage():
             * it first shows a resizable/movable overlay so an image
             * pasted at whatever size it happened to be (a full-page
             * screenshot, say) doesn't just dump onto the board at that
             * size; the teacher fits it to the lesson before it becomes
             * permanent pixels.
             *
             * Deliberately global (see init()) rather than bound to the
             * canvas element, which can't hold keyboard focus to receive a
             * paste in the first place - guarded instead by explanationMode/
             * readOnlyMode and by bailing out whenever the actual paste
             * target is a normal text field, so this never hijacks a
             * legitimate paste happening anywhere else on the page (the
             * text tool's own input included).
             */
            handlePaste(e) {
                if (!this.explanationMode || this.readOnlyMode) return;

                const target = e.target;
                // The paste catcher itself (#whiteboard-paste-catcher) is
                // deliberately contenteditable=true - it's the intended
                // target for every legitimate paste this handler should
                // act on, so it must never be treated as an "other text
                // field" to avoid, or literally nothing would ever get
                // through this check.
                const isOtherTextField = target && target.id !== 'whiteboard-paste-catcher'
                    && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable);
                if (isOtherTextField) return;

                const items = (e.clipboardData || window.clipboardData)?.items;
                if (!items) return;

                const imageItem = [...items].find(item => item.type.startsWith('image/'));
                if (!imageItem) return; // Not an image paste - leave it alone entirely.

                const blob = imageItem.getAsFile();
                if (!blob) return;

                e.preventDefault();

                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas || !this.ctx) return;

                const objectUrl = URL.createObjectURL(blob);
                const img = new Image();
                img.onload = () => this.showPendingImage(img, objectUrl);
                img.onerror = () => {
                    URL.revokeObjectURL(objectUrl);
                    console.warn('[LiveDrawing] Failed to load pasted image.');
                };
                img.src = objectUrl;
            },

            /**
             * Shows the just-pasted image as a resizable/movable overlay
             * (see the pendingImage-related markup and
             * startPendingImage{Drag,Resize}()) instead of drawing it
             * straight onto the canvas - nothing is committed to the
             * bitmap/synced to the room until commitPendingImage() runs.
             *
             * Default size: fit within 60% of the CURRENTLY VISIBLE
             * whiteboard viewport (body.clientWidth/clientHeight - the
             * on-screen viewport, not canvas.width/height, which is often
             * far taller than what's actually visible thanks to
             * growCanvasHeight()) - so "proportionate dengan ukuran
             * whiteboard" holds regardless of how large the pasted source
             * image was, while never upscaling a small image past its own
             * natural size.
             */
            showPendingImage(img, objectUrl) {
                const canvas = document.getElementById(this.myCanvasId);
                const body = document.getElementById(this.activeCanvasBodyId());
                if (!canvas || !body) {
                    URL.revokeObjectURL(objectUrl);
                    return;
                }

                this._pendingImageEl = img;

                const maxWidth  = Math.max(body.clientWidth * 0.6, 100);
                const maxHeight = Math.max(body.clientHeight * 0.6, 100);
                const scale = Math.min(1, maxWidth / img.naturalWidth, maxHeight / img.naturalHeight);

                this.pendingImage.width = img.naturalWidth * scale;
                this.pendingImage.height = img.naturalHeight * scale;
                this.pendingImage.aspectRatio = img.naturalWidth / img.naturalHeight;
                // Lands wherever the teacher is currently scrolled to, not
                // always row 0 - pasting mid-lesson (after already
                // scrolling down) should land where they're looking.
                this.pendingImage.x = 20;
                this.pendingImage.y = (body.scrollTop || 0) + 20;
                this.pendingImage.src = objectUrl;
                this.pendingImage.visible = true;

                this.updatePendingImagePos();
            },

            /**
             * Recomputes the pending image overlay's on-screen (viewport-
             * fixed) position from its canvas-space x/y - same rect-based
             * conversion textInput's px/py already uses. Called after any
             * change to x/y (drag, resize) or the canvas's own bounding
             * rect potentially shifting (scroll).
             */
            updatePendingImagePos() {
                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas) return;
                const rect = canvas.getBoundingClientRect();
                // *zoomLevel: x/y/width/height are canvas-space, but this
                // overlay lives outside the zoomed wrapper in real screen
                // pixels (see zoomLevel's state comment) - position AND
                // size both have to scale back up to line up with the
                // zoomed canvas underneath.
                this.pendingImage.px = rect.left + this.pendingImage.x * this.zoomLevel;
                this.pendingImage.py = rect.top + this.pendingImage.y * this.zoomLevel;
            },

            /** Begin dragging the pending image to reposition it (not resize - see startPendingImageResize()). */
            startPendingImageDrag(e) {
                if (!this.pendingImage.visible) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                this._pendingImageDrag = {
                    startClientX: clientX, startClientY: clientY,
                    startX: this.pendingImage.x, startY: this.pendingImage.y,
                };

                const onMove = (ev) => this.dragPendingImage(ev);
                const onUp = () => {
                    window.removeEventListener('pointermove', onMove);
                    window.removeEventListener('pointerup', onUp);
                    this._pendingImageDrag = null;
                };
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
            },

            dragPendingImage(e) {
                const d = this._pendingImageDrag;
                if (!d) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                // /zoomLevel: the pointer moved this many real SCREEN
                // pixels, but pendingImage.x/y are canvas-space - the same
                // screen-pixel drag should move it a smaller canvas-space
                // distance when zoomed in (and a larger one zoomed out).
                this.pendingImage.x = d.startX + (clientX - d.startClientX) / this.zoomLevel;
                this.pendingImage.y = d.startY + (clientY - d.startClientY) / this.zoomLevel;
                this.updatePendingImagePos();
            },

            /** Begin resizing from one corner (see the 4 handle elements in the template). Aspect ratio is always preserved. */
            startPendingImageResize(corner, e) {
                if (!this.pendingImage.visible) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                this._pendingImageResize = {
                    corner,
                    startClientX: clientX, startClientY: clientY,
                    startX: this.pendingImage.x, startY: this.pendingImage.y,
                    startWidth: this.pendingImage.width, startHeight: this.pendingImage.height,
                };

                const onMove = (ev) => this.resizePendingImage(ev);
                const onUp = () => {
                    window.removeEventListener('pointermove', onMove);
                    window.removeEventListener('pointerup', onUp);
                    this._pendingImageResize = null;
                };
                window.addEventListener('pointermove', onMove);
                window.addEventListener('pointerup', onUp);
            },

            resizePendingImage(e) {
                const r = this._pendingImageResize;
                if (!r) return;
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);
                // /zoomLevel - same screen-to-canvas-space conversion as dragPendingImage().
                const dx = (clientX - r.startClientX) / this.zoomLevel;

                // Width drives the resize (east corners grow with dx, west
                // corners shrink with it), height always follows from the
                // locked aspect ratio - simpler and more predictable than
                // tracking both dx/dy independently, and never distorts
                // the image.
                const sign = r.corner.includes('e') ? 1 : -1;
                const newWidth  = Math.max(30, r.startWidth + dx * sign);
                const newHeight = newWidth / this.pendingImage.aspectRatio;

                // Anchor the OPPOSITE edge - a west handle keeps the
                // image's right edge fixed while its left edge (and thus x)
                // moves, and likewise north keeps the bottom edge fixed -
                // so the handle actually being dragged is the one that
                // visibly follows the pointer, not the whole image sliding.
                this.pendingImage.x = r.corner.includes('w') ? r.startX + (r.startWidth - newWidth) : r.startX;
                this.pendingImage.y = r.corner.includes('n') ? r.startY + (r.startHeight - newHeight) : r.startY;
                this.pendingImage.width = newWidth;
                this.pendingImage.height = newHeight;
                this.updatePendingImagePos();
            },

            /** Draws the pending image onto the canvas at its current (possibly resized/moved) position/size, then syncs - the actual "paste" commit. */
            commitPendingImage() {
                if (!this.pendingImage.visible || !this.ctx || !this._pendingImageEl) return;

                this.growCanvasHeight(this.pendingImage.y + this.pendingImage.height + 20);

                this.pushHistory();
                this.localEditVersion++;
                this.ctx.drawImage(this._pendingImageEl, this.pendingImage.x, this.pendingImage.y, this.pendingImage.width, this.pendingImage.height);
                this.syncDrawingToServer();

                this.discardPendingImage();
            },

            /** Discards the pending image without drawing it - nothing was ever committed to the canvas/synced, so there's nothing to undo. */
            cancelPendingImage() {
                this.discardPendingImage();
            },

            discardPendingImage() {
                if (this.pendingImage.src) URL.revokeObjectURL(this.pendingImage.src);
                this.pendingImage.visible = false;
                this.pendingImage.src = null;
                this._pendingImageEl = null;
            },

            /**
             * Focuses the hidden contenteditable paste target (see the
             * #whiteboard-paste-catcher element) so a native browser paste
             * event actually fires somewhere handlePaste() can catch it - a
             * <canvas> can never itself hold keyboard focus. Called
             * whenever the panel opens and on every canvas
             * click/pointerdown (see startDrawing()), so Ctrl+V/Cmd+V keeps
             * working through normal use without a separate click first.
             *
             * Deferred via setTimeout(0): called from a pointerdown handler,
             * but the click itself is a non-focusable target (the canvas),
             * and the browser's OWN default focus-handling for that click
             * (blurring whatever was previously focused) runs as part of
             * the same native event and can fire AFTER this handler
             * returns - winning the race and undoing an immediate
             * .focus() call. Pushing this to the next tick lets that
             * default settle first, so this is the last thing to touch
             * focus.
             */
            focusPasteCatcher() {
                setTimeout(() => {
                    document.getElementById('whiteboard-paste-catcher')?.focus();
                }, 0);
            },

            // ── Zoom ───────────────────────────────────────────────────────

            zoomIn() {
                this.setZoom(this.zoomLevel + this.zoomStep);
            },

            zoomOut() {
                this.setZoom(this.zoomLevel - this.zoomStep);
            },

            resetZoom() {
                this.setZoom(1);
            },

            /**
             * Applies a new zoomLevel (clamped to [zoomMin, zoomMax], and
             * rounded to avoid classic float drift from repeated +/-
             * zoomStep, e.g. 0.1 + 0.1 + 0.1 !== 0.3 in JS). Doesn't touch
             * the canvas bitmap at all - see #whiteboard-canvas-zoom-wrapper,
             * which is what actually renders the zoom via CSS `zoom`.
             *
             * Re-syncs any currently-open text input/pending image
             * overlay's on-screen position+size, since both were computed
             * from zoomLevel at the time they were last placed and would
             * otherwise visually drift off their true canvas-space spot
             * the moment zoom changes under them.
             */
            setZoom(level) {
                this.zoomLevel = Math.min(this.zoomMax, Math.max(this.zoomMin, Math.round(level * 100) / 100));

                // Propagate immediately to anyone currently watching a
                // broadcast, rather than waiting for the next 8s heartbeat
                // (see sendPresence()/toggleBroadcast()) - mirrors
                // toggleRuledLines(). Guarded by isStaffViewer too since
                // students watching a broadcast also call setZoom() (see
                // checkBatchStatus()) and must never echo it back as if
                // they were the broadcaster.
                if (this.isStaffViewer && this.broadcastActive) {
                    this.sendPresence(true, true);
                }

                if (this.textInput.visible) {
                    const canvas = document.getElementById(this.myCanvasId);
                    if (canvas) {
                        const rect = canvas.getBoundingClientRect();
                        this.textInput.px = rect.left + this.textInput.x * this.zoomLevel;
                        this.textInput.py = rect.top + this.textInput.y * this.zoomLevel;
                    }
                }
                if (this.pendingImage.visible) {
                    this.updatePendingImagePos();
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

                // Subscribe to the shared room channel. Echo whispers are
                // fanned out to every OTHER subscriber on the channel (the
                // sender never receives its own whisper back), so every
                // participant listening here naturally forms an N-way board.
                this.channel = window.Echo.private('remote-view.' + this.targetUserId);

                if (window.Echo._broadcastingEnabled) {
                    this.channel.listenForWhisper('live-draw', (e) => {
                        this.handleRemoteDraw(e);
                    });
                    console.log('[LiveDrawing] WebSocket channel subscribed for room:', this.targetUserId);
                }
            },

            /**
             * Whisper a drawing event over the Echo private channel.
             * This is stroke-level real-time sync (pen-up/pen-down/move).
             * Only called when Echo WebSocket is genuinely connected.
             */
            broadcastWhisper(payload) {
                // The channel is scoped to targetUserId, the WHITEBOARD's
                // own room (see channel setup in init()) - whispering
                // notebook strokes there would leak them in real time to
                // anyone else watching that room (e.g. staff via Live
                // Student View), exactly what the notebook's isolation is
                // supposed to prevent. The notebook has no live audience
                // to whisper to anyway - it only ever syncs via
                // syncNotebookToServer()'s HTTP polling path.
                if (this.activeTab === 'notebook') return;

                if (
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
             * Single polling request. Fetches BOTH layers' drawing state
             * from the server and renders whichever is newer than what
             * we've already displayed - my own layer paints onto myCanvasId
             * (e.g. another staff member/device updated the same staff
             * layer), the other layer always paints onto otherCanvasId.
             */
            pollDrawingState() {
                if (!this.targetUserId) return;
                // While the Notebook tab is active, this.ctx/myCanvasId/
                // otherCanvasId are repointed at the notebook's own canvas
                // + dummy "other" canvas (see switchTab()) - this poll
                // must never run in that state, or it would paint the
                // whiteboard room's staff/student content straight onto
                // the private notebook the moment either layer changes.
                // pollNotebookState() (its own separate 1.5s interval)
                // handles the notebook layer instead; this interval just
                // resumes normally the instant activeTab flips back.
                if (this.activeTab === 'notebook') return;

                let url = `/api/live-drawing/fetch/${this.targetUserId}`
                    + `?last_time_staff=${this.lastFetchTimeStaff}`
                    + `&last_time_student=${this.lastFetchTimeStudent}`;

                // Per-panel scroll regions (see scrollRegions) - ask the
                // server for each one's own staff/student pair too,
                // reporting what we've already seen so it only sends what's
                // actually new (same last_time_* convention as the main layers).
                if (this.scrollRegions.length > 0) {
                    const keys = this.scrollRegions.map(r => r.key);
                    url += `&regions=${keys.join(',')}`;
                    keys.forEach((k) => {
                        url += `&last_time_staff_r${k}=${this.regionFetchTimes[`staff_r${k}`] || 0}`;
                        url += `&last_time_student_r${k}=${this.regionFetchTimes[`student_r${k}`] || 0}`;
                    });
                }

                fetch(url, {
                    // The very first poll after any fresh page load always
                    // repeats the exact same URL it did last time
                    // (last_time_staff/student reset to 0) - without this,
                    // a browser or intermediary (Cloudflare fronts this
                    // site) caching that GET could replay a stale response
                    // on refresh instead of hitting the server. See
                    // noCacheJson() server-side for the matching headers.
                    cache: 'no-store',
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

                    // Self-heal: the panel's very first auto-open (see
                    // checkBatchStatus()) tries to size the canvas via a
                    // single $nextTick(() => resizeCanvas()) call. On a real
                    // page that can land before the panel's layout has
                    // actually settled (e.g. still mid-reflow right after a
                    // fresh load) and silently no-op forever after, since
                    // nothing else ever retries it - polling keeps updating
                    // lastFetchTime* regardless, so the symptom is "content
                    // never appears" with no error anywhere. Every poll tick
                    // is a free retry opportunity, so just check here too.
                    if (this.explanationMode && !this.ctx) {
                        this.resizeCanvas();
                        // By now lastFetchTime* may already have advanced
                        // past 0 from earlier polls that arrived before the
                        // canvas was ready - the server would think we
                        // already have that content and skip resending it.
                        // Force the NEXT tick to re-fetch everything fresh
                        // now that there's actually a canvas to paint it on.
                        if (this.ctx) {
                            this.lastFetchTimeStaff = 0;
                            this.lastFetchTimeStudent = 0;
                        }
                    }

                    const myLayer = this.isStaffViewer ? 'staff' : 'student';

                    ['staff', 'student'].forEach((layer) => {
                        const layerData = data[layer];
                        if (!layerData) return;

                        // Guard against out-of-order poll responses - two
                        // overlapping /fetch requests (easily triggered by
                        // rapid local activity, e.g. several quick eraser
                        // strokes each queuing their own sync+poll cycle)
                        // can have their RESPONSES arrive in the opposite
                        // order they were sent in. Without this check, an
                        // older response landing last would both rewind
                        // lastFetchTime* backward AND repaint this layer
                        // with a stale, older snapshot - even overwriting
                        // content this same client just finished drawing
                        // and successfully synced moments earlier, since
                        // isStale() below only guards against a currently-
                        // PENDING local edit, not a chronologically stale
                        // incoming payload. lastFetchTime* must only ever
                        // move forward.
                        const priorFetchTime = layer === 'staff' ? this.lastFetchTimeStaff : this.lastFetchTimeStudent;
                        if (layerData.time && priorFetchTime && layerData.time <= priorFetchTime) {
                            return;
                        }

                        if (layerData.time) {
                            if (layer === 'staff') this.lastFetchTimeStaff = layerData.time;
                            else this.lastFetchTimeStudent = layerData.time;
                        }

                        // `payload` key is only present when there's new data
                        if (layerData.payload !== undefined) {
                            if (layer === myLayer) {
                                this.renderBase64ToCanvas(layerData.payload, this.myCanvasId, this.ctx, true);
                            } else {
                                this.renderBase64ToCanvas(layerData.payload, this.otherCanvasId, this.otherCtx);
                            }
                        }
                    });

                    // Per-panel scroll regions (see scrollRegions) - same
                    // out-of-order-guard + render pattern as the main
                    // staff/student loop above, just against each region's
                    // own fixed canvas ids (region.myCanvasId/otherCanvasId
                    // never change - unlike this.myCanvasId/this.ctx, which
                    // startDrawing()'s context-switch may currently point at
                    // a DIFFERENT region entirely).
                    this.scrollRegions.forEach((region) => {
                        const regionData = data.regions && data.regions[region.key];
                        if (!regionData) return;

                        ['staff', 'student'].forEach((layer) => {
                            const layerData = regionData[layer];
                            if (!layerData) return;

                            const fetchKey = `${layer}_r${region.key}`;
                            const priorFetchTime = this.regionFetchTimes[fetchKey] || 0;
                            if (layerData.time && priorFetchTime && layerData.time <= priorFetchTime) {
                                return;
                            }
                            if (layerData.time) {
                                this.regionFetchTimes[fetchKey] = layerData.time;
                            }

                            if (layerData.payload !== undefined) {
                                const canvasId = layer === myLayer ? region.myCanvasId : region.otherCanvasId;
                                const canvas = document.getElementById(canvasId);
                                if (canvas) {
                                    this.renderBase64ToCanvas(layerData.payload, canvasId, canvas.getContext('2d'), layer === myLayer);
                                }
                            }
                        });
                    });

                    // Student side only: "teacher activates the whiteboard"
                    // - auto-open the panel the moment a poll reports the
                    // staff side is active, so the student doesn't have to
                    // notice and click it themselves. See sendPresence() /
                    // toggleExplanationMode() for the staff side that sets this.
                    if (!this.isStaffViewer && typeof data.staffActive === 'boolean') {
                        if (data.staffActive) {
                            // Only ever touch directOverlayMode/readOnlyMode
                            // at the EXACT MOMENT of a fresh auto-open
                            // (explanationMode transitioning false -> true) -
                            // NOT on every poll tick while staffActive stays
                            // true (which fires every ~1.5s for as long as
                            // the teacher's presence heartbeat keeps ticking,
                            // often for minutes after they've stopped
                            // actively annotating). Confirmed live this was
                            // a real bug: with these two lines OUTSIDE the
                            // guard below, a student who had ALREADY opened
                            // their own NORMAL whiteboard by clicking the
                            // pencil button themselves (directOverlayMode
                            // false) had it silently hijacked back into the
                            // transparent, toolbar-hidden read-only overlay
                            // on the very next poll tick - looking exactly
                            // like "the whiteboard doesn't appear" (it's
                            // there, just invisible - transparent background,
                            // hidden toolbar) with the direct-overlay close
                            // button flickering in at top-left.
                            if (!this.explanationMode && !this.autoOpenSuppressed) {
                                // Mirror whether the teacher is in Admin's
                                // Live Student View ("Mode Coret-Coret" -
                                // see directOverlayMode's docblock) so this
                                // student's auto-opened panel matches the
                                // same lean overlay presentation, not the
                                // full panel. This auto-open is purely
                                // one-way: the teacher annotates, the
                                // student just watches - reusing
                                // readOnlyMode here (same flag
                                // checkBatchStatus() already uses for
                                // "watching a class broadcast, can't draw")
                                // gets the toolbar hidden (already
                                // x-show="!readOnlyMode") and startDrawing()
                                // blocked for free. There's no other way a
                                // student's own directOverlayMode ever
                                // becomes true (their own manual toggle
                                // never sets isEmbeddedPreview), so this can
                                // never misfire for a student's legitimate
                                // own use of the normal panel.
                                this.directOverlayMode = (data.staffMode === 'direct');
                                if (this.directOverlayMode) {
                                    this.readOnlyMode = true;
                                }
                                this.explanationMode = true;
                                this.$nextTick(() => {
                                    this.resizeCanvas();
                                    if (this.directOverlayMode) {
                                        this.setupScrollRegions();
                                    }
                                });
                            }
                        } else {
                            // Teacher's session ended - let the NEXT
                            // activation auto-open again even if this one
                            // was manually dismissed.
                            this.autoOpenSuppressed = false;
                            this.directOverlayMode = false;
                            // Only clear the read-only flag THIS path set -
                            // never override checkBatchStatus()'s own
                            // ownership of it while a class broadcast is
                            // separately still active.
                            if (!this.batchViewActive) {
                                this.readOnlyMode = false;
                            }
                        }
                    }
                })
                .catch(err => {
                    // Silent fail — polling will retry on next interval
                    console.warn('[LiveDrawing] Poll error:', err.message);
                });
            },

            /**
             * Low-level POST to /api/live-drawing/sync. `explicitLayer`, when
             * given, is the escape hatch documented on the server (sync()):
             * only used by openArchive() to restore a snapshot that
             * legitimately contains both layers back onto the live board,
             * regardless of who's doing the restoring - normal drawing never
             * passes this, always relying on the server's own role
             * inference instead.
             *
             * `region`, when given, targets a per-panel scroll region's own
             * Cache-key suffix instead of the main canvas - see
             * scrollRegions/syncDrawingToServer(). Only ever passed by the
             * normal (non-clear) drawn-snapshot sync path.
             */
            postSync(payload, explicitLayer = null, region = null) {
                const body = { targetUserId: this.targetUserId, payload };
                if (explicitLayer) body.layer = explicitLayer;
                if (region !== null) body.region = region;

                return fetch('/api/live-drawing/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'Accept':           'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(body),
                }).then(res => res.json());
            },

            /** Record which layer(s) a sync response touched, so polling
             *  knows not to redundantly re-fetch/redraw what we just did
             *  ourselves (avoids a flicker when others draw at the same time). */
            markLayersSeen(data) {
                if (!data.success || !data.time) return;
                if (data.layer === 'staff' || data.scope === 'staff' || data.scope === 'all') {
                    this.lastFetchTimeStaff = data.time;
                }
                if (data.layer === 'student' || data.scope === 'student' || data.scope === 'all') {
                    this.lastFetchTimeStudent = data.time;
                }
            },

            /**
             * Sync MY OWN canvas's current snapshot to the server via HTTP
             * POST. Called after the sender lifts the pointer (pointerup) or
             * clears. Which layer this becomes is inferred server-side from
             * my own role - see class docblock on LiveDrawingController.
             *
             * @param {?string} clearScope - 'all' | 'staff' | 'student' to
             *   clear a layer instead of sending a drawn snapshot; null (the
             *   default) sends the normal drawn snapshot. 'notebook'
             *   delegates entirely to syncNotebookToServer() instead (see
             *   below) - different target (ownUserId, not targetUserId),
             *   different authorization (explicit layer, not role-inferred).
             */
            syncDrawingToServer(clearScope = null) {
                if (this.activeTab === 'notebook') {
                    return this.syncNotebookToServer(clearScope === 'notebook');
                }

                if (!this.targetUserId) return Promise.resolve();

                if (this._syncInFlight) {
                    this._pendingSync = clearScope || true;
                    return Promise.resolve(); // Debounce rapid sync calls by queuing
                }

                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas) return Promise.resolve();

                const now = Date.now();
                const laserData = this.laserPaths.map(path => ({
                    points: path.points.map(p => ({
                        x: p.x,
                        y: p.y,
                        age: now - p.time
                    }))
                }));

                const payload = clearScope ? ('clear:' + clearScope) : JSON.stringify({
                    image: canvas.toDataURL('image/png'),
                    laserData: laserData
                });

                this._syncInFlight = true;
                // Snapshot which edit version this upload actually contains
                // (canvas.toDataURL() above was captured at this same
                // moment) - only mark that version as synced, so an edit
                // that starts while this request is still in flight isn't
                // mistaken for already being saved.
                const versionAtSync = this.localEditVersion;

                // Per-panel scroll region (see scrollRegions/startDrawing())
                // - only for a normal drawn-snapshot sync, never a
                // clearScope one: Clear All always targets the named
                // staff/student/all layer regardless of which canvas was
                // last drawn on, so it must never be tagged as region-scoped.
                const region = (!clearScope && this.activeRegion !== null) ? this.activeRegion : null;

                return this.postSync(payload, null, region)
                .then(data => {
                    if (data.success) {
                        this.markLayersSeen(data);
                        this.syncedEditVersion = versionAtSync;
                        console.log('[LiveDrawing] Synced to server. Time:', data.time);
                    }
                })
                .catch(err => {
                    console.error('[LiveDrawing] Sync error:', err);
                })
                .finally(() => {
                    this._syncInFlight = false;
                    if (this._pendingSync) {
                        const scope = this._pendingSync === true ? null : this._pendingSync;
                        this._pendingSync = false;
                        this.syncDrawingToServer(scope);
                    }
                });
            },

            /**
             * Sync a SPECIFIC canvas's content to the server as a specific
             * layer, bypassing "infer layer from my own role" - only used by
             * openArchive() to restore both layers from a saved snapshot.
             * Authorization is still enforced server-side: a student can
             * only ever target their own layer this way (see sync()).
             */
            async restoreLayerToServer(canvasId, layer) {
                const canvas = document.getElementById(canvasId);
                if (!canvas || !this.targetUserId) return;

                const payload = JSON.stringify({
                    image: canvas.toDataURL('image/png'),
                    laserData: [],
                });

                const data = await this.postSync(payload, layer);
                this.markLayersSeen(data);
            },

            /**
             * "Simpan" button handler. Every stroke already autosaves via
             * syncDrawingToServer() (called on pointerup) - that part isn't
             * functionally different, it just gives the user an explicit
             * action + visual confirmation that their work is saved. On top
             * of that, every click also captures a new checkpoint (see
             * createCheckpoint()) - unlike the plain autosave (which keeps
             * overwriting the same single row), each Simpan click leaves a
             * distinct, later-reopenable point in time behind.
             */
            async manualSave() {
                if (this.savingManually) return;

                this.savingManually = true;
                this.saveConfirmed = false;

                try {
                    await this.syncDrawingToServer();
                    await this.createCheckpoint();
                } finally {
                    this.savingManually = false;
                    this.saveConfirmed = true;
                    setTimeout(() => { this.saveConfirmed = false; }, 2000);
                }
            },

            /**
             * Captures the current canvas (both layers, like archiveNow())
             * as a new WhiteboardCheckpoint row - called from manualSave()
             * on every "Simpan" click. Deliberately no standalone UI trigger
             * of its own (unlike archiveNow()/"Arsipkan") - a checkpoint is
             * always just a side effect of saving, never a separate action.
             */
            async createCheckpoint() {
                if (!this.targetUserId) return;

                const staffCanvas   = document.getElementById('global-live-drawing-canvas');
                const studentCanvas = document.getElementById('student-live-drawing-canvas');
                if (!staffCanvas || !studentCanvas) return;

                const payload = JSON.stringify({
                    image: staffCanvas.toDataURL('image/png'),
                    laserData: [],
                });
                const payloadStudent = JSON.stringify({
                    image: studentCanvas.toDataURL('image/png'),
                    laserData: [],
                });

                try {
                    const res = await fetch('/api/live-drawing/checkpoint', {
                        method: 'POST',
                        headers: {
                            'Content-Type':     'application/json',
                            'Accept':           'application/json',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ targetUserId: this.targetUserId, payload: payload, payloadStudent: payloadStudent }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        if (this.showCheckpointPanel) {
                            this.checkpoints.unshift(data.checkpoint);
                        }
                    } else {
                        console.error('[LiveDrawing] Checkpoint failed:', data.message);
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Checkpoint error:', e);
                }
            },

            /** Position + open the checkpoint dropdown, anchored above the
             *  small chevron button next to "Simpan" - same pattern as
             *  toggleClearMenu(). (Re)loads the list every time it opens. */
            async toggleCheckpointPanel(e) {
                if (this.showCheckpointPanel) {
                    this.showCheckpointPanel = false;
                    return;
                }
                const rect = e.currentTarget.getBoundingClientRect();
                this.checkpointPanelX = rect.left;
                this.checkpointPanelY = rect.top;
                this.showCheckpointPanel = true;
                await this.loadCheckpointsList();
            },

            async loadCheckpointsList() {
                if (!this.targetUserId) return;

                this.checkpointsLoading = true;
                try {
                    const res = await fetch(`/api/live-drawing/checkpoints/${this.targetUserId}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.checkpoints = data.checkpoints;
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to load checkpoints:', e);
                } finally {
                    this.checkpointsLoading = false;
                }
            },

            /**
             * Open a checkpoint back onto the live board for EVERYONE in the
             * room, replacing whatever is currently drawn on both layers -
             * same restore-then-resync pattern as openArchive().
             */
            async openCheckpoint(checkpointId) {
                if (!this.targetUserId || this.openingCheckpointId) return;
                if (!confirm('Tampilkan checkpoint ini? Coretan yang sedang aktif di papan akan digantikan untuk semua orang di room ini.')) return;

                this.openingCheckpointId = checkpointId;
                try {
                    const res = await fetch(`/api/live-drawing/checkpoints/${this.targetUserId}/${checkpointId}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        const staffCtx   = this.isStaffViewer ? this.ctx : this.otherCtx;
                        const studentCtx = this.isStaffViewer ? this.otherCtx : this.ctx;

                        await Promise.all([
                            this.renderBase64ToCanvasAsync(data.payload, 'global-live-drawing-canvas', staffCtx),
                            this.renderBase64ToCanvasAsync(data.payloadStudent, 'student-live-drawing-canvas', studentCtx),
                        ]);
                        this.showCheckpointPanel = false;
                        this.restoreLayerToServer('global-live-drawing-canvas', 'staff');
                        this.restoreLayerToServer('student-live-drawing-canvas', 'student');
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to open checkpoint:', e);
                } finally {
                    this.openingCheckpointId = null;
                }
            },

            /**
             * Switches the Clear All popover between its normal scope
             * buttons and a checkbox list of checkpoints to bulk-delete -
             * the ONLY place a checkpoint can ever be removed from (no
             * per-item delete button in the checkpoint dropdown itself, no
             * single-checkpoint DELETE route server-side either - see
             * LiveDrawingController::destroyCheckpoints()).
             */
            toggleClearMenuCheckpointView() {
                this.clearMenuView = this.clearMenuView === 'checkpoints' ? 'main' : 'checkpoints';
                if (this.clearMenuView === 'checkpoints') {
                    this.selectedCheckpointIdsForDelete = [];
                    this.loadCheckpointsList();
                }
            },

            async deleteSelectedCheckpoints() {
                if (this.selectedCheckpointIdsForDelete.length === 0 || this.deletingCheckpoints || !this.targetUserId) return;
                if (!confirm(`Hapus ${this.selectedCheckpointIdsForDelete.length} checkpoint terpilih secara permanen?`)) return;

                this.deletingCheckpoints = true;
                try {
                    const res = await fetch(`/api/live-drawing/checkpoints/${this.targetUserId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type':     'application/json',
                            'Accept':           'application/json',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ ids: this.selectedCheckpointIdsForDelete }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        const deletedIds = this.selectedCheckpointIdsForDelete;
                        this.checkpoints = this.checkpoints.filter(c => !deletedIds.includes(c.id));
                        this.selectedCheckpointIdsForDelete = [];
                        this.clearMenuView = 'main';
                        this.showClearMenu = false;
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to delete checkpoints:', e);
                } finally {
                    this.deletingCheckpoints = false;
                }
            },

            /**
             * "Arsipkan" button - saves the current canvas as a brand new
             * permanent archive entry (does not touch the continuous
             * autosave). Unlike manualSave(), this always creates a NEW row
             * server-side rather than overwriting anything. Captures BOTH
             * layers so reopening the archive later restores the full
             * board, not just one layer's content.
             */
            async archiveNow() {
                if (this.archivingNow || !this.targetUserId) return;

                const staffCanvas   = document.getElementById('global-live-drawing-canvas');
                const studentCanvas = document.getElementById('student-live-drawing-canvas');
                if (!staffCanvas || !studentCanvas) return;

                this.archivingNow = true;
                this.archiveConfirmed = false;

                const payload = JSON.stringify({
                    image: staffCanvas.toDataURL('image/png'),
                    laserData: [],
                });
                const payloadStudent = JSON.stringify({
                    image: studentCanvas.toDataURL('image/png'),
                    laserData: [],
                });

                try {
                    const res = await fetch('/api/live-drawing/archive', {
                        method: 'POST',
                        headers: {
                            'Content-Type':     'application/json',
                            'Accept':           'application/json',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ targetUserId: this.targetUserId, payload: payload, payloadStudent: payloadStudent }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        if (this.showArchivePanel) {
                            this.archives.unshift(data.archive);
                        }
                    } else {
                        console.error('[LiveDrawing] Archive failed:', data.message);
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Archive error:', e);
                } finally {
                    this.archivingNow = false;
                    this.archiveConfirmed = true;
                    setTimeout(() => { this.archiveConfirmed = false; }, 2000);
                }
            },

            /** Toggle the archive-browser overlay, (re)loading the list every time it's opened. */
            async toggleArchivePanel() {
                this.showArchivePanel = !this.showArchivePanel;
                if (this.showArchivePanel) {
                    await this.loadArchivesList();
                }
            },

            async loadArchivesList() {
                if (!this.targetUserId) return;

                this.archivesLoading = true;
                try {
                    const res = await fetch(`/api/live-drawing/archives/${this.targetUserId}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.archives = data.archives;
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to load archives:', e);
                } finally {
                    this.archivesLoading = false;
                }
            },

            /**
             * Open a saved archive back onto the live board, replacing
             * whatever is currently drawn on BOTH layers, then syncs each
             * layer back to the server (so it keeps autosaving from here on
             * and anyone else polling this room sees it within ~1.5s).
             * Uses restoreLayerToServer()'s explicit-layer sync rather than
             * syncDrawingToServer(), since the archive's staff-layer content
             * needs restoring even if the person opening it is a student
             * (still authorization-checked server-side - a student can only
             * ever land their own layer's content this way, see sync()).
             */
            async openArchive(archiveId) {
                if (!this.targetUserId || this.openingArchiveId) return;
                if (!confirm('Buka arsip ini? Coretan yang sedang aktif di papan akan digantikan.')) return;

                this.openingArchiveId = archiveId;
                try {
                    const res = await fetch(`/api/live-drawing/archives/${this.targetUserId}/${archiveId}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        const staffCtx   = this.isStaffViewer ? this.ctx : this.otherCtx;
                        const studentCtx = this.isStaffViewer ? this.otherCtx : this.ctx;

                        await Promise.all([
                            this.renderBase64ToCanvasAsync(data.payload, 'global-live-drawing-canvas', staffCtx),
                            this.renderBase64ToCanvasAsync(data.payloadStudent, 'student-live-drawing-canvas', studentCtx),
                        ]);
                        this.showArchivePanel = false;
                        this.restoreLayerToServer('global-live-drawing-canvas', 'staff');
                        this.restoreLayerToServer('student-live-drawing-canvas', 'student');
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to open archive:', e);
                } finally {
                    this.openingArchiveId = null;
                }
            },

            async deleteArchive(archiveId) {
                if (!this.targetUserId) return;
                if (!confirm('Hapus arsip ini secara permanen?')) return;

                try {
                    const res = await fetch(`/api/live-drawing/archives/${this.targetUserId}/${archiveId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept':           'application/json',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.archives = this.archives.filter(a => a.id !== archiveId);
                    }
                } catch (e) {
                    console.error('[LiveDrawing] Failed to delete archive:', e);
                }
            },

            // ── Rendering ──────────────────────────────────────────────────

            /**
             * Render a base64 PNG (or 'clear') onto a canvas. Scales the
             * image to fill the current canvas dimensions so drawings from
             * different screen sizes still look correct.
             *
             * @param {string} base64 - Data URI or 'clear'.
             * @param {string} canvasId - Defaults to MY OWN canvas; polling
             *   passes otherCanvasId explicitly when painting the other
             *   layer's update (see pollDrawingState()).
             * @param {CanvasRenderingContext2D} ctx - Matching context for canvasId.
             * @param {boolean} respectPendingEdit - When true, skip applying
             *   this snapshot if canvasId is MY OWN canvas and it currently
             *   has local edits the server doesn't know about yet (see
             *   localEditVersion/syncedEditVersion). Only pollDrawingState()
             *   passes this - it's the one caller where the snapshot being
             *   applied can be stale relative to what the user is actively
             *   drawing right now; other callers (e.g. openArchive() via
             *   renderBase64ToCanvasAsync()) are deliberate overwrites.
             */
            renderBase64ToCanvas(base64, canvasId = this.myCanvasId, ctx = this.ctx, respectPendingEdit = false) {
                const canvas = document.getElementById(canvasId);
                if (!canvas || !ctx) return;

                const isStale = () => respectPendingEdit
                    && canvasId === this.myCanvasId
                    && this.localEditVersion !== this.syncedEditVersion;

                if (base64 === 'clear' || !base64) {
                    if (isStale()) return;
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    return;
                }

                // Handle legacy JSON payload format (backwards compatibility)
                let imageSrc = base64;
                if (base64.startsWith('{')) {
                    try {
                        const parsed = JSON.parse(base64);
                        imageSrc = parsed.image || base64;

                        // The laser pointer is a single shared gesture
                        // indicator, not per-layer content - apply it
                        // regardless of which layer this image belongs to,
                        // so e.g. a student always sees the teacher's laser
                        // even though it arrives bundled with the staff
                        // layer's (the "other" layer, from the student's view) update.
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
                    // If this snapshot came from a room where the canvas
                    // grew taller than ours (e.g. a teacher watching a
                    // student who's written several ruled lines), grow ours
                    // to match first, so nothing is clipped and it stays
                    // scrollable to the same extent. growCanvasHeight()
                    // always keeps both layers' canvases the same height,
                    // so this is correct regardless of which one canvasId is.
                    // Re-check at apply time, not just at request time - the
                    // user may have started a new local edit during the
                    // network round trip + image decode above.
                    if (isStale()) return;
                    if (img.naturalHeight > canvas.height) {
                        this.growCanvasHeight(img.naturalHeight);
                    }
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    if (this.directOverlayMode) {
                        // directOverlayMode's canvas is sized to each
                        // viewer's OWN viewport (see #whiteboard-canvas-body),
                        // which the admin's Live Preview iframe and the
                        // real student's device almost never share (e.g.
                        // 1428x844 vs 1800x929) - unlike the normal fixed
                        // 760x480 panel, where "canvas overlays the same
                        // template" below actually held true for everyone.
                        // Drawing at native 1:1 there copied absolute
                        // pixels, landing a stroke at a totally different
                        // RELATIVE position on a differently-sized canvas
                        // (or off the visible area entirely) - stretching
                        // to fill the local canvas keeps it at the same
                        // relative position instead, which is what
                        // actually matters for "draw directly on what's
                        // visible".
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    } else {
                        // Draw at 1:1 scale at origin — canvas overlays the same template
                        ctx.drawImage(img, 0, 0);
                    }
                };
                img.onerror = () => {
                    console.warn('[LiveDrawing] Failed to decode image payload.');
                };
                img.src = imageSrc;
            },

            /**
             * Promise-based variant of renderBase64ToCanvas() for callers
             * (like openArchive()) that need to know the image has actually
             * finished painting before doing something after it, e.g.
             * syncing the freshly-opened archive as the new live state.
             */
            renderBase64ToCanvasAsync(base64, canvasId = this.myCanvasId, ctx = this.ctx) {
                return new Promise((resolve) => {
                    const canvas = document.getElementById(canvasId);
                    if (!canvas || !ctx || base64 === 'clear' || !base64) {
                        this.renderBase64ToCanvas(base64, canvasId, ctx);
                        resolve();
                        return;
                    }

                    let imageSrc = base64;
                    if (base64.startsWith('{')) {
                        try {
                            const parsed = JSON.parse(base64);
                            imageSrc = parsed.image || base64;
                        } catch (e) { /* ignore */ }
                    }

                    const img = new Image();
                    img.onload = () => {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(img, 0, 0);
                        resolve();
                    };
                    img.onerror = () => {
                        console.warn('[LiveDrawing] Failed to decode archive image.');
                        resolve();
                    };
                    img.src = imageSrc;
                });
            },

            // ── Toolbar UI Controls ────────────────────────────────────────

            /**
             * Toggle the drawing overlay on/off.
             * On exit, optionally clears the canvas (with confirmation).
             */
            toggleExplanationMode() {
                if (this.textInput.visible) {
                    this.finalizeText();
                }
                // Commit (not discard) a still-pending pasted image on
                // close - silently losing something the teacher just
                // pasted would be far more surprising than keeping it at
                // whatever size/position it was last left.
                if (this.pendingImage.visible) {
                    this.commitPendingImage();
                }

                this.explanationMode = !this.explanationMode;

                if (this.explanationMode) {
                    // Panel was hidden (x-show, zero size) until now - measure
                    // and size the canvases now that it's actually visible.
                    this.$nextTick(() => {
                        this.resizeCanvas();
                        // Also lets paste work immediately on open, before
                        // the first click/stroke (see focusPasteCatcher()).
                        this.focusPasteCatcher();
                        if (this.directOverlayMode) {
                            this.setupScrollRegions();
                        }
                    });

                    // Staff opening their panel is the "teacher activates
                    // the whiteboard" signal the student's poll auto-opens
                    // on - see sendPresence()/pollDrawingState(). Note this
                    // is independent of broadcasting (see toggleBroadcast())
                    // - opening the panel no longer starts a broadcast by
                    // itself, only the explicit "Aktifkan" button does.
                    if (this.isStaffViewer) {
                        this.sendPresence(true);
                        if (!this.presenceHeartbeat) {
                            this.presenceHeartbeat = setInterval(() => this.sendPresence(true), 8000);
                        }
                    } else {
                        // A student opening their own panel manually (not
                        // via auto-open) shouldn't get immediately
                        // re-suppressed by a stale flag from an earlier session.
                        this.autoOpenSuppressed = false;

                        // If a teacher's live "Mode Coret-Coret" session is
                        // STILL active on this student (staffActive hasn't
                        // flipped false yet - pollDrawingState()'s own
                        // cleanup below only runs on THAT transition), a
                        // manual close+reopen of this exact panel left
                        // directOverlayMode/readOnlyMode stuck true: nothing
                        // else ever clears them mid-session, so the
                        // student's own deliberate re-open silently
                        // inherited the teacher's transparent, header-less,
                        // read-only overlay instead of their own normal
                        // panel - exactly the "coret-coret ambil alih
                        // whiteboard sendiri" report this fixes. This is a
                        // real, own, manual open, so it always wins: same
                        // reset pollDrawingState() applies once staffActive
                        // finally goes false, just triggered earlier by the
                        // student's own action instead of waiting for it.
                        this.directOverlayMode = false;
                        if (!this.batchViewActive) {
                            this.readOnlyMode = false;
                        }
                    }
                } else {
                    // Undo setupScrollRegions()'s changes to real page
                    // content (position/z-index overrides + injected
                    // canvases) before anything else - see
                    // teardownScrollRegions()'s docblock for why this can't
                    // be allowed to linger after the session ends.
                    if (this.scrollRegions.length > 0) {
                        this.teardownScrollRegions();
                    }

                    // Closing the panel implies "I'm done" - also stop
                    // broadcasting if it was on. Broadcasting no longer
                    // touches targetUserId at all (see toggleBroadcast()),
                    // so this is just a presence flip, nothing to restore.
                    if (this.broadcastActive) {
                        this.broadcastActive = false;
                        this.sendPresence(false, true);
                        clearInterval(this.broadcastHeartbeat);
                        this.broadcastHeartbeat = null;
                    }

                    if (this.isStaffViewer) {
                        this.sendPresence(false);
                        clearInterval(this.presenceHeartbeat);
                        this.presenceHeartbeat = null;
                    } else {
                        // Respect the student's choice to close it - don't
                        // let the next poll immediately reopen it while the
                        // teacher is still in the same activation.
                        this.autoOpenSuppressed = true;
                        // Undo pollDrawingState()'s auto-open readOnlyMode
                        // (see its docblock) if this WAS a directOverlayMode
                        // auto-opened session - otherwise it would leak into
                        // this student's own NEXT normal (non-direct)
                        // whiteboard open and wrongly hide their own toolbar.
                        // Never override checkBatchStatus()'s own ownership
                        // of the same flag while a class broadcast is
                        // separately still active.
                        if (this.directOverlayMode && !this.batchViewActive) {
                            this.readOnlyMode = false;
                        }
                    }

                    // Stop the Notebook tab's own poll loop too, if it was
                    // running (see switchTab()) - no point polling a canvas
                    // nobody can see right now.
                    if (this.notebookPollInterval) {
                        clearInterval(this.notebookPollInterval);
                        this.notebookPollInterval = null;
                    }

                    // Ask whether to clear drawings when leaving mode - only
                    // MY OWN layer (matches Clear All's per-layer scoping;
                    // leaving shouldn't silently wipe the other party's work).
                    // Skipped while watching a broadcast: there's nothing of
                    // the student's own to clear (they never drew anything -
                    // see readOnlyMode), and the server would reject the
                    // write anyway (only the broadcaster's own staff layer).
                    if (!this.batchViewActive && confirm('Bersihkan coretan Anda saat keluar mode coret-coret?')) {
                        this.executeDraw({ type: 'clear' });
                        this.localEditVersion++;
                        this.broadcastWhisper({ type: 'clear' });
                        this.syncDrawingToServer(this.isStaffViewer ? 'staff' : 'student');
                    }
                }
            },

            /**
             * Staff-only: announce to the room's student that the teacher's
             * whiteboard panel is open (active=true) or closed (false) - see
             * LiveDrawingController::presence(). Best-effort/fire-and-forget;
             * a failed request just means the student's panel won't
             * auto-open/close this particular time, not a functional error.
             *
             * `broadcasting` flags this as the SEPARATE "Aktifkan" signal
             * (see toggleBroadcast()) rather than the general "my panel is
             * open" one - the server tracks them under different cache keys
             * so stopping one never flickers the other off, even though
             * both target the exact same room (this viewer's own). While
             * broadcasting, also carries `ruledLines` and `zoomLevel` -
             * purely cosmetic viewer preferences (see toggleRuledLines()/
             * setZoom()) that aren't part of the synced bitmap, so they
             * can't ride along with fetch()'s payload like drawn content
             * does; this is the only channel that propagates them to
             * watching students.
             */
            sendPresence(active, broadcasting = false) {
                if (!this.isStaffViewer || !this.targetUserId) return;

                fetch('/api/live-drawing/presence', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'Accept':           'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ targetUserId: this.targetUserId, active, broadcasting, ruledLines: this.ruledLines, zoomLevel: this.zoomLevel, directOverlay: this.isEmbeddedPreview }),
                    keepalive: true,
                }).catch(() => { /* best-effort - see docblock */ });
            },

            /**
             * Student-side only (see init()): polls GET
             * /api/live-drawing/batch/my-status every 5s to detect when
             * this student's class starts/stops being broadcast to. While
             * active, temporarily repoints targetUserId at the broadcasting
             * staff member's OWN room (read-only - see
             * readOnlyMode/startDrawing()) instead of this student's own
             * individual room, restoring it once the broadcast ends.
             */
            /**
             * Wipes both on-screen canvases immediately when targetUserId
             * is about to switch rooms (see checkBatchStatus()). Both
             * <canvas> DOM elements (myCanvasId/otherCanvasId) are fixed by
             * ROLE, not by room - the same two elements get reused across
             * every room this viewer ever points at. pollDrawingState()
             * only clears+redraws a layer when the server actually reports
             * a payload for it; fetchLayer() returns none at all for a
             * layer with no cached/saved data for the new room (which is
             * the common case - e.g. a student's own room's staff layer
             * almost never has anything in it). Without this, switching
             * rooms with nothing to report leaves whatever was on-screen
             * from the PREVIOUS room's content untouched, so it stays
             * visually "stuck" and gets drawn over/into rather than
             * cleanly replaced.
             */
            clearCanvasesForRoomSwitch() {
                const canvas = document.getElementById(this.myCanvasId);
                if (canvas && this.ctx) this.ctx.clearRect(0, 0, canvas.width, canvas.height);

                const otherCanvas = document.getElementById(this.otherCanvasId);
                if (otherCanvas && this.otherCtx) this.otherCtx.clearRect(0, 0, otherCanvas.width, otherCanvas.height);
            },

            checkBatchStatus() {
                fetch('/api/live-drawing/batch/my-status', {
                    cache: 'no-store', // see pollDrawingState()'s fetch() for why
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                })
                .then(res => res.ok ? res.json() : null)
                .then(data => {
                    if (!data || !data.success) return;

                    if (data.active && !this.batchViewActive) {
                        this.preBatchTargetUserId = this.targetUserId;
                        this.targetUserId         = data.room;
                        this.batchViewActive      = true;
                        this.readOnlyMode         = true;
                        this.preBatchRuledLines    = this.ruledLines;
                        this.ruledLines            = !!data.ruledLines;
                        this.preBatchZoomLevel     = this.zoomLevel;
                        this.setZoom(data.zoomLevel ?? 1);
                        // Force the very next poll to fetch the broadcaster's
                        // full current canvas rather than "nothing newer
                        // than my old room's stale timestamps".
                        this.lastFetchTimeStaff   = 0;
                        this.lastFetchTimeStudent = 0;
                        // Wipe on-screen NOW, don't wait for that poll (see
                        // clearCanvasesForRoomSwitch()) - my own room's old
                        // content must never linger under/behind whatever
                        // the broadcaster's room paints next.
                        this.clearCanvasesForRoomSwitch();
                        // A broadcast starting always pulls the student back
                        // to the Whiteboard tab, even if they were on
                        // Notebook - they shouldn't have to notice and
                        // switch back themselves to see the teacher explain.
                        this.switchTab('whiteboard');

                        if (!this.explanationMode && !this.autoOpenSuppressed) {
                            this.explanationMode = true;
                            this.$nextTick(() => this.resizeCanvas());
                        }
                    } else if (!data.active && this.batchViewActive) {
                        this.targetUserId         = this.preBatchTargetUserId;
                        this.batchViewActive      = false;
                        this.readOnlyMode         = false;
                        this.ruledLines           = this.preBatchRuledLines;
                        this.setZoom(this.preBatchZoomLevel ?? 1);
                        this.lastFetchTimeStaff   = 0;
                        this.lastFetchTimeStudent = 0;
                        this.autoOpenSuppressed   = false;
                        // Wipe on-screen NOW (see clearCanvasesForRoomSwitch())
                        // - this is the exact fix for "coretan teacher dan
                        // student menyatu overlapping ketika broadcast
                        // berhenti": the broadcaster's room's content must
                        // never linger visually once we're back on my own room.
                        this.clearCanvasesForRoomSwitch();
                    } else if (data.active && this.batchViewActive) {
                        // Still watching the same broadcast - keep the
                        // cosmetic ruled-lines background and zoom level in
                        // sync too (see sendPresence()/toggleRuledLines()/
                        // setZoom()). Checked on the same 5s cadence as
                        // everything else here; both are purely visual, so
                        // they don't need to be faster.
                        this.ruledLines = !!data.ruledLines;
                        if (typeof data.zoomLevel === 'number' && data.zoomLevel !== this.zoomLevel) {
                            this.setZoom(data.zoomLevel);
                        }
                    }
                })
                .catch(() => { /* silent - retried on the next 5s tick */ });
            },

            /**
             * Staff-only: turns broadcasting on/off from wherever this
             * staff member currently is - no separate page/class needed.
             * Unlike the earlier design, this NEVER touches targetUserId -
             * it always stays this instance's own room, drawing continues
             * exactly as before. "Aktifkan" only controls who ELSE is
             * currently authorized to view that same room's staff layer
             * (see LiveDrawingController class docblock) - so what a
             * teacher sees never changes when toggling broadcast on/off.
             */
            toggleBroadcast() {
                if (!this.isStaffViewer) return;

                this.broadcastActive = !this.broadcastActive;

                if (this.broadcastActive) {
                    this.sendPresence(true, true);
                    // A SEPARATE handle from presenceHeartbeat (used by
                    // toggleExplanationMode()'s individual-room presence) -
                    // sharing one would mean turning broadcasting off could
                    // kill the panel-open heartbeat too, and vice versa.
                    if (!this.broadcastHeartbeat) {
                        this.broadcastHeartbeat = setInterval(() => this.sendPresence(true, true), 8000);
                    }
                    // Push the CURRENT target selection right away, not
                    // just on the next checkbox change - otherwise
                    // accepting the "Semua Siswa" default without ever
                    // touching the picker would leave the server with no
                    // targets recorded at all.
                    this.updateBatchTargets();
                } else {
                    this.sendPresence(false, true);
                    clearInterval(this.broadcastHeartbeat);
                    this.broadcastHeartbeat = null;
                }
            },

            /**
             * Staff-only: searches students by name/email for the "siswa
             * tertentu" target picker. Sends the CURRENT PAGE's own path
             * (not this fetch's own request path, which is always just
             * /api/live-drawing/students/search) so the server can scope
             * results to whatever batch is currently being taught here -
             * see LiveDrawingController::searchStudents()/
             * resolveProgramFromPath() for how that's resolved, and falls
             * back to an unscoped search across ALL students if it can't
             * be. Called on input (debounced in the markup) and on focus,
             * so the list isn't empty by default.
             */
            searchStudents() {
                if (!this.isStaffViewer) return;

                const params = new URLSearchParams({
                    q: this.studentSearchQuery,
                    path: window.location.pathname,
                });

                fetch(`/api/live-drawing/students/search?${params}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                })
                .then(res => res.ok ? res.json() : null)
                .then(data => {
                    if (data && data.success) {
                        this.studentSearchResults = data.students;
                        this.studentSearchScopedTo = data.scopedTo || null;
                    }
                })
                .catch(() => { /* silent - user can retype to retry */ });
            },

            /**
             * Posts the current target selection (broadcastTargetMode +
             * selectedStudentIds) to the server, gating which students'
             * myBatchStatus() calls report this broadcast as active for
             * them. Scoped to the CALLER's own broadcast - no id in the URL.
             */
            updateBatchTargets() {
                if (!this.isStaffViewer) return;

                const targets = this.broadcastTargetMode === 'all' ? 'all' : this.selectedStudentIds;

                fetch('/api/live-drawing/batch/targets', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'Accept':           'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ targets }),
                }).catch(() => { /* best-effort, matches sendPresence() */ });
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
                    this.lineWidth = this.eraserWidth;
                } else if (t === 'laser' || t === 'text' || t === 'list') {
                    // Doesn't change line width
                } else {
                    this.lineWidth = this.penWidth;
                    this.baseColor = this.colors.pen[0];
                }
                this.updateColor();
            },

            /** Position + open the Clear All popover menu, anchored above
             *  the button it was clicked from (the toolbar sits at the
             *  bottom of the panel, so the menu opens upward). */
            toggleClearMenu(e) {
                if (this.showClearMenu) {
                    this.showClearMenu = false;
                    return;
                }
                const rect = e.currentTarget.getBoundingClientRect();
                this.clearMenuX = rect.left;
                this.clearMenuY = rect.top;
                this.clearMenuView = 'main';
                this.showClearMenu = true;
            },

            /**
             * Clear a layer ('staff' | 'student') or both ('all'), locally
             * and for everyone else in the room via the server (see
             * LiveDrawingController::handleClear() for authorization -
             * clearing 'staff' or 'all' requires staff, enforced there too,
             * not just hidden in the menu).
             *
             * Only pushes an undo() snapshot when the clear touches MY OWN
             * layer - undo()/redo() only ever operate on my own canvas, so
             * there's nothing meaningful to push when just clearing the
             * OTHER layer (e.g. staff clearing a student's scratch work).
             */
            clearCanvases(scope) {
                this.showClearMenu = false;

                if (scope === 'notebook') {
                    if (!confirm('Bersihkan semua catatan di notebook ini?')) return;
                    this.pushHistory();
                    this.executeDraw({ type: 'clear' });
                    this.localEditVersion++;
                    this.syncDrawingToServer('notebook');
                    return;
                }

                const myLayer     = this.isStaffViewer ? 'staff' : 'student';
                const clearsMine  = scope === 'all' || scope === myLayer;
                const clearsOther = scope === 'all' || scope !== myLayer;

                const confirmMessages = {
                    all:     'Bersihkan SEMUA coretan (guru/admin dan siswa) di whiteboard ini untuk semua orang?',
                    staff:   'Bersihkan coretan guru/admin saja? Coretan siswa akan tetap ada.',
                    student: 'Bersihkan coretan siswa saja? Coretan guru/admin akan tetap ada.',
                };
                if (!confirm(confirmMessages[scope])) return;

                if (clearsMine) {
                    this.pushHistory();
                    this.executeDraw({ type: 'clear' });
                    this.localEditVersion++;
                }

                if (clearsOther) {
                    const otherCanvas = document.getElementById(this.otherCanvasId);
                    if (otherCanvas && this.otherCtx) {
                        this.otherCtx.clearRect(0, 0, otherCanvas.width, otherCanvas.height);
                    }
                }

                // Sent once with the real scope (not gated behind clearsMine)
                // so a remote listener - if WebSocket broadcasting is ever
                // enabled - can correctly work out which of ITS OWN two
                // canvases to clear via handleRemoteDraw(), rather than
                // always assuming "my own layer" like a normal draw whisper.
                this.broadcastWhisper({ type: 'clear', scope });

                this.syncDrawingToServer(scope);

                // Shrink the canvas back down to the viewport - only when
                // BOTH layers are now empty, since a partial clear might
                // still leave real content on the other layer that needs
                // the extra scroll height.
                if (scope === 'all') {
                    const body = document.getElementById('whiteboard-canvas-body');
                    if (body) {
                        this.canvasContentHeight = body.clientHeight;
                        this.canvasContentWidth = body.clientWidth;
                        this.resizeCanvas();
                        body.scrollTop = 0;
                    }
                }
            },

            /**
             * Capture whatever is currently drawn on the whiteboard and
             * download it as a ready-to-save PDF ("catatan"). Sends the
             * canvas's own PNG snapshot to the server, which wraps it in a
             * PDF page (via dompdf) and streams it back as a file download.
             */
            async downloadPdf() {
                if (this.pdfExporting) return;

                // Notebook has just the one layer - nothing to composite,
                // export it directly. Whiteboard still composites both
                // layers (staff below, student above - same stacking order
                // as on screen) so the PDF reflects the full board, not
                // just whichever layer this viewer happens to draw on.
                const isNotebook = this.activeTab === 'notebook';
                const staffCanvas   = document.getElementById(isNotebook ? this.notebookCanvasId : 'global-live-drawing-canvas');
                const studentCanvas = isNotebook ? null : document.getElementById('student-live-drawing-canvas');
                if (!staffCanvas || (!isNotebook && !studentCanvas)) return;

                this.pdfExporting = true;

                try {
                    // The two layers can end up with different backing-store
                    // sizes - e.g. the student's own layer grows taller as
                    // they write (growCanvasHeight()), while the untouched
                    // staff layer stays at whatever height it last was.
                    // Sizing the composite to staffCanvas alone meant
                    // drawImage() silently clipped any student ink beyond
                    // that height/width - the exact "coretan hilang" report
                    // this fixes. Math.max keeps the composite big enough
                    // for whichever layer is actually larger.
                    const composite = document.createElement('canvas');
                    composite.width  = studentCanvas ? Math.max(staffCanvas.width, studentCanvas.width) : staffCanvas.width;
                    composite.height = studentCanvas ? Math.max(staffCanvas.height, studentCanvas.height) : staffCanvas.height;
                    const compositeCtx = composite.getContext('2d');
                    compositeCtx.drawImage(staffCanvas, 0, 0);
                    if (studentCanvas) compositeCtx.drawImage(studentCanvas, 0, 0);

                    const response = await fetch('/api/live-drawing/pdf', {
                        method: 'POST',
                        headers: {
                            'Content-Type':     'application/json',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        // width/height let the server size the PDF page to
                        // the image itself instead of forcing it into a
                        // fixed A4 frame - see exportPdf()'s docblock for
                        // why that matters (tall boards were exporting as a
                        // blank first page).
                        body: JSON.stringify({
                            payload: composite.toDataURL('image/png'),
                            width:   composite.width,
                            height:  composite.height,
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    // The response IS the PDF file itself (not JSON) - turn
                    // it into a blob URL and trigger a normal file download.
                    const blob = await response.blob();
                    const blobUrl = URL.createObjectURL(blob);

                    const link = document.createElement('a');
                    link.href = blobUrl;
                    link.download = `Catatan-Whiteboard-${Date.now()}.pdf`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(blobUrl);
                } catch (e) {
                    console.error('[LiveDrawing] PDF export failed:', e);
                    alert('Gagal membuat PDF catatan. Silakan coba lagi.');
                } finally {
                    this.pdfExporting = false;
                }
            },

            // ── Undo / Redo History ──────────────────────────────────────────

            /** Snapshot the current canvas so undo() can restore it later.
             *  Call this right BEFORE a mutating action (stroke/shape/text/
             *  clear) starts, so the saved state is "how it looked before".
             *  Also invalidates any pending redo() states, since they were
             *  only ever valid as a "future" for the action that's about to
             *  be overwritten by this new one. */
            pushHistory() {
                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas) return;
                this.history.push(canvas.toDataURL('image/png'));
                if (this.history.length > this.historyLimit) {
                    this.history.shift();
                }
                this.redoStack = [];
            },

            /**
             * Restore the most recent history snapshot and sync it to the
             * room. This undoes this user's own last local action; if
             * someone else in the room drew something after that snapshot
             * was taken, their stroke gets overwritten too - an inherent
             * limitation of the full-canvas-snapshot sync model (same
             * tradeoff every sync already has when two people draw at once).
             * The state being replaced is pushed onto redoStack first, so
             * redo() can bring it straight back.
             */
            undo() {
                if (this.undoing || this.history.length === 0) return;

                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas || !this.ctx) return;

                const dataUrl = this.history.pop();

                this.redoStack.push(canvas.toDataURL('image/png'));
                if (this.redoStack.length > this.historyLimit) {
                    this.redoStack.shift();
                }

                this.undoing = true;
                this.localEditVersion++;

                // No whisper here (unlike Clear All): the restored state
                // usually isn't empty, and the whisper channel only carries
                // small incremental draw events, not a full snapshot - so
                // there's nothing meaningful to whisper. Other participants
                // pick up the restored canvas via the next HTTP poll instead.
                const img = new Image();
                img.onload = () => {
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    this.ctx.drawImage(img, 0, 0);
                    this.syncDrawingToServer();
                    this.undoing = false;
                };
                img.onerror = () => {
                    this.undoing = false;
                };
                img.src = dataUrl;
            },

            /**
             * The inverse of undo(): restore the most recently undone state.
             * The state being replaced is pushed back onto `history` first,
             * so the redo itself can be undone again. Guarded against rapid
             * repeat clicks the same way undo() is.
             */
            redo() {
                if (this.redoing || this.redoStack.length === 0) return;

                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas || !this.ctx) return;

                const dataUrl = this.redoStack.pop();

                this.history.push(canvas.toDataURL('image/png'));
                if (this.history.length > this.historyLimit) {
                    this.history.shift();
                }

                this.redoing = true;
                this.localEditVersion++;

                const img = new Image();
                img.onload = () => {
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    this.ctx.drawImage(img, 0, 0);
                    this.syncDrawingToServer();
                    this.redoing = false;
                };
                img.onerror = () => {
                    this.redoing = false;
                };
                img.src = dataUrl;
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
             * Return pointer/touch coordinates relative to the canvas, in
             * TRUE canvas-space (i.e. what ctx.lineTo() etc. actually
             * expect) - NOT raw screen pixels. The whiteboard panel is
             * `position: fixed` (floats above the page, doesn't move with
             * scroll), so screen coordinates are computed viewport-relative
             * (clientX/clientY), not document-relative; getBoundingClientRect()
             * on the canvas already reflects zoomLevel (see
             * #whiteboard-canvas-zoom-wrapper) since CSS `zoom` is a real
             * layout property, so the raw screen-space delta has to be
             * divided back down by it to get the actual canvas-pixel
             * position everything else in this file works in.
             */
            getPointerPos(e) {
                const canvas = document.getElementById(this.myCanvasId);
                const rect = canvas.getBoundingClientRect();
                const clientX = e.clientX ?? (e.touches?.[0]?.clientX ?? 0);
                const clientY = e.clientY ?? (e.touches?.[0]?.clientY ?? 0);

                return {
                    x: (clientX - rect.left) / this.zoomLevel,
                    y: (clientY - rect.top) / this.zoomLevel,
                };
            },

            /** Pointer pressed down — begin a stroke. */
            startDrawing(e) {
                if (!this.explanationMode) return;
                // Watching a batch broadcast (see checkBatchStatus()) is
                // read-only for students - the toolbar is hidden too, but
                // this is the actual enforcement point. Students CAN still
                // draw on their own individual room otherwise (e.g. the
                // admin's "Live Student View", ?live_preview_for=... -
                // see admin/students/current-assignment.blade.php), which
                // is a different room than whatever the teacher is
                // currently broadcasting into, so the two never collide.
                if (this.readOnlyMode) return;
                // A pasted image is still being positioned/resized (see
                // showPendingImage()) - make the teacher explicitly
                // commit/cancel it first, rather than let a stroke land
                // underneath an overlay that hasn't been placed yet.
                if (this.pendingImage.visible) return;

                // Keep the paste catcher focused through normal use (see
                // handlePaste()) - every click/stroke re-focuses it, so
                // Ctrl+V/Cmd+V keeps working without the teacher needing to
                // click some specific hidden spot first.
                this.focusPasteCatcher();

                // If they click while text tool is active, finalize any pending text
                if (this.textInput.visible) {
                    this.finalizeText();
                    // If they just clicked outside to blur, don't immediately start a new text box
                    // unless they click again, or let them start a new one right away?
                    // We'll let them start a new one right away if it's the text tool.
                }

                // Per-panel scroll region context-switch (see
                // scrollRegions/activeRegion's docblocks) - resolve which
                // physical canvas this stroke actually landed on (the main
                // page canvas, or one of the per-region canvases injected
                // by setupScrollRegions()) from e.currentTarget, and
                // repoint myCanvasId/otherCanvasId/ctx/otherCtx (+
                // history/redoStack, mirroring switchTab()'s existing swap
                // for the Notebook tab - see its docblock) to match, BEFORE
                // getPointerPos()/anything else below runs. Every other
                // function in this file just keeps using whatever these
                // already point to afterward - nothing else changes.
                const targetId = e.currentTarget && e.currentTarget.id;
                if (targetId && targetId !== this.myCanvasId) {
                    const region = this.scrollRegions.find(r => r.myCanvasId === targetId);
                    const mainMyCanvasId = this.isStaffViewer ? 'global-live-drawing-canvas' : 'student-live-drawing-canvas';

                    if (region || targetId === mainMyCanvasId) {
                        // Stash whatever bucket is CURRENTLY active before
                        // switching away from it, so switching back to that
                        // same canvas later restores it exactly.
                        if (this.activeRegion === null) {
                            this._mainHistory   = this.history;
                            this._mainRedoStack = this.redoStack;
                        } else {
                            this.regionHistory[this.myCanvasId] = { history: this.history, redoStack: this.redoStack };
                        }

                        if (region) {
                            this.activeRegion  = region.key;
                            this.myCanvasId    = region.myCanvasId;
                            this.otherCanvasId = region.otherCanvasId;
                            const bucket = this.regionHistory[region.myCanvasId] || { history: [], redoStack: [] };
                            this.history   = bucket.history;
                            this.redoStack = bucket.redoStack;
                        } else {
                            this.activeRegion  = null;
                            this.myCanvasId    = mainMyCanvasId;
                            this.otherCanvasId = this.isStaffViewer ? 'student-live-drawing-canvas' : 'global-live-drawing-canvas';
                            this.history   = this._mainHistory   || [];
                            this.redoStack = this._mainRedoStack || [];
                        }

                        const myCanvasEl    = document.getElementById(this.myCanvasId);
                        const otherCanvasEl = document.getElementById(this.otherCanvasId);
                        if (myCanvasEl)    this.ctx      = myCanvasEl.getContext('2d');
                        if (otherCanvasEl) this.otherCtx = otherCanvasEl.getContext('2d');
                    }
                }

                const pos = this.getPointerPos(e);

                // Text/List tool: place text where clicked, snapped to the
                // nearest ruled line when Buku is on OR the List tool is
                // active (a list's bullets always need even line spacing,
                // regardless of whether the decorative ruled background
                // happens to be showing). Ruled lines are purely a
                // decorative background otherwise - they must NOT hijack
                // clicks made with Pen/Stabilo/Laser/Hapus/shape tools, or
                // those tools would appear completely broken while Buku is
                // toggled on.
                if (this.tool === 'text' || this.tool === 'list') {
                    const textY = (this.ruledLines || this.tool === 'list')
                        ? Math.round(pos.y / this.ruledLineHeight) * this.ruledLineHeight
                        : pos.y;
                    // Grow first - openTextInputAt() re-reads the canvas's
                    // bounding rect itself, so it's safe to call after a
                    // scroll happens here.
                    this.growCanvasHeight(textY + this.ruledLineHeight);
                    this.openTextInputAt(pos.x, textY);
                    return;
                }

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

                // Give freehand/shape strokes a little headroom below the
                // click point too, so starting a stroke near the bottom
                // edge doesn't immediately run off it.
                this.growCanvasHeight(pos.y + 100);

                if (['rectangle', 'ellipse', 'line', 'arrow', 'table'].includes(this.tool)) {
                    this.pushHistory();
                    this.isDrawing = true;
                    this.localEditVersion++;
                    this.shapePreview = {
                        tool: this.tool,
                        x1: pos.x, y1: pos.y,
                        x2: pos.x, y2: pos.y,
                        color: this.color,
                        lineWidth: this.lineWidth,
                        // Only meaningful for tool === 'table', harmless
                        // extra fields otherwise (drawShapeOutline() ignores
                        // them for the other shapes).
                        rows: this.tableRows,
                        cols: this.tableCols,
                    };
                    return;
                }

                this.pushHistory();
                this.isDrawing = true;
                this.localEditVersion++;
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
                if (!this.explanationMode) return;
                const pos = this.getPointerPos(e);

                // Track the eraser-size preview circle on every move,
                // regardless of isDrawing - it should follow the pointer
                // while just hovering too, not only while actively erasing.
                if (this.tool === 'eraser') {
                    this.eraserCursor.x = pos.x;
                    this.eraserCursor.y = pos.y;
                    this.eraserCursor.hovering = true;
                }

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

                // Shape tools don't draw permanently on every move - they
                // just update the live rubber-band preview (rendered by
                // animateLaser() onto the laser canvas) until pointerup.
                if (this.shapePreview) {
                    this.shapePreview.x2 = pos.x;
                    this.shapePreview.y2 = pos.y;
                    return;
                }

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
                if (!this.explanationMode) return;

                // Hide the eraser-size preview circle whenever the pointer
                // leaves/lifts (pointerout/pointercancel/pointerup all route
                // here) - unconditional, so it also hides while just
                // hovering out without having drawn anything.
                if (e.type === 'pointerout' || e.type === 'pointercancel') {
                    this.eraserCursor.hovering = false;
                }

                if (!this.isDrawing) return;

                this.isDrawing = false;

                // Finalize a shape tool: commit the rubber-band preview onto
                // the real canvas (it was only ever drawn on the laser
                // preview layer up to this point), then clear the preview.
                if (this.shapePreview) {
                    const payload = { type: this.shapePreview.tool, ...this.shapePreview };
                    this.shapePreview = null;
                    this.executeDraw(payload);
                    this.broadcastWhisper(payload);
                    this.syncDrawingToServer();
                    return;
                }

                this.broadcastWhisper({ type: 'stop' });

                // ✅ KEY: Capture canvas → base64 PNG → POST to server cache
                // This is the HTTP Polling sync trigger (called on every stroke end)
                this.syncDrawingToServer();
            },

            /**
             * How wide the text input box should be right now, in pixels -
             * measured against the actual typed content (or the placeholder,
             * while empty) using the same font the text is drawn with, so
             * the box grows/shrinks with what's typed instead of scrolling
             * text inside a fixed-width box. "Seperti mengetik biasa."
             */
            measureTextWidth() {
                const content = this.textInput.text || 'Ketik teks...';
                const minWidth = 40;
                const horizontalPadding = 16; // matches the input's px-1 padding + caret room

                if (!this.ctx) return minWidth;

                this.ctx.font = '24px sans-serif';
                const measured = this.ctx.measureText(content).width;
                return Math.max(minWidth, measured + horizontalPadding);
            },

            /**
             * Draw the current textInput content onto the canvas, if it's
             * non-empty. Shared by finalizeText() (closes the input) and
             * continueToNextLine() (keeps it open on the next ruled line) so
             * both commit identically.
             */
            commitTextInput() {
                const rawText = this.textInput.text.trim();
                if (!rawText) return;

                // List tool: every line becomes a bullet item.
                const text = this.tool === 'list' ? ('• ' + rawText) : rawText;

                this.pushHistory();
                this.localEditVersion++;

                const payload = {
                    type: 'text',
                    text: text,
                    color: this.color,
                    fontSize: 24,
                    x: this.textInput.x,
                    y: this.textInput.y,
                    // 'alphabetic' sits the text right on top of the y
                    // coordinate (like a real baseline resting on a ruled
                    // line); 'middle' centers it on y instead, which reads
                    // more naturally for free placement off the lines. List
                    // items always sit on an (invisible) line grid too - see
                    // startDrawing() - so they use the same baseline as Buku.
                    baseline: (this.ruledLines || this.tool === 'list') ? 'alphabetic' : 'middle',
                };

                this.executeDraw(payload);
                this.broadcastWhisper(payload);
                this.syncDrawingToServer();
            },

            /** Finalizes the text tool input: commit + close. */
            finalizeText() {
                if (!this.textInput.visible) return;

                this.textInput.visible = false;
                this.commitTextInput();
                this.textInput.text = '';
            },

            /**
             * Ruled-lines mode only: commit the current line, then keep the
             * text input open one ruled line lower - so pressing Enter
             * repeatedly types a fresh line each time, like a real notebook.
             * Triggered by plain Enter (no Shift) while Buku is active; see
             * handleTextEnterKey().
             */
            continueToNextLine() {
                if (!this.textInput.visible) return;

                this.commitTextInput();

                const newY = this.textInput.y + this.ruledLineHeight;
                // Grow (and scroll to reveal) BEFORE recomputing the input's
                // on-screen position below - growing can scroll the canvas,
                // which shifts its bounding rect.
                this.growCanvasHeight(newY + this.ruledLineHeight);

                this.textInput.y = newY;
                this.textInput.text = '';

                const canvas = document.getElementById(this.myCanvasId);
                if (canvas) {
                    const rect = canvas.getBoundingClientRect();
                    // *zoomLevel: textInput.x/y are canvas-space, but this
                    // overlay lives outside the zoomed wrapper in real
                    // screen pixels (see zoomLevel's state comment) - has
                    // to be scaled back UP to line up visually.
                    this.textInput.px = rect.left + this.textInput.x * this.zoomLevel;
                    this.textInput.py = rect.top + this.textInput.y * this.zoomLevel;
                }

                this.$nextTick(() => {
                    document.getElementById('live-drawing-text-input')?.focus();
                });
            },

            /**
             * Enter-key router for the text input. In ruled-lines mode OR
             * the List tool, plain Enter moves to the next line instead of
             * finishing (you need Shift+Enter to actually finish) - for
             * List this is what lets Enter keep adding bullet items one
             * after another; otherwise Enter always finishes, unchanged
             * from before.
             */
            handleTextEnterKey(e) {
                if ((this.ruledLines || this.tool === 'list') && !e.shiftKey) {
                    e.preventDefault();
                    this.continueToNextLine();
                } else {
                    this.finalizeText();
                }
            },

            /**
             * Open the text input at a specific CANVAS-space position,
             * deriving the matching on-screen (client-space) position from
             * the canvas's current bounding rect. Shared by clicking the
             * canvas (startDrawing) and by toggleRuledLines() auto-opening
             * on the first line.
             */
            openTextInputAt(canvasX, canvasY) {
                const canvas = document.getElementById(this.myCanvasId);
                if (!canvas) return;
                const rect = canvas.getBoundingClientRect();

                this.textInput.visible = true;
                this.textInput.x = canvasX;
                this.textInput.y = canvasY;
                // *zoomLevel - see continueToNextLine()'s comment on the same conversion.
                this.textInput.px = rect.left + canvasX * this.zoomLevel;
                this.textInput.py = rect.top + canvasY * this.zoomLevel;
                this.textInput.text = '';

                this.$nextTick(() => {
                    document.getElementById('live-drawing-text-input')?.focus();
                });
            },

            /**
             * Toggle ruled notebook-paper lines on/off. Turning it ON
             * switches to the Text tool and immediately opens the text
             * input on the first line so you can start typing right away,
             * without needing to click the canvas first - "seperti buku"
             * from the moment you switch it on. The lines themselves stay
             * purely decorative after that - switching to Pen/Stabilo/
             * Laser/Hapus/shape tools works normally on top of them (see
             * startDrawing()), it's only the initial default that's text.
             */
            toggleRuledLines() {
                this.ruledLines = !this.ruledLines;

                if (this.ruledLines) {
                    this.setTool('text');
                    this.openTextInputAt(50, this.ruledLineHeight);
                }

                // Propagate immediately to anyone currently watching a
                // broadcast, rather than waiting for the next 8s heartbeat
                // (see sendPresence()/toggleBroadcast()).
                if (this.broadcastActive) {
                    this.sendPresence(true, true);
                }
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

                // Live rubber-band preview for shape tools (rectangle/ellipse/
                // line/arrow) while the user is still dragging. Drawn here
                // (rather than directly on pointermove) because this loop
                // already owns clearing/redrawing the laser canvas every
                // frame - drawing the preview anywhere else would just get
                // wiped by the clearRect() above on the very next frame.
                if (this.shapePreview) {
                    this.drawShapeOutline(this.laserCtx, this.shapePreview);
                }

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
                    const canvas = document.getElementById(this.myCanvasId);
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
                    this.ctx.textBaseline = payload.baseline || 'middle';
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
                } else if (['rectangle', 'ellipse', 'line', 'arrow', 'table'].includes(payload.type)) {
                    this.drawShapeOutline(this.ctx, payload);
                }
            },

            /**
             * Draw a rectangle/ellipse/line/arrow/table outline from
             * (x1,y1) to (x2,y2) onto the given 2D context. Shared by the
             * live rubber-band preview (laserCtx, every frame while
             * dragging) and the final committed shape (ctx, once on
             * release) so both always render identically.
             */
            drawShapeOutline(ctx, shape) {
                const { tool, x1, y1, x2, y2, color, lineWidth, rows, cols } = shape;

                ctx.save();
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = color;
                ctx.lineWidth = lineWidth;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                if (tool === 'rectangle') {
                    ctx.strokeRect(Math.min(x1, x2), Math.min(y1, y2), Math.abs(x2 - x1), Math.abs(y2 - y1));
                } else if (tool === 'ellipse') {
                    const cx = (x1 + x2) / 2;
                    const cy = (y1 + y2) / 2;
                    const rx = Math.abs(x2 - x1) / 2;
                    const ry = Math.abs(y2 - y1) / 2;
                    ctx.beginPath();
                    ctx.ellipse(cx, cy, rx, ry, 0, 0, 2 * Math.PI);
                    ctx.stroke();
                } else if (tool === 'line' || tool === 'arrow') {
                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.stroke();

                    if (tool === 'arrow') {
                        const angle = Math.atan2(y2 - y1, x2 - x1);
                        const headLength = Math.max(12, lineWidth * 3);
                        const headAngle = Math.PI / 7;

                        ctx.beginPath();
                        ctx.moveTo(x2, y2);
                        ctx.lineTo(
                            x2 - headLength * Math.cos(angle - headAngle),
                            y2 - headLength * Math.sin(angle - headAngle)
                        );
                        ctx.moveTo(x2, y2);
                        ctx.lineTo(
                            x2 - headLength * Math.cos(angle + headAngle),
                            y2 - headLength * Math.sin(angle + headAngle)
                        );
                        ctx.stroke();
                    }
                } else if (tool === 'table') {
                    const left = Math.min(x1, x2);
                    const top  = Math.min(y1, y2);
                    const w    = Math.abs(x2 - x1);
                    const h    = Math.abs(y2 - y1);
                    const numRows = Math.max(1, rows || 1);
                    const numCols = Math.max(1, cols || 1);

                    ctx.strokeRect(left, top, w, h);

                    for (let i = 1; i < numCols; i++) {
                        const x = left + (w / numCols) * i;
                        ctx.beginPath();
                        ctx.moveTo(x, top);
                        ctx.lineTo(x, top + h);
                        ctx.stroke();
                    }
                    for (let j = 1; j < numRows; j++) {
                        const y = top + (h / numRows) * j;
                        ctx.beginPath();
                        ctx.moveTo(left, y);
                        ctx.lineTo(left + w, y);
                        ctx.stroke();
                    }
                }

                ctx.restore();
            },

            /**
             * Handle a remote drawing event received via WebSocket whisper.
             * Delegates to executeDraw() for everything except 'clear',
             * which needs its own scope-aware handling here: unlike a normal
             * draw (always "my own layer" for the sender, so executeDraw()'s
             * unconditional this.myCanvasId is correct there), a clear can
             * target either layer independently of which one the SENDER
             * draws on - see clearCanvases().
             */
            handleRemoteDraw(e) {
                // A remote whisper is always about the whiteboard's own
                // room (the WebSocket channel is scoped to targetUserId,
                // never the private notebook - see channel setup in
                // init()) - if this.ctx/otherCtx currently point at the
                // notebook canvas instead (see switchTab()), a remote
                // event must never be allowed to touch it.
                if (this.activeTab === 'notebook') return;

                if (e.type === 'clear') {
                    const scope = e.scope || 'all';
                    const myLayer = this.isStaffViewer ? 'staff' : 'student';

                    if (scope === 'all' || scope === myLayer) {
                        this.executeDraw({ type: 'clear' });
                    }
                    if (scope === 'all' || scope !== myLayer) {
                        const otherCanvas = document.getElementById(this.otherCanvasId);
                        if (otherCanvas && this.otherCtx) {
                            this.otherCtx.clearRect(0, 0, otherCanvas.width, otherCanvas.height);
                        }
                    }
                    return;
                }
                this.executeDraw(e);
            },

            // ── Student Notebook ──────────────────────────────────────────
            // Reuses the EXACT SAME drawing engine/toolbar as the
            // whiteboard - pen, highlight, text, list, shapes, table,
            // ruled lines, zoom, undo/redo, colors all work here because
            // this.ctx/myCanvasId/otherCanvasId/history/redoStack simply
            // get repointed at the notebook's own canvas + stacks while
            // this tab is active (see switchTab()), and
            // syncDrawingToServer()/pollDrawingState() branch to a
            // notebook-specific network path instead of touching the
            // whiteboard's own room. Deliberately excluded: Laser pointer
            // (a live, multi-viewer gesture tool - meaningless with no one
            // else watching) and Arsipkan/Arsip (archives are tied to a
            // different, room-scoped DB table this doesn't extend to) -
            // both buttons are hidden here in the template.

            /**
             * Switches between the "Whiteboard" and "Notebook" tabs (see
             * activeTab's docblock / the tab switcher in the template).
             * Student-only - never called for staff. Repoints the shared
             * drawing engine's "current surface" at whichever tab is now
             * active, stashing the outgoing surface's own history/redo
             * stacks so they're intact whenever the user switches back.
             */
            switchTab(tab) {
                if (this.activeTab === tab) return;

                if (tab === 'notebook') {
                    this._wbHistory   = this.history;
                    this._wbRedoStack = this.redoStack;
                    this.history      = this.notebookHistory;
                    this.redoStack    = this.notebookRedoStack;

                    this.myCanvasId = this.notebookCanvasId;
                    // No "other viewer" layer exists for a private
                    // notebook - this permanently-empty dummy canvas (see
                    // template) exists purely so the whiteboard's generic
                    // engine (initCanvas()/growCanvasHeight()/etc, all of
                    // which assume a real, SEPARATE "other" canvas) has
                    // something harmless to point at instead of double-
                    // touching the same canvas as myCanvasId and
                    // corrupting it.
                    this.otherCanvasId = 'notebook-other-dummy-canvas';

                    if (!this.notebookPollInterval) {
                        this.notebookPollInterval = setInterval(() => this.pollNotebookState(), 1500);
                    }
                } else {
                    this.notebookHistory   = this.history;
                    this.notebookRedoStack = this.redoStack;
                    this.history   = this._wbHistory   || [];
                    this.redoStack = this._wbRedoStack || [];

                    if (this.isStaffViewer) {
                        this.myCanvasId    = 'global-live-drawing-canvas';
                        this.otherCanvasId = 'student-live-drawing-canvas';
                    } else {
                        this.myCanvasId    = 'student-live-drawing-canvas';
                        this.otherCanvasId = 'global-live-drawing-canvas';
                    }

                    if (this.notebookPollInterval) {
                        clearInterval(this.notebookPollInterval);
                        this.notebookPollInterval = null;
                    }
                }

                this.activeTab = tab;
                // Force initCanvas() to re-run against the newly-active
                // surface (see resizeCanvas()'s "if (!this.ctx)" check)
                // instead of continuing to paint into whichever canvas was
                // active a moment ago.
                this.ctx      = null;
                this.otherCtx = null;

                this.$nextTick(() => {
                    this.resizeCanvas();
                    if (tab === 'notebook') this.pollNotebookState();
                });
            },

            /** 'whiteboard-canvas-body' | 'whiteboard-notebook-body' -
             *  whichever scrolling container currently owns the active
             *  canvas. initCanvas()/resizeCanvas()/growCanvasHeight()/
             *  showPendingImage() all measure against this instead of a
             *  single hardcoded id, so they work correctly regardless of
             *  which tab is active. */
            activeCanvasBodyId() {
                return this.activeTab === 'notebook' ? 'whiteboard-notebook-body' : 'whiteboard-canvas-body';
            },

            /**
             * Sync the notebook layer to the server. Always targets
             * ownUserId (never targetUserId, which can be pointed at a
             * broadcaster's room while watching one - see ownUserId's
             * docblock) and always an explicit layer='notebook' (never
             * role-inferred). Delegated to from the shared
             * syncDrawingToServer() whenever activeTab === 'notebook', so
             * every caller (manualSave, undo, redo, a stroke's pointerup,
             * clearCanvases()) can keep calling that one same entry point
             * either way.
             */
            syncNotebookToServer(clear = false) {
                if (!this.ownUserId) return Promise.resolve();
                const canvas = document.getElementById(this.notebookCanvasId);
                if (!canvas) return Promise.resolve();

                const body = clear
                    ? { targetUserId: this.ownUserId, payload: 'clear:notebook' }
                    : { targetUserId: this.ownUserId, payload: canvas.toDataURL('image/png'), layer: 'notebook' };

                return fetch('/api/live-drawing/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'Accept':           'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(body),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.time) this.notebookLastFetchTime = data.time;
                    return data;
                })
                .catch(err => console.error('[LiveDrawing] Notebook sync error:', err));
            },

            /**
             * Polls the notebook layer only, via the same fetch() endpoint
             * the whiteboard uses but with last_time_staff/last_time_student
             * pinned to an unreachably large value so the server never
             * re-sends those (possibly large) payloads here - the
             * whiteboard's own separate pollDrawingState() interval already
             * handles them on its own cadence (see its activeTab guard).
             * last_time_notebook is the only one this call actually cares
             * about. Renders straight through the whiteboard's own
             * renderBase64ToCanvas() - safe to reuse now that myCanvasId/
             * ctx genuinely point at the notebook canvas while this tab is
             * active (see switchTab()).
             */
            pollNotebookState() {
                if (!this.ownUserId || this.activeTab !== 'notebook') return;

                const url = `/api/live-drawing/fetch/${this.ownUserId}`
                    + `?last_time_staff=9007199254740991&last_time_student=9007199254740991`
                    + `&last_time_notebook=${this.notebookLastFetchTime}`;

                fetch(url, {
                    cache: 'no-store',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                })
                .then(res => res.ok ? res.json() : null)
                .then(data => {
                    if (!data || !data.success || !data.notebook) return;
                    if (data.notebook.time) this.notebookLastFetchTime = data.notebook.time;
                    if (data.notebook.payload !== undefined) {
                        this.renderBase64ToCanvas(data.notebook.payload, this.notebookCanvasId, this.ctx, false);
                    }
                })
                .catch(() => { /* silent - retried on the next 1.5s tick */ });
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

<x-submit-confirm-modal />
