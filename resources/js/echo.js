import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// Only initialize Echo if broadcasting is enabled
const broadcastDriver = import.meta.env.VITE_BROADCAST_DRIVER || 'null';

if (broadcastDriver !== 'null') {
    let authPath = '/broadcasting/auth';
    if (window.location.pathname.includes('/public/')) {
        authPath = window.location.pathname.substring(0, window.location.pathname.indexOf('/public/') + 7) + '/broadcasting/auth';
    }

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME === 'https') || window.location.protocol === 'https:',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: authPath
    });
    window.Echo._broadcastingEnabled = true;
} else {
    // Mock Echo object for null broadcaster
    const mockChannel = {
        listen: () => mockChannel,
        on: () => mockChannel,
        whisper: () => mockChannel,
        subscribed: () => mockChannel,
        joining: () => mockChannel,
        here: () => mockChannel,
        joining: () => mockChannel,
        left: () => mockChannel,
        notification: () => mockChannel,
        leaving: () => mockChannel,
        listenForWhisper: () => mockChannel,
    };

    window.Echo = {
        channel: () => mockChannel,
        private: () => mockChannel,
        presence: () => mockChannel,
        join: () => mockChannel,
        leaveChannel: () => {},
        leave: () => {},
        _broadcastingEnabled: false,
    };
}
