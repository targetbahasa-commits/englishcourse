{{-- Audio Player Section - Fixed/Floating --}}
@php 
$fixed = $fixed ?? true; 

if (!function_exists('formatTranscriptText')) {
    function formatTranscriptText($text) {
        if (!$text) return '';
        $text = e($text);
        
        $colors = [
            'speaker 1' => 'text-blue-600',
            'speaker 2' => 'text-emerald-600',
            'speaker 3' => 'text-purple-600',
            'speaker 4' => 'text-orange-600',
            'speaker 5' => 'text-pink-600',
            'moderator' => 'text-rose-600',
            'interviewer' => 'text-rose-600',
            'interviewee' => 'text-blue-600',
            'pembicara 1' => 'text-blue-600',
            'pembicara 2' => 'text-emerald-600',
            'pembicara 3' => 'text-purple-600',
        ];
        
        return preg_replace_callback('/^((?:Speaker \d+|Moderator|Pembicara \d+|Interviewer|Interviewee):)(.*)$/mi', function($matches) use ($colors) {
            $speakerFull = $matches[1];
            $lineContent = $matches[2];
            $speakerName = strtolower(trim(rtrim($speakerFull, ':')));
            
            $color = $colors[$speakerName] ?? 'text-indigo-600';
            return '<span class="' . $color . '"><span class="font-bold">' . $speakerFull . '</span>' . $lineContent . '</span>';
        }, $text);
    }
}

if (!function_exists('srtTimeToSeconds')) {
    function srtTimeToSeconds($srtTime) {
        if (empty($srtTime)) return 0;
        if (is_numeric($srtTime)) return (float)$srtTime;
        $srtTime = str_replace(',', '.', $srtTime);
        $parts = explode(':', $srtTime);
        if (count($parts) === 3) {
            return ($parts[0] * 3600) + ($parts[1] * 60) + (float)$parts[2];
        } elseif (count($parts) === 2) {
            return ($parts[0] * 60) + (float)$parts[1];
        }
        return (float)$srtTime;
    }
}
@endphp
<div x-data="mockupAudioPlayer()" @part-changed.window="changePart($event.detail)" class="{{ $fixed ? 'fixed bottom-0 left-0 right-0 z-50 pointer-events-none' : 'relative w-full rounded-b-2xl border-t border-slate-100 bg-white' }}">
    {{-- Transcript Drawer (Collapsible) --}}
    @php $drawerClass = $fixed ? 'mb-0 rounded-b-none border-b-0 pointer-events-auto' : 'mt-4 border-t-0 mb-4'; @endphp
    <div id="transcriptDrawer" style="height: 384px; max-height: 80vh; min-height: 200px;" class="hidden border border-gray-300 rounded-t-2xl mx-auto max-w-7xl {{ $drawerClass }} bg-white overflow-hidden flex flex-col shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)]">
        {{-- Resizer Handle --}}
        <div id="transcriptResizer" class="w-full h-3 cursor-ns-resize bg-gray-100 hover:bg-gray-200 flex items-center justify-center border-b border-gray-300 flex-shrink-0 z-20" style="touch-action: none;">
            <div class="w-12 h-1 bg-gray-400 rounded-full"></div>
        </div>
        <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
            {{-- English Column --}}
            <div class="flex flex-col h-full bg-slate-50">
                <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                    <div class="flex items-center gap-2">
                        <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                        @if(Auth::check() && strtolower(Auth::user()->role) === 'admin' && isset($testId) && isset($edition))
                            <button @click="editTranscript('en', currentPart)" class="ml-2 px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-[11px] font-bold rounded transition-colors flex items-center gap-1 shadow-sm">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </button>
                        @endif
                    </div>
                </div>
                <div class="flex-1 relative overflow-hidden">
                    <div id="transcriptScrollEn" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2" x-data>
                        @for($i = 1; $i <= 4; $i++)
                            <div x-show="currentPart === {{ $i }}" style="display: none;">
                                @php
                                    $transcriptEn = $section->{'transcript_en_' . $i} ?? ($i === 1 ? ($section->transcript_en ?? null) : null);
                                @endphp
                                @if($transcriptEn)
                                    @php
                                        $jsonEn = json_decode($transcriptEn, true);
                                        $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                                    @endphp
                                    @if($isJsonEn)
                                        <div x-show="!isEditing('en', {{ $i }})" class="space-y-4 transcript-container transcript-en" id="transcript-en-{{ $i }}">
                                            @foreach($jsonEn as $block)
                                                @php 
                                                    $start = srtTimeToSeconds($block['start'] ?? 0);
                                                    $end = srtTimeToSeconds($block['end'] ?? 0);
                                                    $speaker = $block['speaker'] ?? '';
                                                    $english = $block['english'] ?? $block['text'] ?? '';
                                                    $lineText = $speaker ? "{$speaker}: {$english}" : $english;
                                                @endphp
                                                <div class="transcript-line transition-colors duration-300 p-2 rounded" data-start="{{ $start }}" data-end="{{ $end }}">
                                                    {!! nl2br(formatTranscriptText($lineText)) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div x-show="!isEditing('en', {{ $i }})">{!! nl2br(formatTranscriptText($transcriptEn)) !!}</div>
                                    @endif
                                @else
                                    <div x-show="!isEditing('en', {{ $i }})" class="text-center text-slate-400 italic mt-4">No transcript available for Part {{ $i }}.</div>
                                @endif

                                @if(Auth::check() && strtolower(Auth::user()->role) === 'admin' && isset($testId) && isset($edition))
                                <div x-show="isEditing('en', {{ $i }})" style="display: none;" class="h-full flex flex-col pt-2 pb-4">
                                    <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" class="flex flex-col h-full gap-2">
                                        @csrf
                                        <input type="hidden" name="part" value="{{ $i }}">
                                        <input type="hidden" name="language" value="en">
                                        <textarea name="srt_content" rows="15" class="w-full flex-1 p-3 border border-gray-300 rounded-lg font-mono text-xs text-gray-700 bg-white focus:ring-2 focus:ring-indigo-500 custom-scrollbar">{{ isset($isJsonEn) && $isJsonEn ? json_encode($jsonEn, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($transcriptEn ?? '') }}</textarea>
                                        <div class="flex gap-2 justify-end mt-2">
                                            <button type="button" @click="cancelEdit('en', {{ $i }})" class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors">Batal</button>
                                            <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            {{-- Indonesian Column --}}
            <div class="flex flex-col h-full bg-gray-50">
                <div class="flex-none px-4 py-2 bg-gray-100 border-b border-gray-200 font-semibold text-gray-800 flex items-center justify-between z-10">
                    <div class="flex items-center gap-2">
                        <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Terjemahan Indonesia
                        
                        @if(Auth::check() && strtolower(Auth::user()->role) === 'admin' && isset($testId) && isset($edition))
                            <button @click="editTranscript('id', currentPart)" class="ml-2 px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-[11px] font-bold rounded transition-colors flex items-center gap-1 shadow-sm">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.transcribe', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" class="ml-2 inline-block" @submit.prevent="if (!hasAudio()) { alert('Silakan upload audio untuk Part ini terlebih dahulu!'); return; } if (confirm('Proses transcribe ulang akan memakan waktu sekitar 1-2 menit. Lanjutkan?')) { $el.submit(); }">
                                @csrf
                                <input type="hidden" name="part" :value="currentPart || 1">
                                <button type="submit" class="px-2 py-1 bg-indigo-600 text-white text-[11px] font-bold rounded hover:bg-indigo-700 transition-colors flex items-center gap-1 shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                    Transcribe
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-medium text-gray-600 hover:text-indigo-600 transition-colors bg-white px-2 py-1 rounded border border-gray-200 shadow-sm" title="Matikan/Hidupkan Autoscroll">
                            <input type="checkbox" id="autoscrollCheckbox" class="w-3.5 h-3.5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer" checked onchange="toggleAutoscroll(this.checked)">
                            <span>Autoscroll</span>
                        </label>
                        <button onclick="toggleTranscriptDrawer()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 relative overflow-hidden">
                    <div id="transcriptScrollId" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-gray-600 custom-scrollbar pr-2" x-data>
                        @for($i = 1; $i <= 4; $i++)
                            <div x-show="currentPart === {{ $i }}" style="display: none;">
                                @php
                                    $transcriptId = $section->{'transcript_id_' . $i} ?? ($i === 1 ? ($section->transcript_id ?? null) : null);
                                @endphp
                                @if($transcriptId)
                                    @php
                                        $jsonId = json_decode($transcriptId, true);
                                        $isJsonId = (json_last_error() === JSON_ERROR_NONE && is_array($jsonId));
                                    @endphp
                                    @if($isJsonId)
                                        <div x-show="!isEditing('id', {{ $i }})" class="space-y-4 transcript-container transcript-id" id="transcript-id-{{ $i }}">
                                            @foreach($jsonId as $block)
                                                @php 
                                                    $start = srtTimeToSeconds($block['start'] ?? 0);
                                                    $end = srtTimeToSeconds($block['end'] ?? 0);
                                                    $speaker = $block['speaker'] ?? '';
                                                    $indonesian = $block['indonesian'] ?? $block['text'] ?? '';
                                                    $lineText = $speaker ? "{$speaker}: {$indonesian}" : $indonesian;
                                                @endphp
                                                <div class="transcript-line transition-colors duration-300 p-2 rounded" data-start="{{ $start }}" data-end="{{ $end }}">
                                                    {!! nl2br(formatTranscriptText($lineText)) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div x-show="!isEditing('id', {{ $i }})">{!! nl2br(formatTranscriptText($transcriptId)) !!}</div>
                                    @endif
                                @else
                                    <div x-show="!isEditing('id', {{ $i }})" class="text-center text-gray-400 italic mt-4">Belum ada terjemahan untuk Part {{ $i }}.</div>
                                @endif

                                @if(Auth::check() && strtolower(Auth::user()->role) === 'admin' && isset($testId) && isset($edition))
                                <div x-show="isEditing('id', {{ $i }})" style="display: none;" class="h-full flex flex-col pt-2 pb-4">
                                    <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" class="flex flex-col h-full gap-2">
                                        @csrf
                                        <input type="hidden" name="part" value="{{ $i }}">
                                        <input type="hidden" name="language" value="id">
                                        <textarea name="srt_content" rows="15" class="w-full flex-1 p-3 border border-gray-300 rounded-lg font-mono text-xs text-gray-700 bg-white focus:ring-2 focus:ring-indigo-500 custom-scrollbar">{{ isset($isJsonId) && $isJsonId ? json_encode($jsonId, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : ($transcriptId ?? '') }}</textarea>
                                        <div class="flex gap-2 justify-end mt-2">
                                            <button type="button" @click="cancelEdit('id', {{ $i }})" class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors">Batal</button>
                                            <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pointer-events-auto w-full {{ $fixed ? 'bg-white shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]' : '' }}">
        <div class="{{ $fixed ? 'max-w-7xl mx-auto' : '' }}">
            <div class="flex items-center gap-4 p-4 bg-white {{ $fixed ? 'border-b-2 border-gray-200' : '' }}">
            <div class="flex items-center gap-3">
                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold" :class="hasAudio() ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200'">
                            <span class="font-bold" x-text="hasAudio() ? '✓' : '✕'"></span> Audio
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold" :class="hasTranscript() ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200'">
                            <span class="font-bold" x-text="hasTranscript() ? '✓' : '✕'"></span> SRT
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold" :class="hasAnswerKey() ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200'">
                            <span class="font-bold" x-text="hasAnswerKey() ? '✓' : '✕'"></span> Key
                        </span>
                    </div>
                @endif
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                </div>
                <span class="text-sm font-bold text-gray-900">Audio Session - Part <span x-text="currentPart"></span></span>
            </div>
            
            {{-- Custom Audio Player with Skip Controls --}}
            <div class="flex-1 flex items-center gap-3 max-w-3xl">
                {{-- Backward 10s Button --}}
                <button type="button" onclick="skipAudio(-10)" 
                        class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex-shrink-0" title="Mundur 10 detik">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                    </svg>
                </button>

                {{-- Play/Pause Button --}}
                <button type="button" id="playPauseBtn" onclick="togglePlayPause()" 
                        class="p-2 bg-black hover:bg-gray-800 rounded-lg transition-colors flex-shrink-0">
                    <svg id="playIcon" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg id="pauseIcon" class="w-6 h-6 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                    </svg>
                </button>

                {{-- Progress Bar Container --}}
                <div class="flex-1 flex flex-col gap-1">
                    {{-- Time Display --}}
                    <div class="flex justify-between text-xs text-gray-600 font-medium">
                        <span id="currentTime">0:00</span>
                        <span id="duration">0:00</span>
                    </div>
                    
                    {{-- Seekable Progress Bar --}}
                    <div class="relative h-2 bg-gray-200 rounded-full cursor-pointer group" id="progressContainer">
                        <div id="progressBar" class="absolute h-full bg-black rounded-full transition-all" style="width: 0%"></div>
                        <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white border-2 border-black rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                    </div>
                </div>

                {{-- Forward 10s Button --}}
                <button type="button" onclick="skipAudio(10)" 
                        class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex-shrink-0" title="Maju 10 detik">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                    </svg>
                </button>

                {{-- Hidden Audio Element --}}
                <audio id="mainAudio" class="hidden" preload="auto">
                    <source id="audioSource" src="" type="audio/mpeg">
                </audio>
            </div>

            {{-- Right Side: Transcript & Admin Controls --}}
            <div class="flex items-center gap-2">
                {{-- Transcript Button --}}
                <button onclick="toggleTranscriptDrawer()" class="px-3 py-2 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center gap-2 font-semibold shadow-sm text-sm border border-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden md:inline">Transcript</span>
                </button>

                {{-- Admin Upload Audio Button --}}
                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <div class="flex gap-2 border-l border-gray-200 pl-2">
                        <button type="button" 
                                onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" 
                                class="p-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md relative z-10 flex-shrink-0"
                                title="Upload SRT">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                        
                        <button type="button" 
                                onclick="document.getElementById('uploadAudioModal').classList.remove('hidden');" 
                                class="p-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md relative z-10 flex-shrink-0"
                                title="Upload Audio">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </button>
                        
                        <button type="button" 
                                onclick="document.getElementById('uploadAnswerKeyModal').classList.remove('hidden');" 
                                class="p-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md relative z-10 flex-shrink-0"
                                title="Upload Kunci">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>


{{-- Spacer --}}
@if($fixed)
<div class="h-20 mb-8 pointer-events-none"></div>
@endif

@if(Auth::check() && strtolower(Auth::user()->role) === 'admin')
@if(isset($testId) && isset($edition))
    {{-- Upload SRT Modal --}}
    <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload SRT Transcript</h3>
                <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Part</label>
                    <select name="part" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none" x-data :value="window.mockupAudioPlayerContext?.currentPart || 1">
                        <option value="1">Part 1</option>
                        <option value="2">Part 2</option>
                        <option value="3">Part 3</option>
                        <option value="4">Part 4</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="en" class="text-indigo-600 focus:ring-indigo-500" checked>
                            <span class="text-gray-700">English 🇺🇸</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="id" class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">Indonesian 🇮🇩</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SRT File (.srt - Max 2MB)</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                        <input type="file" id="srtFileInput" name="srt_file" accept=".srt" class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0] ? this.files[0].name : 'Click to select file'">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                    </div>
                </div>
                <div class="relative py-2 hidden md:block">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center"><span class="px-2 bg-white text-xs text-gray-500 font-semibold uppercase">Or Paste Text</span></div>
                </div>
                <div class="hidden md:block">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Paste SRT Content</label>
                    <textarea name="srt_content" rows="3" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1\n00:00:10,000 --> 00:00:15,000\nStart translating here..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors" :disabled="loading">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors shadow-sm disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2" :disabled="loading">
                        <span x-show="!loading">Upload & Parse</span>
                        <span x-show="loading">Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Audio Modal --}}
    <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload Audio File (Auto Whisper)</h3>
                <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Part</label>
                    <select name="part" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none" x-data :value="window.mockupAudioPlayerContext?.currentPart || 1">
                        <option value="1">Part 1</option>
                        <option value="2">Part 2</option>
                        <option value="3">Part 3</option>
                        <option value="4">Part 4</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Audio File (MP3, WAV, OGG - Max 50MB)</label>
                    <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    
                    <div class="mt-4 flex items-center gap-2 bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                        <input type="checkbox" id="auto_transcribe" name="auto_transcribe" value="1" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                        <label for="auto_transcribe" class="text-sm text-indigo-900 font-medium cursor-pointer">Auto Transcribe & Translate dengan AI (Whisper)</label>
                    </div>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors" :disabled="loading">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2" :disabled="loading">
                        <span x-show="!loading">Submit</span>
                        <span x-show="loading">Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Answer Key Modal --}}
    <div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload Answer Key</h3>
                <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" class="space-y-4" x-data="{ loading: false, selectedPart: window.mockupAudioPlayerContext?.currentPart || 1 }" @submit="loading = true">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Part</label>
                    <select name="part" x-model.number="selectedPart" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none mb-4">
                        <option value="1">Part 1</option>
                        <option value="2">Part 2</option>
                        <option value="3">Part 3</option>
                        <option value="4">Part 4</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key Content</label>
                    <textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-teal-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1. A\n2. B..." x-model="window.mockupAudioPlayerContext.audioData[selectedPart].answerKey"></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors" :disabled="loading">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-sm disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2" :disabled="loading">
                        <span x-show="!loading">Save Key</span>
                        <span x-show="loading">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endif
@endif

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mockupAudioPlayer', () => ({
            currentPart: 1,
            editingState: {
                en: { 1: false, 2: false, 3: false, 4: false },
                id: { 1: false, 2: false, 3: false, 4: false },
            },
            isEditing(lang, part) {
                return this.editingState[lang][part];
            },
            editTranscript(lang, part) {
                this.editingState[lang][part] = true;
            },
            cancelEdit(lang, part) {
                this.editingState[lang][part] = false;
            },
            audioData: {
                @for($i = 1; $i <= 4; $i++)
                @php
                    $aud = isset($section) ? ($section->{'audio_file_'.$i} ?? ($i === 1 ? ($section->audio_file ?? null) : null)) : null;
                    $tEn = isset($section) ? ($section->{'transcript_en_'.$i} ?? ($i === 1 ? ($section->transcript_en ?? null) : null)) : null;
                    $tId = isset($section) ? ($section->{'transcript_id_'.$i} ?? ($i === 1 ? ($section->transcript_id ?? null) : null)) : null;
                    $ansKey = isset($section) ? ($section->{'answer_key_'.$i} ?? null) : null;
                @endphp
                {{ $i }}: {
                    url: '{{ $aud ? asset($aud) : "" }}',
                    hasAudio: {{ filled($aud) ? 'true' : 'false' }},
                    hasTranscript: {{ (filled($tEn) || filled($tId)) ? 'true' : 'false' }},
                    answerKey: {!! json_encode($ansKey) !!}
                },
                @endfor
            },
            init() {
                window.mockupAudioPlayerContext = this;
                this.changePart(1);
            },
            changePart(part) {
                this.currentPart = part;
                const audio = document.getElementById('mainAudio');
                const source = document.getElementById('audioSource');
                const isPlaying = audio && !audio.paused;
                
                if (audio && source) {
                    source.src = this.audioData[part]?.url || '';
                    audio.load();
                    
                    document.getElementById('currentTime').textContent = '0:00';
                    document.getElementById('duration').textContent = '0:00';
                    document.getElementById('progressBar').style.width = '0%';
                    document.getElementById('progressHandle').style.left = '0%';
                    
                    if (isPlaying && source.src) {
                        audio.play().catch(e => console.log('Autoplay prevented', e));
                    } else {
                        document.getElementById('playIcon').classList.remove('hidden');
                        document.getElementById('pauseIcon').classList.add('hidden');
                    }
                }
            },
            hasAudio() {
                return this.audioData[this.currentPart]?.hasAudio;
            },
            hasTranscript() {
                return this.audioData[this.currentPart]?.hasTranscript;
            },
            hasAnswerKey() {
                return !!this.audioData[this.currentPart]?.answerKey;
            }
        }));
    });

    document.addEventListener('DOMContentLoaded', function() {
        const audio = document.getElementById('mainAudio');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const progressContainer = document.getElementById('progressContainer');
        const currentTimeDisplay = document.getElementById('currentTime');
        const durationDisplay = document.getElementById('duration');

        if (!audio || !progressContainer) return;

        let isDragging = false;

        function formatTime(seconds) {
            if (isNaN(seconds) || !isFinite(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        window.togglePlayPause = function() {
            if (audio.paused) {
                const source = document.getElementById('audioSource');
                const hasValidSource = source && source.getAttribute('src') && source.getAttribute('src') !== '';
                if (hasValidSource) {
                    audio.play().catch(e => console.error(e));
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    alert('Audio belum diupload untuk Part ini.');
                }
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        };

        window.skipAudio = function(seconds) {
            if (audio && audio.duration) {
                audio.currentTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
            }
        };

        function seekAudio(event) {
            if (!audio.duration) return;
            const rect = progressContainer.getBoundingClientRect();
            const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
            const percentage = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
            audio.currentTime = percentage * audio.duration;
        }

        progressContainer.addEventListener('mousedown', (e) => { isDragging = true; seekAudio(e); e.preventDefault(); });
        document.addEventListener('mousemove', (e) => { if (isDragging) seekAudio(e); });
        document.addEventListener('mouseup', () => { isDragging = false; });
        
        progressContainer.addEventListener('touchstart', (e) => { isDragging = true; seekAudio(e.touches[0]); e.preventDefault(); });
        document.addEventListener('touchmove', (e) => { if (isDragging) seekAudio(e.touches[0]); });
        document.addEventListener('touchend', () => { isDragging = false; });

        audio.addEventListener('timeupdate', () => {
            if (audio.duration && !isDragging) {
                const percentage = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = percentage + '%';
                progressHandle.style.left = percentage + '%';
                currentTimeDisplay.textContent = formatTime(audio.currentTime);
            }
        });

        audio.addEventListener('loadedmetadata', () => { durationDisplay.textContent = formatTime(audio.duration); });
        audio.addEventListener('ended', () => { playIcon.classList.remove('hidden'); pauseIcon.classList.add('hidden'); });
        
        window.toggleTranscriptDrawer = function() {
            const transcriptDrawer = document.getElementById('transcriptDrawer');
            if (transcriptDrawer) transcriptDrawer.classList.toggle('hidden');
        };

        // Resizer logic
        const resizer = document.getElementById('transcriptResizer');
        const drawer = document.getElementById('transcriptDrawer');
        let isResizing = false;
        let startY;
        let startHeight;

        if (resizer && drawer) {
            const initResize = (e) => {
                isResizing = true;
                startY = e.clientY || (e.touches && e.touches[0].clientY);
                startHeight = parseInt(document.defaultView.getComputedStyle(drawer).height, 10);
                document.body.style.userSelect = 'none'; // Prevent text selection
                e.preventDefault();
            };

            const doResize = (e) => {
                if (!isResizing) return;
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);
                const dy = startY - clientY; // upward drag means higher drawer
                const newHeight = startHeight + dy;
                // Constraints
                if (newHeight >= 200 && newHeight <= window.innerHeight * 0.8) {
                    drawer.style.height = `${newHeight}px`;
                }
            };

            const stopResize = () => {
                isResizing = false;
                document.body.style.userSelect = '';
            };

            resizer.addEventListener('mousedown', initResize);
            document.addEventListener('mousemove', doResize);
            document.addEventListener('mouseup', stopResize);

            resizer.addEventListener('touchstart', initResize, {passive: false});
            document.addEventListener('touchmove', doResize, {passive: false});
            document.addEventListener('touchend', stopResize);
        }
    });
</script>
