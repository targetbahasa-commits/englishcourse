<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WhatsApp Management | Target Bahasa Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
@include('components.impersonation-banner')

<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64 p-6 relative">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex justify-between items-start">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex justify-between items-start">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        {{-- Alpine Component for live status --}}
        <div x-data="wahaManager()" x-init="initPolling()" class="max-w-4xl mx-auto space-y-6">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">WhatsApp Gateway Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage the WAHA connection session directly from the dashboard.</p>
                </div>
                
                {{-- Status Badge --}}
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full border shadow-sm font-medium text-sm transition-all duration-300"
                     :class="{
                        'bg-green-50 border-green-200 text-green-700': status === 'WORKING',
                        'bg-orange-50 border-orange-200 text-orange-700': status === 'SCAN_QR_CODE' || status === 'STARTING',
                        'bg-red-50 border-red-200 text-red-700': status === 'OFFLINE' || status === 'ERROR',
                        'bg-gray-50 border-gray-200 text-gray-700': status === 'STOPPED' || status === 'LOADING'
                     }">
                    
                    {{-- Ping dot --}}
                    <span class="relative flex h-2.5 w-2.5">
                      <span x-show="status === 'WORKING' || status === 'STARTING'" class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
                            :class="status === 'WORKING' ? 'bg-green-400' : 'bg-orange-400'"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5"
                            :class="{
                                'bg-green-500': status === 'WORKING',
                                'bg-orange-500': status === 'SCAN_QR_CODE' || status === 'STARTING',
                                'bg-red-500': status === 'OFFLINE' || status === 'ERROR',
                                'bg-gray-400': status === 'STOPPED' || status === 'LOADING'
                            }"></span>
                    </span>

                    <span x-text="statusText"></span>
                </div>
            </div>

            {{-- MAIN CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    
                    {{-- Left side: Info & Controls --}}
                    <div class="p-6 md:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                Configuration Details
                            </h2>
                            <div class="space-y-3">
                                <div>
                                    <form action="{{ route('admin.waha.update-api') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-0.5">WAHA URL</span>
                                            <input type="url" name="waha_url" value="{{ $wahaUrl }}" class="text-sm text-gray-800 bg-white px-2 py-1.5 w-full md:w-64 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required placeholder="http://localhost:3000">
                                        </div>
                                        <div>
                                            <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-0.5">WAHA API Key</span>
                                            <div class="relative w-full md:w-64" x-data="{ showKey: false }">
                                                <input :type="showKey ? 'text' : 'password'" name="waha_api_key" value="{{ $wahaApiKey ?? '' }}" class="text-sm text-gray-800 bg-white px-2 py-1.5 w-full rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm pr-8" placeholder="Leave empty if no auth">
                                                <button type="button" @click="showKey = !showKey" class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-400 hover:text-gray-600">
                                                    <svg x-show="!showKey" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    <svg x-show="showKey" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="text-xs bg-gray-800 hover:bg-gray-700 text-white px-3 py-1.5 rounded font-medium shadow-sm transition-colors">Update API Config</button>
                                        </div>
                                    </form>
                                </div>
                                <hr class="border-gray-100 my-4">
                                <div>
                                    <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-0.5" title="Nomor WA (contoh: 628123...)">Session Name (WA Number)</span>
                                    <form action="{{ route('admin.waha.update-session') }}" method="POST" class="flex gap-2 items-center mt-1">
                                        @csrf
                                        <input type="text" name="session_name" value="{{ $sessionName }}" class="text-sm text-gray-800 bg-white px-2 py-1.5 w-48 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required placeholder="e.g. 628123456789">
                                        <button type="submit" class="text-xs bg-gray-800 hover:bg-gray-700 text-white px-3 py-1.5 rounded font-medium shadow-sm transition-colors" :disabled="status === 'WORKING' || status === 'STARTING'" :class="{'opacity-50 cursor-not-allowed': status === 'WORKING' || status === 'STARTING'}">Save</button>
                                    </form>
                                    <p class="text-[11px] text-gray-500 mt-1">Change this only when stopped.</p>
                                </div>
                                
                                <p class="text-sm text-gray-500 pt-2" x-show="status === 'WORKING'">
                                    The gateway is connected. The system can send WhatsApp notifications automatically.
                                </p>
                                <p class="text-sm text-gray-500 pt-2" x-show="status === 'OFFLINE' || status === 'ERROR'">
                                    Cannot reach the WAHA server. Make sure your WAHA Docker container or local process is currently running.
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 space-y-3">
                            <form action="{{ route('admin.waha.start') }}" method="POST" x-show="status === 'STOPPED' || status === 'OFFLINE' || status === 'ERROR'">
                                @csrf
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Start Session
                                </button>
                            </form>

                            <form action="{{ route('admin.waha.stop') }}" method="POST" x-show="status === 'WORKING' || status === 'SCAN_QR_CODE' || status === 'STARTING'">
                                @csrf
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl shadow-sm transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path></svg>
                                    Stop Session
                                </button>
                            </form>

                            <form action="{{ route('admin.waha.logout') }}" method="POST" x-show="status === 'WORKING' || status === 'SCAN_QR_CODE'" onsubmit="return confirm('Are you sure you want to log out? You will need to scan the QR code again.')">
                                @csrf
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout WhatsApp
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Right side: Dynamic Content (QR Code or Connected state) --}}
                    <div class="p-6 md:p-8 flex flex-col items-center justify-center min-h-[350px] bg-gray-50/50">
                        
                        {{-- LOADING STATE --}}
                        <div x-show="status === 'LOADING'" class="text-center text-gray-400 flex flex-col items-center">
                            <svg class="animate-spin h-8 w-8 mb-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-medium">Checking WAHA Server...</p>
                        </div>

                        {{-- STARTING STATE --}}
                        <div x-show="status === 'STARTING'" x-cloak class="text-center text-gray-400 flex flex-col items-center">
                            <svg class="animate-spin h-8 w-8 mb-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-medium">Starting WhatsApp Session engine...</p>
                            <p class="text-xs text-gray-400 mt-2 text-balance max-w-xs">This can take a few seconds. The page will automatically update once it's ready.</p>
                        </div>

                        {{-- OFFLINE STATE --}}
                        <div x-show="status === 'OFFLINE' || status === 'ERROR'" x-cloak class="text-center">
                            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Server Unreachable</h3>
                            <p class="text-sm text-gray-500 max-w-xs mx-auto">Make sure WAHA is running at <span class="font-mono text-xs">{{ $wahaUrl }}</span>.</p>
                        </div>

                        {{-- STOPPED STATE --}}
                        <div x-show="status === 'STOPPED'" x-cloak class="text-center">
                            <div class="w-16 h-16 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Session is Stopped</h3>
                            <p class="text-sm text-gray-500">Click the Start Session button to begin.</p>
                        </div>

                        {{-- QR SCAN STATE --}}
                        <div x-show="status === 'SCAN_QR_CODE'" x-cloak class="text-center w-full">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Scan to Login</h3>
                            
                            <div class="relative bg-white border border-gray-200 shadow-sm rounded-xl p-4 inline-block mx-auto min-h-[256px] min-w-[256px] flex items-center justify-center">
                                <template x-if="qrCode">
                                    <img :src="qrCode" alt="QR Code" class="w-64 h-64 object-contain">
                                </template>
                                <template x-if="!qrCode">
                                    <div class="text-center text-gray-400">
                                        <svg class="animate-spin h-6 w-6 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-xs">Generating QR...</span>
                                    </div>
                                </template>
                            </div>

                            <ol class="text-sm text-gray-600 text-left mt-6 max-w-xs mx-auto space-y-2 list-decimal list-inside">
                                <li>Open <strong>WhatsApp</strong> on your phone</li>
                                <li>Tap <strong>Menu</strong> or <strong>Settings</strong></li>
                                <li>Select <strong>Linked Devices</strong></li>
                                <li>Tap on <strong>Link a Device</strong></li>
                                <li>Point your phone to this screen</li>
                            </ol>
                        </div>

                        {{-- CONNECTED STATE --}}
                        <div x-show="status === 'WORKING'" x-cloak class="text-center">
                            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                
                                {{-- Sparkles --}}
                                <div class="absolute -top-1 -right-1 text-yellow-400 animate-pulse">✨</div>
                                <div class="absolute bottom-1 left-0 text-yellow-400 animate-pulse delay-150">✨</div>
                            </div>
                            <h3 class="text-xl font-extrabold text-gray-900 mb-1">Connected</h3>
                            <p class="text-sm text-gray-500">WhatsApp Gateway is active and ready to process messages.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function wahaManager() {
        return {
            status: 'LOADING', // LOADING, STARTING, SCAN_QR_CODE, WORKING, STOPPED, OFFLINE, ERROR
            statusText: 'Checking connection...',
            qrCode: null,
            pollInterval: null,

            initPolling() {
                this.checkStatus();
                // Poll every 3 seconds to get live QR code changes or login status
                this.pollInterval = setInterval(() => {
                    this.checkStatus();
                }, 3000);
            },

            async checkStatus() {
                try {
                    const res = await fetch('{{ route('admin.waha.status') }}');
                    
                    if (res.status === 500 || res.status === 502 || res.status === 504) {
                        this.status = 'OFFLINE';
                        this.statusText = 'Server Offline';
                        return;
                    }

                    const data = await res.json();
                    
                    this.status = data.status;
                    
                    if (this.status === 'WORKING') {
                        this.statusText = 'Connected & Ready';
                    } else if (this.status === 'SCAN_QR_CODE') {
                        this.statusText = 'Waiting for Scan';
                        if (data.qr_code) {
                            this.qrCode = data.qr_code;
                        }
                    } else if (this.status === 'STOPPED') {
                        this.statusText = 'Stopped';
                    } else if (this.status === 'STARTING') {
                        this.statusText = 'Starting engine...';
                    } else {
                        this.statusText = this.status;
                    }

                } catch (err) {
                    this.status = 'ERROR';
                    this.statusText = 'Connection Error';
                }
            }
        }
    }
</script>
</body>
</html>
