<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Read Aloud Practice | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    {{-- Top Navigation Bar --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.index') }}" class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">Read Aloud</h1>
                    <p class="text-xs text-gray-500">Speaking & Writing</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg text-sm text-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Look at the text below. In 40 seconds, you must read this text aloud as naturally and clearly as possible.
            </div>
        </div>
    </nav>

    {{-- Main Test Area --}}
    <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8" x-data="{ state: 'prepare', timer: 16, isRecording: false }">
        
        {{-- Question Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-semibold text-gray-800">#{{ str_pad($topicId, 3, '0', STR_PAD_LEFT) }} {{ $topic['title'] }}</h2>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-gray-400 hover:text-teal-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </button>
                <div class="px-4 py-1.5 bg-teal-500 text-white text-sm font-semibold rounded-full shadow-sm">
                    Tested (59)
                </div>
            </div>
        </div>

        {{-- Timer --}}
        <div class="mb-4">
            <p class="text-lg font-medium text-red-500 flex items-center gap-2">
                <span x-text="state === 'prepare' ? 'Prepare:' : 'Recording:'">Prepare:</span>
                <span class="font-mono" x-text="`00:${timer.toString().padStart(2, '0')}`">00:40</span>
            </p>
        </div>

        {{-- Reading Text Container --}}
        <div class="bg-white border-2 border-dashed border-gray-300 rounded-2xl p-6 md:p-10 mb-6 relative">
            <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-serif text-justify">
                {{ $topic['content'] }}
            </p>
            <div class="absolute bottom-4 right-4">
                <button class="w-10 h-10 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center hover:bg-teal-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                </button>
            </div>
        </div>

        {{-- Recording Controls Area --}}
        <div class="bg-gray-100 rounded-2xl p-8 flex flex-col items-center justify-center relative shadow-inner">
            <p class="text-gray-600 font-medium mb-4" x-text="isRecording ? 'Recording in progress...' : 'Click to Start'">Click to Start</p>
            
            <button @click="isRecording = !isRecording" 
                    :class="isRecording ? 'bg-red-500 hover:bg-red-600 animate-pulse' : 'bg-gray-300 hover:bg-gray-400 text-gray-600'" 
                    class="w-16 h-16 rounded-full flex items-center justify-center text-white transition-colors shadow-md">
                <svg x-show="!isRecording" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                <svg x-show="isRecording" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><rect x="6" y="6" width="12" height="12" rx="2"></rect></svg>
            </button>

            <div class="absolute bottom-4 right-6 flex items-center gap-2 text-xs text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Use a headset with inline microphone to get accurate AI scores
            </div>
        </div>
    </main>

    {{-- Bottom Action Bar --}}
    <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button disabled class="px-6 py-2.5 bg-gray-100 text-gray-400 font-medium rounded-lg cursor-not-allowed">
                    Submit
                </button>
                <button class="px-6 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg shadow-sm transition-colors">
                    Re-do
                </button>
                <button class="px-4 py-2.5 bg-white border-2 border-teal-500 text-teal-600 hover:bg-teal-50 font-medium rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Dict Mode
                </button>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-48">
                    <input type="text" placeholder="Question ..." class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <button class="absolute right-0 top-0 bottom-0 px-3 bg-teal-500 hover:bg-teal-600 text-white rounded-r-lg transition-colors flex items-center justify-center">
                        Search
                    </button>
                </div>
                <button class="px-6 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg shadow-sm transition-colors">
                    Previous
                </button>
                <button class="px-6 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg shadow-sm transition-colors">
                    Next
                </button>
            </div>
        </div>
    </footer>

    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
