<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Promo Tests - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <div class="max-w-7xl mx-auto" x-data="promoTestsAdmin()">
                <div x-show="selectedTests.length > 0" x-cloak style="display: none;" class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                    <div class="text-sm font-medium text-blue-800">
                        <span x-text="selectedTests.length"></span> tests selected
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.promo-tests.bulk-update') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="activate">
                            <template x-for="(test, index) in selectedTests" :key="index">
                                <div>
                                    <input type="hidden" :name="`tests[${index}][id]`" :value="test.id">
                                    <input type="hidden" :name="`tests[${index}][type]`" :value="test.type">
                                </div>
                            </template>
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">Activate Selected</button>
                        </form>
                        <form action="{{ route('admin.promo-tests.bulk-update') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="deactivate">
                            <template x-for="(test, index) in selectedTests" :key="index">
                                <div>
                                    <input type="hidden" :name="`tests[${index}][id]`" :value="test.id">
                                    <input type="hidden" :name="`tests[${index}][type]`" :value="test.type">
                                </div>
                            </template>
                            <button type="submit" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">Deactivate Selected</button>
                        </form>
                    </div>
                </div>

                <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Manage Promo Tests</h1>
                        <p class="mt-2 text-sm text-gray-500">Configure which assignments are marked as Free Promotional Tests.</p>
                    </div>
                    <div class="flex flex-row items-center gap-2 mt-2">

                        <div x-data="{ openPreview: false }" class="relative">
                            <button @click="openPreview = !openPreview" @click.away="openPreview = false" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Preview Evaluasi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="openPreview" style="display: none;" class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    <a href="{{ route('admin.promo-tests.preview.writing') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi IELTS Writing</a>
                                    <a href="{{ route('admin.promo-tests.preview.speaking') }}?b=online" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi IELTS Speaking</a>
                                    <a href="#" onclick="alert('Evaluasi untuk IELTS Listening terintegrasi secara otomatis saat pengguna selesai tes.'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi IELTS Listening</a>
                                    <a href="#" onclick="alert('Evaluasi untuk IELTS Reading General terintegrasi secara otomatis saat pengguna selesai tes.'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi IELTS Reading General</a>
                                    <a href="#" onclick="alert('Evaluasi untuk IELTS Reading Academic terintegrasi secara otomatis saat pengguna selesai tes.'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi IELTS Reading Academic</a>
                                    <a href="{{ route('admin.promo-tests.preview.toefl') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Evaluasi TOEFL</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('promo.test.expired') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Preview Expired Page
                        </a>

                        {{-- Preview WhatsApp Evaluation Dropdown --}}
                        <div x-data="{ openWaDropdown: false }" class="relative">
                            <button @click="openWaDropdown = !openWaDropdown" @click.away="openWaDropdown = false" class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-300 rounded-lg shadow-sm text-sm font-medium text-green-700 hover:bg-green-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 whitespace-nowrap">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                Preview Sent WhatsApp
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="openWaDropdown" style="display: none;" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_writing' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Writing</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_writing_general' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Writing General</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_speaking' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Speaking</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_listening' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Listening</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_reading_general' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Reading General</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'ielts_reading_academic' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA IELTS Reading Academic</a>
                                    <a href="#" @click.prevent="$dispatch(\'open-wa-preview\', { type: \'grammar\' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Grammar</a>
                                    <a href="#" @click.prevent="$dispatch(\'open-wa-preview\', { type: \'grammar\' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Grammar</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'toefl_listening' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Listening ITP</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'toefl_structure' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Structure ITP</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'toefl_reading' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Reading ITP</a>
                                    <a href="#" @click.prevent="$dispatch('open-wa-preview', { type: 'toefl' }); openWaDropdown = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium" role="menuitem">WA Full TOEFL ITP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Google Colab Integration</h3>
                        <p class="text-xs text-gray-500 mt-1">SADTALKER_API_URL (used for IELTS Speaking rendering)</p>
                    </div>
                    <form action="{{ route('admin.promo-tests.update-colab') }}" method="POST" class="flex items-center gap-2 w-full sm:w-auto">
                        @csrf
                        <input type="url" name="colab_url" value="{{ env('SADTALKER_API_URL') }}" placeholder="https://..." class="flex-1 sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Link
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Grouped Program Tabs -->
                <div class="border-b border-gray-200 mb-6 pb-4 flex flex-wrap items-center gap-3">
                    
                    <!-- 1. IELTS Academic Dropdown -->
                    <div x-data="{ openDropdown: false }" class="relative inline-block text-left">
                        <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" 
                                :class="['writing', 'ielts_reading_academic', 'ielts_listening', 'speaking'].includes(tab) ? 'bg-indigo-600 text-white shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400'"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>IELTS Academic</span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                  :class="['writing', 'ielts_reading_academic', 'ielts_listening', 'speaking'].includes(tab) ? 'bg-indigo-700 text-white' : 'bg-gray-100 text-gray-600'"
                                  x-text="tab === 'writing' ? 'Writing' : (tab === 'ielts_reading_academic' ? 'Reading' : (tab === 'ielts_listening' ? 'Listening' : (tab === 'speaking' ? 'Speaking' : 'Select')))"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openDropdown" x-transition style="display: none;" class="absolute left-0 mt-2 w-60 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 p-1.5 border border-gray-100">
                            <div class="px-3 py-1.5 text-xs font-bold text-gray-400 uppercase tracking-wider">IELTS Academic Modules</div>
                            <a href="#" @click.prevent="tab = 'writing'; openDropdown = false" 
                               :class="tab === 'writing' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                   <span>Writing Academic</span>
                               </div>
                               <span x-show="tab === 'writing'" class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'ielts_reading_academic'; openDropdown = false" 
                               :class="tab === 'ielts_reading_academic' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                   <span>Reading Academic</span>
                               </div>
                               <span x-show="tab === 'ielts_reading_academic'" class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'ielts_listening'; openDropdown = false" 
                               :class="tab === 'ielts_listening' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 0112.728 0M12 12h.01"></path></svg>
                                   <span>Listening</span>
                               </div>
                               <span x-show="tab === 'ielts_listening'" class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'speaking'; openDropdown = false" 
                               :class="tab === 'speaking' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                                   <span>Speaking</span>
                               </div>
                               <span x-show="tab === 'speaking'" class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. IELTS General Training Dropdown -->
                    <div x-data="{ openDropdown: false }" class="relative inline-block text-left">
                        <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" 
                                :class="['writing_general', 'ielts_reading_general'].includes(tab) ? 'bg-emerald-600 text-white shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400'"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>IELTS General</span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                  :class="['writing_general', 'ielts_reading_general'].includes(tab) ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-600'"
                                  x-text="tab === 'writing_general' ? 'Writing' : (tab === 'ielts_reading_general' ? 'Reading' : 'Select')"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openDropdown" x-transition style="display: none;" class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 p-1.5 border border-gray-100">
                            <div class="px-3 py-1.5 text-xs font-bold text-gray-400 uppercase tracking-wider">IELTS General Modules</div>
                            <a href="#" @click.prevent="tab = 'writing_general'; openDropdown = false" 
                               :class="tab === 'writing_general' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                   <span>Writing General</span>
                               </div>
                               <span x-show="tab === 'writing_general'" class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'ielts_reading_general'; openDropdown = false" 
                               :class="tab === 'ielts_reading_general' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                   <span>Reading General</span>
                               </div>
                               <span x-show="tab === 'ielts_reading_general'" class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            </a>
                        </div>
                    </div>

                    <!-- 3. TOEFL ITP Dropdown -->
                    <div x-data="{ openDropdown: false }" class="relative inline-block text-left">
                        <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" 
                                :class="['toefl_listening', 'toefl_structure', 'toefl_reading'].includes(tab) ? 'bg-purple-600 text-white shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400'"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>TOEFL ITP</span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                  :class="['toefl_listening', 'toefl_structure', 'toefl_reading'].includes(tab) ? 'bg-purple-700 text-white' : 'bg-gray-100 text-gray-600'"
                                  x-text="tab === 'toefl_listening' ? 'Listening' : (tab === 'toefl_structure' ? 'Structure' : (tab === 'toefl_reading' ? 'Reading' : 'Select'))"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openDropdown" x-transition style="display: none;" class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 p-1.5 border border-gray-100">
                            <div class="px-3 py-1.5 text-xs font-bold text-gray-400 uppercase tracking-wider">TOEFL ITP Modules</div>
                            <a href="#" @click.prevent="tab = 'toefl_listening'; openDropdown = false" 
                               :class="tab === 'toefl_listening' ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <span>Listening ITP</span>
                               <span x-show="tab === 'toefl_listening'" class="w-2 h-2 rounded-full bg-purple-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'toefl_structure'; openDropdown = false" 
                               :class="tab === 'toefl_structure' ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <span>Structure ITP</span>
                               <span x-show="tab === 'toefl_structure'" class="w-2 h-2 rounded-full bg-purple-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'toefl_reading'; openDropdown = false" 
                               :class="tab === 'toefl_reading' ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <span>Reading ITP</span>
                               <span x-show="tab === 'toefl_reading'" class="w-2 h-2 rounded-full bg-purple-600"></span>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Grammar Practice Button -->
                    <button @click="tab = 'grammar'" 
                            :class="tab === 'grammar' ? 'bg-teal-600 text-white shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400'"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Grammar</span>
                    </button>

                    <!-- 5. PTE Academic Dropdown -->
                    <div x-data="{ openDropdown: false }" class="relative inline-block text-left">
                        <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" 
                                :class="['pte_speaking_writing', 'pte_reading', 'pte_listening'].includes(tab) ? 'bg-orange-600 text-white shadow-md' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400'"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>PTE Academic</span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                  :class="['pte_speaking_writing', 'pte_reading', 'pte_listening'].includes(tab) ? 'bg-orange-700 text-white' : 'bg-gray-100 text-gray-600'"
                                  x-text="tab === 'pte_speaking_writing' ? 'Speaking & Writing' : (tab === 'pte_reading' ? 'Reading' : (tab === 'pte_listening' ? 'Listening' : 'Select'))"></span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="openDropdown" x-transition style="display: none;" class="absolute left-0 mt-2 w-64 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50 p-1.5 border border-gray-100">
                            <div class="px-3 py-1.5 text-xs font-bold text-gray-400 uppercase tracking-wider">PTE Academic Modules</div>
                            <a href="#" @click.prevent="tab = 'pte_speaking_writing'; openDropdown = false" 
                               :class="tab === 'pte_speaking_writing' ? 'bg-orange-50 text-orange-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                   <span>Speaking & Writing</span>
                               </div>
                               <span x-show="tab === 'pte_speaking_writing'" class="w-2 h-2 rounded-full bg-orange-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'pte_reading'; openDropdown = false" 
                               :class="tab === 'pte_reading' ? 'bg-orange-50 text-orange-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                   <span>Reading</span>
                               </div>
                               <span x-show="tab === 'pte_reading'" class="w-2 h-2 rounded-full bg-orange-600"></span>
                            </a>
                            <a href="#" @click.prevent="tab = 'pte_listening'; openDropdown = false" 
                               :class="tab === 'pte_listening' ? 'bg-orange-50 text-orange-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm transition-colors">
                               <div class="flex items-center gap-2">
                                   <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 0112.728 0M12 12h.01"></path></svg>
                                   <span>Listening</span>
                               </div>
                               <span x-show="tab === 'pte_listening'" class="w-2 h-2 rounded-full bg-orange-600"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Writing Tests Tab -->
                <div x-show="tab === 'writing'">
                    <div class="mb-4 flex justify-end">
                        <button @click="createWritingModal = 'writing'" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Academic Writing Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($writingTests) }}, 'writing')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($writingTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'writing')" @change="toggleTest({{ $test->id }}, 'writing')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }} (Task {{ $test->task_type }})</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $test->test_type ?: 'writing_t' . $test->task_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => 'writing', 'id' => $test->id]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => 'writing', 'id' => $test->id]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.ieltswritingacademic.meeting', ['task' => $test->task_type, 'id' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit Soal</a>
                                                <button @click="editWritingModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- IELTS Writing General Tab -->
                <div x-show="tab === 'writing_general'" style="display: none;">
                    <div class="mb-4 flex justify-end">
                        <button @click="createWritingModal = 'writing_general'" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New General Writing Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($writingGeneralTests) }}, 'writing_general')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($writingGeneralTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'writing_general')" @change="toggleTest({{ $test->id }}, 'writing_general')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }} (Task {{ $test->task_type }})</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $test->test_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => $test->test_type ?: 'writing_t' . $test->task_type, 'id' => $test->id]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'" class="text-xs"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => $test->test_type ?: 'writing_t' . $test->task_type, 'id' => $test->id]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'" class="text-xs"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.ieltswritinggeneral.meeting', ['task' => $test->task_type, 'id' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit Soal</a>
                                                <button @click="editWritingModal = testData; console.log(editWritingModal)" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Speaking Tests Tab -->
                <div x-show="tab === 'speaking'" style="display: none;">
                    <div class="mb-4 flex justify-end">
                        <button @click="createSpeakingModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Speaking Topic
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($speakingTests) }}, 'speaking')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($speakingTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'speaking')" @change="toggleTest({{ $test->id }}, 'speaking')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Part {{ collect($test->content)->count() }} Questions</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $test->test_type ?: 'speaking' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => 'speaking', 'id' => $test->id]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('promo.test.show', ['type' => 'speaking', 'id' => $test->id]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                    </button>
                                                @endif
                                                    @php
                                                        $isRendered = file_exists(storage_path('app/scripts/web_assets/videos/rendered_' . $test->id . '.flag'));
                                                        $isRendering = file_exists(storage_path('app/scripts/web_assets/videos/rendering_' . $test->id . '.flag'));
                                                        $videoList = [];
                                                        if ($isRendered) {
                                                            // Part 1 Questions
                                                            $part1 = \Illuminate\Support\Facades\DB::table('ielts_speaking_topics')->where('part', 1)->whereNull('subtopics')->whereNotNull('questions')->orderBy('id')->first();
                                                            if ($part1) {
                                                                $p1 = is_string($part1->questions) ? json_decode($part1->questions, true) : $part1->questions;
                                                                if (is_array($p1)) {
                                                                    $p1 = array_slice($p1, 0, 3);
                                                                    foreach ($p1 as $q) {
                                                                        $hash = substr(md5($q), 0, 12);
                                                                        $videoFilePath = public_path('web_assets/videos/video_' . $hash . '.mp4');
                                                                        $videoFilePathMaleNew = public_path('web_assets/videos/male_lipsync_' . $hash . '.mp4');
                                                                        $videoFilePathMaleOld = public_path('web_assets/videos/male_' . $hash . '.mp4');
                                                                        $maleUrl = null;
                                                                        if (file_exists($videoFilePathMaleNew)) {
                                                                            $maleUrl = asset('web_assets/videos/male_lipsync_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePathMaleNew);
                                                                        } elseif (file_exists($videoFilePathMaleOld)) {
                                                                            $maleUrl = asset('web_assets/videos/male_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePathMaleOld);
                                                                        }
                                                                        
                                                                        if (file_exists($videoFilePath)) {
                                                                            $videoList[] = [
                                                                                'text' => $q, 
                                                                                'url_female' => asset('web_assets/videos/video_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePath),
                                                                                'url_male' => $maleUrl
                                                                            ];
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            // Part 3 Questions
                                                            $p3 = is_string($test->part3_questions) ? json_decode($test->part3_questions, true) : $test->part3_questions;
                                                            if (is_array($p3)) {
                                                                foreach ($p3 as $q) {
                                                                    $hash = substr(md5($q), 0, 12);
                                                                    $videoFilePath = public_path('web_assets/videos/video_' . $hash . '.mp4');
                                                                    $videoFilePathMaleNew = public_path('web_assets/videos/male_lipsync_' . $hash . '.mp4');
                                                                    $videoFilePathMaleOld = public_path('web_assets/videos/male_' . $hash . '.mp4');
                                                                    $maleUrl = null;
                                                                    if (file_exists($videoFilePathMaleNew)) {
                                                                        $maleUrl = asset('web_assets/videos/male_lipsync_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePathMaleNew);
                                                                    } elseif (file_exists($videoFilePathMaleOld)) {
                                                                        $maleUrl = asset('web_assets/videos/male_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePathMaleOld);
                                                                    }
                                                                        
                                                                    if (file_exists($videoFilePath)) {
                                                                        $videoList[] = [
                                                                            'text' => $q, 
                                                                            'url_female' => asset('web_assets/videos/video_' . $hash . '.mp4') . '?v=' . filemtime($videoFilePath),
                                                                            'url_male' => $maleUrl
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if($isRendered && count($videoList) > 0)
                                                        <div class="flex items-center gap-2">
                                                            <button @click="$dispatch('open-avatar-modal', { videos: {{ json_encode($videoList) }} })" type="button" class="text-green-600 hover:text-green-900 flex items-center gap-1 font-semibold bg-green-50 px-2 py-1 rounded-md" title="Show Sample Video">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <span>Show Avatar</span>
                                                            </button>
                                                            <form action="{{ route('admin.promo-tests.speaking.render', $test->id) }}" method="POST" class="inline" onsubmit="return confirm('Video avatar sudah pernah dirender. Ingin merender ulang secara otomatis (Male & Female)?');">
                                                                @csrf
                                                                <button type="submit" class="text-gray-400 hover:text-gray-600 flex items-center" title="Render Ulang">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @elseif($isRendering)
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-yellow-600 flex items-center gap-1 font-semibold bg-yellow-50 px-2 py-1 rounded-md" title="Rendering in Progress">
                                                                <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                                Rendering...
                                                            </span>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('admin.promo-tests.speaking.render', $test->id) }}" method="POST" class="inline" onsubmit="return confirm('Proses render avatar memakan waktu ~5 menit. Lanjutkan?');">
                                                            @csrf
                                                            <button type="submit" class="text-purple-600 hover:text-purple-900 flex items-center gap-1" title="Render AI Avatar Videos">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <span>Render Avatar</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                <button @click="editSpeakingModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TOEFL ITP Tests Tab -->
                <!-- TOEFL Listening Tab -->
                <div x-show="tab === 'toefl_listening'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($toeflListening) }}, 'toefl_listening')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($toeflListening as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" @change="toggleTest({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                            {{ $test->toefl_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'" class="text-xs"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'" class="text-xs"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.toeflitplistening.meeting', ['number' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Edit Soal</a>
                                                <button @click="editToeflModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TOEFL Structure Tab -->
                <div x-show="tab === 'toefl_structure'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($toeflStructure) }}, 'toefl_structure')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($toeflStructure as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" @change="toggleTest({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                            {{ $test->toefl_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'" class="text-xs"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'" class="text-xs"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.toeflitpstructure.meeting', ['number' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Edit Soal</a>
                                                <button @click="editToeflModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TOEFL Reading Tab -->
                <div x-show="tab === 'toefl_reading'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($toeflReading) }}, 'toefl_reading')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($toeflReading as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" @change="toggleTest({{ $test->id }}, '{{ 'toefl_' . $test->toefl_type }}')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                            {{ $test->toefl_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                            class="text-blue-600 hover:text-blue-900 flex items-center gap-1"
                                                            title="Copy Online Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'" class="text-xs"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ route('guest.quick-access-toefl', ['type' => $test->toefl_type, 'number' => $test->meeting_number]) }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                            class="text-green-600 hover:text-green-900 flex items-center gap-1"
                                                            title="Copy Offline Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'" class="text-xs"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.toeflitpreading.meeting', ['number' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Edit Soal</a>
                                                <button @click="editToeflModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- IELTS Listening Tab -->
                <div x-show="tab === 'ielts_listening'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($listeningTests) }}, 'ielts_listening')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($listeningTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'ielts_listening')" @change="toggleTest({{ $test->id }}, 'ielts_listening')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired Promo</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Scheduled Promo</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            listening
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier && (!$test->promo_start || \Carbon\Carbon::parse($test->promo_start)->isPast()) && (!$test->promo_deadline || \Carbon\Carbon::parse($test->promo_deadline)->isFuture()))
                                                    <button @click="copyPromoLink('{{ route('promo.test.ielts_listening.show', ['meeting' => $test->meeting_number, 'test' => 1]) }}?b=online')" class="text-blue-600 hover:text-blue-900 mr-3 flex items-center inline-flex gap-1" title="Copy Online Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Online
                                                    </button>
                                                    <button @click="copyPromoLink('{{ route('promo.test.ielts_listening.show', ['meeting' => $test->meeting_number, 'test' => 1]) }}?b=offline')" class="text-green-600 hover:text-green-900 mr-3 flex items-center inline-flex gap-1" title="Copy Offline Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Offline
                                                    </button>
                                                @endif
                                                <button @click="editListeningModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($listeningTests->count() === 0)
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No IELTS Listening tests found. Ensure students have accessed the tests or manually create them.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- IELTS Reading General Tab -->
                <div x-show="tab === 'ielts_reading_general'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($readingGeneralTests) }}, 'ielts_reading_general')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($readingGeneralTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'ielts_reading_general')" @change="toggleTest({{ $test->id }}, 'ielts_reading_general')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired Promo</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Scheduled Promo</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            reading general
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier && (!$test->promo_start || \Carbon\Carbon::parse($test->promo_start)->isPast()) && (!$test->promo_deadline || \Carbon\Carbon::parse($test->promo_deadline)->isFuture()))
                                                    <button @click="copyPromoLink('{{ url('/assignments/ielts-general/reading/'.($test->meeting_number).'/test/1?promo=1&b=online') }}')" class="text-blue-600 hover:text-blue-900 mr-3 flex items-center inline-flex gap-1" title="Copy Online Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Online
                                                    </button>
                                                    <button @click="copyPromoLink('{{ url('/assignments/ielts-general/reading/'.($test->meeting_number).'/test/1?promo=1&b=offline') }}')" class="text-green-600 hover:text-green-900 mr-3 flex items-center inline-flex gap-1" title="Copy Offline Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Offline
                                                    </button>
                                                @endif
                                                <button @click="editReadingGeneralModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($readingGeneralTests->count() === 0)
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No IELTS Reading General tests found. Ensure students have accessed the tests or manually create them.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- IELTS Reading Academic Tab -->
                <div x-show="tab === 'ielts_reading_academic'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($readingAcademicTests) }}, 'ielts_reading_academic')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($readingAcademicTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'ielts_reading_academic')" @change="toggleTest({{ $test->id }}, 'ielts_reading_academic')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $test->title }}</div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired Promo</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Scheduled Promo</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            reading academic
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier && (!$test->promo_start || \Carbon\Carbon::parse($test->promo_start)->isPast()) && (!$test->promo_deadline || \Carbon\Carbon::parse($test->promo_deadline)->isFuture()))
                                                    <button @click="copyPromoLink('{{ url('/assignments/ielts-academic/reading/'.($test->meeting_number).'/test/1?promo=1&b=online') }}')" class="text-blue-600 hover:text-blue-900 mr-3 flex items-center inline-flex gap-1" title="Copy Online Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Online
                                                    </button>
                                                    <button @click="copyPromoLink('{{ url('/assignments/ielts-academic/reading/'.($test->meeting_number).'/test/1?promo=1&b=offline') }}')" class="text-green-600 hover:text-green-900 mr-3 flex items-center inline-flex gap-1" title="Copy Offline Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Offline
                                                    </button>
                                                @endif
                                                <button @click="editReadingAcademicModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($readingAcademicTests->count() === 0)
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No IELTS Reading Academic tests found. Ensure students have accessed the tests or manually create them.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <!-- Grammar Tab -->
                <div x-show="tab === 'grammar'" style="display: none;">
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-4">
                                        <input type="checkbox" @change="selectAll({{ \Illuminate\Support\Js::from($grammarTests) }}, 'grammar')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson / Period</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($grammarTests as $test)
                                    <tr>
                                        <td class="px-6 py-4 w-4 whitespace-nowrap">
                                            <input type="checkbox" :checked="isTestSelected({{ $test->id }}, 'grammar')" @change="toggleTest({{ $test->id }}, 'grammar')" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $test->title }}
                                                @php
                                                    $materi = null;
                                                    if ($test->program_id == 39) {
                                                        $materi = \Illuminate\Support\Facades\DB::table('grammar_topics')->where('order', $test->meeting_number)->value('title');
                                                    } elseif ($test->program_id == 48) {
                                                        $materi = \Illuminate\Support\Facades\DB::table('grammar_intro_topics')->where('order', $test->meeting_number)->value('topic');
                                                    }
                                                @endphp
                                                @if($materi)
                                                    <span class="text-blue-600 font-normal ml-1">- {{ $materi }}</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">Meeting {{ $test->meeting_number }} ({{ $test->program->name ?? 'Unknown Program' }})</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($test->is_free_tier)
                                                @if($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Expired at {{ \Carbon\Carbon::parse($test->promo_deadline)->format('d M Y, H:i') }}">Expired Promo</span>
                                                @elseif($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" title="Active from {{ \Carbon\Carbon::parse($test->promo_start)->format('d M Y, H:i') }}">Scheduled Promo</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            grammar
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($test) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($test->is_free_tier)
                                                    <button @click="copyPromoLink(getGrammarPromoLink(testData, 'online'))" class="text-blue-600 hover:text-blue-900 mr-3 flex items-center inline-flex gap-1" title="Copy Online Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Online
                                                    </button>
                                                    <button @click="copyPromoLink(getGrammarPromoLink(testData, 'offline'))" class="text-green-600 hover:text-green-900 mr-3 flex items-center inline-flex gap-1" title="Copy Offline Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        Copy Offline
                                                    </button>
                                                @endif
                                                <a href="{{ route('promo.test.grammar.meeting', ['meeting' => $test->meeting_number]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit Soal</a>
                                                <button @click="editGrammarModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-10 mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-gray-800">Grammar Practice Topics</h3>
                            <p class="text-xs text-gray-500">Isolated from real class curriculum &mdash; safe to flag as promo or create new here.</p>
                        </div>
                        <button type="button" @click="createGrammarPracticeModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Grammar Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promo Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($grammarPracticeTopics as $topic)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $topic->title }}</div>
                                            @if($topic->desc)
                                                <div class="text-xs text-gray-500">{{ $topic->desc }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($topic->is_free_tier)
                                                @if($topic->promo_deadline && \Carbon\Carbon::parse($topic->promo_deadline)->isPast())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired Promo</span>
                                                @elseif($topic->promo_start && \Carbon\Carbon::parse($topic->promo_start)->isFuture())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Scheduled Promo</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Free Tier</span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Standard</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $topic->questions_count }} questions
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @php
                                                $topicPromoUrl = url('/promo/test/grammar-practice/' . $topic->id);
                                            @endphp
                                            <div x-data="{ linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                @if($topic->is_free_tier)
                                                    <button @click="window.copyLink('{{ $topicPromoUrl }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" class="text-blue-600 hover:text-blue-900 flex items-center inline-flex gap-1" title="Copy Online Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                    </button>
                                                    <button @click="window.copyLink('{{ $topicPromoUrl }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" class="text-green-600 hover:text-green-900 flex items-center inline-flex gap-1" title="Copy Offline Link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                        <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.promo-tests.grammar-practice.questions.index', $topic->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Edit Questions</a>
                                                <button @click="editGrammarPracticeModal = {{ \Illuminate\Support\Js::from($topic) }}" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PTE Speaking & Writing Tab -->
                <div x-show="tab === 'pte_speaking_writing'" style="display: none;">
                    <div class="mb-4 flex justify-end">
                        <button type="button" @click="createPteSpeakingWritingModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Speaking & Writing Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LESSON / PERIOD</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PROMO STATUS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TEST TYPE</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pteSpeakingWritingTypes as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item['title'] }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $item['count'] }} Topics Available</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Free Tier
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            pte_{{ $item['slug'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($item) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                        class="text-blue-600 hover:text-blue-900 flex items-center inline-flex gap-1"
                                                        title="Copy Online Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                </button>
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                        class="text-green-600 hover:text-green-900 flex items-center inline-flex gap-1"
                                                        title="Copy Offline Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                </button>
                                                <!-- No content editor exists yet for these config-driven PTE questions; link opens a live preview of the public promo page instead --><a href="{{ $item['route'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Preview</a>
                                                <button @click="editPteModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PTE Reading Tab -->
                <div x-show="tab === 'pte_reading'" style="display: none;">
                    <div class="mb-4 flex justify-end">
                        <button type="button" @click="createPteReadingModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Reading Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LESSON / PERIOD</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PROMO STATUS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TEST TYPE</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pteReadingTypes as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item['title'] }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $item['count'] }} Passages Available</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Free Tier
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            pte_{{ $item['slug'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($item) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                        class="text-blue-600 hover:text-blue-900 flex items-center inline-flex gap-1"
                                                        title="Copy Online Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                </button>
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                        class="text-green-600 hover:text-green-900 flex items-center inline-flex gap-1"
                                                        title="Copy Offline Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                </button>
                                                <!-- No content editor exists yet for these config-driven PTE questions; link opens a live preview of the public promo page instead --><a href="{{ $item['route'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Preview</a>
                                                <button @click="editPteModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PTE Listening Tab -->
                <div x-show="tab === 'pte_listening'" style="display: none;">
                    <div class="mb-4 flex justify-end">
                        <button type="button" @click="createPteListeningModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium shadow-sm">
                            + Create New Listening Test
                        </button>
                    </div>
                    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LESSON / PERIOD</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PROMO STATUS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TEST TYPE</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pteListeningTypes as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item['title'] }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $item['count'] }} Audios Available</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Free Tier
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            pte_{{ $item['slug'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ testData: {{ \Illuminate\Support\Js::from($item) }}, linkCopiedOnline: false, linkCopiedOffline: false }" class="flex justify-end gap-3 items-center">
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=online'); linkCopiedOnline = true; setTimeout(() => linkCopiedOnline = false, 2000)" 
                                                        class="text-blue-600 hover:text-blue-900 flex items-center inline-flex gap-1"
                                                        title="Copy Online Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOnline ? 'Copied!' : 'Copy Online'"></span>
                                                </button>
                                                <button @click="window.copyLink('{{ $item['route'] }}?b=offline'); linkCopiedOffline = true; setTimeout(() => linkCopiedOffline = false, 2000)" 
                                                        class="text-green-600 hover:text-green-900 flex items-center inline-flex gap-1"
                                                        title="Copy Offline Link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <span x-text="linkCopiedOffline ? 'Copied!' : 'Copy Offline'"></span>
                                                </button>
                                                <!-- No content editor exists yet for these config-driven PTE questions; link opens a live preview of the public promo page instead --><a href="{{ $item['route'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Preview</a>
                                                <button @click="editPteModal = testData" class="text-blue-600 hover:text-blue-900">Manage Settings</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Grammar Test Modal -->
                <div x-show="editGrammarModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="editGrammarModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="editGrammarModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form :action="`{{ url('/admin/promo-tests/grammar') }}/${editGrammarModal ? editGrammarModal.id : ''}`" method="POST">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Manage Promo Settings: <span x-text="editGrammarModal ? editGrammarModal.title : ''"></span>
                                            </h3>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="is_free_tier" id="grammar_is_free_tier" :checked="editGrammarModal && editGrammarModal.is_free_tier == 1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label for="grammar_is_free_tier" class="ml-2 block text-sm text-gray-900">
                                                        Enable as Free Promotional Test
                                                    </label>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Promo Start Date (Optional)</label>
                                                        <input type="datetime-local" name="promo_start" :value="editGrammarModal && editGrammarModal.promo_start ? editGrammarModal.promo_start.replace(' ', 'T') : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700">Promo End Date (Optional)</label>
                                                        <input type="datetime-local" name="promo_deadline" :value="editGrammarModal && editGrammarModal.promo_deadline ? editGrammarModal.promo_deadline.replace(' ', 'T') : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>
                                                <p class="text-xs text-gray-500">Leave dates empty for permanent free tier. If set, promo is only active between these dates.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" @click="editGrammarModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="createWritingModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createWritingModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <form method="POST" action="/admin/promo-tests/writing">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="createWritingModal === 'writing_general' ? 'Create New General Writing Test' : 'Create New Academic Writing Test'"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="cw_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="cw_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Prompt / Question</label>
                                            <textarea name="prompt" rows="5" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Test Type</label>
                                            <select name="test_type" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                                <template x-if="createWritingModal === 'writing'">
                                                    <option value="writing_t1">Academic Task 1 (Graph/Chart/Map)</option>
                                                </template>
                                                <template x-if="createWritingModal === 'writing'">
                                                    <option value="writing_t2">Academic Task 2 (Essay)</option>
                                                </template>
                                                <template x-if="createWritingModal === 'writing_general'">
                                                    <option value="writing_general_t1">General Task 1 (Letter)</option>
                                                </template>
                                                <template x-if="createWritingModal === 'writing_general'">
                                                    <option value="writing_general_t2">General Task 2 (Essay)</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create
                                    </button>
                                    <button type="button" @click="createWritingModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Create Speaking Modal -->
                <div x-show="createSpeakingModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createSpeakingModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <form method="POST" action="/admin/promo-tests/speaking">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Create New Speaking Topic</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="cs_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="cs_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Questions JSON / Prompt</label>
                                            <textarea name="questions" rows="5" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono" placeholder='["Q1", "Q2"]' required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create
                                    </button>
                                    <button type="button" @click="createSpeakingModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Writing Modal -->
                <div x-show="editWritingModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editWritingModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <form method="POST" :action="`/admin/promo-tests/writing/${editWritingModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editWritingModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="w_is_free_tier" name="is_free_tier" value="1" :checked="editWritingModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="w_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" :value="editWritingModal?.title" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Prompt / Question</label>
                                            <textarea name="prompt" rows="5" :value="editWritingModal?.prompt" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Test Type</label>
                                            <input type="text" name="test_type" :value="editWritingModal?.test_type || ('writing_t' + editWritingModal?.task_type)" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. writing_t1, writing_t2">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Active From (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editWritingModal?.promo_start ? editWritingModal.promo_start.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will only be active from this time.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editWritingModal?.promo_deadline ? editWritingModal.promo_deadline.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will be inactive after this time.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">System Prompt Override</label>
                                            <textarea name="system_prompt_override" rows="3" :value="editWritingModal?.system_prompt_override" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Optional custom AI instruction..."></textarea>
                                        </div>

                                        <div x-show="editWritingModal?.task_type == '1'">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Graph Data JSON (Task 1 Only)</label>
                                            <textarea name="graph_data_json" rows="4" :value="editWritingModal?.graph_data_json" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder='{"data": []}'></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center">
                                    <div class="sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editWritingModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                    <button type="button" @click="if(confirm('Are you sure you want to delete this test?')){ document.getElementById('delete-writing-form').action = `/admin/promo-tests/writing/${editWritingModal.id}`; document.getElementById('delete-writing-form').submit(); }" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Delete
                                    </button>
                                </div>
                            </form>
                            <form id="delete-writing-form" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Speaking Modal -->
                <div x-show="editSpeakingModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editSpeakingModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <form method="POST" :action="`/admin/promo-tests/speaking/${editSpeakingModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editSpeakingModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="s_is_free_tier" name="is_free_tier" value="1" :checked="editSpeakingModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="s_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" :value="editSpeakingModal?.title" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Questions JSON / Prompt</label>
                                            <textarea name="questions" rows="5" :value="editSpeakingModal?.questions" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm font-mono" required></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Test Type</label>
                                            <input type="text" name="test_type" :value="editSpeakingModal?.test_type || 'speaking'" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="e.g. speaking">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Active From (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editSpeakingModal?.promo_start ? editSpeakingModal.promo_start.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will only be active from this time.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editSpeakingModal?.promo_deadline ? editSpeakingModal.promo_deadline.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will be inactive after this time.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">System Prompt Override</label>
                                            <textarea name="system_prompt_override" rows="3" :value="editSpeakingModal?.system_prompt_override" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Optional custom AI instruction..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center">
                                    <div class="sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editSpeakingModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                    <button type="button" @click="if(confirm('Are you sure you want to delete this test?')){ document.getElementById('delete-speaking-form').action = `/admin/promo-tests/speaking/${editSpeakingModal.id}`; document.getElementById('delete-speaking-form').submit(); }" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Delete
                                    </button>
                                </div>
                            </form>
                            <form id="delete-speaking-form" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit IELTS Listening Modal -->
                <div x-show="editListeningModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editListeningModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" :action="`/admin/promo-tests/listening/${editListeningModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editListeningModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="l_is_free_tier" name="is_free_tier" value="1" :checked="editListeningModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="l_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Start (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editListeningModal?.promo_start ? editListeningModal.promo_start.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Leave blank to start immediately when free tier is enabled.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editListeningModal?.promo_deadline ? editListeningModal.promo_deadline.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Test will automatically revert to standard tier after this deadline.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center">
                                    <div>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editListeningModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit IELTS Reading General Modal -->
                <div x-show="editReadingGeneralModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editReadingGeneralModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" :action="`/admin/promo-tests/reading-general/${editReadingGeneralModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editReadingGeneralModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="rg_is_free_tier" name="is_free_tier" value="1" :checked="editReadingGeneralModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="rg_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Start (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editReadingGeneralModal?.promo_start ? editReadingGeneralModal.promo_start.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Leave blank to start immediately when free tier is enabled.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editReadingGeneralModal?.promo_deadline ? editReadingGeneralModal.promo_deadline.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Test will automatically revert to standard tier after this deadline.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center">
                                    <div>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editReadingGeneralModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit IELTS Reading Academic Modal -->
                <div x-show="editReadingAcademicModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editReadingAcademicModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" :action="`/admin/promo-tests/reading-academic/${editReadingAcademicModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editReadingAcademicModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="ra_is_free_tier" name="is_free_tier" value="1" :checked="editReadingAcademicModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="ra_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Start (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editReadingAcademicModal?.promo_start ? editReadingAcademicModal.promo_start.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Leave blank to start immediately when free tier is enabled.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editReadingAcademicModal?.promo_deadline ? editReadingAcademicModal.promo_deadline.replace(' ', 'T').substring(0, 16) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <p class="mt-1 text-xs text-gray-500">Test will automatically revert to standard tier after this deadline.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center">
                                    <div>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button" @click="editReadingAcademicModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit TOEFL Modal -->
                <div x-show="editToeflModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editToeflModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            <form method="POST" :action="`/admin/promo-tests/toefl-${editToeflModal?.toefl_type}/${editToeflModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="`Edit Promo Settings: ${editToeflModal?.title}`"></h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-md">
                                            <input type="checkbox" id="t_is_free_tier" name="is_free_tier" value="1" :checked="editToeflModal?.is_free_tier" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="t_is_free_tier" class="text-sm text-gray-700 font-medium">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" :value="editToeflModal?.title" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Active From (Optional)</label>
                                            <input type="datetime-local" name="promo_start" :value="editToeflModal?.promo_start ? editToeflModal.promo_start.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will only be active from this time.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Promo Deadline (Optional)</label>
                                            <input type="datetime-local" name="promo_deadline" :value="editToeflModal?.promo_deadline ? editToeflModal.promo_deadline.replace(' ', 'T').slice(0, 16) : ''" class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <p class="text-xs text-gray-500 mt-1">If set, the promo test will be inactive after this time.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" @click="editToeflModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit PTE Test Modal -->
                <div x-show="editPteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="editPteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="editPteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" :action="`/admin/promo-tests/pte/${editPteModal?.category}/${editPteModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4" id="modal-title">
                                                Manage Settings: <span class="text-orange-600" x-text="editPteModal ? editPteModal.title : ''"></span>
                                            </h3>

                                            <div class="space-y-4">
                                                <div class="flex items-center gap-2 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                                    <input type="checkbox" id="pte_is_free_tier" name="is_free_tier" value="1" :checked="editPteModal?.is_free_tier" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500 h-4 w-4">
                                                    <label for="pte_is_free_tier" class="text-sm font-semibold text-orange-900">Enable as Free Tier Promo Test</label>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                                                    <input type="text" :value="editPteModal ? editPteModal.title : ''" readonly class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-700 shadow-sm sm:text-sm font-medium">
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Promo Start Date (Optional)</label>
                                                        <input type="datetime-local" name="promo_start" :value="editPteModal?.promo_start ? editPteModal.promo_start.replace(' ', 'T').substring(0, 16) : ''" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Promo End Date (Optional)</label>
                                                        <input type="datetime-local" name="promo_deadline" :value="editPteModal?.promo_deadline ? editPteModal.promo_deadline.replace(' ', 'T').substring(0, 16) : ''" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                    </div>
                                                </div>
                                                <p class="text-xs text-gray-500">Controls whether the public "Copy Online"/"Copy Offline" link for this test is accessible to guests.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" @click="editPteModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Create PTE Speaking & Writing Modal -->
                <div x-show="createPteSpeakingWritingModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createPteSpeakingWritingModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <form method="POST" action="{{ route('admin.promo-tests.pte.speaking-writing.store') }}">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[75vh] overflow-y-auto">
                                    <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">Create New PTE Speaking &amp; Writing Promo Test</h3>
                                    <p class="text-xs text-gray-500 mb-4">All 6 tasks are required &mdash; the public promo page always shows this fixed sequence.</p>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                            <input type="checkbox" id="psw_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-orange-600 focus:ring-orange-500 h-4 w-4">
                                            <label for="psw_is_free_tier" class="text-sm font-semibold text-orange-900">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" required placeholder="PTE Speaking & Writing Promo Test 3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm">
                                        </div>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">1. Read Aloud</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Text to read aloud</label>
                                            <textarea name="read_aloud_text" rows="2" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div><label class="block text-xs text-gray-500 mb-1">Prep (sec)</label><input type="number" name="read_aloud_prep" value="35" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Record (sec)</label><input type="number" name="read_aloud_record" value="40" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">2. Repeat Sentence</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Sentence to repeat</label>
                                            <textarea name="repeat_sentence_text" rows="2" required class="w-full rounded-md border-gray-300 shadow-sm text-sm"></textarea>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">3. Describe Image</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Image title</label>
                                            <input type="text" name="describe_image_title" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Image path/URL</label>
                                            <input type="text" name="describe_image_image" required placeholder="/images/practice/example.png" class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2">
                                            <div class="grid grid-cols-3 gap-2">
                                                <div>
                                                    <label class="block text-xs text-gray-500 mb-1">Type</label>
                                                    <select name="describe_image_type" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                        <option value="chart">chart</option>
                                                        <option value="graph">graph</option>
                                                        <option value="flowchart">flowchart</option>
                                                        <option value="table">table</option>
                                                        <option value="map">map</option>
                                                        <option value="diagram">diagram</option>
                                                    </select>
                                                </div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Prep (sec)</label><input type="number" name="describe_image_prep" value="25" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Record (sec)</label><input type="number" name="describe_image_record" value="40" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">4. Re-tell Lecture</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Lecture title</label>
                                            <input type="text" name="retell_lecture_title" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Lecture transcript</label>
                                            <textarea name="retell_lecture_transcript" rows="2" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div><label class="block text-xs text-gray-500 mb-1">Prep (sec)</label><input type="number" name="retell_lecture_prep" value="10" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Record (sec)</label><input type="number" name="retell_lecture_record" value="40" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">5. Summarize Written Text</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Passage</label>
                                            <textarea name="summarize_written_text_passage" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div><label class="block text-xs text-gray-500 mb-1">Word limit</label><input type="text" name="summarize_written_text_word_limit" value="5-75 words" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Time limit (sec)</label><input type="number" name="summarize_written_text_time_limit" value="600" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">6. Write Essay</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Essay topic</label>
                                            <textarea name="write_essay_topic" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div><label class="block text-xs text-gray-500 mb-1">Word limit</label><input type="text" name="write_essay_word_limit" value="200-300 words" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Time limit (sec)</label><input type="number" name="write_essay_time_limit" value="1200" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create Test
                                    </button>
                                    <button type="button" @click="createPteSpeakingWritingModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Create PTE Reading Modal -->
                <div x-show="createPteReadingModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createPteReadingModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <form method="POST" action="{{ route('admin.promo-tests.pte.reading.store') }}">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[75vh] overflow-y-auto">
                                    <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">Create New PTE Reading Promo Test</h3>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                            <input type="checkbox" id="pr_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-orange-600 focus:ring-orange-500 h-4 w-4">
                                            <label for="pr_is_free_tier" class="text-sm font-semibold text-orange-900">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" required placeholder="PTE Reading Promo Test 3" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        </div>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">1. Reading &amp; Writing: Fill in the Blanks</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Passage &mdash; wrap each correct blank word in [brackets]</label>
                                            <textarea name="rw_fib_passage" rows="3" required placeholder="Historians believe these were [urban] settlements..." class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Options &mdash; one line per blank, comma-separated, in the SAME order as the blanks above. Include the bracketed word as one of the choices.</label>
                                            <textarea name="rw_fib_options" rows="3" required placeholder="urban, rural, coastal, isolated&#10;interconnected, separated, isolated, fragmented" class="w-full rounded-md border-gray-300 shadow-sm text-sm font-mono"></textarea>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">2. Re-order Paragraphs</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Paragraphs &mdash; one per line, in the CORRECT reading order (they'll be shuffled automatically for the student)</label>
                                            <textarea name="reorder_paragraphs" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm text-sm"></textarea>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">3. Reading: Fill in the Blanks</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Passage &mdash; wrap each correct blank word in [brackets]</label>
                                            <textarea name="reading_fib_passage" rows="3" required placeholder="Memory [retention] is enhanced by..." class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Extra distractor words (comma-separated, optional)</label>
                                            <input type="text" name="reading_fib_distractors" placeholder="distraction, suppression" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create Test
                                    </button>
                                    <button type="button" @click="createPteReadingModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Create PTE Listening Modal -->
                <div x-show="createPteListeningModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createPteListeningModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <form method="POST" action="{{ route('admin.promo-tests.pte.listening.store') }}">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[75vh] overflow-y-auto">
                                    <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">Create New PTE Listening Promo Test</h3>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                            <input type="checkbox" id="pl_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-orange-600 focus:ring-orange-500 h-4 w-4">
                                            <label for="pl_is_free_tier" class="text-sm font-semibold text-orange-900">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" name="title" required placeholder="PTE Listening Promo Test 3" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        </div>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">Summarize Spoken Text</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Transcript (played to the student via text-to-speech)</label>
                                            <textarea name="sst_transcript" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm text-sm mb-2"></textarea>
                                            <div class="grid grid-cols-3 gap-2">
                                                <div class="col-span-1"><label class="block text-xs text-gray-500 mb-1">Prompt</label><input type="text" name="sst_prompt" value="Summarize the spoken text in 50-70 words." class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Word limit</label><input type="text" name="sst_word_limit" value="50-70 words" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                                <div><label class="block text-xs text-gray-500 mb-1">Time limit (sec)</label><input type="number" name="sst_time_limit" value="600" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-xs font-bold text-gray-500 uppercase px-1">Write From Dictation</legend>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Sentences &mdash; one per line, each played via text-to-speech</label>
                                            <textarea name="wfd_sentences" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm text-sm"></textarea>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create Test
                                    </button>
                                    <button type="button" @click="createPteListeningModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Create Grammar Practice Topic Modal -->
                <div x-show="createGrammarPracticeModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="createGrammarPracticeModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" action="{{ route('admin.promo-tests.grammar-practice.store') }}">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">Create New Grammar Test</h3>
                                    <p class="text-xs text-gray-500 mb-4">Creates a new Grammar Practice topic, fully separate from real class curriculum. Add its questions afterward from the Grammar Practice admin page.</p>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-teal-50 border border-teal-200 rounded-lg">
                                            <input type="checkbox" id="gp_is_free_tier" name="is_free_tier" value="1" checked class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 h-4 w-4">
                                            <label for="gp_is_free_tier" class="text-sm font-semibold text-teal-900">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Topic Title</label>
                                            <input type="text" name="title" required placeholder="e.g. Conditional Sentences" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                                            <textarea name="desc" rows="2" class="w-full rounded-md border-gray-300 shadow-sm text-sm"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Create Topic
                                    </button>
                                    <button type="button" @click="createGrammarPracticeModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Manage Grammar Practice Topic Settings Modal -->
                <div x-show="editGrammarPracticeModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editGrammarPracticeModal = null"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form method="POST" :action="`/admin/promo-tests/grammar-practice/${editGrammarPracticeModal?.id}`">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">
                                        Manage Settings: <span class="text-teal-600" x-text="editGrammarPracticeModal ? editGrammarPracticeModal.title : ''"></span>
                                    </h3>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 p-3 bg-teal-50 border border-teal-200 rounded-lg">
                                            <input type="checkbox" id="gpe_is_free_tier" name="is_free_tier" value="1" :checked="editGrammarPracticeModal?.is_free_tier" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 h-4 w-4">
                                            <label for="gpe_is_free_tier" class="text-sm font-semibold text-teal-900">Enable as Free Tier Promo Test</label>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Promo Start Date (Optional)</label>
                                                <input type="datetime-local" name="promo_start" :value="editGrammarPracticeModal?.promo_start ? editGrammarPracticeModal.promo_start.replace(' ', 'T').substring(0, 16) : ''" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Promo End Date (Optional)</label>
                                                <input type="datetime-local" name="promo_deadline" :value="editGrammarPracticeModal?.promo_deadline ? editGrammarPracticeModal.promo_deadline.replace(' ', 'T').substring(0, 16) : ''" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500">This topic has <span x-text="editGrammarPracticeModal?.questions_count ?? 0"></span> question(s). The public promo link uses the first 5.</p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" @click="editGrammarPracticeModal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function promoTestsAdmin() {
            return {
                tab: sessionStorage.getItem('adminPromoTab') || 'writing',
                createWritingModal: false,
                createSpeakingModal: false,
                editWritingModal: null,
                editSpeakingModal: null,
                editListeningModal: null,
                editReadingGeneralModal: null,
                editReadingAcademicModal: null,
                editToeflModal: null,
                editGrammarModal: null,
                editPteModal: null,
                createPteSpeakingWritingModal: false,
                createPteReadingModal: false,
                createPteListeningModal: false,
                createGrammarPracticeModal: false,
                editGrammarPracticeModal: null,
                selectedTests: [],
                init() {
                    this.$watch('tab', value => sessionStorage.setItem('adminPromoTab', value));
                },
                toggleTest(id, type) {
                    const idx = this.selectedTests.findIndex(t => t.id === id && t.type === type);
                    if (idx > -1) {
                        this.selectedTests.splice(idx, 1);
                    } else {
                        this.selectedTests.push({ id, type });
                    }
                },
                getTestType(t, defaultType) {
                    if (t.toefl_type) return 'toefl_' + t.toefl_type;
                    if (t.test_type) {
                        if (t.test_type.includes('general')) return 'writing_general';
                        return 'writing';
                    }
                    if (defaultType === 'ielts_listening') return 'ielts_listening';
                    if (defaultType === 'ielts_reading_general') return 'ielts_reading_general';
                    if (defaultType === 'ielts_reading_academic') return 'ielts_reading_academic';
                    return defaultType;
                },
                isTestSelected(id, type) {
                    return this.selectedTests.findIndex(t => t.id === id && t.type === type) > -1;
                },
                selectAll(tests, defaultType) {
                    const allSelected = tests.every(t => this.isTestSelected(t.id, this.getTestType(t, defaultType)));
                    if (allSelected) {
                        tests.forEach(t => {
                            const type = this.getTestType(t, defaultType);
                            const idx = this.selectedTests.findIndex(st => st.id === t.id && st.type === type);
                            if (idx > -1) this.selectedTests.splice(idx, 1);
                        });
                    } else {
                        tests.forEach(t => {
                            const type = this.getTestType(t, defaultType);
                            if (!this.isTestSelected(t.id, type)) {
                                this.selectedTests.push({ id: t.id, type: type });
                            }
                        });
                    }
                },
                copyPromoLink(url) {
                    window.copyLink(url).then(() => {
                        // Show a brief alert or toast
                        const toast = document.createElement('div');
                        toast.textContent = '✓ Link copied to clipboard!';
                        toast.style.cssText = 'position:fixed;top:1rem;right:1rem;z-index:9999;background:#059669;color:white;padding:0.75rem 1.25rem;border-radius:0.5rem;font-size:0.875rem;font-weight:600;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:opacity 0.3s;';
                        document.body.appendChild(toast);
                        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2000);
                    }).catch(() => {
                        prompt('Copy this link:', url);
                    });
                },
                getGrammarPromoLink(test, type) {
                    let base = '{{ url("/promo/test/grammar-promo") }}';
                    return `${base}/${test.meeting_number}?promo=1&b=${type}`;
                }
            }
        }
    </script>
    <script>
        window.copyLink = function(text) {
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            } else {
                return new Promise((resolve, reject) => {
                    let textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        resolve();
                    } catch (err) {
                        reject(err);
                    }
                    textArea.remove();
                });
            }
        };
    </script>

    <!-- Video Modal -->
    <div x-data="{ open: false, videos: [], currentIndex: 0, gender: 'female' }" 
         @open-avatar-modal.window="open = true; videos = $event.detail.videos; currentIndex = 0; gender = 'female';" 
         class="relative z-[100]" 
         x-show="open" 
         style="display: none;"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="open" 
                     @click.away="open = false; videos = []"
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <div class="flex items-center justify-between mb-4 w-full">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Avatar Video Preview</h3>
                                    <div class="flex items-center gap-1 text-sm bg-gray-100 p-1 rounded-lg">
                                        <button @click="gender = 'female'" :class="gender === 'female' ? 'bg-white shadow text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 rounded-md transition-all">Female</button>
                                        <button @click="gender = 'male'" :class="gender === 'male' ? 'bg-white shadow text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 rounded-md transition-all" :disabled="!videos[currentIndex]?.url_male" :title="!videos[currentIndex]?.url_male ? 'Male video not rendered yet' : ''">Male</button>
                                    </div>
                                </div>
                                <div class="mt-2 w-full rounded-xl overflow-hidden bg-black flex flex-col items-center justify-center relative">
                                    <template x-if="videos.length > 0">
                                        <div class="w-full flex flex-col items-center">
                                            <video :src="gender === 'female' ? videos[currentIndex].url_female : (videos[currentIndex].url_male || videos[currentIndex].url_female)" controls autoplay class="w-full max-h-[65vh] object-contain"></video>
                                            
                                            <!-- Navigation Controls -->
                                            <div class="w-full bg-gray-900 p-3 flex items-center justify-between">
                                                <button @click="if(currentIndex > 0) currentIndex--" 
                                                        :disabled="currentIndex === 0" 
                                                        class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                    Previous
                                                </button>
                                                
                                                <div class="flex flex-col items-center px-4 max-w-[60%]">
                                                    <span class="text-xs text-gray-400 mb-1" x-text="`Video ${currentIndex + 1} of ${videos.length}`"></span>
                                                    <p class="text-sm text-white text-center line-clamp-2" x-text="videos[currentIndex].text"></p>
                                                </div>
                                                
                                                <button @click="if(currentIndex < videos.length - 1) currentIndex++" 
                                                        :disabled="currentIndex === videos.length - 1" 
                                                        class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded-md text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="videos.length === 0">
                                        <div class="text-gray-500 text-sm py-12">Video not available</div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" @click="open = false; videos = []" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

{{-- ============================================================ --}}
{{-- WhatsApp Evaluation Preview Modal --}}
{{-- ============================================================ --}}
<div x-data="{ open: false, type: 'ielts_writing' }" @open-wa-preview.window="open = true; type = $event.detail.type" style="display:none" x-show="open" class="relative z-[100]" x-cloak>
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    {{-- Modal --}}
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" @click.stop>
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 bg-[#075E54]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Preview Pesan WhatsApp</p>
                        <p class="text-white/70 text-xs">
                            <span x-show="type === 'ielts_writing'">Format Evaluasi IELTS Writing</span>
                            <span x-show="type === 'ielts_writing_general'">Format Evaluasi IELTS Writing General</span>
                            <span x-show="type === 'ielts_speaking'">Format Evaluasi IELTS Speaking</span>
                            <span x-show="type === 'ielts_listening'">Format Evaluasi IELTS Listening</span>
                            <span x-show="type === 'ielts_reading_general'">Format Evaluasi IELTS Reading General</span>
                            <span x-show="type === 'ielts_reading_academic'">Format Evaluasi IELTS Reading Academic</span>
                            <span x-show="type === 'toefl_listening'">Format Evaluasi Listening ITP</span>
                            <span x-show="type === 'toefl_structure'">Format Evaluasi Structure ITP</span>
                            <span x-show="type === 'toefl_reading'">Format Evaluasi Reading ITP</span>
                            <span x-show="type === 'toefl'">Format Evaluasi Full TOEFL ITP</span>
                        </p>
                    </div>
                </div>
                <button @click="open = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- WhatsApp Chat UI --}}
            <div class="bg-[#ECE5DD]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"\u003e%3Cg fill=\"none\" fill-rule=\"evenodd\"\u003e%3Cg fill=\"%23d4c5b0\" fill-opacity=\"0.3\"\u003e%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                <div class="p-4 max-h-96 overflow-y-auto">
                    {{-- Chat bubble from Target Bahasa --}}
                    <div class="flex justify-start mb-4">
                        <div class="max-w-xs bg-white rounded-2xl rounded-tl-none shadow-sm px-4 py-3 text-sm text-gray-800 leading-relaxed relative" style="max-width: 85%;">
                            <p class="text-[#075E54] font-semibold text-xs mb-1">Target Bahasa</p>
                            
                            {{-- IELTS Writing & Speaking --}}
                            <div x-show="type === 'ielts_writing' || type === 'ielts_writing_general' || type === 'ielts_speaking'" class="whitespace-pre-line text-[13px] leading-6">
Halo! Berikut adalah summary hasil evaluasi Free Test IELTS Anda dari <strong>Target Bahasa</strong>:

⭐️ <strong>Overall Band Score: [Skor Peserta]</strong>

Rincian Skor:
- <span x-text="type === 'ielts_speaking' ? 'Pronunciation' : 'Task Response'"></span>: [Skor Task]
- <span x-text="type === 'ielts_speaking' ? 'Fluency & Coherence' : 'Coherence/Cohesion'"></span>: [Skor Coherence]
- Lexical Resource: [Skor Lexical]
- Grammatical Range: [Skor Grammar]

Saran Perbaikan:
[Saran dari AI Feedback]
<span x-show="type.includes('writing')">
Detailed Text Analysis:
[Hasil teks dengan ~coretan~ dan *perbaikan*]
</span>
Terus semangat belajar! Untuk panduan dan course IELTS terbaik, segera hubungi admin Target Bahasa.
                            </div>

                            {{-- IELTS Listening & Reading --}}
                            <div x-show="type === 'ielts_listening' || type === 'ielts_reading_general' || type === 'ielts_reading_academic'" class="whitespace-pre-line text-[13px] leading-6">
Halo! Berikut adalah summary hasil evaluasi Free Test IELTS Anda dari <strong>Target Bahasa</strong>:

⭐️ <strong>Band Score: [Skor Anda]</strong>

Terus semangat belajar! Untuk panduan dan course IELTS terbaik, segera hubungi admin Target Bahasa.
                            </div>

                            {{-- TOEFL Single Sections --}}
                            <div x-show="type === 'toefl_listening' || type === 'toefl_structure' || type === 'toefl_reading'" class="whitespace-pre-line text-[13px] leading-6">
Halo! Berikut adalah summary hasil evaluasi Free Test TOEFL ITP Anda dari <strong>Target Bahasa</strong>:

⭐️ <strong>Section Score: [Skor Anda]</strong>
<span x-show="type === 'toefl_listening'">Tipe: Listening Comprehension</span>
<span x-show="type === 'toefl_structure'">Tipe: Structure & Written Expression</span>
<span x-show="type === 'toefl_reading'">Tipe: Reading Comprehension</span>

Terus semangat belajar! Untuk panduan dan course TOEFL terbaik, segera hubungi admin Target Bahasa.
                            </div>

                            {{-- TOEFL Full --}}
                            <div x-show="type === 'toefl'" class="whitespace-pre-line text-[13px] leading-6">
Halo! Berikut adalah summary hasil evaluasi Free Test TOEFL ITP Anda dari <strong>Target Bahasa</strong>:

⭐️ <strong>Total Score: [Total Skor]</strong>

Rincian Skor:
- Listening Comprehension: [Skor Listening]
- Structure & Written Expression: [Skor Structure]
- Reading Comprehension: [Skor Reading]

Terus semangat belajar! Untuk panduan dan course TOEFL terbaik, segera hubungi admin Target Bahasa.
                            </div>

                            <p class="text-right text-gray-400 text-[10px] mt-1">Sent via Fonnte ✓✓</p>
                            {{-- Bubble tail --}}
                            <div class="absolute -left-2 top-0 w-0 h-0" style="border-top: 8px solid white; border-left: 8px solid transparent;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info section --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Variabel yang diisi otomatis dari AI Feedback:</p>
                
                {{-- IELTS Fields --}}
                <div x-show="type === 'ielts_writing' || type === 'ielts_writing_general' || type === 'ielts_speaking'" class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">overall_band_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                        <span class="text-gray-600">
                            <code x-show="type === 'ielts_writing' || type === 'ielts_writing_general'" class="bg-gray-100 px-1 rounded">task_response_score</code>
                            <code x-show="type === 'ielts_speaking'" class="bg-gray-100 px-1 rounded">pronunciation_score</code>
                        </span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500 shrink-0"></span>
                        <span class="text-gray-600">
                            <code x-show="type === 'ielts_writing' || type === 'ielts_writing_general'" class="bg-gray-100 px-1 rounded">coherence_cohesion_score</code>
                            <code x-show="type === 'ielts_speaking'" class="bg-gray-100 px-1 rounded">fluency_and_coherence_score</code>
                        </span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">lexical_resource_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">grammatical_range_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5 col-span-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">feedback</code> / <code class="bg-gray-100 px-1 rounded">overall_comment</code></span>
                    </div>
                </div>

                <div x-show="type === 'ielts_listening' || type === 'ielts_reading_general' || type === 'ielts_reading_academic'" class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">band_score</code></span>
                    </div>
                </div>

                {{-- TOEFL Full Fields --}}
                <div x-show="type === 'toefl'" class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">total_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">listening_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">structure_score</code></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">reading_score</code></span>
                    </div>
                </div>

                {{-- TOEFL Single Fields --}}
                <div x-show="type === 'toefl_listening' || type === 'toefl_structure' || type === 'toefl_reading'" class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">score</code></span>
                    </div>
                </div>

                {{-- TPA & SKD Fields --}}
                <div x-show="type === 'tpa' || type === 'skd'" class="grid grid-cols-1 gap-2 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                        <span class="text-gray-600"><code class="bg-gray-100 px-1 rounded">score</code></span>
                    </div>
                </div>

                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                    <p class="text-xs text-amber-700">
                        <svg class="inline w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pesan ini dikirim melalui <strong>Fonnte API</strong> setelah peserta memasukkan nomor WhatsApp di halaman hasil.
                        Pastikan <code class="bg-amber-100 px-1 rounded">FONNTE_API_KEY</code> sudah dikonfigurasi di <code class="bg-amber-100 px-1 rounded">.env</code>.
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-3 flex justify-end gap-2 border-t border-gray-100">
                <button @click="open = false" class="px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
