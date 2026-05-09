{{-- Audio Player Section - Fixed at top (respects sidebar on desktop) --}}
@php
    // Pastikan $audioQuestions selalu terdefinisi agar tidak error di bagian lain
    if (!isset($audioQuestions)) {
        $audioQuestions = $listeningQuestions ?? $questions ?? [];
    }
    $audioQuestions = collect($audioQuestions);
    $firstAudioQuestion = $audioQuestions->first();
@endphp
<div class="fixed top-0 left-0 right-0 md:left-64 z-40 bg-gradient-to-r from-blue-50 via-indigo-50 to-violet-50 shadow-lg border-b border-indigo-200">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap lg:flex-nowrap items-center gap-2 md:gap-4 p-2 md:p-4 bg-white/85 backdrop-blur border-b border-indigo-100">
            {{-- Status Indicators (Paling Kiri) --}}
            @if(Auth::user()->isAdmin())
                @php
                    $statusAudio = false;
                    $statusTranscript = false;
                    
                    if (isset($firstQ) && $firstQ) {
                        $statusAudio = filled($firstQ->audio_file ?? null);
                        $statusTranscript = filled($firstQ->transcript_en ?? null) || filled($firstQ->transcript_id ?? null);
                    } elseif ($firstAudioQuestion) {
                        $statusAudio = filled(data_get($firstAudioQuestion, 'audio_file'));
                        $statusTranscript = filled(data_get($firstAudioQuestion, 'transcript_en')) || filled(data_get($firstAudioQuestion, 'transcript_id'));
                    }
                @endphp
                <div class="flex items-center gap-1 flex-shrink-0">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold {{ $statusAudio ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                        <span class="font-bold">{{ $statusAudio ? '✓' : '✕' }}</span> Audio
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold {{ $statusTranscript ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                        <span class="font-bold">{{ $statusTranscript ? '✓' : '✕' }}</span> SRT
                    </span>
                </div>
            @endif

            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-9 h-9 md:w-10 md:h-10 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path></svg>
                </div>
                <span class="text-sm md:text-lg font-bold text-indigo-900 whitespace-nowrap">Audio Session - Mock Test</span>
            </div>
            
            {{-- Custom Audio Player with Skip Controls --}}
            <div class="flex-1 min-w-[220px] flex items-center gap-1.5 md:gap-3 max-w-3xl">
                {{-- Backward 10s Button --}}
                <button type="button" onclick="skipAudio(-10)" 
                        class="p-1.5 md:p-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Mundur 10 detik">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                    </svg>
                </button>

                {{-- Play/Pause Button --}}
                <button type="button" id="playPauseBtn" onclick="togglePlayPause()" 
                    class="p-1.5 md:p-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg transition-colors flex-shrink-0 border border-indigo-600">
                    <svg id="playIcon" class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg id="pauseIcon" class="w-5 h-5 md:w-6 md:h-6 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                    </svg>
                </button>

                {{-- Progress Bar Container --}}
                <div class="flex-1 flex flex-col gap-1">
                    {{-- Time Display --}}
                    <div class="flex justify-between text-xs text-indigo-700 font-medium">
                        <span id="currentTime">0:00</span>
                        <span id="duration">0:00</span>
                    </div>
                    
                    {{-- Seekable Progress Bar --}}
                    <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                        <div id="progressBar" class="absolute h-full bg-gradient-to-r from-indigo-600 to-violet-600 rounded-full transition-all" style="width: 0%"></div>
                        <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                    </div>
                </div>

                {{-- Forward 10s Button --}}
                <button type="button" onclick="skipAudio(10)" 
                        class="p-1.5 md:p-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Maju 10 detik">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                    </svg>
                </button>

                {{-- Transcript Toggle Button --}}
                <button type="button" onclick="toggleTranscriptDrawer()" 
                        class="p-1.5 md:p-2 bg-yellow-100 border border-yellow-300 hover:bg-yellow-200 rounded-lg transition-colors flex-shrink-0 flex items-center gap-1.5 md:gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-yellow-800 group-hover:text-yellow-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs font-bold text-yellow-900 hidden sm:inline">Transcript</span>
                </button>

                {{-- Hidden Audio Element --}}
                <audio id="mainAudio" class="hidden" preload="auto">
                    @php
                        // Pilih file audio utama berdasarkan paket
                        $mainAudioFile = '';
                        $firstQ = null;
                        if (isset($packageNumber)) {
                            $firstQ = \App\Models\ToeflMockupQuestion::where('package_number', $packageNumber)->where('section', 'listening')->first();
                            if ($firstQ && $firstQ->audio_file) {
                                $mainAudioFile = asset($firstQ->audio_file);
                            }
                        } elseif ($firstAudioQuestion && data_get($firstAudioQuestion, 'audio_file')) {
                            $mainAudioFile = asset(data_get($firstAudioQuestion, 'audio_file'));
                        }
                    @endphp
                    <source src="{{ $mainAudioFile }}" type="audio/mpeg">
                </audio>
            </div>

            {{-- Admin/Teacher Upload Audio Buttons --}}
            @if(Auth::user()->isAdmin())
                <div class="w-full lg:w-auto flex flex-wrap justify-end items-center gap-2">
                    {{-- Upload Buttons --}}
                    <button type="button" 
                            onclick="document.getElementById('uploadSrtModal').classList.remove('hidden'); document.getElementById('uploadSrtModal').classList.add('flex')" 
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Upload SRT
                    </button>
                    
                    <button type="button" 
                            onclick="console.log('Upload button clicked'); document.getElementById('uploadAudioModal').classList.remove('hidden'); document.getElementById('uploadAudioModal').classList.add('flex');" 
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Audio
                    </button>

                    <button type="button"
                            onclick="document.getElementById('chooseAudioModal').classList.remove('hidden'); document.getElementById('chooseAudioModal').classList.add('flex'); setTimeout(function(){ if(typeof audioFileManager !== 'undefined') audioFileManager.init(); }, 100);"
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-white text-indigo-800 font-semibold rounded-lg hover:bg-indigo-50 border border-indigo-200 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
                        </svg>
                        Choose Audio
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Floating Transcript Boxes (Glass-morphism) - Positioned above content --}}
<div id="transcriptDrawer" class="hidden fixed top-20 left-0 right-0 md:left-64 z-30 px-4 md:px-6 transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-end mb-2 gap-2">
        {{-- Layout Toggle Button --}}
        <button onclick="toggleTranscriptLayout()" 
            class="px-3 py-1.5 bg-white border border-indigo-200 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-50 transition-colors flex items-center gap-1"
                title="Toggle layout">
            <svg id="layoutIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"></path>
            </svg>
        </button>
        
        {{-- Position Toggle Button (appears only in vertical mode) --}}
        <button id="positionToggleBtn" onclick="toggleTranscriptPosition()" 
            class="hidden px-3 py-1.5 bg-white border border-indigo-200 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-50 transition-colors items-center gap-1"
                title="Toggle position">
            <svg id="positionIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
    </div>
    <div id="transcriptGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-full transition-all duration-300">
    
        {{-- English Transcript Box --}}
        <div class="bg-gradient-to-b from-indigo-50 to-blue-50 border border-indigo-200 rounded-2xl shadow-xl overflow-hidden flex flex-col h-96">
            <div class="flex-none px-5 py-3 bg-gradient-to-r from-indigo-100 to-blue-100 border-b border-indigo-200 font-semibold text-indigo-900 flex items-center justify-between gap-2 z-10">
                <div class="flex items-center gap-2">
                    <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm w-5 h-4">
                    <span>English Script</span>
                </div>
                <div class="flex items-center gap-1" title="Navigasi segmen transkrip">
                    <button type="button" onclick="stepTranscriptSegment(-1)" class="w-6 h-6 flex items-center justify-center bg-white hover:bg-stone-100 rounded text-zinc-700 font-bold text-base border border-stone-300 transition-colors leading-none" title="Segmen sebelumnya">&minus;</button>
                    <button type="button" id="telepromptPlayBtn" onclick="toggleTeleprompter()" class="w-7 h-7 flex items-center justify-center bg-zinc-900 hover:bg-black rounded text-white transition-colors shadow-sm" title="Play/Pause gulir otomatis">
                        <svg id="telepromptPlayIcon" class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <svg id="telepromptPauseIcon" class="w-3 h-3 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                    </button>
                    <button type="button" onclick="stepTranscriptSegment(1)" class="w-6 h-6 flex items-center justify-center bg-white hover:bg-stone-100 rounded text-zinc-700 font-bold text-base border border-stone-300 transition-colors leading-none" title="Segmen berikutnya">+</button>
                </div>
            </div>
            <div class="flex-1 relative overflow-hidden">
                <div class="absolute inset-0 m-3 rounded-xl bg-white p-4 overflow-y-scroll overflow-x-hidden text-sm text-slate-900 leading-7 custom-scrollbar shadow-md pr-2 border border-indigo-100">
                    @php
                        // Pilih transcript English & Indonesia berdasarkan paket
                        $transcriptEn = '';
                        $transcriptId = '';
                        if (isset($packageNumber) && isset($firstQ)) {
                            $transcriptEn = $firstQ->transcript_en ?? '';
                            $transcriptId = $firstQ->transcript_id ?? '';
                        } elseif ($firstAudioQuestion) {
                            $transcriptEn = data_get($firstAudioQuestion, 'transcript_en', '');
                            $transcriptId = data_get($firstAudioQuestion, 'transcript_id', '');
                        }
                        $jsonEn = json_decode($transcriptEn, true);
                        $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                        $plainEnSegments = collect(preg_split('/\R+/', trim($transcriptEn ?? '')))
                            ->map(fn ($line) => trim($line))
                            ->filter()
                            ->values();
                    @endphp
                    @if($transcriptEn)
                        @if($isJsonEn)
                            <div id="transcript-en-content" class="space-y-2">
                                @foreach($jsonEn as $block)
                                    <button
                                        type="button"
                                        class="transcript-segment block w-full rounded-xl px-3 py-2 text-left transition-all duration-200 hover:bg-amber-100/80"
                                        data-transcript-group="en"
                                        data-start="{{ $block['start'] }}"
                                        data-end="{{ $block['end'] }}"
                                        onclick="jumpToTranscriptSegment(this)">
                                        {{ $block['text'] }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div id="transcript-en-content" class="space-y-2">
                                @foreach($plainEnSegments as $segment)
                                    <button
                                        type="button"
                                        class="transcript-segment block w-full rounded-xl px-3 py-2 text-left transition-all duration-200 hover:bg-amber-100/80"
                                        data-transcript-group="en"
                                        data-approx="true"
                                        onclick="jumpToTranscriptSegment(this)">
                                        {{ $segment }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center text-slate-500 italic mt-4">No transcript available.</div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Indonesian Transcript Box --}}
        <div class="bg-gradient-to-b from-violet-50 to-purple-50 border border-violet-200 rounded-2xl shadow-xl overflow-hidden flex flex-col h-96">
            <div class="flex-none px-5 py-3 bg-gradient-to-r from-violet-100 to-purple-100 border-b border-violet-200 font-semibold text-violet-900 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm w-5 h-4"> 
                    <span>Terjemahan Indonesia</span>
                </div>
                <button onclick="toggleTranscriptDrawer()" class="text-violet-700 hover:text-violet-900 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 relative overflow-hidden">
                <div class="absolute inset-0 m-3 rounded-xl bg-white p-4 overflow-y-scroll overflow-x-hidden text-sm text-slate-900 leading-7 custom-scrollbar shadow-md pr-2 border border-violet-100">
                    @if($transcriptId)
                        @php
                            $jsonId = json_decode($transcriptId, true);
                            $isJsonId = (json_last_error() === JSON_ERROR_NONE && is_array($jsonId));
                            $plainIdSegments = collect(preg_split('/\R+/', trim($transcriptId ?? '')))
                                ->map(fn ($line) => trim($line))
                                ->filter()
                                ->values();
                        @endphp
                        @if($isJsonId)
                            <div id="transcript-id-content" class="space-y-2">
                                @foreach($jsonId as $block)
                                    <button
                                        type="button"
                                        class="transcript-segment block w-full rounded-xl px-3 py-2 text-left transition-all duration-200 hover:bg-amber-100/80"
                                        data-transcript-group="id"
                                        data-start="{{ $block['start'] }}"
                                        data-end="{{ $block['end'] }}"
                                        onclick="jumpToTranscriptSegment(this)">
                                        {{ $block['text'] }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div id="transcript-id-content" class="space-y-2">
                                @foreach($plainIdSegments as $segment)
                                    <button
                                        type="button"
                                        class="transcript-segment block w-full rounded-xl px-3 py-2 text-left transition-all duration-200 hover:bg-amber-100/80"
                                        data-transcript-group="id"
                                        data-approx="true"
                                        onclick="jumpToTranscriptSegment(this)">
                                        {{ $segment }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center text-slate-500 italic mt-4">Belum ada terjemahan.</div>
                    @endif
                </div>
            </div>
        </div>
    
    </div>
</div>

<script>
let transcriptLayoutMode = 'horizontal'; // 'horizontal' or 'vertical'
let transcriptVerticalPosition = 'left'; // 'left' or 'right' (only used in vertical mode)

function toggleTranscriptLayout() {
    const grid = document.getElementById('transcriptGrid');
    const icon = document.getElementById('layoutIcon');
    const positionBtn = document.getElementById('positionToggleBtn');
    const drawer = document.getElementById('transcriptDrawer');
    
    if (transcriptLayoutMode === 'horizontal') {
        // Switch to vertical (stack)
        grid.classList.remove('grid-cols-1', 'md:grid-cols-2');
        grid.classList.add('grid-cols-1');
        transcriptLayoutMode = 'vertical';
        
        // Show position toggle button
        positionBtn.classList.remove('hidden');
        positionBtn.classList.add('flex');
        
        // Update drawer positioning for vertical
        updateVerticalPosition();
        
        // Update icon to show columns (indicating can switch back to horizontal)
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v14a2 2 0 002 2h4m0-21h10a2 2 0 012 2v14a2 2 0 01-2 2h-10m0-21v21m0-21H9"></path>';
    } else {
        // Switch to horizontal (side-by-side)
        grid.classList.remove('grid-cols-1');
        grid.classList.add('grid-cols-1', 'md:grid-cols-2');
        transcriptLayoutMode = 'horizontal';
        
        // Hide position toggle button
        positionBtn.classList.add('hidden');
        positionBtn.classList.remove('flex');
        
        // Reset drawer positioning (full content width)
        drawer.classList.remove('left-auto', 'right-auto', 'max-w-sm', 'max-w-none', 'md:w-1/2');
        drawer.classList.add('left-0', 'right-0', 'md:left-64');
        
        // Update icon to show split (indicating can switch to vertical)
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"></path>';
    }
}

function updateVerticalPosition() {
    const drawer = document.getElementById('transcriptDrawer');
    const positionIcon = document.getElementById('positionIcon');
    
    // Keep panel wide in vertical mode; only move side (left/right)
    drawer.classList.remove('left-0', 'right-0', 'left-auto', 'right-auto', 'max-w-sm');
    drawer.classList.add('max-w-none', 'md:w-1/2');
    
    if (transcriptVerticalPosition === 'left') {
        drawer.classList.add('left-0', 'right-auto', 'md:left-64');
        // Icon points right (can switch to right)
        positionIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
    } else {
        drawer.classList.remove('md:left-64');
        drawer.classList.add('left-auto', 'right-0');
        // Icon points left (can switch to left)
        positionIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>';
    }
}

function toggleTranscriptPosition() {
    if (transcriptLayoutMode === 'vertical') {
        transcriptVerticalPosition = transcriptVerticalPosition === 'left' ? 'right' : 'left';
        updateVerticalPosition();
    }
}
</script>
