@if(setting('live_chat_enabled', '1') === '1')
@auth
<div x-data="chatNotifier()" x-init="init()">
    <!-- Audio element for notification sound (optional) -->
    <audio id="chat-notification-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
</div>

<script>
function chatNotifier() {
    return {
        lastUnreadCount: 0,
        pollingTimer: null,
        
        init() {
            // Load SweetAlert2 if not already loaded
            if (!document.getElementById('sweetalert2-styles-notify')) {
                const style = document.createElement('link');
                style.id = 'sweetalert2-styles-notify';
                style.rel = 'stylesheet';
                style.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
                document.head.appendChild(style);
            }
            if (!window.Swal) {
                const script = document.createElement('script');
                script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
                document.head.appendChild(script);
            }

            // Initial fetch to set baseline
            this.fetchUnreadCount(true);

            // Start polling
            this.pollingTimer = setInterval(() => {
                this.fetchUnreadCount(false);
            }, 4000);
        },

        fetchUnreadCount(isInitial = false) {
            fetch('/api/chat/unread-count', {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                const currentCount = data.total_unread || 0;
                
                // If it's not the initial fetch and unread count has increased
                if (!isInitial && currentCount > this.lastUnreadCount) {
                    this.showNotification();
                }
                
                this.lastUnreadCount = currentCount;
            })
            .catch(err => console.error('Error fetching unread count:', err));
        },

        showNotification() {
            // Play sound
            const sound = document.getElementById('chat-notification-sound');
            if (sound) {
                sound.volume = 0.5;
                sound.play().catch(e => console.log('Audio play prevented by browser policy'));
            }

            // Show Toast Popup
            const checkSwal = setInterval(() => {
                if (window.Swal) {
                    clearInterval(checkSwal);
                    const Toast = window.Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', window.Swal.stopTimer)
                            toast.addEventListener('mouseleave', window.Swal.resumeTimer)
                            toast.style.cursor = 'pointer';
                            toast.onclick = () => {
                                // Redirect to inbox or open floating chat if available
                                window.location.href = '/inbox?tab=messages';
                            };
                        }
                    });

                    Toast.fire({
                        icon: 'info',
                        title: 'Pesan Baru!',
                        text: 'Anda menerima pesan baru. Klik untuk membuka.'
                    });
                }
            }, 200);
        }
    }
}
</script>
@endauth
@endif
