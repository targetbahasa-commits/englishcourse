<script>
    document.addEventListener('DOMContentLoaded', function() {
        const audio = document.getElementById('mainAudio');
        const playPauseBtn = document.getElementById('playPauseBtn');
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

        let isDragging = false;

        // Format time in MM:SS
        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        // Toggle play/pause
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

        // Skip audio by seconds
        window.skipAudio = function(seconds) {
            if (audio && audio.duration) {
                const newTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                audio.currentTime = newTime;
            }
        };

        // Seek to position when clicking or dragging progress bar
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
        }

        // Mouse down on progress bar
        progressContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            seekAudio(e);
            e.preventDefault();
        });

        // Mouse move - drag to seek
        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                seekAudio(e);
            }
        });

        // Mouse up - stop dragging
        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        // Touch support for mobile
        progressContainer.addEventListener('touchstart', (e) => {
            isDragging = true;
            const touch = e.touches[0];
            seekAudio(touch);
            e.preventDefault();
        });

        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                const touch = e.touches[0];
                seekAudio(touch);
            }
        });

        document.addEventListener('touchend', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        // Update progress bar and time display
        audio.addEventListener('timeupdate', () => {
            if (audio.duration && !isDragging) {
                const percentage = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = percentage + '%';
                progressHandle.style.left = percentage + '%';
                currentTimeDisplay.textContent = formatTime(audio.currentTime);
            }
        });

        // Set duration when metadata is loaded
        audio.addEventListener('loadedmetadata', () => {
            durationDisplay.textContent = formatTime(audio.duration);
        });

        // Reset play button when audio ends
        audio.addEventListener('ended', () => {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        });

        // Keyboard shortcuts
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
    
    // Global function for jumpToTime (used by question cards)
    window.jumpToTime = function(seconds) {
        const audio = document.getElementById('mainAudio');
        if(audio && typeof seconds === 'number') {
            audio.currentTime = seconds;
            audio.play();
            // Update UI Icons
            document.getElementById('playIcon').classList.add('hidden');
            document.getElementById('pauseIcon').classList.remove('hidden');
        }
    };

    // Transcript Drawer Logic
    window.openTranscriptDrawer = function() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer && drawer.classList.contains('hidden')) {
            drawer.classList.remove('hidden');
            void drawer.offsetWidth; // Force reflow
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
