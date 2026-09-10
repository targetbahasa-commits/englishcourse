{{-- Audio Player - Practice Pages (Colored Indigo/Purple Theme) --}}
{{-- Variables expected:
     $section       (IeltsSection model — has audio_file, transcript_en, transcript_id, answer_key)
     $meeting       (Meeting model)
     $set           (int — section/part number)
     $fixed         (bool, default true)
--}}
@php
$fixed   = $fixed ?? true;
$testId  = $testId ?? request()->route('test') ?? request()->route('testId') ?? request()->get('testId');

$_audioUrl    = isset($section) && filled($section->audio_file) ? asset($section->audio_file) : null;

if (!$_audioUrl && isset($set) && filled($testId)) {
    $relAudio = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $testId . '.mp3';
    $pathA = public_path($relAudio);
    $pathB = public_path('public/' . $relAudio);
    $pathC = base_path('public/' . $relAudio);
    $pathD = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relAudio;
    if (file_exists($pathA) || file_exists($pathB) || file_exists($pathC) || file_exists($pathD)) {
        $_audioUrl = asset($relAudio);
    }
}

$_hasAudio    = (bool) $_audioUrl;
$_hasTranscript = isset($section) && (filled($section->transcript_en) || filled($section->transcript_id));
$_hasKey      = (isset($section) && filled($section->answer_key)) ||
                (isset($set) && filled($testId) && view()->exists('assignments.ielts.listening.answers.part' . $set . '.test' . $testId));

if (!$_hasTranscript && isset($set) && filled($testId)) {
    $relSrt = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $testId . '.srt';
    $pathSrtA = public_path($relSrt);
    $pathSrtB = public_path('public/' . $relSrt);
    $pathSrtC = base_path('public/' . $relSrt);
    $pathSrtD = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relSrt;
    if (file_exists($pathSrtA) || file_exists($pathSrtB) || file_exists($pathSrtC) || file_exists($pathSrtD) || view()->exists('assignments.ielts.listening.transcripts.part' . $set . '.test' . $testId)) {
        $_hasTranscript = true;
    }
}

if (!function_exists('formatTranscriptText')) {
    function formatTranscriptText($text) {
        if (!$text) return '';
        $text = e($text);
        $colors = [
            'speaker 1' => 'text-blue-600','speaker 2' => 'text-emerald-600','speaker 3' => 'text-purple-600',
            'speaker 4' => 'text-orange-600','speaker 5' => 'text-pink-600','moderator' => 'text-rose-600',
            'interviewer' => 'text-rose-600','interviewee' => 'text-blue-600',
            'pembicara 1' => 'text-blue-600','pembicara 2' => 'text-emerald-600','pembicara 3' => 'text-purple-600',
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
        if (count($parts) === 3) return ($parts[0] * 3600) + ($parts[1] * 60) + (float)$parts[2];
        if (count($parts) === 2) return ($parts[0] * 60) + (float)$parts[1];
        return (float)$srtTime;
    }
}

if (!function_exists('parseSrtToBlocks')) {
    function parseSrtToBlocks($srtContent) {
        if (!$srtContent) return [];
        $blocks = [];
        $rawBlocks = explode("\n\n", str_replace("\r\n", "\n", trim($srtContent)));
        foreach ($rawBlocks as $b) {
            $lines = array_filter(array_map('trim', explode("\n", trim($b))));
            if (count($lines) >= 2) {
                $timeLine = null;
                $textLines = [];
                foreach ($lines as $l) {
                    if (str_contains($l, '-->')) {
                        $timeLine = $l;
                    } elseif ($timeLine !== null) {
                        $textLines[] = $l;
                    }
                }
                if ($timeLine) {
                    $times = explode('-->', $timeLine);
                    $startStr = trim($times[0]);
                    $endStr = trim($times[1] ?? $times[0]);
                    $text = implode(' ', $textLines);
                    $blocks[] = [
                        'start' => $startStr,
                        'end' => $endStr,
                        'english' => $text,
                        'speaker' => '',
                    ];
                }
            }
        }
        return $blocks;
    }
}
@endphp

<div x-data="practiceAudioPlayer()" class="{{ $fixed ? 'fixed bottom-0 left-0 right-0 z-50 pointer-events-none' : 'relative w-full' }}">

    {{-- Transcript Drawer --}}
    <div id="transcriptDrawer" style="height: 384px; max-height: 80vh; min-height: 200px;"
         class="hidden border border-gray-300 rounded-t-2xl mx-auto max-w-7xl mb-0 rounded-b-none border-b-0 pointer-events-auto bg-white overflow-hidden flex flex-col shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)]">
        <div id="transcriptResizer" class="w-full h-3 cursor-ns-resize bg-white hover:bg-white flex items-center justify-center border-b border-gray-300 flex-shrink-0 z-20" style="touch-action: none;">
            <div class="w-12 h-1 bg-indigo-300 rounded-full"></div>
        </div>
        <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
            {{-- English Column --}}
            <div class="flex flex-col h-full bg-white">
                <div class="flex-none px-4 py-2 bg-white border-b border-indigo-100 font-semibold text-indigo-900 flex items-center justify-between z-10">
                    <div class="flex items-center gap-2">
                        <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                    </div>
                </div>
                <div class="flex-1 relative overflow-hidden">
                    <div id="transcriptScrollEn" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                        @php
                            $transcriptEn = $section->transcript_en ?? null;
                            $jsonEn = $transcriptEn ? json_decode($transcriptEn, true) : null;
                            $isJsonEn = $jsonEn && json_last_error() === JSON_ERROR_NONE && is_array($jsonEn);

                            if (!$transcriptEn && isset($set) && filled($testId)) {
                                $relSrt = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $testId . '.srt';
                                $pathSrtA = public_path($relSrt);
                                $pathSrtB = public_path('public/' . $relSrt);
                                $pathSrtC = base_path('public/' . $relSrt);
                                $pathSrtD = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relSrt;
                                $foundSrt = null;
                                if (file_exists($pathSrtA)) $foundSrt = $pathSrtA;
                                elseif (file_exists($pathSrtB)) $foundSrt = $pathSrtB;
                                elseif (file_exists($pathSrtC)) $foundSrt = $pathSrtC;
                                elseif (file_exists($pathSrtD)) $foundSrt = $pathSrtD;

                                if ($foundSrt) {
                                    $srtRaw = @file_get_contents($foundSrt);
                                    $parsedBlocks = parseSrtToBlocks($srtRaw);
                                    if (!empty($parsedBlocks)) {
                                        $jsonEn = $parsedBlocks;
                                        $isJsonEn = true;
                                        $transcriptEn = true;
                                    }
                                }
                            }
                        @endphp
                        @if($transcriptEn)
                            @if($isJsonEn)
                                <div class="space-y-4 transcript-container transcript-en" id="transcript-en-1">
                                    @foreach($jsonEn as $block)
                                        @php
                                            $start = srtTimeToSeconds($block['start'] ?? 0);
                                            $end   = srtTimeToSeconds($block['end']   ?? 0);
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
                                <div>{!! nl2br(formatTranscriptText($transcriptEn)) !!}</div>
                            @endif
                        @else
                            <div class="text-center text-slate-400 italic mt-4">No transcript available.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Indonesian Column --}}
            <div class="flex flex-col h-full bg-white">
                <div class="flex-none px-4 py-2 bg-white border-b border-purple-100 font-semibold text-purple-900 flex items-center justify-between z-10">
                    <div class="flex items-center gap-2">
                        <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Terjemahan Indonesia
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-medium text-purple-700 hover:text-indigo-600 transition-colors bg-white px-2 py-1 rounded border border-purple-200 shadow-sm" title="Autoscroll">
                            <input type="checkbox" id="autoscrollCheckbox" class="w-3.5 h-3.5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer" checked onchange="toggleAutoscroll(this.checked)">
                            <span>Autoscroll</span>
                        </label>
                        <button onclick="toggleTranscriptDrawer()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 relative overflow-hidden">
                    <div id="transcriptScrollId" class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-gray-600 custom-scrollbar pr-2">
                        @php
                            $transcriptId = isset($section) && $section ? ($section->transcript_id ?? null) : null;
                            $jsonId = $transcriptId ? json_decode($transcriptId, true) : null;
                            $isJsonId = $jsonId && json_last_error() === JSON_ERROR_NONE && is_array($jsonId);

                            if (!$transcriptId && isset($set) && filled($testId)) {
                                $relSrtId = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $testId . '.id.srt';
                                $pathSrtIdA = public_path($relSrtId);
                                $pathSrtIdB = public_path('public/' . $relSrtId);
                                $pathSrtIdC = base_path('public/' . $relSrtId);
                                $pathSrtIdD = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relSrtId;
                                $foundSrtId = null;
                                if (file_exists($pathSrtIdA)) $foundSrtId = $pathSrtIdA;
                                elseif (file_exists($pathSrtIdB)) $foundSrtId = $pathSrtIdB;
                                elseif (file_exists($pathSrtIdC)) $foundSrtId = $pathSrtIdC;
                                elseif (file_exists($pathSrtIdD)) $foundSrtId = $pathSrtIdD;

                                if ($foundSrtId) {
                                    $srtIdRaw = @file_get_contents($foundSrtId);
                                    $parsedBlocksId = parseSrtToBlocks($srtIdRaw);
                                    if (!empty($parsedBlocksId)) {
                                        foreach ($parsedBlocksId as &$bId) {
                                            $bId['indonesian'] = $bId['english'];
                                        }
                                        $jsonId = $parsedBlocksId;
                                        $isJsonId = true;
                                        $transcriptId = true;
                                    }
                                }
                            }
                        @endphp
                        @if($transcriptId)
                            @if($isJsonId)
                                <div class="space-y-4 transcript-container transcript-id" id="transcript-id-1">
                                    @foreach($jsonId as $block)
                                        @php
                                            $start = srtTimeToSeconds($block['start'] ?? 0);
                                            $end   = srtTimeToSeconds($block['end']   ?? 0);
                                            $speaker = $block['speaker'] ?? '';
                                            $indonesian = $block['indonesian'] ?? $block['text'] ?? $block['english'] ?? '';
                                            $lineText = $speaker ? "{$speaker}: {$indonesian}" : $indonesian;
                                        @endphp
                                        <div class="transcript-line transition-colors duration-300 p-2 rounded" data-start="{{ $start }}" data-end="{{ $end }}">
                                            {!! nl2br(formatTranscriptText($lineText)) !!}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div>{!! nl2br(formatTranscriptText($transcriptId)) !!}</div>
                            @endif
                        @else
                            <div class="text-center text-gray-400 italic mt-4">Belum ada terjemahan.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Player Bar --}}
    <div class="pointer-events-auto w-full bg-white shadow-[0_-4px_6px_-1px_rgba(79,70,229,0.15)] border-t-2 border-indigo-100">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-indigo-50/60 via-white to-purple-50/60">

                {{-- Status Badges (Admin Only) --}}
                @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                <div class="flex items-center gap-1 flex-shrink-0">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold {{ $_hasAudio ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                        <span class="font-bold">{{ $_hasAudio ? '✓' : '✕' }}</span> Audio
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold {{ $_hasTranscript ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                        <span class="font-bold">{{ $_hasTranscript ? '✓' : '✕' }}</span> SRT
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] md:text-[11px] font-semibold {{ $_hasKey ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                        <span class="font-bold">{{ $_hasKey ? '✓' : '✕' }}</span> Key
                    </span>
                </div>
                @endif

                {{-- Music Icon + Label --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-indigo-900 hidden sm:inline">Audio - Part {{ $set }}</span>
                </div>

                {{-- Backward --}}
                <button type="button" onclick="skipAudio(-10)"
                        class="p-2 bg-white hover:bg-white rounded-lg transition-colors flex-shrink-0 border border-indigo-200" title="Mundur 10 detik">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                    </svg>
                </button>

                {{-- Play/Pause --}}
                <button type="button" id="playPauseBtn" onclick="togglePlayPause()"
                        class="p-2.5 bg-gradient-to-br from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-xl transition-all flex-shrink-0 shadow-lg shadow-indigo-200">
                    <svg id="playIcon" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg id="pauseIcon" class="w-6 h-6 text-white hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                    <svg id="loadingIcon" class="w-6 h-6 text-white hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                </button>

                {{-- Progress --}}
                <div class="flex-1 flex flex-col gap-1 max-w-3xl">
                    <div class="flex justify-between text-xs text-indigo-600 font-semibold">
                        <span id="currentTime">0:00</span>
                        <span id="duration">0:00</span>
                    </div>
                    <div class="relative h-2 bg-white rounded-full cursor-pointer group" id="progressContainer">
                        <div id="progressBar" class="absolute h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all" style="width: 0%"></div>
                        <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white border-2 border-indigo-500 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                    </div>
                    <p id="audioErrorMsg" class="hidden text-xs text-red-600 font-medium mt-0.5"></p>
                </div>

                {{-- Forward --}}
                <button type="button" onclick="skipAudio(10)"
                        class="p-2 bg-white hover:bg-white rounded-lg transition-colors flex-shrink-0 border border-indigo-200" title="Maju 10 detik">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                    </svg>
                </button>

                {{-- Hidden Audio Element --}}
                <audio id="mainAudio" class="hidden" preload="auto">
                    <source id="audioSource" src="{{ $_audioUrl ?? '' }}" type="audio/mpeg">
                </audio>

                {{-- Right Controls --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    {{-- Transcript Button --}}
                    <button onclick="toggleTranscriptDrawer()"
                            class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center gap-2 font-semibold shadow-sm text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="hidden md:inline">Transcript</span>
                    </button>

                    {{-- Admin Buttons --}}
                    @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                    <div class="flex gap-1.5 border-l border-indigo-200 pl-2">
                        {{-- Upload SRT --}}
                        <button type="button" onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')"
                                class="p-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md flex-shrink-0" title="Upload SRT">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                        {{-- Upload Audio --}}
                        <button type="button" onclick="document.getElementById('uploadAudioModal').classList.remove('hidden')"
                                class="p-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-md flex-shrink-0" title="Upload Audio">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </button>
                        {{-- Upload Answer Key --}}
                        <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.remove('hidden')"
                                class="p-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-md flex-shrink-0" title="Kunci Jawaban">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

{{-- Admin Modals --}}
@if(Auth::check() && strtolower(Auth::user()->role) === 'admin')

{{-- Upload Audio Modal --}}
<div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg></span>
                Upload Audio
            </h3>
            <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('assignments.ielts.listening.upload-audio', ['meeting' => $meeting->id ?? 0, 'set' => $set]) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div class="p-4 bg-white rounded-lg border-2 border-dashed border-gray-300 text-center">
                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                <input type="file" name="audio_file" accept=".mp3,.wav,.m4a,audio/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-indigo-700 hover:file:bg-white">
                <p class="mt-2 text-xs text-gray-500">MP3, WAV atau M4A • Max 50MB</p>
            </div>
            <p class="text-xs text-indigo-700 bg-white p-3 rounded-lg">🤖 Auto-transcribe & translate dengan Whisper AI</p>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="flex-1 py-2 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition" :disabled="loading">Cancel</button>
                <button type="submit" class="flex-1 py-2 bg-rose-600 text-white font-bold rounded-lg hover:bg-rose-700 transition disabled:opacity-70" :disabled="loading">
                    <span x-show="!loading">Upload Audio</span>
                    <span x-show="loading">Uploading...</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Upload SRT Modal --}}
<div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg></span>
                Upload / Edit Transcript
            </h3>
            <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('assignments.ielts.listening.upload-srt', ['meeting' => $meeting->id ?? 0, 'set' => $set]) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="language" value="en" class="text-indigo-600" checked> <span>English 🇺🇸</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="language" value="id" class="text-indigo-600"> <span>Indonesia 🇮🇩</span></label>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">SRT File (.srt)</label>
                <input type="file" name="srt_file" accept=".srt" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-purple-700 hover:file:bg-white">
            </div>
            <div class="relative py-1"><div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div><div class="relative flex justify-center"><span class="px-2 bg-white text-xs text-gray-400 uppercase">Or Paste Text</span></div></div>
            <div>
                <textarea name="srt_content" rows="4" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:outline-none text-sm font-mono placeholder-gray-400" placeholder="Paste transcript text here..."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="flex-1 py-2 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition" :disabled="loading">Cancel</button>
                <button type="submit" class="flex-1 py-2 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition disabled:opacity-70" :disabled="loading">
                    <span x-show="!loading">Save Transcript</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Upload Answer Key Modal --}}
<div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                Kunci Jawaban
            </h3>
            <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('assignments.ielts.listening.upload-answer-key', ['meeting' => $meeting->id ?? 0, 'set' => $set]) }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key</label>
                <textarea name="answer_key" rows="8" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-teal-500 focus:outline-none text-sm font-mono placeholder-gray-400" placeholder="1. A&#10;2. B&#10;3. technology&#10;...">{{ isset($section) && $section ? ($section->answer_key ?? '') : '' }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 py-2 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition" :disabled="loading">Cancel</button>
                <button type="submit" class="flex-1 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition disabled:opacity-70" :disabled="loading">
                    <span x-show="!loading">Save Key</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endif

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('practiceAudioPlayer', () => ({
        init() { window.practiceAudioCtx = this; }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    const audio       = document.getElementById('mainAudio');
    const playIcon    = document.getElementById('playIcon');
    const pauseIcon   = document.getElementById('pauseIcon');
    const loadingIcon = document.getElementById('loadingIcon');
    const errorMsg    = document.getElementById('audioErrorMsg');
    const progressBar = document.getElementById('progressBar');
    const progressHandle = document.getElementById('progressHandle');
    const progressContainer = document.getElementById('progressContainer');
    const currentTimeDisplay = document.getElementById('currentTime');
    const durationDisplay    = document.getElementById('duration');
    if (!audio || !progressContainer) return;

    let isDragging = false;
    let isAutoscrollEnabled = true;
    let stallTimer = null;

    function formatTime(s) {
        if (isNaN(s) || !isFinite(s)) return '0:00';
        return Math.floor(s/60) + ':' + String(Math.floor(s%60)).padStart(2,'0');
    }

    function setIconState(state) {
        // state: 'play' | 'pause' | 'loading'
        playIcon.classList.toggle('hidden', state !== 'play');
        pauseIcon.classList.toggle('hidden', state !== 'pause');
        loadingIcon.classList.toggle('hidden', state !== 'loading');
    }

    function showAudioError(message) {
        errorMsg.textContent = message;
        errorMsg.classList.remove('hidden');
        setIconState('play');
    }

    function clearAudioError() {
        errorMsg.classList.add('hidden');
        errorMsg.textContent = '';
    }

    window.toggleAutoscroll = (v) => { isAutoscrollEnabled = v; };

    window.togglePlayPause = function() {
        if (audio.paused) {
            const src = document.getElementById('audioSource');
            if (!src || !src.getAttribute('src') || src.getAttribute('src') === '') {
                alert('Audio belum diupload untuk Part ini.');
                return;
            }

            clearAudioError();
            setIconState('loading');

            // If the browser hasn't actually started producing playable data
            // within a reasonable window, don't leave the button stuck on a
            // spinner/pause icon forever - tell the student clearly instead.
            clearTimeout(stallTimer);
            stallTimer = setTimeout(() => {
                if (audio.readyState < 2) {
                    audio.pause();
                    showAudioError('Audio gagal dimuat. Periksa koneksi internet Anda dan coba lagi.');
                }
            }, 10000);

            audio.play().then(() => {
                clearTimeout(stallTimer);
                setIconState('pause');
            }).catch(() => {
                clearTimeout(stallTimer);
                showAudioError('Audio gagal diputar. Silakan coba lagi.');
            });
        } else {
            audio.pause();
            setIconState('play');
        }
    };

    audio.addEventListener('error', () => {
        clearTimeout(stallTimer);
        showAudioError('Audio gagal dimuat. File mungkin rusak atau belum tersedia.');
    });

    audio.addEventListener('waiting', () => {
        if (!audio.paused) setIconState('loading');
    });

    audio.addEventListener('playing', () => {
        clearTimeout(stallTimer);
        clearAudioError();
        setIconState('pause');
    });

    window.skipAudio = (s) => {
        if (audio && audio.duration) audio.currentTime = Math.max(0, Math.min(audio.duration, audio.currentTime + s));
    };

    function seekAudio(e) {
        if (!audio.duration) return;
        const rect = progressContainer.getBoundingClientRect();
        const clientX = e.clientX || (e.touches ? e.touches[0].clientX : 0);
        const pct = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
        audio.currentTime = pct * audio.duration;
    }

    progressContainer.addEventListener('mousedown', e => { isDragging = true; seekAudio(e); e.preventDefault(); });
    document.addEventListener('mousemove', e => { if (isDragging) seekAudio(e); });
    document.addEventListener('mouseup', () => { isDragging = false; });
    progressContainer.addEventListener('touchstart', e => { isDragging = true; seekAudio(e.touches[0]); e.preventDefault(); });
    document.addEventListener('touchmove', e => { if (isDragging) seekAudio(e.touches[0]); });
    document.addEventListener('touchend', () => { isDragging = false; });

    audio.addEventListener('timeupdate', () => {
        if (audio.duration && !isDragging) {
            const pct = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = pct + '%';
            progressHandle.style.left = pct + '%';
            currentTimeDisplay.textContent = formatTime(audio.currentTime);
            if (isAutoscrollEnabled) highlightTranscript(audio.currentTime);
        }
    });

    audio.addEventListener('loadedmetadata', () => { durationDisplay.textContent = formatTime(audio.duration); });
    audio.addEventListener('ended', () => { setIconState('play'); });

    window.toggleTranscriptDrawer = function() {
        const d = document.getElementById('transcriptDrawer');
        if (d) d.classList.toggle('hidden');
    };

    function highlightTranscript(currentTime) {
        document.querySelectorAll('.transcript-line').forEach(el => {
            const s = parseFloat(el.dataset.start), e = parseFloat(el.dataset.end);
            if (currentTime >= s && currentTime <= e) {
                el.classList.add('bg-white', 'text-indigo-900');
                if (isAutoscrollEnabled) el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                el.classList.remove('bg-white', 'text-indigo-900');
            }
        });
    }

    // Resizer
    const resizer = document.getElementById('transcriptResizer');
    const drawer  = document.getElementById('transcriptDrawer');
    let isResizing = false, startY, startHeight;
    if (resizer && drawer) {
        const initResize = e => { isResizing = true; startY = e.clientY || (e.touches && e.touches[0].clientY); startHeight = parseInt(getComputedStyle(drawer).height); document.body.style.userSelect = 'none'; e.preventDefault(); };
        const doResize   = e => { if (!isResizing) return; const cy = e.clientY || (e.touches && e.touches[0].clientY); const nh = startHeight + (startY - cy); if (nh >= 200 && nh <= window.innerHeight * 0.8) drawer.style.height = nh + 'px'; };
        const stopResize = () => { isResizing = false; document.body.style.userSelect = ''; };
        resizer.addEventListener('mousedown', initResize);
        document.addEventListener('mousemove', doResize);
        document.addEventListener('mouseup', stopResize);
        resizer.addEventListener('touchstart', initResize, {passive: false});
        document.addEventListener('touchmove', doResize, {passive: false});
        document.addEventListener('touchend', stopResize);
    }
});
</script>
