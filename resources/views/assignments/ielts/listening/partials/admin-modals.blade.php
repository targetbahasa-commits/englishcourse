{{-- Upload SRT Modal --}}
<div id="uploadSrtModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-[60] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
            <h3 class="text-lg font-bold text-gray-800">Upload SRT / Transcript</h3>
            <button onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('assignments.ielts.listening.upload-srt', ['meeting' => $meeting->id, 'set' => $set ?? 1]) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Transcript Format</label>
                <div class="text-xs text-gray-500 mb-2">Choose 'Text' for direct pasting or 'JSON' for word-clickable format.</div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">English Transcript</label>
                <textarea name="transcript_en" rows="4" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-50 text-sm" placeholder="Paste English text here..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Indonesian Translation</label>
                <textarea name="transcript_id" rows="4" class="w-full rounded-lg border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-50 text-sm" placeholder="Paste translation here..."></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" class="flex-1 py-2 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="flex-1 py-2 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition">Save Transcripts</button>
            </div>
        </form>
    </div>
</div>

{{-- Upload Audio Modal --}}
<div id="uploadAudioModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-[60] flex items-center justify-center p-4" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
            <h3 class="text-lg font-bold text-gray-800">Upload Audio</h3>
            <button onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('assignments.ielts.listening.upload-audio', ['meeting' => $meeting->id, 'set' => $set ?? 1]) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            
            <div class="p-4 bg-white rounded-lg border border-dashed border-gray-300 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                <label class="block">
                    <span class="sr-only">Choose file</span>
                    <input type="file" name="audio_file" accept=".mp3,.wav,.m4a" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-red-50 file:text-red-700
                        hover:file:bg-red-100
                    "/>
                </label>
                <p class="mt-2 text-xs text-gray-500">MP3, WAV, or M4A</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" class="flex-1 py-2 bg-white text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="flex-1 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">Upload Audio</button>
            </div>
        </form>
    </div>
</div>


