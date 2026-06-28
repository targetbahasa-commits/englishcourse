<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Remote View - {{ $user->name }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="remoteView()" class="font-sans antialiased bg-gray-900 text-white min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <nav class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex items-center justify-between shadow-sm z-10">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                 <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-lg border border-blue-500/30">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-100 flex items-center gap-2">
                        Viewing Screen: {{ $user->name }}
                        <span x-show="status === 'live'" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20" style="display: none;">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Live
                        </span>
                        <span x-show="status !== 'live'" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-500/10 text-gray-400 border border-gray-500/20">
                            Offline
                        </span>
                    </h1>
                    <p class="text-xs text-gray-400 capitalize">Role: {{ $user->role }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Controls -->
            <div class="flex items-center gap-3 bg-gray-700/50 p-1.5 rounded-lg border border-gray-600">
                <div class="flex items-center gap-2 px-2">
                    <label class="text-xs text-gray-300">Task</label>
                    <select x-model="writingTask" class="h-9 rounded-md border border-gray-600 bg-gray-800 text-xs text-gray-100 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="1">Task 1</option>
                        <option value="2">Task 2</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 px-2">
                    <label class="text-xs text-gray-300">Meeting</label>
                    <input type="number" min="1" x-model="writingMeetingId" placeholder="33" class="h-9 w-20 rounded-md border border-gray-600 bg-gray-800 text-xs text-gray-100 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500/50" />
                </div>
                <button type="button" @click="openLiveDraftMonitor()" :disabled="!canBuildWritingTarget()" :class="{'opacity-40 cursor-not-allowed': !canBuildWritingTarget()}" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-md shadow-sm transition">
                    Open Live Draft
                </button>
                <div class="h-6 w-px bg-gray-600 mx-1"></div>
                <button type="button" @click="toggleMic()" :class="micActive ? 'bg-indigo-600 hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.5)]' : 'bg-gray-600 hover:bg-gray-500'" class="px-4 py-2 text-white text-sm font-semibold rounded-md shadow-sm transition flex items-center gap-2">
                    <svg x-show="!micActive" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <svg x-show="micActive" class="w-4 h-4 animate-pulse text-red-300" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <span x-text="micActive ? 'Mic Active' : 'Activate Mic'"></span>
                </button>
                <div class="h-6 w-px bg-gray-600 mx-1"></div>
                <button type="button" @click="requestScreen()" :disabled="['requesting', 'accepted', 'live'].includes(status)" :class="{'opacity-50 cursor-not-allowed': ['requesting', 'accepted', 'live'].includes(status)}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-md shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span x-text="status === 'requesting' ? 'Requesting...' : (status === 'live' ? 'Screen Shared' : 'Request Screen')"></span>
                </button>
            </div>
            
            <div class="h-8 w-px bg-gray-700 mx-2"></div>

            <button @click="closeSession()" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/20 text-sm font-semibold rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Close Session
            </button>
        </div>
    </nav>

    <!-- Main Screen Area -->
    <main class="flex-1 p-6 flex flex-col items-center justify-center relative overflow-hidden bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')]">
        
        <!-- Video Container -->
        <div class="w-full h-full max-w-7xl max-h-[85vh] aspect-video bg-gray-950 rounded-2xl shadow-2xl border border-gray-800 flex flex-col items-center justify-center relative overflow-hidden group">
            
            <!-- Video Element (Hidden until live) -->
            <video id="remoteVideo" autoplay playsinline muted x-show="status === 'live'" class="w-full h-full object-contain bg-black z-20" style="display: none;"></video>

            <!-- Placeholder overlays -->
            <div x-show="status !== 'live'" class="absolute inset-0 flex items-center justify-center bg-gray-900/80 backdrop-blur-sm z-10 transition-opacity">
                <div class="text-center p-8">
                    
                    <div x-show="status === 'awaiting' || status === 'stopped'" class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl border border-gray-700">
                         <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>

                    <div x-show="['requesting', 'accepted'].includes(status)" style="display: none;" class="w-20 h-20 bg-emerald-900/50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(16,185,129,0.3)] border border-emerald-500/30">
                         <svg class="w-10 h-10 text-emerald-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <div x-show="status === 'rejected'" style="display: none;" class="w-20 h-20 bg-red-900/50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(239,68,68,0.3)] border border-red-500/30">
                         <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-200 mb-2" x-text="statusTextHeading"></h2>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto" x-text="statusTextSub"></p>
                    
                    <div x-show="['requesting', 'accepted'].includes(status)" style="display: none;" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 rounded-full border border-gray-700 shadow-inner">
                        <svg class="w-4 h-4 text-emerald-400 animate-spin" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-300" x-text="status === 'requesting' ? 'Waiting for user to accept...' : 'Establishing secure connection...'"></span>
                    </div>

                    <button x-show="status === 'awaiting'" @click="requestScreen()" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-lg shadow-lg hover:shadow-emerald-600/30 transition flex items-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Request Screen Share Now
                    </button>
                    
                    <button x-show="['rejected', 'stopped'].includes(status)" style="display: none;" @click="requestScreen()" class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg transition flex items-center gap-2 mx-auto mt-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Try Again
                    </button>
                </div>
            </div>

            <!-- Fake screen background (aesthetic only) -->
            <div x-show="status !== 'live'" class="absolute inset-0 opacity-10 pointer-events-none p-4">
                <div class="w-full h-12 bg-gray-800 rounded-t-lg border-b border-gray-700 flex items-center px-4 gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div><div class="w-3 h-3 rounded-full bg-yellow-500"></div><div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="flex-1 mx-4 h-6 bg-gray-700 rounded text-center text-[10px] text-gray-400 leading-6 font-mono">https://targetbahasa.com/dashboard</div>
                </div>
                <div class="w-full h-[calc(100%-3rem)] bg-white rounded-b-lg"></div>
            </div>

        </div>

    </main>

    <script>
        @php
            $liveDraftRouteTemplate = auth()->user()->role === 'admin'
                ? route('admin.live-draft.ielts-writing', ['user' => $user->id, 'task' => '__TASK__', 'meetingId' => '__MEETING__'])
                : route('teacher.live-draft.ielts-writing', ['user' => $user->id, 'task' => '__TASK__', 'meetingId' => '__MEETING__']);
        @endphp

        document.addEventListener('alpine:init', () => {
            Alpine.data('remoteView', () => ({
                status: 'awaiting', // awaiting, requesting, accepted, rejected, live, stopped
                targetName: '{!! addslashes($user->name) !!}',
                targetId: {{ $user->id }},
                writingTask: '2',
                writingMeetingId: '',
                echoChannel: null,
                peerConnection: null,
                localStream: null,
                micActive: false,
                noTrackTimer: null,
                rejectionReason: '',
                signalPollingTimer: null,
                processedSignalIds: new Set(),
                config: {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun.relay.metered.ca:80' },
                        { urls: 'turn:global.relay.metered.ca:80',              username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:80?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:443',             username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' }
                    ]
                },

                get statusTextHeading() {
                    const map = {
                        'awaiting': 'Awaiting Screen Stream',
                        'requesting': 'Request Sent',
                        'accepted': 'Request Accepted',
                        'live': 'Live',
                        'rejected': 'Request Denied',
                        'stopped': 'Session Ended'
                    };
                    return map[this.status] || 'Connecting...';
                },

                get statusTextSub() {
                    const map = {
                        'awaiting': `Click 'Request Screen Share' to send a popup prompt to ${this.targetName}.`,
                        'requesting': `Waiting for ${this.targetName} to accept the prompt and choose a screen to share.`,
                        'accepted': `${this.targetName} accepted. Initializing WebRTC handshake...`,
                        'live': `Viewing ${this.targetName}'s screen in real-time.`,
                        'rejected': this.rejectionReason || `${this.targetName} dismissed or denied the screen share request.`,
                        'stopped': `${this.targetName} stopped sharing their screen.`
                    };
                    return map[this.status] || '';
                },

                iceCandidateQueue: [],

                createSignalId() {
                    if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                        return window.crypto.randomUUID();
                    }

                    return `signal-${Date.now()}-${Math.random().toString(36).slice(2)}`;
                },

                serializeDescription(description) {
                    if (!description) {
                        return null;
                    }

                    return {
                        type: description.type,
                        sdp: description.sdp,
                    };
                },

                normalizeDescription(description) {
                    if (!description) {
                        return null;
                    }

                    if (typeof description === 'string') {
                        try {
                            return JSON.parse(description);
                        } catch (_) {
                            return null;
                        }
                    }

                    if (description.type && description.sdp) {
                        return {
                            type: description.type,
                            sdp: description.sdp,
                        };
                    }

                    return null;
                },

                serializeCandidate(candidate) {
                    if (!candidate) {
                        return null;
                    }

                    return {
                        candidate: candidate.candidate,
                        sdpMid: candidate.sdpMid,
                        sdpMLineIndex: candidate.sdpMLineIndex,
                        usernameFragment: candidate.usernameFragment ?? null,
                    };
                },

                normalizeCandidate(candidate) {
                    if (!candidate) {
                        return null;
                    }

                    if (typeof candidate === 'string') {
                        try {
                            return JSON.parse(candidate);
                        } catch (_) {
                            return null;
                        }
                    }

                    if (candidate.candidate) {
                        return candidate;
                    }

                    return null;
                },

                shouldProcessSignal(signalId) {
                    if (!signalId) {
                        return true;
                    }

                    if (this.processedSignalIds.has(signalId)) {
                        return false;
                    }

                    this.processedSignalIds.add(signalId);
                    if (this.processedSignalIds.size > 300) {
                        const firstValue = this.processedSignalIds.values().next().value;
                        if (firstValue) {
                            this.processedSignalIds.delete(firstValue);
                        }
                    }

                    return true;
                },

                sendSignalFallback(type, payload = {}) {
                    const signalId = payload.signal_id || this.createSignalId();
                    const fullPayload = { ...payload, signal_id: signalId };

                    window.axios.post('{{ route('remote-view.signal') }}', {
                        target_id: this.targetId,
                        type,
                        payload: fullPayload,
                    }).catch(() => {});

                    return fullPayload;
                },

                whisperAndSignal(type, payload = {}) {
                    const fullPayload = this.sendSignalFallback(type, payload);
                    if (this.echoChannel) {
                        this.echoChannel.whisper(type, fullPayload);
                    }
                    return fullPayload;
                },

                handleAccepted(e = {}) {
                    if (!this.shouldProcessSignal(e.signal_id)) {
                        return;
                    }
                    this.rejectionReason = '';
                    this.status = 'accepted';
                },

                handleRejected(e = {}) {
                    if (!this.shouldProcessSignal(e.signal_id)) {
                        return;
                    }
                    this.rejectionReason = e.reason || '';
                    this.status = 'rejected';
                },

                handleStopped() {
                    this.status = 'stopped';
                    if(this.peerConnection) {
                        this.peerConnection.close();
                        this.peerConnection = null;
                    }
                    const videoEl = document.getElementById('remoteVideo');
                    if(videoEl) videoEl.srcObject = null;
                },

                handleOffer(e = {}) {
                    if (!this.shouldProcessSignal(e.signal_id)) {
                        return;
                    }

                    const offer = this.normalizeDescription(e.offer);
                    if (!offer) {
                        alert('Offer handling error: Invalid SDP payload.');
                        return;
                    }

                    this.status = 'live';
                    if (this.noTrackTimer) {
                        clearTimeout(this.noTrackTimer);
                    }
                    this.noTrackTimer = setTimeout(() => {
                        const videoEl = document.getElementById('remoteVideo');
                        const hasTrack = !!(videoEl && videoEl.srcObject && videoEl.srcObject.getVideoTracks && videoEl.srcObject.getVideoTracks().length > 0);
                        if (!hasTrack) {
                            this.status = 'requesting';
                            alert('Request accepted, but no screen track was received. Ask the teacher to retry and ensure screen sharing is allowed in the browser.');
                        }
                    }, 7000);

                    if (!this.peerConnection) {
                         this.setupPeerConnection();
                    }
                    this.peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
                        .then(() => this.peerConnection.createAnswer())
                        .then(answer => this.peerConnection.setLocalDescription(answer))
                        .then(() => {
                            this.whisperAndSignal('Answer', {
                                answer: this.serializeDescription(this.peerConnection.localDescription),
                                target: this.targetId
                            });
                            while(this.iceCandidateQueue.length > 0) {
                                let c = this.iceCandidateQueue.shift();
                                this.peerConnection.addIceCandidate(new RTCIceCandidate(c)).catch(console.error);
                            }
                        })
                        .catch(err => {
                            console.error("Error handling offer: ", err);
                            alert("Offer handling error: " + err.message);
                        });
                },

                handleIceCandidate(e = {}) {
                    if (!this.shouldProcessSignal(e.signal_id)) {
                        return;
                    }

                    const candidate = this.normalizeCandidate(e.candidate);
                    if (!candidate) {
                        return;
                    }

                    if (this.peerConnection) {
                        if (this.peerConnection.remoteDescription && this.peerConnection.remoteDescription.type) {
                            this.peerConnection.addIceCandidate(new RTCIceCandidate(candidate)).catch(console.error);
                        } else {
                            this.iceCandidateQueue.push(candidate);
                        }
                    }
                },

                handleLog(e = {}) {
                    console.log("Remote Log:", e.message);
                    if(e.isError) {
                        alert("Student Side Error: " + e.message);
                        this.status = 'awaiting';
                    }
                },

                pollPendingSignals() {
                    window.axios.get('{{ route('remote-view.pending-signals') }}')
                        .then((res) => {
                            const signals = Array.isArray(res.data?.signals) ? res.data.signals : [];
                            signals.forEach((signal) => {
                                const payload = signal.payload || {};
                                const eventPayload = { ...payload, fromId: signal.fromId, fromName: signal.fromName };
                                if (signal.type === 'ScreenAccepted') this.handleAccepted(eventPayload);
                                if (signal.type === 'ScreenRejected') this.handleRejected(eventPayload);
                                if (signal.type === 'ScreenStopped') this.handleStopped();
                                if (signal.type === 'Offer') this.handleOffer(eventPayload);
                                if (signal.type === 'IceCandidate') this.handleIceCandidate(eventPayload);
                                if (signal.type === 'Log') this.handleLog(eventPayload);
                            });
                        })
                        .catch(() => {});
                },

                canBuildWritingTarget() {
                    const meeting = parseInt(this.writingMeetingId, 10);
                    const task = parseInt(this.writingTask, 10);
                    return Number.isInteger(meeting) && meeting > 0 && (task === 1 || task === 2);
                },

                buildWritingTarget() {
                    if (!this.canBuildWritingTarget()) {
                        return null;
                    }

                    const task = parseInt(this.writingTask, 10);
                    const meeting = parseInt(this.writingMeetingId, 10);
                    return {
                        path: `/assignments/ielts-academic/writing/${task}/meeting/${meeting}`,
                        title: `IELTS Writing Task ${task} - Meeting ${meeting}`,
                        monitorUrl: @json($liveDraftRouteTemplate)
                            .replace('__TASK__', String(task))
                            .replace('__MEETING__', String(meeting)),
                    };
                },

                openLiveDraftMonitor() {
                    const target = this.buildWritingTarget();
                    if (!target) {
                        alert('Isi Task dan Meeting dulu.');
                        return;
                    }

                    window.open(target.monitorUrl, '_blank', 'noopener');
                },

                init() {
                    const query = new URLSearchParams(window.location.search);
                    const queryTask = query.get('task');
                    const queryMeeting = query.get('meeting');
                    const autoRequest = query.get('auto_request') === '1';

                    if (queryTask === '1' || queryTask === '2') {
                        this.writingTask = queryTask;
                    }

                    if (queryMeeting && /^\d+$/.test(queryMeeting)) {
                        this.writingMeetingId = queryMeeting;
                    }

                    if (typeof window.Echo !== 'undefined') {
                        this.echoChannel = window.Echo.private('remote-view.' + this.targetId);
                        
                        this.echoChannel.listenForWhisper('ScreenAccepted', (e) => this.handleAccepted(e))
                        .listenForWhisper('ScreenRejected', (e) => this.handleRejected(e))
                        .listenForWhisper('ScreenStopped', () => this.handleStopped())
                        .listenForWhisper('Offer', (e) => this.handleOffer(e))
                        .listenForWhisper('IceCandidate', (e) => this.handleIceCandidate(e))
                        .listenForWhisper('Log', (e) => this.handleLog(e));

                        this.pollPendingSignals();
                        this.signalPollingTimer = setInterval(() => this.pollPendingSignals(), 1200);

                        if (autoRequest) {
                            setTimeout(() => this.requestScreen(), 350);
                        }
                    } else {
                        console.error('Laravel Echo is not defined.');
                    }
                },

                requestScreen() {
                    if(!this.echoChannel) return;
                    this.rejectionReason = '';
                    this.status = 'requesting';

                    const writingTarget = this.buildWritingTarget();
                    const payload = {
                        target_id: this.targetId,
                    };

                    if (writingTarget) {
                        payload.target_path = writingTarget.path;
                        payload.target_title = writingTarget.title;
                    }

                    window.axios.post('{{ route('remote-view.request-screen') }}', {
                        ...payload,
                    }).catch(() => {
                        // Fallback to whisper in case broadcast endpoint fails.
                        this.echoChannel.whisper('RequestScreen', {
                            fromId: {{ auth()->id() }},
                            fromName: '{!! addslashes(auth()->user()->name) !!}',
                            target_path: payload.target_path || null,
                            target_title: payload.target_title || null,
                        });
                    });
                },

                setupPeerConnection() {
                    this.peerConnection = new RTCPeerConnection(this.config);
                    
                    this.peerConnection.onicecandidate = event => {
                        if (event.candidate) {
                            this.whisperAndSignal('IceCandidate', {
                                candidate: this.serializeCandidate(event.candidate),
                                target: this.targetId
                            });
                        }
                    };

                    this.peerConnection.ontrack = event => {
                        const videoEl = document.getElementById('remoteVideo');
                        if (videoEl && videoEl.srcObject !== event.streams[0]) {
                            videoEl.srcObject = event.streams[0];
                            videoEl.play().catch(() => {});
                        }
                    };
                    
                    // If mic is already active, add its track to the new connection
                    if(this.localStream) {
                         this.localStream.getTracks().forEach(track => {
                             this.peerConnection.addTrack(track, this.localStream);
                         });
                    }
                },

                toggleMic() {
                    if(this.micActive && this.localStream) {
                        this.localStream.getTracks().forEach(track => track.stop());
                        this.localStream = null;
                        this.micActive = false;
                    } else {
                        navigator.mediaDevices.getUserMedia({ audio: true })
                            .then(stream => {
                                this.localStream = stream;
                                this.micActive = true;
                                
                                if(this.peerConnection) {
                                    stream.getTracks().forEach(track => {
                                        this.peerConnection.addTrack(track, this.localStream);
                                    });
                                    // Make new offer to add mic track
                                    this.peerConnection.createOffer()
                                        .then(offer => this.peerConnection.setLocalDescription(offer))
                                        .then(() => {
                                            this.whisperAndSignal('Offer', {
                                                offer: this.serializeDescription(this.peerConnection.localDescription),
                                                target: this.targetId
                                            });
                                        })
                                        .catch(err => console.error("Error creating renegotiation offer: ", err));
                                }
                            })
                            .catch(err => {
                                console.error("Mic error", err);
                                alert("Browser could not access your microphone.");
                            });
                    }
                },

                closeSession() {
                    if(this.echoChannel) {
                        this.whisperAndSignal('CloseSession', { target: this.targetId });
                    }
                    if(this.localStream) {
                        this.localStream.getTracks().forEach(track => track.stop());
                    }
                    if(this.peerConnection) {
                        this.peerConnection.close();
                    }
                    if (this.signalPollingTimer) {
                        clearInterval(this.signalPollingTimer);
                    }
                    window.close();
                }
            }));
        });
    </script>
</body>
</html>
