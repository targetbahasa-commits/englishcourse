@if(auth()->check())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Echo !== 'undefined') {
                const channel = window.Echo.join('monitoring');

                // Send a whisper to the channel indicating current page
                const broadcastCurrentPage = () => {
                    channel.whisper('client-page-update', {
                        id: {{ auth()->id() }},
                        name: '{{ addslashes(auth()->user()->name) }}',
                        url: window.location.href,
                        title: document.title,
                        timestamp: new Date().toISOString()
                    });
                };

                // Whisper immediately on join
                channel.here((users) => {
                    broadcastCurrentPage();
                });

                // And whisper periodically to keep the status fresh (every 30 seconds)
                setInterval(broadcastCurrentPage, 30000);
            }
        });
    </script>
@endif
