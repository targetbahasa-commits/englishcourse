import sys

content = """<!DOCTYPE html>
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
            <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.index') }}#topic-{{ $topicId }}" class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#00c5b5]/10 text-[#00c5b5] rounded-lg flex items-center justify-center font-bold">
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
    <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8" x-data="{ state: 'prepare', timer: 35, isRecording: false }">
        
        {{-- Top Cyan Header Banner --}}
        <div class="bg-[#00c5b5] text-white font-bold text-lg px-6 py-3.5 rounded-xl mb-4 shadow-sm">
            Sample Question {{ $topicId }}: {{ $topic['title'] }}
        </div>

        {{-- Status / Timer --}}
        <div class="mb-4">
            <p class="text-base font-bold text-gray-800">
                Beginning in <span class="text-[#00c5b5] font-extrabold" x-text="timer + ' sec'">35 sec</span>
            </p>
        </div>

        {{-- Reading Text Container --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-8 mb-6 shadow-sm">
            <p class="text-base md:text-lg text-gray-800 leading-relaxed font-sans font-normal">
                {{ $topic['content'] }}
            </p>
        </div>

        {{-- Recording Controls Area --}}
        <div class="bg-[#fffcf8] border border-amber-100/80 rounded-xl p-6 md:p-8 mb-6 shadow-sm flex flex-col items-center justify-center relative">
            <p class="text-gray-800 font-bold text-base mb-6 text-center" x-text="isRecording ? 'Recording in progress...' : 'Click to Start'">Click to Start</p>
            
            <div class="w-full max-w-3xl flex items-center gap-4">
                <button @click="isRecording = !isRecording" 
                        class="w-10 h-10 rounded-full bg-[#e87a5d] hover:bg-[#d6684b] text-white flex items-center justify-center shadow transition-all shrink-0 cursor-pointer">
                    <svg x-show="!isRecording" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <svg x-show="isRecording" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><rect x="6" y="6" width="12" height="12" rx="2"></rect></svg>
                </button>
                <span class="text-xs font-mono font-bold text-gray-500 shrink-0">00:00</span>
                <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#00c5b5] rounded-full transition-all duration-300" :style="isRecording ? 'width: 40%' : 'width: 0%'"></div>
                </div>
                <span class="text-xs font-mono font-bold text-gray-500 shrink-0">00:35</span>
            </div>
        </div>

        {{-- Action Pill Buttons --}}
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <button @click="isRecording = !isRecording" class="px-6 py-2.5 bg-[#00c5b5] hover:bg-[#00b3a4] text-white font-bold rounded-full shadow transition-all cursor-pointer">
                Practice with AI Scoring
            </button>
            <button @click="timer = 35; isRecording = false" class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-full transition-all cursor-pointer">
                Restart
            </button>
            @if(Auth::check() && Auth::user()->isAdmin())
            <button onclick="PTEScorePopup.show({ skill: 'Speaking', score: 78, max: 90, breakdown: { 'Content': 82, 'Pronunciation': 75, 'Oral_Fluency': 78 }, feedback: 'Pace was good. Minor hesitation on academic vocabulary.' })" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer" title="Khusus Admin: Preview Hasil Evaluasi AI">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Preview Evaluasi
            </button>
            @endif
        </div>
    </main>

    {{-- Bottom Action Bar & Helpers --}}
    <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.practice', ['id' => max(1, $topicId - 1)]) }}" class="px-6 py-2.5 bg-[#00c5b5] hover:bg-[#00b3a4] text-white font-medium rounded-lg shadow-sm transition-colors {{ $topicId <= 1 ? 'opacity-40 pointer-events-none' : '' }}">
                    Previous
                </a>
                <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.practice', ['id' => min(300, $topicId + 1)]) }}" class="px-6 py-2.5 bg-[#00c5b5] hover:bg-[#00b3a4] text-white font-medium rounded-lg shadow-sm transition-colors {{ $topicId >= 300 ? 'opacity-40 pointer-events-none' : '' }}">
                    Next
                </a>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-48">
                    <input type="text" placeholder="Question ..." class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-[#00c5b5] focus:border-[#00c5b5] text-sm">
                    <button class="absolute right-0 top-0 bottom-0 px-3 bg-[#00c5b5] hover:bg-[#00b3a4] text-white rounded-r-lg transition-colors flex items-center justify-center">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </footer>

    @include('components.pte-score-popup')
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
"""

with open('resources/views/assignments/pte-academic/read-aloud/practice.blade.php', 'w') as f:
    f.write(content)

print('Updated Read Aloud practice view successfully.')
