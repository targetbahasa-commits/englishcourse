
{{-- Edit Transcript Modal --}}
@if(Auth::user()->isAdmin())
    <div id="editTranscriptModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Transcript (Set {{ $set ?? '' }})</h3>
                <form action="{{ route('assignments.toefl-itp.listening.meeting.update-transcript', ['number' => $number, 'set' => $set ?? 0]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">English Script</label>
                        <textarea name="transcript_en" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $questions->first() ? $questions->first()->transcript_en : '' }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Use newline for paragraphs.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Indonesian Translation</label>
                        <textarea name="transcript_id" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $questions->first() ? $questions->first()->transcript_id : '' }}</textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('editTranscriptModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Upload SRT Modal (Admin Only) --}}
    <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
            onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 relative transform transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Upload Transcript (.srt)</h3>
                <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('assignments.toefl-itp.listening.meeting.upload-srt', ['number' => $number ?? 0, 'set' => $set ?? 0]) }}" 
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Target Language</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="en" checked class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">English Script 🇺🇸</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="id" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">Indonesian 🇮🇩</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SRT File (.srt - Max 2MB)
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                        <input type="file" id="srtFileInput" name="srt_file" accept=".srt"
                                class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0].name">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                    </div>
                </div>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-2 bg-white text-sm text-gray-500 font-semibold">OR PASTE TEXT</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Paste SRT Content Directly
                    </label>
                    <textarea name="srt_content" rows="4" 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono"
                                placeholder="1
00:00:10,000 --> 00:00:15,000
Start translating here..."></textarea>
                </div>

                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                    <p class="text-xs text-yellow-800">
                        <strong>Note:</strong> Auto-parsing will remove timestamps (<code>00:00:10 --> ...</code>) and keep only the text dialog.
                    </p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                        Upload & Parse
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Audio Modal (Admin Only) --}}
    <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
            onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Upload Audio File</h3>
                <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('assignments.toefl-itp.listening.meeting.upload-audio', ['number' => $number ?? 0, 'set' => $set ?? 0]) }}" 
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Audio File (MP3, WAV, OGG - Max 10MB)
                    </label>
                    <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                @if(isset($questions) && $questions->first() && $questions->first()->audio_file)
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-800">
                            <span class="font-semibold">Current file:</span> 
                            {{ basename($questions->first()->audio_file) }}
                        </p>
                    </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
