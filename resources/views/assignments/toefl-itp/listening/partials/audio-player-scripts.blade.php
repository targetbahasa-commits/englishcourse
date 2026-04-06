<script>
    document.addEventListener('DOMContentLoaded', function() {
        const audio = document.getElementById('mainAudio');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const progressContainer = document.getElementById('progressContainer');
        const currentTimeDisplay = document.getElementById('currentTime');
        const durationDisplay = document.getElementById('duration');

        if (!audio || !progressContainer) {
            console.error('Audio player elements not found');
            return;
        }

        const activeClasses = ['bg-amber-200', 'text-slate-950', 'ring-1', 'ring-amber-300', 'shadow-sm'];
        let isDragging = false;
        let activeSegmentByGroup = { en: null, id: null };
        const transcriptOffsetSeconds = 56;

        // Teleprompter state
        const telepromptSpeeds = [0.5, 0.75, 1.0, 1.5, 2.0, 3.0];
        let telepromptSpeedIndex = 2; // 1.0×
        const telepromptBaseMs = 4000; // ms per segment at 1×
        let telepromptActive = false;
        let telepromptTimer = null;
        let telepromptCurrentIndex = { en: 0, id: 0 };

        function getSegments(group) {
            return Array.from(document.querySelectorAll(`.transcript-segment[data-transcript-group="${group}"]`));
        }

        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function segmentHasTiming(segment) {
            return Number.isFinite(parseFloat(segment.dataset.start)) && Number.isFinite(parseFloat(segment.dataset.end));
        }

        function segmentWeight(segment) {
            const text = (segment.textContent || '').replace(/\s+/g, ' ').trim();
            return Math.max(text.length, 8);
        }

        function setSegmentTiming(segment, start, end) {
            segment.dataset.start = start.toFixed(3);
            segment.dataset.end = end.toFixed(3);
        }

        function applyTranscriptOffsetOnce() {
            if (!transcriptOffsetSeconds) {
                return;
            }

            document.querySelectorAll('.transcript-segment').forEach((segment) => {
                if (segment.dataset.offsetApplied === '1') {
                    return;
                }

                const start = parseFloat(segment.dataset.start);
                const end = parseFloat(segment.dataset.end);

                if (Number.isFinite(start) && Number.isFinite(end)) {
                    setSegmentTiming(segment, start + transcriptOffsetSeconds, end + transcriptOffsetSeconds);
                }

                segment.dataset.offsetApplied = '1';
            });
        }

        function distributeSegmentsAcrossDuration(segments, duration, startOffset = 0) {
            if (!segments.length || !duration || duration <= 0) {
                return;
            }

            const totalWeight = segments.reduce((sum, segment) => sum + segmentWeight(segment), 0);
            const windowEnd = startOffset + duration;
            let cursor = startOffset;

            segments.forEach((segment, index) => {
                const sliceDuration = index === segments.length - 1
                    ? Math.max(windowEnd - cursor, 0)
                    : duration * (segmentWeight(segment) / totalWeight);
                const start = cursor;
                const end = Math.min(windowEnd, cursor + sliceDuration);
                setSegmentTiming(segment, start, end);
                cursor = end;
            });
        }

        function syncApproximateTranscriptTimings() {
            if (!audio.duration || !Number.isFinite(audio.duration)) {
                return;
            }

            applyTranscriptOffsetOnce();

            const enSegments = getSegments('en');
            const idSegments = getSegments('id');
            const enHasExact = enSegments.some(segmentHasTiming);
            const idHasExact = idSegments.some(segmentHasTiming);
            const approximateWindow = Math.max(audio.duration - transcriptOffsetSeconds, 0);

            if (!enHasExact) {
                distributeSegmentsAcrossDuration(enSegments, approximateWindow, transcriptOffsetSeconds);
            }

            if (!idHasExact) {
                const syncedEnSegments = getSegments('en');
                const canMirrorEnglish = syncedEnSegments.length > 0
                    && syncedEnSegments.length === idSegments.length
                    && syncedEnSegments.every(segmentHasTiming);

                if (canMirrorEnglish) {
                    idSegments.forEach((segment, index) => {
                        setSegmentTiming(
                            segment,
                            parseFloat(syncedEnSegments[index].dataset.start),
                            parseFloat(syncedEnSegments[index].dataset.end)
                        );
                    });
                } else {
                    distributeSegmentsAcrossDuration(idSegments, approximateWindow, transcriptOffsetSeconds);
                }
            }
        }

        function setActiveSegment(group, nextSegment) {
            const previousSegment = activeSegmentByGroup[group];

            if (previousSegment && previousSegment !== nextSegment) {
                previousSegment.classList.remove(...activeClasses);
            }

            if (!nextSegment) {
                activeSegmentByGroup[group] = null;
                return;
            }

            if (previousSegment !== nextSegment) {
                nextSegment.classList.add(...activeClasses);
                nextSegment.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }

            activeSegmentByGroup[group] = nextSegment;
        }

        function updateTranscriptHighlight() {
            if (telepromptActive) return;
            syncApproximateTranscriptTimings();

            ['en', 'id'].forEach((group) => {
                const activeSegment = getSegments(group).find((segment) => {
                    const start = parseFloat(segment.dataset.start);
                    const end = parseFloat(segment.dataset.end);
                    return Number.isFinite(start) && Number.isFinite(end) && audio.currentTime >= start && audio.currentTime <= end + 0.05;
                }) || null;

                setActiveSegment(group, activeSegment);
            });
        }

        function telepromptAdvance() {
            const enSegs = getSegments('en');
            const idSegs = getSegments('id');
            if (telepromptCurrentIndex.en >= enSegs.length && telepromptCurrentIndex.id >= idSegs.length) {
                stopTeleprompter();
                return;
            }
            if (telepromptCurrentIndex.en < enSegs.length) {
                setActiveSegment('en', enSegs[telepromptCurrentIndex.en]);
                telepromptCurrentIndex.en++;
            }
            if (telepromptCurrentIndex.id < idSegs.length) {
                setActiveSegment('id', idSegs[telepromptCurrentIndex.id]);
                telepromptCurrentIndex.id++;
            }
        }

        function startTeleprompter() {
            telepromptActive = true;
            const ms = telepromptBaseMs / telepromptSpeeds[telepromptSpeedIndex];
            telepromptAdvance();
            telepromptTimer = setInterval(telepromptAdvance, ms);
            document.getElementById('telepromptPlayIcon')?.classList.add('hidden');
            document.getElementById('telepromptPauseIcon')?.classList.remove('hidden');
        }

        function stopTeleprompter() {
            telepromptActive = false;
            clearInterval(telepromptTimer);
            telepromptTimer = null;
            document.getElementById('telepromptPlayIcon')?.classList.remove('hidden');
            document.getElementById('telepromptPauseIcon')?.classList.add('hidden');
        }

        window.toggleTeleprompter = function() {
            if (telepromptActive) {
                stopTeleprompter();
            } else {
                telepromptCurrentIndex = { en: 0, id: 0 };
                startTeleprompter();
            }
        };

        window.stepTranscriptSegment = function(dir) {
            ['en', 'id'].forEach(function(group) {
                const segs = getSegments(group);
                if (!segs.length) return;
                const current = activeSegmentByGroup[group];
                const idx = current ? segs.indexOf(current) : (dir > 0 ? -1 : 0);
                const nextIdx = Math.max(0, Math.min(segs.length - 1, idx + dir));
                setActiveSegment(group, segs[nextIdx]);
                telepromptCurrentIndex[group] = nextIdx + 1;
            });
        };

        window.togglePlayPause = function() {
            if (audio.paused) {
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        };

        window.skipAudio = function(seconds) {
            if (audio && audio.duration) {
                const newTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                audio.currentTime = newTime;
                updateTranscriptHighlight();
            }
        };

        function seekAudio(event) {
            if (!audio.duration) return;

            const rect = progressContainer.getBoundingClientRect();
            const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
            const clickX = clientX - rect.left;
            const width = rect.width;

            if (width === 0) return;

            let percentage = clickX / width;
            percentage = Math.max(0, Math.min(1, percentage));

            const newTime = percentage * audio.duration;
            audio.currentTime = newTime;
            updateTranscriptHighlight();
        }

        progressContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            seekAudio(e);
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                seekAudio(e);
            }
        });

        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        progressContainer.addEventListener('touchstart', (e) => {
            isDragging = true;
            seekAudio(e.touches[0]);
            e.preventDefault();
        });

        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                seekAudio(e.touches[0]);
            }
        });

        document.addEventListener('touchend', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        audio.addEventListener('timeupdate', () => {
            if (audio.duration && !isDragging) {
                const percentage = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = percentage + '%';
                progressHandle.style.left = percentage + '%';
                currentTimeDisplay.textContent = formatTime(audio.currentTime);
            }

            updateTranscriptHighlight();
        });

        audio.addEventListener('loadedmetadata', () => {
            durationDisplay.textContent = formatTime(audio.duration);
            syncApproximateTranscriptTimings();
            updateTranscriptHighlight();
        });

        audio.addEventListener('ended', () => {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            setActiveSegment('en', null);
            setActiveSegment('id', null);
            stopTeleprompter();
        });

        audio.addEventListener('seeked', updateTranscriptHighlight);

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                window.togglePlayPause();
            } else if (e.code === 'ArrowLeft') {
                e.preventDefault();
                window.skipAudio(-10);
            } else if (e.code === 'ArrowRight') {
                e.preventDefault();
                window.skipAudio(10);
            }
        });

    });

    window.jumpToTime = function(seconds) {
        const audio = document.getElementById('mainAudio');
        if(audio && typeof seconds === 'number') {
            audio.currentTime = seconds;
            audio.play();
            document.getElementById('playIcon').classList.add('hidden');
            document.getElementById('pauseIcon').classList.remove('hidden');
        }
    };

    window.jumpToTranscriptSegment = function(segment) {
        if (!segment) {
            return;
        }

        const start = parseFloat(segment.dataset.start);
        if (Number.isFinite(start)) {
            window.jumpToTime(start);
        }
    };

    window.openTranscriptDrawer = function() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer && drawer.classList.contains('hidden')) {
            drawer.classList.remove('hidden');
            void drawer.offsetWidth;
            drawer.classList.remove('h-0');
            drawer.classList.add('h-80');
        }
    };

    window.closeTranscriptDrawer = function() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer && !drawer.classList.contains('hidden')) {
            drawer.classList.remove('h-80');
            drawer.classList.add('h-0');
            setTimeout(() => {
                drawer.classList.add('hidden');
            }, 300);
        }
    };

    window.toggleTranscriptDrawer = function() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer) {
            if (drawer.classList.contains('hidden')) {
                openTranscriptDrawer();
            } else {
                closeTranscriptDrawer();
            }
        }
    };
</script>
