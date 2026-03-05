{{-- Audio Player Section - Fixed/Floating --}}
@php $fixed = $fixed ?? true; @endphp
<div class="{{ $fixed ? 'fixed bottom-0 left-0 right-0 z-50' : 'relative w-full rounded-b-2xl border-t border-slate-100' }} bg-white {{ $fixed ? 'shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]' : '' }}">
    <div class="{{ $fixed ? 'max-w-7xl mx-auto' : '' }}">
        <div class="flex items-center gap-4 p-4 bg-white {{ $fixed ? 'border-b-2 border-gray-200' : '' }}">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                </div>
                <span class="text-sm font-bold text-gray-900">Audio Session - Part {{ $set ?? '' }}</span>
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
                    {{-- Use proper audio source logic --}}
                    @if(isset($audio_url))
                        <source src="{{ $audio_url }}" type="audio/mpeg">
                    @elseif(isset($section) && $section && $section->audio_file)
                        <source src="{{ asset($section->audio_file) }}" type="audio/mpeg">
                    @endif
                </audio>
            </div>

            {{-- Admin Upload Audio Button --}}
            @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                <div class="flex gap-2">
                    <button type="button" 
                            onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" 
                            class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Upload SRT
                    </button>
                    
                    <button type="button" 
                            onclick="console.log('Upload button clicked'); document.getElementById('uploadAudioModal').classList.remove('hidden');" 
                            class="px-3 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Audio
                    </button>
                    
                    <button type="button" 
                            onclick="document.getElementById('uploadAnswerKeyModal').classList.remove('hidden');" 
                            class="px-3 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Upload Kunci
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Transcript Drawer (Collapsible) --}}
@php $drawerClass = $fixed ? 'mt-20' : 'mt-4 border-t-0'; @endphp
<div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 {{ $drawerClass }} mb-4 bg-white h-80 overflow-hidden flex flex-col transition-all duration-300 ease-in-out shadow-md">
    <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
        {{-- English Column --}}
        <div class="flex flex-col h-full bg-slate-50">
            <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                </div>
            </div>
            <div class="flex-1 relative overflow-hidden">
                <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                    @if(isset($section) && $section && $section->transcript_en)
                        @php
                            $transcriptEn = $section->transcript_en;
                            $jsonEn = json_decode($transcriptEn, true);
                            $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                        @endphp
                        @if($isJsonEn)
                            <div class="space-y-2">
                                @foreach($jsonEn as $block)
                                    <div class="mb-2">
                                        @php $words = explode(' ', $block['text']); @endphp
                                        @foreach($words as $word)
                                            <span class="transcript-word cursor-pointer hover:bg-gray-200 transition-colors duration-200 rounded px-0.5 inline-block">{{ $word }}</span>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {!! nl2br(e($transcriptEn)) !!}
                        @endif
                    @else
                        <div class="text-center text-slate-400 italic mt-4">No transcript available.</div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Indonesian Column --}}
        <div class="flex flex-col h-full bg-gray-50">
            <div class="flex-none px-4 py-2 bg-gray-100 border-b border-gray-200 font-semibold text-gray-800 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Terjemahan Indonesia
                </div>
                <button onclick="toggleTranscriptDrawer()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 relative overflow-hidden">
                <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-gray-600 custom-scrollbar pr-2">
                    @if(isset($section) && $section && $section->transcript_id)
                        {!! nl2br(e($section->transcript_id)) !!}
                    @else
                        <div class="text-center text-gray-400 italic mt-4">Belum ada terjemahan.</div>
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
