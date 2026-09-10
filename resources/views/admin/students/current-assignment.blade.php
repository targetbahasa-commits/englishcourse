@extends('layouts.admin')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('students.show', $student) }}" class="hover:text-blue-600 transition-colors">{{ $student->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-900 font-medium">Current Assignment</span>
        </div>
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl text-gray-800">Live Assignment Snapshot</h2>
            <span id="auto-refresh-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span id="last-updated-text">Just now</span>
            </span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back
        </a>
        <a href="{{ route('students.show', $student) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition">
            Back to Student
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="p-8 max-w-5xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Student</p>
                <a href="{{ route('students.show', $student) }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition-colors">{{ $student->name }}</a>
                <p class="text-sm text-gray-500">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Detected Program</p>
                <p id="program-name" class="text-lg font-semibold text-blue-700">{{ $programName }}</p>
                <p id="last-activity" class="text-sm text-gray-500">
                    Last activity:
                    @if($lastActivityAt)
                        <span id="last-activity-human">{{ $lastActivityAt->diffForHumans() }}</span>
                    @else
                        <span id="last-activity-human">N/A</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Current Page URL</p>
        @if($activityUrl)
            <a id="activity-url" href="{{ $activityUrl }}" target="_blank" rel="noopener" class="text-sm font-medium text-blue-600 hover:text-blue-700 break-all">
                {{ $activityUrl }}
            </a>
        @else
            <p id="activity-url" class="text-sm text-gray-500">No active assignment URL detected from current session.</p>
        @endif
    </div>
</div>

{{-- Live view is intentionally outside the max-w-5xl wrapper above: the embedded
     student page's own layout (sidebar + wide content grid) needs much more width
     than the narrow reading-width container, or its CSS wraps/overlaps badly.
     No max-width/mx-auto here on purpose - capping+centering this block left a
     wide blank gap on either side (most noticeable next to the sidebar) on any
     screen wider than ~1800px+sidebar; filling the full available width avoids
     that regardless of viewport size. --}}
<div class="px-8 mt-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs uppercase tracking-wide text-gray-500">Live Student View (Same Layout)</p>
            <div class="flex items-center gap-2">
                {{-- Audio call status text - hidden (empty) while idle, filled in
                     by startAudioCall()/handleAudioSignal() below. Sits left of
                     the call button so "Memanggil..."/"Tersambung 00:12" etc.
                     never causes the button row to jump width. --}}
                <span id="audio-call-status-text" class="text-xs font-medium text-gray-500 mr-1"></span>
                <button id="btn-audio-call" onclick="toggleAudioCall()" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors border border-emerald-700 shadow-sm" title="Panggil Audio">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Panggil Audio
                </button>
                <button id="btn-toggle-coret" onclick="toggleCoret()" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors border border-indigo-700 shadow-sm" title="Toggle Coret-Coret Mode">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Mode Coret-Coret
                </button>
                <button onclick="
                let frame = document.getElementById('student-live-frame');
                let url = new URL(frame.src);
                url.searchParams.set('live_preview_tick', Date.now());
                frame.src = url.toString();
                refreshSnapshot();
            " class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 rounded-lg transition-colors border border-gray-200 shadow-sm" title="Reload iframe and fetch latest data">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
            </div>
        </div>

        @if($activityUrl)
            {{-- Wrapper with relative positioning to anchor the floating name badge --}}
            <div class="relative">
                {{-- Floating student name & status badge --}}
                <div id="student-status-floating-badge" class="absolute top-3 right-3 z-10 flex items-center gap-2.5 bg-slate-900/90 backdrop-blur-md text-white px-3.5 py-2 rounded-xl shadow-xl border border-slate-700/60 pointer-events-none select-none">
                    <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-white font-bold text-xs">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Student</span>
                        <a href="{{ route('students.show', $student) }}" class="text-sm font-semibold text-white hover:text-blue-400 transition-colors pointer-events-auto">{{ $student->name }}</a>
                    </div>
                    {{-- Status pill (LIVE vs OFF) --}}
                    <div id="student-live-status-pill" class="ml-1 flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-bold {{ ($isOnline ?? false) ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/40' : 'bg-slate-700/60 text-slate-300 border border-slate-600/50' }}">
                        @if($isOnline ?? false)
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                            </span>
                            <span>LIVE</span>
                        @else
                            <span class="inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                            <span>OFF</span>
                        @endif
                    </div>
                </div>

                <iframe
                    id="student-live-frame"
                    src="{{ $activityUrl }}{{ str_contains($activityUrl, '?') ? '&' : '?' }}live_preview_for={{ $student->id }}"
                    class="w-full rounded-xl border border-gray-200 bg-white"
                    style="height: 900px;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Live student assignment page preview"
                ></iframe>
            </div>
            <p class="text-xs text-gray-500 mt-3">Preview auto-reloads every 5 seconds to follow current student page.</p>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-sm text-gray-500 text-center">
                Live preview is unavailable because current assignment URL is not detected yet.
            </div>
        @endif
    </div>
</div>

{{-- Playback element for the student's incoming audio-call track (see
     handleAudioSignal()'s AudioCallAccepted branch below) - hidden, no
     visible player UI needed, just needs to actually be in the DOM for
     autoplay to work reliably across browsers. --}}
<audio id="remoteAudioStudentCall" autoplay style="display:none;"></audio>

<script>
    const studentId = {{ $student->id }};
    const jsonEndpoint = `/admin/students/${studentId}/current-assignment-json`;
    let secondsSinceUpdate = 0;
    let updateInterval;
    let timerInterval;
    let iframeRefreshTick = 0;

    // Which grammar-writing meeting number the iframe is CURRENTLY showing,
    // parsed the same way ManageStudents::resolveGrammarMeetingSnapshot()
    // parses it server-side. A polled snapshot can legitimately belong to a
    // different (older) meeting than what's on screen right now - either
    // because resolveGrammarMeetingSnapshotFromSession()'s whole-session
    // scan fell back to an unrelated meeting's leftover answers, or because
    // the student navigated to a new meeting between one 5s poll and the
    // next. Since many meetings reuse the same "answers[N]" field names,
    // injectSnapshotIntoIframe() flattening a mismatched snapshot's
    // raw_answers into this iframe would silently paint another meeting's
    // old answers over the one actually being previewed. Gate injection on
    // this matching the snapshot's own meeting_number instead of trusting
    // that whatever snapshot last arrived belongs to whatever page is
    // currently loaded.
    function extractMeetingNumber(url) {
        if (!url) return null;
        const match = url.match(/\/assignments\/grammar-writing\/(?:[^/?]+\/)?meeting\/?(\d+)/i);
        return match ? parseInt(match[1], 10) : null;
    }

    let currentIframeMeetingNumber = extractMeetingNumber(@js($activityUrl ?? null));

    // Format time difference
    function formatTimeDifference(seconds) {
        if (seconds < 5) return 'Just now';
        if (seconds < 60) return `${seconds} second${seconds !== 1 ? 's' : ''} ago`;
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
        const hours = Math.floor(minutes / 60);
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
    }

    // Update timer display
    function updateTimerDisplay() {
        secondsSinceUpdate++;
        const el = document.getElementById('last-updated-text');
        if (el) el.textContent = formatTimeDifference(secondsSinceUpdate);
    }

    // Fetch and update snapshot data
    async function refreshSnapshot() {
        try {
            const response = await fetch(jsonEndpoint);
            if (!response.ok) {
                console.error('Failed to refresh snapshot:', response.status);
                return;
            }

            const data = await response.json();
            
            // Update program name
            if (data.program_name) {
                document.getElementById('program-name').textContent = data.program_name;
            }

            // Update last activity
            if (data.last_activity_human) {
                document.getElementById('last-activity-human').textContent = data.last_activity_human;
            }

            // Update live / off status badge in floating badge
            const statusPill = document.getElementById('student-live-status-pill');
            if (statusPill && typeof data.is_online !== 'undefined') {
                if (data.is_online) {
                    statusPill.className = 'ml-1 flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/40';
                    statusPill.innerHTML = `
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        <span>LIVE</span>
                    `;
                } else {
                    statusPill.className = 'ml-1 flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-bold bg-slate-700/60 text-slate-300 border border-slate-600/50';
                    statusPill.innerHTML = `
                        <span class="inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                        <span>OFF</span>
                    `;
                }
            }

            // Update activity URL
            if (data.activity_url) {
                const urlElement = document.getElementById('activity-url');
                urlElement.href = data.activity_url;
                urlElement.textContent = data.activity_url;
                urlElement.className = 'text-sm font-medium text-blue-600 hover:text-blue-700 break-all';

                const openLiveView = document.getElementById('open-live-view');
                if (openLiveView) {
                    openLiveView.href = data.activity_url;
                }

                const liveFrame = document.getElementById('student-live-frame');
                if (liveFrame) {
                    const currentBaseUrl = liveFrame.src.split('?')[0];
                    const newBaseUrl = data.activity_url.split('?')[0];
                    const separator = data.activity_url.includes('?') ? '&' : '?';
                    
                    // Only reload iframe if the base URL actually changed (e.g. student moved to a new page)
                    if (currentBaseUrl !== newBaseUrl || liveFrame.src === '') {
                        liveFrame.src = `${data.activity_url}${separator}live_preview_tick=${Date.now()}&live_preview_for={{ $student->id }}`;
                        currentIframeMeetingNumber = extractMeetingNumber(data.activity_url);
                    }
                }
            }

            // Update snapshot data
            if (data.snapshot) {
                latestSnapshot = data.snapshot;
                injectSnapshotIntoIframe(latestSnapshot);
            }

            // Reset timer since we got fresh data
            secondsSinceUpdate = 0;
            const lastUpdatedEl = document.getElementById('last-updated-text');
            if (lastUpdatedEl) lastUpdatedEl.textContent = 'Just now';

        } catch (error) {
            console.error('Error refreshing snapshot:', error);
        }
    }

    let latestSnapshot = null;

    function injectSnapshotIntoIframe(snapshot) {
        if (!snapshot) return;
        // Refuse to paint a snapshot from a different grammar-writing
        // meeting than the one the iframe is currently displaying - see
        // currentIframeMeetingNumber's docblock above for why this can
        // otherwise happen even though nothing else here is misbehaving.
        if (snapshot.meeting_number !== null && snapshot.meeting_number !== undefined
            && currentIframeMeetingNumber !== null
            && parseInt(snapshot.meeting_number, 10) !== currentIframeMeetingNumber) {
            return;
        }
        const liveFrame = document.getElementById('student-live-frame');
        if (liveFrame && liveFrame.contentWindow && (snapshot.raw_answers || snapshot.raw_paragraph_answer)) {
            try {
                const iframeDoc = liveFrame.contentDocument || liveFrame.contentWindow.document;
                if (iframeDoc && iframeDoc.body && iframeDoc.body.innerHTML.trim() !== '') {
                    const flattened = {};
                    const flatten = (value, prefix) => {
                        if (value === null || value === undefined) {
                            return;
                        }
                        if (typeof value === 'object' && !Array.isArray(value)) {
                            Object.keys(value).forEach((key) => {
                                flatten(value[key], prefix ? `${prefix}[${key}]` : key);
                            });
                        } else if (Array.isArray(value)) {
                            value.forEach((item, idx) => {
                                flatten(item, prefix ? `${prefix}[${idx}]` : String(idx));
                            });
                        } else if (prefix) {
                            flattened[prefix] = (value === null || value === undefined) ? '' : value;
                        }
                    };

                    flatten(snapshot.raw_answers, '');
                    if (snapshot.raw_paragraph_answer !== undefined) {
                        if (!('userParagraphAnswer' in flattened)) {
                            flattened['userParagraphAnswer'] = snapshot.raw_paragraph_answer || '';
                        }
                        if (!('paragraph_answer' in flattened)) {
                            flattened['paragraph_answer'] = snapshot.raw_paragraph_answer || '';
                        }
                    }

                    Object.keys(flattened).forEach((name) => {
                        const value = flattened[name];
                        if (value === null || value === undefined) {
                            return;
                        }
                        const field = iframeDoc.querySelector(`[name="${CSS.escape(name)}"]`);
                        if (!field || field.readOnly || field.disabled) {
                            return;
                        }
                        if (field.type === 'checkbox' || field.type === 'radio') {
                            field.checked = (String(field.value) === String(value));
                        } else {
                            field.value = value;
                        }
                    });
                }
            } catch (e) {
                console.log("Could not inject answers into iframe", e);
            }
        }
    }

    // Initialize auto-refresh
    function initAutoRefresh() {
        const liveFrame = document.getElementById('student-live-frame');
        if (liveFrame) {
            liveFrame.addEventListener('load', () => {
                if (latestSnapshot) {
                    injectSnapshotIntoIframe(latestSnapshot);
                }
            });
        }

        // Initial fetch
        refreshSnapshot();

        // Update every 5 seconds
        updateInterval = setInterval(refreshSnapshot, 5000);

        // Update timer display every second
        timerInterval = setInterval(updateTimerDisplay, 1000);
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (updateInterval) clearInterval(updateInterval);
        if (timerInterval) clearInterval(timerInterval);
    });

    // Start auto-refresh when page loads
    document.addEventListener('DOMContentLoaded', initAutoRefresh);

    // Mode Coret-Coret Toggler
    let coretActive = false;
    function toggleCoret() {
        let frame = document.getElementById('student-live-frame');
        if (!frame) return;
        
        // Send message to iframe
        if (frame.contentWindow) {
            frame.contentWindow.postMessage({ type: 'TOGGLE_CORET' }, '*');
        }

        // Toggle state locally
        coretActive = !coretActive;
        let btn = document.getElementById('btn-toggle-coret');
        
        // Update button UI
        if (coretActive) {
            btn.classList.replace('bg-indigo-600', 'bg-rose-500');
            btn.classList.replace('hover:bg-indigo-700', 'hover:bg-rose-600');
            btn.classList.replace('border-indigo-700', 'border-rose-600');
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> Tutup Coret-Coret`;
        } else {
            btn.classList.replace('bg-rose-500', 'bg-indigo-600');
            btn.classList.replace('hover:bg-rose-600', 'hover:bg-indigo-700');
            btn.classList.replace('border-rose-600', 'border-indigo-700');
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg> Mode Coret-Coret`;
        }
    }

    // ── Audio Call (admin/teacher -> student, WebRTC) ──────────────────
    //
    // Ring-then-connect flow, mirroring (but not sharing state/UI with)
    // the existing screen-share Remote View feature - see
    // AudioCallController's docblock for why this needed its own "ring"
    // endpoints instead of reusing requestScreen() (that one is hard-
    // restricted to IELTS Writing pages and requires the student to have
    // manually armed a tab first; a voice call must work from wherever the
    // student currently is, with no arming step).
    //
    // 1. Click "Panggil Audio" -> POST /audio-call/request (no mic
    //    captured yet - see below for why).
    // 2. Student's browser (student-broadcaster.blade.php, global on every
    //    page) shows an incoming-call prompt. Accept -> student captures
    //    its own mic, builds its RTCPeerConnection, sends AudioCallAccepted
    //    (an ack only, no SDP - the student is never the offerer).
    // 3. THIS code receives AudioCallAccepted -> only NOW captures the
    //    admin's own mic (deliberately delayed past the button click so a
    //    call that goes unanswered/declined never opens the admin's mic at
    //    all), builds its own RTCPeerConnection, creates+sends an Offer.
    // 4. Student replies with an Answer; both sides trickle IceCandidate
    //    signals; both sides' ontrack fires once media flows.
    //
    // Signaling reuses the EXISTING generic remote-view.signal/
    // pending-signals endpoints unchanged (already unrestricted, already
    // proven for the screen-share feature) - this page just adds its own
    // polling loop for them, since (unlike remote-view/index.blade.php)
    // this page never had one before.
    let audioCallPeerConnection = null;
    let audioCallLocalStream = null;
    let audioCallState = 'idle'; // idle | calling | connecting | connected | ended
    let audioCallMuted = false;
    let audioCallEchoChannel = null;
    let audioCallSignalPollTimer = null;
    let audioCallRingTimeoutTimer = null;
    let audioCallDurationTimer = null;
    let audioCallSecondsElapsed = 0;
    const audioCallProcessedSignalIds = new Set();
    const audioCallIceConfig = {
        iceServers: [
            { urls: 'stun:stun.l.google.com:19302' },
            { urls: 'stun:stun.relay.metered.ca:80' },
            { urls: 'turn:global.relay.metered.ca:80', username: 'openrelayproject', credential: 'openrelayproject' },
            { urls: 'turn:global.relay.metered.ca:80?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' },
            { urls: 'turn:global.relay.metered.ca:443', username: 'openrelayproject', credential: 'openrelayproject' },
            { urls: 'turn:global.relay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' },
        ],
    };

    function audioCallCreateSignalId() {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            return window.crypto.randomUUID();
        }
        return `signal-${Date.now()}-${Math.random().toString(36).slice(2)}`;
    }

    function audioCallSerializeDescription(description) {
        if (!description) return null;
        return { type: description.type, sdp: description.sdp };
    }

    function audioCallNormalizeDescription(description) {
        if (!description) return null;
        if (typeof description === 'string') {
            try { return JSON.parse(description); } catch (_) { return null; }
        }
        if (description.type && description.sdp) {
            return { type: description.type, sdp: description.sdp };
        }
        return null;
    }

    function audioCallSerializeCandidate(candidate) {
        if (!candidate) return null;
        return {
            candidate: candidate.candidate,
            sdpMid: candidate.sdpMid,
            sdpMLineIndex: candidate.sdpMLineIndex,
            usernameFragment: candidate.usernameFragment ?? null,
        };
    }

    function audioCallNormalizeCandidate(candidate) {
        if (!candidate) return null;
        if (typeof candidate === 'string') {
            try { return JSON.parse(candidate); } catch (_) { return null; }
        }
        return candidate.candidate ? candidate : null;
    }

    function audioCallShouldProcessSignal(signalId) {
        if (!signalId) return true;
        if (audioCallProcessedSignalIds.has(signalId)) return false;
        audioCallProcessedSignalIds.add(signalId);
        if (audioCallProcessedSignalIds.size > 200) {
            const first = audioCallProcessedSignalIds.values().next().value;
            if (first) audioCallProcessedSignalIds.delete(first);
        }
        return true;
    }

    // Always posts the REST fallback (works even with broadcasting
    // disabled - see .env's BROADCAST_CONNECTION=null) and additionally
    // whispers if a real Echo connection is active; whispering on the mock
    // Echo object (see resources/js/echo.js) is a harmless no-op when it
    // isn't, so this is safe to call unconditionally either way.
    function audioCallSendSignal(type, payload = {}) {
        const signalId = payload.signal_id || audioCallCreateSignalId();
        const fullPayload = { ...payload, signal_id: signalId };

        window.axios.post('{{ route('remote-view.signal') }}', {
            target_id: studentId,
            type,
            payload: fullPayload,
        }).catch(() => {});

        if (audioCallEchoChannel) {
            audioCallEchoChannel.whisper(type, fullPayload);
        }

        return fullPayload;
    }

    function audioCallEnsureEchoChannel() {
        if (!audioCallEchoChannel && typeof window.Echo !== 'undefined') {
            audioCallEchoChannel = window.Echo.private('remote-view.' + studentId);
            audioCallEchoChannel
                .listenForWhisper('AudioCallAccepted', (e) => audioCallHandleSignal({ type: 'AudioCallAccepted', payload: e }))
                .listenForWhisper('AudioCallRejected', (e) => audioCallHandleSignal({ type: 'AudioCallRejected', payload: e }))
                .listenForWhisper('Answer', (e) => audioCallHandleSignal({ type: 'Answer', payload: e }))
                .listenForWhisper('IceCandidate', (e) => audioCallHandleSignal({ type: 'IceCandidate', payload: e }))
                .listenForWhisper('CloseSession', (e) => audioCallHandleSignal({ type: 'CloseSession', payload: e }))
                .listenForWhisper('Log', (e) => audioCallHandleSignal({ type: 'Log', payload: e }));
        }
    }

    function audioCallSetStatusText(text) {
        const el = document.getElementById('audio-call-status-text');
        if (el) el.textContent = text;
    }

    function audioCallSetButtonUI(state) {
        const btn = document.getElementById('btn-audio-call');
        if (!btn) return;

        if (state === 'active') {
            btn.classList.replace('bg-emerald-600', 'bg-rose-500');
            btn.classList.replace('hover:bg-emerald-700', 'hover:bg-rose-600');
            btn.classList.replace('border-emerald-700', 'border-rose-600');
            btn.title = 'Akhiri Panggilan';
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> Akhiri Panggilan`;
        } else {
            btn.classList.replace('bg-rose-500', 'bg-emerald-600');
            btn.classList.replace('hover:bg-rose-600', 'hover:bg-emerald-700');
            btn.classList.replace('border-rose-600', 'border-emerald-700');
            btn.title = 'Panggil Audio';
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> Panggil Audio`;
        }
    }

    function audioCallFormatDuration(totalSeconds) {
        const m = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
        const s = String(totalSeconds % 60).padStart(2, '0');
        return `${m}:${s}`;
    }

    function audioCallPollPendingSignals() {
        window.axios.get('{{ route('remote-view.pending-signals') }}')
            .then((res) => {
                const signals = Array.isArray(res.data?.signals) ? res.data.signals : [];
                signals.forEach((signal) => audioCallHandleSignal(signal));
            })
            .catch(() => {});
    }

    function audioCallStartSignalPolling() {
        if (audioCallSignalPollTimer) return;
        audioCallPollPendingSignals();
        audioCallSignalPollTimer = setInterval(audioCallPollPendingSignals, 1200);
    }

    function audioCallStopSignalPolling() {
        if (audioCallSignalPollTimer) {
            clearInterval(audioCallSignalPollTimer);
            audioCallSignalPollTimer = null;
        }
    }

    function toggleAudioCall() {
        if (audioCallState === 'idle' || audioCallState === 'ended') {
            startAudioCall();
        } else {
            endAudioCall('Panggilan diakhiri.');
        }
    }

    function startAudioCall() {
        audioCallState = 'calling';
        audioCallSetButtonUI('active');
        audioCallSetStatusText('Memanggil...');
        audioCallEnsureEchoChannel();
        audioCallStartSignalPolling();

        window.axios.post('{{ route('audio-call.request') }}', { target_id: studentId })
            .catch(() => {
                audioCallSetStatusText('Gagal memanggil.');
            });

        // No answer within 30s - most likely the student isn't online at
        // all (offline students never even see the incoming-call prompt).
        audioCallRingTimeoutTimer = setTimeout(() => {
            if (audioCallState === 'calling') {
                endAudioCall('Tidak ada jawaban.');
            }
        }, 30000);
    }

    function audioCallHandleSignal(signal) {
        if (!signal || !signal.type) return;
        const payload = signal.payload || signal;
        if (!audioCallShouldProcessSignal(payload.signal_id)) return;

        if (signal.type === 'AudioCallAccepted') {
            if (audioCallRingTimeoutTimer) {
                clearTimeout(audioCallRingTimeoutTimer);
                audioCallRingTimeoutTimer = null;
            }
            audioCallState = 'connecting';
            audioCallSetStatusText('Tersambung...');

            if (!window.isSecureContext || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                audioCallSetStatusText('Mikrofon tidak tersedia (butuh HTTPS).');
                endAudioCall(null);
                return;
            }

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then((stream) => {
                    audioCallLocalStream = stream;
                    audioCallPeerConnection = new RTCPeerConnection(audioCallIceConfig);

                    stream.getTracks().forEach((track) => audioCallPeerConnection.addTrack(track, stream));

                    audioCallPeerConnection.onicecandidate = (event) => {
                        if (event.candidate) {
                            audioCallSendSignal('IceCandidate', { candidate: audioCallSerializeCandidate(event.candidate) });
                        }
                    };

                    audioCallPeerConnection.ontrack = (event) => {
                        const audioEl = document.getElementById('remoteAudioStudentCall');
                        if (audioEl && audioEl.srcObject !== event.streams[0]) {
                            audioEl.srcObject = event.streams[0];
                        }
                    };

                    audioCallPeerConnection.createOffer()
                        .then((offer) => audioCallPeerConnection.setLocalDescription(offer))
                        .then(() => {
                            audioCallSendSignal('Offer', { offer: audioCallSerializeDescription(audioCallPeerConnection.localDescription) });
                        })
                        .catch(() => {
                            audioCallSetStatusText('Gagal memulai panggilan.');
                            endAudioCall(null);
                        });
                })
                .catch(() => {
                    audioCallSetStatusText('Akses mikrofon ditolak.');
                    endAudioCall(null);
                });
            return;
        }

        if (signal.type === 'AudioCallRejected') {
            endAudioCall('Panggilan ditolak.');
            return;
        }

        if (signal.type === 'Answer') {
            const answer = audioCallNormalizeDescription(payload.answer);
            if (audioCallPeerConnection && answer) {
                audioCallPeerConnection.setRemoteDescription(new RTCSessionDescription(answer)).then(() => {
                    audioCallState = 'connected';
                    audioCallSecondsElapsed = 0;
                    audioCallSetStatusText(audioCallFormatDuration(0));
                    audioCallDurationTimer = setInterval(() => {
                        audioCallSecondsElapsed++;
                        audioCallSetStatusText(audioCallFormatDuration(audioCallSecondsElapsed));
                    }, 1000);
                });
            }
            return;
        }

        if (signal.type === 'IceCandidate') {
            const candidate = audioCallNormalizeCandidate(payload.candidate);
            if (audioCallPeerConnection && candidate) {
                audioCallPeerConnection.addIceCandidate(new RTCIceCandidate(candidate)).catch(() => {});
            }
            return;
        }

        if (signal.type === 'CloseSession') {
            endAudioCall('Panggilan berakhir.', /* alreadyClosedByPeer */ true);
        }
    }

    function endAudioCall(statusMessage, alreadyClosedByPeer = false) {
        if (audioCallRingTimeoutTimer) {
            clearTimeout(audioCallRingTimeoutTimer);
            audioCallRingTimeoutTimer = null;
        }
        if (audioCallDurationTimer) {
            clearInterval(audioCallDurationTimer);
            audioCallDurationTimer = null;
        }

        if (!alreadyClosedByPeer && (audioCallState === 'connecting' || audioCallState === 'connected')) {
            audioCallSendSignal('CloseSession', {});
        }

        if (audioCallLocalStream) {
            audioCallLocalStream.getTracks().forEach((track) => track.stop());
            audioCallLocalStream = null;
        }
        if (audioCallPeerConnection) {
            audioCallPeerConnection.close();
            audioCallPeerConnection = null;
        }

        const audioEl = document.getElementById('remoteAudioStudentCall');
        if (audioEl) audioEl.srcObject = null;

        audioCallStopSignalPolling();
        audioCallState = 'ended';
        audioCallMuted = false;
        audioCallSetButtonUI('idle');
        if (statusMessage) {
            audioCallSetStatusText(statusMessage);
            setTimeout(() => {
                if (audioCallState === 'ended') {
                    audioCallState = 'idle';
                    audioCallSetStatusText('');
                }
            }, 4000);
        } else {
            audioCallState = 'idle';
            audioCallSetStatusText('');
        }
    }

    // A closed/navigated-away admin tab mid-call must never leave the
    // student's side stuck "connected" with no way to know the admin is
    // gone - mirrors the same beforeunload -> CloseSession pattern already
    // used by student-broadcaster.blade.php's own signaling cleanup.
    window.addEventListener('beforeunload', () => {
        if (audioCallState === 'connecting' || audioCallState === 'connected') {
            audioCallSendSignal('CloseSession', {});
        }
    });
</script>
@endsection
