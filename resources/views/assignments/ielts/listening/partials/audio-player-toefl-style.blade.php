{{-- TOEFL-style Audio Player for IELTS Warmup pages --}}
@php
    $fixed = $fixed ?? true;
@endphp

<div class="{{ $fixed ? 'fixed top-0 left-0 right-0 md:left-64 z-40' : 'relative w-full rounded-b-2xl' }} bg-gradient-to-r from-blue-50 via-indigo-50 to-violet-50 shadow-lg border-b border-indigo-200">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap lg:flex-nowrap items-center gap-2 md:gap-4 p-2 md:p-4 bg-white/85 backdrop-blur border-b border-indigo-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 md:w-10 md:h-10 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-full flex items-center justify-center text-white shadow-md">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path></svg>
                </div>
                <span class="text-sm md:text-lg font-bold text-indigo-900 whitespace-nowrap">Audio Session - Latihan {{ $set ?? 1 }}</span>
            </div>

            <div class="flex-1 min-w-[220px] flex items-center gap-1.5 md:gap-3 max-w-3xl">
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
                    <button type="button" id="toggleKeyBtn" onclick="toggleAnswerKey()"
                            class="p-2 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg transition-colors flex-shrink-0 flex items-center gap-2 border border-yellow-300"
                            title="Toggle Answer Key">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-xs font-bold hidden md:inline">Key</span>
                    </button>
                @endif

                <button type="button" onclick="skipAudio(-10)"
                        class="p-1.5 md:p-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Mundur 10 detik">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                    </svg>
                </button>

                <button type="button" id="playPauseBtn" onclick="togglePlayPause()"
                        class="p-1.5 md:p-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-lg transition-colors flex-shrink-0 border border-indigo-600">
                    <svg id="playIcon" class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg id="pauseIcon" class="w-5 h-5 md:w-6 md:h-6 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                    </svg>
                </button>

                <div class="flex-1 flex flex-col gap-1">
                    <div class="flex justify-between text-xs text-indigo-700 font-medium">
                        <span id="currentTime">0:00</span>
                        <span id="duration">0:00</span>
                    </div>

                    <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                        <div id="progressBar" class="absolute h-full bg-gradient-to-r from-indigo-600 to-violet-600 rounded-full transition-all" style="width: 0%"></div>
                        <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                    </div>
                </div>

                <button type="button" onclick="skipAudio(10)"
                        class="p-1.5 md:p-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-colors flex-shrink-0" title="Maju 10 detik">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                    </svg>
                </button>

                <button type="button" onclick="toggleTranscriptDrawer()"
                        class="p-1.5 md:p-2 bg-yellow-400 border-2 border-yellow-500 hover:bg-yellow-500 rounded-lg transition-colors flex-shrink-0 flex items-center gap-1.5 md:gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-black group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs font-bold text-black hidden sm:inline">Terjemah</span>
                </button>

                <audio id="mainAudio" class="hidden" preload="auto">
                    @if(isset($audio_url))
                        <source src="{{ $audio_url }}" type="audio/mpeg">
                    @elseif(isset($section) && $section && $section->audio_file)
                        <source src="{{ asset($section->audio_file) }}" type="audio/mpeg">
                    @endif
                </audio>
            </div>

            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin')
                <div class="w-full lg:w-auto flex flex-wrap justify-end gap-2">
                    <button type="button"
                            onclick="document.getElementById('uploadSrtModal')?.classList.remove('hidden'); document.getElementById('uploadSrtModal')?.classList.add('flex');"
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Upload SRT
                    </button>

                    <button type="button"
                            onclick="document.getElementById('uploadAudioModal')?.classList.remove('hidden'); document.getElementById('uploadAudioModal')?.classList.add('flex');"
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Audio
                    </button>

                    <button type="button"
                            onclick="document.getElementById('chooseAudioModal')?.classList.remove('hidden'); document.getElementById('chooseAudioModal')?.classList.add('flex'); if (typeof audioFileManager !== 'undefined') { setTimeout(() => audioFileManager.init(), 100); }"
                            class="px-2 py-1.5 md:px-3 md:py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors flex items-center gap-1.5 md:gap-2 shadow-md relative z-10 text-xs md:text-sm">
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

@if($fixed)
<div class="h-24 mb-4 pointer-events-none"></div>
@endif

<script>
    // Fallback agar tombol Key tidak error di halaman yang belum punya implementasi khusus.
    window.toggleAnswerKey = window.toggleAnswerKey || function () {
        document.body.classList.toggle('reveal-key');
    };
</script>
