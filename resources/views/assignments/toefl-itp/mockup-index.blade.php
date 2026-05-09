<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TOEFL ITP Full Mock Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-red-50 via-red-100 to-pink-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">TOEFL ITP Full Mock Test</h1>
                            <p class="text-gray-600 mt-1">Complete simulation test with Listening, Structure, and Reading sections</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Pilih Paket Full Mock Test</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-5 gap-6">
                    @foreach($mockPackages as $package)
                        @php
                            $isPackageAvailable = ($package['status'] ?? 'coming_soon') === 'available';
                        @endphp
                        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">
                            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 relative">
                                <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border border-red-100/50 text-white bg-white/15">
                                    {{ strtoupper(str_replace('_', ' ', $package['status'])) }}
                                </span>
                                <p class="text-white text-sm font-semibold tracking-wide">Full Mock Package</p>
                            </div>

                            <div class="p-6 flex flex-col flex-1 bg-white justify-between">
                                <div>
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-sm mb-4 bg-red-100 text-red-700 border border-red-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>

                                    <h3 class="text-slate-900 text-2xl font-bold">{{ $package['title'] }}</h3>
                                    <p class="text-red-700 text-sm mt-1 font-medium">{{ $package['subtitle'] }}</p>
                                    <p class="mt-3 text-slate-600 text-sm leading-6">{{ $package['description'] }}</p>
                                    
                                    <div class="mt-4 space-y-2">
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                                            <span>Listening (50 questions)</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <span>Structure (40 questions)</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <span>Reading (50 questions)</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                        disabled
                                        class="block w-full py-3 text-center rounded-xl font-bold shadow cursor-not-allowed bg-red-300 text-white {{ $isPackageAvailable ? 'hidden' : '' }}">
                                    Coming Soon
                                </button>

                                @if($isPackageAvailable)
                                    <a href="{{ route('assignments.toefl-itp.mockup.package', ['package' => $package['package_number']]) }}"
                                       class="block w-full py-3 text-center rounded-xl font-bold shadow bg-red-600 text-white hover:bg-red-700 transition">
                                        Mulai Paket {{ $package['package_number'] }} ->
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <!-- LMStudio Chat Widget -->
    <div x-data="chatWidget()" x-init="init()" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <button @click="toggle()" 
                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center text-white hover:scale-105"
                :class="{ 'rotate-45': isOpen }">
            <svg x-show="!isOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <svg x-show="isOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Chat Window -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
             @click.outside="isOpen = false">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full" :class="isConnected ? 'bg-green-400 animate-pulse' : 'bg-red-400'"></div>
                    <span class="text-white font-semibold text-sm">LMStudio Chat</span>
                </div>
                <button @click="clearChat()" class="text-white/80 hover:text-white text-xs">
                    Clear
                </button>
            </div>

            <!-- Messages -->
            <div class="h-80 overflow-y-auto p-4 space-y-3 bg-gray-50" id="chat-messages" x-ref="messages">
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="msg.role === 'user' 
                            ? 'bg-blue-500 text-white rounded-2xl rounded-br-sm px-3 py-2 max-w-[85%] text-sm' 
                            : 'bg-white text-gray-800 rounded-2xl rounded-bl-sm px-3 py-2 max-w-[85%] text-sm shadow-sm border border-gray-100'"
                             x-html="formatMessage(msg.content)">
                        </div>
                    </div>
                </template>
                
                <!-- Loading -->
                <div x-show="isLoading" class="flex justify-start">
                    <div class="bg-white rounded-2xl rounded-bl-sm px-4 py-3 shadow-sm border border-gray-100">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 bg-white border-t border-gray-100">
                <div class="flex gap-2">
                    <input type="text" 
                           x-model="inputMessage"
                           @keydown.enter="sendMessage()"
                           placeholder="Ketik pesan..."
                           class="flex-1 px-3 py-2 bg-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           :disabled="isLoading">
                    <button @click="sendMessage()" 
                            :disabled="!inputMessage.trim() || isLoading"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-gray-300 text-white rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
                <div class="text-center mt-2">
                    <span class="text-[10px] text-gray-400" x-text="status"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function chatWidget() {
            return {
                isOpen: false,
                isLoading: false,
                isConnected: false,
                inputMessage: '',
                status: 'Menunggu pesan...',
                messages: [
                    { role: 'assistant', content: 'Halo! Saya terhubung ke LMStudio Anda. Ada yang bisa saya bantu?' }
                ],
                
                init() {
                    this.checkConnection();
                },
                
                toggle() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }
                },
                
                async checkConnection() {
                    try {
                        const response = await fetch('/api/lmstudio/chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ message: 'hi', history: [] })
                        });
                        this.isConnected = response.ok;
                        this.status = this.isConnected ? 'Terhubung ke LMStudio' : 'LMStudio tidak terdeteksi';
                    } catch (e) {
                        this.isConnected = false;
                        this.status = 'LMStudio tidak terdeteksi di port 1234';
                    }
                },
                
                async sendMessage() {
                    if (!this.inputMessage.trim() || this.isLoading) return;
                    
                    const userMessage = this.inputMessage.trim();
                    this.messages.push({ role: 'user', content: userMessage });
                    this.inputMessage = '';
                    this.isLoading = true;
                    this.status = 'Mengirim ke LMStudio...';
                    
                    this.$nextTick(() => this.scrollToBottom());
                    
                    try {
                        const response = await fetch('/api/lmstudio/chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                message: userMessage,
                                history: this.messages.slice(0, -1)
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.error) {
                            this.messages.push({ 
                                role: 'assistant', 
                                content: 'Maaf, ' + data.error 
                            });
                            this.isConnected = false;
                        } else {
                            this.messages.push({ 
                                role: 'assistant', 
                                content: data.response 
                            });
                            this.isConnected = true;
                            this.status = 'Terhubung ke ' + data.source;
                        }
                    } catch (e) {
                        this.messages.push({ 
                            role: 'assistant', 
                            content: 'Maaf, terjadi kesalahan saat menghubungi LMStudio. Pastikan LMStudio berjalan di port 1234.' 
                        });
                        this.isConnected = false;
                        this.status = 'Error koneksi';
                    }
                    
                    this.isLoading = false;
                    this.$nextTick(() => this.scrollToBottom());
                },
                
                clearChat() {
                    this.messages = [{ 
                        role: 'assistant', 
                        content: 'Halo! Saya terhubung ke LMStudio Anda. Ada yang bisa saya bantu?' 
                    }];
                },
                
                scrollToBottom() {
                    const container = this.$refs.messages;
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                },
                
                formatMessage(text) {
                    return text.replace(/\n/g, '<br>');
                }
            }
        }
    </script>
</body>
</html>
