@if(auth()->check())
    <script>
        const initBroadcaster = () => {
            if (typeof window.Echo === 'undefined') {
                // Echo not ready yet — retry in 100ms (race condition prevention)
                if (!window._broadcasterRetries) window._broadcasterRetries = 0;
                if (window._broadcasterRetries++ < 100) {
                    setTimeout(initBroadcaster, 100);
                } else {
                    console.warn('Laravel Echo did not load in time. WebRTC features disabled.');
                }
                return;
            }
            if (window._broadcasterInitialized) return; // Guard against double-init
            window._broadcasterInitialized = true;

            {
                const userId = {{ auth()->id() }};
                const remoteShareConfig = window.remoteShareConfig || { enabled: false, pageKey: null };
                const activeTabStorageKey = 'remote-share-active-tab-id';
                const activePageStorageKey = 'remote-share-active-page-key';
                const activeHeartbeatStorageKey = 'remote-share-active-tab-heartbeat';
                const tabIdStorageKey = 'remote-share-tab-id';
                const deferredRequestStorageKey = 'remote-share-deferred-request';
                const lastCourseUrlStorageKey = 'remote-share-last-course-url';
                const lastCourseTitleStorageKey = 'remote-share-last-course-title';
                const tabId = sessionStorage.getItem(tabIdStorageKey) || `remote-share-tab-${Date.now()}-${Math.random().toString(36).slice(2)}`;
                sessionStorage.setItem(tabIdStorageKey, tabId);

                const getActiveTabId = () => localStorage.getItem(activeTabStorageKey);
                const getActivePageKey = () => localStorage.getItem(activePageStorageKey);
                const isActiveOwnerFresh = () => {
                    const heartbeat = Number(localStorage.getItem(activeHeartbeatStorageKey) || 0);
                    return heartbeat > 0 && (Date.now() - heartbeat) < 10000;
                };
                const isCurrentTabArmed = () => remoteShareConfig.enabled
                    && getActiveTabId() === tabId
                    && getActivePageKey() === remoteShareConfig.pageKey;

                if (!remoteShareConfig.enabled && getActiveTabId() === tabId) {
                    localStorage.removeItem(activeTabStorageKey);
                    localStorage.removeItem(activePageStorageKey);
                    localStorage.removeItem(activeHeartbeatStorageKey);
                }
                
                // --- 1. Presence Channel for Monitoring (existing) ---
                const channel = window.Echo.join('monitoring');
                const broadcastCurrentPage = () => {
                    channel.whisper('client-page-update', {
                        id: userId,
                        name: '{{ addslashes(auth()->user()->name) }}',
                        url: window.location.href,
                        title: document.title,
                        timestamp: new Date().toISOString()
                    });
                };
                channel.here((users) => {
                    broadcastCurrentPage();
                });
                setInterval(broadcastCurrentPage, 30000);

                // --- 2. WebRTC Signaling Channel (New) ---
                const webrtcChannel = window.Echo.private('remote-view.' + userId);
                let peerConnection = null;
                let localStream = null;
                let lastRequestFromId = null;
                let lastRequestAt = 0;
                let pollingTimer = null;
                let signalPollingTimer = null;
                const processedSignalIds = new Set();
                const config = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun.relay.metered.ca:80' },
                        { urls: 'turn:global.relay.metered.ca:80',         username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:80?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:443',        username: 'openrelayproject', credential: 'openrelayproject' },
                        { urls: 'turn:global.relay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' }
                    ]
                };

                    const buildDisplayMediaOptions = () => {
                        const options = {
                            video: {
                                cursor: 'always',
                                displaySurface: 'browser',
                            },
                            audio: false,
                        };

                        options.preferCurrentTab = true;
                        options.selfBrowserSurface = 'include';
                        options.surfaceSwitching = 'exclude';
                        options.monitorTypeSurfaces = 'exclude';

                        return options;
                    };

                const createSignalId = () => {
                    if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                        return window.crypto.randomUUID();
                    }

                    return `signal-${Date.now()}-${Math.random().toString(36).slice(2)}`;
                };

                const serializeDescription = (description) => {
                    if (!description) {
                        return null;
                    }

                    return {
                        type: description.type,
                        sdp: description.sdp,
                    };
                };

                const normalizeDescription = (description) => {
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
                };

                const serializeCandidate = (candidate) => {
                    if (!candidate) {
                        return null;
                    }

                    return {
                        candidate: candidate.candidate,
                        sdpMid: candidate.sdpMid,
                        sdpMLineIndex: candidate.sdpMLineIndex,
                        usernameFragment: candidate.usernameFragment ?? null,
                    };
                };

                const normalizeCandidate = (candidate) => {
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
                };

                const shouldProcessSignal = (signalId) => {
                    if (!signalId) {
                        return true;
                    }

                    if (processedSignalIds.has(signalId)) {
                        return false;
                    }

                    processedSignalIds.add(signalId);
                    if (processedSignalIds.size > 300) {
                        const firstValue = processedSignalIds.values().next().value;
                        if (firstValue) {
                            processedSignalIds.delete(firstValue);
                        }
                    }

                    return true;
                };

                const sendSignalFallback = (type, targetId, payload = {}) => {
                    const signalId = payload.signal_id || createSignalId();
                    const fullPayload = { ...payload, signal_id: signalId };

                    if (type === 'RequestScreen') {
                        return fullPayload;
                    }

                    window.axios.post('{{ route('remote-view.signal') }}', {
                        target_id: targetId,
                        type,
                        payload: fullPayload,
                    }).catch(() => {});

                    return fullPayload;
                };

                const whisperAndSignal = (type, targetId, payload = {}) => {
                    const fullPayload = sendSignalFallback(type, targetId, payload);
                    webrtcChannel.whisper(type, fullPayload);
                    return fullPayload;
                };

                const handleFallbackSignal = (signal) => {
                    if (!signal || !signal.type) {
                        return;
                    }

                    const payload = signal.payload || {};
                    if (!shouldProcessSignal(payload.signal_id || signal.signal_id)) {
                        return;
                    }

                    if (signal.type === 'Answer') {
                        const answer = normalizeDescription(payload.answer);
                        if (peerConnection && answer) {
                            peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
                        }
                        return;
                    }

                    if (signal.type === 'IceCandidate') {
                        const candidate = normalizeCandidate(payload.candidate);
                        if (peerConnection && candidate) {
                            peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
                        }
                        return;
                    }

                    if (signal.type === 'Offer') {
                        const offer = normalizeDescription(payload.offer);
                        if (peerConnection && offer) {
                            peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
                                .then(() => peerConnection.createAnswer())
                                .then(answer => peerConnection.setLocalDescription(answer))
                                .then(() => {
                                    whisperAndSignal('Answer', signal.fromId, {
                                        answer: serializeDescription(peerConnection.localDescription),
                                        target: signal.fromId,
                                    });
                                });
                        }
                        return;
                    }

                    if (signal.type === 'CloseSession') {
                        if (localStream) {
                            localStream.getTracks().forEach(track => track.stop());
                        }
                        if (peerConnection) {
                            peerConnection.close();
                            peerConnection = null;
                        }
                    }
                };

                const pollPendingSignals = () => {
                    window.axios.get('{{ route('remote-view.pending-signals') }}')
                        .then((res) => {
                            const signals = Array.isArray(res.data?.signals) ? res.data.signals : [];
                            signals.forEach(handleFallbackSignal);
                        })
                        .catch(() => {});
                };

                // Insert SweetAlert2 dynamically if not present
                if (!document.getElementById('sweetalert2-styles')) {
                    const style = document.createElement('link');
                    style.id = 'sweetalert2-styles';
                    style.rel = 'stylesheet';
                    style.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
                    document.head.appendChild(style);
                }

                if(!window.Swal) {
                    const script = document.createElement('script');
                    script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
                    document.head.appendChild(script);
                }

                const normalizeTargetUrl = (targetPath) => {
                    if (!targetPath || typeof targetPath !== 'string') {
                        return null;
                    }

                    try {
                        if (targetPath.startsWith('http://') || targetPath.startsWith('https://')) {
                            const parsed = new URL(targetPath);
                            if (parsed.origin !== window.location.origin) {
                                return null;
                            }

                            return `${parsed.pathname}${parsed.search || ''}`;
                        }

                        if (!targetPath.startsWith('/')) {
                            return null;
                        }

                        return targetPath;
                    } catch (_) {
                        return null;
                    }
                };

                const notifyCourseTabRequired = (e, message) => {
                    const fallbackUrl = '{{ route('assignments.index') }}';
                    const requestedUrl = normalizeTargetUrl(e.target_path);
                    const requestedTitle = e.target_title || null;
                    const targetUrl = requestedUrl || localStorage.getItem(lastCourseUrlStorageKey) || fallbackUrl;
                    const lastCourseTitle = requestedTitle || localStorage.getItem(lastCourseTitleStorageKey) || 'last course page';
                    const openLabel = targetUrl === fallbackUrl ? 'Open Assignments' : `Open ${lastCourseTitle}`;
                    const showPrompt = () => {
                        if (typeof Swal === 'undefined') {
                            setTimeout(showPrompt, 100);
                            return;
                        }

                        Swal.fire({
                            title: 'Screen Share Request Received',
                            html: `<strong>${e.fromName}</strong> requested to view your screen.<br><br>${message}`,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#2563EB',
                            cancelButtonColor: '#64748B',
                            confirmButtonText: openLabel,
                            cancelButtonText: 'Close',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = targetUrl;
                            }
                        });
                    };

                    showPrompt();
                };

                const saveDeferredRequest = (e) => {
                    localStorage.setItem(deferredRequestStorageKey, JSON.stringify({
                        ...e,
                        deferred_at: Date.now(),
                    }));
                };

                const getDeferredRequest = () => {
                    const raw = localStorage.getItem(deferredRequestStorageKey);
                    if (!raw) {
                        return null;
                    }

                    try {
                        const parsed = JSON.parse(raw);
                        if (!parsed || !parsed.fromId || !parsed.fromName) {
                            localStorage.removeItem(deferredRequestStorageKey);
                            return null;
                        }

                        if (parsed.deferred_at && (Date.now() - parsed.deferred_at) > 120000) {
                            localStorage.removeItem(deferredRequestStorageKey);
                            return null;
                        }

                        return parsed;
                    } catch (_) {
                        localStorage.removeItem(deferredRequestStorageKey);
                        return null;
                    }
                };

                const clearDeferredRequest = () => {
                    localStorage.removeItem(deferredRequestStorageKey);
                };

                const handleIncomingRequest = (e, options = {}) => {
                    const normalizedTargetUrl = normalizeTargetUrl(e.target_path);
                    const targetPathname = normalizedTargetUrl ? new URL(normalizedTargetUrl, window.location.origin).pathname : null;

                    if (targetPathname && targetPathname !== window.location.pathname) {
                        const reason = `Open the requested assignment first: ${e.target_title || targetPathname}.`;
                        saveDeferredRequest(e);
                        notifyCourseTabRequired(e, reason);
                        return;
                    }

                    if (getActiveTabId() && getActiveTabId() !== tabId) {
                        if (!isActiveOwnerFresh()) {
                            localStorage.removeItem(activeTabStorageKey);
                            localStorage.removeItem(activePageStorageKey);
                            localStorage.removeItem(activeHeartbeatStorageKey);
                        } else {
                            return;
                        }
                    }

                    if (!isCurrentTabArmed()) {
                        const reason = remoteShareConfig.enabled
                            ? 'This course page is open, but Tab Share is not active yet. Click "Activate Tab Share" on the course page, then ask the admin to retry.'
                            : 'Open a course page from Assignments first, then click "Activate Tab Share" there before retrying.';

                        saveDeferredRequest(e);
                        notifyCourseTabRequired(e, reason);
                        return;
                    }

                    clearDeferredRequest();

                    const now = Date.now();
                    if (lastRequestFromId === e.fromId && (now - lastRequestAt) < 1500) {
                        return;
                    }
                    lastRequestFromId = e.fromId;
                    lastRequestAt = now;

                    if (peerConnection) {
                        peerConnection.close();
                    }
                    
                    // Add ping animation to mail icon if it exists (simulate inbox notification)
                    const mailIcon = document.querySelector('a[href*="inbox"] svg');
                    if(mailIcon) {
                        mailIcon.classList.add('animate-bounce', 'text-blue-500');
                        setTimeout(() => mailIcon.classList.remove('animate-bounce', 'text-blue-500'), 5000);
                    }
                    
                    const handleRequest = () => {
                        if(typeof Swal === 'undefined') {
                            setTimeout(handleRequest, 100);
                            return;
                        }
                        
                        Swal.fire({
                            title: 'Screen Share Request',
                               html: `<strong>${e.fromName}</strong> (Admin/Teacher) is requesting to view your screen in real-time.<br><br>Please choose <strong>this course tab</strong> only. Do not choose the entire screen or another app window.`,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#10B981',
                            cancelButtonColor: '#EF4444',
                            confirmButtonText: '<svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Allow Sharing',
                            cancelButtonText: 'Decline',
                            backdrop: `rgba(0,0,123,0.4)`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (!window.isSecureContext || !navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
                                    clearDeferredRequest();
                                    Swal.fire({
                                        title: 'Screen Sharing Not Available',
                                        html: 'Browser screen sharing requires a secure context (HTTPS). Please open this site using HTTPS and try again.',
                                        icon: 'error',
                                    });
                                    whisperAndSignal('ScreenRejected', e.fromId, { target: e.fromId });
                                    return;
                                }

                                   navigator.mediaDevices.getDisplayMedia(buildDisplayMediaOptions())
                                    .then(stream => {
                                        if (!stream.getVideoTracks || stream.getVideoTracks().length === 0) {
                                            throw new Error('No video track captured from screen share.');
                                        }

                                        const videoTrack = stream.getVideoTracks()[0];
                                        const displaySurface = videoTrack.getSettings ? videoTrack.getSettings().displaySurface : null;
                                        const userAgent = navigator.userAgent || '';
                                        const isSafari = /Safari/i.test(userAgent) && !/Chrome|Chromium|CriOS/i.test(userAgent);

                                        // Safari can report tab sharing as "window", so only hard-block monitor capture.
                                        if (displaySurface === 'monitor') {
                                            stream.getTracks().forEach(track => track.stop());
                                            throw new Error('Please do not share your entire screen. Share this course tab (or a browser window containing this tab).');
                                        }

                                        if (!isSafari && displaySurface && displaySurface !== 'browser') {
                                            stream.getTracks().forEach(track => track.stop());
                                            throw new Error('Please share a browser tab only. Sharing another app window is not allowed.');
                                        }

                                        whisperAndSignal('ScreenAccepted', e.fromId, { target: e.fromId });

                                        localStream = stream;
                                        peerConnection = new RTCPeerConnection(config);
                                        
                                        stream.getTracks().forEach(track => {
                                            peerConnection.addTrack(track, stream);
                                        });

                                        peerConnection.onicecandidate = event => {
                                            if (event.candidate) {
                                                whisperAndSignal('IceCandidate', e.fromId, {
                                                    candidate: serializeCandidate(event.candidate),
                                                    target: e.fromId
                                                });
                                            }
                                        };

                                        peerConnection.ontrack = event => {
                                            // Receiving audio from teacher
                                            let audioEl = document.getElementById('remoteAudioTeacher');
                                            if(!audioEl) {
                                                audioEl = document.createElement('audio');
                                                audioEl.id = 'remoteAudioTeacher';
                                                audioEl.autoplay = true;
                                                document.body.appendChild(audioEl);
                                            }
                                            if (audioEl.srcObject !== event.streams[0]) {
                                                audioEl.srcObject = event.streams[0];
                                            }
                                        };

                                        peerConnection.createOffer()
                                            .then(offer => peerConnection.setLocalDescription(offer))
                                            .then(() => {
                                                whisperAndSignal('Offer', e.fromId, {
                                                    offer: serializeDescription(peerConnection.localDescription),
                                                    target: e.fromId
                                                });
                                            })
                                            .catch(err => {
                                                console.error("Offer creation error: ", err);
                                                whisperAndSignal('Log', e.fromId, { message: 'Offer creation failed: ' + err.message, isError: true, target: e.fromId });
                                                whisperAndSignal('ScreenRejected', e.fromId, { target: e.fromId });
                                            });
                                            
                                        // Handle stream stop by user (native browser UI)
                                           videoTrack.onended = () => {
                                             whisperAndSignal('ScreenStopped', e.fromId, { target: e.fromId });
                                             if(peerConnection) peerConnection.close();
                                             peerConnection = null;
                                        };
                                    })
                                    .catch(err => {
                                        clearDeferredRequest();
                                        console.error("Screen sharing failed: ", err);
                                        const permissionHelp = 'If you are using macOS, open System Settings > Privacy & Security > Screen Recording and allow your browser (Safari or Google Chrome), then fully close and reopen the browser.';
                                        Swal.fire({
                                            title: 'Screen Sharing Failed',
                                            html: `${err.message}<br><br>${permissionHelp}`,
                                            icon: 'error',
                                        });
                                        whisperAndSignal('Log', e.fromId, { message: 'Screen share access denied or failed: ' + err.message, isError: true, target: e.fromId });
                                        whisperAndSignal('ScreenRejected', e.fromId, { target: e.fromId });
                                    });
                            } else {
                                clearDeferredRequest();
                                whisperAndSignal('ScreenRejected', e.fromId, { target: e.fromId });
                            }
                        });
                    };
                    
                    handleRequest();
                };

                const processDeferredRequest = () => {
                    if (!isCurrentTabArmed()) {
                        return;
                    }

                    const deferredRequest = getDeferredRequest();
                    if (!deferredRequest) {
                        return;
                    }

                    handleIncomingRequest(deferredRequest, { deferred: true });
                };

                const pollPendingRequest = () => {
                    window.axios.get('{{ route('remote-view.pending-request') }}')
                        .then((res) => {
                            if (!res.data || !res.data.pending || !res.data.request) {
                                return;
                            }

                            const req = res.data.request;
                            handleIncomingRequest(req);

                            if (req.request_id) {
                                window.axios.post('{{ route('remote-view.pending-request.ack') }}', {
                                    request_id: req.request_id,
                                }).catch(() => {});
                            }
                        })
                        .catch(() => {});
                };

                webrtcChannel.listenForWhisper('RequestScreen', (e) => {
                    handleIncomingRequest(e);
                })
                .listen('.RemoteScreenRequested', (e) => {
                    handleIncomingRequest(e);
                })
                .listenForWhisper('Answer', (e) => {
                    if (!shouldProcessSignal(e.signal_id)) {
                        return;
                    }

                    const answer = normalizeDescription(e.answer);
                    if (peerConnection && answer) {
                        peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
                    }
                })
                .listenForWhisper('IceCandidate', (e) => {
                    if (!shouldProcessSignal(e.signal_id)) {
                        return;
                    }

                    const candidate = normalizeCandidate(e.candidate);
                    if (peerConnection && candidate) {
                        peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
                    }
                })
                .listenForWhisper('Offer', (e) => {
                     if (!shouldProcessSignal(e.signal_id)) {
                         return;
                     }

                     const offer = normalizeDescription(e.offer);

                     // Teacher sent an offer (e.g. renegotiation for mic Audio)
                     if (peerConnection && offer) {
                         peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
                             .then(() => peerConnection.createAnswer())
                             .then(answer => peerConnection.setLocalDescription(answer))
                             .then(() => {
                                 whisperAndSignal('Answer', e.fromId, {
                                     answer: serializeDescription(peerConnection.localDescription),
                                     target: e.fromId
                                 });
                             });
                     }
                })
                .listenForWhisper('CloseSession', (e) => {
                     if(localStream) {
                         localStream.getTracks().forEach(track => track.stop());
                     }
                     if(peerConnection) {
                         peerConnection.close();
                         peerConnection = null;
                     }
                });

                pollPendingRequest();
                pollingTimer = setInterval(pollPendingRequest, 4000);
                pollPendingSignals();
                signalPollingTimer = setInterval(pollPendingSignals, 1200);

                window.addEventListener('beforeunload', () => {
                    if (pollingTimer) {
                        clearInterval(pollingTimer);
                    }
                    if (signalPollingTimer) {
                        clearInterval(signalPollingTimer);
                    }
                });

                window.addEventListener('remote-share-tab-state-change', (event) => {
                    if (event.detail && event.detail.isActive) {
                        processDeferredRequest();
                    }
                });

                setTimeout(processDeferredRequest, 300);
            }
        };

        // Start the broadcaster init — works even if Echo isn't ready yet
        initBroadcaster();
    </script>
@endif
