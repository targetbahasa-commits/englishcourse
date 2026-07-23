@php
    use Illuminate\Support\Str;
    $masked = fn($key) => $key ? (Str::length($key) > 12 ? Str::substr($key, 0, 8) . str_repeat('•', min(Str::length($key) - 8, 20)) . Str::substr($key, -4) : str_repeat('•', Str::length($key))) : '(not set)';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Management - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 p-8 min-h-screen" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0f172a 100%);">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">AI Management</h1>
                    <p class="text-indigo-300 text-sm mt-0.5">Kelola semua AI provider, model, API key, dan fungsinya dalam satu panel</p>
                </div>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-900/40 border border-emerald-500/30 text-emerald-300 rounded-xl px-5 py-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-900/40 border border-red-500/30 text-red-300 rounded-xl px-5 py-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Summary stats --}}
        @php
            $totalProviders = count($config['providers']);
            $totalModels = collect($config['providers'])->sum(fn($p) => count($p['models']));
            $configuredCount = collect($config['providers'])->filter(fn($p) => !empty($p['api_key']))->count();
        @endphp
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="rounded-2xl p-5 border" style="background: rgba(99,102,241,0.12); border-color: rgba(99,102,241,0.25);">
                <div class="text-3xl font-black text-indigo-300">{{ $totalProviders }}</div>
                <div class="text-xs font-semibold text-indigo-400 uppercase tracking-wider mt-1">AI Providers</div>
            </div>
            <div class="rounded-2xl p-5 border" style="background: rgba(139,92,246,0.12); border-color: rgba(139,92,246,0.25);">
                <div class="text-3xl font-black text-violet-300">{{ $totalModels }}</div>
                <div class="text-xs font-semibold text-violet-400 uppercase tracking-wider mt-1">AI Models</div>
            </div>
            <div class="rounded-2xl p-5 border" style="background: rgba(16,185,129,0.12); border-color: rgba(16,185,129,0.25);">
                <div class="text-3xl font-black text-emerald-300">{{ $configuredCount }}/{{ $totalProviders }}</div>
                <div class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mt-1">Configured</div>
            </div>
        </div>

        {{-- Provider Cards --}}
        <div class="space-y-6" x-data="{ showKey: {} }">
            @foreach($config['providers'] as $pi => $provider)
            @php
                $isConfigured = !empty($provider['api_key']);
                $cardGradients = [
                    'groq'              => 'from-orange-900/30 to-yellow-900/20',
                    'sambanova'         => 'from-sky-900/30 to-blue-900/20',
                    'google'            => 'from-blue-900/30 to-cyan-900/20',
                    'fonnte'            => 'from-green-900/30 to-emerald-900/20',
                    'listening_machine' => 'from-violet-900/30 to-purple-900/20',
                ];
                $gradient = $cardGradients[$provider['id']] ?? 'from-gray-800/40 to-gray-900/20';
                $badgeColors = [
                    'groq'              => 'bg-orange-500/20 text-orange-300 border-orange-500/30',
                    'sambanova'         => 'bg-sky-500/20 text-sky-300 border-sky-500/30',
                    'google'            => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                    'fonnte'            => 'bg-green-500/20 text-green-300 border-green-500/30',
                    'listening_machine' => 'bg-violet-500/20 text-violet-300 border-violet-500/30',
                ];
                $badge = $badgeColors[$provider['id']] ?? 'bg-gray-500/20 text-gray-300 border-gray-500/30';
            @endphp

            <div class="rounded-2xl border overflow-hidden" style="background: rgba(15,23,42,0.7); border-color: rgba(99,102,241,0.2); backdrop-filter: blur(12px);">
                {{-- Card Header --}}
                <div class="px-6 py-5 bg-gradient-to-r {{ $gradient }} border-b" style="border-color: rgba(99,102,241,0.15);">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            {{-- Status dot --}}
                            <div class="relative">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/10">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full border-2 border-gray-900 {{ $isConfigured ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">{{ $provider['name'] }}</h2>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($provider['website'])
                                    <a href="{{ $provider['website'] }}" target="_blank" class="text-xs text-indigo-300 hover:text-indigo-200 transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        {{ $provider['website'] }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full border {{ $isConfigured ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : 'bg-red-500/20 text-red-300 border-red-500/30' }}">
                            {{ $isConfigured ? '✓ Configured' : '✗ Not Set' }}
                        </span>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Left: Account & API Key --}}
                    <div class="lg:col-span-1 space-y-4">
                        {{-- Account --}}
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Account Email
                            </div>
                            <p class="text-sm text-gray-200 font-mono">{{ $provider['account'] }}</p>
                        </div>

                        {{-- API Key --}}
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                {{ $provider['api_key_env'] }}
                            </div>
                            <div class="flex items-center gap-2">
                                <span x-show="!showKey['{{ $provider['id'] }}']" class="text-xs font-mono text-gray-300 break-all">{{ $masked($provider['api_key']) }}</span>
                                <span x-show="showKey['{{ $provider['id'] }}']" class="text-xs font-mono text-yellow-300 break-all" style="display:none;">{{ $provider['api_key'] ?? '(not set)' }}</span>
                                <button @click="showKey['{{ $provider['id'] }}'] = !showKey['{{ $provider['id'] }}']" class="flex-shrink-0 text-gray-500 hover:text-gray-300 transition-colors ml-auto">
                                    <svg x-show="!showKey['{{ $provider['id'] }}']" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showKey['{{ $provider['id'] }}']" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>

                            {{-- Edit Key Form --}}
                            <details class="mt-3">
                                <summary class="text-xs text-indigo-400 hover:text-indigo-300 cursor-pointer font-medium select-none">Ubah API Key</summary>
                                <form action="{{ route('admin.ai-management.update-key') }}" method="POST" class="mt-3 flex gap-2">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $provider['api_key_env'] }}">
                                    <input type="text" name="value" placeholder="Paste new key..." class="flex-1 text-xs bg-gray-900/80 border border-gray-600 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none font-mono">
                                    <button type="submit" class="flex-shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors">Save</button>
                                </form>
                            </details>
                        </div>

                        @if($provider['id'] === 'listening_machine')
                        <div x-data="{
                            status: {{ $localApiStatus ? 'true' : 'false' }},
                            loading: false,
                            toast: '',
                            toastType: 'success',
                            showToast(msg, type='success') {
                                this.toast = msg;
                                this.toastType = type;
                                setTimeout(() => this.toast = '', 4000);
                            },
                            toggleApi() {
                                const action = this.status ? 'stop' : 'start';
                                this.loading = true;
                                fetch('{{ route('admin.ai-management.toggle-local-api') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({ action: action })
                                }).then(res => res.json()).then(data => {
                                    this.loading = false;
                                    if (data.success) {
                                        // Use actual server state from response, not flip
                                        this.status = data.online;
                                        this.showToast(data.message, data.online || action === 'stop' ? 'success' : 'warning');
                                    } else {
                                        this.showToast('Error: ' + data.message, 'error');
                                    }
                                }).catch(err => {
                                    this.loading = false;
                                    this.showToast('Gagal terhubung ke server Laravel.', 'error');
                                });
                            }
                        }" class="rounded-xl p-4 mt-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Server Control
                                </span>
                                <span x-show="status" class="text-[10px] bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider" style="display: none;">Online</span>
                                <span x-show="!status" class="text-[10px] bg-red-500/20 text-red-300 border border-red-500/30 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider" style="display: none;">Offline</span>
                            </div>
                            
                            {{-- Toast notification --}}
                            <div x-show="toast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="mb-3 text-xs px-3 py-2 rounded-lg font-medium leading-relaxed"
                                :class="toastType === 'success' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : (toastType === 'warning' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30')"
                                x-text="toast" style="display:none;">
                            </div>

                            <button @click="toggleApi" :disabled="loading" class="w-full relative flex items-center justify-center gap-2 text-sm font-bold px-4 py-2.5 rounded-lg transition-all border outline-none overflow-hidden" 
                                :class="status ? 'bg-red-500/10 text-red-400 border-red-500/30 hover:bg-red-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20'">
                                <span x-show="loading" class="absolute inset-0 flex items-center justify-center backdrop-blur-sm" style="background: rgba(0,0,0,0.5); display: none;">
                                    <svg class="animate-spin w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>
                                <svg x-show="!status" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <svg x-show="status" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                                <span x-text="loading ? (status ? 'Mematikan…' : 'Menyalakan…') : (status ? 'Matikan Server' : 'Nyalakan Server')"></span>
                            </button>
                            <p class="mt-2 text-[10px] text-gray-400 text-center leading-relaxed" x-text="status ? 'Klik untuk mematikan server agar RAM tidak penuh.' : 'Klik untuk menyalakan API saat ingin membuat audio.'"></p>
                        </div>
                        @endif
                    </div>

                    {{-- Middle: Models --}}
                    <div class="lg:col-span-1">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            AI Models
                        </div>
                        @if(count($provider['models']) > 0)
                        <div class="space-y-3">
                            @foreach($provider['models'] as $model)
                            <div class="rounded-xl p-3.5" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                                <div class="font-mono text-sm font-bold text-indigo-300 mb-1">{{ $model['name'] }}</div>
                                <div class="text-xs text-gray-400 leading-relaxed">{{ $model['use_case'] }}</div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="rounded-xl p-4 text-center" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <p class="text-xs text-gray-500 italic">No AI model (API/integration service)</p>
                        </div>
                        @endif
                    </div>

                    {{-- Right: Functions --}}
                    <div class="lg:col-span-1">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Fungsi di Project Ini
                        </div>
                        <div class="rounded-xl p-4 space-y-2.5" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                            @foreach($provider['functions'] as $fn)
                            <div class="flex items-start gap-2.5">
                                <span class="mt-1 flex-shrink-0 w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                <span class="text-xs text-gray-300 leading-relaxed">{{ $fn }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Groq Key Pool Manager --}}
        <div class="mt-8 rounded-2xl border overflow-hidden" style="background: rgba(15,23,42,0.8); border-color: rgba(251,146,60,0.35); backdrop-filter: blur(12px);">
            <div class="px-6 py-5 border-b flex items-center gap-3" style="background: rgba(251,146,60,0.1); border-color: rgba(251,146,60,0.25);">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(251,146,60,0.2);">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-orange-300">Groq Key Pool Manager</h3>
                    <p class="text-xs text-orange-400/70 mt-0.5">Kelola API key Groq per-fitur dengan <strong class="text-orange-300">Sequential Fallback</strong>. Pisahkan dengan koma <code class="bg-black/30 px-1 rounded text-orange-200">,</code> untuk multiple keys.</p>
                </div>
            </div>

            <div class="p-6">
                {{-- Strategy explanation --}}
                <div class="mb-6 rounded-xl p-4 border text-xs space-y-1.5" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                    <div class="font-bold text-gray-300 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Alur Sequential Fallback
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-gray-400">
                        <span class="bg-orange-900/30 text-orange-300 border border-orange-800/40 px-2 py-1 rounded-lg font-mono">Key #1 (dedicated)</span>
                        <span class="text-gray-600">→ jika 429/error →</span>
                        <span class="bg-orange-900/30 text-orange-300 border border-orange-800/40 px-2 py-1 rounded-lg font-mono">Key #2</span>
                        <span class="text-gray-600">→ jika gagal →</span>
                        <span class="bg-gray-800 text-gray-400 border border-gray-700 px-2 py-1 rounded-lg font-mono">General Pool</span>
                        <span class="text-gray-600">→ jika semua gagal →</span>
                        <span class="bg-red-900/30 text-red-400 border border-red-800/40 px-2 py-1 rounded-lg font-mono">Error 503</span>
                    </div>
                </div>

                <form action="{{ route('admin.ai-management.save-groq-keys') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- General --}}
                        @php $features = [
                            ['key' => 'general',   'label' => '🌐 General / Fallback Pool', 'desc' => 'Digunakan oleh semua fitur jika key dedicated-nya kosong. Juga dipakai AI Chat & vocabulary tools.', 'color' => 'gray'],
                            ['key' => 'writing',   'label' => '✍️ Writing Pool',             'desc' => 'Evaluasi IELTS Writing Task 1 & Task 2 (Groq Llama 3.3 70B).', 'color' => 'orange'],
                            ['key' => 'speaking',  'label' => '🎤 Speaking Pool',            'desc' => 'Fallback hybrid untuk evaluasi Speaking (jika Gemini gagal).', 'color' => 'blue'],
                            ['key' => 'listening', 'label' => '🎧 Listening Pool',           'desc' => 'Listening Machine: humanisasi naskah, generate questions, & Whisper translation.', 'color' => 'violet'],
                        ]; @endphp

                        @foreach($features as $f)
                        @php
                            $currentVal = $groqFeatureKeys[$f['key']] ?? '';
                            $keyCount = $currentVal ? count(array_filter(array_map('trim', explode(',', $currentVal)))) : 0;
                            $colorMap = ['gray' => 'rgba(107,114,128,', 'orange' => 'rgba(251,146,60,', 'blue' => 'rgba(59,130,246,', 'violet' => 'rgba(139,92,246,'];
                            $c = $colorMap[$f['color']] ?? 'rgba(99,102,241,';
                        @endphp
                        <div class="rounded-xl p-4 border" style="background: rgba(255,255,255,0.03); border-color: {{ $c }}0.2);">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-white">{{ $f['label'] }}</label>
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background: {{ $c }}0.15); color: {{ $c }}0.9); border: 1px solid {{ $c }}0.3);">
                                    {{ $keyCount }} key{{ $keyCount !== 1 ? 's' : '' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ $f['desc'] }}</p>
                            <textarea
                                name="groq_{{ $f['key'] }}"
                                rows="3"
                                placeholder="gsk_key1..., gsk_key2..., gsk_key3..."
                                class="w-full text-xs font-mono rounded-lg px-3 py-2 resize-none outline-none focus:ring-2 transition-all"
                                style="background: rgba(0,0,0,0.4); border: 1px solid {{ $c }}0.25); color: #e5e7eb; focus:ring-color: {{ $c }}0.5);"
                            >{{ $currentVal }}</textarea>
                            @if($currentVal)
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @foreach(array_filter(array_map('trim', explode(',', $currentVal))) as $ki => $k)
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full" style="background: {{ $c }}0.1); color: {{ $c }}0.8); border: 1px solid {{ $c }}0.2);">
                                    #{{ $ki + 1 }} {{ substr($k, 0, 8) }}•••{{ substr($k, -4) }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <p class="text-xs text-gray-500">Perubahan langsung aktif (cache otomatis di-refresh).</p>
                        <button type="submit" class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all hover:shadow-lg hover:shadow-orange-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Semua Key Pools
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Other AI Providers Key Pool Manager --}}
        <div class="mt-8 rounded-2xl border overflow-hidden" style="background: rgba(15,23,42,0.8); border-color: rgba(99,102,241,0.35); backdrop-filter: blur(12px);">
            <div class="px-6 py-5 border-b flex items-center gap-3" style="background: rgba(99,102,241,0.1); border-color: rgba(99,102,241,0.25);">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(99,102,241,0.2);">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-indigo-300">Other AI Providers Key Pool</h3>
                    <p class="text-xs text-indigo-400/70 mt-0.5">Kelola API key untuk provider lainnya dengan <strong class="text-indigo-300">Sequential Fallback</strong>. Pisahkan dengan koma <code class="bg-black/30 px-1 rounded text-indigo-200">,</code> untuk multiple keys.</p>
                </div>
            </div>

            <div class="p-6">
                {{-- Strategy explanation --}}
                <div class="mb-6 rounded-xl p-4 border text-xs space-y-1.5" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                    <div class="font-bold text-gray-300 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Alur Sequential Fallback (per Provider)
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-gray-400">
                        <span class="bg-indigo-900/30 text-indigo-300 border border-indigo-800/40 px-2 py-1 rounded-lg font-mono">Key #1 (utama)</span>
                        <span class="text-gray-600">→ jika 429/error →</span>
                        <span class="bg-indigo-900/30 text-indigo-300 border border-indigo-800/40 px-2 py-1 rounded-lg font-mono">Key #2</span>
                        <span class="text-gray-600">→ jika gagal →</span>
                        <span class="bg-indigo-900/30 text-indigo-300 border border-indigo-800/40 px-2 py-1 rounded-lg font-mono">Key #3 dst...</span>
                        <span class="text-gray-600">→ jika semua gagal →</span>
                        <span class="bg-red-900/30 text-red-400 border border-red-800/40 px-2 py-1 rounded-lg font-mono">Error / Next Provider</span>
                    </div>
                </div>

                <form action="{{ route('admin.ai-management.save-other-provider-keys') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        @php
                        $otherProviders = [
                            [
                                'key'   => 'sambanova',
                                'label' => '🚀 SambaNova',
                                'desc'  => 'Primary untuk IELTS Writing grading (DeepSeek-V3.1 & Meta-Llama-3.3-70B). Layanan cepat dengan free tier yang murah hati.',
                                'color' => 'emerald',
                            ],
                            [
                                'key'   => 'gemini',
                                'label' => '✨ Google Gemini',
                                'desc'  => 'Digunakan untuk evaluasi Speaking (audio multimodal) & fallback AI Chat. Mendukung Gemini 2.5 Flash.',
                                'color' => 'teal',
                            ],
                            [
                                'key'   => 'openrouter',
                                'label' => '🌌 OpenRouter',
                                'desc'  => 'Gateway ke 200+ model AI (Llama, Mistral, Claude, dll). Ideal sebagai cadangan universal jika provider lain habis limit.',
                                'color' => 'fuchsia',
                            ],
                            [
                                'key'   => 'deepinfra',
                                'label' => '⚡ DeepInfra',
                                'desc'  => 'Inferensi GPU yang hemat biaya untuk model open-source besar (Llama 3.1, Mixtral). Alternatif SambaNova yang ekonomis.',
                                'color' => 'sky',
                            ],
                            [
                                'key'   => 'huggingface',
                                'label' => '🤗 HuggingFace',
                                'desc'  => 'Akses ke model-model open-source via Inference API. Cocok untuk eksperimen dan tugas-tugas khusus.',
                                'color' => 'yellow',
                            ],
                            [
                                'key'   => 'cerebras',
                                'label' => '🧠 Cerebras',
                                'desc'  => 'Chip WSE terkencang di dunia. Inferensi ultra-cepat untuk Llama 3.3 70B (2,200+ tokens/detik). Ideal untuk response time kritis.',
                                'color' => 'rose',
                            ],
                        ];

                        $colorMap = [
                            'emerald' => 'rgba(16,185,129,',
                            'teal'    => 'rgba(20,184,166,',
                            'fuchsia' => 'rgba(217,70,239,',
                            'sky'     => 'rgba(14,165,233,',
                            'yellow'  => 'rgba(234,179,8,',
                            'rose'    => 'rgba(244,63,94,',
                        ];
                        @endphp

                        @foreach($otherProviders as $p)
                        @php
                            $currentVal = $otherProviderKeys[$p['key']] ?? '';
                            $keyCount   = $currentVal ? count(array_filter(array_map('trim', explode(',', $currentVal)))) : 0;
                            $c          = $colorMap[$p['color']] ?? 'rgba(99,102,241,';
                        @endphp
                        <div class="rounded-xl p-4 border" style="background: rgba(255,255,255,0.03); border-color: {{ $c }}0.2);">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-white">{{ $p['label'] }}</label>
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background: {{ $c }}0.15); color: {{ $c }}0.9); border: 1px solid {{ $c }}0.3);">
                                    {{ $keyCount }} key{{ $keyCount !== 1 ? 's' : '' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ $p['desc'] }}</p>
                            <textarea
                                name="{{ $p['key'] }}_keys"
                                rows="3"
                                placeholder="key1..., key2..., key3..."
                                class="w-full text-xs font-mono rounded-lg px-3 py-2 resize-none outline-none transition-all"
                                style="background: rgba(0,0,0,0.4); border: 1px solid {{ $c }}0.25); color: #e5e7eb;"
                            >{{ $currentVal }}</textarea>
                            @if($currentVal)
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @foreach(array_filter(array_map('trim', explode(',', $currentVal))) as $ki => $k)
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full" style="background: {{ $c }}0.1); color: {{ $c }}0.8); border: 1px solid {{ $c }}0.2);">
                                    #{{ $ki + 1 }} {{ substr($k, 0, 8) }}•••{{ substr($k, -4) }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach

                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <p class="text-xs text-gray-500">Perubahan langsung aktif (cache otomatis di-refresh).</p>
                        <button type="submit" class="flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all hover:shadow-lg hover:shadow-indigo-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Semua Provider Keys
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Architecture Overview --}}

        <div class="mt-8 rounded-2xl p-6 border" style="background: rgba(15,23,42,0.7); border-color: rgba(99,102,241,0.2); backdrop-filter: blur(12px);">
            <h3 class="text-base font-bold text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                Ringkasan Arsitektur AI
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="rounded-xl p-4 border" style="background: rgba(234,88,12,0.1); border-color: rgba(234,88,12,0.2);">
                    <div class="font-bold text-orange-300 mb-2">📝 Evaluasi Writing</div>
                    <ul class="space-y-1 text-xs text-gray-400">
                        <li>• <span class="text-orange-200">Task 1:</span> SambaNova (DeepSeek + Llama parallel)</li>
                        <li>• <span class="text-orange-200">Task 2:</span> Groq (Llama 3.3 70B)</li>
                    </ul>
                </div>
                <div class="rounded-xl p-4 border" style="background: rgba(59,130,246,0.1); border-color: rgba(59,130,246,0.2);">
                    <div class="font-bold text-blue-300 mb-2">🎤 Evaluasi Speaking</div>
                    <ul class="space-y-1 text-xs text-gray-400">
                        <li>• <span class="text-blue-200">Evaluasi:</span> Google Gemini 2.5 Flash</li>
                        <li>• <span class="text-blue-200">Fallback:</span> Groq (Hybrid stack)</li>
                    </ul>
                </div>
                <div class="rounded-xl p-4 border" style="background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.2);">
                    <div class="font-bold text-violet-300 mb-2">🎧 Listening Machine</div>
                    <ul class="space-y-1 text-xs text-gray-400">
                        <li>• <span class="text-violet-200">Script:</span> Groq Llama humanisation</li>
                        <li>• <span class="text-violet-200">TTS:</span> Kokoro (local server)</li>
                        <li>• <span class="text-violet-200">Questions:</span> Groq auto-generation</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
        </main>
    </div>
</body>
</html>
