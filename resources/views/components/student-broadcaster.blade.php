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

                // Insert SweetAlert2 dynamically if not present
                if(!window.Swal) {
                    const script = document.createElement('script');
                    script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
                    document.head.appendChild(script);
                }

                const handleIncomingRequest = (e) => {
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
                            html: `<strong>${e.fromName}</strong> (Admin/Teacher) is requesting to view your screen in real-time.`,
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
                                    Swal.fire({
                                        title: 'Screen Sharing Not Available',
                                        html: 'Browser screen sharing requires a secure context (HTTPS). Please open this site using HTTPS and try again.',
                                        icon: 'error',
                                    });
                                    webrtcChannel.whisper('ScreenRejected', { target: e.fromId });
                                    return;
                                }

                                webrtcChannel.whisper('ScreenAccepted', { target: e.fromId });
                                
                                navigator.mediaDevices.getDisplayMedia({ video: { cursor: "always" }, audio: false })
                                    .then(stream => {
                                        if (!stream.getVideoTracks || stream.getVideoTracks().length === 0) {
                                            throw new Error('No video track captured from screen share.');
                                        }

                                        localStream = stream;
                                        peerConnection = new RTCPeerConnection(config);
                                        
                                        stream.getTracks().forEach(track => {
                                            peerConnection.addTrack(track, stream);
                                        });

                                        peerConnection.onicecandidate = event => {
                                            if (event.candidate) {
                                                webrtcChannel.whisper('IceCandidate', {
                                                    candidate: event.candidate,
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
                                                webrtcChannel.whisper('Offer', {
                                                    offer: peerConnection.localDescription,
                                                    target: e.fromId
                                                });
                                            })
                                            .catch(err => {
                                                console.error("Offer creation error: ", err);
                                                webrtcChannel.whisper('Log', { message: 'Offer creation failed: ' + err.message, isError: true, target: e.fromId });
                                                webrtcChannel.whisper('ScreenRejected', { target: e.fromId });
                                            });
                                            
                                        // Handle stream stop by user (native browser UI)
                                        stream.getVideoTracks()[0].onended = () => {
                                             webrtcChannel.whisper('ScreenStopped', { target: e.fromId });
                                             if(peerConnection) peerConnection.close();
                                             peerConnection = null;
                                        };
                                    })
                                    .catch(err => {
                                        console.error("Screen sharing failed: ", err);
                                        webrtcChannel.whisper('Log', { message: 'Screen share access denied or failed: ' + err.message, isError: true, target: e.fromId });
                                        webrtcChannel.whisper('ScreenRejected', { target: e.fromId });
                                    });
                            } else {
                                webrtcChannel.whisper('ScreenRejected', { target: e.fromId });
                            }
                        });
                    };
                    
                    handleRequest();
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
                    if (peerConnection) {
                        peerConnection.setRemoteDescription(new RTCSessionDescription(e.answer));
                    }
                })
                .listenForWhisper('IceCandidate', (e) => {
                    if (peerConnection && e.candidate) {
                        peerConnection.addIceCandidate(new RTCIceCandidate(e.candidate));
                    }
                })
                .listenForWhisper('Offer', (e) => {
                     // Teacher sent an offer (e.g. renegotiation for mic Audio)
                     if (peerConnection) {
                         peerConnection.setRemoteDescription(new RTCSessionDescription(e.offer))
                             .then(() => peerConnection.createAnswer())
                             .then(answer => peerConnection.setLocalDescription(answer))
                             .then(() => {
                                 webrtcChannel.whisper('Answer', {
                                     answer: peerConnection.localDescription,
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

                window.addEventListener('beforeunload', () => {
                    if (pollingTimer) {
                        clearInterval(pollingTimer);
                    }
                });
            }
        };

        // Start the broadcaster init — works even if Echo isn't ready yet
        initBroadcaster();
    </script>
@endif
